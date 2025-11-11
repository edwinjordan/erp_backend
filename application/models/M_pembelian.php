<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_pembelian extends CI_Model {

	public $tables = 'pembelian';
	public $tables2 = 'detail_pembelian';
	public $tables3	= 'gudang';
	public $tables4	= 'detail_gudang';

	public function all()
	{
		$this->db->select('
			a.id_pembelian, a.date, a.time, a.total_harga,a.no_faktur,a.no_nota,a.biaya, 
			b.id_karyawan,b.kode_karyawan,b.nama as nama_karyawan,b.email as email_karyawan , 
			c.id_supplier,c.nama as nama_supplier, c.kode_supplier');
		$this->db->from('pembelian as a');
		$this->db->join('karyawan as b', 'b.id_karyawan = a.id_karyawan' ,'left');
		$this->db->join('supplier as c', 'c.id_supplier = a.id_supplier' ,'left');
		$this->db->where('a.status', 1);
		return $this->db->get();
	}
	public function getPembelian($id)
	{
		return $this->db->get_where($this->tables,['id_pembelian'=> $id]);
	}
	public function getPembelianDetail($id)
	{
		return $this->db->get_where($this->tables2,['id_pembelian'=> $id]);
	}
	public function getSupplier()
	{
		$this->db->select('id_supplier,kode_supplier,nama as nama_supplier');
		$this->db->from('supplier');
		return $this->db->get();
	}
	public function getBarang()
	{
		$this->db->select('id_barang,nama_barang,kode_barang');
		$this->db->from('barang');
		$this->db->group_by('nama_barang');
		return $this->db->get();
	}
	public function fak()
	 {
	 	$this->db->select('no_faktur');
	 	$this->db->from($this->tables);
	 	return $this->db->get();
	 }
	public function getId_pembelian()
	{
		$this->db->select('id_pembelian as id');
		$this->db->from($this->tables);
		$this->db->order_by('id_pembelian', 'desc');
		$this->db->limit(1);
		return $this->db->get()->row();
	}
	public function getIdGudang()
	{
		$this->db->select('id_gudang as id');
		$this->db->from($this->tables3);
		$this->db->order_by('id_gudang', 'desc');
		$this->db->limit(1);
		return $this->db->get()->row();
	}
	public function getGudang($id)
	{
		$this->db->select('id_gudang as id,coly,nama_gudang');
		$this->db->from($this->tables3);
		$this->db->where($id);
		return $this->db->get()->row();
	}
	public function insertDetail($dataDetailPembelian)
	{
		$this->db->insert($this->tables2, $dataDetailPembelian);
	}
	public function insertGudang($dataGudang)
	{
		 $this->db->insert($this->tables3, $dataGudang);
		 return $this->db->insert_id();
	}
	public function insertDetailGudang($dataDetailGudang)
	{
		$this->db->insert($this->tables4, $dataDetailGudang);
	}
	public function update($dataPembelian,$id)
	{
		$this->db->where('id_pembelian', $id);
		$this->db->update($this->tables, $dataPembelian);
	}
	public function updateGudang($dataGudang,$id)
	{
		$this->db->where('id_pembelian', $id);
		$this->db->update($this->tables3, $dataGudang);
	}
	public function updateDetail($dataDetailPembelian,$id)
	{
		$this->db->where('id_pembelian', $id);
		$this->db->update($this->tables2, $dataDetailPembelian);
	}
	public function updateDetailGudang($data,$id)
	{
		$this->db->where('id_gudang', $id);
		$this->db->update($this->tables4, $data);
	}
	public function insert($dataPembelian)
	{
		$this->db->insert($this->tables, $dataPembelian);
		return $this->db->insert_id();
	}
	public function delete($table,$where)
	{
		$this->db->where($where);
		$this->db->delete($table);
	}

}

/* End of file M_pembelian.php */
/* Location: ./application/models/M_pembelian.php */