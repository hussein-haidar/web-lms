<?php

namespace App\Controllers\Staf;

use App\Controllers\BaseController;
use App\Models\M_pembayaran;
use App\Models\M_pendaftaran;
use App\Models\M_siswa;

class PembayaranStaf extends BaseController
{
    protected $pembayaranModel;
    protected $pendaftaranModel;
    protected $siswaModel;

    public function __construct()
    {
        $this->pembayaranModel = new M_pembayaran();
        $this->pendaftaranModel = new M_pendaftaran();
        $this->siswaModel = new M_siswa();
    }

    public function index()
    {
        $data = [
            'title' => 'Verifikasi Pembayaran',
            'title2' => 'Verifikasi Pembayaran',
            'pembayaran' => $this->pembayaranModel->getPendingPayments()
        ];
        return view('backend/karyawan/staf_admin/pembayaran/v_pembayaran', $data);
    }

    public function detail($id_pembayaran)
    {
        $pembayaran = $this->pembayaranModel->getPaymentWithDetails($id_pembayaran);
        if (!$pembayaran) {
            session()->setFlashdata('error', 'Data pembayaran tidak ditemukan!');
            return redirect()->to(base_url('home_karyawan/pembayaran'));
        }
        $data = [
            'title' => 'Detail Pembayaran',
            'title2' => 'Detail Pembayaran',
            'payment' => $pembayaran,
            'pendaftaran' => $pembayaran
        ];
        return view('backend/karyawan/staf_admin/pembayaran/v_detail', $data);
    }

    public function konfirmasi($id_pembayaran)
    {
        $pembayaran = $this->pembayaranModel->find($id_pembayaran);
        if (!$pembayaran) {
            session()->setFlashdata('error', 'Data pembayaran tidak ditemukan!');
            return redirect()->to(base_url('home_karyawan/pembayaran'));
        }
        $data = [
            'status_pembayaran' => 'success',
            'tanggal_konfirmasi' => date('Y-m-d H:i:s')
        ];
        $this->pembayaranModel->update($id_pembayaran, $data);
        $this->pendaftaranModel->where('kode_invoice', $pembayaran['kode_invoice'])->update(['status' => 'aktif']);
        session()->setFlashdata('pesan', 'Pembayaran berhasil dikonfirmasi!');
        return redirect()->to(base_url('home_karyawan/pembayaran'));
    }

    public function check_notification_count()
    {
        $id_karyawan = session()->get('id_karyawan');
        if (!$id_karyawan) {
            return $this->response->setJSON(['count' => 0]);
        }
        $count = $this->pembayaranModel->where('status_pembayaran', 'pending')->countAll();
        return $this->response->setJSON(['count' => $count]);
    }

    public function check_payment_updates()
    {
        $id_karyawan = session()->get('id_karyawan');
        if (!$id_karyawan) {
            return $this->response->setJSON(['has_updates' => false]);
        }
        $pending = $this->pembayaranModel->where('status_pembayaran', 'pending')->countAll();
        $lastChecked = session()->get('last_payment_check') ?? 0;
        if ($pending > $lastChecked) {
            session()->set('last_payment_check', $pending);
            return $this->response->setJSON(['has_updates' => true, 'count' => $pending]);
        }
        return $this->response->setJSON(['has_updates' => false]);
    }
}
