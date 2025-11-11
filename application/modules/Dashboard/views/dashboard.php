
<style type="text/css">
	.shortcut {
    font-size: 20px;
    margin-top: 30px;
    text-align: center;
}
.row {
    margin-right: -249px;
    margin-left: -15px;
}

.panel-default {
    border-color: #ddd;
}

.panel {
    margin-bottom: 20px;
    background-color: #fff;
    border: 1px solid transparent;
    border-radius: 4px;
    -webkit-box-shadow: 0 1px 1px rgba(0,0,0,.05);
    box-shadow: 0 1px 1px rgba(0,0,0,.05);
}
.panel-body {
    padding: 15px;
}

.shortcut a {
    display: block;
    width: 100%;
    height: 100%;
}

a {
    text-decoration: none;
    color: #009AE6;
}
a {
    text-decoration: none;
    color: #086590;
}
a {
    color: #337ab7;
    text-decoration: none;
}
a {
    background-color: transparent;
}

#container .fa {
    font-size: 17px;
}
#container .fa {
    font-size: 24px;
}
.shortcut .fa {
    display: block;
    font-size: 25px !important;
}
.fa {
    display: inline-block;
    font: normal normal normal 14px/1 FontAwesome;
    font-size: inherit;
    text-rendering: auto;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
}
* {
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    box-sizing: border-box;
}
div {
    display: block;
}
</style>
<link href="<?php echo base_url('assets')?>/table/bootstrap-table.css" rel="stylesheet">
<script src="<?php echo base_url('assets')?>/table/bootstrap-table.js"></script>
<div id="wrapper">
	
	<div class="main-content container">
	
		<div class="row small-spacing">
			<!-- <div class="col-xs-12">
				<div class="box-content">
					<h4 class="box-title">Activity</h4>
					<div class="dropdown js__drop_down">
						<a href="#" class="dropdown-icon glyphicon glyphicon-option-vertical js__drop_down_button"></a>
						<ul class="sub-menu">
							<li><a href="#">Action</a></li>
							<li><a href="#">Another action</a></li>
							<li><a href="#">Something else there</a></li>
							<li class="split"></li>
							<li><a href="#">Separated link</a></li>
						</ul>
					</div>
					<div id="smil-animation-index-chartist-chart" class="chartist-chart" style="height: 320px"></div>
				</div>
			</div> -->
			
			<!-- /.col-lg-3 col-md-6 col-xs-12 -->
			
			
			<!-- /.col-lg-3 col-md-6 col-xs-12 -->
			<div class="row shortcut">
  <div class="col-xs-6 col-md-2 produk">
    <div class="panel panel-default">
      <div class="panel-body">
        <a href="<?php echo base_url('Barang')?>">
          <i class="fa fa-cubes" aria-hidden="true"></i>
          <span>Produk</span>
        </a>
      </div>
    </div>
  </div>
    <div class="col-xs-6 col-md-2 pembelian">
      <div class="panel panel-default">
        <div class="panel-body">
          <a href="<?php echo base_url('Pembelian_bpb')?>">
            <i class="fa fa-shopping-cart" aria-hidden="true"></i>
            <span>Pembelian</span>
          </a>
        </div>
      </div>
    </div>
    <div class="col-xs-6 col-md-2 penjualan">
      <div class="panel panel-default">
        <div class="panel-body">
          <a href="<?php echo base_url('Penjualan')?>">
            <i class="fa fa-clipboard" aria-hidden="true"></i>
            <span>Penjualan</span>
          </a>
        </div>
      </div>
    </div>
  
  
  <div class="col-xs-6 col-md-2 penjualan">
    <div class="panel panel-default">
      <div class="panel-body">
        <a href="<?php echo base_url('Penjualan/pos')?>">
          <i class="fa fa-tablet" aria-hidden="true"></i>
          <span>POS</span>
        </a>
      </div>
    </div>
  </div>

    <div class="col-xs-6 col-md-2 laba_rugi">
      <div class="panel panel-default">
        <div class="panel-body">
          <a href="<?php echo base_url('Laporan/laporan_laba_rugi')?>">
            <i class="fa fa-files-o" aria-hidden="true"></i>
            <span>Laba Rugi</span>
          </a>
        </div>
      </div>
    </div>
     	

  
  <div class="clearfx"></div>
