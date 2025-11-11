<?php
defined('BASEPATH') OR exit('No direct script access allowed');

header('Content-Type: application/json');
require APPPATH . '/libraries/REST_Controller.php';
// use Restserver\Libraries\REST_Controller;

class Api extends CI_Controller {

  public function __construct(){
    parent::__construct();
    $this->load->model('m_user');
    $this->load->model('m_barang');
    $this->load->model('m_supplier');
    $this->load->model('m_pelanggan');
    $this->load->model('m_pembelian');
    $this->load->model('m_penjualan');
    $this->load->library('session');
	}
	
  public function login(){ 
    $response = new stdClass();
		$username=$this->input->get('username');
		$password=md5($this->input->get("password"));
		
		$response->username = $username;
		$response->password = $password;

		if ((empty($username)) || (empty($password))) { 
		
		$response->success = 0;
		$response->message = "Lengkapi username dan password"; 
		die(json_encode($response));
		}
		$cek = $this->m_user->where(array('username' => $username, 'password' => $password));
		$hasil = $cek->result_array();
		
		// $this->m_user->update(array('status' => 1),array('id_karyawan' => $hasil[0]['id_karyawan']));
		if ($cek->num_rows() > 0) {
		 
				$response->success = true;
				$response->message = "success";
				$response->data = array(
										'id_karyawan' => $hasil[0]['id_karyawan'],
										'kode_karyawan' => $hasil[0]['kode_karyawan'],
										'username' => $hasil[0]['username'],
										'password' => $hasil[0]['password'],
										'nama' => $hasil[0]['nama'],
										'alamat' => $hasil[0]['alamat'], 
										'no_telp' => $hasil[0]['no_telp'], 
										'email' => $hasil[0]['email'], 
										'date_input' => $hasil[0]['date_input'], 
										'date_edit' => $hasil[0]['date_edit'], 
										'token' => $hasil[0]['token'], 
									);
				die(json_encode($response));
			
		}
		else {
				$response->success = false;
				$response->message = "username dan password salah";
				die(json_encode($response));
		}
	}

	public function barang($search = ''){
		// $search = ''; 
		$response = new stdClass();
		// $data;
		if($search != null){
			$data = $this->m_barang->search_barang($search);
		}else{
			$data = $this->m_barang->list_barang();
		}
		if ($data->num_rows() > 0) {
				$response->data = array();
				$v = array();
				foreach ($data->result_array() as $key => $value) {
					$v = $value;
					$v['detail_harga'] = array();
					$detail = $this->m_barang->where_harga(array('id_barang' => $value['id_barang'] ));
					if($detail->num_rows() > 0){
						foreach ($detail->result_array() as $key2 => $value2) {
							unset($value2['id_barang']);
							$v['detail_harga'][] = $value2;
						}
					}else{
						$v['detail_harga'] = 'tidak ada data';
					}

					$response->data[] = $v;

				}
				
				die(json_encode($response));
		}
		else {
				$response->success = false;
				$response->message = "data barang tidak ada";
				die(json_encode($response));
		}
	}
	
	public function supplier(){ 
    $response = new stdClass();
		$data = $this->m_supplier->all();
		if ($data->num_rows() > 0) {
		 
				$response->success = true;
				$response->message = "success";
				$response->data = array();
				foreach ($data->result_array() as $key => $value) {
					$response->data[] = $value;
					
				}
				die(json_encode($response));
			
		}
		else {
				$response->success = false;
				$response->message = "data supplier tidak ada";
				die(json_encode($response));
		}
	}
	
	public function pelanggan(){ 
    $response = new stdClass();
		$search = $_GET['search'];
		$data;
		if($search != null){
			$data = $this->m_pelanggan->search_pelanggan($search);
		}else{
			$data = $this->m_pelanggan->all();
		}
		if ($data->num_rows() > 0) {
		 
				$response->success = true;
				$response->message = "success";
				$response->data = array();
				foreach ($data->result_array() as $key => $value) {
					$response->data[] = $value;
					
				}
				die(json_encode($response));
			
		}
		else {
				$response->success = false;
				$response->message = "data pelanggan tidak ada";
				die(json_encode($response));
		}
	}
	
	public function nonota(){
	  $data['nota'] 		= $this->m_pembelian->fak()->num_rows()+1; 
		$data['supplier'] 	= $this->m_pembelian->getSupplier()->result();
		$data['barang'] 	= $this->m_pembelian->getBarang()->result();
		die(json_encode($data));
	}

