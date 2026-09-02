<?php

namespace App\Models;

use CodeIgniter\Model;

class M_instruktur extends Model
{
    protected $table = 'instruktur';
    protected $primaryKey = 'id_instruktur';
    protected $allowedFields = [
        'nama_lengkap',
        'keahlian',
        'foto',
        'facebook',
        'twitter',
        'linkedin',
        'instagram',
        'email',
        'no_telepon',
        'deskripsi',
        'pendidikan',
        'pengalaman',
        'urutan',
        'status'
    ];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';
    protected $useSoftDeletes = true;

    // Get all instructor data
    public function getInstruktur($status_filter = null)
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

    // Get detail instructor by ID
    public function getDetailInstruktur($id_instruktur)
    {
        return $this->db->table('instruktur')
            ->where('id_instruktur', $id_instruktur)
            ->where('deleted_at IS NULL')
            ->get()
            ->getRowArray();
    }

    // Insert new instructor data
    public function insertInstruktur($data)
    {
        return $this->insert($data);
    }

    // Update instructor data
    public function updateInstruktur($id_instruktur, $data)
    {
        return $this->update($id_instruktur, $data);
    }

    // Delete instructor data (soft delete)
    public function deleteInstruktur($id_instruktur)
    {
        return $this->delete($id_instruktur);
    }

    // Restore soft deleted instructor
    public function restoreInstruktur($id_instruktur)
    {
        return $this->update($id_instruktur, ['deleted_at' => null]);
    }

    // Get deleted instructor data
    public function getDeletedInstruktur()
    {
        return $this->db->table($this->table)
            ->where('deleted_at IS NOT NULL')
            ->orderBy('id_instruktur', 'DESC')
            ->get()
            ->getResultArray();
    }

    // Force permanent delete
    public function forceDeleteInstruktur($id_instruktur)
    {
        return $this->db->table($this->table)
            ->where('id_instruktur', $id_instruktur)
            ->delete();
    }

    // Update order/sequence
    public function updateUrutan($id_instruktur, $urutan)
    {
        return $this->update($id_instruktur, ['urutan' => $urutan]);
    }

    // Get instructor for public display (active only)
    public function getActiveInstruktur()
    {
        // Check if status column exists
        $builder = $this->db->table('instruktur')
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

    // Get instructors for dropdown
    public function getInstrukturDropdown()
    {
        // Check if status column exists
        $builder = $this->db->table('instruktur')
            ->select('id_instruktur, nama_lengkap')
            ->where('deleted_at IS NULL');
            
        // Try to filter by status if column exists
        try {
            $builder->where('status', 'aktif');
        } catch (\Exception $e) {
            // If status column doesn't exist, continue without filtering
        }
        
        return $builder->orderBy('nama_lengkap', 'ASC')
            ->get()
            ->getResultArray();
    }

    // Search instructors by name or expertise
    public function searchInstruktur($keyword)
    {
        return $this->db->table('instruktur')
            ->where('deleted_at IS NULL')
            ->groupStart()
                ->like('nama_lengkap', $keyword)
                ->orLike('keahlian', $keyword)
                ->orLike('jabatan', $keyword)
            ->groupEnd()
            ->orderBy('urutan', 'ASC')
            ->get()
            ->getResultArray();
    }
}
