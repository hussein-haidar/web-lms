<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateKaryawanTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_karyawan'    => ['type' => 'INT', 'auto_increment' => true],
            'nama_lengkap'   => ['type' => 'VARCHAR', 'constraint' => 100],
            'email'          => ['type' => 'VARCHAR', 'constraint' => 100, 'unique' => true],
            'kata_sandi'     => ['type' => 'VARCHAR', 'constraint' => 255],
            'no_telepon'     => ['type' => 'VARCHAR', 'constraint' => 15],
            'alamat'         => ['type' => 'TEXT', 'null' => true],
            'foto_profil'    => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'role'           => ['type' => "ENUM('pengajar','staf','teknisi','superadmin')", 'default' => 'staf'],
            'status'         => ['type' => "ENUM('aktif','nonaktif')", 'default' => 'aktif'],
            'tanggal_bergabung' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id_karyawan', true);
        $this->forge->createTable('karyawan');
    }

    public function down()
    {
        $this->forge->dropTable('karyawan');
    }
}
