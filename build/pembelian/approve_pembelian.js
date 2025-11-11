 var zonk =''
 var save_method;
 var table;
 var link = "<?php echo site_url('Penjadwalan_order')?>";
 var halaman = '1';
  
 function swal_berhasil() { swal({ title:"SUCCESS", text:"Berhasil", type: "success", closeOnConfirm: true}); }
 function swal_error(msg) { swal({ title:"ERROR", text: msg, type: "warning", closeOnConfirm: true});  }

 

function actionpilihbarang(value, row, index){
  var str = row.nama_barang;
  var res = str.replace('"', '|');
  res = res.replace('"', '|');
  return '<div class="btn-group" role="group" aria-label="...">'
  +'<a href="#" onclick="pilihDatabarang('+row.id_barang+',\''+res+'\',\''+row.harga_beli+'\')" class="btn btn-success">Pilih</a></div>';
}

function runningFormatter(value, row, index) {
   return index+1;
}

 // $(document).ready(function(){
 //                HitungTotalBayar();
 //                // $('.qty').change(function() {
 //                //     total();
 //                // });
 //                $('.ambil_get_barang').change(function() {
 //                    HitungTotalBayar();
 //                });                
 //            });


var saldo_asli=0;
$(document).ready(function () {
    //Date range picker
        $('#tgl_1').datepicker({
          format: "yyyy-mm-dd",
          autoclose: true
        });
        $('#tgl_2').datepicker({
          format: "yyyy-mm-dd",
          autoclose: true
        });
        $('#tanggal').datepicker({
          format: "yyyy-mm-dd",
          autoclose: true
        });
});
$("#filter_all").click(function () {
       var url=linke+"Approve_pembelian/get_list_pembelian/";
       var tgl_1=$("#tgl_1").val();
       var tgl_2=$("#tgl_2").val();
       if (tgl_1 != "" && tgl_2!="") {
         //console.log(url+"?tgl_1="+tgl_1+"&tgl_2="+tgl_2);
              $('#table').bootstrapTable('refresh', {url: linke+'Approve_pembelian/get_list_pembelian/' + tgl_1 + '/' + tgl_2});
              saldo_asli = 0;
       }else {
         alert('Silahkan Masukkan Tanggal');
       }

});

function barangdet(value, row, index){
    return ''+row.nama_barang+'-'+row.satuan+'-'+row.warna+'';
}

function actiondetail(id){
      return '<div class="btn-group" role="group" aria-label="..."><a href="#" onclick="detailnya(\''+id+'\')" type="button" class="btn btn-primary"><span aria-hidden="true"></span>Detail Pembelian</a></div>';
}

function actionfaktur(id){
  return '<a href="#" onclick="detail_faktur(\''+id+'\')" >'+id+'</a>';
}

function detailnya(no_faktur){
    var $pembayaran_hutang_table = $('#pembayaran_hutang_table');
    $pembayaran_hutang_table.bootstrapTable('refresh', {
        url: 'Approve_pembelian/get_pembelian_detail_tampil/'+no_faktur
    });
 //   document.getElementById('no_faktur').value = no_faktur;
    $('[name="no_faktur"]').val(no_faktur);
    $('#detail_transaksi').modal('show');
}    

function detail_faktur(no_faktur){
  $('#detail_transaksine').modal('show');

  $.ajax({
    type: "POST",
    url: linke+"Approve_pembelian/nota_pembelian/"+no_faktur,
    success:function(html){
      $("#notaData").html(html);
    }
  });

  // $('[name="no_faktur"]').val(no_faktur);
  
}


function inputqty(value, row, index){
    return '<input type="hidden" name="id_barange[]" value="'+row.id_barang+'" class="form-control"><input type="text" name="qty[]" id="qty'+row.id_varian_harga+'" value="'+row.qty+'" class="qty form-control" readonly>';
}

function inputharga_beli(value, row, index){
  return '<input type="text" name="ambil_get_barang[]" id="ambil_get_barang'+row.id_varian_harga+'" class="ambil_get_barang form-control" onkeyup="cek_harga(this.value,'+row.id_varian_harga+')"><input type="hidden" id="ambil_get_kode" name="ambil_get_kode"><div class="form-group"><input type="hidden" name="cekemailin" value="0" id="cekemailin'+row.id_varian_harga+'"><div class="md-form" id="dur_pass2'+row.id_varian_harga+'"><label class="btn_2 rounded" for="inputSuccess" id="erpr2'+row.id_varian_harga+'" style="display: none;"><i class="fa fa-check label-danger"></i> Harga Tidak Sesuai Dengan Harga Lama (Harga Lama : '+row.harga_beli+')</label></div><label class="btn_1 rounded" for="inputError"  id="scpr2'+row.id_varian_harga+'" style="display: none;"><i class="fa fa-times label-success"></i> Harga  Sesuai Dengan Harga Lama </label></div>';
}

function inputsubtotal(id){
  return '<input type="text" name="subtotal[]" id="subtotal'+id+'" class="form-control" readonly>';
}

