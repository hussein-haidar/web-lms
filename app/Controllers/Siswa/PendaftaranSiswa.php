<?php

namespace App\Controllers\Siswa;

use App\Controllers\BaseController;
use App\Models\M_pendaftaran;
use App\Models\M_kursus;

class PendaftaranSiswa extends BaseController
{
    protected $pendaftaranModel;
    protected $kursusModel;

    public function __construct()
    {
        $this->pendaftaranModel = new M_pendaftaran();
        $this->kursusModel = new M_kursus();
    }

    public function form_daftar($id_kursus)
    {
        $id_siswa = session()->get('id_siswa');
        if (!$id_siswa) return redirect()->to(base_url('auth_login/login_siswa'));
        $kursus = $this->kursusModel->find($id_kursus);
        if (!$kursus) {
            session()->setFlashdata('error', 'Kursus tidak ditemukan!');
            return redirect()->to(base_url('home_siswa/kursus_saya'));
        }
        $siswa = (new \App\Models\M_siswa())->find($id_siswa);
        $data = [
            'title' => 'Formulir Pendaftaran',
            'title2' => 'Formulir Pendaftaran',
            'kursus' => $kursus,
            'siswa' => $siswa
        ];
        return view('backend/siswa/pendaftaran/v_form_daftar', $data);
    }

    public function simpan()
    {
        $id_siswa = session()->get('id_siswa');
        if (!$id_siswa) return redirect()->to(base_url('auth_login/login_siswa'));
        $rules = [
            'id_kursus' => 'required',
            'nama_paket' => 'required',
            'harga_kursus' => 'required|numeric'
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', \Config\Services::validation()->getErrors());
        }
        $siswa = (new \App\Models\M_siswa())->find($id_siswa);
        $data = [
            'id_siswa' => $id_siswa,
            'id_kursus' => $this->request->getPost('id_kursus'),
            'kode_invoice' => 'INV-' . date('Ymd') . '-' . rand(1000, 9999),
            'nama_paket' => $this->request->getPost('nama_paket'),
            'harga_kursus' => $this->request->getPost('harga_kursus'),
            'nama_lengkap' => $siswa['nama_lengkap'] ?? '',
            'email' => $siswa['email'] ?? '',
            'no_telepon' => $siswa['no_telepon'] ?? '',
            'status' => 'pending',
            'tanggal_pendaftaran' => date('Y-m-d H:i:s')
        ];
        $this->pendaftaranModel->insert($data);
        session()->setFlashdata('pesan', 'Pendaftaran berhasil! Silakan lakukan pembayaran.');
        return redirect()->to(base_url('home_siswa/status_bayar'));
    }

    public function riwayat()
    {
        $id_siswa = session()->get('id_siswa');
        if (!$id_siswa) return redirect()->to(base_url('auth_login/login_siswa'));
        $pendaftaran = $this->pendaftaranModel->getBySiswa($id_siswa);
        $data = [
            'title' => 'Riwayat Pendaftaran',
            'title2' => 'Riwayat Pendaftaran',
            'pendaftaran' => $pendaftaran
        ];
        return view('backend/siswa/pendaftaran/v_riwayat', $data);
    }

    public function detail($id_pendaftaran)
    {
        $id_siswa = session()->get('id_siswa');
        if (!$id_siswa) return redirect()->to(base_url('auth_login/login_siswa'));
        $pendaftaran = $this->pendaftaranModel->find($id_pendaftaran);
        if (!$pendaftaran || $pendaftaran['id_siswa'] != $id_siswa) {
            session()->setFlashdata('error', 'Data tidak ditemukan!');
            return redirect()->to(base_url('home_siswa/pendaftaran/riwayat'));
        }
        $data = [
            'title' => 'Detail Pendaftaran',
            'title2' => 'Detail Pendaftaran',
            'pendaftaran' => $pendaftaran
        ];
        return view('backend/siswa/pendaftaran/v_detail', $data);
    }
}
