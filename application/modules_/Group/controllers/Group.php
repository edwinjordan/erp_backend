<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Group extends MY_Admin {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_group');
    } 

    function ajax_get_list_group(){
        $bindings = array();
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && empty($_POST))
        $request = json_decode(file_get_contents('php://input'), true);
        $data = $this->M_group->get_datatables();
    	$output = array(
                        "draw" => isset ( $request['draw'] ) ?
                        intval( $request['draw'] ) :
                        0,
                        "recordsTotal" => $this->M_group->count_all(),
                        "recordsFiltered" => $this->M_group->count_filtered(),
                        "data" => $data,
				);
        echo json_encode($output);
    }

    function get_data_brand(){
        $data = $this->M_group->get_data_brand();
		
        echo json_encode($data);
    }

    public function ajax_get_kode_group(){
        $data = $this->M_group->where_max()->row();
        //print_r($this->db->last_query());
        $json['maxs'] = @$data->maxs;
        echo json_encode($json);
    }

    function ajax_add_group(){
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Request-Headers: GET,POST,OPTIONS,DELETE,PUT");
        header("Access-Control-Allow-Headers: authorization, Content-Type");
	
        
        $fc_kdgroup = $this->input->post('fc_kdgroup');
        $fc_kdbrand = $this->input->post('fc_kdbrand');
        $fv_nmgroup = $this->input->post('fv_nmgroup');
        $fc_hold = $this->input->post('fc_hold');
      
        $DataGroup = array(
            'fc_kdgroup' => $fc_kdgroup,
            'fc_kdbrand' => $fc_kdbrand,
            'fv_nmgroup' => $fv_nmgroup,
            'fc_hold' => $fc_hold,
        );
  
        $this->db->insert('tm_group',$DataGroup);
        
        $result['success'] = true;
        return die(json_encode($result));
    }

    public function ajax_get_by_id($id)
	{
		header("Access-Control-Allow-Origin: *");
		header("Access-Control-Allow-Headers: authorization, Content-Type");


		$blog = $this->M_group->get_by_id2($id);

		$post = array(
			'fc_kdgroup' => $blog->fc_kdgroup,
			'fc_kdbrand' => $blog->fc_kdbrand,
			'fv_nmgroup' => $blog->fv_nmgroup,
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

		$fc_kdgroup = $this->input->post('fc_kdgroup');
        $fc_kdbrand = $this->input->post('fc_kdbrand');
        $fv_nmgroup = $this->input->post('fv_nmgroup');
        $fc_hold = $this->input->post('fc_hold');
		//print('aaa'.$f_deptid);
        $DataGroup = array(
            'fc_kdgroup' => $fc_kdgroup,
            'fc_kdbrand' => $fc_kdbrand,
            'fv_nmgroup' => $fv_nmgroup,
            'fc_hold' => $fc_hold,
		);
		
		$this->M_group->updateGroup($fc_kdgroup, $DataGroup);

		$result['success'] = true;
		return die(json_encode($result));
	}

	public function ajax_delete($id)
	{
	  header('Access-Control-Allow-Origin: *');
	  header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
	  header("Access-Control-Allow-Headers: authorization, Content-Type");
  
	 
	  //if($id){
	  $this->M_group->deleteGroup(@$id);
  
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