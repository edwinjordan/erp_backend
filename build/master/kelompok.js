 function uppercase() {
        var x = document.getElementById("nama_salesman");
        x.value = x.value.toUpperCase();
    }
    function uppercasea() {
        var x = document.getElementById("alamat_salesman");
        x.value = x.value.toUpperCase();
    }
	function tampil_tambah(){
		$('[name="kode_salesman"]').val('');
		$('[name="nama_salesman"]').val('');
		$('[name="alamat_salesman"]').val('');
		$('#modal-1').modal('show');
        $('.modal').on('shown.bs.modal', function() {
          $(this).find('[autofocus]').focus();
        });
	}

	function runningFormatter(value, row, index) {
        return index+1;
    }
	function actionPeriode(value, row, index){
        return '<div class="btn-group" role="group" aria-label="..."><a href="#" onclick="editdata(\''+row.id_kelompok+'\',\''+row.kode_kelompok+'\',\''+row.nama_kelompok+'\')" type="button" class="btn btn-primary"><span aria-hidden="true"></span>Edit</a></div>';
	}
	function editdata(id, nama, kota){
		$('[name="kode_salesman"]').val(id);
		$('[name="nama_salesman"]').val(nama);
		$('[name="alamat_salesman"]').val(kota);
		$('#modal-1').modal('show');
        $('.modal').on('shown.bs.modal', function() {
          $(this).find('[autofocus]').focus();
        });
	}