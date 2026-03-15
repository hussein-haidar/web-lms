<?php

namespace App\Models;

use CodeIgniter\Model;

class M_karyawan extends Model
{
    protected $table = 'karyawan';
    protected $primaryKey = 'id_karyawan';
    protected $allowedFields = [
        'id_instruktur',
        'email',
        'nip',
        'kata_sandi',
        'nama_lengkap',
        'id_pemilik',
        'no_telepon',
        'foto_profil',
        'level',
        'status',
        'tanggal_daftar',
        'last_login',
        'alamat'
    ];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';
    protected $useSoftDeletes = true;

    // ✅ Get karyawan dengan filter dinamis
    public function get_karyawan($status_filter = null, $level_filter = null)
    {
        $builder = $this->db->table($this->table)
            ->where('deleted_at IS NULL'); // ✅ Hanya tampilkan data yang tidak dihapus
        
        // Filter status
        if (!empty($status_filter) && trim($status_filter) !== '') {
            $builder->where('status', trim($status_filter));
        }
        
        // Filter level
        if (!empty($level_filter) && trim($level_filter) !== '' && $level_filter !== 'all') {
            $builder->where('level', trim($level_filter));
        }
        
        return $builder->orderBy('id_karyawan', 'DESC')->get()->getResultArray();
    }

    // ✅ Get detail karyawan
    public function detailKaryawan($id_karyawan)
    {
        return $this->db->table('karyawan')
            ->where('id_karyawan', $id_karyawan)
            ->get()
            ->getRowArray();
    }

    // ✅ Get pengajar untuk dropdown
    public function get_pengajar()
    {
        return $this->db->table('karyawan')
            ->select('id_karyawan, nama_lengkap')
            ->where('level', 'pengajar')
            ->where('status', 'aktif')
            ->where('deleted_at IS NULL') // ✅ Hanya tampilkan data yang tidak dihapus
            ->orderBy('nama_lengkap', 'ASC')
            ->get()
            ->getResultArray();
    }

    // ✅ Cari berdasarkan NIP atau Email
    public function findByNipOrEmail($input)
    {
        return $this->db->table($this->table)
            ->where('nip', $input)
            ->orWhere('email', $input)
            ->get()
            ->getRowArray();
    }

    // ✅ Update last login
    public function updateLastLogin($id_karyawan)
    {
        return $this->update($id_karyawan, ['last_login' => date('Y-m-d H:i:s')]);
    }

    // ✅ Restore soft deleted karyawan
    public function restore($id_karyawan)
    {
        return $this->update($id_karyawan, ['deleted_at' => null]);
    }

    // ✅ Get deleted karyawan (for restore functionality)
    public function getDeletedKaryawan()
    {
        $db = \Config\Database::connect();
        return $db->table($this->table)
                   ->where('deleted_at IS NOT NULL')
                   ->orderBy('id_karyawan', 'DESC')
                   ->get()
                   ->getResultArray();
    }

    // ✅ Force permanent delete (if needed)
    public function forceDelete($id_karyawan)
    {
        return $this->db->table($this->table)
            ->where('id_karyawan', $id_karyawan)
            ->delete();
    }
}