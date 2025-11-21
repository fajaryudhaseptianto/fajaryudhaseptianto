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
            form-style: italic;
            word-spacing: 30px;
        }

        .judul{
            font-style: italic;
            font-size: 20px;
        }
    </style>
</head>
    
<body>

<p class="judul"> Jurnal Umum</p>
Periode : <?=date('d F Y', strtotime($tglawal)) . "s/d" . date('d F Y', strtotime($tglakhir)) ?>
<br />
<br />

    <table border="0.1px" class="table tab-bordered" >
        <thead>
            <tr>
                <td class="aturtengah" width="50">Tanggal</td>
                <td class="aturtengah" width="150">Keterangan</td>
                <td class="aturtengah" width="50">Ref</td>
                <td class="aturtengah">Debit</td>
                <td class="aturtengah">Kredit</td>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($dttransaksi as $key => $value) : ?>
                <tr>
                    <td class="aturtengah" width="50"><?= $value->tanggal ?></td>
                    <?php 
                    if($value->debit <> 0 ) { ?>
                        <td class="aturkiri" width="150"><?= $value->nama_akun3 ?></td>
                    <?php 
                    } else { ?>
                        <td class="spesifik"><?= " " . $value->nama_akun3 ?></td>
                    <?php } ?>

                    <td class="aturtengah" width="50"><?= $value->kode_akun3 ?></td>
                    <td class="aturkanan"><?= number_format($value->debit, 0, ",", ",") ?></td>
                    <td class="aturkanan"><?= number_format($value->kredit, 0, ",", ",") ?></td>
                </tr>

            <?php endforeach; ?>
        </tbody>

    </table>

    <br />
    <?php 
    $tgl = date('l, d-m-y');
    echo $tgl;
    ?>
    <br/>
    <br/>
    PIMPINAN AKN 
    ____
</body>

</html>