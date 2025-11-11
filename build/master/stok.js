function runningFormatter(value, row, index) {
   return index+1;
}

function tampilkan_berdasarkan_perintah_status(){
        var i = document.getElementById('perintah_status');
    	var id = i.options[i.selectedIndex].value;
    	
    	var salesman_perintah = $('#table_stock_ok');
        salesman_perintah.bootstrapTable('refresh', {
            url: 'Stok/get_stock_form/'+id
        });
}

function actionPeriode(value, row, index){
        return '<div class="btn-group" role="group" aria-label="..."><a href="#" onclick="editdata(\''+row.id_detail_gudang+'\',\''+row.stok_min+'\')" type="button" class="btn btn-danger"><span aria-hidden="true"></span>Set Stok Min</a></div>';
}

function editdata(id, nama){
		$('[name="id_detail_gudang"]').val(id);
		$('[name="stok_min"]').val(nama);
		$('#modal-1'+mdl).modal('show');
        $('.modal').on('shown.bs.modal', function() {
          $(this).find('[autofocus]').focus();
        });
}