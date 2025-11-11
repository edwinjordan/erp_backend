$(document).ready(function () {
  //Date range picker
      $('#tgl_1').datepicker({
        format: "dd-mm-yyyy",
        autoclose: true
      });
      $('#tgl_2').datepicker({
        format: "dd-mm-yyyy",
        autoclose: true
      });
});

$('#bayar').keyup(function(){
    HitungKembalian();
  })

$('#UangDebit').keyup(function(){
    HitungKembalianDebit();
  })

function runningFormatter(value, row, index) {
   return index+1;
}

$("#filter_all").click(function () {
       var url=linke+"Penjualan_po/get_list_po/";
       var tgl_1=$("#tgl_1").val();
       var tgl_2=$("#tgl_2").val();
       if (tgl_1 != "" && tgl_2!="") {
         //console.log(url+"?tgl_1="+tgl_1+"&tgl_2="+tgl_2);
              $('#table').bootstrapTable('refresh', {url: linke+'Penjualan_po/get_list_po/' + tgl_1 + '/' + tgl_2});
              saldo_asli = 0;
       }else {
         alert('Silahkan Masukkan Tanggal');
       }

});

function actiondetail(id){
      return '<div class="btn-group" role="group" aria-label="..."><a href="Po_penjualan/nota/'+id+'" class="btn btn-primary"><span aria-hidden="true"></span>Detail Penawaran Penjualan</a></div>';
}

function detailnya(no_faktur){
    var $pembayaran_hutang_table = $('#pembayaran_hutang_table');
    $pembayaran_hutang_table.bootstrapTable('refresh', {
        url: 'Penjualan_po/get_po_detail_tampil/'+no_faktur
    });
 //   document.getElementById('no_faktur').value = no_faktur;
    $('[name="nopo"]').val(no_faktur);
    $('#detail_transaksi').modal('show');
  //  console.log('Total');
    $.getJSON(linke+'Penjualan_po/get_total/'+no_faktur, {
        format: "json"
    })
    .done(function (datae) {
            $.each(datae, function (key, val) {
                // if(kode==val.id_lokasi){
                //     okeylokasi += '<option value="' + val.id_lokasi + '" selected >' + val.nama_lokasi + '</option>';
                // }else{
                //     okeylokasi += '<option value="' + val.id_lokasi + '" >' + val.nama_lokasi + '</option>';
                // }
                console.log('Total'+val.grand_total);
               $('#totalBayar').val(val.grand_total);                 
    		});
    })
}  

function inputqty(value, row, index){
    return '<input type="hidden" name="id_barange[]" value="'+row.id_barang+'" class="form-control"><input type="text" name="qty[]" id="qty" value="'+row.qty+'" class="qty form-control" readonly>';
}

function inputharga_beli(value, row, index){
  return '<input type="text" name="ambil_get_barang[]" id="ambil_get_barang" class="ambil_get_barang form-control" value="'+row.harga_jual+'" readonly><input type="hidden" id="ambil_get_kode" name="ambil_get_kode">';
}

function inputsubtotal(value, row, index){
  return '<input type="text" name="subtotal[]" id="subtotal" value="'+row.total_harga+'" class="form-control" readonly>';
}

function barangdet(value, row, index){
    return ''+row.nama_barang+'-'+row.satuan+'-'+row.warna+'';
}

function HitungKembalian() {
    var Cash = $('#bayar').val();
    
    if ($('#UangDebit').val()=='') {
      var Debit = 0;
    }else{
      var Debit = $('#UangDebit').val();
    }
    var TotalBayar = $('#totalBayar').val();
    var Metode = $('#metode_pembayaran').val();
    console.log("metode"+Metode);
      var Jadi = (parseInt(Cash) + parseInt(Debit));
      if (parseInt(Jadi) > parseInt(TotalBayar)){

        var Selisih =  parseInt(Cash) - parseInt(TotalBayar);
        $('#UangKembali').val(to_rupiah(Selisih));

      }else{
        $('UangKembali').val('');
      }
    
    
}

function HitungKembalianDebit() {
    
    var Debit = $('#UangDebit').val();
    if ($('#bayar').val()=='') {
      var Cash = 0;
    }else{
      var Cash = $('#bayar').val();
    }
    var TotalBayar = $('#totalBayar').val();
    var Metode = $('#metode_pembayaran').val();
    console.log("metode"+Metode);
    
    var Jadi = (parseInt(Cash) + parseInt(Debit));
    if (parseInt(Jadi) > parseInt(TotalBayar)){
      var Selisih = (parseInt(Cash) + parseInt(Debit))  - parseInt(TotalBayar);
      $('#UangKembali').val(to_rupiah(Selisih));
    }else{
      $('UangKembali').val('');
    } 

      
    
    
  }

  function to_rupiah(angka){
    var rev     = parseInt(angka, 10).toString().split('').reverse().join('');
    var rev2    = '';
    for(var i = 0; i < rev.length; i++){
      rev2  += rev[i];
      if((i + 1) % 3 === 0 && i !== (rev.length - 1)){
        rev2 += '.';
      }
    }
    return 'Rp. ' + rev2.split('').reverse().join('');
  }


