let dataBarang;
	$(document).ready(function(){
		getDataBarang();
		BarisBaru();
        //BarisBaruID(idne);
		//edit(idne);
		$( 'html, body' ).animate( { scrollTop: 0 }, 0 );
	});

	// fitur button
	$('#BarisBaru').on('click',function(){
		BarisBaru();
	});
	$(document).on('click','#HapusBaris',function(e){
		e.preventDefault();
		if($(this).parent().parent().find("#pencarian_kode2").val() == ""){
			$(this).parent().parent().remove();
			var Nomor = 1;
			$('#tableTransaksi2 tbody tr').each(function(){
				$(this).find('td:nth-child(1)').html(Nomor);
				Nomor++;
			})
		}else{
			$(this).parent().parent().remove();
			var Nomor = 1;
			$('#tableTransaksi2 tbody tr').each(function(){
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
	$(document).on('keyup','#pencarian_kode2', function(e){
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
						(dataBarang[i].kode_barang.toLowerCase()).includes(keyword.toLowerCase()) || 
						(dataBarang[i].kode_barcode_varian.toLowerCase()).includes(keyword.toLowerCase()) || 
						(dataBarang[i].nama_barang.toLowerCase()).includes(keyword.toLowerCase())
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
							var IdVarianHarga = $(this).find('span#id_varian').html();
							var stokMin = $(this).find('span#stokmin').html();
							var idp = document.getElementById("id_pelanggan").value;

							var diskon = getpot(idp, Harganya, IdVarianHarga);
							let hargaText = Harganya - diskon > 0 ? to_rupiah(Harganya) + "<br> Disc: <b>" + to_rupiah(Harganya - diskon) : to_rupiah(Harganya) + "</b>";

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

							$('#tableTransaksi2 tbody tr:eq('+Indexnya+') td:nth-child(2)').find('div#hasil_pencarian').hide();
							$('#tableTransaksi2 tbody tr:eq('+Indexnya+') td:nth-child(3)').html(NamaBarang + '&nbsp;'+ Warna + '&nbsp;'+ VarianHarga);
							$('#tableTransaksi2 tbody tr:eq('+Indexnya+') td:nth-child(4) input').val(diskon);
							$('#tableTransaksi2 tbody tr:eq('+Indexnya+') td:nth-child(4) input#stok_min').val(stokMin);
							$('#tableTransaksi2 tbody tr:eq('+Indexnya+') td:nth-child(4) input#harga_jual').val(Harganya);
							$('#tableTransaksi2 tbody tr:eq('+Indexnya+') td:nth-child(4) input#id_barang').val(IdBarang);
							$('#tableTransaksi2 tbody tr:eq('+Indexnya+') td:nth-child(4) input#id_varian_harga').val(IdVarianHarga);
							$('#tableTransaksi2 tbody tr:eq('+Indexnya+') td:nth-child(4) span').html(hargaText);
							$('#tableTransaksi2 tbody tr:eq('+Indexnya+') td:nth-child(5) input').removeAttr('disabled').val(1);
							$('#tableTransaksi2 tbody tr:eq('+Indexnya+') td:nth-child(6) input').val(diskon);
							
							$('#tableTransaksi2 tbody tr:eq('+Indexnya+') td:nth-child(6) span').html(to_rupiah(diskon));

							var IndexIni = Indexnya + 1;
							var TotalIndex = $('#tableTransaksi2 tbody tr').length;
							if(IndexIni == TotalIndex){
								BarisBaru();
								$('#tableTransaksi2 tbody tr:eq('+Indexnya+') td:nth-child(5) input').focus();
								// $('html, body').animate({ scrollTop: $(document).height() }, 0);
							}
							else {
								$('#tableTransaksi2 tbody tr:eq('+Indexnya+') td:nth-child(5) input').focus();
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
						var IdVarianHarga = $(this).find('span#id_varian').html();
						var stokMin = $(this).find('span#stokmin').html();
						var idp = document.getElementById("id_pelanggan").value;

						var diskon = getpot(idp, Harganya, IdVarianHarga);
						let hargaText = Harganya - diskon > 0 ? to_rupiah(Harganya) + "<br> Disc: <b>" + to_rupiah(Harganya - diskon) : to_rupiah(Harganya) + "</b>";
						console.log(idp, Harganya, IdVarianHarga)
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

						$('#tableTransaksi2 tbody tr:eq('+Indexnya+') td:nth-child(2)').find('div#hasil_pencarian').hide();
						$('#tableTransaksi2 tbody tr:eq('+Indexnya+') td:nth-child(3)').html(NamaBarang + '&nbsp;'+ Warna + '&nbsp;'+ VarianHarga);
						$('#tableTransaksi2 tbody tr:eq('+Indexnya+') td:nth-child(4) input').val(diskon);
						$('#tableTransaksi2 tbody tr:eq('+Indexnya+') td:nth-child(4) input#stok_min').val(stokMin);
						$('#tableTransaksi2 tbody tr:eq('+Indexnya+') td:nth-child(4) input#harga_jual').val(Harganya);
						$('#tableTransaksi2 tbody tr:eq('+Indexnya+') td:nth-child(4) input#id_barang').val(IdBarang);
						$('#tableTransaksi2 tbody tr:eq('+Indexnya+') td:nth-child(4) input#id_varian_harga').val(IdVarianHarga);
						$('#tableTransaksi2 tbody tr:eq('+Indexnya+') td:nth-child(4) span').html(hargaText);
						$('#tableTransaksi2 tbody tr:eq('+Indexnya+') td:nth-child(5) input').removeAttr('disabled').val(1);
						$('#tableTransaksi2 tbody tr:eq('+Indexnya+') td:nth-child(6) input').val(diskon);
						$('#tableTransaksi2 tbody tr:eq('+Indexnya+') td:nth-child(6) span').html(to_rupiah(diskon));

						var IndexIni = Indexnya + 1;
						var TotalIndex = $('#tableTransaksi2 tbody tr').length;
						if(IndexIni == TotalIndex){
							BarisBaru();
							$('#tableTransaksi2 tbody tr:eq('+Indexnya+') td:nth-child(5) input').focus();
							// $('html, body').animate({ scrollTop: $(document).height() }, 0);
						}
						else {
							$('#tableTransaksi2 tbody tr:eq('+Indexnya+') td:nth-child(5) input').focus();
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
		var IdVarianHarga = $(this).find('span#id_varian').html();
		var stokMin = $(this).find('span#stokmin').html();
		var idp = document.getElementById("id_pelanggan").value;

		var diskon = getpot(idp, Harganya, IdVarianHarga);
		let hargaText = Harganya - diskon > 0 ? to_rupiah(Harganya) + "<br> Disc: <b>" + to_rupiah(Harganya - diskon) : to_rupiah(Harganya) + "</b>";
		console.log(idp, Harganya, IdVarianHarga)
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

		$('#tableTransaksi2 tbody tr:eq('+Indexnya+') td:nth-child(2)').find('div#hasil_pencarian').hide();
		$('#tableTransaksi2 tbody tr:eq('+Indexnya+') td:nth-child(3)').html(NamaBarang + '&nbsp;'+ Warna + '&nbsp;'+ VarianHarga);
		$('#tableTransaksi2 tbody tr:eq('+Indexnya+') td:nth-child(4) input').val(diskon);
		$('#tableTransaksi2 tbody tr:eq('+Indexnya+') td:nth-child(4) input#stok_min').val(stokMin);
		$('#tableTransaksi2 tbody tr:eq('+Indexnya+') td:nth-child(4) input#harga_jual').val(Harganya);
		$('#tableTransaksi2 tbody tr:eq('+Indexnya+') td:nth-child(4) input#id_barang').val(IdBarang);
		$('#tableTransaksi2 tbody tr:eq('+Indexnya+') td:nth-child(4) input#id_varian_harga').val(IdVarianHarga);
		$('#tableTransaksi2 tbody tr:eq('+Indexnya+') td:nth-child(4) span').html(hargaText);
		$('#tableTransaksi2 tbody tr:eq('+Indexnya+') td:nth-child(5) input').removeAttr('disabled').val(1);
		$('#tableTransaksi2 tbody tr:eq('+Indexnya+') td:nth-child(6) input').val(diskon);
		
		$('#tableTransaksi2 tbody tr:eq('+Indexnya+') td:nth-child(6) span').html(to_rupiah(diskon));


		var IndexIni = Indexnya + 1;
		var TotalIndex = $('#tableTransaksi2 tbody tr').length;
		if(IndexIni == TotalIndex){
			BarisBaru();
			$('#tableTransaksi2 tbody tr:eq('+Indexnya+') td:nth-child(5) input').focus();
			// $('html, body').animate({ scrollTop: $(document).height() }, 0);
		}
		else {
			$('#tableTransaksi2 tbody tr:eq('+Indexnya+') td:nth-child(5) input').focus();
		}	
		HitungTotalBayar();
	});
	// hide and show "hasil pencarian"
	$(window).click(function() {
		var Indexnya = $(this).parent().parent().index();
		$('.hasil_pencarian').hide();
	});
	$(document).on('click', '#pencarian_kode2', function(){
		$('.hasil_pencarian').hide();
		var Indexnya = $(this).parent().parent().index();
		$('#tableTransaksi2 tbody tr:eq('+Indexnya+') td:nth-child(2)').find('div#hasil_pencarian').show();
	});
	$(document).on('keypress','#tableTransaksi2', function(e) {
	   var key = e.which || e.keyCode;
	   if(key == 13) { return false; }
	});

	$(document).on('keypress','#tableTransaksi2', function(e) {
	   var key = e.which || e.keyCode;
	   if(key == 13) { return false; }
	});

	$(document).on('click', '#plus_jumlah', function() {
		var id_varian_harga = document.getElementById("id_varian_harga").value;
		var id_barange2 = document.getElementById("id_barang").value;
		var jumlah_beli = document.getElementById("jumlah_beli").value;
		$.getJSON(linke+'Penjualan/get_stoke/'+id_varian_harga+'/'+id_barange2+'/', {
				format: "json"
		})
		.done(function (datas) {
	        	// console.log(datas);
	        //	document.getElementById('jml_barang').innerHTML = '<strong><font color="red">*</font></strong>Total stok : '+datas;
	        	// document.getElementById('jumlah_barang').value = datas;
				//$('#jumlah_beli').attr('max',datas);
				if(jumlah_beli > datas){
					alert('jumlah barang melebihi jumlah stok');
				}

	    })
		let input = $(this).siblings('input');
		let plus = Number(input.val()) + 1;
		input.val(plus);

		var Indexnya = $(this).parent().parent().parent().index();
		var Harga = $('#tableTransaksi2 tbody tr:eq('+Indexnya+') td:nth-child(4) input').val();
		var jumlahBeli = $(this).siblings('input').val();

		var SubTotal = parseInt(Harga) * parseInt(jumlahBeli);
		if(SubTotal > 0){
			var SubTotalVal = SubTotal;
			SubTotal = to_rupiah(SubTotal);
		} else {
			SubTotal = '';
			var SubTotalVal = 0;
		}

		$('#tableTransaksi2 tbody tr:eq('+Indexnya+') td:nth-child(6) input').val(SubTotalVal);
		$('#tableTransaksi2 tbody tr:eq('+Indexnya+') td:nth-child(6) span').html(SubTotal);
		HitungTotalBayar();
	});
	$(document).on('click', '#minus_jumlah', function() {
		var id_varian_harga = document.getElementById("id_varian_harga").value;
		var id_barange2 = document.getElementById("id_barang").value;
		var jumlah_beli = document.getElementById("jumlah_beli").value;
		$.getJSON(linke+'Penjualan/get_stoke/'+id_varian_harga+'/'+id_barange2+'/', {
				format: "json"
		})
		.done(function (datas) {
	        	// console.log(datas);
	        //	document.getElementById('jml_barang').innerHTML = '<strong><font color="red">*</font></strong>Total stok : '+datas;
	        	// document.getElementById('jumlah_barang').value = datas;
				//$('#jumlah_beli').attr('max',datas);
				if(jumlah_beli > datas){
					alert('jumlah barang melebihi jumlah stok');
				}

	         })
		let input = $(this).siblings('input');
		let minus = Number(input.val()) - 1;
		if(minus > 0){
			input.val(minus);
		}

		var Indexnya = $(this).parent().parent().parent().index();
		var Harga = $('#tableTransaksi2 tbody tr:eq('+Indexnya+') td:nth-child(4) input').val();
		var jumlahBeli = $(this).siblings('input').val();

		var SubTotal = parseInt(Harga) * parseInt(jumlahBeli);
		if(SubTotal > 0){
			var SubTotalVal = SubTotal;
			SubTotal = to_rupiah(SubTotal);
		} else {
			SubTotal = '';
			var SubTotalVal = 0;
		}

		$('#tableTransaksi2 tbody tr:eq('+Indexnya+') td:nth-child(6) input').val(SubTotalVal);
		$('#tableTransaksi2 tbody tr:eq('+Indexnya+') td:nth-child(6) span').html(SubTotal);
		HitungTotalBayar();
	});
	$(document).on('keyup','#jumlah_beli', function(e){
		var id_varian_harga = document.getElementById("id_varian_harga").value;
		var id_barange2 = document.getElementById("id_barang").value;
		var jumlah_beli = document.getElementById("jumlah_beli").value;
		$.getJSON(linke+'Penjualan/get_stoke/'+id_varian_harga+'/'+id_barange2+'/', {
				format: "json"
		})
		.done(function (datas) {
	        	// console.log(datas);
	        //	document.getElementById('jml_barang').innerHTML = '<strong><font color="red">*</font></strong>Total stok : '+datas;
	        	// document.getElementById('jumlah_barang').value = datas;
				//$('#jumlah_beli').attr('max',datas);
				if(jumlah_beli > datas){
					alert('jumlah barang melebihi jumlah stok');
				}

	         })
		var Indexnya = $(this).parent().parent().parent().index();

		if (e.which == 38) { 
			let jumlah = Number($(this).val()) + 1;
			$(this).val(jumlah);
		}else if(e.which == 40){
			let jumlah = Number($(this).val()) - 1;
			
			if($(this).val() > 1){
				$(this).val(jumlah);
			}
		}else if(e.which == 13){
			$('#tableTransaksi2 tbody tr:eq('+ (Indexnya + 1) +') td:nth-child(2) input').focus();
		}

		var Harga = $('#tableTransaksi2 tbody tr:eq('+Indexnya+') td:nth-child(4) input').val();
		var jumlahBeli = $(this).val();

		var SubTotal = parseInt(Harga) * parseInt(jumlahBeli);
		if(SubTotal > 0){
			var SubTotalVal = SubTotal;
			SubTotal = to_rupiah(SubTotal);
		} else {
			SubTotal = '';
			var SubTotalVal = 0;
		}

		$('#tableTransaksi2 tbody tr:eq('+Indexnya+') td:nth-child(6) input').val(SubTotalVal);
		$('#tableTransaksi2 tbody tr:eq('+Indexnya+') td:nth-child(6) span').html(SubTotal);
		HitungTotalBayar();
	});

	$('#metode_pembayaran').on('change', function() {
	  console.log(this.value);
	  if ( this.value == 'cash_debit'){
	  	$('#biaya_debit').show();
	  }else{
	  	$('#biaya_debit').hide();
	  }
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


	function getdiskon(idp, hargaawal, idv) {
		var diskon=hargaawal;
		$.ajax({
			'async': false,
			type: 'GET',
			url: linke+'Penjualan/getDiskone/'+idp,
			dataType: 'json',
			success: function(data){
				$.each(data, function(index, item) {
					if (item.id_barang == idp && item.id_varian_harga == idv) {
						if(item.disko_rupiah==0){
							diskon = ((hargaawal * item.diskon_persen) / 100);
						}else{
							diskon = hargaawal - item.diskon_rupiah;
						}

						return false;
					}
				})
			}
		});
		return diskon;
	}

	function BarisBaru(){
		var Nomor = $('#tableTransaksi2 tbody tr').length +1;
		
		// 0
		var Baris = "<tr>";
		Baris += "<td>"+Nomor+"</td>";

		// 1
		Baris += "<td>";
		Baris += "<input autocomplete='off' required  type='text' class='form-control' name='kode_barang[]' id='pencarian_kode2' placeholder='Ketik Kode / Nama Barang'>";
		Baris += "<div id='hasil_pencarian' class='hasil_pencarian'></div>";
		Baris += "</td>";

		// 2
		Baris += "<td></td>";

		// 3
		Baris += "<td>";
		Baris += "<input required  type='hidden' name='harga_satuan[]'> <input type='hidden' id='id_barang' name='id_barang[]' /> <input type='hidden' id='id_varian_harga' name='id_varian_harga[]' /><input type='hidden' id='harga_jual' name='harga_jual[]' /><input type='hidden' id='stok_min' name='stok_min[]' />";
		Baris += "<span></span>";
		Baris += "</td>";

		// 4
		Baris += "<td>";
		Baris += "<div style='display: flex;'>"
		Baris += '<button id="minus_jumlah" class="btn btn-success pull-left" style="padding: 5px;"><i class="fa fa-minus fa-fw"></i></button>';
		Baris += "<input required type='text' class='form-control col-md' id='jumlah_beli' name='jumlah_beli[]' disabled style='width: 62px; margin: 0 5px;'>";
		Baris += '<button id="plus_jumlah" class="btn btn-success pull-left" style="padding: 5px;"><i class="fa fa-plus fa-fw"></i></button>';
		Baris += "</div>"
		Baris += "</td>";

		// 5
		Baris += "<td>";
		Baris += "<input  required type='hidden' name='sub_total[]'>";
		Baris += '<span></span>';
		Baris += "</td>";
		
		Baris += "<td><button type='button' class='btn btn-danger' id='HapusBaris' ><i class='fa fa-times' style='color:white;'></i></button></td>";
		Baris += "</tr>";

		$('#tableTransaksi2').append(Baris);
		// Fokus Input
		$('#tableTransaksi2 tbody tr').each(function(){
			$(this).find('td:nth-child(2) input').focus();
		});
	}

	function getDataBarang(){
		$.ajax({
			url: linke+"Penjualan/getDataBarang",  
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
					<span id='barangnya' style="color :`+ warna +`;">Sisa Stok : ` + stoke + `</span> <br />
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
			$('#tableTransaksi2 tbody tr:eq('+Indexnya+') td:nth-child(2)').find('div#hasil_pencarian').show('fast');
			$('#tableTransaksi2 tbody tr:eq('+Indexnya+') td:nth-child(2)').find('div#hasil_pencarian').html(htmlFoundItem);
		}else{
			let tidakAda = '<ul class="daftar-autocomplete"><li> <span>Data Tidak Ditemukan</span></li><ul>'
			$('#tableTransaksi2 tbody tr:eq('+Indexnya+') td:nth-child(2)').find('div#hasil_pencarian').html(tidakAda);
		}
		return foundItem.length;
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

	// function changeUser() {
	// 	var Total = 0;
	// 	var idp = document.getElementById("id_pelanggan").value;
	// 	var i=0;
	// 	var Indexnya = $(this).parent().parent().parent().parent().index();
	// 	len = $('#tableTransaksi tbody tr').length;
	// 	$('#tableTransaksi tbody tr').each(function(){
	// 		if ((len-i) != 1) {
	// 			var input4 = $(this).find('td:nth-child(4) input').val();
	// 			var Harganya = $(this).find('td:nth-child(4) input#harga_jual').val();
	// 			var idv = $(this).find('td:nth-child(4) input#id_varian_harga').val();
	// 			var idb = $(this).find('td:nth-child(4) input#id_barang').val();
	// 			var diskon = getpot(idp, Harganya, idv);
	// 			let hargaText = Harganya - diskon > 0 ? to_rupiah(Harganya) + "<br> Disc: <b>" + to_rupiah(Harganya - diskon) : to_rupiah(Harganya) + "</b>";

	// 			$(this).find('td:nth-child(4) span').html(hargaText);
	// 			$(this).find('td:nth-child(4) input').val(diskon);
	// 			// $(this).find('td:nth-child(4) input#harga_jual').val(Harganya);
	// 			$(this).find('td:nth-child(4) input#harga_jual').val(diskon);
	// 			$(this).find('td:nth-child(4) input#id_barang').val(idb);
	// 			$(this).find('td:nth-child(4) input#id_varian_harga').val(idv);
	// 			$(this).find('td:nth-child(6) input').val(diskon);
	// 			$(this).find('td:nth-child(6) span').html(to_rupiah(diskon));

	// 			var Harga = $(this).find('td:nth-child(4) input').val();
	// 			var jumlahBeli = $("input[name='jumlah_beli[]']").map(function(){return $(this).val();}).get();
	// 			var SubTotal = parseInt(Harga) * parseInt(jumlahBeli[i]);
	// 			if(SubTotal > 0){
	// 				var SubTotalVal = SubTotal;
	// 				SubTotal = to_rupiah(SubTotal);
	// 			} else {
	// 				SubTotal = '';
	// 				var SubTotalVal = 0;
	// 			}

	// 			$(this).find('td:nth-child(6) input').val(SubTotalVal);
	// 			$(this).find('td:nth-child(6) span').html(SubTotal);
	// 			HitungTotalBayar();
	// 			i++;
	// 		}else{
	// 			return false;
	// 		}
	// 	});

	// 	HitungTotalBayar();
	// 	bayar_cek();
	// 	HitungKembalian();
	// }

	function changeUser() {
		var Total = 0;
		var idp = document.getElementById("id_pelanggan").value;
		var i=0;
		var Indexnya = $(this).parent().parent().parent().parent().index();
		len = $('#tableTransaksi2 tbody tr').length;
		$('#tableTransaksi2 tbody tr').each(function(){
			if ((len-i) != 1) {
				var input4 = $(this).find('td:nth-child(4) input').val();
				var Harganya = $(this).find('td:nth-child(4) input#harga_jual').val();
				var idv = $(this).find('td:nth-child(4) input#id_varian_harga').val();
				var idb = $(this).find('td:nth-child(4) input#id_barang').val();
				var diskon = getpot(idp, Harganya, idv);
				let hargaText = Harganya - diskon > 0 ? to_rupiah(Harganya) + "<br> Disc: <b>" + to_rupiah(Harganya - diskon) : to_rupiah(Harganya) + "</b>";

				$(this).find('td:nth-child(4) span').html(hargaText);
				$(this).find('td:nth-child(4) input').val(diskon);
				$(this).find('td:nth-child(4) input#harga_jual').val(Harganya);
				$(this).find('td:nth-child(4) input#id_barang').val(idb);
				$(this).find('td:nth-child(4) input#id_varian_harga').val(idv);
				$(this).find('td:nth-child(6) input').val(diskon);
				$(this).find('td:nth-child(6) span').html(to_rupiah(diskon));
				
				var Harga = $(this).find('td:nth-child(4) input').val();
				var jumlahBeli = $("input[name='jumlah_beli[]']").map(function(){return $(this).val();}).get();
				var SubTotal = parseInt(Harga) * parseInt(jumlahBeli[i]);
				if(SubTotal > 0){
					var SubTotalVal = SubTotal;
					SubTotal = to_rupiah(SubTotal);
				} else {
					SubTotal = '';
					var SubTotalVal = 0;
				}

				$(this).find('td:nth-child(6) input').val(SubTotalVal);
				$(this).find('td:nth-child(6) span').html(SubTotal);
				HitungTotalBayar();
				i++;
			}else{
				return false;
			}
		});

		HitungTotalBayar();
	}

	function HitungTotalBayar() {
		var Total = 0;
		$('#tableTransaksi2 tbody tr').each(function(){
			if($(this).find('td:nth-child(6) input').val() > 0)
			{
				var SubTotal = $(this).find('td:nth-child(6) input').val();
				Total = parseInt(Total) + parseInt(SubTotal);
			}
		});

		$('#TotalBayar2').html(to_rupiah(Total));
		$('#TotalBayarHidden2').val(Total);

		// $('#UangCash').val('');
		$('#UangDebit').val('');
		$('#UangKembali').val('');
	}

	function HitungKembalian() {
		var Cash = $('#UangCash').val();

		if ($('#UangDebit').val()=='') {
			var Debit = 0;
		}else{
			var Debit = $('#UangDebit').val();
		}
		var TotalBayar = $('#TotalBayarHidden').val();
		var Metode = $('#metode_pembayaran').val();
		// console.log("metode"+Metode);
		var Jadi = (parseInt(Cash) + parseInt(Debit));
		if (parseInt(Jadi) > parseInt(TotalBayar)){
			var Selisih =  parseInt(Cash) - parseInt(TotalBayar);
			$('#UangKembali').val(to_rupiah(Selisih));
		}else{
			$('#UangKembali').val('');
		}	
	}

	function HitungKembalianDebit() {
		var Debit = $('#UangDebit').val();
		if ($('#UangCash').val()=='') {
			var Cash = 0;
		}else{
			var Cash = $('#UangCash').val();
		}
		var TotalBayar = $('#TotalBayarHidden').val();
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

	function cekIsi(){
		if($('[id="HapusBaris"]').length < 2){
			return false;
		}
		$('[id="HapusBaris"]').each(function() {
			if($(this).parent().parent().find("#pencarian_kode2").val() == ""){
				$(this).parent().parent().remove();
			}
		});
		return confirm('Apakah anda yakin menyimpan Transaksi ini ??');
	}

	function getpot(idp, hargaawal, idv) {
		var diskon=hargaawal;
		$.ajax({
			'async': false,
			type: 'GET',
			url: linke+'Penjualan/getDiskon',
			dataType: 'json',
			success: function(data){
				$.each(data, function(index, item) {
					if (item.id_pelanggan == idp && item.id_varian_harga == idv) {
						diskon = hargaawal - item.rekom_harga;
						return false;
					}
				})
			}
		});
		return diskon;
	}

	function bayar_cek(){
		if ($('#UangDebit').val()=='') {
			var Debit = 0;
		}else{
			var Debit = $('#UangDebit').val();
		}

		if ($('#UangCash').val()=='') {
			var Cash = 0;
		}else{
			var Cash = $('#UangCash').val();
		}


		var kodecustomer = document.getElementById('id_pelanggan').value;
		// var bayar = document.getElementById('UangCash').value;
		// var bayar_debit = document.getElementById('UangCash').value;
		var total_bayar = document.getElementById('TotalBayarHidden2').value;

		var Jadi = (parseInt(Cash) + parseInt(Debit));
		console.log('Jadi'+Jadi);
		console.log('total_bayar'+total_bayar);
		if(Jadi < total_bayar){
			$.get(linke+"Penjualan/getTop/" + kodecustomer, $(this).serialize())
      .done(function(data) {
      	console.log(data)
        if (data === 'open') {
          $('#xpay2').hide();
          $('#Simpan').prop('disabled', false);
        }else{
          $('#xpay2').show();
          $('#Simpan').prop('disabled', true);
        }
      });
    }else if(Jadi > total_bayar){
    	// $('#xpay2').fadeOut('slow');
      $('#xpay2').hide();
			$('#Simpan').prop('disabled', false);
    } 
    }
    
    // function edit(idne) {
    
    //     //document.getElementById('formAksi').reset();
    //     $.ajax({
  
    //       url : linke+'Penjualan/get_penjualan/'+idne,
    //       type: "GET",
    //       dataType: "JSON",
    //       success: function(result) {
    //                  $('#TotalBayar').html(to_rupiah(result.total_harga));
    //                  // var kapa = document.getElementById("TotalBayar");
    //         //     kapa.innerHTML = result.total_harga;
    //         //     kapa.style.display = "block";
  
    //       }, error: function (jqXHR, textStatus, errorThrown) {
    //         alert('Error get data from ajax');
    //       }
    //     });
    // }	
  
//   function BarisBaruID(idne){
      
//       $.getJSON(linke+'Penjualan/get_detail_penjualan/'+idne, {
//                       format: "json"
//                   })
//                           .done(function (datae) {
//                           $.each(datae, function (key, val) {
//                               var Nomor = $('#tableTransaksi tbody tr').length +1;
//                               var Baris = "<tr>";
//                               Baris += "<td>"+Nomor+"</td>";
  
//                               // 1
//                               Baris += "<td>";
//                               Baris += "<input autocomplete='off' required  type='text' class='form-control' value='"+val.kode_barcode_varian+"' name='kode_barang[]' id='pencarian_kode' placeholder='Ketik Nama Pelanggan' readonly>  ";
//                               Baris += "<div id='hasil_pencarian' class='hasil_pencarian'></div>";
//                               Baris += "</td>";
  
//                               // 2
//                               Baris += "<td><input required type='text' class='form-control col-md' id='harga_jual' value='"+val.nama_barang+"-"+val.warna+"-"+val.satuan+"-("+val.meter+")' name='harga_jual[]' readonly></td>";
  
//                               //3
//                               // Baris += "<td>";
//                               // Baris += "<input required  type='hidden' name='harga_satuan[]'> <input type='text' id='id_barang' name='id_barang[]' /> <input type='text' id='id_varian_harga' name='id_varian_harga[]' />";
//                               // Baris += "<span></span>";
//                               // Baris += "</td>";
  
//                               // 4
//                               Baris += "<td><input required type='text' class='form-control col-md' id='harga_diskon' value='"+to_rupiah(val.harga_jual)+"' name='harga_diskon[]' readonly> </td>";
  
//                               Baris += "<td><input required type='text' class='form-control col-md' id='harga_diskon' value='"+val.qty+"' name='harga_diskon[]' readonly> </td>";
  
//                               Baris += "<td><input required type='text' class='form-control col-md' id='harga_diskon' value='"+to_rupiah(val.total_harga)+"' name='harga_diskon[]' readonly> </td>";
  
  
  
//                               // 5
//                               // Baris += "<td>";
//                               // Baris += "<input  required type='hidden' name='sub_total[]'>";
//                               // Baris += '<span></span>';
//                               // Baris += "</td>";
//                             //   Baris += "<td><button type='button' class='btn btn-danger' onclick='hapuse("+val.id_detail_penjualan+")'><i class='fa fa-times' style='color:white;'></i></button></td>";
                          
//                               Baris += "</tr>";
  
//                               $('#tableTransaksi').append(Baris);
//                           // Fokus Input
//                           // $('#tableTransaksi tbody tr').each(function(){
//                           // 	$(this).find('td:nth-child(2) input').focus();
//                           // });
//                           })	
  
                          
//                       })
                           
      
//   }

  function hapuse(id){
	// var id_penjualan = 
	var nota = document.getElementById('no_nota').value;  
    if (confirm('Are you sure delete this data?')) {
      $.ajax ({
          url : linke+"Penjualan/penjualan_delete/"+id+'/'+nota,
          type: "POST",
          dataType: "JSON",
          success: function(data) {
              // setTimeout(function(){
//                    Batal();
//                }, 1000);
              // swal_berhasil(); 
              // setTimeout(function(){
              //     reload_table();
			  // }, 1000);
			  setTimeout(function(){
			  	BarisBaruID(idne);
			  }, 1000);
			  setTimeout(function(){ 	
				  edit(idne);
			  }, 1000);	  
          }, error: function (jqXHR, textStatus, errorThrown) {
              swal({ title:"ERROR", text:"Error delete data", type: "warning", closeOnConfirm: true}); 
              $('#btnSave').text('save'); $('#btnSave').attr('disabled',false); 
          }
      });
  }
}