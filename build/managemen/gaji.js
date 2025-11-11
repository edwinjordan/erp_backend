let dataBarang;
	$(document).ready(function(){
		// init
		BarisBaru(); // init "baris baru"
		getDataPegawai();


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
		Baris += "<input autocomplete='off' required  type='text' class='form-control' name='nama[]' id='pencarian_kode' placeholder='Ketik Nama Karyawan'> <input type='hidden' id='kode_karyawan' name='kode_karyawan[]' /><input type='hidden' id='id_karyawan' name='id_karyawan[]' /> ";
		Baris += "<div id='hasil_pencarian' class='hasil_pencarian'></div>";
		Baris += "</td>";

		// 2
		Baris += "<td><input required type='text' class='form-control col-md' id='gaji_pokok' name='gaji_pokok[]' ></td>";

		//3
		// Baris += "<td>";
		// Baris += "<input required  type='hidden' name='harga_satuan[]'> <input type='text' id='id_barang' name='id_barang[]' /> <input type='text' id='id_varian_harga' name='id_varian_harga[]' />";
		// Baris += "<span></span>";
		// Baris += "</td>";

		// 4
        Baris += "<td><input required type='text' class='form-control col-md' id='bonus' name='bonus[]' > </td>";

        Baris += "<td><input required type='text' class='form-control col-md' id='uang_makan' name='uang_makan[]' > </td>";
        
        Baris += "<td><input required type='text' class='form-control col-md' id='potongan' name='potongan[]' > </td>";

        Baris += "<td><input required type='text' class='form-control col-md' id='kasbon' name='kasbon[]' > </td>";

        Baris += "<td><input required type='text' class='form-control col-md' id='total_gaji' name='total_gaji[]' > </td>";

        // var okeylokasi = '<select name="id_keuangan" class="form-control">';
        // $.getJSON(linke+'Gaji/keuangan/', {
        //     format: "json"
        // })
        //         .done(function (datae) {
        //             $.each(datae, function (key, val) {
                        
        //                      okeylokasi += '<option value="' + val.kode_nama_keuangan + '" >' + val.nama_keuangan + '</option>';
                      
                        
        //             });
        //               okeylokasi += '</select></div></div>';
        //               var f = document.getElementById("keuangane");
        //               f.innerHTML= okeylokasi;  

        //          })
        // Baris += "<td><div id='keuangane'></div></td>";         
		// Baris += "<td><button  class='btn btn-danger' id='HapusBaris'><i class='fa fa-times' style='color:white;'></i></button></td>";
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
            if(dataBarang[i].nama.match(reg)){
                foundItem.push(dataBarang[i])
            }
        }

        let htmlFoundItem =  "<ul id='daftar-autocomplete' class='daftar-autocomplete'>";
        foundItem.forEach((b) => {
            htmlFoundItem += `
                <li>
                    <b>Kode</b> : 
                    <span id='kodenya'>` + b.kode_karyawan + `</span> <br />
                    <span id='nama'>` + b.nama + `</span> <br />
                    <span id='gaji_karyawan' style='display:none;'>` + b.gaji_karyawan + `</span> <br />
                    <span id='id_karyawan' style='display:none;'>` + b.id_karyawan + `</span> <br />
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

$(document).on('click', '#daftar-autocomplete li', function(){
    $(this).parent().parent().parent().find('input').val($(this).find('span#nama').html());

    var Indexnya 	  = $(this).parent().parent().parent().parent().index();
    var kodeKaryawan 	  = $(this).find('span#kodenya').html();
    var namaKaryawan 	  = $(this).find('span#nama').html();
    var gajiKaryawan 	  = $(this).find('span#gaji_karyawan').html();
    var idKaryawan 	  = $(this).find('span#id_karyawan').html();
    var bln = document.getElementById("bln").value;
    var tahun = document.getElementById("tahun").value;
    var bonuse = getbonus(idKaryawan);
    var potongane = getpotongane(idKaryawan, bln,tahun);
    var uangmakan = getuangmakan(idKaryawan, bln,tahun);
    var kasBon = getkasbon(kodeKaryawan, bln,tahun);
    if (isNaN(kasBon)) {
        kasBon = 0;
    }
    //  return val;
    


    var total_gaji = (parseInt(gajiKaryawan)+parseInt(bonuse)+parseInt(uangmakan))-(parseInt(potongane)+parseInt(kasBon));
    // var VarianHarga   = $(this).find('span#variannya').html();
    // var Warna 		  = $(this).find('span#warnanya').html();
    // var Harganya 	  = $(this).find('span#harganya').html();
    // var IdBarang 	  = $(this).find('span#id_barang').html();
    // var IdVarianHarga = $(this).find('span#id_varian').html();

    $('#tableTransaksi tbody tr:eq('+Indexnya+') td:nth-child(2)').find('div#hasil_pencarian').hide();
    $('#tableTransaksi tbody tr:eq('+Indexnya+') td:nth-child(2) input#kode_karyawan').val(kodeKaryawan);
   // $('#tableTransaksi tbody tr:eq('+Indexnya+') td:nth-child(2) input#kode_pelanggan').val(kodeKaryawan);
    $('#tableTransaksi tbody tr:eq('+Indexnya+') td:nth-child(2) input#id_karyawan').val(idKaryawan);
    $('#tableTransaksi tbody tr:eq('+Indexnya+') td:nth-child(3) input#gaji_pokok').val(gajiKaryawan);
    $('#tableTransaksi tbody tr:eq('+Indexnya+') td:nth-child(4) input#bonus').val(bonuse);
    $('#tableTransaksi tbody tr:eq('+Indexnya+') td:nth-child(5) input#uang_makan').val(uangmakan);
    $('#tableTransaksi tbody tr:eq('+Indexnya+') td:nth-child(6) input#potongan').val(potongane);
    $('#tableTransaksi tbody tr:eq('+Indexnya+') td:nth-child(7) input#kasbon').val(kasBon);
    $('#tableTransaksi tbody tr:eq('+Indexnya+') td:nth-child(8) input#total_gaji').val(total_gaji);
    // $('#tableTransaksi tbody tr:eq('+Indexnya+') td:nth-child(3)').html(NamaBarang + '&nbsp;'+ Warna + '&nbsp;'+ VarianHarga);
    // $('#tableTransaksi tbody tr:eq('+Indexnya+') td:nth-child(4) input').val('');
    // $('#tableTransaksi tbody tr:eq('+Indexnya+') td:nth-child(4) input#id_barang').val(IdBarang);
    // $('#tableTransaksi tbody tr:eq('+Indexnya+') td:nth-child(4) input#id_barange').val(IdBarang);
    // $('#tableTransaksi tbody tr:eq('+Indexnya+') td:nth-child(4) input#id_varian_harga').val(IdVarianHarga);
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
    //HitungTotalBayar();
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
event.stopPropagation();
});

function getbonus(idKaryawan) {
    var bonuse=0;
    $.ajax({
        'async': false,
        type: 'GET',
        url: linke+'Gaji/getBonus/'+idKaryawan,
        dataType: 'json',
        success: function(data){
            $.each(data, function(index, item) {
                // if (item.id_karyawan == idKaryawan) {
                    bonuse = item.bonus_karyawan;
                    //console.log('bonuse'+bonuse);
                    return false;
                //}
            })
        }
    });
    return bonuse;
}

function getpotongane(idKaryawan,bln,tahun){
    var potongane=0;
    $.ajax({
        'async': false,
        type: 'GET',
        url: linke+'Gaji/getPotongan/'+idKaryawan+'/'+bln+'/'+tahun,
        dataType: 'json',
        success: function(data){
            $.each(data, function(index, item) {
                // if (item.id_karyawan == idKaryawan) {
                    var jumlah_bolos = item.sts_masuk - item.bolos;

                    if(jumlah_bolos > 3){
                        potongane = jumlah_bolos * 50000;
                    }else{
                        potongane = 0
                    }
                    //potongane = item.bonus * item.jumlah_poin;
                   // potongane = parseInt(item.sts_masuk) * parseInt(item.denda_bolos);
                    console.log('bonuse'+potongane);
                    return false;
                //}
            })
        }
    });
    return potongane;
}

function getuangmakan(idKaryawan,bln,tahun){
    var uangmakan=0;
    $.ajax({
        'async': false,
        type: 'GET',
        url: linke+'Gaji/getUangMakan/'+idKaryawan+'/'+bln+'/'+tahun,
        dataType: 'json',
        success: function(data){
            $.each(data, function(index, item) {
                // if (item.id_karyawan == idKaryawan) {
                 //   var jumlah_bolos = item.sts_masuk - item.bolos;

                    // if(jumlah_bolos > 3){
                    //     potongane = jumlah_bolos * 50000;
                    // }else{
                    //     potongane = 0
                    // }
                    //potongane = item.bonus * item.jumlah_poin;
                    uangmakan = parseInt(item.sts_masuk) * parseInt(item.uangmakan);
                    // console.log('bonuse'+potongane);
                    return false;
                //}
            })
        }
    });
    return uangmakan;
}

function getkasbon(kodeKaryawan,bln,tahun){
    var kasBon=0;
    $.ajax({
        'async': false,
        type: 'GET',
        url: linke+'Gaji/getkasbon/'+kodeKaryawan+'/'+bln+'/'+tahun,
        dataType: 'json',
        success: function(data){
            $.each(data, function(index, item) {
                // if (item.id_karyawan == idKaryawan) {
                 //   var jumlah_bolos = item.sts_masuk - item.bolos;

                    // if(jumlah_bolos > 3){
                    //     potongane = jumlah_bolos * 50000;
                    // }else{
                    //     potongane = 0
                    // }
                    //potongane = item.bonus * item.jumlah_poin;
                    kasBon = parseInt(item.kredit);
                    // console.log('bonuse'+potongane);
                    return false;
                //}
            })
        }
    });
    return kasBon;
}

function getDataPegawai(){
		$.ajax({
			url: linke + 'Gaji/getDataPegawai',  
			method : 'POST',
			dataType : 'JSON',
			success : function(json)
			{
				console.log(json);
				dataBarang = json.datanya;
			}
		})
}