</div>
			
			<!-- /.col-lg-6 col-xs-12 -->
			<div class="col-lg-6 col-xs-12">
				<div class="box-content">
					<h4 class="box-title">PO Penjualan</h4>
					<div class="table-responsive table-purchases">
					
						<table id="table_hutang_supplier" data-toggle="table" data-url="<?php echo base_url('Dashboard/get_po_tampil');?>"  data-show-refresh="true" data-show-toggle="true" data-show-columns="true" data-search="true" data-select-item-name="toolbar1" data-sort-name="awal_periode_renop" data-sort-order="desc" data-pagination="true">
						<thead>
							<tr>
								<th data-formatter="runningFormatter" data-sortable="true">No</th>
								<th data-field="nopo"  data-sortable="true" data-formatter="detail_po">No Po</th>
								<th data-field="nama"  data-sortable="true"  >Nama Pelanggan</th>
								<th data-field="tgl_po_kirim"  data-sortable="true" >Tanggal PO</th>
								<th data-field="status_ready"  data-sortable="true" data-formatter="status_readye">Status PO</th>
								
							</tr>
						</thead>
						</table>
						<!-- /.table -->
					</div>
					<!-- /.table-responsive -->
				</div>
				<!-- /.box-content -->
			</div>
			<div class="col-lg-6 col-xs-12">
				<div class="box-content">
					<h4 class="box-title">Penjualan Jatuh Tempo</h4>
					<div class="table-responsive table-purchases">
					
						<table id="table_hutang_supplier2" data-toggle="table" data-url="<?php echo base_url('Dashboard/get_jatuh_tempo');?>"  data-show-refresh="true" data-show-toggle="true" data-show-columns="true" data-search="true" data-select-item-name="toolbar1" data-sort-name="awal_periode_renop" data-sort-order="desc" data-pagination="true">
						<thead>
							<tr>
								<th data-formatter="runningFormatter" data-sortable="true">No</th>
								<th data-field="no_faktur"  data-sortable="true">No Nota</th>
								<th data-field="nama"  data-sortable="true"  >Nama Pelanggan</th>
								<th data-field="date"  data-sortable="true" >Tanggal</th>
								<th data-field="total_harga"  data-sortable="true" >Total Transaksi</th>
								
							</tr>
						</thead>
						</table>
						<!-- /.table -->
					</div>
					<!-- /.table-responsive -->
				</div>

				<!-- /.box-content -->
			</div>
			<!-- /.col-lg-6 col-xs-12 -->
		</div>
		
		<div class="row small-spacing">

			<div class="col-lg-6 col-xs-12">
				<div class="box-content">
					<h4 class="box-title">Pembelian Jatuh Tempo</h4>
					<div class="table-responsive table-purchases">
						
						<table id="table_hutang_supplier3" data-toggle="table" data-url="<?php echo base_url('Dashboard/get_beli_jatuh_tempo');?>"  data-show-refresh="true" data-show-toggle="true" data-show-columns="true" data-search="true" data-select-item-name="toolbar1" data-sort-name="awal_periode_renop" data-sort-order="desc" data-pagination="true">
						<thead>
							<tr>
								<th data-formatter="runningFormatter" data-sortable="true">No</th>
								<th data-field="no_faktur"  data-sortable="true">No Nota</th>
								<th data-field="nama"  data-sortable="true"  >Nama Supplier</th>
								<th data-field="date"  data-sortable="true" >Tanggal</th>
								<th data-field="biaya_pembelian"  data-sortable="true" >Total Transaksi</th>
								
							</tr>
						</thead>
						</table>
						<!-- /.table -->
					</div>
					<!-- /.table-responsive -->
				</div>
				<!-- /.box-content -->
			</div>
			<!-- /.col-lg-6 col-xs-12 -->

			<div class="col-lg-6 col-xs-12">
				<div class="box-content">
					<h4 class="box-title">Barang Kurang Laku</h4>
					<div class="table-responsive table-purchases">
			
						<table id="table_hutang_supplier4" data-toggle="table" data-url="<?php echo base_url('Dashboard/get_barang_kurang_laku');?>"  data-show-refresh="true" data-show-toggle="true" data-show-columns="true" data-search="true" data-select-item-name="toolbar1" data-sort-name="awal_periode_renop" data-sort-order="desc" data-pagination="true">
						<thead>
							<tr>
								<th data-formatter="runningFormatter" data-sortable="true">No</th>
								<th data-field="kode_barang"  data-sortable="true">Kode Barang</th>
								<th data-field="nama_barang"  data-sortable="true"  >Nama Barang</th>
								<th data-field="stok_gudang"  data-sortable="true" >Stok Gudang</th>
								<th data-field="date_edit"  data-sortable="true" >Transaksi Terakhir</th>
								
							</tr>
						</thead>
						</table>
						<!-- /.table -->
					</div>
					<!-- /.table-responsive -->
				</div>
				<!-- /.box-content -->
			</div>
			<!-- /.col-lg-6 col-xs-12 -->

		</div>
		<div class="row small-spacing">

			<div class="col-lg-6 col-xs-12">
				<div class="box-content">
					<h4 class="box-title">Stok Menipis</h4>
					<div class="table-responsive table-purchases">
					<table id="table_stock_ok" data-toggle="table" data-url="<?php echo base_url('Stok_menipis/get_stock_menipis');?>"  data-show-refresh="true" data-show-toggle="true" data-show-columns="true" data-search="true" data-select-item-name="toolbar1" data-pagination="true">
						<thead>
						<tr>
							<th data-formatter="runningFormatter" data-sortable="true">No</th>
							<th data-field="kode_barang"  data-sortable="true">Kode Barang</th>
							<th data-field="nama_barang"  data-sortable="true">Nama</th>
							<th data-field="stok_gudang"  data-sortable="true">Jumlah</th>
							<th data-field="stok_min"  data-sortable="true">Stok min</th>
						</tr>
						</thead>
					</table>
						
						<!-- /.table -->
					</div>
					<!-- /.table-responsive -->
				</div>
				<!-- /.box-content -->
			</div>
		</div>	
		
	</div>
</div>

<div class="modal fade" id="modal-2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  	<div class="modal-dialog modal-lg">
  		<div class="modal-content">
    		<div class="modal-header">
     		 	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
      			<h4 class="modal-title">Nota PO Penjualan</h4>
    		</div>
     		<div class="modal-body" style="overflow:auto;">
     			
				   <div class="col-lg-12">  	
				     
					   <div id="notaData2"></div>
				       
					</div>

     		</div>
     	</div>
    </div>
</div> 

<script>
	var linke = "<?= base_url()?>";

	function runningFormatter(value, row, index) {
        return index+1;
	}

	function status_readye(value){
		if(value==0){
			return 'PO Belum Ready Barang';
		}else{
			return 'PO Sudah Ready Barang';
		}
	}

	function detail_po(value){
		return '<a href="javascript:void(0)" onclick="detail_pone('+"'"+value+"'"+')" style="color: black;">'+value+'</a>';
	}

	function detail_pone(value){
		$("#modal-2").modal("show", function(){
		//console.log("dapat");	
		
		});
		$.ajax({
			type: "POST",
			url: linke+"Dashboard/nota_po_det/"+value,
			success:function(html){
				$("#notaData2").html(html);
			}
		});
	}
</script>