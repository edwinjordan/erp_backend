<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Top extends MY_Admin {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_top');
    } 

    function ajax_get_list_top(){
        $bindings = array();
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && empty($_POST))
        $request = json_decode(file_get_contents('php://input'), true);
        $data = $this->M_top->get_datatables();
    	$output = array(
                        "draw" => isset ( $request['draw'] ) ?
                        intval( $request['draw'] ) :
                        0,
                        "recordsTotal" => $this->M_top->count_all(),
                        "recordsFiltered" => $this->M_top->count_filtered(),
                        "data" => $data,
				);
        echo json_encode($output);
    }

    public function ajax_get_kode_top(){
        $data = $this->M_top->where_max()->row();
        //print_r($this->db->last_query());
        $json['maxs'] = @$data->maxs;
        echo json_encode($json);
    }

    public function ajax_add_top(){
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Request-Headers: GET,POST,OPTIONS,DELETE,PUT");
        header("Access-Control-Allow-Headers: authorization, Content-Type");
		
    
		$fc_kdtop = $this->input->post('fc_kdtop');
		$fv_nmtop = $this->input->post('fv_nmtop');
		$fn_jumlah = $this->input->post('fn_jumlah');	

        $DataTop = array(
                'fc_kdtop' => $fc_kdtop,
                'fv_nmtop' => $fv_nmtop,
                'fn_jumlah' => $fn_jumlah,
        );
        $id = $this->M_top->insertTop($DataTop);
  
           
		$result['success'] = true;
		return die(json_encode($result));
        
    }
    
    public function ajax_get_by_id($id)
	{
		header("Access-Control-Allow-Origin: *");
		header("Access-Control-Allow-Headers: authorization, Content-Type");


		$blog = $this->M_top->get_by_id2($id);

		$post = array(
			'fc_kdtop' => $blog->fc_kdtop,
			'fv_nmtop' => $blog->fv_nmtop,
			'fn_jumlah' => $blog->fn_jumlah
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

		$fc_kdtop = $this->input->post('fc_kdtop');
		$fv_nmtop = $this->input->post('fv_nmtop');
		$fn_jumlah = $this->input->post('fn_jumlah');	

        $DataTop = array(
                'fc_kdtop' => $fc_kdtop,
                'fv_nmtop' => $fv_nmtop,
                'fn_jumlah' => $fn_jumlah,
        );
		
		$this->M_top->updateTop($fc_kdtop, $DataTop);

		$result['success'] = true;
		return die(json_encode($result));
	}

	public function ajax_delete($id)
	{
	  header('Access-Control-Allow-Origin: *');
	  header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
	  header("Access-Control-Allow-Headers: authorization, Content-Type");
  
	 
	  //if($id){
	  $this->M_top->deleteTop(@$id);
  
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