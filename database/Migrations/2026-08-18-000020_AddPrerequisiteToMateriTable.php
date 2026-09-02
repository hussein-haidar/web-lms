<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddPrerequisiteToMateriTable extends Migration
{
    public function up()
    {
        $this->forge->addColumn('materi', [
            'prerequisite_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('materi', 'prerequisite_id');
    }
}
