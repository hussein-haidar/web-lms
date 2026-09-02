<?php

namespace App\Models;

use CodeIgniter\Model;

class M_jadwal extends Model
{
    protected $table = 'jadwal';
    protected $primaryKey = 'id_jadwal';
    protected $allowedFields = [
        'id_kursus',
        'id_karyawan',
        'judul',
        'deskripsi',
        'tanggal_mulai',
        'tanggal_selesai',
        'tipe',
        'warna',
        'is_recurring',
        'recurrence',
        'status',
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $returnType = 'array';

    /**
     * Semua jadwal + nama kursus & karyawan (untuk manajemen staf/pengajar)
     */
    public function getList()
    {
        return $this->db->table($this->table . ' j')
            ->select('j.*, k.nama_kursus, kar.nama_lengkap as nama_pengajar')
            ->leftJoin('kursus k', 'k.id_kursus = j.id_kursus')
            ->leftJoin('karyawan kar', 'kar.id_karyawan = j.id_karyawan')
            ->orderBy('j.tanggal_mulai', 'DESC')
            ->get()
            ->getResultArray();
    }

    /**
     * Ambil jadwal untuk bulan tertentu (siswa)
     */
    public function getJadwalBulan($bulan, $tahun, $id_siswa = null)
    {
        $start = "$tahun-$bulan-01";
        $end = date('Y-m-t', strtotime($start));

        $builder = $this->db->table($this->table . ' j')
            ->select('j.*, k.nama_kursus')
            ->leftJoin('kursus k', 'k.id_kursus = j.id_kursus')
            ->where('j.status', 'aktif')
            ->where('j.tanggal_mulai >=', $start)
            ->where('j.tanggal_selesai <=', $end);

        if ($id_siswa) {
            $builder->groupStart()
                ->where('j.id_kursus IS NULL')
                ->orWhereIn('j.id_kursus', function ($query) use ($id_siswa) {
                    $query->select('id_kursus')
                        ->from('pendaftaran')
                        ->where('id_siswa', $id_siswa)
                        ->whereIn('status', ['aktif', 'selesai']);
                })
                ->groupEnd();
        }

        return $builder->orderBy('j.tanggal_mulai', 'ASC')
            ->get()
            ->getResultArray();
    }

    /**
     * Ambil jadwal untuk rentang tanggal (FullCalendar)
     */
    public function getJadwalRange($start, $end, $id_siswa = null)
    {
        $builder = $this->db->table($this->table . ' j')
            ->select('j.*, k.nama_kursus')
            ->leftJoin('kursus k', 'k.id_kursus = j.id_kursus')
            ->where('j.status', 'aktif')
            ->where('j.tanggal_mulai >=', $start)
            ->where('j.tanggal_selesai <=', $end);

        if ($id_siswa) {
            $builder->groupStart()
                ->where('j.id_kursus IS NULL')
                ->orWhereIn('j.id_kursus', function ($query) use ($id_siswa) {
                    $query->select('id_kursus')
                        ->from('pendaftaran')
                        ->where('id_siswa', $id_siswa)
                        ->whereIn('status', ['aktif', 'selesai']);
                })
                ->groupEnd();
        }

        return $builder->orderBy('j.tanggal_mulai', 'ASC')
            ->get()
            ->getResultArray();
    }
}
