<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelAkun2 extends Model
{
    protected $table            = 'akun2s';
    protected $primaryKey       = 'id_akun2';
    protected $returnType       = 'object';
    protected $allowedFields    = ['kode_akun2', 'nama_akun2', 'kode_akun1'];
    // protected $DBGroup           = 'default';
    // protected $useAutoIncrement  = true;
    // protected $insertID          = 0;
    // protected $useSoftDeletes    = false;
    // protected $protectFields     = true;

    // Dates
    // protected $useTimestamps = false;
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

    function ambilrelasi()
    {
        $builder = $this->db->table('akun2s');
        $builder->join('akun1s', 'akun1s.kode_akun1 = akun2s.kode_akun1');
        $query = $builder->get();
        return $query->getResult();
    }
}
