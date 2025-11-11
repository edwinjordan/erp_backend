<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_gudang extends CI_Model {
	public $tables = 'gudang';
	public $tables2 = 'detail_gudang';

	public function list_gudang()
	{
		$this->db->select('gudang.*, supplier.nama as nama_supplier');
		$this->db->from($this->tables);
		$this->db->join('supplier', 'supplier.id_supplier = gudang.id_supplier');
		return $this->db->get();
	}
	public function detail_data($id)
	{
		$this->db->select('detail_gudang.*,barang.nama_barang,barang.id_barang');
		$this->db->from($this->tables2);
		$this->db->join('barang', 'barang.id_barang = detail_gudang.id_barang');
		$this->db->where('id_gudang', $id);
		return $this->db->get();
	}
	public function detail_edit($id)
	{
		$this->db->select('*');
		$this->db->from($this->tables2);
		$this->db->where('id_barang', $id);
		return $this->db->get();
	}
	public function atur_barang($id){
		$this->db->select('*');
		$this->db->from('varian_harga');
		$this->db->where('id_barang', $id);
		return $this->db->get()->result();
	}

	public function getBarang($id)
	{
		$this->db->select('nama_barang,kode_barang,id_barang');
		$this->db->from('barang');
		$this->db->where('id_barang', $id);
		return $this->db->get()->row();
	}
	public function updateDetail($id,$data)
	{
		$this->db->where($id);
		$this->db->update($this->tables2, $data);
	}
	

}

/* End of file M_gudang.php */
/* Location: ./application/models/M_gudang.php */