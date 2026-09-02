<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\M_postingan;

class Postingan extends BaseController
{
    protected $postinganModel;

    public function __construct()
    {
        $this->postinganModel = new M_postingan();
    }

    public function index()
    {
        $status = $this->request->getGet('status');
        $postinganQuery = $this->postinganModel;
        if ($status && in_array($status, ['draft', 'published', 'archived'])) {
            $postinganQuery = $postinganQuery->where('status', $status);
        }
        $data = [
            'title' => 'Postingan Admin',
            'title2' => 'Postingan Admin',
            'postingan' => $postinganQuery->orderBy('created_at', 'DESC')->findAll(),
            'status' => $status
        ];
        return view('backend/superadmin/postingan/v_postingan_admin', $data);
    }

    public function create()
    {
        $categories = [
            'Umum' => 'Umum',
            'Pengumuman' => 'Pengumuman',
            'Berita' => 'Berita',
            'Tutorial' => 'Tutorial'
        ];
        $data = [
            'title' => 'Buat Postingan',
            'title2' => 'Buat Postingan',
            'categories' => $categories
        ];
        return view('backend/superadmin/postingan/v_postingan_create', $data);
    }

    public function save()
    {
        $rules = [
            'judul_postingan' => 'required',
            'konten' => 'required',
            'kategori' => 'required'
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', \Config\Services::validation()->getErrors());
        }
        $gambar = '';
        $file = $this->request->getFile('gambar_postingan');
        if ($file && $file->isValid()) {
            $gambar = $file->getRandomName();
            $file->move('uploads/postingan', $gambar);
        }
        $data = [
            'judul_postingan' => $this->request->getPost('judul_postingan'),
            'slug' => $this->request->getPost('slug'),
            'konten' => $this->request->getPost('konten'),
            'excerpt' => $this->request->getPost('excerpt'),
            'kategori' => $this->request->getPost('kategori'),
            'penulis' => $this->request->getPost('penulis'),
            'status' => $this->request->getPost('status') ?: 'published',
            'meta_description' => $this->request->getPost('meta_description'),
            'meta_keywords' => $this->request->getPost('meta_keywords'),
            'gambar_postingan' => $gambar,
            'created_at' => date('Y-m-d H:i:s')
        ];
        $this->postinganModel->insert($data);
        session()->setFlashdata('pesan', 'Postingan berhasil dibuat!');
        return redirect()->to(base_url('admin/postingan'));
    }

    public function edit($id_postingan)
    {
        $postingan = $this->postinganModel->find($id_postingan);
        if (!$postingan) {
            session()->setFlashdata('error', 'Data postingan tidak ditemukan!');
            return redirect()->to(base_url('admin/postingan'));
        }
        $categories = [
            'Umum' => 'Umum',
            'Pengumuman' => 'Pengumuman',
            'Berita' => 'Berita',
            'Tutorial' => 'Tutorial'
        ];
        $data = [
            'title' => 'Edit Postingan',
            'title2' => 'Edit Postingan',
            'postingan' => $postingan,
            'categories' => $categories
        ];
        return view('backend/superadmin/postingan/v_postingan_edit', $data);
    }

    public function update($id_postingan)
    {
        $postingan = $this->postinganModel->find($id_postingan);
        if (!$postingan) {
            session()->setFlashdata('error', 'Data postingan tidak ditemukan!');
            return redirect()->to(base_url('admin/postingan'));
        }
        $rules = [
            'judul_postingan' => 'required',
            'konten' => 'required',
            'kategori' => 'required'
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', \Config\Services::validation()->getErrors());
        }
        $data = [
            'judul_postingan' => $this->request->getPost('judul_postingan'),
            'slug' => $this->request->getPost('slug'),
            'konten' => $this->request->getPost('konten'),
            'excerpt' => $this->request->getPost('excerpt'),
            'kategori' => $this->request->getPost('kategori'),
            'penulis' => $this->request->getPost('penulis'),
            'status' => $this->request->getPost('status'),
            'meta_description' => $this->request->getPost('meta_description'),
            'meta_keywords' => $this->request->getPost('meta_keywords')
        ];
        $file = $this->request->getFile('gambar_postingan');
        if ($file && $file->isValid()) {
            if (!empty($postingan['gambar_postingan']) && file_exists('uploads/postingan/' . $postingan['gambar_postingan'])) {
                unlink('uploads/postingan/' . $postingan['gambar_postingan']);
            }
            $gambar = $file->getRandomName();
            $file->move('uploads/postingan', $gambar);
            $data['gambar_postingan'] = $gambar;
        }
        if ($this->request->getPost('remove_current_image') == '1') {
            if (!empty($postingan['gambar_postingan']) && file_exists('uploads/postingan/' . $postingan['gambar_postingan'])) {
                unlink('uploads/postingan/' . $postingan['gambar_postingan']);
            }
            $data['gambar_postingan'] = null;
        }
        $this->postinganModel->update($id_postingan, $data);
        session()->setFlashdata('pesan', 'Postingan berhasil diperbarui!');
        return redirect()->to(base_url('admin/postingan'));
    }

    public function delete($id_postingan)
    {
        $postingan = $this->postinganModel->find($id_postingan);
        if (!$postingan) {
            session()->setFlashdata('error', 'Data postingan tidak ditemukan!');
            return redirect()->to(base_url('admin/postingan'));
        }
        if (!empty($postingan['gambar_postingan']) && file_exists('uploads/postingan/' . $postingan['gambar_postingan'])) {
            unlink('uploads/postingan/' . $postingan['gambar_postingan']);
        }
        $this->postinganModel->delete($id_postingan);
        session()->setFlashdata('pesan', 'Postingan berhasil dihapus!');
        return redirect()->to(base_url('admin/postingan'));
    }

    public function restore($id_postingan)
    {
        $postingan = $this->postinganModel->withDeleted()->find($id_postingan);
        if (!$postingan) {
            session()->setFlashdata('error', 'Data postingan tidak ditemukan!');
            return redirect()->to(base_url('admin/postingan/deleted'));
        }
        $this->postinganModel->restore($id_postingan);
        session()->setFlashdata('pesan', 'Postingan berhasil dipulihkan!');
        return redirect()->to(base_url('admin/postingan/deleted'));
    }

    public function permanent_delete($id_postingan)
    {
        $postingan = $this->postinganModel->withDeleted()->find($id_postingan);
        if (!$postingan) {
            session()->setFlashdata('error', 'Data postingan tidak ditemukan!');
            return redirect()->to(base_url('admin/postingan/deleted'));
        }
        $this->postinganModel->purgeDeleted($id_postingan);
        session()->setFlashdata('pesan', 'Postingan berhasil dihapus permanen!');
        return redirect()->to(base_url('admin/postingan/deleted'));
    }

    public function deleted()
    {
        $data = [
            'title' => 'Postingan Dihapus',
            'title2' => 'Postingan Dihapus',
            'postingan' => $this->postinganModel->onlyDeleted()->findAll()
        ];
        return view('backend/superadmin/postingan/v_postingan_deleted', $data);
    }
}
