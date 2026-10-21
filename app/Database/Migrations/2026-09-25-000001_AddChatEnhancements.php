<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddChatEnhancements extends Migration
{
    public function up()
    {
        // Add new columns to chat table
        $this->forge->addColumn('chat', [
            'file_name' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true, 'after' => 'pesan'],
            'file_type' => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true, 'after' => 'file_name'],
            'reply_to'  => ['type' => 'INT', 'null' => true, 'after' => 'file_type'],
            'is_edited' => ['type' => 'TINYINT', 'default' => 0, 'after' => 'reply_to'],
            'edited_at' => ['type' => 'DATETIME', 'null' => true, 'after' => 'is_edited'],
            'is_pinned' => ['type' => 'TINYINT', 'default' => 0, 'after' => 'edited_at'],
            'read_at'   => ['type' => 'DATETIME', 'null' => true, 'after' => 'is_read'],
        ]);

        // Create chat_reactions table
        $this->forge->addField([
            'id'         => ['type' => 'INT', 'auto_increment' => true],
            'id_chat'    => ['type' => 'INT'],
            'id_siswa'   => ['type' => 'INT'],
            'emoji'      => ['type' => 'VARCHAR', 'constraint' => 10],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey(['id_chat', 'id_siswa']);
        $this->forge->createTable('chat_reactions');

        // Create chat_typing table
        $this->forge->addField([
            'id'         => ['type' => 'INT', 'auto_increment' => true],
            'id_siswa'   => ['type' => 'INT'],
            'other_id'   => ['type' => 'INT'],
            'is_typing'  => ['type' => 'TINYINT', 'default' => 0],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey(['id_siswa', 'other_id']);
        $this->forge->createTable('chat_typing');

        // Add last_activity to siswa table
        $this->forge->addColumn('siswa', [
            'last_activity' => ['type' => 'DATETIME', 'null' => true],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('chat', ['file_name', 'file_type', 'reply_to', 'is_edited', 'edited_at', 'is_pinned', 'read_at']);
        $this->forge->dropTable('chat_reactions');
        $this->forge->dropTable('chat_typing');
        $this->forge->dropColumn('siswa', 'last_activity');
    }
}
