<?php

namespace App\Controllers\Siswa;

use App\Controllers\BaseController;
use App\Models\M_pendaftaran;
use App\Models\M_progres_materi;

class ProgressSiswa extends BaseController
{
    protected $pendaftaranModel;
    protected $progresModel;

    public function __construct()
    {
        $this->pendaftaranModel = new M_pendaftaran();
        $this->progresModel = new M_progres_materi();
    }

    public function index()
    {
        $id_siswa = session()->get('id_siswa');
        if (!$id_siswa) return redirect()->to(base_url('auth_login/login_siswa'));
        $pendaftaran = $this->pendaftaranModel->getBySiswa($id_siswa);
        $data = [
            'title' => 'Progress Belajar',
            'title2' => 'Progress Belajar',
            'pendaftaran' => $pendaftaran
        ];
        return view('backend/siswa/progress/v_progress', $data);
    }

    public function nilai()
    {
        $id_siswa = session()->get('id_siswa');
        if (!$id_siswa) return redirect()->to(base_url('auth_login/login_siswa'));
        $pendaftaran = $this->pendaftaranModel->getBySiswa($id_siswa);
        $data = [
            'title' => 'Nilai Saya',
            'title2' => 'Nilai Saya',
            'pendaftaran' => $pendaftaran
        ];
        return view('backend/siswa/progress/v_nilai', $data);
    }

    public function detail_nilai($id_pendaftaran)
    {
        $id_siswa = session()->get('id_siswa');
        if (!$id_siswa) return redirect()->to(base_url('auth_login/login_siswa'));
        $pendaftaran = $this->pendaftaranModel->find($id_pendaftaran);
        if (!$pendaftaran || $pendaftaran['id_siswa'] != $id_siswa) {
            session()->setFlashdata('error', 'Data tidak ditemukan!');
            return redirect()->to(base_url('home_siswa/progress/nilai'));
        }
        $data = [
            'title' => 'Detail Nilai',
            'title2' => 'Detail Nilai',
            'pendaftaran' => $pendaftaran
        ];
        return view('backend/siswa/progress/v_detail_nilai', $data);
    }

    public function update($id_pendaftaran)
    {
        $id_siswa = session()->get('id_siswa');
        if (!$id_siswa) return redirect()->to(base_url('auth_login/login_siswa'));
        $pendaftaran = $this->pendaftaranModel->find($id_pendaftaran);
        if (!$pendaftaran || $pendaftaran['id_siswa'] != $id_siswa) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Unauthorized']);
        }
        $progress = $this->request->getPost('progress');
        $this->pendaftaranModel->update($id_pendaftaran, ['progress' => $progress]);
        return $this->response->setJSON(['status' => 'success', 'message' => 'Progress updated']);
    }
}
