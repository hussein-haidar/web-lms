<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class Filter_staf implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $allowed_levels = ['staf_admin', 'pengajar'];
        if (!in_array(session()->get('level'), $allowed_levels)) {
            session()->setFlashdata('pesan_warning', 'Anda harus login sebagai Staf Admin atau Pengajar untuk mengakses halaman ini!');
            return redirect()->to(base_url('auth_login/login_karyawan'));
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Biarkan kosong
    }
}
