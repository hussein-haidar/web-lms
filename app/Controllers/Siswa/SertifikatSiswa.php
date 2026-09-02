<?php

namespace App\Controllers\Siswa;

use App\Controllers\BaseController;
use App\Models\M_sertifikat;
use App\Models\M_pendaftaran;
use App\Models\M_siswa;

class SertifikatSiswa extends BaseController
{
    protected $M_sertifikat;
    protected $M_pendaftaran;
    protected $M_siswa;

    public function __construct()
    {
        $this->M_sertifikat = new M_sertifikat();
        $this->M_pendaftaran = new M_pendaftaran();
        $this->M_siswa = new M_siswa();
    }

    public function index()
    {
        $id_siswa = session()->get('id_siswa');
        if (!$id_siswa) {
            return redirect()->to(base_url('auth_login/login_siswa'));
        }

        $sertifikat = $this->M_sertifikat->getBySiswa($id_siswa);
        $pending_courses = $this->getPendingCourses($id_siswa);

        $data = [
            'title' => 'Sertifikat Saya',
            'title2' => 'Sertifikat Saya',
            'sertifikat' => $sertifikat,
            'pending_courses' => $pending_courses,
            'siswa' => $this->M_siswa->get_profil($id_siswa)
        ];

        return view('backend/siswa/sertifikat/v_index', $data);
    }

    public function claim($id_pendaftaran)
    {
        $id_siswa = session()->get('id_siswa');
        if (!$id_siswa) {
            return redirect()->to(base_url('auth_login/login_siswa'));
        }

        $pendaftaran = $this->M_pendaftaran->detailDaftar($id_pendaftaran);
        if (!$pendaftaran || $pendaftaran['id_siswa'] != $id_siswa) {
            session()->setFlashdata('error', 'Pendaftaran tidak ditemukan!');
            return redirect()->back();
        }

        $existing = $this->M_sertifikat->where('id_pendaftaran', $id_pendaftaran)->first();
        if ($existing) {
            session()->setFlashdata('warning', 'Sertifikat sudah diterbitkan sebelumnya!');
            return redirect()->back();
        }

        if ($pendaftaran['progress'] < 100) {
            session()->setFlashdata('error', 'Anda harus menyelesaikan kursus terlebih dahulu! Progress: ' . $pendaftaran['progress'] . '%');
            return redirect()->back();
        }

        $sertifikat = $this->M_sertifikat->createFromPendaftaran($id_pendaftaran);

        if ($sertifikat) {
            $files = $this->generatePDFCertificate($sertifikat);

            $this->M_sertifikat->update($sertifikat['id_sertifikat'], [
                'file_pdf'   => $files['file_pdf'],
                'file_thumb' => $files['file_thumb'],
                'qr_code' => $this->generateQRCode($sertifikat),
                'verification_url' => base_url('sertifikat/verify/' . $sertifikat['nomor_sertifikat'])
            ]);

            $siswa_model = new M_siswa();
            $siswa = $siswa_model->find($id_siswa);
            if ($siswa) {
                email_sertifikat_siap($siswa, $sertifikat);
            }

            session()->setFlashdata('pesan', 'Sertifikat berhasil diklaim! Anda dapat mengunduh sertifikat Anda.');
        } else {
            session()->setFlashdata('error', 'Gagal membuat sertifikat!');
        }

        return redirect()->to(base_url('siswa/sertifikat'));
    }

    public function download($id_sertifikat)
    {
        $id_siswa = session()->get('id_siswa');
        if (!$id_siswa) {
            return redirect()->to(base_url('auth_login/login_siswa'));
        }

        $sertifikat = $this->M_sertifikat
            ->where('id_sertifikat', $id_sertifikat)
            ->where('id_siswa', $id_siswa)
            ->first();

        if (!$sertifikat || empty($sertifikat['file_pdf'])) {
            session()->setFlashdata('error', 'Sertifikat tidak ditemukan!');
            return redirect()->back();
        }

        $file_path = \App\Libraries\CertificatePdf::pdfAbsolutePath((string) $sertifikat['file_pdf']);
        if (is_file($file_path)) {
            return $this->response->download($file_path, null);
        } else {
            session()->setFlashdata('error', 'File sertifikat tidak ditemukan!');
            return redirect()->back();
        }
    }

    public function print($id_sertifikat)
    {
        $sertifikat = $this->M_sertifikat->find($id_sertifikat);

        if (!$sertifikat || $sertifikat['is_active'] != 1) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Sertifikat tidak ditemukan');
        }

        $data = [
            'title' => 'Cetak Sertifikat',
            'title2' => 'Cetak Sertifikat',
            'sertifikat' => $sertifikat
        ];

        return view('public/sertifikat/v_print', $data);
    }

    private function getPendingCourses($id_siswa)
    {
        return $this->M_pendaftaran
            ->select('p.*, k.nama_kursus, k.slug')
            ->join('kursus k', 'k.id_kursus = p.id_kursus')
            ->where('p.id_siswa', $id_siswa)
            ->where('p.progress >=', 100)
            ->where('p.sertifikat_dikirim', 0)
            ->whereIn('p.status', ['aktif', 'selesai'])
            ->orderBy('p.tanggal_selesai', 'DESC')
            ->get()
            ->getResultArray();
    }

    private function generatePDFCertificate($sertifikat)
    {
        return \App\Libraries\CertificatePdf::generate($sertifikat);
    }

    private function generateQRCode($sertifikat)
    {
        try {
            $verify_url = base_url('sertifikat/verify/' . $sertifikat['nomor_sertifikat']);

            if (class_exists('\Endroid\QrCode\QrCode')) {
                $qrCode = new \Endroid\QrCode\QrCode($verify_url);
                $writer = new \Endroid\QrCode\Writer\PngWriter();
                $qrResult = $writer->write($qrCode);
                $qrImage = $qrResult->getString();

                $qr_filename = 'qr_' . str_replace(['/', '-'], '_', $sertifikat['nomor_sertifikat']) . '.png';
                $qr_dir = WRITEPATH . 'certificates/qr_codes';
                if (!is_dir($qr_dir)) {
                    mkdir($qr_dir, 0755, true);
                }
                file_put_contents($qr_dir . '/' . $qr_filename, $qrImage);
                return 'certificates/qr_codes/' . $qr_filename;
            }

            $qr_filename = 'qr_' . str_replace(['/', '-'], '_', $sertifikat['nomor_sertifikat']) . '.svg';
            $qr_dir = WRITEPATH . 'certificates/qr_codes';
            if (!is_dir($qr_dir)) {
                mkdir($qr_dir, 0755, true);
            }
            $qr_svg = \App\Libraries\QRCodeGenerator::generateSVG($verify_url, 200);
            file_put_contents($qr_dir . '/' . $qr_filename, $qr_svg);
            return 'certificates/qr_codes/' . $qr_filename;

        } catch (\Exception $e) {
            return base_url('sertifikat/verify/' . $sertifikat['nomor_sertifikat']);
        }
    }
}
