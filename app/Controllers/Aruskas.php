<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelAkun3;
use App\Models\ModelNilai;
use App\Models\ModelStatus;
use App\Models\ModelTransaksi;
use CodeIgniter\HTTP\ResponseInterface;
use TCPDF;

class Aruskas extends BaseController
{
    protected $objNilai;
    protected $objTransaksi;
    protected $db;
    protected $objAkun3;
    protected $objStatus;


    function __construct()
    {
        $this->db = \config\Database::connect();
        $this->objTransaksi = new ModelTransaksi();
    }
    public function index()
    {
        $tglawal = $this->request->getVar('tglawal') ? $this->request->getVar('tglawal') : '';
        $tglakhir = $this->request->getVar('tglakhir') ? $this->request->getVar('tglakhir') : '';

        $rowdata = $this->objTransaksi->get_aruskas($tglawal, $tglakhir);

        $data = [
            'dttransaksi' => $rowdata,
            'tglawal' => $tglawal,
            'tglakhir' => $tglakhir,
        ];


        // echo "<pre>";
        // echo print_r($data);
        // echo "</pre>";
        // die;

        return view('aruskas/index', $data);
    }

    public function aruskaspdf()
    {
        $tglawal = $this->request->getVar('tglawal') ? $this->request->getVar('tglawal') : '';
        $tglakhir = $this->request->getVar('tglakhir') ? $this->request->getVar('tglakhir') : '';

        $rowdata = $this->objTransaksi->get_aruskas($tglawal, $tglakhir);

        $data = [
            'dttransaksi' => $rowdata,
            'tglawal' => $tglawal,
            'tglakhir' => $tglakhir,
        ];


        // echo "<pre>";
        // echo print_r($data);
        // echo "</pre>";
        // die;

        // return view('aruskas/index', $data);
        
        $html = view('aruskas/aruskaspdf', $data);
        $pdf = new TCPDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->SetMargins(30, 4, 3);
        $pdf->SetFont('helvetica', '', 8);
        $pdf->AddPage();
        $pdf->writeHTML($html, true, false, true, false, '');
        $this->response->setContentType('application/pdf');
        $pdf->Output('aruskaspdf.pdf', 'I');
    }
}
