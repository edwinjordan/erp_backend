var save_method;
var link = "<?php echo site_url('Pembelian_bpb')?>";
var table;

function swal_berhasil() { swal({ title:"SUCCESS", text:"Berhasil", type: "success", closeOnConfirm: true}); }
function swal_error(msg) { swal({ title:"ERROR", text: msg, type: "warning", closeOnConfirm: true});  }

$('#id_supplier').change(function(){ // get id pelanggan
    const id = $(this).val();

    $.ajax({
        url: linke+"Pesanan_pembelian/ajax_supplier",  
        data : {id :id},
        dataType: 'json',
        method : 'POST',
        success : function(json)
        {
            //kd_plgn = json.kode_pelanggan;
            $('#alamat_supplier').html(json.alamat);
            $('#telp_supplier').html(json.telp);
            // $('#info_tambahan_pelanggan').html(json.info_tambahan);
        }
    });
    //changeUser();
});

let dataBarang;
$(document).ready(function(){
	getDataBarang();
	BarisBaru();

	$( 'html, body' ).animate( { scrollTop: 0 }, 0 );
});

// fitur button
$('#BarisBaru').on('click',function(){
	BarisBaru();
});
$(document).on('click','#HapusBaris',function(e){
	e.preventDefault();
	if($(this).parent().parent().find("#pencarian_kode").val() == ""){
		$(this).parent().parent().remove();
		var Nomor = 1;
		$('#tableTransaksi tbody tr').each(function(){
			$(this).find('td:nth-child(1)').html(Nomor);
			Nomor++;
		})
	}else{
		$(this).parent().parent().remove();
		var Nomor = 1;
		$('#tableTransaksi tbody tr').each(function(){
			$(this).find('td:nth-child(1)').html(Nomor);
			Nomor++;
		})
		HitungTotalBayar();
	}
});

// function cekStokMin(){
// 	var qty = document.getElementById('jumlah_beli').value;
// 	var qty_min = document.getElementById('stok_min').value;

// 	console.log('qty'+qty);
// 	console.log('qty_min'+qty_min);
// 	if(qty >= qty_min){
// 		alert('Jumlah Barang Melebihi Batas Minimum');
// 	}
// }