	public function nonotapenjualan(){
		$nota = $this->m_penjualan->max()->row();
    $kode = $nota->maxs;
    $urut = (int) substr($kode, 4, 3);
    $urut++;
    $char = "NOTA";
    $kode = $char . sprintf("%03s", $urut);


    $data['nota'] = $kode;
    $data['pelanggan'] = $this->m_pelanggan->all()->result();

    die(json_encode($data));
	}
	
	public function pembelian(){ 
    $response = new stdClass();
    $tgl = new DateTime("now", new DateTimeZone('Asia/Jakarta'));

		$date=$tgl->format('m/d/Y');
		$time=$tgl->format('H:i:s');

		$no_faktur=$this->input->post("no_faktur");
		$no_nota=$this->input->post("no_nota");
		$metode_pembayaran=$this->input->post("metode_pembayaran");
		$total_harga=$this->input->post("total_harga");
		$biaya=$this->input->post("biaya");
		$selisih=($this->input->post('biaya')-$this->input->post('total_harga'));
		$id_karyawan=$this->input->post("id_karyawan");
		$id_supplier=$this->input->post("id_supplier");
		$coly=$this->input->post("coly");
		$status=$this->input->post("status");

		if(!empty($no_faktur) && !empty($no_nota) && !empty($metode_pembayaran) && !empty($total_harga) && !empty($biaya) && !empty($id_karyawan) && !empty($id_supplier) && !empty($coly) && $status != ''){

			// save to pembelian dan detail pembelian
			$last_id = $this->m_pembelian->insert(array(
				'date' => $date, 
				'time' => $time, 
				'no_faktur' => $no_faktur, 
				'no_nota' => $no_nota, 
				'metode_pembayaran' => $metode_pembayaran, 
				'total_harga' => $total_harga, 
				'biaya' => $biaya, 
				'selisih' => $selisih, 
				'id_karyawan' => $id_karyawan,
				'id_supplier' => $id_supplier,
				'status'=> $status
			));

			$dataDetailPembelian = array(
				'id_pembelian'	=> $last_id, 
				'id_barang' 	=> $this->input->post('id_barang'),
				'ket' 			=> $this->input->post('ket'),
			);;
			$this->m_pembelian->insertDetail($dataDetailPembelian);

			// Save to gudang and gudang detail
			if($last_id != null){
				
				// $this->m_pembelian->insertGudang(array(
				// 	'id_pembelian' => $last_id,
				// 	'coly' => $coly,
				// 	'id_supplier' => $id_supplier,
				// ));

				// Config upload gambar
				// $nama_gambar = uniqid();
				// $config['upload_path']          = './assets/images/';
				// $config['allowed_types']        = 'jpg|png';
				// $config['max_size']             = 2048 ;
				// $config['file_name']			= $nama_gambar;

				// $this->load->library('upload', $config);

				// if ( ! $this->upload->do_upload('image'))
				// {
					// Insert data_gudang
					// $dataGudang = array(
					// 	'id_supplier' 	=> $this->input->post('id_supplier'), 
					// 	'id_pembelian' 	=> $last_id, 
					// 	'coly' 			=> $this->input->post('coly'), 
					// 	'nama_gudang' 	=> $this->input->post('nama_gudang'), 
					// 	'image' 		=> 'default.png' 
					// );

					// $id_gudang = $this->m_pembelian->insertGudang($dataGudang);
				// }
				// else
				// {
				// 	// Insert data_gudang
				// 	$dataGudang = array(
				// 		'id_supplier' 	=> $this->input->post('supplier'), 
				// 		'id_pembelian' 	=> $last_id, 
				// 		'coly' 			=> $this->input->post('coly'), 
				// 		'nama_gudang' 	=> $this->input->post('nama_gudang'), 
				// 		'image' 		=> $this->upload->data('file_name')
				// 	);

				// 	$id_gudang = $this->m_pembelian->insertGudang($dataGudang);
				// }

				$dataDetailGudang = array(
					'id_barang' 	=> $this->input->post('id_barang'),
					'id_gudang'		=> $id_gudang, 
					'date_input'	=> date('d/m/Y'),
				);
				$this->m_pembelian->insertDetailGudang($dataDetailGudang);

				$response->success = true;
				$response->message = "Berhasil Menambahkan Pembelian";
				die(json_encode($response));
			}else{
				$response->success = false;
				$response->message = "gagal input ke gudang";
				die(json_encode($response));
			}
		}else{
			$response->success = false;
			$response->message = "Mohon isikan semua";
			$response->data = array(
				'date' => $date, 
				'time' => $time, 
				'no_faktur' => $no_faktur, 
				'no_nota' => $no_nota, 
				'metode_pembayaran' => $metode_pembayaran, 
				'total_harga' => $total_harga, 
				'biaya' => $biaya, 
				'selisih' => $selisih, 
				'id_karyawan' => $id_karyawan,
				'id_supplier' => $id_supplier,
				'status'=> $status
			);
			die(json_encode($response));
		}
	}

