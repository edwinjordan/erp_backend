function runningFormatter(value, row, index) {
        return index+1;
}

var saldo_asli=0;
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
});
$("#filter_all").click(function () {
       var url=linke+"Laporan/get_pengeluaran_harian/";
       var tgl_1=$("#tgl_1").val();
       var tgl_2=$("#tgl_2").val();
       if (tgl_1 != "" && tgl_2!="") {
         //console.log(url+"?tgl_1="+tgl_1+"&tgl_2="+tgl_2);
              $('#table').bootstrapTable('refresh', {url: linke+'Laporan/get_pengeluaran_harian/' + tgl_1 + '/' + tgl_2});
              saldo_asli = 0;
       }else {
         alert('Silahkan Masukkan Tanggal');
       }

});

   function nota_jalan(){
        var tgl_1=$("#tgl_1").val();
        var tgl_2=$("#tgl_2").val();
     //   console.log('penjualan/print_rugi_laba_salesman/'+tgl_1+'/'+tgl_2);
        $('#area-1').load(linke+'Laporan/print_pengeluaran_harian/'+tgl_1+'/'+tgl_2, function() {
          printDiv('area-1');
           /*var $transaksi_supplier = $('#tabel_order');
            $transaksi_supplier.bootstrapTable('refresh', {
                url: 'hasil_validasi_penjualan_keranjang/'
            });*/
        });
        
        //console.log(id);
    }

    function printDiv(elementId) {
        $('#'+elementId).show();
        var a = document.getElementById('printing-css').value;
        var b = document.getElementById(elementId).innerHTML;
        window.frames["print_frame"].document.title = document.title;
        window.frames["print_frame"].document.body.innerHTML = '<style>' + a + '</style>' + b;
        window.frames["print_frame"].window.focus();
        window.frames["print_frame"].window.print();

        $('#'+elementId).hide();
    }