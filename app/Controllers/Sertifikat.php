<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\M_sertifikat;

class Sertifikat extends BaseController
{
    protected $M_sertifikat;

    public function __construct()
    {
        $this->M_sertifikat = new M_sertifikat();
    }

    public function view($id_sertifikat)
    {
        $sertifikat = $this->M_sertifikat->find($id_sertifikat);

        if (!$sertifikat || $sertifikat['is_active'] != 1) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Sertifikat tidak ditemukan');
        }

        $data = [
            'title' => 'Verifikasi Sertifikat',
            'title2' => 'Verifikasi Sertifikat',
            'sertifikat' => $sertifikat
        ];

        return view('public/sertifikat/v_view', $data);
    }

    public function verify($kode = null)
    {
        if ($kode === null) {
            $kode = $this->request->getPost('kode');
        }

        if (!$kode) {
            session()->setFlashdata('error', 'Silakan masukkan nomor sertifikat!');
            return redirect()->to(base_url('sertifikat/verify'));
        }

        $sertifikat = $this->M_sertifikat->verifyCertificate($kode);

        if (!$sertifikat) {
            session()->setFlashdata('error', 'Sertifikat tidak valid atau tidak ditemukan!');
            return redirect()->to(base_url('sertifikat/verify'));
        }

        $data = [
            'title' => 'Verifikasi Sertifikat',
            'title2' => 'Verifikasi Sertifikat',
            'sertifikat' => $sertifikat,
            'is_valid' => true
        ];

        return view('public/sertifikat/v_verify', $data);
    }

    public function verify_form()
    {
        $data = [
            'title' => 'Verifikasi Sertifikat',
            'title2' => 'Verifikasi Sertifikat'
        ];

        return view('public/sertifikat/v_verify_form', $data);
    }
}
