<?= $this->extend('layout/backend') ?>


<?= $this->section('content') ?>

<section class="section">
    <div class="section-header">
        <!-- <h1>Blank Page</h1> -->
        <a href="<?= site_url('akun3') ?>" class="btn btn-primary"> Back</a>
    </div>

    <div class="section-body"
        <!-- dinamis -->
        <div class="card">
            <div class="card-header">
                <h4>Edit Data Akun 3</h4>
            </div>
            <div class="card-body p-4">

                <form method="post" action="<?= site_url('akun3/' . $dtakun3->id_akun3) ?>">
                    <?= csrf_field() ?>
                    <input type="hidden" name="_method" value="PUT">

                    <div class="form-group">
                        <label>Kode Akun 1</label>
                        <select class="form-control" name="kode_akun1">
                            <?php foreach ($dtakun1 as $key => $value) : ?>
                                <option value="<?= $value->kode_akun1 ?>" <?= $dtakun3->kode_akun1 == $value->kode_akun1 ? 'selected' : null ?>><?= $value->nama_akun1 ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Kode Akun 2</label>
                        <select class="form-control" name="kode_akun2">
                            <?php foreach ($dtakun2 as $key => $value) : ?>
                                <option value="<?= $value->kode_akun2 ?>" <?= $dtakun3->kode_akun2 == $value->kode_akun2 ? 'selected' : null ?>><?= $value->nama_akun2 ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Kode Akun 3</label>
                        <input type="text" class="form-control" name="kode_akun3" placeholder="Kode Akun 3" required value="<?= $dtakun3->kode_akun3 ?>">
                    </div>
                    <div class="form-group">
                        <label>Nama Akun 3</label>
                        <input type="text" class="form-control" name="nama_akun3" placeholder="Nama Akun 3" required value="<?= $dtakun3->nama_akun3 ?>">
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