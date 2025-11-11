 $(document).ready(function () {
    //Date range picker
        $('#tgl_1').datepicker({
          format: "yyyy-mm-dd",
          autoclose: true
        });
        $('#tgl_2').datepicker({
          format: "yyyy-mm-dd",
          autoclose: true
        });
        // $('#tgl_validasi_input').datetimepicker({
        //   format: "yyyy-mm-dd hh:ii:ss",
        //   autoclose: true,
        //   todayBtn: true
        // });
        });
        
        $("#filter_all").click(function () {
       var tgl_1=$("#tgl_1").val();
       var tgl_2=$("#tgl_2").val();
       if (tgl_1 != "" && tgl_2!="") {
         //console.log(url+"?tgl_1="+tgl_1+"&tgl_2="+tgl_2);
              $('#tabel_order').bootstrapTable('refresh', {url: linke+'penjualan/hasil_validasi_penjualan_keranjang_versi_tgl/' + tgl_1 + '/' + tgl_2});
       }else {
         alert('Silahkan Masukkan Tanggal');
       }

});

  function actionpilihpenjualan(value, row, index){
//    return '<div class="btn-group" role="group" aria-label="..."><a href="#" onclick="nota(\''+row.id_penjualan+'\', \''+row.jumlah_print+'\')"  type="button" class="btn btn-info"><span>'+row.jumlah_print+'. Nota</span></a><a href="#" onclick="nota_gudang(\''+row.id_penjualan+'\', \''+row.print_gudang+'\')"  type="button" class="btn btn-primary"><span aria-hidden="true"></span>'+row.print_gudang+'. Gudang</a><a href="#" onclick="nota_jalan(\''+row.id_penjualan+'\', \''+row.print_jalan+'\')"  type="button" class="btn btn-warning"><span aria-hidden="true"></span>'+row.print_jalan+'. Surat Jalan</a><a href="#" onclick="nota_jalan_jalan(\''+row.id_penjualan+'\', \''+row.print_nota_jalan+'\')"  type="button" class="btn btn-warning"><span aria-hidden="true"></span>'+row.print_nota_jalan+'. Nota Jalan</a><a href="#" onclick="confirdetail(\''+row.id_penjualan+'\', \''+row.kode_customer+'\', \''+row.pembayaran_aktif+'\')"  type="button" class="btn btn-primary"><span aria-hidden="true"></span>Detail Transaksi</a></div>';
        return '<div class="btn-group" role="group" aria-label="..."><a href="#" onclick="nota(\''+row.id_penjualan+'\', \''+row.jumlah_print+'\')"  type="button" class="btn btn-info"><span>'+row.jumlah_print+'. Nota Kecil</span></a> <a href="#" onclick="nota_besar(\''+row.id_penjualan+'\', \''+row.jumlah_print+'\')"  type="button" class="btn btn-danger"><span>'+row.jumlah_print+'. Nota Besar</span></a></div>';
        //<a href="#" type="button" onclick="confirmDelete('+row.id_penjualan+')" class="btn btn-danger"> Delete</a>
  }    

  function runningFormatter(value, row, index) {
    return index+1;
  }

    function nota(id,idn){
//console.log(id);
        $('#area-1').load(linke+'Penjualan/nota_penjualan/'+id, function() {
          printDiv('area-1');
           var $transaksi_supplier = $('#tabel_order');
            $transaksi_supplier.bootstrapTable('refresh', {
                url: 'Penjualan/hasil_validasi_penjualan_keranjang/'
            });
            location.reload();
        });
        
        console.log(id);
    }

  function nota_besar(id,idn){
//console.log(id);
        $('#area-2').load(linke+'Penjualan/nota_besar/'+id, function() {
          printDiv2('area-2');
           var $transaksi_supplier = $('#tabel_order');
            $transaksi_supplier.bootstrapTable('refresh', {
                url: 'Penjualan/hasil_validasi_penjualan_keranjang/'
            });
            location.reload();
        });
        
        console.log(id);
}   

function printDiv(elementId) {
        $('#'+elementId).show();
        var a = document.getElementById('printing-css').value;
        var b = document.getElementById(elementId).innerHTML;
        // window.frames["print_frame"].document.title = document.title;
        window.frames["print_frame"].document.body.innerHTML = '<style>' + a + '</style>' + b;
        window.frames["print_frame"].window.focus();
        window.frames["print_frame"].window.print();

        $('#'+elementId).hide();
} 

function printDiv2(elementId) {
        $('#'+elementId).show();
        var a = document.getElementById('printing-css').value;
        var b = document.getElementById(elementId).innerHTML;
        // window.frames["print_frame"].document.title = document.title;
        window.frames["print_frame"].document.body.innerHTML = '<style>' + a + '</style>' + b;
        window.frames["print_frame"].window.focus();
        window.frames["print_frame"].window.print();

        $('#'+elementId).hide();
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

function rupiaha(harga){
    return to_rupiah(harga);
}   
    