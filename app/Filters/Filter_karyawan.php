<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class Filter_karyawan implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $level = session()->get('level');
        $allowed = ['staf_admin', 'pengajar', 'teknisi'];

        if (!in_array($level, $allowed)) {
            session()->setFlashdata('pesan_warning', 'Anda harus login sebagai Karyawan untuk mengakses halaman ini!');
            return redirect()->to(base_url('auth_login/login_karyawan'));
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Biarkan kosong
    }
}
