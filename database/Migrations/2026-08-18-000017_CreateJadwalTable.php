<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateJadwalTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_jadwal'      => ['type' => 'INT', 'auto_increment' => true],
            'id_kursus'      => ['type' => 'INT', 'null' => true],
            'id_karyawan'    => ['type' => 'INT', 'null' => true],
            'judul'          => ['type' => 'VARCHAR', 'constraint' => 200],
            'deskripsi'      => ['type' => 'TEXT', 'null' => true],
            'tanggal_mulai'  => ['type' => 'DATETIME'],
            'tanggal_selesai' => ['type' => 'DATETIME'],
            'tipe'           => ['type' => "ENUM('kelas','ujian','tugas','acara')", 'default' => 'kelas'],
            'warna'          => ['type' => 'VARCHAR', 'constraint' => 7, 'default' => '#3c8dbc'],
            'is_recurring'   => ['type' => 'TINYINT', 'default' => 0],
            'recurrence'     => ['type' => "ENUM('none','daily','weekly','monthly')", 'default' => 'none'],
            'status'         => ['type' => "ENUM('aktif','batal','selesai')", 'default' => 'aktif'],
            'created_at'     => ['type' => 'DATETIME', 'null' => true],
            'updated_at'     => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id_jadwal', true);
        $this->forge->addKey(['tanggal_mulai', 'tanggal_selesai']);
        $this->forge->createTable('jadwal');
    }

    public function down()
    {
        $this->forge->dropTable('jadwal');
    }
}
