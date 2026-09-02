<?php

namespace App\Controllers\Siswa;

use App\Controllers\BaseController;
use App\Models\M_siswa;
use App\Models\M_keranjang;
use App\Models\M_paket;
use App\Models\M_kursus;
use App\Models\M_pendaftaran;
use App\Models\M_pembayaran;

class CartSiswa extends BaseController
{
    protected $siswaModel;
    protected $keranjangModel;
    protected $paketModel;
    protected $kursusModel;
    protected $pendaftaranModel;
    protected $pembayaranModel;

    public function __construct()
    {
        $this->siswaModel = new M_siswa();
        $this->keranjangModel = new M_keranjang();
        $this->paketModel = new M_paket();
        $this->kursusModel = new M_kursus();
        $this->pendaftaranModel = new M_pendaftaran();
        $this->pembayaranModel = new M_pembayaran();
    }

    public function index()
    {
        $id_siswa = session()->get('id_siswa');
        if (!$id_siswa) {
            session()->setFlashdata('error', 'Anda harus login terlebih dahulu!');
            return redirect()->to(base_url('auth_login/login_siswa'));
        }
        $keranjang = $this->keranjangModel->get_keranjang_siswa($id_siswa);
        $total_harga = 0;
        foreach ($keranjang as $item) {
            $total_harga += $item['harga_kursus'] ?? 0;
        }
        $data = [
            'title' => 'Keranjang Belanja',
            'keranjang' => $keranjang,
            'total_harga' => $total_harga,
        ];
        if (empty($keranjang)) {
            $data['empty_message'] = 'Keranjang Anda kosong. Silakan tambahkan kursus terlebih dahulu.';
        }
        return view('frontend/web/store/cart/v_keranjang', $data);
    }

    public function save_cart()
    {
        $id_siswa = session()->get('id_siswa');
        if (!$id_siswa) {
            session()->setFlashdata('error', 'Anda harus login terlebih dahulu!');
            return redirect()->to(base_url('auth_login/login_siswa'));
        }
        $id_kursus = $this->request->getPost('id_kursus');
        $id_paket = $this->request->getPost('id_paket');
        $nama_paket = $this->request->getPost('nama_paket');
        $nama_program = $this->request->getPost('nama_program');
        $gambar_detail_a = $this->request->getPost('gambar_detail_a');
        $harga_kursus = $this->request->getPost('harga_kursus');
        if (!$id_kursus || !$harga_kursus) {
            session()->setFlashdata('error', 'Data kursus atau harga tidak valid!');
            return redirect()->back();
        }
        $harga_kursus = is_numeric($harga_kursus) ? (float)$harga_kursus : 0.00;
        $cek = $this->keranjangModel->cek_item_ada($id_siswa, $id_kursus, $id_paket, $nama_program);
        if ($cek) {
            session()->setFlashdata('info', 'Item sudah ada di keranjang!');
            return redirect()->to(base_url('home_siswa/cart'));
        }
        $data = [
            'id_siswa' => $id_siswa,
            'id_kursus' => $id_kursus,
            'id_paket' => $id_paket,
            'nama_paket' => $nama_paket,
            'nama_program' => $nama_program,
            'harga_kursus' => $harga_kursus,
            'created_at' => date('Y-m-d H:i:s')
        ];
        try {
            $this->keranjangModel->insert($data);
            session()->setFlashdata('pesan', 'Berhasil ditambahkan ke keranjang!');
        } catch (\Exception $e) {
            session()->setFlashdata('error', 'Gagal menambah ke keranjang: ' . $e->getMessage());
        }
        return redirect()->to(base_url('home_siswa/cart'));
    }

    public function delete_cart($id_keranjang)
    {
        $id_siswa = session()->get('id_siswa');
        if (!$id_siswa) {
            session()->setFlashdata('error', 'Anda harus login terlebih dahulu!');
            return redirect()->to(base_url('auth_login/login_siswa'));
        }
        $item = $this->keranjangModel->find($id_keranjang);
        if ($item && $item['id_siswa'] == $id_siswa) {
            $this->keranjangModel->delete($id_keranjang);
            session()->setFlashdata('pesan', 'Berhasil dihapus dari keranjang!');
        } else {
            session()->setFlashdata('error', 'Gagal menghapus item!');
        }
        return redirect()->to(base_url('home_siswa/cart'));
    }

