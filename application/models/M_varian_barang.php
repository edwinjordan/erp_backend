<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_varian_barang extends CI_Model {
	public $table = "varian_harga";

	function where($where){		
		return $this->db->get_where($this->table,$where);
	}
	public function insert($data)
	{
		$this->db->insert($this->table, $data);
		return $this->db->insert_id();
		
	}
	function update($where,$data)
	{
		$this->db->where($where);
		$this->db->update($this->table,$data);
	}
	function delete($id)
	{
		return $this->db->delete($this->table,$id);

	}
	

}

/* End of file M_varian_barang.php */
/* Location: ./application/models/M_varian_barang.php */