	public function ambilBarang(){
		echo $this->m_penjualan->ambilBarang();
	}

	public function penjualan(){ 
		$response = new stdClass();
		//
			// $input = $this->input->raw_input_stream;
			// $params = array();
			// $params = json_decode($input, true);
			// $x = array();

			// $x['id_karyawan'] = $params['id_karyawan'];
			// $x['id_pelanggan'] = $params['id_pelanggan'];
			// $x['date'] = $params['date'];
			// $x['time'] = $params['time'];
			// $x['no_faktur'] = $params['no_faktur'];
			// $x['no_nota'] = $params['no_nota'];
			// $x['metode_pembayaran'] = $params['metode_pembayaran'];
			// $x['total_harga'] = $params['total_harga'];
			// $x['biaya'] = $params['biaya'];
			// $x['selisih'] = $params['selisih'];

			// $x['diskon_persen'] = $params['diskon_persen'];
			// $x['diskon_rupiah'] = $params['diskon_rupiah'];

			// $x['detail_penjualan'] = $params['detail_penjualan'];

			// $last_id = $this->m_penjualan->insert($x);	
			// if($last_id != null){
			// 	if(count($params['detail_penjualan']) > 0){
			// 		foreach ($params['detail_penjualan'] as $key) {
			// 			$v = array();
			// 			$v['id_penjualan'] = $last_id;
			// 			$v['id_barang'] = $key['id_barang'];
			// 			$v['id_varian_harga'] = $key['id_varian_harga'];
			// 			$v['qty'] = $key['qty'];
			// 			$v['total_harga'] = $key['total_harga'];
			// 			$v['ket'] = $key['ket'];
			// 			$this->m_penjualan->insert_detail($v);
			// 		}

			// 		$response->success = true;
			// 		$response->message = "success";
			// 		die(json_encode($response));
			// 	}else{
			// 		$response->success = false;
			// 		$response->message = "detail_pejualan belum diisi";
			// 		die(json_encode($response));
			// 	}
			// }else{
			// 	$response->success = false;
			// 	$response->message = "variable penjualan salah";
			// 	die(json_encode($response));
			// }	

		//
	    // $data_penjualan['detail_pejualan'] = $data_detail_penjualan;
			// foreach ($this->input->post('detail_penjualan') as $key) {
			// 	$key = json_decode($key, true);
			// 	$v = array();
			// 	$v['id_penjualan'] = $last_id;
			// 	$v['id_barang'] = $key['id_barang'];
			// 	$v['id_varian_harga'] = $key['id_varian_harga'];
			// 	$v['qty'] = $key['qty']; 
			// 	$v['total_harga'] = $key['total_harga'];
			// 	$v['ket'] = $key['ket'];
			// 	$data_penjualan['detail_pejualan'][] = $v;
			// }


		$tgl = new DateTime("now", new DateTimeZone('Asia/Jakarta'));
		$data_penjualan = array(
      'id_karyawan'          => $this->input->post('id_karyawan'), 
      'id_pelanggan'         => $this->input->post('id_pelanggan'), 
      'date'                 => $tgl->format('m/d/Y'), 
      'time'                 => $tgl->format('H:i:s'), 
      'no_faktur'            => $this->input->post('no_nota'), 
      'no_nota'              => $this->input->post('no_nota'), 
      'metode_pembayaran'    => $this->input->post('metode_pembayaran'), 
      'total_harga'          => $this->input->post('Total'), 
      'biaya'                => $this->input->post('cash'), 
      'selisih'              => ($this->input->post('cash') - $this->input->post('Total')), 
      'status'								=> 2
      // 'detail_penjualan'     => $this->input->post('detail_penjualan'), 
    );
		$id_penjualan = $this->m_penjualan->insert($data_penjualan);

		if(count($params['id_barang']) > 0){
			for ($i=0; $i < count($_POST['id_barang']); $i++) { 
	      $data_detail_penjualan[] = array(
	        'id_penjualan'    => $id_penjualan, 
	        'id_barang'       => $_POST['id_barang'][$i], 
	        'id_varian_harga' => $_POST['id_varian_harga'][$i], 
	        'qty'             => $_POST['jumlah_beli'][$i], 
	        'total_harga'     => $_POST['sub_total'][$i], 
	      );
	    }
	    $this->db->insert_batch('detail_penjualan', $data_detail_penjualan);
	    for ($i=0; $i < count($_POST['id_barang']); $i++) { 
	        # code...
	        $data_hold_penjualan[] = array(
	            'id_barang'       => $_POST['id_barang'][$i], 
	            'id_varian'       => $_POST['id_varian_harga'][$i],
	            'id_karyawan'     => $this->session->userdata('id_karyawan'),  
	            'qty'             => $_POST['jumlah_beli'][$i], 
	            'date'            => $tgl->format('m/d/Y'), 
	      			'time'            => $tgl->format('H:i:s'),  
	        );
	    }
	    $this->db->insert_batch('hold_penjualan', $data_hold_penjualan);
			
			$response->success = true;
			$response->message = "Transaksi berhasil di simpan !!";
			$response->data = $data_penjualan;
			die(json_encode($response));
		}else{
			$response->success = false;
			$response->message = "Transaksi gagal di simpan. tidak ada barang !!";
			$response->data = $data_penjualan;
			die(json_encode($response));
		}
	}

