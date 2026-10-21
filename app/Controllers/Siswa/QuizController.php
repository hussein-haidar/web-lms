<?php

namespace App\Controllers\Siswa;

use App\Controllers\BaseController;
use App\Models\M_quiz;
use App\Models\M_quiz_hasil;
use App\Models\M_pendaftaran;
use App\Models\M_notifikasi;

class QuizController extends BaseController
{
    protected $M_quiz;
    protected $M_quiz_hasil;
    protected $M_pendaftaran;
    protected $M_notifikasi;

    public function __construct()
    {
        $this->M_quiz = new M_quiz();
        $this->M_quiz_hasil = new M_quiz_hasil();
        $this->M_pendaftaran = new M_pendaftaran();
        $this->M_notifikasi = new M_notifikasi();
    }

    private function isQuizExpired($id_quiz, $id_pendaftaran)
    {
        $timerKey = 'quiz_timer_' . $id_quiz . '_' . $id_pendaftaran;
        $timerData = session()->get($timerKey);
        if (!$timerData) return false;
        $savedAt = strtotime($timerData['saved_at']);
        $now = time();
        $elapsed = $now - $savedAt;
        $remaining = max(0, $timerData['remaining_seconds'] - $elapsed);
        return $remaining <= 0;
    }

    private function forceAutoSubmitIfExpired($id_quiz, $id_pendaftaran, $id_siswa)
    {
        if (!$this->isQuizExpired($id_quiz, $id_pendaftaran)) return false;

        $quizData = $this->M_quiz->getQuizWithSoal($id_quiz);
        $jawaban_siswa = [];
        if (isset($quizData['soal']) && is_array($quizData['soal'])) {
            foreach ($quizData['soal'] as $soal) {
                $jawaban_siswa[] = ['soal_id' => $soal['id_soal'] ?? '', 'jawaban' => ''];
            }
        }
        $hasil = $this->M_quiz->hitungNilai($quizData['soal_json'] ?? '[]', $jawaban_siswa);
        $is_lulus = ($hasil['total_nilai'] >= ($quizData['passing_grade'] ?? 70)) ? 1 : 0;
        $attempt_count = $this->M_quiz->getAttemptCount($id_quiz, $id_pendaftaran);
        $data_hasil = [
            'id_quiz' => $id_quiz,
            'id_pendaftaran' => $id_pendaftaran,
            'id_siswa' => $id_siswa,
            'attempt_ke' => $attempt_count + 1,
            'jawaban_json' => json_encode($jawaban_siswa),
            'total_nilai' => $hasil['total_nilai'],
            'total_benar' => $hasil['total_benar'],
            'total_salah' => $hasil['total_salah'],
            'is_lulus' => $is_lulus,
            'waktu_mulai' => date('Y-m-d H:i:s'),
            'waktu_selesai' => date('Y-m-d H:i:s'),
        ];
        $this->M_quiz_hasil->insert($data_hasil);
        $timerKey = 'quiz_timer_' . $id_quiz . '_' . $id_pendaftaran;
        session()->remove($timerKey);
        return ['auto_submitted' => true, 'total_nilai' => $hasil['total_nilai'], 'is_lulus' => $is_lulus];
    }

    public function ajax_timer($id_quiz)
    {
        $id_siswa = session()->get('id_siswa');
        if (!$id_siswa) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Session expired.', 'redirect' => base_url('auth_login/login_siswa')]);
        }
        $quiz = $this->M_quiz->find($id_quiz);
        if (!$quiz) return $this->response->setJSON(['status' => 'error', 'message' => 'Quiz tidak ditemukan.']);

        $id_pendaftaran = $this->request->getPost('id_pendaftaran');
        $remaining_seconds = $this->request->getPost('remaining_seconds');
        if (!$id_pendaftaran || $remaining_seconds === null) return $this->response->setJSON(['status' => 'error', 'message' => 'Parameter tidak lengkap.']);

        $pendaftaran = $this->M_pendaftaran->find($id_pendaftaran);
        if (!$pendaftaran || $pendaftaran['id_siswa'] != $id_siswa) return $this->response->setJSON(['status' => 'error', 'message' => 'Akses ditolak.']);

        $timerKey = 'quiz_timer_' . $id_quiz . '_' . $id_pendaftaran;
        session()->set($timerKey, ['remaining_seconds' => (int) $remaining_seconds, 'saved_at' => date('Y-m-d H:i:s')]);

