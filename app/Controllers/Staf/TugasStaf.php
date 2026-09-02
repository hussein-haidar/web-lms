<?php

namespace App\Controllers\Staf;

use App\Controllers\BaseController;
use App\Models\M_pendaftaran;

class TugasStaf extends BaseController
{
    protected $pendaftaranModel;

    public function __construct()
    {
        $this->pendaftaranModel = new M_pendaftaran();
    }

    public function index()
    {
        $id_karyawan = session()->get('id_karyawan');
        $data = [
            'title' => 'Data Tugas',
            'title2' => 'Data Tugas',
            'tugas' => $this->pendaftaranModel->getTugasByPengajar($id_karyawan)
        ];
        return view('backend/karyawan/pengajar/kursus/tugas/v_tugas', $data);
    }

    public function add()
    {
        $data = [
            'title' => 'Tambah Tugas',
            'title2' => 'Tambah Tugas'
        ];
        return view('backend/karyawan/pengajar/kursus/tugas/v_add', $data);
    }

    public function save()
    {
        $rules = [
            'id_kursus' => 'required',
            'judul_tugas' => 'required',
            'deskripsi_tugas' => 'required'
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', \Config\Services::validation()->getErrors());
        }
        $data = [
            'id_kursus' => $this->request->getPost('id_kursus'),
            'judul_tugas' => $this->request->getPost('judul_tugas'),
            'deskripsi_tugas' => $this->request->getPost('deskripsi_tugas'),
            'tanggal_dibuat' => date('Y-m-d H:i:s')
        ];
        $this->pendaftaranModel->insertTugas($data);
        session()->setFlashdata('pesan', 'Tugas berhasil ditambahkan!');
        return redirect()->to(base_url('home_karyawan/tugas'));
    }

    public function edit($id_tugas)
    {
        $tugas = $this->pendaftaranModel->getTugasById($id_tugas);
        if (!$tugas) {
            session()->setFlashdata('error', 'Data tugas tidak ditemukan!');
            return redirect()->to(base_url('home_karyawan/tugas'));
        }
        $data = [
            'title' => 'Edit Tugas',
            'title2' => 'Edit Tugas',
            'tugas' => $tugas
        ];
        return view('backend/karyawan/pengajar/kursus/tugas/v_edit', $data);
    }

    public function update($id_tugas)
    {
        $tugas = $this->pendaftaranModel->getTugasById($id_tugas);
        if (!$tugas) {
            session()->setFlashdata('error', 'Data tugas tidak ditemukan!');
            return redirect()->to(base_url('home_karyawan/tugas'));
        }
        $data = [
            'judul_tugas' => $this->request->getPost('judul_tugas'),
            'deskripsi_tugas' => $this->request->getPost('deskripsi_tugas')
        ];
        $this->pendaftaranModel->updateTugas($id_tugas, $data);
        session()->setFlashdata('pesan', 'Tugas berhasil diperbarui!');
        return redirect()->to(base_url('home_karyawan/tugas'));
    }

    public function delete($id_tugas)
    {
        $tugas = $this->pendaftaranModel->getTugasById($id_tugas);
        if (!$tugas) {
            session()->setFlashdata('error', 'Data tugas tidak ditemukan!');
            return redirect()->to(base_url('home_karyawan/tugas'));
        }
        $this->pendaftaranModel->deleteTugas($id_tugas);
        session()->setFlashdata('pesan', 'Tugas berhasil dihapus!');
        return redirect()->to(base_url('home_karyawan/tugas'));
    }

    public function kumpul_tugas()
    {
        $id_karyawan = session()->get('id_karyawan');
        $data = [
            'title' => 'Pengumpulan Tugas',
            'title2' => 'Pengumpulan Tugas',
            'kumpul' => $this->pendaftaranModel->getKumpulTugasByPengajar($id_karyawan)
        ];
        return view('backend/karyawan/pengajar/kumpul_tugas/v_kumpul', $data);
    }

    public function grade_kumpul($id_kumpul)
    {
        $kumpul = $this->pendaftaranModel->getKumpulTugasById($id_kumpul);
        if (!$kumpul) {
            session()->setFlashdata('error', 'Data pengumpulan tidak ditemukan!');
            return redirect()->to(base_url('home_karyawan/v_kumpul_tugas'));
        }
        $data = [
            'status_penilaian' => 'dinilai',
            'nilai' => $this->request->getPost('nilai'),
            'feedback' => $this->request->getPost('feedback')
        ];
        $this->pendaftaranModel->updateKumpulTugas($id_kumpul, $data);
        session()->setFlashdata('pesan', 'Tugas berhasil dinilai!');
        return redirect()->to(base_url('home_karyawan/v_kumpul_tugas'));
    }
}
