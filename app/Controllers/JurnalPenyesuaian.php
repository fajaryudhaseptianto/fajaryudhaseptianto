<?php

namespace App\Controllers;

use App\Models\ModelAkun3;
use App\Models\ModelTransaksi;
use App\Models\ModelStatus;
use App\Models\ModelNilai;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use TCPDF;

class JurnalPenyesuaian extends BaseController
{
    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->objTransaksi = new ModelTransaksi();
        $this->objNilai = new ModelNilai();
        $this->objAkun3 = new ModelAkun3();
        $this->objStatus = new ModelStatus();
    }

    public function index()
    {
        {
            $tglawal = $this->request->getVar('tglawal') ? $this->request->getVar('tglawal') : '';
            $tglakhir = $this->request->getVar('tglakhir') ? $this->request->getVar('tglakhir') : '';
    
            $rowdata = $this->objTransaksi->get_jpenyesuaian($tglawal, $tglakhir);    
            $data['dttransaksi'] = $rowdata;
            $data['tglawal'] = $tglawal;
            $data['tglakhir'] = $tglakhir;
            return view('jurnalpenyesuaian/index', $data);
        }    
    }
}