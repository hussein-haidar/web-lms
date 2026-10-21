<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\M_siswa;
use App\Models\M_pendaftaran;
use App\Models\M_kursus;
use App\Models\M_pembayaran;
use App\Models\M_tugas;
use App\Models\M_pengumpulan;
use App\Models\M_quiz;
use App\Models\M_quiz_hasil;
use App\Models\M_sertifikat;
use App\Models\M_karyawan;

class Home_karyawan extends BaseController
{
    protected $siswaModel;
    protected $pendaftaranModel;
    protected $kursusModel;
    protected $pembayaranModel;
    protected $tugasModel;
    protected $pengumpulanModel;
    protected $quizModel;
    protected $quizHasilModel;
    protected $sertifikatModel;
    protected $karyawanModel;

    public function __construct()
    {
        $this->siswaModel = new M_siswa();
        $this->pendaftaranModel = new M_pendaftaran();
        $this->kursusModel = new M_kursus();
        $this->pembayaranModel = new M_pembayaran();
        $this->tugasModel = new M_tugas();
        $this->pengumpulanModel = new M_pengumpulan();
        $this->quizModel = new M_quiz();
        $this->quizHasilModel = new M_quiz_hasil();
        $this->sertifikatModel = new M_sertifikat();
        $this->karyawanModel = new M_karyawan();
    }

    public function index()
    {
        $data = [
            'title' => 'Dashboard Admin',
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
        return view('backend/karyawan/staf_admin/siswa/v_siswa', $data);
    }

    public function tambah_siswa()
    {
        $data = [
            'title' => 'Tambah Siswa',
            'title2' => 'Tambah Siswa'
        ];
        return view('backend/karyawan/staf_admin/siswa/v_add', $data);
    }

    public function save_siswa()
    {
        $rules = [
            'nama_lengkap' => 'required|min_length[3]|max_length[100]',
            'email' => 'required|valid_email|is_unique[siswa.email]',
            'password' => 'required|min_length[6]',
            'no_telepon' => 'required|min_length[10]|max_length[15]',
            'tempat_lahir' => 'required|min_length[3]|max_length[50]',
            'tanggal_lahir' => 'required|valid_date',
            'jenis_kelamin' => 'required|in_list[L,P]',
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
            'tempat_lahir' => $this->request->getPost('tempat_lahir'),
            'tanggal_lahir' => $this->request->getPost('tanggal_lahir'),
            'jenis_kelamin' => $this->request->getPost('jenis_kelamin'),
            'alamat' => $this->request->getPost('alamat'),
            'status' => 'aktif',
            'tanggal_daftar' => date('Y-m-d H:i:s'),
        ];

        $this->siswaModel->insert($data);
        session()->setFlashdata('success', 'Data siswa berhasil ditambahkan!');
        return redirect()->to(base_url('home_karyawan/siswa'));
    }

    public function edit_siswa($id_siswa)
    {
        $siswa = $this->siswaModel->find($id_siswa);
        if (!$siswa) {
            session()->setFlashdata('error', 'Data siswa tidak ditemukan!');
            return redirect()->to(base_url('home_karyawan/siswa'));
        }

        $data = [
            'title' => 'Edit Siswa',
            'title2' => 'Edit Siswa',
            'siswa' => $siswa
        ];
        return view('backend/karyawan/staf_admin/siswa/v_edit', $data);
    }

    public function update_siswa($id_siswa)
    {
        $siswa = $this->siswaModel->find($id_siswa);
        if (!$siswa) {
            session()->setFlashdata('error', 'Data siswa tidak ditemukan!');
            return redirect()->to(base_url('home_karyawan/siswa'));
        }

        $rules = [
            'nama_lengkap' => 'required|min_length[3]|max_length[100]',
            'email' => 'required|valid_email|is_unique[siswa.email,id_siswa,' . $id_siswa . ']',
            'no_telepon' => 'required|min_length[10]|max_length[15]',
            'tempat_lahir' => 'required|min_length[3]|max_length[50]',
            'tanggal_lahir' => 'required|valid_date',
            'jenis_kelamin' => 'required|in_list[L,P]',
            'alamat' => 'required|min_length[10]|max_length[255]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', \Config\Services::validation()->getErrors());
        }

        $data = [
            'nama_lengkap' => $this->request->getPost('nama_lengkap'),
            'email' => $this->request->getPost('email'),
            'no_telepon' => $this->request->getPost('no_telepon'),
            'tempat_lahir' => $this->request->getPost('tempat_lahir'),
            'tanggal_lahir' => $this->request->getPost('tanggal_lahir'),
            'jenis_kelamin' => $this->request->getPost('jenis_kelamin'),
            'alamat' => $this->request->getPost('alamat'),
        ];

        $password = $this->request->getPost('password');
        if (!empty($password)) {
            $data['password'] = password_hash($password, PASSWORD_DEFAULT);
        }

        $this->siswaModel->update($id_siswa, $data);
        session()->setFlashdata('success', 'Data siswa berhasil diperbarui!');
        return redirect()->to(base_url('home_karyawan/siswa'));
    }

    public function delete_siswa($id_siswa)
    {
        $siswa = $this->siswaModel->find($id_siswa);
        if (!$siswa) {
            session()->setFlashdata('error', 'Data siswa tidak ditemukan!');
            return redirect()->to(base_url('home_karyawan/siswa'));
        }

        $this->siswaModel->delete($id_siswa);
        session()->setFlashdata('success', 'Data siswa berhasil dihapus!');
        return redirect()->to(base_url('home_karyawan/siswa'));
    }

    public function pembayaran()
    {
        $data = [
            'title' => 'Verifikasi Pembayaran',
            'title2' => 'Verifikasi Pembayaran',
            'pembayaran' => $this->pembayaranModel->getPendingPayments()
        ];
        return view('backend/karyawan/staf_admin/pembayaran/v_pembayaran', $data);
    }

