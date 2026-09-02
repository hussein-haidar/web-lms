<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\M_visi_misi;

class VisiMisi extends BaseController
{
    protected $visiMisiModel;

    public function __construct()
    {
        $this->visiMisiModel = new M_visi_misi();
    }

    public function index()
    {
        $data_visimisi = $this->visiMisiModel->getAllVisiMisi();
        $data = [
            'title' => 'Visi & Misi',
            'title2' => 'Visi & Misi',
            'visimisi' => $data_visimisi
        ];
        return view('backend/superadmin/visi_misi/v_visi_misi', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Visi/Misi',
            'title2' => 'Tambah Visi/Misi'
        ];
        return view('backend/superadmin/visi_misi/v_create_visi_misi', $data);
    }

    public function save()
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
        return redirect()->to(base_url('admin/visi-misi'));
    }

    public function edit($id)
    {
        $visimisi = $this->visiMisiModel->getById($id);
        if (!$visimisi) {
            session()->setFlashdata('error', 'Data visi/misi tidak ditemukan!');
            return redirect()->to(base_url('admin/visi-misi'));
        }
        $data = [
            'title' => 'Edit Visi/Misi',
            'title2' => 'Edit Visi/Misi',
            'visimisi' => $visimisi
        ];
        return view('backend/superadmin/visi_misi/v_edit_visi_misi', $data);
    }

    public function update($id)
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
        return redirect()->to(base_url('admin/visi-misi'));
    }

    public function delete($id)
    {
        $this->visiMisiModel->deleteVisiMisi($id);
        session()->setFlashdata('pesan', 'Visi/Misi berhasil dihapus!');
        return redirect()->to(base_url('admin/visi-misi'));
    }
}
