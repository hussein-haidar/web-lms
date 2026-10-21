<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use Config\Database;
use Config\Services;

class BackupController extends BaseController
{
    protected $backupPath;
    protected $maxBackups;

    public function __construct()
    {
        $this->backupPath = WRITEPATH . 'backups/';
        $this->maxBackups = 10; // Simpan maksimal 10 backup
        if (!is_dir($this->backupPath)) {
            mkdir($this->backupPath, 0755, true);
        }
    }

    public function index()
    {
        $files = $this->getBackupFiles();
        $data = [
            'title' => 'Backup Database',
            'title2' => 'Backup Database',
            'files' => $files
        ];
        return view('backend/superadmin/backup/v_index', $data);
    }

    public function create()
    {
        $filename = 'backup_' . date('Y-m-d_H-i-s') . '.sql';
        $filepath = $this->backupPath . $filename;
        
        $db = Database::connect();
        $tables = $db->listTables();
        
        $sql = "-- Backup Database LPK INASABA\n";
        $sql .= "-- Generated: " . date('Y-m-d H:i:s') . "\n\n";
        
        foreach ($tables as $table) {
            $sql .= "DROP TABLE IF EXISTS `$table`;\n";
            
            // Get CREATE TABLE
            $create = $db->query("SHOW CREATE TABLE `$table`")->getRowArray();
            $sql .= $create['Create Table'] . ";\n\n";
            
            // Get data
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
            // Compress
            $zip = new \ZipArchive();
            $zipPath = $filepath . '.zip';
            if ($zip->open($zipPath, \ZipArchive::CREATE) === TRUE) {
                $zip->addFile($filepath, $filename);
                $zip->close();
                unlink($filepath); // Hapus SQL mentah
                $filepath = $zipPath;
            }
            
            $this->cleanupOldBackups();
            
            log_message('info', 'Backup database berhasil: ' . basename($filepath));
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Backup berhasil dibuat',
                'file' => basename($filepath),
                'size' => filesize($filepath)
            ]);
        }
        
        return $this->response->setJSON(['status' => 'error', 'message' => 'Gagal membuat backup']);
    }

    public function download($filename)
    {
        $filepath = $this->backupPath . $filename;
        if (file_exists($filepath)) {
            return $this->response->download($filepath, null);
        }
        return redirect()->back()->with('error', 'File tidak ditemukan');
    }

    public function delete($filename)
    {
        $filepath = $this->backupPath . $filename;
        if (file_exists($filepath)) {
            unlink($filepath);
            return $this->response->setJSON(['status' => 'success']);
        }
        return $this->response->setJSON(['status' => 'error', 'message' => 'File tidak ditemukan']);
    }

    public function auto()
    {
        // Untuk cron job / scheduler
        return $this->create();
    }

    public function schedule()
    {
        // Endpoint untuk setup cron (akan dijalankan via CLI)
        $this->auto();
    }

    protected function getBackupFiles()
    {
        $files = [];
        $dir = new \DirectoryIterator($this->backupPath);
        foreach ($dir as $file) {
            if ($file->isFile() && in_array($file->getExtension(), ['zip', 'sql'])) {
                $files[] = [
                    'name' => $file->getFilename(),
                    'size' => $this->formatBytes($file->getSize()),
                    'date' => date('Y-m-d H:i:s', $file->getMTime()),
                    'path' => $file->getPathname()
                ];
            }
        }
        usort($files, fn($a, $b) => strtotime($b['date']) - strtotime($a['date']));
        return $files;
    }

    protected function cleanupOldBackups()
    {
        $files = $this->getBackupFiles();
        if (count($files) > $this->maxBackups) {
            for ($i = $this->maxBackups; $i < count($files); $i++) {
                if (file_exists($files[$i]['path'])) {
                    unlink($files[$i]['path']);
                }
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