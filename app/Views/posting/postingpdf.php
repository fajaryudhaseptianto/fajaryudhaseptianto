<html>

<head>
    <style type="text/css">
        .aturangka {
            text-align: right;
        }

        .judul {
            font-style: italic;
            font-size: 20px;
        }

        .aturkiri {
            text-align: left;
        }

        .aturtengah {
            text-align: center;
        }

    </style>
</head>
    
<body>
    <p class="judul"> Posting</p>
    Periode : <?=date('d F Y', strtotime($tglawal)) . "s/d" . date('d F Y', strtotime($tglakhir)) ?>
    <br />
    <br />

    <table border="0.1px" class="table tab-bordered" >
        <thead>
            <tr>
                <td class="text-center" rowspan="2" width="45px">Tanggal</td>
                <td class="text-center" rowspan="2" width="50px">Keterangan</td>
                <td class="text-center" rowspan="2" width="200px">Ref</td>
                <td class="text-center" rowspan="2" width="50px">Debit</td>
                <td class="text-center" rowspan="2" width="50px">Kredit</td>
                <td class="text-center" colspan="2" width="50px">Saldo</td>
            </tr>
            <tr>
                <td class="text-center" width="50px">Debit</td>
                <td class="text-center" width="50px">Kredit</td>
            </tr>
                </thead>
                <tbody>
                    <?php
                    $dbt = 0; 
                    ?>
                    <?php foreach ($dttransaksi as $key => $value) : ?>
                        <?php 
                        if($value->debit)
                        {
                            $dbt = $dbt + $value->debit;
                        } else {
                            $dbt = $dbt - $value->kredit;
                        }

                        $ndbt1 = $dbt >= 0 ? $dbt : 0;
                        $ndbt2 = $dbt <= 0 ? $dbt : 0;

                            ?> 
                        <tr>
                            <td class="aturtengah" width="45px"><?= $value->tanggal ?></td>
                            <td class="aturtengah" width="50px"><?= $value->kode_akun3 ?></td>
                            <td class="aturkiri" width="200px"><?= $value->ketjurnal ?></td>
                            <td class="aturangka" width="50px"><?= number_format($value->debit, 0, ",", ",") ?></td>
                            <td class="aturangka" width="50px"><?= number_format($value->kredit, 0, ",", ",") ?></td>
                            <td class="aturangka" width="50px"><?= number_format($ndbt1, 0, ",", ",") ?></td>
                            <td class="aturangka" width="50px"><?= number_format(abs($ndbt2), 0, ",", ",") ?></td>
                        </tr>

                    <?php endforeach; ?>
                </tbody>
            </table>
        </body>
</html>