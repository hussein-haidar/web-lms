<?php

namespace App\Models;

use CodeIgniter\Model;

class M_keranjang extends Model
{
    protected $table            = 'keranjang';
    protected $primaryKey       = 'id_keranjang';
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'id_siswa',
        'id_kursus', 
        'id_paket',
        'nama_paket',
        'nama_program',
        'harga_kursus',
        'harga', // fallback for old column name
        'created_at'
    ];
    
    // Dynamic allowed fields based on actual table structure
    public function getAllowedFields()
    {
        $db = \Config\Database::connect();
        $columns = $db->getFieldNames('keranjang');
        
        $possibleFields = [
            'id_siswa',
            'id_kursus', 
            'id_paket',
            'nama_paket',
            'nama_program',
            'harga_kursus',
            'harga', // fallback for old column name
            'created_at'
        ];
        
        return array_intersect($possibleFields, $columns);
    }
    
    // Override insert to handle dynamic column mapping
    public function insert($data = null, bool $returnID = true)
    {
        $db = \Config\Database::connect();
        $columns = $db->getFieldNames('keranjang');
        
        // Ensure harga_kursus is never null
        if (isset($data['harga_kursus'])) {
            $data['harga_kursus'] = is_numeric($data['harga_kursus']) ? (float)$data['harga_kursus'] : 0.00;
        }
        
        // Handle column mapping for compatibility
        if (isset($data['harga_kursus']) && !in_array('harga_kursus', $columns) && in_array('harga', $columns)) {
            $data['harga'] = $data['harga_kursus'];
            unset($data['harga_kursus']);
        }
        
        // Remove nama_program if column doesn't exist
        if (isset($data['nama_program']) && !in_array('nama_program', $columns)) {
            unset($data['nama_program']);
        }
        
        return parent::insert($data, $returnID);
    }

    // Ambil semua isi keranjang milik siswa beserta detail kursus
    public function get_keranjang_siswa($id_siswa)
    {
        return $this->db->table('keranjang')
            ->select('keranjang.*, kursus.nama_kursus, detail_kursus.gambar_detail_a, detail_kursus.gambar_detail_b, detail_kursus.gambar_detail_c, kursus.gambar_utama')
            ->join('kursus', 'kursus.id_kursus = keranjang.id_kursus', 'left')
            ->join('detail_kursus', 'detail_kursus.id_kursus = keranjang.id_kursus', 'left')
            ->where('keranjang.id_siswa', $id_siswa)
            ->get()->getResultArray();
    }

    // Cek apakah item sudah ada di keranjang untuk menghindari dobel
    public function cek_item_ada($id_siswa, $id_kursus, $id_paket, $nama_program)
    {
        // Build the base where conditions
        $whereConditions = [
            'id_siswa' => $id_siswa,
            'id_kursus' => $id_kursus,
            'id_paket' => $id_paket
        ];
        
        // Check if nama_program column exists before adding it to where clause
        $db = \Config\Database::connect();
        $columns = $db->getFieldNames('keranjang');
        
        if (in_array('nama_program', $columns)) {
            $whereConditions['nama_program'] = $nama_program;
        }
        
        return $this->where($whereConditions)->first();
    }

    // Total harga keranjang
    public function total_harga_keranjang($id_siswa)
    {
        $db = \Config\Database::connect();
        $columns = $db->getFieldNames('keranjang');
        
        $builder = $this->db->table('keranjang');
        
        // Use the correct column name based on what exists
        if (in_array('harga_kursus', $columns)) {
            $builder->selectSum('harga_kursus');
        } else {
            $builder->selectSum('harga');
        }
        
        $builder->where('id_siswa', $id_siswa);
        $result = $builder->get()->getRow();
        
        // Return the appropriate column value
        if (in_array('harga_kursus', $columns)) {
            return $result->harga_kursus ?? 0;
        } else {
            return $result->harga ?? 0;
        }
    }

    public function hapus_keranjang_siswa($id_siswa)
    {
        return $this->db->table('keranjang')->where('id_siswa', $id_siswa)->delete();
    }
}
