

<?= $this->extend('layout/backend') ?>

<?= $this->section('content') ?>

<section class="section">
    <div class="section-header">
        <h1>Manajemen Pengguna</h1>
    </div>

    <div class="section-body">
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
    </div>
</section>

<?= $this->endSection() ?>

