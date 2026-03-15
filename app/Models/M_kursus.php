<?php

namespace App\Models;

use CodeIgniter\Model;

class M_kursus extends Model
{
    protected $table = 'kursus';
    protected $primaryKey = 'id_kursus';
    protected $allowedFields = [
        'id_karyawan',
        'nama_kursus',
        'id_program',
        'slug',
        'deskripsi_singkat',
        'gambar_utama',
        'status',
        'tanggal_dibuat',
        'id_pemilik'
    ];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';
    protected $useSoftDeletes = true;
    protected $returnType = 'array';
    // Di dalam app/Models/M_kursus.php

    public function get_kursus_by_pengajar($id_karyawan, array $filters = [], array $filterConfig = [])
    {
        $builder = $this->db->table('kursus k');

        $builder->select('k.*, dk.*, pr.nama_program, kr.nama_lengkap AS nama_pengajar')
            ->join('detail_kursus dk', 'dk.id_kursus = k.id_kursus', 'left')
            ->join('program_kursus pr', 'pr.id_program = k.id_program', 'left')
            ->join('karyawan kr', 'kr.id_karyawan = k.id_karyawan', 'left')
            ->where('k.deleted_at IS NULL'); // ✅ Hanya tampilkan data yang tidak dihapus

        // ✅ WAJIB: Filter berdasarkan ID Pengajar yang Login
        // Jika Anda ingin Superadmin melihat semua, tambahkan kondisi level di controller atau sini
        $builder->where('k.id_karyawan', $id_karyawan);

        // Terapkan filter tambahan (status, tipe program, dll)
        foreach ($filters as $key => $val) {
            if (empty($val) || !isset($filterConfig[$key])) continue;

            $cfg = $filterConfig[$key];
            $field = "{$cfg['table_alias']}.{$cfg['column']}";

            if ($cfg['type'] === 'like') {
                $builder->like("LOWER({$field})", strtolower($val), 'both');
            } else {
                $builder->where($field, $val);
            }
        }

        return $builder->orderBy('k.tanggal_dibuat', 'DESC')->get()->getResultArray();
    }

    public function get_kursus(array $filters = [], array $filterConfig = [])
    {
        $builder = $this->db->table('kursus k');

        $builder->select('k.*, dk.*, pr.nama_program, kr.nama_lengkap AS nama_pengajar')
            ->join('detail_kursus dk', 'dk.id_kursus = k.id_kursus', 'left')
            ->join('program_kursus pr', 'pr.id_program = k.id_program', 'left')
            ->join('karyawan kr', 'kr.id_karyawan = k.id_karyawan', 'left')
            ->where('k.deleted_at IS NULL'); // ✅ Hanya tampilkan data yang tidak dihapus

        // ✅ Terapkan filter dengan table_alias
        foreach ($filters as $key => $val) {
            if (empty($val) || !isset($filterConfig[$key])) continue;

            $cfg = $filterConfig[$key];
            // ✅ Gunakan table_alias untuk query WHERE
            $field = "{$cfg['table_alias']}.{$cfg['column']}";

            if ($cfg['type'] === 'like') {
                $builder->like("LOWER({$field})", strtolower($val), 'both');
            } else {
                $builder->where($field, $val);
            }
        }

        return $builder->orderBy('k.tanggal_dibuat', 'DESC')->get()->getResultArray();
    }

