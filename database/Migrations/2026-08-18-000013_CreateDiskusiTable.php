<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateDiskusiTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_diskusi'       => ['type' => 'INT', 'auto_increment' => true],
            'id_kursus'        => ['type' => 'INT'],
            'id_modul'         => ['type' => 'INT', 'null' => true],
            'id_pendaftaran'   => ['type' => 'INT', 'null' => true],
            'id_user'          => ['type' => 'INT'],
            'user_role'        => ['type' => "ENUM('siswa','mentor','admin')", 'default' => 'siswa'],
            'user_name'        => ['type' => 'VARCHAR', 'constraint' => 100],
            'user_avatar'      => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'judul'            => ['type' => 'VARCHAR', 'constraint' => 200],
            'slug'             => ['type' => 'VARCHAR', 'constraint' => 255, 'unique' => true],
            'konten'           => ['type' => 'LONGTEXT'],
            'kategori'         => ['type' => "ENUM('pertanyaan','diskusi','pengumuman')", 'default' => 'diskusi'],
            'tags'             => ['type' => 'VARCHAR', 'constraint' => 500, 'null' => true],
            'komentar_json'    => ['type' => 'LONGTEXT'],
            'total_views'      => ['type' => 'INT', 'default' => 0],
            'total_comments'   => ['type' => 'INT', 'default' => 0],
            'total_likes'      => ['type' => 'INT', 'default' => 0],
            'is_pinned'        => ['type' => 'TINYINT', 'default' => 0],
            'is_locked'        => ['type' => 'TINYINT', 'default' => 0],
            'status'           => ['type' => "ENUM('open','answered','closed')", 'default' => 'open'],
            'created_at'       => ['type' => 'DATETIME', 'null' => true],
            'updated_at'       => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id_diskusi', true);
        $this->forge->addKey('slug');
        $this->forge->addForeignKey('id_kursus', 'kursus', 'id_kursus', 'CASCADE');
        $this->forge->createTable('diskusi');
    }

    public function down()
    {
        $this->forge->dropTable('diskusi');
    }
}