function get_barang(){
  $('#get_barang').modal('show');
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

function pilihDatabarang(kode, nama, harga){
  var res = nama.replace('|', '"');
  res = res.replace('|', '"');
  document.getElementById('ambil_get_kode').value = kode;
  document.getElementById('ambil_get_barang').value = harga;

  var txtFirstNumberValue = document.getElementById('qty').value;
  var txtSecondNumberValue = document.getElementById('ambil_get_barang').value;
  var result = parseInt(txtFirstNumberValue) * parseInt(txtSecondNumberValue);
  if (!isNaN(result)) {
         document.getElementById('subtotal').value = result;
  }

  // var Total = 0; 
  // var Totale = 0;    
  // Total = parseInt(Total) + parseInt(result);
  // // if( document.getElementById('potongan').value!=''){
  // //   var txtTigaNumberValue = document.getElementById('potongan').value;
  // //    Totale = parseInt(Total) - parseInt(txtTigaNumberValue);  
  // // }else {
  // //    Totale = Total;
  // // }

  // document.getElementById('total').value = Total;

  $('#get_barang').modal('hide');
}

 function cek_harga(val,id) {

        // console.log('<?php echo base_url("Registrasi/cekref/");?>/'+val);
       // console.log(""+id);
        $.ajax({

        url: linke+'Approve_pembelian/cek_harga/'+val+'/'+id,

        dataType:'json',

        success:function(response){

           console.log(response);

          if (response=="true") {

              document.getElementById('scpr2'+id).removeAttribute('style');

              $("#dur_pass2"+id).attr('class','col-sm-10 has-success');

              $("#erpr2"+id).attr('style','display: none;');

              $('[name="cekemailin"]').val('1');

              var txtFirstNumberValue = document.getElementById('qty'+id).value;
              
              var txtSecondNumberValue = document.getElementById('ambil_get_barang'+id).value;
              var result = parseInt(txtFirstNumberValue) * parseInt(txtSecondNumberValue);
              if (!isNaN(result)) {
                     document.getElementById('subtotal'+id).value = result;
              }
              var SubTotal = document.getElementById('subtotal'+id).value;
              // console.log('salah'+SubTotal);
                var Total = 0;
   // var SubTotal = 0;
              $('#pembayaran_hutang_table tbody tr').each(function(){
                //  SubTotal += $(this).find('td:nth-child(5) input').val();
                // console.log('salah'+SubTotal);
                if($(this).find('td:nth-child(5) input').val() > 0)
                {
                     var SubTotal = $(this).find('td:nth-child(5) input').val();
                     console.log('salah'+SubTotal);   
                     Total = parseInt(Total) + parseInt(SubTotal);
                     
                } 
              }); 
              $('#TotalBayare').html(to_rupiah(Total)); 
              $('#totalBayar').val(Total);
              $('#TotalBayarHidden').val(Total);
              $('#bayar').val(Total);
              
              // var Total = 0;    
              // Total += result;
              // console.log('Total'+Total);
              // document.getElementById('total').value = Total;

             // $("#spassnext").attr('disabled','disabled');

              // console.log('benar');

            }else{

              document.getElementById('erpr2'+id).removeAttribute('style');

             // document.getElementById('spassnext').removeAttribute('disabled');

              $("#dur_pass2"+id).attr('class','col-sm-10 has-error');

              $("#scpr2"+id).attr('style','display: none;');

              $('[name="cekemailin"]').val('0');

              var txtFirstNumberValue = document.getElementById('qty'+id).value;
              var txtSecondNumberValue = document.getElementById('ambil_get_barang'+id).value;
              var result = parseInt(txtFirstNumberValue) * parseInt(txtSecondNumberValue);
              if (!isNaN(result)) {
                     document.getElementById('subtotal'+id).value = result;
              }
                var Total = 0;
   // var SubTotal = 0;
              $('#pembayaran_hutang_table tbody tr').each(function(){
                //  SubTotal += $(this).find('td:nth-child(5) input').val();
                // console.log('salah'+SubTotal);
                if($(this).find('td:nth-child(5) input').val() > 0)
                {
                     var SubTotal = $(this).find('td:nth-child(5) input').val();
                     console.log('salah'+SubTotal);   
                     Total = parseInt(Total) + parseInt(SubTotal);
                     
                } 
              });  
              $('#TotalBayare').html(to_rupiah(Total)); 
              $('#totalBayar').val(Total);
              $('#TotalBayarHidden').val(Total);
              $('#bayar').val(Total);
              // var Total = 0;    
              // Total += parseInt(result);
              // document.getElementById('total').value = Total;

              // console.log('salah');

            }

        },

        error:function(){

          alert('ERROR ! Check your internet connection');

          //$(id).html('ERROR');

        }

      });

      }

function HitungTotalBayar() {
  
  //   document.getElementById('subtotal'+id).value = result;
    // var SubTotal = $('subtotal').val();
    // if (!isNaN(SubTotal)) {
    // Total += SubTotal;
    // }
    // console.log('salah'+Total);
    // $('#tableTransaksi tbody tr').each(function(){
    //   if($(this).find('td:nth-child(6) input').val() > 0)
    //   {
    //     var SubTotal = $(this).find('td:nth-child(6) input').val();
    //     Total = parseInt(Total) + parseInt(SubTotal);
    //   }
    // });

    // $('#TotalBayar').html(to_rupiah(Total));
    // $('#TotalBayarHidden').val(Total);

    // $('#UangCash').val('');
    // $('#UangDebit').val('');
    // $('#UangKembali').val('');
  }      

function sum() {
  //var txtSijiNumberValue = document.getElementById('total').value;
    var txtFirstNumberValue = document.getElementById('totalBayar').value;
    var txtSecondNumberValue = document.getElementById('potongan').value;
    var result = parseInt(txtFirstNumberValue) - parseInt(txtSecondNumberValue);
      if (!isNaN(result)) {
         document.getElementById('bayar').value = result;
      }
}  
