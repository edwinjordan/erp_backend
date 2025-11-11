<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Barang extends MY_Admin {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_barang');
    } 

    function ajax_get_list_barang(){
        $bindings = array();
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && empty($_POST))
        $request = json_decode(file_get_contents('php://input'), true);
        $data = $this->M_barang->get_datatables();
    	$output = array(
                        "draw" => isset ( $request['draw'] ) ?
                        intval( $request['draw'] ) :
                        0,
                        "recordsTotal" => $this->M_barang->count_all(),
                        "recordsFiltered" => $this->M_barang->count_filtered(),
                        "data" => $data,
				);
        echo json_encode($output);
    }

    function randomString($length = 10) {
        $str = "";
        $characters = array_merge(range('0','9'));
        $max = count($characters) - 1;
        for ($i = 0; $i < $length; $i++) {
            $rand = mt_rand(0, $max);
            $str  .= $characters[$rand];
        }
        return $str;
    }

    function get_data_tipe(){
        $data = $this->M_barang->get_data_tipe();
		
        echo json_encode($data);
    }

    function get_data_group(){
        $data = $this->M_barang->get_data_group();
		
        echo json_encode($data);
    }

    function get_data_brand(){
        $data = $this->M_barang->get_data_brand();
		
        echo json_encode($data);
    }

    function get_data_satuan(){
        $data = $this->M_barang->get_data_satuan();
		
        echo json_encode($data);
    }

    public function ajax_add_post(){
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Request-Headers: GET,POST,OPTIONS,DELETE,PUT");
        header("Access-Control-Allow-Headers: authorization, Content-Type");
  
    
        $fc_kdstock = $this->input->post('fc_kdstock');
        $fv_namastock = $this->input->post('fv_namastock');
        $fc_kdtipe = $this->input->post('fc_kdtipe');
        $fc_kdbrand = $this->input->post('fc_kdbrand');
        $fc_kdgroup = $this->input->post('fc_kdgroup');
        $fm_hargajual = $this->input->post('fm_hargajual');
        $fm_hargabeli = $this->input->post('fm_hargabeli');
        $fn_qtymin = $this->input->post('fn_qtymin');
        $fn_qtymax = $this->input->post('fn_qtymax');
        $fn_qtyPOmax = $this->input->post('fn_qtyPOmax');
        $fn_qtyPOmin = $this->input->post('fn_qtyPOmin');
        $fc_status = $this->input->post('fc_status');
        $fv_ket = $this->input->post('fv_ket');
        $ff_disc_persen = $this->input->post('ff_disc_persen');
        $ff_disc_rupiah = $this->input->post('ff_disc_rupiah');
        $fm_ongkir = $this->input->post('fm_ongkir');
        $fc_kdsatuan = $this->input->post('fc_kdsatuan');
            
        $filename = NULL;
    
        $isUploadError = FALSE;

        $config['upload_path'] =  './assets/images/';
        $config['allowed_types']        = 'gif|jpg|png';
        $config['max_size'] = '2000000';
        
        $new_name = 'fotobarang_'.time();
        $config['file_name'] = $new_name;
        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        if(!$this->upload->do_upload('image')){   
              $blogData = array(
                'fc_kdstock' => $fc_kdstock,
                'fc_barcode' => $this->randomString(),
                'fv_namastock' => $fv_namastock,
                'fc_kdtipe' => $fc_kdtipe,
                'fc_kdbrand' => $fc_kdbrand,
                'fc_kdgroup' => $fc_kdgroup,
                'fm_hargajual' => $fm_hargajual,
                'fm_hargabeli' => $fm_hargabeli,
                'fn_qtymin' => $fn_qtymin,
                'fn_qtymax' => $fn_qtymax,
                'fn_qtyPOmax' => $fn_qtyPOmax,
                'fn_qtyPOmin' => $fn_qtyPOmin,
                'fc_status' => $fc_status,
                'fv_ket' => $fv_ket,
                'ff_disc_persen' => $ff_disc_persen,
                'ff_disc_rupiah' => $ff_disc_rupiah,
                'fm_ongkir' => $fm_ongkir,
                'fc_kdsatuan' => $fc_kdsatuan,
              );
    
            $id = $this->M_barang->insertBarang($blogData);

            $response = array(
              'status' => 'success'
            );
        }else{
            $get_name = $this->upload->data();
            $nama_foto = $get_name['file_name'];
            $gambar1 = $nama_foto;
            $blogData = array(
                'fc_kdstock' => $fc_kdstock,
                'fc_barcode' => $this->randomString(),
                'fv_namastock' => $fv_namastock,
                'fc_kdtipe' => $fc_kdtipe,
                'fc_kdbrand' => $fc_kdbrand,
                'fc_kdgroup' => $fc_kdgroup,
                'fm_hargajual' => $fm_hargajual,
                'fm_hargabeli' => $fm_hargabeli,
                'fn_qtymin' => $fn_qtymin,
                'fn_qtymax' => $fn_qtymax,
                'fn_qtyPOmax' => $fn_qtyPOmax,
                'fn_qtyPOmin' => $fn_qtyPOmin,
                'fc_status' => $fc_status,
                'fv_ket' => $fv_ket,
                'ff_disc_persen' => $ff_disc_persen,
                'ff_disc_rupiah' => $ff_disc_rupiah,
                'fm_ongkir' => $fm_ongkir,
                'fc_kdsatuan' => $fc_kdsatuan,
                'f_foto' => $gambar1
            );
    
            $id = $this->M_barang->insertBarang($blogData);

            $response = array(
              'status' => 'success'
            );
        }  
    
          $this->output
            ->set_status_header(200)
            ->set_content_type('application/json')
            ->set_output(json_encode($response)); 
        
    }
  
      public function ajax_get_by_id($id)
    {
      header("Access-Control-Allow-Origin: *");
      header("Access-Control-Allow-Headers: authorization, Content-Type");
  
  
        $blog = $this->M_barang->get_by_id2($id);
  
        $post = array(
          'fn_id' => $blog->fn_id,
          'fc_kdstock' => $blog->fc_kdstock,
          'fv_namastock' => $blog->fv_namastock,
          'fc_kdtipe' => $blog->fc_kdtipe,
          'fc_kdbrand' => $blog->fc_kdbrand,
          'fc_kdgroup' => $blog->fc_kdgroup,
          'fm_hargajual' => $blog->fm_hargajual,
          'fm_hargabeli' => $blog->fm_hargabeli,
          'fn_qtymin' => $blog->fn_qtymin,
          'fn_qtymax' => $blog->fn_qtymax,
          'fn_qtyPOmax' => $blog->fn_qtyPOmax,
          'fn_qtyPOmin' => $blog->fn_qtyPOmin,
          'fc_status' => $blog->fc_status,
          'fv_ket' => $blog->fv_ket,
          'ff_disc_persen' => $blog->ff_disc_persen,
          'ff_disc_rupiah' => $blog->ff_disc_rupiah,
          'fm_ongkir' => $blog->fm_ongkir,
          'fc_kdsatuan' => $blog->fc_kdsatuan,
          'f_foto' => base_url('assets/images/'.$blog->f_foto),
        );
        
  
        $this->output
          ->set_status_header(200)
          ->set_content_type('application/json')
          ->set_output(json_encode($post)); 
      
    }
  
    public function ajax_edit_post($id)
    {
      header("Access-Control-Allow-Origin: *");
      header("Access-Control-Allow-Headers: authorization, Content-Type");
      header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
  
  
        $blog = $this->M_barang->get_by_id2($id);
        $filename = $blog->f_foto;
  
        $fc_kdstock = $this->input->post('fc_kdstock');
        $fv_namastock = $this->input->post('fv_namastock');
        $fc_kdtipe = $this->input->post('fc_kdtipe');
        $fc_kdbrand = $this->input->post('fc_kdbrand');
        $fc_kdgroup = $this->input->post('fc_kdgroup');
        $fm_hargajual = $this->input->post('fm_hargajual');
        $fm_hargabeli = $this->input->post('fm_hargabeli');
        $fn_qtymin = $this->input->post('fn_qtymin');
        $fn_qtymax = $this->input->post('fn_qtymax');
        $fn_qtyPOmax = $this->input->post('fn_qtyPOmax');
        $fn_qtyPOmin = $this->input->post('fn_qtyPOmin');
        $fc_status = $this->input->post('fc_status');
        $fv_ket = $this->input->post('fv_ket');
        $ff_disc_persen = $this->input->post('ff_disc_persen');
        $ff_disc_rupiah = $this->input->post('ff_disc_rupiah');
        $fm_ongkir = $this->input->post('fm_ongkir');
        $fc_kdsatuan = $this->input->post('fc_kdsatuan');
  
          $isUploadError = FALSE;
  
          $config['upload_path'] =  './assets/images/';
          $config['allowed_types']        = 'gif|jpg|png';
          $config['max_size'] = '2000000';
          
          $new_name = 'fotokaryawan_'.time();
          $config['file_name'] = $new_name;
          $this->load->library('upload', $config);
          $this->upload->initialize($config);   
          if(!$this->upload->do_upload('image')){ 
            $blogData = array(
                'fc_kdstock' => $fc_kdstock,
                'fv_namastock' => $fv_namastock,
                'fc_kdtipe' => $fc_kdtipe,
                'fc_kdbrand' => $fc_kdbrand,
                'fc_kdgroup' => $fc_kdgroup,
                'fm_hargajual' => $fm_hargajual,
                'fm_hargabeli' => $fm_hargabeli,
                'fn_qtymin' => $fn_qtymin,
                'fn_qtymax' => $fn_qtymax,
                'fn_qtyPOmax' => $fn_qtyPOmax,
                'fn_qtyPOmin' => $fn_qtyPOmin,
                'fc_status' => $fc_status,
                'fv_ket' => $fv_ket,
                'ff_disc_persen' => $ff_disc_persen,
                'ff_disc_rupiah' => $ff_disc_rupiah,
                'fm_ongkir' => $fm_ongkir,
                'fc_kdsatuan' => $fc_kdsatuan,
              );
  
              $this->M_barang->updateBarang($id, $blogData);
  
              $response = array(
              'status' => 'success'
              ); 
  
          }else{
              $get_name = $this->upload->data();
              $nama_foto = $get_name['file_name'];
              $gambar1 = $nama_foto;
              $blogData = array(
                'fc_kdstock' => $fc_kdstock,
                'fv_namastock' => $fv_namastock,
                'fc_kdtipe' => $fc_kdtipe,
                'fc_kdbrand' => $fc_kdbrand,
                'fc_kdgroup' => $fc_kdgroup,
                'fm_hargajual' => $fm_hargajual,
                'fm_hargabeli' => $fm_hargabeli,
                'fn_qtymin' => $fn_qtymin,
                'fn_qtymax' => $fn_qtymax,
                'fn_qtyPOmax' => $fn_qtyPOmax,
                'fn_qtyPOmin' => $fn_qtyPOmin,
                'fc_status' => $fc_status,
                'fv_ket' => $fv_ket,
                'ff_disc_persen' => $ff_disc_persen,
                'ff_disc_rupiah' => $ff_disc_rupiah,
                'fm_ongkir' => $fm_ongkir,
                'fc_kdsatuan' => $fc_kdsatuan,
                'f_foto' => $gambar1
                );
  
                $this->M_barang->updateBarang($id, $blogData);
  
              $response = array(
              'status' => 'success'
              );
  
          }    
           
             
  
        $this->output
          ->set_status_header(200)
          ->set_content_type('application/json')
          ->set_output(json_encode($response)); 
      
    }

    public function ajax_delete($id)
  {
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
    header("Access-Control-Allow-Headers: authorization, Content-Type");

   

      
        $this->M_barang->deleteBarang(@$id);


        $response = array(
          'status' => 'success'
        );
  
        $this->output
          ->set_status_header(200)
          ->set_content_type('application/json')
          ->set_output(json_encode($response)); 

     
    }

}    