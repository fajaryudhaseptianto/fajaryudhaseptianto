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
                
                $pendapatan  = floatval($value->jumkredit ?? 0) + floatval($value->jumkredits ?? 0);
                $totpendapatan  = $totpendapatan + $pendapatan;
                
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
                    <td class="aturkanan" style="padding-right:6em"><?= number_format($pendapatan, 0, ",", ","); ?></td>
                </tr>
            <?php endforeach; ?>

            <tr>
                <td class="aturkiri">BEBAN-BEBAN</td>
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
                    <td class="aturkanan" style="padding-right:6em"><?= number_format($beban, 0, ",", ","); ?></td>
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
                <td class="aturkanan" style="padding-right:6em"><?= number_format($beban_perlengkapan, 0, ",", ","); ?></td>
            </tr>
            
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
