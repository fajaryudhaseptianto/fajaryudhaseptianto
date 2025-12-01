<?php

namespace App\Controllers;

use Myth\Auth\Models\UserModel;
use Myth\Auth\Models\GroupModel;

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

    /**
     * Membersihkan duplikasi akun (akun1, akun2, akun3)
     * Menghapus duplikat berdasarkan kode_akun yang sama
     */
    public function cleanDuplicateAkun()
    {
        try {
            $this->db->transStart();

            $results = [
                'akun1' => $this->cleanAkun1Duplicates(),
                'akun2' => $this->cleanAkun2Duplicates(),
                'akun3' => $this->cleanAkun3Duplicates(),
            ];

            $this->db->transComplete();

            if ($this->db->transStatus() === false) {
                return redirect()->to(site_url('admin'))->with('error', 'Gagal membersihkan duplikat akun: ' . $this->db->error()['message']);
            }

            $message = sprintf(
                'Duplikasi akun berhasil dibersihkan! Akun1: %d, Akun2: %d, Akun3: %d',
                $results['akun1'],
                $results['akun2'],
                $results['akun3']
            );

            return redirect()->to(site_url('admin'))->with('success', $message);
        } catch (\Exception $e) {
            return redirect()->to(site_url('admin'))->with('error', 'Error: ' . $e->getMessage());
        }
    }

    /**
     * Membersihkan duplikat di akun1s berdasarkan kode_akun1
     * Menyisakan record dengan id_akun1 terkecil
     * Update referensi di akun2s dan akun3s jika diperlukan
     */
    private function cleanAkun1Duplicates()
    {
        // Cari duplikat berdasarkan kode_akun1
        $duplicates = $this->db->query("
            SELECT kode_akun1, COUNT(*) as count, GROUP_CONCAT(id_akun1 ORDER BY id_akun1) as ids
            FROM akun1s
            GROUP BY kode_akun1
            HAVING count > 1
        ")->getResult();

        $deleted = 0;

        foreach ($duplicates as $dup) {
            $ids = explode(',', $dup->ids);
            // Simpan ID pertama (terkecil), hapus yang lain
            $keepId = array_shift($ids);
            
            // Update referensi dan hapus duplikat
            foreach ($ids as $idToDelete) {
                // Update referensi di akun2s ke id yang disimpan
                $this->db->table('akun2s')
                    ->where('kode_akun1', $idToDelete)
                    ->update(['kode_akun1' => $keepId]);
                
                // Update referensi di akun3s ke id yang disimpan
                $this->db->table('akun3s')
                    ->where('kode_akun1', $idToDelete)
                    ->update(['kode_akun1' => $keepId]);
                
                // Hapus duplikat setelah update referensi
                $this->db->table('akun1s')->where('id_akun1', $idToDelete)->delete();
                $deleted++;
            }
        }

        return $deleted;
    }

    /**
     * Membersihkan duplikat di akun2s berdasarkan kode_akun2
     * Menyisakan record dengan id_akun2 terkecil
     * Update referensi di akun3s jika diperlukan
     */
    private function cleanAkun2Duplicates()
    {
        // Cari duplikat berdasarkan kode_akun2
        $duplicates = $this->db->query("
            SELECT kode_akun2, COUNT(*) as count, GROUP_CONCAT(id_akun2 ORDER BY id_akun2) as ids
            FROM akun2s
            GROUP BY kode_akun2
            HAVING count > 1
        ")->getResult();

        $deleted = 0;

        foreach ($duplicates as $dup) {
            $ids = explode(',', $dup->ids);
            // Simpan ID pertama (terkecil), hapus yang lain
            $keepId = array_shift($ids);
            
            // Update referensi dan hapus duplikat
            foreach ($ids as $idToDelete) {
                // Update referensi di akun3s ke id yang disimpan
                $this->db->table('akun3s')
                    ->where('kode_akun2', $idToDelete)
                    ->update(['kode_akun2' => $keepId]);
                
                // Hapus duplikat setelah update referensi
                $this->db->table('akun2s')->where('id_akun2', $idToDelete)->delete();
                $deleted++;
            }
        }

        return $deleted;
    }

    /**
     * Membersihkan duplikat di akun3s berdasarkan kode_akun3
     * Menyisakan record dengan id_akun3 terkecil
     * AMAN: Karena tbl_nilai dan tbl_nilaipenyesuaian menggunakan kode_akun3 (bukan id_akun3),
     * kita bisa menghapus duplikat dengan aman
     */
    private function cleanAkun3Duplicates()
    {
        // Cari duplikat berdasarkan kode_akun3
        $duplicates = $this->db->query("
            SELECT kode_akun3, COUNT(*) as count, GROUP_CONCAT(id_akun3 ORDER BY id_akun3) as ids
            FROM akun3s
            GROUP BY kode_akun3
            HAVING count > 1
        ")->getResult();

        $deleted = 0;

        foreach ($duplicates as $dup) {
            $ids = explode(',', $dup->ids);
            // Simpan ID pertama (terkecil), hapus yang lain
            $keepId = array_shift($ids);
            
            // Hapus semua duplikat karena kode_akun3 digunakan sebagai referensi
            // bukan id_akun3, jadi aman untuk dihapus
            foreach ($ids as $idToDelete) {
                $this->db->table('akun3s')->where('id_akun3', $idToDelete)->delete();
                $deleted++;
            }
        }

        return $deleted;
    }

    /**
     * Menampilkan laporan duplikasi akun
     */
    public function checkDuplicateAkun()
    {
        $data = [
            'duplicates_akun1' => $this->getAkun1Duplicates(),
            'duplicates_akun2' => $this->getAkun2Duplicates(),
            'duplicates_akun3' => $this->getAkun3Duplicates(),
        ];

        return view('admin/check_duplicate_akun', $data);
    }

    private function getAkun1Duplicates()
    {
        return $this->db->query("
            SELECT kode_akun1, COUNT(*) as count, GROUP_CONCAT(id_akun1 ORDER BY id_akun1) as ids,
                   GROUP_CONCAT(nama_akun1 SEPARATOR ' | ') as names
            FROM akun1s
            GROUP BY kode_akun1
            HAVING count > 1
        ")->getResult();
    }

    private function getAkun2Duplicates()
    {
        return $this->db->query("
            SELECT kode_akun2, COUNT(*) as count, GROUP_CONCAT(id_akun2 ORDER BY id_akun2) as ids,
                   GROUP_CONCAT(nama_akun2 SEPARATOR ' | ') as names
            FROM akun2s
            GROUP BY kode_akun2
            HAVING count > 1
        ")->getResult();
    }

    private function getAkun3Duplicates()
    {
        return $this->db->query("
            SELECT kode_akun3, COUNT(*) as count, GROUP_CONCAT(id_akun3 ORDER BY id_akun3) as ids,
                   GROUP_CONCAT(nama_akun3 SEPARATOR ' | ') as names
            FROM akun3s
            GROUP BY kode_akun3
            HAVING count > 1
        ")->getResult();
    }

    /**
     * Assign role admin ke user yang sedang login
     * Route ini TIDAK dilindungi filter role:admin untuk memudahkan setup awal
     */
    public function assignAdminRole()
    {
        // Cek apakah user sudah login
        if (!auth()->loggedIn()) {
            return redirect()->to(site_url('login'))->with('error', 'Silakan login terlebih dahulu');
        }

        $userId = auth()->id();
        $groupModel = new GroupModel();
        
        // Cek apakah role admin sudah ada (id = 3 berdasarkan hasil query sebelumnya)
        $adminGroup = $groupModel->where('name', 'admin')->first();
        if (!$adminGroup) {
            return redirect()->to(site_url('/'))->with('error', 'Role admin tidak ditemukan di database');
        }

        // Cek apakah user sudah memiliki role admin
        $userGroups = $groupModel->getGroupsForUser($userId);
        $hasAdminRole = false;
        foreach ($userGroups as $group) {
            if ($group->name === 'admin') {
                $hasAdminRole = true;
                break;
            }
        }

        if ($hasAdminRole) {
            return redirect()->to(site_url('/'))->with('info', 'Anda sudah memiliki role admin');
        }

        // Assign role admin ke user
        try {
            $groupModel->addUserToGroup($userId, $adminGroup->id);
            return redirect()->to(site_url('/'))->with('success', 'Role admin berhasil diberikan! Sekarang Anda bisa mengakses halaman admin di /admin');
        } catch (\Exception $e) {
            return redirect()->to(site_url('/'))->with('error', 'Gagal memberikan role admin: ' . $e->getMessage());
        }
    }
}

