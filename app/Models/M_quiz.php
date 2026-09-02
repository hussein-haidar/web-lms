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
        $builder = $this->db->table($this->table)
            ->where('id_kursus', $id_kursus)
            ->where('status', 'aktif')
            ->where('tanggal_mulai <=', date('Y-m-d H:i:s'));
            
        // Only filter by id_modul if it's provided and not 0
        if ($id_modul > 0) {
            $builder->where('id_modul', $id_modul);
        }
        
        return $builder->orderBy('created_at', 'ASC')
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

    // ✅ Hitung nilai otomatis dari jawaban siswa (supports multiple question types)
    public function hitungNilai($soal_json, $jawaban_siswa)
    {
        $soal = json_decode($soal_json, true);
        $total_bobot = 0;
        $total_skor = 0;

        foreach ($soal as $index => $s) {
            $soal_id = $s['id_soal'] ?? ($index + 1);
            $bobot = $s['bobot'] ?? 1;
            $tipe = $s['tipe_soal'] ?? 'pilihan_ganda';

            // Cari jawaban siswa
            $j = array_filter($jawaban_siswa, fn($x) => $x['soal_id'] == $soal_id);
            $j = reset($j);

            $jawaban_siswa_val = $j['jawaban'] ?? '';
            $jawaban_benar = $s['jawaban_benar'] ?? '';

            $is_benar = false;

            switch ($tipe) {
                case 'pilihan_ganda':
                case 'true_false':
                    $siswa_huruf = '';
                    if (is_numeric($jawaban_siswa_val)) {
                        $idx = (int)$jawaban_siswa_val;
                        $siswa_huruf = chr(65 + $idx);
                    } else {
                        $siswa_huruf = strtoupper(trim($jawaban_siswa_val));
                    }
                    $is_benar = ($siswa_huruf === strtoupper(trim($jawaban_benar)));
                    break;

                case 'fill_blank':
                    $is_benar = (strtolower(trim($jawaban_siswa_val)) === strtolower(trim($jawaban_benar)));
                    break;

                case 'essay':
                    // Essay dinilai manual, berikan 0 dulu (nanti dinilai manual)
                    $is_benar = false;
                    break;

                case 'matching':
                    $siswa_pairs = is_array($jawaban_siswa_val) ? $jawaban_siswa_val : json_decode($jawaban_siswa_val, true);
                    $benar_pairs = json_decode($jawaban_benar, true);
                    if ($siswa_pairs && $benar_pairs) {
                        $correct_count = 0;
                        foreach ($benar_pairs as $key => $val) {
                            if (isset($siswa_pairs[$key]) && $siswa_pairs[$key] === $val) {
                                $correct_count++;
                            }
                        }
                        $match_ratio = count($benar_pairs) > 0 ? $correct_count / count($benar_pairs) : 0;
                        $total_skor += $bobot * $match_ratio;
                    }
                    $total_bobot += $bobot;
                    continue 2;

                default:
                    $is_benar = ($jawaban_siswa_val === $jawaban_benar);
            }

            if ($is_benar) {
                $total_skor += $bobot;
            }
            $total_bobot += $bobot;
        }

        $total_nilai = $total_bobot > 0 ? round(($total_skor / $total_bobot) * 100, 2) : 0;
        $total_soal = count($soal);
        $total_benar = (int) round($total_skor);

        return [
            'total_nilai' => $total_nilai,
            'total_benar' => $total_benar,
            'total_salah' => $total_soal - $total_benar,
            'total_soal' => $total_soal
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

    // ✅ Create quiz from bank soal IDs
    public function createQuizFromBank(array $data, array $bankSoalIds)
    {
        $bankSoalModel = new \App\Models\M_bank_soal();
        $soalFromBank = $bankSoalModel->getSoalByIds($bankSoalIds);

        $soalArray = [];
        foreach ($soalFromBank as $idx => $soal) {
            $soalArray[] = [
                'id_soal'        => $soal['id_soal'],
                'tipe_soal'      => $soal['tipe_soal'],
                'pertanyaan'     => $soal['pertanyaan'],
                'pilihan'        => json_decode($soal['pilihan'], true),
                'jawaban_benar'  => $soal['jawaban_benar'],
                'pilihan_pair'   => json_decode($soal['pilihan_pair'], true),
                'bobot'          => $soal['bobot'],
                'penjelasan'     => $soal['penjelasan'],
            ];
        }

        $data['soal_json'] = json_encode($soalArray);
        $data['soal_source'] = 'bank';

        return $this->insert($data);
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