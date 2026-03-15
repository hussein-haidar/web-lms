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
        return view('backend/karyawan/siswa/v_siswa', $data);
    }

    public function tambah_siswa()
    {
        $data = [
            'title' => 'Tambah Siswa',
            'title2' => 'Tambah Siswa'
        ];
        return view('backend/karyawan/siswa/v_tambah_siswa', $data);
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
        return view('backend/karyawan/siswa/v_edit_siswa', $data);
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
        return view('backend/karyawan/pembayaran/v_pembayaran', $data);
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
        return view('backend/karyawan/pembayaran/v_verifikasi_pembayaran', $data);
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
        $email = new \CodeIgniter\Email\Email();
        $email->setFrom('admin@lpkinasaba.com', 'LPK INASABA');
        $email->setTo($siswa['email']);
        $email->setSubject('🎉 Pembayaran Disetujui - LPK INASABA');

        $message = "
        <h2>🎉 Pembayaran Anda Telah Disetujui!</h2>
        <p>Hai {$siswa['nama_lengkap']},</p>
        <p>Pembayaran Anda untuk kursus <strong>{$pendaftaran['nama_kursus']}</strong> telah disetujui.</p>
        
        <table border='1' cellpadding='10' style='border-collapse: collapse;'>
            <tr><td><strong>Kode Transaksi</strong></td><td>{$payment['kode_transaksi']}</td></tr>
            <tr><td><strong>Kode Invoice</strong></td><td>{$payment['kode_invoice']}</td></tr>
            <tr><td><strong>Nama Kursus</strong></td><td>{$pendaftaran['nama_kursus']}</td></tr>
            <tr><td><strong>Jumlah</strong></td><td>Rp " . number_format($payment['jumlah_bayar'], 0, ',', '.') . "</td></tr>
            <tr><td><strong>Tanggal Verifikasi</strong></td><td>" . date('d/m/Y H:i') . "</td></tr>
        </table>
        
        <p>Silakan login untuk mulai belajar.</p>
        <p><a href='" . base_url('auth_login/login_siswa') . "' style='background: #28a745; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>Login Sekarang</a></p>
        ";

        $email->setMessage($message);
        return $email->send();
    }

    /**
     * Kirim notifikasi penolakan pembayaran
     */
    private function kirimNotifikasiPenolakan($siswa, $pendaftaran, $alasan)
    {
        $email = new \CodeIgniter\Email\Email();
        $email->setFrom('admin@lpkinasaba.com', 'LPK INASABA');
        $email->setTo($siswa['email']);
        $email->setSubject('❌ Pembayaran Ditolak - LPK INASABA');

        $message = "
        <h2>❌ Pembayaran Anda Ditolak</h2>
        <p>Hai {$siswa['nama_lengkap']},</p>
        <p>Pembayaran Anda untuk kursus <strong>{$pendaftaran['nama_kursus']}</strong> ditolak.</p>
        
        <p><strong>Alasan:</strong> " . htmlspecialchars($alasan) . "</p>
        
        <p>Silakan upload ulang bukti pembayaran yang valid.</p>
        <p><a href='" . base_url('home_siswa/status_bayar') . "' style='background: #dc3545; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>Upload Ulang</a></p>
        ";

        $email->setMessage($message);
        return $email->send();
    }

    public function kursus()
    {
        $data = [
            'title' => 'Data Kursus',
            'title2' => 'Data Kursus',
            'kursus' => $this->kursusModel->findAll()
        ];
        return view('backend/karyawan/kursus/v_kursus', $data);
    }

    public function sertifikat()
    {
        $data = [
            'title' => 'Data Sertifikat',
            'title2' => 'Data Sertifikat',
            'sertifikat' => $this->sertifikatModel->getSertifikatAll()
        ];
        return view('backend/karyawan/sertifikat/v_sertifikat', $data);
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
        return view('backend/karyawan/v_profil', $data);
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
}
