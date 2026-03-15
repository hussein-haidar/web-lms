<?php

namespace App\Models;

use CodeIgniter\Model;

class M_slider extends Model
{
    protected $table            = 'slider_promo';
    protected $primaryKey       = 'id_slider';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftdeleteds   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'judul_slider',
        'deskripsi',
        'gambar_slider',
        'link_url',
        'urutan',
        'status',
        'id_pemilik'
    ];

    // ✅ Default image constants
    const DEFAULT_IMAGE = 'default-slider.jpg';
    const DEFAULT_HERO = 'hero-default.png';

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    /**
     * Get all active sliders ordered by urutan
     */
    public function getActiveSliders()
    {
        return $this->where('status', 'aktif')
                    ->orderBy('urutan', 'ASC')
                    ->findAll();
    }

    /**
     * Get all sliders by pemilik
     */
    public function getSlidersByPemilik($id_pemilik)
    {
        return $this->where('id_pemilik', $id_pemilik)
                    ->orderBy('urutan', 'ASC')
                    ->orderBy('created_at', 'DESC')
                    ->findAll();
    }

    /**
     * Update slider order
     */
    public function updateOrder($id_slider, $urutan)
    {
        return $this->update($id_slider, ['urutan' => $urutan]);
    }

    /**
     * Toggle slider status
     */
    public function toggleStatus($id_slider)
    {
        $slider = $this->find($id_slider);
        $newStatus = ($slider['status'] === 'aktif') ? 'nonaktif' : 'aktif';
        
        return $this->update($id_slider, ['status' => $newStatus]);
    }
}