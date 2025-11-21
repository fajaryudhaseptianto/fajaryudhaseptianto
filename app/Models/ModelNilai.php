<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelNilai extends Model
{
    protected $table            = 'tbl_nilai';
    protected $primaryKey       = 'id_nilai';
    // protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    // protected $useSoftDeletes   = false;
    // protected $protectFields    = true;
    protected $allowedFields    = ['id_transaksi','kode_akun3','debit','kredit','id_status'];

    protected bool $allowEmptyInserts = false;

    // Dates
    protected $useTimestamps = false;
    // protected $dateFormat    = 'datetime';
    // protected $createdField  = 'created_at';
    // protected $updatedField  = 'updated_at';
    // protected $deletedField  = 'deleted_at';

    // Validation
    // protected $validationRules      = [];
    // protected $validationMessages   = [];
    // protected $skipValidation       = false;
    // protected $cleanValidationRules = true;

    // Callbacks
    // protected $allowCallbacks = true;
    // protected $beforeInsert   = [];
    // protected $afterInsert    = [];
    // protected $beforeUpdate   = [];
    // protected $afterUpdate    = [];
    // protected $beforeFind     = [];
    // protected $afterFind      = [];
    // protected $beforeDelete   = [];
    // protected $afterDelete    = [];

    function ambilrelasiid($id)
    {
        $builder = $this->db->table('tbl_nilai')
            ->select([
                'tbl_nilai.id_transaksi',
                'tbl_nilai.kode_akun3',
                'tbl_nilai.debit',
                'tbl_nilai.kredit',
                'tbl_nilai.id_status',
                'akun3s.nama_akun3',
                'tbl_status.status',
            ])
            ->where('tbl_nilai.id_transaksi', $id)
            ->join('akun3s', 'akun3s.kode_akun3 = tbl_nilai.kode_akun3')
            ->join('tbl_status', 'tbl_status.id_status = tbl_nilai.id_status')
            ->groupBy([
                'tbl_nilai.id_transaksi',
                'tbl_nilai.kode_akun3',
                'tbl_nilai.debit',
                'tbl_nilai.kredit',
                'tbl_nilai.id_status',
                'akun3s.nama_akun3',
                'tbl_status.status',
            ]);

        $query = $builder->get();
        return $query->getResultObject();
    }
}