<?php namespace App\Models;

use CodeIgniter\Model;

class M_tugas extends Model
{
    protected $table = 'tugas';
    protected $primaryKey = 'id_tugas';
    protected $allowedFields = [
        'id_kursus', 'id_modul', 'id_materi',
        'judul_tugas', 'deskripsi',
        'tipe_tugas', 'format_file', 'max_file_mb', 'deadline',
        'nilai_maks', 'rubrik',
        'status', 'id_pemilik'
    ];
    protected $useTimestamps = false;
    protected $returnType = 'array';

    // ✅ Get tugas dengan join kursus
    public function get_tugas($id_kursus = null)
    {
        $builder = $this->db->table('tugas t');
        
        $builder->select('t.*, k.nama_kursus, dk.materi_yang_dipelajari')
            ->join('kursus k', 'k.id_kursus = t.id_kursus', 'left')
            ->join('detail_kursus dk', 'dk.id_kursus = k.id_kursus', 'left');
        
        if (!empty($id_kursus)) {
            $builder->where('t.id_kursus', $id_kursus);
        }
        
        return $builder->orderBy('t.deadline', 'ASC')->get()->getResultArray();
    }
    
    // ✅ Detail tugas
    public function detailTugas($id_tugas)
    {
        return $this->db->table('tugas t')
            ->select('t.*, k.*, dk.*')
            ->join('kursus k', 'k.id_kursus = t.id_kursus', 'left')
            ->join('detail_kursus dk', 'dk.id_kursus = k.id_kursus', 'left')
            ->where('t.id_tugas', $id_tugas)
            ->get()
            ->getRowArray();
    }
    
    // ✅ Get tugas aktif by kursus
    public function getTugasAktif($id_kursus)
    {
        return $this->where('id_kursus', $id_kursus)
            ->where('status', 'aktif')
            ->where('deadline >=', date('Y-m-d H:i:s'))
            ->findAll();
    }
    
    // ✅ Get tugas by pengajar
    public function getTugasByPengajar($id_pengajar)
    {
        return $this->db->table('tugas t')
            ->select('t.*, k.nama_kursus')
            ->join('kursus k', 'k.id_kursus = t.id_kursus')
            ->where('k.id_karyawan', (string)$id_pengajar)
            ->where('t.status', 'aktif')
            ->orderBy('t.deadline', 'ASC')
            ->get()
            ->getResultArray();
    }
}