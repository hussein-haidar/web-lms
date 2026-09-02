<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\M_siswa;
use App\Models\M_pendaftaran;
use App\Models\M_kursus;
use App\Models\M_detail_kursus;
use App\Models\M_paket;
use App\Models\M_pembayaran;
use App\Models\M_karyawan;
use App\Models\M_modul;
use App\Models\M_materi;
use App\Models\M_tugas;
use App\Models\M_quiz;
use App\Models\M_sertifikat;
use App\Models\M_postingan;
use App\Models\M_web;
use App\Models\M_program;
use App\Models\M_slider_promo;
use App\Models\M_slider_web;
use App\Models\M_bank;
use App\Models\M_backup;
use App\Models\M_saran;
use App\Models\M_uji_kompetensi;
use App\Models\M_galeri_uji_kompetensi;
use App\Models\M_mitra_kerja;
use App\Models\M_manajemen;
use App\Models\M_instruktur;
use App\Models\M_profil_lpk;
use App\Models\M_visi_misi;
use App\Models\M_stats;
use App\Models\M_alumni;

class Home_superadmin extends BaseController
{
    protected $siswaModel;
    protected $pendaftaranModel;
    protected $kursusModel;
    protected $detailKursusModel;
    protected $paketModel;
    protected $pembayaranModel;
    protected $karyawanModel;
    protected $modulModel;
    protected $materiModel;
    protected $tugasModel;
    protected $quizModel;
    protected $sertifikatModel;
    protected $postinganModel;
    protected $webModel;
    protected $programModel;
    protected $sliderModel;
    protected $sliderWebModel;
    protected $bankModel;
    protected $backupModel;
    protected $saranModel;
    protected $ujiKompetensiModel;
    protected $mitraKerjaModel;
    protected $manajemenModel;
    protected $instrukturModel;
    protected $profilLpkModel;
    protected $visiMisiModel;
    protected $statsModel;
    protected $alumniModel;

    public function __construct()
    {
        $this->siswaModel = new M_siswa();
        $this->pendaftaranModel = new M_pendaftaran();
        $this->kursusModel = new M_kursus();
        $this->detailKursusModel = new M_detail_kursus();
        $this->paketModel = new M_paket();
        $this->pembayaranModel = new M_pembayaran();
        $this->karyawanModel = new M_karyawan();
        $this->modulModel = new M_modul();
        $this->materiModel = new M_materi();
        $this->tugasModel = new M_tugas();
        $this->quizModel = new M_quiz();
        $this->sertifikatModel = new M_sertifikat();
        $this->postinganModel = new M_postingan();
        $this->webModel = new M_web();
        $this->programModel = new M_program();
        $this->sliderModel = new M_slider_promo();
        $this->sliderWebModel = new M_slider_web();
        $this->bankModel = new M_bank();
        $this->backupModel = new M_backup();
        $this->saranModel = new M_saran();
        $this->ujiKompetensiModel = new M_uji_kompetensi();
        $this->mitraKerjaModel = new M_mitra_kerja();
        $this->manajemenModel = new M_manajemen();
        $this->instrukturModel = new M_instruktur();
        $this->profilLpkModel = new M_profil_lpk();
        $this->visiMisiModel = new M_visi_misi();
        $this->statsModel = new M_stats();
        $this->alumniModel = new M_alumni();
        $this->galeriUjiModel = new M_galeri_uji_kompetensi();
    }

    public function index()
    {
        $db = \Config\Database::connect();
        
        // Basic statistics
        $total_siswa = $this->siswaModel->countAll();
        $total_karyawan = $this->karyawanModel->countAll();
        $total_kursus = $this->kursusModel->countAll();
        $total_pengajar = $this->karyawanModel->where('level', 'pengajar')->countAllResults();
        $total_staf_admin = $this->karyawanModel->where('level', 'staf_admin')->countAllResults();
        $total_teknisi = $this->karyawanModel->where('level', 'teknisi')->countAllResults();

        // Additional stats
        $total_pendaftaran = $db->table('pendaftaran')->countAllResults();
        $total_pendapatan = $db->table('pembayaran')->where('status', 'lunas')->sum('jumlah_bayar') ?? 0;
        $total_sertifikat = $db->table('sertifikat')->countAllResults();
        $pending_pembayaran = $db->table('pembayaran')->where('status', 'pending')->countAllResults();

        // Chart: Pendaftaran 6 bulan terakhir
        $chart_pendaftaran_labels = [];
        $chart_pendaftaran_data = [];
        for ($i = 5; $i >= 0; $i--) {
            $bulan = date('Y-m', strtotime("-{$i} months"));
            $chart_pendaftaran_labels[] = date('M', strtotime("{$bulan}-01"));
            $count = $db->table('pendaftaran')->like('created_at', $bulan, 'after')->countAllResults();
            $chart_pendaftaran_data[] = $count;
        }

        // Chart: Status pembayaran
        $lunas = $db->table('pembayaran')->where('status', 'lunas')->countAllResults();
        $pending_bayar = $db->table('pembayaran')->where('status', 'pending')->countAllResults();
        $ditolak = $db->table('pembayaran')->where('status', 'ditolak')->countAllResults();
        $gagal = $db->table('pembayaran')->where('status', 'gagal')->countAllResults();
        $chart_pembayaran_data = [$lunas, $pending_bayar, $ditolak, $gagal];

        // Chart: Pendapatan bulanan
        $chart_pendapatan_labels = [];
        $chart_pendapatan_data = [];
        for ($i = 5; $i >= 0; $i--) {
            $bulan = date('Y-m', strtotime("-{$i} months"));
            $chart_pendapatan_labels[] = date('M', strtotime("{$bulan}-01"));
            $pendapatan = $db->table('pembayaran')->like('created_at', $bulan, 'after')->where('status', 'lunas')->sum('jumlah_bayar') ?? 0;
            $chart_pendapatan_data[] = (int) $pendapatan;
        }

        // Chart: Kursus populer (top 6)
        $kursus_populer = $db->table('pendaftaran p')
            ->select('k.nama_kursus, COUNT(*) as total')
            ->join('kursus k', 'k.id_kursus = p.id_kursus', 'left')
            ->groupBy('p.id_kursus')
            ->orderBy('total', 'DESC')
            ->limit(6)
            ->get()
            ->getResultArray();
        $chart_kursus_labels = array_column($kursus_populer, 'nama_kursus');
        $chart_kursus_data = array_column($kursus_populer, 'total');

        // Recent data
        $recent_pendaftaran = $db->table('pendaftaran p')
            ->select('p.*, s.nama_lengkap, k.nama_kursus')
            ->join('siswa s', 's.id_siswa = p.id_siswa', 'left')
            ->join('kursus k', 'k.id_kursus = p.id_kursus', 'left')
            ->orderBy('p.created_at', 'DESC')
            ->limit(5)
            ->get()
            ->getResultArray();

        $recent_pembayaran = $db->table('pembayaran p')
            ->select('p.*, s.nama_lengkap')
            ->join('siswa s', 's.id_siswa = p.id_siswa', 'left')
            ->where('p.status', 'pending')
            ->orderBy('p.created_at', 'DESC')
            ->limit(5)
            ->get()
            ->getResultArray();
        
        $data = [
            'title' => 'Dashboard Superadmin',
            'title2' => 'Dashboard',
            'total_siswa' => $total_siswa,
            'total_karyawan' => $total_karyawan,
            'total_kursus' => $total_kursus,
            'total_pengajar' => $total_pengajar,
            'total_staf_admin' => $total_staf_admin,
            'total_teknisi' => $total_teknisi,
            'total_pendaftaran' => $total_pendaftaran,
            'total_pendapatan' => $total_pendapatan,
            'total_sertifikat' => $total_sertifikat,
            'pending_pembayaran' => $pending_pembayaran,
            'chart_pendaftaran_labels' => $chart_pendaftaran_labels,
            'chart_pendaftaran_data' => $chart_pendaftaran_data,
            'chart_pembayaran_data' => $chart_pembayaran_data,
            'chart_pendapatan_labels' => $chart_pendapatan_labels,
            'chart_pendapatan_data' => $chart_pendapatan_data,
            'chart_kursus_labels' => $chart_kursus_labels,
            'chart_kursus_data' => $chart_kursus_data,
            'recent_pendaftaran' => $recent_pendaftaran,
            'recent_pembayaran' => $recent_pembayaran,
        ];
        return view('backend/superadmin/v_home_superadmin', $data);
    }

    
    public function karyawan()
    {
        $data = [
            'title' => 'Data Karyawan',
            'title2' => 'Data Karyawan',
            'karyawan' => $this->karyawanModel->findAll()
        ];
        return view('backend/superadmin/karyawan/v_karyawan', $data);
    }

    public function tambah_karyawan()
    {
        $data = [
            'title' => 'Tambah Karyawan',
            'title2' => 'Tambah Karyawan'
        ];
        return view('backend/superadmin/karyawan/v_tambah_karyawan', $data);
    }

    public function save_karyawan()
    {
        $rules = [
            'nama_lengkap' => 'required|min_length[3]|max_length[100]',
            'email' => 'required|valid_email|is_unique[karyawan.email]',
            'password' => 'required|min_length[6]',
            'no_telepon' => 'required|min_length[10]|max_length[15]',
            'level' => 'required|in_list[staf_admin,superadmin]',
            'alamat' => 'required|min_length[10]|max_length[255]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', \Config\Services::validation()->getErrors());
        }

        $data = [
            'nama_lengkap' => $this->request->getPost('nama_lengkap'),
            'email' => $this->request->getPost('email'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'no_telepon' => $this->request->getPost('no_telepon'),
            'level' => $this->request->getPost('level'),
            'alamat' => $this->request->getPost('alamat'),
            'status' => 'aktif',
            'tanggal_daftar' => date('Y-m-d H:i:s'),
        ];

        $this->karyawanModel->insert($data);
        session()->setFlashdata('success', 'Data karyawan berhasil ditambahkan!');
        return redirect()->to(base_url('home_superadmin/karyawan'));
    }

    public function edit_karyawan($id_karyawan)
    {
        $karyawan = $this->karyawanModel->find($id_karyawan);
        if (!$karyawan) {
            session()->setFlashdata('error', 'Data karyawan tidak ditemukan!');
            return redirect()->to(base_url('home_superadmin/karyawan'));
        }

        $data = [
            'title' => 'Edit Karyawan',
            'title2' => 'Edit Karyawan',
            'karyawan' => $karyawan
        ];
        return view('backend/superadmin/karyawan/v_edit_karyawan', $data);
    }

    public function update_karyawan($id_karyawan)
    {
        $karyawan = $this->karyawanModel->find($id_karyawan);
        if (!$karyawan) {
            session()->setFlashdata('error', 'Data karyawan tidak ditemukan!');
            return redirect()->to(base_url('home_superadmin/karyawan'));
        }

        $rules = [
            'nama_lengkap' => 'required|min_length[3]|max_length[100]',
            'email' => 'required|valid_email|is_unique[karyawan.email,id_karyawan,' . $id_karyawan . ']',
            'no_telepon' => 'required|min_length[10]|max_length[15]',
            'level' => 'required|in_list[staf_admin,superadmin]',
            'alamat' => 'required|min_length[10]|max_length[255]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', \Config\Services::validation()->getErrors());
        }

        $data = [
            'nama_lengkap' => $this->request->getPost('nama_lengkap'),
            'email' => $this->request->getPost('email'),
            'no_telepon' => $this->request->getPost('no_telepon'),
            'level' => $this->request->getPost('level'),
            'alamat' => $this->request->getPost('alamat'),
        ];

        $password = $this->request->getPost('password');
        if (!empty($password)) {
            $data['password'] = password_hash($password, PASSWORD_DEFAULT);
        }

