$(function () {
	    var $result = $('#eventsResult');
	    var $table = $('#table_utama');
	    var $ret=$('#total_semua');
	     $table.bootstrapTable('checkAll');
	    $('#table_utama')
	    // .on('load-success.bs.table', function (e, data) {
	    //      $table.bootstrapTable('checkAll');
	    // })
	    .on('check-all.bs.table', function (e) {
	    	var total =akumulasi_total('table_utama');
	    	$('#total_semua').val(total);
	    	console.log(total);

	    })
	    .on('uncheck-all.bs.table', function (e) {
	        var total =akumulasi_total('table_utama');
	    	$('#total_semua').val(total);
	    })
	    .on('check.bs.table', function (e, row) {
	        var total =akumulasi_total('table_utama');
	    	$('#total_semua').val(total);
	    })
	    .on('uncheck.bs.table', function (e, row) {
	       var total =akumulasi_total('table_utama');
	    	$('#total_semua').val(total);
	    });
});

function akumulasi_total(id) {
		var $table = $('#'+id);
		var select_row_table_utama=$table.bootstrapTable('getSelections');
		var json_select_row_table_utama=JSON.parse(JSON.stringify($table.bootstrapTable('getSelections')));
    	var data_akumulasi=0;
        for (var i = 0; i < json_select_row_table_utama.length; i++) {
			    console.log(json_select_row_table_utama[i]['selisih']);
			    data_akumulasi=data_akumulasi+parseFloat(json_select_row_table_utama[i]['selisih']);
		}
		return data_akumulasi;
}

function disabledstateFormatter(value, row, index) {
		var nama_customer=$("#nama_customer"+mdl).val();
		if (nama_customer=="") {

	        return {
	             disabled: true
	        };
		}else{
			return {
	             disabled: false
	        };
		}
        return value;
}

function runningFormatter(value, row, index) {
    return index+1;
}

function actiontanggal(tanggal){
    	var pecahsatu = tanggal.split(" ");
    	var pecahdua = pecahsatu[0];
    	var pecahtiga = pecahdua.split("-");
    	return pecahtiga[2]+ '-' +pecahtiga[1]+ '-' +pecahtiga[0]+' '+pecahsatu[1];
}

function selisih_kurangin(value, row, index){
		return row.jumlah-row.tanggal + ' Hari';
}

function actionhutang(value, row, index){
    return '<div class="btn-group" role="group" aria-label="..."><a href="#" onclick="confirmbayar(\''+row.no_faktur+'\', '+row.selisih+', '+row.id_pelanggan+')" type="button" class="btn btn-primary"><span aria-hidden="true"></span>Bayar</a><a href="#" onclick="confirmlunasin(\''+row.no_faktur+'\', '+row.selisih+')" type="button" class="btn btn-danger"><span aria-hidden="true"></span>Lunas</a></div>';
}

function kotane_cus(value, row, index){
	return row.alamat + ' , ' + row.kota;
}

function actionpilihcustomer(value, row, index){
	return '<div class="btn-group" role="group" aria-label="..."><a href="#" onclick="pilihantepat(\''+row.id_pelanggan+'\', \''+row.nama+'\')" type="button" class="btn btn-success"><span aria-hidden="true"></span>Pilih</a></div>';
}

function pilihantepat(id, nama){
		var $pembayaran_hutang_tabl = $('#table_utama');
        $pembayaran_hutang_tabl.bootstrapTable('refresh', {
            url: 'Piutang_penjualan/get_utang_penjualan/'+id
        });
        
        var oke = '<button type="submit" class="btn btn-primary" onclick="confirmbayarcustomer()">Bayar</button>';
        var ea = document.getElementById("cek_kode");
		ea.innerHTML= oke;
	        	var okey = '<div class="col-xs-2"><div class="form-group pull-right"><div id="cek_kode"><input type="text" class="form-control" name="total_semua" id="total_semua" value="0" readonly></div></div></div>';
	        	var eay = document.getElementById("tampil_total");
				eay.innerHTML= okey;
		
		document.getElementById('kode_customer'+mdl).value = id;
        document.getElementById('nama_customer'+mdl).value = nama;
        $('#modal-1'+mdl).modal('hide');
}

