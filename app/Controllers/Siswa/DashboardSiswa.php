<?php

namespace App\Controllers\Siswa;

use App\Controllers\BaseController;
use App\Models\M_siswa;
use App\Models\M_kursus;
use App\Models\M_pendaftaran;
use App\Models\M_slider_promo;
use App\Models\M_review;
use App\Models\M_pembayaran;

class DashboardSiswa extends BaseController
{
    protected $siswaModel;
    protected $kursusModel;
    protected $pendaftaranModel;
    protected $sliderModel;
    protected $reviewModel;
    protected $pembayaranModel;

    public function __construct()
    {
        date_default_timezone_set('Asia/Jakarta');
        $this->siswaModel = new M_siswa();
        $this->kursusModel = new M_kursus();
        $this->pendaftaranModel = new M_pendaftaran();
        $this->sliderModel = new M_slider_promo();
        $this->reviewModel = new M_review();
        $this->pembayaranModel = new M_pembayaran();
    }

    public function index()
    {
        $id_siswa = session()->get('id_siswa');
        if (!$id_siswa) {
            session()->setFlashdata('error', 'Anda harus login terlebih dahulu!');
            return redirect()->to(base_url('auth_login/login_siswa'));
        }
        $this->pendaftaranModel->cleanupExpired();
        $this->pembayaranModel->cleanupExpired();
        $profil = $this->siswaModel->get_profil($id_siswa);
        $sliders = $this->sliderModel->getActiveSliders();
        $enrolled = $this->pendaftaranModel->getEnrolledCoursesForDashboard($id_siswa);
        $recommendations = $this->kursusModel->getRecommendationsForDashboard($id_siswa);
        $reviewed_ids = [];
        $my_reviews = $this->reviewModel->where('id_siswa', $id_siswa)->findAll();
        foreach ($my_reviews as $rv) {
            $reviewed_ids[] = $rv['id_pendaftaran'];
        }
        $data = [
            'title' => 'LPK INASADA',
            'title2' => 'Dashboard Siswa',
            'profil' => $profil,
            'sliders' => $sliders,
            'enrolled' => $enrolled,
            'recommendations' => $recommendations,
            'reviewed_ids' => $reviewed_ids,
        ];
        return view('backend/siswa/v_home_siswa', $data);
    }
}