	public function testpenjualan(){ 
		$response = new stdClass();
		$tgl = new DateTime("now", new DateTimeZone('Asia/Jakarta'));
		$data_penjualan = array(
      'id_karyawan'          => $this->input->post('id_karyawan'), 
      'id_pelanggan'         => $this->input->post('id_pelanggan'), 
      'date'                 => $tgl->format('m/d/Y'), 
      'time'                 => $tgl->format('H:i:s'), 
      'no_faktur'            => $this->input->post('no_nota'), 
      'no_nota'              => $this->input->post('no_nota'), 
      // 'metode_pembayaran'    => $this->input->post('metode_pembayaran'), 
      'total_harga'          => $this->input->post('Total'), 
      // 'biaya'                => $this->input->post('cash'), 
      'selisih'              => ($this->input->post('cash') - $this->input->post('Total')), 
      'status'								=> 2
      // 'detail_penjualan'     => $this->input->post('detail_penjualan'), 
    );
		$response->data = $data_penjualan;
		// $id_penjualan = $this->m_penjualan->insert($data_penjualan);

		if($this->input->post('id_barang') > 0){
			for ($i=0; $i < count($_POST['id_barang']); $i++) { 
	      $data_detail_penjualan[] = array(
	        // 'id_penjualan'    => $id_penjualan, 
	        'id_barang'       => $_POST['id_barang'][$i], 
	        'id_varian_harga' => $_POST['id_varian_harga'][$i], 
	        'qty'             => $_POST['jumlah_beli'][$i], 
	        'total_harga'     => $_POST['sub_total'][$i], 
	      );
	    }
	    $response->data['barang'] = $data_detail_penjualan;
	    // $this->db->insert_batch('detail_penjualan', $data_detail_penjualan);
	    // for ($i=0; $i < count($_POST['id_barang']); $i++) { 
	    //     # code...
	    //     $data_hold_penjualan[] = array(
	    //         'id_barang'       => $_POST['id_barang'][$i], 
	    //         'id_varian'       => $_POST['id_varian_harga'][$i],
	    //         'id_karyawan'     => $this->session->userdata('id_karyawan'),  
	    //         'qty'             => $_POST['jumlah_beli'][$i], 
	    //         'date'            => $tgl->format('m/d/Y'), 
	    //   			'time'            => $tgl->format('H:i:s'),  
	    //     );
	    // }
	    // $this->db->insert_batch('hold_penjualan', $data_hold_penjualan);
			
			$response->success = true;
			$response->message = "Transaksi berhasil di simpan !!";
			die(json_encode($response));
		}else{
			$response->success = false;
			$response->message = "Transaksi gagal di simpan. tidak ada barang !!";
			$response->data = $data_penjualan;
			die(json_encode($response));
		}
	}

	public function konfirmasiBayar(){
		die(json_encode($this->m_penjualan->list_konfirmasiBayar()));
	}
	public function detailhistory($id)
  {
      $where = array('id_penjualan' => $id );
      
      $data['detail'] =  $this->m_penjualan->where_detail($where)->result();
      die(json_encode($data));
  }

  public function kasirBayar($id){
  		$where = array('status' => 1);
  		$id = array('id_penjualan' => $id);
      die(json_encode($this->m_penjualan->update($where, $id)));
  }

	public function historypenjualan(){
		die(json_encode($this->m_penjualan->list_penjualanAndroid()));
	}

	public function historypembelian(){
		die(json_encode($this->m_pembelian->all()->result()));
	}

	public function get_karyawan(){
		$this->db->select('kode_karyawan');
		$this->db->select('nama');
		$this->db->from('karyawan');
		die(json_encode($this->db->get()->result()));
	}
}