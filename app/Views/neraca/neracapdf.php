<html>

<head>
    <style type="text/css">
        .aturkiri {
            text-align: left;
        }

        .aturkanan {
            text-align: right;
        }

        .aturtengah {
            text-align: center;
        }

        .spesifik {
            font-style: italic;
            word-spacing: 30px;
        }

        .judul {
            font-style: italic;
            font-size: 20px;
        }
    </style>
</head>

<body>

    <p class="judul">Laporan Neraca</p>
    Periode : <?= date('d F Y', strtotime($tglawal)) . "s/d" . date('d F Y', strtotime($tglakhir)) ?>
    <br />
    <br />

    <table class="table table-hover table-striped table-md">

        <!-- AKTIVA -->
        <tr>
            <td>AKTIVA</td>
            <td></td>
            <td></td>
        </tr>
        <?php
        $aktiva_lancar = 0;
        $total_aktiva_lancar = 0;
        $aktiva_tetap = 0;
        $total_aktiva_tetap = 0;
        $total_kewajiban = 0;
        $modal_pemilik = 0;
        ?>

        <!-- Aktiva Lancar -->
        <?php foreach ($dttransaksi as $key => $value) : ?>
            <?php if ($value->kode_akun2 == 11) : ?>
                <?php
                $debit = $value->jumdebit + $value->jumdebits;
                $kredit = $value->jumkredit + $value->jumkredits;
                $aktiva_lancar = $debit - $kredit;
                $total_aktiva_lancar = $total_aktiva_lancar + $aktiva_lancar;
                ?>
                <tr>
                    <td class="text-left" style="padding-left:3em"><?= $value->nama_akun3; ?></td>
                    <td></td>
                    <td class="text-right" style="padding-right:6em"><?= number_format(abs($aktiva_lancar), 0, ",", ","); ?></td>
                </tr>
            <?php endif; ?>
        <?php endforeach; ?>
        <tr>
            <td>AKTIVA LANCAR</td>
            <td></td>
            <td class="text-right"><?= number_format($total_aktiva_lancar, 0, ",", ","); ?></td>
        </tr>

        <!-- Aktiva Tetap -->
        <?php foreach ($dttransaksi as $key => $value) : ?>
            <?php if ($value->kode_akun2 == 12) : ?>
                <?php
                $debit = $value->jumdebit + $value->jumdebits;
                $kredit = $value->jumkredit + $value->jumkredits;
                $aktiva_tetap = $debit - $kredit;
                $total_aktiva_tetap = $total_aktiva_tetap + $aktiva_tetap;
                ?>
                <tr>
                    <td class="text-left" style="padding-left:3em"><?= $value->nama_akun3; ?></td>
                    <td></td>
                    <td class="text-right" style="padding-right:6em"><?= number_format(abs($aktiva_tetap), 0, ",", ","); ?></td>
                </tr>
            <?php endif; ?>
        <?php endforeach; ?>
        <tr>
            <td>AKTIVA TETAP</td>
            <td></td>
            <td class="text-right"><?= number_format($total_aktiva_tetap, 0, ",", ","); ?></td>
        </tr>
        <tr>
            <td>JUMLAH AKTIVA</td>
            <td></td>
            <td class="text-right"><?= number_format($total_aktiva_lancar + $total_aktiva_tetap, 0, ",", ","); ?></td>
        </tr>

        <!-- MODAL DAN KEWAJIBAN -->
        <tr>
            <td>MODAL DAN KEWAJIBAN</td>
            <td></td>
            <td></td>

        </tr>
        <?php foreach ($dttransaksi as $key => $value) : ?>
            <?php if ($value->kode_akun2 == 21) : ?>
                <?php
                $debit = $value->jumdebit + $value->jumdebits;
                $kredit = $value->jumkredit + $value->jumkredits;
                $kewajiban = $debit - $kredit;
                $total_kewajiban = $total_kewajiban + $kewajiban;
                $modal_pemilik = $total_aktiva_lancar + $total_aktiva_tetap + $total_kewajiban
                ?>
                <tr>
                    <td class="text-left" style="padding-left:3em"><?= $value->nama_akun3; ?></td>
                    <td></td>
                    <td class="text-right" style="padding-right:6em"><?= number_format(abs($kewajiban), 0, ",", ","); ?></td>
                </tr>
            <?php endif; ?>
        <?php endforeach; ?>
        <tr>
            <td>TOTAL KEWAJIBAN</td>
            <td></td>
            <td class="text-right"><?= number_format($total_kewajiban, 0, ",", ","); ?></td>
        </tr>
        <tr>
            <td>MODAL</td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td class="text-left" style="padding-left:3em">Perubahan Modal Pemilik</td>
            <td></td>
            <td class="text-right"><?= number_format($modal_pemilik, 0, ",", ","); ?></td>
        </tr>
        <tr>
            <td class="text-left">JUMLAH KEWAJIBAN DAN MODAL</td>
            <td></td>
            <td class="text-right"><?= number_format($modal_pemilik + abs($total_kewajiban), 0, ",", ","); ?></td>
        </tr>
    </table>
</body>

</html>
