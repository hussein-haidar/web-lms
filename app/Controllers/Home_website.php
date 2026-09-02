<?php

namespace App\Controllers;

use CodeIgniter\Controller;

use App\Models\M_karyawan;
use App\Models\M_saran;
use App\Models\M_web;
use App\Models\M_Paket;
use App\Models\M_modul;
use App\Models\M_materi;
use App\Models\M_review;
use App\Models\M_postingan;
use App\Models\M_uji_kompetensi;
use App\Models\M_mitra_kerja;
use App\Models\M_slider_web;
use App\Models\M_kursus;
use App\Models\M_stats;
use App\Models\M_manajemen;
use App\Models\M_instruktur;
use App\Models\M_profil_lpk;
use App\Models\M_visi_misi;

class Home_website extends BaseController
{
    protected $M_karyawan;
    protected $M_saran;
    protected $M_web;
    protected $M_paket;
    protected $M_modul;
    protected $M_materi;
    protected $M_review;
    protected $M_postingan;
    protected $M_uji_kompetensi;
    protected $M_mitra_kerja;
    protected $M_slider_web;
    protected $M_kursus;
    protected $M_stats;
    protected $M_manajemen;
    protected $M_instruktur;
    protected $M_profil_lpk;
    protected $M_visi_misi;

    public function __construct()
    {
        // Jika butuh model, load di sini
        $this->M_karyawan = new M_karyawan();
        $this->M_saran = new M_saran();
        $this->M_web = new M_web();
        $this->M_paket = new M_paket();
        $this->M_modul = new M_modul();
        $this->M_materi = new M_materi();
        $this->M_review = new M_review();
        $this->M_postingan = new M_postingan();
        $this->M_uji_kompetensi = new M_uji_kompetensi();
        $this->M_mitra_kerja = new M_mitra_kerja();
        $this->M_slider_web = new M_slider_web();
        $this->M_kursus = new M_kursus();
        $this->M_stats = new M_stats();
        $this->M_manajemen = new M_manajemen();
        $this->M_instruktur = new M_instruktur();
        $this->M_profil_lpk = new M_profil_lpk();
        $this->M_visi_misi = new M_visi_misi();
    }

