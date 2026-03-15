<?php

namespace App\Models;

use CodeIgniter\Model;

class M_materi extends Model
{
    protected $table            = 'materi';
    protected $primaryKey       = 'id_materi';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id_modul',
        'id_kursus',
        'judul_materi',
        'tipe_materi',
        'konten_text',
        'deskripsi_materi',
        'urutan',
        'is_preview',
        'status',
        'tanggal_dibuat'
    ];

    // Dates
    protected $useTimestamps = false;

    /**
     * Get materi by Modul ID
     */
    public function getByModul($id_modul)
    {
        return $this->where('id_modul', $id_modul)
            ->where('status', 'aktif')
            ->orderBy('urutan', 'ASC')
            ->findAll();
    }

    /**
     * Get materi by Modul ID (alias for consistency)
     */
    public function getMateriByModul($id_modul)
    {
        return $this->getByModul($id_modul);
    }

    /**
     * Get counts of video, zoom, quiz, and text materials for a course
     */
    public function getMateriStats($id_kursus)
    {
        return $this->select('tipe_materi, COUNT(*) as total')
            ->where('id_kursus', $id_kursus)
            ->where('status', 'aktif')
            ->groupBy('tipe_materi')
            ->findAll();
    }
}
