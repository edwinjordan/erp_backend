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
        });
    $("#filter_all").click(function () {
       var url= linke+"Laporan_lunas_jual/get_giro_penjualan_tampil";
       var tgl_1=$("#tgl_1").val();
       var tgl_2=$("#tgl_2").val();
       if (tgl_1 != "" && tgl_2!="") {
         //console.log(url+"?tgl_1="+tgl_1+"&tgl_2="+tgl_2);
              $('#table').bootstrapTable('refresh', {url: linke+'Laporan_lunas_jual/get_giro_penjualan_tampil/' + tgl_1 + '/' + tgl_2});
          saldo_asli = 0;
       }else {
         alert('Silahkan Masukkan Tanggal');
       }

    });

    function cus_nama(value, row, index){
        return row.nama_pelanggan + ' , ' + row.kota_pelanggan;
    }

    function sales_nama(value, row, index){
        return row.nama_karyawan + ' , ' + row.kota_karyawan;
    }

	function runningFormatter(value, row, index) {
        return index+1;
    }
    
    function actionsaldo(value, row, index){
		saldo_asli =  saldo_asli + (row.debit_transaksi_master - row.kredit_transaksi_master);
    	return to_rupiah(saldo_asli);
    }
    function actiondetail(value){
    	// return '<div class="btn-group" role="group" aria-label="..."><a href="#" onclick="detailnya(\''+id+'\')" type="button" class="btn btn-primary"><span aria-hidden="true"></span>Detail Transaksi</a></div>';
      // return '<div class="btn-group" role="group" aria-label="..."><a href="#" onclick="ubah(\''+id+'\')" type="button" class="btn btn-primary"><span aria-hidden="true"></span>Edit</a></div>';

      return '<div class="btn-group" role="group" aria-label="..."><a href="#" onclick="detail_transaksi_faktur(\''+value+'\')" type="button" class="btn btn-primary"><span aria-hidden="true"></span>Faktur</a></div>';
    }

    function detail_transaksi_faktur(id){
      var $table_penjualan_detail_master = $('#table_penjualan_detail_master');
      $table_penjualan_detail_master.bootstrapTable('refresh', {
          url: 'Laporan_lunas_jual/get_giro_penjualan_tampil_id/'+id
      });
      saldo_asli = 0;
      $('#detail_transaksi_master').modal('show');
    }
    function ubah(id) {
      // console.log(id);
      $.ajax({
          url : linke+"Laporan_lunas_jual/get_giro_penjualan_tampil_id/" + id,//id barang
          type: "GET",
          dataType: "JSON",
          success: function(data_log)
          {
            console.log(data_log);
            $('#id_master').val(data_log.kode_transaksi_master);
            $('#id_faktur').val(data_log.no_faktur);
            $('#pemasukan').val(data_log.debit_transaksi_master);
            //$('#pengeluaran').val(data_log.kredit_transaksi_master);

          },
          error: function (jqXHR, textStatus, errorThrown)
          {
              alert('Error get data from ajax');
          }
      });
      $('#modal-6').modal('show');
    }
    function detailnya(no_faktur){
    	var $pembayaran_hutang_table = $('#pembayaran_hutang_table');
		$pembayaran_hutang_table.bootstrapTable('refresh', {
		    url: 'Laporan_lunas_jual/get_pembayaran_hutang_tampiloke/'+no_faktur
		});
    saldo_asli = 0;
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
    		return to_rupiah(row.debit_transaksi_master);
    	}else{
    		if(row.debit_transaksi_master==0){
    			return to_rupiah(row.debit_transaksi_master);
    		}else{
    			return '<a type="button" class="btn btn-default">'+to_rupiah(row.debit_transaksi_master)+'</a>';
    		}
    	}
    }
    function cekstatuskebijakandebitpem(value, row, index){
      if(row.kebijakan_transaksi_master==0){
        return to_rupiah(row.debit_sum);
      }else{
        if(row.debit_sum==0){
          return to_rupiah(row.debit_sum);
        }else{
          return '<a type="button" class="btn btn-default">'+to_rupiah(row.debit_sum)+'</a>';
        }
      }
    }
    function cekstatuskebijakankreditpem(value, row, index){
      if(row.kebijakan_transaksi_master==0){
        return to_rupiah(row.kredit_sum);
      }else{
        if(row.kredit_sum==0){
          return to_rupiah(row.kredit_sum);
        }else{
        //   return '<a type="button" class="btn btn-default" onclick="ubahkebijakan(\''+row.faktur_bp+'\')">'+jumlah_titik(row.kredit_sum)+'</a>';
        
            return '<a type="button" class="btn btn-default">'+to_rupiah(row.kredit_sum)+'</a>';
        }
      }
    }
    function cekstatuskebijakankredit(value, row, index){
    	if(row.kebijakan_transaksi_master==0){
    		return to_rupiah(row.kredit_transaksi_master);
    	}else{
    		if(row.kredit_transaksi_master==0){
    			return to_rupiah(row.kredit_transaksi_master);
    		}else{
    // 			return '<a type="button" class="btn btn-default" onclick="ubahkebijakan(\''+row.faktur_bp+'\')">'+jumlah_titik(row.kredit_transaksi_master)+'</a>';
    			return '<a type="button" class="btn btn-default" >'+to_rupiah(row.kredit_transaksi_master)+'</a>';
    		}
    	}
    }

    function ubahkebijakan(id){
      $.ajax({
          url : linke+"Laporan_lunas_jual/get_giro_penjualan_tampil_id/" + id,//id barang
          type: "GET",
          dataType: "JSON",
          success: function(data_log)
          {
            console.log(data_log);
            $('#id_mastere').val(data_log.kode_transaksi_master);
            $('#id_fakture').val(data_log.no_faktur);
            $('#pemasukane').val(data_log.kredit_transaksi_master);
            //$('#pengeluaran').val(data_log.kredit_transaksi_master);

          },
          error: function (jqXHR, textStatus, errorThrown)
          {
              alert('Error get data from ajax');
          }
      });
      $('#modal-7').modal('show');
    }

  var tanpa_pembagi = document.getElementById('pemasukan');
  tanpa_pembagi.addEventListener('keyup', function(e)
  {
    tanpa_pembagi.value = formatpembagi(this.value);
  });

  var tanpa_pembagi1 = document.getElementById('pengeluaran');
  tanpa_pembagi1.addEventListener('keyup', function(e)
  {
    tanpa_pembagi1.value = formatpembagi(this.value);
  });

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

   function actiondetaile(value){
    return '<div class="btn-group" role="group" aria-label="..."><a href="#" onclick="detail_nota(\''+value+'\')" type="button" class="btn btn-danger"><span aria-hidden="true"></span>Detail Transaksi</a></div>';
  }

  function detail_nota(id){
    //$('#modal-2').modal('show');
    // $('#id_penjualane').val(id);
    $('#id_penjualane2').val(id);
  
    $("#modal-2").modal("show", function(){
    console.log("dapat");	
  
    });
    $.ajax({
      type: "POST",
      url: linke+"Penjualan/nota_det/"+id,
      success:function(html){
        $("#notaData2").html(html);
      }
  });
  }