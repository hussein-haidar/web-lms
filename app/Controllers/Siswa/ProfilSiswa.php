<?php

namespace App\Controllers\Siswa;

use App\Controllers\BaseController;
use App\Models\M_siswa;

class ProfilSiswa extends BaseController
{
    protected $siswaModel;

    public function __construct()
    {
        $this->siswaModel = new M_siswa();
    }

    public function index()
    {
        $id_siswa = session()->get('id_siswa');
        if (!$id_siswa) {
            session()->setFlashdata('error', 'Anda harus login terlebih dahulu!');
            return redirect()->to(base_url('auth_login/login_siswa'));
        }
        $profil = $this->siswaModel->get_profil($id_siswa);
        if (!$profil) {
            session()->setFlashdata('error', 'Profil tidak ditemukan!');
            return redirect()->to(base_url('home_siswa/profil'));
        }
        $data = ['title' => 'Data Profil', 'title2' => 'Profil Saya', 'profil' => $profil];
        return view('backend/siswa/v_profil', $data);
    }

    public function edit()
    {
        $id_siswa = session()->get('id_siswa');
        if (!$id_siswa) {
            session()->setFlashdata('error', 'Anda harus login terlebih dahulu!');
            return redirect()->to(base_url('auth_login/login_siswa'));
        }
        $profil = $this->siswaModel->find($id_siswa);
        if (!$profil) {
            session()->setFlashdata('error', 'Profil tidak ditemukan!');
            return redirect()->to(base_url('home_siswa/profil'));
        }
        $data = ['title' => 'Data Profil', 'title2' => 'Profil Saya', 'data_profil' => $profil];
        return view('backend/siswa/v_edit', $data);
    }

    public function update()
    {
        $id_siswa = session()->get('id_siswa');
        $profil_lama = $this->siswaModel->find($id_siswa);
        if (!$profil_lama) {
            session()->setFlashdata('error', 'Profil tidak ditemukan!');
            return redirect()->back();
        }
        $rules = [
            'email' => ['label' => 'Email', 'rules' => 'required|valid_email|max_length[100]|is_unique[siswa.email,id_siswa,' . $id_siswa . ']'],
            'kata_sandi' => ['label' => 'Password', 'rules' => 'permit_empty|min_length[6]'],
            'nama_lengkap' => ['label' => 'Nama Lengkap', 'rules' => 'required|min_length[3]|max_length[100]'],
            'no_telepon' => ['label' => 'No Telepon', 'rules' => 'required|min_length[10]|max_length[15]|regex_match[/^[0-9]+$/]'],
            'alamat' => ['label' => 'Alamat', 'rules' => 'permit_empty'],
            'foto_profil' => ['label' => 'Foto Profil', 'rules' => 'permit_empty|max_size[foto_profil,1024]|is_image[foto_profil]|mime_in[foto_profil,image/png,image/jpg,image/jpeg,image/gif,image/webp]'],
        ];
        if (!$this->validate($rules)) {
            session()->setFlashdata('errors', \Config\Services::validation()->getErrors());
            return redirect()->back()->withInput();
        }
        $foto = $this->request->getFile('foto_profil');
        $foto_profil = $profil_lama['foto_profil'];
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
            $data['kata_sandi'] = $password;
        }
        $sukses = $this->siswaModel->update($id_siswa, $data);
        if ($sukses) {
            session()->set(['email' => $data['email'], 'nama_lengkap' => $data['nama_lengkap'], 'no_telepon' => $data['no_telepon'], 'foto_profil' => $data['foto_profil']]);
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
        $siswa = $this->siswaModel->find($id_siswa);
        if (!$siswa) {
            session()->setFlashdata('error', 'Data siswa tidak ditemukan!');
            return redirect()->back();
        }
        if (!password_verify($this->request->getPost('password_lama'), $siswa['kata_sandi'])) {
            session()->setFlashdata('error', 'Password lama salah!');
            return redirect()->back();
        }
        $this->siswaModel->update($id_siswa, ['kata_sandi' => password_hash($this->request->getPost('password_baru'), PASSWORD_DEFAULT)]);
        session()->setFlashdata('pesan', 'Password berhasil diganti!');
        return redirect()->to(base_url('home_siswa/ganti-password'));
    }
}
