let dataBarang;
$(document).ready(function(){
    // init
    BarisBaruID(idne);
    edit(idne); // init "baris baru"
    //getDataPelanggan();


    // add "baris baru" button click
    // $('#BarisBaru').on('click',function(){
    // 	BarisBaru();
    // });
    // remove "baris baru" button click
    // $(document).on('click','#HapusBaris',function(e){
    // 	e.preventDefault();
    // 	$(this).parent().find('#kode_pelanggan').val("hapus");
    // 	$(this).parent().parent().hide();
    // });
});

function BarisBaruID(idne){

$.getJSON(linke+'Pembelian_bpb/get_detail_pembelian_bg/'+idne, {
                format: "json"
            })
                    .done(function (datae) {
                    $.each(datae, function (key, val) {
                        var Nomor = $('#tableTransaksi tbody tr').length +1;
                        var Baris = "<tr>";
                        Baris += "<td>"+Nomor+"</td>";

                        // 1
                        Baris += "<td>";
                        Baris += "<input autocomplete='off' required  type='text' class='form-control' name='kode_barang[]' value='"+val.no_faktur+"' id='pencarian_kode'  readonly>";
                        Baris += "<div id='hasil_pencarian' class='hasil_pencarian' style='background: white;'></div>";
                        Baris += "</td>";

                        // 2
                        Baris += "<td><input required type='text' class='form-control col-md' id='harga_jual' value='"+val.tgl_pembayaran+"' name='harga_jual[]' readonly></td>";

                        // 3
                        // Baris += "<td>";
                        // Baris += "<input required  type='hidden' name='harga_satuan[]'> <input type='hidden' id='id_barang' name='id_barang[]' /> <input type='hidden' id='id_varian_harga' name='id_varian_harga[]' />";
                        // Baris += "<span></span>";
                        // Baris += "</td>";

                        // 4
                        Baris += "<td><input required type='text' class='form-control col-md' id='jumlah_beli' name='jumlah_beli[]' value='"+val.nominal+"' readonly></td>";

                        // 5
                        // Baris += "<td>";
                        // Baris += "<input  required type='hidden' name='sub_total[]'>";
                        // Baris += '<span></span>';
                        // Baris += "</td>";
                        
                        Baris += "</tr>";

                        $('#tableTransaksi').append(Baris);
    
                    // Fokus Input
                    // $('#tableTransaksi tbody tr').each(function(){
                    // 	$(this).find('td:nth-child(2) input').focus();
                    // });
                    })	

                    
                })
                     

}

function edit(idne) {
    
    //document.getElementById('formAksi').reset();
    $.ajax({

      url : linke+'Pembelian_bpb/get_tot_pembelian/'+idne,
      type: "GET",
      dataType: "JSON",
      success: function(result) {
                 $('#TotalBayar').html(to_rupiah(result.nominal));
                 // var kapa = document.getElementById("TotalBayar");
        //     kapa.innerHTML = result.total_harga;
        //     kapa.style.display = "block";

      }, error: function (jqXHR, textStatus, errorThrown) {
        alert('Error get data from ajax');
      }
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
