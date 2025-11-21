<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateNilaiPenyesuaian extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'id_penyesuaian' => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
            ],
            'kode_akun3' => [
                'type'           => 'INT',
                'constraint'     => 6,
                'unsigned'       => true,
            ],
            'debit' => [
                'type' => 'FLOAT',
                'constraint'     => 12,
                'unsigned'       => true,
            ],
            'kredit' => [
                'type' => 'FLOAT',
                'constraint'     => 12,
                'unsigned'       => true,
            ],
            'id_status' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned'       => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'deleted_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('id_penyesuaian', 'tbl_penyesuaian', 'id_penyesuaian');
        $this->forge->createTable('tbl_nilaipenyesuaian');
    }

    public function down()
    {
        $this->forge->dropForeignKey('tbl_penyesuaian', 'tbl_nilaipenyesuaian_id_penyesuaian_foreign');
        $this->forge->dropTable('tbl_nilaipenyesuaian');
    }
}