<?php

namespace App\Models;

use CodeIgniter\Model;

class M_web extends Model
{
    protected $table = 'setting_web'; // Nama tabel
    protected $primaryKey = 'id_setting'; // Primary key
    protected $allowedFields = ['id_pemilik','nama_website','logo', 'banner_utama', 'url_yt', 'alamat', 'no_telepon', 'email', 'jam_kerja', 'sejarah', 'meta_description', 'meta_keywords', 'updated_at'];

    public function get_web()
    {
        $id_pemilik = session()->get('id_pemilik'); // pastikan session ini ada
        
        // Check if id_pemilik exists, if not, get all data
        if ($id_pemilik) {
            return $this->db->table('setting_web')
                ->select('setting_web.*')
                ->where('setting_web.id_pemilik', $id_pemilik)
                ->orderBy('setting_web.id_setting', 'DESC')
                ->get()
                ->getResultArray();
        } else {
            // If no id_pemilik, get all data (for admin superadmin)
            return $this->db->table('setting_web')
                ->select('setting_web.*')
                ->orderBy('setting_web.id_setting', 'DESC')
                ->get()
                ->getResultArray();
        }
    }
    
    public function detailWeb($id_setting)
    {
        return $this->db->table('setting_web')
            ->where('id_setting', $id_setting)
            ->get()->getRowArray();
    }

    public function add($data)
    {
        $this->db->table('setting_web')
            ->insert($data);
    }

    public function edit($data)
    {
        $this->db->table('setting_web')
            ->where('id_setting', $data['id_setting'])
            ->update($data);
    }

    public function deleted_data($data)
    {
        return $this->db->table('setting_web')
            ->where('id_setting', $data['id_setting'])
            ->delete($data);
    }
}
