<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\M_web;
use App\Models\M_program;
use App\Models\M_slider_promo;
use App\Models\M_slider_web;

class WebManagement extends BaseController
{
    protected $webModel;
    protected $programModel;
    protected $sliderModel;
    protected $sliderWebModel;

    public function __construct()
    {
        $this->webModel = new M_web();
        $this->programModel = new M_program();
        $this->sliderModel = new M_slider_promo();
        $this->sliderWebModel = new M_slider_web();
    }

    // ==================== WEB ====================
    public function web()
    {
        $data = [
            'title' => 'Web Management',
            'title2' => 'Web Management',
            'web' => $this->webModel->get_web()
        ];
        return view('backend/superadmin/web/v_web', $data);
    }

    public function add_web()
    {
        $data = [
            'title' => 'Tambah Web',
            'title2' => 'Tambah Web'
        ];
        return view('backend/superadmin/web/v_add_web', $data);
    }

    public function save_web()
    {
        $rules = [
            'nama_website' => 'required|min_length[3]|max_length[100]',
            'alamat' => 'required|min_length[10]',
            'no_telepon' => 'required|min_length[10]|max_length[15]',
            'email' => 'required|valid_email'
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', \Config\Services::validation()->getErrors());
        }
        $data = [
            'nama_website' => $this->request->getPost('nama_website'),
            'alamat' => $this->request->getPost('alamat'),
            'no_telepon' => $this->request->getPost('no_telepon'),
            'email' => $this->request->getPost('email_kontak'),
            'jam_kerja' => $this->request->getPost('jam_kerja'),
            'sejarah' => $this->request->getPost('sejarah_lengkap'),
            'url_yt' => $this->request->getPost('url_yt'),
            'meta_description' => $this->request->getPost('meta_description'),
            'meta_keywords' => $this->request->getPost('meta_keywords')
        ];
        $logo = $this->request->getFile('logo');
        if ($logo && $logo->isValid() && !$logo->hasMoved()) {
            $logoName = $logo->getRandomName();
            $logo->move('logo', $logoName);
            $data['logo'] = $logoName;
        }
        $banner = $this->request->getFile('banner_utama');
        if ($banner && $banner->isValid() && !$banner->hasMoved()) {
            $bannerName = $banner->getRandomName();
            $banner->move('banner', $bannerName);
            $data['banner_utama'] = $bannerName;
        }
        $this->webModel->add($data);
        session()->setFlashdata('pesan', 'Web berhasil ditambahkan!');
        return redirect()->to(base_url('admin/web'));
    }

    public function edit_web($id_web)
    {
        $web = $this->webModel->detailWeb($id_web);
        if (!$web) {
            session()->setFlashdata('error', 'Data web tidak ditemukan!');
            return redirect()->to(base_url('admin/web'));
        }
        $data = [
            'title' => 'Edit Web',
            'title2' => 'Edit Web',
            'web' => $web
        ];
        return view('backend/superadmin/web/v_edit_web', $data);
    }

    public function update_web($id_web)
    {
        $web = $this->webModel->detailWeb($id_web);
        if (!$web) {
            session()->setFlashdata('error', 'Data web tidak ditemukan!');
            return redirect()->to(base_url('admin/web'));
        }
        $rules = [
            'nama_website' => 'required|min_length[3]|max_length[100]',
            'alamat' => 'required|min_length[10]',
            'no_telepon' => 'required|min_length[10]|max_length[15]',
            'email' => 'required|valid_email'
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', \Config\Services::validation()->getErrors());
        }
        $data = [
            'id_setting' => $id_web,
            'nama_website' => $this->request->getPost('nama_website'),
            'alamat' => $this->request->getPost('alamat'),
            'no_telepon' => $this->request->getPost('no_telepon'),
            'email' => $this->request->getPost('email_kontak'),
            'jam_kerja' => $this->request->getPost('jam_kerja'),
            'sejarah' => $this->request->getPost('sejarah_lengkap'),
            'url_yt' => $this->request->getPost('url_yt'),
            'meta_description' => $this->request->getPost('meta_description'),
            'meta_keywords' => $this->request->getPost('meta_keywords'),
            'updated_at' => date('Y-m-d H:i:s')
        ];
        $logo = $this->request->getFile('logo');
        if ($logo && $logo->isValid() && !$logo->hasMoved()) {
            if (!empty($web['logo']) && file_exists('logo/' . $web['logo'])) {
                unlink('logo/' . $web['logo']);
            }
            $logoName = $logo->getRandomName();
            $logo->move('logo', $logoName);
            $data['logo'] = $logoName;
        }
        $banner = $this->request->getFile('banner_utama');
        if ($banner && $banner->isValid() && !$banner->hasMoved()) {
            if (!empty($web['banner_utama']) && file_exists('banner/' . $web['banner_utama'])) {
                unlink('banner/' . $web['banner_utama']);
            }
            $bannerName = $banner->getRandomName();
            $banner->move('banner', $bannerName);
            $data['banner_utama'] = $bannerName;
        }
        $this->webModel->edit($data);
        session()->setFlashdata('pesan', 'Web berhasil diperbarui!');
        return redirect()->to(base_url('admin/web'));
    }

