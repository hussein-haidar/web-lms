<?php

namespace App\Models;

use CodeIgniter\Model;

class M_galeri_uji_kompetensi extends Model
{
    protected $table = 'galeri_uji_kompetensi';
    protected $primaryKey = 'id_galeri';
    protected $allowedFields = [
        'id_uji_kompetensi',
        'judul',
        'deskripsi',
        'gambar',
        'status',
    ];
    protected $useTimestamps = false;
    protected $returnType = 'array';

    public function getAll()
    {
        return $this->select('galeri_uji_kompetensi.*, uji_kompetensi.nama_uji_kompetensi')
            ->join('uji_kompetensi', 'uji_kompetensi.id_uji_kompetensi = galeri_uji_kompetensi.id_uji_kompetensi', 'left')
            ->orderBy('galeri_uji_kompetensi.created_at', 'DESC')
            ->findAll();
    }

    public function getAktif()
    {
        return $this->where('status', 'aktif')
            ->orderBy('created_at', 'DESC')
            ->findAll();
    }
}
