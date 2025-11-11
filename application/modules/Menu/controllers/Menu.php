<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Menu extends MY_Admin {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_menu');
    }

    function getMenuAPI($id){

        // header("Access-Control-Allow-Origin: *");
        // header("Access-Control-Request-Headers: GET,POST,OPTIONS,DELETE,PUT");
        // header("Access-Control-Allow-Headers: authorization, Content-Type");

        $data['mainmenu'] = $this->M_menu->get_mainmenu($id);

        foreach ($data['mainmenu'] as $key => $value) {
          $value->submenu = $this->M_menu->where_submenu($value->id_menu, $id)->result();
        }
		
	    	echo json_encode($data);
    }

}    