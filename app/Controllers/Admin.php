<?php

namespace App\Controllers;

use Myth\Auth\Models\UserModel;

class Admin extends BaseController
{
    protected UserModel $users;
    protected $db;

    public function __construct()
    {
        $this->users = new UserModel();
        $this->db = \Config\Database::connect();
    }

    public function index()
    {
        $data['users'] = $this->users->findAll();

        return view('admin/index', $data);
    }

    public function createUser()
    {
        $email = $this->request->getVar('email');
        $password = $this->request->getVar('password');
        $username = $this->request->getVar('username') ?: $email;

        // Validasi
        if (empty($email) || empty($password)) {
            return redirect()->to(site_url('admin'))->with('error', 'Email dan password harus diisi');
        }

        // Cek apakah email sudah ada
        $existingUser = $this->users->where('email', $email)->first();
        if ($existingUser) {
            return redirect()->to(site_url('admin'))->with('error', 'Email sudah terdaftar');
        }

        // Buat user baru (non-admin)
        $userData = [
            'email' => $email,
            'username' => $username,
            'password_hash' => password_hash($password, PASSWORD_DEFAULT),
            'active' => 1,
        ];

        try {
            $userId = $this->users->insert($userData);
            
            if ($userId) {
                return redirect()->to(site_url('admin'))->with('success', 'User berhasil ditambahkan');
            } else {
                return redirect()->to(site_url('admin'))->with('error', 'Gagal menambahkan user');
            }
        } catch (\Exception $e) {
            return redirect()->to(site_url('admin'))->with('error', 'Error: ' . $e->getMessage());
        }
    }

    /**
     * Membersihkan data duplikat di tbl_nilai dan tbl_nilaipenyesuaian
     * Hanya menyisakan satu record per kombinasi unik
     */
    public function cleanDuplicates()
    {
        try {
            $this->db->transStart();

            // Bersihkan duplikat di tbl_nilai
            $this->cleanNilaiDuplicates();
            
            // Bersihkan duplikat di tbl_nilaipenyesuaian
            $this->cleanNilaiPenyesuaianDuplicates();

            $this->db->transComplete();

            if ($this->db->transStatus() === false) {
                return redirect()->to(site_url('admin'))->with('error', 'Gagal membersihkan duplikat: ' . $this->db->error()['message']);
            }

            return redirect()->to(site_url('admin'))->with('success', 'Data duplikat berhasil dibersihkan!');
        } catch (\Exception $e) {
            return redirect()->to(site_url('admin'))->with('error', 'Error: ' . $e->getMessage());
        }
    }

    /**
     * Membersihkan duplikat di tbl_nilai
     */
    private function cleanNilaiDuplicates()
    {
        // Cari semua data duplikat berdasarkan kombinasi id_transaksi, kode_akun3, debit, kredit, id_status
        // Hapus semua kecuali yang memiliki id_nilai terkecil
        $query = $this->db->query("
            DELETE n1 FROM tbl_nilai n1
            INNER JOIN tbl_nilai n2 
            WHERE n1.id_nilai > n2.id_nilai 
            AND n1.id_transaksi = n2.id_transaksi 
            AND n1.kode_akun3 = n2.kode_akun3 
            AND n1.debit = n2.debit 
            AND n1.kredit = n2.kredit 
            AND n1.id_status = n2.id_status
        ");

        return $this->db->affectedRows();
    }

    /**
     * Membersihkan duplikat di tbl_nilaipenyesuaian
     */
    private function cleanNilaiPenyesuaianDuplicates()
    {
        // Cari semua data duplikat berdasarkan kombinasi id_penyesuaian, kode_akun3, debit, kredit, id_status
        // Hapus semua kecuali yang memiliki id terkecil
        $query = $this->db->query("
            DELETE n1 FROM tbl_nilaipenyesuaian n1
            INNER JOIN tbl_nilaipenyesuaian n2 
            WHERE n1.id > n2.id 
            AND n1.id_penyesuaian = n2.id_penyesuaian 
            AND n1.kode_akun3 = n2.kode_akun3 
            AND n1.debit = n2.debit 
            AND n1.kredit = n2.kredit 
            AND n1.id_status = n2.id_status
        ");

        return $this->db->affectedRows();
    }
}

