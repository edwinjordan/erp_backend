<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Tipe extends MY_Admin {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_tipe');
    } 

    function ajax_get_list_tipe(){
        $bindings = array();
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && empty($_POST))
        $request = json_decode(file_get_contents('php://input'), true);
        $data = $this->M_tipe->get_datatables();
    	$output = array(
                        "draw" => isset ( $request['draw'] ) ?
                        intval( $request['draw'] ) :
                        0,
                        "recordsTotal" => $this->M_tipe->count_all(),
                        "recordsFiltered" => $this->M_tipe->count_filtered(),
                        "data" => $data,
				);
        echo json_encode($output);
    }

    function get_data_group(){
        $data = $this->M_tipe->get_data_group();
		
        echo json_encode($data);
    }

    function get_data_brand(){
        $data = $this->M_tipe->get_data_brand();
		
        echo json_encode($data);
    }

    public function ajax_get_kode_tipe(){
        $data = $this->M_tipe->where_max()->row();
        //print_r($this->db->last_query());
        $json['maxs'] = @$data->maxs;
        echo json_encode($json);
    }

    function ajax_add_tipe(){
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Request-Headers: GET,POST,OPTIONS,DELETE,PUT");
        header("Access-Control-Allow-Headers: authorization, Content-Type");
	
        
        $fc_kdtipe = $this->input->post('fc_kdtipe');
        $fc_kdgroup = $this->input->post('fc_kdgroup');
        $fc_kdbrand = $this->input->post('fc_kdbrand');
        $fv_nmtipe = $this->input->post('fv_nmtipe');
        $fc_hold = $this->input->post('fc_hold');
      
        $DataTipe = array(
            'fc_kdtipe' => $fc_kdtipe,
            'fc_kdgroup' => $fc_kdgroup,
            'fc_kdbrand' => $fc_kdbrand,
            'fv_nmtipe' => $fv_nmtipe,
            'fc_hold' => $fc_hold,
        );
  
        $this->db->insert('tm_tipe',$DataTipe);
        
        $result['success'] = true;
        return die(json_encode($result));
    }

    public function ajax_get_by_id($id)
	{
		header("Access-Control-Allow-Origin: *");
		header("Access-Control-Allow-Headers: authorization, Content-Type");


		$blog = $this->M_tipe->get_by_id2($id);

		$post = array(
			'fc_kdtipe' => $blog->fc_kdtipe,
			'fc_kdgroup' => $blog->fc_kdgroup,
			'fc_kdbrand' => $blog->fc_kdbrand,
			'fv_nmtipe' => $blog->fv_nmtipe,
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

		$fc_kdtipe = $this->input->post('fc_kdtipe');
        $fc_kdgroup = $this->input->post('fc_kdgroup');
        $fc_kdbrand = $this->input->post('fc_kdbrand');
        $fv_nmtipe = $this->input->post('fv_nmtipe');
        $fc_hold = $this->input->post('fc_hold');
      
        $DataTipe = array(
            'fc_kdtipe' => $fc_kdtipe,
            'fc_kdgroup' => $fc_kdgroup,
            'fc_kdbrand' => $fc_kdbrand,
            'fv_nmtipe' => $fv_nmtipe,
            'fc_hold' => $fc_hold,
        );
		
		$this->M_tipe->updateTipe($fc_kdtipe, $DataTipe);

		$result['success'] = true;
		return die(json_encode($result));
	}

	public function ajax_delete($id)
	{
	  header('Access-Control-Allow-Origin: *');
	  header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
	  header("Access-Control-Allow-Headers: authorization, Content-Type");
  
	 
	  //if($id){
	  $this->M_tipe->deleteTipe(@$id);
  
	  $response = array(
			'status' => 'success'
	  );
	
	  $this->output
			->set_status_header(200)
			->set_content_type('application/json')
			->set_output(json_encode($response)); 
	   // }
  
	   
	}
}    