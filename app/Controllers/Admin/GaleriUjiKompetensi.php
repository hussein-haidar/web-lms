<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\M_uji_kompetensi;

class GaleriUjiKompetensi extends BaseController
{
    protected $ujiKompetensiModel;

    public function __construct()
    {
        $this->ujiKompetensiModel = new M_uji_kompetensi();
    }

    public function index()
    {
        $data = [
            'title' => 'Data Uji Kompetensi',
            'title2' => 'Data Uji Kompetensi',
            'uji_kompetensi' => $this->ujiKompetensiModel->getAll()
        ];
        return view('backend/superadmin/uji_kompetensi/v_uji_kompetensi', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Uji Kompetensi',
            'title2' => 'Tambah Uji Kompetensi'
        ];
        return view('backend/superadmin/uji_kompetensi/v_add_uji_kompetensi', $data);
    }

    public function save()
    {
        $rules = [
            'nama_uji_kompetensi' => 'required|min_length[3]|max_length[100]',
            'deskripsi' => 'required|min_length[10]',
            'durasi' => 'required',
            'tipe_pembelajaran' => 'required',
            'harga' => 'required|numeric',
            'gambar' => 'uploaded[gambar]|max_size[gambar,2048]|ext_in[gambar,jpg,jpeg,png]',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', \Config\Services::validation()->getErrors());
        }
        $file = $this->request->getFile('gambar');
        $gambar = $file->getRandomName();
        $file->move('uploads/uji_kompetensi', $gambar);
        $data = [
            'nama_uji_kompetensi' => $this->request->getPost('nama_uji_kompetensi'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'durasi' => $this->request->getPost('durasi'),
            'tipe_pembelajaran' => $this->request->getPost('tipe_pembelajaran'),
            'sertifikat' => $this->request->getPost('sertifikat') ?: 'Tidak',
            'harga' => $this->request->getPost('harga'),
            'gambar' => $gambar,
            'status' => 'aktif'
        ];
        $this->ujiKompetensiModel->insert($data);
        session()->setFlashdata('pesan', 'Uji Kompetensi berhasil ditambahkan!');
        return redirect()->to(base_url('admin/uji-kompetensi'));
    }

    public function edit($id_uji_kompetensi)
    {
        $uji_kompetensi = $this->ujiKompetensiModel->find($id_uji_kompetensi);
        if (!$uji_kompetensi) {
            session()->setFlashdata('error', 'Data Uji Kompetensi tidak ditemukan!');
            return redirect()->to(base_url('admin/uji-kompetensi'));
        }
        $data = [
            'title' => 'Edit Uji Kompetensi',
            'title2' => 'Edit Uji Kompetensi',
            'uji_kompetensi' => $uji_kompetensi
        ];
        return view('backend/superadmin/uji_kompetensi/v_edit_uji_kompetensi', $data);
    }

    public function update($id_uji_kompetensi)
    {
        $uji_kompetensi = $this->ujiKompetensiModel->find($id_uji_kompetensi);
        if (!$uji_kompetensi) {
            session()->setFlashdata('error', 'Data Uji Kompetensi tidak ditemukan!');
            return redirect()->to(base_url('admin/uji-kompetensi'));
        }
        $rules = [
            'nama_uji_kompetensi' => 'required|min_length[3]|max_length[100]',
            'deskripsi' => 'required|min_length[10]',
            'durasi' => 'required|numeric',
            'tipe_pembelajaran' => 'required',
            'harga' => 'required|numeric',
        ];
        $file = $this->request->getFile('gambar');
        if ($file && $file->isValid()) {
            $rules['gambar'] = 'max_size[gambar,2048]|ext_in[gambar,jpg,jpeg,png]';
        }
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', \Config\Services::validation()->getErrors());
        }
        $data = [
            'nama_uji_kompetensi' => $this->request->getPost('nama_uji_kompetensi'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'durasi' => $this->request->getPost('durasi'),
            'tipe_pembelajaran' => $this->request->getPost('tipe_pembelajaran'),
            'sertifikat' => $this->request->getPost('sertifikat') ?: 'Tidak',
            'harga' => $this->request->getPost('harga'),
            'status' => $this->request->getPost('status')
        ];
        if ($file && $file->isValid()) {
            if ($uji_kompetensi['gambar'] && file_exists('uploads/uji_kompetensi/' . $uji_kompetensi['gambar'])) {
                unlink('uploads/uji_kompetensi/' . $uji_kompetensi['gambar']);
            }
            $gambar = $file->getRandomName();
            $file->move('uploads/uji_kompetensi', $gambar);
            $data['gambar'] = $gambar;
        }
        $this->ujiKompetensiModel->update($id_uji_kompetensi, $data);
        session()->setFlashdata('pesan', 'Uji Kompetensi berhasil diperbarui!');
        return redirect()->to(base_url('admin/uji-kompetensi'));
    }

    public function delete($id_uji_kompetensi)
    {
        $uji_kompetensi = $this->ujiKompetensiModel->find($id_uji_kompetensi);
        if (!$uji_kompetensi) {
            session()->setFlashdata('error', 'Data Uji Kompetensi tidak ditemukan!');
            return redirect()->to(base_url('admin/uji-kompetensi'));
        }
        if ($uji_kompetensi['gambar'] && file_exists('uploads/uji_kompetensi/' . $uji_kompetensi['gambar'])) {
            unlink('uploads/uji_kompetensi/' . $uji_kompetensi['gambar']);
        }
        $this->ujiKompetensiModel->delete($id_uji_kompetensi);
        session()->setFlashdata('pesan', 'Uji Kompetensi berhasil dihapus!');
        return redirect()->to(base_url('admin/uji-kompetensi'));
    }
}
