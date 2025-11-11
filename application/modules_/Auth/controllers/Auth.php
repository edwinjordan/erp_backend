<?php (defined('BASEPATH')) OR exit('No direct script access allowed');
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Auth extends MX_Controller {

	public function __construct(){
        parent::__construct();
        $this->load->model('M_user');
        $this->load->library('session');
    }

    public function login(){
       //  return die(json_encode($this->input->post()));
        $email = $this->input->post('email');
        $password = $this->input->post('password');
        $area = $this->input->post('area');
        $divisi = $this->input->post('divisi');
        $where = array(
            'fv_username' => $email,
            'fv_password' => md5($password),
            'fc_kdarea'   => $area,
            'fc_kddivisi' => $divisi
        );
        $cek_login = $this->M_user->where($where);
        print_r($this->db->last_query());
        if($cek_login->num_rows() > 0){
            $sql = $cek_login->result_array();
            $menu_main = $this->M_user->get_menu_main($sql[0]['f_deptid'])->result_array();
            $menu_sub = $this->M_user->get_menu_sub($sql[0]['f_deptid'])->result_array();
            // $posisi = $this->M_user->get_posisi($sql[0]['id_posisi'])->result();
            $items = array();
            foreach($sql as $key) {
                $items = $key;
            }

            // $items_submenu = array();
            // foreach($menu_android as $key_submenu) {
            //     $items_submenu = $key_submenu;
            // }
            $this->session->set_userdata($items);
            $data['success'] = 'success';
            $data['data'] = $items;
            $data['area'] = $this->input->post('area');
            $data['divisi'] = $this->input->post('divisi');
            $data['mainmenu'] = $menu_main;
            $data['submenu'] = $menu_sub;
            // $data['posisi'] = $posisi[0];
            die(json_encode($data));
        }else{
            $data['success'] = 'failed';
            die(json_encode($data));
        }
    }

    public function login_android(){
        //  return die(json_encode($this->input->post()));
         $email = $this->input->post('username');
         $password = $this->input->post('password');
         $area = $this->input->post('area');
         $divisi = $this->input->post('divisi');
         $where = array(
             'fv_username' => $email,
             'fv_password' => md5($password),
             'fc_kdarea'   => $area,
             'fc_kddivisi' => $divisi
         );
         $cek_login = $this->M_user->where($where);
       //  print_r($this->db->last_query());
         if($cek_login->num_rows() > 0){
             $sql = $cek_login->result_array();
             $menu_main = $this->M_user->get_menu_main($sql[0]['f_deptid'])->result_array();
             $menu_sub = $this->M_user->get_menu_sub($sql[0]['f_deptid'])->result_array();
             // $posisi = $this->M_user->get_posisi($sql[0]['id_posisi'])->result();
             $items = array();
             foreach($sql as $key) {
                 $items = $key;
             }
 
             // $items_submenu = array();
             // foreach($menu_android as $key_submenu) {
             //     $items_submenu = $key_submenu;
             // }
             $this->session->set_userdata($items);
             $data['success'] = 'success';
             $data['data'] = $items;
             $data['area'] = $this->input->post('area');
             $data['divisi'] = $this->input->post('divisi');
             $data['mainmenu'] = $menu_main;
             $data['submenu'] = $menu_sub;
             // $data['posisi'] = $posisi[0];
             die(json_encode($data));
         }else{
             $data['success'] = 'failed';
             die(json_encode($data));
         }
     }

    function ajax_get_area(){
        $data = $this->M_user->get_area();
		
		echo json_encode($data);
    }

    function ajax_get_divisi(){
        $data = $this->M_user->get_divisi();
		
		echo json_encode($data);
    }

     public function logout()
    {
        $this->session->sess_destroy();
        redirect('Auth','refresh');
    }

    public function getArea(){
        $data = $this->M_user->get_area();
		
		echo json_encode($data);
    }

    public function getDivisi(){

        $data = $this->M_user->get_divisi();
		
		echo json_encode($data);

    }

}	