    /**
     * Get single kursus with detail by ID
     */
    public function getKursusWithDetailById($id_kursus)
    {
        return $this->db->table('kursus k')
            ->select('
                k.*,
                k.gambar_utama,
                dk.*,
                pk.total_pertemuan,
                pk.durasi_per_pertemuan_jam,
                pr.nama_program,
                kr.nama_lengkap AS nama_pengajar
            ')
            ->join('detail_kursus dk', 'dk.id_kursus = k.id_kursus', 'left')
            ->join('paket_kursus pk', 'pk.id_kursus = k.id_kursus', 'left')
            ->join('program_kursus pr', 'pr.id_program = k.id_program', 'left')
            ->join('karyawan kr', 'kr.id_karyawan = k.id_karyawan', 'left')
            ->where('k.id_kursus', $id_kursus)
            ->get()
            ->getRowArray();
    }

    /**
     * Get kursus detail (alias for consistency)
     */
    public function getKursusDetail($id_kursus)
    {
        return $this->getKursusWithDetailById($id_kursus);
    }

    /**
     * Delete kursus (soft delete)
     */
    public function deleted($id_kursus)
    {
        return $this->delete($id_kursus);
    }

    // ✅ Get kursus by pengajar untuk quiz management
    public function getKursusByPengajar($id_karyawan)
    {
        return $this->where('id_karyawan', $id_karyawan)
            ->where('status', 'aktif')
            ->orderBy('nama_kursus', 'ASC')
            ->findAll();
    }

    // ✅ Restore soft deleted kursus
    public function restore($id_kursus)
    {
        $db = \Config\Database::connect();
        return $db->table($this->table)
                   ->where($this->primaryKey, $id_kursus)
                   ->set(['deleted_at' => null])
                   ->update();
    }

    // ✅ Get deleted kursus (for restore functionality)
    public function getDeletedKursus()
    {
        $db = \Config\Database::connect();
        return $db->table($this->table)
                   ->where('deleted_at IS NOT NULL')
                   ->get()
                   ->getResultArray();
    }

    // ✅ Force permanent delete (if needed)
    public function forceDelete($id_kursus)
    {
        return $this->db->table('kursus')
            ->where('id_kursus', $id_kursus)
            ->delete();
    }

    public function findBySlug($slug)
    {
        return $this->where('slug', $slug)->first();
    }

    // Data
    public function getProgram()
    {
        return $this->db->table('program_kursus')
            ->get()
            ->getResultArray();
    }

    public function getPengajar()
    {
        return $this->db->table('karyawan')
            ->where('level', 'pengajar')
            ->where('deleted_at IS NULL') // ✅ Hanya tampilkan data yang tidak dihapus
            ->get()
            ->getResultArray();
    }

    // Data
    public function getRecommendationsForDashboard($id_siswa)
    {
        // Show all active courses - don't hide enrolled courses
        // Students should see all courses even if they've enrolled (no stock concept)
        $builder = $this->db->table('kursus k')
            ->select('k.*, pk.id_paket, pk.harga_reguler, pr.nama_program, dk.gambar_detail_a')
            ->join('paket_kursus pk', 'pk.id_kursus = k.id_kursus', 'left')
            ->join('program_kursus pr', 'pr.id_program = k.id_program', 'left')
            ->join('detail_kursus dk', 'dk.id_kursus = k.id_kursus', 'left')
            ->where('k.status', 'aktif')
            ->where('pr.nama_program', 'Kelas Online')
            ->groupBy('k.id_kursus');

        return $builder->limit(6)->get()->getResultArray();
    }

    // ✅ Method untuk register form - get kursus dengan harga
    public function getKursusDenganHarga()
    {
        return $this->db->table('kursus k')
            ->select('k.*, pk.nama_paket, pk.harga_reguler, pk.total_pertemuan, pk.durasi_per_pertemuan_jam, pr.nama_program')
            ->join('paket_kursus pk', 'pk.id_kursus = k.id_kursus', 'left')
            ->join('program_kursus pr', 'pr.id_program = k.id_program', 'left')
            ->where('k.status', 'aktif')
            ->where('pk.deleted_at IS NULL', null, false)
            ->orderBy('k.nama_kursus', 'ASC')
            ->get()
            ->getResultArray();
    }

    // ✅ Method untuk staf admin - get semua kursus dengan filter
    public function getKursusWithFilter($filters = [], $filterConfig = [])
    {
        $builder = $this->db->table('kursus k')
            ->select('
                k.*,
                k.gambar_utama,
                dk.*,
                pk.total_pertemuan,
                pk.durasi_per_pertemuan_jam,
                pr.nama_program,
                kr.nama_lengkap AS nama_pengajar
            ')
            ->join('detail_kursus dk', 'dk.id_kursus = k.id_kursus', 'left')
            ->join('paket_kursus pk', 'pk.id_kursus = k.id_kursus', 'left')
            ->join('program_kursus pr', 'pr.id_program = k.id_program', 'left')
            ->join('karyawan kr', 'kr.id_karyawan = k.id_karyawan', 'left')
            ->where('pk.deleted_at IS NULL', null, false);

        // Apply filters
        foreach ($filters as $key => $value) {
            if (!empty($value) && isset($filterConfig[$key])) {
                $cfg = $filterConfig[$key];
                $column = ($cfg['table_alias'] ?? '') . '.' . $cfg['column'];
                
                if ($cfg['type'] === 'where') {
                    $builder->where($column, $value);
                } elseif ($cfg['type'] === 'like') {
                    $builder->like($column, $value);
                }
            }
        }

        return $builder
            ->orderBy('k.nama_kursus', 'ASC')
            ->get()
            ->getResultArray();
    }
}
