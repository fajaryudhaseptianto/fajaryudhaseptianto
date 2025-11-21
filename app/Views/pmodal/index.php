<?= $this->extend('layout/backend') ?>


<?= $this->section('content') ?>
<title>SIA-IPB &mdash; Perubahan Modal</title>
<?= $this->endSection(); ?>

<?= $this->section('content') ?>

<section class="section">
    <div class="section-header">
        <h1>Perubahan Modal</h1>
    </div>

    <div class="section-body">
        <div class="card-body">
            <form action="<?= site_url('pmodal') ?>" method="Post">
                <?= csrf_field() ?>
                <div class="row g-3">
                    <div class="col">
                        <input type="date" class="form-control" name="tglawal" value="<?= $tglawal ?>">
                    </div>
                    <div class="col">
                        <input type="date" class="form-control" name="tglakhir" value="<?= $tglakhir ?>">
                    </div>
                    <div class="col">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-list"></i> Tampilkan</button>
                        <input type="submit" class="btn btn-primary" formtarget="_blank" formaction="pmodal/pmodalpdf" value="Cetak PDF">
                    </div>
                </div>
            </form>
        </div>
        <div class="card-body p-4">
            <div class="table-responsive">
                <table class="table table-hover table-striped table-md">
                    <thead>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="text-left">Modal Awal</td>
                            <td></td>
                            <td class="text-right"><?= number_format($dttransaksi['modal_awal'], 0, ",", ","); ?></td>
                        </tr>
                        <tr>
                            <td class="text-left" style="padding-left:3em">Laba/Rugi Bersih</td>
                            <td></td>
                            <td class="text-right" style="padding-right:6em"><?= number_format($dttransaksi['laba_rugi'], 0, ",", ","); ?></td>
                        </tr>
                        <tr>
                            <td class="text-left" style="padding-left:3em">Prive</td>
                            <td></td>
                            <td class="text-right" style="padding-right:6em"><?= number_format($dttransaksi['prive'], 0, ",", ","); ?></td>
                        </tr>
                        <tr>
                            <td class="text-left">Penambahan Modal</td>
                            <td></td>
                            <td class="text-right"><?= number_format($dttransaksi['penambahan_modal'], 0, ",", ","); ?></td>
                        </tr>
                        <tr>
                            <td class="text-left">Modal Akhir</td>
                            <td></td>
                            <td class="text-right"><?= number_format($dttransaksi['modal_akhir'], 0, ",", ","); ?></td>
                        </tr>
                    </tbody>
                    <tfoot>
                    </tfoot>

                </table>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection(); ?>