<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\M_siswa;
use App\Models\M_notifikasi;
use App\Models\M_kursus;
use App\Models\M_tugas;
use App\Models\M_pengumpulan;
use App\Models\M_pendaftaran;
use App\Models\M_quiz;
use App\Models\M_quiz_hasil;
use App\Models\M_sertifikat;
use App\Models\M_diskusi;
use App\Models\M_keranjang;
use App\Models\M_slider_promo;
use App\Models\M_paket;
use App\Models\M_modul;
use App\Models\M_materi;
use App\Models\M_progres_materi;
use App\Models\M_pembayaran;
use App\Models\M_review;
use App\Models\M_alumni;
use App\Models\M_saran;

class Home_siswa extends BaseController
{
    protected $M_siswa;
    protected $M_kursus;
    protected $M_tugas;
    protected $M_pengumpulan;
    protected $M_pendaftaran;
    protected $M_quiz;
    protected $M_quiz_hasil;
    protected $M_sertifikat;
    protected $M_diskusi;
    protected $M_keranjang;
    protected $M_slider_promo;
    protected $M_paket;
    protected $M_modul;
    protected $M_materi;
    protected $M_progres_materi;
    protected $M_review;
    protected $M_pembayaran;
    protected $M_alumni;
    protected $M_saran;
    protected $M_notifikasi;
    protected $db;

    public function __construct()
    {
        date_default_timezone_set('Asia/Jakarta');

        $this->M_siswa = new M_siswa();
        $this->M_kursus = new M_kursus();
        $this->M_tugas = new M_tugas();
        $this->M_pengumpulan = new M_pengumpulan();
        $this->M_pendaftaran = new M_pendaftaran();
        $this->M_quiz = new M_quiz();
        $this->M_quiz_hasil = new M_quiz_hasil();
        $this->M_sertifikat = new M_sertifikat();
        $this->M_diskusi = new M_diskusi();
        $this->M_keranjang = new M_keranjang();
        $this->M_slider_promo = new M_slider_promo();
        $this->M_paket = new M_paket();
        $this->M_modul = new M_modul();
        $this->M_materi = new M_materi();
        $this->M_progres_materi = new M_progres_materi();
        $this->M_review = new M_review();
        $this->M_pembayaran = new M_pembayaran();
        $this->M_alumni = new M_alumni();
        $this->M_saran = new M_saran();
        $this->M_notifikasi = new M_notifikasi();
        $this->db = \Config\Database::connect();
    }

