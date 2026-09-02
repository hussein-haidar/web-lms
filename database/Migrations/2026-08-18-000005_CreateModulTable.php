<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateModulTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_modul'     => ['type' => 'INT', 'auto_increment' => true],
            'id_kursus'    => ['type' => 'INT'],
            'nama_modul'   => ['type' => 'VARCHAR', 'constraint' => 200],
            'deskripsi'    => ['type' => 'TEXT', 'null' => true],
            'urutan'       => ['type' => 'INT', 'default' => 0],
            'created_at'   => ['type' => 'DATETIME', 'null' => true],
            'updated_at'   => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id_modul', true);
        $this->forge->addForeignKey('id_kursus', 'kursus', 'id_kursus', 'CASCADE');
        $this->forge->createTable('modul');
    }

    public function down()
    {
        $this->forge->dropTable('modul');
    }
}
