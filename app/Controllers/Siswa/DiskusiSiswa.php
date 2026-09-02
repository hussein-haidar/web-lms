<?php

namespace App\Controllers\Siswa;

use App\Controllers\BaseController;
use App\Models\M_diskusi;
use App\Models\M_kursus;
use App\Models\M_pendaftaran;
use App\Models\M_siswa;

class DiskusiSiswa extends BaseController
{
    protected $M_diskusi;
    protected $M_kursus;
    protected $M_pendaftaran;
    protected $M_siswa;

    public function __construct()
    {
        $this->M_diskusi = new M_diskusi();
        $this->M_kursus = new M_kursus();
        $this->M_pendaftaran = new M_pendaftaran();
        $this->M_siswa = new M_siswa();
    }

    public function index($id_kursus)
    {
        $id_siswa = session()->get('id_siswa');
        if (!$id_siswa) {
            return redirect()->to(base_url('auth_login/login_siswa'));
        }

        $pendaftaran = $this->M_pendaftaran
            ->where('id_siswa', $id_siswa)
            ->where('id_kursus', $id_kursus)
            ->whereIn('status', ['aktif', 'selesai'])
            ->first();

        if (!$pendaftaran) {
            session()->setFlashdata('error', 'Anda belum terdaftar di kursus ini!');
            return redirect()->to(base_url('siswa/kursus'));
        }

        $filter = [
            'kategori' => $this->request->getGet('kategori') ?? 'all',
            'status'   => $this->request->getGet('status') ?? 'all',
            'search'   => $this->request->getGet('search') ?? '',
            'sort'     => $this->request->getGet('sort') ?? 'terbaru',
        ];

        $page = (int) ($this->request->getGet('page') ?? 1);
        $perPage = 20;
        $offset = ($page - 1) * $perPage;

        $total = $this->M_diskusi->countByKursus($id_kursus, $filter);
        $diskusi = $this->M_diskusi->getByKursus($id_kursus, $filter, $perPage, $offset);
        $kursus = $this->M_kursus->find($id_kursus);

        $data = [
            'title'       => 'Diskusi Kursus',
            'title2'      => 'Diskusi - ' . ($kursus['nama_kursus'] ?? ''),
            'kursus'      => $kursus,
            'diskusi'     => $diskusi,
            'total'       => $total,
            'page'        => $page,
            'perPage'     => $perPage,
            'totalPages'  => ceil($total / $perPage),
            'filter'      => $filter,
        ];

        return view('backend/siswa/diskusi/v_index', $data);
    }

    public function create($id_kursus)
    {
        $id_siswa = session()->get('id_siswa');
        if (!$id_siswa) {
            return redirect()->to(base_url('auth_login/login_siswa'));
        }

        $pendaftaran = $this->M_pendaftaran
            ->where('id_siswa', $id_siswa)
            ->where('id_kursus', $id_kursus)
            ->whereIn('status', ['aktif', 'selesai'])
            ->first();

        if (!$pendaftaran) {
            session()->setFlashdata('error', 'Anda belum terdaftar di kursus ini!');
            return redirect()->to(base_url('siswa/kursus'));
        }

        $kursus = $this->M_kursus->find($id_kursus);

        $data = [
            'title'  => 'Buat Diskusi Baru',
            'title2' => 'Buat Diskusi - ' . ($kursus['nama_kursus'] ?? ''),
            'kursus' => $kursus,
        ];

        return view('backend/siswa/diskusi/v_create', $data);
    }

    public function store()
    {
        $id_siswa = session()->get('id_siswa');
        if (!$id_siswa) {
            return redirect()->to(base_url('auth_login/login_siswa'));
        }

        $rules = [
            'id_kursus'  => 'required|integer',
            'judul'      => 'required|min_length[5]|max_length[200]',
            'konten'     => 'required|min_length[10]',
            'kategori'   => 'required|in_list[pertanyaan,diskusi,pengumuman]',
        ];

        if (!$this->validate($rules)) {
            session()->setFlashdata('errors', \Config\Services::validation()->getErrors());
            return redirect()->back()->withInput();
        }

        $id_kursus = $this->request->getPost('id_kursus');

        $pendaftaran = $this->M_pendaftaran
            ->where('id_siswa', $id_siswa)
            ->where('id_kursus', $id_kursus)
            ->whereIn('status', ['aktif', 'selesai'])
            ->first();

        if (!$pendaftaran) {
            session()->setFlashdata('error', 'Akses ditolak!');
            return redirect()->to(base_url('siswa/kursus'));
        }

        $siswa = $this->M_siswa->find($id_siswa);
        $judul = $this->request->getPost('judul');

        $data_diskusi = [
            'id_kursus'    => $id_kursus,
            'id_pendaftaran' => $pendaftaran['id_pendaftaran'],
            'id_user'      => $id_siswa,
            'user_role'    => 'siswa',
            'user_name'    => $siswa['nama_lengkap'] ?? 'Siswa',
            'user_avatar'  => $siswa['foto_profil'] ?? '',
            'judul'        => $judul,
            'slug'         => $this->M_diskusi->generateSlug($judul),
            'konten'       => $this->request->getPost('konten'),
            'kategori'     => $this->request->getPost('kategori'),
            'tags'         => $this->request->getPost('tags') ?? '',
            'komentar_json' => '[]',
            'total_views'  => 0,
            'total_comments' => 0,
            'total_likes'  => 0,
            'is_pinned'    => 0,
            'is_locked'    => 0,
            'status'       => 'open',
        ];

        $this->M_diskusi->insert($data_diskusi);

        session()->setFlashdata('pesan', 'Diskusi berhasil dibuat!');
        return redirect()->to(base_url('siswa/diskusi/' . $id_kursus));
    }

