function runningFormatter(value, row, index) {
   return index+1;
}

function tampilkan_berdasarkan_perintah_status(){
        var i = document.getElementById('perintah_status');
    	var id = i.options[i.selectedIndex].value;
    	
    	var salesman_perintah = $('#table_stock_ok');
        salesman_perintah.bootstrapTable('refresh', {
            url: 'Stok_menipis/get_stock_menipis/'+id
        });
}

function stok(value, row, index){
    if(row.stok_gudang < row.stok_min){
        return '<div style="color: red;">'+row.stok_gudang+'</div>';
    }else{
        return row.stok_gudang;
    }
    
}