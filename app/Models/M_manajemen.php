<?php

namespace App\Models;

use CodeIgniter\Model;

class M_manajemen extends Model
{
    protected $table = 'manajemen';
    protected $primaryKey = 'id_manajemen';
    protected $allowedFields = [
        'nama_lengkap',
        'jabatan',
        'foto',
        'facebook',
        'twitter',
        'linkedin',
        'instagram',
        'email',
        'no_telepon',
        'deskripsi',
        'urutan',
        'status'
    ];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';
    protected $useSoftDeletes = true;

    // Get all management data
    public function getManajemen($status_filter = null)
    {
        $builder = $this->db->table($this->table);
        
        // Try to filter deleted_at if column exists
        try {
            $builder->where('deleted_at IS NULL');
        } catch (\Exception $e) {
            // If deleted_at column doesn't exist, continue without filtering
        }
        
        if (!empty($status_filter) && trim($status_filter) !== '') {
            try {
                $builder->where('status', trim($status_filter));
            } catch (\Exception $e) {
                // If status column doesn't exist, continue without filtering
            }
        }
        
        return $builder->orderBy('urutan', 'ASC')->get()->getResultArray();
    }

    // Get detail management by ID
    public function getDetailManajemen($id_manajemen)
    {
        return $this->db->table('manajemen')
            ->where('id_manajemen', $id_manajemen)
            ->where('deleted_at IS NULL')
            ->get()
            ->getRowArray();
    }

    // Insert new management data
    public function insertManajemen($data)
    {
        return $this->insert($data);
    }

    // Update management data
    public function updateManajemen($id_manajemen, $data)
    {
        return $this->update($id_manajemen, $data);
    }

    // Delete management data (soft delete)
    public function deleteManajemen($id_manajemen)
    {
        return $this->delete($id_manajemen);
    }

    // Restore soft deleted management
    public function restoreManajemen($id_manajemen)
    {
        return $this->update($id_manajemen, ['deleted_at' => null]);
    }

    // Get deleted management data
    public function getDeletedManajemen()
    {
        return $this->db->table($this->table)
            ->where('deleted_at IS NOT NULL')
            ->orderBy('id_manajemen', 'DESC')
            ->get()
            ->getResultArray();
    }

    // Force permanent delete
    public function forceDeleteManajemen($id_manajemen)
    {
        return $this->db->table($this->table)
            ->where('id_manajemen', $id_manajemen)
            ->delete();
    }

    // Update order/sequence
    public function updateUrutan($id_manajemen, $urutan)
    {
        return $this->update($id_manajemen, ['urutan' => $urutan]);
    }

    // Get management for public display (active only)
    public function getActiveManajemen()
    {
        // Check if status column exists
        $builder = $this->db->table('manajemen')
            ->where('deleted_at IS NULL');
            
        // Try to filter by status if column exists
        try {
            $builder->where('status', 'aktif');
        } catch (\Exception $e) {
            // If status column doesn't exist, continue without filtering
        }
        
        return $builder->orderBy('urutan', 'ASC')
            ->get()
            ->getResultArray();
    }
}
