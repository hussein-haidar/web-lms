<?php

namespace App\Controllers\Staf;

use App\Controllers\BaseController;
use App\Models\M_siswa;
use App\Models\M_pembayaran;

class SiswaStaf extends BaseController
{
    protected $siswaModel;
    protected $pembayaranModel;

    public function __construct()
    {
        $this->siswaModel = new M_siswa();
        $this->pembayaranModel = new M_pembayaran();
    }

    public function index()
    {
        $siswaWithPendaftaran = $this->siswaModel->getSiswaWithPendaftaran();
        foreach ($siswaWithPendaftaran as &$siswa) {
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

    public function add()
    {
        $data = [
            'title' => 'Tambah Siswa',
            'title2' => 'Tambah Siswa'
        ];
        return view('backend/karyawan/staf_admin/siswa/v_add', $data);
    }

    public function save()
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
        return redirect()->to(base_url('home_karyawan/siswa_admin'));
    }

    public function edit($id_siswa)
    {
        $siswa = $this->siswaModel->find($id_siswa);
        if (!$siswa) {
            session()->setFlashdata('error', 'Data siswa tidak ditemukan!');
            return redirect()->to(base_url('home_karyawan/siswa_admin'));
        }
        $data = [
            'title' => 'Edit Siswa',
            'title2' => 'Edit Siswa',
            'siswa' => $siswa
        ];
        return view('backend/karyawan/staf_admin/siswa/v_edit', $data);
    }

    public function update($id_siswa)
    {
        $siswa = $this->siswaModel->find($id_siswa);
        if (!$siswa) {
            session()->setFlashdata('error', 'Data siswa tidak ditemukan!');
            return redirect()->to(base_url('home_karyawan/siswa_admin'));
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
        return redirect()->to(base_url('home_karyawan/siswa_admin'));
    }

    public function deleted($id_siswa)
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

    public function restore($id_siswa)
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

    public function force_delete($id_siswa)
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
}
