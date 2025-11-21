<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatAkun3 extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_akun3' => [
                'type'           => 'INT',
                'constraint'     => 6,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'kode_akun3' => [
                'type'       => 'INT',
                'constraint' => 6,
                'unsigned'   => true,
            ],
            'nama_akun3' => [
                'type' => 'VARCHAR',
                'constraint' => 70,
            ],
            'kode_akun2' => [
                'type' => 'INT',
                'constraint' => 6,
                'unsigned'       => true,
            ],
            'kode_akun1' => [
                'type' => 'INT',
                'constraint' => 6,
                'unsigned'       => true,
            ],
        ]);
        $this->forge->addKey('id_akun3', true);
        $this->forge->addForeignKey('kode_akun1', 'akun1s', 'id_akun1');
        $this->forge->createTable('akun3s');
    }

    public function down()
    {
        $this->forge->dropForeignKey('akun3s', 'akun3s_kode_akun1_foreign');
        $this->forge->dropTable('akun3s');
    }
}
