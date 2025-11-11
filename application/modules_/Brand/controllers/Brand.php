<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Brand extends MY_Admin {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_brand');
    } 

    function ajax_get_list_brand(){
        $bindings = array();
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && empty($_POST))
        $request = json_decode(file_get_contents('php://input'), true);
        $data = $this->M_brand->get_datatables();
    	$output = array(
                        "draw" => isset ( $request['draw'] ) ?
                        intval( $request['draw'] ) :
                        0,
                        "recordsTotal" => $this->M_brand->count_all(),
                        "recordsFiltered" => $this->M_brand->count_filtered(),
                        "data" => $data,
				);
        echo json_encode($output);
    }

    function ajax_add_brand(){
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Request-Headers: GET,POST,OPTIONS,DELETE,PUT");
        header("Access-Control-Allow-Headers: authorization, Content-Type");
	
        
        $fc_kdbrand = $this->input->post('fc_kdbrand');
        $fv_nmbrand = $this->input->post('fv_nmbrand');
        $fc_hold = $this->input->post('fc_hold');
      
        $DataBank = array(
            'fc_kdbrand' => $fc_kdbrand,
            'fv_nmbrand' => $fv_nmbrand,
            'fc_hold' => $fc_hold,
        );
  
        $this->db->insert('tm_brand',$DataBank);
        
        $result['success'] = true;
        return die(json_encode($result));
    }

    public function ajax_get_by_id($id)
	{
		header("Access-Control-Allow-Origin: *");
		header("Access-Control-Allow-Headers: authorization, Content-Type");


		$blog = $this->M_brand->get_by_id2($id);

		$post = array(
			'fc_kdbrand' => $blog->fc_kdbrand,
            'fv_nmbrand' => $blog->fv_nmbrand,
            'fc_hold' => $blog->fc_hold,
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

		$fc_kdbrand = $this->input->post('fc_kdbrand');
        
		$fv_nmbrand = $this->input->post('fv_nmbrand');
	   
        $fc_hold = $this->input->post('fc_hold');

		$DataBrand = array(
			'fc_kdbrand' => $fc_kdbrand,
            'fv_nmbrand' => $fv_nmbrand,
            'fc_hold' => $fc_hold
		);
		
		$this->M_brand->updateBrand($fc_kdbrand, $DataBrand);

		$result['success'] = true;
		return die(json_encode($result));
    }

    public function ajax_delete($id)
	{
	  header('Access-Control-Allow-Origin: *');
	  header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
	  header("Access-Control-Allow-Headers: authorization, Content-Type");
  
	  $this->M_brand->deleteBrand(@$id);
  
	  $response = array(
			'status' => 'success'
	  );
	
	  $this->output
			->set_status_header(200)
			->set_content_type('application/json')
			->set_output(json_encode($response)); 
  
	   
	}
}   