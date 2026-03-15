<?php

namespace App\Models;

use CodeIgniter\Model;

class M_detail_kursus extends Model
{
    protected $table = 'detail_kursus';
    protected $primaryKey = 'id_detail';
    protected $allowedFields = [
        'id_kursus',
        'gambar_detail_a',
        'gambar_detail_b',
        'gambar_detail_c',
        'materi_yang_dipelajari',
        'syarat_pendaftaran',
        'id_pemilik'
    ];
    protected $useTimestamps = false;
    protected $returnType = 'array';

    // Ambil detail berdasarkan ID kursus
    public function getByKursus($id_kursus)
    {
        return $this->where('id_kursus', $id_kursus)->first();
    }

    // ✅ TAMBAHKAN METHOD INI
    // Update detail berdasarkan id_kursus
    public function updateDetail($id_kursus, $data)
    {
        return $this->where('id_kursus', $id_kursus)->set($data)->update();
    }

    // Detail lengkap berdasarkan id_kursus
    public function deleteByKursus($id_kursus)
    {
        return $this->where('id_kursus', $id_kursus)->delete();
    }

    /**
     * Update detail kursus
     */
    public function edit($data)
    {
        return $this->update($data['id_detail'], $data);
    }
}
