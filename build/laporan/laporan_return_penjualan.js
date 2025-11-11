var saldo_asli=0;
$(document).ready(function () {
    //Date range picker
        $('#tgl_1').datepicker({
          format: "dd-mm-yyyy",
          autoclose: true
        });
        $('#tgl_2').datepicker({
          format: "dd-mm-yyyy",
          autoclose: true
        });
        });
    $("#filter_all").click(function () {
       var url=linke+"Laporan/get_return_penjualan_tampil/";
       var tgl_1=$("#tgl_1").val();
       var tgl_2=$("#tgl_2").val();
       if (tgl_1 != "" && tgl_2!="") {
         //console.log(url+"?tgl_1="+tgl_1+"&tgl_2="+tgl_2);
              $('#table').bootstrapTable('refresh', {url: linke+'Laporan/get_return_penjualan_tampil/' + tgl_1 + '/' + tgl_2});
              saldo_asli = 0;
       }else {
         alert('Silahkan Masukkan Tanggal');
       }

    });
    
    function jenis(value){
        if(value==1){
            return "Faktur Bebas";
        }else{
            return "Faktur Jenis";
        }
    }
    function cus(value, row, index){
        return row.nama_customer + ' , ' + row.kota_customer;
    }

    function sales(value, row, index){
        return row.nama_salesman + ' , ' + row.kota_salesman;
    }

	function runningFormatter(value, row, index) {
        return index+1;
    }
    
    function total(value, row, index){
        var totalnya = parseFloat(row.jumlah_barang)*parseFloat(row.harga_penjualan);
        return totalnya;
    }

    
    function actionsaldo(value, row, index){
		saldo_asli =  parseFloat(saldo_asli) + (parseFloat(row.jumlah_barang) * parseFloat(row.harga_penjualan));
    	return saldo_asli;
    }
    function actiondetail(id){
    	return '<div class="btn-group" role="group" aria-label="..."><a href="#" onclick="detailnya(\''+id+'\')" type="button" class="btn btn-primary"><span aria-hidden="true"></span>Detail Return</a></div>';
    }
    function detailnya(no_faktur){
    	var $pembayaran_hutang_table = $('#pembayaran_hutang_table');
		$pembayaran_hutang_table.bootstrapTable('refresh', {
		    url: 'Laporan/get_return_detail_tampil/'+no_faktur
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
    		return row.debit_transaksi_master;
    	}else{
    		if(row.debit_transaksi_master==0){
    			return row.debit_transaksi_master;
    		}else{
    			return '<a type="button" class="btn btn-default">'+row.debit_transaksi_master+'</a>';
    		}
    	}
    }
    function cekstatuskebijakankredit(value, row, index){
    	if(row.kebijakan_transaksi_master==0){
    		return row.kredit_transaksi_master;
    	}else{
    		if(row.kredit_transaksi_master==0){
    			return row.kredit_transaksi_master;
    		}else{
    			return '<a type="button" class="btn btn-default">'+row.kredit_transaksi_master+'</a>';
    		}
    	}
    }

     function nota_jalan(){
        var tgl_1=$("#tgl_1").val();
        var tgl_2=$("#tgl_2").val();
     //   console.log('penjualan/print_rugi_laba_salesman/'+tgl_1+'/'+tgl_2);
        $('#area-1').load(linke+'Laporan/print_return_penjualan/'+tgl_1+'/'+tgl_2, function() {
          printDiv('area-1');
           /*var $transaksi_supplier = $('#tabel_order');
            $transaksi_supplier.bootstrapTable('refresh', {
                url: 'hasil_validasi_penjualan_keranjang/'
            });*/
        });
        
        //console.log(id);
    }

    function printDiv(elementId) {
        $('#'+elementId).show();
        var a = document.getElementById('printing-css').value;
        var b = document.getElementById(elementId).innerHTML;
        window.frames["print_frame"].document.title = document.title;
        window.frames["print_frame"].document.body.innerHTML = '<style>' + a + '</style>' + b;
        window.frames["print_frame"].window.focus();
        window.frames["print_frame"].window.print();

        $('#'+elementId).hide();
    }