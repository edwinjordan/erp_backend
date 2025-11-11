$(document).ready(function(){
	

// AJax pelanggan (Penjualan)
   let dataBarang;
	$(document).ready(function(){
		// init
		BarisBaru(); // init "baris baru"
		$( 'html, body' ).animate( { scrollTop: 0 }, 0 );
		$('#id_pelanggan').change(function(){ // get id pelanggan
			const id = $(this).val();
			
			$.ajax({
				url: linke+"Po_penjualan/ajax_pelanggan",  
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
			HitungTotalBayar();
		});
});
});	

$(document).on('keyup','#pencarian_kode',function(){
	console.log("keyup");
	var keyword = $(this).val();
	var Indexnya = $(this).parent().parent().index();
	$.ajax({
		url : linke+'Po_penjualan/pencarian_kode/',
		method : 'POST',
		dataType : 'JSON',
		data : {keyword :keyword},
		success : function(json)
		{
				console.log(json); 
				if(json.status == 1)
				{
					$('#tableTransaksi tbody tr:eq('+Indexnya+') td:nth-child(2)').find('div#hasil_pencarian').show('fast');
					$('#tableTransaksi tbody tr:eq('+Indexnya+') td:nth-child(2)').find('div#hasil_pencarian').html(json.datanya);
				}
				if(json.status == 0)
				{
					$('#tableTransaksi tbody tr:eq('+Indexnya+') td:nth-child(2)').find('div#hasil_pencarian').html('Data tidak ditemukan !!');
					// $('#tableTransaksi tbody tr:eq('+Indexnya+') td:nth-child(3)').html('');
					// $('#tableTransaksi tbody tr:eq('+Indexnya+') td:nth-child(4) input').val('');
					// $('#tableTransaksi tbody tr:eq('+Indexnya+') td:nth-child(4) span').html('');
					// $('#tableTransaksi tbody tr:eq('+Indexnya+') td:nth-child(5) input').prop('disabled', true).val('');
					// $('#tableTransaksi tbody tr:eq('+Indexnya+') td:nth-child(6) input').val(0);
					// $('#tableTransaksi tbody tr:eq('+Indexnya+') td:nth-child(6) span').html('');
				}
			}
		})
})
// $(document).on('click', '#daftar-autocomplete li', function(){
// 	$(this).parent().parent().parent().find('input').val($(this).find('span#kodenya').html());

// 	var Indexnya 	  = $(this).parent().parent().parent().parent().index();
// 	var NamaBarang 	  = $(this).find('span#barangnya').html();
// 	var VarianHarga   = $(this).find('span#variannya').html();
// 	var Warna 		  = $(this).find('span#warnanya').html();
// 	var Harganya 	  = $(this).find('span#harganya').html();
// 	var IdBarang 	  = $(this).find('span#id_barang').html();
// 	var IdVarianHarga = $(this).find('span#id_varian').html();
// 	var idp = document.getElementById("id_pelanggan").value;
// 	var diskon = getpot(idp, Harganya, IdVarianHarga);
// 	console.log("diskon "+diskon);
// 	$('#tableTransaksi tbody tr:eq('+Indexnya+') td:nth-child(2)').find('div#hasil_pencarian').hide();
// 	$('#tableTransaksi tbody tr:eq('+Indexnya+') td:nth-child(3)').html(NamaBarang + '&nbsp;'+ Warna + '&nbsp;'+ VarianHarga);
// 	$('#tableTransaksi tbody tr:eq('+Indexnya+') td:nth-child(4) input').val(diskon);
// 	$('#tableTransaksi tbody tr:eq('+Indexnya+') td:nth-child(4) input#id_barang').val(IdBarang);
// 	$('#tableTransaksi tbody tr:eq('+Indexnya+') td:nth-child(4) input#id_varian_harga').val(IdVarianHarga);
// 	$('#tableTransaksi tbody tr:eq('+Indexnya+') td:nth-child(4) span').html(to_rupiah(Harganya));
// 	$('#tableTransaksi tbody tr:eq('+Indexnya+') td:nth-child(5) input').removeAttr('disabled').val(1);
// 	$('#tableTransaksi tbody tr:eq('+Indexnya+') td:nth-child(6) input').val(diskon);
// 	$('#tableTransaksi tbody tr:eq('+Indexnya+') td:nth-child(6) span').html(to_rupiah(diskon));

// 	var IndexIni = Indexnya + 1;
// 	var TotalIndex = $('#tableTransaksi tbody tr').length;
// 	// if(IndexIni == TotalIndex){
// 	// 	BarisBaru();
// 	// 	$('html, body').animate({ scrollTop: $(document).height() }, 0);
// 	// }
// 	// else {
// 	// 	$('#tableTransaksi tbody tr:eq('+Indexnya+') td:nth-child(5) input').focus();
// 	// }
// 	HitungTotalBayar();
// });
$(document).on('click', '#daftar-autocomplete li', function(){
		$(this).parent().parent().parent().find('input').val($(this).find('span#kodenya').html());

		var Indexnya 	  = $(this).parent().parent().parent().parent().index();
		var NamaBarang 	  = $(this).find('span#barangnya').html();
		var VarianHarga   = $(this).find('span#variannya').html();
		var Warna 		  = $(this).find('span#warnanya').html();
		var Harganya 	  = $(this).find('span#harganya').html();
		var IdBarang 	  = $(this).find('span#id_barang').html();
		var IdVarianHarga = $(this).find('span#id_varian').html();
		var idp = document.getElementById("id_pelanggan").value;
		
		var diskon = getpot(idp, Harganya, IdVarianHarga);

		$('#tableTransaksi tbody tr:eq('+Indexnya+') td:nth-child(2)').find('div#hasil_pencarian').hide();
		$('#tableTransaksi tbody tr:eq('+Indexnya+') td:nth-child(3)').html(NamaBarang + '&nbsp;'+ Warna + '&nbsp;'+ VarianHarga);
		$('#tableTransaksi tbody tr:eq('+Indexnya+') td:nth-child(4) input').val(diskon);
		$('#tableTransaksi tbody tr:eq('+Indexnya+') td:nth-child(4) input#harga_jual').val(Harganya);
		$('#tableTransaksi tbody tr:eq('+Indexnya+') td:nth-child(4) input#id_barang').val(IdBarang);
		$('#tableTransaksi tbody tr:eq('+Indexnya+') td:nth-child(4) input#id_varian_harga').val(IdVarianHarga);
		$('#tableTransaksi tbody tr:eq('+Indexnya+') td:nth-child(4) span').html(to_rupiah(Harganya));
		$('#tableTransaksi tbody tr:eq('+Indexnya+') td:nth-child(5) input').removeAttr('disabled').val(1);
		$('#tableTransaksi tbody tr:eq('+Indexnya+') td:nth-child(6) input').val(diskon);
		$('#tableTransaksi tbody tr:eq('+Indexnya+') td:nth-child(6) span').html(to_rupiah(diskon));

		var IndexIni = Indexnya + 1;
		var TotalIndex = $('#tableTransaksi tbody tr').length;
		if(IndexIni == TotalIndex){
			BarisBaru();
			$('html, body').animate({ scrollTop: $(document).height() }, 0);
		}
		else {
			$('#tableTransaksi tbody tr:eq('+Indexnya+') td:nth-child(5) input').focus();
		}
		HitungTotalBayar();
	});
$(document).on('keyup','#jumlah_beli',function(){
	var Indexnya = $(this).parent().parent().index();
	var Harga = $('#tableTransaksi tbody tr:eq('+Indexnya+') td:nth-child(4) input').val();
	var jumlahBeli = $(this).val();

	var SubTotal = parseInt(Harga) * parseInt(jumlahBeli);
	if(SubTotal > 0){
		var SubTotalVal = SubTotal;
		SubTotal = to_rupiah(SubTotal);
	} else {
		SubTotal = '';
		var SubTotalVal = 0;
	}

	$('#tableTransaksi tbody tr:eq('+Indexnya+') td:nth-child(6) input').val(SubTotalVal);
	$('#tableTransaksi tbody tr:eq('+Indexnya+') td:nth-child(6) span').html(SubTotal);
	HitungTotalBayar();
});
$('#UangCash').keyup(function(){
	HitungKembalian();
})


function BarisBaru(){

	var Nomor = $('#tableTransaksi tbody tr').length +1;

	// 0
	var Baris = "<tr>";
	Baris += "<td>"+Nomor+"</td>";

	// 1
	Baris += "<td>";
	Baris += "<input autocomplete='off' required  type='text' class='form-control' name='kode_barang[]' id='pencarian_kode' placeholder='Ketik Kode / Nama Barang'>";
	Baris += "<div id='hasil_pencarian'></div>";
	Baris += "</td>";

	// 2
	Baris += "<td></td>";

	// 3
	Baris += "<td>";
	Baris += "<input required  type='hidden' name='harga_satuan[]'> <input type='hidden' id='id_barang' name='id_barang[]' /> <input type='hidden' id='id_varian_harga' name='id_varian_harga[]' />";
	Baris += "<span></span>";
	Baris += "</td>";

	// 4
	// Baris += "<td><input required type='text' class='form-control col-md' id='jumlah_beli' name='jumlah_beli[]' disabled></td>";
	Baris += "<td>";
		Baris += "<div style='display: flex;'>"
		Baris += '<button id="minus_jumlah" type="button" class="btn btn-success pull-left" style="padding: 5px;"><i class="fa fa-minus fa-fw"></i></button>';
		Baris += "<input required type='text' class='form-control col-md' id='jumlah_beli' name='jumlah_beli[]' style='width: 62px; margin: 0 5px;'><input type='hidden' id='id_barang' name='id_barang[]' /><input type='hidden' id='id_varian_harga' name='id_varian_harga[]' />";
		Baris += '<button id="plus_jumlah" type="button" class="btn btn-success pull-left" style="padding: 5px;"><i class="fa fa-plus fa-fw"></i></button>';
		Baris += "</div>"
		Baris += "</td>";

	// 5
	Baris += "<td>";
	Baris += "<input  required type='hidden' name='sub_total[]'>";
	Baris += '<span></span>';
	Baris += "</td>";
	
	Baris += "<td><button  class='btn btn-danger' id='HapusBaris'><i class='fa fa-times' style='color:white;'></i></button></td>";
	Baris += "</tr>";

	$('#tableTransaksi').append(Baris);
		// Fokus Input
		$('#tableTransaksi tbody tr').each(function(){
			$(this).find('td:nth-child(2) input').focus();

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

	function HitungTotalBayar()
	{
		var Total = 0;
		$('#tableTransaksi tbody tr').each(function(){
			if($(this).find('td:nth-child(6) input').val() > 0)
			{
				var SubTotal = $(this).find('td:nth-child(6) input').val();
				Total = parseInt(Total) + parseInt(SubTotal);
			}
		});

		$('#TotalBayar').html(to_rupiah(Total));
		$('#TotalBayarHidden').val(Total);

		$('#UangCash').val('');
		$('#UangKembali').val('');
	}
	function HitungKembalian()
	{
		var Cash = $('#UangCash').val();
		var TotalBayar = $('#TotalBayarHidden').val();

		if (parseInt(Cash) > parseInt(TotalBayar)){

			var Selisih = parseInt(Cash) - parseInt(TotalBayar);
			$('#UangKembali').val(to_rupiah(Selisih));

		}
		else{
			$('UangKembali').val('');
		}
	}
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

function changeUser() {
		var Total = 0;
		var idp = document.getElementById("id_pelanggan").value;
		var i=0;
		var Indexnya = $(this).parent().parent().parent().parent().index();
		len = $('#tableTransaksi tbody tr').length;
		$('#tableTransaksi tbody tr').each(function(){
			if ((len-i) != 1) {
				var input4 = $(this).find('td:nth-child(4) input').val();
				var Harganya = $(this).find('td:nth-child(4) input#harga_jual').val();
				var idv = $(this).find('td:nth-child(4) input#id_varian_harga').val();
				var idb = $(this).find('td:nth-child(4) input#id_barang').val();
				var diskon = getpot(idp, Harganya, idv);
				console.log("diskon "+diskon);
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

function getDataBarang(){
		$.ajax({
			url: linke+"Po_penjualan/getDataBarang",  
			method : 'POST',
			dataType : 'JSON',
			success : function(json)
			{
				console.log(json);
				dataBarang = json.datanya;
			}
		})
}

function getpot(idp, hargaawal, idv) {
		var diskon=hargaawal;
		$.ajax({
			'async': false,
			type: 'GET',
			url: linke+'Po_penjualan/getDiskon',
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
