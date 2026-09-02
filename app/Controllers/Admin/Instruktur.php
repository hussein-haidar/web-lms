<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\M_instruktur;

class Instruktur extends BaseController
{
    protected $instrukturModel;

    public function __construct()
    {
        $this->instrukturModel = new M_instruktur();
    }

    public function index()
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

    public function create()
    {
        $data = [
            'title' => 'Tambah Instruktur',
            'title2' => 'Tambah Data Instruktur',
            'validation' => \Config\Services::validation()
        ];
        return view('backend/superadmin/instruktur/v_create_instruktur', $data);
    }

    public function save()
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
        return redirect()->to(base_url('admin/instruktur'));
    }

    public function edit($id_instruktur)
    {
        $data = [
            'title' => 'Edit Instruktur',
            'title2' => 'Edit Data Instruktur',
            'validation' => \Config\Services::validation(),
            'instruktur' => $this->instrukturModel->getDetailInstruktur($id_instruktur)
        ];
        if (empty($data['instruktur'])) {
            session()->setFlashdata('error', 'Data instruktur tidak ditemukan!');
            return redirect()->to(base_url('admin/instruktur'));
        }
        return view('backend/superadmin/instruktur/v_edit_instruktur', $data);
    }

    public function update($id_instruktur)
    {
        $instruktur = $this->instrukturModel->getDetailInstruktur($id_instruktur);
        if (!$instruktur) {
            session()->setFlashdata('error', 'Data instruktur tidak ditemukan!');
            return redirect()->to(base_url('admin/instruktur'));
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
            if (!empty($instruktur['foto']) && file_exists('uploads/instruktur/' . $instruktur['foto'])) {
                unlink('uploads/instruktur/' . $instruktur['foto']);
            }
            $namaFoto = $foto->getRandomName();
            $foto->move('uploads/instruktur', $namaFoto);
            $data['foto'] = $namaFoto;
        }
        $this->instrukturModel->updateInstruktur($id_instruktur, $data);
        session()->setFlashdata('pesan', 'Data instruktur berhasil diperbarui!');
        return redirect()->to(base_url('admin/instruktur'));
    }

    public function delete($id_instruktur)
    {
        $instruktur = $this->instrukturModel->getDetailInstruktur($id_instruktur);
        if (!$instruktur) {
            session()->setFlashdata('error', 'Data instruktur tidak ditemukan!');
            return redirect()->to(base_url('admin/instruktur'));
        }
        $this->instrukturModel->deleteInstruktur($id_instruktur);
        session()->setFlashdata('pesan', 'Data instruktur berhasil dihapus!');
        return redirect()->to(base_url('admin/instruktur'));
    }
}