        if ((int) $remaining_seconds <= 0) {
            $autoResult = $this->forceAutoSubmitIfExpired($id_quiz, $id_pendaftaran, $id_siswa);
            if ($autoResult) {
                $this->M_notifikasi->addNotification($id_siswa, 'siswa', 'Quiz Selesai!', 'Quiz "' . $quiz['judul_quiz'] . '" di-submit otomatis karena waktu habis.', $autoResult['is_lulus'] ? 'success' : 'warning');
                return $this->response->setJSON(['status' => 'timeout', 'message' => 'Waktu quiz habis. Quiz di-submit otomatis.', 'auto_submit' => true, 'total_nilai' => $autoResult['total_nilai'], 'is_lulus' => $autoResult['is_lulus']]);
            }
            return $this->response->setJSON(['status' => 'timeout', 'message' => 'Waktu habis.']);
        }
        return $this->response->setJSON(['status' => 'success', 'message' => 'Timer tersimpan.', 'remaining_seconds' => (int) $remaining_seconds]);
    }

    public function ajax_get_timer($id_quiz)
    {
        $id_siswa = session()->get('id_siswa');
        if (!$id_siswa) return $this->response->setJSON(['status' => 'error', 'message' => 'Session expired.']);
        $id_pendaftaran = $this->request->getGet('id_pendaftaran');
        if (!$id_pendaftaran) return $this->response->setJSON(['status' => 'error', 'message' => 'Parameter tidak lengkap.']);

        $timerKey = 'quiz_timer_' . $id_quiz . '_' . $id_pendaftaran;
        $timerData = session()->get($timerKey);
        if (!$timerData) {
            $quiz = $this->M_quiz->find($id_quiz);
            return $this->response->setJSON(['status' => 'fresh', 'remaining_seconds' => $quiz ? ($quiz['durasi_menit'] ?? 30) * 60 : 1800, 'durasi_menit' => $quiz['durasi_menit'] ?? 30]);
        }
        $savedAt = strtotime($timerData['saved_at']);
        $now = time();
        $elapsed = $now - $savedAt;
        $remaining = max(0, $timerData['remaining_seconds'] - $elapsed);
        return $this->response->setJSON(['status' => 'success', 'remaining_seconds' => $remaining, 'saved_at' => $timerData['saved_at']]);
    }

    public function ajax_reset_timer($id_quiz)
    {
        $id_siswa = session()->get('id_siswa');
        if (!$id_siswa) return $this->response->setJSON(['status' => 'error', 'message' => 'Session expired.']);
        $id_pendaftaran = $this->request->getPost('id_pendaftaran');
        if (!$id_pendaftaran) return $this->response->setJSON(['status' => 'error', 'message' => 'Parameter tidak lengkap.']);
        $timerKey = 'quiz_timer_' . $id_quiz . '_' . $id_pendaftaran;
        session()->remove($timerKey);
        $quiz = $this->M_quiz->find($id_quiz);
        $remaining = $quiz ? ($quiz['durasi_menit'] ?? 30) * 60 : 1800;
        return $this->response->setJSON(['status' => 'success', 'message' => 'Timer direset.', 'remaining_seconds' => $remaining]);
    }

    public function check_expiry($id_quiz)
    {
        $id_siswa = session()->get('id_siswa');
        if (!$id_siswa) return $this->response->setJSON(['status' => 'error', 'message' => 'Session expired']);
        $id_pendaftaran = $this->request->getGet('id_pendaftaran');
        if (!$id_pendaftaran) return $this->response->setJSON(['status' => 'error', 'message' => 'Parameter tidak lengkap']);

        $expired = $this->isQuizExpired($id_quiz, $id_pendaftaran);
        $timerKey = 'quiz_timer_' . $id_quiz . '_' . $id_pendaftaran;
        $timerData = session()->get($timerKey);
        $remaining = 0;
        if ($timerData && !$expired) {
            $savedAt = strtotime($timerData['saved_at']);
            $remaining = max(0, $timerData['remaining_seconds'] - (time() - $savedAt));
        } elseif (!$timerData) {
            $quiz = $this->M_quiz->find($id_quiz);
            $remaining = $quiz ? ($quiz['durasi_menit'] ?? 30) * 60 : 1800;
        }
        return $this->response->setJSON(['expired' => $expired, 'remaining_seconds' => (int) $remaining]);
    }
}
