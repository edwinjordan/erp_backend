<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
 
class M_pelanggan extends CI_Model{	
	public $tables = 'pelanggan';

	function all(){		
		return $this->db->get($this->tables);
	}
	
	function max(){		
		return $this->db->query('SELECT max(kode_pelanggan) AS maxs FROM '.$this->tables);
	}

	function search_pelanggan($cari){		
		return $this->db->query('SELECT * FROM '.$this->tables.' WHERE nama LIKE "%'.$cari.'%" OR kode_pelanggan LIKE "%'.$cari.'%"');
	}

	function where($where){		
		return $this->db->get_where($this->tables,$where);
	}	

	function insert($where){
		$this->db->insert($this->tables,$where);
		return $this->db->insert_id();
	}

	function update($where, $id){
		return $this->db->update($this->tables,$where,$id);
	}

	function delete($id){
        return $this->db->delete($this->tables,$id);
	}

}
