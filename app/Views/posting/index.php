<?= $this->extend('layout/backend') ?>

<?= $this->section('content') ?>
<title>SIA-IPB &mdash; Posting</title>
<?= $this->endSection(); ?>

<?= $this->section('content') ?>

<section class="section">
    <div class="section-header">
        <h1>Laporan Posting</h1>
    </div>

    <div class="section-body">
        <div class="card-body">
            <form action="<?= site_url('posting') ?>" method="POST">
                <?= csrf_field() ?>
                <div class="row">
                    <div class="col">
                        <input type="date" class="form-control" name="tglawal" value="<?= $tglawal ?>">
                    </div>
                    <div class="col">
                        <input type="date" class="form-control" name="tglakhir" value="<?= $tglakhir ?>">
                    </div>
                    <div class="col">
                        <select class="form-control" name="kode_akun3">
                            <option selected> Pilih Kode Akun </option>
                            <?php foreach ($dtakun3 as $key => $value) : ?>
                                <option value="<?=$value->kode_akun3 ?>" <?=$kode_akun3 == $value->kode_akun3 ? 'selected' : null ?>> <?= $value->kode_akun3 ?> | <?= $value->nama_akun3 ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-list"></i> Tampilkan</button>
                        <input type="submit" class="btn btn-success" formtarget="_blank" formaction="posting/postingpdf" value="Cetak PDF" >
                    </div>
                </div>
            </form>
        </div>
        <div class="card-body p-4">
            <div class="table-responsive">
                <table class="table table-striped table-md" >
                    <thead>
                        <tr>
                            <td class="text-center" rowspan="2">Tanggal</td>
                            <td class="text-center" rowspan="2">Keterangan</td>
                            <td class="text-center" rowspan="2">Ref</td>
                            <td class="text-center" rowspan="2">Debit</td>
                            <td class="text-center" rowspan="2">Kredit</td>
                            <td class="text-center" colspan="2">Saldo</td>
                        </tr>
                        <tr>
                            <td>Debit</td>
                            <td>Kredit</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $dbt = 0; 
                        ?>
                        <?php foreach ($dttransaksi as $key => $value) : ?>
                            <?php 
                            if($value->debit)
                            {
                                $dbt = $dbt + $value->debit;
                            } else {
                                $dbt = $dbt - $value->kredit;
                            }

                            $ndbt1 = $dbt >= 0 ? $dbt : 0;
                            $ndbt2 = $dbt <= 0 ? $dbt : 0;

                                ?> 
                            <tr>
                                <td><?= $value->tanggal ?></td>
                                <td><?= $value->kode_akun3 ?></td>
                                <td><?= $value->ketjurnal ?></td>
                                <td class="text-right"><?= number_format($value->debit, 0, ",", ",") ?></td>
                                <td class="text-right"><?= number_format($value->kredit, 0, ",", ",") ?></td>
                                <td class="text-right"><?= number_format($ndbt1, 0, ",", ",") ?></td>
                                <td class="text-right"><?= number_format(abs($ndbt2), 0, ",", ",") ?></td>
                            </tr>

                        <?php endforeach; ?>
                    </tbody>

                </table>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection(); ?>