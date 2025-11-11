<!DOCTYPE html>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>
		Nota Penjualan
	</title>
</head>
<style>
	body{
		margin: 0 !important;
	}
	.kotak-judul{
		text-align:center;
		padding:5px 0;
		/* border-bottom:1px solid black; */
		width:100%;
		font-weight:normal;
		/*float:left;*/
		display:inline-table;
		font-size:14px;
		font-family:'Arial';
	}
	.kotak{
		/*width:100%;*/
		border-bottom:1px dashed #000;
	}
	.kotak-content{
		/*float:left;*/
		/*width: 100%;*/
		margin-left: 10px;
		/*margin-right: 10px;*/
		margin-top: 2px;
		margin-bottom: 2px;
		display:inline-table;
	}
	.kotak-item{
		/*float:left;*/
		width: 100%;
		margin-left: 10px;
		margin-right: 10px;
		margin-top: 2px;
		margin-bottom: 2px;
		display:inline-table;
	}
	.kotak3{
		width:100%;
		/*float:left;*/
		display:inline-table;
		margin:5px 0;
		margin-top:0px;
		/* height:210px; */
		border-bottom:1px dashed #000;
	}
	.kotak3-content{
		width:100%;
		margin:2px 0;
		/*float:left;*/
		display:flex;
	}
	.kotak3-content-content{
		/*float:left;*/
		display:inline-table;
		margin:0;
	}
	.judul{
		text-align:center;
		<!-- font-size:18px; -->
	}
	.isi{
		<!-- text-align:center; -->
	}
	.judulheadline{
		text-align:center;
		<!-- font-size:20px; -->
	}
	.kotak3-content:first-child{
		border-bottom:1px dashed #000;
		/*padding-bottom:5px;*/
	}
	.kotak-judul p{
		margin:3px 0;
	}
	#col-1 {
		width: 65%
	}
	#col-2 {
		width: 35%
	}
	.kotak4{
		margin-top:0px;
		/*width:100%;*/
		display:inline-table;
		/*float:left;*/
		text-align:right;
		/* border-top:1px solid black; */
	}

	@page {
		size: A6;
		margin: 0;
	}
	@media print {
		html, body {
			width: 105mm;
			height: 148mm;
		}
		/* ... the rest of the rules ... */
	}
</style>
<body>

<div class="container-position">
		<div class="container" style="
    width: 330px;padding-left: 40px;
    margin-top: 20px;
">
			<div class="kotak-judul">
				<p><?php echo $nama_toko->fc_isi?></p>
				<p><?php echo $alamat_toko->fc_isi?></p>
				<p><?php echo $telp_toko->fc_isi?></p>
			</div>
			<div class="kotak3">
				<div class="kotak3-content">
					<div style="width:50%; font-size: 13px; text-align: left;" class="kotak3-content-content judulheadline">
						<?php $originalDate2 =  date('Y-m-d H:i:s');
						echo date("d-m-Y") . '<br>' . date("H:i:s");
						?>
					</div>
					<!-- <div style="width:20%;font-size: 13px;" class="kotak3-content-content judulheadline">
						<?php 
							if($penjualan->sts=="T"){
								echo "ML26";
							}else{
								echo "U04";
							}
						?>
					</div> -->
					<!-- <div style="width:3%;font-size: 13px;" class="kotak3-content-content judulheadline">
						<?php echo $this->session->userdata('kode_karyawan')?>
					</div> -->
					<div style="width:50%;font-size: 13px; text-align: right;" class="kotak3-content-content judulheadline">
						<?php echo $master_penjualan->fc_nofaktur; ?>
					</div>
				</div>	
				<?php $grand_total=0 ; $no=1; foreach($det_barang as $iyaps):?>	
				<div class="kotak3-content">
					<div style="width:30%;font-size: 13px;text-align:left;" class="kotak3-content-content judul">
						<?php echo $iyaps->fv_namastock?>
					</div>
					<div style="width:5%;font-size: 13px;" class="kotak3-content-content isi">
						<?php
						 //echo $iyaps->total_qty
						
							echo $iyaps->fn_qty;
						
						 ?>
					</div>
					<div style="width:15%;font-size: 13px; text-align: right;" class="kotak3-content-content judul">
						<?php echo $iyaps->fv_satuan?>
					</div>	
					<div style="width:25%;font-size: 13px; text-align: right;" class="kotak3-content-content judul">
						<?php echo number_format($iyaps->fm_price);
						?>
					</div>
					<div style="width:25%;font-size: 13px; text-align: right; letter-spacing: 0.05em;" class="kotak3-content-content judul">
						<?php echo number_format($iyaps->fm_subtot)?>
					</div>
				</div>
				<?php endforeach?>
			</div>
			
            <div class="kotak">
				<div class="kotak-content" style="margin-left: 0;">

							<div class="kotak4">
								<p style="margin:0; width:40%;float:left;text-align:left;/*letter-spacing:3px;*/font-size: 13px;"> TOTAL ITEM : <?php echo $count_barang->jml_barang;?> </p>
								<p style="margin:0; width:30%;float:left;text-align:right;font-size: 13px;">SUBTOTAL:</p>
								<p style="margin:0; width:30%;float:left;font-size: 13px;"><b><?php echo number_format($master_penjualan->fm_total)?></b></p>
								<p style="margin: 5px 0 0 0; width:40%;float:left;text-align:left;"><img src="<?php echo base_url('Penjualan/Barcode/'.$master_penjualan->fc_nofaktur); ?>" alt=""></p>
								<!-- <p style="margin:0; width:30%;float:left;text-align:right;font-size: 13px;">:</p>
								<p style="margin:0; width:30%;float:left;font-size: 13px;"><b></b></p> -->
								<p style="margin:0; width:30%;float:left;text-align:right;font-size: 13px;">TOTAL:</p>
								<?php $total = $master_penjualan->fm_total;?>
								<p style="margin:0; width:30%;float:left;font-size: 13px;"><b><?php echo number_format($total)?></b></p>
								
							</div>
							
                </div>
			</div> 
			<div class="kotak">
				<div class="kotak-content" style="margin-left: 0;">

					<div class="kotak4">
						<p style="margin:0; width:15%;float:left;text-align:left;font-size: 13px;">TUNAI:</p>
						<p style="margin:0; width:25%;float:left;font-size: 13px;"><b><?php echo number_format($master_penjualan->fm_dpp)?></b></p>
						<p style="margin:0; width:35%;float:left;text-align:right;font-size: 13px;">KEMBALI:</p>
						<?php $total_kembali = $master_penjualan->fm_dpp - $master_penjualan->fm_total;?>
						<p style="margin:0; width:25%;float:left;font-size: 13px;"><b><?php echo number_format($master_penjualan->fm_selisih)?></b></p>
						<p style="width:100%;float:left;text-align:left;font-size: 10pt;"><b>NB : MAX RETURN 1 MINGGU, NOTA BARCODE & BARANG UTUH</b></p>
						<p style="width:100%;font-size: 13px;float:left;text-align:center;">TERIMA KASIH <br>KAMI SENANG MELAYANI ANDA</p>
					</div>	
				</div>	
			</div>	
							
		</div>
	</div>
</body>
</html>