    public function delete_web($id_web)
    {
        $web = $this->webModel->detailWeb($id_web);
        if (!$web) {
            session()->setFlashdata('error', 'Data web tidak ditemukan!');
            return redirect()->to(base_url('admin/web'));
        }
        if (!empty($web['logo']) && file_exists('logo/' . $web['logo'])) {
            unlink('logo/' . $web['logo']);
        }
        if (!empty($web['banner_utama']) && file_exists('banner/' . $web['banner_utama'])) {
            unlink('banner/' . $web['banner_utama']);
        }
        $this->webModel->deleted_data(['id_setting' => $id_web]);
        session()->setFlashdata('pesan', 'Web berhasil dihapus!');
        return redirect()->to(base_url('admin/web'));
    }

    // ==================== PROGRAM ====================
    public function program()
    {
        $data = [
            'title' => 'Data Program',
            'title2' => 'Data Program',
            'program' => $this->programModel->findAll()
        ];
        return view('backend/superadmin/program/v_program', $data);
    }

    public function add_program()
    {
        $data = [
            'title' => 'Tambah Program',
            'title2' => 'Tambah Program'
        ];
        return view('backend/superadmin/program/v_add_program', $data);
    }

    public function save_program()
    {
        $rules = [
            'nama_program' => 'required',
            'deskripsi' => 'required'
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', \Config\Services::validation()->getErrors());
        }
        $data = [
            'nama_program' => $this->request->getPost('nama_program'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'status' => 'aktif'
        ];
        $this->programModel->insert($data);
        session()->setFlashdata('pesan', 'Program berhasil ditambahkan!');
        return redirect()->to(base_url('admin/program'));
    }

    public function edit_program($id_program)
    {
        $program = $this->programModel->find($id_program);
        if (!$program) {
            session()->setFlashdata('error', 'Data program tidak ditemukan!');
            return redirect()->to(base_url('admin/program'));
        }
        $data = [
            'title' => 'Edit Program',
            'title2' => 'Edit Program',
            'program' => $program
        ];
        return view('backend/superadmin/program/v_edit_program', $data);
    }

    public function update_program($id_program)
    {
        $program = $this->programModel->find($id_program);
        if (!$program) {
            session()->setFlashdata('error', 'Data program tidak ditemukan!');
            return redirect()->to(base_url('admin/program'));
        }
        $data = [
            'nama_program' => $this->request->getPost('nama_program'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'status' => $this->request->getPost('status')
        ];
        $this->programModel->update($id_program, $data);
        session()->setFlashdata('pesan', 'Program berhasil diperbarui!');
        return redirect()->to(base_url('admin/program'));
    }

    public function delete_program($id_program)
    {
        $program = $this->programModel->find($id_program);
        if (!$program) {
            session()->setFlashdata('error', 'Data program tidak ditemukan!');
            return redirect()->to(base_url('admin/program'));
        }
        $this->programModel->delete($id_program);
        session()->setFlashdata('pesan', 'Program berhasil dihapus!');
        return redirect()->to(base_url('admin/program'));
    }

    // ==================== SLIDER PROMO ====================
    public function slider_promo()
    {
        $data = [
            'title' => 'Slider Promo',
            'title2' => 'Slider Promo',
            'slider' => $this->sliderModel->orderBy('urutan', 'ASC')->findAll()
        ];
        return view('backend/superadmin/slider_promo/v_slider_promo', $data);
    }

    public function add_slider_promo()
    {
        $data = [
            'title' => 'Tambah Slider Promo',
            'title2' => 'Tambah Slider Promo'
        ];
        return view('backend/superadmin/slider_promo/v_add_slider_promo', $data);
    }

    public function save_slider_promo()
    {
        $rules = [
            'judul_slider' => 'required',
            'deskripsi' => 'required',
            'gambar_slider' => 'uploaded[gambar_slider]|max_size[gambar_slider,2048]|is_image[gambar_slider]'
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', \Config\Services::validation()->getErrors());
        }
        $gambar = $this->request->getFile('gambar_slider');
        $namaGambar = $gambar->getRandomName();
        $gambar->move('uploads/slider_promo', $namaGambar);
        $data = [
            'judul_slider' => $this->request->getPost('judul_slider'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'gambar_slider' => $namaGambar,
            'status' => 'aktif',
            'urutan' => $this->sliderModel->countAll() + 1
        ];
        $this->sliderModel->insert($data);
        session()->setFlashdata('pesan', 'Slider promo berhasil ditambahkan!');
        return redirect()->to(base_url('admin/slider-promo'));
    }

    public function edit_slider_promo($id_slider)
    {
        $slider = $this->sliderModel->find($id_slider);
        if (!$slider) {
            session()->setFlashdata('error', 'Data slider promo tidak ditemukan!');
            return redirect()->to(base_url('admin/slider-promo'));
        }
        $data = [
            'title' => 'Edit Slider Promo',
            'title2' => 'Edit Slider Promo',
            'slider' => $slider
        ];
        return view('backend/superadmin/slider_promo/v_edit_slider_promo', $data);
    }

    public function update_slider_promo($id_slider)
    {
        $slider = $this->sliderModel->find($id_slider);
        if (!$slider) {
            session()->setFlashdata('error', 'Data slider promo tidak ditemukan!');
            return redirect()->to(base_url('admin/slider-promo'));
        }
        $data = [
            'judul_slider' => $this->request->getPost('judul_slider'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'link_url' => $this->request->getPost('link_url'),
            'urutan' => $this->request->getPost('urutan'),
            'status' => $this->request->getPost('status')
        ];
        $gambar = $this->request->getFile('gambar_slider');
        if ($gambar && $gambar->isValid()) {
            if (!empty($slider['gambar_slider']) && file_exists('uploads/slider_promo/' . $slider['gambar_slider'])) {
                unlink('uploads/slider_promo/' . $slider['gambar_slider']);
            }
            $namaGambar = $gambar->getRandomName();
            $gambar->move('uploads/slider_promo', $namaGambar);
            $data['gambar_slider'] = $namaGambar;
        }
        $this->sliderModel->update($id_slider, $data);
        session()->setFlashdata('pesan', 'Slider promo berhasil diperbarui!');
        return redirect()->to(base_url('admin/slider-promo'));
    }

    public function delete_slider_promo($id_slider)
    {
        $slider = $this->sliderModel->find($id_slider);
        if (!$slider) {
            session()->setFlashdata('error', 'Data slider promo tidak ditemukan!');
            return redirect()->to(base_url('admin/slider-promo'));
        }
        if (!empty($slider['gambar_slider']) && file_exists('uploads/slider_promo/' . $slider['gambar_slider'])) {
            unlink('uploads/slider_promo/' . $slider['gambar_slider']);
        }
        $this->sliderModel->delete($id_slider);
        session()->setFlashdata('pesan', 'Slider promo berhasil dihapus!');
        return redirect()->to(base_url('admin/slider-promo'));
    }

    public function update_order_slider_promo()
    {
        $id_slider = $this->request->getPost('id_slider');
        $urutan = $this->request->getPost('urutan');
        if ($id_slider && $urutan !== null) {
            $this->sliderModel->update($id_slider, ['urutan' => $urutan]);
            return $this->response->setJSON(['status' => 'success', 'message' => 'Urutan slider promo berhasil diperbarui']);
        }
        return $this->response->setJSON(['status' => 'error', 'message' => 'Data tidak lengkap']);
    }

    public function toggle_status_slider_promo($id_slider)
    {
        $slider = $this->sliderModel->find($id_slider);
        if (!$slider) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Slider promo tidak ditemukan']);
        }
        $newStatus = $slider['status'] == 'aktif' ? 'nonaktif' : 'aktif';
        $this->sliderModel->update($id_slider, ['status' => $newStatus]);
        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Status slider promo berhasil diubah',
            'new_status' => $newStatus
        ]);
    }

    // ==================== SLIDER WEB ====================
    public function slider_web()
    {
        $data = [
            'title' => 'Slider Web',
            'title2' => 'Slider Web',
            'slider' => $this->sliderWebModel->orderBy('urutan', 'ASC')->findAll()
        ];
        return view('backend/superadmin/slider_web/v_slider_web', $data);
    }

    public function add_slider_web()
    {
        $data = [
            'title' => 'Tambah Slider Web',
            'title2' => 'Tambah Slider Web'
        ];
        return view('backend/superadmin/slider_web/v_add_slider_web', $data);
    }

    public function save_slider_web()
    {
        $rules = [
            'judul_slider' => 'required',
            'deskripsi' => 'required',
            'gambar_slider' => 'uploaded[gambar_slider]|max_size[gambar_slider,2048]|is_image[gambar_slider]'
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', \Config\Services::validation()->getErrors());
        }
        $gambar = $this->request->getFile('gambar_slider');
        $namaGambar = $gambar->getRandomName();
        $gambar->move('uploads/slider_web', $namaGambar);
        $data = [
            'judul_slider' => $this->request->getPost('judul_slider'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'gambar_slider' => $namaGambar,
            'status' => 'aktif',
            'urutan' => $this->sliderWebModel->countAll() + 1
        ];
        $this->sliderWebModel->insert($data);
        session()->setFlashdata('pesan', 'Slider web berhasil ditambahkan!');
        return redirect()->to(base_url('admin/slider-web'));
    }

    public function edit_slider_web($id_slider)
    {
        $slider = $this->sliderWebModel->find($id_slider);
        if (!$slider) {
            session()->setFlashdata('error', 'Data slider web tidak ditemukan!');
            return redirect()->to(base_url('admin/slider-web'));
        }
        $data = [
            'title' => 'Edit Slider Web',
            'title2' => 'Edit Slider Web',
            'slider' => $slider
        ];
        return view('backend/superadmin/slider_web/v_edit_slider_web', $data);
    }

    public function update_slider_web($id_slider)
    {
        $slider = $this->sliderWebModel->find($id_slider);
        if (!$slider) {
            session()->setFlashdata('error', 'Data slider web tidak ditemukan!');
            return redirect()->to(base_url('admin/slider-web'));
        }
        $data = [
            'judul_slider' => $this->request->getPost('judul_slider'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'link_url' => $this->request->getPost('link_url'),
            'urutan' => $this->request->getPost('urutan'),
            'status' => $this->request->getPost('status')
        ];
        $gambar = $this->request->getFile('gambar_slider');
        if ($gambar && $gambar->isValid()) {
            if (!empty($slider['gambar_slider']) && file_exists('uploads/slider_web/' . $slider['gambar_slider'])) {
                unlink('uploads/slider_web/' . $slider['gambar_slider']);
            }
            $namaGambar = $gambar->getRandomName();
            $gambar->move('uploads/slider_web', $namaGambar);
            $data['gambar_slider'] = $namaGambar;
        }
        $this->sliderWebModel->update($id_slider, $data);
        session()->setFlashdata('pesan', 'Slider web berhasil diperbarui!');
        return redirect()->to(base_url('admin/slider-web'));
    }

    public function delete_slider_web($id_slider)
    {
        $slider = $this->sliderWebModel->find($id_slider);
        if (!$slider) {
            session()->setFlashdata('error', 'Data slider web tidak ditemukan!');
            return redirect()->to(base_url('admin/slider-web'));
        }
        if (!empty($slider['gambar_slider']) && file_exists('uploads/slider_web/' . $slider['gambar_slider'])) {
            unlink('uploads/slider_web/' . $slider['gambar_slider']);
        }
        $this->sliderWebModel->delete($id_slider);
        session()->setFlashdata('pesan', 'Slider web berhasil dihapus!');
        return redirect()->to(base_url('admin/slider-web'));
    }
}
