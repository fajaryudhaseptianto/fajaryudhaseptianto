<?= $this->extend('layout/backend') ?>

<?= $this->Section('content') ?>

<section class="section">
    <div class="section-header">
        <!-- <h6>Blank Page</h6> -->
        <a href="<?= site_url('transaksi') ?>" class="btn btn-primary">Back</a>
    </div>

    <div class="section-body">
        <!-- Dinamis  -->
        <div class="card">
            <div class="card-header">
                <h4>Detail Transaksi</h4>
            </div>
            <div class="card-body p-4">
                <table>
                    <tr>
                        <td>No Kwitansi</td>
                        <td>:</td>
                        <td>
                            <?= $dttransaksi->kwitansi ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Tanggal</td>
                        <td>:</td>
                        <td>
                            <?= $dttransaksi->tanggal ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Deskripsi</td>
                        <td>:</td>
                        <td>
                            <?= $dttransaksi->deskripsi ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Ket Jurnal</td>
                        <td>:</td>
                        <td>
                            <?= $dttransaksi->ketjurnal ?>
                        </td>
                    </tr>
                </table>

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode Akun</th>
                            <th>Nama Akun</th>
                            <th>Debit</th>
                            <th>Kredit</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($dtnilai as $key => $item) : ?>
                            <tr>
                                <td>
                                    <?= $key + 1 ?>
                                </td>
                                <td>
                                    <?= $item->kode_akun3 ?>
                                </td>

                                <td>
                                    <?= $item->nama_akun3 ?>
                                </td>

                                <td class="text-right">
                                    <?= number_format($item->debit, 0, ",", ".") ?>
                                </td>

                                <td class="text-right">
                                    <?= number_format($item->kredit, 0, ",", ".") ?>
                                </td>

                                <td>
                                    <?= $item->status ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>

                    </tbody>
                </table>

            </div>

        </div>
    </div>
    </div>

</section>

<?= $this->endSection(); ?>