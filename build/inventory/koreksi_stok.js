let dataBarang;
	$(document).ready(function(){
		// init
		var idp = document.getElementById("id_lokasi").value;
		BarisBaru(); // init "baris baru"
		getDataBarang(idp);


		// add "baris baru" button click
		$('#BarisBaru').on('click',function(){
			BarisBaru();
		});
		// remove "baris baru" button click
		$(document).on('click','#HapusBaris',function(e){
			e.preventDefault();
			$(this).parent().parent().remove();
			var Nomor = 1;
			$('#tableTransaksi tbody tr').each(function(){
				$(this).find('td:nth-child(1)').html(Nomor);
				Nomor++;
			})
		});
});

function BarisBaru(){
		var Nomor = $('#tableTransaksi tbody tr').length +1;
		
		// 0
		var Baris = "<tr>";
		Baris += "<td>"+Nomor+"</td>";

		// 1
		Baris += "<td>";
		Baris += "<input autocomplete='off' required  type='text' class='form-control' name='kode_barang[]' id='pencarian_kode' placeholder='Ketik Kode / Nama Barang'> ";
		Baris += "<div id='hasil_pencarian' class='hasil_pencarian'></div>";
		Baris += "</td>";

		// 2
		Baris += "<td></td>";

		//3
		// Baris += "<td>";
		// Baris += "<input required  type='hidden' name='harga_satuan[]'> <input type='text' id='id_barang' name='id_barang[]' /> <input type='text' id='id_varian_harga' name='id_varian_harga[]' />";
		// Baris += "<span></span>";
		// Baris += "</td>";

		// 4
		Baris += "<td><input required type='text' class='form-control col-md' id='jumlah_beli' name='jumlah_beli[]' > <input type='hidden' id='id_barang' name='id_barang[]' /> <input type='hidden' id='id_varian_harga' name='id_varian_harga[]' /></td>";
		Baris += "<td><input required type='text' class='form-control col-md' id='jumlah_koreksi' name='jumlah_koreksi[]' ></td>";
		Baris += "<td><input required type='hidden' class='form-control col-md' id='batch' name='batch[]' value='"+batch+"'><input type='text' class='form-control col-md' id='alasan_koreksi' name='alasan_koreksi[]' ></td>";
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


$(document).on('keyup','#pencarian_kode', function(){
		console.log("keyup");
		var keyword = $(this).val();
		var Indexnya = $(this).parent().parent().index();
		
		clearInterval(intervalPress);
		intervalPress = setTimeout(() => {
			cariBarang(keyword, Indexnya)
		}, 300);
	})
	let intervalPress;
	function cariBarang(keyword, Indexnya){
		let foundItem = [];
			for(let i = 0; i < dataBarang.length; i++){
				let reg = new RegExp('^' + keyword + '.*$', 'i');
				if(dataBarang[i].kode_barang.match(reg)){
					foundItem.push(dataBarang[i])
				}
			}

			let htmlFoundItem =  "<ul id='daftar-autocomplete' class='daftar-autocomplete'>";
			foundItem.forEach((b) => {
				htmlFoundItem += `
					<li>
						<b>Kode</b> : 
						<span id='kodenya'>` + b.kode_barang + `</span> <br />
						<span id='barangnya'>` + b.nama_barang + `</span> <br />
						<span id='variannya'>` + b.satuan + ` (` + b.meter + ` Pcs)</span><br/>
						<span id='nama_lokasi'>` + b.nama_lokasi + `</span> <br />
						<span id='harganya' style='display:none;'>`  + b.harga + `</span>
						<span id='warnanya' style='display:none;'>` + b.warna + `</span>
						<span id='id_varian' style='display:none;'>` + b.id_varian_harga + `</span>
						<span id='id_barang' style='display:none;'>` + b.id_barang + `</span>
						<span id='stok_gudang' style='display:none;'>` + b.stok_gudang + `</span>
						<span id='kode_barcode_varian' style='display:none;'>` + b.kode_barcode_varian + `</span>
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
	}

	// hide and show "hasil pencarian"
	$(window).click(function() {
		var Indexnya = $(this).parent().parent().index();
		$('.hasil_pencarian').hide();
	});
	$(document).on('click', '#pencarian_kode', function(){
		$('.hasil_pencarian').hide();
		var Indexnya = $(this).parent().parent().index();
		$('#tableTransaksi tbody tr:eq('+Indexnya+') td:nth-child(2)').find('div#hasil_pencarian').show();
    event.stopPropagation();
	});

	// click item "hasil cari"
	$(document).on('click', '#daftar-autocomplete li', function(){
		$(this).parent().parent().parent().find('input').val($(this).find('span#kodenya').html());

		var Indexnya 	  = $(this).parent().parent().parent().parent().index();
		var NamaBarang 	  = $(this).find('span#barangnya').html();
		var VarianHarga   = $(this).find('span#variannya').html();
		var Warna 		  = $(this).find('span#warnanya').html();
		var Harganya 	  = $(this).find('span#harganya').html();
		var IdBarang 	  = $(this).find('span#id_barang').html();
		var IdVarianHarga = $(this).find('span#id_varian').html();
		var StokGudang = $(this).find('span#stok_gudang').html();
		var KodeVarian = $(this).find('span#kode_barcode_varian').html();
		var idp = document.getElementById("id_lokasi").value;

		var stoke = getlokasi(idp, IdBarang, IdVarianHarga, StokGudang,KodeVarian);

		$('#tableTransaksi tbody tr:eq('+Indexnya+') td:nth-child(2)').find('div#hasil_pencarian').hide();
		$('#tableTransaksi tbody tr:eq('+Indexnya+') td:nth-child(3)').html(NamaBarang + '&nbsp;'+ Warna + '&nbsp;'+ VarianHarga);
		$('#tableTransaksi tbody tr:eq('+Indexnya+') td:nth-child(4) input').val('');
		$('#tableTransaksi tbody tr:eq('+Indexnya+') td:nth-child(4) input#id_barang').val(IdBarang);
		$('#tableTransaksi tbody tr:eq('+Indexnya+') td:nth-child(4) input#id_barange').val(IdBarang);
		$('#tableTransaksi tbody tr:eq('+Indexnya+') td:nth-child(4) input#id_varian_harga').val(IdVarianHarga);
		$('#tableTransaksi tbody tr:eq('+Indexnya+') td:nth-child(4) input#jumlah_beli').val(stoke);
		// $('#tableTransaksi tbody tr:eq('+Indexnya+') td:nth-child(5) input').removeAttr('disabled').val(1);
		// $('#tableTransaksi tbody tr:eq('+Indexnya+') td:nth-child(6) input').val(Harganya);
		// $('#tableTransaksi tbody tr:eq('+Indexnya+') td:nth-child(6) span').html(Harganya);

		var IndexIni = Indexnya + 1;
		var TotalIndex = $('#tableTransaksi tbody tr').length;
		if(IndexIni == TotalIndex){
			//BarisBaru();
			$('html, body').animate({ scrollTop: $(document).height() }, 0);
		}
		else {
			$('#tableTransaksi tbody tr:eq('+Indexnya+') td:nth-child(5) input').focus();
		}
		//HitungTotalBayar();
	});

function getDataBarang(idp){

		var id_lokasi = document.getElementById('id_lokasi').value;
		console.log('idp'+ idp);
		$.ajax({
			url: linke + 'Stock_opname/getDataBarangAll/'+id_lokasi,  
			method : 'POST',
			dataType : 'JSON',
			success : function(json)
			{
				console.log(json);
				dataBarang = json.datanya;
			}
		})
}

function getlokasi(idp, idbarang, idvarian, stok_gudang,kode_varian){
	var stoke = stok_gudang
	var kode_var = kode_varian
	$.ajax({
			'async': false,
			type: 'GET',
			url: linke+'Stock_opname/getStoke/'+idp+'/'+idbarang+'/'+idvarian,
			dataType: 'json',
			success: function(data){
				$.each(data, function(index, item) {
					if (item.id_lokasi == idp && item.id_varian_harga == idvarian && item.id_barang==idbarang) {
						stoke = item.stok_gudang;
						kode_var = item.kode_barcode_varian;
						console.log('stoke'+stoke);
						return false;
					}
				})
			}
	});
		return stoke;
}

$('#id_lokasi').change(function(){ // get id pelanggan
	const idne = $(this).val();
	// console.log('id_lokasi'+idne);
	getDataBarang(idne);
	changeLokasi();
});		


function changeLokasi() {
		var Total = 0;
		var idp = document.getElementById("id_lokasi").value;
		var i=0;
		var Indexnya = $(this).parent().parent().parent().parent().index();
		len = $('#tableTransaksi tbody tr').length;
		$('#tableTransaksi tbody tr').each(function(){
			if ((len-i) != 1) {
				var input4 = $(this).find('td:nth-child(4) input').val();
				var Stoke = $(this).find('td:nth-child(4) input#jumlah_beli').val();
				var idv = $(this).find('td:nth-child(4) input#id_varian_harga').val();
				var idb = $(this).find('td:nth-child(4) input#id_barang').val();
				var kode_varian = $(this).find('td:nth-child(2) input#kode_barang').val();
				var stoke = getlokasi(idp,idb,idv,Stoke,kode_varian);
				

				$(this).find('td:nth-child(2) span').html(kode_varian)
				$(this).find('td:nth-child(4) span').html(stoke);
				$(this).find('td:nth-child(4) input').val(stoke);
				$(this).find('td:nth-child(4) input#jumlah_beli').val(stoke);
				$(this).find('td:nth-child(4) input#id_barang').val(idb);
				$(this).find('td:nth-child(4) input#id_varian_harga').val(idv);
				// $(this).find('td:nth-child(6) input').val(diskon);
				// $(this).find('td:nth-child(6) span').html(diskon);

				// $('#tableTransaksi tbody tr:eq('+Indexnya+') td:nth-child(2)').find('div#hasil_pencarian').hide();
				// $('#tableTransaksi tbody tr:eq('+Indexnya+') td:nth-child(3)').html(NamaBarang + '&nbsp;'+ Warna + '&nbsp;'+ VarianHarga);
				// $('#tableTransaksi tbody tr:eq('+Indexnya+') td:nth-child(4) input').val('');
				// $('#tableTransaksi tbody tr:eq('+Indexnya+') td:nth-child(4) input#id_barang').val(IdBarang);
				// $('#tableTransaksi tbody tr:eq('+Indexnya+') td:nth-child(4) input#id_barange').val(IdBarang);
				// $('#tableTransaksi tbody tr:eq('+Indexnya+') td:nth-child(4) input#id_varian_harga').val(IdVarianHarga);
				// $('#tableTransaksi tbody tr:eq('+Indexnya+') td:nth-child(4) input#jumlah_beli').val(stoke);
				i++;
			}else{
				return false;
			}
		});

		//HitungTotalBayar();
}