    public function index()
    {
        // Ambil data kelas online untuk rekomendasi
        $online = $this->M_paket
            ->select([
                'paket_kursus.id_paket',
                'paket_kursus.nama_paket',
                'paket_kursus.harga_reguler',
                'paket_kursus.harga_intensive',
                'paket_kursus.harga_private',
                'paket_kursus.total_pertemuan',
                'paket_kursus.durasi_per_pertemuan_jam',
                'paket_kursus.created_at',
                'k.id_kursus',
                'k.nama_kursus',
                'k.slug',
                'k.gambar_utama',
                'k.deskripsi_singkat',
                'k.status as status_kursus',
                'pr.nama_program',
                'dk.gambar_detail_a',
                'dk.gambar_detail_b',
                'dk.gambar_detail_c'
            ])
            ->join('kursus k', 'k.id_kursus = paket_kursus.id_kursus', 'left')
            ->join('detail_kursus dk', 'dk.id_kursus = k.id_kursus', 'left')
            ->join('program_kursus pr', 'pr.id_program = k.id_program', 'left')
            ->where('paket_kursus.deleted_at', null)
            ->where('k.status', 'aktif')
            ->where('pr.nama_program', 'Kelas Online')
            ->orderBy('paket_kursus.created_at', 'DESC')
            ->findAll();

        // Ambil data kelas offline
        $offline = $this->M_paket
            ->select([
                'paket_kursus.id_paket',
                'paket_kursus.nama_paket',
                'paket_kursus.harga_reguler',
                'paket_kursus.harga_intensive',
                'paket_kursus.harga_private',
                'paket_kursus.total_pertemuan',
                'paket_kursus.durasi_per_pertemuan_jam',
                'paket_kursus.created_at',
                'k.id_kursus',
                'k.nama_kursus',
                'k.slug',
                'k.gambar_utama',
                'k.deskripsi_singkat',
                'k.status as status_kursus',
                'pr.nama_program',
                'dk.gambar_detail_a',
                'dk.gambar_detail_b',
                'dk.gambar_detail_c'
            ])
            ->join('kursus k', 'k.id_kursus = paket_kursus.id_kursus', 'left')
            ->join('detail_kursus dk', 'dk.id_kursus = k.id_kursus', 'left')
            ->join('program_kursus pr', 'pr.id_program = k.id_program', 'left')
            ->where('paket_kursus.deleted_at', null)
            ->where('k.status', 'aktif')
            ->where('pr.nama_program', 'Kelas Offline')
            ->orderBy('paket_kursus.created_at', 'DESC')
            ->findAll();

        // Ambil data postingan terbaru untuk homepage
        $recent_posts = $this->M_postingan->getPublishedPosts(4, 0);

        // Ambil data mitra kerja untuk carousel
        $partners_carousel = $this->M_mitra_kerja->getPartnersForCarousel();

        // Ambil data slider promo untuk carousel
        $sliders = $this->M_slider_web->getActiveSliders();

        // Ambil data stats dari database
        $stats_data = $this->M_stats->getActiveStats();
        $stats_row1 = $this->M_stats->getStatsByRow(1);
        $stats_row2 = $this->M_stats->getStatsByRow(2);

        $data = [
            'title'  => 'LPK INASADA',
            'title2' => 'LPK INASADA',
            'online_courses' => $online,
            'offline' => $offline,
            'recent_posts' => $recent_posts,
            'partners_carousel' => $partners_carousel,
            'sliders' => $sliders,
            'stats_data' => $stats_data,
            'stats_row1' => $stats_row1,
            'stats_row2' => $stats_row2,
        ];

        return view('frontend/web/v_home', $data);
    }

    public function detail_program($program_type = 'a')
    {
        // Fetch program data based on type
        // Program A: Sekretaris & Administrasi (id_program = 4)
        // Program B: Desain Grafis (id_program = 4, DKV course)
        
        // Ambil data slider web untuk carousel
        $sliders = $this->M_slider_web->getActiveSliders();
        
        $program_id = 4; // Program Profesi 1 Tahun
        
        if ($program_type == 'a') {
            // Program A: Sekretaris & Administrasi Perkantoran
            $kursus = $this->M_kursus
                ->where('id_program', $program_id)
                ->like('nama_kursus', 'Sekretaris')
                ->first();
        } else {
            // Program B: Desain Grafis (DKV)
            $kursus = $this->M_kursus
                ->where('id_program', $program_id)
                ->like('nama_kursus', 'DKV')
                ->first();
        }
        
        // Fallback if no specific course found
        if (!$kursus) {
            $kursus = $this->M_kursus
                ->where('id_program', $program_id)
                ->first();
        }

        $data = [
            'title' => 'Detail Program - LPK INASABA',
            'program_type' => $program_type,
            'kursus' => $kursus,
            'sliders' => $sliders,
        ];

        return view('frontend/program/v_detail_program', $data);
    }

