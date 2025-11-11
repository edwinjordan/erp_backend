<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Template extends MX_Controller {
    function view_login($data){
        $this->load->view('view_login', $data);
    }
    
    function view_admin($data){
        $this->load->view('view_admin', $data);
    }
}
