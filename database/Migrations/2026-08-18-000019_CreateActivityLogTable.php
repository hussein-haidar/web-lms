<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateActivityLogTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_log' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'id_user' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => true,
            ],
            'user_role' => [
                'type'       => 'ENUM',
                'constraint' => ['superadmin', 'staf_admin', 'pengajar', 'teknisi', 'siswa'],
                'null'       => true,
            ],
            'user_name' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
                'null'       => true,
            ],
            'action' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'description' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'model' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
            ],
            'model_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
            ],
            'ip_address' => [
                'type'       => 'VARCHAR',
                'constraint' => 45,
                'null'       => true,
            ],
            'user_agent' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id_log', true);
        $this->forge->addKey('id_user');
        $this->forge->addKey('user_role');
        $this->forge->addKey('action');
        $this->forge->addKey('created_at');
        $this->forge->createTable('activity_log');
    }

    public function down()
    {
        $this->forge->dropTable('activity_log');
    }
}
