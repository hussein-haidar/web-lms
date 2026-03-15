<?php

namespace App\Models;

use CodeIgniter\Model;

class M_Saran extends Model
{
    protected $table            = 'saran';
    protected $primaryKey       = 'id_saran';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftdeleteds   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['nama', 'email', 'pesan', 'tanggal'];

    // Dates
    protected $useTimestamps = false; // Karena kita handle manual di controller
    protected $dateFormat    = 'datetime';
    protected $createdField  = '';
    protected $updatedField  = '';
    protected $deleteddField  = '';
    protected $skipValidation     = false;

    public function get_saran()
    {
        return $this->orderBy('id_saran', 'DESC')->findAll();
    }

     public function add($data)
    {
        $this->db->table('saran')
            ->insert($data);
    }
    
       // Hapus tugas
    public function deleted_data($id_saran)
    {
        return $this->delete($id_saran);
    }

}