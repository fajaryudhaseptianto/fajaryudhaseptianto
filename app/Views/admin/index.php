

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

<?= $this->endSection() ?>

