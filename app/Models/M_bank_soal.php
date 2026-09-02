<?php

namespace App\Models;

use CodeIgniter\Model;

class M_bank_soal extends Model
{
    protected $table = 'bank_soal';
    protected $primaryKey = 'id_soal';
    protected $allowedFields = [
        'id_kursus',
        'id_modul',
        'kategori',
        'tipe_soal',
        'pertanyaan',
        'pilihan',
        'jawaban_benar',
        'pilihan_pair',
        'bobot',
        'level',
        'penjelasan',
        'status',
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $returnType = 'array';

    public function getSoalByKursus($id_kursus, $tipeSoal = null, $kategori = null)
    {
        $builder = $this->where('id_kursus', $id_kursus)->where('status', 'aktif');

        if ($tipeSoal) {
            $builder->where('tipe_soal', $tipeSoal);
        }
        if ($kategori) {
            $builder->where('kategori', $kategori);
        }

        return $builder->orderBy('created_at', 'DESC')->findAll();
    }

    public function getSoalByIds(array $ids)
    {
        return $this->whereIn('id_soal', $ids)->findAll();
    }

    public function countSoalByKursus($id_kursus)
    {
        return $this->where('id_kursus', $id_kursus)->where('status', 'aktif')->countAllResults();
    }

    public function getSoalStats($id_kursus)
    {
        return $this->db->table('bank_soal')
            ->select('tipe_soal, level, COUNT(*) as jumlah')
            ->where('id_kursus', $id_kursus)
            ->where('status', 'aktif')
            ->groupBy('tipe_soal, level')
            ->get()
            ->getResultArray();
    }

    public function importSoal($id_kursus, array $soalArray)
    {
        $insertData = [];
        foreach ($soalArray as $soal) {
            $insertData[] = [
                'id_kursus'     => $id_kursus,
                'id_modul'      => $soal['id_modul'] ?? null,
                'kategori'      => $soal['kategori'] ?? null,
                'tipe_soal'     => $soal['tipe_soal'] ?? 'pilihan_ganda',
                'pertanyaan'    => $soal['pertanyaan'],
                'pilihan'       => isset($soal['pilihan']) ? json_encode($soal['pilihan']) : null,
                'jawaban_benar' => $soal['jawaban_benar'],
                'pilihan_pair'  => isset($soal['pilihan_pair']) ? json_encode($soal['pilihan_pair']) : null,
                'bobot'         => $soal['bobot'] ?? 1,
                'level'         => $soal['level'] ?? 'sedang',
                'penjelasan'    => $soal['penjelasan'] ?? null,
                'status'        => 'aktif',
                'created_at'    => date('Y-m-d H:i:s'),
            ];
        }

        if (!empty($insertData)) {
            return $this->db->table('bank_soal')->insertBatch($insertData);
        }
        return false;
    }
}
