<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Bank extends MY_Admin {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_bank');
    } 

    function ajax_get_list_bank(){
        $bindings = array();
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && empty($_POST))
        $request = json_decode(file_get_contents('php://input'), true);
        $data = $this->M_bank->get_datatables();
    	$output = array(
                        "draw" => isset ( $request['draw'] ) ?
                        intval( $request['draw'] ) :
                        0,
                        "recordsTotal" => $this->M_bank->count_all(),
                        "recordsFiltered" => $this->M_bank->count_filtered(),
                        "data" => $data,
				);
        echo json_encode($output);
    }

    function ajax_get_kode_bank(){
        $data = $this->M_bank->where_max()->row();
        //print_r($this->db->last_query());
        $json['maxs'] = @$data->maxs;
        echo json_encode($json);
    }

    function ajax_add_bank(){
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Request-Headers: GET,POST,OPTIONS,DELETE,PUT");
        header("Access-Control-Allow-Headers: authorization, Content-Type");
	
        
        $fc_kdbank = $this->input->post('fc_kdbank');
        
        $fv_bank = $this->input->post('fv_bank');
      
        $DataBank = array(
            'fc_kdbank' => $fc_kdbank,
            'fv_bank' => $fv_bank,
        );
  
        $this->db->insert('tm_bank',$DataBank);
        
        $result['success'] = true;
        return die(json_encode($result));
    }

    public function ajax_get_by_id($id)
	{
		header("Access-Control-Allow-Origin: *");
		header("Access-Control-Allow-Headers: authorization, Content-Type");


		$blog = $this->M_bank->get_by_id2($id);

		$post = array(
			'fc_kdbank' => $blog->fc_kdbank,
			'fv_bank' => $blog->fv_bank,
		);
		

		$this->output
			->set_status_header(200)
			->set_content_type('application/json')
			->set_output(json_encode($post)); 
		
    }
    
    public function ajax_edit_post($id){
		header("Access-Control-Allow-Origin: *");
		header("Access-Control-Allow-Headers: authorization, Content-Type");
		header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");

		$fc_kdbank = $this->input->post('fc_kdbank');
        
		$fv_bank = $this->input->post('fv_bank');
	   
	   
		$DataBank = array(
			'fc_kdbank' => $fc_kdbank,
			'fv_bank' => $fv_bank
		);
		
		$this->M_bank->updateBank($fc_kdbank, $DataBank);

		$result['success'] = true;
		return die(json_encode($result));
    }
    
    public function ajax_delete($id)
	{
	  header('Access-Control-Allow-Origin: *');
	  header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
	  header("Access-Control-Allow-Headers: authorization, Content-Type");
  
	  $this->M_bank->deleteBank(@$id);
  
	  $response = array(
			'status' => 'success'
	  );
	
	  $this->output
			->set_status_header(200)
			->set_content_type('application/json')
			->set_output(json_encode($response)); 
  
	   
	}
}   