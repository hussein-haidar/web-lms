<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSiswaTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_siswa'       => ['type' => 'INT', 'auto_increment' => true],
            'nama_lengkap'   => ['type' => 'VARCHAR', 'constraint' => 100],
            'email'          => ['type' => 'VARCHAR', 'constraint' => 100, 'unique' => true],
            'kata_sandi'     => ['type' => 'VARCHAR', 'constraint' => 255],
            'no_telepon'     => ['type' => 'VARCHAR', 'constraint' => 15],
            'tempat_lahir'   => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'tanggal_lahir'  => ['type' => 'DATE', 'null' => true],
            'jenis_kelamin'  => ['type' => "ENUM('Laki - laki','Perempuan')", 'default' => 'Laki - laki'],
            'agama'          => ['type' => 'VARCHAR', 'constraint' => 20, 'default' => 'Islam'],
            'alamat'         => ['type' => 'TEXT', 'null' => true],
            'foto_profil'    => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'status'         => ['type' => "ENUM('aktif','nonaktif')", 'default' => 'aktif'],
            'tanggal_daftar' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id_siswa', true);
        $this->forge->createTable('siswa');
    }

    public function down()
    {
        $this->forge->dropTable('siswa');
    }
}
