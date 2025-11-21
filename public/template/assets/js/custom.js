/**
 *
 * You can write your JS code here, DO NOT touch the default style file
 * because it will make it harder for you to update.
 *
 */

"use strict";

// confirmasi delete 
function hapus(id) {
    $('#del-'+id).submit()
};

// menu dinamis
var path = location.pathname.split('/')
var url = location.origin + '/' + path[1]
$('ul.sidebar-menu li a').each(function () {
    if ($(this).attr('href').indexOf(url) !== -1) {
        $(this).parent().addClass('active').parent().parent('li').addClass('active')
    }
});

// datatables dan pagination
$(document).ready(function () {
    $('#myTable').DataTable();
});

$(document).ready(function () {
    $('#repotTable').DataTable({
        "searching": false,
        "paging": false,
        "ordering":false,
    });
});


// input transaksi
function Barisbaru() {
    $(document).ready(function() {
        $("[data-toggle='tooltip']").tooltip();
    });
    var Nomor = $("#tableLoop tbody tr").length + 1;
    var Baris = '<tr>';
        Baris += '<td class="text-center">' + Nomor + '</td>';
        Baris += '<td>';
        Baris += '<select class="form-control" name="kode_akun3[]" id="kode_akun3' + Nomor + '" required> </select>';
        Baris += '</td>';
        Baris += '<td>';
        Baris += '<input type="number" name="debit[]" class="form-control debit" placeholder="Debit..." required="">';
        Baris += '</td>';
        Baris += '<td>';
        Baris += '<input type="number" name="kredit[]" class="form-control kredit" placeholder="Kredit..." required="">';
        Baris += '</td>';
        Baris += '<td>';
        Baris += '<select class="form-control" name="id_status[]" id="id_status' + Nomor + '" required> </select>';
        Baris += '</td>';
        Baris += '<td class="text-center">';
        Baris += '<a class="btn btn-sm btn-warning" title="Hapus Baris" id="HapusBaris"><i class="fas fa-times"></i> </a>';
        Baris += '</td>';
        Baris += '</tr>';

        $("#tableLoop tbody").append(Baris);
        $("#tableLoop tbody tr").each(function() {
            $(this).find('td:nth-child(2) input').focus();
        });

    FormSelectAkun(Nomor);
    FormSelectStatus(Nomor);
}

$(document).ready(function () {
    var A;
    for (A = 1; A <= 1; A++) {
        Barisbaru();
    }
    $('#Barisbaru').click(function(e) {
        e.preventDefault();
        Barisbaru();
    });
    $("tableLoop tbody").find('input[type=text]').filter(':visible:first').focus();
});

$(document).on('click', '#HapusBaris', function(e) {
    e.preventDefault();
    var Nomor = 1;
    $(this).parent().parent().remove();
    $('tableLoop tbody tr').each(function() {
        $(this).find('td:nth-child(1)').html(Nomor);
        Nomor++;
    });
});

function FormSelectAkun(Nomor) {
    var output = [];
    output.push('<option value="">Pilih Data</option>');
    // ambil datanya disini
        $.getJSON('/Transaksi/akun3', function(data) {
            $.each(data, function(key, value) {
                output.push('<option value="' + value.kode_akun3 + '">' + value.kode_akun3 + ' | ' + value.nama_akun3 + '</option>');
            });
        $('#kode_akun3' + Nomor).html(output.join(''));
    });
}
        
function FormSelectStatus(Nomor) {
    var output = [];
    output.push('<option value="">Pilih Data</option>');
    // ambil datanya disini
        $.getJSON('/Transaksi/status', function(data) {
            $.each(data, function(key, value) {
                output.push('<option value="' + value.id_status + '">' + value.status + '</option>');
            });
            $('#id_status' + Nomor).html(output.join(''));
        });
}

function hitung() {
    var nilai = $('input[name="nilai"]').val();
    var waktu = $('input[name="waktu"]').val();

    var jumlah = parseInt(nilai) / parseInt(waktu);
    $('input[name="jumlah"]').val(jumlah);
    
    // $("#jumlah").attr("value", jumlah);
    // if (!isNaN()) {
    //         $('input[name="jumlah"]').val(hasil);   
    //     } else {
    //         $('input[name="jumlah"]').val(0);   
    // }
}

    

// $(".penyesuaian").keyup(function() {
//     var nilai = parseInt($("#nilai").val())
//     var waktu = parseInt($("#waktu").val())
//     var jumlah = nilai / waktu;
//     $("#jumlah").attr("value", jumlah)
// });