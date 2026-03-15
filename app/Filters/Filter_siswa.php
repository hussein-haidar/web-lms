<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class Filter_siswa implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if (session()->get('level') != 'siswa') {
            session()->setFlashdata('pesan', 'Silakan login sebagai siswa untuk mengakses halaman ini!');
            return redirect()->to(base_url('auth_login/login_siswa'));
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Biarkan kosong
    }
}
