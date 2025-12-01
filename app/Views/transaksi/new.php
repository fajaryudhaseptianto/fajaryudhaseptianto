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
                <h4>Tambah Data Transaksi</h4>
            </div>
            <div class="card-body p-4">
                <form method="post" action="<?= site_url('transaksi') ?>">
                    <?= csrf_field() ?>
                    <!-- <div class="form-group"> -->
                    <!-- <label>Kwitansi</label> -->
                    <!-- <input type="text" class="form-control" name='kwitansi' placeholder="Kwitansi" required> -->
                    <!-- </div> -->
                    <div class="form-group">
                        <label>Tanggal</label>
                        <input type="date" class="form-control" name='tanggal' placeholder="Tanggal" required>
                    </div>
                    <div class="form-group">
                        <label>Deskripsi</label>
                        <input type="text" class="form-control" name='deskripsi' placeholder="Deskripsi" required>
                    </div>
                    <div class="form-group">
                        <label>Ketjurnal</label>
                        <input type="text" class="form-control" name='ketjurnal' placeholder="Ket Jurnal" required>
                    </div>
                    <div class="box-body">
                        <table class="table table-bordered" id="tableLoop">
                            <thead>
                                <tr>
                                    <th style="color: #ffffff !important; background: linear-gradient(135deg, #007bff 0%, #0056b3 100%) !important; font-weight: 700 !important;">No</th>
                                    <th style="color: #ffffff !important; background: linear-gradient(135deg, #007bff 0%, #0056b3 100%) !important; font-weight: 700 !important;">Kode Akun</th>
                                    <th style="color: #ffffff !important; background: linear-gradient(135deg, #007bff 0%, #0056b3 100%) !important; font-weight: 700 !important;">Debit</th>
                                    <th style="color: #ffffff !important; background: linear-gradient(135deg, #007bff 0%, #0056b3 100%) !important; font-weight: 700 !important;">Kredit</th>
                                    <th style="color: #ffffff !important; background: linear-gradient(135deg, #007bff 0%, #0056b3 100%) !important; font-weight: 700 !important;">Status</th>
                                    <th style="color: #ffffff !important; background: linear-gradient(135deg, #007bff 0%, #0056b3 100%) !important; font-weight: 700 !important;">
                                        <button class=" btn btn-primary btn-sm btn-block" id="Barisbaru"><i class="fa fa-plus"></i> Add Baris</button>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <!--disini form dinamis dibuat dgn Jquery -->
                            </tbody>
                        </table>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-success"><i class="fas fa-paper-plane"></i> Save</button>
                        <button type="reset" class="btn btn-secondary"> Reset</button>
                    </div>
                </form>
            </div>
            <!-- <div class="card-footer text-right">
                <nav class="d-inline-block">
                    <ul class="pagination mb-0">
                        <li class="page-item disabled">
                            <a class="page-link" href="#" tabindex="-1"><i class="fas fa-chevron-left"></i></a>
                        </li>
                        <li class="page-item active"><a class="page-link" href="#">1 <span class="sr-only">(current)</span></a></li>
                        <li class="page-item">
                            <a class="page-link" href="#">2</a>
                        </li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item">
                            <a class="page-link" href="#"><i class="fas fa-chevron-right"></i></a>
                        </li>
                    </ul>
                </nav>
            </div> -->
        </div>
    </div>

</section>

<?= $this->endSection(); ?>