    public function index()
    {
        $id_siswa = session()->get('id_siswa');
        if (!$id_siswa) {
            session()->setFlashdata('error', 'Anda harus login terlebih dahulu!');
            return redirect()->to(base_url('auth_login/login_siswa'));
        }

        // Hapus data pendaftaran yang melebihi batas waktu (2 jam)
        $this->M_pendaftaran->cleanupExpired();

        // Hapus data pembayaran yang pending lebih dari 2 jam
        $this->M_pembayaran->cleanupExpired();

        $profil = $this->M_siswa->get_profil($id_siswa);
        $sliders = $this->M_slider_promo->getActiveSliders();
        $enrolled = $this->M_pendaftaran->getEnrolledCoursesForDashboard($id_siswa);
        $recommendations = $this->M_kursus->getRecommendationsForDashboard($id_siswa);

        // ✅ Get list of pendaftaran IDs that already have reviews
        $reviewed_ids = [];
        $my_reviews = $this->M_review->where('id_siswa', $id_siswa)->findAll();
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
            'unread_count' => $this->M_notifikasi->getUnreadCount($id_siswa, 'siswa'),
        ];
        return view('backend/siswa/v_home_siswa', $data);
    }

    public function profil()
    {
        $id_siswa = session()->get('id_siswa');
        if (!$id_siswa) {
            session()->setFlashdata('error', 'Anda harus login terlebih dahulu!');
            return redirect()->to(base_url('auth_login/login_siswa'));
        }
        $profil = $this->M_siswa->get_profil($id_siswa);
        if (!$profil) {
            session()->setFlashdata('error', 'Profil tidak ditemukan!');
            return redirect()->to(base_url('home_siswa/profil'));
        }
        $data = ['title' => 'Data Profil', 'title2' => 'Profil Saya', 'profil' => $profil];
        return view('backend/siswa/v_profil', $data);
    }

    public function edit_profil()
    {
        $id_siswa = session()->get('id_siswa');
        if (!$id_siswa) {
            session()->setFlashdata('error', 'Anda harus login terlebih dahulu!');
            return redirect()->to(base_url('auth_login/login_siswa'));
        }
        $profil = $this->M_siswa->find($id_siswa);
        if (!$profil) {
            session()->setFlashdata('error', 'Profil tidak ditemukan!');
            return redirect()->to(base_url('home_siswa/profil'));
        }
        $data = ['title' => 'Data Profil', 'title2' => 'Profil Saya', 'data_profil' => $profil];
        return view('backend/siswa/v_edit', $data);
    }

    public function update_profil()
    {
        $id_siswa = session()->get('id_siswa');
        $profil_lama = $this->M_siswa->find($id_siswa);
        if (!$profil_lama) {
            session()->setFlashdata('error', 'Profil tidak ditemukan!');
            return redirect()->back();
        }
        $rules = [
            'email' => ['label' => 'Email', 'rules' => 'required|valid_email|max_length[100]|is_unique[siswa.email,id_siswa,' . $id_siswa . ']', 'errors' => ['required' => '{field} Wajib Diisi !!!', 'valid_email' => 'Format {field} tidak valid!', 'is_unique' => '{field} sudah digunakan oleh pengguna lain!']],
            'kata_sandi' => ['label' => 'Password', 'rules' => 'permit_empty|min_length[6]', 'errors' => ['min_length' => '{field} minimal 6 karakter!']],
            'nama_lengkap' => ['label' => 'Nama Lengkap', 'rules' => 'required|min_length[3]|max_length[100]', 'errors' => ['required' => '{field} Wajib Diisi !!!', 'min_length' => '{field} minimal 3 karakter!', 'max_length' => '{field} maksimal 100 karakter!']],
            'no_telepon' => ['label' => 'No Telepon', 'rules' => 'required|min_length[10]|max_length[15]|regex_match[/^[0-9]+$/]', 'errors' => ['required' => '{field} Wajib Diisi !!!', 'min_length' => '{field} minimal 10 digit!', 'max_length' => '{field} maksimal 15 digit!', 'regex_match' => '{field} hanya boleh berisi angka!']],
            'alamat' => ['label' => 'Alamat', 'rules' => 'permit_empty', 'errors' => ['required' => '{field} Wajib Diisi !!!']],
            'foto_profil' => ['label' => 'Foto Profil', 'rules' => 'permit_empty|max_size[foto_profil,1024]|is_image[foto_profil]|mime_in[foto_profil,image/png,image/jpg,image/jpeg,image/gif,image/webp]', 'errors' => ['max_size' => '{field} Maksimal 1 MB!', 'mime_in' => 'Format {field} harus PNG, JPG, JPEG, GIF, atau WEBP!', 'is_image' => '{field} bukan file gambar yang valid!']],
        ];
        if (!$this->validate($rules)) {
            session()->setFlashdata('errors', \Config\Services::validation()->getErrors());
            return redirect()->back()->withInput();
        }
        $foto = $this->request->getFile('foto_profil');
        $foto_profil = $profil_lama['foto_profil']; // Inisialisasi dengan foto lama
        
        if ($foto && $foto->isValid() && !$foto->hasMoved()) {
            if (!empty($profil_lama['foto_profil']) && file_exists(FCPATH . 'fotosiswa/' . $profil_lama['foto_profil'])) {
                unlink(FCPATH . 'fotosiswa/' . $profil_lama['foto_profil']);
            }
            $newName = 'siswa_' . time() . '_' . $foto->getRandomName();
            $moveResult = $foto->move(FCPATH . 'fotosiswa', $newName);
            
            if ($moveResult) {
                $foto_profil = $newName;
            }
        }
        $data = [
            'email' => $this->request->getPost('email'),
            'nama_lengkap' => $this->request->getPost('nama_lengkap'),
            'no_telepon' => $this->request->getPost('no_telepon'),
            'foto_profil' => $foto_profil
        ];
        
        // Add optional fields if they exist
        $alamat = $this->request->getPost('alamat');
        if ($alamat !== null && $alamat !== '') {
            $data['alamat'] = $alamat;
        }
        
        $tanggal_lahir = $this->request->getPost('tanggal_lahir');
        if ($tanggal_lahir !== null && $tanggal_lahir !== '') {
            $data['tanggal_lahir'] = $tanggal_lahir;
        }
        
        $password = $this->request->getPost('kata_sandi');
        if (!empty($password)) {
            $data['kata_sandi'] = $password; // Plain text sesuai request
        }
        
        $sukses = $this->M_siswa->update($id_siswa, $data);
        if ($sukses) {
            session()->set(['email' => $data['email'], 'nama_lengkap' => $data['nama_lengkap'], 'no_telepon' => $data['no_telepon'], 'foto_profil' => $data['foto_profil']]);
            // Update session for optional fields too
            if (isset($data['alamat'])) {
                session()->set('alamat', $data['alamat']);
            }
            if (isset($data['tanggal_lahir'])) {
                session()->set('tanggal_lahir', $data['tanggal_lahir']);
            }
            session()->setFlashdata('pesan', 'Data Profil Berhasil Diubah!');
            return redirect()->to(base_url('home_siswa/profil'));
        } else {
            session()->setFlashdata('error', 'Gagal Mengubah Data Profil!');
            return redirect()->to(base_url('home_siswa/edit_profil'));
        }
    }

    // ✅ Kirim Notifikasi ke Admin
    private function kirimNotifikasiKeAdmin($data_pembayaran, $siswa)
    {
        // Logic untuk mengirim notifikasi ke admin
        // Bisa ditambahkan ke tabel notifikasi atau kirim email
        log_message('info', 'Pembayaran baru: ' . $data_pembayaran['kode_invoice'] . ' oleh ' . $siswa['nama_lengkap']);
        return true;
    }

    // ✅ Kirim Notifikasi Bukti Bayar
    private function kirimNotifikasiBuktiBayar($id_pembayaran, $pembayaran, $fileName)
    {
        // Logic untuk mengirim notifikasi bukti bayar ke admin
        log_message('info', 'Bukti bayar diunggah: ' . $fileName . ' untuk pembayaran ID: ' . $id_pembayaran);
        return true;
    }

    public function checkout_noncart()
    {
        $id_siswa = session()->get('id_siswa');
        if (!$id_siswa) {
            session()->setFlashdata('error', 'Anda harus login terlebih dahulu!');
            return redirect()->to(base_url('auth_login/login_siswa'));
        }

        $id_kursus = $this->request->getPost('id_kursus');
        $id_paket = $this->request->getPost('id_paket');
        $nama_paket = $this->request->getPost('nama_paket');
        $nama_program = $this->request->getPost('nama_program');
        $harga_kursus = $this->request->getPost('harga_kursus');

        if (!$id_kursus) {
            return redirect()->to(base_url('home_siswa/kursus_saya'));
        }

        $kursus = $this->M_kursus->find($id_kursus);

        $item_checkout = [
            'id_kursus' => $id_kursus,
            'id_paket' => $id_paket,
            'nama_paket' => $nama_paket,
            'nama_program' => $nama_program,
            'harga_kursus' => $harga_kursus,
            'nama_kursus' => $kursus['nama_kursus'] ?? 'Unknown Course'
        ];

        $data = [
            'title'  => 'Checkout Pembelian',
            'title2' => 'Checkout Pembelian',
            'siswa'  => $this->M_siswa->find($id_siswa),
            'item_checkout' => $item_checkout
        ];
        return view('frontend/web/store/noncart/v_checkout', $data);
    }

    public function checkout_direct($id_paket)
    {
        $id_siswa = session()->get('id_siswa');
        if (!$id_siswa) {
            session()->setFlashdata('error', 'Anda harus login terlebih dahulu!');
            return redirect()->to(base_url('auth_login/login_siswa'));
        }

        $paket = $this->M_paket->detailPaket($id_paket);
        if (!$paket) {
            session()->setFlashdata('error', 'Paket tidak ditemukan!');
            return redirect()->to(base_url('home_website/kls_online'));
        }

        // Default to reguler price if no type specified
        $harga_kursus = $paket['harga_reguler'];

        $item_checkout = [
            'id_kursus' => $paket['id_kursus'],
            'id_paket' => $id_paket,
            'nama_paket' => $paket['nama_paket'],
            'nama_program' => $paket['nama_program'] ?? 'Kelas Online',
            'harga_kursus' => $harga_kursus,
            'nama_kursus' => $paket['nama_kursus'] ?? 'Unknown Course'
        ];

        $data = [
            'title'  => 'Checkout Pembelian',
            'title2' => 'Checkout Pembelian',
            'siswa'  => $this->M_siswa->find($id_siswa),
            'item_checkout' => $item_checkout
        ];
        return view('frontend/web/store/noncart/v_checkout', $data);
    }

    public function save_checkout_noncart()
    {
        $id_siswa = session()->get('id_siswa');
        if (!$id_siswa) {
            session()->setFlashdata('error', 'Anda harus login terlebih dahulu!');
            return redirect()->to(base_url('auth_login/login_siswa'));
        }

        $id_kursus = $this->request->getPost('id_kursus');
               $nama_paket = $this->request->getPost('nama_paket');
              $harga_kursus = $this->request->getPost('harga_kursus');

        // DEBUG: Check actual table structure
        $db = \Config\Database::connect();
        $fields = $db->getFieldNames('pendaftaran');
        
        // Log the actual fields for debugging
        log_message('debug', 'Actual table fields: ' . implode(', ', $fields));
        
        // Check if nama_paket exists
        if (!in_array('nama_paket', $fields)) {
            log_message('error', 'Field nama_paket not found in table. Available fields: ' . implode(', ', $fields));
            session()->setFlashdata('error', 'Database structure mismatch. Field nama_paket not found. Check logs for details.');
            return redirect()->back()->withInput();
        }

        $siswa = $this->M_siswa->find($id_siswa);

        // 1. Generate Kode Invoice
        $kode_invoice = 'INV-' . date('Ymd') . '-' . rand(1000, 9999);

        // 2. Create Pendaftaran Item
        $data_pendaftaran = [
            'id_siswa' => $id_siswa,
            'kode_invoice' => $kode_invoice,
            'id_kursus' => $id_kursus,
            'nama_paket' => $nama_paket,
            'harga_kursus' => $harga_kursus,
            'status' => 'pending',
            'tanggal_pendaftaran' => date('Y-m-d H:i:s'),
            // Student data (use existing student data with fallbacks)
            'email' => $siswa['email'] ?? '',
            'nama_lengkap' => $siswa['nama_lengkap'] ?? '',
            'foto_profil' => $siswa['foto_profil'] ?? '',
            'tempat_lahir' => $siswa['tempat_lahir'] ?? '',
            'tanggal_lahir' => $siswa['tanggal_lahir'] ?? null,
            'jenis_kelamin' => $siswa['jenis_kelamin'] ?? 'Laki - laki',
            'agama' => $siswa['agama'] ?? 'Islam',
            'no_telepon' => $siswa['no_telepon'] ?? '',
            'alamat' => $siswa['alamat'] ?? '',
        ];

        // Error prevention: Validate required data before insert
        // Check if student data exists
        if (!$siswa) {
            session()->setFlashdata('error', 'Data siswa tidak ditemukan');
            return redirect()->back()->withInput();
        }
        
        // Check required fields
        if (empty($id_siswa) || empty($id_kursus) || empty($nama_paket) || empty($harga_kursus)) {
            session()->setFlashdata('error', 'Data required tidak lengkap');
            return redirect()->back()->withInput();
        }
        
        // Validate harga_kursus is numeric
        if (!is_numeric($harga_kursus) || $harga_kursus <= 0) {
            session()->setFlashdata('error', 'Harga kursus tidak valid');
            return redirect()->back()->withInput();
        }
        
        // Attempt to insert data
        $insert_result = $this->M_pendaftaran->insert($data_pendaftaran);
        
        if (!$insert_result) {
            session()->setFlashdata('error', 'Gagal menyimpan data pendaftaran');
            return redirect()->back()->withInput();
        }

        // 3. OTOMATIS BUAT PEMBAYARAN PENDING AGAR NOTIFIKASI LANGSUNG MUNCUL
        $data_pembayaran = [
            'kode_invoice' => $kode_invoice,
            'kode_transaksi' => $this->M_pembayaran->generateKodeTransaksi(),
            'jumlah_bayar' => $harga_kursus,
                      'metode_pembayaran' => 'transfer_bank',
            'status_pembayaran' => 'pending',
            'tanggal_transaksi' => date('Y-m-d H:i:s'),
        ];

        $this->M_pembayaran->insert($data_pembayaran);

        // KIRIM NOTIFIKASI KE STAF ADMIN
        $this->kirimNotifikasiKeAdmin($data_pembayaran, $siswa);

        session()->setFlashdata('pesan', 'Checkout berhasil! Kode Invoice: ' . $kode_invoice);
        return redirect()->to(base_url('home_siswa/status_bayar'));
    }

    public function cart()
    {
        $id_siswa = session()->get('id_siswa');
        if (!$id_siswa) {
            session()->setFlashdata('error', 'Anda harus login terlebih dahulu!');
            return redirect()->to(base_url('auth_login/login_siswa'));
        }

        $keranjang = $this->M_keranjang->get_keranjang_siswa($id_siswa);

        // Calculate total harga
        $total_harga = 0;
        foreach ($keranjang as $item) {
            $total_harga += $item['harga_kursus'] ?? 0;
        }

        $data = [
            'title' => 'Keranjang Belanja',
            'keranjang' => $keranjang,
            'total_harga' => $total_harga,
        ];

        if (empty($keranjang)) {
            $data['empty_message'] = 'Keranjang Anda kosong. Silakan tambahkan kursus terlebih dahulu.';
        }

        return view('frontend/web/store/cart/v_keranjang', $data);
    }

    public function save_cart()
    {
        $id_siswa = session()->get('id_siswa');
        if (!$id_siswa) {
            session()->setFlashdata('error', 'Anda harus login terlebih dahulu!');
            return redirect()->to(base_url('auth_login/login_siswa'));
        }

        $id_kursus = $this->request->getPost('id_kursus');
        $id_paket = $this->request->getPost('id_paket');
        $nama_paket = $this->request->getPost('nama_paket');
        $nama_program = $this->request->getPost('nama_program');
        $gambar_detail_a = $this->request->getPost('gambar_detail_a');
        $harga_kursus = $this->request->getPost('harga_kursus');

        // Validate required fields
        if (!$id_kursus || !$harga_kursus) {
            session()->setFlashdata('error', 'Data kursus atau harga tidak valid!');
            return redirect()->back();
        }

        // Ensure harga_kursus is a valid number
        $harga_kursus = is_numeric($harga_kursus) ? (float)$harga_kursus : 0.00;

        // Cek apakah sudah ada
        $cek = $this->M_keranjang->cek_item_ada($id_siswa, $id_kursus, $id_paket, $nama_program);
        if ($cek) {
            session()->setFlashdata('info', 'Item sudah ada di keranjang!');
            return redirect()->to(base_url('home_siswa/cart'));
        }

        $data = [
            'id_siswa' => $id_siswa,
            'id_kursus' => $id_kursus,
            'id_paket' => $id_paket,
            'nama_paket' => $nama_paket,
            'nama_program' => $nama_program,
            'harga_kursus' => $harga_kursus,
            'created_at' => date('Y-m-d H:i:s')
        ];

        // Add gambar_detail_a if provided and column exists
        if ($gambar_detail_a) {
            $db = \Config\Database::connect();
            $columns = $db->getFieldNames('keranjang');
            if (in_array('gambar_detail_a', $columns)) {
                $data['gambar_detail_a'] = $gambar_detail_a;
            }
        }

        try {
            $this->M_keranjang->insert($data);
            session()->setFlashdata('pesan', 'Berhasil ditambahkan ke keranjang!');
        } catch (\Exception $e) {
            session()->setFlashdata('error', 'Gagal menambah ke keranjang: ' . $e->getMessage());
            log_message('error', 'Cart insert error: ' . $e->getMessage());
        }

        return redirect()->to(base_url('home_siswa/cart'));
    }

    public function delete_cart($id_keranjang)
    {
        $id_siswa = session()->get('id_siswa');
        if (!$id_siswa) {
            session()->setFlashdata('error', 'Anda harus login terlebih dahulu!');
            return redirect()->to(base_url('auth_login/login_siswa'));
        }

        // Pastikan milik siswa tersebut
        $item = $this->M_keranjang->find($id_keranjang);
        if ($item && $item['id_siswa'] == $id_siswa) {
            $this->M_keranjang->delete($id_keranjang);
            session()->setFlashdata('pesan', 'Berhasil dihapus dari keranjang!');
        } else {
            session()->setFlashdata('error', 'Gagal menghapus item!');
        }

        return redirect()->to(base_url('home_siswa/cart'));
    }

    public function checkout_cart()
    {
        $id_siswa = session()->get('id_siswa');
        if (!$id_siswa) {
            session()->setFlashdata('error', 'Anda harus login terlebih dahulu!');
            return redirect()->to(base_url('auth_login/login_siswa'));
        }

        // Handle POST request - get selected courses
        $selected_courses = $this->request->getPost('selected_courses') ?? [];

        // If no courses selected, redirect back
        if (empty($selected_courses)) {
            session()->setFlashdata('error', 'Pilih minimal satu kursus untuk checkout!');
            return redirect()->to(base_url('home_siswa/cart'));
        }

        // Get only selected items from keranjang
        $keranjang = $this->M_keranjang->get_keranjang_siswa($id_siswa);
        $selected_keranjang = array_filter($keranjang, function ($item) use ($selected_courses) {
            return in_array($item['id_keranjang'], $selected_courses);
        });

        if (empty($selected_keranjang)) {
            session()->setFlashdata('error', 'Keranjang Anda kosong!');
            return redirect()->to(base_url('home_siswa/cart'));
        }

        $siswa = $this->M_siswa->find($id_siswa);
        if (!$siswa) {
            session()->setFlashdata('error', 'Data siswa tidak ditemukan!');
            return redirect()->to(base_url('home_siswa/cart'));
        }

        // 1. Generate Kode Invoice
        $kode_invoice = 'INV-' . date('Ymd') . '-' . rand(1000, 9999);

        // 2. Save each selected item as a separate registration/pendaftaran linked to the invoice
        foreach ($selected_keranjang as $item) {
            $data_pendaftaran = [
                // Data siswa (tidak akan NULL)
                'nama_lengkap' => $siswa['nama_lengkap'],
                'email' => $siswa['email'],
                'no_telepon' => $siswa['no_telepon'],
                'alamat' => $siswa['alamat'],
                'tempat_lahir' => $siswa['tempat_lahir'],
                'tanggal_lahir' => $siswa['tanggal_lahir'],
                'jenis_kelamin' => $siswa['jenis_kelamin'],
                'agama' => $siswa['agama'],
                'foto_profil' => $siswa['foto_profil'],

                // Data keranjang dengan validasi
                'id_siswa' => $id_siswa,
                'kode_invoice' => $kode_invoice,
                'id_kursus' => $item['id_kursus'],
                'nama_paket' => $item['nama_paket'] ?? 'Tidak ada paket',
                'harga_kursus' => $item['harga_kursus'] ?? 0,
                'status' => 'pending',
                'progress' => 0,
                'tanggal_pendaftaran' => date('Y-m-d H:i:s'),
                'sumber_biaya' => 'Sendiri',
            ];
            $this->M_pendaftaran->insert($data_pendaftaran);
        }

        // OTOMATIS BUAT PEMBAYARAN PENDING AGAR NOTIFIKASI LANGSUNG MUNCUL
        // Hitung total dari selected items
        $total_harga = 0;
        $nama_paket_list = [];
        foreach ($selected_keranjang as $item) {
            $total_harga += $item['harga_kursus'] ?? 0;
            $nama_paket_list[] = $item['nama_paket'] ?? 'Tidak ada paket';
        }
        
        // Create ONE payment record per invoice with total amount
        $data_pembayaran = [
            'kode_invoice' => $kode_invoice,
            'kode_transaksi' => $this->M_pembayaran->generateKodeTransaksi(),
            'jumlah_bayar' => $total_harga,
                    'metode_pembayaran' => 'transfer_bank',
            'status_pembayaran' => 'pending',
            'tanggal_transaksi' => date('Y-m-d H:i:s'),
        ];

        $this->M_pembayaran->insert($data_pembayaran);

        // KIRIM NOTIFIKASI KE STAF ADMIN
        $last_payment_data = $data_pembayaran ?? [];
        $this->kirimNotifikasiKeAdmin($last_payment_data, $siswa);

        // 3. Remove only selected items from cart
        foreach ($selected_courses as $id_keranjang) {
            $this->M_keranjang->delete($id_keranjang);
        }

        session()->setFlashdata('pesan', 'Checkout berhasil! Kode Invoice: ' . $kode_invoice);
        return redirect()->to(base_url('home_siswa/status_bayar'));
    }

    public function status_bayar()
    {
        $id_siswa = session()->get('id_siswa');
        if (!$id_siswa) {
            return redirect()->to('home_siswa/login')->with('error', 'Silakan login terlebih dahulu');
        }

        // Initialize session for tracking payment status if not exists
        if (!session()->has('last_payment_status')) {
            session()->set('last_payment_status', []);
        }

        // Hapus data pembayaran yang pending lebih dari 2 jam
        $this->M_pembayaran->cleanupExpired();

        // Debug: Try simple query first
        $simple_pembayaran = $this->M_pembayaran
            ->select('pembayaran.id_pembayaran, pembayaran.kode_invoice, pembayaran.kode_transaksi, pembayaran.jumlah_bayar, pembayaran.metode_pembayaran, pembayaran.bank_tujuan, pembayaran.nama_pengirim, pembayaran.bukti_bayar, pembayaran.status_pembayaran, pembayaran.tanggal_transaksi, pembayaran.tanggal_konfirmasi, pembayaran.dikonfirmasi_oleh, pembayaran.alasan_penolakan, pembayaran.refund_amount, pembayaran.created_at, pembayaran.updated_at')
            ->where('pembayaran.status_pembayaran', 'failed')
            ->orderBy('pembayaran.tanggal_transaksi', 'DESC')
            ->findAll();
        
        log_message('debug', 'Simple query result: ' . json_encode($simple_pembayaran));
        log_message('debug', 'Simple count: ' . count($simple_pembayaran));

        // Get pembayaran data with actual course names - Group by invoice to avoid duplicates
        $pembayaran_all = $this->M_pembayaran
            ->select('pembayaran.id_pembayaran, pembayaran.kode_invoice, pembayaran.kode_transaksi, pembayaran.jumlah_bayar, pembayaran.metode_pembayaran, pembayaran.bank_tujuan, pembayaran.nama_pengirim, pembayaran.bukti_bayar, pembayaran.status_pembayaran, pembayaran.tanggal_transaksi, pembayaran.tanggal_konfirmasi, pembayaran.dikonfirmasi_oleh, pembayaran.alasan_penolakan, pembayaran.refund_amount, pembayaran.created_at, pembayaran.updated_at, GROUP_CONCAT(DISTINCT pendaftaran.nama_paket) as nama_paket, GROUP_CONCAT(DISTINCT kursus.nama_kursus) as nama_kursus')
            ->join('pendaftaran', 'pendaftaran.kode_invoice = pembayaran.kode_invoice', 'left')
            ->join('kursus', 'kursus.id_kursus = pendaftaran.id_kursus', 'left')
            ->where('pendaftaran.id_siswa', $id_siswa)
            ->whereIn('pembayaran.status_pembayaran', ['failed', 'pending'])
            ->groupBy('pembayaran.kode_invoice')
            ->orderBy('pembayaran.tanggal_transaksi', 'DESC')
            ->findAll();

        // Debug: Log hasil query
        log_message('debug', 'Student ID: ' . $id_siswa);
        log_message('debug', 'Query Result: ' . json_encode($pembayaran_all));
        log_message('debug', 'Count: ' . count($pembayaran_all));

        // Ensure all required fields exist
        foreach ($pembayaran_all as &$row) {
            // Use course name directly from pendaftaran (now grouped)
            $row['nama_paket'] = $row['nama_paket'] ?? 'Tidak ada paket';
            $row['nama_kursus'] = $row['nama_kursus'] ?? 'Kursus';
            $row['nama_program'] = 'Kelas Online'; // Default program
            $row['alasan_penolakan'] = $row['alasan_penolakan'] ?? '';
        }

        $data = [
            'title'  => 'Status Pembayaran',
            'title2' => 'Status Pembayaran',
            'pembayaran' => $pembayaran_all
        ];
        return view('frontend/web/store/v_status_bayar', $data);
    }

    public function upload_bukti($id_pembayaran)
    {
        // Get payment data first
        $pembayaran = $this->M_pembayaran->find($id_pembayaran);
        if (!$pembayaran) {
            return redirect()->back()->with('error', 'Data pembayaran tidak ditemukan');
        }

        // Get pendaftaran data using invoice
        $pendaftaran = $this->M_pendaftaran->where('kode_invoice', $pembayaran['kode_invoice'])->first();
        if (!$pendaftaran || $pendaftaran['id_siswa'] != session()->get('id_siswa')) {
            return redirect()->back()->with('error', 'Akses ditolak');
        }

        $data = [
            'title' => 'Upload Bukti Pembayaran',
            'pendaftaran' => $pendaftaran,
            'pembayaran' => $pembayaran,
        ];
        return view('frontend/web/store/v_upload_bukti', $data);
    }

    public function proses_upload()
    {
        $id_pembayaran = $this->request->getPost('id_pembayaran');
        $validation = \Config\Services::validation();

        // Buat validasi lebih fleksibel (hanya bukti_bayar yang wajib)
        $validation->setRules([
            'bukti_bayar'         => 'uploaded[bukti_bayar]|max_size[bukti_bayar,20480]|ext_in[bukti_bayar,png,jpg,jpeg,pdf]',
            'id_pembayaran'       => 'required',
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $file = $this->request->getFile('bukti_bayar');
        $fileName = time() . '_' . $file->getRandomName();
        $file->move('uploads/bukti_bayar', $fileName);

        // Get payment data
        $pembayaran = $this->M_pembayaran->find($id_pembayaran);
        if (!$pembayaran) {
            return redirect()->back()->with('error', 'Data pembayaran tidak ditemukan');
        }

        // Update existing payment
        $this->M_pembayaran->update($id_pembayaran, [
            'bank_tujuan'   => $this->request->getPost('bank_tujuan') ?: 'BCA',
            'nama_pengirim'   => $this->request->getPost('nama_pengirim') ?: 'Unknown',   
            'bukti_bayar'         => $fileName,
            'status_pembayaran'   => 'pending',
            'tanggal_transaksi'   => date('Y-m-d H:i:s'),
        ]);

        // KIRIM NOTIFIKASI KE STAF ADMIN SAAT BUKTI BAYAR DIUNGGAH
        log_message('info', 'Mulai mengirim notifikasi bukti bayar untuk pembayaran ID: ' . $id_pembayaran);
        $notifikasiResult = $this->kirimNotifikasiBuktiBayar($id_pembayaran, $pembayaran, $fileName);
        log_message('info', 'Hasil notifikasi bukti bayar: ' . ($notifikasiResult ? 'SUCCESS' : 'FAILED'));

        return redirect()->to(base_url('home_siswa/status_bayar'))->with('success', 'Bukti pembayaran berhasil dikirim! Silakan tunggu verifikasi admin.');
    }

    /**
     * AJAX: Check payment status real-time (auto-polling dari frontend)
     */
    public function check_payment_status()
    {
        $id_siswa = session()->get('id_siswa');
        if (!$id_siswa) {
            return $this->response->setJSON(['has_updates' => false]);
        }

        $last_check = session()->get('last_payment_status_check') ?? date('Y-m-d H:i:s', strtotime('-5 minutes'));
        session()->set('last_payment_status_check', date('Y-m-d H:i:s'));

        $updated = $this->M_pembayaran
            ->select('pembayaran.kode_invoice, pembayaran.status_pembayaran, pembayaran.tanggal_konfirmasi, pembayaran.alasan_penolakan')
            ->join('pendaftaran', 'pendaftaran.kode_invoice = pembayaran.kode_invoice', 'left')
            ->where('pendaftaran.id_siswa', $id_siswa)
            ->where('pembayaran.updated_at >', $last_check)
            ->whereIn('pembayaran.status_pembayaran', ['success', 'failed'])
            ->groupBy('pembayaran.kode_invoice')
            ->orderBy('pembayaran.updated_at', 'DESC')
            ->findAll();

        return $this->response->setJSON([
            'has_updates' => count($updated) > 0,
            'status_data' => $updated,
            'checked_at' => date('Y-m-d H:i:s'),
        ]);
    }

    /**
     * AJAX: Reset payment tracking session
     */
    public function reset_payment_tracking()
    {
        session()->set('last_payment_status_check', date('Y-m-d H:i:s', strtotime('-5 minutes')));
        return $this->response->setJSON(['status' => 'ok', 'message' => 'Tracking reset']);
    }

    /**
     * Halaman Notifikasi
     */
    public function notifikasi()
    {
        $id_siswa = session()->get('id_siswa');
        if (!$id_siswa) {
            return redirect()->to(base_url('auth_login/login_siswa'));
        }

        $notifikasi = $this->M_notifikasi->getByUser($id_siswa, 'siswa');
        $unread_count = $this->M_notifikasi->getUnreadCount($id_siswa, 'siswa');

        $data = [
            'title'  => 'Notifikasi',
            'title2' => 'Notifikasi',
            'notifikasi' => $notifikasi,
            'unread_count' => $unread_count,
        ];
        return view('backend/siswa/v_notifikasi', $data);
    }

    /**
     * Mark single notification as read
     */
    public function mark_read($id_notifikasi)
    {
        $id_siswa = session()->get('id_siswa');
        if (!$id_siswa) {
            return $this->response->setJSON(['status' => 'error']);
        }
        $this->M_notifikasi->markAsRead($id_notifikasi);
        return $this->response->setJSON(['status' => 'success']);
    }

    /**
     * Mark all notifications as read
     */
    public function mark_all_read()
    {
        $id_siswa = session()->get('id_siswa');
        if (!$id_siswa) {
            return $this->response->setJSON(['status' => 'error']);
        }
        $this->M_notifikasi->markAllAsRead($id_siswa, 'siswa');
        return $this->response->setJSON(['status' => 'success', 'message' => 'Semua notifikasi dibaca']);
    }

    /**
     * AJAX: Get unread notification count
     */
    public function ajax_notif_count()
    {
        $id_siswa = session()->get('id_siswa');
        if (!$id_siswa) {
            return $this->response->setJSON(['count' => 0]);
        }
        $count = $this->M_notifikasi->getUnreadCount($id_siswa, 'siswa');
        return $this->response->setJSON(['count' => $count]);
    }

    /**
     * AJAX: Load more notifications
     */
    public function ajax_load_notifikasi()
    {
        $id_siswa = session()->get('id_siswa');
        if (!$id_siswa) {
            return $this->response->setJSON(['status' => 'error']);
        }
        $offset = $this->request->getPost('offset') ?? 0;
        $notifikasi = $this->M_notifikasi->getByUser($id_siswa, 'siswa', 10, $offset);
        return $this->response->setJSON(['status' => 'success', 'notifikasi' => $notifikasi]);
    }

    /**
     * AJAX: Get notifications for sidebar
     */
    public function ajax_get_notifications()
    {
        $id_siswa = session()->get('id_siswa');
        if (!$id_siswa) {
            return $this->response->setJSON(['notifications' => []]);
        }
        $notifications = $this->M_notifikasi->getByUser($id_siswa, 'siswa', 10);
        return $this->response->setJSON(['status' => 'success', 'notifications' => $notifications]);
    }

    public function riwayat_beli()
    {
        $id_siswa = session()->get('id_siswa');
        if (!$id_siswa) {
            session()->setFlashdata('error', 'Anda harus login terlebih dahulu!');
            return redirect()->to(base_url('auth_login/login_siswa'));
        }

        $pendaftaran_all = $this->M_pendaftaran->getBySiswa($id_siswa);

        $data = [
            'title'  => 'Riwayat Pembelian',
            'title2' => 'Riwayat Pembelian',
            'pendaftaran' => $pendaftaran_all
        ];
        return view('frontend/web/store/v_riwayat_beli', $data);
    }

    public function detail_pendaftaran($id_pendaftaran)
    {
        $id_siswa = session()->get('id_siswa');
        if (!$id_siswa) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON(['error' => 'Session expired']);
            }
            return redirect()->to(base_url('auth_login/login_siswa'));
        }

        $db = \Config\Database::connect();
        $pendaftaran = $db->table('pendaftaran')
            ->select('pendaftaran.*, kursus.nama_kursus, kursus.gambar_utama, pembayaran.metode_pembayaran, siswa.nama_lengkap, siswa.email, pembayaran.status_pembayaran as status_pembelian')
            ->join('kursus', 'kursus.id_kursus = pendaftaran.id_kursus', 'left')
            ->join('pembayaran', 'pembayaran.kode_invoice = pendaftaran.kode_invoice', 'left')
            ->join('siswa', 'siswa.id_siswa = pendaftaran.id_siswa', 'left')
            ->where('pendaftaran.id_pendaftaran', $id_pendaftaran)
            ->where('pendaftaran.id_siswa', $id_siswa)
            ->get()->getRowArray();

        if (!$pendaftaran) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON(['error' => 'Data pendaftaran tidak ditemukan!']);
            }
            session()->setFlashdata('error', 'Data pendaftaran tidak ditemukan!');
            return redirect()->to(base_url('home_siswa/riwayat_beli'));
        }

        // Ambil data pembayaran terbaru jika ada
        $pembayaran = $db->table('pembayaran')
            ->where('kode_invoice', $pendaftaran['kode_invoice'] ?? '')
            ->orderBy('id_pembayaran', 'DESC')
            ->get()->getRowArray();

        $data = [
            'title' => 'Detail Pendaftaran',
            'title2' => 'Detail Pendaftaran',
            'pendaftaran' => $pendaftaran,
            'pembayaran'  => $pembayaran,
        ];

        if ($this->request->isAJAX()) {
            // Return HTML for AJAX modal
            $view = view('frontend/web/store/v_detail', $data);
            return $this->response->setJSON(['html' => $view]);
        }

        return view('frontend/web/store/v_detail', $data);
    }

    public function detail_kursus($id_kursus)
    {
        $id_siswa = session()->get('id_siswa');
        $kursus = $this->M_kursus->getKursusWithDetailById($id_kursus);
        if (!$kursus) {
            session()->setFlashdata('pesan_warning', 'Kursus tidak ditemukan!');
            return redirect()->to(base_url('home_siswa/kursus_saya'));
        }

        // Cari pendaftaran aktif untuk tombol Mulai Belajar
        $pendaftaran = $this->M_pendaftaran->where('id_siswa', $id_siswa)
            ->where('id_kursus', $id_kursus)
            ->whereIn('status', ['aktif', 'selesai'])
            ->first();

        // Get quizzes for this course
        $quizzes = $this->M_quiz->getQuizAktif($kursus['id_kursus']);
        
        // Add quiz results to quizzes if student is enrolled
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

    public function detail_kelas_saya($id_pendaftaran)
    {
        $id_siswa = session()->get('id_siswa');
        if (!$id_siswa) {
            session()->setFlashdata('error', 'Anda harus login terlebih dahulu!');
            return redirect()->to(base_url('auth_login/login_siswa'));
        }

        // Get pendaftaran data (sama seperti method belajar)
        $pendaftaran = $this->M_pendaftaran->detailDaftar($id_pendaftaran);
        if (!$pendaftaran || $pendaftaran['id_siswa'] != $id_siswa) {
            session()->setFlashdata('error', 'Kelas tidak ditemukan!');
            return redirect()->to(base_url('home_siswa/riwayat_beli'));
        }

        // Get modules with unique filtering (sama seperti belajar)
        $modul = $this->M_modul->where('id_kursus', $pendaftaran['id_kursus'])->orderBy('urutan', 'ASC')->findAll();
        $modul = $this->filterUniqueModules($modul);
        
        // Add materials and quizzes to modules
        foreach ($modul as &$m) {
            $m['materi'] = $this->M_materi->getByModul($m['id_modul'], $id_pendaftaran);
            $m['materi'] = $this->filterUniqueMaterials($m['materi']);
            $this->addQuizToModule($m, $id_pendaftaran);
        }

        // Get progress data
        $progres = $this->getProgressData($id_pendaftaran);
        
        // Calculate progress
        $progress_stats = $this->calculateProgress($modul, $progres, $id_pendaftaran);
        
        // Get tasks for this course
        $tasks = $this->M_tugas->get_tugas($pendaftaran['id_kursus']);
        
        // Get quizzes for this course
        $quizzes = $this->M_quiz->getQuizAktif($pendaftaran['id_kursus']);
        
        // Add quiz count to course data
        $pendaftaran['jumlah_quiz'] = count($quizzes);
        
        // Add submission status to tasks
        foreach ($tasks as &$task) {
            $submission = $this->db->table('pengumpulan_tugas')
                ->where('id_tugas', $task['id_tugas'])
                ->where('id_siswa', $pendaftaran['id_siswa'])
                ->get()
                ->getRowArray();
            $task['status_penilaian'] = $submission ? $submission['status_penilaian'] : 'belum_dikumpulkan';
            $task['nilai'] = $submission ? $submission['nilai'] : null;
        }
        
        // Add quiz results to quizzes
        foreach ($quizzes as &$quiz) {
            $quiz_result = $this->db->table('quiz_hasil')
                ->where('id_quiz', $quiz['id_quiz'])
                ->where('id_siswa', $pendaftaran['id_siswa'])
                ->orderBy('created_at', 'DESC')
                ->get()
                ->getRowArray();
            $quiz['is_lulus'] = $quiz_result ? ($quiz_result['status'] == 'lulus' ? 1 : 0) : 0;
            $quiz['total_nilai'] = $quiz_result ? $quiz_result['total_nilai'] : 0;
        }

        $data = [
            'title' => 'Detail Kelas Saya',
            'title2' => $pendaftaran['nama_kursus'],
            'profil' => $this->M_siswa->get_profil($id_siswa),
            'pendaftaran' => $pendaftaran,
            'modules' => $modul,
            'progres' => $progres,
            'progress_stats' => $progress_stats,
            'tasks' => $tasks,
            'quizzes' => $quizzes
        ];

        return view('backend/siswa/kursus/v_detail_kelas_saya', $data);
    }

    public function v_tugas()
    {
        $data = ['title' => 'Data Tugas', 'title2' => 'Data Tugas', 'tugas' => $this->M_tugas->get_tugas()];
        return view('backend/siswa/tugas/v_tugas', $data);
    }

    public function detail_tugas($id_tugas)
    {
        $tugas = $this->M_tugas->detailTugas($id_tugas);
        if (!$tugas) {
            session()->setFlashdata('error', 'Tugas tidak ditemukan!');
            return redirect()->to(base_url('home_siswa/v_tugas'));
        }
        $submissions = $this->M_pengumpulan->getSubmissions($id_tugas);
        $data = ['title' => 'Detail Tugas', 'title2' => 'Detail Tugas', 'tugas' => $tugas, 'submissions' => $submissions];
        return view('backend/siswa/tugas/v_dtl_tgs', $data);
    }

    public function kumpul_tugas()
    {
        $data = ['title' => 'Daftar Kumpul Tugas', 'title2' => 'Data Kumpul Tugas', 'kumpul' => $this->M_pengumpulan->get_kumpul()];
        return view('backend/siswa/kml_tgs/v_kumpul', $data);
    }

    public function add_kumpul()
    {
        $id_tugas = $this->request->getGet('id_tugas');
        $data = [
            'title' => 'Kumpul Tugas',
            'title2' => 'Data Tugas',
            'tugas' => $this->M_tugas->get_tugas(),
            'id_tugas' => $id_tugas,
        ];
        return view('backend/siswa/kml_tgs/v_add', $data);
    }

    public function save_kumpul()
    {
        $id_tugas = $this->request->getPost('id_tugas');
        $id_siswa = session()->get('id_siswa');
        if (!$id_tugas || !$id_siswa) {
            session()->setFlashdata('errors', ['Data tugas atau siswa tidak valid.']);
            return redirect()->back();
        }
        $rules = ['catatan_siswa' => ['label' => 'Catatan', 'rules' => 'required'], 'file_tugas' => ['label' => 'File Tugas', 'rules' => 'uploaded[file_tugas]|max_size[file_tugas,2048]|ext_in[file_tugas,pdf,doc,docx,txt]', 'errors' => ['uploaded' => 'File tugas wajib diunggah!', 'max_size' => 'Ukuran maksimal 2 MB!', 'ext_in' => 'Format harus PDF, DOC, DOCX, atau TXT!']]];
        if ($this->validate($rules)) {
            $file = $this->request->getFile('file_tugas');
            $namaFile = null;
            if ($file && $file->isValid()) {
                $namaFile = $file->getRandomName();
                $file->move('kursus/tugassiswa', $namaFile);
            }
            $data = ['id_tugas' => $id_tugas, 'id_siswa' => $id_siswa, 'file_tugas' => $namaFile, 'nilai' => 0, 'status_penilaian' => 'menunggu', 'tanggal_kirim' => date('Y-m-d H:i:s'), 'id_pemilik' => session()->get('id_pemilik') ?? 1];
            $this->M_pengumpulan->insert($data);
            
            // Get pendaftaran ID from the task
            $tugas_data = $this->M_tugas->find($id_tugas);
            if ($tugas_data) {
                $pendaftaran = $this->M_pendaftaran
                    ->where('id_siswa', $id_siswa)
                    ->where('id_kursus', $tugas_data['id_kursus'])
                    ->where('status', 'aktif')
                    ->first();
                if ($pendaftaran) {
                    // Update progress setelah mengumpulkan tugas
                    $this->update_total_progress($pendaftaran['id_pendaftaran']);
                }
            }
            
            session()->setFlashdata('pesan', 'Tugas berhasil dikumpulkan!');
            return redirect()->to(base_url('home_siswa/kumpul_tugas'));
        } else {
            session()->setFlashdata('errors', \Config\Services::validation()->getErrors());
            return redirect()->back()->withInput();
        }
    }

    public function edit_kumpul($id_kumpul)
    {
        $data = ['title' => 'Edit Kumpul Tugas', 'title2' => 'Data Kumpul Tugas', 'kml' => $this->M_pengumpulan->detailKumpul($id_kumpul), 'tugas' => $this->M_tugas->get_tugas()];
        return view('backend/siswa/kml_tgs/v_edit', $data);
    }

    public function update_kumpul($id_kumpul)
    {
        $id_tugas = $this->request->getPost('id_tugas');
        $id_siswa = session()->get('id_siswa');
        if (!$id_tugas || !$id_siswa) {
            session()->setFlashdata('errors', ['Data tugas atau siswa tidak valid.']);
            return redirect()->back();
        }
        $dataLama = $this->M_pengumpulan->detailKumpul($id_kumpul);
        if (!$dataLama) {
            session()->setFlashdata('errors', ['Data pengumpulan tidak ditemukan.']);
            return redirect()->to(base_url('home_siswa/kumpul_tugas'));
        }
        $rules = ['catatan_siswa' => ['label' => 'Catatan', 'rules' => 'required', 'errors' => ['required' => '{field} Wajib Diisi!']], 'nilai' => ['label' => 'Nilai Tugas', 'rules' => 'required|numeric', 'errors' => ['required' => '{field} Wajib Diisi!', 'numeric' => 'Nilai harus berupa angka!']]];
        $file = $this->request->getFile('file_tugas');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $rules['file_tugas'] = ['label' => 'File Tugas', 'rules' => 'max_size[file_tugas,2048]|ext_in[file_tugas,pdf,doc,docx,txt]', 'errors' => ['max_size' => 'Ukuran maksimal 2 MB!', 'ext_in' => 'Format harus PDF, DOC, DOCX, atau TXT!']];
        }
        if ($this->validate($rules)) {
            $dataUpdate = ['id_tugas' => $id_tugas, 'id_siswa' => $id_siswa, 'catatan_siswa' => $this->request->getPost('catatan_siswa'), 'status_penilaian' => 'menunggu', 'tanggal_kirim' => date('Y-m-d H:i:s')];
            if ($file && $file->isValid() && !$file->hasMoved()) {
                if (!empty($dataLama['file_tugas'])) {
                    $oldPath = FCPATH . 'kursus/tugassiswa/' . $dataLama['file_tugas'];
                    if (file_exists($oldPath)) unlink($oldPath);
                }
                $newName = $file->getRandomName();
                $file->move('kursus/tugassiswa', $newName);
                $dataUpdate['file_tugas'] = $newName;
            } else {
                $dataUpdate['file_tugas'] = $dataLama['file_tugas'];
            }
            $this->M_pengumpulan->edit($id_kumpul, $dataUpdate);
            
            // Get pendaftaran ID from the task
            $tugas_data = $this->M_tugas->find($id_tugas);
            if ($tugas_data) {
                $pendaftaran = $this->M_pendaftaran
                    ->where('id_siswa', $id_siswa)
                    ->where('id_kursus', $tugas_data['id_kursus'])
                    ->where('status', 'aktif')
                    ->first();
                if ($pendaftaran) {
                    // Update progress setelah mengedit pengumpulan tugas
                    $this->update_total_progress($pendaftaran['id_pendaftaran']);
                }
            }
            
            session()->setFlashdata('pesan', 'Data pengumpulan tugas berhasil diperbarui!');
            return redirect()->to(base_url('home_siswa/kumpul_tugas'));
        } else {
            session()->setFlashdata('errors', \Config\Services::validation()->getErrors());
            return redirect()->to(base_url('home_siswa/edit_kumpul/' . $id_kumpul));
        }
    }

    public function deleted_kumpul_tugas($id_kumpul)
    {
        $kml = $this->M_pengumpulan->detailKumpul($id_kumpul);
        if ($kml['file_tugas'] != "") {
            unlink('kursus/tugassiswa/' . $kml['file_tugas']);
        }
        $data = ['id_kumpul' => $id_kumpul];
        $this->M_pengumpulan->deleted_data($data);
        session()->setFlashdata('pesan', 'Data Kumpul Tugas Ini Di Hapus !');
        return redirect()->to(base_url('home_siswa/kumpul_tugas'));
    }

    public function belajar($id_pendaftaran, $id_materi = null)
    {
        $id_siswa = session()->get('id_siswa');
        if (!$id_siswa) return redirect()->to(base_url('auth_login/login_siswa'));

        // Get pendaftaran data
        $pendaftaran = $this->M_pendaftaran->detailDaftar($id_pendaftaran);
        if (!$pendaftaran || $pendaftaran['id_siswa'] != $id_siswa) {
            session()->setFlashdata('pesan_warning', 'Pendaftaran tidak ditemukan!');
            return redirect()->to(base_url('home_siswa/riwayat_beli'));
        }

        // Get modules with unique filtering
        $modul = $this->M_modul->where('id_kursus', $pendaftaran['id_kursus'])->orderBy('urutan', 'ASC')->findAll();
        $modul = $this->filterUniqueModules($modul);
        
        // Add materials and quizzes to modules
        foreach ($modul as &$m) {
            $m['materi'] = $this->M_materi->getByModul($m['id_modul']);
            $m['materi'] = $this->filterUniqueMaterials($m['materi']);
            $this->addQuizToModule($m, $id_pendaftaran);
        }

        // Get progress data
        $progres = $this->getProgressData($id_pendaftaran);
        
        // Find active material
        $materi_aktif = $this->findActiveMaterial($modul, $id_materi, $progres, $id_pendaftaran);
        
        // Get quiz data if needed
        list($quiz, $quiz_hasil) = $this->getQuizData($materi_aktif, $id_pendaftaran);
        
        // Calculate and update progress
        $progress_stats = $this->calculateProgress($modul, $progres, $id_pendaftaran);
        $this->M_pendaftaran->update($id_pendaftaran, [
            'progress' => $progress_stats['progress_percentage'],
            'last_accessed' => date('Y-m-d H:i:s')
        ]);

        $data = [
            'title' => 'Ruang Belajar',
            'title2' => $pendaftaran['nama_kursus'],
            'profil' => $this->M_siswa->get_profil($id_siswa),
            'pendaftaran' => $pendaftaran,
            'modul' => $modul,
            'progres' => $progres,
            'materi_aktif' => $materi_aktif,
            'quiz' => $quiz,
            'quiz_hasil' => $quiz_hasil,
            'progress_stats' => $progress_stats
        ];

        return view('backend/siswa/v_belajar', $data);
    }

    // Helper methods
    private function filterUniqueModules($modul)
    {
        $unique = [];
        $seen_names = [];
        $seen_ids = [];
        
        foreach ($modul as $m) {
            $name = strtolower(trim($m['nama_modul']));
            if (!in_array($name, $seen_names) && !in_array($m['id_modul'], $seen_ids)) {
                $unique[] = $m;
                $seen_names[] = $name;
                $seen_ids[] = $m['id_modul'];
            }
        }
        return $unique;
    }

    private function filterUniqueMaterials($materi)
    {
        $unique = [];
        $seen_names = [];
        $seen_ids = [];
        
        foreach ($materi as $mat) {
            $name = strtolower(trim($mat['judul_materi']));
            if (!in_array($name, $seen_names) && !in_array($mat['id_materi'], $seen_ids)) {
                $unique[] = $mat;
                $seen_names[] = $name;
                $seen_ids[] = $mat['id_materi'];
            }
        }
        return $unique;
    }

    private function addQuizToModule(&$module, $id_pendaftaran)
    {
        $quiz_data = $this->db->table('quiz')
            ->where('id_modul', $module['id_modul'])
            ->where('status', 'aktif')
            ->get()
            ->getRowArray();
            
        if ($quiz_data) {
            // Strict check: exact match only
            $quiz_title = strtolower(trim($quiz_data['judul_quiz']));
            $exists = false;
            
            foreach ($module['materi'] as $mat) {
                $materi_title = strtolower(trim($mat['judul_materi']));
                // Only exact match, not partial
                if ($materi_title === $quiz_title) {
                    $exists = true;
                    break;
                }
            }
            
            if (!$exists) {
                $quiz_result = $this->db->table('quiz_hasil')
                    ->where('id_quiz', $quiz_data['id_quiz'])
                    ->where('id_pendaftaran', $id_pendaftaran)
                    ->where('is_lulus', 1)
                    ->get()
                    ->getRowArray();
                
                $module['materi'][] = [
                    'id_materi' => 'quiz_' . $quiz_data['id_quiz'],
                    'id_modul' => $quiz_data['id_modul'],
                    'judul_materi' => $quiz_data['judul_quiz'],
                    'tipe_materi' => 'quiz',
                    'deskripsi_materi' => $quiz_data['deskripsi'] ?? 'Quiz untuk modul ini',
                    'urutan' => 999,
                    'is_completed' => $quiz_result ? 1 : 0,
                    'id_quiz' => $quiz_data['id_quiz'],
                    'durasi' => $quiz_data['durasi_menit'] ?? 30
                ];
                
                // Sort materials by urutan after adding quiz
                usort($module['materi'], function($a, $b) {
                    return $a['urutan'] - $b['urutan'];
                });
            }
        }
    }

    private function getProgressData($id_pendaftaran)
    {
        $records = $this->M_progres_materi->where('id_pendaftaran', $id_pendaftaran)->findAll();
        $progres = [];
        foreach ($records as $pr) {
            $progres[$pr['id_materi']] = $pr;
        }
        return $progres;
    }

    private function findActiveMaterial($modul, $id_materi, $progres, $id_pendaftaran)
    {
        if ($id_materi) {
            // Find specific material
            foreach ($modul as $m) {
                foreach ($m['materi'] as $mat) {
                    if ($mat['id_materi'] == $id_materi || 
                        (strpos($id_materi, 'quiz_') === 0 && $mat['id_materi'] == $id_materi)) {
                        return $mat;
                    }
                }
            }
        } else {
            // Find first incomplete material
            foreach ($modul as $m) {
                foreach ($m['materi'] as $mat) {
                    if (!$this->isMaterialCompleted($mat, $progres, $id_pendaftaran)) {
                        return $mat;
                    }
                }
            }
        }
        
        // Return first material if all completed
        return !empty($modul) ? $modul[0]['materi'][0] ?? null : null;
    }

    private function isMaterialCompleted($mat, $progres, $id_pendaftaran)
    {
        // Check regular progress
        if (isset($progres[$mat['id_materi']]) && $progres[$mat['id_materi']]['is_completed'] == 1) {
            return true;
        }
        
        // Check quiz completion
        if ($mat['tipe_materi'] == 'quiz') {
            $quiz_id = $mat['id_quiz'] ?? str_replace('quiz_', '', $mat['id_materi']);
            if ($quiz_id) {
                $result = $this->M_quiz_hasil->getNilaiTerbaik($quiz_id, $id_pendaftaran);
                return $result && $result['is_lulus'] == 1;
            }
        }
        
        return false;
    }

    private function getQuizData($materi_aktif, $id_pendaftaran)
    {
        $quiz = null;
        $quiz_hasil = null;
        
        if ($materi_aktif && $materi_aktif['tipe_materi'] == 'quiz') {
            $quiz_id = $materi_aktif['id_quiz'] ?? str_replace('quiz_', '', $materi_aktif['id_materi']);
            
            if ($quiz_id) {
                $quiz = $this->M_quiz->getQuizWithSoal($quiz_id);
                $quiz_hasil = $this->M_quiz_hasil->getNilaiTerbaik($quiz_id, $id_pendaftaran);
                
                if ($quiz && isset($quiz['soal'])) {
                    $quiz['jumlah_soal'] = count($quiz['soal']);
                    $quiz['durasi'] = $quiz['durasi_menit'] ?? 30;
                }
            }
        }
        
        return [$quiz, $quiz_hasil];
    }

    private function calculateProgress($modul, $progres, $id_pendaftaran)
    {
        // Hitung total dan completed quiz
        $total_quiz = 0;
        $completed_quiz = 0;
        foreach ($modul as $m) {
            if (isset($m['materi'])) {
                foreach ($m['materi'] as $mat) {
                    if ($mat['tipe_materi'] == 'quiz') {
                        $total_quiz++;
                        if ($this->isMaterialCompleted($mat, $progres, $id_pendaftaran)) {
                            $completed_quiz++;
                        }
                    }
                }
            }
        }
        
        // Ambil data pendaftaran untuk menghitung tugas
        $pendaftaran = $this->M_pendaftaran->find($id_pendaftaran);
        if ($pendaftaran) {
            // Hitung total tugas untuk kursus ini
            $db = \Config\Database::connect();
            $total_tugas = $db->table('tugas')
                ->where('id_kursus', $pendaftaran['id_kursus'])
                ->countAllResults();
            
            // Hitung tugas yang sudah dinilai
            $tugas_selesai = 0;
            if ($total_tugas > 0) {
                $tugas_selesai = $db->table('pengumpulan_tugas')
                    ->join('tugas', 'tugas.id_tugas = pengumpulan_tugas.id_tugas')
                    ->where('pengumpulan_tugas.id_siswa', $pendaftaran['id_siswa'])
                    ->where('tugas.id_kursus', $pendaftaran['id_kursus'])
                    ->where('pengumpulan_tugas.status_penilaian', 'dinilai')
                    ->countAllResults();
            }
        }
        
        // Hitung total materi non-quiz
        $total_materi_non_quiz = 0;
        $completed_materi_non_quiz = 0;
        foreach ($modul as $m) {
            if (isset($m['materi'])) {
                foreach ($m['materi'] as $mat) {
                    if ($mat['tipe_materi'] != 'quiz') {
                        $total_materi_non_quiz++;
                        if ($this->isMaterialCompleted($mat, $progres, $id_pendaftaran)) {
                            $completed_materi_non_quiz++;
                        }
                    }
                }
            }
        }
        
        $progress_percentage = ($total_materi_non_quiz + $total_tugas + $total_quiz) > 0 ? min(100, round(($completed_materi_non_quiz + $tugas_selesai + $completed_quiz) / ($total_materi_non_quiz + $total_tugas + $total_quiz) * 100)) : 0;
        
        return [
            'total_materials' => $total_materi_non_quiz,
            'completed_materials' => $completed_materi_non_quiz,
            'total_tasks' => $total_tugas,
            'completed_tasks' => $tugas_selesai,
            'total_quizzes' => $total_quiz,
            'completed_quizzes' => $completed_quiz,
            'progress_percentage' => $progress_percentage
        ];
    }

    public function update_progres()
    {
        $id_pendaftaran = $this->request->getPost('id_pendaftaran');
        $id_materi = $this->request->getPost('id_materi');
        $last_position = $this->request->getPost('last_position');
        $is_completed = $this->request->getPost('is_completed');

        // Log input for debugging
        log_message('debug', 'update_progres called: id_pendaftaran=' . $id_pendaftaran . ', id_materi=' . $id_materi . ', is_completed=' . $is_completed);
        
        // Validate input
        if (!$id_pendaftaran || !$id_materi) {
            log_message('error', 'Invalid parameters: id_pendaftaran=' . $id_pendaftaran . ', id_materi=' . $id_materi);
            return $this->response->setJSON(['status' => 'error', 'message' => 'Invalid parameters']);
        }

        $data = [
            'last_position' => $last_position ?? 0,
            'is_completed' => $is_completed ?? 0,
            'updated_at' => date('Y-m-d H:i:s')
        ];

        try {
            // Update progress
            $updateResult = $this->M_progres_materi->updateProgres($id_pendaftaran, $id_materi, $data);
            log_message('debug', 'Progress update result: ' . json_encode($updateResult));
            
            // Update total progress
            $this->update_total_progress($id_pendaftaran);

            return $this->response->setJSON([
                'status' => 'success', 
                'message' => 'Progress updated successfully',
                'data' => $data
            ]);
        } catch (\Exception $e) {
            log_message('error', 'Error updating progress: ' . $e->getMessage());
            log_message('error', 'Stack trace: ' . $e->getTraceAsString());
            return $this->response->setJSON([
                'status' => 'error', 
                'message' => 'Failed to update progress: ' . $e->getMessage()
            ]);
        }
    }

    // ✅ QUIZ FUNCTIONS
    public function quiz($id_kursus)
    {
        $id_siswa = session()->get('id_siswa');
        if (!$id_siswa) return redirect()->to(base_url('auth_login/login_siswa'));

        $pendaftaran = $this->M_pendaftaran->where('id_siswa', $id_siswa)->where('id_kursus', $id_kursus)->whereIn('status', ['aktif', 'selesai'])->first();
        
        if (!$pendaftaran) {
            session()->setFlashdata('error', 'Anda belum terdaftar di kursus ini!');
            return redirect()->to(base_url('home_siswa/kursus_saya'));
        }

        $quizzes = $this->M_quiz->where('id_kursus', $id_kursus)->where('status', 'aktif')->findAll();
        
        // Add jumlah_soal to each quiz
        foreach ($quizzes as &$quiz) {
            $soal_array = json_decode($quiz['soal_json'], true);
            $quiz['jumlah_soal'] = is_array($soal_array) ? count($soal_array) : 0;
            unset($quiz['soal_json']);
        }
        
        $data = [
            'title' => 'Quiz - ' . $pendaftaran['nama_paket'],
            'pendaftaran' => $pendaftaran,
            'quizzes' => $quizzes,
            'quizModel' => $this->M_quiz,
            'quizHasilModel' => $this->M_quiz_hasil
        ];
        
        return view('backend/siswa/quiz/v_quiz_list', $data);
    }

    public function kerjakan($id_quiz)
    {
        $id_siswa = session()->get('id_siswa');
        if (!$id_siswa) {
            return redirect()->to(base_url('auth_login/login_siswa'));
        }

        $quiz = $this->M_quiz->getQuizWithSoal($id_quiz);
        if (!$quiz) {
            session()->setFlashdata('error', 'Quiz tidak ditemukan!');
            return redirect()->back();
        }

        // Add jumlah_soal to quiz data
        if (isset($quiz['soal'])) {
            $quiz['jumlah_soal'] = count($quiz['soal']);
        }

        $pendaftaran = $this->M_pendaftaran->where('id_siswa', $id_siswa)->where('id_kursus', $quiz['id_kursus'])->whereIn('status', ['aktif', 'selesai'])->first();
        
        if (!$pendaftaran) {
            session()->setFlashdata('error', 'Anda belum terdaftar di kursus ini!');
            return redirect()->to(base_url('home_siswa/kursus_saya'));
        }

        $attempt = $this->M_quiz->getAttemptCount($id_quiz, $pendaftaran['id_pendaftaran']);
        
        // Check if student has passed with 70-100 score
        $bestResult = $this->M_quiz_hasil->getNilaiTerbaik($id_quiz, $pendaftaran['id_pendaftaran']);
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
        if (!$id_siswa) {
            return redirect()->to(base_url('auth_login/login_siswa'));
        }

        $quiz = $this->M_quiz->getQuizWithSoal($id_quiz);
        if (!$quiz) {
            session()->setFlashdata('error', 'Quiz tidak ditemukan!');
            return redirect()->back();
        }

        // Add jumlah_soal to quiz data
        if (isset($quiz['soal'])) {
            $quiz['jumlah_soal'] = count($quiz['soal']);
        }

        $pendaftaran = $this->M_pendaftaran->where('id_siswa', $id_siswa)->where('id_kursus', $quiz['id_kursus'])->whereIn('status', ['aktif', 'selesai'])->first();
        
        if (!$pendaftaran) {
            session()->setFlashdata('error', 'Anda belum terdaftar di kursus ini!');
            return redirect()->to(base_url('home_siswa/kursus_saya'));
        }

        $attempt = $this->M_quiz->getAttemptCount($id_quiz, $pendaftaran['id_pendaftaran']);
        
        // Check if student has passed with 70-100 score
        $bestResult = $this->M_quiz_hasil->getNilaiTerbaik($id_quiz, $pendaftaran['id_pendaftaran']);
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
            'title' => 'Kerjakan Quiz - ' . $quiz['judul_quiz'],
            'quiz' => $quiz,
            'pendaftaran' => $pendaftaran,
            'attempt' => $attempt + 1
        ];
        
        return view('frontend/siswa/quiz/v_kerjakan', $data);
    }

    public function submit()
    {
        $id_siswa = session()->get('id_siswa');
        if (!$id_siswa) return redirect()->to(base_url('auth_login/login_siswa'));

        $id_quiz = $this->request->getPost('id_quiz');
        $id_pendaftaran = $this->request->getPost('id_pendaftaran');
        
        $quiz = $this->M_quiz->find($id_quiz);
        if (!$quiz) {
            session()->setFlashdata('error', 'Quiz tidak ditemukan!');
            return redirect()->back();
        }

        $jawaban_input = $this->request->getPost('jawaban');
        $jawaban_siswa = [];
        
        if (is_array($jawaban_input)) {
            foreach ($jawaban_input as $soal_id => $j) {
                $jawaban_siswa[] = ['soal_id' => $soal_id, 'jawaban' => $j];
            }
        }

        $hasil = $this->M_quiz->hitungNilai($quiz['soal_json'], $jawaban_siswa);
        $is_lulus = ($hasil['total_nilai'] >= ($quiz['passing_grade'] ?? 70)) ? 1 : 0;

        $data_hasil = [
            'id_quiz' => $id_quiz,
            'id_pendaftaran' => $id_pendaftaran,
            'id_siswa' => $id_siswa,
            'attempt_ke' => $this->M_quiz->getAttemptCount($id_quiz, $id_pendaftaran) + 1,
            'jawaban_json' => json_encode($jawaban_siswa),
            'total_nilai' => $hasil['total_nilai'],
            'total_benar' => $hasil['total_benar'],
            'total_salah' => $hasil['total_salah'],
            'total_soal' => $hasil['total_soal'], // Tambahkan total soal
            'is_lulus' => $is_lulus,
            'waktu_mulai' => date('Y-m-d H:i:s'), // Tambahkan waktu mulai
            'waktu_selesai' => date('Y-m-d H:i:s')
        ];

        $this->M_quiz_hasil->simpanHasil($data_hasil);
        
        // Send email notification with quiz result
        $siswa_model = new \App\Models\M_siswa();
        $siswa = $siswa_model->find($id_siswa);
        if ($siswa) {
            email_hasil_quiz($siswa, $quiz, $hasil, $is_lulus);
        }

        // Update progress regardless of pass/fail status
        $this->update_total_progress($id_pendaftaran);
        
        session()->setFlashdata('pesan', 'Quiz berhasil disubmit! Nilai Anda: ' . $hasil['total_nilai']);
        return redirect()->to(base_url('home_siswa/hasil/' . $id_quiz));
    }

    public function hasil($id_quiz)
    {
        $id_siswa = session()->get('id_siswa');
        if (!$id_siswa) return redirect()->to(base_url('auth_login/login_siswa'));

        $quiz = $this->M_quiz->find($id_quiz);
        if (!$quiz) {
            session()->setFlashdata('error', 'Quiz tidak ditemukan!');
            return redirect()->to(base_url('home_siswa/kursus'));
        }

        $pendaftaran = $this->M_pendaftaran->where('id_siswa', $id_siswa)->where('id_kursus', $quiz['id_kursus'])->whereIn('status', ['aktif', 'selesai'])->first();

        if (!$pendaftaran) {
            session()->setFlashdata('error', 'Anda belum terdaftar di kursus ini!');
            return redirect()->to(base_url('home_siswa/kursus'));
        }

        $results = $this->M_quiz_hasil->getSemuaAttempt($id_quiz, $pendaftaran['id_pendaftaran']);

        $data = [
            'title' => 'Hasil Quiz - ' . $quiz['judul_quiz'],
            'title2' => 'Hasil Quiz - ' . $quiz['judul_quiz'],
            'quiz' => $quiz,
            'pendaftaran' => $pendaftaran,
            'results' => $results,
            'quizModel' => $this->M_quiz, // Pass quizModel to view
            'quizHasilModel' => $this->M_quiz_hasil // Pass quizHasilModel to view
        ];

        return view('backend/siswa/quiz/v_hasil', $data);
    }

    public function kursus_saya()
    {
        $id_siswa = session()->get('id_siswa');
        if (!$id_siswa) {
            session()->setFlashdata('error', 'Anda harus login terlebih dahulu!');
            return redirect()->to(base_url('auth_login/login_siswa'));
        }

        // Hapus data pendaftaran yang melebihi batas waktu (2 jam)
        $this->M_pendaftaran->cleanupExpired();

        // Hapus data pembayaran yang pending lebih dari 2 jam
        $this->M_pembayaran->cleanupExpired();

        $pendaftaran_all = $this->M_pendaftaran->getBySiswa($id_siswa);

        $data = [
            'title' => 'Kursus Saya',
            'title2' => 'Kursus Saya',
            'kursus' => $pendaftaran_all // Use 'kursus' variable name for view compatibility
        ];
        return view('backend/siswa/kursus/v_kursus', $data);
    }

    public function ganti_password()
    {
        $id_siswa = session()->get('id_siswa');
        if (!$id_siswa) {
            session()->setFlashdata('error', 'Anda harus login terlebih dahulu!');
            return redirect()->to(base_url('auth_login/login_siswa'));
        }

        $data = [
            'title' => 'Ganti Password',
            'title2' => 'Ganti Password'
        ];
        return view('backend/siswa/v_ganti_password', $data);
    }

    public function update_password()
    {
        $id_siswa = session()->get('id_siswa');
        if (!$id_siswa) {
            return redirect()->to(base_url('auth_login/login_siswa'));
        }

        $rules = [
            'password_lama' => 'required|min_length[6]',
            'password_baru' => 'required|min_length[6]',
            'konfirmasi_password' => 'required|matches[password_baru]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', \Config\Services::validation()->getErrors());
        }

        $siswa = $this->M_siswa->find($id_siswa);
        if (!$siswa) {
            session()->setFlashdata('error', 'Data siswa tidak ditemukan!');
            return redirect()->back();
        }

        // Verifikasi password lama
        if (!password_verify($this->request->getPost('password_lama'), $siswa['kata_sandi'])) {
            session()->setFlashdata('error', 'Password lama salah!');
            return redirect()->back();
        }

        // Update password baru
        $this->M_siswa->update($id_siswa, ['kata_sandi' => password_hash($this->request->getPost('password_baru'), PASSWORD_DEFAULT)]);

        session()->setFlashdata('pesan', 'Password berhasil diganti!');
        return redirect()->to(base_url('home_siswa/ganti-password'));
    }

    public function progress_dashboard()
    {
        $id_siswa = session()->get('id_siswa');
        if (!$id_siswa) {
            session()->setFlashdata('error', 'Anda harus login terlebih dahulu!');
            return redirect()->to(base_url('auth_login/login_siswa'));
        }

        $pendaftaran = $this->M_pendaftaran->getBySiswa($id_siswa);

        $data = [
            'title' => 'Progress Pembelajaran',
            'title2' => 'Progress Pembelajaran',
            'pendaftaran' => $pendaftaran
        ];
        return view('backend/siswa/progress/v_dashboard', $data);
    }

    public function update_progress($id_pendaftaran)
    {
        $id_siswa = session()->get('id_siswa');
        if (!$id_siswa) {
            return redirect()->to(base_url('auth_login/login_siswa'));
        }

        $progress = $this->request->getPost('progress');
        
        $this->M_pendaftaran->update($id_pendaftaran, ['progress' => $progress]);

        return redirect()->to(base_url('home_siswa/profil'))->with('success', 'Profil berhasil diperbarui!');
    }

    public function v_nilai()
    {
        $id_siswa = session()->get('id_siswa');
        if (!$id_siswa) {
            session()->setFlashdata('error', 'Anda harus login terlebih dahulu!');
            return redirect()->to(base_url('auth_login/login_siswa'));
        }

        $pendaftaran = $this->M_pendaftaran->getBySiswa($id_siswa);

        $data = [
            'title' => 'Nilai Siswa',
            'title2' => 'Nilai Siswa',
            'pendaftaran' => $pendaftaran
        ];
        return view('backend/siswa/progress/v_nilai', $data);
    }

    public function detail_nilai($id_pendaftaran)
    {
        $id_siswa = session()->get('id_siswa');
        if (!$id_siswa) {
            session()->setFlashdata('error', 'Anda harus login terlebih dahulu!');
            return redirect()->to(base_url('auth_login/login_siswa'));
        }

        $pendaftaran = $this->M_pendaftaran->detailDaftar($id_pendaftaran);
        if (!$pendaftaran || $pendaftaran['id_siswa'] != $id_siswa) {
            session()->setFlashdata('error', 'Data tidak ditemukan!');
            return redirect()->to(base_url('home_siswa/v_nilai'));
        }

        $data = [
            'title' => 'Detail Nilai',
            'title2' => 'Detail Nilai',
            'pendaftaran' => $pendaftaran
        ];
        return view('backend/siswa/progress/v_detail_nilai', $data);
    }

    public function form_daftar($id_kursus)
    {
        $id_siswa = session()->get('id_siswa');
        if (!$id_siswa) {
            session()->setFlashdata('error', 'Anda harus login terlebih dahulu!');
            return redirect()->to(base_url('auth_login/login_siswa'));
        }

        $kursus = $this->M_kursus->find($id_kursus);
        if (!$kursus) {
            session()->setFlashdata('error', 'Kursus tidak ditemukan!');
            return redirect()->to(base_url('home_website/kls_online'));
        }

        $siswa = $this->M_siswa->find($id_siswa);

        $data = [
            'title' => 'Form Pendaftaran',
            'title2' => 'Form Pendaftaran',
            'kursus' => $kursus,
            'siswa' => $siswa
        ];
        return view('backend/siswa/pendaftaran/v_form_daftar', $data);
    }

    public function simpan_pendaftaran()
    {
        $id_siswa = session()->get('id_siswa');
        if (!$id_siswa) {
            return redirect()->to(base_url('auth_login/login_siswa'));
        }

        $rules = [
            'id_kursus' => 'required',
            'nama_paket' => 'required',
            'harga_kursus' => 'required|numeric'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', \Config\Services::validation()->getErrors());
        }

        $data = [
            'id_siswa' => $id_siswa,
            'id_kursus' => $this->request->getPost('id_kursus'),
            'kode_invoice' => 'INV-' . date('Ymd') . '-' . rand(1000, 9999),
            'nama_paket' => $this->request->getPost('nama_paket'),
            'harga_kursus' => $this->request->getPost('harga_kursus'),
            'status' => 'pending',
            'tanggal_pendaftaran' => date('Y-m-d H:i:s')
        ];

        $this->M_pendaftaran->insert($data);

        session()->setFlashdata('pesan', 'Pendaftaran berhasil! Silakan lakukan pembayaran.');
        return redirect()->to(base_url('home_siswa/status_bayar'));
    }

    public function riwayat_pendaftaran()
    {
        $id_siswa = session()->get('id_siswa');
        if (!$id_siswa) {
            session()->setFlashdata('error', 'Anda harus login terlebih dahulu!');
            return redirect()->to(base_url('auth_login/login_siswa'));
        }

        $pendaftaran = $this->M_pendaftaran->getBySiswa($id_siswa);

        $data = [
            'title' => 'Riwayat Pendaftaran',
            'title2' => 'Riwayat Pendaftaran',
            'pendaftaran' => $pendaftaran
        ];
        return view('backend/siswa/pendaftaran/v_riwayat', $data);
    }

    public function ajax_update_materi_progress($id_materi)
    {
        $id_siswa = session()->get('id_siswa');
        if (!$id_siswa) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Not logged in']);
        }

        $id_pendaftaran = $this->request->getPost('id_pendaftaran');
        $is_completed = $this->request->getPost('is_completed');

        // Update progress materi
        $this->M_progres_materi->updateProgress($id_pendaftaran, $id_materi, $is_completed);

        return $this->response->setJSON(['status' => 'success']);
    }

    public function kursus_tersedia()
    {
        $id_siswa = session()->get('id_siswa');
        if (!$id_siswa) {
            session()->setFlashdata('error', 'Anda harus login terlebih dahulu!');
            return redirect()->to(base_url('auth_login/login_siswa'));
        }

        $kursus = $this->M_kursus->getKursusTersedia();

        $data = [
            'title' => 'Kursus Tersedia',
            'title2' => 'Kursus Tersedia',
            'kursus' => $kursus
        ];
        return view('backend/siswa/kursus/v_kursus_tersedia', $data);
    }

    public function akses_kursus($id_pendaftaran)
    {
        $id_siswa = session()->get('id_siswa');
        if (!$id_siswa) {
            session()->setFlashdata('error', 'Anda harus login terlebih dahulu!');
            return redirect()->to(base_url('auth_login/login_siswa'));
        }

        $pendaftaran = $this->M_pendaftaran->detailDaftar($id_pendaftaran);
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

        $pendaftaran = $this->M_pendaftaran->detailDaftar($id_pendaftaran);
        if (!$pendaftaran || $pendaftaran['id_siswa'] != $id_siswa) {
            session()->setFlashdata('error', 'Data tidak ditemukan!');
            return redirect()->to(base_url('home_siswa/kursus_saya'));
        }

        $modul = $this->M_modul->find($id_modul);

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

        $materi = $this->M_materi->getMateriWithModul($id_materi);

        $data = [
            'title' => 'View Materi',
            'title2' => 'View Materi',
            'materi' => $materi
        ];
        return view('backend/siswa/materi/v_view_materi', $data);
    }

    public function form_kumpul($id_tugas)
    {
        $id_siswa = session()->get('id_siswa');
        if (!$id_siswa) {
            session()->setFlashdata('error', 'Anda harus login terlebih dahulu!');
            return redirect()->to(base_url('auth_login/login_siswa'));
        }

        $tugas = $this->M_tugas->detailTugas($id_tugas);

        $data = [
            'title' => 'Form Kumpul Tugas',
            'title2' => 'Form Kumpul Tugas',
            'tugas' => $tugas
        ];
        return view('backend/siswa/kml_tgs/v_add', $data);
    }

    public function lihat_penilaian($id_kumpul)
    {
        $id_siswa = session()->get('id_siswa');
        if (!$id_siswa) {
            session()->setFlashdata('error', 'Anda harus login terlebih dahulu!');
            return redirect()->to(base_url('auth_login/login_siswa'));
        }

        $kumpul = $this->M_pengumpulan->detailKumpul($id_kumpul);
        if (!$kumpul || $kumpul['id_siswa'] != $id_siswa) {
            session()->setFlashdata('error', 'Data tidak ditemukan!');
            return redirect()->to(base_url('home_siswa/kumpul_tugas'));
        }

        $data = [
            'title' => 'Penilaian Tugas',
            'title2' => 'Penilaian Tugas',
            'kumpul' => $kumpul
        ];
        return view('backend/siswa/kml_tgs/v_lihat_penilaian', $data);
    }

    public function sertifikat()
    {
        $id_siswa = session()->get('id_siswa');
        if (!$id_siswa) {
            session()->setFlashdata('error', 'Anda harus login terlebih dahulu!');
            return redirect()->to(base_url('auth_login/login_siswa'));
        }

        $sertifikat = $this->M_sertifikat->getBySiswa($id_siswa);

        $data = [
            'title' => 'Sertifikat Saya',
            'title2' => 'Sertifikat Saya',
            'sertifikat' => $sertifikat
        ];
        return view('backend/siswa/sertifikat/v_index', $data);
    }

    public function view_sertifikat($id_sertifikat)
    {
        $id_siswa = session()->get('id_siswa');
        if (!$id_siswa) {
            session()->setFlashdata('error', 'Anda harus login terlebih dahulu!');
            return redirect()->to(base_url('auth_login/login_siswa'));
        }

        $sertifikat = $this->M_sertifikat->find($id_sertifikat);
        if (!$sertifikat || $sertifikat['id_siswa'] != $id_siswa) {
            session()->setFlashdata('error', 'Sertifikat tidak ditemukan!');
            return redirect()->to(base_url('home_siswa/sertifikat'));
        }

        $data = [
            'title' => 'View Sertifikat',
            'title2' => 'View Sertifikat',
            'sertifikat' => $sertifikat
        ];
        return view('backend/siswa/sertifikat/v_sertifikat', $data);
    }

    public function download_sertifikat($id_sertifikat)
    {
        $id_siswa = session()->get('id_siswa');
        if (!$id_siswa) {
            return redirect()->to(base_url('auth_login/login_siswa'));
        }

        $sertifikat = $this->M_sertifikat->find($id_sertifikat);
        if (!$sertifikat || $sertifikat['id_siswa'] != $id_siswa) {
            session()->setFlashdata('error', 'Sertifikat tidak ditemukan!');
            return redirect()->to(base_url('home_siswa/sertifikat'));
        }

        $file_path = WRITEPATH . 'uploads/sertifikat/' . $sertifikat['file_sertifikat'];
        if (file_exists($file_path)) {
            return $this->response->download($file_path, null);
        } else {
            session()->setFlashdata('error', 'File sertifikat tidak ditemukan!');
            return redirect()->to(base_url('home_siswa/sertifikat'));
        }
    }

    public function alumni()
    {
        $id_siswa = session()->get('id_siswa');
        if (!$id_siswa) {
            session()->setFlashdata('error', 'Anda harus login terlebih dahulu!');
            return redirect()->to(base_url('auth_login/login_siswa'));
        }

        $alumni = $this->M_alumni->where('id_siswa', $id_siswa)->first();

        $data = [
            'title' => 'Data Alumni',
            'title2' => 'Data Alumni',
            'alumni' => $alumni
        ];
        return view('backend/siswa/alumni/v_index', $data);
    }

    public function saran()
    {
        $id_siswa = session()->get('id_siswa');
        if (!$id_siswa) {
            session()->setFlashdata('error', 'Anda harus login terlebih dahulu!');
            return redirect()->to(base_url('auth_login/login_siswa'));
        }

        if ($this->request->getMethod() === 'POST') {
            $rules = [
                'saran' => 'required|min_length[10]|max_length[1000]'
            ];

            if (!$this->validate($rules)) {
                return redirect()->back()->withInput()->with('errors', \Config\Services::validation()->getErrors());
            }

            $data = [
                'id_siswa' => $id_siswa,
                'saran' => $this->request->getPost('saran'),
                'tanggal_saran' => date('Y-m-d H:i:s')
            ];

            $this->M_saran->insert($data);
            session()->setFlashdata('pesan', 'Saran berhasil dikirim!');
            return redirect()->to(base_url('home_siswa/saran'));
        }

        $data = [
            'title' => 'Saran & Kritik',
            'title2' => 'Saran & Kritik'
        ];
        return view('backend/siswa/saran/v_index', $data);
    }

    public function add_to_cart($id_paket = null)
    {
        if (!session()->get('id_siswa')) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Anda harus login terlebih dahulu',
                'redirect' => base_url('auth_login/login_siswa')
            ]);
        }

        if (!$id_paket) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'ID Paket tidak valid'
            ]);
        }

        $paket = $this->M_paket->find($id_paket);
        if (!$paket) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Paket tidak ditemukan'
            ]);
        }

        $id_siswa = session()->get('id_siswa');

        $existing = $this->M_keranjang->where([
            'id_siswa' => $id_siswa,
            'id_paket' => $id_paket
        ])->first();

        if ($existing) {
            return $this->response->setJSON([
                'status' => 'info',
                'message' => 'Paket sudah ada di keranjang'
            ]);
        }

        $data = [
            'id_siswa' => $id_siswa,
            'id_paket' => $id_paket,
            'jumlah' => 1,
            'tanggal' => date('Y-m-d H:i:s')
        ];

        if ($this->M_keranjang->insert($data)) {
            $cart_count = $this->M_keranjang->where('id_siswa', $id_siswa)->countAll();

            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Berhasil ditambahkan ke keranjang',
                'cart_count' => $cart_count,
                'paket_nama' => $paket['nama_paket'] ?? 'Paket Kursus'
            ]);
        } else {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Gagal menambahkan ke keranjang'
            ]);
        }
    }

    public function beli_sekarang($id_paket = null)
    {
        if (!session()->get('id_siswa')) {
            session()->setFlashdata('error', 'Anda harus login terlebih dahulu');
            return redirect()->to(base_url('auth_login/login_siswa'));
        }

        if (!$id_paket) {
            session()->setFlashdata('error', 'Paket tidak valid');
            return redirect()->back();
        }

        $paket = $this->M_paket->find($id_paket);
        if (!$paket) {
            session()->setFlashdata('error', 'Paket tidak ditemukan');
            return redirect()->back();
        }

        $this->M_keranjang->hapus_keranjang_siswa(session()->get('id_siswa'));

        $data = [
            'id_siswa' => session()->get('id_siswa'),
            'id_paket' => $id_paket,
            'jumlah' => 1,
            'tanggal' => date('Y-m-d H:i:s')
        ];

        $this->M_keranjang->insert($data);

        return redirect()->to(base_url('home_siswa/checkout'));
    }

    public function get_cart_count()
    {
        if (!session()->get('id_siswa')) {
            return $this->response->setJSON([
                'status' => 'error',
                'cart_count' => 0
            ]);
        }

        $cart_count = $this->M_keranjang->where('id_siswa', session()->get('id_siswa'))->countAll();

        return $this->response->setJSON([
            'status' => 'success',
            'cart_count' => $cart_count
        ]);
    }

    public function retry($id_quiz)
    {
        $id_siswa = session()->get('id_siswa');
        if (!$id_siswa) return redirect()->to(base_url('auth_login/login_siswa'));

        return redirect()->to(base_url('home_siswa/kerjakan/' . $id_quiz));
    }

    public function submit_quiz()
    {
        $id_pendaftaran = $this->request->getPost('id_pendaftaran');
        $id_quiz = $this->request->getPost('id_quiz');
        $id_materi = $this->request->getPost('id_materi');
        $id_siswa = session()->get('id_siswa');

        $quiz = $this->M_quiz->find($id_quiz);
        $jawaban_input = $this->request->getPost('jawaban'); // Array [soal_id => jawaban]

        // Debug: Log jawaban input
        log_message('debug', 'Jawaban Input: ' . json_encode($jawaban_input));

        $jawaban_siswa = [];
        if (!empty($jawaban_input)) {
            foreach ($jawaban_input as $soal_id => $j) {
                $jawaban_siswa[] = ['soal_id' => $soal_id, 'jawaban' => $j];
            }
        }

        // Debug: Log jawaban siswa yang akan disimpan
        log_message('debug', 'Jawaban Siswa: ' . json_encode($jawaban_siswa));

        $hasil = $this->M_quiz->hitungNilai($quiz['soal_json'], $jawaban_siswa);

        $is_lulus = ($hasil['total_nilai'] >= ($quiz['passing_grade'] ?? 70)) ? 1 : 0;

        $attempt_count = $this->M_quiz->getAttemptCount($id_quiz, $id_pendaftaran);
        $attempt_ke = $attempt_count + 1;

        // Debug: Log attempt info
        log_message('debug', 'Attempt Count: ' . $attempt_count . ', Attempt Ke: ' . $attempt_ke);

        $data_hasil = [
            'id_quiz' => $id_quiz,
            'id_pendaftaran' => $id_pendaftaran,
            'id_siswa' => $id_siswa,
            'attempt_ke' => $attempt_ke,
            'jawaban_json' => json_encode($jawaban_siswa),
            'total_nilai' => $hasil['total_nilai'],
            'total_benar' => $hasil['total_benar'],
            'total_salah' => $hasil['total_salah'],
            'is_lulus' => $is_lulus,
            'waktu_mulai' => date('Y-m-d H:i:s'), // Waktu mulai saat submit quiz
            'waktu_selesai' => date('Y-m-d H:i:s')  // Waktu selesai saat submit
        ];

        // Debug: Log data yang akan disimpan
        log_message('debug', 'Data Hasil: ' . json_encode($data_hasil));

        $this->M_quiz_hasil->insert($data_hasil);

        // Send email notification with quiz result
        $siswa_model = new \App\Models\M_siswa();
        $siswa = $siswa_model->find($id_siswa);
        if ($siswa) {
            email_hasil_quiz($siswa, $quiz, $hasil, $is_lulus);
        }

        // Update progress regardless of pass/fail status
        $this->update_total_progress($id_pendaftaran);

        return redirect()->to(base_url("home_siswa/belajar/$id_pendaftaran/$id_materi"))
            ->with($is_lulus ? 'pesan' : 'pesan_warning', $is_lulus ? 'Selamat! Anda lulus kuis.' : 'Maaf, Anda belum lulus kuis. Silakan coba lagi.');
    }

    private function getPendingCourses($id_siswa)
    {
        return $this->M_pendaftaran
            ->from('pendaftaran p')
            ->select('p.*, k.nama_kursus, k.slug')
            ->join('kursus k', 'k.id_kursus = p.id_kursus')
            ->where('p.id_siswa', $id_siswa)
            ->where('p.progress >=', 100)
            ->where('p.sertifikat_dikirim', 0)
            ->whereIn('p.status', ['aktif', 'selesai'])
            ->orderBy('p.tanggal_selesai', 'DESC')
            ->get()
            ->getResultArray();
    }

    private function update_total_progress($id_pendaftaran)
    {
        try {
            $pendaftaran = $this->M_pendaftaran->find($id_pendaftaran);
            if (!$pendaftaran) {
                log_message('error', 'Pendaftaran not found: ' . $id_pendaftaran);
                return;
            }

            // Hitung total materi (regular materials only)
            $db = \Config\Database::connect();
            $total_materi = $db->table('materi')->where('id_kursus', $pendaftaran['id_kursus'])->countAllResults();
            
            // Hitung total quiz untuk kursus ini
            $total_quiz = $db->table('quiz')
                ->join('modul', 'modul.id_modul = quiz.id_modul')
                ->where('modul.id_kursus', $pendaftaran['id_kursus'])
                ->where('quiz.status', 'aktif')
                ->countAllResults();
            
            // Hitung total tugas untuk kursus ini
            $total_tugas = $db->table('tugas')
                ->where('id_kursus', $pendaftaran['id_kursus'])
                ->countAllResults();
            
            // Hitung materi selesai (regular progress)
            $materi_selesai = $this->M_progres_materi->where('id_pendaftaran', $id_pendaftaran)
                ->where('is_completed', 1)
                ->countAllResults();
            
            // Hitung quiz yang sudah lulus
            $quiz_selesai = $db->table('quiz_hasil')
                ->join('quiz', 'quiz.id_quiz = quiz_hasil.id_quiz')
                ->join('modul', 'modul.id_modul = quiz.id_modul')
                ->where('quiz_hasil.id_pendaftaran', $id_pendaftaran)
                ->where('quiz_hasil.is_lulus', 1)
                ->where('modul.id_kursus', $pendaftaran['id_kursus'])
                ->where('quiz.status', 'aktif')
                ->countAllResults();
            
            // Hitung tugas yang sudah dinilai (selesai)
            $tugas_selesai = 0;
            if ($total_tugas > 0) {
                $tugas_selesai = $db->table('pengumpulan_tugas')
                    ->join('tugas', 'tugas.id_tugas = pengumpulan_tugas.id_tugas')
                    ->where('pengumpulan_tugas.id_siswa', $pendaftaran['id_siswa'])
                    ->where('tugas.id_kursus', $pendaftaran['id_kursus'])
                    ->where('pengumpulan_tugas.status_penilaian', 'dinilai')
                    ->countAllResults();
            }
            
            // Logika Progress Baru:
            // Base progress = materi + quiz (bisa 100% jika tidak ada tugas)
            $base_total = $total_materi + $total_quiz;
            $base_completed = $materi_selesai + $quiz_selesai;
            $base_progress = ($base_total > 0) ? round(($base_completed / $base_total) * 100, 2) : 0;
            
            // Jika ada tugas, hitung progress lengkap
            if ($total_tugas > 0) {
                // Progress dengan tugas = materi + quiz + tugas
                $total_items = $base_total + $total_tugas;
                $total_selesai = $base_completed + $tugas_selesai;
                $progress = ($total_items > 0) ? min(100, round(($total_selesai / $total_items) * 100, 2)) : 0;
            } else {
                // Jika tidak ada tugas, gunakan base progress
                $progress = min(100, $base_progress);
            }
            
            log_message('debug', 'Progress calculation - Total materi: ' . $total_materi . ', Total quiz: ' . $total_quiz . ', Total tugas: ' . $total_tugas . ', Materi selesai: ' . $materi_selesai . ', Quiz selesai: ' . $quiz_selesai . ', Tugas selesai: ' . $tugas_selesai . ', Base progress: ' . $base_progress . '%, Final progress: ' . $progress . '%');

            $data_update = ['progress' => $progress];

            // Jika progress 100%, set status selesai dan terbitkan sertifikat
            if ($progress >= 100 && $pendaftaran['status'] == 'aktif') {
                $data_update['status'] = 'selesai';
                $data_update['tanggal_selesai'] = date('Y-m-d H:i:s');

                // Terbitkan Sertifikat Otomatis (dengan error handling)
                try {
                    if (method_exists($this->M_sertifikat, 'createFromPendaftaran')) {
                        $this->M_sertifikat->createFromPendaftaran($id_pendaftaran);
                    } else {
                        log_message('warning', 'Method createFromPendaftaran not found in M_sertifikat');
                    }
                } catch (\Exception $e) {
                    log_message('error', 'Error creating certificate: ' . $e->getMessage());
                }
            }

            $this->M_pendaftaran->update($id_pendaftaran, $data_update);
            log_message('debug', 'Progress updated: ' . $progress . '% for pendaftaran ' . $id_pendaftaran);
            
        } catch (\Exception $e) {
            log_message('error', 'Error in update_total_progress: ' . $e->getMessage());
        }
    }

    // =========================================================================
    // ✅ REVIEW KURSUS
    // =========================================================================

    /**
     * Form Review - Tampilkan form review untuk pendaftaran tertentu
     * Syarat: progress >= 80% dan belum pernah review
     */
    public function form_review($id_pendaftaran)
    {
        $id_siswa = session()->get('id_siswa');
        if (!$id_siswa) return redirect()->to(base_url('auth_login/login_siswa'));

        // Validasi kepemilikan
        $pendaftaran = $this->M_pendaftaran->detailDaftar($id_pendaftaran);
        if (!$pendaftaran || $pendaftaran['id_siswa'] != $id_siswa) {
            session()->setFlashdata('pesan_warning', 'Pendaftaran tidak ditemukan!');
            return redirect()->to(base_url('home_siswa'));
        }

        // Validasi progress >= 80%
        $progress = (float) ($pendaftaran['progress'] ?? 0);
        if ($progress < 80) {
            session()->setFlashdata('pesan_warning', 'Anda harus menyelesaikan minimal 80% kursus sebelum memberikan review.');
            return redirect()->to(base_url('home_siswa'));
        }

        // Cek apakah sudah pernah review
        $existing = $this->M_review->alreadyReviewed($id_pendaftaran);
        if ($existing) {
            session()->setFlashdata('pesan_warning', 'Anda sudah memberikan review untuk kursus ini.');
            return redirect()->to(base_url('home_siswa'));
        }

        $profil = $this->M_siswa->get_profil($id_siswa);

        $data = [
            'title'  => 'Beri Review',
            'title2' => 'Review Kursus: ' . esc($pendaftaran['nama_kursus'] ?? ''),
            'profil' => $profil,
            'pendaftaran' => $pendaftaran,
        ];

        return view('backend/siswa/review/v_form_review', $data);
    }

    /**
     * Simpan Review ke database
     */
    public function simpan_review()
    {
        $id_siswa = session()->get('id_siswa');
        if (!$id_siswa) return redirect()->to(base_url('auth_login/login_siswa'));

        $id_pendaftaran = $this->request->getPost('id_pendaftaran');

        // Validasi kepemilikan
        $pendaftaran = $this->M_pendaftaran->detailDaftar($id_pendaftaran);
        if (!$pendaftaran || $pendaftaran['id_siswa'] != $id_siswa) {
            session()->setFlashdata('pesan_warning', 'Pendaftaran tidak valid!');
            return redirect()->to(base_url('home_siswa'));
        }

        // Cek duplikat
        if ($this->M_review->alreadyReviewed($id_pendaftaran)) {
            session()->setFlashdata('pesan_warning', 'Anda sudah memberikan review untuk kursus ini.');
            return redirect()->to(base_url('home_siswa'));
        }

        // Validasi input
        $rules = [
            'rating_overall' => 'required|integer|in_list[1,2,3,4,5]',
            'rating_materi'  => 'required|integer|in_list[1,2,3,4,5]',
            'rating_mentor'  => 'required|integer|in_list[1,2,3,4,5]',
            'review_title'   => 'required|min_length[5]|max_length[200]',
            'review_text'    => 'required|min_length[10]|max_length[2000]',
        ];

        if (!$this->validate($rules)) {
            session()->setFlashdata('errors', $this->validator->getErrors());
            return redirect()->back()->withInput();
        }

        $data = [
            'id_pendaftaran' => $id_pendaftaran,
            'id_kursus'      => $pendaftaran['id_kursus'],
            'id_siswa'       => $id_siswa,
            'rating_overall' => $this->request->getPost('rating_overall'),
            'rating_materi'  => $this->request->getPost('rating_materi'),
            'rating_mentor'  => $this->request->getPost('rating_mentor'),
            'review_title'   => $this->request->getPost('review_title'),
            'review_text'    => $this->request->getPost('review_text'),
            'pros'           => $this->request->getPost('pros'),
            'cons'           => $this->request->getPost('cons'),
            'is_verified'    => 1,
            'is_visible'     => 1,
        ];

        $this->M_review->insert($data);

        session()->setFlashdata('pesan', 'Terima kasih! Review Anda berhasil disimpan.');
        return redirect()->to(base_url('home_siswa'));
    }

    public function learning_path()
    {
        $id_siswa = session()->get('id_siswa');
        if (!$id_siswa) return redirect()->to(base_url('auth_login/login_siswa'));
        $pendaftaran = $this->M_pendaftaran->getBySiswa($id_siswa);
        $completed_materi = [];
        $modul_data = [];
        foreach ($pendaftaran as $p) {
            $progres = $this->M_progres_materi->getProgresPendaftaran($p['id_pendaftaran']);
            foreach ($progres as $pg) {
                if ($pg['is_completed']) $completed_materi[] = $pg['id_materi'];
            }
            $modul = $this->M_modul->where('id_kursus', $p['id_kursus'])->orderBy('urutan', 'ASC')->findAll();
            foreach ($modul as $m) {
                $materi = $this->M_materi->getByModul($m['id_modul']);
                $cc = 0;
                foreach ($materi as $mt) { foreach ($progres as $pg) { if ($pg['id_materi'] == $mt['id_materi'] && $pg['is_completed']) $cc++; } }
                $modul_data[] = ['modul' => $m, 'materi' => $materi, 'completed_materi' => $cc, 'total_materi' => count($materi), 'percentage' => count($materi) > 0 ? round(($cc / count($materi)) * 100, 2) : 0];
            }
        }
        $data = ['title' => 'Learning Path', 'title2' => 'Jalur Belajar', 'pendaftaran' => $pendaftaran, 'completed_materi' => $completed_materi, 'modul_data' => $modul_data, 'progres' => [], 'progress_percentage' => $this->M_progres_materi->getCompletionPercentage($pendaftaran[0]['id_pendaftaran'] ?? null)];
        return view('backend/siswa/v_learning_path', $data);
    }

    public function learning_path_modul($id_pendaftaran)
    {
        $id_siswa = session()->get('id_siswa');
        if (!$id_siswa) return redirect()->to(base_url('auth_login/login_siswa'));
        $pendaftaran = $this->M_pendaftaran->find($id_pendaftaran);
        if (!$pendaftaran || $pendaftaran['id_siswa'] != $id_siswa) return redirect()->to(base_url('home_siswa'));
        $modul = $this->M_modul->where('id_kursus', $pendaftaran['id_kursus'])->orderBy('urutan', 'ASC')->findAll();
        $progres = $this->M_progres_materi->getProgresPendaftaran($id_pendaftaran);
        $modul_data = [];
        foreach ($modul as $m) {
            $materi = $this->M_materi->getByModul($m['id_modul']);
            $cc = 0;
            foreach ($materi as $mt) { foreach ($progres as $pg) { if ($pg['id_materi'] == $mt['id_materi'] && $pg['is_completed']) $cc++; } }
            $modul_data[] = ['modul' => $m, 'materi' => $materi, 'completed_materi' => $cc, 'total_materi' => count($materi), 'percentage' => count($materi) > 0 ? round(($cc / count($materi)) * 100, 2) : 0];
        }
        $data = ['title' => 'Learning Path - Modul', 'title2' => 'Jalur Belajar', 'modul_data' => $modul_data, 'pendaftaran' => $pendaftaran, 'progress_percentage' => $this->M_progres_materi->getCompletionPercentage($id_pendaftaran)];
        return view('backend/siswa/v_learning_path_modul', $data);
    }

    public function learning_path_next()
    {
        $id_siswa = session()->get('id_siswa');
        if (!$id_siswa) return redirect()->to(base_url('auth_login/login_siswa'));
        $pendaftaran = $this->M_pendaftaran->getBySiswa($id_siswa);
        $next_materi = null;
        foreach ($pendaftaran as $p) {
            $modul = $this->M_modul->where('id_kursus', $p['id_kursus'])->orderBy('urutan', 'ASC')->findAll();
            foreach ($modul as $m) {
                $materi = $this->M_materi->getByModul($m['id_modul']);
                foreach ($materi as $mt) {
                    $existing = $this->M_progres_materi->where('id_pendaftaran', $p['id_pendaftaran'])->where('id_materi', $mt['id_materi'])->first();
                    if (!$existing || !$existing['is_completed']) { $next_materi = $mt; break 3; }
                }
            }
        }
        if ($next_materi) return redirect()->to(base_url('home_siswa/belajar/' . $pendaftaran[0]['id_pendaftaran'] . '/' . $next_materi['id_materi']));
        session()->setFlashdata('pesan', 'Selamat! Semua materi sudah diselesaikan.');
        return redirect()->to(base_url('home_siswa/kursus_saya'));
    }
}
