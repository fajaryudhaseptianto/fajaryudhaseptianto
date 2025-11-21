<?= $this->extend('layout/backend') ?>


<?= $this->section('content') ?>

<section class="section">
    <div class="section-header">
        <!-- <h1>Blank Page</h1> -->
        <a href="<?= site_url('akun2') ?>" class="btn btn-primary"> Back</a>
    </div>

    <div class="section-body"
        <!-- dinamis -->
        <div class="card">
            <div class="card-header">
                <h4>Edit Data Akun 2</h4>
            </div>
            <div class="card-body p-4">

                <form method="post" action="<?= site_url('akun2/' . $dtakun2->id_akun2) ?>">
                    <?= csrf_field() ?>
                    <input type="hidden" name="_method" value="PUT">

                    <div class="form-group">
                        <label>Kode Akun 1</label>
                        <select class="form-control" name="kode_akun1">
                            <?php foreach ($dtakun1 as $key => $value) : ?>
                                <option value="<?= $value->kode_akun1 ?>" <?= $dtakun2->kode_akun1 == $value->kode_akun1 ? 'selected' : null ?>><?= $value->nama_akun1 ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Kode Akun 2</label>
                        <input type="text" class="form-control" name="kode_akun2" placeholder="Kode Akun" required value="<?= $dtakun2->kode_akun2 ?>">
                    </div>
                    <div class="form-group">
                        <label>Nama Akun 2</label>
                        <input type="text" class="form-control" name="nama_akun2" placeholder="Nama Akun" required value="<?= $dtakun2->nama_akun2 ?>">
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-success"> <i class="fas fa-paper-plane"></i> Update</button>
                        <button type="reset" class="btn btn-secondary"> Reset</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</section>

<?= $this->endSection() ?>