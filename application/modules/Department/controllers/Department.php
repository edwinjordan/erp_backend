<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Department extends MY_Admin {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_department');
    } 

    function ajax_get_list_department(){
        $bindings = array();
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && empty($_POST))
        $request = json_decode(file_get_contents('php://input'), true);
        $data = $this->M_department->get_datatables();
    	$output = array(
                        "draw" => isset ( $request['draw'] ) ?
                        intval( $request['draw'] ) :
                        0,
                        "recordsTotal" => $this->M_department->count_all(),
                        "recordsFiltered" => $this->M_department->count_filtered(),
                        "data" => $data,
				);
        echo json_encode($output);
    }

    public function ajax_add_department(){
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Request-Headers: GET,POST,OPTIONS,DELETE,PUT");
        header("Access-Control-Allow-Headers: authorization, Content-Type");
	
        
         $f_deptid = $this->input->post('f_deptid');
        
         $f_deptname = $this->input->post('f_deptname');
      
         $f_status = $this->input->post('f_status');	
        
		
        $DataDepartment = array(
            'f_deptid' => $f_deptid,
            'f_deptname' => $f_deptname,
            'f_status' => $f_status
        );
  
        $this->db->insert('t_departement',$DataDepartment);
        
        $result['success'] = true;
        return die(json_encode($result));
  
        
	}

    public function ajax_get_kode_department(){
        $data = $this->M_department->where_max()->row();
        //print_r($this->db->last_query());
        $json['maxs'] = @$data->maxs;
        echo json_encode($json);
	}
	
	public function ajax_edit_post($id){
		header("Access-Control-Allow-Origin: *");
		header("Access-Control-Allow-Headers: authorization, Content-Type");
		header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");

		$f_deptid = $this->input->post('f_deptid');
        
        $f_deptname = $this->input->post('f_deptname');
      
        $f_status = $this->input->post('f_status');	
        
		
        $DataDepartment = array(
            'f_deptid' => $f_deptid,
            'f_deptname' => $f_deptname,
            'f_status' => $f_status
        );
		
		$this->M_department->updateDepartment($f_deptid, $DataDepartment);

		$result['success'] = true;
		return die(json_encode($result));
	}

	public function ajax_get_by_id($id)
	{
		header("Access-Control-Allow-Origin: *");
		header("Access-Control-Allow-Headers: authorization, Content-Type");


		$area = $this->M_department->get_by_id2($id);

		$post = array(
			'f_deptid' => $area->f_deptid,
			'f_deptname' => $area->f_deptname,
			'f_status' => $area->f_status
		);
		

		$this->output
			->set_status_header(200)
			->set_content_type('application/json')
			->set_output(json_encode($post)); 
		
	}

	public function ajax_delete($id)
	{
	  header('Access-Control-Allow-Origin: *');
	  header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
	  header("Access-Control-Allow-Headers: authorization, Content-Type");
  
	  $this->M_department->deleteDepartment(@$id);
  
	  $response = array(
			'status' => 'success'
	  );
	
	  $this->output
			->set_status_header(200)
			->set_content_type('application/json')
			->set_output(json_encode($response)); 
  
	   
	}

    
}   