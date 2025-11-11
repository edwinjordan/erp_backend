<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Profesi extends MY_Admin {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_profesi');
    } 

    function ajax_get_list_profesi(){
        $bindings = array();
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && empty($_POST))
        $request = json_decode(file_get_contents('php://input'), true);
        $data = $this->M_profesi->get_datatables();
    	$output = array(
                        "draw" => isset ( $request['draw'] ) ?
                        intval( $request['draw'] ) :
                        0,
                        "recordsTotal" => $this->M_profesi->count_all(),
                        "recordsFiltered" => $this->M_profesi->count_filtered(),
                        "data" => $data,
				);
        echo json_encode($output);
    }

    function ajax_get_kode_profesi(){
        $data = $this->M_profesi->where_max()->row();
        //print_r($this->db->last_query());
        $json['maxs'] = @$data->maxs;
        echo json_encode($json);
    }

    function ajax_add_profesi(){
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Request-Headers: GET,POST,OPTIONS,DELETE,PUT");
        header("Access-Control-Allow-Headers: authorization, Content-Type");
	
        
        $fc_kdprofesi = $this->input->post('fc_kdprofesi');
        
        $fv_nmprofesi = $this->input->post('fv_nmprofesi');
      
        $DataProfesi = array(
            'fc_kdprofesi' => $fc_kdprofesi,
            'fv_nmprofesi' => $fv_nmprofesi,
        );
  
        $this->db->insert('tm_profesi',$DataProfesi);
        
        $result['success'] = true;
        return die(json_encode($result));
    }


    public function ajax_get_by_id($id)
	{
		header("Access-Control-Allow-Origin: *");
		header("Access-Control-Allow-Headers: authorization, Content-Type");


		$blog = $this->M_profesi->get_by_id2($id);

		$post = array(
			'fc_kdprofesi' => $blog->fc_kdprofesi,
			'fv_nmprofesi' => $blog->fv_nmprofesi,
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

        $fc_kdprofesi = $this->input->post('fc_kdprofesi');
        
        $fv_nmprofesi = $this->input->post('fv_nmprofesi');
      
        $DataProfesi = array(
            'fc_kdprofesi' => $fc_kdprofesi,
            'fv_nmprofesi' => $fv_nmprofesi,
        );
		
		$this->M_profesi->updateProfesi($fc_kdprofesi, $DataProfesi);

		$result['success'] = true;
		return die(json_encode($result));
    }
    
    public function ajax_delete($id)
	{
	  header('Access-Control-Allow-Origin: *');
	  header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
	  header("Access-Control-Allow-Headers: authorization, Content-Type");
  
	  $this->M_profesi->deleteProfesi(@$id);
  
	  $response = array(
			'status' => 'success'
	  );
	
	  $this->output
			->set_status_header(200)
			->set_content_type('application/json')
			->set_output(json_encode($response)); 
  
	   
	}

}    