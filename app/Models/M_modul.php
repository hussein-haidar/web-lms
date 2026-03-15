<?php

namespace App\Models;

use CodeIgniter\Model;

class M_modul extends Model
{
    protected $table            = 'modul';
    protected $primaryKey       = 'id_modul';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id_kursus',
        'nama_modul',
        'deskripsi',
        'urutan',
        'tanggal_dibuat'
    ];

    // Dates
    protected $useTimestamps = false;

    /**
     * Get moduls by Kursus ID
     */
    public function getByKursus($id_kursus)
    {
        return $this->where('id_kursus', $id_kursus)
            ->orderBy('urutan', 'ASC')
            ->findAll();
    }

    /**
     * Get moduls by Kursus ID (alias for consistency)
     */
    public function getModulByKursus($id_kursus)
    {
        return $this->getByKursus($id_kursus);
    }

    /**
     * Get unique moduls by Kursus ID (no duplicate names)
     */
    public function getUniqueModulByKursus($id_kursus)
    {
        $moduls = $this->where('id_kursus', $id_kursus)
            ->orderBy('urutan', 'ASC')
            ->findAll();
        
        // Remove duplicates based on nama_modul
        $unique_moduls = [];
        $seen_names = [];
        foreach ($moduls as $modul) {
            $normalized_name = strtolower(trim($modul['nama_modul']));
            if (!in_array($normalized_name, $seen_names)) {
                $unique_moduls[] = $modul;
                $seen_names[] = $normalized_name;
            }
        }
        
        return $unique_moduls;
    }
}
