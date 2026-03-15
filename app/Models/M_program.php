<?php

namespace App\Models;

use CodeIgniter\Model;

class M_program extends Model
{
    protected $table            = 'program_kursus';
    protected $primaryKey       = 'id_program';
    protected $allowedFields    = [
        'id_kursus',
        'nama_program',
        'deskripsi',
        'id_pemilik'
    ];
    protected $useTimestamps    = false;
    protected $returnType       = 'array';

    public function get_program()
    {
        return $this->orderBy('id_program', 'DESC')->findAll();
    }

    // ✅ Method untuk mendapatkan program dengan filter
    public function getProgramWithFilter($filters = [], $filterConfig = [])
    {
        $builder = $this->db->table($this->table);
        
        // Apply filter untuk nama_program
        if (!empty($filters['nama_program'])) {
            $column = $filterConfig['nama_program']['column'] ?? 'nama_program';
            $builder->where($column, $filters['nama_program']);
        }
        
        return $builder->orderBy('id_program', 'DESC')->get()->getResultArray();
    }
    
    public function detailProgram($id_program)
    {
        return $this->find($id_program);
    }

    // ✅ CUSTOM METHOD UPDATE - TERIMA ID SEBAGAI PARAMETER TERPISAH
    public function updateProgram($id_program, $data)
    {
        return $this->db->table($this->table)
            ->where($this->primaryKey, $id_program) // ✅ WHERE by PRIMARY KEY
            ->update($data);
    }

    // ✅ CUSTOM METHOD DELETE - TERIMA ID SEBAGAI PARAMETER
    public function deleteProgram($id_program)
    {
        return $this->db->table($this->table)
            ->where($this->primaryKey, $id_program) // ✅ WHERE by PRIMARY KEY
            ->delete();
    }
}