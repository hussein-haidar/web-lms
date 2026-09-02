<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\M_alumni;

class Alumni extends BaseController
{
    protected $alumniModel;

    public function __construct()
    {
        $this->alumniModel = new M_alumni();
    }

    public function index()
    {
        $data = [
            'title' => 'Data Alumni',
            'alumni' => $this->alumniModel->getAlumniWithGambar(),
            'kategori_list' => $this->alumniModel->getKategoriList()
        ];

        return view('admin/alumni/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Alumni',
            'kategori_list' => $this->alumniModel->getKategoriList()
        ];

        return view('admin/alumni/create', $data);
    }

    public function store()
    {
        $validation = \Config\Services::validation();

        $rules = [
            'nama' => 'required|min_length[3]|max_length[255]',
            'deskripsi' => 'required|min_length[10]',
            'kategori' => 'required',
            'lokasi' => 'required|max_length[255]',
            'status' => 'required|in_list[Aktif,Tidak Aktif]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'nama' => $this->request->getPost('nama'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'kategori' => $this->request->getPost('kategori'),
            'lokasi' => $this->request->getPost('lokasi'),
            'facebook_url' => $this->request->getPost('facebook_url'),
            'tiktok_url' => $this->request->getPost('tiktok_url'),
            'whatsapp_url' => $this->request->getPost('whatsapp_url'),
            'status' => $this->request->getPost('status'),
            'warna_tema' => $this->request->getPost('warna_tema') ?: '#007bff'
        ];

        $fotoProfil = $this->request->getFile('foto_profil');
        if ($fotoProfil && $fotoProfil->isValid() && !$fotoProfil->hasMoved()) {
            $newName = $fotoProfil->getRandomName();
            $fotoProfil->move('uploads/alumni/profil', $newName);
            $data['foto_profil'] = $newName;
        }

        $galeriPhotos = $this->request->getFileMultiple('galeri_foto');
        $galeriData = [];

        if (!empty($galeriPhotos)) {
            foreach ($galeriPhotos as $index => $foto) {
                if ($foto && $foto->isValid() && !$foto->hasMoved()) {
                    $newName = $foto->getRandomName();
                    $foto->move('uploads/alumni/galeri', $newName);
                    $galeriData[] = [
                        'foto' => $newName,
                        'keterangan' => $this->request->getPost('galeri_keterangan')[$index] ?? ''
                    ];
                }
            }
        }

        $data['galeri'] = !empty($galeriData) ? json_encode($galeriData) : null;

        if ($this->alumniModel->addAlumniWithPaths($data)) {
            session()->setFlashdata('success', 'Data alumni berhasil ditambahkan');
            return redirect()->to(base_url('admin/alumni'));
        } else {
            session()->setFlashdata('error', 'Gagal menambahkan data alumni');
            return redirect()->back()->withInput();
        }
    }

    public function edit($id)
    {
        $alumni = $this->alumniModel->getAlumniById($id);

        if (!$alumni) {
            session()->setFlashdata('error', 'Data alumni tidak ditemukan');
            return redirect()->to(base_url('admin/alumni'));
        }

        if (!empty($alumni['galeri'])) {
            $alumni['galeri'] = json_decode($alumni['galeri'], true);
        }

        $data = [
            'title' => 'Edit Alumni',
            'alumni' => $alumni,
            'kategori_list' => $this->alumniModel->getKategoriList()
        ];

        return view('admin/alumni/edit', $data);
    }

    public function update($id)
    {
        $validation = \Config\Services::validation();

        $rules = [
            'nama' => 'required|min_length[3]|max_length[255]',
            'deskripsi' => 'required|min_length[10]',
            'kategori' => 'required',
            'lokasi' => 'required|max_length[255]',
            'status' => 'required|in_list[Aktif,Tidak Aktif]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'nama' => $this->request->getPost('nama'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'kategori' => $this->request->getPost('kategori'),
            'lokasi' => $this->request->getPost('lokasi'),
            'facebook_url' => $this->request->getPost('facebook_url'),
            'tiktok_url' => $this->request->getPost('tiktok_url'),
            'whatsapp_url' => $this->request->getPost('whatsapp_url'),
            'status' => $this->request->getPost('status'),
            'warna_tema' => $this->request->getPost('warna_tema') ?: '#007bff'
        ];

        $fotoProfil = $this->request->getFile('foto_profil');
        if ($fotoProfil && $fotoProfil->isValid() && !$fotoProfil->hasMoved()) {
            $newName = $fotoProfil->getRandomName();
            $fotoProfil->move('uploads/alumni/profil', $newName);
            $data['foto_profil'] = $newName;
        }

        $galeriPhotos = $this->request->getFileMultiple('galeri_foto');
        $galeriKeterangan = $this->request->getPost('galeri_keterangan') ?? [];
        $existingGaleri = $this->request->getPost('existing_galeri') ?? [];

        $alumni = $this->alumniModel->getAlumniById($id);
        $galeriData = [];

        if (!empty($alumni['galeri'])) {
            $galeriData = json_decode($alumni['galeri'], true) ?: [];
        }

        if (!empty($galeriPhotos)) {
            foreach ($galeriPhotos as $index => $foto) {
                if ($foto && $foto->isValid() && !$foto->hasMoved()) {
                    $newName = $foto->getRandomName();
                    $foto->move('uploads/alumni/galeri', $newName);
                    $galeriData[] = [
                        'foto' => $newName,
                        'keterangan' => $galeriKeterangan[$index] ?? ''
                    ];
                }
            }
        }

        $data['galeri'] = !empty($galeriData) ? json_encode($galeriData) : null;

        if ($this->alumniModel->updateAlumni($id, $data)) {
            session()->setFlashdata('success', 'Data alumni berhasil diperbarui');
            return redirect()->to(base_url('admin/alumni'));
        } else {
            session()->setFlashdata('error', 'Gagal memperbarui data alumni');
            return redirect()->back()->withInput();
        }
    }

    public function delete($id)
    {
        if ($this->alumniModel->deleteAlumni($id)) {
            session()->setFlashdata('success', 'Data alumni berhasil dihapus');
        } else {
            session()->setFlashdata('error', 'Gagal menghapus data alumni');
        }

        return redirect()->to(base_url('admin/alumni'));
    }
}
