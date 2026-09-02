<?php

namespace App\Models;

use CodeIgniter\Model;

class M_visi_misi extends Model
{
    protected $table = 'visi_misi';
    protected $primaryKey = 'id_visimisi';
    protected $allowedFields = [
        'jenis',
        'konten',
        'urutan',
        'status'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';
    protected $useSoftDeletes = true;

    // Get all visi
    public function getVisi()
    {
        try {
            return $this->where('jenis', 'visi')
                       ->where('status', 'aktif')
                       ->where('deleted_at', null)
                       ->orderBy('urutan', 'ASC')
                       ->findAll();
        } catch (\Exception $e) {
            // If columns don't exist, get without filtering
            try {
                return $this->where('jenis', 'visi')
                           ->orderBy('urutan', 'ASC')
                           ->findAll();
            } catch (\Exception $e2) {
                // If jenis column doesn't exist, return empty array
                return [];
            }
        }
    }

    // Get all misi
    public function getMisi()
    {
        try {
            return $this->where('jenis', 'misi')
                       ->where('status', 'aktif')
                       ->where('deleted_at', null)
                       ->orderBy('urutan', 'ASC')
                       ->findAll();
        } catch (\Exception $e) {
            // If columns don't exist, get without filtering
            try {
                return $this->where('jenis', 'misi')
                           ->orderBy('urutan', 'ASC')
                           ->findAll();
            } catch (\Exception $e2) {
                // If jenis column doesn't exist, return empty array
                return [];
            }
        }
    }

    // Get all visi and misi (for admin)
    public function getAllVisiMisi()
    {
        return $this->where('deleted_at', null)
                   ->orderBy('jenis', 'ASC')
                   ->orderBy('urutan', 'ASC')
                   ->findAll();
    }

    // Get by ID
    public function getById($id)
    {
        return $this->where('id_visimisi', $id)
                   ->where('deleted_at', null)
                   ->first();
    }

    // Insert new visi/misi
    public function insertVisiMisi($data)
    {
        return $this->insert($data);
    }

    // Update visi/misi
    public function updateVisiMisi($id, $data)
    {
        return $this->where('id_visimisi', $id)
                   ->set($data)
                   ->update();
    }

    // Soft delete
    public function deleteVisiMisi($id)
    {
        return $this->where('id_visimisi', $id)
                   ->set('deleted_at', date('Y-m-d H:i:s'))
                   ->update();
    }

    // Restore
    public function restoreVisiMisi($id)
    {
        return $this->where('id_visimisi', $id)
                   ->set('deleted_at', null)
                   ->update();
    }

    // Force delete
    public function forceDeleteVisiMisi($id)
    {
        return $this->where('id_visimisi', $id)
                   ->delete();
    }

    // Get deleted items
    public function getDeletedVisiMisi()
    {
        return $this->where('deleted_at IS NOT NULL')
                   ->orderBy('deleted_at', 'DESC')
                   ->findAll();
    }

    // Update order
    public function updateOrder($id, $urutan)
    {
        return $this->where('id_visimisi', $id)
                   ->set('urutan', $urutan)
                   ->update();
    }
}
