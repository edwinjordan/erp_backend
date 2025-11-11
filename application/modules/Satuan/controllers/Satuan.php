<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Satuan extends MY_Admin {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_satuan');
    } 

    function ajax_get_list_satuan(){
        $bindings = array();
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && empty($_POST))
        $request = json_decode(file_get_contents('php://input'), true);
        $data = $this->M_satuan->get_datatables();
    	$output = array(
                        "draw" => isset ( $request['draw'] ) ?
                        intval( $request['draw'] ) :
                        0,
                        "recordsTotal" => $this->M_satuan->count_all(),
                        "recordsFiltered" => $this->M_satuan->count_filtered(),
                        "data" => $data,
				);
        echo json_encode($output);
    }

    function ajax_get_kode_satuan(){
        $data = $this->M_satuan->where_max()->row();
        //print_r($this->db->last_query());
        $json['maxs'] = @$data->maxs;
        echo json_encode($json);
    }

    function ajax_add_satuan(){
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Request-Headers: GET,POST,OPTIONS,DELETE,PUT");
        header("Access-Control-Allow-Headers: authorization, Content-Type");
	
        
        $fc_kdsatuan = $this->input->post('fc_kdsatuan');
        $fv_satuan = $this->input->post('fv_satuan');
        $fc_sts = $this->input->post('fc_sts');
      
        $DataSatuan = array(
            'fc_kdsatuan' => $fc_kdsatuan,
            'fv_satuan' => $fv_satuan,
            'fc_sts' => $fc_sts,
        );
  
        $this->db->insert('tm_satuan',$DataSatuan);
        
        $result['success'] = true;
        return die(json_encode($result));
    }

    public function ajax_get_by_id($id)
	{
		header("Access-Control-Allow-Origin: *");
		header("Access-Control-Allow-Headers: authorization, Content-Type");


		$blog = $this->M_satuan->get_by_id2($id);

		$post = array(
			'fc_kdsatuan' => $blog->fc_kdsatuan,
            'fv_satuan' => $blog->fv_satuan,
            'fc_sts' => $blog->fc_sts,
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

		$fc_kdsatuan = $this->input->post('fc_kdsatuan');
        
		$fv_satuan = $this->input->post('fv_satuan');
	   
        $fc_sts = $this->input->post('fc_sts');

		$DataSatuan = array(
			'fc_kdsatuan' => $fc_kdsatuan,
            'fv_satuan' => $fv_satuan,
            'fc_sts' => $fc_sts
		);
		
		$this->M_satuan->updateSatuan($fc_kdsatuan, $DataSatuan);

		$result['success'] = true;
		return die(json_encode($result));
    }

    public function ajax_delete($id)
	{
	  header('Access-Control-Allow-Origin: *');
	  header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
	  header("Access-Control-Allow-Headers: authorization, Content-Type");
  
	  $this->M_satuan->deleteSatuan(@$id);
  
	  $response = array(
			'status' => 'success'
	  );
	
	  $this->output
			->set_status_header(200)
			->set_content_type('application/json')
			->set_output(json_encode($response)); 
  
	   
	}
}    