<?php

namespace App\Controllers;

use App\Models\ModelAkun3;
use App\Models\ModelTransaksi;
use App\Models\ModelStatus;
use App\Models\ModelNilai;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use TCPDF;

class Posting extends BaseController
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
        $tglawal = $this->request->getVar('tglawal') ? $this->request->getVar('tglawal') : '';
        $tglakhir = $this->request->getVar('tglakhir') ? $this->request->getVar('tglakhir') : '';
        $kode_akun3 = $this->request->getVar('kode_akun3') ? $this->request->getVar('kode_akun3') : '';

        $rowdata = $this->objTransaksi->get_posting($tglawal, $tglakhir, $kode_akun3);
        $data['dttransaksi'] = $rowdata;
        $data['tglawal'] = $tglawal;
        $data['tglakhir'] = $tglakhir;
        $data['kode_akun3'] = $kode_akun3;
        $data['dtakun3'] = $this->objAkun3->ambilrelasi();
        return view('posting/index', $data);
    }

    public function postingpdf()
    {
        $tglawal = $this->request->getVar('tglawal') ? $this->request->getVar('tglawal') : '';
        $tglakhir = $this->request->getVar('tglakhir') ? $this->request->getVar('tglakhir') : '';
        $kode_akun3 = $this->request->getVar('kode_akun3') ? $this->request->getVar('kode_akun3') : '';

        $rowdata = $this->objTransaksi->get_posting($tglawal, $tglakhir, $kode_akun3);
        $data['dttransaksi'] = $rowdata;
        $data['tglawal'] = $tglawal;
        $data['tglakhir'] = $tglakhir;
        $data['kode_akun3'] = $kode_akun3;
        $data['dtakun3'] = $this->objAkun3->ambilrelasi();

        $html = view('posting/postingpdf', $data);

        $pdf = new TCPDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);    
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->SetMargins(30, 4, 3);
        $pdf->SetFont('helvetica', '', 8);
        $pdf->AddPage();
        $pdf->writeHTML($html, true, false, true, false, '');
        $this->response->setContentType('application/pdf');
        $pdf->Output('posting.pdf', 'I');
    }
}