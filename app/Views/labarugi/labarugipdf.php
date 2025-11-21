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
    <p class="judul"> Laba Rugi</p>
    Periode : <?= date('d F Y', strtotime($tglawal)) . "s/d" . date('d F Y', strtotime($tglakhir)) ?>
    <br />
    <br />

    <table border="0.1px" class="table-striped table-hover table-md">
        <tbody>
            <?php
            $pendapatan  = 0;
            $totpendapatan  = 0;
            $beban = 0;
            $totbeban = 0;

            ?>
            <?php foreach ($dttransaksi as $key => $value) : ?>
                <?php
                $pendapatan  = $value->jumkredit + $value->jumkredits;
                $totpendapatan  = $totpendapatan + $pendapatan;
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
                        <td class="aturkanan" style="padding-right:6em"><?= number_format($pendapatan, 0, ",", ","); ?></td>
                    </tr>
                <?php endif; ?>
            <?php endforeach; ?>

            <tr>
                <td class="aturkiri">BEBAN-BEBAN</td>
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
                        <td class="aturkanan" style="padding-right:6em"><?= number_format($beban, 0, ",", ","); ?></td>
                    </tr>
                <?php endif; ?>
            <?php endforeach; ?>
            <tr>
                <td class="aturkiri">TOTAL BEBAN</td>
                <td></td>
                <td class="aturkanan"><?= number_format($totbeban, 0, ",", ","); ?></td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <td class="aturkiri">LABA RUGI</td>
                <td></td>
                <td class="aturkanan"><?= number_format(($totpendapatan - $totbeban), 0, ",", ","); ?></td>
            </tr>
        </tfoot>
    </table>

</body>

</html>
