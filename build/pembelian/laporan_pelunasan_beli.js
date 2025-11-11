function aksi_detail(value){
    return '<div class="btn-group" role="group" aria-label="..."><a href="#" onclick="detailnya_aksi(\''+value+'\')" type="button" class="btn btn-primary"><span aria-hidden="true"></span>Faktur</a></div>';
  }

function actiondetaile(value){
  return '<div class="btn-group" role="group" aria-label="..."><a href="#" onclick="detailnya_aksi_modal(\''+value+'\')" type="button" class="btn btn-danger"><span aria-hidden="true"></span>Detail Transaksi</a></div>';
}

function detailnya_aksi_modal(id){
  //$('#modal-2').modal('show');
  // $('#id_penjualane').val(id);
  $('#id_penjualane2').val(id);

  $("#modal-2").modal("show", function(){
  console.log("dapat");	

  });
  $.ajax({
    type: "POST",
    url: linke+"Laporan_lunas_beli/nota_besar2/"+id,
    success:function(html){
      $("#notaData2").html(html);
    }
});
}

  function detailnya_aksi(id){
      var $table_faktur_bp = $('#table_faktur_bp');
      $table_faktur_bp.bootstrapTable('refresh', {
          url: 'Laporan_lunas_beli/get_giro_pembelian_tampil_id/'+id
      });
      saldo_asli = 0;
      $('#detail_transaksi_faktur_bp').modal('show');
  }

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
        });
    var saldo_asli=0;
    $("#filter_all").click(function () {
       var url= linke+"Laporan_lunas_beli/get_giro_pembelian_tampil_group/";
       var tgl_1=$("#tgl_1").val();
       var tgl_2=$("#tgl_2").val();
       if (tgl_1 != "" && tgl_2!="") {
         //console.log(url+"?tgl_1="+tgl_1+"&tgl_2="+tgl_2);
              $('#table').bootstrapTable('refresh', {url: linke+'Laporan_lunas_beli/get_giro_pembelian_tampil_group/' + tgl_1 + '/' + tgl_2});
              saldo_asli = 0;
       }else {
         alert('Silahkan Masukkan Tanggal');
       }

    });

    function supplierbro(value, row, index){
        return row.nama+' , '+row.kota;
    }
	function runningFormatter(value, row, index) {
        return index+1;
    }
    
    function actionsaldo(value, row, index){
		saldo_asli =  parseFloat(saldo_asli) + (parseFloat(row.debit_transaksi_master) - parseFloat(row.kredit_transaksi_master));
    	return saldo_asli;
    }
    function actiondetail(id){
    	return '<div class="btn-group" role="group" aria-label="..."><a href="#" onclick="detailnya(\''+id+'\')" type="button" class="btn btn-primary"><span aria-hidden="true"></span>Detail Transaksi</a></div>';
    }
    function detailnya(no_faktur){
    	var $pembayaran_hutang_table = $('#pembayaran_hutang_table');
  		$pembayaran_hutang_table.bootstrapTable('refresh', {
  		    url: 'Laporan_lunas_beli/get_pembayaran_hutang_tampil/'+no_faktur
  		});
    	$('#detail_transaksi').modal('show');
    }
    function actiontanggal(tanggal){
    	var pecahsatu = tanggal.split(" ");
    	var pecahdua = pecahsatu[0];
    	var pecahtiga = pecahdua.split("-");
    	return pecahtiga[2]+ '-' +pecahtiga[1]+ '-' +pecahtiga[0]+' '+pecahsatu[1];
    }
    function cekstatuskebijakandebit(value, row, index){
    	if(row.kebijakan_transaksi_master==0){
    		return row.debit_sum;
    	}else{
    		if(row.debit_sum==0){
    			return row.debit_sum;
    		}else{
    			return '<a type="button" class="btn btn-default">'+row.debit_sum+'</a>';
    		}
    	}
    }
    function cekstatuskebijakankredit(value, row, index){
      if(row.kebijakan_transaksi_master==0){
        return row.kredit_sum;
      }else{
        if(row.kredit_sum==0){
          return row.kredit_sum;
        }else{
          return '<a type="button" class="btn btn-default">'+row.kredit_sum+'</a>';
        }
      }
    }
    function cekstatuskebijakankreditpem(value, row, index){
    	if(row.kebijakan_transaksi_master==0){
    		return to_rupiah(row.kredit_transaksi_master);
    	}else{
    		if(row.kredit_transaksi_master==0){
    			return to_rupiah(row.kredit_transaksi_master);
    		}else{
    			return '<a type="button" class="btn btn-default">'+to_rupiah(row.kredit_transaksi_master)+'</a>';
    		}
    	}
    }
    function cekstatuskebijakandebitpem(value, row, index){
      if(row.kebijakan_transaksi_master==0){
        return to_rupiah(row.debit_transaksi_master);
      }else{
        if(row.debit_transaksi_master==0){
          return to_rupiah(row.debit_transaksi_master);
        }else{
          return '<a type="button" class="btn btn-default">'+to_rupiah(row.debit_transaksi_master)+'</a>';
        }
      }
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

   function rupiaha(harga){
      return to_rupiah(harga);
   }