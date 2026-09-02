<?php

namespace App\Controllers\Siswa;

use App\Controllers\BaseController;
use App\Models\M_quiz;
use App\Models\M_quiz_hasil;
use App\Models\M_pendaftaran;

class QuizSiswa extends BaseController
{
    protected $quizModel;
    protected $quizHasilModel;
    protected $pendaftaranModel;

    public function __construct()
    {
        $this->quizModel = new M_quiz();
        $this->quizHasilModel = new M_quiz_hasil();
        $this->pendaftaranModel = new M_pendaftaran();
    }

    public function index($id_kursus)
    {
        $id_siswa = session()->get('id_siswa');
        if (!$id_siswa) return redirect()->to(base_url('auth_login/login_siswa'));
        $pendaftaran = $this->pendaftaranModel->where('id_siswa', $id_siswa)->where('id_kursus', $id_kursus)->whereIn('status', ['aktif', 'selesai'])->first();
        if (!$pendaftaran) {
            session()->setFlashdata('error', 'Anda belum terdaftar di kursus ini!');
            return redirect()->to(base_url('home_siswa/kursus_saya'));
        }
        $quizzes = $this->quizModel->where('id_kursus', $id_kursus)->where('status', 'aktif')->findAll();
        foreach ($quizzes as &$quiz) {
            $soal_array = json_decode($quiz['soal_json'], true);
            $quiz['jumlah_soal'] = is_array($soal_array) ? count($soal_array) : 0;
            unset($quiz['soal_json']);
        }
        $data = [
            'title' => 'Quiz - ' . $pendaftaran['nama_paket'],
            'pendaftaran' => $pendaftaran,
            'quizzes' => $quizzes,
            'quizModel' => $this->quizModel,
            'quizHasilModel' => $this->quizHasilModel
        ];
        return view('backend/siswa/quiz/v_quiz_list', $data);
    }

    public function kerjakan($id_quiz)
    {
        $id_siswa = session()->get('id_siswa');
        if (!$id_siswa) return redirect()->to(base_url('auth_login/login_siswa'));
        $quiz = $this->quizModel->getQuizWithSoal($id_quiz);
        if (!$quiz) {
            session()->setFlashdata('error', 'Quiz tidak ditemukan!');
            return redirect()->back();
        }
        if (isset($quiz['soal'])) {
            $quiz['jumlah_soal'] = count($quiz['soal']);
        }
        $pendaftaran = $this->pendaftaranModel->where('id_siswa', $id_siswa)->where('id_kursus', $quiz['id_kursus'])->whereIn('status', ['aktif', 'selesai'])->first();
        if (!$pendaftaran) {
            session()->setFlashdata('error', 'Anda belum terdaftar di kursus ini!');
            return redirect()->to(base_url('home_siswa/kursus_saya'));
        }
        $attempt = $this->quizModel->getAttemptCount($id_quiz, $pendaftaran['id_pendaftaran']);
        $bestResult = $this->quizHasilModel->getNilaiTerbaik($id_quiz, $pendaftaran['id_pendaftaran']);
        $hasPassedWithHighScore = $bestResult && $bestResult['total_nilai'] >= 70 && $bestResult['is_lulus'] == 1;
        $hasExceededAttempts = $attempt >= 3;
        if ($hasPassedWithHighScore) {
            session()->setFlashdata('error', 'Anda sudah lulus quiz dengan nilai ' . round($bestResult['total_nilai']) . '% dan tidak dapat mengulang kembali!');
            return redirect()->to(base_url('home_siswa/quiz/' . $quiz['id_kursus']));
        }
        if ($hasExceededAttempts) {
            session()->setFlashdata('error', 'Anda sudah mencapai batas maksimal 3 percobaan!');
            return redirect()->to(base_url('home_siswa/quiz/' . $quiz['id_kursus']));
        }
        if ($attempt >= $quiz['max_attempt']) {
            session()->setFlashdata('error', 'Anda sudah mencapai batas maksimal attempt!');
            return redirect()->to(base_url('home_siswa/quiz/' . $quiz['id_kursus']));
        }
        $data = [
            'title' => 'Preview Quiz - ' . $quiz['judul_quiz'],
            'quiz' => $quiz,
            'pendaftaran' => $pendaftaran,
            'attempt' => $attempt + 1
        ];
        return view('frontend/siswa/quiz/v_preview', $data);
    }

