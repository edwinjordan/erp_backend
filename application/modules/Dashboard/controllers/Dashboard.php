<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Dashboard extends MY_Admin {

	function __construct() {
                parent::__construct();
                $this->load->model('M_dashboard');
        }

	public function index()
	{
                //$this->template->set_js(base_url().'build/home.js','footer', 'remote'); 
                $data['po'] = $this->M_dashboard->get_po();
                $data['jual_jatuh_tempo'] = $this->M_dashboard->get_jual_jatuh_tempo();
                $data['beli_jatuh_tempo'] = $this->M_dashboard->get_beli_jatuh_tempo();
                $data['barang_kurang_laku'] = $this->M_dashboard->get_barang_kurang_laku();
                $data['stok_menipis'] = $this->M_dashboard->get_stok_menipis()->result_array();
                $this->template->set_layout('Template/view_admin');
                $this->template->set_content('Dashboard/dashboard', $data);
                $this->template->render();
        }
        
        public function get_po_tampil(){
                echo json_encode($this->M_dashboard->get_po()->result());
        }

        public function get_jatuh_tempo(){
                echo json_encode($this->M_dashboard->get_jual_jatuh_tempo()->result());
        }

        public function get_beli_jatuh_tempo(){
                echo json_encode($this->M_dashboard->get_beli_jatuh_tempo()->result());
        }

        public function get_barang_kurang_laku(){
                echo json_encode($this->M_dashboard->get_barang_kurang_laku()->result());
        }

        public function nota_po_det($id)
        {
            $data['po']=$this->M_dashboard->get_nota_print(array('nopo'=>$id));
        //   //  print_r($this->db->last_query());
            $data['master_po']=$this->M_dashboard->get_nota_print_master(array('nopo'=>$id));
            $data['barang']=$this->M_dashboard->get_nota_print_barang_penjualan2(array('detail_po.nopo'=>$data['po']->nopo));  
         
            $this->load->view('Dashboard/view_nota_detail', $data);
        }
}	