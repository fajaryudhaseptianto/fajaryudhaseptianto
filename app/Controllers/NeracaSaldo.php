<?php

namespace App\Controllers;

use App\Models\ModelTransaksi;
use App\Models\ModelAkun3;
use App\Models\ModelStatus;
use App\Models\ModelNilai;
use TCPDF;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class NeracaSaldo extends BaseController
{
    protected $objTransaksi;
    protected $db;
    protected $objNilai;
    protected $objAkun3;
    protected $objStatus;

    function __construct()
    {
        $this->objTransaksi = new ModelTransaksi();
        $this->db = \Config\Database::connect();
        $this->objNilai = new ModelNilai();
        $this->objAkun3 = new ModelAkun3();
        $this->objStatus = new ModelStatus();
    }
    public function index()
    {
        $tglawal = $this->request->getVar('tglawal') ? $this->request->getVar('tglawal') : '';
        $tglakhir = $this->request->getVar('tglakhir') ? $this->request->getVar('tglakhir') : '';

        $rowdata = $this->objTransaksi->get_neracasaldo($tglawal, $tglakhir);

        $data['dttransaksi'] = $rowdata;
        $data['tglawal'] = $tglawal;
        $data['tglakhir'] = $tglakhir;
        return view('neracasaldo/index', $data);
    }
    public function neracasaldopdf()
    {
        $tglawal = $this->request->getVar('tglawal') ? $this->request->getVar('tglawal') : '';
        $tglakhir = $this->request->getVar('tglakhir') ? $this->request->getVar('tglakhir') : '';

        $rowdata = $this->objTransaksi->get_neracasaldo($tglawal, $tglakhir);

        $data['dttransaksi'] = $rowdata;
        $data['tglawal'] = $tglawal;
        $data['tglakhir'] = $tglakhir;

        $html = view('neracasaldo/neracasaldopdf', $data);
        // create new PDF document
        $pdf = new TCPDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);
        // remove default header/footer
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        // set margins
        $pdf->SetMargins(30, 4, 3);

        // set font
        $pdf->SetFont('helvetica', '', 8);
        // add a page
        $pdf->AddPage();
        // Print text using writeHTMLCell()
        $pdf->writeHTML($html, true, false, true, false, '');

        // This method has several options, check the source code documentation for more information.
        $this->response->setContentType('application/pdf');
        $pdf->Output('neracasaldo.pdf', 'I');
    }
    
}