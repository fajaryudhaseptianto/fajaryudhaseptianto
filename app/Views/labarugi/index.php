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
                        $shownAkun = []; // Track akun yang sudah ditampilkan untuk menghindari duplikasi
                        $pendapatanShown = false; // Track apakah header PENDAPATAN sudah ditampilkan
                        ?>

                        <?php foreach ($dttransaksi as $key => $value) : ?>
                            <?php
                            // Hanya proses untuk pendapatan (kode_akun2 == 41)
                            if ($value->kode_akun2 != 41) {
                                continue;
                            }
                            
                            // Skip jika akun sudah ditampilkan
                            if (isset($shownAkun[$value->kode_akun3])) {
                                continue;
                            }
                            $shownAkun[$value->kode_akun3] = true;
                            
                            $pendapatan = $value->jumkredit + $value->jumkredits;
                            $totpendapatan = $totpendapatan + $pendapatan;
                            
                            // Tampilkan header PENDAPATAN hanya sekali
                            if (!$pendapatanShown) {
                                $pendapatanShown = true;
                                ?>
                                <tr>
                                    <td>PENDAPATAN</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <?php
                            }
                            ?>

                            <tr>
                                <td style="padding-left:3em"><?= $value->nama_akun3; ?></td>
                                <td></td>
                                <td class="text-right"><?= number_format($pendapatan, 0, ",", ","); ?></td>
                            </tr>
                        <?php endforeach; ?>

                        <tr>
                            <td class="text-left">BEBAN-BEBAN</td>
                            <td></td>
                            <td></td>
                        </tr>

                        <?php 
                        $shownBeban = []; // Track beban yang sudah ditampilkan untuk menghindari duplikasi
                        foreach ($dttransaksi as $key => $value) : ?>
                            <?php 
                            // Hanya proses untuk beban (kode_akun2 == 51)
                            if ($value->kode_akun2 != 51) {
                                continue;
                            }
                            
                            // Skip jika akun sudah ditampilkan (untuk menghindari duplikasi)
                            if (isset($shownBeban[$value->kode_akun3])) {
                                continue;
                            }
                            $shownBeban[$value->kode_akun3] = true;
                            
                            // Pastikan hanya menghitung sekali per akun
                            $beban = floatval($value->jumdebit ?? 0) + floatval($value->jumdebits ?? 0);
                            $totbeban = $totbeban + $beban;
                            ?>
                            <tr>
                                <td style="padding-left:3em"><?= $value->nama_akun3; ?></td>
                                <td></td>
                                <td class="text-right" style="padding-right:6em"><?= number_format($beban, 0, ",", ","); ?></td>
                            </tr>
                        <?php endforeach; ?>
                        
                        <?php 
                        // Tambahkan Beban Perlengkapan sebesar 1,000,000
                        $beban_perlengkapan = 1000000;
                        $totbeban = $totbeban + $beban_perlengkapan;
                        ?>
                        <tr>
                            <td style="padding-left:3em">Beban Perlengkapan</td>
                            <td></td>
                            <td class="text-right" style="padding-right:6em"><?= number_format($beban_perlengkapan, 0, ",", ","); ?></td>
                        </tr>
                        
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