    public function start($id_quiz)
    {
        $id_siswa = session()->get('id_siswa');
        if (!$id_siswa) return redirect()->to(base_url('auth_login/login_siswa'));
        $quiz = $this->quizModel->getQuizWithSoal($id_quiz);
        if (!$quiz) {
            session()->setFlashdata('error', 'Quiz tidak ditemukan!');
            return redirect()->back();
        }
        if (isset($quiz['soal'])) {
            $quiz['jumlah_soal'] = count($quiz['soal']);
        }
        $pendaftaran = $this->pendaftaranModel->where('id_siswa', $id_siswa)->where('id_kursus', $quiz['id_kursus'])->whereIn('status', ['aktif', 'selesai'])->first();
        if (!$pendaftaran) {
            session()->setFlashdata('error', 'Anda belum terdaftar di kursus ini!');
            return redirect()->to(base_url('home_siswa/kursus_saya'));
        }
        $data = [
            'title' => 'Kerjakan Quiz - ' . $quiz['judul_quiz'],
            'quiz' => $quiz,
            'pendaftaran' => $pendaftaran,
            'attempt' => $this->quizModel->getAttemptCount($id_quiz, $pendaftaran['id_pendaftaran']) + 1
        ];
        return view('frontend/siswa/quiz/v_kerjakan', $data);
    }

    public function submit()
    {
        $id_pendaftaran = $this->request->getPost('id_pendaftaran');
        $id_quiz = $this->request->getPost('id_quiz');
        $id_materi = $this->request->getPost('id_materi');
        $id_siswa = session()->get('id_siswa');
        $quiz = $this->quizModel->find($id_quiz);
        $jawaban_input = $this->request->getPost('jawaban');
        $jawaban_siswa = [];
        if (!empty($jawaban_input)) {
            foreach ($jawaban_input as $soal_id => $j) {
                $jawaban_siswa[] = ['soal_id' => $soal_id, 'jawaban' => $j];
            }
        }
        $hasil = $this->quizModel->hitungNilai($quiz['soal_json'], $jawaban_siswa);
        $is_lulus = ($hasil['total_nilai'] >= ($quiz['passing_grade'] ?? 70)) ? 1 : 0;
        $attempt_count = $this->quizModel->getAttemptCount($id_quiz, $id_pendaftaran);
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
            'waktu_selesai' => date('Y-m-d H:i:s')
        ];
        $this->quizHasilModel->insert($data_hasil);
        $siswa_model = new \App\Models\M_siswa();
        $siswa = $siswa_model->find($id_siswa);
        if ($siswa) {
            email_hasil_quiz($siswa, $quiz, $hasil, $is_lulus);
        }
        return redirect()->to(base_url("home_siswa/belajar/$id_pendaftaran/$id_materi"))
            ->with($is_lulus ? 'pesan' : 'pesan_warning', $is_lulus ? 'Selamat! Anda lulus kuis.' : 'Maaf, Anda belum lulus kuis. Silakan coba lagi.');
    }

    public function hasil($id_quiz)
    {
        $id_siswa = session()->get('id_siswa');
        if (!$id_siswa) return redirect()->to(base_url('auth_login/login_siswa'));
        $quiz = $this->quizModel->find($id_quiz);
        if (!$quiz) {
            session()->setFlashdata('error', 'Quiz tidak ditemukan!');
            return redirect()->to(base_url('home_siswa/kursus'));
        }
        $pendaftaran = $this->pendaftaranModel->where('id_siswa', $id_siswa)->where('id_kursus', $quiz['id_kursus'])->whereIn('status', ['aktif', 'selesai'])->first();
        if (!$pendaftaran) {
            session()->setFlashdata('error', 'Anda belum terdaftar di kursus ini!');
            return redirect()->to(base_url('home_siswa/kursus'));
        }
        $results = $this->quizHasilModel->getSemuaAttempt($id_quiz, $pendaftaran['id_pendaftaran']);
        $data = [
            'title' => 'Hasil Quiz - ' . $quiz['judul_quiz'],
            'title2' => 'Hasil Quiz - ' . $quiz['judul_quiz'],
            'quiz' => $quiz,
            'pendaftaran' => $pendaftaran,
            'results' => $results,
            'quizModel' => $this->quizModel,
            'quizHasilModel' => $this->quizHasilModel
        ];
        return view('backend/siswa/quiz/v_hasil', $data);
    }

    public function retry($id_quiz)
    {
        $id_siswa = session()->get('id_siswa');
        if (!$id_siswa) return redirect()->to(base_url('auth_login/login_siswa'));
        return redirect()->to(base_url('home_siswa/kerjakan/' . $id_quiz));
    }
}
