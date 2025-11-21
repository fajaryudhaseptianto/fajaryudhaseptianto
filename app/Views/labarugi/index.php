<?= $this->extend('layout/backend') ?>


<?= $this->section('content') ?>
<title>SIA-IPB &mdash; Laba Rugi</title>
<?= $this->endSection(); ?>

<?= $this->section('content') ?>

<section class="section">
    <div class="section-header">
        <h1>Laba Rugi</h1>
    </div>

    <div class="section-body">
        <div class="card-body">
            <form action="<?= site_url('labarugi') ?>" method="Post">
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
                        <input type="submit" class="btn btn-primary" formtarget="_blank" formaction="labarugi/labarugipdf" value="Cetak PDF">
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
                        <?php
                        $pendapatan = 0;
                        $totpendapatan = 0;
                        $totbeban = 0;
                        $beban = 0;

                        ?>

                        <?php foreach ($dttransaksi as $key => $value) : ?>
                            <?php
                            $pendapatan = $value->jumkredit + $value->jumkredits;
                            $totpendapatan = $totpendapatan + $pendapatan;
                            ?>

                            <?php if ($value->kode_akun2 == 41) : ?>
                                <tr>
                                    <td>PENDAPATAN</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td style="padding-left:3em"><?= $value->nama_akun3; ?></td>
                                    <td></td>
                                    <td class="text-right"><?= number_format($pendapatan, 0, ",", ","); ?></td>
                                </tr>
                            <?php endif; ?>
                        <?php endforeach; ?>

                        <tr>
                            <td class="text-left">BEBAN-BEBAN</td>
                            <td></td>
                            <td></td>
                        </tr>

                        <?php foreach ($dttransaksi as $key => $value) : ?>
                            <?php if ($value->kode_akun2 == 51) : ?>
                                <?php
                                $beban = $value->jumdebit + $value->jumdebits;
                                $totbeban = $totbeban + $beban;
                                ?>
                                <tr>
                                    <td style="padding-left:3em"><?= $value->nama_akun3; ?></td>
                                    <td></td>
                                    <td class="text-right" style="padding-right:6em"><?= number_format($beban, 0, ",", ","); ?></td>
                                </tr>
                            <?php endif; ?>
                        <?php endforeach; ?>
                        <tr>
                            <td class="text-left">TOTAL BEBAN</td>
                            <td></td>
                            <td class="text-right"><?= number_format($totbeban, 0, ",", ","); ?></td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td class="text-left">LABA RUGI</td>
                            <td></td>
                            <td class="text-right"><?= number_format(($totpendapatan - $totbeban), 0, ",", ","); ?></td>
                        </tr>
                    </tfoot>

                </table>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection(); ?>