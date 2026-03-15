<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\M_siswa;
use App\Models\M_pendaftaran;
use App\Models\M_kursus;
use App\Models\M_paket;
use App\Models\M_pembayaran;
use App\Models\M_karyawan;
use App\Models\M_modul;
use App\Models\M_materi;
use App\Models\M_tugas;
use App\Models\M_quiz;
use App\Models\M_sertifikat;
use App\Models\M_postingan;
use App\Models\M_alumni;

class Home_superadmin extends BaseController
{
    protected $siswaModel;
    protected $pendaftaranModel;
    protected $kursusModel;
    protected $paketModel;
    protected $pembayaranModel;
    protected $karyawanModel;
    protected $modulModel;
    protected $materiModel;
    protected $tugasModel;
    protected $quizModel;
    protected $sertifikatModel;
    protected $postinganModel;
    protected $alumniModel;

    public function __construct()
    {
        $this->siswaModel = new M_siswa();
        $this->pendaftaranModel = new M_pendaftaran();
        $this->kursusModel = new M_kursus();
        $this->paketModel = new M_paket();
        $this->pembayaranModel = new M_pembayaran();
        $this->karyawanModel = new M_karyawan();
        $this->modulModel = new M_modul();
        $this->materiModel = new M_materi();
        $this->tugasModel = new M_tugas();
        $this->quizModel = new M_quiz();
        $this->sertifikatModel = new M_sertifikat();
        $this->postinganModel = new M_postingan();
        $this->alumniModel = new M_alumni();
    }

    public function index()
    {
        $data = [
            'title' => 'Dashboard Superadmin',
            'title2' => 'Dashboard'
        ];
        return view('backend/template_user/main', $data);
    }

    public function siswa()
    {
        $data = [
            'title' => 'Data Siswa',
            'title2' => 'Data Siswa',
            'siswa' => $this->siswaModel->findAll()
        ];
        return view('backend/superadmin/siswa/v_siswa', $data);
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

    public function kursus()
    {
        $data = [
            'title' => 'Data Kursus',
            'title2' => 'Data Kursus',
            'kursus' => $this->kursusModel->findAll()
        ];
        return view('backend/superadmin/kursus/v_kursus', $data);
    }

    public function tambah_kursus()
    {
        $data = [
            'title' => 'Tambah Kursus',
            'title2' => 'Tambah Kursus',
            'paket' => $this->paketModel->findAll()
        ];
        return view('backend/superadmin/kursus/v_tambah_kursus', $data);
    }

    public function save_kursus()
    {
        $rules = [
            'nama_kursus' => 'required|min_length[3]|max_length[100]',
            'slug' => 'required|alpha_dash|is_unique[kursus.slug]',
            'deskripsi' => 'required|min_length[10]',
            'harga' => 'required|numeric',
            'durasi' => 'required|numeric',
            'id_paket' => 'required|numeric',
            'gambar' => 'uploaded[gambar]|max_size[gambar,2048]|ext_in[gambar,jpg,jpeg,png]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', \Config\Services::validation()->getErrors());
        }

        $file = $this->request->getFile('gambar');
        $gambar = $file->getRandomName();
        $file->move('uploads/kursus', $gambar);

        $data = [
            'nama_kursus' => $this->request->getPost('nama_kursus'),
            'slug' => $this->request->getPost('slug'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'harga' => $this->request->getPost('harga'),
            'durasi' => $this->request->getPost('durasi'),
            'id_paket' => $this->request->getPost('id_paket'),
            'gambar' => $gambar,
            'status' => 'aktif',
            'tanggal_buat' => date('Y-m-d H:i:s'),
        ];

        $this->kursusModel->insert($data);
        session()->setFlashdata('success', 'Data kursus berhasil ditambahkan!');
        return redirect()->to(base_url('home_superadmin/kursus'));
    }

    public function edit_kursus($id_kursus)
    {
        $kursus = $this->kursusModel->find($id_kursus);
        if (!$kursus) {
            session()->setFlashdata('error', 'Data kursus tidak ditemukan!');
            return redirect()->to(base_url('home_superadmin/kursus'));
        }

        $data = [
            'title' => 'Edit Kursus',
            'title2' => 'Edit Kursus',
            'kursus' => $kursus,
            'paket' => $this->paketModel->findAll()
        ];
        return view('backend/superadmin/kursus/v_edit_kursus', $data);
    }

    public function update_kursus($id_kursus)
    {
        $kursus = $this->kursusModel->find($id_kursus);
        if (!$kursus) {
            session()->setFlashdata('error', 'Data kursus tidak ditemukan!');
            return redirect()->to(base_url('home_superadmin/kursus'));
        }

        $rules = [
            'nama_kursus' => 'required|min_length[3]|max_length[100]',
            'slug' => 'required|alpha_dash|is_unique[kursus.slug,id_kursus,' . $id_kursus . ']',
            'deskripsi' => 'required|min_length[10]',
            'harga' => 'required|numeric',
            'durasi' => 'required|numeric',
            'id_paket' => 'required|numeric',
        ];

        $file = $this->request->getFile('gambar');
        if ($file && $file->isValid()) {
            $rules['gambar'] = 'max_size[gambar,2048]|ext_in[gambar,jpg,jpeg,png]';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', \Config\Services::validation()->getErrors());
        }

        $data = [
            'nama_kursus' => $this->request->getPost('nama_kursus'),
            'slug' => $this->request->getPost('slug'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'harga' => $this->request->getPost('harga'),
            'durasi' => $this->request->getPost('durasi'),
            'id_paket' => $this->request->getPost('id_paket'),
        ];

        if ($file && $file->isValid()) {
            // Hapus gambar lama
            if ($kursus['gambar'] && file_exists('uploads/kursus/' . $kursus['gambar'])) {
                unlink('uploads/kursus/' . $kursus['gambar']);
            }
            
            $gambar = $file->getRandomName();
            $file->move('uploads/kursus', $gambar);
            $data['gambar'] = $gambar;
        }

        $this->kursusModel->update($id_kursus, $data);
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
        return view('backend/superadmin/pembayaran/v_pembayaran', $data);
    }

    public function postingan()
    {
        $data = [
            'title' => 'Postingan',
            'title2' => 'Postingan',
            'postingan' => $this->postinganModel->getPostinganAll()
        ];
        return view('backend/superadmin/postingan/v_postingan', $data);
    }

    public function tambah_postingan()
    {
        $data = [
            'title' => 'Tambah Postingan',
            'title2' => 'Tambah Postingan'
        ];
        return view('backend/superadmin/postingan/v_tambah_postingan', $data);
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
            'judul' => $this->request->getPost('judul'),
            'konten' => $this->request->getPost('konten'),
            'kategori' => $this->request->getPost('kategori'),
            'gambar' => $gambar,
            'status' => 'publik',
            'tanggal_buat' => date('Y-m-d H:i:s'),
            'id_pembuat' => session()->get('id_karyawan'),
        ];

        $this->postinganModel->insert($data);
        session()->setFlashdata('success', 'Postingan berhasil ditambahkan!');
        return redirect()->to(base_url('home_superadmin/postingan'));
    }

    public function alumni()
    {
        $data = [
            'title' => 'Data Alumni',
            'title2' => 'Data Alumni',
            'alumni' => $this->alumniModel->getAlumniAll()
        ];
        return view('backend/superadmin/alumni/v_alumni', $data);
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
}