        $this->karyawanModel->update($id_karyawan, $data);
        session()->setFlashdata('success', 'Data karyawan berhasil diperbarui!');
        return redirect()->to(base_url('home_superadmin/karyawan'));
    }

    public function delete_karyawan($id_karyawan)
    {
        $karyawan = $this->karyawanModel->find($id_karyawan);
        if (!$karyawan) {
            session()->setFlashdata('error', 'Data karyawan tidak ditemukan!');
            return redirect()->to(base_url('home_superadmin/karyawan'));
        }

        // Cek apakah ini superadmin yang sedang login
        if ($id_karyawan == session()->get('id_karyawan')) {
            session()->setFlashdata('error', 'Tidak dapat menghapus akun yang sedang digunakan!');
            return redirect()->to(base_url('home_superadmin/karyawan'));
        }

        $this->karyawanModel->delete($id_karyawan);
        session()->setFlashdata('success', 'Data karyawan berhasil dihapus!');
        return redirect()->to(base_url('home_superadmin/karyawan'));
    }

    public function kursus_admin()
    {
        // Get filter values from request
        $filters = [
            'program' => $this->request->getGet('program')
        ];
        
        // Filter configuration
        $filterConfig = [
            'program' => [
                'label' => 'Program',
                'column' => 'id_program',
                'table_alias' => 'k',
                'type' => 'where',
                'options' => \Config\Database::connect()->table('program_kursus')
                    ->select('id_program, nama_program')
                    ->get()
                    ->getResultArray()
            ]
        ];
        
        $data = [
            'title' => 'Data Kursus',
            'title2' => 'Data Kursus',
            'kursus' => $this->kursusModel->getKursusWithFilter($filters, $filterConfig),
            'filterConfig' => $filterConfig,
            'filters' => $filters
        ];
        return view('backend/superadmin/kursus/v_kursus', $data);
    }

    public function add_kursus()
    {
        return $this->tambah_kursus();
    }

    public function tambah_kursus()
    {
        $data = [
            'title' => 'Tambah Kursus',
            'title2' => 'Tambah Kursus',
            'program' => $this->programModel->findAll(),
            'karyawan' => $this->kursusModel->getPengajar()
        ];
        return view('backend/superadmin/kursus/v_tambah_kursus', $data);
    }

    public function save_kursus()
    {
        $rules = [
            'nama_kursus' => 'required|min_length[3]|max_length[100]',
            'slug' => 'required|alpha_dash|is_unique[kursus.slug]',
            'deskripsi_singkat' => 'required|min_length[10]',
            'id_program' => 'required|numeric',
            'materi_yang_dipelajari' => 'required|min_length[10]',
            'syarat_pendaftaran' => 'required|min_length[10]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', \Config\Services::validation()->getErrors());
        }

        // Handle gambar_utama upload
        $gambar_utama = '';
        $file = $this->request->getFile('gambar_utama');
        if ($file && $file->isValid()) {
            $gambar_utama = $file->getRandomName();
            $file->move('kursus/materi', $gambar_utama);
        }

        // Handle gambar_detail_a upload
        $gambar_detail_a = '';
        $file_detail_a = $this->request->getFile('gambar_detail_a');
        if ($file_detail_a && $file_detail_a->isValid()) {
            $gambar_detail_a = $file_detail_a->getRandomName();
            $file_detail_a->move('kursus/materi', $gambar_detail_a);
        }

        // Handle gambar_detail_b upload
        $gambar_detail_b = '';
        $file_detail_b = $this->request->getFile('gambar_detail_b');
        if ($file_detail_b && $file_detail_b->isValid()) {
            $gambar_detail_b = $file_detail_b->getRandomName();
            $file_detail_b->move('kursus/materi', $gambar_detail_b);
        }

        // Handle gambar_detail_c upload
        $gambar_detail_c = '';
        $file_detail_c = $this->request->getFile('gambar_detail_c');
        if ($file_detail_c && $file_detail_c->isValid()) {
            $gambar_detail_c = $file_detail_c->getRandomName();
            $file_detail_c->move('kursus/materi', $gambar_detail_c);
        }

        // Insert ke tabel kursus
        $kursus_data = [
            'id_karyawan' => $this->request->getPost('id_karyawan'),
            'nama_kursus' => $this->request->getPost('nama_kursus'),
            'id_program' => $this->request->getPost('id_program'),
            'slug' => $this->request->getPost('slug'),
            'deskripsi_singkat' => $this->request->getPost('deskripsi_singkat'),
            'gambar_utama' => $gambar_utama,
            'status' => $this->request->getPost('status'),
            'tanggal_dibuat' => date('Y-m-d H:i:s')
        ];

        $this->kursusModel->insert($kursus_data);
        $id_kursus = $this->kursusModel->getInsertID();

        // Insert ke tabel detail_kursus
        $detail_data = [
            'id_kursus' => $id_kursus,
            'materi_yang_dipelajari' => $this->request->getPost('materi_yang_dipelajari'),
            'syarat_pendaftaran' => $this->request->getPost('syarat_pendaftaran'),
            'gambar_detail_a' => $gambar_detail_a,
            'gambar_detail_b' => $gambar_detail_b,
            'gambar_detail_c' => $gambar_detail_c
        ];

        $this->detailKursusModel->insert($detail_data);
        
        session()->setFlashdata('success', 'Data kursus berhasil ditambahkan!');
        return redirect()->to(base_url('home_superadmin/kursus'));
    }

    public function edit_kursus($id_kursus)
    {
        $kursus = $this->kursusModel->getKursusWithDetailById($id_kursus);
        if (!$kursus) {
            session()->setFlashdata('error', 'Data kursus tidak ditemukan!');
            return redirect()->to(base_url('home_superadmin/kursus'));
        }

        $data = [
            'title' => 'Edit Kursus',
            'title2' => 'Edit Kursus',
            'kursus' => $kursus,
            'program' => $this->programModel->findAll(),
            'karyawan' => $this->kursusModel->getPengajar()
        ];
        return view('backend/superadmin/kursus/v_edit_kursus', $data);
    }

    public function update_kursus($id_kursus)
    {
        $kursus = $this->kursusModel->getKursusWithDetailById($id_kursus);
        if (!$kursus) {
            session()->setFlashdata('error', 'Data kursus tidak ditemukan!');
            return redirect()->to(base_url('home_superadmin/kursus'));
        }

        $rules = [
            'nama_kursus' => 'required|min_length[3]|max_length[100]',
            'slug' => 'required|alpha_dash|is_unique[kursus.slug,id_kursus,' . $id_kursus . ']',
            'deskripsi_singkat' => 'required|min_length[10]',
            'id_program' => 'required|numeric',
            'materi_yang_dipelajari' => 'required|min_length[10]',
            'syarat_pendaftaran' => 'required|min_length[10]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', \Config\Services::validation()->getErrors());
        }

        // Update data kursus
        $kursus_data = [
            'id_karyawan' => $this->request->getPost('id_karyawan'),
            'nama_kursus' => $this->request->getPost('nama_kursus'),
            'id_program' => $this->request->getPost('id_program'),
            'slug' => $this->request->getPost('slug'),
            'deskripsi_singkat' => $this->request->getPost('deskripsi_singkat'),
            'status' => $this->request->getPost('status')
        ];

        // Handle gambar_utama upload
        $file = $this->request->getFile('gambar_utama');
        if ($file && $file->isValid()) {
            // Hapus gambar lama
            if (!empty($kursus['gambar_utama']) && file_exists('kursus/materi/' . $kursus['gambar_utama'])) {
                unlink('kursus/materi/' . $kursus['gambar_utama']);
            }
            
            $gambar_utama = $file->getRandomName();
            $file->move('kursus/materi', $gambar_utama);
            $kursus_data['gambar_utama'] = $gambar_utama;
        }

        $this->kursusModel->update($id_kursus, $kursus_data);

        // Update data detail_kursus
        $detail_data = [
            'materi_yang_dipelajari' => $this->request->getPost('materi_yang_dipelajari'),
            'syarat_pendaftaran' => $this->request->getPost('syarat_pendaftaran')
        ];

        // Handle gambar_detail_a upload
        $file_detail_a = $this->request->getFile('gambar_detail_a');
        if ($file_detail_a && $file_detail_a->isValid()) {
            // Hapus gambar lama
            if (!empty($kursus['gambar_detail_a']) && file_exists('kursus/materi/' . $kursus['gambar_detail_a'])) {
                unlink('kursus/materi/' . $kursus['gambar_detail_a']);
            }
            
            $gambar_detail_a = $file_detail_a->getRandomName();
            $file_detail_a->move('kursus/materi', $gambar_detail_a);
            $detail_data['gambar_detail_a'] = $gambar_detail_a;
        }

        // Handle gambar_detail_b upload
        $file_detail_b = $this->request->getFile('gambar_detail_b');
        if ($file_detail_b && $file_detail_b->isValid()) {
            // Hapus gambar lama
            if (!empty($kursus['gambar_detail_b']) && file_exists('kursus/materi/' . $kursus['gambar_detail_b'])) {
                unlink('kursus/materi/' . $kursus['gambar_detail_b']);
            }
            
            $gambar_detail_b = $file_detail_b->getRandomName();
            $file_detail_b->move('kursus/materi', $gambar_detail_b);
            $detail_data['gambar_detail_b'] = $gambar_detail_b;
        }

        // Handle gambar_detail_c upload
        $file_detail_c = $this->request->getFile('gambar_detail_c');
        if ($file_detail_c && $file_detail_c->isValid()) {
            // Hapus gambar lama
            if (!empty($kursus['gambar_detail_c']) && file_exists('kursus/materi/' . $kursus['gambar_detail_c'])) {
                unlink('kursus/materi/' . $kursus['gambar_detail_c']);
            }
            
            $gambar_detail_c = $file_detail_c->getRandomName();
            $file_detail_c->move('kursus/materi', $gambar_detail_c);
            $detail_data['gambar_detail_c'] = $gambar_detail_c;
        }

        // Update atau insert detail_kursus
        $existing_detail = $this->detailKursusModel->where('id_kursus', $id_kursus)->first();
        if ($existing_detail) {
            $this->detailKursusModel->update($id_kursus, $detail_data);
        } else {
            $detail_data['id_kursus'] = $id_kursus;
            $this->detailKursusModel->insert($detail_data);
        }

        session()->setFlashdata('success', 'Data kursus berhasil diperbarui!');
        return redirect()->to(base_url('home_superadmin/kursus'));
    }

    public function delete_kursus($id_kursus)
    {
        $kursus = $this->kursusModel->find($id_kursus);
        if (!$kursus) {
            session()->setFlashdata('error', 'Data kursus tidak ditemukan!');
            return redirect()->to(base_url('home_superadmin/kursus'));
        }

        // Hapus gambar
        if ($kursus['gambar'] && file_exists('uploads/kursus/' . $kursus['gambar'])) {
            unlink('uploads/kursus/' . $kursus['gambar']);
        }

        $this->kursusModel->delete($id_kursus);
        session()->setFlashdata('success', 'Data kursus berhasil dihapus!');
        return redirect()->to(base_url('home_superadmin/kursus'));
    }

    public function pembayaran()
    {
        $data = [
            'title' => 'Data Pembayaran',
            'title2' => 'Data Pembayaran',
            'pembayaran' => $this->pembayaranModel->getPembayaranAll()
        ];
        return view('backend/karyawan/staf_admin/pembayaran/v_pembayaran', $data);
    }

    public function postingan()
    {
        $data = [
            'title' => 'Postingan',
            'title2' => 'Postingan',
            'postingan' => $this->postinganModel->getPostinganAll()
        ];
        return view('backend/superadmin/postingan/v_postingan_admin', $data);
    }

    public function tambah_postingan()
    {
        $data = [
            'title' => 'Tambah Postingan',
            'title2' => 'Tambah Postingan'
        ];
        return view('backend/superadmin/postingan/v_postingan_create', $data);
    }

    public function save_postingan()
    {
        $rules = [
            'judul' => 'required|min_length[3]|max_length[200]',
            'konten' => 'required|min_length[10]',
            'kategori' => 'required|in_list[Umum,Pengumuman,Berita,Tutorial]',
            'gambar' => 'uploaded[gambar]|max_size[gambar,2048]|ext_in[gambar,jpg,jpeg,png]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', \Config\Services::validation()->getErrors());
        }

        $file = $this->request->getFile('gambar');
        $gambar = $file->getRandomName();
        $file->move('uploads/postingan', $gambar);

        $data = [
            'judul_postingan' => $this->request->getPost('judul'),
            'konten' => $this->request->getPost('konten'),
            'kategori' => $this->request->getPost('kategori'),
            'gambar_postingan' => $gambar,
            'status' => 'published',
            'penulis' => session()->get('nama_lengkap'),
            'created_at' => date('Y-m-d H:i:s'),
        ];

        $this->postinganModel->insert($data);
        session()->setFlashdata('success', 'Postingan berhasil ditambahkan!');
        return redirect()->to(base_url('home_superadmin/postingan'));
    }

    
    public function profil()
    {
        $id_karyawan = session()->get('id_karyawan');
        if (!$id_karyawan) {
            return redirect()->to(base_url('auth_login'));
        }

        $karyawan = $this->karyawanModel->find($id_karyawan);
        if (!$karyawan) {
            session()->setFlashdata('error', 'Data karyawan tidak ditemukan!');
            return redirect()->to(base_url('auth_login'));
        }

        $data = [
            'title' => 'Profil Superadmin',
            'title2' => 'Profil Superadmin',
            'karyawan' => $karyawan
        ];
        return view('backend/superadmin/v_profil', $data);
    }

    public function update_profil()
    {
        $id_karyawan = session()->get('id_karyawan');
        if (!$id_karyawan) {
            return redirect()->to(base_url('auth_login'));
        }

        $karyawan = $this->karyawanModel->find($id_karyawan);
        if (!$karyawan) {
            session()->setFlashdata('error', 'Data karyawan tidak ditemukan!');
            return redirect()->to(base_url('home_superadmin/profil'));
        }

        $rules = [
            'nama_lengkap' => 'required|min_length[3]|max_length[100]',
            'email' => 'required|valid_email|is_unique[karyawan.email,id_karyawan,' . $id_karyawan . ']',
            'no_telepon' => 'required|min_length[10]|max_length[15]',
            'alamat' => 'required|min_length[10]|max_length[255]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', \Config\Services::validation()->getErrors());
        }

        $data = [
            'nama_lengkap' => $this->request->getPost('nama_lengkap'),
            'email' => $this->request->getPost('email'),
            'no_telepon' => $this->request->getPost('no_telepon'),
            'alamat' => $this->request->getPost('alamat'),
        ];

        $password = $this->request->getPost('password');
        if (!empty($password)) {
            $data['password'] = password_hash($password, PASSWORD_DEFAULT);
        }

        $this->karyawanModel->update($id_karyawan, $data);

        session()->set('nama_lengkap', $data['nama_lengkap']);
        session()->set('email', $data['email']);

        return redirect()->to(base_url('home_superadmin/profil'))->with('success', 'Profil berhasil diperbarui!');
    }

    // WEB MANAGEMENT METHODS
    public function web()
    {
        $data = [
            'title' => 'Web Management',
            'title2' => 'Web Management',
            'web' => $this->webModel->get_web()
        ];
        return view('backend/superadmin/web/v_web', $data);
    }

    public function add_web()
    {
        $data = [
            'title' => 'Tambah Web',
            'title2' => 'Tambah Web'
        ];
        return view('backend/superadmin/web/v_add_web', $data);
    }

    public function save_web()
    {
        $rules = [
            'nama_website' => 'required|min_length[3]|max_length[100]',
            'alamat' => 'required|min_length[10]',
            'no_telepon' => 'required|min_length[10]|max_length[15]',
            'email' => 'required|valid_email'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', \Config\Services::validation()->getErrors());
        }

        $data = [
            'nama_website' => $this->request->getPost('nama_website'),
            'alamat' => $this->request->getPost('alamat'),
            'no_telepon' => $this->request->getPost('no_telepon'),
            'email' => $this->request->getPost('email_kontak'),
            'jam_kerja' => $this->request->getPost('jam_kerja'),
            'sejarah' => $this->request->getPost('sejarah_lengkap'),
            'url_yt' => $this->request->getPost('url_yt'),
            'meta_description' => $this->request->getPost('meta_description'),
            'meta_keywords' => $this->request->getPost('meta_keywords')
        ];

        // Handle file uploads
        $logo = $this->request->getFile('logo');
        if ($logo && $logo->isValid() && !$logo->hasMoved()) {
            $logoName = $logo->getRandomName();
            $logo->move('logo', $logoName);
            $data['logo'] = $logoName;
        }

        $banner = $this->request->getFile('banner_utama');
        if ($banner && $banner->isValid() && !$banner->hasMoved()) {
            $bannerName = $banner->getRandomName();
            $banner->move('banner', $bannerName);
            $data['banner_utama'] = $bannerName;
        }

        $this->webModel->add($data);
        session()->setFlashdata('pesan', 'Web berhasil ditambahkan!');
        return redirect()->to(base_url('home_superadmin/web'));
    }

    public function edit_web($id_web)
    {
        $web = $this->webModel->detailWeb($id_web);
        if (!$web) {
            session()->setFlashdata('error', 'Data web tidak ditemukan!');
            return redirect()->to(base_url('home_superadmin/web'));
        }

        $data = [
            'title' => 'Edit Web',
            'title2' => 'Edit Web',
            'web' => $web
        ];
        return view('backend/superadmin/web/v_edit_web', $data);
    }

    public function update_web($id_web)
    {
        $web = $this->webModel->detailWeb($id_web);
        if (!$web) {
            session()->setFlashdata('error', 'Data web tidak ditemukan!');
            return redirect()->to(base_url('home_superadmin/web'));
        }

        $rules = [
            'nama_website' => 'required|min_length[3]|max_length[100]',
            'alamat' => 'required|min_length[10]',
            'no_telepon' => 'required|min_length[10]|max_length[15]',
            'email' => 'required|valid_email'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', \Config\Services::validation()->getErrors());
        }

        $data = [
            'id_setting' => $id_web,
            'nama_website' => $this->request->getPost('nama_website'),
            'alamat' => $this->request->getPost('alamat'),
            'no_telepon' => $this->request->getPost('no_telepon'),
            'email' => $this->request->getPost('email_kontak'),
            'jam_kerja' => $this->request->getPost('jam_kerja'),
            'sejarah' => $this->request->getPost('sejarah_lengkap'),
            'url_yt' => $this->request->getPost('url_yt'),
            'meta_description' => $this->request->getPost('meta_description'),
            'meta_keywords' => $this->request->getPost('meta_keywords'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        // Handle file uploads
        $logo = $this->request->getFile('logo');
        if ($logo && $logo->isValid() && !$logo->hasMoved()) {
            // Delete old logo if exists
            if (!empty($web['logo']) && file_exists('logo/' . $web['logo'])) {
                unlink('logo/' . $web['logo']);
            }
            $logoName = $logo->getRandomName();
            $logo->move('logo', $logoName);
            $data['logo'] = $logoName;
        }

        $banner = $this->request->getFile('banner_utama');
        if ($banner && $banner->isValid() && !$banner->hasMoved()) {
            // Delete old banner if exists
            if (!empty($web['banner_utama']) && file_exists('banner/' . $web['banner_utama'])) {
                unlink('banner/' . $web['banner_utama']);
            }
            $bannerName = $banner->getRandomName();
            $banner->move('banner', $bannerName);
            $data['banner_utama'] = $bannerName;
        }

        $this->webModel->edit($data);
        session()->setFlashdata('pesan', 'Web berhasil diperbarui!');
        return redirect()->to(base_url('home_superadmin/web'));
    }

    public function deleted_web($id_web)
    {
        $web = $this->webModel->detailWeb($id_web);
        if (!$web) {
            session()->setFlashdata('error', 'Data web tidak ditemukan!');
            return redirect()->to(base_url('home_superadmin/web'));
        }

        // Delete associated files if they exist
        if (!empty($web['logo']) && file_exists('logo/' . $web['logo'])) {
            unlink('logo/' . $web['logo']);
        }
        
        if (!empty($web['banner_utama']) && file_exists('banner/' . $web['banner_utama'])) {
            unlink('banner/' . $web['banner_utama']);
        }

        $this->webModel->deleted_data(['id_setting' => $id_web]);
        session()->setFlashdata('pesan', 'Web berhasil dihapus!');
        return redirect()->to(base_url('home_superadmin/web'));
    }

    // BACKUP METHODS
    public function backup_db()
    {
        $data = [
            'title' => 'Backup Database',
            'title2' => 'Backup Database',
            'backups' => $this->getBackupFiles()
        ];
        return view('backend/superadmin/backup/v_backup', $data);
    }

    public function proses_db()
    {
        try {
            // Debug: Log attempt
            log_message('info', 'Backup process started at ' . date('Y-m-d H:i:s'));
            
            // Load database utility
            $db = \Config\Database::connect();
            
            if (!$db) {
                throw new \Exception('Database connection failed');
            }
            
            log_message('info', 'Database connected successfully: ' . $db->database);
            
            // Create backup filename with timestamp
            $filename = 'backup_' . date('Y-m-d_H-i-s') . '.sql';
            $backupPath = WRITEPATH . 'backups/' . $filename;
            
            log_message('info', 'Backup path: ' . $backupPath);
            
            // Ensure backup directory exists
            if (!is_dir(WRITEPATH . 'backups')) {
                mkdir(WRITEPATH . 'backups', 0755, true);
                log_message('info', 'Created backup directory');
            }
            
            // Get all tables
            $tables = $db->listTables();
            log_message('info', 'Found ' . count($tables) . ' tables');
            
            // Create backup content
            $backupContent = "-- Database Backup\n";
            $backupContent .= "-- Generated: " . date('Y-m-d H:i:s') . "\n";
            $backupContent .= "-- Database: " . $db->database . "\n\n";
            
            foreach ($tables as $table) {
                $backupContent .= "-- Table structure for `{$table}`\n";
                $backupContent .= "DROP TABLE IF EXISTS `{$table}`;\n";
                
                // Get table structure
                $structure = $db->query("SHOW COLUMNS FROM `{$table}`");
                $fields = [];
                foreach ($structure->getResultArray() as $field) {
                    $fields[] = "`{$field['Field']}` {$field['Type']} " . 
                               ($field['Null'] == 'NO' ? 'NOT NULL' : 'NULL') . 
                               ($field['Default'] !== null ? " DEFAULT {$field['Default']}" : '');
                }
                
                $backupContent .= "CREATE TABLE `{$table}` (" . implode(', ', $fields) . ");\n\n";
                
                // Get table data
                $data = $db->table($table)->get()->getResultArray();
                if (!empty($data)) {
                    foreach ($data as $row) {
                        $values = [];
                        foreach ($row as $value) {
                            $values[] = $value === null ? 'NULL' : "'" . addslashes($value) . "'";
                        }
                        $backupContent .= "INSERT INTO `{$table}` VALUES (" . implode(', ', $values) . ");\n";
                    }
                    $backupContent .= "\n";
                }
            }
            
            // Write backup to file
            $result = file_put_contents($backupPath, $backupContent);
            if ($result) {
                log_message('info', 'Backup file created successfully: ' . $filename);
                session()->setFlashdata('pesan', 'Database berhasil di-backup! File: ' . $filename);
            } else {
                throw new \Exception('Gagal menyimpan file backup!');
            }
            
        } catch (\Exception $e) {
            log_message('error', 'Backup failed: ' . $e->getMessage());
            session()->setFlashdata('error', 'Backup gagal: ' . $e->getMessage());
        }
        
        return redirect()->to(base_url('home_superadmin/backup_db'));
    }

    public function download_backup($filename)
    {
        $file_path = WRITEPATH . 'backups/' . $filename;
        if (file_exists($file_path)) {
            return $this->response->download($file_path, null);
        } else {
            session()->setFlashdata('error', 'File backup tidak ditemukan!');
            return redirect()->back();
        }
    }

    public function deleted_backup($filename)
    {
        $file_path = WRITEPATH . 'backups/' . $filename;
        if (file_exists($file_path)) {
            unlink($file_path);
            session()->setFlashdata('pesan', 'File backup berhasil dihapus!');
        } else {
            session()->setFlashdata('error', 'File backup tidak ditemukan!');
        }
        return redirect()->to(base_url('home_superadmin/backup_db'));
    }

    // PROGRAM METHODS
    public function program()
    {
        $data = [
            'title' => 'Data Program',
            'title2' => 'Data Program',
            'program' => $this->programModel->findAll()
        ];
        return view('backend/superadmin/program/v_program', $data);
    }

    public function add_program()
    {
        $data = [
            'title' => 'Tambah Program',
            'title2' => 'Tambah Program'
        ];
        return view('backend/superadmin/program/v_add_program', $data);
    }

    public function save_program()
    {
        $rules = [
            'nama_program' => 'required',
            'deskripsi' => 'required'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', \Config\Services::validation()->getErrors());
        }

        $data = [
            'nama_program' => $this->request->getPost('nama_program'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'status' => 'aktif'
        ];

        $this->programModel->insert($data);
        session()->setFlashdata('pesan', 'Program berhasil ditambahkan!');
        return redirect()->to(base_url('home_superadmin/program'));
    }

    public function edit_program($id_program)
    {
        $program = $this->programModel->find($id_program);
        if (!$program) {
            session()->setFlashdata('error', 'Data program tidak ditemukan!');
            return redirect()->to(base_url('home_superadmin/program'));
        }

        $data = [
            'title' => 'Edit Program',
            'title2' => 'Edit Program',
            'program' => $program
        ];
        return view('backend/superadmin/program/v_edit_program', $data);
    }

    public function update_program($id_program)
    {
        $program = $this->programModel->find($id_program);
        if (!$program) {
            session()->setFlashdata('error', 'Data program tidak ditemukan!');
            return redirect()->to(base_url('home_superadmin/program'));
        }

        $data = [
            'nama_program' => $this->request->getPost('nama_program'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'status' => $this->request->getPost('status')
        ];

        $this->programModel->update($id_program, $data);
        session()->setFlashdata('pesan', 'Program berhasil diperbarui!');
        return redirect()->to(base_url('home_superadmin/program'));
    }

    public function deleted_program($id_program)
    {
        $program = $this->programModel->find($id_program);
        if (!$program) {
            session()->setFlashdata('error', 'Data program tidak ditemukan!');
            return redirect()->to(base_url('home_superadmin/program'));
        }

        $this->programModel->delete($id_program);
        session()->setFlashdata('pesan', 'Program berhasil dihapus!');
        return redirect()->to(base_url('home_superadmin/program'));
    }

        public function deleted_kursus($id_kursus)
    {
        $kursus = $this->kursusModel->find($id_kursus);
        if (!$kursus) {
            session()->setFlashdata('error', 'Data kursus tidak ditemukan!');
            return redirect()->to(base_url('home_superadmin/kursus'));
        }

        $this->kursusModel->delete($id_kursus);
        session()->setFlashdata('pesan', 'Kursus berhasil dihapus!');
        return redirect()->to(base_url('home_superadmin/kursus'));
    }

    public function restore_kursus($id_kursus)
    {
        $kursus = $this->kursusModel->withDeleted()->find($id_kursus);
        if (!$kursus) {
            session()->setFlashdata('error', 'Data kursus tidak ditemukan!');
            return redirect()->to(base_url('home_superadmin/kursus_deleted'));
        }

        $this->kursusModel->restore($id_kursus);
        session()->setFlashdata('pesan', 'Kursus berhasil dipulihkan!');
        return redirect()->to(base_url('home_superadmin/kursus_deleted'));
    }

    public function force_delete_kursus($id_kursus)
    {
        $kursus = $this->kursusModel->withDeleted()->find($id_kursus);
        if (!$kursus) {
            session()->setFlashdata('error', 'Data kursus tidak ditemukan!');
            return redirect()->to(base_url('home_superadmin/kursus_deleted'));
        }

        $this->kursusModel->purgeDeleted($id_kursus);
        session()->setFlashdata('pesan', 'Kursus berhasil dihapus permanen!');
        return redirect()->to(base_url('home_superadmin/kursus_deleted'));
    }

    public function kursus_deleted()
    {
        $data = [
            'title' => 'Kursus Dihapus',
            'title2' => 'Kursus Dihapus',
            'kursus' => $this->kursusModel->onlyDeleted()->findAll()
        ];
        return view('backend/superadmin/kursus/v_kursus_deleted', $data);
    }

    // MODUL METHODS
    public function modul($id_kursus)
    {
        // Get modules with material count
        $moduls = $this->modulModel->where('id_kursus', $id_kursus)->findAll();
        
        // Add material count to each module
        foreach ($moduls as &$module) {
            $material_count = $this->materiModel->where('id_modul', $module['id_modul'])->countAllResults();
            $module['jumlah_materi'] = $material_count;
        }
        
        $data = [
            'title' => 'Data Modul',
            'title2' => 'Data Modul',
            'modul' => $moduls,
            'kursus' => $this->kursusModel->find($id_kursus)
        ];
        return view('backend/superadmin/kursus/modul/v_modul', $data);
    }

    public function add_modul($id_kursus = null)
    {
        // Get all kursus for dropdown
        $kursus_list = $this->kursusModel->where('status', 'aktif')->findAll();
        
        $data = [
            'title' => 'Tambah Modul',
            'title2' => 'Tambah Modul',
            'kursus_list' => $kursus_list,
            'selected_kursus' => $id_kursus
        ];
        return view('backend/superadmin/kursus/modul/v_add', $data);
    }

    public function save_modul()
    {
        $rules = [
            'id_kursus' => 'required',
            'nama_modul' => 'required',
            'deskripsi' => 'required'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', \Config\Services::validation()->getErrors());
        }

        $data = [
            'id_kursus' => $this->request->getPost('id_kursus'),
            'nama_modul' => $this->request->getPost('nama_modul'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'status' => 'aktif'
        ];

        $this->modulModel->insert($data);
        session()->setFlashdata('pesan', 'Modul berhasil ditambahkan!');
        return redirect()->to(base_url('home_superadmin/modul/' . $this->request->getPost('id_kursus')));
    }

    public function edit_modul($id_modul)
    {
        $modul = $this->modulModel->find($id_modul);
        if (!$modul) {
            session()->setFlashdata('error', 'Data modul tidak ditemukan!');
            return redirect()->back();
        }

        // Get kursus data for display
        $kursus = $this->kursusModel->find($modul['id_kursus']);

        $data = [
            'title' => 'Edit Modul',
            'title2' => 'Edit Modul',
            'modul' => $modul,
            'kursus' => $kursus
        ];
        return view('backend/superadmin/kursus/modul/v_edit', $data);
    }

    public function update_modul($id_modul)
    {
        $modul = $this->modulModel->find($id_modul);
        if (!$modul) {
            session()->setFlashdata('error', 'Data modul tidak ditemukan!');
            return redirect()->back();
        }

        $data = [
            'nama_modul' => $this->request->getPost('nama_modul'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'status' => $this->request->getPost('status')
        ];

        $this->modulModel->update($id_modul, $data);
        session()->setFlashdata('pesan', 'Modul berhasil diperbarui!');
        return redirect()->to(base_url('home_superadmin/modul/' . $modul['id_kursus']));
    }

    public function delete_modul($id_modul)
    {
        $modul = $this->modulModel->find($id_modul);
        if (!$modul) {
            session()->setFlashdata('error', 'Data modul tidak ditemukan!');
            return redirect()->back();
        }

        $this->modulModel->delete($id_modul);
        session()->setFlashdata('pesan', 'Modul berhasil dihapus!');
        return redirect()->to(base_url('home_superadmin/modul/' . $modul['id_kursus']));
    }

    // MATERI METHODS
    public function materi($id_modul)
    {
        $modul = $this->modulModel->find($id_modul);
        $kursus = null;
        
        if ($modul) {
            $kursus = $this->kursusModel->find($modul['id_kursus']);
        }

        $data = [
            'title' => 'Data Materi',
            'title2' => 'Data Materi',
            'materi' => $this->materiModel->getByModul($id_modul),
            'modul' => $modul,
            'kursus' => $kursus
        ];
        return view('backend/superadmin/kursus/materi/v_materi', $data);
    }

    public function add_materi($id_modul = null)
    {
        // Get all kursus for dropdown
        $kursus_list = $this->kursusModel->where('status', 'aktif')->findAll();
        
        // Get all modul for dropdown
        $modul_list = $this->modulModel->findAll();
        
        // Get selected modul and kursus info
        $selected_kursus = null;
        if ($id_modul) {
            $modul = $this->modulModel->find($id_modul);
            if ($modul) {
                $selected_kursus = $modul['id_kursus'];
            }
        }
        
        $data = [
            'title' => 'Tambah Materi',
            'title2' => 'Tambah Materi',
            'kursus_list' => $kursus_list,
            'modul_list' => $modul_list,
            'selected_modul' => $id_modul,
            'selected_kursus' => $selected_kursus
        ];
        return view('backend/superadmin/kursus/materi/v_add', $data);
    }

    public function save_materi()
    {
        $rules = [
            'id_modul' => 'required',
            'judul_materi' => 'required',
            'tipe_materi' => 'required',
            'deskripsi_materi' => 'required'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', \Config\Services::validation()->getErrors());
        }

        $data = [
            'id_modul' => $this->request->getPost('id_modul'),
            'id_kursus' => $this->request->getPost('id_kursus'),
            'judul_materi' => $this->request->getPost('judul_materi'),
            'tipe_materi' => $this->request->getPost('tipe_materi'),
            'url_youtube' => $this->request->getPost('url_youtube'),
            'konten_text' => $this->request->getPost('konten_text'),
            'deskripsi_materi' => $this->request->getPost('deskripsi_materi'),
            'status' => 'aktif'
        ];

        $this->materiModel->insert($data);
        session()->setFlashdata('pesan', 'Materi berhasil ditambahkan!');
        return redirect()->to(base_url('home_superadmin/materi/' . $this->request->getPost('id_modul')));
    }

    public function edit_materi($id_materi)
    {
        $materi = $this->materiModel->find($id_materi);
        if (!$materi) {
            session()->setFlashdata('error', 'Data materi tidak ditemukan!');
            return redirect()->back();
        }

        // Get modul and kursus data for display
        $modul = $this->modulModel->find($materi['id_modul']);
        $kursus = null;
        
        if ($modul) {
            $kursus = $this->kursusModel->find($modul['id_kursus']);
        }

        $data = [
            'title' => 'Edit Materi',
            'title2' => 'Edit Materi',
            'materi' => $materi,
            'modul' => $modul,
            'kursus' => $kursus
        ];
        return view('backend/superadmin/kursus/materi/v_edit', $data);
    }

    public function update_materi($id_materi)
    {
        $materi = $this->materiModel->find($id_materi);
        if (!$materi) {
            session()->setFlashdata('error', 'Data materi tidak ditemukan!');
            return redirect()->back();
        }

        $data = [
            'judul_materi' => $this->request->getPost('judul_materi'),
            'konten' => $this->request->getPost('konten'),
            'status' => $this->request->getPost('status')
        ];

        $this->materiModel->update($id_materi, $data);
        session()->setFlashdata('pesan', 'Materi berhasil diperbarui!');
        return redirect()->to(base_url('home_superadmin/materi/' . $materi['id_modul']));
    }

    public function delete_materi($id_materi)
    {
        $materi = $this->materiModel->find($id_materi);
        if (!$materi) {
            session()->setFlashdata('error', 'Data materi tidak ditemukan!');
            return redirect()->back();
        }

        $this->materiModel->delete($id_materi);
        session()->setFlashdata('pesan', 'Materi berhasil dihapus!');
        return redirect()->to(base_url('home_superadmin/materi/' . $materi['id_modul']));
    }

    // PAKET KURSUS METHODS
    public function paket_kursus()
    {
        $data = [
            'title' => 'Paket Kursus',
            'title2' => 'Paket Kursus',
            'paket' => $this->paketModel->getPaketWithKursus()
        ];
        return view('backend/superadmin/paket_kursus/v_paket', $data);
    }

    public function add_paket()
    {
        $data = [
            'title' => 'Tambah Paket',
            'title2' => 'Tambah Paket',
            'kursus' => $this->kursusModel->findAll()
        ];
        return view('backend/superadmin/paket/v_add_paket', $data);
    }

    public function save_paket()
    {
        $rules = [
            'nama_paket' => 'required',
            'harga' => 'required|numeric',
            'deskripsi' => 'required'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', \Config\Services::validation()->getErrors());
        }

        $data = [
            'nama_paket' => $this->request->getPost('nama_paket'),
            'harga' => $this->request->getPost('harga'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'status' => 'aktif'
        ];

        $this->paketModel->insert($data);
        session()->setFlashdata('pesan', 'Paket berhasil ditambahkan!');
        return redirect()->to(base_url('home_superadmin/paket_kursus'));
    }

    public function edit_paket($id_paket)
    {
        $paket = $this->paketModel->find($id_paket);
        if (!$paket) {
            session()->setFlashdata('error', 'Data paket tidak ditemukan!');
            return redirect()->to(base_url('home_superadmin/paket_kursus'));
        }

        $data = [
            'title' => 'Edit Paket',
            'title2' => 'Edit Paket',
            'paket' => $paket,
            'kursus' => $this->kursusModel->findAll()
        ];
        return view('backend/superadmin/paket/v_edit_paket', $data);
    }

    public function update_paket($id_paket)
    {
        $paket = $this->paketModel->find($id_paket);
        if (!$paket) {
            session()->setFlashdata('error', 'Data paket tidak ditemukan!');
            return redirect()->to(base_url('home_superadmin/paket_kursus'));
        }

        $data = [
            'nama_paket' => $this->request->getPost('nama_paket'),
            'harga' => $this->request->getPost('harga'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'status' => $this->request->getPost('status')
        ];

        $this->paketModel->update($id_paket, $data);
        session()->setFlashdata('pesan', 'Paket berhasil diperbarui!');
        return redirect()->to(base_url('home_superadmin/paket_kursus'));
    }

    public function delete_paket($id_paket)
    {
        $paket = $this->paketModel->find($id_paket);
        if (!$paket) {
            session()->setFlashdata('error', 'Data paket tidak ditemukan!');
            return redirect()->to(base_url('home_superadmin/paket_kursus'));
        }

        $this->paketModel->softDelete($id_paket);
        session()->setFlashdata('pesan', 'Paket berhasil dihapus!');
        return redirect()->to(base_url('home_superadmin/paket_kursus'));
    }

    public function restore_paket($id_paket)
    {
        $paket = $this->paketModel->withDeleted()->find($id_paket);
        if (!$paket) {
            session()->setFlashdata('error', 'Data paket tidak ditemukan!');
            return redirect()->to(base_url('home_superadmin/paket_kursus_deleted'));
        }

        $this->paketModel->restore($id_paket);
        session()->setFlashdata('pesan', 'Paket berhasil dipulihkan!');
        return redirect()->to(base_url('home_superadmin/paket_kursus_deleted'));
    }

    public function force_delete_paket($id_paket)
    {
        $paket = $this->paketModel->withDeleted()->find($id_paket);
        if (!$paket) {
            session()->setFlashdata('error', 'Data paket tidak ditemukan!');
            return redirect()->to(base_url('home_superadmin/paket_kursus_deleted'));
        }

        $this->paketModel->delete($id_paket, true);
        session()->setFlashdata('pesan', 'Paket berhasil dihapus permanen!');
        return redirect()->to(base_url('home_superadmin/paket_kursus_deleted'));
    }

    public function paket_kursus_deleted()
    {
        $data = [
            'title' => 'Paket Kursus Dihapus',
            'title2' => 'Paket Kursus Dihapus',
            'paket' => $this->paketModel->onlyDeleted()->findAll()
        ];
        return view('backend/superadmin/paket_kursus/v_paket_deleted', $data);
    }

    // POSTINGAN ADMIN METHODS
    public function postingan_admin()
    {
        // Get status filter from GET parameter
        $status = $this->request->getGet('status');
        
        // Build query based on status filter
        $postinganQuery = $this->postinganModel;
        if ($status && in_array($status, ['draft', 'published', 'archived'])) {
            $postinganQuery = $postinganQuery->where('status', $status);
        }
        
        $data = [
            'title' => 'Postingan Admin',
            'title2' => 'Postingan Admin',
            'postingan' => $postinganQuery->orderBy('created_at', 'DESC')->findAll(),
            'status' => $status // Pass status to view for filter persistence
        ];
        return view('backend/superadmin/postingan/v_postingan_admin', $data);
    }

    public function postingan_create()
    {
        // Define categories
        $categories = [
            'Umum' => 'Umum',
            'Pengumuman' => 'Pengumuman',
            'Berita' => 'Berita',
            'Tutorial' => 'Tutorial'
        ];

        $data = [
            'title' => 'Buat Postingan',
            'title2' => 'Buat Postingan',
            'categories' => $categories
        ];
        return view('backend/superadmin/postingan/v_postingan_create', $data);
    }

    public function postingan_save()
    {
        $rules = [
            'judul_postingan' => 'required',
            'konten' => 'required',
            'kategori' => 'required'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', \Config\Services::validation()->getErrors());
        }

        // Handle image upload
        $gambar = '';
        $file = $this->request->getFile('gambar_postingan');
        if ($file && $file->isValid()) {
            $gambar = $file->getRandomName();
            $file->move('uploads/postingan', $gambar);
        }

        $data = [
            'judul_postingan' => $this->request->getPost('judul_postingan'),
            'slug' => $this->request->getPost('slug'),
            'konten' => $this->request->getPost('konten'),
            'excerpt' => $this->request->getPost('excerpt'),
            'kategori' => $this->request->getPost('kategori'),
            'penulis' => $this->request->getPost('penulis'),
            'status' => $this->request->getPost('status') ?: 'published',
            'meta_description' => $this->request->getPost('meta_description'),
            'meta_keywords' => $this->request->getPost('meta_keywords'),
            'gambar_postingan' => $gambar,
            'created_at' => date('Y-m-d H:i:s')
        ];

        $this->postinganModel->insert($data);
        session()->setFlashdata('pesan', 'Postingan berhasil dibuat!');
        return redirect()->to(base_url('home_superadmin/postingan_admin'));
    }

    public function postingan_edit($id_postingan)
    {
        $postingan = $this->postinganModel->find($id_postingan);
        if (!$postingan) {
            session()->setFlashdata('error', 'Data postingan tidak ditemukan!');
            return redirect()->to(base_url('home_superadmin/postingan_admin'));
        }

        // Define categories
        $categories = [
            'Umum' => 'Umum',
            'Pengumuman' => 'Pengumuman',
            'Berita' => 'Berita',
            'Tutorial' => 'Tutorial'
        ];

        $data = [
            'title' => 'Edit Postingan',
            'title2' => 'Edit Postingan',
            'postingan' => $postingan,
            'categories' => $categories
        ];
        return view('backend/superadmin/postingan/v_postingan_edit', $data);
    }

    public function postingan_update($id_postingan)
    {
        $postingan = $this->postinganModel->find($id_postingan);
        if (!$postingan) {
            session()->setFlashdata('error', 'Data postingan tidak ditemukan!');
            return redirect()->to(base_url('home_superadmin/postingan_admin'));
        }

        $rules = [
            'judul_postingan' => 'required',
            'konten' => 'required',
            'kategori' => 'required'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', \Config\Services::validation()->getErrors());
        }

        $data = [
            'judul_postingan' => $this->request->getPost('judul_postingan'),
            'slug' => $this->request->getPost('slug'),
            'konten' => $this->request->getPost('konten'),
            'excerpt' => $this->request->getPost('excerpt'),
            'kategori' => $this->request->getPost('kategori'),
            'penulis' => $this->request->getPost('penulis'),
            'status' => $this->request->getPost('status'),
            'meta_description' => $this->request->getPost('meta_description'),
            'meta_keywords' => $this->request->getPost('meta_keywords')
        ];

        // Handle image upload
        $file = $this->request->getFile('gambar_postingan');
        if ($file && $file->isValid()) {
            // Delete old image if exists
            if (!empty($postingan['gambar_postingan']) && file_exists('uploads/postingan/' . $postingan['gambar_postingan'])) {
                unlink('uploads/postingan/' . $postingan['gambar_postingan']);
            }
            
            $gambar = $file->getRandomName();
            $file->move('uploads/postingan', $gambar);
            $data['gambar_postingan'] = $gambar;
        }

        // Handle image removal
        if ($this->request->getPost('remove_current_image') == '1') {
            if (!empty($postingan['gambar_postingan']) && file_exists('uploads/postingan/' . $postingan['gambar_postingan'])) {
                unlink('uploads/postingan/' . $postingan['gambar_postingan']);
            }
            $data['gambar_postingan'] = null;
        }

        $this->postinganModel->update($id_postingan, $data);
        session()->setFlashdata('pesan', 'Postingan berhasil diperbarui!');
        return redirect()->to(base_url('home_superadmin/postingan_admin'));
    }

    public function postingan_delete($id_postingan)
    {
        $postingan = $this->postinganModel->find($id_postingan);
        if (!$postingan) {
            session()->setFlashdata('error', 'Data postingan tidak ditemukan!');
            return redirect()->to(base_url('home_superadmin/postingan_admin'));
        }

        // Delete image if exists
        if (!empty($postingan['gambar_postingan']) && file_exists('uploads/postingan/' . $postingan['gambar_postingan'])) {
            unlink('uploads/postingan/' . $postingan['gambar_postingan']);
        }

        $this->postinganModel->delete($id_postingan);
        session()->setFlashdata('pesan', 'Postingan berhasil dihapus!');
        return redirect()->to(base_url('home_superadmin/postingan_admin'));
    }

    public function postingan_restore($id_postingan)
    {
        $postingan = $this->postinganModel->withDeleted()->find($id_postingan);
        if (!$postingan) {
            session()->setFlashdata('error', 'Data postingan tidak ditemukan!');
            return redirect()->to(base_url('home_superadmin/postingan_deleted'));
        }

        $this->postinganModel->restore($id_postingan);
        session()->setFlashdata('pesan', 'Postingan berhasil dipulihkan!');
        return redirect()->to(base_url('home_superadmin/postingan_deleted'));
    }

    public function postingan_permanent_delete($id_postingan)
    {
        $postingan = $this->postinganModel->withDeleted()->find($id_postingan);
        if (!$postingan) {
            session()->setFlashdata('error', 'Data postingan tidak ditemukan!');
            return redirect()->to(base_url('home_superadmin/postingan_deleted'));
        }

        $this->postinganModel->purgeDeleted($id_postingan);
        session()->setFlashdata('pesan', 'Postingan berhasil dihapus permanen!');
        return redirect()->to(base_url('home_superadmin/postingan_deleted'));
    }

    public function postingan_deleted()
    {
        $data = [
            'title' => 'Postingan Dihapus',
            'title2' => 'Postingan Dihapus',
            'postingan' => $this->postinganModel->onlyDeleted()->findAll()
        ];
        return view('backend/superadmin/postingan/v_postingan_deleted', $data);
    }

    // KARYAWAN DELETED MANAGEMENT
    public function deleted_karyawan($id_karyawan)
    {
        $karyawan = $this->karyawanModel->find($id_karyawan);
        if (!$karyawan) {
            session()->setFlashdata('error', 'Data karyawan tidak ditemukan!');
            return redirect()->to(base_url('home_superadmin/karyawan'));
        }

        $this->karyawanModel->delete($id_karyawan);
        session()->setFlashdata('pesan', 'Karyawan berhasil dihapus!');
        return redirect()->to(base_url('home_superadmin/karyawan'));
    }

    public function restore_karyawan($id_karyawan)
    {
        $karyawan = $this->karyawanModel->withDeleted()->find($id_karyawan);
        if (!$karyawan) {
            session()->setFlashdata('error', 'Data karyawan tidak ditemukan!');
            return redirect()->to(base_url('home_superadmin/karyawan_deleted'));
        }

        $this->karyawanModel->restore($id_karyawan);
        session()->setFlashdata('pesan', 'Karyawan berhasil dipulihkan!');
        return redirect()->to(base_url('home_superadmin/karyawan_deleted'));
    }

    public function force_delete_karyawan($id_karyawan)
    {
        $karyawan = $this->karyawanModel->withDeleted()->find($id_karyawan);
        if (!$karyawan) {
            session()->setFlashdata('error', 'Data karyawan tidak ditemukan!');
            return redirect()->to(base_url('home_superadmin/karyawan_deleted'));
        }

        $this->karyawanModel->purgeDeleted($id_karyawan);
        session()->setFlashdata('pesan', 'Karyawan berhasil dihapus permanen!');
        return redirect()->to(base_url('home_superadmin/karyawan_deleted'));
    }

    public function karyawan_deleted()
    {
        $data = [
            'title' => 'Karyawan Dihapus',
            'title2' => 'Karyawan Dihapus',
            'karyawan' => $this->karyawanModel->onlyDeleted()->findAll()
        ];
        return view('backend/superadmin/karyawan/v_karyawan_deleted', $data);
    }

    // SLIDER PROMO METHODS
    public function slider_promo()
    {
        $data = [
            'title' => 'Slider Promo',
            'title2' => 'Slider Promo',
            'slider' => $this->sliderModel->orderBy('urutan', 'ASC')->findAll()
        ];
        return view('backend/superadmin/slider_promo/v_slider_promo', $data);
    }

    public function add_slider_promo()
    {
        $data = [
            'title' => 'Tambah Slider Promo',
            'title2' => 'Tambah Slider Promo'
        ];
        return view('backend/superadmin/slider_promo/v_add_slider_promo', $data);
    }

    public function save_slider_promo()
    {
        $rules = [
            'judul_slider' => 'required',
            'deskripsi' => 'required',
            'gambar_slider' => 'uploaded[gambar_slider]|max_size[gambar_slider,2048]|is_image[gambar_slider]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', \Config\Services::validation()->getErrors());
        }

        $gambar = $this->request->getFile('gambar_slider');
        $namaGambar = $gambar->getRandomName();
        $gambar->move('uploads/slider_promo', $namaGambar);

        $data = [
            'judul_slider' => $this->request->getPost('judul_slider'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'gambar_slider' => $namaGambar,
            'status' => 'aktif',
            'urutan' => $this->sliderModel->countAll() + 1
        ];

        $this->sliderModel->insert($data);
        session()->setFlashdata('pesan', 'Slider promo berhasil ditambahkan!');
        return redirect()->to(base_url('home_superadmin/slider_promo'));
    }

    public function edit_slider_promo($id_slider)
    {
        $slider = $this->sliderModel->find($id_slider);
        if (!$slider) {
            session()->setFlashdata('error', 'Data slider promo tidak ditemukan!');
            return redirect()->to(base_url('home_superadmin/slider_promo'));
        }

        $data = [
            'title' => 'Edit Slider Promo',
            'title2' => 'Edit Slider Promo',
            'slider' => $slider
        ];
        return view('backend/superadmin/slider_promo/v_edit_slider_promo', $data);
    }

    public function update_slider_promo($id_slider)
    {
        $slider = $this->sliderModel->find($id_slider);
        if (!$slider) {
            session()->setFlashdata('error', 'Data slider promo tidak ditemukan!');
            return redirect()->to(base_url('home_superadmin/slider_promo'));
        }

        $data = [
            'judul_slider' => $this->request->getPost('judul_slider'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'link_url' => $this->request->getPost('link_url'),
            'urutan' => $this->request->getPost('urutan'),
            'status' => $this->request->getPost('status')
        ];

        $gambar = $this->request->getFile('gambar_slider');
        if ($gambar && $gambar->isValid()) {
            // Hapus gambar lama jika ada
            if (!empty($slider['gambar_slider']) && file_exists('uploads/slider_promo/' . $slider['gambar_slider'])) {
                unlink('uploads/slider_promo/' . $slider['gambar_slider']);
            }
            
            $namaGambar = $gambar->getRandomName();
            $gambar->move('uploads/slider_promo', $namaGambar);
            $data['gambar_slider'] = $namaGambar;
        }

        $this->sliderModel->update($id_slider, $data);
        session()->setFlashdata('pesan', 'Slider promo berhasil diperbarui!');
        return redirect()->to(base_url('home_superadmin/slider_promo'));
    }

    public function deleted_slider_promo($id_slider)
    {
        $slider = $this->sliderModel->find($id_slider);
        if (!$slider) {
            session()->setFlashdata('error', 'Data slider promo tidak ditemukan!');
            return redirect()->to(base_url('home_superadmin/slider_promo'));
        }

        // Hapus gambar
        if (!empty($slider['gambar_slider']) && file_exists('uploads/slider_promo/' . $slider['gambar_slider'])) {
            unlink('uploads/slider_promo/' . $slider['gambar_slider']);
        }

        $this->sliderModel->delete($id_slider);
        session()->setFlashdata('pesan', 'Slider promo berhasil dihapus!');
        return redirect()->to(base_url('home_superadmin/slider_promo'));
    }

    public function update_order_slider_promo()
    {
        $id_slider = $this->request->getPost('id_slider');
        $urutan = $this->request->getPost('urutan');
        
        if ($id_slider && $urutan !== null) {
            $this->sliderModel->update($id_slider, ['urutan' => $urutan]);
            return $this->response->setJSON(['status' => 'success', 'message' => 'Urutan slider promo berhasil diperbarui']);
        }
        
        return $this->response->setJSON(['status' => 'error', 'message' => 'Data tidak lengkap']);
    }

    public function toggle_status_slider_promo($id_slider)
    {
        $slider = $this->sliderModel->find($id_slider);
        if (!$slider) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Slider promo tidak ditemukan']);
        }

        $newStatus = $slider['status'] == 'aktif' ? 'nonaktif' : 'aktif';
        $this->sliderModel->update($id_slider, ['status' => $newStatus]);

        return $this->response->setJSON([
            'status' => 'success', 
            'message' => 'Status slider promo berhasil diubah',
            'new_status' => $newStatus
        ]);
    }

    // SLIDER WEB METHODS
    public function slider_web()
    {
        $data = [
            'title' => 'Slider Web',
            'title2' => 'Slider Web',
            'slider' => $this->sliderWebModel->orderBy('urutan', 'ASC')->findAll()
        ];
        return view('backend/superadmin/slider_web/v_slider_web', $data);
    }

    public function add_slider_web()
    {
        $data = [
            'title' => 'Tambah Slider Web',
            'title2' => 'Tambah Slider Web'
        ];
        return view('backend/superadmin/slider_web/v_add_slider_web', $data);
    }

    public function save_slider_web()
    {
        $rules = [
            'judul_slider' => 'required',
            'deskripsi' => 'required',
            'gambar_slider' => 'uploaded[gambar_slider]|max_size[gambar_slider,2048]|is_image[gambar_slider]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', \Config\Services::validation()->getErrors());
        }

        $gambar = $this->request->getFile('gambar_slider');
        $namaGambar = $gambar->getRandomName();
        $gambar->move('uploads/slider_web', $namaGambar);

        $data = [
            'judul_slider' => $this->request->getPost('judul_slider'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'gambar_slider' => $namaGambar,
            'status' => 'aktif',
            'urutan' => $this->sliderWebModel->countAll() + 1
        ];

        $this->sliderWebModel->insert($data);
        session()->setFlashdata('pesan', 'Slider web berhasil ditambahkan!');
        return redirect()->to(base_url('home_superadmin/slider_web'));
    }

    public function edit_slider_web($id_slider)
    {
        $slider = $this->sliderWebModel->find($id_slider);
        if (!$slider) {
            session()->setFlashdata('error', 'Data slider web tidak ditemukan!');
            return redirect()->to(base_url('home_superadmin/slider_web'));
        }

        $data = [
            'title' => 'Edit Slider Web',
            'title2' => 'Edit Slider Web',
            'slider' => $slider
        ];
        return view('backend/superadmin/slider_web/v_edit_slider_web', $data);
    }

    public function update_slider_web($id_slider)
    {
        $slider = $this->sliderWebModel->find($id_slider);
        if (!$slider) {
            session()->setFlashdata('error', 'Data slider web tidak ditemukan!');
            return redirect()->to(base_url('home_superadmin/slider_web'));
        }

        $data = [
            'judul_slider' => $this->request->getPost('judul_slider'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'link_url' => $this->request->getPost('link_url'),
            'urutan' => $this->request->getPost('urutan'),
            'status' => $this->request->getPost('status')
        ];

        $gambar = $this->request->getFile('gambar_slider');
        if ($gambar && $gambar->isValid()) {
            // Hapus gambar lama jika ada
            if (!empty($slider['gambar_slider']) && file_exists('uploads/slider_web/' . $slider['gambar_slider'])) {
                unlink('uploads/slider_web/' . $slider['gambar_slider']);
            }
            
            $namaGambar = $gambar->getRandomName();
            $gambar->move('uploads/slider_web', $namaGambar);
            $data['gambar_slider'] = $namaGambar;
        }

        $this->sliderWebModel->update($id_slider, $data);
        session()->setFlashdata('pesan', 'Slider web berhasil diperbarui!');
        return redirect()->to(base_url('home_superadmin/slider_web'));
    }

    public function deleted_slider_web($id_slider)
    {
        $slider = $this->sliderWebModel->find($id_slider);
        if (!$slider) {
            session()->setFlashdata('error', 'Data slider web tidak ditemukan!');
            return redirect()->to(base_url('home_superadmin/slider_web'));
        }

        $this->sliderWebModel->delete($id_slider);
        session()->setFlashdata('pesan', 'Slider web berhasil dihapus!');
        return redirect()->to(base_url('home_superadmin/slider_web'));
    }

    public function update_order_slider_web()
    {
        $id_slider = $this->request->getPost('id_slider');
        $urutan = $this->request->getPost('urutan');
        
        if ($id_slider && $urutan !== null) {
            $this->sliderWebModel->update($id_slider, ['urutan' => $urutan]);
            return $this->response->setJSON(['status' => 'success', 'message' => 'Urutan berhasil diperbarui']);
        }
        
        return $this->response->setJSON(['status' => 'error', 'message' => 'Data tidak lengkap']);
    }

    public function toggle_status_slider_web($id_slider)
    {
        $slider = $this->sliderWebModel->find($id_slider);
        if (!$slider) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Slider web tidak ditemukan']);
        }

        $newStatus = $slider['status'] == 'aktif' ? 'nonaktif' : 'aktif';
        $this->sliderWebModel->update($id_slider, ['status' => $newStatus]);

        return $this->response->setJSON([
            'status' => 'success', 
            'message' => 'Status slider web berhasil diubah',
            'new_status' => $newStatus
        ]);
    }

    // BANK MANAGEMENT METHODS
    public function bank()
    {
        $data = [
            'title' => 'Data Bank',
            'title2' => 'Data Bank',
            'bank' => $this->bankModel->findAll()
        ];
        return view('backend/superadmin/bank/v_bank', $data);
    }

    public function add_bank()
    {
        $data = [
            'title' => 'Tambah Bank',
            'title2' => 'Tambah Bank'
        ];
        return view('backend/superadmin/bank/v_add_bank', $data);
    }

    public function save_bank()
    {
        $rules = [
            'nama_bank' => 'required',
            'no_rekening' => 'required',
            'atas_nama' => 'required'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', \Config\Services::validation()->getErrors());
        }

        $data = [
            'nama_bank' => $this->request->getPost('nama_bank'),
            'no_rekening' => $this->request->getPost('no_rekening'),
            'atas_nama' => $this->request->getPost('atas_nama'),
            'status' => 'aktif'
        ];

        $this->bankModel->insert($data);
        session()->setFlashdata('pesan', 'Bank berhasil ditambahkan!');
        return redirect()->to(base_url('home_superadmin/bank'));
    }

    public function edit_bank($id_bank)
    {
        $bank = $this->bankModel->find($id_bank);
        if (!$bank) {
            session()->setFlashdata('error', 'Data bank tidak ditemukan!');
            return redirect()->to(base_url('home_superadmin/bank'));
        }

        $data = [
            'title' => 'Edit Bank',
            'title2' => 'Edit Bank',
            'bank' => $bank
        ];
        return view('backend/superadmin/bank/v_edit_bank', $data);
    }

    public function update_bank($id_bank)
    {
        $bank = $this->bankModel->find($id_bank);
        if (!$bank) {
            session()->setFlashdata('error', 'Data bank tidak ditemukan!');
            return redirect()->to(base_url('home_superadmin/bank'));
        }

        $data = [
            'nama_bank' => $this->request->getPost('nama_bank'),
            'no_rekening' => $this->request->getPost('no_rekening'),
            'atas_nama' => $this->request->getPost('atas_nama'),
            'status' => $this->request->getPost('status')
        ];

        $this->bankModel->update($id_bank, $data);
        session()->setFlashdata('pesan', 'Bank berhasil diperbarui!');
        return redirect()->to(base_url('home_superadmin/bank'));
    }

    public function deleted_bank($id_bank)
    {
        $bank = $this->bankModel->find($id_bank);
        if (!$bank) {
            session()->setFlashdata('error', 'Data bank tidak ditemukan!');
            return redirect()->to(base_url('home_superadmin/bank'));
        }

        $this->bankModel->delete($id_bank);
        session()->setFlashdata('pesan', 'Bank berhasil dihapus!');
        return redirect()->to(base_url('home_superadmin/bank'));
    }

    public function restore_bank($id_bank)
    {
        $bank = $this->bankModel->withDeleted()->find($id_bank);
        if (!$bank) {
            session()->setFlashdata('error', 'Data bank tidak ditemukan!');
            return redirect()->to(base_url('home_superadmin/bank'));
        }

        $this->bankModel->restore($id_bank);
        session()->setFlashdata('pesan', 'Bank berhasil dipulihkan!');
        return redirect()->to(base_url('home_superadmin/bank'));
    }

    public function bank_deleted()
    {
        $data = [
            'title' => 'Data Bank Terhapus',
            'title2' => 'Bank Terhapus',
            'bank' => $this->bankModel->get_bank_deleted(),
        ];
        return view('backend/superadmin/bank/v_deleted_bank', $data);
    }

    public function force_delete_bank($id_bank)
    {
        $bank = $this->bankModel->withDeleted()->find($id_bank);
        if (!$bank) {
            session()->setFlashdata('error', 'Data bank tidak ditemukan!');
            return redirect()->to(base_url('home_superadmin/bank_deleted'));
        }

        $this->bankModel->force_delete_bank($id_bank);
        session()->setFlashdata('pesan', 'Bank berhasil dihapus permanen!');
        return redirect()->to(base_url('home_superadmin/bank_deleted'));
    }

    public function edit_profil()
    {
        $id_karyawan = session()->get('id_karyawan');
        if (!$id_karyawan) {
            return redirect()->to(base_url('auth_login'));
        }

        $karyawan = $this->karyawanModel->find($id_karyawan);
        if (!$karyawan) {
            session()->setFlashdata('error', 'Data karyawan tidak ditemukan!');
            return redirect()->to(base_url('home_superadmin/profil'));
        }

        $data = [
            'title' => 'Edit Profil',
            'title2' => 'Edit Profil',
            'karyawan' => $karyawan
        ];
        return view('backend/superadmin/v_edit_profil', $data);
    }

    private function getBackupFiles()
    {
        $backupPath = WRITEPATH . 'backups';
        if (!is_dir($backupPath)) {
            mkdir($backupPath, 0755, true);
        }

        $files = [];
        if ($handle = opendir($backupPath)) {
            while (false !== ($file = readdir($handle))) {
                if ($file != '.' && $file != '..' && pathinfo($file, PATHINFO_EXTENSION) == 'sql') {
                    $files[] = [
                        'filename' => $file,
                        'size' => filesize($backupPath . '/' . $file),
                        'date' => date('Y-m-d H:i:s', filemtime($backupPath . '/' . $file))
                    ];
                }
            }
            closedir($handle);
        }

        return $files;
    }

    // --- UJI KOMPETENSI MANAGEMENT ---
    public function uji_kompetensi()
    {
        $data = [
            'title' => 'Data Uji Kompetensi',
            'title2' => 'Data Uji Kompetensi',
            'uji_kompetensi' => $this->ujiKompetensiModel->getAll()
        ];
        return view('backend/superadmin/uji_kompetensi/v_uji_kompetensi', $data);
    }

    public function add_uji_kompetensi()
    {
        $data = [
            'title' => 'Tambah Uji Kompetensi',
            'title2' => 'Tambah Uji Kompetensi'
        ];
        return view('backend/superadmin/uji_kompetensi/v_add_uji_kompetensi', $data);
    }

    public function save_uji_kompetensi()
    {
        $rules = [
            'nama_uji_kompetensi' => 'required|min_length[3]|max_length[100]',
            'deskripsi' => 'required|min_length[10]',
            'durasi' => 'required',
            'tipe_pembelajaran' => 'required',
            'harga' => 'required|numeric',
            'gambar' => 'uploaded[gambar]|max_size[gambar,2048]|ext_in[gambar,jpg,jpeg,png]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', \Config\Services::validation()->getErrors());
        }

        $file = $this->request->getFile('gambar');
        $gambar = $file->getRandomName();
        $file->move('uploads/uji_kompetensi', $gambar);

        $data = [
            'nama_uji_kompetensi' => $this->request->getPost('nama_uji_kompetensi'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'durasi' => $this->request->getPost('durasi'),
            'tipe_pembelajaran' => $this->request->getPost('tipe_pembelajaran'),
            'sertifikat' => $this->request->getPost('sertifikat') ?: 'Tidak',
            'harga' => $this->request->getPost('harga'),
            'gambar' => $gambar,
            'status' => 'aktif'
        ];

        $this->ujiKompetensiModel->insert($data);
        session()->setFlashdata('pesan', 'Uji Kompetensi berhasil ditambahkan!');
        return redirect()->to(base_url('home_superadmin/uji_kompetensi'));
    }

    public function edit_uji_kompetensi($id_uji_kompetensi)
    {
        $uji_kompetensi = $this->ujiKompetensiModel->find($id_uji_kompetensi);
        if (!$uji_kompetensi) {
            session()->setFlashdata('error', 'Data Uji Kompetensi tidak ditemukan!');
            return redirect()->to(base_url('home_superadmin/uji_kompetensi'));
        }

        $data = [
            'title' => 'Edit Uji Kompetensi',
            'title2' => 'Edit Uji Kompetensi',
            'uji_kompetensi' => $uji_kompetensi
        ];
        return view('backend/superadmin/uji_kompetensi/v_edit_uji_kompetensi', $data);
    }

    public function update_uji_kompetensi($id_uji_kompetensi)
    {
        $uji_kompetensi = $this->ujiKompetensiModel->find($id_uji_kompetensi);
        if (!$uji_kompetensi) {
            session()->setFlashdata('error', 'Data Uji Kompetensi tidak ditemukan!');
            return redirect()->to(base_url('home_superadmin/uji_kompetensi'));
        }

        $rules = [
            'nama_uji_kompetensi' => 'required|min_length[3]|max_length[100]',
            'deskripsi' => 'required|min_length[10]',
            'durasi' => 'required|numeric',
            'tipe_pembelajaran' => 'required',
            'harga' => 'required|numeric',
        ];

        $file = $this->request->getFile('gambar');
        if ($file && $file->isValid()) {
            $rules['gambar'] = 'max_size[gambar,2048]|ext_in[gambar,jpg,jpeg,png]';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', \Config\Services::validation()->getErrors());
        }

        $data = [
            'nama_uji_kompetensi' => $this->request->getPost('nama_uji_kompetensi'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'durasi' => $this->request->getPost('durasi'),
            'tipe_pembelajaran' => $this->request->getPost('tipe_pembelajaran'),
            'sertifikat' => $this->request->getPost('sertifikat') ?: 'Tidak',
            'harga' => $this->request->getPost('harga'),
            'status' => $this->request->getPost('status')
        ];

        if ($file && $file->isValid()) {
            // Hapus gambar lama
            if ($uji_kompetensi['gambar'] && file_exists('uploads/uji_kompetensi/' . $uji_kompetensi['gambar'])) {
                unlink('uploads/uji_kompetensi/' . $uji_kompetensi['gambar']);
            }
            
            $gambar = $file->getRandomName();
            $file->move('uploads/uji_kompetensi', $gambar);
            $data['gambar'] = $gambar;
        }

        $this->ujiKompetensiModel->update($id_uji_kompetensi, $data);
        session()->setFlashdata('pesan', 'Uji Kompetensi berhasil diperbarui!');
        return redirect()->to(base_url('home_superadmin/uji_kompetensi'));
    }

    public function deleted_uji_kompetensi($id_uji_kompetensi)
    {
        $uji_kompetensi = $this->ujiKompetensiModel->find($id_uji_kompetensi);
        if (!$uji_kompetensi) {
            session()->setFlashdata('error', 'Data Uji Kompetensi tidak ditemukan!');
            return redirect()->to(base_url('home_superadmin/uji_kompetensi'));
        }

        // Hapus gambar
        if ($uji_kompetensi['gambar'] && file_exists('uploads/uji_kompetensi/' . $uji_kompetensi['gambar'])) {
            unlink('uploads/uji_kompetensi/' . $uji_kompetensi['gambar']);
        }

        $this->ujiKompetensiModel->delete($id_uji_kompetensi);
        session()->setFlashdata('pesan', 'Uji Kompetensi berhasil dihapus!');
        return redirect()->to(base_url('home_superadmin/uji_kompetensi'));
    }

    // --- GALERI UJI KOMPETENSI MANAGEMENT ---
    public function galeri_uji_kompetensi()
    {
        $data = [
            'title' => 'Galeri Uji Kompetensi',
            'title2' => 'Galeri Uji Kompetensi',
            'galeri' => $this->galeriUjiModel->getAll()
        ];
        return view('backend/superadmin/galeri_uji_kompetensi/v_galeri_uji_kompetensi', $data);
    }

    public function add_galeri_uji_kompetensi()
    {
        $data = [
            'title' => 'Tambah Galeri Uji Kompetensi',
            'title2' => 'Tambah Galeri Uji Kompetensi'
        ];
        return view('backend/superadmin/galeri_uji_kompetensi/v_add_galeri_uji_kompetensi', $data);
    }

    public function save_galeri_uji_kompetensi()
    {
        $rules = [
            'judul' => 'required|min_length[3]|max_length[100]',
            'deskripsi' => 'required|min_length[10]',
            'gambar' => 'uploaded[gambar]|max_size[gambar,2048]|ext_in[gambar,jpg,jpeg,png]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', \Config\Services::validation()->getErrors());
        }

        $file = $this->request->getFile('gambar');
        $gambar = $file->getRandomName();

        $upload_dir = FCPATH . 'uploads/galeri_uji_kompetensi';
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true);
        }
        $file->move($upload_dir, $gambar);

        $this->galeriUjiModel->insert([
            'id_uji_kompetensi' => $this->request->getPost('id_uji_kompetensi') ?: null,
            'judul' => $this->request->getPost('judul'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'gambar' => $gambar,
            'status' => 'aktif',
        ]);

        session()->setFlashdata('pesan', 'Galeri Uji Kompetensi berhasil ditambahkan!');
        return redirect()->to(base_url('home_superadmin/galeri_uji_kompetensi'));
    }

    public function deleted_galeri_uji_kompetensi($id)
    {
        $galeri = $this->galeriUjiModel->find($id);
        if (!$galeri) {
            session()->setFlashdata('error', 'Data Galeri tidak ditemukan!');
            return redirect()->to(base_url('home_superadmin/galeri_uji_kompetensi'));
        }

        // Hapus gambar
        if ($galeri['gambar'] && file_exists(FCPATH . 'uploads/galeri_uji_kompetensi/' . $galeri['gambar'])) {
            unlink(FCPATH . 'uploads/galeri_uji_kompetensi/' . $galeri['gambar']);
        }

        $this->galeriUjiModel->delete($id);
        session()->setFlashdata('pesan', 'Galeri berhasil dihapus!');
        return redirect()->to(base_url('home_superadmin/galeri_uji_kompetensi'));
    }

    // MITRA KERJA MANAGEMENT METHODS
    public function mitra_kerja()
    {
        $data = [
            'title' => 'Mitra Kerja',
            'title2' => 'Mitra Kerja',
            'mitra' => $this->mitraKerjaModel->getAllPartners()
        ];
        return view('backend/superadmin/mitra_kerja/v_mitra_kerja', $data);
    }

    public function add_mitra_kerja()
    {
        $data = [
            'title' => 'Tambah Mitra Kerja',
            'title2' => 'Tambah Mitra Kerja'
        ];
        return view('backend/superadmin/mitra_kerja/v_add_mitra_kerja', $data);
    }

    public function save_mitra_kerja()
    {
        $rules = [
            'nama_mitra' => 'required|min_length[3]|max_length[100]',
            'deskripsi' => 'required|min_length[10]',
            'logo_mitra' => 'uploaded[logo_mitra]|max_size[logo_mitra,10240]|is_image[logo_mitra]',
            'urutan' => 'required|numeric',
            'status' => 'required|in_list[aktif,tidak_aktif]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', \Config\Services::validation()->getErrors());
        }

        $logo = $this->request->getFile('logo_mitra');
        $namaLogo = $logo->getRandomName();
        $logo->move('uploads/mitra_kerja', $namaLogo);

        $data = [
            'nama_mitra' => $this->request->getPost('nama_mitra'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'logo_mitra' => $namaLogo,
            'url_website' => $this->request->getPost('url_website'),
            'urutan' => $this->request->getPost('urutan'),
            'status' => $this->request->getPost('status')
        ];

        $this->mitraKerjaModel->insertPartner($data);
        session()->setFlashdata('pesan', 'Mitra kerja berhasil ditambahkan!');
        return redirect()->to(base_url('home_superadmin/mitra_kerja'));
    }

    public function edit_mitra_kerja($id_mitra)
    {
        $mitra = $this->mitraKerjaModel->getPartnerById($id_mitra);
        if (!$mitra) {
            session()->setFlashdata('error', 'Data mitra kerja tidak ditemukan!');
            return redirect()->to(base_url('home_superadmin/mitra_kerja'));
        }

        $data = [
            'title' => 'Edit Mitra Kerja',
            'title2' => 'Edit Mitra Kerja',
            'mitra' => $mitra
        ];
        return view('backend/superadmin/mitra_kerja/v_edit_mitra_kerja', $data);
    }

    public function update_mitra_kerja($id_mitra)
    {
        $mitra = $this->mitraKerjaModel->getPartnerById($id_mitra);
        if (!$mitra) {
            session()->setFlashdata('error', 'Data mitra kerja tidak ditemukan!');
            return redirect()->to(base_url('home_superadmin/mitra_kerja'));
        }

        $rules = [
            'nama_mitra' => 'required|min_length[3]|max_length[100]',
            'deskripsi' => 'required|min_length[10]',
            'urutan' => 'required|numeric',
            'status' => 'required|in_list[aktif,tidak_aktif]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', \Config\Services::validation()->getErrors());
        }

        $data = [
            'nama_mitra' => $this->request->getPost('nama_mitra'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'url_website' => $this->request->getPost('url_website'),
            'urutan' => $this->request->getPost('urutan'),
            'status' => $this->request->getPost('status')
        ];

        $logo = $this->request->getFile('logo_mitra');
        if ($logo && $logo->isValid()) {
            // Hapus logo lama jika ada
            if (!empty($mitra['logo_mitra']) && file_exists('uploads/mitra_kerja/' . $mitra['logo_mitra'])) {
                unlink('uploads/mitra_kerja/' . $mitra['logo_mitra']);
            }
            
            $namaLogo = $logo->getRandomName();
            $logo->move('uploads/mitra_kerja', $namaLogo);
            $data['logo_mitra'] = $namaLogo;
        }

        $this->mitraKerjaModel->updatePartner($id_mitra, $data);
        session()->setFlashdata('pesan', 'Mitra kerja berhasil diperbarui!');
        return redirect()->to(base_url('home_superadmin/mitra_kerja'));
    }

    public function deleted_mitra_kerja($id_mitra)
    {
        $mitra = $this->mitraKerjaModel->getPartnerById($id_mitra);
        if (!$mitra) {
            session()->setFlashdata('error', 'Data mitra kerja tidak ditemukan!');
            return redirect()->to(base_url('home_superadmin/mitra_kerja'));
        }

        // Hapus logo jika ada
        if (!empty($mitra['logo_mitra']) && file_exists('uploads/mitra_kerja/' . $mitra['logo_mitra'])) {
            unlink('uploads/mitra_kerja/' . $mitra['logo_mitra']);
        }

        $this->mitraKerjaModel->deletePartner($id_mitra);
        session()->setFlashdata('pesan', 'Mitra kerja berhasil dihapus!');
        return redirect()->to(base_url('home_superadmin/mitra_kerja'));
    }

    // =============================================
    // CRUD MANAJEMEN
    // =============================================
    
    public function manajemen()
    {
        $status_filter = $this->request->getGet('status');
        $data = [
            'title' => 'Manajemen LPK INASABA',
            'title2' => 'Data Manajemen',
            'manajemen' => $this->manajemenModel->getManajemen($status_filter),
            'status_filter' => $status_filter
        ];
        return view('backend/superadmin/manajemen/v_manajemen', $data);
    }

    public function create_manajemen()
    {
        $data = [
            'title' => 'Tambah Manajemen',
            'title2' => 'Tambah Data Manajemen',
            'validation' => \Config\Services::validation()
        ];
        return view('backend/superadmin/manajemen/v_create_manajemen', $data);
    }

    public function save_manajemen()
    {
        $rules = [
            'nama_lengkap' => 'required|min_length[3]|max_length[255]',
            'jabatan' => 'required|min_length[3]|max_length[255]',
            'urutan' => 'required|numeric',
            'status' => 'required|in_list[aktif,nonaktif]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', \Config\Services::validation()->getErrors());
        }

        $data = [
            'nama_lengkap' => $this->request->getPost('nama_lengkap'),
            'jabatan' => $this->request->getPost('jabatan'),
            'facebook' => $this->request->getPost('facebook'),
            'twitter' => $this->request->getPost('twitter'),
            'linkedin' => $this->request->getPost('linkedin'),
            'instagram' => $this->request->getPost('instagram'),
            'email' => $this->request->getPost('email'),
            'no_telepon' => $this->request->getPost('no_telepon'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'urutan' => $this->request->getPost('urutan'),
            'status' => $this->request->getPost('status')
        ];

        $foto = $this->request->getFile('foto');
        if ($foto && $foto->isValid()) {
            $namaFoto = $foto->getRandomName();
            $foto->move('uploads/manajemen', $namaFoto);
            $data['foto'] = $namaFoto;
        }

        $this->manajemenModel->insertManajemen($data);
        session()->setFlashdata('pesan', 'Data manajemen berhasil ditambahkan!');
        return redirect()->to(base_url('home_superadmin/manajemen'));
    }

    public function edit_manajemen($id_manajemen)
    {
        $data = [
            'title' => 'Edit Manajemen',
            'title2' => 'Edit Data Manajemen',
            'validation' => \Config\Services::validation(),
            'manajemen' => $this->manajemenModel->getDetailManajemen($id_manajemen)
        ];
        
        if (empty($data['manajemen'])) {
            session()->setFlashdata('error', 'Data manajemen tidak ditemukan!');
            return redirect()->to(base_url('home_superadmin/manajemen'));
        }
        
        return view('backend/superadmin/manajemen/v_edit_manajemen', $data);
    }

    public function update_manajemen($id_manajemen)
    {
        $manajemen = $this->manajemenModel->getDetailManajemen($id_manajemen);
        if (!$manajemen) {
            session()->setFlashdata('error', 'Data manajemen tidak ditemukan!');
            return redirect()->to(base_url('home_superadmin/manajemen'));
        }

        $rules = [
            'nama_lengkap' => 'required|min_length[3]|max_length[255]',
            'jabatan' => 'required|min_length[3]|max_length[255]',
            'urutan' => 'required|numeric',
            'status' => 'required|in_list[aktif,nonaktif]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', \Config\Services::validation()->getErrors());
        }

        $data = [
            'nama_lengkap' => $this->request->getPost('nama_lengkap'),
            'jabatan' => $this->request->getPost('jabatan'),
            'facebook' => $this->request->getPost('facebook'),
            'twitter' => $this->request->getPost('twitter'),
            'linkedin' => $this->request->getPost('linkedin'),
            'instagram' => $this->request->getPost('instagram'),
            'email' => $this->request->getPost('email'),
            'no_telepon' => $this->request->getPost('no_telepon'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'urutan' => $this->request->getPost('urutan'),
            'status' => $this->request->getPost('status')
        ];

        $foto = $this->request->getFile('foto');
        if ($foto && $foto->isValid()) {
            // Hapus foto lama jika ada
            if (!empty($manajemen['foto']) && file_exists('uploads/manajemen/' . $manajemen['foto'])) {
                unlink('uploads/manajemen/' . $manajemen['foto']);
            }
            
            $namaFoto = $foto->getRandomName();
            $foto->move('uploads/manajemen', $namaFoto);
            $data['foto'] = $namaFoto;
        }

        $this->manajemenModel->updateManajemen($id_manajemen, $data);
        session()->setFlashdata('pesan', 'Data manajemen berhasil diperbarui!');
        return redirect()->to(base_url('home_superadmin/manajemen'));
    }

    public function delete_manajemen($id_manajemen)
    {
        $manajemen = $this->manajemenModel->getDetailManajemen($id_manajemen);
        if (!$manajemen) {
            session()->setFlashdata('error', 'Data manajemen tidak ditemukan!');
            return redirect()->to(base_url('home_superadmin/manajemen'));
        }

        $this->manajemenModel->deleteManajemen($id_manajemen);
        session()->setFlashdata('pesan', 'Data manajemen berhasil dihapus!');
        return redirect()->to(base_url('home_superadmin/manajemen'));
    }

    // =============================================
    // CRUD INSTRUKTUR
    // =============================================
    
    public function instruktur()
    {
        $status_filter = $this->request->getGet('status');
        $data = [
            'title' => 'Instruktur LPK INASABA',
            'title2' => 'Data Instruktur',
            'instruktur' => $this->instrukturModel->getInstruktur($status_filter),
            'status_filter' => $status_filter
        ];
        return view('backend/superadmin/instruktur/v_instruktur', $data);
    }

    public function create_instruktur()
    {
        $data = [
            'title' => 'Tambah Instruktur',
            'title2' => 'Tambah Data Instruktur',
            'validation' => \Config\Services::validation()
        ];
        return view('backend/superadmin/instruktur/v_create_instruktur', $data);
    }

    public function save_instruktur()
    {
        $rules = [
            'nama_lengkap' => 'required|min_length[3]|max_length[255]',
            'keahlian' => 'required|min_length[5]',
            'urutan' => 'required|numeric',
            'status' => 'required|in_list[aktif,nonaktif]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', \Config\Services::validation()->getErrors());
        }

        $data = [
            'nama_lengkap' => $this->request->getPost('nama_lengkap'),
            'keahlian' => $this->request->getPost('keahlian'),
            'facebook' => $this->request->getPost('facebook'),
            'twitter' => $this->request->getPost('twitter'),
            'linkedin' => $this->request->getPost('linkedin'),
            'instagram' => $this->request->getPost('instagram'),
            'email' => $this->request->getPost('email'),
            'no_telepon' => $this->request->getPost('no_telepon'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'pendidikan' => $this->request->getPost('pendidikan'),
            'pengalaman' => $this->request->getPost('pengalaman'),
            'urutan' => $this->request->getPost('urutan'),
            'status' => $this->request->getPost('status')
        ];

        $foto = $this->request->getFile('foto');
        if ($foto && $foto->isValid()) {
            $namaFoto = $foto->getRandomName();
            $foto->move('uploads/instruktur', $namaFoto);
            $data['foto'] = $namaFoto;
        }

        $this->instrukturModel->insertInstruktur($data);
        session()->setFlashdata('pesan', 'Data instruktur berhasil ditambahkan!');
        return redirect()->to(base_url('home_superadmin/instruktur'));
    }

    public function edit_instruktur($id_instruktur)
    {
        $data = [
            'title' => 'Edit Instruktur',
            'title2' => 'Edit Data Instruktur',
            'validation' => \Config\Services::validation(),
            'instruktur' => $this->instrukturModel->getDetailInstruktur($id_instruktur)
        ];
        
        if (empty($data['instruktur'])) {
            session()->setFlashdata('error', 'Data instruktur tidak ditemukan!');
            return redirect()->to(base_url('home_superadmin/instruktur'));
        }
        
        return view('backend/superadmin/instruktur/v_edit_instruktur', $data);
    }

    public function update_instruktur($id_instruktur)
    {
        $instruktur = $this->instrukturModel->getDetailInstruktur($id_instruktur);
        if (!$instruktur) {
            session()->setFlashdata('error', 'Data instruktur tidak ditemukan!');
            return redirect()->to(base_url('home_superadmin/instruktur'));
        }

        $rules = [
            'nama_lengkap' => 'required|min_length[3]|max_length[255]',
            'keahlian' => 'required|min_length[5]',
            'urutan' => 'required|numeric',
            'status' => 'required|in_list[aktif,nonaktif]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', \Config\Services::validation()->getErrors());
        }

        $data = [
            'nama_lengkap' => $this->request->getPost('nama_lengkap'),
            'keahlian' => $this->request->getPost('keahlian'),
            'facebook' => $this->request->getPost('facebook'),
            'twitter' => $this->request->getPost('twitter'),
            'linkedin' => $this->request->getPost('linkedin'),
            'instagram' => $this->request->getPost('instagram'),
            'email' => $this->request->getPost('email'),
            'no_telepon' => $this->request->getPost('no_telepon'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'pendidikan' => $this->request->getPost('pendidikan'),
            'pengalaman' => $this->request->getPost('pengalaman'),
            'urutan' => $this->request->getPost('urutan'),
            'status' => $this->request->getPost('status')
        ];

        $foto = $this->request->getFile('foto');
        if ($foto && $foto->isValid()) {
            // Hapus foto lama jika ada
            if (!empty($instruktur['foto']) && file_exists('uploads/instruktur/' . $instruktur['foto'])) {
                unlink('uploads/instruktur/' . $instruktur['foto']);
            }
            
            $namaFoto = $foto->getRandomName();
            $foto->move('uploads/instruktur', $namaFoto);
            $data['foto'] = $namaFoto;
        }

        $this->instrukturModel->updateInstruktur($id_instruktur, $data);
        session()->setFlashdata('pesan', 'Data instruktur berhasil diperbarui!');
        return redirect()->to(base_url('home_superadmin/instruktur'));
    }

    public function delete_instruktur($id_instruktur)
    {
        $instruktur = $this->instrukturModel->getDetailInstruktur($id_instruktur);
        if (!$instruktur) {
            session()->setFlashdata('error', 'Data instruktur tidak ditemukan!');
            return redirect()->to(base_url('home_superadmin/instruktur'));
        }

        $this->instrukturModel->deleteInstruktur($id_instruktur);
        session()->setFlashdata('pesan', 'Data instruktur berhasil dihapus!');
        return redirect()->to(base_url('home_superadmin/instruktur'));
    }

    // =============================================
    // PROFIL LPK CRUD
    // =============================================

    public function profil_lpk()
    {
        $data_profil = $this->profilLpkModel->getProfil();
        
        $data = [
            'title' => 'Profil LPK',
            'title2' => 'Profil LPK',
            'profil' => $data_profil
        ];
        
        return view('backend/superadmin/profil_lpk/v_profil_lpk', $data);
    }

    public function create_profil()
    {
        $data = [
            'title' => 'Tambah Profil LPK',
            'title2' => 'Tambah Profil LPK'
        ];
        
        return view('backend/superadmin/profil_lpk/v_create_profil', $data);
    }

    public function save_profil()
    {
        $validation = \Config\Services::validation();

        $rules = [
            'judul_header' => 'required',
            'video_url' => 'required',
            'sejarah_singkat' => 'required',
            'tahun_berdiri' => 'required|numeric'
        ];

        if (!$this->validate($rules)) {
            session()->setFlashdata('errors', $validation->getErrors());
            return redirect()->back()->withInput();
        }

        $data = [
            'judul_header' => $this->request->getPost('judul_header'),
            'subjudul_header' => $this->request->getPost('subjudul_header'),
            'video_url' => $this->request->getPost('video_url'),
            'video_title' => $this->request->getPost('video_title'),
            'sejarah_singkat' => $this->request->getPost('sejarah_singkat'),
            'tahun_berdiri' => $this->request->getPost('tahun_berdiri'),
            'tanggal_resmi' => $this->request->getPost('tanggal_resmi'),
            'tanggal_izin' => $this->request->getPost('tanggal_izin'),
            'status_akreditasi' => $this->request->getPost('status_akreditasi')
        ];

        $this->profilLpkModel->insertProfil($data);
        session()->setFlashdata('pesan', 'Profil LPK berhasil ditambahkan!');
        return redirect()->to(base_url('home_superadmin/profil_lpk'));
    }

    public function edit_profil_lpk($id)
    {
        $profil = $this->profilLpkModel->getProfilById($id);
        
        if (!$profil) {
            session()->setFlashdata('error', 'Data profil tidak ditemukan!');
            return redirect()->to(base_url('home_superadmin/profil_lpk'));
        }

        $data = [
            'title' => 'Edit Profil LPK',
            'title2' => 'Edit Profil LPK',
            'profil' => $profil
        ];
        
        return view('backend/superadmin/profil_lpk/v_edit_profil', $data);
    }

    public function update_profil_lpk($id)
    {
        $validation = \Config\Services::validation();

        $rules = [
            'judul_header' => 'required',
            'video_url' => 'required',
            'sejarah_singkat' => 'required',
            'tahun_berdiri' => 'required|numeric'
        ];

        if (!$this->validate($rules)) {
            session()->setFlashdata('errors', $validation->getErrors());
            return redirect()->back()->withInput();
        }

        $data = [
            'judul_header' => $this->request->getPost('judul_header'),
            'subjudul_header' => $this->request->getPost('subjudul_header'),
            'video_url' => $this->request->getPost('video_url'),
            'video_title' => $this->request->getPost('video_title'),
            'sejarah_singkat' => $this->request->getPost('sejarah_singkat'),
            'tahun_berdiri' => $this->request->getPost('tahun_berdiri'),
            'tanggal_resmi' => $this->request->getPost('tanggal_resmi'),
            'tanggal_izin' => $this->request->getPost('tanggal_izin'),
            'status_akreditasi' => $this->request->getPost('status_akreditasi')
        ];

        $this->profilLpkModel->updateProfil($id, $data);
        session()->setFlashdata('pesan', 'Profil LPK berhasil diupdate!');
        return redirect()->to(base_url('home_superadmin/profil_lpk'));
    }

    public function delete_profil($id)
    {
        $this->profilLpkModel->deleteProfil($id);
        session()->setFlashdata('pesan', 'Profil LPK berhasil dihapus!');
        return redirect()->to(base_url('home_superadmin/profil_lpk'));
    }

    // =============================================
    // VISI & MISI CRUD
    // =============================================

    public function visi_misi()
    {
        $data_visimisi = $this->visiMisiModel->getAllVisiMisi();
        
        $data = [
            'title' => 'Visi & Misi',
            'title2' => 'Visi & Misi',
            'visimisi' => $data_visimisi
        ];
        
        return view('backend/superadmin/visi_misi/v_visi_misi', $data);
    }

    public function create_visi_misi()
    {
        $data = [
            'title' => 'Tambah Visi/Misi',
            'title2' => 'Tambah Visi/Misi'
        ];
        
        return view('backend/superadmin/visi_misi/v_create_visi_misi', $data);
    }

    public function save_visi_misi()
    {
        $validation = \Config\Services::validation();

        $rules = [
            'jenis' => 'required',
            'konten' => 'required',
            'urutan' => 'required|numeric'
        ];

        if (!$this->validate($rules)) {
            session()->setFlashdata('errors', $validation->getErrors());
            return redirect()->back()->withInput();
        }

        $data = [
            'jenis' => $this->request->getPost('jenis'),
            'konten' => $this->request->getPost('konten'),
            'urutan' => $this->request->getPost('urutan'),
            'status' => $this->request->getPost('status')
        ];

        $this->visiMisiModel->insertVisiMisi($data);
        session()->setFlashdata('pesan', 'Visi/Misi berhasil ditambahkan!');
        return redirect()->to(base_url('home_superadmin/visi_misi'));
    }

    public function edit_visi_misi($id)
    {
        $visimisi = $this->visiMisiModel->getById($id);
        
        if (!$visimisi) {
            session()->setFlashdata('error', 'Data visi/misi tidak ditemukan!');
            return redirect()->to(base_url('home_superadmin/visi_misi'));
        }

        $data = [
            'title' => 'Edit Visi/Misi',
            'title2' => 'Edit Visi/Misi',
            'visimisi' => $visimisi
        ];
        
        return view('backend/superadmin/visi_misi/v_edit_visi_misi', $data);
    }

    public function update_visi_misi($id)
    {
        $validation = \Config\Services::validation();

        $rules = [
            'jenis' => 'required',
            'konten' => 'required',
            'urutan' => 'required|numeric'
        ];

        if (!$this->validate($rules)) {
            session()->setFlashdata('errors', $validation->getErrors());
            return redirect()->back()->withInput();
        }

        $data = [
            'jenis' => $this->request->getPost('jenis'),
            'konten' => $this->request->getPost('konten'),
            'urutan' => $this->request->getPost('urutan'),
            'status' => $this->request->getPost('status')
        ];

        $this->visiMisiModel->updateVisiMisi($id, $data);
        session()->setFlashdata('pesan', 'Visi/Misi berhasil diupdate!');
        return redirect()->to(base_url('home_superadmin/visi_misi'));
    }

    public function delete_visi_misi($id)
    {
        $this->visiMisiModel->deleteVisiMisi($id);
        session()->setFlashdata('pesan', 'Visi/Misi berhasil dihapus!');
        return redirect()->to(base_url('home_superadmin/visi_misi'));
    }

    // STATS MANAGEMENT METHODS
    // List all stats
    public function stats()
    {
        $data['stats'] = $this->statsModel->getAllStats();
        $data['title'] = 'Kelola Statistik';
        
        return view('backend/stats/v_stats_list', $data);
    }

    // Add new stats form
    public function stats_add()
    {
        $data['title'] = 'Tambah Statistik';
        $data['max_order_row1'] = $this->statsModel->getMaxOrderInRow(1) + 1;
        $data['max_order_row2'] = $this->statsModel->getMaxOrderInRow(2) + 1;
        
        return view('backend/stats/v_stats_add', $data);
    }

    // Save new stats
    public function stats_save()
    {
        $validation = \Config\Services::validation();
        
        $rules = [
            'judul_stats' => 'required|min_length[3]|max_length[255]',
            'nilai_stats' => 'required|numeric|greater_than_equal_to[0]',
            'suffix_stats' => 'max_length[50]',
            'baris_stats' => 'required|in_list[1,2]',
            'urutan_stats' => 'required|numeric|greater_than[0]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $data = [
            'judul_stats' => $this->request->getPost('judul_stats'),
            'nilai_stats' => $this->request->getPost('nilai_stats'),
            'suffix_stats' => $this->request->getPost('suffix_stats'),
            'baris_stats' => $this->request->getPost('baris_stats'),
            'urutan_stats' => $this->request->getPost('urutan_stats'),
            'is_active' => 1
        ];

        if ($this->statsModel->insertStats($data)) {
            return redirect()->to('/home_superadmin/stats')->with('success', 'Statistik berhasil ditambahkan');
        } else {
            return redirect()->back()->withInput()->with('error', 'Gagal menambahkan statistik');
        }
    }

    // Edit stats form
    public function stats_edit($id)
    {
        $data['stats'] = $this->statsModel->getStatsById($id);
        
        if (empty($data['stats'])) {
            return redirect()->to('/home_superadmin/stats')->with('error', 'Statistik tidak ditemukan');
        }

        $data['title'] = 'Edit Statistik';
        $data['max_order_row1'] = $this->statsModel->getMaxOrderInRow(1) + 1;
        $data['max_order_row2'] = $this->statsModel->getMaxOrderInRow(2) + 1;
        
        return view('backend/stats/v_stats_edit', $data);
    }

    // Update stats
    public function stats_update($id)
    {
        $validation = \Config\Services::validation();
        
        $rules = [
            'judul_stats' => 'required|min_length[3]|max_length[255]',
            'nilai_stats' => 'required|numeric|greater_than_equal_to[0]',
            'suffix_stats' => 'max_length[50]',
            'baris_stats' => 'required|in_list[1,2]',
            'urutan_stats' => 'required|numeric|greater_than[0]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $data = [
            'judul_stats' => $this->request->getPost('judul_stats'),
            'nilai_stats' => $this->request->getPost('nilai_stats'),
            'suffix_stats' => $this->request->getPost('suffix_stats'),
            'baris_stats' => $this->request->getPost('baris_stats'),
            'urutan_stats' => $this->request->getPost('urutan_stats')
        ];

        if ($this->statsModel->updateStats($id, $data)) {
            return redirect()->to('/home_superadmin/stats')->with('success', 'Statistik berhasil diperbarui');
        } else {
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui statistik');
        }
    }

    // Delete stats
    public function stats_delete($id)
    {
        if ($this->statsModel->deleteStats($id)) {
            return redirect()->to('/home_superadmin/stats')->with('success', 'Statistik berhasil dihapus');
        } else {
            return redirect()->to('/home_superadmin/stats')->with('error', 'Gagal menghapus statistik');
        }
    }

    // Toggle active status
    public function stats_toggle($id)
    {
        if ($this->statsModel->toggleActive($id)) {
            return redirect()->to('/home_superadmin/stats')->with('success', 'Status statistik berhasil diubah');
        } else {
            return redirect()->to('/home_superadmin/stats')->with('error', 'Gagal mengubah status statistik');
        }
    }

    // Get stats for API (for frontend)
    public function stats_getStats()
    {
        $stats = $this->statsModel->getActiveStats();
        return $this->response->setJSON($stats);
    }

    // Alumni management method
    public function alumni()
    {
        return redirect()->to(base_url('home_superadmin/alumni/'));
    }

    // ============================================
    // BANK SOAL MANAGEMENT
    // ============================================

    public function bank_soal($id_kursus = null)
    {
        $bankSoalModel = new \App\Models\M_bank_soal();

        if ($id_kursus) {
            $soal = $bankSoalModel->getSoalByKursus($id_kursus);
            $kursus = $this->kursusModel->find($id_kursus);
            $stats = $bankSoalModel->getSoalStats($id_kursus);
        } else {
            $soal = $bankSoalModel->orderBy('created_at', 'DESC')->findAll();
            $kursus = null;
            $stats = [];
        }

        $data = [
            'title' => 'Bank Soal',
            'title2' => 'Bank Soal',
            'soal' => $soal,
            'kursus_list' => $this->kursusModel->findAll(),
            'kursus_aktif' => $kursus,
            'stats' => $stats,
        ];
        return view('backend/superadmin/bank_soal/v_index', $data);
    }

    public function add_bank_soal($id_kursus)
    {
        $data = [
            'title' => 'Tambah Soal',
            'title2' => 'Tambah Soal Baru',
            'kursus' => $this->kursusModel->find($id_kursus),
            'modul_list' => $this->modulModel->where('id_kursus', $id_kursus)->findAll(),
            'id_kursus' => $id_kursus,
        ];
        return view('backend/superadmin/bank_soal/v_add', $data);
    }

    public function save_bank_soal()
    {
        $bankSoalModel = new \App\Models\M_bank_soal();

        $id_kursus = $this->request->getPost('id_kursus');
        $tipe_soal = $this->request->getPost('tipe_soal');

        $data = [
            'id_kursus'     => $id_kursus,
            'id_modul'      => $this->request->getPost('id_modul') ?: null,
            'kategori'      => $this->request->getPost('kategori'),
            'tipe_soal'     => $tipe_soal,
            'pertanyaan'    => $this->request->getPost('pertanyaan'),
            'jawaban_benar' => $this->request->getPost('jawaban_benar'),
            'bobot'         => $this->request->getPost('bobot') ?? 1,
            'level'         => $this->request->getPost('level') ?? 'sedang',
            'penjelasan'    => $this->request->getPost('penjelasan'),
            'status'        => 'aktif',
        ];

        if ($tipe_soal === 'pilihan_ganda' || $tipe_soal === 'true_false') {
            $pilihan = [
                'A' => $this->request->getPost('pilihan_a'),
                'B' => $this->request->getPost('pilihan_b'),
                'C' => $this->request->getPost('pilihan_c'),
                'D' => $this->request->getPost('pilihan_d'),
            ];
            $data['pilihan'] = json_encode($pilihan);
        } elseif ($tipe_soal === 'matching') {
            $pairs = [];
            $left = $this->request->getPost('pair_left');
            $right = $this->request->getPost('pair_right');
            if (is_array($left) && is_array($right)) {
                foreach ($left as $idx => $l) {
                    $pairs[$l] = $right[$idx] ?? '';
                }
            }
            $data['pilihan_pair'] = json_encode($pairs);
        }

        if ($bankSoalModel->insert($data)) {
            return redirect()->to(base_url('home_superadmin/bank_soal/' . $id_kursus))->with('success', 'Soal berhasil ditambahkan');
        }
        return redirect()->back()->withInput()->with('error', 'Gagal menambahkan soal');
    }

    public function edit_bank_soal($id_soal)
    {
        $bankSoalModel = new \App\Models\M_bank_soal();
        $soal = $bankSoalModel->find($id_soal);

        $data = [
            'title' => 'Edit Soal',
            'title2' => 'Edit Soal',
            'soal' => $soal,
            'kursus' => $this->kursusModel->find($soal['id_kursus']),
            'modul_list' => $this->modulModel->where('id_kursus', $soal['id_kursus'])->findAll(),
        ];
        return view('backend/superadmin/bank_soal/v_edit', $data);
    }

    public function update_bank_soal($id_soal)
    {
        $bankSoalModel = new \App\Models\M_bank_soal();
        $soal = $bankSoalModel->find($id_soal);
        $tipe_soal = $this->request->getPost('tipe_soal');

        $updateData = [
            'id_modul'      => $this->request->getPost('id_modul') ?: null,
            'kategori'      => $this->request->getPost('kategori'),
            'tipe_soal'     => $tipe_soal,
            'pertanyaan'    => $this->request->getPost('pertanyaan'),
            'jawaban_benar' => $this->request->getPost('jawaban_benar'),
            'bobot'         => $this->request->getPost('bobot') ?? 1,
            'level'         => $this->request->getPost('level') ?? 'sedang',
            'penjelasan'    => $this->request->getPost('penjelasan'),
        ];

        if ($tipe_soal === 'pilihan_ganda' || $tipe_soal === 'true_false') {
            $pilihan = [
                'A' => $this->request->getPost('pilihan_a'),
                'B' => $this->request->getPost('pilihan_b'),
                'C' => $this->request->getPost('pilihan_c'),
                'D' => $this->request->getPost('pilihan_d'),
            ];
            $updateData['pilihan'] = json_encode($pilihan);
        } elseif ($tipe_soal === 'matching') {
            $pairs = [];
            $left = $this->request->getPost('pair_left');
            $right = $this->request->getPost('pair_right');
            if (is_array($left) && is_array($right)) {
                foreach ($left as $idx => $l) {
                    $pairs[$l] = $right[$idx] ?? '';
                }
            }
            $updateData['pilihan_pair'] = json_encode($pairs);
        }

        $bankSoalModel->update($id_soal, $updateData);
        return redirect()->to(base_url('home_superadmin/bank_soal/' . $soal['id_kursus']))->with('success', 'Soal berhasil diperbarui');
    }

    public function delete_bank_soal($id_soal)
    {
        $bankSoalModel = new \App\Models\M_bank_soal();
        $soal = $bankSoalModel->find($id_soal);
        $bankSoalModel->delete($id_soal);
        return redirect()->to(base_url('home_superadmin/bank_soal/' . $soal['id_kursus']))->with('success', 'Soal berhasil dihapus');
    }

    public function import_bank_soal()
    {
        $bankSoalModel = new \App\Models\M_bank_soal();
        $id_kursus = $this->request->getPost('id_kursus');
        $json_data = $this->request->getPost('json_data');

        $data = json_decode($json_data, true);
        if (!$data || !is_array($data)) {
            return redirect()->back()->with('error', 'Format JSON tidak valid');
        }

        $count = $bankSoalModel->importSoal($id_kursus, $data);
        return redirect()->to(base_url('home_superadmin/bank_soal/' . $id_kursus))->with('success', $count . ' soal berhasil diimpor');
    }

    // ============================================
    // GRADEBOOK
    // ============================================

    public function gradebook()
    {
        $db = \Config\Database::connect();

        $pendaftaran = $db->table('pendaftaran p')
            ->select('p.*, s.nama_lengkap as nama_siswa, s.email, k.nama_kursus, k.id_kursus')
            ->join('siswa s', 's.id_siswa = p.id_siswa', 'left')
            ->join('kursus k', 'k.id_kursus = p.id_kursus', 'left')
            ->where('p.status', 'aktif')
            ->orderBy('s.nama_lengkap', 'ASC')
            ->get()
            ->getResultArray();

        $data = [
            'title' => 'Gradebook',
            'title2' => 'Rekap Nilai Siswa',
            'pendaftaran' => $pendaftaran,
        ];
        return view('backend/superadmin/v_gradebook', $data);
    }

    public function gradebook_detail($id_pendaftaran)
    {
        $db = \Config\Database::connect();

        $pendaftaran = $db->table('pendaftaran p')
            ->select('p.*, s.nama_lengkap as nama_siswa, s.email, k.nama_kursus')
            ->join('siswa s', 's.id_siswa = p.id_siswa', 'left')
            ->join('kursus k', 'k.id_kursus = p.id_kursus', 'left')
            ->where('p.id_pendaftaran', $id_pendaftaran)
            ->get()
            ->getRowArray();

        $quiz_nilai = $db->table('quiz_hasil qh')
            ->select('qh.*, q.judul_quiz, q.passing_grade')
            ->join('quiz q', 'q.id_quiz = qh.id_quiz', 'left')
            ->where('qh.id_pendaftaran', $id_pendaftaran)
            ->orderBy('qh.created_at', 'DESC')
            ->get()
            ->getResultArray();

        $tugas_nilai = $db->table('pengumpulan_tugas pt')
            ->select('pt.*, t.judul_tugas')
            ->join('tugas t', 't.id_tugas = pt.id_tugas', 'left')
            ->where('pt.id_pemilik', $id_pendaftaran)
            ->orderBy('pt.created_at', 'DESC')
            ->get()
            ->getResultArray();

        $data = [
            'title' => 'Detail Nilai',
            'title2' => 'Detail Nilai Siswa',
            'pendaftaran' => $pendaftaran,
            'quiz_nilai' => $quiz_nilai,
            'tugas_nilai' => $tugas_nilai,
        ];
        return view('backend/superadmin/v_gradebook_detail', $data);
    }
}