function confirmbayarcustomer(){

		var $table=$("#table_utama");
		var select_row_table_utama=$table.bootstrapTable('getSelections');
		var json_select_row_table_utama=JSON.parse(JSON.stringify($table.bootstrapTable('getSelections')));
		 
		var as=jQuery.isEmptyObject(select_row_table_utama);
		if (!as) {
			//alert('getSelections: ' + as  +" asu "+json_select_row_table_utama);
			console.log(json_select_row_table_utama);
			var data_akumulasi=0;
			var ty=$("#layout_input_id_penjualan");
			ty.text('');
			for (var i = 0; i < json_select_row_table_utama.length; i++) {
			    console.log(json_select_row_table_utama[i]['pembaran_udah_bayar']);
			    data_akumulasi=data_akumulasi+parseFloat(json_select_row_table_utama[i]['pembaran_udah_bayar']);
			    var t_id_penjualan=json_select_row_table_utama[i]['id_penjualan'];
			    ty.append('<input type="text" name="t_id_penjualan[]" value="'+t_id_penjualan+'" />');
			}
			console.log(json_select_row_table_utama);

			console.log("ddasd"+ty);

			document.getElementById('belum_bayar').value = document.getElementById('total_semua').value;
			document.getElementById('no_faktur_pembelian').value = '';
			document.getElementById('kebijakan_pembelian').value = 'bayar';
		//	document.getElementById('kebijakan_pembeliann').value = '';
			document.getElementById('kode_customere').value = document.getElementById('kode_customer').value;

			// var ta = document.getElementById('total_semua').value;
			// var ok = '<input type="text" class="form-control" id="bayar_tagihan" name="bayar_tagihan" value="'+formatpembagi(ta)+'" min="0" max="'+ta+'" autofocus autocomplete="off" onkeyup="harga_muncullahs()">';
			// var ea = document.getElementById("bayar_show");
			// ea.innerHTML= ok;
			// document.getElementById('bayar_show').style.display = "block";

			// var tanpa_pembagi1 = document.getElementById('bayar_tagihan');
			// tanpa_pembagi1.addEventListener('keyup', function(e)
			// {
			// 	tanpa_pembagi1.value = formatpembagi(this.value);
			// });
			var kode = document.getElementById('kode_customere').value;
			var biaya = document.getElementById('total_semua').value;
			$.ajax({
	            url : "<?php echo site_url('Piutang_penjualan/total_return_customer/')?>/" +kode,
	            type: "GET",
	            dataType: "JSON",
	            success: function(dataesopo)
	            {
	            	if(dataesopo==null){
	            		document.getElementById('return_pakai').value = 0;
	            	}else{
	            		var pakai_return = -(dataesopo.bayar_biaya_return);
		            	document.getElementById('return_pakai').value = pakai_return
		            	var z = parseFloat(pakai_return)+parseFloat(biaya);
						document.getElementById('kembalis').value = z.toFixed(2);
	            	}
	            	

	            },
        			error: function (jqXHR, textStatus, errorThrown)
        		{
            		
        		}
    		});

	        $('#pembayaran').modal('show');
	        $('.modal').on('shown.bs.modal', function() {
	          $(this).find('[autofocus]').focus();
	        });
	        harga_muncullahs();
		}else{

		}
			

 }

 function confirmbayar(id, biaya, kode){
		var $pembayaran_hutang_table = $('#pembayaran_hutang_table');
		$pembayaran_hutang_table.bootstrapTable('refresh', {
		    url: 'get_pembayaran_hutang_tampil/'+id
		});
		document.getElementById('belum_bayar').value = biaya;
		document.getElementById('no_faktur_pembelian').value = id;
		document.getElementById('kebijakan_pembelian').value = 'bayar';
		//document.getElementById('kebijakan_pembeliann').value = '';
		document.getElementById('kode_customere').value = '';

		// var ta = -(biaya);
		// var ok = '<input type="text" class="form-control" id="bayar_tagihan" name="bayar_tagihan" value="'+formatpembagi(ta.toString())+'" min="0" max="'+ta+'" autofocus autocomplete="off" onkeyup="harga_muncullahs()">';
		// var ea = document.getElementById("bayar_show");
		// ea.innerHTML= ok;
		// document.getElementById('bayar_show').style.display = "block";

		// var tanpa_pembagi = document.getElementById('bayar_tagihan');
		// 	tanpa_pembagi.addEventListener('keyup', function(e)
		// 	{
		// 		tanpa_pembagi.value = formatpembagi(this.value);
		// 	});
		$.ajax({
	            url : linke+"Piutang_penjualan/total_return_customer/" + kode,
	            type: "GET",
	            dataType: "JSON",
	            success: function(dataesopo)
	            {
	            	if(dataesopo==null){
	            		document.getElementById('return_pakai').value = 0;
	            	}else{
	            		var pakai_return = -(dataesopo.bayar_biaya_return);
		            	document.getElementById('return_pakai').value = pakai_return
		            	var z = parseFloat(pakai_return)+parseFloat(biaya);
						document.getElementById('kembalis').value = z.toFixed(2);
	            	}
	            	

	            },
        			error: function (jqXHR, textStatus, errorThrown)
        		{
            		
        		}
    		});


        $('#pembayaran'+mdl).modal('show');
        $('.modal').on('shown.bs.modal', function() {
          $(this).find('[autofocus]').focus();
        });
        harga_muncullahs();
    }

   function harga_muncullahs(){
		var poli = document.getElementById('belum_bayar').value;
		var ik = document.getElementById('bayar_tagihan').value;
		//var ikk = document.getElementById('bayar_tagihan1').value;
		var ikkkk = document.getElementById('return_pakai').value;
		
		if(ik==""){
			ik=0;
		}
		// if(ikk==""){
		// 	ikk=0;
		// }
		if(ikkkk==""){
			ikkkk=0;
		}
		
		//cari
		
		
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

// 		 = document.getElementsByName('status_pakai');
        var z = 0;
        console.log(keputusan_if);
        console.log(parseFloat(poli));
		if(keputusan_if=="Yes"){
		    z = parseFloat(ikkkk)+parseFloat(ik)+parseFloat(poli);
		    console.log("aa"+z);
		}else{
		     z = parseFloat(ik)+parseFloat(poli);
		     console.log("aa"+z);
		}
		
// 		var z = parseFloat(ik)+parseFloat(ikk)+parseFloat(i);
		//console.log(i+' : '+ik+' : '+z);
		document.getElementById('kembalis').value = z.toFixed(2);

		// var tanpa_pembagi1 = document.getElementById('bayar_tagihan');
		// tanpa_pembagi1.addEventListener('keyup', function(e)
		// {
		// 	tanpa_pembagi1.value = formatpembagi(this.value);
		// });
		// var tanpa_pembagi2 = document.getElementById('bayar_tagihan1');
		// tanpa_pembagi2.addEventListener('keyup', function(e)
		// {
		// 	tanpa_pembagi2.value = formatpembagi(this.value);
		// });
	}

	 function confirmlunasin(id, biaya){
		var $pembayaran_hutang_table = $('#pembayaran_hutang_tablee');
		$pembayaran_hutang_table.bootstrapTable('refresh', {
		    url: 'get_pembayaran_hutang_tampil/'+id
		});
		document.getElementById('belum_bayarr').value = biaya;
		document.getElementById('no_faktur_pembeliann').value = id;
		document.getElementById('kebijakan_pembeliann').value = 'kebijakan';
		document.getElementById('kebijakan_pembelian').value = '';
		document.getElementById('bayar_tagihann').value = biaya;
        $('#lunasin'+mdl).modal('show');
        $('.modal').on('shown.bs.modal', function() {
          $(this).find('[autofocus]').focus();
        });
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