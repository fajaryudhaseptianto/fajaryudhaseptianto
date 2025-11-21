<?php

namespace App\Controllers;

use App\Models\ModelAkun3;
use App\Models\ModelStatus;
use App\Models\ModelPenyesuaian;
use App\Models\ModelNilaiPenyesuaian;
use CodeIgniter\HTTP\ResponseInterface; 
use CodeIgniter\RESTful\ResourceController;

class Penyesuaian extends ResourceController
{
    /**
     * Return an array of resource objects, themselves in array format.
     *
     * @return ResponseInterface
     */

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->objPenyesuaian = new ModelPenyesuaian();
        $this->objNilaiPenyesuaian = new ModelNilaiPenyesuaian();
        $this->objAkun3 = new ModelAkun3();
        $this->objStatus = new ModelStatus();
    }
 
    public function index()
    {
        $data['dtpenyesuaian'] = $this->objPenyesuaian->findAll();
        return view('penyesuaian/index', $data);
    }

    /**
     * Return the properties of a resource object.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function show($id = null)
    {
        $penyesuaian = $this->objPenyesuaian->find($id);
        $akun3 = $this->objAkun3->findAll();
        $status = $this->objStatus->findAll();
        $nilai = $this->objNilaiPenyesuaian->ambilrelasiid($id);
        $data['dtnilaipenyesuaian'] =$nilai;

        if(is_object($penyesuaian)) {
            $data['dtakun3'] = $akun3;
            $data['dtstatus'] = $status;
            $data['dtpenyesuaian'] = $penyesuaian;

            return view('penyesuaian/show', $data);
        } else {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
    }

    /**
     * Return a new resource object, with default properties.
     *
     * @return ResponseInterface
     */
    public function new()
    {
        return view('penyesuaian/new');
    }

    /**
     * Create a new resource object, from "posted" parameters.
     *
     * @return ResponseInterface
     */

    public function create()
    {
        $data1 = [
            'tanggal' => $this->request->getVar('tanggal'),
            'deskripsi' => $this->request->getVar('deskripsi'),
            'nilai' => $this->request->getVar('nilai'),
            'waktu' => $this->request->getVar('waktu'),
            'jumlah' => $this->request->getVar('jumlah'),
        ];
        // simpan data ke tbl_penyesuaian
        $this->db->table('tbl_penyesuaian')->insert($data1);

        // kita ambil ID dari tbl_penyesuaian
        $id_penyesuaian = $this->objPenyesuaian->insertID();
        $kode_akun3 = $this->request->getVar('kode_akun3');
        $debit = $this->request->getVar('debit');
        $kredit = $this->request->getVar('kredit');
        $id_status = $this->request->getVar('id_status');

        $data2 = [];
        $uniqRows = [];
        for ($i = 0; $i < count($kode_akun3); $i++) {
            $kode = $kode_akun3[$i] ?? '';
            $debitVal = $debit[$i] ?? '';
            $kreditVal = $kredit[$i] ?? '';
            $statusVal = $id_status[$i] ?? '';

            // Skip jika semua field kosong
            if (empty($kode) && empty($debitVal) && empty($kreditVal) && empty($statusVal)) {
                continue;
            }

            // Buat signature untuk deteksi duplikasi
            $signature = implode('|', [$kode, $debitVal, $kreditVal, $statusVal]);
            if (isset($uniqRows[$signature])) {
                continue; // Skip duplikat
            }
            $uniqRows[$signature] = true;

            $data2[] = [
                'id_penyesuaian' => $id_penyesuaian,
                'kode_akun3' => $kode,
                'debit' => $debitVal === '' ? 0 : $debitVal,
                'kredit' => $kreditVal === '' ? 0 : $kreditVal,
                'id_status' => $statusVal
            ];
        }
        
        if (!empty($data2)) {
            $this->objNilaiPenyesuaian->insertBatch($data2);
        }
        return redirect()->to(site_url('penyesuaian'))->with('success', 'Data Berhasil di Simpan');
    }

    /**
     * Return the editable properties of a resource object.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function edit($id = null)
    {
        $penyesuaian = $this->objPenyesuaian->find($id);
        $akun3 = $this->objAkun3->findAll();
        $status = $this->objStatus->findAll();
        $nilai = $this->objNilaiPenyesuaian->findAll();
        $data['dtnilaipenyesuaian'] =$nilai;

        if(is_object($penyesuaian)) {
            $data['dtakun3'] = $akun3;
            $data['dtstatus'] = $status;
            $data['dtpenyesuaian'] = $penyesuaian;

            return view('penyesuaian/edit', $data);
        } else {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
    }

    /**
     * Add or update a model resource, from "posted" properties.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function update($id = null)
    {
        $data1=[
            'tanggal' => $this->request->getVar('tanggal'),
            'deskripsi' => $this->request->getVar('deskripsi'),
            'nilai' => $this->request->getVar('nilai'),
            'waktu' => $this->request->getVar('waktu'),
            'jumlah' => $this->request->getVar('jumlah'),
        ];
        // simpan data ke tbl_penyesuaian
        $this->db->table('tbl_penyesuaian')->where(['id_penyesuaian' => $id])->update($data1);

        $ids = $this->request->getVar('id');
        $kode_akun3 = $this->request->getVar('kode_akun3');
        $debit = $this->request->getVar('debit');
        $kredit = $this->request->getVar('kredit');
        $id_status = $this->request->getVar('id_status');

        foreach ($ids as $key => $value) {
            $result[]=[
                'id' => $ids[$key],
                'kode_akun3'=> $kode_akun3[$key],
                'debit'=> $debit[$key],
                'kredit'=> $kredit[$key],
                'id_status'=> $id_status[$key],
            ];
        }
        $this->objNilaiPenyesuaian->updateBatch($result, 'id');
        return redirect()->to(site_url('penyesuaian'))->with('success', 'Data Berhasil di Update');
 
    }

    /**
     * Delete the designated resource object from the model.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function delete($id = null)
    {
        $this->objNilaiPenyesuaian->where(['id_penyesuaian' => $id])->delete();
        $this->objPenyesuaian->where(['id_penyesuaian' => $id])->delete();
        return redirect()->to(site_url('penyesuaian'))->with('success', 'Data Berhasil Di Hapus');
    }
}