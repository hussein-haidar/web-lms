<?php

namespace App\Models;

use CodeIgniter\Model;

class M_slider_web extends Model
{
    protected $table            = 'slider_web';
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

    /**
     * Get all sliders with pagination
     */
    public function getSlidersWithPagination($limit = 10, $offset = 0)
    {
        return $this->orderBy('urutan', 'ASC')
                    ->orderBy('created_at', 'DESC')
                    ->findAll($limit, $offset);
    }

    /**
     * Count all sliders
     */
    public function countSliders()
    {
        return $this->countAll();
    }

    /**
     * Get slider by ID with details
     */
    public function getSliderById($id_slider)
    {
        return $this->find($id_slider);
    }

    /**
     * Delete slider
     */
    public function deleteSlider($id_slider)
    {
        return $this->delete($id_slider);
    }

    /**
     * Get max urutan for new slider
     */
    public function getMaxUrutan()
    {
        $result = $this->selectMax('urutan')->first();
        return $result ? $result['urutan'] + 1 : 1;
    }
}