    public function verifikasi_pembayaran($id_pembayaran)
    {
        $pembayaran = $this->pembayaranModel->find($id_pembayaran);
        if (!$pembayaran) {
            session()->setFlashdata('error', 'Data pembayaran tidak ditemukan!');
            return redirect()->to(base_url('home_karyawan/pembayaran'));
        }

        $pendaftaran = $this->pendaftaranModel->where('kode_invoice', $pembayaran['kode_invoice'])->first();
        if (!$pendaftaran) {
            session()->setFlashdata('error', 'Data pendaftaran tidak ditemukan!');
            return redirect()->to(base_url('home_karyawan/pembayaran'));
        }

        $siswa = $this->siswaModel->find($pendaftaran['id_siswa']);
        if (!$siswa) {
            session()->setFlashdata('error', 'Data siswa tidak ditemukan!');
            return redirect()->to(base_url('home_karyawan/pembayaran'));
        }

        $data = [
            'title' => 'Verifikasi Pembayaran',
            'title2' => 'Verifikasi Pembayaran',
            'pembayaran' => $pembayaran,
            'pendaftaran' => $pendaftaran,
            'siswa' => $siswa
        ];
        return view('backend/karyawan/staf_admin/pembayaran/v_pembayaran', $data);
    }

    public function proses_verifikasi()
    {
        $id_pembayaran = $this->request->getPost('id_pembayaran');
        $status = $this->request->getPost('status');
        $alasan_penolakan = $this->request->getPost('alasan_penolakan');

        $pembayaran = $this->pembayaranModel->find($id_pembayaran);
        if (!$pembayaran) {
            session()->setFlashdata('error', 'Data pembayaran tidak ditemukan!');
            return redirect()->to(base_url('home_karyawan/pembayaran'));
        }

        $pendaftaran = $this->pendaftaranModel->where('kode_invoice', $pembayaran['kode_invoice'])->first();
        if (!$pendaftaran) {
            session()->setFlashdata('error', 'Data pendaftaran tidak ditemukan!');
            return redirect()->to(base_url('home_karyawan/pembayaran'));
        }

        $siswa = $this->siswaModel->find($pendaftaran['id_siswa']);
        if (!$siswa) {
            session()->setFlashdata('error', 'Data siswa tidak ditemukan!');
            return redirect()->to(base_url('home_karyawan/pembayaran'));
        }

        // Update status pembayaran
        $this->pembayaranModel->update($id_pembayaran, [
            'status_pembayaran' => $status,
            'alasan_penolakan' => $alasan_penolakan,
            'tanggal_verifikasi' => date('Y-m-d H:i:s'),
            'id_verifikator' => session()->get('id_karyawan'),
        ]);

        // Update status pendaftaran
        if ($status == 'success') {
            $this->pendaftaranModel->update($pendaftaran['id_pendaftaran'], [
                'status' => 'aktif',
                'tanggal_aktif' => date('Y-m-d H:i:s'),
            ]);

            // Kirim notifikasi pembayaran disetujui
            $this->kirimNotifikasiPembayaranDisetujui($siswa, $pendaftaran, $pembayaran);
            session()->setFlashdata('success', 'Pembayaran berhasil disetujui!');
        } else {
            $this->pendaftaranModel->update($pendaftaran['id_pendaftaran'], [
                'status' => 'pending',
            ]);

            // Kirim notifikasi penolakan
            $this->kirimNotifikasiPenolakan($siswa, $pendaftaran, $alasan_penolakan);
            session()->setFlashdata('success', 'Pembayaran berhasil ditolak!');
        }

        return redirect()->to(base_url('home_karyawan/pembayaran'));
    }

    /**
     * Kirim notifikasi pembayaran disetujui ke siswa
     */
    private function kirimNotifikasiPembayaranDisetujui($siswa, $pendaftaran, $payment)
    {
        return email_pembayaran_disetujui($siswa, $pendaftaran, $payment);
    }

    /**
     * Kirim notifikasi penolakan pembayaran
     */
    private function kirimNotifikasiPenolakan($siswa, $pendaftaran, $alasan)
    {
        return email_pembayaran_ditolak($siswa, $pendaftaran, $alasan);
    }

    public function kursus()
    {
        $data = [
            'title' => 'Data Kursus',
            'title2' => 'Data Kursus',
            'kursus' => $this->kursusModel->findAll()
        ];
        return view('backend/karyawan/pengajar/kursus/v_kursus', $data);
    }

