<?php namespace App\Models;

use CodeIgniter\Model;

class M_quiz extends Model
{
    protected $table = 'quiz';
    protected $primaryKey = 'id_quiz';
    protected $allowedFields = [
        'id_kursus',
        'id_modul',
        'judul_quiz',
        'slug_quiz',
        'deskripsi',
        'durasi_menit',
        'passing_grade',
        'max_attempt',
        'soal_json',        // JSON: array of questions
        'status',           // draft/aktif/nonaktif
        'tanggal_mulai',
        'tanggal_selesai',
    ];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $returnType = 'array';

    // ✅ Get quiz aktif untuk kursus tertentu
    public function getQuizAktif($id_kursus, $id_modul = 0)
    {
        return $this->db->table($this->table)
            ->where('id_kursus', $id_kursus)
            ->where('id_modul', $id_modul)
            ->where('status', 'aktif')
            ->where('tanggal_mulai <=', date('Y-m-d H:i:s'))
            ->groupBy('id_modul')
            ->orderBy('id_modul', 'ASC')
            ->get()
            ->getResultArray();
    }

    // ✅ Get quiz dengan decode soal JSON
    public function getQuizWithSoal($id_quiz)
    {
        $quiz = $this->find($id_quiz);
        if ($quiz) {
            $quiz['soal'] = json_decode($quiz['soal_json'], true);
            unset($quiz['soal_json']);
        }
        return $quiz;
    }

    // ✅ Cek apakah siswa sudah pernah kerjakan quiz
    public function getSudahKerjakan($id_quiz, $id_pendaftaran)
    {
        return $this->db->table('quiz_hasil')
            ->where('id_quiz', $id_quiz)
            ->where('id_pendaftaran', $id_pendaftaran)
            ->countAllResults();
    }

    // ✅ Get attempt count siswa untuk quiz
    public function getAttemptCount($id_quiz, $id_pendaftaran)
    {
        return $this->db->table('quiz_hasil')
            ->where('id_quiz', $id_quiz)
            ->where('id_pendaftaran', $id_pendaftaran)
            ->countAllResults();
    }

    // ✅ Validasi soal JSON sebelum simpan
    public function validateSoalJSON($json)
    {
        $data = json_decode($json, true);
        if (json_last_error() !== JSON_ERROR_NONE || !is_array($data) || empty($data)) {
            return false;
        }
        foreach ($data as $soal) {
            if (!isset($soal['pertanyaan']) || !isset($soal['jawaban_benar'])) {
                return false;
            }
        }
        return true;
    }

    // ✅ Hitung nilai otomatis dari jawaban siswa
    public function hitungNilai($soal_json, $jawaban_siswa)
    {
        $soal = json_decode($soal_json, true);
        $total_benar = 0;
        $total_soal = count($soal);

        foreach ($soal as $index => $s) {
            // Cari jawaban siswa untuk soal ini berdasarkan index
            $j = array_filter($jawaban_siswa, fn($x) => $x['soal_id'] == $index);
            $j = reset($j);
            
            if ($j && $j['jawaban'] == $s['jawaban_benar']) {
                $total_benar++;
            }
        }

        // Perbaikan: Hitung persentase, bukan jumlah bobot
        $total_nilai = $total_soal > 0 ? round(($total_benar / $total_soal) * 100, 2) : 0;

        return [
            'total_nilai' => $total_nilai,
            'total_benar' => $total_benar,
            'total_salah' => $total_soal - $total_benar,
            'total_soal' => $total_soal  // Tambahkan total soal
        ];
    }

    // ✅ CRUD Operations untuk Quiz Management
    public function getQuizByKursus($id_kursus)
    {
        return $this->where('id_kursus', $id_kursus)
            ->orderBy('created_at', 'DESC')
            ->findAll();
    }

    public function getQuizWithKursus($id_quiz)
    {
        return $this->db->table('quiz q')
            ->select('q.*, k.nama_kursus, m.nama_modul')
            ->join('kursus k', 'k.id_kursus = q.id_kursus', 'left')
            ->join('modul m', 'm.id_modul = q.id_modul', 'left')
            ->where('q.id_quiz', $id_quiz)
            ->get()
            ->getRowArray();
    }

    public function createQuiz($data)
    {
        // Generate slug if not provided
        if (empty($data['slug_quiz'])) {
            $data['slug_quiz'] = url_title($data['judul_quiz'], '-', true) . '-' . time();
        }
        
        return $this->insert($data);
    }

    public function updateQuiz($id_quiz, $data)
    {
        // Update slug if judul changed
        if (isset($data['judul_quiz']) && empty($data['slug_quiz'])) {
            $data['slug_quiz'] = url_title($data['judul_quiz'], '-', true) . '-' . time();
        }
        
        return $this->update($id_quiz, $data);
    }

    public function deleteQuiz($id_quiz)
    {
        // Check if quiz has results
        $hasResults = $this->db->table('quiz_hasil')
            ->where('id_quiz', $id_quiz)
            ->countAllResults() > 0;
            
        if ($hasResults) {
            // Soft delete if has results
            return $this->update($id_quiz, ['status' => 'nonaktif']);
        } else {
            // Hard delete if no results
            return $this->delete($id_quiz);
        }
    }

    public function getQuizStats($id_quiz)
    {
        $stats = $this->db->table('quiz_hasil')
            ->select('
                COUNT(*) as total_attempts,
                AVG(total_nilai) as avg_score,
                MAX(total_nilai) as max_score,
                MIN(total_nilai) as min_score,
                SUM(CASE WHEN is_lulus = 1 THEN 1 ELSE 0 END) as passed_count
            ')
            ->where('id_quiz', $id_quiz)
            ->get()
            ->getRowArray();

        return $stats;
    }

    public function getQuizByKursusWithDetails($id_karyawan)
    {
        return $this->db->table('quiz q')
            ->select('
                q.*,
                k.nama_kursus,
                kr.nama_lengkap as nama_pengajar,
                COUNT(qh.id_quiz_hasil) as total_attempts,
                AVG(qh.total_nilai) as avg_score,
                SUM(CASE WHEN qh.is_lulus = 1 THEN 1 ELSE 0 END) as passed_count
            ')
            ->join('kursus k', 'k.id_kursus = q.id_kursus', 'left')
            ->join('karyawan kr', 'kr.id_karyawan = k.id_karyawan', 'left')
            ->join('quiz_hasil qh', 'qh.id_quiz = q.id_quiz', 'left')
            ->where('k.id_karyawan', $id_karyawan)
            ->groupBy('q.id_quiz')
            ->orderBy('q.created_at', 'DESC')
            ->get()
            ->getResultArray();
    }
}