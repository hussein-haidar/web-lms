<?php

namespace App\Controllers\Staf;

use App\Controllers\BaseController;
use App\Models\M_pendaftaran;

class PendaftaranStaf extends BaseController
{
    protected $pendaftaranModel;

    public function __construct()
    {
        $this->pendaftaranModel = new M_pendaftaran();
    }

    public function index()
    {
        $data = [
            'title' => 'Data Pendaftaran',
            'title2' => 'Data Pendaftaran',
            'pendaftaran' => $this->pendaftaranModel->getPendaftaranWithSiswa()
        ];
        return view('backend/karyawan/staf_admin/pendaftaran/v_pendaftaran', $data);
    }

    public function edit($id_pendaftaran)
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

    public function update($id_pendaftaran)
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

    public function update_status($id_pendaftaran)
    {
        $pendaftaran = $this->pendaftaranModel->find($id_pendaftaran);
        if (!$pendaftaran) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Data tidak ditemukan']);
        }
        $status = $this->request->getPost('status');
        $this->pendaftaranModel->update($id_pendaftaran, ['status' => $status]);
        return $this->response->setJSON(['status' => 'success', 'message' => 'Status berhasil diperbarui']);
    }

    public function save()
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

    public function delete($id_pendaftaran)
    {
        $pendaftaran = $this->pendaftaranModel->find($id_pendaftaran);
        if (!$pendaftaran) {
            session()->setFlashdata('error', 'Data pendaftaran tidak ditemukan!');
            return redirect()->to(base_url('home_karyawan/pendaftaran'));
        }
        $this->pendaftaranModel->delete($id_pendaftaran);
        session()->setFlashdata('pesan', 'Pendaftaran berhasil dihapus!');
        return redirect()->to(base_url('home_karyawan/pendaftaran'));
    }
}
