<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class M_akses extends CI_Model{

    // ==================== MAIN MENU ====================
    
    /**
     * Get all main menu access by department/user
     */
    public function get_akses_mainmenu($f_deptid = null){
        $this->db->select('tab_akses_mainmenu.*, tb_menu.nm_menu as menu_name, tb_menu.class1 as menu_icon, tb_menu.link as menu_url');
        $this->db->join('tb_menu', 'tb_menu.id_menu = tab_akses_mainmenu.id_menu', 'left');
        
        if ($f_deptid !== null) {
            $this->db->where('tab_akses_mainmenu.f_deptid', $f_deptid);
        }
        
        $this->db->order_by('tb_menu.urutan', 'ASC');
        return $this->db->get('tab_akses_mainmenu')->result();
    }
    
    /**
     * Get specific main menu access
     */
    public function get_akses_mainmenu_by_id($id){
        $this->db->select('tab_akses_mainmenu.*, tb_menu.nm_menu as menu_name, tb_menu.class1 as menu_icon, tb_menu.link as menu_url');
        $this->db->join('tb_menu', 'tb_menu.id_menu = tab_akses_mainmenu.id_menu', 'left');
        $this->db->where('tab_akses_mainmenu.id_akses_mainmenu', $id);
        return $this->db->get('tab_akses_mainmenu')->row();
    }
    
    /**
     * Check if main menu access already exists
     */
    public function check_akses_mainmenu_exists($id_menu, $f_deptid){
        $this->db->where('id_menu', $id_menu);
        $this->db->where('f_deptid', $f_deptid);
        return $this->db->get('tab_akses_mainmenu')->row();
    }
    
    /**
     * Create main menu access
     */
    public function create_akses_mainmenu($data){
        return $this->db->insert('tab_akses_mainmenu', $data);
    }
    
    /**
     * Update main menu access
     */
    public function update_akses_mainmenu($id, $data){
        $this->db->where('id_akses_mainmenu', $id);
        return $this->db->update('tab_akses_mainmenu', $data);
    }
    
    /**
     * Delete main menu access
     */
    public function delete_akses_mainmenu($id){
        $this->db->where('id_akses_mainmenu', $id);
        return $this->db->delete('tab_akses_mainmenu');
    }
    
    /**
     * Bulk update main menu access for department
     */
    public function bulk_update_mainmenu($f_deptid, $menu_access){
        // Delete existing access for this department
        $this->db->where('f_deptid', $f_deptid);
        $this->db->delete('tab_akses_mainmenu');
        
        // Insert new access
        if (!empty($menu_access)) {
            return $this->db->insert_batch('tab_akses_mainmenu', $menu_access);
        }
        return true;
    }

    // ==================== SUB MENU ====================
    
    /**
     * Get all sub menu access by department/user
     */
    public function get_akses_submenu($f_deptid = null, $id_menu = null){
        $this->db->select('tab_akses_submenu.*, tb_submenu.nm_submenu as submenu_name, tb_submenu.link as submenu_url, tb_submenu.id_menu');
        $this->db->join('tb_submenu', 'tb_submenu.id_submenu = tab_akses_submenu.id_sub_menu', 'left');
        
        if ($f_deptid !== null) {
            $this->db->where('tab_akses_submenu.f_deptid', $f_deptid);
        }
        
        if ($id_menu !== null) {
            $this->db->where('tb_submenu.id_menu', $id_menu);
        }
        
        $this->db->order_by('tb_submenu.urutan', 'ASC');
        return $this->db->get('tab_akses_submenu')->result();
    }
    
    /**
     * Get specific sub menu access
     */
    public function get_akses_submenu_by_id($id){
        $this->db->select('tab_akses_submenu.*, tb_submenu.nm_submenu as submenu_name, tb_submenu.link as submenu_url, tb_submenu.id_menu');
        $this->db->join('tb_submenu', 'tb_submenu.id_submenu = tab_akses_submenu.id_sub_menu', 'left');
        $this->db->where('tab_akses_submenu.id_akses_submenu', $id);
        return $this->db->get('tab_akses_submenu')->row();
    }
    
    /**
     * Check if sub menu access already exists
     */
    public function check_akses_submenu_exists($id_sub_menu, $f_deptid){
        $this->db->where('id_sub_menu', $id_sub_menu);
        $this->db->where('f_deptid', $f_deptid);
        return $this->db->get('tab_akses_submenu')->row();
    }
    
    /**
     * Create sub menu access
     */
    public function create_akses_submenu($data){
        return $this->db->insert('tab_akses_submenu', $data);
    }
    
    /**
     * Update sub menu access
     */
    public function update_akses_submenu($id, $data){
        $this->db->where('id_akses_submenu', $id);
        return $this->db->update('tab_akses_submenu', $data);
    }
    
    /**
     * Delete sub menu access
     */
    public function delete_akses_submenu($id){
        $this->db->where('id_akses_submenu', $id);
        return $this->db->delete('tab_akses_submenu');
    }
    
    /**
     * Bulk update sub menu access for department
     */
    public function bulk_update_submenu($f_deptid, $submenu_access){
        // Delete existing access for this department
        $this->db->where('f_deptid', $f_deptid);
        $this->db->delete('tab_akses_submenu');
        
        // Insert new access
        if (!empty($submenu_access)) {
            return $this->db->insert_batch('tab_akses_submenu', $submenu_access);
        }
        return true;
    }
    
    /**
     * Delete all sub menu access by main menu id and department
     */
    public function delete_submenu_by_mainmenu($id_menu, $f_deptid){
        $this->db->where('id_sub_menu IN (SELECT id_submenu FROM tb_submenu WHERE id_menu = '.$id_menu.')');
        $this->db->where('f_deptid', $f_deptid);
        return $this->db->delete('tab_akses_submenu');
    }

    // ==================== MENU & SUBMENU DATA ====================
    
    /**
     * Get all main menus
     */
    public function get_all_mainmenu(){
        $this->db->order_by('urutan', 'ASC');
        return $this->db->get('tb_menu')->result();
    }
    
    /**
     * Get all sub menus
     */
    public function get_all_submenu($id_menu = null){
        if ($id_menu !== null) {
            $this->db->where('id_menu', $id_menu);
        }
        $this->db->order_by('urutan', 'ASC');
        return $this->db->get('tb_submenu')->result();
    }
    
    /**
     * Get main menu by id
     */
    public function get_mainmenu_by_id($id){
        $this->db->where('id_menu', $id);
        return $this->db->get('tb_menu')->row();
    }
    
    /**
     * Get submenu by id
     */
    public function get_submenu_by_id($id){
        $this->db->where('id_submenu', $id);
        return $this->db->get('tb_submenu')->row();
    }

}   
