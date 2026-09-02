<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\M_profil_lpk;

class ProfilLpk extends BaseController
{
    protected $profilLpkModel;

    public function __construct()
    {
        $this->profilLpkModel = new M_profil_lpk();
    }

    public function index()
    {
        $data_profil = $this->profilLpkModel->getProfil();
        $data = [
            'title' => 'Profil LPK',
            'title2' => 'Profil LPK',
            'profil' => $data_profil
        ];
        return view('backend/superadmin/profil_lpk/v_profil_lpk', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Profil LPK',
            'title2' => 'Tambah Profil LPK'
        ];
        return view('backend/superadmin/profil_lpk/v_create_profil', $data);
    }

    public function save()
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
        return redirect()->to(base_url('admin/profil-lpk'));
    }

    public function edit($id)
    {
        $profil = $this->profilLpkModel->getProfilById($id);
        if (!$profil) {
            session()->setFlashdata('error', 'Data profil tidak ditemukan!');
            return redirect()->to(base_url('admin/profil-lpk'));
        }
        $data = [
            'title' => 'Edit Profil LPK',
            'title2' => 'Edit Profil LPK',
            'profil' => $profil
        ];
        return view('backend/superadmin/profil_lpk/v_edit_profil', $data);
    }

    public function update($id)
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
        return redirect()->to(base_url('admin/profil-lpk'));
    }

    public function delete($id)
    {
        $this->profilLpkModel->deleteProfil($id);
        session()->setFlashdata('pesan', 'Profil LPK berhasil dihapus!');
        return redirect()->to(base_url('admin/profil-lpk'));
    }
}
