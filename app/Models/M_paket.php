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
// ✅ GET PAKET DENGAN FILTER - Mapping "Program kursus singkat" ke "Kelas Offline"
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
            
            // ✅ LOGICA KHUSUS: Mapping "Program kursus singkat" → "Kelas Offline"
            if ($filterValue === 'program kursus singkat') {
                // Tampilkan data dari program "Kelas Offline"
                $builder->where("LOWER(pr.nama_program)", 'kelas offline');
            } elseif ($filterValue === 'kelas online') {
                // Jika filter "Kelas Online", hanya tampilkan Paket A
                $builder->where("LOWER(pr.nama_program)", 'kelas online')
                        ->where("LOWER(pk.paket_a) IS NOT NULL")
                        ->where("LOWER(pk.paket_b) IS NOT NULL")
                        ->where("LOWER(pk.paket_c) IS NOT NULL");
                // Tambahkan kondisi untuk hanya menampilkan paket yang relevan untuk kelas online
                $builder->where("(pk.paket_a != '' OR pk.paket_a IS NOT NULL)");
            } elseif ($filterValue === 'profesi 1 tahun') {
                // Jika filter "Profesi 1 Tahun", hanya tampilkan Paket A
                $builder->where("LOWER(pr.nama_program)", 'profesi 1 tahun')
                        ->where("(pk.paket_a != '' OR pk.paket_a IS NOT NULL)");
            } else {
                // Filter normal untuk pilihan lain
                $cfg = $filterConfig[$key];
                $field = "{$cfg['table_alias']}.{$cfg['column']}";
                
                if ($cfg['type'] === 'like') {
                    $builder->like("LOWER({$field})", strtolower($val), 'both');
                } else {
                    $builder->where("LOWER({$field})", strtolower($val));
                }
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
}
