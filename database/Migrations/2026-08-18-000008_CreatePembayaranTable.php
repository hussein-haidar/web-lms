<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePembayaranTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_pembayaran'      => ['type' => 'INT', 'auto_increment' => true],
            'kode_invoice'       => ['type' => 'VARCHAR', 'constraint' => 50],
            'kode_transaksi'     => ['type' => 'VARCHAR', 'constraint' => 50],
            'jumlah_bayar'       => ['type' => 'DECIMAL', 'constraint' => '12,2'],
            'metode_pembayaran'  => ['type' => "ENUM('transfer_bank','ewallet','qris','tunai','payment_gateway')", 'default' => 'transfer_bank'],
            'bank_tujuan'        => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'no_rekening_pengirim' => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'nama_pengirim'      => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'bukti_bayar'        => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'status_pembayaran'  => ['type' => "ENUM('pending','processing','success','failed','refunded')", 'default' => 'pending'],
            'tanggal_transaksi'  => ['type' => 'DATETIME', 'null' => true],
            'tanggal_konfirmasi' => ['type' => 'DATETIME', 'null' => true],
            'dikonfirmasi_oleh'  => ['type' => 'INT', 'null' => true],
            'alasan_penolakan'   => ['type' => 'TEXT', 'null' => true],
            'refund_amount'      => ['type' => 'DECIMAL', 'constraint' => '12,2', 'null' => true],
            'gateway_ref'        => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'gateway_status'     => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'created_at'         => ['type' => 'DATETIME', 'null' => true],
            'updated_at'         => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id_pembayaran', true);
        $this->forge->addKey('kode_invoice');
        $this->forge->addKey('kode_transaksi');
        $this->forge->createTable('pembayaran');
    }

    public function down()
    {
        $this->forge->dropTable('pembayaran');
    }
}
