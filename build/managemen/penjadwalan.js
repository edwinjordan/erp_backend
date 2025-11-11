function get_karyawan() {
	$('#get_karyawan'+mdl).modal('show');
}

function runningFormatter(value, row, index) {
   return index+1;
}

function actionpilihbarang(value, row, index){
  // var str = row.nama_barang;
  // var res = str.replace('"', '|');
  // res = res.replace('"', '|');
  return '<div class="btn-group" role="group" aria-label="...">'
  +'<a href="#" onclick="pilihDatabarang(\''+row.kode_karyawan+'\')" class="btn btn-success">Pilih</a></div>';
}


function pilihDatabarang(kode){
  // var res = nama.replace('|', '"');
  // res = res.replace('|', '"');
  document.getElementById('kode_karyawan').value = kode;
  //document.getElementById('id_barange').value = kode;

  //     var txtFirstNumberValue = document.getElementById('qty').value;
  //     var txtSecondNumberValue = document.getElementById('harga_beli').value;
  //     var result = parseInt(txtFirstNumberValue) * parseInt(txtSecondNumberValue);
  //     if (!isNaN(result)) {
  //        document.getElementById('subtotal').value = result;
  //     }

  // var Total = 0;    
  // Total = parseInt(Total) + parseInt(result);
  // document.getElementById('total').value = Total;
 // var SubTotal = parseInt(Harga) * parseInt(jumlahBeli);    

  $('#get_karyawan'+mdl).modal('hide');
  //document.getElementById('ambil_get_barang').value = res;
}  

$('#formdata').on('submit',function(e) {
		e.preventDefault();
		var str = $( "#formdata").serialize();
	        $.ajax({
            type: "POST",
            url : linke+"Penjadwalan/show_tanggal",
            data :str,
        	beforeSend: function(msg){$('#proses').text('Please wait...');},
            success: function(msg){
                var js_msg=JSON.parse(''+msg+'');
                $('#karyawan').show(500);
				$('#data_form').show(500);
				$('#tombol').show(500);
                $('#data_form').html(js_msg.tabel);
                $('#karyawan').html(js_msg.karyawan);
                $('#tombol').html(js_msg.tombol);
                $('#proses').text('Tampilkan');
            }
        });
});

aksiClose();
function saveData() {
		var str = $( "#form_akses").serialize();
        $.ajax({
                type: "POST",
                url : linke+"Penjadwalan/save",
                data :str,
            	beforeSend: function(msg){$('#simpan').text('Please wait...');},
                success: function(msg){
                	if (msg==1) {
                		window.location.assign(linke+"Penjadwalan/add_data");
                	}
                }
            });
}

function aksiClose() {
		$('#karyawan').hide(500);
		$('#data_form').hide(500);
		$('#tombol').hide(500);
}