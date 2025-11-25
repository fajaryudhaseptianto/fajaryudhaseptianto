

<?= $this->extend('layout/backend') ?>

<?= $this->section('content') ?>

<section class="section">
    <div class="section-header">
        <h1>Manajemen Pengguna</h1>
    </div>

    <div class="section-body">
        <?php if (session()->getFlashdata('success')) : ?>
            <div class="alert alert-success alert-dismissible show fade">
                <div class="alert-body">
                    <button class="close" data-dismiss="alert">
                        <span>&times;</span>
                    </button>
                    <?= session()->getFlashdata('success') ?>
                </div>
            </div>
        <?php endif; ?>
        
        <?php if (session()->getFlashdata('error')) : ?>
            <div class="alert alert-danger alert-dismissible show fade">
                <div class="alert-body">
                    <button class="close" data-dismiss="alert">
                        <span>&times;</span>
                    </button>
                    <?= session()->getFlashdata('error') ?>
                </div>
            </div>
        <?php endif; ?>

        <div class="card">
            <div class="card-header">
                <h4>Daftar Pengguna</h4>
                <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#addUserModal">
                    <i class="fas fa-plus"></i> Tambah User
                </a>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (! empty($users)) : ?>
                            <?php foreach ($users as $index => $user) : ?>
                                <tr>
                                    <td><?= $index + 1 ?></td>
                                    <td><?= esc($user->username ?? '-') ?></td>
                                    <td><?= esc($user->email ?? '-') ?></td>
                                    <td><?= $user->active ? 'Aktif' : 'Nonaktif' ?></td>
                                </tr>
                            <?php endforeach ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="4" class="text-center">Belum ada pengguna.</td>
                            </tr>
                        <?php endif ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-header">
                <h4>Pembersihan Data</h4>
            </div>
            <div class="card-body">
                <p class="text-muted">Hapus data duplikat di tabel transaksi dan penyesuaian untuk memperbaiki balance jurnal.</p>
                <form action="<?= site_url('admin/clean-duplicates') ?>" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin membersihkan data duplikat? Pastikan sudah backup database terlebih dahulu!');">
                    <?= csrf_field() ?>
                    <button type="submit" class="btn btn-warning">
                        <i class="fas fa-broom"></i> Bersihkan Data Duplikat
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>

<!-- Modal Tambah User -->
<div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addUserModalLabel">Tambah User Baru</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= site_url('admin/create-user') ?>" method="POST">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" class="form-control" name="email" required placeholder="contoh@email.com">
                    </div>
                    <div class="form-group">
                        <label>Username (Opsional)</label>
                        <input type="text" class="form-control" name="username" placeholder="Kosongkan untuk menggunakan email">
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" class="form-control" name="password" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

