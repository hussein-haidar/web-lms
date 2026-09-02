<?php

namespace App\Controllers\Siswa;

use App\Controllers\BaseController;
use App\Models\M_tugas;
use App\Models\M_pengumpulan;
use App\Models\M_pendaftaran;

class TugasSiswa extends BaseController
{
    protected $tugasModel;
    protected $pengumpulanModel;
    protected $pendaftaranModel;

    public function __construct()
    {
        $this->tugasModel = new M_tugas();
        $this->pengumpulanModel = new M_pengumpulan();
        $this->pendaftaranModel = new M_pendaftaran();
    }

    public function index()
    {
        $data = ['title' => 'Data Tugas', 'title2' => 'Data Tugas', 'tugas' => $this->tugasModel->get_tugas()];
        return view('backend/siswa/tugas/v_tugas', $data);
    }

    public function detail($id_tugas)
    {
        $tugas = $this->tugasModel->detailTugas($id_tugas);
        if (!$tugas) {
            session()->setFlashdata('error', 'Tugas tidak ditemukan!');
            return redirect()->to(base_url('home_siswa/v_tugas'));
        }
        $submissions = $this->pengumpulanModel->getSubmissions($id_tugas);
        $data = ['title' => 'Detail Tugas', 'title2' => 'Detail Tugas', 'tugas' => $tugas, 'submissions' => $submissions];
        return view('backend/siswa/tugas/v_dtl_tgs', $data);
    }

    public function form_kumpul($id_tugas)
    {
        $id_siswa = session()->get('id_siswa');
        if (!$id_siswa) {
            session()->setFlashdata('error', 'Anda harus login terlebih dahulu!');
            return redirect()->to(base_url('auth_login/login_siswa'));
        }
        $tugas = $this->tugasModel->detailTugas($id_tugas);
        $data = [
            'title' => 'Form Kumpul Tugas',
            'title2' => 'Form Kumpul Tugas',
            'tugas' => $tugas
        ];
        return view('backend/siswa/kml_tgs/v_add', $data);
    }

    public function save_kumpul()
    {
        $id_tugas = $this->request->getPost('id_tugas');
        $id_siswa = session()->get('id_siswa');
        if (!$id_tugas || !$id_siswa) {
            session()->setFlashdata('errors', ['Data tugas atau siswa tidak valid.']);
            return redirect()->back();
        }
        $rules = [
            'catatan_siswa' => ['label' => 'Catatan', 'rules' => 'required'],
            'file_tugas' => ['label' => 'File Tugas', 'rules' => 'uploaded[file_tugas]|max_size[file_tugas,2048]|ext_in[file_tugas,pdf,doc,docx,txt]']
        ];
        if ($this->validate($rules)) {
            $file = $this->request->getFile('file_tugas');
            $namaFile = null;
            if ($file && $file->isValid()) {
                $namaFile = $file->getRandomName();
                $file->move('kursus/tugassiswa', $namaFile);
            }
            $data = ['id_tugas' => $id_tugas, 'id_siswa' => $id_siswa, 'file_tugas' => $namaFile, 'nilai' => 0, 'status_penilaian' => 'menunggu', 'tanggal_kirim' => date('Y-m-d H:i:s'), 'id_pemilik' => session()->get('id_pemilik') ?? 1];
            $this->pengumpulanModel->insert($data);
            session()->setFlashdata('pesan', 'Tugas berhasil dikumpulkan!');
            return redirect()->to(base_url('home_siswa/kumpul_tugas'));
        } else {
            session()->setFlashdata('errors', \Config\Services::validation()->getErrors());
            return redirect()->back()->withInput();
        }
    }

    public function edit_kumpul($id_kumpul)
    {
        $data = ['title' => 'Edit Kumpul Tugas', 'title2' => 'Data Kumpul Tugas', 'kml' => $this->pengumpulanModel->detailKumpul($id_kumpul), 'tugas' => $this->tugasModel->get_tugas()];
        return view('backend/siswa/kml_tgs/v_edit', $data);
    }

    public function update_kumpul($id_kumpul)
    {
        $id_tugas = $this->request->getPost('id_tugas');
        $id_siswa = session()->get('id_siswa');
        if (!$id_tugas || !$id_siswa) {
            session()->setFlashdata('errors', ['Data tugas atau siswa tidak valid.']);
            return redirect()->back();
        }
        $dataLama = $this->pengumpulanModel->detailKumpul($id_kumpul);
        if (!$dataLama) {
            session()->setFlashdata('errors', ['Data pengumpulan tidak ditemukan.']);
            return redirect()->to(base_url('home_siswa/kumpul_tugas'));
        }
        $rules = [
            'catatan_siswa' => ['label' => 'Catatan', 'rules' => 'required'],
            'nilai' => ['label' => 'Nilai Tugas', 'rules' => 'required|numeric']
        ];
        $file = $this->request->getFile('file_tugas');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $rules['file_tugas'] = ['label' => 'File Tugas', 'rules' => 'max_size[file_tugas,2048]|ext_in[file_tugas,pdf,doc,docx,txt]'];
        }
        if ($this->validate($rules)) {
            $dataUpdate = ['id_tugas' => $id_tugas, 'id_siswa' => $id_siswa, 'catatan_siswa' => $this->request->getPost('catatan_siswa'), 'status_penilaian' => 'menunggu', 'tanggal_kirim' => date('Y-m-d H:i:s')];
            if ($file && $file->isValid() && !$file->hasMoved()) {
                if (!empty($dataLama['file_tugas'])) {
                    $oldPath = FCPATH . 'kursus/tugassiswa/' . $dataLama['file_tugas'];
                    if (file_exists($oldPath)) unlink($oldPath);
                }
                $newName = $file->getRandomName();
                $file->move('kursus/tugassiswa', $newName);
                $dataUpdate['file_tugas'] = $newName;
            } else {
                $dataUpdate['file_tugas'] = $dataLama['file_tugas'];
            }
            $this->pengumpulanModel->edit($id_kumpul, $dataUpdate);
            session()->setFlashdata('pesan', 'Data pengumpulan tugas berhasil diperbarui!');
            return redirect()->to(base_url('home_siswa/kumpul_tugas'));
        } else {
            session()->setFlashdata('errors', \Config\Services::validation()->getErrors());
            return redirect()->back()->withInput();
        }
    }

    public function delete_kumpul($id_kumpul)
    {
        $id_siswa = session()->get('id_siswa');
        $kumpul = $this->pengumpulanModel->detailKumpul($id_kumpul);
        if (!$kumpul || $kumpul['id_siswa'] != $id_siswa) {
            session()->setFlashdata('error', 'Data tidak ditemukan!');
            return redirect()->to(base_url('home_siswa/kumpul_tugas'));
        }
        if (!empty($kumpul['file_tugas'])) {
            $path = FCPATH . 'kursus/tugassiswa/' . $kumpul['file_tugas'];
            if (file_exists($path)) unlink($path);
        }
        $this->pengumpulanModel->delete($id_kumpul);
        session()->setFlashdata('pesan', 'Pengumpulan tugas berhasil dihapus!');
        return redirect()->to(base_url('home_siswa/kumpul_tugas'));
    }

    public function lihat_penilaian($id_kumpul)
    {
        $kumpul = $this->pengumpulanModel->detailKumpul($id_kumpul);
        $data = ['title' => 'Penilaian Tugas', 'title2' => 'Penilaian Tugas', 'kumpul' => $kumpul];
        return view('backend/siswa/kml_tgs/v_penilaian', $data);
    }
}
