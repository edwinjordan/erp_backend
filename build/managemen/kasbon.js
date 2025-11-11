$("#filter_all").click(function () {
    var url= linke+"Kas_bon/get_karyawan_kasbon";
    var id_karyawan=$("#id_karyawan").val();
    if (id_karyawan != "") {
      //console.log(url+"?tgl_1="+tgl_1+"&tgl_2="+tgl_2);
           $('#table').bootstrapTable('refresh', {url: linke+'Kas_bon/get_karyawan_kasbon/' + id_karyawan });
           $.ajax({
                url : linke+"Kas_bon/get_tot_kasbon/"+id_karyawan,
                type: "GET",
                dataType: "JSON",
                success: function(result) {  
                    if(result.kredit==null){
                        var kredit = 0;
                    }else{
                        var kredit = result.kredit;
                    }

                    if(result.debit==null){
                        var debit = 0;
                    }else{
                        var debit = result.debit;
                    }

                    if(result.sisa_hutang==null){
                        var sisa_hutang = 0;
                    }

                    var hutang = 0;

                    hutang = result.debit - result.kredit;

                    $('[name="total_kasbon"]').val(kredit);
                    $('[name="total_terbayar"]').val(debit);
                    // $('[name="total_terbayar"]').val(sisa_hutang);
                    $('[name="hutang"]').val(hutang);

                }, error: function (jqXHR, textStatus, errorThrown) {
                    alert('Error get data from ajax');
                }
            });
      // saldo_asli = 0;
    }else {
      alert('Silahkan Masukkan Karyawan');
    }

 });

$('#jumlah').on('keyup',function(){
    HitungSisa();
})

function HitungSisa() {
    var Jumlah = $('#jumlah').val();
    var Hutang = $('#hutang').val();

    if($('#id_penyesuaian').val()=="tambah_kasbon"){
        var Selisih = parseInt(Jumlah) - parseInt(Hutang) ;
        $('#sisa_hutang').val(Selisih);
    }else{
        var Selisih =  parseInt(Hutang) + parseInt(Jumlah);
        $('#sisa_hutang').val(Selisih);
    }

    //if (parseInt(Jumlah) > parseInt(Hutang)){
      
    // }else{
    //     $('#sisa_hutang').val('0');
    // }
}   

function runningFormatter(value, row, index) {
    return index+1;
}