let tempKeyword = false;
$(document).on('keyup','#pencarian_kode', function(e){
	var keyword = $(this).val();
	var Indexnya = $(this).parent().parent().index();
	var key = e.which || e.keyCode;
	if (e.which == 40) { 
		$(this).select();
		$(this).parent().find("#hasil_pencarian > #daftar-autocomplete li").each(function(i, e) {
		  if($(this).hasClass("--focus") && i < $(this).parent().find('li').length - 1){
			  $(this).removeClass("--focus");
			  $(this).parent().find('li').each(function(ii, e){
				  if(ii == (i +1)){
					  $(this).addClass("--focus");
					  if($(this).position().top > 350){
						  $(this).parent().parent().scrollTop($(this).parent().parent().scrollTop() + 71);
					  }
				  }
			  })
			  return false;
		  }
	  })
	 e.preventDefault();
	 return false;
}else if (e.which == 38) { 
	$(this).select();
	$(this).parent().find("#hasil_pencarian > #daftar-autocomplete li").each(function(i, e) {
		  if($(this).hasClass("--focus") && i != 0){
			  $(this).removeClass("--focus");
			  $(this).parent().find('li').each(function(ii, e){
				  if(ii == (i-1)){
					  $(this).addClass("--focus");
					  if($(this).position().top < 0){
						  $(this).parent().parent().scrollTop($(this).parent().parent().scrollTop() - 71);
					  }
				  }
			  })
			  return false;
		  }
	  })
  e.preventDefault();
  return false;
}else if (e.which == 13){
		$(this).select();
		let foundItem = [];
		for(let i = 0; i < dataBarang.length; i++){
			let reg = new RegExp('^' + keyword + '.*$', 'i');
			if(	
					// dataBarang[i].kode_barcode_varian == keyword ||
					// dataBarang[i].kode_barang.match(reg) || 
					// dataBarang[i].nama_barang.includes(keyword) || 
					//(dataBarang[i].kode_barang.toLowerCase()).includes(keyword.toLowerCase()) || 
					(dataBarang[i].kode_barcode_varian.toLowerCase()).includes(keyword.toLowerCase())
					//(dataBarang[i].nama_barang.toLowerCase()).includes(keyword.toLowerCase())
				){
				foundItem.push(dataBarang[i])
			}
		}

		// foundItem = [foundItem[0]];

		if(foundItem.length > 1){
			if($(this).parent().find('#hasil_pencarian > #daftar-autocomplete').is(':visible') && tempKeyword){
				$(this).parent().find("#hasil_pencarian > #daftar-autocomplete li").each(function(i, e) {
				if($(this).hasClass('--focus')) {
				  $(this).parent().parent().parent().find('input').val($(this).find('span#kodenya').html());

						var Indexnya 	  = $(this).parent().parent().parent().parent().index();
						var NamaBarang 	  = $(this).find('span#barangnya').html();
						var VarianHarga   = $(this).find('span#variannya').html();
						var Warna 		  = $(this).find('span#warnanya').html();
						var Harganya 	  = $(this).find('span#harganya').html();
						var IdBarang 	  = $(this).find('span#id_barange').html();
						//console.log('IdBarang'+IdBarang);
						var IdVarianHarga = $(this).find('span#id_varian').html();
						//console.log('IdVarianHarga'+IdVarianHarga);
						var stokMin = $(this).find('span#stokmin').html();
						//var idp = document.getElementById("id_pelanggan").value;

					// 	var diskon_barang = getdiskon(IdBarang, Harganya, IdVarianHarga);
					// 	//console.log('diskon_barang'+diskon_barang);
					// 	var diskon = getpot(idp, Harganya, IdVarianHarga);
					// 	//console.log('diskon'+diskon);
					// 	var akhir_diskon = diskon - diskon_barang;
					// 	//console.log('akhir_diskon'+akhir_diskon);

					// 	if(akhir_diskon==0){
					// 			var biaya = Harganya;
					// 	}else{
					// 			var biaya = akhir_diskon;
					// 	}
					// //	console.log('akhir_diskon'+akhir_diskon);
					// 	let hargaText = Harganya - diskon > 0 ? to_rupiah(Harganya) + "<br> Harga Rekomendasi: <b>" + to_rupiah(biaya) : to_rupiah(biaya) + "</b>";

						// $('#tableTransaksi tbody tr:eq('+Indexnya+') td:nth-child(2)').find('div#hasil_pencarian').hide();
						// $('#tableTransaksi tbody tr:eq('+Indexnya+') td:nth-child(3)').html(NamaBarang + '&nbsp;'+ Warna + '&nbsp;'+ VarianHarga);
						// $('#tableTransaksi tbody tr:eq('+Indexnya+') td:nth-child(4) input').val(diskon);
						// // $('#tableTransaksi tbody tr:eq('+Indexnya+') td:nth-child(4) input#harga_jual').val(Harganya);
						// $('#tableTransaksi tbody tr:eq('+Indexnya+') td:nth-child(4) input#harga_jual').val(diskon);
						// $('#tableTransaksi tbody tr:eq('+Indexnya+') td:nth-child(4) input#id_barang').val(IdBarang);
						// $('#tableTransaksi tbody tr:eq('+Indexnya+') td:nth-child(4) input#id_varian_harga').val(IdVarianHarga);
						// $('#tableTransaksi tbody tr:eq('+Indexnya+') td:nth-child(4) span').html(hargaText);
						// $('#tableTransaksi tbody tr:eq('+Indexnya+') td:nth-child(5) input').removeAttr('disabled').val(1);
						// $('#tableTransaksi tbody tr:eq('+Indexnya+') td:nth-child(6) input').val(diskon);
						// $('#tableTransaksi tbody tr:eq('+Indexnya+') td:nth-child(6) span').html(to_rupiah(diskon));

						$('#tableTransaksi tbody tr:eq('+Indexnya+') td:nth-child(2)').find('div#hasil_pencarian').hide();
						$('#tableTransaksi tbody tr:eq('+Indexnya+') td:nth-child(3)').html(NamaBarang + '&nbsp;'+ Warna + '&nbsp;'+ VarianHarga);
						$('#tableTransaksi tbody tr:eq('+Indexnya+') td:nth-child(4) input').val(biaya);
						$('#tableTransaksi tbody tr:eq('+Indexnya+') td:nth-child(4) input#stok_min').val(stokMin);
						$('#tableTransaksi tbody tr:eq('+Indexnya+') td:nth-child(4) input#harga_jual').val(Harganya);
						$('#tableTransaksi tbody tr:eq('+Indexnya+') td:nth-child(4) input#id_barang').val(IdBarang);
						$('#tableTransaksi tbody tr:eq('+Indexnya+') td:nth-child(4) input#id_varian_harga').val(IdVarianHarga);
						//$('#tableTransaksi tbody tr:eq('+Indexnya+') td:nth-child(4) span').html(hargaText);
						$('#tableTransaksi tbody tr:eq('+Indexnya+') td:nth-child(5) input').removeAttr('disabled').val(1);
						//$('#tableTransaksi tbody tr:eq('+Indexnya+') td:nth-child(6) input').val(biaya);
						
						//$('#tableTransaksi tbody tr:eq('+Indexnya+') td:nth-child(6) span').html(to_rupiah(biaya));

						var IndexIni = Indexnya + 1;
						var TotalIndex = $('#tableTransaksi tbody tr').length;
						if(IndexIni == TotalIndex){
							BarisBaru();
							$('#tableTransaksi tbody tr:eq('+Indexnya+') td:nth-child(5) input').focus();
							// $('html, body').animate({ scrollTop: $(document).height() }, 0);
						}
						else {
							$('#tableTransaksi tbody tr:eq('+Indexnya+') td:nth-child(5) input').focus();
						}	
						HitungTotalBayar();
				}
			  })
			}else{
				cariBarang(keyword, Indexnya, foundItem);
				tempKeyword = true;
			}
		}else{
			cariBarang(keyword, Indexnya, foundItem);
			$(this).parent().find("#hasil_pencarian > #daftar-autocomplete li").each(function(i, e) {
			if($(this).hasClass('--focus')) {
			  $(this).parent().parent().parent().find('input').val($(this).find('span#kodenya').html());

					var Indexnya 	  = $(this).parent().parent().parent().parent().index();
					var NamaBarang 	  = $(this).find('span#barangnya').html();
					var VarianHarga   = $(this).find('span#variannya').html();
					var Warna 		  = $(this).find('span#warnanya').html();
					var Harganya 	  = $(this).find('span#harganya').html();
					var IdBarang 	  = $(this).find('span#id_barange').html();
					console.log('IdBarang'+IdBarang);
					var IdVarianHarga = $(this).find('span#id_varian').html();
					console.log('IdVarianHarga'+IdVarianHarga);
					var stokMin = $(this).find('span#stokmin').html();
					//var idp = document.getElementById("id_pelanggan").value;

					// var diskon_barang = getdiskon(IdBarang, Harganya, IdVarianHarga);
					// //console.log('diskon_barang'+diskon_barang);
					// var diskon = getpot(idp, Harganya, IdVarianHarga);
					// //console.log('diskon'+diskon);
					// var akhir_diskon = diskon - diskon_barang;
					// //console.log('akhir_diskon'+akhir_diskon);

					// if(akhir_diskon==0){
					// 		var biaya = Harganya;
					// }else{
					// 		var biaya = akhir_diskon;
					// }
					// let hargaText = Harganya - diskon > 0 ? to_rupiah(Harganya) + "<br> Harga Rekomendasi: <b>" + to_rupiah(biaya) : to_rupiah(biaya) + "</b>";
					// console.log(idp, Harganya, IdVarianHarga)
					// $('#tableTransaksi tbody tr:eq('+Indexnya+') td:nth-child(2)').find('div#hasil_pencarian').hide();
					// $('#tableTransaksi tbody tr:eq('+Indexnya+') td:nth-child(3)').html(NamaBarang + '&nbsp;'+ Warna + '&nbsp;'+ VarianHarga);
					// $('#tableTransaksi tbody tr:eq('+Indexnya+') td:nth-child(4) input').val(diskon);
					// // $('#tableTransaksi tbody tr:eq('+Indexnya+') td:nth-child(4) input#harga_jual').val(Harganya);
					// $('#tableTransaksi tbody tr:eq('+Indexnya+') td:nth-child(4) input#harga_jual').val(diskon);
					// $('#tableTransaksi tbody tr:eq('+Indexnya+') td:nth-child(4) input#id_barang').val(IdBarang);
					// $('#tableTransaksi tbody tr:eq('+Indexnya+') td:nth-child(4) input#id_varian_harga').val(IdVarianHarga);
					// $('#tableTransaksi tbody tr:eq('+Indexnya+') td:nth-child(4) span').html(hargaText);
					// $('#tableTransaksi tbody tr:eq('+Indexnya+') td:nth-child(5) input').removeAttr('disabled').val(1);
					// $('#tableTransaksi tbody tr:eq('+Indexnya+') td:nth-child(6) input').val(diskon);
					// $('#tableTransaksi tbody tr:eq('+Indexnya+') td:nth-child(6) span').html(to_rupiah(diskon));

					$('#tableTransaksi tbody tr:eq('+Indexnya+') td:nth-child(2)').find('div#hasil_pencarian').hide();
					$('#tableTransaksi tbody tr:eq('+Indexnya+') td:nth-child(3)').html(NamaBarang + '&nbsp;'+ Warna + '&nbsp;'+ VarianHarga);
					//$('#tableTransaksi tbody tr:eq('+Indexnya+') td:nth-child(4) input').val(biaya);
					$('#tableTransaksi tbody tr:eq('+Indexnya+') td:nth-child(4) input#stok_min').val(stokMin);
					//$('#tableTransaksi tbody tr:eq('+Indexnya+') td:nth-child(4) input#harga_jual').val(Harganya);
					$('#tableTransaksi tbody tr:eq('+Indexnya+') td:nth-child(4) input#id_barang').val(IdBarang);
					$('#tableTransaksi tbody tr:eq('+Indexnya+') td:nth-child(4) input#id_varian_harga').val(IdVarianHarga);
					//$('#tableTransaksi tbody tr:eq('+Indexnya+') td:nth-child(4) span').html(hargaText);
					$('#tableTransaksi tbody tr:eq('+Indexnya+') td:nth-child(5) input').removeAttr('disabled').val(1);
					// $('#tableTransaksi tbody tr:eq('+Indexnya+') td:nth-child(6) input').val(biaya);
					// $('#tableTransaksi tbody tr:eq('+Indexnya+') td:nth-child(6) span').html(to_rupiah(biaya));

					var IndexIni = Indexnya + 1;
					var TotalIndex = $('#tableTransaksi tbody tr').length;
					if(IndexIni == TotalIndex){
						BarisBaru();
						$('#tableTransaksi tbody tr:eq('+Indexnya+') td:nth-child(5) input').focus();
						// $('html, body').animate({ scrollTop: $(document).height() }, 0);
					}
					else {
						$('#tableTransaksi tbody tr:eq('+Indexnya+') td:nth-child(5) input').focus();
					}	
					HitungTotalBayar();
			}
		  })
		}
	}
	// else if(e.which == 8 || e.which == 46){
	// 	tempKeyword = false;

	// 	$(this).select();
	// 	let foundItem = [];
	// 	for(let i = 0; i < dataBarang.length; i++){
	// 		let reg = new RegExp('^' + keyword + '.*$', 'i');
	// 		if(dataBarang[i].kode_barang.match(reg) || dataBarang[i].nama_barang.includes(keyword) || (dataBarang[i].kode_barang.toLowerCase()).includes(keyword.toLowerCase())){
	// 			foundItem.push(dataBarang[i])
	// 		}
	// 	}
	// 	cariBarang(keyword, Indexnya, foundItem);
	// }
	else{
		tempKeyword = false;
	}
})
$(document).on('click', '#daftar-autocomplete li', function(){
	$(this).parent().find(".--focus").each(function() {
	  $(this).removeClass("--focus");
	})
	$(this).addClass("--focus");
	$(this).parent().parent().parent().find('input').val($(this).find('span#kodenya').html());

	var Indexnya 	  = $(this).parent().parent().parent().parent().index();
	var NamaBarang 	  = $(this).find('span#barangnya').html();
	var VarianHarga   = $(this).find('span#variannya').html();
	var Warna 		  = $(this).find('span#warnanya').html();
	var Harganya 	  = $(this).find('span#harganya').html();
	var IdBarang 	  = $(this).find('span#id_barange').html();
	console.log('IdBarang'+IdBarang);
	var IdVarianHarga = $(this).find('span#id_varian').html();
	console.log('IdVarianHarga'+IdVarianHarga);
	var stokMin = $(this).find('span#stokmin').html();
	//var idp = document.getElementById("id_pelanggan").value;

	// var diskon_barang = getdiskon(IdBarang, Harganya, IdVarianHarga);
	// 				//console.log('diskon_barang'+diskon_barang);
	// 				var diskon = getpot(idp, Harganya, IdVarianHarga);
	// 				//console.log('diskon'+diskon);
	// 				var akhir_diskon = diskon - diskon_barang;
	// 				//console.log('akhir_diskon'+akhir_diskon);

	// 				if(akhir_diskon==0){
	// 						var biaya = Harganya;
	// 				}else{
	// 						var biaya = akhir_diskon;
	// 				}
	// let hargaText = Harganya - diskon > 0 ? to_rupiah(Harganya) + "<br> Harga Rekomendasi: <b>" + to_rupiah(biaya) : to_rupiah(biaya) + "</b>";
	// console.log(idp, Harganya, IdVarianHarga)
	// $('#tableTransaksi tbody tr:eq('+Indexnya+') td:nth-child(2)').find('div#hasil_pencarian').hide();
	// $('#tableTransaksi tbody tr:eq('+Indexnya+') td:nth-child(3)').html(NamaBarang + '&nbsp;'+ Warna + '&nbsp;'+ VarianHarga);
	// $('#tableTransaksi tbody tr:eq('+Indexnya+') td:nth-child(4) input').val(diskon);
	// // $('#tableTransaksi tbody tr:eq('+Indexnya+') td:nth-child(4) input#harga_jual').val(Harganya);
	// $('#tableTransaksi tbody tr:eq('+Indexnya+') td:nth-child(4) input#harga_jual').val(diskon);
	// $('#tableTransaksi tbody tr:eq('+Indexnya+') td:nth-child(4) input#id_barang').val(IdBarang);
	// $('#tableTransaksi tbody tr:eq('+Indexnya+') td:nth-child(4) input#id_varian_harga').val(IdVarianHarga);
	// $('#tableTransaksi tbody tr:eq('+Indexnya+') td:nth-child(4) span').html(hargaText);
	// $('#tableTransaksi tbody tr:eq('+Indexnya+') td:nth-child(5) input').removeAttr('disabled').val(1);
	// $('#tableTransaksi tbody tr:eq('+Indexnya+') td:nth-child(6) input').val(diskon);
	// $('#tableTransaksi tbody tr:eq('+Indexnya+') td:nth-child(6) span').html(to_rupiah(diskon));

	$('#tableTransaksi tbody tr:eq('+Indexnya+') td:nth-child(2)').find('div#hasil_pencarian').hide();
	$('#tableTransaksi tbody tr:eq('+Indexnya+') td:nth-child(3)').html(NamaBarang + '&nbsp;'+ Warna + '&nbsp;'+ VarianHarga);
	//$('#tableTransaksi tbody tr:eq('+Indexnya+') td:nth-child(4) input').val(biaya);
	$('#tableTransaksi tbody tr:eq('+Indexnya+') td:nth-child(4) input#stok_min').val(stokMin);
	//$('#tableTransaksi tbody tr:eq('+Indexnya+') td:nth-child(4) input#harga_jual').val(Harganya);
	$('#tableTransaksi tbody tr:eq('+Indexnya+') td:nth-child(4) input#id_barang').val(IdBarang);
	$('#tableTransaksi tbody tr:eq('+Indexnya+') td:nth-child(4) input#id_varian_harga').val(IdVarianHarga);
	//$('#tableTransaksi tbody tr:eq('+Indexnya+') td:nth-child(4) span').html(hargaText);
	$('#tableTransaksi tbody tr:eq('+Indexnya+') td:nth-child(5) input').removeAttr('disabled').val(1);
	//$('#tableTransaksi tbody tr:eq('+Indexnya+') td:nth-child(6) input').val(biaya);
	
	$('#tableTransaksi tbody tr:eq('+Indexnya+') td:nth-child(6) span').html(to_rupiah(biaya));


	var IndexIni = Indexnya + 1;
	var TotalIndex = $('#tableTransaksi tbody tr').length;
	if(IndexIni == TotalIndex){
		BarisBaru();
		$('#tableTransaksi tbody tr:eq('+Indexnya+') td:nth-child(5) input').focus();
		// $('html, body').animate({ scrollTop: $(document).height() }, 0);
	}
	else {
		$('#tableTransaksi tbody tr:eq('+Indexnya+') td:nth-child(5) input').focus();
	}	
	HitungTotalBayar();
});
// hide and show "hasil pencarian"
$(window).click(function() {
	var Indexnya = $(this).parent().parent().index();
	$('.hasil_pencarian').hide();
});
$(document).on('click', '#pencarian_kode', function(){
	$('.hasil_pencarian').hide();
	var Indexnya = $(this).parent().parent().index();
	$('#tableTransaksi tbody tr:eq('+Indexnya+') td:nth-child(2)').find('div#hasil_pencarian').show();
});
$(document).on('keypress','#tableTransaksi', function(e) {
   var key = e.which || e.keyCode;
   if(key == 13) { return false; }
});

