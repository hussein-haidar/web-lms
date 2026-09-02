<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePendaftaranTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_pendaftaran'      => ['type' => 'INT', 'auto_increment' => true],
            'id_siswa'            => ['type' => 'INT'],
            'kode_invoice'        => ['type' => 'VARCHAR', 'constraint' => 50],
            'id_kursus'           => ['type' => 'INT'],
            'nama_paket'          => ['type' => 'VARCHAR', 'constraint' => 100],
            'harga_kursus'        => ['type' => 'DECIMAL', 'constraint' => '12,2', 'default' => 0],
            'status'              => ['type' => "ENUM('pending','aktif','selesai','dibatalkan')", 'default' => 'pending'],
            'tanggal_pendaftaran' => ['type' => 'DATETIME', 'null' => true],
            'tanggal_konfirmasi'  => ['type' => 'DATETIME', 'null' => true],
            'tanggal_aktif'       => ['type' => 'DATETIME', 'null' => true],
            'progress'            => ['type' => 'DECIMAL', 'constraint' => '5,2', 'default' => 0],
            'tanggal_selesai'     => ['type' => 'DATETIME', 'null' => true],
            'last_accessed'       => ['type' => 'DATETIME', 'null' => true],
            'nilai_akhir'         => ['type' => 'DECIMAL', 'constraint' => '5,2', 'null' => true],
            'sertifikat_dikirim'  => ['type' => 'TINYINT', 'default' => 0],
            'tanggal_sertifikat'  => ['type' => 'DATETIME', 'null' => true],
            'email'               => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'nama_lengkap'        => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'foto_profil'         => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'tempat_lahir'        => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'tanggal_lahir'       => ['type' => 'DATE', 'null' => true],
            'jenis_kelamin'       => ['type' => "ENUM('Laki - laki','Perempuan')", 'null' => true],
            'agama'               => ['type' => 'VARCHAR', 'constraint' => 20, 'null' => true],
            'no_telepon'          => ['type' => 'VARCHAR', 'constraint' => 15, 'null' => true],
            'alamat'              => ['type' => 'TEXT', 'null' => true],
            'sumber_biaya'        => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
        ]);
        $this->forge->addKey('id_pendaftaran', true);
        $this->forge->addKey('kode_invoice');
        $this->forge->addForeignKey('id_siswa', 'siswa', 'id_siswa', 'CASCADE');
        $this->forge->addForeignKey('id_kursus', 'kursus', 'id_kursus', 'CASCADE');
        $this->forge->createTable('pendaftaran');
    }

    public function down()
    {
        $this->forge->dropTable('pendaftaran');
    }
}