    public function kls_online()
    {
        $paket = $this->M_paket
            ->select([
                'paket_kursus.id_paket',
                'paket_kursus.nama_paket',
                'paket_kursus.harga_reguler',
                'paket_kursus.harga_intensive',
                'paket_kursus.harga_private',
                'paket_kursus.total_pertemuan',
                'paket_kursus.durasi_per_pertemuan_jam',
                'paket_kursus.created_at',
                'k.id_kursus',
                'k.nama_kursus',
                'k.slug',
                'k.gambar_utama',
                'k.deskripsi_singkat',
                'k.status as status_kursus',
                'pr.nama_program',
                'dk.gambar_detail_a',
                'dk.gambar_detail_b',
                'dk.gambar_detail_c'
            ])
            ->join('kursus k', 'k.id_kursus = paket_kursus.id_kursus', 'left')
            ->join('detail_kursus dk', 'dk.id_kursus = k.id_kursus', 'left')
            ->join('program_kursus pr', 'pr.id_program = k.id_program', 'left')
            ->where('paket_kursus.deleted_at', null)
            ->where('k.status', 'aktif')

            // ✅ PERBAIKAN: 'Kelas O' → 'Kelas Online'
            ->where('pr.nama_program', 'Kelas Online')

            ->orderBy('paket_kursus.created_at', 'DESC')
            ->findAll();

        $data = [
            'title'   => 'PROGRAM LPK INASABA',
            'title2'  => 'PROGRAM LPK INASABA',
            'paket'   => $paket,
        ];

        return view('frontend/kelas_online/v_kls_online', $data);
    }

    public function detail_online($id_paket = null)
    {
        if (!$id_paket) {
            return redirect()->to('home_website/kls_online');
        }

        // ✅ Query Data Kursus Utama
        $kursus = $this->M_paket
            ->select([
                'paket_kursus.id_paket',
                'paket_kursus.id_kursus',
                'paket_kursus.nama_paket',
                'paket_kursus.harga_reguler',
                'paket_kursus.harga_intensive',
                'paket_kursus.harga_private',
                'paket_kursus.total_pertemuan',
                'paket_kursus.durasi_per_pertemuan_jam',
                'k.id_kursus',
                'k.nama_kursus',
                'k.slug',
                'k.gambar_utama',
                'k.deskripsi_singkat',
                'k.status as status_kursus',
                'dk.materi_yang_dipelajari',
                'dk.syarat_pendaftaran',
                'dk.gambar_detail_a',
                'dk.gambar_detail_b',
                'dk.gambar_detail_c',
                'pr.nama_program',
                'kr.nama_lengkap as nama_pengajar',
                'kr.foto_profil as foto_pengajar'
            ])
            ->join('kursus k', 'k.id_kursus = paket_kursus.id_kursus', 'left')
            ->join('detail_kursus dk', 'dk.id_kursus = k.id_kursus', 'left')
            ->join('program_kursus pr', 'pr.id_program = k.id_program', 'left')
            ->join('karyawan kr', 'kr.id_karyawan = k.id_karyawan', 'left')
            ->where('paket_kursus.deleted_at', null)
            ->where('paket_kursus.id_paket', $id_paket)
            ->first();

        if (!$kursus) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Paket tidak ditemukan');
        }

        // ✅ Query Data Paket Lainnya (untuk rekomendasi)
        $paket = $this->M_paket
            ->select([
                'paket_kursus.id_paket',
                'paket_kursus.nama_paket',
                'paket_kursus.harga_reguler',
                'paket_kursus.harga_intensive',
                'paket_kursus.harga_private',
                'paket_kursus.total_pertemuan',
                'paket_kursus.durasi_per_pertemuan_jam',
                'paket_kursus.created_at',
                'k.nama_kursus',
                'k.slug',
                'k.gambar_utama',
                'k.deskripsi_singkat',
                'k.status as status_kursus',
                'pr.nama_program',
                'dk.gambar_detail_a',
                'dk.gambar_detail_b',
                'dk.gambar_detail_c'
            ])
            ->join('kursus k', 'k.id_kursus = paket_kursus.id_kursus', 'left')
            ->join('detail_kursus dk', 'dk.id_kursus = k.id_kursus', 'left')
            ->join('program_kursus pr', 'pr.id_program = k.id_program', 'left')
            ->where('paket_kursus.deleted_at', null)
            ->where('k.status', 'aktif')
            ->where('pr.nama_program', 'Kelas Online')
            ->orderBy('paket_kursus.created_at', 'DESC')
            ->findAll();

