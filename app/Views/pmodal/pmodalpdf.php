<html>

<head>
    <style type="text/css">
        /* Mengatur teks rata kiri */
        .aturkiri {
            text-align: left;
        }

        /* Mengatur teks rata kanan */
        .aturkanan {
            text-align: right;
            padding-right: 1em;
        }

        /* Mengatur teks rata tengah */
        .aturtengah {
            text-align: center;
        }

        /* Menambahkan gaya italic pada spesifik */
        .spesifik {
            font-style: italic;
            word-spacing: 30px;
        }

        /* Mengatur tampilan judul */
        .judul {
            font-style: italic;
            font-size: 20px;
            text-align: center;
        }

        /* Menambah posisi di bawah untuk footer */
        .footer {
            position: relative;
            margin-top: 50px;
            text-align: center;
        }

        /* Tambahkan jarak antara Pimpinan dan Alinggar untuk ttd */
        .ttd {
            margin-bottom: 100px;
        }

        /* Mengatur tanggal menjadi rata tengah */
        .tanggal {
            text-align: center;
            margin: 0;
        }

        /* Mengatur tabel menjadi lebar 80% untuk tidak terlalu ke kanan */
        .table {
            width: 90%;
            margin-left: auto;
            margin-right: auto;
            border-collapse: collapse;
        }

        .table th,
        .table td {
            border: 1px solid black;
            padding: 8px;
        }

        /* Angka dalam kolom kanan diatur rata kanan */
        .table td.aturkanan {
            text-align: right;
            padding-right: 1em;
        }

        /* Padding untuk teks dalam konten tabel */
        .tabel-konten {
            padding-left: 1em;
        }
    </style>

</head>

<body>
    <p class="judul">Laporan Perubahan Modal</p>
    <p class="aturtengah">PERUSAHAAN AKN-ALINGGAR AGLI NUGROHO</p>
    <p class="aturtengah">Periode : <?= date('d F Y', strtotime($tglawal)) . " s/d " . date('d F Y', strtotime($tglakhir)) ?></p>

    <br>

    <table class="table">
        <thead>
        </thead>
        <tbody>
            <tr>
                <td class="aturkiri"><strong>Modal Awal</strong></td>
                <td class="aturkanan"><strong><?= number_format($dttransaksi['modal_awal'], 0, ",", ","); ?></strong></td>
            </tr>
            <tr>
                <td class="aturkiri" style="padding-left:4em">Laba/Rugi Bersih</td>
                <td class="aturkanan" style="padding-right:7em"><?= number_format($dttransaksi['labarugi'], 0, ",", ","); ?></td>
            </tr>
            <tr>
                <td class="aturkiri" style="padding-left:4em">Prive</td>
                <td class="aturkanan" style="padding-right:7em"><?= number_format($dttransaksi['prive'], 0, ",", ","); ?></td>
            </tr>
            <tr>
                <td class="aturkiri">Penambahan Modal</td>
                <td class="aturkanan"><?= number_format($dttransaksi['penambahan_modal'], 0, ",", ","); ?></td>
            </tr>
            <tr>
                <td class="aturkiri"><strong>Modal Akhir</strong></td>
                <td class="aturkanan"><strong><?= number_format($dttransaksi['modal_akhir'], 0, ",", ","); ?></strong></td>
            </tr>
        </tbody>
    </table>

    <br>

    <div class="footer">
        <p class="tanggal">
            <?php
            $tgl = date('l, d-m-y');
            echo $tgl;
            ?> </body>

</html> 
