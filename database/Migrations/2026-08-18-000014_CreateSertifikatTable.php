<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSertifikatTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_sertifikat'    => ['type' => 'INT', 'auto_increment' => true],
            'id_pendaftaran'   => ['type' => 'INT'],
            'id_siswa'         => ['type' => 'INT'],
            'id_kursus'        => ['type' => 'INT'],
            'kode_sertifikat'  => ['type' => 'VARCHAR', 'constraint' => 50, 'unique' => true],
            'nama_penerima'    => ['type' => 'VARCHAR', 'constraint' => 100],
            'nama_kursus'      => ['type' => 'VARCHAR', 'constraint' => 200],
            'tanggal_terbit'   => ['type' => 'DATE'],
            'file_sertifikat'  => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'status'           => ['type' => "ENUM('draft','aktif','dicabut')", 'default' => 'aktif'],
            'qr_code'          => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'created_at'       => ['type' => 'DATETIME', 'null' => true],
            'updated_at'       => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id_sertifikat', true);
        $this->forge->addKey('kode_sertifikat');
        $this->forge->addForeignKey('id_pendaftaran', 'pendaftaran', 'id_pendaftaran', 'CASCADE');
        $this->forge->addForeignKey('id_siswa', 'siswa', 'id_siswa', 'CASCADE');
        $this->forge->createTable('sertifikat');
    }

    public function down()
    {
        $this->forge->dropTable('sertifikat');
    }
}
