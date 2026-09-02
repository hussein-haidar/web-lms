<?php

namespace App\Models;

use CodeIgniter\Model;

class M_pembayaran extends Model
{
    protected $table = 'pembayaran';
    protected $primaryKey = 'id_pembayaran';
    protected $allowedFields = [
        'kode_invoice',
        'kode_transaksi',
        'jumlah_bayar',
        'metode_pembayaran',  // transfer_bank/ewallet/qris/tunai
        'bank_tujuan',
        'no_rekening_pengirim',
        'nama_pengirim',
        'bukti_bayar',
        'status_pembayaran',  // pending/processing/success/failed/refunded
        'tanggal_transaksi',
        'tanggal_konfirmasi',
        'dikonfirmasi_oleh',     // id_karyawan yang konfirmasi
        'alasan_penolakan',
        'refund_amount',
    ];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $returnType = 'array';

    // ✅ Generate kode transaksi unik: TRX-YYYYMMDD-XXXX
    public function generateKodeTransaksi()
    {
        $prefix = 'TRX-' . date('Ymd');
        $last = $this->db->table($this->table)
            ->like('kode_transaksi', $prefix, 'after')
            ->orderBy('kode_transaksi', 'DESC')
            ->get()
            ->getRowArray();

        $number = $last ? (int)substr($last['kode_transaksi'], -4) + 1 : 1;
        return $prefix . '-' . str_pad($number, 4, '0', STR_PAD_LEFT);
    }

    // ✅ Get pembayaran by invoice
    public function getByInvoice($kode_invoice)
    {
        return $this->db->table($this->table)
            ->where('kode_invoice', $kode_invoice)
            ->orderBy('tanggal_transaksi', 'DESC')
            ->get()
            ->getResultArray();
    }

    // ✅ Get pembayaran untuk notifikasi (berdasarkan nama_lengkap - semua user)
    public function get_status_bayar_sesi($nama_lengkap, $status = ['pending'])
    {
        $builder = $this->db->table($this->table)
            ->select('pembayaran.id_pembayaran, pembayaran.kode_transaksi, pembayaran.status_pembayaran, pembayaran.tanggal_transaksi, pembayaran.jumlah_bayar, siswa.nama_lengkap')
            ->join('pendaftaran', 'pendaftaran.kode_invoice = pembayaran.kode_invoice', 'left')
            ->join('siswa', 'siswa.id_siswa = pendaftaran.id_siswa', 'left')
            ->groupBy('pembayaran.id_pembayaran')
            ->where('siswa.nama_lengkap', trim($nama_lengkap));

        if (is_array($status)) {
            $builder->whereIn('pembayaran.status_pembayaran', $status);
        } else {
            $builder->where('pembayaran.status_pembayaran', $status);
        }

        return $builder->orderBy('pembayaran.tanggal_transaksi', 'DESC')->get()->getResultArray();
    }

    // ✅ Get pembayaran dengan detail lengkap
    public function getPaymentWithDetails($id_pembayaran)
    {
        return $this->db->table($this->table)
            ->select('pembayaran.*, siswa.nama_lengkap, siswa.email, kursus.nama_kursus')
            ->join('pendaftaran', 'pendaftaran.kode_invoice = pembayaran.kode_invoice', 'left')
            ->join('siswa', 'siswa.id_siswa = pendaftaran.id_siswa', 'left')
            ->join('kursus', 'kursus.id_kursus = pendaftaran.id_kursus', 'left')
            ->where('pembayaran.id_pembayaran', $id_pembayaran)
            ->get()
            ->getRowArray();
    }

    // ✅ Get pembayaran pending untuk admin
    public function getPendingPayments()
    {
        return $this->db->table($this->table)
            ->select('pembayaran.*, siswa.nama_lengkap, siswa.email, siswa.no_telepon, kursus.nama_kursus')
            ->join('pendaftaran', 'pendaftaran.kode_invoice = pembayaran.kode_invoice', 'left')
            ->join('siswa', 'siswa.id_siswa = pendaftaran.id_siswa', 'left')
            ->join('kursus', 'kursus.id_kursus = pendaftaran.id_kursus', 'left')
            ->where('pembayaran.status_pembayaran', 'pending')
            ->groupBy('pembayaran.id_pembayaran')
            ->orderBy('pembayaran.tanggal_transaksi', 'ASC')
            ->get()
            ->getResultArray();
    }

