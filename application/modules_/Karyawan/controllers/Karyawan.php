<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Karyawan extends MY_Admin {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_karyawan');
    } 

    function ajax_get_list_karyawan(){
        $bindings = array();
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && empty($_POST))
        $request = json_decode(file_get_contents('php://input'), true);
        $data = $this->M_karyawan->get_datatables();
    	$output = array(
                        "draw" => isset ( $request['draw'] ) ?
                        intval( $request['draw'] ) :
                        0,
                        "recordsTotal" => $this->M_karyawan->count_all(),
                        "recordsFiltered" => $this->M_karyawan->count_filtered(),
                        "data" => $data,
				);
        echo json_encode($output);
    }

    function get_data_dept(){
        $data = $this->M_karyawan->get_data_dept();
		
        echo json_encode($data);
    }

    function get_data_area(){
        $data = $this->M_karyawan->get_data_area();
		
        echo json_encode($data);
    }

    function get_data_divisi(){
        $data = $this->M_karyawan->get_data_divisi();
		
        echo json_encode($data);
    }

    public function ajax_get_kode_karyawan(){
        $data = $this->M_karyawan->where_max()->row();
        //print_r($this->db->last_query());
        $json['maxs'] = @$data->maxs;
        echo json_encode($json);
    }

    public function ajax_add_karyawan(){
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Request-Headers: GET,POST,OPTIONS,DELETE,PUT");
        header("Access-Control-Allow-Headers: authorization, Content-Type");
		
		$fc_kdkaryawan = $this->input->post('fc_kdkaryawan');
		$fv_noktp = $this->input->post('fv_noktp');
		$fv_nama = $this->input->post('fv_nama');		
		$fv_alamat = $this->input->post('fv_alamat');
		
        $fc_kota = $this->input->post('fc_kota');
        $fv_notelp = $this->input->post('fv_notelp');
        $f_deptid = $this->input->post('f_deptid');
        $fc_sts = $this->input->post('fc_sts');
        $fc_kdarea = $this->input->post('fc_kdarea');
        $fc_kddivisi = $this->input->post('fc_kddivisi');
        
        $DataKaryawan = array(
                'fc_kdkaryawan' => $fc_kdkaryawan,
                'fv_noktp' => $fv_noktp,
                'fv_nama' => $fv_nama,
                'fv_alamat' => $fv_alamat,
                'fc_kota' => $fc_kota,
                'fv_notelp' => $fv_notelp,
                'f_deptid' => $f_deptid,
                'fc_sts' => $fc_sts,
                'fc_kdarea' => $fc_kdarea,
                'fc_kddivisi' => $fc_kddivisi,
        );
		 
        $this->db->insert('tm_karyawan',$DataKaryawan);
           
		$result['success'] = true;
		return die(json_encode($result));
        
    }
    
    public function ajax_get_by_id($id)
	{
		header("Access-Control-Allow-Origin: *");
		header("Access-Control-Allow-Headers: authorization, Content-Type");


		$blog = $this->M_karyawan->get_by_id2($id);

		$post = array(
			'fc_kdkaryawan' => $blog->fc_kdkaryawan,
			'fv_noktp' => $blog->fv_noktp,
			'fv_nama' => $blog->fv_nama,
            'fv_alamat' => $blog->fv_alamat,
            'fc_kota' => $blog->fc_kota,
            'fv_notelp' => $blog->fv_notelp,
            'f_deptid' => $blog->f_deptid,
            'fc_sts' => $blog->fc_sts,
            'fc_kdarea' => $blog->fc_kdarea,
            'fc_kddivisi' => $blog->fc_kddivisi,
		);
		

		$this->output
			->set_status_header(200)
			->set_content_type('application/json')
			->set_output(json_encode($post)); 
		
    }

    public function ajax_get_by_id_login($id){
        header("Access-Control-Allow-Origin: *");
		header("Access-Control-Allow-Headers: authorization, Content-Type");


		$blog = $this->M_karyawan->get_by_id3($id);

		$post = array(
			'fc_kdkaryawan' => $blog->fc_kdkaryawan,
            'fv_username' => $blog->fv_username,
            'fv_view_password' => $blog->fv_view_password,
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

		$fc_kdkaryawan = $this->input->post('fc_kdkaryawan');
		$fv_noktp = $this->input->post('fv_noktp');
		$fv_nama = $this->input->post('fv_nama');		
		$fv_alamat = $this->input->post('fv_alamat');
		
        $fc_kota = $this->input->post('fc_kota');
        $fv_notelp = $this->input->post('fv_notelp');
        $f_deptid = $this->input->post('f_deptid');
        $fc_sts = $this->input->post('fc_sts');
        $fc_kdarea = $this->input->post('fc_kdarea');
        $fc_kddivisi = $this->input->post('fc_kddivisi');
        
        $DataKaryawan = array(
                'fc_kdkaryawan' => $fc_kdkaryawan,
                'fv_noktp' => $fv_noktp,
                'fv_nama' => $fv_nama,
                'fv_alamat' => $fv_alamat,
                'fc_kota' => $fc_kota,
                'fv_notelp' => $fv_notelp,
                'f_deptid' => $f_deptid,
                'fc_sts' => $fc_sts,
                'fc_kdarea' => $fc_kdarea,
                'fc_kddivisi' => $fc_kddivisi,
        );
		
		$this->M_karyawan->updateKaryawan($fc_kdkaryawan, $DataKaryawan);

		$result['success'] = true;
		return die(json_encode($result));
    }
    
    public function ajax_edit_post_login($id){
        header("Access-Control-Allow-Origin: *");
		header("Access-Control-Allow-Headers: authorization, Content-Type");
		header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");

		$fc_kdkaryawan = $this->input->post('fc_kdkaryawan');
		$fv_username = $this->input->post('fv_username');
        $fv_view_password = $this->input->post('fv_view_password');

        $DataKaryawan = array(
                'fc_kdkaryawan' => $fc_kdkaryawan,
                'fv_username' => $fv_username,
                'fv_view_password' => $fv_view_password,
                'fv_password' => md5($fv_view_password)
        );
		
		$this->M_karyawan->updateLoginKaryawan($fc_kdkaryawan, $DataKaryawan);

		$result['success'] = true;
		return die(json_encode($result));	
    }    

	public function ajax_delete($id)
	{
	  header('Access-Control-Allow-Origin: *');
	  header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
	  header("Access-Control-Allow-Headers: authorization, Content-Type");
  
	 
	  //if($id){
	  $this->M_karyawan->deleteKaryawan(@$id);
  
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