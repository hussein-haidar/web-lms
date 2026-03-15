<?php

namespace App\Models;

use CodeIgniter\Model;

class M_inventory extends Model
{
    protected $table = 'inventory';
    protected $primaryKey = 'id_simpan';
    protected $allowedFields = [
        'nama_barang',
        'jumlah_barang',
        'tanggal_masuk',
        'tanggal_keluar',
        'tanggal_perbaikan',
        'tanggal_pengecekan',
        'kondisi',
        'id_karyawan',
        'id_pemilik'
    ];
    protected $useTimestamps = false;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;

    // Ambil semua data inventory, urut terbaru
    public function get_simpan()
    {
        return $this->orderBy('id_simpan', 'DESC')->findAll();
    }

    // Ambil inventory berdasarkan karyawan
    public function getInventoryByKaryawan($id_karyawan)
    {
        return $this->where('id_karyawan', $id_karyawan)
                    ->orderBy('tanggal_pengecekan', 'DESC')
                    ->findAll();
    }

    // Ambil inventory berdasarkan kondisi
    public function getInventoryByKondisi($kondisi)
    {
        return $this->where('kondisi', $kondisi)
                    ->orderBy('tanggal_pengecekan', 'DESC')
                    ->findAll();
    }

    // Detail inventory berdasarkan ID
    public function detailInventory($id_simpan)
    {
        return $this->where('id_simpan', $id_simpan)->first();
    }

    // Tambah data inventory
    public function add($data)
    {
        return $this->insert($data);
    }

    // Edit data inventory
    public function edit($data)
    {
        return $this->update($data['id_simpan'], $data);
    }

    // Hapus data inventory
    public function deleted($id_simpan)
    {
        return $this->delete($id_simpan);
    }

    // Update stok barang (masuk)
    public function updateStokMasuk($id_simpan, $jumlah_tambah)
    {
        $inventory = $this->find($id_simpan);
        if ($inventory) {
            $new_jumlah = $inventory['jumlah_barang'] + $jumlah_tambah;
            return $this->update($id_simpan, [
                'jumlah_barang' => $new_jumlah,
                'tanggal_masuk' => date('Y-m-d H:i:s')
            ]);
        }
        return false;
    }

    // Update stok barang (keluar)
    public function updateStokKeluar($id_simpan, $jumlah_keluar)
    {
        $inventory = $this->find($id_simpan);
        if ($inventory && $inventory['jumlah_barang'] >= $jumlah_keluar) {
            $new_jumlah = $inventory['jumlah_barang'] - $jumlah_keluar;
            return $this->update($id_simpan, [
                'jumlah_barang' => $new_jumlah,
                'tanggal_keluar' => date('Y-m-d H:i:s')
            ]);
        }
        return false;
    }

    // Update kondisi barang
    public function updateKondisi($id_simpan, $kondisi, $tanggal_perbaikan = null)
    {
        $update_data = [
            'kondisi' => $kondisi,
            'tanggal_pengecekan' => date('Y-m-d H:i:s')
        ];
        
        if ($tanggal_perbaikan) {
            $update_data['tanggal_perbaikan'] = $tanggal_perbaikan;
        }
        
        return $this->update($id_simpan, $update_data);
    }

    // Get statistik inventory
    public function getStatistik()
    {
        $builder = $this->db->table($this->table);
        
        // Total barang
        $total_barang = $builder->selectSum('jumlah_barang')->get()->getRowArray();
        
        // Barang berdasarkan kondisi
        $kondisi_baik = $builder->where('kondisi', 'baik')->countAllResults(false);
        $kondisi_rusak_ringan = $builder->where('kondisi', 'rusak_ringan')->countAllResults(false);
        $kondisi_rusak_berat = $builder->where('kondisi', 'rusak_berat')->countAllResults(false);
        
        return [
            'total_barang' => $total_barang['jumlah_barang'] ?? 0,
            'kondisi_baik' => $kondisi_baik,
            'kondisi_rusak_ringan' => $kondisi_rusak_ringan,
            'kondisi_rusak_berat' => $kondisi_rusak_berat
        ];
    }

    // Cari inventory berdasarkan nama barang
    public function searchInventory($keyword)
    {
        return $this->like('nama_barang', $keyword)
                    ->orLike('kondisi', $keyword)
                    ->orderBy('tanggal_pengecekan', 'DESC')
                    ->findAll();
    }
}