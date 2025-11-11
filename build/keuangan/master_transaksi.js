function runningFormatter(value, row, index) {
        return index+1;
}

function aksi_ubah_laporan(value, row, index){
    	var pecahsatu = row.tgl_transaksi_master.split(" ");
    	if(pecahsatu[0]== new Date()){
    		return '<div class="btn-group" role="group" aria-label="..."><a href="#" onclick="confirmubah(\''+row.kode_transaksi_master+'\', '+row.no_faktur+', '+row.kode_nama_keuangan+', '+row.kredit_transaksi_master+', '+row.debit_transaksi_master+', \''+row.keterangan_transaksi_master+'\')"  type="button" class="btn btn-primary"><span aria-hidden="true"></span>Ubah</a></div>';
    	}else{
    		return '<div class="btn-group" role="group" aria-label="..."><a href="#" type="button" class="btn btn-primary" disabled><span aria-hidden="true"></span>Ubah</a></div>';
    	}
 }