        // ✅ Query Data Kurikulum (Modul & Materi)
        $modul = $this->M_modul->where('id_kursus', $kursus['id_kursus'])->orderBy('urutan', 'ASC')->findAll();
        $kurikulum = [];
        $stats = [
            'video' => 0,
            'zoom'  => 0,
            'quiz'  => 0,
            'text'  => 0
        ];

        foreach ($modul as $m) {
            $list_materi = $this->M_materi->getByModul($m['id_modul']);
            foreach ($list_materi as $mat) {
                if ($mat['tipe_materi'] == 'youtube' || $mat['tipe_materi'] == 'video') $stats['video']++;
                if ($mat['tipe_materi'] == 'zoom') $stats['zoom']++;
                if ($mat['tipe_materi'] == 'quiz') $stats['quiz']++;
                if ($mat['tipe_materi'] == 'text') $stats['text']++;
            }
            $kurikulum[] = [
                'judul' => $m['nama_modul'],
                'materi' => $list_materi
            ];
        }

        // =====================================================
        // ✅ SANITASI DATA (Taruh kode di sini)
        // =====================================================

        // 1. Sanitasi Data Kursus Utama
        if ($kursus) {
            $kursus['nama_paket'] = $kursus['nama_paket'] ?? 'Tanpa Judul';
            $kursus['gambar_utama'] = $kursus['gambar_utama'] ?? 'as.png';
            $kursus['deskripsi_singkat'] = $kursus['deskripsi_singkat'] ?? '';
            // Tambahkan field lain jika diperlukan
        }

        // 2. Sanitasi Data Paket Lainnya (Rekomendasi)
        if ($paket) {
            foreach ($paket as &$p) {
                $p['nama_paket'] = $p['nama_paket'] ?? 'Tanpa Judul';
                $p['gambar_utama'] = $p['gambar_utama'] ?? 'as.png';
                $p['deskripsi_singkat'] = $p['deskripsi_singkat'] ?? '';
            }
            unset($p); // Penting: hapus reference variable setelah loop
        }
        // =====================================================
        // ✅ AKHIR SANITASI
        // =====================================================

        // ✅ Query Data Review
        $reviews = $this->M_review->getByKursusWithSiswa($kursus['id_kursus']);
        $rating_stats = $this->M_review->getAverageRating($kursus['id_kursus']);

        // ✅ Fetch Dynamic Content Statistics for Konten Kelas
        $contentStats = [
            'dokumen' => $stats['text'],
            'video' => $stats['video'],
            'zoom' => $stats['zoom'],
            'quiz' => $stats['quiz'],
            'tugas' => 0,
            'pre_exam' => 0,
            'exam' => 0,
            'sertifikat' => false
        ];

        // Count active tasks for this course
        $tugasModel = new \App\Models\M_tugas();
        $tugasList = $tugasModel->getTugasAktif($kursus['id_kursus']);
        $contentStats['tugas'] = count($tugasList);

        // Count and categorize quizzes
        $quizModel = new \App\Models\M_quiz();
        $quizList = $quizModel->getQuizByKursus($kursus['id_kursus']);
        
        foreach ($quizList as $quiz) {
            if ($quiz['status'] == 'aktif') {
                // Cek apakah ini pre-exam atau exam berdasarkan judul
                $judulLower = strtolower($quiz['judul_quiz']);
                if (strpos($judulLower, 'pre') !== false || strpos($judulLower, 'awal') !== false || strpos($judulLower, 'diagnostic') !== false) {
                    $contentStats['pre_exam']++;
                } elseif (strpos($judulLower, 'final') !== false || strpos($judulLower, 'akhir') !== false || strpos($judulLower, 'ujian') !== false) {
                    $contentStats['exam']++;
                }
            }
        }

