<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
 
class M_karyawan extends CI_Model{	
	public $tables = 'karyawan';	
	public $tables2 = 'posisi';

	function all(){		
		return $this->db->get($this->tables);
	}
    
    function all_posisi(){		
		return $this->db->get($this->tables2);
	}
	function cek_user($where)
	{
		$this->db->where('username', $where);
		return $this->db->get($this->tables);
	}
	function max(){		
		return $this->db->query('SELECT max(kode_karyawan) AS maxs FROM '.$this->tables);
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
