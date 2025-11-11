<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class M_dashboard extends CI_Model {

	public function get_po(){
		$this->db->join('pelanggan','t_po.id_pelanggan=pelanggan.id_pelanggan');
		$this->db->where('t_po.status_ready','1');
		return $this->db->get('t_po');
	}

	public function get_jual_jatuh_tempo(){
		$date = date('Y-m-d');
		$this->db->where('tgl_jatuh_tempo <=',$date);
		$this->db->where('selisih <=',0);
		$this->db->join('pelanggan','penjualan.id_pelanggan=pelanggan.id_pelanggan');
		return $this->db->get('penjualan');
	}

	public function get_beli_jatuh_tempo(){
		$date = date('Y-m-d');
		$this->db->where('tgl_jatuh_tempo <=',$date);
		$this->db->where('selisih <=',0);
		$this->db->join('supplier','pembelian.id_supplier=supplier.kode_supplier');
		return $this->db->get('pembelian');
	}
	
	public function get_barang_kurang_laku() {
		$date = date('Y-m-d');
		$this->db->select("b.kode_barang, b.nama_barang, dg.stok_gudang, STR_TO_DATE(vh.date_edit, '%d/%m/%Y') AS date_edit");
		$this->db->from('varian_harga vh');
		$this->db->join('barang b', 'vh.id_barang = b.id_barang', 'inner');
		$this->db->join('detail_gudang dg', 'vh.id_varian_harga = dg.id_varian_harga', 'inner');
		$this->db->where("STR_TO_DATE(vh.date_edit, '%d/%m/%Y') < NOW() - INTERVAL 30 DAY");
		return $this->db->get();
	}

	public function get_stok_menipis(){
		 $this->db->select('id_detail_gudang');
		$this->db->select('kode_barang');
		$this->db->select('nama_barang');
		$this->db->select('stok_gudang');
		$this->db->select('stok_dijual');
		$this->db->select('stok_min');
		$this->db->select('nama_lokasi');
		$this->db->from('detail_gudang');
		$this->db->join('varian_harga', 'detail_gudang.id_varian_harga=varian_harga.id_varian_harga');
		$this->db->join('barang', 'varian_harga.id_barang=barang.id_barang');
		$this->db->join('lokasi', 'detail_gudang.id_lokasi=lokasi.id_lokasi');
		
		//$this->db->order_by('detail_gudang.kode_barang', 'ASC');
		$this->db->order_by('detail_gudang.id_lokasi', 'ASC');
		return $this->db->get();
	}

	function get_nota_print($where)
	{
		$this->db->select('karyawan.nama as nama_karyawan');
	    $this->db->select('karyawan.kota as kota_karyawan');
	    $this->db->select('pelanggan.nama as nama_pelanggan');
		$this->db->select('pelanggan.kota as kota_pelanggan');
		$this->db->select('t_po.nopo');
	    $this->db->select('t_po.tgl_po_kirim');
	    $this->db->select('t_po.diskon_rupiah');
	    $this->db->select('t_po.diskon_rupiah');
	    $this->db->select('t_po.grand_total');
		$this->db->select('t_po.id_karyawan');
		$this->db->select('t_po.id_pelanggan');
		$this->db->join('pelanggan','pelanggan.id_pelanggan=t_po.id_pelanggan','left outer');
		$this->db->join('karyawan','karyawan.id_karyawan=t_po.id_karyawan','left outer');
		$this->db->where($where);
		return $this->db->get('t_po')->row();
	}

	public function get_nota_print_master($where){
		// $this->db->select('metode_pembayaran');
		// //$this->db->select('total_harga');
		// $this->db->select('diskon_persen');
		// $this->db->select('diskon_rupiah');
		// $this->db->select('biaya');
		// $this->db->select('total_harga');
		// $this->db->select('selisih');
		// $this->db->select('no_nota');
		$this->db->select('*');
		$this->db->where($where);
		$query = $this->db->get('t_po');
		return $query->row();
	}

	function get_nota_print_barang_penjualan2($where){
		$subquery = $this->db->select_sum('harga_jual')

							 ->from('detail_po')

							 ->where($where)

							 ->group_by('id_barang')

							 ->get_compiled_select();

		$subquery_jml = $this->db->select_sum('qty')

							 ->from('detail_po')

							 ->where($where)

							 ->group_by('id_barang')

							 ->get_compiled_select();	

		$subquery_tot = $this->db->select_sum('total_harga')

							 ->from('detail_po')

							 ->where($where)

							 ->group_by('id_barang')

							 ->get_compiled_select();
							 					 					 
		$this->db->select(' ('.$subquery.') as total_harga_jual, barang.kode_barang, tm_satuan.satuan,('.$subquery_tot.') as grand_harga_total ,barang.nama_barang,detail_po.harga_jual, ('.$subquery_jml.') as total_qty,detail_po.nopo');		
		$this->db->join('barang','detail_po.id_barang=barang.id_barang','left outer');
		$this->db->join('varian_harga','varian_harga.id_varian_harga=detail_po.id_varian_harga','left outer');
		$this->db->join('tm_satuan','tm_satuan.kode_satuan=varian_harga.kode_satuan','left outer');
		$this->db->where($where);
		$this->db->group_by('detail_po.id_barang');
		$query = $this->db->get('detail_po');
		return $query->result();

	}
}	