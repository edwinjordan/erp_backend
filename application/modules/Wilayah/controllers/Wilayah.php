<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Wilayah extends MY_Admin {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_wilayah');
    } 

    function ajax_get_list_wilayah(){
        $bindings = array();
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && empty($_POST))
        $request = json_decode(file_get_contents('php://input'), true);
        $data = $this->M_wilayah->get_datatables();
    	$output = array(
                        "draw" => isset ( $request['draw'] ) ?
                        intval( $request['draw'] ) :
                        0,
                        "recordsTotal" => $this->M_wilayah->count_all(),
                        "recordsFiltered" => $this->M_wilayah->count_filtered(),
                        "data" => $data,
				);
        echo json_encode($output);
    }

    public function ajax_get_kode_wilayah(){
        $data = $this->M_wilayah->where_max()->row();
        //print_r($this->db->last_query());
        $json['maxs'] = @$data->maxs;
        echo json_encode($json);
    }

    public function ajax_add_wilayah(){
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Request-Headers: GET,POST,OPTIONS,DELETE,PUT");
        header("Access-Control-Allow-Headers: authorization, Content-Type");
		
    
		$fc_kdwilayah = $this->input->post('fc_kdwilayah');
		$fv_nmwilayah = $this->input->post('fv_nmwilayah');

        $DataWilayah = array(
                'fc_kdwilayah' => $fc_kdwilayah,
                'fv_nmwilayah' => $fv_nmwilayah,
        );
        $id = $this->M_wilayah->insertWilayah($DataWilayah);
  
           
		$result['success'] = true;
		return die(json_encode($result));
        
    }
    
    public function ajax_get_by_id($id)
	{
		header("Access-Control-Allow-Origin: *");
		header("Access-Control-Allow-Headers: authorization, Content-Type");


		$blog = $this->M_wilayah->get_by_id2($id);

		$post = array(
			'fc_kdwilayah' => $blog->fc_kdwilayah,
			'fv_nmwilayah' => $blog->fv_nmwilayah,
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

		$fc_kdwilayah = $this->input->post('fc_kdwilayah');
		$fv_nmwilayah = $this->input->post('fv_nmwilayah');

        $DataWilayah = array(
                'fc_kdwilayah' => $fc_kdwilayah,
                'fv_nmwilayah' => $fv_nmwilayah,
        );
		
		$this->M_wilayah->updateWilayah($fc_kdwilayah, $DataWilayah);

		$result['success'] = true;
		return die(json_encode($result));
	}

	public function ajax_delete($id)
	{
	  header('Access-Control-Allow-Origin: *');
	  header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
	  header("Access-Control-Allow-Headers: authorization, Content-Type");
  
	 
	  //if($id){
	  $this->M_wilayah->deleteWilayah(@$id);
  
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