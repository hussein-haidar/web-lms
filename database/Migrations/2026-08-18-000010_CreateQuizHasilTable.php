<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateQuizHasilTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_quiz_hasil'  => ['type' => 'INT', 'auto_increment' => true],
            'id_quiz'        => ['type' => 'INT'],
            'id_pendaftaran' => ['type' => 'INT'],
            'id_siswa'       => ['type' => 'INT'],
            'attempt_ke'     => ['type' => 'INT', 'default' => 1],
            'jawaban_json'   => ['type' => 'LONGTEXT'],
            'total_nilai'    => ['type' => 'DECIMAL', 'constraint' => '5,2', 'default' => 0],
            'total_benar'    => ['type' => 'INT', 'default' => 0],
            'total_salah'    => ['type' => 'INT', 'default' => 0],
            'total_soal'     => ['type' => 'INT', 'default' => 0],
            'is_lulus'       => ['type' => 'TINYINT', 'default' => 0],
            'waktu_mulai'    => ['type' => 'DATETIME', 'null' => true],
            'waktu_selesai'  => ['type' => 'DATETIME', 'null' => true],
            'created_at'     => ['type' => 'DATETIME', 'null' => true],
            'updated_at'     => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id_quiz_hasil', true);
        $this->forge->addForeignKey('id_quiz', 'quiz', 'id_quiz', 'CASCADE');
        $this->forge->addForeignKey('id_pendaftaran', 'pendaftaran', 'id_pendaftaran', 'CASCADE');
        $this->forge->addForeignKey('id_siswa', 'siswa', 'id_siswa', 'CASCADE');
        $this->forge->createTable('quiz_hasil');
    }

    public function down()
    {
        $this->forge->dropTable('quiz_hasil');
    }
}
