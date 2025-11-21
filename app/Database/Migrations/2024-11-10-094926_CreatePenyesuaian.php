<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePenyesuaian extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_penyesuaian'          => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'tanggal' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'deskripsi' => [
                'type' => 'TEXT',
            ],
            'nilai' => [
                'type' => 'FLOAT',
                'constraint' => 12,
            ],
            'waktu' => [
                'type' => 'INT',
                'constraint' => 12,
            ],
            'jumlah' => [
                'type' => 'FLOAT',
                'constraint' => 12,
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
        $this->forge->addKey('id_penyesuaian', true);
        $this->forge->createTable('tbl_penyesuaian');
    }

    public function down()
    {
        $this->forge->dropTable('tbl_penyesuaian');
    }
}