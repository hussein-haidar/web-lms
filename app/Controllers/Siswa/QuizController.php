<?php

namespace App\Controllers\Siswa;

use App\Controllers\BaseController;
use App\Models\M_quiz;
use App\Models\M_quiz_hasil;
use App\Models\M_pendaftaran;

class QuizController extends BaseController
{
    protected $M_quiz;
    protected $M_quiz_hasil;
    protected $M_pendaftaran;

    public function __construct()
    {
        $this->M_quiz = new M_quiz();
        $this->M_quiz_hasil = new M_quiz_hasil();
        $this->M_pendaftaran = new M_pendaftaran();
    }

    /**
     * AJAX: Simpan/update timer quiz siswa
     * POST /api/siswa/quiz/timer/{id_quiz}
     * Body: { id_pendaftaran, remaining_seconds }
     */
    public function ajax_timer($id_quiz)
    {
        $id_siswa = session()->get('id_siswa');
        if (!$id_siswa) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Session expired. Silakan login kembali.',
                'redirect' => base_url('auth_login/login_siswa'),
            ]);
        }

        $quiz = $this->M_quiz->find($id_quiz);
        if (!$quiz) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Quiz tidak ditemukan.',
            ]);
        }

        $id_pendaftaran = $this->request->getPost('id_pendaftaran');
        $remaining_seconds = $this->request->getPost('remaining_seconds');

        if (!$id_pendaftaran || $remaining_seconds === null) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Parameter tidak lengkap.',
            ]);
        }

        // Validasi kepemilikan
        $pendaftaran = $this->M_pendaftaran->find($id_pendaftaran);
        if (!$pendaftaran || $pendaftaran['id_siswa'] != $id_siswa) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Akses ditolak.',
            ]);
        }

        // Simpan timer ke session agar persist across page refresh
        $timerKey = 'quiz_timer_' . $id_quiz . '_' . $id_pendaftaran;
        session()->set($timerKey, [
            'remaining_seconds' => (int) $remaining_seconds,
            'saved_at'          => date('Y-m-d H:i:s'),
        ]);

        // Jika waktu habis (0 detik), submit otomatis
        if ((int) $remaining_seconds <= 0) {
            return $this->response->setJSON([
                'status'    => 'timeout',
                'message'   => 'Waktu quiz habis. Quiz akan di-submit otomatis.',
                'auto_submit' => true,
            ]);
        }

        return $this->response->setJSON([
            'status'           => 'success',
            'message'          => 'Timer tersimpan.',
            'remaining_seconds' => (int) $remaining_seconds,
        ]);
    }

    /**
     * AJAX: Ambil sisa waktu quiz
     * GET /api/siswa/quiz/timer/{id_quiz}?id_pendaftaran=X
     */
    public function ajax_get_timer($id_quiz)
    {
        $id_siswa = session()->get('id_siswa');
        if (!$id_siswa) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Session expired.',
            ]);
        }

        $id_pendaftaran = $this->request->getGet('id_pendaftaran');
        if (!$id_pendaftaran) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Parameter tidak lengkap.',
            ]);
        }

        $timerKey = 'quiz_timer_' . $id_quiz . '_' . $id_pendaftaran;
        $timerData = session()->get($timerKey);

        if (!$timerData) {
            // Belum ada timer, inisialisasi dari durasi quiz
            $quiz = $this->M_quiz->find($id_quiz);
            $remaining = $quiz ? ($quiz['durasi_menit'] ?? 30) * 60 : 1800;

            return $this->response->setJSON([
                'status'           => 'fresh',
                'remaining_seconds' => $remaining,
                'durasi_menit'     => $quiz['durasi_menit'] ?? 30,
            ]);
        }

        // Hitung sisa waktu aktual berdasarkan kapan terakhir disimpan
        $savedAt = strtotime($timerData['saved_at']);
        $now = time();
        $elapsed = $now - $savedAt;
        $remaining = max(0, $timerData['remaining_seconds'] - $elapsed);

        return $this->response->setJSON([
            'status'           => 'success',
            'remaining_seconds' => $remaining,
            'saved_at'         => $timerData['saved_at'],
        ]);
    }

    /**
     * AJAX: Reset timer quiz (saat mulai ulang)
     * POST /api/siswa/quiz/timer/reset/{id_quiz}
     */
    public function ajax_reset_timer($id_quiz)
    {
        $id_siswa = session()->get('id_siswa');
        if (!$id_siswa) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Session expired.',
            ]);
        }

        $id_pendaftaran = $this->request->getPost('id_pendaftaran');
        if (!$id_pendaftaran) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Parameter tidak lengkap.',
            ]);
        }

        $timerKey = 'quiz_timer_' . $id_quiz . '_' . $id_pendaftaran;
        session()->remove($timerKey);

        $quiz = $this->M_quiz->find($id_quiz);
        $remaining = $quiz ? ($quiz['durasi_menit'] ?? 30) * 60 : 1800;

        return $this->response->setJSON([
            'status'           => 'success',
            'message'          => 'Timer direset.',
            'remaining_seconds' => $remaining,
        ]);
    }
}