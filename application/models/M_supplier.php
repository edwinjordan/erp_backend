<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
 
class M_supplier extends CI_Model{	
	public $tables = 'supplier';

	function all(){		
		return $this->db->get($this->tables);
	}
	
	function max(){		
		return $this->db->query('SELECT max(kode_supplier) AS maxs FROM '.$this->tables);
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
