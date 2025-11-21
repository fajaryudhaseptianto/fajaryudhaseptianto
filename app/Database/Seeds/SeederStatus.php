<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SeederStatus extends Seeder
{
    public function run()
    {
        $this->db->table('tbl_status')->truncate();
        $data = [
            [
                'status'    => 'Penerimaan',
            ],
            [
                'status'    => 'Pengeluaran',
            ],
            [
                'status'    => 'Investasi Masuk',
            ],
            [
                'status'    => 'Investasi Keluar',
            ],
            [
                'status'    => 'Normal',
            ],
        ];

       
        $this->db->table('tbl_status')->insertBatch($data);
    }
}