$(document).on('keypress','#tableTransaksi', function(e) {
   var key = e.which || e.keyCode;
   if(key == 13) { return false; }
});


$('#UangCash').on('keyup',function(){
	HitungKembalian();
})
$(document).on('keypress','#UangCash', function(e) {
   var key = e.which || e.keyCode;
   if(key == 13) { cekIsi() }
});
$('#UangDebit').keyup(function(){
	HitungKembalianDebit();
})
$(document).on('keydown', 'body', function(e){
	var charCode = ( e.which ) ? e.which : event.keyCode;

	if(charCode == 118) //F7
	{
		BarisBaru();
		return false;
	}

	if(charCode == 119) //F8
	{
		$('#UangCash').focus();
		return false;
	}
	if(charCode == 121) //F10
	{
		$('#Simpan').click();
		return false;
	} 
});

$('#id_pelanggan').change(function(){ // get id pelanggan
	const id = $(this).val();

	$.ajax({
		url:"<?php echo base_url() . 'Penjualan/ajax_pelanggan'; ?>",  
		data : {id :id},
		dataType: 'json',
		method : 'POST',
		success : function(json)
		{
			//kd_plgn = json.kode_pelanggan;
			$('#alamat_pelanggan').html(json.alamat);
			$('#telp_pelanggan').html(json.telp);
			$('#info_tambahan_pelanggan').html(json.info_tambahan);
		}
	});
	changeUser();
});




