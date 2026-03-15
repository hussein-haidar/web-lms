<?php

namespace App\Models;

use CodeIgniter\Model;

class M_alumni extends Model
{
    protected $table = 'lulusan';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'nama',
        'deskripsi',
        'kategori',
        'lokasi',
        'foto_profil',
        'facebook_url',
        'tiktok_url',
        'whatsapp_url',
        'galeri',
        'warna_tema',
        'status'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $dateFormat = 'datetime';

    // Get all alumni with filtering
    public function getAlumni($status = null, $kategori = null)
    {
        $builder = $this->builder();
        
        if ($status) {
            $builder->where('status', $status);
        }
        
        if ($kategori) {
            $builder->where('kategori', $kategori);
        }
        
        return $builder->orderBy('created_at', 'DESC')->get()->getResultArray();
    }

    // Get alumni by ID
    public function getAlumniById($id)
    {
        return $this->find($id);
    }

    // Get categories for filter
    public function getKategoriList()
    {
        $builder = $this->builder();
        $result = $builder->select('kategori')->distinct()->get()->getResultArray();
        
        $categories = [];
        foreach ($result as $row) {
            $categories[] = $row['kategori'];
        }
        
        return $categories;
    }

    // Insert alumni data
    public function addAlumni($data)
    {
        // Handle galeri JSON
        if (isset($data['galeri']) && is_array($data['galeri'])) {
            $data['galeri'] = json_encode($data['galeri']);
        }
        
        return $this->insert($data);
    }

    // Update alumni data
    public function updateAlumni($id, $data)
    {
        // Handle galeri JSON
        if (isset($data['galeri']) && is_array($data['galeri'])) {
            $data['galeri'] = json_encode($data['galeri']);
        }
        
        return $this->update($id, $data);
    }

    // Delete alumni
    public function deleteAlumni($id)
    {
        $alumni = $this->find($id);
        
        if ($alumni) {
            // Hapus foto profil jika ada
            if (!empty($alumni['foto_profil']) && file_exists(FCPATH . 'uploads/alumni/profil/' . $alumni['foto_profil'])) {
                unlink(FCPATH . 'uploads/alumni/profil/' . $alumni['foto_profil']);
            }
            
            // Hapus foto galeri jika ada
            if (!empty($alumni['galeri'])) {
                $galeri = json_decode($alumni['galeri'], true);
                if (is_array($galeri)) {
                    foreach ($galeri as $foto) {
                        if (!empty($foto['foto']) && file_exists(FCPATH . 'uploads/alumni/galeri/' . $foto['foto'])) {
                            unlink(FCPATH . 'uploads/alumni/galeri/' . $foto['foto']);
                        }
                    }
                }
            }
        }
        
        return $this->delete($id);
    }

    // Get gallery photos from JSON
    public function getGaleriPhotos($alumniId)
    {
        $alumni = $this->find($alumniId);
        
        if ($alumni && !empty($alumni['galeri'])) {
            return json_decode($alumni['galeri'], true) ?: [];
        }
        
        return [];
    }

    // Count alumni by status
    public function countByStatus($status = null)
    {
        $builder = $this->builder();
        
        if ($status) {
            $builder->where('status', $status);
        }
        
        return $builder->countAllResults();
    }
}
