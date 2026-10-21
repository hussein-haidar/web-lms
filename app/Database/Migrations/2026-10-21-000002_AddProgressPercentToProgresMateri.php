<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddProgressPercentToProgresMateri extends Migration
{
    public function up()
    {
        $this->forge->addColumn('progres_materi', [
            'progress_percent' => ['type' => 'INT', 'default' => 0, 'after' => 'last_position'],
            'milestone_25'    => ['type' => 'TINYINT', 'default' => 0, 'after' => 'progress_percent'],
            'milestone_50'    => ['type' => 'TINYINT', 'default' => 0, 'after' => 'milestone_25'],
            'milestone_75'    => ['type' => 'TINYINT', 'default' => 0, 'after' => 'milestone_50'],
            'milestone_100'   => ['type' => 'TINYINT', 'default' => 0, 'after' => 'milestone_75'],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('progres_materi', ['progress_percent', 'milestone_25', 'milestone_50', 'milestone_75', 'milestone_100']);
    }
}
