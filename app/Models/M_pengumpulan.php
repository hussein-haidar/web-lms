<?php

namespace App\Models;

use CodeIgniter\Model;

class M_pengumpulan extends Model
{
    protected $table = 'pengumpulan_tugas';
    protected $primaryKey = 'id_kumpul'; // ✅ Primary key yang benar
    protected $allowedFields = [
        'id_tugas',
        'id_siswa',
        'id_karyawan',
        'file_tugas',
        'catatan_siswa',
        'catatan_pengajar', 
        'nilai',
        'status_penilaian',
        'tanggal_kirim',
        'tanggal_penilaian',
        'id_pemilik'
    ];
    protected $useTimestamps = false;
    protected $returnType = 'array';
    protected $useSoftDeletes = true;
    protected $deletedField = 'deleted_at';

    // Ambil semua tugas, urut terbaru
   public function get_kumpul()
{
    return $this->db->table('pengumpulan_tugas pt')
        ->select('
            pt.*,
            t.judul_tugas,
            t.deskripsi,
            t.deadline,
            s.nama_lengkap as nama_siswa,
            s.email,
            k.nama_kursus
        ')
        ->join('tugas t', 't.id_tugas = pt.id_tugas', 'left')
        ->join('siswa s', 's.id_siswa = pt.id_siswa', 'left')
        ->join('kursus k', 'k.id_kursus = t.id_kursus', 'left')
        ->orderBy('pt.id_kumpul', 'DESC')
        ->get()
        ->getResultArray();
}

    // Cek apakah siswa sudah mengumpulkan tugas tertentu
    public function sudahKumpul($id_siswa, $id_tugas)
    {
        return $this->where('id_siswa', $id_siswa)
            ->where('id_tugas', $id_tugas)
            ->first(); // ✅ Gunakan first() bukan get()->getRowArray()
    }

    // ✅ HAPUS METHOD INI - TIDAK PERLU
    // public function add($data) { return $this->insert($data); }
    // public function edit($id_kumpul, $data) { return $this->update($id_kumpul, $data); }
    // public function deleted_data($id_kumpul) { return $this->delete($id_kumpul); }

          public function detailKumpul($id_kumpul)
    {
        return $this->db->table('pengumpulan_tugas')
            ->where('id_kumpul', $id_kumpul)
            ->get()->getRowArray();
    }

    public function getSubmissions($id_tugas)
    {
        return $this->db->table('pengumpulan_tugas pt')
            ->select('pt.*, s.*')
            ->join('siswa s', 'pt.id_siswa = s.id_siswa', 'left')
            ->where('pt.id_tugas', $id_tugas)
            ->orderBy('pt.tanggal_kirim', 'DESC')
            ->get()
            ->getResultArray();
    }

    // Soft delete method untuk pengumpulan tugas
    public function deleted_data($data)
    {
        // Use soft delete instead of hard delete
        return $this->delete($data['id_kumpul']);
    }

    // Restore soft deleted pengumpulan tugas
    public function restore($id_kumpul)
    {
        return $this->update($id_kumpul, ['deleted_at' => null]);
    }

    // Get deleted pengumpulan tugas (for restore functionality)
    public function getDeletedKumpul()
    {
        return $this->onlyDeleted()->findAll();
    }

    // Force permanent delete (if needed)
    public function forceDelete($id_kumpul)
    {
        return $this->db->table('pengumpulan_tugas')
            ->where('id_kumpul', $id_kumpul)
            ->delete();
    }

}