        // Check if course offers certificate
        $sertifikatValue = $kursus['sertifikat'] ?? null;
        $contentStats['sertifikat'] = ($sertifikatValue == 1) || 
                                    (is_string($sertifikatValue) && strtolower($sertifikatValue) === 'ya') ||
                                    (is_string($sertifikatValue) && strtolower($sertifikatValue) === 'yes');

        $data = [
            'title'   => 'DETAIL PAKET - ' . esc($kursus['nama_paket']),
            'title2'  => 'Detail Paket',
            'kursus'  => $kursus,
            'paket'   => $paket,
            'kurikulum' => $kurikulum,
            'stats'     => $stats,
            'contentStats' => $contentStats,
            'reviews'   => $reviews,
            'rating_stats' => $rating_stats,
        ];

        return view('frontend/kelas_online/v_detail_kelas', $data);
    }

    public function program_cfk()
    {
        $data = [
            'title' =>  'PROGRAM LPK INASADA ',
            'title2' => 'PROGRAM LPK INASADA',

        ];
        return view('frontend/program/v_cfk', $data);
    }

    public function program_setahun()
    {
        $data = [
            'title' =>  'PROGRAM LPK INASADA ',
            'title2' => 'PROGRAM LPK INASADA',

        ];
        return view('frontend/program/v_program_setahun', $data);
    }

    public function detail_program_a($id_paket = null)
    {
        // Ambil data slider web untuk carousel
        $sliders = $this->M_slider_web->getActiveSliders();
        
        // Debug: Tampilkan data sliders
        // echo '<pre>'; print_r($sliders); echo '</pre>';
        
        $data = [
            'title' =>  'MATERI LPK INASADA ',
            'title2' => 'MATERI LPK INASADA',
            'kursus' => $this->M_paket
                ->find($id_paket),
            'sliders' => $sliders,
            'program_type' => 'a'
        ];
        return view('frontend/program/v_detail_program', $data);
    }

    public function detail_program_b($id_paket = null)
    {
        // Ambil data slider web untuk carousel
        $sliders = $this->M_slider_web->getActiveSliders();
        
        $data = [
            'title' =>  'MATERI LPK INASADA ',
            'title2' => 'MATERI LPK INASADA',
            'kursus' => $this->M_paket
                ->find($id_paket),
            'sliders' => $sliders,
            'program_type' => 'b'
        ];
        return view('frontend/program/v_detail_program', $data);
    }

    public function kls_offline()
    {
        $paket = $this->M_paket
            ->select([
                'paket_kursus.id_paket',
                'paket_kursus.nama_paket',
                'paket_kursus.harga_reguler',
                'paket_kursus.harga_intensive',
                'paket_kursus.harga_private',
                'paket_kursus.total_pertemuan',
                'paket_kursus.durasi_per_pertemuan_jam',
                'paket_kursus.created_at',
                'k.nama_kursus',
                'k.slug',
                'k.gambar_utama',
                'k.deskripsi_singkat',
                'k.status as status_kursus',
                'pr.nama_program',
                'dk.gambar_detail_a',
                'dk.gambar_detail_b',
                'dk.gambar_detail_c'
            ])
            ->join('kursus k', 'k.id_kursus = paket_kursus.id_kursus', 'left')
            ->join('detail_kursus dk', 'dk.id_kursus = k.id_kursus', 'left')
            ->join('program_kursus pr', 'pr.id_program = k.id_program', 'left')
            ->where('paket_kursus.deleted_at', null)
            ->where('k.status', 'aktif')
            ->where('pr.nama_program', 'Kelas Offline')
            ->orderBy('paket_kursus.created_at', 'DESC')
            ->findAll();

        $data = [
            'title'   => 'PROGRAM LPK INASABA',
            'title2'  => 'PROGRAM LPK INASABA',
            'paket'   => $paket,
        ];

        return view('frontend/kelas_offline/v_kls_offline', $data);
    }

    public function detail_offline($id_paket = null)
    {
        if (!$id_paket) {
            return redirect()->to('home_website/kls_offline');
        }

        $kursus = $this->M_paket
            ->select([
                'paket_kursus.id_paket',
                'paket_kursus.id_kursus',
                'paket_kursus.nama_paket',
                'paket_kursus.harga_reguler',
                'paket_kursus.harga_intensive',
                'paket_kursus.harga_private',
                'paket_kursus.total_pertemuan',
                'paket_kursus.durasi_per_pertemuan_jam',
                'k.id_kursus',
                'k.nama_kursus',
                'k.slug',
                'k.gambar_utama',
                'k.deskripsi_singkat',
                'k.status as status_kursus',
                'dk.materi_yang_dipelajari',
                'dk.syarat_pendaftaran',
                'dk.gambar_detail_a',
                'dk.gambar_detail_b',
                'dk.gambar_detail_c',
                'pr.nama_program',
                'kr.nama_lengkap as nama_pengajar',
                'kr.foto_profil as foto_pengajar'
            ])
            ->join('kursus k', 'k.id_kursus = paket_kursus.id_kursus', 'left')
            ->join('detail_kursus dk', 'dk.id_kursus = k.id_kursus', 'left')
            ->join('program_kursus pr', 'pr.id_program = k.id_program', 'left')
            ->join('karyawan kr', 'kr.id_karyawan = k.id_karyawan', 'left')
            ->where('paket_kursus.deleted_at', null)
            ->where('paket_kursus.id_paket', $id_paket)
            ->first();

        if (!$kursus) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Paket tidak ditemukan');
        }

        // ✅ Query Data Kurikulum (Modul & Materi)
        $modul = $this->M_modul->where('id_kursus', $kursus['id_kursus'])->orderBy('urutan', 'ASC')->findAll();
        $kurikulum = [];
        $stats = [
            'video' => 0,
            'zoom'  => 0,
            'quiz'  => 0,
            'text'  => 0
        ];

        foreach ($modul as $m) {
            $list_materi = $this->M_materi->getByModul($m['id_modul']);
            foreach ($list_materi as $mat) {
                if ($mat['tipe_materi'] == 'youtube' || $mat['tipe_materi'] == 'video') $stats['video']++;
                if ($mat['tipe_materi'] == 'zoom') $stats['zoom']++;
                if ($mat['tipe_materi'] == 'quiz') $stats['quiz']++;
                if ($mat['tipe_materi'] == 'text') $stats['text']++;
            }
            $kurikulum[] = [
                'judul' => $m['nama_modul'],
                'materi' => $list_materi
            ];
        }

        $data = [
            'title'   => 'DETAIL PAKET - ' . esc($kursus['nama_paket'] ?? 'Unknown'),
            'title2'  => 'Detail Paket',
            'kursus'  => $kursus,
            'kurikulum' => $kurikulum,
            'stats'     => $stats,
        ];

        return view('frontend/kelas_offline/v_detail_kelas', $data);
    }

    // Halaman daftar postingan (public)
    public function postingan_index()
    {
        $page = $this->request->getVar('page') ?? 1;
        $perPage = 6;

        $data = [
            'title' => 'Postingan Terbaru - LPK INASABA',
            'title2' => 'Postingan Terbaru',
            'postingan' => $this->M_postingan->getPublishedPosts($perPage, ($page - 1) * $perPage),
            'pager' => $this->M_postingan->pager,
            'currentPage' => $page,
            'totalPosts' => count($this->M_postingan->getPublishedPosts()),
            'recentPosts' => $this->M_postingan->getRecentPosts(3),
            'popularPosts' => $this->M_postingan->getPopularPosts(3)
        ];

        return view('frontend/postingan/v_postingan', $data);
    }

    // Halaman detail postingan
    public function postingan_detail($slug)
    {
        $post = $this->M_postingan->getPostBySlug($slug);

        if (!$post) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
        }

        // Increment views
        $this->M_postingan->incrementViews($post['id_postingan']);

        $data = [
            'title' => $post['judul_postingan'] . ' - LPK INASABA',
            'title2' => 'Detail Postingan',
            'post' => $post,
            'relatedPosts' => $this->M_postingan->getPostsByCategory($post['kategori'], 3),
            'recentPosts' => $this->M_postingan->getRecentPosts(5)
        ];

        return view('frontend/postingan/v_detail_postingan', $data);
    }

    // Search postingan
    public function postingan_search()
    {
        $keyword = $this->request->getGet('keyword');

        if (empty($keyword)) {
            return redirect()->to('/home_superadmin/postingan_index');
        }

        $data = [
            'title' => 'Hasil Pencarian: ' . $keyword . ' - LPK INASABA',
            'title2' => 'Hasil Pencarian',
            'keyword' => $keyword,
            'postingan' => $this->M_postingan->searchPosts($keyword),
            'recentPosts' => $this->M_postingan->getRecentPosts(3)
        ];

        return view('frontend/postingan/v_search_postingan', $data);
    }

    // Get postingan categories
    private function getPostinganCategories()
    {
        return [
            'Umum' => 'Umum',
            'Tips Karir' => 'Tips Karir',
            'Teknologi' => 'Teknologi',
            'Pendidikan' => 'Pendidikan',
            'Alumni' => 'Alumni',
            'Pengumuman' => 'Pengumuman',
            'Event' => 'Event'
        ];
    }

    public function alumni()
    {
        $alumniModel = new \App\Models\M_alumni();
        
        // Get alumni data with automatic gambar paths
        try {
            $alumni = $alumniModel->getAlumniWithGambar('aktif');
        } catch (\Exception $e) {
            // If the query fails, try with basic method
            try {
                $alumni = $alumniModel->getAlumni('aktif');
            } catch (\Exception $e2) {
                $alumni = [];
            }
        }
        
        $data = [
            'title' =>  'ALUMNI LPK INASADA ',
            'title2' => 'ALUMNI LPK INASADA',
            'alumni' => $alumni
        ];
        return view('frontend/web/v_alumni', $data);
    }

    public function teach_factory()
    {
        $data = [
            'title' =>  'TEACHING FACTORY LPK INASADA ',
            'title2' => 'TEACHING FACTORY LPK INASADA',

        ];
        return view('frontend/web/v_teach_factory', $data);
    }

    public function kontak()
    {
        $data = [
            'title' =>  'KONTAK LPK INASADA ',
            'title2' => 'KONTAK LPK INASADA',

        ];
        return view('frontend/web/v_kontak', $data);
    }

    public function simpan_saran()
    {
        // Validasi input saran (sesuai struktur tabel)
        $rules = [
            'nama' => [
                'label'  => 'Nama',
                'rules'  => 'required|min_length[3]|max_length[100]',
                'errors' => [
                    'required'   => '{field} wajib diisi!',
                    'min_length' => '{field} minimal 3 karakter!',
                    'max_length' => '{field} maksimal 100 karakter!'
                ]
            ],
            'email' => [
                'label'  => 'Email',
                'rules'  => 'required|valid_email|max_length[100]',
                'errors' => [
                    'required'    => '{field} wajib diisi!',
                    'valid_email' => 'Format {field} tidak valid!',
                    'max_length'  => '{field} maksimal 100 karakter!'
                ]
            ],
            'pesan' => [
                'label'  => 'Pesan',
                'rules'  => 'required|min_length[10]|max_length[1000]',
                'errors' => [
                    'required'   => '{field} wajib diisi!',
                    'min_length' => '{field} minimal 10 karakter!',
                    'max_length' => '{field} maksimal 1000 karakter!'
                ]
            ]
        ];

        if ($this->validate($rules)) {
            $data = [
                'nama'    => $this->request->getPost('nama'),
                'email'   => $this->request->getPost('email'),
                'pesan'   => $this->request->getPost('pesan'),
                'tanggal' => date('Y-m-d H:i:s') // Timestamp otomatis saat simpan
            ];

            $this->M_saran->add($data);

            session()->setFlashdata('pesan', 'Terima kasih atas sarannya! Saran Anda telah kami terima.');
            return redirect()->to(base_url('home_website/kontak'))->with('success', 'Saran berhasil dikirim!');
        } else {
            session()->setFlashdata('errors', \Config\Services::validation()->getErrors());
            return redirect()->back()->withInput();
        }
    }

    public function sejarah()
    {
        // Get data from database
        $data_profil = $this->M_profil_lpk->getProfil();
        $data_manajemen = $this->M_manajemen->getActiveManajemen();
        $data_instruktur = $this->M_instruktur->getActiveInstruktur();
        $data_visi = $this->M_visi_misi->getVisi();
        $data_misi = $this->M_visi_misi->getMisi();
        
        $data = [
            'title' =>  'PROFIL LPK INASADA ',
            'title2' => 'PROFIL LPK INASADA',
            'profil' => $data_profil,
            'manajemen' => $data_manajemen,
            'instruktur' => $data_instruktur,
            'visi' => $data_visi,
            'misi' => $data_misi
        ];
        return view('frontend/web/v_sejarah', $data);
    }

    public function galeri()
    {
        $data = [
            'title' =>  'galeri LPK INASADA ',
            'title2' => 'galeri LPK INASADA',

        ];
        return view('frontend/web/v_galeri', $data);
    }
    public function pencarian()
    {
        $keyword = $this->request->getGet('keyword');

        $paket = [];
        if (!empty($keyword)) {
            $db = \Config\Database::connect();
            $paket = $db->table('paket_kursus pk')
                ->select([
                    'pk.id_paket',
                    'pk.nama_paket',
                    'k.id_kursus',
                    'k.nama_kursus',
                    'k.slug',
                    'k.gambar_utama',
                    'k.deskripsi_singkat',
                    'pr.nama_program'
                ])
                ->join('kursus k', 'k.id_kursus = pk.id_kursus', 'left')
                ->join('program_kursus pr', 'pr.id_program = k.id_program', 'left')
                ->where('pk.deleted_at', null)
                ->where('k.status', 'aktif')
                ->groupStart()
                ->like('pk.nama_paket', $keyword)
                ->orLike('k.nama_kursus', $keyword)
                ->orLike('k.deskripsi_singkat', $keyword)
                ->orLike('pr.nama_program', $keyword)
                ->groupEnd()
                ->orderBy('pk.created_at', 'DESC')
                ->get()
                ->getResultArray();
        }

        $data = [
            'title'   => 'Hasil Pencarian: ' . esc($keyword),
            'title2'  => 'Hasil Pencarian',
            'keyword' => $keyword,
            'paket'   => $paket,
        ];

        return view('frontend/web/v_pencarian', $data);
    }

    // --- UJI KOMPETENSI FRONTEND ---
    public function uji_kompetensi()
    {
        // Get data uji kompetensi
        $uji_kompetensi = $this->M_uji_kompetensi->getAktif();
        
        // Prepare data for view
        $data = [
            'uji_kompetensi' => $uji_kompetensi,
            'title' => 'Uji Kompetensi - LMS Web'
        ];
        
        // Load view v_uji_kompetensi
        return view('frontend/web/v_uji_kompetensi', $data);
    }
    
    public function detail_uji_kompetensi($id)
    {
        // Get specific uji kompetensi data
        $detail = $this->M_uji_kompetensi->getDetail($id);
        
        if (!$detail) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
        }
        
        $data = [
            'detail' => $detail,
            'title' => $detail['nama_uji_kompetensi'] . ' - LMS Web'
        ];
        
        return view('frontend/web/v_detail_uji_kompetensi', $data);
    }
}
