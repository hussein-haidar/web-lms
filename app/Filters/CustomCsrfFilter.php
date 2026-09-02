<?php

namespace App\Filters;

use CodeIgniter\Filters\CSRF;

class CustomCsrfFilter extends CSRF
{
    public array $excludedURIs = [
        'home_siswa/pembayaran/midtrans_notification',
    ];
}
