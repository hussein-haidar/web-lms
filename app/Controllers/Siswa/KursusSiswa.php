<?php

namespace App\Controllers\Siswa;

use App\Controllers\BaseController;
use App\Models\M_kursus;
use App\Models\M_pendaftaran;
use App\Models\M_modul;
use App\Models\M_materi;
use App\Models\M_quiz;

class KursusSiswa extends BaseController
{
    protected $kursusModel;
    protected $pendaftaranModel;
    protected $modulModel;
    protected $materiModel;
    protected $quizModel;
    protected $db;

    public function __construct()
    {
        $this->kursusModel = new M_kursus();
        $this->pendaftaranModel = new M_pendaftaran();
        $this->modulModel = new M_modul();
        $this->materiModel = new M_materi();
        $this->quizModel = new M_quiz();
        $this->db = \Config\Database::connect();
    }

    public function index()
    {
        $id_siswa = session()->get('id_siswa');
        if (!$id_siswa) {
            session()->setFlashdata('error', 'Anda harus login terlebih dahulu!');
            return redirect()->to(base_url('auth_login/login_siswa'));
        }
        $this->pendaftaranModel->cleanupExpired();
        $pendaftaran_all = $this->pendaftaranModel->getBySiswa($id_siswa);
        $data = [
            'title' => 'Kursus Saya',
            'title2' => 'Kursus Saya',
            'kursus' => $pendaftaran_all
        ];
        return view('backend/siswa/kursus/v_kursus', $data);
    }

    public function tersedia()
    {
        $id_siswa = session()->get('id_siswa');
        if (!$id_siswa) {
            session()->setFlashdata('error', 'Anda harus login terlebih dahulu!');
            return redirect()->to(base_url('auth_login/login_siswa'));
        }
        $kursus = $this->kursusModel->getKursusTersedia();
        $data = [
            'title' => 'Kursus Tersedia',
            'title2' => 'Kursus Tersedia',
            'kursus' => $kursus
        ];
        return view('backend/siswa/kursus/v_kursus_tersedia', $data);
    }

    public function detail($id_kursus)
    {
        $id_siswa = session()->get('id_siswa');
        $kursus = $this->kursusModel->getKursusWithDetailById($id_kursus);
        if (!$kursus) {
            session()->setFlashdata('pesan_warning', 'Kursus tidak ditemukan!');
            return redirect()->to(base_url('home_siswa/kursus_saya'));
        }
        $pendaftaran = $this->pendaftaranModel->where('id_siswa', $id_siswa)
            ->where('id_kursus', $id_kursus)
            ->whereIn('status', ['aktif', 'selesai'])
            ->first();
        $quizzes = $this->quizModel->getQuizAktif($kursus['id_kursus']);
        if ($pendaftaran) {
            foreach ($quizzes as &$quiz) {
                $quiz_result = $this->db->table('quiz_hasil')
                    ->where('id_quiz', $quiz['id_quiz'])
                    ->where('id_siswa', $pendaftaran['id_siswa'])
                    ->orderBy('created_at', 'DESC')
                    ->get()
                    ->getRowArray();
                $quiz['is_lulus'] = $quiz_result && isset($quiz_result['status']) ? ($quiz_result['status'] == 'lulus' ? 1 : 0) : 0;
                $quiz['total_nilai'] = $quiz_result ? $quiz_result['total_nilai'] : 0;
            }
        }
        $data = [
            'title' => 'Detail Kursus',
            'title2' => 'LPK INASABA',
            'kursus' => $kursus,
            'pendaftaran' => $pendaftaran,
            'quizzes' => $quizzes
        ];
        return view('backend/siswa/kursus/v_dtl_ks', $data);
    }

    public function akses($id_pendaftaran)
    {
        $id_siswa = session()->get('id_siswa');
        if (!$id_siswa) {
            session()->setFlashdata('error', 'Anda harus login terlebih dahulu!');
            return redirect()->to(base_url('auth_login/login_siswa'));
        }
        $pendaftaran = $this->pendaftaranModel->detailDaftar($id_pendaftaran);
        if (!$pendaftaran || $pendaftaran['id_siswa'] != $id_siswa) {
            session()->setFlashdata('error', 'Data tidak ditemukan!');
            return redirect()->to(base_url('home_siswa/kursus_saya'));
        }
        $data = [
            'title' => 'Akses Kursus',
            'title2' => 'Akses Kursus',
            'pendaftaran' => $pendaftaran
        ];
        return view('backend/siswa/kursus/v_akses_kursus', $data);
    }

    public function akses_modul($id_pendaftaran, $id_modul)
    {
        $id_siswa = session()->get('id_siswa');
        if (!$id_siswa) {
            session()->setFlashdata('error', 'Anda harus login terlebih dahulu!');
            return redirect()->to(base_url('auth_login/login_siswa'));
        }
        $pendaftaran = $this->pendaftaranModel->detailDaftar($id_pendaftaran);
        if (!$pendaftaran || $pendaftaran['id_siswa'] != $id_siswa) {
            session()->setFlashdata('error', 'Data tidak ditemukan!');
            return redirect()->to(base_url('home_siswa/kursus_saya'));
        }
        $modul = $this->modulModel->find($id_modul);
        $data = [
            'title' => 'Akses Modul',
            'title2' => 'Akses Modul',
            'pendaftaran' => $pendaftaran,
            'modul' => $modul
        ];
        return view('backend/siswa/kursus/v_akses_modul', $data);
    }

    public function view_materi($id_materi)
    {
        $id_siswa = session()->get('id_siswa');
        if (!$id_siswa) {
            session()->setFlashdata('error', 'Anda harus login terlebih dahulu!');
            return redirect()->to(base_url('auth_login/login_siswa'));
        }
        $materi = $this->materiModel->getMateriWithModul($id_materi);
        $data = [
            'title' => 'View Materi',
            'title2' => 'View Materi',
            'materi' => $materi
        ];
        return view('backend/siswa/materi/v_view_materi', $data);
    }
}