function BarisBaru(){
	var Nomor = $('#tableTransaksi tbody tr').length +1;
	
	// 0
	var Baris = "<tr>";
	Baris += "<td>"+Nomor+"</td>";

	// 1
	Baris += "<td>";
	Baris += "<input autocomplete='off' required  type='text' class='form-control' name='kode_barang[]' id='pencarian_kode' placeholder='Ketik Kode / Nama Barang'>";
	Baris += "<div id='hasil_pencarian' class='hasil_pencarian'></div>";
	Baris += "</td>";

	// 2
	Baris += "<td></td>";

	// 3
	// Baris += "<td>";
	// Baris += "<input required  type='hidden' name='harga_satuan[]'> <input type='hidden' id='id_barang' name='id_barang[]' /> <input type='hidden' id='id_varian_harga' name='id_varian_harga[]' /><input type='hidden' id='harga_jual' name='harga_jual[]' /><input type='hidden' id='stok_min' name='stok_min[]' />";
	// Baris += "<span></span>";
	// Baris += "</td>";

	// 4
	Baris += "<td>";
	Baris += "<div style='display: flex;'>"
	Baris += '<button id="minus_jumlah" type="button" class="btn btn-success pull-left" style="padding: 5px;"><i class="fa fa-minus fa-fw"></i></button>';
	Baris += "<input required type='text' class='form-control col-md' id='jumlah_beli' name='jumlah_beli[]' disabled style='width: 62px; margin: 0 5px;'><input type='hidden' id='id_barang' name='id_barang[]' /> <input type='hidden' id='id_varian_harga' name='id_varian_harga[]' /><input type='hidden' id='harga_jual' name='harga_jual[]' /><input type='hidden' id='stok_min' name='stok_min[]' />";
	Baris += '<button id="plus_jumlah" type="button" class="btn btn-success pull-left" style="padding: 5px;"><i class="fa fa-plus fa-fw"></i></button>';
	Baris += "</div>"
	Baris += "</td>";

	// 5
	// Baris += "<td>";
	// Baris += "<input  required type='hidden' name='sub_total[]'>";
	// Baris += '<span></span>';
	// Baris += "</td>";
	
	Baris += "<td><button  class='btn btn-danger' id='HapusBaris'><i class='fa fa-times' style='color:white;'></i></button></td>";
	Baris += "</tr>";

	$('#tableTransaksi').append(Baris);
	// Fokus Input
	$('#tableTransaksi tbody tr').each(function(){
		$(this).find('td:nth-child(2) input').focus();
	});
}

