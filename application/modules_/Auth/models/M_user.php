<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
 
class M_user extends CI_Model{	
	public $tables = 'tm_karyawan';

	function all(){		
		return $this->db->get($this->tables);
	}	
	
	function count($id){		
		return $this->db->query('SELECT count(id_users) AS total_user FROM '.$this->tables.' WHERE id_users = '.$id);
	}

	function where($where){		
		//$this->db->join('tab_akses_menu','tab_akses_menu.id_posisi=karyawan.id_posisi');
		return $this->db->get_where('tm_karyawan',$where);
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

	public function get_area() {
        
		$this->db->from('tm_area');

		$query = $this->db->get();
		return $query->result();
	}

	function get_divisi(){
		$this->db->from('tm_divisi');

		$query = $this->db->get();
		return $query->result();
	}

	function get_menu_main($f_deptid){
		$this->db->where('tab_akses_mainmenu.f_deptid', $f_deptid);
		$this->db->where('tb_menu.sts_menu', 'W');
		$this->db->join('tb_menu','tab_akses_mainmenu.id_menu=tb_menu.id_menu','left outer');
		return $this->db->get('tab_akses_mainmenu');
	}

	function get_menu_sub($f_deptid){
		$this->db->where('tab_akses_submenu.f_deptid', $f_deptid);
		$this->db->where('tb_submenu.sts_menu', 'W');
		$this->db->join('tb_submenu','tab_akses_submenu.id_sub_menu=tb_submenu.id_submenu','left outer');
		return $this->db->get('tab_akses_submenu');
	}

}
