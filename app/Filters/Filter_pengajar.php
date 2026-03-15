<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class Filter_pengajar implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if (session()->get('level') != 'pengajar') {
            session()->setFlashdata('pesan_warning', 'Anda harus login sebagai Pengajar untuk mengakses halaman ini!');
            return redirect()->to(base_url('auth_login/login_karyawan'));
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Biarkan kosong
    }
}