function getDataBarang(){
	$.ajax({
		url:linke+"Pembelian_bpb/getDataBarang",  
		method : 'POST',
		dataType : 'JSON',
		success : function(json)
		{
			console.log(json);
			dataBarang = json.datanya;
		}
	})
}

let intervalPress;
function cariBarang(keyword, Indexnya, foundItem){
	let htmlFoundItem =  "<ul id='daftar-autocomplete' class='daftar-autocomplete'>";
	foundItem.forEach((b, i) => {
	//	var b.stok_gudang = 0;
		if(i == 0){
			htmlFoundItem += '<li class="--focus">';
		}else{
			htmlFoundItem += '<li>';
		}

		var stoke;
		if(b.stok_gudang!=null){
			stoke = b.stok_gudang;
			var warna = 'green';
		}else{
			stoke = 0;
			var warna = 'red';
		}
		htmlFoundItem += `
				<b>Kode</b> : 
				` 
				// <span id='kodenya'>` + b.kode_barang + `</span> <br />
				+ 
				`
				<span id='kodenya'>` + b.kode_barcode_varian + `</span> <br />
				<span id='barangnya'>` + b.nama_barang + `</span> <br />
				<span id='variannya'>` + b.satuan + ` (` + b.meter + ` Pcs)</span><br />
				<span id='harganya' style='display:none;'>`  + b.harga + `</span>
				<span id='warnanya' style='display:none;'>` + b.warna + `</span>
				<span id='id_varian' style='display:none;'>` + b.id_varian_harga + `</span>
				<span id='id_barange' style='display:none;'>` + b.id_barang + `</span>
				<span id='stokmin' style='display:none;'>` + b.stok_gudang + `</span>
			</li>
		`;
	})
	htmlFoundItem += "</ul>";

	if(foundItem.length > 0 && keyword != ""){
		$('#tableTransaksi tbody tr:eq('+Indexnya+') td:nth-child(2)').find('div#hasil_pencarian').show('fast');
		$('#tableTransaksi tbody tr:eq('+Indexnya+') td:nth-child(2)').find('div#hasil_pencarian').html(htmlFoundItem);
	}else{
		let tidakAda = '<ul class="daftar-autocomplete"><li> <span>Data Tidak Ditemukan</span></li><ul>'
		$('#tableTransaksi tbody tr:eq('+Indexnya+') td:nth-child(2)').find('div#hasil_pencarian').html(tidakAda);
	}
	return foundItem.length;
}

	// $(document).on('keyup','#jumlah_beli',function(){
	// 	var Indexnya = $(this).parent().parent().index();
	// 	var Harga = $('#tableTransaksi tbody tr:eq('+Indexnya+') td:nth-child(4) input').val();
	// 	var jumlahBeli = $(this).val();

	// 	var SubTotal = parseInt(Harga) * parseInt(jumlahBeli);
	// 	if(SubTotal > 0){
	// 		var SubTotalVal = SubTotal;
	// 		SubTotal = to_rupiah(SubTotal);
	// 	} else {
	// 		SubTotal = '';
	// 		var SubTotalVal = 0;
	// 	}

	// 	$('#tableTransaksi tbody tr:eq('+Indexnya+') td:nth-child(6) input').val(SubTotalVal);
	// 	$('#tableTransaksi tbody tr:eq('+Indexnya+') td:nth-child(6) span').html(SubTotal);
	// 	HitungTotalBayar();
	// });
	// $('#UangCash').keyup(function(){
	// 	HitungKembalian();
	// })



	// function to_rupiah(angka){
	// 	var rev     = parseInt(angka, 10).toString().split('').reverse().join('');
	// 	var rev2    = '';
	// 	for(var i = 0; i < rev.length; i++){
	// 		rev2  += rev[i];
	// 		if((i + 1) % 3 === 0 && i !== (rev.length - 1)){
	// 			rev2 += '.';
	// 		}
	// 	}
	// 	return 'Rp. ' + rev2.split('').reverse().join('');
	// }

	// function HitungTotalBayar() {
	// 	var Total = 0;
	// 	$('#tableTransaksi tbody tr').each(function(){
	// 		if($(this).find('td:nth-child(6) input').val() > 0)
	// 		{
	// 			var SubTotal = $(this).find('td:nth-child(6) input').val();
	// 			Total = parseInt(Total) + parseInt(SubTotal);
	// 		}
	// 	});

	// 	$('#TotalBayar').html(to_rupiah(Total));
	// 	$('#TotalBayarHidden').val(Total);

	// 	$('#UangCash').val('');
	// 	$('#UangKembali').val('');
	// }
	// function HitungKembalian() {
	// 	var Cash = $('#UangCash').val();
	// 	var TotalBayar = $('#TotalBayarHidden').val();

	// 	if (parseInt(Cash) > parseInt(TotalBayar)){

	// 		var Selisih = parseInt(Cash) - parseInt(TotalBayar);
	// 		$('#UangKembali').val(to_rupiah(Selisih));

	// 	}
	// 	else{
	// 		$('UangKembali').val('');
	// 	}
	// }
	$(document).on('keydown', 'body', function(e){
		var charCode = ( e.which ) ? e.which : event.keyCode;

		if(charCode == 118) //F7
		{
			BarisBaru();
			return false;
		}

		if(charCode == 119) //F8
		{
			$('#UangCash').focus();
			return false;
		}
		if(charCode == 121) //F10
		{
			$('#Simpan').click();
			return false;
		} 
	});

	function cekIsi(){
		if($('[id="HapusBaris"]').length < 2){
			return false;
		}
		$('[id="HapusBaris"]').each(function() {
			if($(this).parent().parent().find("#pencarian_kode").val() == ""){
				$(this).parent().parent().remove();
			}
		});
		return confirm('Apakah anda yakin menyimpan Transaksi ini ??');
	}

	$(document).on('keypress','#tableTransaksi', function(e) {
		var key = e.which || e.keyCode;
		if(key == 13) { return false; }
	 });

	$(document).on('click', '#plus_jumlah', function() {
		let input = $(this).siblings('input');
		let plus = Number(input.val()) + 1;
		input.val(plus);

		// var Indexnya = $(this).parent().parent().parent().index();
		// var Harga = $('#tableTransaksi tbody tr:eq('+Indexnya+') td:nth-child(4) input').val();
		// var jumlahBeli = $(this).siblings('input').val();

		// var SubTotal = parseInt(Harga) * parseInt(jumlahBeli);
		// if(SubTotal > 0){
		// 	var SubTotalVal = SubTotal;
		// 	SubTotal = to_rupiah(SubTotal);
		// } else {
		// 	SubTotal = '';
		// 	var SubTotalVal = 0;
		// }

		// $('#tableTransaksi tbody tr:eq('+Indexnya+') td:nth-child(6) input').val(SubTotalVal);
		// $('#tableTransaksi tbody tr:eq('+Indexnya+') td:nth-child(6) span').html(SubTotal);
		//HitungTotalBayar();
	});
	$(document).on('click', '#minus_jumlah', function() {
		let input = $(this).siblings('input');
		let minus = Number(input.val()) - 1;
		if(minus > 0){
			input.val(minus);
		}

		// var Indexnya = $(this).parent().parent().parent().index();
		// var Harga = $('#tableTransaksi tbody tr:eq('+Indexnya+') td:nth-child(4) input').val();
		// var jumlahBeli = $(this).siblings('input').val();

		// var SubTotal = parseInt(Harga) * parseInt(jumlahBeli);
		// if(SubTotal > 0){
		// 	var SubTotalVal = SubTotal;
		// 	SubTotal = to_rupiah(SubTotal);
		// } else {
		// 	SubTotal = '';
		// 	var SubTotalVal = 0;
		// }

		// $('#tableTransaksi tbody tr:eq('+Indexnya+') td:nth-child(6) input').val(SubTotalVal);
		// $('#tableTransaksi tbody tr:eq('+Indexnya+') td:nth-child(6) span').html(SubTotal);
		// HitungTotalBayar();
	});