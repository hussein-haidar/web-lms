<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use Config\Database;

class BackupAuto extends BaseCommand
{
    protected $group = 'Backup';
    protected $name = 'backup:auto';
    protected $description = 'Membuat backup database otomatis (untuk cron job)';
    protected $usage = 'backup:auto [--compress] [--keep=10]';
    protected $arguments = [];
    protected $options = [
        'compress' => 'Kompres backup ke ZIP (default: true)',
        'keep'     => 'Jumlah backup yang disimpan (default: 10)',
    ];

    public function run(array $params)
    {
        $compress = !isset($params['compress']) || $params['compress'] !== 'false';
        $keep = (int) ($params['keep'] ?? 10);
        
        CLI::write('Memulai backup otomatis...', 'green');
        
        $backupPath = WRITEPATH . 'backups/';
        if (!is_dir($backupPath)) {
            mkdir($backupPath, 0755, true);
        }
        
        $filename = 'auto_backup_' . date('Y-m-d_H-i-s') . '.sql';
        $filepath = $backupPath . $filename;
        
        $db = Database::connect();
        $tables = $db->listTables();
        
        $sql = "-- Auto Backup Database LPK INASABA\n";
        $sql .= "-- Generated: " . date('Y-m-d H:i:s') . "\n\n";
        
        $totalTables = count($tables);
        $current = 0;
        
        foreach ($tables as $table) {
            $current++;
            CLI::write("  [$current/$totalTables] Backing up table: $table", 'yellow');
            
            $sql .= "DROP TABLE IF EXISTS `$table`;\n";
            
            $create = $db->query("SHOW CREATE TABLE `$table`")->getRowArray();
            $sql .= $create['Create Table'] . ";\n\n";
            
            $rows = $db->table($table)->get()->getResultArray();
            if (!empty($rows)) {
                $columns = array_keys($rows[0]);
                $sql .= "INSERT INTO `$table` (`" . implode('`, `', $columns) . "`) VALUES\n";
                
                $values = [];
                foreach ($rows as $row) {
                    $vals = [];
                    foreach ($row as $val) {
                        if ($val === null) {
                            $vals[] = 'NULL';
                        } else {
                            $vals[] = "'" . $db->escapeString($val) . "'";
                        }
                    }
                    $values[] = '(' . implode(', ', $vals) . ')';
                }
                $sql .= implode(",\n", $values) . ";\n\n";
            }
        }
        
        if (file_put_contents($filepath, $sql)) {
            CLI::write("  SQL created: $filename", 'green');
            
            if ($compress) {
                $zip = new \ZipArchive();
                $zipPath = $filepath . '.zip';
                if ($zip->open($zipPath, \ZipArchive::CREATE) === TRUE) {
                    $zip->addFile($filepath, $filename);
                    $zip->close();
                    unlink($filepath);
                    $filepath = $zipPath;
                    CLI::write("  Compressed to ZIP", 'green');
                }
            }
            
            // Cleanup old
            $this->cleanupOld($backupPath, $keep);
            
            CLI::write('Backup selesai: ' . basename($filepath), 'green');
            CLI::write('Size: ' . $this->formatBytes(filesize($filepath)), 'green');
        } else {
            CLI::error('Gagal membuat backup!');
        }
    }
    
    protected function cleanupOld($path, $keep)
    {
        $files = glob($path . '*.{sql,zip}', GLOB_BRACE);
        usort($files, function($a, $b) {
            return filemtime($b) - filemtime($a);
        });
        
        for ($i = $keep; $i < count($files); $i++) {
            if (file_exists($files[$i])) {
                unlink($files[$i]);
                CLI::write("  Deleted old: " . basename($files[$i]), 'yellow');
            }
        }
    }
    
    protected function formatBytes($bytes, $precision = 2)
    {
        $units = ['B', 'KB', 'MB', 'GB'];
        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }
        return round($bytes, $precision) . ' ' . $units[$i];
    }
}