    public function checkout_noncart()
    {
        $id_siswa = session()->get('id_siswa');
        if (!$id_siswa) {
            session()->setFlashdata('error', 'Anda harus login terlebih dahulu!');
            return redirect()->to(base_url('auth_login/login_siswa'));
        }
        $id_kursus = $this->request->getPost('id_kursus');
        $id_paket = $this->request->getPost('id_paket');
        $nama_paket = $this->request->getPost('nama_paket');
        $nama_program = $this->request->getPost('nama_program');
        $harga_kursus = $this->request->getPost('harga_kursus');
        if (!$id_kursus) {
            return redirect()->to(base_url('home_siswa/kursus_saya'));
        }
        $kursus = $this->kursusModel->find($id_kursus);
        $item_checkout = [
            'id_kursus' => $id_kursus,
            'id_paket' => $id_paket,
            'nama_paket' => $nama_paket,
            'nama_program' => $nama_program,
            'harga_kursus' => $harga_kursus,
            'nama_kursus' => $kursus['nama_kursus'] ?? 'Unknown Course'
        ];
        $data = [
            'title'  => 'Checkout Pembelian',
            'title2' => 'Checkout Pembelian',
            'siswa'  => $this->siswaModel->find($id_siswa),
            'item_checkout' => $item_checkout
        ];
        return view('frontend/web/store/noncart/v_checkout', $data);
    }

    public function save_checkout_noncart()
    {
        $id_siswa = session()->get('id_siswa');
        if (!$id_siswa) {
            session()->setFlashdata('error', 'Anda harus login terlebih dahulu!');
            return redirect()->to(base_url('auth_login/login_siswa'));
        }
        $id_kursus = $this->request->getPost('id_kursus');
        $nama_paket = $this->request->getPost('nama_paket');
        $harga_kursus = $this->request->getPost('harga_kursus');
        $siswa = $this->siswaModel->find($id_siswa);
        if (!$siswa) {
            session()->setFlashdata('error', 'Data siswa tidak ditemukan');
            return redirect()->back()->withInput();
        }
        $kode_invoice = 'INV-' . date('Ymd') . '-' . rand(1000, 9999);
        $data_pendaftaran = [
            'id_siswa' => $id_siswa,
            'kode_invoice' => $kode_invoice,
            'id_kursus' => $id_kursus,
            'nama_paket' => $nama_paket,
            'harga_kursus' => $harga_kursus,
            'status' => 'pending',
            'tanggal_pendaftaran' => date('Y-m-d H:i:s'),
            'email' => $siswa['email'] ?? '',
            'nama_lengkap' => $siswa['nama_lengkap'] ?? '',
            'foto_profil' => $siswa['foto_profil'] ?? '',
            'tempat_lahir' => $siswa['tempat_lahir'] ?? '',
            'tanggal_lahir' => $siswa['tanggal_lahir'] ?? null,
            'jenis_kelamin' => $siswa['jenis_kelamin'] ?? 'Laki - laki',
            'agama' => $siswa['agama'] ?? 'Islam',
            'no_telepon' => $siswa['no_telepon'] ?? '',
            'alamat' => $siswa['alamat'] ?? '',
        ];
        $insert_result = $this->pendaftaranModel->insert($data_pendaftaran);
        if (!$insert_result) {
            session()->setFlashdata('error', 'Gagal menyimpan data pendaftaran');
            return redirect()->back()->withInput();
        }
        $data_pembayaran = [
            'kode_invoice' => $kode_invoice,
            'kode_transaksi' => $this->pembayaranModel->generateKodeTransaksi(),
            'jumlah_bayar' => $harga_kursus,
            'metode_pembayaran' => 'transfer_bank',
            'status_pembayaran' => 'pending',
            'tanggal_transaksi' => date('Y-m-d H:i:s'),
        ];
        $this->pembayaranModel->insert($data_pembayaran);
        session()->setFlashdata('pesan', 'Checkout berhasil! Kode Invoice: ' . $kode_invoice);
        return redirect()->to(base_url('home_siswa/status_bayar'));
    }

    public function checkout_direct($id_paket)
    {
        $id_siswa = session()->get('id_siswa');
        if (!$id_siswa) {
            session()->setFlashdata('error', 'Anda harus login terlebih dahulu!');
            return redirect()->to(base_url('auth_login/login_siswa'));
        }
        $paket = $this->paketModel->detailPaket($id_paket);
        if (!$paket) {
            session()->setFlashdata('error', 'Paket tidak ditemukan!');
            return redirect()->to(base_url('home_website/kls_online'));
        }
        $harga_kursus = $paket['harga_reguler'];
        $item_checkout = [
            'id_kursus' => $paket['id_kursus'],
            'id_paket' => $id_paket,
            'nama_paket' => $paket['nama_paket'],
            'nama_program' => $paket['nama_program'] ?? 'Kelas Online',
            'harga_kursus' => $harga_kursus,
            'nama_kursus' => $paket['nama_kursus'] ?? 'Unknown Course'
        ];
        $data = [
            'title'  => 'Checkout Pembelian',
            'title2' => 'Checkout Pembelian',
            'siswa'  => $this->siswaModel->find($id_siswa),
            'item_checkout' => $item_checkout
        ];
        return view('frontend/web/store/noncart/v_checkout', $data);
    }
}
