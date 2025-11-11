// $(document).ready(function(){
	

// // AJax pelanggan (Penjualan)
// for(B=1; B<=1; B++){
// 	BarisBaru();
// }
// $('#BarisBaru').on('click',function(){
// 	BarisBaru();
// });
// $(document).on('click','#HapusBaris',function(e)
// {

// 	e.preventDefault();

// 	$(this).parent().parent().remove();
	
// 	var Nomor = 1;
// 	$('#tableTransaksi tbody tr').each(function(){
// 		$(this).find('td:nth-child(1)').html(Nomor);
// 		Nomor++;
// 	})
// });


// $('#id_pelanggan').change(function(){
// 	const id = $(this).val();

// 	$.ajax({
// 		url : "http://laris23.premiumcookieslimo.com/penjualan/ajax_pelanggan",
// 		data : {id :id},
// 		dataType: 'json',
// 		method : 'POST',
// 		success : function(json)
// 		{
// 				// console.log(json);
// 				$('#alamat_pelanggan').html(json.alamat);
// 				$('#telp_pelanggan').html(json.telp);
// 				$('#info_tambahan_pelanggan').html(json.info_tambahan);

// 			}
// 		});
// });


// });

// $(document).on('keyup','#pencarian_kode',function(){
// 	console.log("keyup");
// 	var keyword = $(this).val();
// 	var Indexnya = $(this).parent().parent().index();
// 	$.ajax({
// 		url : 'http://laris23.premiumcookieslimo.com/penjualan/pencarian_kode/',
// 		method : 'POST',
// 		dataType : 'JSON',
// 		data : {keyword :keyword},
// 		success : function(json)
// 		{
// 				console.log(json); 
// 				if(json.status == 1)
// 				{
// 					$('#tableTransaksi tbody tr:eq('+Indexnya+') td:nth-child(2)').find('div#hasil_pencarian').show('fast');
// 					$('#tableTransaksi tbody tr:eq('+Indexnya+') td:nth-child(2)').find('div#hasil_pencarian').html(json.datanya);
// 				}
// 				if(json.status == 0)
// 				{
// 					$('#tableTransaksi tbody tr:eq('+Indexnya+') td:nth-child(2)').find('div#hasil_pencarian').html('Data tidak ditemukan !!');
// 					// $('#tableTransaksi tbody tr:eq('+Indexnya+') td:nth-child(3)').html('');
// 					// $('#tableTransaksi tbody tr:eq('+Indexnya+') td:nth-child(4) input').val('');
// 					// $('#tableTransaksi tbody tr:eq('+Indexnya+') td:nth-child(4) span').html('');
// 					// $('#tableTransaksi tbody tr:eq('+Indexnya+') td:nth-child(5) input').prop('disabled', true).val('');
// 					// $('#tableTransaksi tbody tr:eq('+Indexnya+') td:nth-child(6) input').val(0);
// 					// $('#tableTransaksi tbody tr:eq('+Indexnya+') td:nth-child(6) span').html('');
// 				}
// 			}
// 		})
// })
// $(document).on('click', '#daftar-autocomplete li', function(){
// 	$(this).parent().parent().parent().find('input').val($(this).find('span#kodenya').html());

// 	var Indexnya 	  = $(this).parent().parent().parent().parent().index();
// 	var NamaBarang 	  = $(this).find('span#barangnya').html();
// 	var VarianHarga   = $(this).find('span#variannya').html();
// 	var Warna 		  = $(this).find('span#warnanya').html();
// 	var Harganya 	  = $(this).find('span#harganya').html();
// 	var IdBarang 	  = $(this).find('span#id_barang').html();
// 	var IdVarianHarga = $(this).find('span#id_varian').html();

// 	$('#tableTransaksi tbody tr:eq('+Indexnya+') td:nth-child(2)').find('div#hasil_pencarian').hide();
// 	$('#tableTransaksi tbody tr:eq('+Indexnya+') td:nth-child(3)').html(NamaBarang + '&nbsp;'+ Warna + '&nbsp;'+ VarianHarga);
// 	$('#tableTransaksi tbody tr:eq('+Indexnya+') td:nth-child(4) input').val(Harganya);
// 	$('#tableTransaksi tbody tr:eq('+Indexnya+') td:nth-child(4) input#id_barang').val(IdBarang);
// 	$('#tableTransaksi tbody tr:eq('+Indexnya+') td:nth-child(4) input#id_varian_harga').val(IdVarianHarga);
// 	$('#tableTransaksi tbody tr:eq('+Indexnya+') td:nth-child(4) span').html(to_rupiah(Harganya));
// 	$('#tableTransaksi tbody tr:eq('+Indexnya+') td:nth-child(5) input').removeAttr('disabled').val(1);
// 	$('#tableTransaksi tbody tr:eq('+Indexnya+') td:nth-child(6) input').val(Harganya);
// 	$('#tableTransaksi tbody tr:eq('+Indexnya+') td:nth-child(6) span').html(to_rupiah(Harganya));

