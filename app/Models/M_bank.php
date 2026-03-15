<?php

namespace App\Models;

use CodeIgniter\Model;

class M_bank extends Model
{
    protected $table = 'bank';
    protected $primaryKey = 'id_bank';
    protected $allowedFields = [
        'sesi_user',
        'nama_bank',
        'no_rek',
        'a_n',
        'deleted_at'
    ];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    public function get_bank()
    {
        return $this->findAll();
    }

    public function get_bank_by_id($id_bank)
    {
        return $this->find($id_bank);
    }

    public function add($data)
    {
        return $this->insert($data);
    }

    public function edit($data)
    {
        return $this->update($data['id_bank'], $data);
    }

    public function deleted_data($id_bank)
    {
        return $this->delete($id_bank);
    }

    public function get_bank_deleted()
    {
        return $this->onlyDeleted()->findAll();
    }

    public function restore_bank($id_bank)
    {
        return $this->db->table('bank')
            ->where('id_bank', $id_bank)
            ->set(['deleted_at' => null])
            ->update();
    }

    public function force_delete_bank($id_bank)
    {
        return $this->db->table('bank')
            ->where('id_bank', $id_bank)
            ->delete();
    }
}
