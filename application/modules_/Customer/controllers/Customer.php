<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Customer extends MY_Admin {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_customer');
    } 

    function ajax_get_list_customer(){
        $bindings = array();
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && empty($_POST))
        $request = json_decode(file_get_contents('php://input'), true);
        $data = $this->M_customer->get_datatables();
    	$output = array(
                        "draw" => isset ( $request['draw'] ) ?
                        intval( $request['draw'] ) :
                        0,
                        "recordsTotal" => $this->M_customer->count_all(),
                        "recordsFiltered" => $this->M_customer->count_filtered(),
                        "data" => $data,
				);
        echo json_encode($output);
    }

    function get_data_top(){
        $data = $this->M_customer->get_data_top();
		
        echo json_encode($data);
    }

    function get_data_profesi(){
        $data = $this->M_customer->get_data_profesi();
		
        echo json_encode($data);
    }

    public function ajax_get_kode_customer(){
        $data = $this->M_customer->where_max()->row();
        //print_r($this->db->last_query());
        $json['maxs'] = @$data->maxs;
        echo json_encode($json);
    }

    public function ajax_add_customer(){
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Request-Headers: GET,POST,OPTIONS,DELETE,PUT");
        header("Access-Control-Allow-Headers: authorization, Content-Type");
		
    
		$fc_kdcust = $this->input->post('fc_kdcust');
		$fv_nama = $this->input->post('fv_nama');
		$fv_alamat = $this->input->post('fv_alamat');		
		$fv_email = $this->input->post('fv_email');
		
        $fv_noktp = $this->input->post('fv_noktp');
      //  $fc_jenis = $this->input->post('fc_jenis');
        $fc_hold = $this->input->post('fc_hold');
        $fc_kota = $this->input->post('fc_kota');
        $fc_kdtop = $this->input->post('fc_kdtop');
        $fc_kdprofesi = $this->input->post('fc_kdprofesi');
        $fc_statusangsur = $this->input->post('fc_statusangsur');
        
        $DataCustomer = array(
                'fc_kdcust' => $fc_kdcust,
                'fv_nama' => $fv_nama,
                'fv_alamat' => $fv_alamat,
                'fv_email' => $fv_email,
                'fv_noktp' => $fv_noktp,
             //   'fc_jenis' => $fc_jenis,
                'fc_hold' => $fc_hold,
                'fc_kota' => $fc_kota,
                'fc_kdtop' => $fc_kdtop,
                'fc_kdprofesi' => $fc_kdprofesi,
                'fc_statusangsur' => $fc_statusangsur,
        );
		//print_r('aaa'.$DataSales);
        $id = $this->M_customer->insertCustomer($DataCustomer);
  
           
		$result['success'] = true;
		return die(json_encode($result));
        
	}
	
	public function ajax_get_by_id($id)
	{
		header("Access-Control-Allow-Origin: *");
		header("Access-Control-Allow-Headers: authorization, Content-Type");


		$blog = $this->M_customer->get_by_id2($id);

		$post = array(
			'fc_kdcust' => $blog->fc_kdcust,
			'fv_nama' => $blog->fv_nama,
			'fv_alamat' => $blog->fv_alamat,
			'fv_email' => $blog->fv_email,
			'fv_noktp' => $blog->fv_noktp,
			//'fc_jenis' => $blog->fc_jenis,
			'fc_hold' => $blog->fc_hold,
            'fc_kota' => $blog->fc_kota,
            'fc_kdtop' => $blog->fc_kdtop,
            'fc_kdprofesi' => $blog->fc_kdprofesi,
            'fc_statusangsur' => $blog->fc_statusangsur
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
        
		$fc_kdcust = $this->input->post('fc_kdcust');
		$fv_nama = $this->input->post('fv_nama');
		$fv_alamat = $this->input->post('fv_alamat');		
		$fv_email = $this->input->post('fv_email');
		
        $fv_noktp = $this->input->post('fv_noktp');
        $fc_jenis = $this->input->post('fc_jenis');
        $fc_hold = $this->input->post('fc_hold');
        $fc_kota = $this->input->post('fc_kota');
        $fc_kdtop = $this->input->post('fc_kdtop');
        $fc_kdprofesi = $this->input->post('fc_kdprofesi');
        $fc_statusangsur = $this->input->post('fc_statusangsur');
        
        $DataCustomer = array(
                'fc_kdcust' => $fc_kdcust,
                'fv_nama' => $fv_nama,
                'fv_alamat' => $fv_alamat,
                'fv_email' => $fv_email,
                'fv_noktp' => $fv_noktp,
               // 'fc_jenis' => $fc_jenis,
                'fc_hold' => $fc_hold,
                'fc_kota' => $fc_kota,
                'fc_kdtop' => $fc_kdtop,
                'fc_kdprofesi' => $fc_kdprofesi,
                'fc_statusangsur' => $fc_statusangsur,
        );
		
		$this->M_customer->updateCustomer($fc_kdcust, $DataCustomer);

		$result['success'] = true;
		return die(json_encode($result));
	}

	public function ajax_delete($id)
	{
	  header('Access-Control-Allow-Origin: *');
	  header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
	  header("Access-Control-Allow-Headers: authorization, Content-Type");
  
	 
	  //if($id){
	  $this->M_customer->deleteCustomer(@$id);
  
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