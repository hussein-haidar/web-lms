<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateKursusTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_kursus'        => ['type' => 'INT', 'auto_increment' => true],
            'id_karyawan'      => ['type' => 'INT', 'null' => true],
            'id_program'       => ['type' => 'INT', 'null' => true],
            'nama_kursus'      => ['type' => 'VARCHAR', 'constraint' => 200],
            'slug'             => ['type' => 'VARCHAR', 'constraint' => 255, 'unique' => true],
            'deskripsi_singkat' => ['type' => 'TEXT', 'null' => true],
            'deskripsi_kursus' => ['type' => 'LONGTEXT', 'null' => true],
            'gambar_utama'     => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'jenis_kursus'     => ['type' => "ENUM('online','offline')", 'default' => 'online'],
            'harga_default'    => ['type' => 'DECIMAL', 'constraint' => '12,2', 'default' => 0],
            'status'           => ['type' => "ENUM('draft','aktif','nonaktif')", 'default' => 'draft'],
            'created_at'       => ['type' => 'DATETIME', 'null' => true],
            'updated_at'       => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id_kursus', true);
        $this->forge->addForeignKey('id_karyawan', 'karyawan', 'id_karyawan', 'SET NULL');
        $this->forge->addForeignKey('id_program', 'program_kursus', 'id_program', 'SET NULL');
        $this->forge->createTable('kursus');
    }

    public function down()
    {
        $this->forge->dropTable('kursus');
    }
}
