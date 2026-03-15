<?php

namespace App\Models;

use CodeIgniter\Model;

class M_siswa extends Model
{
    protected $table            = 'siswa';
    protected $primaryKey       = 'id_siswa';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftdeleteds   = true;
    protected $deletedField    = 'deleted_at';
    protected $useTimestamps   = true;
    protected $createdField    = 'created_at';
    protected $updatedField    = 'updated_at';
    protected $protectFields    = true;
    protected $allowedFields    = [
        'nis',
        'nama_lengkap',
        'email',
        'kata_sandi',
        'foto_profil',
        'foto_profil',
        'no_telepon',
        'alamat',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'agama',
        'level',
        'tanggal_daftar',
        'last_login',
        'id_pemilik',
        'status_aktif'
    ];

    // Dates
    protected $dateFormat    = 'datetime';

    /**
     * Get profil siswa by ID
     */
    public function get_profil($id_siswa)
    {
        return $this->db->table('siswa')
            ->where('id_siswa', $id_siswa)
            ->get()->getRowArray();
    }

    /**
     * Get profil siswa dengan data pendaftaran
     */
    /**
     * Ambil siswa yang terdaftar di kursus yang diajar oleh pengajar tertentu
     * @param int $id_karyawan ID karyawan/pengajar dari session
     * @param string|null $filter status_aktif (dinamis, tanpa hardcode)
     */
    /**
     * Get siswa by pengajar with program filtering
     * @param int $id_karyawan ID karyawan/pengajar dari session
     * @param int|null $filter_program ID program untuk filter
     */
    public function getSiswaByPengajarAndProgram($id_karyawan, $filter_program = null)
    {
        $builder = $this->db->table('siswa s')
            ->select('
            s.id_siswa, s.nis, s.nama_lengkap, s.email, s.no_telepon, 
            s.alamat, s.foto_profil, s.tanggal_daftar, s.status_aktif,
            k.id_kursus, k.nama_kursus,
            p.id_program, p.nama_program,
            COUNT(d.id_pendaftaran) as jumlah_pendaftaran,
            GROUP_CONCAT(d.nama_paket SEPARATOR ", ") as paket_terdaftar
        ')
            ->join('pendaftaran d', 's.id_siswa = d.id_siswa', 'left')
            ->join('kursus k', 'd.id_kursus = k.id_kursus', 'left')
            ->join('program_kursus p', 'k.id_program = p.id_program', 'left')
            ->where('k.id_karyawan', $id_karyawan)
            ->groupBy('s.id_siswa')
            ->orderBy('p.nama_program', 'ASC')
            ->orderBy('s.nama_lengkap', 'ASC');

        if (!empty($filter_program)) {
            $builder->where('p.id_program', $filter_program);
        }

        $query = $builder->get();

        // Selalu return array kosong jika gagal / tidak ada data
        return $query ? $query->getResultArray() : [];
    }

    /**
     * Get program list by pengajar for dropdown
     * @param int $id_karyawan ID karyawan/pengajar
     */
    public function getProgramListByPengajar($id_karyawan)
    {
        $builder = $this->db->table('program_kursus p')
            ->select('
            p.id_program, p.nama_program,
            COUNT(s.id_siswa) as total
        ')
            ->join('kursus k', 'p.id_program = k.id_program', 'left')
            ->join('pendaftaran d', 'k.id_kursus = d.id_kursus', 'left')
            ->join('siswa s', 'd.id_siswa = s.id_siswa', 'left')
            ->where('k.id_karyawan', $id_karyawan)
            ->groupBy('p.id_program')
            ->orderBy('p.nama_program', 'ASC');

        $query = $builder->get();
        $result = $query ? $query->getResultArray() : [];
        
        // Format untuk dropdown: id_program => nama_program
        $programList = [];
        foreach ($result as $program) {
            $programList[$program['id_program']] = $program['nama_program'];
        }
        
        return $programList;
    }

    public function getSiswaByPengajar($id_karyawan, $filter = null)
    {
        $builder = $this->db->table('siswa s')
            ->select('
            s.id_siswa, s.nis, s.nama_lengkap, s.email, s.no_telepon, 
            s.alamat, s.foto_profil, s.tanggal_daftar, s.status_aktif,
            k.id_kursus, k.nama_kursus,
            COUNT(d.id_pendaftaran) as jumlah_pendaftaran,
            GROUP_CONCAT(d.nama_paket SEPARATOR ", ") as paket_terdaftar
        ')
            ->join('pendaftaran d', 's.id_siswa = d.id_siswa', 'left')
            ->join('kursus k', 'd.id_kursus = k.id_kursus', 'left')
            ->where('k.id_karyawan', $id_karyawan)
            // Hilangkan where status 'proses' agar semua siswa terdaftar muncul
            // Jika ingin filter status tertentu, bisa ditambahkan via parameter atau di controller
            ->groupBy('s.id_siswa')
            ->orderBy('s.nama_lengkap', 'ASC');

        if (!empty($filter)) {
            $builder->where('s.status_aktif', $filter);
        }

        $query = $builder->get();

        // Selalu return array kosong jika gagal / tidak ada data
        return $query ? $query->getResultArray() : [];
    }
    public function getSiswaWithPendaftaran($id_siswa = null, $filter_status = null, $filter_kursus = null)
    {
        $builder = $this->db->table('siswa s')
            ->select('
            s.id_siswa, s.nis, s.nama_lengkap, s.email, s.no_telepon, 
            s.alamat, s.foto_profil, s.tanggal_daftar, s.status_aktif,
            k.id_kursus, k.nama_kursus, -- Ambil info kursus utama
            COUNT(d.id_pendaftaran) as jumlah_pendaftaran,
            GROUP_CONCAT(d.nama_paket SEPARATOR ", ") as paket_terdaftar
        ')
            ->join('pendaftaran d', 's.id_siswa = d.id_siswa', 'left')
            ->join('kursus k', 'd.id_kursus = k.id_kursus', 'left') // Join ke tabel kursus
            ->groupBy('s.id_siswa')
            ->orderBy('s.id_siswa', 'DESC');

        // Filter Status (Aktif/Nonaktif)
        if (!empty($filter_status) && in_array($filter_status, ['aktif', 'nonaktif'])) {
            $builder->where('s.status_aktif', $filter_status);
        }

        // Filter Kursus (Baru)
        if (!empty($filter_kursus)) {
            $builder->where('d.id_kursus', $filter_kursus);
        }

        if ($id_siswa !== null) {
            $builder->where('s.id_siswa', $id_siswa);
            return $builder->get()->getRowArray();
        }

        return $builder->get()->getResultArray();
    }

    // Method helper untuk mendapatkan semua kursus (untuk dropdown)
    public function getAllKursus()
    {
        return $this->db->table('kursus')
            ->select('id_kursus, nama_kursus')
            ->where('status', 'aktif')
            ->orderBy('nama_kursus', 'ASC')
            ->get()
            ->getResultArray();
    }

    public function detailSiswa($id_siswa)
    {
        return $this->db->table('siswa')
            ->where('id_siswa', $id_siswa)
            ->get()->getRowArray();
    }

    public function findByNisOrEmail($input)
    {
        $builder = $this->db
            ->table($this->table)
            ->where('nis', $input)
            ->orWhere('email', $input)
            ->where('status_aktif', 'aktif'); // Hanya siswa aktif

        $query = $builder->get();

        if ($query->getNumRows() > 0) {
            return $query->getRowArray();
        }

        return null;
    }

    public function add($data)
    {
        $this->db->table('siswa')
            ->insert($data);
    }

    public function edit($id_siswa, $data)
    {
        return $this->db->table('siswa')
            ->where('id_siswa', $id_siswa)
            ->update($data);
    }

    public function deleted_data($data)
    {
        // Use soft delete instead of hard delete
        return $this->delete($data['id_siswa']);
    }

    // ✅ Restore soft deleted siswa
    public function restore($id_siswa)
    {
        return $this->update($id_siswa, ['deleted_at' => null]);
    }

    // ✅ Get deleted siswa (for restore functionality)
    public function getDeletedSiswa()
    {
        return $this->onlyDeleted()->findAll();
    }

    // ✅ Force permanent delete (if needed)
    public function forceDelete($id_siswa)
    {
        return $this->db->table('siswa')
            ->where('id_siswa', $id_siswa)
            ->delete();
    }

    public function updateLastLogin($id_siswa)
    {
        $data = [
            'last_login' => date('Y-m-d H:i:s')
        ];

        return $this->update($id_siswa, $data);
    }
}
