<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePengumpulanTugasTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_kumpul'        => ['type' => 'INT', 'auto_increment' => true],
            'id_tugas'         => ['type' => 'INT'],
            'id_siswa'         => ['type' => 'INT'],
            'file_tugas'       => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'catatan_siswa'    => ['type' => 'TEXT', 'null' => true],
            'nilai'            => ['type' => 'DECIMAL', 'constraint' => '5,2', 'null' => true],
            'feedback'         => ['type' => 'TEXT', 'null' => true],
            'status_penilaian' => ['type' => "ENUM('menunggu','dinilai')", 'default' => 'menunggu'],
            'tanggal_kirim'    => ['type' => 'DATETIME', 'null' => true],
            'id_pemilik'       => ['type' => 'INT', 'null' => true],
            'created_at'       => ['type' => 'DATETIME', 'null' => true],
            'updated_at'       => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id_kumpul', true);
        $this->forge->addForeignKey('id_tugas', 'tugas', 'id_tugas', 'CASCADE');
        $this->forge->addForeignKey('id_siswa', 'siswa', 'id_siswa', 'CASCADE');
        $this->forge->createTable('pengumpulan_tugas');
    }

    public function down()
    {
        $this->forge->dropTable('pengumpulan_tugas');
    }
}
