<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Supplier extends MY_Admin {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_supplier');
    } 

    function ajax_get_list_supplier(){
        $bindings = array();
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && empty($_POST))
        $request = json_decode(file_get_contents('php://input'), true);
        $data = $this->M_supplier->get_datatables();
    	$output = array(
                        "draw" => isset ( $request['draw'] ) ?
                        intval( $request['draw'] ) :
                        0,
                        "recordsTotal" => $this->M_supplier->count_all(),
                        "recordsFiltered" => $this->M_supplier->count_filtered(),
                        "data" => $data,
				);
        echo json_encode($output);
    }

    function get_data_top(){
        $data = $this->M_supplier->get_data_top();
		
        echo json_encode($data);
    }

    public function ajax_get_kode_supplier(){
        $data = $this->M_supplier->where_max()->row();
        //print_r($this->db->last_query());
        $json['maxs'] = @$data->maxs;
        echo json_encode($json);
    }

    public function ajax_add_supplier(){
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Request-Headers: GET,POST,OPTIONS,DELETE,PUT");
        header("Access-Control-Allow-Headers: authorization, Content-Type");
		
    
		$fc_kdsupp = $this->input->post('fc_kdsupp');
		$fv_nama = $this->input->post('fv_nama');
		$fv_alamat = $this->input->post('fv_alamat');		
		$fc_kota = $this->input->post('fc_kota');
		
        $fc_telp = $this->input->post('fc_telp');
        $fd_tglinput = date('Y-m-d');
        $fc_telp2 = $this->input->post('fc_telp2');
        $fc_fax = $this->input->post('fc_fax');
        $fv_email = $this->input->post('fv_email');
        $fc_stssup = $this->input->post('fc_stssup');
        $fc_bank = $this->input->post('fc_bank');
        $fv_norek = $this->input->post('fv_norek');
        $fc_kdtop = $this->input->post('fc_kdtop');

        $DataSupplier = array(
                'fc_kdsupp' => $fc_kdsupp,
                'fv_nama' => $fv_nama,
                'fv_alamat' => $fv_alamat,
                'fc_kota' => $fc_kota,
                'fc_telp' => $fc_telp,
                'fd_tglinput' => $fd_tglinput,
                'fc_telp2' => $fc_telp2,
                'fc_fax' => $fc_fax,
                'fv_email' => $fv_email,
                'fc_stssup' => $fc_stssup,
                'fc_bank' => $fc_bank,
                'fv_norek' => $fv_norek,
                'fc_kdtop' => $fc_kdtop,
        );
        $id = $this->M_supplier->insertSupplier($DataSupplier);
  
           
		$result['success'] = true;
		return die(json_encode($result));
        
    }
    
    public function ajax_get_by_id($id)
	{
		header("Access-Control-Allow-Origin: *");
		header("Access-Control-Allow-Headers: authorization, Content-Type");


		$blog = $this->M_supplier->get_by_id2($id);

		$post = array(
			'fc_kdsupp' => $blog->fc_kdsupp,
			'fv_nama' => $blog->fv_nama,
			'fv_alamat' => $blog->fv_alamat,
			'fc_kota' => $blog->fc_kota,
			'fc_telp' => $blog->fc_telp,
			'fc_telp2' => $blog->fc_telp2,
			'fc_fax' => $blog->fc_fax,
            'fv_email' => $blog->fv_email,
            'fc_stssup' => $blog->fc_stssup,
            'fc_bank' => $blog->fc_bank,
            'fv_norek' => $blog->fv_norek,
            'fc_kdtop' => $blog->fc_kdtop,
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

		$fc_kdsupp = $this->input->post('fc_kdsupp');
		$fv_nama = $this->input->post('fv_nama');
		$fv_alamat = $this->input->post('fv_alamat');		
		$fc_kota = $this->input->post('fc_kota');
		
        $fc_telp = $this->input->post('fc_telp');
        $fd_tglinput = date('Y-m-d');
        $fc_telp2 = $this->input->post('fc_telp2');
        $fc_fax = $this->input->post('fc_fax');
        $fv_email = $this->input->post('fv_email');
        $fc_stssup = $this->input->post('fc_stssup');
        $fc_bank = $this->input->post('fc_bank');
        $fv_norek = $this->input->post('fv_norek');
        $fc_kdtop = $this->input->post('fc_kdtop');

        $DataSupplier = array(
                'fc_kdsupp' => $fc_kdsupp,
                'fv_nama' => $fv_nama,
                'fv_alamat' => $fv_alamat,
                'fc_kota' => $fc_kota,
                'fc_telp' => $fc_telp,
                'fd_tglinput' => $fd_tglinput,
                'fc_telp2' => $fc_telp2,
                'fc_fax' => $fc_fax,
                'fv_email' => $fv_email,
                'fc_stssup' => $fc_stssup,
                'fc_bank' => $fc_bank,
                'fv_norek' => $fv_norek,
                'fc_kdtop' => $fc_kdtop,
        );
		
		$this->M_supplier->updateSupplier($fc_kdsupp, $DataSupplier);

		$result['success'] = true;
		return die(json_encode($result));
	}

	public function ajax_delete($id)
	{
	  header('Access-Control-Allow-Origin: *');
	  header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
	  header("Access-Control-Allow-Headers: authorization, Content-Type");
  
	 
	  //if($id){
	  $this->M_supplier->deleteSupplier(@$id);
  
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