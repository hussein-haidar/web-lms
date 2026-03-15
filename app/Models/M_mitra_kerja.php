<?php

namespace App\Models;

use CodeIgniter\Model;

class M_mitra_kerja extends Model
{
    protected $table = 'mitra_kerja';
    protected $primaryKey = 'id_mitra';
    protected $allowedFields = [
        'nama_mitra',
        'logo_mitra',
        'url_website',
        'deskripsi',
        'status',
        'urutan'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';
    protected $returnType = 'array';

    // Get all active partners for frontend
    public function getActivePartners()
    {
        return $this->where('status', 'aktif')
                    ->where('deleted_at IS NULL')
                    ->orderBy('urutan', 'ASC')
                    ->findAll();
    }

    // Get all partners for admin (including inactive)
    public function getAllPartners($status = null)
    {
        $builder = $this->where('deleted_at IS NULL');
        
        if ($status) {
            $builder->where('status', $status);
        }
        
        return $builder->orderBy('urutan', 'ASC')
                      ->findAll();
    }

    // Get partner by ID
    public function getPartnerById($id)
    {
        return $this->where('id_mitra', $id)
                    ->where('deleted_at IS NULL')
                    ->first();
    }

    // Insert new partner
    public function insertPartner($data)
    {
        return $this->insert($data);
    }

    // Update partner
    public function updatePartner($id, $data)
    {
        return $this->where('id_mitra', $id)
                    ->set($data)
                    ->update();
    }

    // Soft delete partner
    public function deletePartner($id)
    {
        return $this->where('id_mitra', $id)
                    ->set('deleted_at', date('Y-m-d H:i:s'))
                    ->update();
    }

    // Restore deleted partner
    public function restorePartner($id)
    {
        return $this->where('id_mitra', $id)
                    ->set('deleted_at', null)
                    ->update();
    }

    // Permanent delete partner
    public function permanentDeletePartner($id)
    {
        return $this->where('id_mitra', $id)
                    ->delete();
    }

    // Get deleted partners
    public function getDeletedPartners()
    {
        return $this->where('deleted_at IS NOT NULL')
                    ->orderBy('deleted_at', 'DESC')
                    ->findAll();
    }

    // Update partner order
    public function updateOrder($id, $urutan)
    {
        return $this->where('id_mitra', $id)
                    ->set('urutan', $urutan)
                    ->update();
    }

    // Count active partners
    public function countActivePartners()
    {
        return $this->where('status', 'aktif')
                    ->where('deleted_at IS NULL')
                    ->countAllResults();
    }

    // Count inactive partners
    public function countInactivePartners()
    {
        return $this->where('status', 'tidak_aktif')
                    ->where('deleted_at IS NULL')
                    ->countAllResults();
    }

    // Search partners
    public function searchPartners($keyword)
    {
        return $this->groupStart()
                    ->like('nama_mitra', $keyword)
                    ->orLike('deskripsi', $keyword)
                    ->groupEnd()
                    ->where('deleted_at IS NULL')
                    ->orderBy('urutan', 'ASC')
                    ->findAll();
    }

    // Get partners for carousel (grouped by 4)
    public function getPartnersForCarousel()
    {
        $partners = $this->getActivePartners();
        return array_chunk($partners, 4);
    }
}
