<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\M_manajemen;

class Manajemen extends BaseController
{
    protected $manajemenModel;

    public function __construct()
    {
        $this->manajemenModel = new M_manajemen();
    }

    public function index()
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

    public function create()
    {
        $data = [
            'title' => 'Tambah Manajemen',
            'title2' => 'Tambah Data Manajemen',
            'validation' => \Config\Services::validation()
        ];
        return view('backend/superadmin/manajemen/v_create_manajemen', $data);
    }

    public function save()
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
        return redirect()->to(base_url('admin/manajemen'));
    }

    public function edit($id_manajemen)
    {
        $data = [
            'title' => 'Edit Manajemen',
            'title2' => 'Edit Data Manajemen',
            'validation' => \Config\Services::validation(),
            'manajemen' => $this->manajemenModel->getDetailManajemen($id_manajemen)
        ];
        if (empty($data['manajemen'])) {
            session()->setFlashdata('error', 'Data manajemen tidak ditemukan!');
            return redirect()->to(base_url('admin/manajemen'));
        }
        return view('backend/superadmin/manajemen/v_edit_manajemen', $data);
    }

    public function update($id_manajemen)
    {
        $manajemen = $this->manajemenModel->getDetailManajemen($id_manajemen);
        if (!$manajemen) {
            session()->setFlashdata('error', 'Data manajemen tidak ditemukan!');
            return redirect()->to(base_url('admin/manajemen'));
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
            if (!empty($manajemen['foto']) && file_exists('uploads/manajemen/' . $manajemen['foto'])) {
                unlink('uploads/manajemen/' . $manajemen['foto']);
            }
            $namaFoto = $foto->getRandomName();
            $foto->move('uploads/manajemen', $namaFoto);
            $data['foto'] = $namaFoto;
        }
        $this->manajemenModel->updateManajemen($id_manajemen, $data);
        session()->setFlashdata('pesan', 'Data manajemen berhasil diperbarui!');
        return redirect()->to(base_url('admin/manajemen'));
    }

    public function delete($id_manajemen)
    {
        $manajemen = $this->manajemenModel->getDetailManajemen($id_manajemen);
        if (!$manajemen) {
            session()->setFlashdata('error', 'Data manajemen tidak ditemukan!');
            return redirect()->to(base_url('admin/manajemen'));
        }
        $this->manajemenModel->deleteManajemen($id_manajemen);
        session()->setFlashdata('pesan', 'Data manajemen berhasil dihapus!');
        return redirect()->to(base_url('admin/manajemen'));
    }
}
