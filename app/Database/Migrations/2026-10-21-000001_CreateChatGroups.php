<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateChatGroups extends Migration
{
    public function up()
    {
        // Chat groups table
        $this->forge->addField([
            'id_group'   => ['type' => 'INT', 'auto_increment' => true],
            'nama_group' => ['type' => 'VARCHAR', 'constraint' => 100],
            'deskripsi'  => ['type' => 'TEXT', 'null' => true],
            'created_by' => ['type' => 'INT'],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id_group', true);
        $this->forge->createTable('chat_groups');

        // Chat group members
        $this->forge->addField([
            'id'         => ['type' => 'INT', 'auto_increment' => true],
            'id_group'   => ['type' => 'INT'],
            'id_siswa'   => ['type' => 'INT'],
            'role'       => ['type' => "ENUM('admin','member')", 'default' => 'member'],
            'joined_at'  => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey(['id_group', 'id_siswa']);
        $this->forge->createTable('chat_group_members');

        // Add group_id to chat table
        $this->forge->addColumn('chat', [
            'id_group' => ['type' => 'INT', 'null' => true, 'after' => 'id_penerima'],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('chat', 'id_group');
        $this->forge->dropTable('chat_group_members');
        $this->forge->dropTable('chat_groups');
    }
}
