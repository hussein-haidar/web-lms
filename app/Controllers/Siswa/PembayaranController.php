<?php

namespace App\Controllers\Siswa;

use App\Controllers\BaseController;
use App\Models\M_pembayaran;
use App\Models\M_pendaftaran;

class PembayaranController extends BaseController
{
    protected $M_pembayaran;
    protected $M_pendaftaran;

    public function __construct()
    {
        $this->M_pembayaran = new M_pembayaran();
        $this->M_pendaftaran = new M_pendaftaran();
    }

    /**
     * AJAX: Cek status pembayaran siswa
     * GET /api/siswa/pembayaran/status/{id}
     */
    public function ajax_status($id_pembayaran)
    {
        $id_siswa = session()->get('id_siswa');
        if (!$id_siswa) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Session expired. Silakan login kembali.',
                'redirect' => base_url('auth_login/login_siswa')
            ]);
        }

        $pembayaran = $this->M_pembayaran->find($id_pembayaran);
        if (!$pembayaran) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Data pembayaran tidak ditemukan.',
            ]);
        }

        // Pastikan milik siswa yang sedang login
        $pendaftaran = $this->M_pendaftaran
            ->where('kode_invoice', $pembayaran['kode_invoice'])
            ->where('id_siswa', $id_siswa)
            ->first();

        if (!$pendaftaran) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Akses ditolak.',
            ]);
        }

        $data = [
            'id_pembayaran'     => $pembayaran['id_pembayaran'],
            'kode_invoice'      => $pembayaran['kode_invoice'],
            'kode_transaksi'    => $pembayaran['kode_transaksi'],
            'status_pembayaran' => $pembayaran['status_pembayaran'],
            'jumlah_bayar'      => $pembayaran['jumlah_bayar'],
            'tanggal_transaksi' => $pembayaran['tanggal_transaksi'],
            'tanggal_konfirmasi' => $pembayaran['tanggal_konfirmasi'] ?? null,
            'alasan_penolakan'  => $pembayaran['alasan_penolakan'] ?? null,
            'metode_pembayaran' => $pembayaran['metode_pembayaran'] ?? null,
            'bank_tujuan'       => $pembayaran['bank_tujuan'] ?? null,
            'nama_pengirim'     => $pembayaran['nama_pengirim'] ?? null,
            'bukti_bayar'       => $pembayaran['bukti_bayar'] ?? null,
        ];

        return $this->response->setJSON([
            'status' => 'success',
            'data'   => $data,
        ]);
    }

    /**
     * AJAX: Cek semua status pembayaran siswa (batch check)
     * GET /api/siswa/pembayaran/status-check
     */
    public function ajax_status_check()
    {
        $id_siswa = session()->get('id_siswa');
        if (!$id_siswa) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Session expired.',
            ]);
        }

        $pembayaran = $this->M_pembayaran
            ->select('pembayaran.id_pembayaran, pembayaran.kode_invoice, pembayaran.status_pembayaran, pembayaran.tanggal_konfirmasi, pembayaran.alasan_penolakan')
            ->join('pendaftaran', 'pendaftaran.kode_invoice = pembayaran.kode_invoice', 'left')
            ->where('pendaftaran.id_siswa', $id_siswa)
            ->whereIn('pembayaran.status_pembayaran', ['pending', 'processing'])
            ->groupBy('pembayaran.id_pembayaran')
            ->orderBy('pembayaran.tanggal_transaksi', 'DESC')
            ->findAll();

        return $this->response->setJSON([
            'status' => 'success',
            'data'   => $pembayaran,
            'count'  => count($pembayaran),
        ]);
    }

    /**
     * Buat pembayaran Midtrans Snap
     * POST /api/siswa/pembayaran/snap
     */
    public function create_snap()
    {
        $id_siswa = session()->get('id_siswa');
        if (!$id_siswa) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Session expired']);
        }

        $id_pembayaran = $this->request->getPost('id_pembayaran');
        $pembayaran = $this->M_pembayaran->find($id_pembayaran);
        if (!$pembayaran) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Pembayaran tidak ditemukan']);
        }

        $pendaftaran = $this->M_pendaftaran
            ->select('pendaftaran.*, kursus.nama_kursus')
            ->join('kursus', 'kursus.id_kursus = pendaftaran.id_kursus', 'left')
            ->where('kode_invoice', $pembayaran['kode_invoice'])
            ->where('id_siswa', $id_siswa)
            ->first();

        if (!$pendaftaran) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Akses ditolak']);
        }

        $payment = new \App\Libraries\PaymentGateway();

        $customer_details = [
            'first_name' => $pendaftaran['nama_lengkap'] ?? $pendaftaran['nama_siswa'] ?? 'Siswa',
            'email' => $pendaftaran['email'] ?? '',
            'phone' => $pendaftaran['no_telepon'] ?? '',
        ];

        $item_details = [[
            'id'    => $pendaftaran['id_kursus'],
            'name'  => $pendaftaran['nama_kursus'] ?? 'Kursus',
            'price' => (int) $pembayaran['jumlah_bayar'],
            'quantity' => 1,
        ]];

        $result = $payment->createTransaction(
            $pembayaran['kode_transaksi'],
            (int) $pembayaran['jumlah_bayar'],
            $customer_details,
            $item_details
        );

        return $this->response->setJSON($result);
    }

    /**
     * Midtrans notification webhook (tanpa session)
     * POST /home_siswa/pembayaran/midtrans_notification
     */
    public function midtrans_notification()
    {
        $payment = new \App\Libraries\PaymentGateway();
        $result = $payment->handleNotification();

        if ($result['status'] == 'error') {
            log_message('error', 'Midtrans notification error: ' . $result['message']);
            return $this->response->setStatusCode(400)->setJSON($result);
        }

        $orderId = $result['order_id'];
        $transactionStatus = $result['transaction_status'];
        $fraudStatus = $result['fraud_status'] ?? '';

        // Map status
        $status_pembayaran = $payment->mapStatus($transactionStatus, $fraudStatus);

        // Update pembayaran
        $pembayaran = $this->M_pembayaran
            ->where('kode_transaksi', $orderId)
            ->first();

        if ($pembayaran) {
            $updateData = [
                'status_pembayaran' => $status_pembayaran,
            ];

            if ($status_pembayaran == 'success') {
                $updateData['tanggal_konfirmasi'] = date('Y-m-d H:i:s');
                // Update pendaftaran status
                $this->M_pendaftaran
                    ->where('kode_invoice', $pembayaran['kode_invoice'])
                    ->update(['status' => 'aktif']);
            } elseif (in_array($status_pembayaran, ['failed', 'expired'])) {
                $updateData['alasan_penolakan'] = 'Pembayaran ' . $transactionStatus . ' via Midtrans';
            }

            $this->M_pembayaran->update($pembayaran['id_pembayaran'], $updateData);

            log_message('info', "Midtrans notification: Order {$orderId} status -> {$status_pembayaran}");
        }

        return $this->response->setJSON(['status' => 'ok']);
    }
}