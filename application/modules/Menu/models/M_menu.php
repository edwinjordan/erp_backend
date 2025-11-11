<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class M_menu extends CI_Model{

    public function get_mainmenu($id){
		$this->db->join('tab_akses_mainmenu','tb_menu.id_menu=tab_akses_mainmenu.id_menu','left outer');
		$this->db->where('tab_akses_mainmenu.r','1');
		$this->db->where('tab_akses_mainmenu.f_deptid',$id);
		return $this->db->get('tb_menu')->result();
    }
    
    function where_submenu($where, $id){		
		$this->db->select('*');
		$this->db->join('tab_akses_submenu','tb_submenu.id_submenu=tab_akses_submenu.id_sub_menu');
		$this->db->where('tab_akses_submenu.r','1');
		$this->db->where('tab_akses_submenu.f_deptid',$id);
		$this->db->where('tb_submenu.id_menu',$where);
		return $this->db->get('tb_submenu');
	}	

}   