    // ✅ Get riwayat pembayaran siswa dengan nama_produk
    public function getRiwayatSiswa($id_siswa)
    {
        return $this->db->table($this->table)
            ->select('pembayaran.*, pendaftaran.nama_paket, pendaftaran.harga_kursus, kursus.nama_kursus')
            ->join('pendaftaran', 'pendaftaran.kode_invoice = pembayaran.kode_invoice')
            ->join('kursus', 'kursus.id_kursus = pendaftaran.id_kursus')
            ->where('pendaftaran.id_siswa', $id_siswa)
            ->groupBy('pembayaran.id_pembayaran, pendaftaran.id_pendaftaran')
            ->orderBy('pembayaran.tanggal_transaksi', 'DESC')
            ->get()
            ->getResultArray();
    }

    // ✅ Approve payment
    public function approvePayment($id_pembayaran, $adminId)
    {
        return $this->update($id_pembayaran, [
            'status_pembayaran' => 'success',
            'tanggal_konfirmasi' => date('Y-m-d H:i:s'),
            'dikonfirmasi_oleh' => $adminId
        ]);
    }

    // ✅ Reject payment
    public function rejectPayment($id_pembayaran, $adminId, $alasan)
    {
        return $this->update($id_pembayaran, [
            'status_pembayaran' => 'failed',
            'tanggal_konfirmasi' => date('Y-m-d H:i:s'),
            'dikonfirmasi_oleh' => $adminId,
            'alasan_penolakan' => $alasan
        ]);
    }

    // ✅ CLEANUP DATA EXPIRED (auto delete)
    public function cleanupExpired()
    {
        $db = \Config\Database::connect();
        $dua_jam_lalu = date('Y-m-d H:i:s', strtotime('-2 hours'));

        // Hapus pembayaran pending lebih dari 2 jam
        return $db->table($this->table)
            ->where('status_pembayaran', 'pending')
            ->where('tanggal_transaksi <', $dua_jam_lalu)
            ->delete();
    }

    // ✅ GET ALL PEMBAYARAN
    public function getPembayaranAll()
    {
        return $this->db->table($this->table . ' p')
            ->select('p.*, k.nama_kursus')
                      ->join('pendaftaran pd', 'p.kode_invoice = pd.kode_invoice', 'left')
            ->join('kursus k', 'pd.id_kursus = k.id_kursus', 'left')
            ->orderBy('p.tanggal_transaksi', 'DESC')
            ->get()
            ->getResultArray();
    }

    // ✅ GET NOTIFIKASI PEMBAYARAN
    public function get_notifikasi_pembayaran($id_siswa = null, $limit = 10, $status = null)
    {
        $builder = $this->db->table($this->table . ' p')
            ->select('p.*, s.nama_lengkap, k.nama_kursus')
            ->join('pendaftaran pd', 'p.kode_invoice = pd.kode_invoice', 'left')
            ->join('siswa s', 'pd.id_siswa = s.id_siswa', 'left')
            ->join('kursus k', 'pd.id_kursus = k.id_kursus', 'left')
            ->groupBy('p.id_pembayaran')
            ->orderBy('p.tanggal_transaksi', 'DESC');

        if ($id_siswa) {
            $builder->where('pd.id_siswa', $id_siswa);
        }

        // Default filter: hanya tampilkan pending dan failed
        if ($status === null) {
            $builder->whereIn('p.status_pembayaran', ['pending', 'failed']);
        } elseif ($status) {
            if (is_array($status)) {
                $builder->whereIn('p.status_pembayaran', $status);
            } else {
                $builder->where('p.status_pembayaran', $status);
            }
        }

        return $builder->limit($limit)->get()->getResultArray();
    }
}
