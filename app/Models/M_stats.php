<?php

namespace App\Models;

use CodeIgniter\Model;

class M_stats extends Model
{
    protected $table = 'stats';
    protected $primaryKey = 'id_stats';
    protected $allowedFields = [
        'judul_stats',
        'nilai_stats', 
        'suffix_stats',
        'urutan_stats',
        'baris_stats',
        'is_active',
        'updated_at'
    ];
    protected $useTimestamps = false;
    protected $returnType = 'array';

    // Get all active stats ordered by row and order
    public function getActiveStats()
    {
        return $this->where('is_active', 1)
                    ->orderBy('baris_stats', 'ASC')
                    ->orderBy('urutan_stats', 'ASC')
                    ->findAll();
    }

    // Get stats by row
    public function getStatsByRow($row)
    {
        return $this->where('is_active', 1)
                    ->where('baris_stats', $row)
                    ->orderBy('urutan_stats', 'ASC')
                    ->findAll();
    }

    // Get stats by ID
    public function getStatsById($id)
    {
        return $this->find($id);
    }

    // Insert new stats
    public function insertStats($data)
    {
        $data['created_at'] = date('Y-m-d H:i:s');
        return $this->insert($data);
    }

    // Update stats
    public function updateStats($id, $data)
    {
        $data['updated_at'] = date('Y-m-d H:i:s');
        return $this->update($id, $data);
    }

    // Delete stats
    public function deleteStats($id)
    {
        return $this->delete($id);
    }

    // Get all stats (including inactive)
    public function getAllStats()
    {
        return $this->orderBy('baris_stats', 'ASC')
                    ->orderBy('urutan_stats', 'ASC')
                    ->findAll();
    }

    // Toggle active status
    public function toggleActive($id)
    {
        $stats = $this->find($id);
        if ($stats) {
            $newStatus = $stats['is_active'] ? 0 : 1;
            return $this->update($id, ['is_active' => $newStatus]);
        }
        return false;
    }

    // Get max order in a row
    public function getMaxOrderInRow($row)
    {
        $result = $this->selectMax('urutan_stats')
                      ->where('baris_stats', $row)
                      ->first();
        return $result ? $result['urutan_stats'] : 0;
    }
}
