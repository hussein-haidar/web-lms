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

    // ✅ Get pembayaran pending untuk admin
    public function getPendingPayments()
    {
        return $this->db->table($this->table)
            ->select('pembayaran.*, siswa.nama_lengkap, siswa.email, siswa.no_telepon, kursus.nama_kursus')
            ->join('pendaftaran', 'pendaftaran.kode_invoice = pembayaran.kode_invoice')
            ->join('siswa', 'siswa.id_siswa = pendaftaran.id_siswa')
            ->join('kursus', 'kursus.id_kursus = pendaftaran.id_kursus')
            ->where('pembayaran.status_pembayaran', 'pending')
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
}
