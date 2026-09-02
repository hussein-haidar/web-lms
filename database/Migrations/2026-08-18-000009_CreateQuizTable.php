<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateQuizTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_quiz'        => ['type' => 'INT', 'auto_increment' => true],
            'id_kursus'      => ['type' => 'INT'],
            'id_modul'       => ['type' => 'INT', 'null' => true],
            'judul_quiz'     => ['type' => 'VARCHAR', 'constraint' => 200],
            'slug_quiz'      => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'deskripsi'      => ['type' => 'TEXT', 'null' => true],
            'durasi_menit'   => ['type' => 'INT', 'default' => 30],
            'passing_grade'  => ['type' => 'DECIMAL', 'constraint' => '5,2', 'default' => 70],
            'max_attempt'    => ['type' => 'INT', 'default' => 3],
            'soal_json'      => ['type' => 'LONGTEXT'],
            'status'         => ['type' => "ENUM('draft','aktif','nonaktif')", 'default' => 'draft'],
            'tanggal_mulai'  => ['type' => 'DATETIME', 'null' => true],
            'tanggal_selesai' => ['type' => 'DATETIME', 'null' => true],
            'created_at'     => ['type' => 'DATETIME', 'null' => true],
            'updated_at'     => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id_quiz', true);
        $this->forge->addForeignKey('id_kursus', 'kursus', 'id_kursus', 'CASCADE');
        $this->forge->createTable('quiz');
    }

    public function down()
    {
        $this->forge->dropTable('quiz');
    }
}
