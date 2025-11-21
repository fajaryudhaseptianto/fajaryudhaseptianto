<?php

namespace App\Controllers;

use App\Models\ModelAkun3;
use App\Models\ModelNilai;
use App\Models\ModelStatus;
use App\Models\ModelTransaksi;
use App\Controllers\BaseController;
use TCPDF;
use CodeIgniter\HTTP\ResponseInterface;

class Pmodal extends BaseController
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
        $this->objNilai = new ModelNilai();
        $this->objAkun3 = new ModelAkun3();
        $this->objStatus = new ModelStatus();
    }

    public function index()
    {
        $tglawal = $this->request->getVar('tglawal') ? $this->request->getVar('tglawal') : '';
        $tglakhir = $this->request->getVar('tglakhir') ? $this->request->getVar('tglakhir') : '';

        $rowdata = $this->objTransaksi->get_pmodal($tglawal, $tglakhir);

        $modal_awal = 0;
        $pendapatan = 0;
        $prive = 0;
        $jumdebit = 0;
        $jumdebits = 0;

        foreach ($rowdata as $row) {
            if ($row->kode_akun3 == 3101) {
                $modal_awal = $row->jumkredit;
            }
            if ($row->kode_akun3 == 4101) {
                $pendapatan = $row->jumkredit + $row->jumkredits;
            }
            if ($row->kode_akun3 == 3201) {
                $prive = $row->jumdebit;
            }
            if (substr($row->kode_akun3, 0, 2) == 51) {
                $jumdebit = $jumdebit + $row->jumdebit;
                $jumdebits = $jumdebits + $row->jumdebits;
            }
        }

        $beban = $jumdebit + $jumdebits;

        $rowdatanew['modal_awal'] = $modal_awal;
        $rowdatanew['pendapatan'] = $pendapatan;
        $rowdatanew['prive'] = $prive;
        $rowdatanew['beban'] = $beban;
        $rowdatanew['laba_rugi'] = $pendapatan - $beban;

        $rowdatanew['penambahan_modal'] = $rowdatanew['laba_rugi'] - $prive;
        $rowdatanew['modal_akhir'] = $rowdatanew['penambahan_modal'] + $modal_awal;

        $data['dttransaksi'] = $rowdatanew;
        $data['tglawal'] = $tglawal;
        $data['tglakhir'] = $tglakhir;

        // echo "<prev>";
        // echo print_r($data);
        // echo "</prev>";
        // die;

        return view('pmodal/index', $data);
    }

    public function pmodalpdf()
    {
        $tglawal = $this->request->getVar('tglawal') ? $this->request->getVar('tglawal') : '';
        $tglakhir = $this->request->getVar('tglakhir') ? $this->request->getVar('tglakhir') : '';

        $rowdata = $this->objTransaksi->get_pmodal($tglawal, $tglakhir);

        $modal_awal = 0;
        $pendapatan = 0;
        $prive = 0;
        $jumdebit = 0;
        $jumdebits = 0;

        foreach ($rowdata as $row) {
            if ($row->kode_akun3 == 3101) {
                $modal_awal = $row->jumkredit;
            }
            if ($row->kode_akun3 == 4101) {
                $pendapatan = $row->jumkredit + $row->jumkredits;
            }
            if ($row->kode_akun3 == 3201) {
                $prive = $row->jumdebit;
            }
            if (substr($row->kode_akun3, 0, 2) == 51) {
                $jumdebit = $jumdebit + $row->jumdebit;
                $jumdebits = $jumdebits + $row->jumdebits;
            }
        }

        $beban = $jumdebit + $jumdebits;

        $rowdatanew['modal_awal'] = $modal_awal;
        $rowdatanew['pendapatan'] = $pendapatan;
        $rowdatanew['prive'] = $prive;
        $rowdatanew['beban'] = $beban;
        $rowdatanew['laba_rugi'] = $pendapatan - $beban;

        $rowdatanew['penambahan_modal'] = $rowdatanew['laba_rugi'] - $prive;
        $rowdatanew['modal_akhir'] = $rowdatanew['penambahan_modal'] + $modal_awal;

        $data['dttransaksi'] = $rowdatanew;
        $data['tglawal'] = $tglawal;
        $data['tglakhir'] = $tglakhir;

        // echo "<prev>";
        // echo print_r($data);
        // echo "</prev>";
        // die;

        $html = view('pmodal/pmodalpdf', $data);
        $pdf = new TCPDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);

        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->SetMargins(30, 4, 3);
        $pdf->SetFont('helvetica', '', 8);
        $pdf->AddPage();
        $pdf->writeHTML($html, true, false, true, false, '');
        $this->response->setContentType('application/pdf');
        $pdf->Output('pmodalpdf.pdf', 'I');

        // return view('pmodal/index', $data);
    }
}