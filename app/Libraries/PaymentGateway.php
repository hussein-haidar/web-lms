<?php

namespace App\Libraries;

use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Transaction;
use Midtrans\Notification;

class PaymentGateway
{
    protected $snap;
    protected $config;

    public function __construct()
    {
        $this->config = config('Midtrans');
        
        Config::$serverKey = $this->config->serverKey;
        Config::$isProduction = $this->config->isProduction;
        Config::$isSanitized = $this->config->isSanitized;
        Config::$is3dsEnabled = $this->config->is3ds;

        $this->snap = new Snap();
    }

    /**
     * Buat Snap Token untuk pembayaran
     */
    public function createTransaction($order_id, $gross_amount, $customer_details, $item_details)
    {
        $params = [
            'transaction_details' => [
                'order_id'     => $order_id,
                'gross_amount' => $gross_amount,
            ],
            'customer_details' => $customer_details,
            'item_details'     => $item_details,
            'callbacks'        => [
                'finish' => base_url('home_siswa/status_bayar'),
            ],
        ];

        try {
            $snapResult = $this->snap->createTransaction($params);
            return [
                'status'     => 'success',
                'snap_token' => $snapResult->token,
                'redirect_url' => $snapResult->redirect_url,
            ];
        } catch (\Exception $e) {
            log_message('error', 'Midtrans Snap Error: ' . $e->getMessage());
            return [
                'status'  => 'error',
                'message' => $e->getMessage(),
            ];
        }
    }

    /**
     * Cek status transaksi Midtrans
     */
    public function getTransactionStatus($order_id)
    {
        try {
            $status = \Midtrans\Transaction::status($order_id);
            return [
                'status'        => 'success',
                'payment_type'  => $status->payment_type ?? '',
                'transaction_status' => $status->transaction_status ?? '',
                'fraud_status'  => $status->fraud_status ?? '',
                'va_number'     => $status->va_number ?? '',
                'bank'          => $status->bank ?? '',
                'gross_amount'  => $status->gross_amount ?? 0,
            ];
        } catch (\Exception $e) {
            log_message('error', 'Midtrans Status Error: ' . $e->getMessage());
            return [
                'status'  => 'error',
                'message' => $e->getMessage(),
            ];
        }
    }

    /**
     * Handle Midtrans notification (webhook)
     */
    public function handleNotification()
    {
        try {
            $notification = new Notification();
            
            $orderId = $notification->order_id;
            $statusCode = $notification->status_code;
            $transactionStatus = $notification->transaction_status;
            $fraudStatus = $notification->fraud_status;
            $grossAmount = $notification->gross_amount;

            // Verifikasi signature
            $serverKey = $this->config->serverKey;
            $input = $orderId . $statusCode . $grossAmount . $serverKey;
            $signature = hash('sha512', $input);

            if ($signature !== $notification->signature_key) {
                log_message('error', 'Midtrans signature mismatch for order: ' . $orderId);
                return [
                    'status' => 'error',
                    'message' => 'Invalid signature'
                ];
            }

            return [
                'status' => 'success',
                'order_id' => $orderId,
                'transaction_status' => $transactionStatus,
                'fraud_status' => $fraudStatus,
                'status_code' => $statusCode,
                'gross_amount' => $grossAmount,
                'payment_type' => $notification->payment_type ?? '',
            ];
        } catch (\Exception $e) {
            log_message('error', 'Midtrans Notification Error: ' . $e->getMessage());
            return [
                'status' => 'error',
                'message' => $e->getMessage()
            ];
        }
    }

    /**
     * Map status Midtrans ke status internal
     */
    public function mapStatus($midtransStatus, $fraudStatus = '')
    {
        $statusMap = [
            'capture'           => ($fraudStatus == 'challenge') ? 'processing' : 'success',
            'settlement'        => 'success',
            'pending'           => 'pending',
            'deny'              => 'failed',
            'cancel'            => 'failed',
            'expire'            => 'failed',
            'refund'            => 'refunded',
            'partial_refund'    => 'refunded',
        ];

        return $statusMap[$midtransStatus] ?? 'pending';
    }
}
