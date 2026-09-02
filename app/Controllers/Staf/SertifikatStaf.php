<?php

namespace App\Controllers\Staf;

use App\Controllers\BaseController;
use App\Models\M_sertifikat;
use App\Models\M_pendaftaran;
use App\Models\M_siswa;

class SertifikatStaf extends BaseController
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
        if (!session()->get('id_karyawan')) {
            return redirect()->to(base_url('auth_login/login_karyawan'));
        }

        $pending = $this->M_sertifikat->getPendingSertifikat();
        $issued = $this->M_sertifikat->orderBy('tanggal_terbit', 'DESC')->findAll();

        $data = [
            'title' => 'Manajemen Sertifikat',
            'title2' => 'Manajemen Sertifikat',
            'pending' => $pending,
            'issued' => $issued
        ];

        return view('backend/karyawan/staf_admin/sertifikat/v_index', $data);
    }

    public function create($id_pendaftaran)
    {
        if (!session()->get('id_karyawan')) {
            return redirect()->to(base_url('auth_login/login_karyawan'));
        }

        $existing = $this->M_sertifikat->where('id_pendaftaran', $id_pendaftaran)->first();
        if ($existing) {
            session()->setFlashdata('warning', 'Sertifikat sudah diterbitkan!');
            return redirect()->back();
        }

        $sertifikat = $this->M_sertifikat->createFromPendaftaran($id_pendaftaran);

        if ($sertifikat) {
            session()->setFlashdata('pesan', 'Sertifikat berhasil dibuat untuk ' . $sertifikat['nama_peserta'] . ' dengan predikat ' . $sertifikat['predikat']);

            $files = $this->generatePDFCertificate($sertifikat);

            $this->M_sertifikat->update($sertifikat['id_sertifikat'], [
                'file_pdf'   => $files['file_pdf'],
                'file_thumb' => $files['file_thumb'],
                'qr_code' => $this->generateQRCode($sertifikat),
                'verification_url' => base_url('sertifikat/verify/' . $sertifikat['nomor_sertifikat'])
            ]);

            $siswa_model = new M_siswa();
            $siswa = $siswa_model->find($sertifikat['id_siswa']);
            if ($siswa) {
                email_sertifikat_siap($siswa, $sertifikat);
            }
        } else {
            session()->setFlashdata('error', 'Gagal membuat sertifikat! Pastikan siswa sudah menyelesaikan kursus dengan nilai yang valid (bukan 0).');
        }

        return redirect()->to(base_url('sertifikat/admin'));
    }

    public function bulk_create()
    {
        if (!session()->get('id_karyawan')) {
            return redirect()->to(base_url('auth_login/login_karyawan'));
        }

        $pendaftaran_ids = $this->request->getPost('pendaftaran_ids');
        $success_count = 0;
        $error_count = 0;

        if (!empty($pendaftaran_ids)) {
            foreach ($pendaftaran_ids as $id_pendaftaran) {
                $sertifikat = $this->M_sertifikat->createFromPendaftaran($id_pendaftaran);

                if ($sertifikat) {
                    $files = $this->generatePDFCertificate($sertifikat);
                    $this->M_sertifikat->update($sertifikat['id_sertifikat'], [
                        'file_pdf'   => $files['file_pdf'],
                        'file_thumb' => $files['file_thumb'],
                        'qr_code' => $this->generateQRCode($sertifikat),
                        'verification_url' => base_url('sertifikat/verify/' . $sertifikat['nomor_sertifikat'])
                    ]);
                    $success_count++;
                } else {
                    $error_count++;
                }
            }

            session()->setFlashdata('pesan', "Berhasil menerbitkan $success_count sertifikat. Gagal: $error_count");
        }

        return redirect()->to(base_url('sertifikat/admin'));
    }

    public function delete($id_sertifikat)
    {
        if (!session()->get('id_karyawan')) {
            return redirect()->to(base_url('auth_login/login_karyawan'));
        }

        $sertifikat = $this->M_sertifikat->find($id_sertifikat);
        if ($sertifikat) {
            foreach (['file_pdf', 'file_thumb'] as $field) {
                if (!empty($sertifikat[$field])) {
                    $file_path = \App\Libraries\CertificatePdf::pdfAbsolutePath($sertifikat[$field]);
                    if (is_file($file_path)) {
                        unlink($file_path);
                    }
                }
            }

            if (!empty($sertifikat['nomor_sertifikat'])) {
                $qr_file = \App\Libraries\CertificatePdf::qrDir() . '/' . \App\Libraries\CertificatePdf::qrFileName($sertifikat['nomor_sertifikat']);
                if (is_file($qr_file)) {
                    unlink($qr_file);
                }
            }

            $this->M_sertifikat->delete($id_sertifikat);

            $this->M_pendaftaran->update($sertifikat['id_pendaftaran'], [
                'sertifikat_dikirim' => 0,
                'tanggal_sertifikat' => null
            ]);

            session()->setFlashdata('pesan', 'Sertifikat berhasil dihapus!');
        }

        return redirect()->to(base_url('sertifikat/admin'));
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
