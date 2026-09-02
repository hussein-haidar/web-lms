<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTugasTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_tugas'        => ['type' => 'INT', 'auto_increment' => true],
            'id_kursus'       => ['type' => 'INT'],
            'judul_tugas'     => ['type' => 'VARCHAR', 'constraint' => 200],
            'deskripsi_tugas' => ['type' => 'TEXT', 'null' => true],
            'file_tugas'      => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'batas_waktu'     => ['type' => 'DATETIME', 'null' => true],
            'tanggal_dibuat'  => ['type' => 'DATETIME', 'null' => true],
            'created_at'      => ['type' => 'DATETIME', 'null' => true],
            'updated_at'      => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id_tugas', true);
        $this->forge->addForeignKey('id_kursus', 'kursus', 'id_kursus', 'CASCADE');
        $this->forge->createTable('tugas');
    }

    public function down()
    {
        $this->forge->dropTable('tugas');
    }
}
