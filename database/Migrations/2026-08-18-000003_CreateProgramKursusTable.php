<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateProgramKursusTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_program'     => ['type' => 'INT', 'auto_increment' => true],
            'nama_program'   => ['type' => 'VARCHAR', 'constraint' => 100],
            'deskripsi'      => ['type' => 'TEXT', 'null' => true],
            'gambar'         => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'status'         => ['type' => "ENUM('aktif','nonaktif')", 'default' => 'aktif'],
            'urutan'         => ['type' => 'INT', 'default' => 0],
        ]);
        $this->forge->addKey('id_program', true);
        $this->forge->createTable('program_kursus');
    }

    public function down()
    {
        $this->forge->dropTable('program_kursus');
    }
}
