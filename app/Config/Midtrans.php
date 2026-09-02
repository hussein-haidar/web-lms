<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Midtrans extends BaseConfig
{
    /**
     * Midtrans Server Key diambil dari .env (keamanan).
     */
    public $serverKey = '';

    /**
     * Client Key berasal dari .env.
     */
    public $clientKey = '';

    /**
     * Production mode
     * false = Sandbox (testing)
     * true = Production (live)
     */
    public $isProduction = false;

    /**
     * Sanitize card data
     */
    public $isSanitized = true;

    /**
     * 3D Secure authentication
     */
    public $is3ds = true;

    /**
     * Notification URL (webhook)
     */
    public $notificationUrl = 'home_siswa/pembayaran/midtrans_notification';

    public function __construct()
    {
        parent::__construct();

        $this->serverKey = env('MIDTRANS_SERVER_KEY', '');
        $this->clientKey = env('MIDTRANS_CLIENT_KEY', '');
        $this->isProduction = (bool) env('MIDTRANS_IS_PRODUCTION', false);
        $this->isSanitized = (bool) env('MIDTRANS_IS_SANITIZED', true);
        $this->is3ds = (bool) env('MIDTRANS_IS_3DS', true);
        $this->notificationUrl = env('MIDTRANS_NOTIFICATION_URL', $this->notificationUrl);
    }
}
