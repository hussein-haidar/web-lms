<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateBankSoalTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_soal' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'id_kursus' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'id_modul' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
            ],
            'kategori' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
            ],
            'tipe_soal' => [
                'type'       => 'ENUM',
                'constraint' => ['pilihan_ganda', 'essay', 'fill_blank', 'matching', 'true_false'],
                'default'    => 'pilihan_ganda',
            ],
            'pertanyaan' => [
                'type' => 'TEXT',
            ],
            'pilihan' => [
                'type' => 'LONGTEXT',
                'null' => true,
            ],
            'jawaban_benar' => [
                'type' => 'TEXT',
            ],
            'pilihan_pair' => [
                'type' => 'LONGTEXT',
                'null' => true,
            ],
            'bobot' => [
                'type'       => 'INT',
                'constraint' => 11,
                'default'    => 1,
            ],
            'level' => [
                'type'       => 'ENUM',
                'constraint' => ['mudah', 'sedang', 'sulit'],
                'default'    => 'sedang',
            ],
            'penjelasan' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['aktif', 'nonaktif'],
                'default'    => 'aktif',
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id_soal', true);
        $this->forge->addKey('id_kursus');
        $this->forge->addKey('tipe_soal');
        $this->forge->createTable('bank_soal');
    }

    public function down()
    {
        $this->forge->dropTable('bank_soal');
    }
}
