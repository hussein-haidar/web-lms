<?php

namespace App\Models;

use CodeIgniter\Model;

class M_profil_lpk extends Model
{
    protected $table = 'profil_lpk';
    protected $primaryKey = 'id_profil';
    protected $allowedFields = [
        'judul_header',
        'subjudul_header',
        'video_url',
        'video_title',
        'sejarah_singkat',
        'tahun_berdiri',
        'tanggal_resmi',
        'tanggal_izin',
        'status_akreditasi'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';
    protected $useSoftDeletes = true;

    // Get profil (single record for website)
    public function getProfil()
    {
        try {
            return $this->where('deleted_at', null)
                       ->orderBy('id_profil', 'DESC')
                       ->first();
        } catch (\Exception $e) {
            // If deleted_at column doesn't exist, get without filtering
            return $this->orderBy('id_profil', 'DESC')->first();
        }
    }

    // Get profil by ID
    public function getProfilById($id)
    {
        return $this->where('id_profil', $id)
                   ->where('deleted_at', null)
                   ->first();
    }

    // Insert new profil
    public function insertProfil($data)
    {
        return $this->insert($data);
    }

    // Update profil
    public function updateProfil($id, $data)
    {
        return $this->where('id_profil', $id)
                   ->set($data)
                   ->update();
    }

    // Soft delete profil
    public function deleteProfil($id)
    {
        return $this->where('id_profil', $id)
                   ->set('deleted_at', date('Y-m-d H:i:s'))
                   ->update();
    }

    // Restore deleted profil
    public function restoreProfil($id)
    {
        return $this->where('id_profil', $id)
                   ->set('deleted_at', null)
                   ->update();
    }

    // Force delete profil
    public function forceDeleteProfil($id)
    {
        return $this->where('id_profil', $id)
                   ->delete();
    }

    // Get all deleted profiles
    public function getDeletedProfil()
    {
        return $this->where('deleted_at IS NOT NULL')
                   ->orderBy('deleted_at', 'DESC')
                   ->findAll();
    }
}