    public function sertifikat()
    {
        $data = [
            'title' => 'Data Sertifikat',
            'title2' => 'Data Sertifikat',
            'sertifikat' => $this->sertifikatModel->getSertifikatAll()
        ];
        return view('backend/karyawan/staf_admin/sertifikat/v_index', $data);
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
            'title' => 'Profil Admin',
            'title2' => 'Profil Admin',
            'karyawan' => $karyawan
        ];
        return view('backend/karyawan/profil/v_profil', $data);
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
            return redirect()->to(base_url('home_karyawan/profil'));
        }

        $data = [
            'title' => 'Edit Profil',
            'title2' => 'Edit Profil',
            'karyawan' => $karyawan
        ];
        return view('backend/karyawan/profil/v_edit', $data);
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
            return redirect()->to(base_url('home_karyawan/profil'));
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

        return redirect()->to(base_url('home_karyawan/profil'))->with('success', 'Profil berhasil diperbarui!');
    }

    // STAF ADMIN METHODS
    public function home_staf()
    {
        // Get statistics data
        $total_siswa = $this->siswaModel->countAll();
        $total_karyawan = $this->karyawanModel->countAll();
        $total_kursus = $this->kursusModel->countAll();
        $pembayaran_pending = $this->pembayaranModel->where('status_pembayaran', 'pending')->countAllResults();
        
        // Get pendaftaran statistics
        $total_pendaftaran = $this->pendaftaranModel->countAll();
        $pendaftaran_aktif = $this->pendaftaranModel->where('status', 'aktif')->countAllResults();
        $pendaftaran_pending = $this->pendaftaranModel->where('status', 'pending')->countAllResults();
        $pembayaran_success = $this->pembayaranModel->where('status_pembayaran', 'success')->countAllResults();
        
        $data = [
            'title' => 'Dashboard Staf Admin',
            'title2' => 'Dashboard Staf Admin',
            'total_siswa' => $total_siswa,
            'total_karyawan' => $total_karyawan,
            'total_kursus' => $total_kursus,
            'pembayaran_pending' => $pembayaran_pending,
            'total_pendaftaran' => $total_pendaftaran,
            'pendaftaran_aktif' => $pendaftaran_aktif,
            'pendaftaran_pending' => $pendaftaran_pending,
            'pembayaran_success' => $pembayaran_success
        ];
        return view('backend/karyawan/staf_admin/v_home_staf', $data);
    }

    public function siswa_admin()
    {
        // Get siswa with pendaftaran data
        $siswaWithPendaftaran = $this->siswaModel->getSiswaWithPendaftaran();
        
        // Add payment information for each student
        foreach ($siswaWithPendaftaran as &$siswa) {
            // Get total payments for this student
            $totalBayar = $this->pembayaranModel->db->table('pembayaran p')
                ->join('pendaftaran pd', 'p.kode_invoice = pd.kode_invoice')
                ->where('pd.id_siswa', $siswa['id_siswa'])
                ->where('p.status_pembayaran', 'success')
                ->selectSum('p.jumlah_bayar')
                ->get()
                ->getRowArray();
            
            $siswa['jumlah_bayar'] = $totalBayar['jumlah_bayar'] ?? 0;
        }
        
        $data = [
            'title' => 'Data Siswa',
            'title2' => 'Data Siswa',
            'siswa' => $siswaWithPendaftaran
        ];
        return view('backend/karyawan/staf_admin/siswa/v_siswa', $data);
    }

    public function add_siswa()
    {
        $data = [
            'title' => 'Tambah Siswa',
            'title2' => 'Tambah Siswa'
        ];
        return view('backend/karyawan/staf_admin/siswa/v_add', $data);
    }

    public function deleted_siswa($id_siswa)
    {
        $siswa = $this->siswaModel->find($id_siswa);
        if (!$siswa) {
            session()->setFlashdata('error', 'Data siswa tidak ditemukan!');
            return redirect()->to(base_url('home_karyawan/siswa_admin'));
        }

        $this->siswaModel->delete($id_siswa);
        session()->setFlashdata('pesan', 'Data siswa berhasil dihapus!');
        return redirect()->to(base_url('home_karyawan/siswa_admin'));
    }

    public function restore_siswa($id_siswa)
    {
        $siswa = $this->siswaModel->withDeleted()->find($id_siswa);
        if (!$siswa) {
            session()->setFlashdata('error', 'Data siswa tidak ditemukan!');
            return redirect()->to(base_url('home_karyawan/siswa_admin'));
        }

        $this->siswaModel->restore($id_siswa);
        session()->setFlashdata('pesan', 'Data siswa berhasil dipulihkan!');
        return redirect()->to(base_url('home_karyawan/siswa_admin'));
    }

    public function force_delete_siswa($id_siswa)
    {
        $siswa = $this->siswaModel->withDeleted()->find($id_siswa);
        if (!$siswa) {
            session()->setFlashdata('error', 'Data siswa tidak ditemukan!');
            return redirect()->to(base_url('home_karyawan/siswa_admin'));
        }

        $this->siswaModel->purgeDeleted($id_siswa);
        session()->setFlashdata('pesan', 'Data siswa berhasil dihapus permanen!');
        return redirect()->to(base_url('home_karyawan/siswa_admin'));
    }

    public function pendaftaran()
    {
        $data = [
            'title' => 'Data Pendaftaran',
            'title2' => 'Data Pendaftaran',
            'pendaftaran' => $this->pendaftaranModel->getPendaftaranWithSiswa()
        ];
        return view('backend/karyawan/staf_admin/pendaftaran/v_pendaftaran', $data);
    }

    public function edit_daftar($id_pendaftaran)
    {
        $pendaftaran = $this->pendaftaranModel->find($id_pendaftaran);
        if (!$pendaftaran) {
            session()->setFlashdata('error', 'Data pendaftaran tidak ditemukan!');
            return redirect()->to(base_url('home_karyawan/pendaftaran'));
        }

        $data = [
            'title' => 'Edit Pendaftaran',
            'title2' => 'Edit Pendaftaran',
            'pendaftaran' => $pendaftaran
        ];
        return view('backend/karyawan/staf_admin/pendaftaran/v_edit', $data);
    }

    public function update_daftar($id_pendaftaran)
    {
        $pendaftaran = $this->pendaftaranModel->find($id_pendaftaran);
        if (!$pendaftaran) {
            session()->setFlashdata('error', 'Data pendaftaran tidak ditemukan!');
            return redirect()->to(base_url('home_karyawan/pendaftaran'));
        }

        $data = [
            'status' => $this->request->getPost('status'),
            'progress' => $this->request->getPost('progress')
        ];

        $this->pendaftaranModel->update($id_pendaftaran, $data);
        session()->setFlashdata('pesan', 'Data pendaftaran berhasil diperbarui!');
        return redirect()->to(base_url('home_karyawan/pendaftaran'));
    }

    public function update_status_pendaftaran($id_pendaftaran)
    {
        $pendaftaran = $this->pendaftaranModel->find($id_pendaftaran);
        if (!$pendaftaran) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Data tidak ditemukan']);
        }

        $status = $this->request->getPost('status');
        $this->pendaftaranModel->update($id_pendaftaran, ['status' => $status]);

        return $this->response->setJSON(['status' => 'success', 'message' => 'Status berhasil diperbarui']);
    }

    public function simpan_daftar()
    {
        $rules = [
            'id_siswa' => 'required',
            'id_kursus' => 'required',
            'nama_paket' => 'required',
            'harga_kursus' => 'required|numeric'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', \Config\Services::validation()->getErrors());
        }

        $data = [
            'id_siswa' => $this->request->getPost('id_siswa'),
            'id_kursus' => $this->request->getPost('id_kursus'),
            'kode_invoice' => 'INV-' . date('Ymd') . '-' . rand(1000, 9999),
            'nama_paket' => $this->request->getPost('nama_paket'),
            'harga_kursus' => $this->request->getPost('harga_kursus'),
            'status' => 'pending',
            'tanggal_pendaftaran' => date('Y-m-d H:i:s')
        ];

        $this->pendaftaranModel->insert($data);
        session()->setFlashdata('pesan', 'Pendaftaran berhasil ditambahkan!');
        return redirect()->to(base_url('home_karyawan/pendaftaran'));
    }

    public function hapus_daftar($id_pendaftaran)
    {
        $pendaftaran = $this->pendaftaranModel->find($id_pendaftaran);
        if (!$pendaftaran) {
            session()->setFlashdata('error', 'Data pendaftaran tidak ditemukan!');
            return redirect()->to(base_url('home_karyawan/pendaftaran'));
        }

        $this->pendaftaranModel->delete($id_pendaftaran);
        session()->setFlashdata('pesan', 'Data pendaftaran berhasil dihapus!');
        return redirect()->to(base_url('home_karyawan/pendaftaran'));
    }

    public function konfirmasi($id_pembayaran)
    {
        $pembayaran = $this->pembayaranModel->find($id_pembayaran);
        if (!$pembayaran) {
            session()->setFlashdata('error', 'Data pembayaran tidak ditemukan!');
            return redirect()->to(base_url('home_karyawan/pembayaran'));
        }

        $data = [
            'status_pembayaran' => 'success',
            'tanggal_konfirmasi' => date('Y-m-d H:i:s')
        ];

        $this->pembayaranModel->update($id_pembayaran, $data);

        // Update status pendaftaran
        $this->pendaftaranModel->where('kode_invoice', $pembayaran['kode_invoice'])->update(['status' => 'aktif']);

        session()->setFlashdata('pesan', 'Pembayaran berhasil dikonfirmasi!');
        return redirect()->to(base_url('home_karyawan/pembayaran'));
    }

    public function detail($id_pembayaran)
    {
        // Get payment with related data
        $pembayaran = $this->pembayaranModel->getPaymentWithDetails($id_pembayaran);
        if (!$pembayaran) {
            session()->setFlashdata('error', 'Data pembayaran tidak ditemukan!');
            return redirect()->to(base_url('home_karyawan/pembayaran'));
        }

        $data = [
            'title' => 'Detail Pembayaran',
            'title2' => 'Detail Pembayaran',
            'payment' => $pembayaran,
            'pendaftaran' => $pembayaran // Use payment data as pendaftaran since it contains all needed info
        ];
        return view('backend/karyawan/staf_admin/pembayaran/v_detail', $data);
    }

    public function check_notification_count()
    {
        $id_karyawan = session()->get('id_karyawan');
        if (!$id_karyawan) {
            return $this->response->setJSON(['count' => 0]);
        }

        $count = $this->pembayaranModel->where('status_pembayaran', 'pending')->countAll();

        return $this->response->setJSON(['count' => $count]);
    }

    public function check_payment_updates()
    {
        $id_karyawan = session()->get('id_karyawan');
        if (!$id_karyawan) {
            return $this->response->setJSON(['has_updates' => false]);
        }

        $pending = $this->pembayaranModel->where('status_pembayaran', 'pending')->countAll();
        $lastChecked = session()->get('last_payment_check') ?? 0;

        if ($pending > $lastChecked) {
            session()->set('last_payment_check', $pending);
            return $this->response->setJSON(['has_updates' => true, 'count' => $pending]);
        }

        return $this->response->setJSON(['has_updates' => false]);
    }

    // PENGAJAR METHODS
    public function home_pengajar()
    {
        $db = \Config\Database::connect();
        $id_karyawan = session()->get('id_karyawan');
        
        // Get statistics data for pengajar
        $total_siswa = $this->siswaModel->countAll();
        $total_kursus = $this->kursusModel->countAll();
        $kursus_aktif = $this->kursusModel->where('status', 'aktif')->countAllResults();
        $siswa_aktif = $this->pendaftaranModel->where('status', 'aktif')->countAllResults();
        
        // Get tugas statistics
        $total_tugas = $db->table('tugas')->countAllResults();
        $tugas_dinilai = $db->table('pengumpulan_tugas')->where('nilai IS NOT NULL', null, false)->countAllResults();
        $tugas_pending = $total_tugas - $tugas_dinilai;
        
        // Quiz statistics
        $total_quiz = $db->table('quiz')->countAllResults();
        $quiz_taken = $db->table('quiz_hasil')->countAllResults();
        
        // Average grade per course (Chart data)
        $avg_grades = $db->table('quiz_hasil qh')
            ->select('q.judul_quiz as nama, AVG(qh.total_nilai) as avg_nilai')
            ->join('quiz q', 'q.id_quiz = qh.id_quiz')
            ->groupBy('qh.id_quiz')
            ->orderBy('AVG(qh.total_nilai)', 'DESC')
            ->limit(8)
            ->get()
            ->getResultArray();
        
        // Recent submissions pending grading
        $recent_submissions = $db->table('pengumpulan_tugas pt')
            ->select('pt.*, s.nama_lengkap as nama_siswa, t.judul as judul_tugas')
            ->join('siswa s', 's.id_siswa = pt.id_siswa')
            ->join('tugas t', 't.id_tugas = pt.id_tugas')
            ->where('pt.nilai IS NULL', null, false)
            ->orderBy('pt.tanggal_kumpul', 'DESC')
            ->limit(5)
            ->get()
            ->getResultArray();
        
        // Student performance distribution
        $performance = [
            'lulus' => $db->table('quiz_hasil')->where('is_lulus', 1)->countAllResults(),
            'tidak_lulus' => $db->table('quiz_hasil')->where('is_lulus', 0)->countAllResults(),
        ];
        
        $data = [
            'title' => 'Dashboard Pengajar',
            'title2' => 'Dashboard Pengajar',
            'total_siswa' => $total_siswa,
            'total_kursus' => $total_kursus,
            'kursus_aktif' => $kursus_aktif,
            'siswa_aktif' => $siswa_aktif,
            'total_tugas' => $total_tugas,
            'tugas_dinilai' => $tugas_dinilai,
            'tugas_pending' => $tugas_pending,
            'total_quiz' => $total_quiz,
            'quiz_taken' => $quiz_taken,
            'avg_grades' => $avg_grades,
            'recent_submissions' => $recent_submissions,
            'performance' => $performance,
        ];
        return view('backend/karyawan/pengajar/v_home_pengajar', $data);
    }

    public function kursus_pengajar()
    {
        $id_karyawan = session()->get('id_karyawan');
        $data = [
            'title' => 'Kursus Saya',
            'title2' => 'Kursus Saya',
            'kursus' => $this->pendaftaranModel->getKursusByPengajar($id_karyawan)
        ];
        return view('backend/karyawan/pengajar/kursus/v_kursus', $data);
    }

    public function detail_kursus($id_kursus)
    {
        $kursus = $this->pendaftaranModel->getKursusWithDetail($id_kursus);
        if (!$kursus) {
            session()->setFlashdata('error', 'Data kursus tidak ditemukan!');
            return redirect()->back();
        }

        $data = [
            'title' => 'Detail Kursus',
            'title2' => 'Detail Kursus',
            'kursus' => $kursus
        ];
        return view('backend/karyawan/pengajar/kursus/v_detail_kursus', $data);
    }

    public function siswa_pengajar()
    {
        $id_karyawan = session()->get('id_karyawan');
        $data = [
            'title' => 'Data Siswa',
            'title2' => 'Data Siswa',
            'siswa' => $this->pendaftaranModel->getSiswaByPengajar($id_karyawan)
        ];
        return view('backend/karyawan/pengajar/siswa/v_siswa', $data);
    }

    public function tugas()
    {
        $id_karyawan = session()->get('id_karyawan');
        $data = [
            'title' => 'Data Tugas',
            'title2' => 'Data Tugas',
            'tugas' => $this->pendaftaranModel->getTugasByPengajar($id_karyawan)
        ];
        return view('backend/karyawan/pengajar/kursus/tugas/v_tugas', $data);
    }

    public function add_tugas()
    {
        $data = [
            'title' => 'Tambah Tugas',
            'title2' => 'Tambah Tugas'
        ];
        return view('backend/karyawan/pengajar/kursus/tugas/v_add', $data);
    }

    public function save_tugas()
    {
        $rules = [
            'id_kursus' => 'required',
            'judul_tugas' => 'required',
            'deskripsi_tugas' => 'required'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', \Config\Services::validation()->getErrors());
        }

        $data = [
            'id_kursus' => $this->request->getPost('id_kursus'),
            'judul_tugas' => $this->request->getPost('judul_tugas'),
            'deskripsi_tugas' => $this->request->getPost('deskripsi_tugas'),
            'tanggal_dibuat' => date('Y-m-d H:i:s')
        ];

        $this->pendaftaranModel->insertTugas($data);
        session()->setFlashdata('pesan', 'Tugas berhasil ditambahkan!');
        return redirect()->to(base_url('home_karyawan/tugas'));
    }

    public function edit_tugas($id_tugas)
    {
        $tugas = $this->pendaftaranModel->getTugasById($id_tugas);
        if (!$tugas) {
            session()->setFlashdata('error', 'Data tugas tidak ditemukan!');
            return redirect()->to(base_url('home_karyawan/tugas'));
        }

        $data = [
            'title' => 'Edit Tugas',
            'title2' => 'Edit Tugas',
            'tugas' => $tugas
        ];
        return view('backend/karyawan/pengajar/kursus/tugas/v_edit', $data);
    }

    public function update_tugas($id_tugas)
    {
        $tugas = $this->pendaftaranModel->getTugasById($id_tugas);
        if (!$tugas) {
            session()->setFlashdata('error', 'Data tugas tidak ditemukan!');
            return redirect()->to(base_url('home_karyawan/tugas'));
        }

        $data = [
            'judul_tugas' => $this->request->getPost('judul_tugas'),
            'deskripsi_tugas' => $this->request->getPost('deskripsi_tugas')
        ];

        $this->pendaftaranModel->updateTugas($id_tugas, $data);
        session()->setFlashdata('pesan', 'Tugas berhasil diperbarui!');
        return redirect()->to(base_url('home_karyawan/tugas'));
    }

    public function deleted_tugas($id_tugas)
    {
        $tugas = $this->pendaftaranModel->getTugasById($id_tugas);
        if (!$tugas) {
            session()->setFlashdata('error', 'Data tugas tidak ditemukan!');
            return redirect()->to(base_url('home_karyawan/tugas'));
        }

        $this->pendaftaranModel->deleteTugas($id_tugas);
        session()->setFlashdata('pesan', 'Tugas berhasil dihapus!');
        return redirect()->to(base_url('home_karyawan/tugas'));
    }

    public function v_kumpul_tugas()
    {
        $id_karyawan = session()->get('id_karyawan');
        $data = [
            'title' => 'Pengumpulan Tugas',
            'title2' => 'Pengumpulan Tugas',
            'kumpul' => $this->pendaftaranModel->getKumpulTugasByPengajar($id_karyawan)
        ];
        return view('backend/karyawan/pengajar/kumpul_tugas/v_kumpul', $data);
    }

    public function update_kumpul($id_kumpul)
    {
        $kumpul = $this->pendaftaranModel->getKumpulTugasById($id_kumpul);
        if (!$kumpul) {
            session()->setFlashdata('error', 'Data pengumpulan tidak ditemukan!');
            return redirect()->to(base_url('home_karyawan/v_kumpul_tugas'));
        }

        $data = [
            'status_penilaian' => 'dinilai',
            'nilai' => $this->request->getPost('nilai'),
            'feedback' => $this->request->getPost('feedback')
        ];

        $this->pendaftaranModel->updateKumpulTugas($id_kumpul, $data);
        session()->setFlashdata('pesan', 'Tugas berhasil dinilai!');
        return redirect()->to(base_url('home_karyawan/v_kumpul_tugas'));
    }

    // QUIZ METHODS
    public function quiz($id_kursus)
    {
        $data = [
            'title' => 'Quiz',
            'title2' => 'Quiz',
            'quiz' => $this->pendaftaranModel->getQuizByKursus($id_kursus)
        ];
        return view('backend/karyawan/pengajar/quiz/v_quiz', $data);
    }

    public function kerjakan($id_quiz)
    {
        $quiz = $this->pendaftaranModel->getQuizById($id_quiz);
        if (!$quiz) {
            session()->setFlashdata('error', 'Data quiz tidak ditemukan!');
            return redirect()->back();
        }

        $data = [
            'title' => 'Kerjakan Quiz',
            'title2' => 'Kerjakan Quiz',
            'quiz' => $quiz
        ];
        return view('backend/karyawan/pengajar/quiz/v_kerjakan', $data);
    }

    public function submit()
    {
        $rules = [
            'id_quiz' => 'required',
            'jawaban' => 'required'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', \Config\Services::validation()->getErrors());
        }

        $data = [
            'id_quiz' => $this->request->getPost('id_quiz'),
            'jawaban' => $this->request->getPost('jawaban'),
            'tanggal_submit' => date('Y-m-d H:i:s')
        ];

        $this->pendaftaranModel->insertQuizHasil($data);
        session()->setFlashdata('pesan', 'Quiz berhasil disubmit!');
        return redirect()->to(base_url('home_karyawan/hasil/' . $this->request->getPost('id_quiz')));
    }

    public function hasil($id_quiz)
    {
        $data = [
            'title' => 'Hasil Quiz',
            'title2' => 'Hasil Quiz',
            'hasil' => $this->pendaftaranModel->getQuizHasil($id_quiz)
        ];
        return view('backend/karyawan/pengajar/quiz/v_hasil', $data);
    }

    public function retry($id_quiz)
    {
        session()->setFlashdata('pesan', 'Anda dapat mencoba kembali quiz ini!');
        return redirect()->to(base_url('home_karyawan/kerjakan/' . $id_quiz));
    }

    public function update_progress()
    {
        $id_pendaftaran = $this->request->getPost('id_pendaftaran');
        $progress = $this->request->getPost('progress');

        $this->pendaftaranModel->update($id_pendaftaran, ['progress' => $progress]);

        return $this->response->setJSON(['status' => 'success']);
    }

    public function quiz_management()
    {
        $id_karyawan = session()->get('id_karyawan');
        $data = [
            'title' => 'Quiz Management',
            'title2' => 'Quiz Management',
            'quiz' => $this->pendaftaranModel->getQuizByPengajar($id_karyawan)
        ];
        return view('backend/karyawan/pengajar/quiz/v_quiz_management', $data);
    }

    public function add_quiz()
    {
        $data = [
            'title' => 'Tambah Quiz',
            'title2' => 'Tambah Quiz'
        ];
        return view('backend/karyawan/pengajar/quiz/v_add_quiz', $data);
    }

    public function save_quiz()
    {
        $rules = [
            'id_kursus' => 'required',
            'judul_quiz' => 'required',
            'pertanyaan' => 'required'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', \Config\Services::validation()->getErrors());
        }

        $data = [
            'id_kursus' => $this->request->getPost('id_kursus'),
            'judul_quiz' => $this->request->getPost('judul_quiz'),
            'pertanyaan' => $this->request->getPost('pertanyaan'),
            'status' => 'aktif'
        ];

        $this->pendaftaranModel->insertQuiz($data);
        session()->setFlashdata('pesan', 'Quiz berhasil ditambahkan!');
        return redirect()->to(base_url('home_karyawan/quiz_management'));
    }

    public function edit_quiz($id_quiz)
    {
        $quiz = $this->pendaftaranModel->getQuizById($id_quiz);
        if (!$quiz) {
            session()->setFlashdata('error', 'Data quiz tidak ditemukan!');
            return redirect()->to(base_url('home_karyawan/quiz_management'));
        }

        $data = [
            'title' => 'Edit Quiz',
            'title2' => 'Edit Quiz',
            'quiz' => $quiz
        ];
        return view('backend/karyawan/pengajar/quiz/v_edit_quiz', $data);
    }

    public function update_quiz($id_quiz)
    {
        $quiz = $this->pendaftaranModel->getQuizById($id_quiz);
        if (!$quiz) {
            session()->setFlashdata('error', 'Data quiz tidak ditemukan!');
            return redirect()->to(base_url('home_karyawan/quiz_management'));
        }

        $data = [
            'judul_quiz' => $this->request->getPost('judul_quiz'),
            'pertanyaan' => $this->request->getPost('pertanyaan')
        ];

        $this->pendaftaranModel->updateQuiz($id_quiz, $data);
        session()->setFlashdata('pesan', 'Quiz berhasil diperbarui!');
        return redirect()->to(base_url('home_karyawan/quiz_management'));
    }

    public function delete_quiz($id_quiz)
    {
        $quiz = $this->pendaftaranModel->getQuizById($id_quiz);
        if (!$quiz) {
            session()->setFlashdata('error', 'Data quiz tidak ditemukan!');
            return redirect()->to(base_url('home_karyawan/quiz_management'));
        }

        $this->pendaftaranModel->deleteQuiz($id_quiz);
        session()->setFlashdata('pesan', 'Quiz berhasil dihapus!');
        return redirect()->to(base_url('home_karyawan/quiz_management'));
    }

    public function quiz_stats($id_quiz)
    {
        $data = [
            'title' => 'Quiz Statistics',
            'title2' => 'Quiz Statistics',
            'stats' => $this->pendaftaranModel->getQuizStats($id_quiz)
        ];
        return view('backend/karyawan/pengajar/quiz/v_quiz_stats', $data);
    }

    public function generate($id_pendaftaran)
    {
        $pendaftaran = $this->pendaftaranModel->find($id_pendaftaran);
        if (!$pendaftaran) {
            session()->setFlashdata('error', 'Data pendaftaran tidak ditemukan!');
            return redirect()->back();
        }

        // Generate certificate logic here
        session()->setFlashdata('pesan', 'Sertifikat berhasil dibuat!');
        return redirect()->to(base_url('home_karyawan/sertifikat'));
    }

    // DISKUSI METHODS
    public function diskusi($id_kursus)
    {
        $data = [
            'title' => 'Diskusi',
            'title2' => 'Diskusi',
            'diskusi' => $this->pendaftaranModel->getDiskusiByKursus($id_kursus)
        ];
        return view('backend/karyawan/pengajar/diskusi/v_diskusi', $data);
    }

    public function save_diskusi()
    {
        $rules = [
            'id_kursus' => 'required',
            'judul_diskusi' => 'required',
            'isi_diskusi' => 'required'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', \Config\Services::validation()->getErrors());
        }

        $data = [
            'id_kursus' => $this->request->getPost('id_kursus'),
            'judul_diskusi' => $this->request->getPost('judul_diskusi'),
            'isi_diskusi' => $this->request->getPost('isi_diskusi'),
            'tanggal_buat' => date('Y-m-d H:i:s')
        ];

        $this->pendaftaranModel->insertDiskusi($data);
        session()->setFlashdata('pesan', 'Diskusi berhasil ditambahkan!');
        return redirect()->to(base_url('home_karyawan/diskusi/' . $this->request->getPost('id_kursus')));
    }

    public function show($id_diskusi)
    {
        $diskusi = $this->pendaftaranModel->getDiskusiById($id_diskusi);
        if (!$diskusi) {
            session()->setFlashdata('error', 'Data diskusi tidak ditemukan!');
            return redirect()->back();
        }

        $data = [
            'title' => 'Detail Diskusi',
            'title2' => 'Detail Diskusi',
            'diskusi' => $diskusi,
            'komentar' => $this->pendaftaranModel->getKomentarByDiskusi($id_diskusi)
        ];
        return view('backend/karyawan/pengajar/diskusi/v_show', $data);
    }

    public function add_komentar($id_diskusi)
    {
        $rules = [
            'isi_komentar' => 'required'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', \Config\Services::validation()->getErrors());
        }

        $data = [
            'id_diskusi' => $id_diskusi,
            'isi_komentar' => $this->request->getPost('isi_komentar'),
            'tanggal_buat' => date('Y-m-d H:i:s')
        ];

        $this->pendaftaranModel->insertKomentar($data);
        session()->setFlashdata('pesan', 'Komentar berhasil ditambahkan!');
        return redirect()->to(base_url('home_karyawan/diskusi/show/' . $id_diskusi));
    }

    public function like_komentar($id_komentar, $id_diskusi)
    {
        $this->pendaftaranModel->likeKomentar($id_komentar);
        return redirect()->to(base_url('home_karyawan/diskusi/show/' . $id_diskusi));
    }

    public function set_solution($id_komentar, $id_diskusi)
    {
        $this->pendaftaranModel->setSolution($id_komentar, $id_diskusi);
        return redirect()->to(base_url('home_karyawan/diskusi/show/' . $id_diskusi));
    }

    public function toggle_pin($id_diskusi)
    {
        $this->pendaftaranModel->togglePin($id_diskusi);
        return redirect()->to(base_url('home_karyawan/diskusi/show/' . $id_diskusi));
    }

    public function toggle_lock($id_diskusi)
    {
        $this->pendaftaranModel->toggleLock($id_diskusi);
        return redirect()->to(base_url('home_karyawan/diskusi/show/' . $id_diskusi));
    }

    public function search()
    {
        $keyword = $this->request->getGet('keyword');
        $data = [
            'title' => 'Search Diskusi',
            'title2' => 'Search Diskusi',
            'diskusi' => $this->pendaftaranModel->searchDiskusi($keyword)
        ];
        return view('backend/karyawan/pengajar/diskusi/v_search', $data);
    }

    public function mentor_unanswered()
    {
        $id_karyawan = session()->get('id_karyawan');
        $data = [
            'title' => 'Unanswered Discussions',
            'title2' => 'Unanswered Discussions',
            'diskusi' => $this->pendaftaranModel->getUnansweredDiskusi($id_karyawan)
        ];
        return view('backend/karyawan/pengajar/diskusi/v_unanswered', $data);
    }

    // TEKNISI METHODS
    public function home_teknisi()
    {
        // Get statistics data for teknisi
        $total_peserta = $this->siswaModel->countAll();
        $total_jadwal = $this->kursusModel->countAll();
        $total_kegiatan = $this->pendaftaranModel->countAll();
        $total_user = $this->karyawanModel->countAll();
        
        $data = [
            'title' => 'Dashboard Teknisi',
            'title2' => 'Dashboard Teknisi',
            'total_peserta' => $total_peserta,
            'total_jadwal' => $total_jadwal,
            'total_kegiatan' => $total_kegiatan,
            'total_user' => $total_user
        ];
        return view('backend/karyawan/teknisi/v_home_teknisi', $data);
    }

    public function inventory()
    {
        $data = [
            'title' => 'Inventory',
            'title2' => 'Inventory',
            'inventory' => $this->pendaftaranModel->getAllInventory()
        ];
        return view('backend/karyawan/teknisi/inventory/v_simpan', $data);
    }

    public function add_inventory()
    {
        $data = [
            'title' => 'Tambah Inventory',
            'title2' => 'Tambah Inventory'
        ];
        return view('backend/karyawan/teknisi/inventory/v_add', $data);
    }

    public function save_inventory()
    {
        $rules = [
            'nama_barang' => 'required',
            'jumlah' => 'required|integer',
            'keterangan' => 'required'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', \Config\Services::validation()->getErrors());
        }

        $data = [
            'nama_barang' => $this->request->getPost('nama_barang'),
            'jumlah' => $this->request->getPost('jumlah'),
            'keterangan' => $this->request->getPost('keterangan'),
            'tanggal_input' => date('Y-m-d H:i:s')
        ];

        $this->pendaftaranModel->insertInventory($data);
        session()->setFlashdata('pesan', 'Inventory berhasil ditambahkan!');
        return redirect()->to(base_url('home_karyawan/inventory'));
    }

    public function edit_inventory($id_inventory)
    {
        $inventory = $this->pendaftaranModel->getInventoryById($id_inventory);
        if (!$inventory) {
            session()->setFlashdata('error', 'Data inventory tidak ditemukan!');
            return redirect()->to(base_url('home_karyawan/inventory'));
        }

        $data = [
            'title' => 'Edit Inventory',
            'title2' => 'Edit Inventory',
            'inventory' => $inventory
        ];
        return view('backend/karyawan/teknisi/inventory/v_edit', $data);
    }

    public function update_inventory($id_inventory)
    {
        $inventory = $this->pendaftaranModel->getInventoryById($id_inventory);
        if (!$inventory) {
            session()->setFlashdata('error', 'Data inventory tidak ditemukan!');
            return redirect()->to(base_url('home_karyawan/inventory'));
        }

        $data = [
            'nama_barang' => $this->request->getPost('nama_barang'),
            'jumlah' => $this->request->getPost('jumlah'),
            'keterangan' => $this->request->getPost('keterangan')
        ];

        $this->pendaftaranModel->updateInventory($id_inventory, $data);
        session()->setFlashdata('pesan', 'Inventory berhasil diperbarui!');
        return redirect()->to(base_url('home_karyawan/inventory'));
    }

    public function delete_inventory($id_inventory)
    {
        $inventory = $this->pendaftaranModel->getInventoryById($id_inventory);
        if (!$inventory) {
            session()->setFlashdata('error', 'Data inventory tidak ditemukan!');
            return redirect()->to(base_url('home_karyawan/inventory'));
        }

        $this->pendaftaranModel->deleteInventory($id_inventory);
        session()->setFlashdata('pesan', 'Inventory berhasil dihapus!');
        return redirect()->to(base_url('home_karyawan/inventory'));
    }

    public function search_inventory()
    {
        $keyword = $this->request->getGet('keyword');
        $data = [
            'title' => 'Search Inventory',
            'title2' => 'Search Inventory',
            'inventory' => $this->pendaftaranModel->searchInventory($keyword)
        ];
        return view('backend/karyawan/teknisi/inventory/v_search_inventory', $data);
    }

    // PUBLIC METHODS
    public function riwayat_bayar()
    {
        $id_siswa = session()->get('id_siswa');
        if (!$id_siswa) {
            return redirect()->to(base_url('auth_login/login_siswa'));
        }

        $data = [
            'title' => 'Riwayat Pembayaran',
            'title2' => 'Riwayat Pembayaran',
            'pembayaran' => $this->pembayaranModel->getRiwayatBySiswa($id_siswa)
        ];
        return view('backend/karyawan/staf_admin/pembayaran/v_riwayat_bayar', $data);
    }

    public function verify($kode = null)
    {
        if ($kode) {
            $sertifikat = $this->sertifikatModel->getSertifikatByKode($kode);
            if ($sertifikat) {
                $data = [
                    'title' => 'Verifikasi Sertifikat',
                    'title2' => 'Verifikasi Sertifikat',
                    'sertifikat' => $sertifikat,
                    'valid' => true
                ];
            } else {
                $data = [
                    'title' => 'Verifikasi Sertifikat',
                    'title2' => 'Verifikasi Sertifikat',
                    'valid' => false
                ];
            }
        } else {
            $data = [
                'title' => 'Verifikasi Sertifikat',
                'title2' => 'Verifikasi Sertifikat'
            ];
        }

        return view('public/sertifikat/v_verify', $data);
    }

    public function download($id_sertifikat)
    {
        $sertifikat = $this->sertifikatModel->find($id_sertifikat);
        if (!$sertifikat) {
            session()->setFlashdata('error', 'Sertifikat tidak ditemukan!');
            return redirect()->back();
        }

        $file_path = WRITEPATH . 'uploads/sertifikat/' . $sertifikat['file_sertifikat'];
        if (file_exists($file_path)) {
            return $this->response->download($file_path, null);
        } else {
            session()->setFlashdata('error', 'File sertifikat tidak ditemukan!');
            return redirect()->back();
        }
    }

    public function get_text_content($id_kursus)
    {
        $kursus = $this->pendaftaranModel->getKursusWithDetail($id_kursus);
        if ($kursus) {
            return $this->response->setJSON([
                'status' => 'success',
                'content' => $kursus['deskripsi_kursus'] ?? ''
            ]);
        }
        return $this->response->setJSON(['status' => 'error']);
    }

    public function auto_generate_certificates()
    {
        $M_sertifikat = new \App\Models\M_sertifikat();
        $result = $M_sertifikat->autoGeneratePendingCertificates();
        session()->setFlashdata('pesan', 'Sertifikat otomatis dibuat: ' . $result['generated'] . ' dari ' . $result['total_pending'] . ' pending.');
        return redirect()->to(base_url('home_karyawan/sertifikat'));
    }

    public function dashboard_analytics()
    {
        $id_karyawan = session()->get('id_karyawan');
        $M_quiz = new \App\Models\M_quiz();
        $analytics = $M_quiz->getDashboardAnalytics($id_karyawan);
        $data = [
            'title' => 'Analytics Dashboard',
            'title2' => 'Analytics Dashboard',
            'analytics' => $analytics
        ];
        return view('backend/karyawan/v_dashboard_analytics', $data);
    }

    public function get_tugas_deadline()
    {
        $id_karyawan = session()->get('id_karyawan');
        $db = \Config\Database::connect();
        $deadlines = $db->table('tugas')
            ->select('tugas.*, kursus.nama_kursus')
            ->join('kursus', 'kursus.id_kursus = tugas.id_kursus', 'left')
            ->where('tugas.tanggal_deadline IS NOT NULL')
            ->where('tugas.tanggal_deadline !=', '0000-00-00 00:00:00')
            ->orderBy('tugas.tanggal_deadline', 'ASC')
            ->get()
            ->getResultArray();
        $data = [
            'title' => 'Deadline Tugas',
            'title2' => 'Deadline Tugas',
            'deadlines' => $deadlines
        ];
        return view('backend/karyawan/v_deadline_tugas', $data);
    }

}
