<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateMateriTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_materi'         => ['type' => 'INT', 'auto_increment' => true],
            'id_modul'          => ['type' => 'INT'],
            'id_kursus'         => ['type' => 'INT', 'null' => true],
            'judul_materi'      => ['type' => 'VARCHAR', 'constraint' => 200],
            'deskripsi_materi'  => ['type' => 'TEXT', 'null' => true],
            'tipe_materi'       => ['type' => "ENUM('video','dokumen','teks','link')", 'default' => 'teks'],
            'konten_materi'     => ['type' => 'LONGTEXT', 'null' => true],
            'file_materi'       => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'url_video'         => ['type' => 'VARCHAR', 'constraint' => 500, 'null' => true],
            'durasi'            => ['type' => 'INT', 'null' => true],
            'urutan'            => ['type' => 'INT', 'default' => 0],
            'created_at'        => ['type' => 'DATETIME', 'null' => true],
            'updated_at'        => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id_materi', true);
        $this->forge->addForeignKey('id_modul', 'modul', 'id_modul', 'CASCADE');
        $this->forge->createTable('materi');
    }

    public function down()
    {
        $this->forge->dropTable('materi');
    }
}
