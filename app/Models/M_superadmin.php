<?php

namespace App\Models;

use CodeIgniter\Model;

class M_superadmin extends Model
{
    protected $table = 'superadmin'; // Adjust the table name accordingly
    protected $primaryKey = 'id_superadmin'; // Adjust the primary key if necessary
    protected $allowedFields = [
        'email',
        'username',
        'kata_sandi',
        'nama_lengkap',
        'id_pemilik',
        'no_telepon',
        'foto_profil',
        'level',
        'tanggal_daftar',
        'last_login'
    ];

    public function get_profil($id_superadmin)
    {
        return $this->db->table('superadmin')
            ->where('id_superadmin', $id_superadmin)
            ->get()->getRowArray();
    }

    public function get_user_by_id($id_pemilik)
    {
        return $this->db->table('superadmin')
            ->select('id_pemilik')
            ->where('id_pemilik', $id_pemilik)
            ->get()
            ->getRowArray();
    }

       public function findByEmailOrUsername($input)
    {
        $builder = $this->db
            ->table($this->table)
            ->groupStart()
                ->where('username', $input)
                ->orWhere('email', $input)
            ->groupEnd();

        $query = $builder->get();

        if ($query->getNumRows() > 0) {
            return $query->getRowArray();
        }

        return null;
    }

    public function detailUser($id_superadmin)
    {
        return $this->db->table('superadmin')
            ->where('id_superadmin', $id_superadmin)
            ->get()->getRowArray();
    }

    public function add($data)
    {
        $this->db->table('superadmin')
            ->insert($data);
    }

    public function edit($data)
    {
        return $this->db->table('superadmin')
            ->where('id_superadmin', $data['id_superadmin'])
            ->update($data);
    }

    public function deleted_data($data)
    {
        return $this->db->table('superadmin')
            ->where('id_superadmin', $data['id_superadmin'])
            ->delete($data);
    }

    public function findByUsername($username)
    {
        return $this->where('username', $username)->first();
    }

    public function updateLastLogin($userId)
    {
        return $this->update($userId, ['last_login' => date('Y-m-d H:i:s')]);
    }
}
