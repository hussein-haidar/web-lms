<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateChatTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_chat'       => ['type' => 'INT', 'auto_increment' => true],
            'id_pengirim'   => ['type' => 'INT'],
            'role_pengirim' => ['type' => "ENUM('siswa','pengajar','admin')"],
            'id_penerima'   => ['type' => 'INT'],
            'role_penerima' => ['type' => "ENUM('siswa','pengajar','admin')"],
            'id_kursus'     => ['type' => 'INT', 'null' => true],
            'pesan'         => ['type' => 'TEXT'],
            'is_read'       => ['type' => 'TINYINT', 'default' => 0],
            'created_at'    => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id_chat', true);
        $this->forge->addKey(['id_pengirim', 'id_penerima']);
        $this->forge->createTable('chat');
    }

    public function down()
    {
        $this->forge->dropTable('chat');
    }
}
