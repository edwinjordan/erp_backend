<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Akun extends MY_Admin {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_akun');
    } 

    function ajax_get_list_akun(){
        $bindings = array();
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && empty($_POST))
        $request = json_decode(file_get_contents('php://input'), true);
        $data = $this->M_akun->get_datatables();
    	$output = array(
                        "draw" => isset ( $request['draw'] ) ?
                        intval( $request['draw'] ) :
                        0,
                        "recordsTotal" => $this->M_akun->count_all(),
                        "recordsFiltered" => $this->M_akun->count_filtered(),
                        "data" => $data,
				);
        echo json_encode($output);
    }

    public function ajax_add_akun(){
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Request-Headers: GET,POST,OPTIONS,DELETE,PUT");
        header("Access-Control-Allow-Headers: authorization, Content-Type");
	
        
         $nama_transaksi_akun = $this->input->post('nama_transaksi_akun');
        
         $status_debit_kredit = $this->input->post('status_debit_kredit');
      
         $sts = $this->input->post('sts');	
        
		
        $DataAkun = array(
            'nama_transaksi_akun' => $nama_transaksi_akun,
            'status_debit_kredit' => $status_debit_kredit,
            'sts' => $sts
        );
  
        $this->db->insert('transaksi_akun',$DataAkun);
        
        $result['success'] = true;
        return die(json_encode($result));
  
        
    }
    
    public function ajax_edit_post($id){
		header("Access-Control-Allow-Origin: *");
		header("Access-Control-Allow-Headers: authorization, Content-Type");
		header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");

	//	$id_transaksi_akun = $this->input->post('id_transaksi_akun');
        
		$nama_transaksi_akun = $this->input->post('nama_transaksi_akun');
	 
        $status_debit_kredit = $this->input->post('status_debit_kredit');

        $sts = $this->input->post('sts');	
	   
	   
		$DataAkun = array(
			'nama_transaksi_akun' => $nama_transaksi_akun,
            'status_debit_kredit' => $status_debit_kredit,
            'sts' => $sts
		);
		
		$this->M_akun->updateAkun($id, $DataAkun);

		$result['success'] = true;
		return die(json_encode($result));
	}

	public function ajax_get_by_id($id)
	{
		header("Access-Control-Allow-Origin: *");
		header("Access-Control-Allow-Headers: authorization, Content-Type");


		$area = $this->M_akun->get_by_id2($id);

		$post = array(
			'id_transaksi_akun' => $area->id_transaksi_akun,
			'nama_transaksi_akun' => $area->nama_transaksi_akun,
            'status_debit_kredit' => $area->status_debit_kredit,
            'sts' => $area->sts,
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
  
	  $this->M_akun->deleteAkun(@$id);
  
	  $response = array(
			'status' => 'success'
	  );
	
	  $this->output
			->set_status_header(200)
			->set_content_type('application/json')
			->set_output(json_encode($response)); 
  
	   
	}

}   