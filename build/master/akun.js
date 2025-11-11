 function uppercase() {
        var x = document.getElementById("nama_salesman");
        x.value = x.value.toUpperCase();
    }
    function status(value, row, index){
        if(row.status_debit_kredit==2){
            return '<div class="btn-group" role="group" aria-label="..."><a href="'+linke+'Akun/ubah_status_akun/'+row.id_transaksi_akun+'/'+row.status_debit_kredit+'" type="button" class="btn btn-success"><span aria-hidden="true"></span>Pemasukan</a></div>';
        }else{
            return '<div class="btn-group" role="group" aria-label="..."><a href="'+linke+'Akun/ubah_status_akun/'+row.id_transaksi_akun+'/'+row.status_debit_kredit+'" type="button" class="btn btn-primary"><span aria-hidden="true"></span>Pengeluaran</a></div>';
        }
    }

	function tampil_tambah(){
		$('[name="kode_salesman"]').val('');
		$('[name="nama_salesman"]').val('');
		$('#modal-1').modal('show');
        $('.modal').on('shown.bs.modal', function() {
          $(this).find('[autofocus]').focus();
        });
	}

	function runningFormatter(value, row, index) {
        return index+1;
    }
	function actionPeriode(value, row, index){
        return '<div class="btn-group" role="group" aria-label="..."><a href="#" onclick="editdata(\''+row.id_transaksi_akun+'\',\''+row.nama_transaksi_akun+'\')" type="button" class="btn btn-primary"><span aria-hidden="true"></span>Edit</a></div>';
	}
	function editdata(id, nama){
		// $('[name="kode_salesman"]').val(id);
		// $('[name="nama_salesman"]').val(nama);
         $.ajax({
            url : linke+"Akun/akun_where_id/" + id,
            type: "GET",
            dataType: "JSON",
            success: function(datasupplierwhere)
            {
                $('[name="kode_salesman"]').val(id);
                $('[name="nama_salesman"]').val(nama);
               $('[name="status_debit_kredit"]').val(datasupplierwhere.status_debit_kredit);
              //  status_debit_kredit = datasupplierwhere.status_debit_kredit;
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
            }
        });
        // var okey = '<select name="status_debit_kredit" class="form-control">';

        // $.getJSON(linke+'Akun/akune/', {
        //             format: "json"
        // })
        // .done(function (data) {
        //                     $.each(data, function (key, val) {
        //                         if(val.status_debit_kredit=='1'){
        //                             var statuse = "Pengeluaran";
        //                         }else if(val.status_debit_kredit=='2'){
        //                             var statuse ="Pemasukan";
        //                         }
        //                         if(status_debit_kredit==val.status_debit_kredit){
        //                             okey += '<option value="' + val.status_debit_kredit + '" selected >' + statuse + '</option>';
        //                         }else{
        //                             okey += '<option value="' + val.status_debit_kredit + '" >' + statuse + '</option>';
        //                         }
                                
        //                     });
        //                     okey += '</select></div></div>';
        //                    // console.log(okey);
        //                     var f = document.getElementById("status_debit_kredite");
        //                     f.innerHTML= okey;
        //                     document.getElementById('status_debit_kredite').style.display = "block";
        //                     document.getElementById('status_debit_kredit').style.display = "none";
        // })
		$('#modal-1').modal('show');
        $('.modal').on('shown.bs.modal', function() {
          $(this).find('[autofocus]').focus();
        });
	}