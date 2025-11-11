<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
 
class M_user extends CI_Model{	
	public $tables = 'karyawan';

	function all(){		
		return $this->db->get($this->tables);
	}	
	
	function count($id){		
		return $this->db->query('SELECT count(id_users) AS total_user FROM '.$this->tables.' WHERE id_users = '.$id);
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
