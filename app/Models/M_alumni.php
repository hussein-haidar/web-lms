<?php

namespace App\Models;

use CodeIgniter\Model;

class M_alumni extends Model
{
    protected $table = 'alumni';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'nama',
        'deskripsi',
        'kategori',
        'lokasi',
        'foto_profil',
        'gambar',
        'folder_galeri',
        'gambar_pattern',
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
    
    protected $useAutoIncrement = true;

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

    // Get alumni with automatic gambar paths
    public function getAlumniWithGambar($status = null, $kategori = null)
    {
        $builder = $this->builder();
        
        if ($status) {
            $builder->where('status', $status);
        }
        
        if ($kategori) {
            $builder->where('kategori', $kategori);
        }
        
        $alumni = $builder->orderBy('created_at', 'DESC')->get()->getResultArray();
        
        // Generate automatic gambar paths for each alumni
        foreach ($alumni as &$item) {
            $item = $this->generateGambarPaths($item);
        }
        
        return $alumni;
    }

    // Generate automatic gambar paths based on pattern
    private function generateGambarPaths($alumni)
    {
        // If gambar_pattern exists, generate gambar paths
        if (!empty($alumni['gambar_pattern'])) {
            $pattern = $alumni['gambar_pattern'];
            
            // Generate main gambar path (index 1 for profile image)
            $alumni['gambar_path'] = str_replace('{index}', '2', $pattern);
            
            // Generate gallery paths (indexes 1-6 for gallery images)
            $alumni['gallery_paths'] = [];
            for ($i = 1; $i <= 6; $i++) {
                $alumni['gallery_paths'][] = str_replace('{index}', $i, $pattern);
            }
        }
        // Fallback to folder_galeri if pattern not set
        elseif (!empty($alumni['folder_galeri'])) {
            $folder = $alumni['folder_galeri'];
            $prefix = $this->getPrefixFromNama($alumni['nama']);
            
            $alumni['gambar_path'] = $folder . '/' . $prefix . '(2).jpg';
            $alumni['gallery_paths'] = [];
            for ($i = 1; $i <= 6; $i++) {
                $alumni['gallery_paths'][] = $folder . '/' . $prefix . '(' . $i . ').jpg';
            }
        }
        // Final fallback to default structure
        else {
            $folder = $this->getDefaultFolder($alumni['nama']);
            $prefix = $this->getPrefixFromNama($alumni['nama']);
            
            $alumni['gambar_path'] = $folder . '/' . $prefix . '(2).jpg';
            $alumni['gallery_paths'] = [];
            for ($i = 1; $i <= 6; $i++) {
                $alumni['gallery_paths'][] = $folder . '/' . $prefix . '(' . $i . ').jpg';
            }
        }
        
        return $alumni;
    }

    // Get prefix from nama alumni
    private function getPrefixFromNama($nama)
    {
        $nama = strtolower($nama);
        
        if (strpos($nama, 'flato') !== false) {
            return 'd';
        } elseif (strpos($nama, 'nusa') !== false) {
            return 'n';
        } elseif (strpos($nama, 'doop') !== false) {
            return 'k';
        }
        
        // Default: use first 3 letters of nama
        return substr(preg_replace('/[^a-z]/', '', $nama), 0, 3);
    }

    // Get default folder based on nama
    private function getDefaultFolder($nama)
    {
        $nama = strtolower($nama);
        
        if (strpos($nama, 'flato') !== false) {
            return 'pwk/flato';
        } elseif (strpos($nama, 'nusa') !== false) {
            return 'pwk/nusa_karya';
        } elseif (strpos($nama, 'doop') !== false) {
            return 'pwk/doop';
        }
        
        // Default: use slugified nama
        return 'pwk/' . preg_replace('/[^a-z]/', '', $nama);
    }

    // Update alumni with automatic path generation
    public function addAlumniWithPaths($data)
    {
        // Generate automatic paths if not provided
        if (empty($data['gambar_pattern']) && !empty($data['nama'])) {
            $folder = $this->getDefaultFolder($data['nama']);
            $prefix = $this->getPrefixFromNama($data['nama']);
            
            $data['folder_galeri'] = $folder;
            $data['gambar_pattern'] = $folder . '/' . $prefix . '({index}).jpg';
            $data['gambar'] = $folder . '/' . $prefix . '(2).jpg';
        }
        
        return $this->addAlumni($data);
    }
}
