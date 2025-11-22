<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelTransaksi extends Model
{
    protected $table            = 'tbl_transaksi';
    protected $primaryKey       = 'id_transaksi';
    // protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    // protected $useSoftDeletes   = false;
    // protected $protectFields    = true;
    protected $allowedFields    = ['kwitansi', 'tanggal', 'deskripsi', 'ketjurnal'];

    // protected bool $allowEmptyInserts = false;

    // Dates
    protected $useTimestamps = true;
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

    public function noKwitansi()
    {
        $number = $this->db->table('tbl_transaksi')->select('RIGHT(tbl_transaksi.kwitansi,4) as kwitansi', FALSE)
            ->orderBy('kwitansi', 'DESC')->limit(1)->get()->getRowArray();

        if ($number == null) {
            $no = 1;
        } else {
            $no = intval($number['kwitansi']) + 1;
        }
        $nomor_kwitansi = str_pad($no, 4, "0", STR_PAD_LEFT);
        return $nomor_kwitansi;
    }

    public function get_jurnalumum($tglawal, $tglakhir)
    {
        $sql = $this->db->table('tbl_nilai')
            ->select([
                'tbl_transaksi.id_transaksi',
                'tbl_transaksi.kwitansi',
                'tbl_transaksi.tanggal',
                'tbl_transaksi.deskripsi',
                'tbl_transaksi.ketjurnal',
                'tbl_nilai.kode_akun3',
                'tbl_nilai.debit',
                'tbl_nilai.kredit',
                'akun3s.nama_akun3',
            ])
            ->select("(CASE WHEN tbl_nilai.debit > 0 AND tbl_nilai.kredit = 0 THEN 0 ELSE 1 END) AS posisi", false)
            ->join('tbl_transaksi', 'tbl_transaksi.id_transaksi=tbl_nilai.id_transaksi')
            ->join('akun3s', 'akun3s.kode_akun3=tbl_nilai.kode_akun3')
            ->distinct()
            ->orderBy('tbl_transaksi.tanggal', 'ASC')
            ->orderBy('tbl_transaksi.id_transaksi', 'ASC')
            ->orderBy('posisi', 'ASC', false)
            ->orderBy('tbl_nilai.kode_akun3', 'ASC');
        if ($tglawal && $tglakhir) {
            $sql->where('tanggal >=', $tglawal)->where('tanggal <=', $tglakhir);
        }
        return $sql->get()->getResultObject();
    }

    public function get_posting($tglawal, $tglakhir, $kode_akun3)
    {
        $sql = $this->db->table('tbl_nilai')
            ->join('tbl_transaksi', 'tbl_transaksi.id_transaksi=tbl_nilai.id_transaksi')
            ->join('akun3s', 'akun3s.kode_akun3=tbl_nilai.kode_akun3')
            ->orderBy('akun3s.kode_akun3');
        if ($tglawal && $tglakhir) {
            $sql->where('tanggal >=', $tglawal)->where('tanggal <=', $tglakhir)->where('tbl_nilai.kode_akun3=', $kode_akun3);
        }
        return $sql->get()->getResultObject();
    }

    public function get_jpenyesuaian($tglawal, $tglakhir)
    {
        // Pastikan semua data penyesuaian terambil tanpa kehilangan akun
        // Gunakan DISTINCT untuk menghindari duplikat dan pastikan semua data terambil
        $sql = $this->db->table('tbl_nilaipenyesuaian')
            ->select('tbl_nilaipenyesuaian.kode_akun3, akun3s.nama_akun3')
            ->selectSum('tbl_nilaipenyesuaian.debit', 'jumdebit')
            ->selectSum('tbl_nilaipenyesuaian.kredit', 'jumkredit')
            ->join('tbl_penyesuaian', 'tbl_penyesuaian.id_penyesuaian = tbl_nilaipenyesuaian.id_penyesuaian', 'inner')
            ->join('akun3s', 'akun3s.kode_akun3 = tbl_nilaipenyesuaian.kode_akun3', 'inner')
            ->groupBy('tbl_nilaipenyesuaian.kode_akun3, akun3s.nama_akun3')
            ->orderBy('tbl_nilaipenyesuaian.kode_akun3', 'ASC');

        if ($tglawal && $tglakhir) {
            $sql->where('tbl_penyesuaian.tanggal >=', $tglawal)
                ->where('tbl_penyesuaian.tanggal <=', $tglakhir);
        }
        
        $query = $sql->get()->getResultObject();
        return $query;
    }

    public function get_neracasaldo($tglawal, $tglakhir)
    {
        $sql = $this->db->table('tbl_nilai')
            ->join('tbl_transaksi', 'tbl_transaksi.id_transaksi=tbl_nilai.id_transaksi')
            ->join('akun3s', 'akun3s.kode_akun3=tbl_nilai.kode_akun3')
            ->selectSum('debit', 'jumdebit')
            ->selectSum('kredit', 'jumkredit')
            ->Select('akun3s.kode_akun3, akun3s.nama_akun3,tbl_transaksi.tanggal')
            ->groupBy('akun3s.kode_akun3');

        if ($tglawal && $tglakhir) {
            $sql->where('tanggal >=', $tglawal)->where('tanggal <=', $tglakhir);
        }
        $query = $sql->get()->getResultObject();
        return $query;
    }

    public function get_neracalajur($tglawal, $tglakhir)
    {
        $where1 = '';
        $where2 = '';

        if ($tglawal && $tglakhir) {
            $where1 = "where tb3.tanggal >= '" . $tglawal . "' and tb3.tanggal <= '" . $tglakhir . "' ";
            $where2 = "where tb4.tanggal >= '" . $tglawal . "' and tb4.tanggal <= '" . $tglakhir . "' ";
        }

        $sql = $this->db->query("SELECT * FROM(
    SELECT 
        tbak.nama_akun3, 
        tb1.kode_akun3,
        tb3.tanggal as tanggal,
        sum(tb1.debit) as jumdebit,
        sum(tb1.kredit) as jumkredit,
        tb2.debit as jumdebits,
        tb2.kredit as jumkredits

    FROM tbl_nilai as tb1

        join tbl_transaksi as tb3 on tb3.id_transaksi = tb1.id_transaksi
        left join tbl_nilaipenyesuaian as tb2 on tb1.kode_akun3 = tb2.kode_akun3
        join akun3s as tbak on tb1.kode_akun3 = tbak.kode_akun3
        " . $where1 . "
        group by tb1.kode_akun3

    UNION

    SELECT 
        tbak.nama_akun3, 
        tb2.kode_akun3,
        tb4.tanggal as tanggal,
        sum(tb1.debit) as jumdebit,
        sum(tb1.kredit) as jumkredit,
        tb2.debit as jumdebits,
        tb2.kredit as jumkredits

    FROM tbl_nilai as tb1

        right join tbl_nilaipenyesuaian as tb2 on tb1.kode_akun3 = tb2.kode_akun3
        join akun3s as tbak on tb2.kode_akun3 = tbak.kode_akun3
        join tbl_penyesuaian as tb4 on tb4.id_penyesuaian = tb2.id_penyesuaian
        " . $where2 . "
        group by tb2.kode_akun3) as tbl_new
        group by tbl_new.kode_akun3");

        $query = $sql->getResultObject();
        return $query;
    }
    public function get_labarugi($tglawal, $tglakhir)
    {
        $where1 = '';
        $where2 = '';

        if ($tglawal && $tglakhir) {
            $where1 = "WHERE tb3.tanggal >= '" . $tglawal . "' AND tb3.tanggal <= '" . $tglakhir . "'";
            $where2 = "WHERE tb4.tanggal >= '" . $tglawal . "' AND tb4.tanggal <= '" . $tglakhir . "'";
        }

        // Query sederhana: gabungkan transaksi dan penyesuaian tanpa duplikasi
        // Pastikan setiap akun hanya muncul sekali dengan GROUP BY
        $sql = $this->db->query("SELECT 
            tbak.kode_akun3,
            tbak.nama_akun3,
            tbak.kode_akun2,
            tbak.kode_akun1,
            COALESCE(SUM(trans.jumdebit), 0) as jumdebit,
            COALESCE(SUM(trans.jumkredit), 0) as jumkredit,
            COALESCE(SUM(adj.jumdebits), 0) as jumdebits,
            COALESCE(SUM(adj.jumkredits), 0) as jumkredits
        FROM akun3s as tbak
        LEFT JOIN (
            SELECT 
                kode_akun3,
                SUM(debit) as jumdebit,
                SUM(kredit) as jumkredit
            FROM tbl_nilai
            JOIN tbl_transaksi as tb3 ON tb3.id_transaksi = tbl_nilai.id_transaksi
            " . $where1 . "
            GROUP BY kode_akun3
        ) as trans ON trans.kode_akun3 = tbak.kode_akun3
        LEFT JOIN (
            SELECT 
                kode_akun3,
                SUM(debit) as jumdebits,
                SUM(kredit) as jumkredits
            FROM tbl_nilaipenyesuaian
            JOIN tbl_penyesuaian as tb4 ON tb4.id_penyesuaian = tbl_nilaipenyesuaian.id_penyesuaian
            " . $where2 . "
            GROUP BY kode_akun3
        ) as adj ON adj.kode_akun3 = tbak.kode_akun3
        WHERE tbak.kode_akun1 >= 4
        AND (trans.kode_akun3 IS NOT NULL OR adj.kode_akun3 IS NOT NULL)
        GROUP BY tbak.kode_akun3, tbak.nama_akun3, tbak.kode_akun2, tbak.kode_akun1
        ORDER BY tbak.kode_akun3");
        
        $query = $sql->getResultObject();
        return $query;
    }

    public function get_pmodal($tglawal, $tglakhir)
    {
        $where1 = '';
        $where2 = '';

        if ($tglawal && $tglakhir) {
            $where1 = "where tb3.tanggal >= '" . $tglawal . "' and tb3.tanggal <= '" . $tglakhir . "' ";
            $where2 = "where tb4.tanggal >= '" . $tglawal . "' and tb4.tanggal <= '" . $tglakhir . "' ";
        }

        $sql = $this->db->query("SELECT * FROM(
    SELECT 
        tbak.nama_akun3, tbak.kode_akun2, tbak.kode_akun1,
        tb1.kode_akun3,
        tb3.tanggal as tanggal,
        sum(tb1.debit) as jumdebit,
        sum(tb1.kredit) as jumkredit,
        tb2.debit as jumdebits,
        tb2.kredit as jumkredits

    FROM tbl_nilai as tb1

        join tbl_transaksi as tb3 on tb3.id_transaksi = tb1.id_transaksi
        left join tbl_nilaipenyesuaian as tb2 on tb1.kode_akun3 = tb2.kode_akun3
        join akun3s as tbak on tb1.kode_akun3 = tbak.kode_akun3
        " . $where1 . "
        group by tb1.kode_akun3

    UNION

    SELECT 
        tbak.nama_akun3, tbak.kode_akun2, tbak.kode_akun1,
        tb2.kode_akun3,
        tb4.tanggal as tanggal,
        sum(tb1.debit) as jumdebit,
        sum(tb1.kredit) as jumkredit,
        tb2.debit as jumdebits,
        tb2.kredit as jumkredits

    FROM tbl_nilai as tb1

        right join tbl_nilaipenyesuaian as tb2 on tb1.kode_akun3 = tb2.kode_akun3
        join akun3s as tbak on tb2.kode_akun3 = tbak.kode_akun3
        join tbl_penyesuaian as tb4 on tb4.id_penyesuaian = tb2.id_penyesuaian
        " . $where2 . "
        group by tb2.kode_akun3) as tbl_new
        group by tbl_new.kode_akun3");

        $query = $sql->getResultObject();
        return $query;
    }

    public function get_neraca($tglawal, $tglakhir)
    {
        $where1 = '';
        $where2 = '';

        if ($tglawal && $tglakhir) {
            $where1 = "where tb3.tanggal >= '" . $tglawal . "' and tb3.tanggal <= '" . $tglakhir . "' ";
            $where2 = "where tb4.tanggal >= '" . $tglawal . "' and tb4.tanggal <= '" . $tglakhir . "' ";
        }

        $sql = $this->db->query("SELECT * FROM(
    SELECT 
        tbak.nama_akun3, tbak.kode_akun2, tbak.kode_akun1,
        tb1.kode_akun3,
        tb3.tanggal as tanggal,
        sum(tb1.debit) as jumdebit,
        sum(tb1.kredit) as jumkredit,
        tb2.debit as jumdebits,
        tb2.kredit as jumkredits

    FROM tbl_nilai as tb1

        join tbl_transaksi as tb3 on tb3.id_transaksi = tb1.id_transaksi
        left join tbl_nilaipenyesuaian as tb2 on tb1.kode_akun3 = tb2.kode_akun3
        join akun3s as tbak on tb1.kode_akun3 = tbak.kode_akun3
        " . $where1 . "
        group by tb1.kode_akun3

    UNION

    SELECT 
        tbak.nama_akun3, tbak.kode_akun2, tbak.kode_akun1,
        tb2.kode_akun3,
        tb4.tanggal as tanggal,
        sum(tb1.debit) as jumdebit,
        sum(tb1.kredit) as jumkredit,
        tb2.debit as jumdebits,
        tb2.kredit as jumkredits

    FROM tbl_nilai as tb1

        right join tbl_nilaipenyesuaian as tb2 on tb1.kode_akun3 = tb2.kode_akun3
        join akun3s as tbak on tb2.kode_akun3 = tbak.kode_akun3
        join tbl_penyesuaian as tb4 on tb4.id_penyesuaian = tb2.id_penyesuaian
        " . $where2 . "
        group by tb2.kode_akun3) as tbl_new where tbl_new.kode_akun1 <= 2
        group by tbl_new.kode_akun3");

        $query = $sql->getResultObject();
        return $query;
    }

    public function get_aruskas($tglawal, $tglakhir)
    {
        $sql = $this->db->table('tbl_nilai')
            ->join('tbl_transaksi', 'tbl_transaksi.id_transaksi=tbl_nilai.id_transaksi')
            ->join('akun3s', 'akun3s.kode_akun3=tbl_nilai.kode_akun3')
            ->Select('akun3s.kode_akun3, akun3s.nama_akun3,tbl_transaksi.tanggal, debit, kredit, id_status,ketjurnal')
            ->where('akun3s.kode_akun3=1101');

        if ($tglawal && $tglakhir) {
            $sql->where('tanggal >=', $tglawal)->where('tanggal <=', $tglakhir);
        }
        $query = $sql->get()->getResultObject();
        return $query;
    }
}