<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Setup extends MY_Admin {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_setup');
    } 

    function ajax_edit(){
        $data = $this->M_setup->get_by_id();
		
       // echo json_encode($data);
        $this->output
        ->set_status_header(200)
        ->set_content_type('application/json')
        ->set_output(json_encode($data)); 
    }


    function ajax_edit_en(){
        $data = $this->M_setup->get_by_en();
		
		echo json_encode($data);
    }

    function ajax_edit_jp(){
        $data = $this->M_setup->get_by_jp();
		
		echo json_encode($data);
    }

    public function update_link() {

        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: authorization, Content-Type");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");

		$data1 = array('fc_isi' => $this->input->post('fc_isi_2'));
        $this->M_setup->update_link($data1,array('fc_param' => 'TELP'));
        
		$data2 = array('fc_isi' => $this->input->post('fc_isi_3'));
        $this->M_setup->update_link($data2,array('fc_param' => 'EMAIL'));
        
		$data3 = array('fc_isi' => $this->input->post('fc_isi_4'));
        $this->M_setup->update_link($data3,array('fc_param' => 'ALAMAT'));
        
		$data4 = array('fc_isi' => $this->input->post('fc_isi_5'));
        $this->M_setup->update_link($data4,array('fc_param' => 'TENTANG'));
        
        $data5 = array('fc_isi' => $this->input->post('fc_isi_6'));
        $this->M_setup->update_link($data4,array('fc_param' => 'KONTAK'));
        
        $config['upload_path'] =  './assets/images/';
        $config['allowed_types']        = 'gif|jpg|png';
        $config['max_size'] = '2000000';
        
        $new_name = 'fotosetup_'.time();
        $config['file_name'] = $new_name;
        $this->load->library('upload', $config);
        $this->upload->initialize($config);   
        
        if($this->upload->do_upload('fc_isi_1')){
       
            $get_name = $this->upload->data();
            $nama_foto = $get_name['file_name'];
            $gambar1 = $nama_foto;
            $blogData = array(
                'fc_isi' => $gambar1,
              );
    
              $this->M_setup->updateSetup('LOGO1', $blogData);

          
        }  

        $response = array(
            'status' => 'success'
          );  
           

      $this->output
        ->set_status_header(200)
        ->set_content_type('application/json')
        ->set_output(json_encode($response)); 
		
	}
}    