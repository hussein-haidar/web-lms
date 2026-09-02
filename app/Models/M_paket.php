<?php

namespace App\Models;

use CodeIgniter\Model;

class M_paket extends Model
{
    protected $table = 'paket_kursus';
    protected $primaryKey = 'id_paket';
    protected $allowedFields = [
        'id_kursus',
        'nama_paket',
        'paket_a',
        'paket_b',
        'paket_c',
        'jadwal_pelatihan',  // ✅ TAMBAH INI
        'total_pertemuan',
        'durasi_per_pertemuan_jam',
        'harga_reguler',
        'harga_intensive',
        'harga_private',
        'deskripsi_a',
        'deskripsi_b',
        'deskripsi_c',
        'id_pemilik'
    ];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    public function detailPaket($id_paket)
    {
        return $this->select('paket_kursus.*, kursus.nama_kursus, program_kursus.nama_program')
            ->join('kursus', 'kursus.id_kursus = paket_kursus.id_kursus', 'left')
            ->join('program_kursus', 'program_kursus.id_program = kursus.id_program', 'left')
            ->find($id_paket);
    }

    // ✅ GET PAKET WITH KURSUS
    public function getPaketWithKursus()
    {
        return $this->db->table($this->table . ' p')
            ->select('p.*, k.nama_kursus')
            ->join('kursus k', 'p.id_kursus = k.id_kursus', 'left')
            ->orderBy('p.created_at', 'DESC')
            ->get()
            ->getResultArray();
    }

// ✅ GET PAKET DENGAN FILTER
    public function get_paket(array $filters = [], array $filterConfig = [])
    {
        $builder = $this->get_paket_builder($filters, $filterConfig);
        return $builder->get()->getResultArray();
    }

    // BUILDER QUERY (untuk debugging jika diperlukan)
    public function get_paket_builder(array $filters = [], array $filterConfig = [])
    {
        $builder = $this->db->table('paket_kursus pk');

        $builder->select('pk.*, k.nama_kursus, k.slug, pr.nama_program')
            ->join('kursus k', 'k.id_kursus = pk.id_kursus', 'left')
            ->join('program_kursus pr', 'pr.id_program = k.id_program', 'left')
            ->where('pk.deleted_at', NULL);

        foreach ($filters as $key => $val) {
            if (empty($val) || !isset($filterConfig[$key])) continue;
            
            $filterValue = strtolower(trim($val));
            
            // Filter normal untuk semua pilihan
            $cfg = $filterConfig[$key];
            $field = "{$cfg['table_alias']}.{$cfg['column']}";
            
            if ($cfg['type'] === 'like') {
                $builder->like("LOWER({$field})", strtolower($val), 'both');
            } else {
                $builder->where("LOWER({$field})", strtolower($val));
            }
        }

        return $builder->orderBy('pk.created_at', 'DESC');
    }

    public function getKursus()
    {
        return $this->db->table('kursus')->get()->getResultArray();
    }

    public function getKursusWithProgram()
    {
        return $this->db->table('kursus k')
            ->select('k.*, pr.nama_program')
            ->join('program_kursus pr', 'pr.id_program = k.id_program', 'left')
            ->where('k.status', 'aktif')
            ->orderBy('k.nama_kursus', 'ASC')
            ->get()
            ->getResultArray();
    }

      // ✅ CUSTOM METHOD DELETE - TERIMA ID SEBAGAI PARAMETER
    public function deleted($id_paket)
    {
        return $this->db->table($this->table)
            ->where($this->primaryKey, $id_paket) // ✅ WHERE by PRIMARY KEY
            ->delete();
    }

    public function softDelete($id)
    {
        return $this->update($id, ['deleted_at' => date('Y-m-d H:i:s')]);
    }

    // Restore soft deleted paket
    public function restore($id_paket)
    {
        return $this->update($id_paket, ['deleted_at' => null]);
    }

    // Get deleted paket (for restore functionality)
    public function onlyDeleted()
    {
        return $this->where('deleted_at IS NOT NULL')
                   ->orderBy('deleted_at', 'DESC')
                   ->findAll();
    }
}
