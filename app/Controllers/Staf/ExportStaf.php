<?php

namespace App\Controllers\Staf;

use App\Controllers\BaseController;
use App\Models\M_pembayaran;
use App\Models\M_quiz_hasil;
use App\Models\M_pendaftaran;
use App\Models\M_siswa;

class ExportStaf extends BaseController
{
    protected $M_pembayaran;
    protected $M_quiz_hasil;
    protected $M_pendaftaran;
    protected $M_siswa;

    public function __construct()
    {
        $this->M_pembayaran = new M_pembayaran();
        $this->M_quiz_hasil = new M_quiz_hasil();
        $this->M_pendaftaran = new M_pendaftaran();
        $this->M_siswa = new M_siswa();
    }

    public function pembayaran()
    {
        $format = $this->request->getGet('format') ?? 'csv';
        $pembayaran = $this->M_pembayaran->getPembayaranAll();

        if ($format == 'excel') {
            export_to_excel($pembayaran, 'laporan_pembayaran_' . date('Y-m-d'),
                ['No', 'Invoice', 'Transaksi', 'Siswa', 'Kursus', 'Jumlah', 'Status', 'Tanggal'],
                'Laporan Pembayaran - ' . date('d/m/Y'));
        } else {
            export_pembayaran_csv($pembayaran);
        }
    }

    public function nilai()
    {
        $format = $this->request->getGet('format') ?? 'csv';
        $db = \Config\Database::connect();

        $nilai = $db->table('quiz_hasil qh')
            ->select('qh.*, s.nama_lengkap, k.nama_kursus, q.judul_quiz')
            ->join('siswa s', 's.id_siswa = qh.id_siswa', 'left')
            ->join('quiz q', 'q.id_quiz = qh.id_quiz', 'left')
            ->join('kursus k', 'k.id_kursus = q.id_kursus', 'left')
            ->orderBy('qh.created_at', 'DESC')
            ->get()
            ->getResultArray();

        if ($format == 'excel') {
            export_to_excel($nilai, 'laporan_nilai_' . date('Y-m-d'),
                ['No', 'Siswa', 'Kursus', 'Quiz', 'Nilai', 'Benar', 'Salah', 'Status', 'Tanggal'],
                'Laporan Nilai - ' . date('d/m/Y'));
        } else {
            export_nilai_csv($nilai);
        }
    }

    public function peserta()
    {
        $format = $this->request->getGet('format') ?? 'csv';
        $peserta = $this->M_pendaftaran->getPendaftaranWithSiswa();

        if ($format == 'excel') {
            export_to_excel($peserta, 'laporan_peserta_' . date('Y-m-d'),
                ['No', 'Nama', 'Email', 'Telepon', 'Kursus', 'Paket', 'Status', 'Progress', 'Tanggal Daftar'],
                'Laporan Peserta - ' . date('d/m/Y'));
        } else {
            export_peserta_csv($peserta);
        }
    }
}
