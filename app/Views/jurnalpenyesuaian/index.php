<?= $this->extend('layout/backend') ?>

<?= $this->section('content') ?>
<title>SIA-IPB &mdash; Jurnal Penyesuaian</title>
<?= $this->endSection(); ?>

<?= $this->section('content') ?>

<section class="section">
    <div class="section-header">
        <h1>Laporan Jurnal Penyesuaian</h1>
    </div>

    <div class="section-body">
        <div class="card-body">
            <form action="<?= site_url('jurnalpenyesuaian') ?>" method="POST">
                <?= csrf_field() ?>
                <div class="row">
                    <div class="col">
                        <input type="date" class="form-control" name="tglawal" value="<?= $tglawal ?>">
                    </div>
                    <div class="col">
                        <input type="date" class="form-control" name="tglakhir" value="<?= $tglakhir ?>">
                    </div>

                    <div class="col">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-list"></i> Tampilkan</button>
                        <input type="submit" class="btn btn-success" formtarget="_blank" formaction="jurnalpenyesuaian/cetak_jppdf" value="Cetak PDF" >
                    </div>
                </div>
            </form>
        </div>
        <div class="card-body p-4">
            <div class="table-responsive">
                <table class="table table-striped table-md" >
                    <thead class="judul">
                        <tr>
                            <td class="text-center" rowspan="2">Kode</td>
                            <td class="text-center" rowspan="2">Keterangan</td>
                            <td class="text-center" colspan="2">Jurnal Penyesuaian</td>
                        </tr>
                        <tr>
                            <td class="text-center">Debit</td>
                            <td class="text-center">Kredit</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $td = 0;
                        $tk = 0;
                        $processedAkun = []; // Track akun yang sudah diproses untuk menghindari duplikasi
                        ?>
                        <?php foreach ($dttransaksi as $key => $value) : ?>
                            <?php
                            // Skip jika akun sudah diproses (untuk menghindari duplikasi)
                            if (isset($processedAkun[$value->kode_akun3])) {
                                continue;
                            }
                            
                            // Tandai akun sebagai sudah diproses
                            $processedAkun[$value->kode_akun3] = true;
                            
                            $d = floatval($value->jumdebit ?? 0);
                            $k = floatval($value->jumkredit ?? 0);
                            
                            // Untuk jurnal penyesuaian, tampilkan debit dan kredit secara terpisah
                            // Jika debit > kredit, tampilkan selisih di kolom debit
                            // Jika kredit > debit, tampilkan selisih di kolom kredit
                            $neraca = $d - $k;

                            if($neraca < 0){
                                $kreditnew = abs($neraca);
                                $debitnew = 0;
                                $tk = $tk + $kreditnew;
                            } else if($neraca > 0){
                                $debitnew = $neraca;
                                $kreditnew = 0;
                                $td = $td + $debitnew;
                            } else {
                                // Jika balance, tidak tampilkan
                                $debitnew = 0;
                                $kreditnew = 0;
                            }

                            // Hanya tampilkan jika ada nilai debit atau kredit
                            if($debitnew > 0 || $kreditnew > 0) :
                            ?>

                            <tr>
                                <td><?= $value->kode_akun3 ?></td>
                                <td><?= $value->nama_akun3 ?></td>
                                <td class="text-right"><?= number_format($debitnew, 0, ",", ".") ?></td>
                                <td class="text-right"><?= number_format($kreditnew, 0, ",", ".") ?></td>
                            </tr>

                            <?php endif; ?>
                        <?php endforeach; ?>
                    </tbody>

                    <tfoot class="judul">
                        <tr>
                            <td class="text-center"></td>
                            <td class="text-center"></td>
                            <td class="text-right"><?= number_format($td, 0, ",", ".") ?></td>
                            <td class="text-right"><?= number_format($tk, 0, ",", ".") ?></td>
                        </tr>
                    </tfoot>

                </table>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection(); ?>