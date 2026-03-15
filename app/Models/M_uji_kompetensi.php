<?php

namespace App\Models;

use CodeIgniter\Model;

class M_uji_kompetensi extends Model
{
    protected $table = 'uji_kompetensi';
    protected $primaryKey = 'id_uji_kompetensi';
    protected $allowedFields = [
        'nama_uji_kompetensi',
        'deskripsi',
        'durasi',
        'tipe_pembelajaran',
        'sertifikat',
        'harga',
        'gambar',
        'status'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    public function getAktif()
    {
        return $this->where('status', 'aktif')->findAll();
    }

    public function getDetail($id)
    {
        return $this->where('id_uji_kompetensi', $id)
                    ->where('status', 'aktif')
                    ->first();
    }

    public function getAll()
    {
        return $this->orderBy('created_at', 'DESC')->findAll();
    }

    public function getWithGaleri()
    {
        // Since we're using single table, this will return uji kompetensi data
        // Gallery data can be handled separately if needed
        return $this->orderBy('created_at', 'DESC')->findAll();
    }
}
