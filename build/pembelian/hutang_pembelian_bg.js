function runningFormatter(value, row, index) {
    return index+1;
}

function actionhutang(value, row, index){
    return '<div class="btn-group" role="group" aria-label="..."><a href="#" onclick="faktur_bg_detail(\''+row.kode_supplier+'\',\''+row.id_supplier+'\')" type="button" class="btn btn-primary"><span aria-hidden="true"></span>Faktur</a></div>';
}

function faktur_bg_detail(value, kode){
    var $table_hutang_detail_bg = $('#table_hutang_detail_bg');
    $table_hutang_detail_bg.bootstrapTable('refresh', {
        url: 'Hutang/get_hutang_tampil_bg_detail/'+value
    });
    document.getElementById('kode_suppliere_bg').value = kode;
    $('#detail_faktur_bg').modal('show');
}

$(function () {
    var $result = $('#eventsResult');
    var $table = $('#table_hutang_detail_bg');
    var $ret=$('#total_semua');
     $table.bootstrapTable('checkAll');
    $('#table_hutang_detail_bg')
    .on('load-success.bs.table', function (e, data) {
         $table.bootstrapTable('checkAll');
    })
    .on('check-all.bs.table', function (e) {
        var total =akumulasi_total('table_hutang_detail_bg');
       // console.log('');
        $('#total_semua_bayar').val(total);
        console.log('total'+total);

    })
    .on('uncheck-all.bs.table', function (e) {
        var total =akumulasi_total('table_hutang_detail_bg');
        $('#total_semua_bayar').val(total);
        console.log('total'+total);
    })
    .on('check.bs.table', function (e, row) {
        var total =akumulasi_total('table_hutang_detail_bg');
        $('#total_semua_bayar').val(total);
        console.log('total'+total);
    })
    .on('uncheck.bs.table', function (e, row) {
       var total =akumulasi_total('table_hutang_detail_bg');
        $('#total_semua_bayar').val(total);
        console.log('total'+total);
    });
});

function akumulasi_total(id) {
    var $table = $('#'+id);
    var select_row_table_utama=$table.bootstrapTable('getSelections');
    var json_select_row_table_utama=JSON.parse(JSON.stringify($table.bootstrapTable('getSelections')));
    var data_akumulasi=0;
    for (var i = 0; i < json_select_row_table_utama.length; i++) {
            console.log(json_select_row_table_utama[i]['selisih']);
            data_akumulasi=data_akumulasi+Math.abs(json_select_row_table_utama[i]['selisih']);
    }
    console.log(data_akumulasi);
    return -(data_akumulasi);
}

function supplierbro(value, row, index){
    return row.nama+' , '+row.kota;
}

function confirmbayarbg(){
    var $table=$("#table_hutang_detail_bg");
    var select_row_table_utama=$table.bootstrapTable('getSelections');
    var json_select_row_table_utama=JSON.parse(JSON.stringify($table.bootstrapTable('getSelections')));
     
    var as=jQuery.isEmptyObject(select_row_table_utama);
    if (!as) {
        //alert('getSelections: ' + as  +" asu "+json_select_row_table_utama);
        console.log(json_select_row_table_utama);
        var data_akumulasi=0;
        var ty=$("#layout_input_bg_id_penjualan");
        ty.text('');
        for (var i = 0; i < json_select_row_table_utama.length; i++) {
            console.log(json_select_row_table_utama[i]['selisih']);
            data_akumulasi=parseFloat(data_akumulasi)+parseFloat(json_select_row_table_utama[i]['selisih']);
            var t_id_penjualan=json_select_row_table_utama[i]['no_faktur'];
            ty.append('<input type="text" name="t_id_penjualan[]" value="'+t_id_penjualan+'" />');
        }
        console.log(json_select_row_table_utama);

        console.log("ddasd"+ty);

        document.getElementById('belum_bayar_bg').value = document.getElementById('total_semua_bayar').value;
        document.getElementById('no_faktur_pembelian').value = '';
        document.getElementById('kebijakan_pembelian').value = 'bayar';
        //document.getElementById('kebijakan_pembeliann').value = '';

        $.ajax({
            url : linke+"Hutang/total_return_supplier/" + document.getElementById('kode_suppliere_bg').value,
            type: "GET",
            dataType: "JSON",
            success: function(dataesopo)
            {
                var pakai_return = -(dataesopo.bayar_return);
                document.getElementById('return_pakai').value = pakai_return;
                var z = parseFloat(data_akumulasi)+parseFloat(pakai_return);
                console.log(parseFloat(pakai_return)+' + '+parseFloat(data_akumulasi)+' = '+z)
                document.getElementById('kembalis_bg').value = z.toFixed(2);

            },
                error: function (jqXHR, textStatus, errorThrown)
            {
                document.getElementById('return_pakai').value = 0;
            }
        });

        $('#pembayaran_faktur_bg').modal('show');
        $('.modal').on('shown.bs.modal', function() {
          $(this).find('[autofocus]').focus();
        });
    }else{

    }
}

function harga_bg(){
    var poli = document.getElementById('belum_bayar_bg').value;
    var ik = document.getElementById('bayars_bg').value;
    //var ikk = document.getElementById('bayars2_bg').value;
    var ikkk = document.getElementById('return_pakai').value;
    if(ik==""){
        ik=0;
    }
    // if(ikk==""){
    //     ikk=0;
    // }
    if(ikkk==""){
        ikkk=0;
    }
    
    var radios = document.getElementsByName('status_pakai');
    var keputusan_if = "";
    for (var i = 0, length = radios.length; i < length; i++) {
        if (radios[i].checked) {
            // do whatever you want with the checked radio
            keputusan_if = radios[i].value;
    
            // only one radio can be logically checked, don't check the rest
            break;
        }
    }
    
    var z = 0;
    console.log(keputusan_if);
    console.log(parseFloat(poli));
    if(keputusan_if=="Yes"){
        console.log('komisi '+keputusan_if);
      //  ikkk= 10;
        z = parseFloat(ikkk)+parseFloat(ik)+parseFloat(poli);
    }else{
        z = parseFloat(ik)+parseFloat(poli);
    }
    
// 		var z = parseFloat(ik)+parseFloat(ikk)+parseFloat(ikkk)+parseFloat(i);
    
    console.log(i+' : '+ik+' : '+z);
    document.getElementById('kembalis_bg').value = z.toFixed(2);

    // var tanpa_pembagi1 = document.getElementById('bayars_bg');
    // tanpa_pembagi1.addEventListener('keyup', function(e)
    // {
    // 	tanpa_pembagi1.value = formatpembagi(this.value);
    // });
}
