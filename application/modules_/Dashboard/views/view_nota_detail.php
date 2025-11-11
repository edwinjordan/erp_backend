
<div class="invoice-box">
				<table>
						<tbody>
						
						<tr class="information">
							<td colspan="2">
								<table>
									<tbody><tr>
										<td>
											Malang, <?php $originalDate =  $po->tgl_po_kirim;
											$newDate = date("d-m-Y", strtotime($originalDate));
											echo $newDate;
											?><br><br>
											Kepada Yth: <?php echo $po->nama_pelanggan ?><br><br>
											<?php echo $po->kota_pelanggan ?><br><br>
											<?php echo $master_po->nopo ?><img src="<?php echo base_url('Penjualan/Barcode/'.$master_po->nopo); ?>" alt="">
										</td>
										
										<td>
											TOKO LARIS 32<br><br>
											Jl. Sersan Harun 16 Malang<br><br>
											Telp. 0341-325825
										</td>
									</tr>
								</tbody></table>
							</td>
						</tr>
				</tbody>
				</table>		
				<div class="row">
					<table class="table_barang table table-sm table-bordered" style="width: 78%;">
						<thead>
							<tr>
								<th>Nama Barang</th>
								<th>Qty</th>
								<th>Satuan</th>
								<th>H. Satuan</th>
								<th>Subtotal</th>
							</tr>
						</thead>
						<tbody>
							 <?php $i=1; $totale = 0; foreach ($barang as $h): $totale = $h->total_qty * $h->total_harga_jual;?>
								<tr>
									<td><?php echo $h->nama_barang ?> :
									<?php $query = $this->db->query('select * from detail_penjualan 
									inner join varian_harga on varian_harga.id_varian_harga= detail_penjualan.id_varian_harga and varian_harga.id_barang=detail_penjualan.id_barang 
									inner join tm_satuan on tm_satuan.kode_satuan=varian_harga.kode_satuan
									where no_faktur="'.$h->nopo.'"');
									//print_r($this->db->last_query());
									?> 
								
									<?php foreach($query->result() as $row){?>
										<?php echo $row->warna.' '.$row->qty.',' ?> 
<!-- 											
										<th><?php echo $row->qty ?></th>
										<th>-</th>
										</tr> -->
									<?php } ?>	
	
									</td>
									<td><?php echo $h->total_qty ?></td>
									<td><?php echo $h->satuan ?></td>
									<td><?php echo 'Rp. '.number_format($h->total_harga_jual).',-' ?></td>
									<td><?php echo 'Rp. '.number_format($totale).',-' ?></td>
								</tr>
							<?php endforeach ?>
						</tbody>
					</table>
				</div>
				<div class="table_total row justify-content-end" style="text-align: right;">
					<div class="col-4 mb-2">
						<table style="width: 78%;">
						
						
						
						
						<tr class="item">
							<td>
								Total
							</td>
							
							<td>
							   <?php echo 'Rp. '.number_format($master_po->grand_total).',-' ?>
							</td>
						</tr>
						<!-- <tr class="item">
							<td>
								Bayar
							</td>
							
							<td>
							   <?php echo 'Rp. '.number_format($master_po->biaya).',-' ?>
							</td>
						</tr>
						<tr class="item">
							<td>
								Kembali
							</td>
							
							<td>
							   <?php echo 'Rp. '.number_format($master_po->selisih).',-' ?>
							</td>
						</tr> -->
						<!-- <tr class="item">
							<td>
								Metode Pembayaran
							</td>
							
							<td>
							   <?php echo $master_po->metode_pembayaran?>
							</td>
						</tr> -->
						</table>
					</div>
				</div>
				<br>
				<br>
				<!-- <div style="text-align: center">Terima Kasih Atas Kunjungan Anda, Sehat & Sukses Selalu</div>
				<br>
				<br>
				<div style="text-align: left">NB: Max Return Barang 2 Minggu</div>
				<br>
				<div style="text-align: left">Syarat : Barcode Nota & Barang Utuh/ Terbaca</div> -->
				</div>
					
				</div>