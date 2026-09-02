<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\M_mitra_kerja;

class MitraKerja extends BaseController
{
    protected $mitraKerjaModel;

    public function __construct()
    {
        $this->mitraKerjaModel = new M_mitra_kerja();
    }

    public function index()
    {
        $data = [
            'title' => 'Mitra Kerja',
            'title2' => 'Mitra Kerja',
            'mitra' => $this->mitraKerjaModel->getAllPartners()
        ];
        return view('backend/superadmin/mitra_kerja/v_mitra_kerja', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Mitra Kerja',
            'title2' => 'Tambah Mitra Kerja'
        ];
        return view('backend/superadmin/mitra_kerja/v_add_mitra_kerja', $data);
    }

    public function save()
    {
        $rules = [
            'nama_mitra' => 'required|min_length[3]|max_length[100]',
            'deskripsi' => 'required|min_length[10]',
            'logo_mitra' => 'uploaded[logo_mitra]|max_size[logo_mitra,10240]|is_image[logo_mitra]',
            'urutan' => 'required|numeric',
            'status' => 'required|in_list[aktif,tidak_aktif]'
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', \Config\Services::validation()->getErrors());
        }
        $logo = $this->request->getFile('logo_mitra');
        $namaLogo = $logo->getRandomName();
        $logo->move('uploads/mitra_kerja', $namaLogo);
        $data = [
            'nama_mitra' => $this->request->getPost('nama_mitra'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'logo_mitra' => $namaLogo,
            'url_website' => $this->request->getPost('url_website'),
            'urutan' => $this->request->getPost('urutan'),
            'status' => $this->request->getPost('status')
        ];
        $this->mitraKerjaModel->insertPartner($data);
        session()->setFlashdata('pesan', 'Mitra kerja berhasil ditambahkan!');
        return redirect()->to(base_url('admin/mitra-kerja'));
    }

    public function edit($id_mitra)
    {
        $mitra = $this->mitraKerjaModel->getPartnerById($id_mitra);
        if (!$mitra) {
            session()->setFlashdata('error', 'Data mitra kerja tidak ditemukan!');
            return redirect()->to(base_url('admin/mitra-kerja'));
        }
        $data = [
            'title' => 'Edit Mitra Kerja',
            'title2' => 'Edit Mitra Kerja',
            'mitra' => $mitra
        ];
        return view('backend/superadmin/mitra_kerja/v_edit_mitra_kerja', $data);
    }

    public function update($id_mitra)
    {
        $mitra = $this->mitraKerjaModel->getPartnerById($id_mitra);
        if (!$mitra) {
            session()->setFlashdata('error', 'Data mitra kerja tidak ditemukan!');
            return redirect()->to(base_url('admin/mitra-kerja'));
        }
        $rules = [
            'nama_mitra' => 'required|min_length[3]|max_length[100]',
            'deskripsi' => 'required|min_length[10]',
            'urutan' => 'required|numeric',
            'status' => 'required|in_list[aktif,tidak_aktif]'
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', \Config\Services::validation()->getErrors());
        }
        $data = [
            'nama_mitra' => $this->request->getPost('nama_mitra'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'url_website' => $this->request->getPost('url_website'),
            'urutan' => $this->request->getPost('urutan'),
            'status' => $this->request->getPost('status')
        ];
        $logo = $this->request->getFile('logo_mitra');
        if ($logo && $logo->isValid()) {
            if (!empty($mitra['logo_mitra']) && file_exists('uploads/mitra_kerja/' . $mitra['logo_mitra'])) {
                unlink('uploads/mitra_kerja/' . $mitra['logo_mitra']);
            }
            $namaLogo = $logo->getRandomName();
            $logo->move('uploads/mitra_kerja', $namaLogo);
            $data['logo_mitra'] = $namaLogo;
        }
        $this->mitraKerjaModel->updatePartner($id_mitra, $data);
        session()->setFlashdata('pesan', 'Mitra kerja berhasil diperbarui!');
        return redirect()->to(base_url('admin/mitra-kerja'));
    }

    public function delete($id_mitra)
    {
        $mitra = $this->mitraKerjaModel->getPartnerById($id_mitra);
        if (!$mitra) {
            session()->setFlashdata('error', 'Data mitra kerja tidak ditemukan!');
            return redirect()->to(base_url('admin/mitra-kerja'));
        }
        if (!empty($mitra['logo_mitra']) && file_exists('uploads/mitra_kerja/' . $mitra['logo_mitra'])) {
            unlink('uploads/mitra_kerja/' . $mitra['logo_mitra']);
        }
        $this->mitraKerjaModel->deletePartner($id_mitra);
        session()->setFlashdata('pesan', 'Mitra kerja berhasil dihapus!');
        return redirect()->to(base_url('admin/mitra-kerja'));
    }
}