    public function show($slug)
    {
        $id_siswa = session()->get('id_siswa');
        if (!$id_siswa) {
            return redirect()->to(base_url('auth_login/login_siswa'));
        }

        $diskusi = $this->M_diskusi->where('slug', $slug)->first();
        if (!$diskusi) {
            session()->setFlashdata('error', 'Diskusi tidak ditemukan!');
            return redirect()->back();
        }

        $diskusi = $this->M_diskusi->getWithKomentar($diskusi['id_diskusi']);
        $kursus = $this->M_kursus->find($diskusi['id_kursus']);

        $data = [
            'title'   => 'Detail Diskusi',
            'title2'  => $diskusi['judul'],
            'diskusi' => $diskusi,
            'kursus'  => $kursus,
        ];

        return view('backend/siswa/diskusi/v_show', $data);
    }

    public function add_komentar($id_diskusi)
    {
        $id_siswa = session()->get('id_siswa');
        if (!$id_siswa) {
            return redirect()->to(base_url('auth_login/login_siswa'));
        }

        $rules = [
            'konten' => 'required|min_length[2]',
        ];

        if (!$this->validate($rules)) {
            session()->setFlashdata('errors', \Config\Services::validation()->getErrors());
            return redirect()->back();
        }

        $diskusi = $this->M_diskusi->find($id_diskusi);
        if (!$diskusi) {
            session()->setFlashdata('error', 'Diskusi tidak ditemukan!');
            return redirect()->back();
        }

        if ($diskusi['is_locked'] == 1) {
            session()->setFlashdata('error', 'Diskusi ini sudah dikunci!');
            return redirect()->back();
        }

        $siswa = $this->M_siswa->find($id_siswa);
        $parent_id = $this->request->getPost('parent_id') ?: null;

        $komentarData = [
            'id_user'    => $id_siswa,
            'user_name'  => $siswa['nama_lengkap'] ?? 'Siswa',
            'user_role'  => 'siswa',
            'user_avatar' => $siswa['foto_profil'] ?? '',
            'konten'     => $this->request->getPost('konten'),
            'parent_id'  => $parent_id,
        ];

        $this->M_diskusi->addKomentar($id_diskusi, $komentarData);

        $diskusiUpdated = $this->M_diskusi->where('id_diskusi', $id_diskusi)->first();
        $slug = $diskusiUpdated['slug'] ?? $id_diskusi;

        session()->setFlashdata('pesan', 'Komentar berhasil ditambahkan!');
        return redirect()->to(base_url('siswa/diskusi/view/' . $slug));
    }

    public function like_komentar($id_diskusi, $komentar_id)
    {
        $id_siswa = session()->get('id_siswa');
        if (!$id_siswa) {
            return redirect()->to(base_url('auth_login/login_siswa'));
        }

        $this->M_diskusi->toggleLike($id_diskusi, $komentar_id, $id_siswa);

        $diskusi = $this->M_diskusi->where('id_diskusi', $id_diskusi)->first();
        $slug = $diskusi['slug'] ?? $id_diskusi;

        return redirect()->to(base_url('siswa/diskusi/view/' . $slug));
    }

    public function search()
    {
        $id_siswa = session()->get('id_siswa');
        if (!$id_siswa) {
            return redirect()->to(base_url('auth_login/login_siswa'));
        }

        $keyword = $this->request->getGet('keyword') ?? '';
        $id_kursus = $this->request->getGet('id_kursus') ?? null;

        $diskusi = [];
        if (!empty($keyword)) {
            $diskusi = $this->M_diskusi->search($keyword, $id_kursus);
        }

        $data = [
            'title'   => 'Cari Diskusi',
            'title2'  => 'Hasil Pencarian',
            'diskusi' => $diskusi,
            'keyword' => $keyword,
        ];

        return view('backend/siswa/diskusi/v_search', $data);
    }

    public function ajax_load_komentar($id_diskusi)
    {
        $diskusi = $this->M_diskusi->getWithKomentar($id_diskusi);
        if (!$diskusi) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Diskusi tidak ditemukan']);
        }

        return $this->response->setJSON([
            'status'   => 'success',
            'komentar' => $diskusi['komentar'] ?? [],
        ]);
    }
}
