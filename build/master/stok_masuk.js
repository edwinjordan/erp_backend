let dataBarang;
	$(document).ready(function(){
		// init
		BarisBaru(); // init "baris baru"
		getDataBarang();


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
		Baris += "<td>";
		Baris += "<div style='display: flex;'>"
		Baris += '<button type="button" id="minus_jumlah" class="btn btn-success pull-left" style="padding: 5px;"><i class="fa fa-minus fa-fw"></i></button>';
		Baris += "<input required type='text' class='form-control col-md' id='jumlah_beli' name='jumlah_beli[]' disabled style='width: 62px; margin: 0 5px;'><input type='hidden' id='id_barang' name='id_barang[]' /><input type='hidden' id='id_varian_harga' name='id_varian_harga[]' />";
		Baris += '<button type="button" id="plus_jumlah" class="btn btn-success pull-left" style="padding: 5px;"><i class="fa fa-plus fa-fw"></i></button>';
		Baris += "</div>"
		Baris += "</td>";

		// Baris += "<input  required  type='text' class='form-control' name='harga_beli[]' id='harga_beli' > ";
		// 5
		// Baris += "<td>";
		// Baris += "<input  required type='hidden' name='sub_total[]'>";
		// Baris += '<span></span>';
		// Baris += "</td>";
		
		Baris += "<td><input required type='hidden' class='form-control col-md' id='batch' name='batch[]' value='"+batch+"'><button  class='btn btn-danger' id='HapusBaris'><i class='fa fa-times' style='color:white;'></i></button></td>";
		Baris += "</tr>";

		$('#tableTransaksi').append(Baris);
		// Fokus Input
		$('#tableTransaksi tbody tr').each(function(){
			$(this).find('td:nth-child(2) input').focus();
		});
}

function getDataBarang(){
		$.ajax({
			url: linke + 'Stock_opname/getDataBarang',  
			method : 'POST',
			dataType : 'JSON',
			success : function(json)
			{
				console.log(json);
				dataBarang = json.datanya;
			}
		})
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
						<span id='variannya'>` + b.satuan + ` (` + b.meter + ` Pcs)</span>
						<span id='harganya' style='display:none;'>`  + b.harga + `</span>
						<span id='warnanya' style='display:none;'>` + b.warna + `</span>
						<span id='id_varian' style='display:none;'>` + b.id_varian_harga + `</span>
						<span id='id_barang' style='display:none;'>` + b.id_barang + `</span>
						<span id='hargane' style='display:none;'>` + b.harga_beli + `</span>
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
		var hargaBeli = $(this).find('span#hargane').html();

		$('#tableTransaksi tbody tr:eq('+Indexnya+') td:nth-child(2)').find('div#hasil_pencarian').hide();
		$('#tableTransaksi tbody tr:eq('+Indexnya+') td:nth-child(3)').html(NamaBarang + '&nbsp;'+ Warna + '&nbsp;'+ VarianHarga);
		$('#tableTransaksi tbody tr:eq('+Indexnya+') td:nth-child(4) input').val('');
		$('#tableTransaksi tbody tr:eq('+Indexnya+') td:nth-child(4) input#id_barang').val(IdBarang);
		$('#tableTransaksi tbody tr:eq('+Indexnya+') td:nth-child(4) input#id_barange').val(IdBarang);
		$('#tableTransaksi tbody tr:eq('+Indexnya+') td:nth-child(4) input#id_varian_harga').val(IdVarianHarga);
		// $('#tableTransaksi tbody tr:eq('+Indexnya+') td:nth-child(5) input#harga_beli').val(hargaBeli);
		// $('#tableTransaksi tbody tr:eq('+Indexnya+') td:nth-child(4) span').html(to_rupiah(Harganya));
		// $('#tableTransaksi tbody tr:eq('+Indexnya+') td:nth-child(5) input').removeAttr('disabled').val(1);
		// $('#tableTransaksi tbody tr:eq('+Indexnya+') td:nth-child(6) input').val(Harganya);
		// $('#tableTransaksi tbody tr:eq('+Indexnya+') td:nth-child(6) span').html(to_rupiah(Harganya));

		var IndexIni = Indexnya + 1;
		var TotalIndex = $('#tableTransaksi tbody tr').length;
		if(IndexIni == TotalIndex){
			//BarisBaru();
			$('html, body').animate({ scrollTop: $(document).height() }, 0);
		}
		else {
			$('#tableTransaksi tbody tr:eq('+Indexnya+') td:nth-child(5) input').focus();
		}
		HitungTotalBayar();
	});

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
