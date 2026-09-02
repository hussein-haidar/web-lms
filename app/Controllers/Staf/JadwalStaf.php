<?php

namespace App\Controllers\Staf;

use App\Controllers\BaseController;
use App\Models\M_jadwal;
use App\Models\M_kursus;
use App\Models\M_karyawan;

class JadwalStaf extends BaseController
{
    protected $M_jadwal;
    protected $M_kursus;
    protected $M_karyawan;

    public function __construct()
    {
        $this->M_jadwal   = new M_jadwal();
        $this->M_kursus   = new M_kursus();
        $this->M_karyawan = new M_karyawan();
    }

    private function cekLogin()
    {
        if (!session()->get('id_karyawan')) {
            return redirect()->to(base_url('auth_login/login_karyawan'));
        }
        return null;
    }

    private function rules(): array
    {
        return [
            'judul'           => 'required|min_length[3]|max_length[255]',
            'deskripsi'       => 'permit_empty|max_length[1000]',
            'tanggal_mulai'   => 'required|valid_date[Y-m-d]',
            'tanggal_selesai' => 'required|valid_date[Y-m-d]',
            'tipe'            => 'required|in_list[kursus,deadline,ujian,libur,lainnya]',
            'warna'           => 'required|regex_match[/^#[0-9A-Fa-f]{6}$/]',
            'status'          => 'required|in_list[aktif,nonaktif]',
            'id_kursus'       => 'permit_empty|is_natural_no_zero',
            'id_karyawan'     => 'permit_empty|is_natural_no_zero',
        ];
    }

    public function index()
    {
        $redirect = $this->cekLogin();
        if ($redirect) {
            return $redirect;
        }

        $data = [
            'title'  => 'Manajemen Jadwal',
            'title2' => 'Kalender Akademik',
            'jadwal' => $this->M_jadwal->getList(),
        ];

        return view('backend/karyawan/jadwal/v_index', $data);
    }

    public function create()
    {
        $redirect = $this->cekLogin();
        if ($redirect) {
            return $redirect;
        }

        $data = [
            'title'    => 'Tambah Jadwal',
            'title2'   => 'Manajemen Jadwal',
            'jadwal'   => null,
            'kursus'   => $this->M_kursus->findAll(),
            'karyawan' => $this->M_karyawan->findAll(),
            'validation' => \Config\Services::validation(),
        ];

        return view('backend/karyawan/jadwal/v_form', $data);
    }

    public function store()
    {
        $redirect = $this->cekLogin();
        if ($redirect) {
            return $redirect;
        }

        if (!$this->validate($this->rules())) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->M_jadwal->insert($this->requestData());

        session()->setFlashdata('pesan', 'Jadwal berhasil ditambahkan!');
        return redirect()->to(base_url('staf/jadwal'));
    }

    public function edit($id_jadwal)
    {
        $redirect = $this->cekLogin();
        if ($redirect) {
            return $redirect;
        }

        $jadwal = $this->M_jadwal->find($id_jadwal);
        if (!$jadwal) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Jadwal tidak ditemukan');
        }

        $data = [
            'title'      => 'Edit Jadwal',
            'title2'     => 'Manajemen Jadwal',
            'jadwal'     => $jadwal,
            'kursus'     => $this->M_kursus->findAll(),
            'karyawan'   => $this->M_karyawan->findAll(),
            'validation' => \Config\Services::validation(),
        ];

        return view('backend/karyawan/jadwal/v_form', $data);
    }

    public function update($id_jadwal)
    {
        $redirect = $this->cekLogin();
        if ($redirect) {
            return $redirect;
        }

        $jadwal = $this->M_jadwal->find($id_jadwal);
        if (!$jadwal) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Jadwal tidak ditemukan');
        }

        if (!$this->validate($this->rules())) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->M_jadwal->update($id_jadwal, $this->requestData());

        session()->setFlashdata('pesan', 'Jadwal berhasil diperbarui!');
        return redirect()->to(base_url('staf/jadwal'));
    }

    public function delete($id_jadwal)
    {
        $redirect = $this->cekLogin();
        if ($redirect) {
            return $redirect;
        }

        $jadwal = $this->M_jadwal->find($id_jadwal);
        if ($jadwal) {
            $this->M_jadwal->delete($id_jadwal);
            session()->setFlashdata('pesan', 'Jadwal berhasil dihapus!');
        } else {
            session()->setFlashdata('error', 'Jadwal tidak ditemukan!');
        }

        return redirect()->to(base_url('staf/jadwal'));
    }

    public function toggle($id_jadwal)
    {
        $redirect = $this->cekLogin();
        if ($redirect) {
            return $redirect;
        }

        $jadwal = $this->M_jadwal->find($id_jadwal);
        if ($jadwal) {
            $this->M_jadwal->update($id_jadwal, [
                'status' => ($jadwal['status'] === 'aktif') ? 'nonaktif' : 'aktif',
            ]);
            session()->setFlashdata('pesan', 'Status jadwal diperbarui!');
        }

        return redirect()->to(base_url('staf/jadwal'));
    }

    private function requestData(): array
    {
        return [
            'judul'           => $this->request->getPost('judul'),
            'deskripsi'       => $this->request->getPost('deskripsi'),
            'tanggal_mulai'   => $this->request->getPost('tanggal_mulai'),
            'tanggal_selesai' => $this->request->getPost('tanggal_selesai'),
            'tipe'            => $this->request->getPost('tipe'),
            'warna'           => $this->request->getPost('warna'),
            'status'          => $this->request->getPost('status'),
            'id_kursus'       => $this->request->getPost('id_kursus') ?: null,
            'id_karyawan'     => $this->request->getPost('id_karyawan') ?: null,
            'is_recurring'    => 0,
            'recurrence'      => null,
        ];
    }
}
