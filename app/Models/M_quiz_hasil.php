<?php namespace App\Models;

use CodeIgniter\Model;

class M_quiz_hasil extends Model
{
    protected $table = 'quiz_hasil';
    protected $primaryKey = 'id_quiz_hasil';
    protected $allowedFields = [
        'id_quiz',
        'id_pendaftaran',
        'id_siswa',
        'attempt_ke',
        'jawaban_json',     // JSON: array of answers
        'total_nilai',
        'total_benar',
        'total_salah',
        'total_soal',       // Total jumlah soal
        'is_lulus',         // 1 = lulus, 0 = belum
        'waktu_mulai',
        'waktu_selesai',
    ];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $returnType = 'array';

    // ✅ Simpan hasil quiz
    public function simpanHasil($data)
    {
        $result = $this->insert($data);
        
        // Otomatis hitung nilai_akhir setelah quiz disimpan
        if ($result && isset($data['id_pendaftaran'])) {
            $pendaftaranModel = new \App\Models\M_pendaftaran();
            $pendaftaranModel->hitungNilaiAkhir($data['id_pendaftaran']);
        }
        
        return $result;
    }

    // ✅ Get hasil quiz terbaik siswa
    public function getNilaiTerbaik($id_quiz, $id_pendaftaran)
    {
        return $this->db->table($this->table)
            ->where('id_quiz', $id_quiz)
            ->where('id_pendaftaran', $id_pendaftaran)
            ->orderBy('total_nilai', 'DESC')
            ->get()
            ->getRowArray();
    }

    // ✅ Get semua attempt siswa untuk quiz
    public function getSemuaAttempt($id_quiz, $id_pendaftaran)
    {
        return $this->db->table($this->table)
            ->where('id_quiz', $id_quiz)
            ->where('id_pendaftaran', $id_pendaftaran)
            ->orderBy('attempt_ke', 'ASC')
            ->get()
            ->getResultArray();
    }

    // ✅ Cek apakah siswa sudah lulus quiz
    public function sudahLulus($id_quiz, $id_pendaftaran)
    {
        return $this->db->table($this->table)
            ->where('id_quiz', $id_quiz)
            ->where('id_pendaftaran', $id_pendaftaran)
            ->where('is_lulus', 1)
            ->countAllResults() > 0;
    }

    // ✅ Get rekap quiz per kursus untuk dashboard siswa
    public function getRekapQuizSiswa($id_siswa, $id_kursus)
    {
        return $this->db->table('quiz_hasil qh')
            ->select('
                qh.*,
                q.judul_quiz,
                q.passing_grade,
                q.durasi_menit,
                CASE 
                    WHEN qh.is_lulus = 1 THEN "Lulus"
                    WHEN qh.total_nilai >= q.passing_grade THEN "Lulus"
                    ELSE "Belum Lulus"
                END as status_lulus
            ')
            ->join('quiz q', 'q.id_quiz = qh.id_quiz')
            ->where('qh.id_siswa', $id_siswa)
            ->where('q.id_kursus', $id_kursus)
            ->groupBy('qh.id_quiz')
            ->orderBy('q.id_modul', 'ASC')
            ->get()
            ->getResultArray();
    }

    // ✅ Get detailed results untuk quiz statistics
    public function getDetailedResults($id_quiz)
    {
        return $this->db->table('quiz_hasil qh')
            ->select('
                qh.*,
                s.nama_lengkap,
                s.email,
                p.nama_paket
            ')
            ->join('siswa s', 's.id_siswa = qh.id_siswa', 'left')
            ->join('pendaftaran p', 'p.id_pendaftaran = qh.id_pendaftaran', 'left')
            ->where('qh.id_quiz', $id_quiz)
            ->orderBy('qh.total_nilai', 'DESC')
            ->get()
            ->getResultArray();
    }
}