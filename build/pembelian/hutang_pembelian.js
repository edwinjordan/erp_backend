$(document).ready(function () {
    //Date range picker
        $('#tgl_faktur_bg').datepicker({
          format: "dd-mm-yyyy",
          autoclose: true,
          todayBtn: true,
          todayBtn: true
        });
});
		
function disabledstateFormatter(value, row, index) {
		var nama_customer=$("#nama_supplier"+mdl).val();
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

function actionhutang(value, row, index){
    return '<div class="btn-group" role="group" aria-label="..."><a href="#" onclick="confirmbayar(\''+row.no_faktur+'\', '+row.selisih+',\''+row.id_supplier+'\')" type="button" class="btn btn-primary"><span aria-hidden="true"></span>Bayar</a><!--<a href="#" onclick="confirmlunasin(\''+row.no_faktur+'\', '+row.biaya_pembayaran+')" type="button" class="btn btn-primary"><span aria-hidden="true"></span>Lunasin</a>--></div>';
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

function rupiaha(biaya){
	return to_rupiah(biaya);
}
function confirmbayar(id, biaya, kode_supplier){
		var $pembayaran_hutang_table = $('#pembayaran_hutang_table');
		$pembayaran_hutang_table.bootstrapTable('refresh', {
		    url: 'Hutang/get_pembayaran_hutang_tampil/'+id
		});
		document.getElementById('belum_bayar').value = biaya;
		document.getElementById('no_faktur_pembelian').value = id;
		document.getElementById('kebijakan_pembelian').value = 'bayar';
		//document.getElementById('kebijakan_pembeliann').value = '';
		document.getElementById('kode_suppliere').value = kode_supplier;
		var ta = -(biaya);
		var ok = '<input type="text" class="form-control" id="bayar_tagihan" name="bayar_tagihan" value="'+ta+'" min="0" MAX="'+ta+'" autofocus autocomplete="off">';

		 $.ajax({
	            url : linke+"Hutang/total_return_supplier/" + kode_supplier,
	            type: "GET",
	            dataType: "JSON",
	            success: function(dataesopo)
	            {
					if(dataesopo==null){
	            		document.getElementById('return_pakai').value = 0;
	            	}else{
	            	var pakai_return = -(dataesopo.bayar_return);
	            	document.getElementById('return_pakai').value = pakai_return
	            	var z = parseFloat(pakai_return)+parseFloat(biaya);
					document.getElementById('kembalis').value = z.toFixed(2);
					}

	            },
        			error: function (jqXHR, textStatus, errorThrown)
        		{
            		
        		}
    		});


		 //var ea = document.getElementById("bayar_show");
		  //ea.innerHTML= ok;
		//document.getElementById('bayar_tagihan').value = formatpembagi(ta.toString());
		//$('#bayar_tagihan').attr('max',ta);
		 // document.getElementById('bayar_show').style.display = "block";
        $('#pembayaran'+mdl).modal('show');
        $('.modal').on('shown.bs.modal', function() {
          $(this).find('[autofocus]').focus();
        });
}

function harga_muncullahs(){
		var poli = document.getElementById('belum_bayar').value;
		var ik = document.getElementById('bayars').value;
		//var ikk = document.getElementById('bayars2').value;
		var ikkk = document.getElementById('potongan').value;
		var ikkkk = document.getElementById('return_pakai').value;
		
		if(ik==""){
			ik=0;
		}
		// if(ikk==""){
		// 	ikk=0;
		// }
		if(ikkk==""){
			ikkk=0;
		}
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
		    z = parseFloat(ikkkk)+parseFloat(ikkk)+parseFloat(ik)+parseFloat(poli);
		}else{
		    z = parseFloat(ikkk)+parseFloat(ik)+parseFloat(poli);
		}

		
		
		 // z = parseFloat(ikkk)+parseFloat(ik)+parseFloat(poli);

		// var x = parseFloat(ikkk);
		// console.log(parseFloat(ikkk));
		// var y = i;
		// var z = x+y;
		//console.log(poli+' : '+ik+' : '+ikk+' : '+ikkk+' : '+z);

		document.getElementById('kembalis').value = z.toFixed(2);
		//document.getElementById('kembalis').value = formatpembagi(z.toString());

		// var tanpa_pembagi1 = document.getElementById('bayars');
		// tanpa_pembagi1.addEventListener('keyup', function(e)
		// {
		// 	tanpa_pembagi1.value = formatpembagi(this.value);
		// });
		// var tanpa_pembagi2 = document.getElementById('potongan');
		// tanpa_pembagi2.addEventListener('keyup', function(e)
		// {
		// 	tanpa_pembagi2.value = formatpembagi(this.value);
		// });
	}

	function getwarna(value){
		// var datee = new Date();
		// var month = datee.getUTCMonth() + 1; //months from 1-12
		// var day = datee.getUTCDate();
		// var year = datee.getUTCFullYear();

		// var newdate = year + "-" + month + "-" + day;
		// console.log('newdate'+newdate);
		if(value < datene){
			return "<button type='button' class='btn btn-danger waves-effect waves-light'>"+value+"</button>";
		}else{
			return "<button type='button' class='btn btn-success waves-effect waves-light'>"+value+"</button>";
		}
		
	}
