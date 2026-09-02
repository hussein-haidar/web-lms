<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateNotifikasiTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_notifikasi'  => ['type' => 'INT', 'auto_increment' => true],
            'id_user'        => ['type' => 'INT'],
            'user_role'      => ['type' => "ENUM('siswa','karyawan','superadmin')"],
            'judul'          => ['type' => 'VARCHAR', 'constraint' => 200],
            'pesan'          => ['type' => 'TEXT'],
            'tipe'           => ['type' => "ENUM('info','success','warning','error')", 'default' => 'info'],
            'link'           => ['type' => 'VARCHAR', 'constraint' => 500, 'null' => true],
            'is_read'        => ['type' => 'TINYINT', 'default' => 0],
            'created_at'     => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id_notifikasi', true);
        $this->forge->addKey(['id_user', 'user_role']);
        $this->forge->createTable('notifikasi');
    }

    public function down()
    {
        $this->forge->dropTable('notifikasi');
    }
}