// 	var IndexIni = Indexnya + 1;
// 	var TotalIndex = $('#tableTransaksi tbody tr').length;
// 	if(IndexIni == TotalIndex){
// 		BarisBaru();
// 		$('html, body').animate({ scrollTop: $(document).height() }, 0);
// 	}
// 	else {
// 		$('#tableTransaksi tbody tr:eq('+Indexnya+') td:nth-child(5) input').focus();
// 	}
// 	HitungTotalBayar();
// });

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


// function BarisBaru(){

// 	var Nomor = $('#tableTransaksi tbody tr').length +1;

// 	// 0
// 	var Baris = "<tr>";
// 	Baris += "<td>"+Nomor+"</td>";

// 	// 1
// 	Baris += "<td>";
// 	Baris += "<input autocomplete='off' required  type='text' class='form-control' name='kode_barang[]' id='pencarian_kode' placeholder='Ketik Kode / Nama Barang'>";
// 	Baris += "<div id='hasil_pencarian'></div>";
// 	Baris += "</td>";

// 	// 2
// 	Baris += "<td></td>";

// 	// 3
// 	Baris += "<td>";
// 	Baris += "<input required  type='hidden' name='harga_satuan[]'> <input type='hidden' id='id_barang' name='id_barang[]' /> <input type='hidden' id='id_varian_harga' name='id_varian_harga[]' />";
// 	Baris += "<span></span>";
// 	Baris += "</td>";

// 	// 4
// 	Baris += "<td><input required type='text' class='form-control col-md' id='jumlah_beli' name='jumlah_beli[]' disabled></td>";

// 	// 5
// 	Baris += "<td>";
// 	Baris += "<input  required type='hidden' name='sub_total[]'>";
// 	Baris += '<span></span>';
// 	Baris += "</td>";
	
// 	Baris += "<td><button  class='btn btn-danger' id='HapusBaris'><i class='fa fa-times' style='color:white;'></i></button></td>";
// 	Baris += "</tr>";

// 	$('#tableTransaksi').append(Baris);
// 		// Fokus Input
// 		$('#tableTransaksi tbody tr').each(function(){
// 			$(this).find('td:nth-child(2) input').focus();

// 		});
// 	}
// 	function to_rupiah(angka){
// 		var rev     = parseInt(angka, 10).toString().split('').reverse().join('');
// 		var rev2    = '';
// 		for(var i = 0; i < rev.length; i++){
// 			rev2  += rev[i];
// 			if((i + 1) % 3 === 0 && i !== (rev.length - 1)){
// 				rev2 += '.';
// 			}
// 		}
// 		return 'Rp. ' + rev2.split('').reverse().join('');
// 	}

// 	function HitungTotalBayar()
// 	{
// 		var Total = 0;
// 		$('#tableTransaksi tbody tr').each(function(){
// 			if($(this).find('td:nth-child(6) input').val() > 0)
// 			{
// 				var SubTotal = $(this).find('td:nth-child(6) input').val();
// 				Total = parseInt(Total) + parseInt(SubTotal);
// 			}
// 		});

// 		$('#TotalBayar').html(to_rupiah(Total));
// 		$('#TotalBayarHidden').val(Total);

// 		$('#UangCash').val('');
// 		$('#UangKembali').val('');
// 	}
// 	function HitungKembalian()
// 	{
// 		var Cash = $('#UangCash').val();
// 		var TotalBayar = $('#TotalBayarHidden').val();

// 		if (parseInt(Cash) > parseInt(TotalBayar)){

// 			var Selisih = parseInt(Cash) - parseInt(TotalBayar);
// 			$('#UangKembali').val(to_rupiah(Selisih));

// 		}
// 		else{
// 			$('UangKembali').val('');
// 		}
// 	}
// $(document).on('keydown', 'body', function(e){
// 	var charCode = ( e.which ) ? e.which : event.keyCode;

// 	if(charCode == 118) //F7
// 	{
// 		BarisBaru();
// 		return false;
// 	}

// 	if(charCode == 119) //F8
// 	{
// 		$('#UangCash').focus();
// 		return false;
// 	}
// 	if(charCode == 121) //F10
// 	{
// 		$('#Simpan').click();
// 		return false;
// 	}
	 
// });




