<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class Transaksi extends MY_Admin {



	public function __construct(){

		parent::__construct();

		$this->load->model('M_transaksi');

		$this->load->model('M_transaksi_keuangan');

		$this->load->model('M_saldo_keuangan');

		$this->load->model('M_laporan_transaksi');

		$this->load->library('session');

    }

    function ajax_get_list_billing(){
        $bindings = array();
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && empty($_POST))
        $request = json_decode(file_get_contents('php://input'), true);
        $data = $this->M_transaksi->get_datatables();
    	$output = array(
                        "draw" => isset ( $request['draw'] ) ?
                        intval( $request['draw'] ) :
                        0,
                        "recordsTotal" => $this->M_transaksi->count_all(),
                        "recordsFiltered" => $this->M_transaksi->count_filtered(),
                        "data" => $data,
				);
        echo json_encode($output);
    }

    function ajax_get_list_transaksi(){
        $bindings = array();
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && empty($_POST))
        $request = json_decode(file_get_contents('php://input'), true);
        $data = $this->M_transaksi_keuangan->get_datatables();
    	$output = array(
                        "draw" => isset ( $request['draw'] ) ?
                        intval( $request['draw'] ) :
                        0,
                        "recordsTotal" => $this->M_transaksi_keuangan->count_all(),
                        "recordsFiltered" => $this->M_transaksi_keuangan->count_filtered(),
                        "data" => $data,
				);
        echo json_encode($output);
    }

    function ajax_get_list_saldo(){
        $bindings = array();
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && empty($_POST))
        $request = json_decode(file_get_contents('php://input'), true);
        $data = $this->M_saldo_keuangan->get_datatables();
    	$output = array(
                        "draw" => isset ( $request['draw'] ) ?
                        intval( $request['draw'] ) :
                        0,
                        "recordsTotal" => $this->M_saldo_keuangan->count_all(),
                        "recordsFiltered" => $this->M_saldo_keuangan->count_filtered(),
                        "data" => $data,
				);
        echo json_encode($output);
    }

    public function ajax_get_laporan_transaksi(){
    	$bindings = array();
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && empty($_POST))
        $request = json_decode(file_get_contents('php://input'), true);
        $data = $this->M_laporan_transaksi->get_datatables();
    	$output = array(
                        "draw" => isset ( $request['draw'] ) ?
                        intval( $request['draw'] ) :
                        0,
                        "recordsTotal" => $this->M_laporan_transaksi->count_all(),
                        "recordsFiltered" => $this->M_laporan_transaksi->count_filtered(),
                        "data" => $data,
				);
        echo json_encode($output);
    }

    public function ajax_get_data_jenis_transaksi(){
    	$rs = $this->M_transaksi->getJenisTransaksi()->result_array();
        echo json_encode($rs);
    }
    
    public function keuangan_transaksi_awal(){
		echo json_encode($this->M_transaksi->keuangan_transaksi_awal()->result());
	}
	
	public function ambil_jenis(){
		return die(json_encode($this->M_transaksi->jenis_tampil()->result_array()));
	}
	
	public function ambil_keuangan(){
		return die(json_encode($this->M_transaksi->tampil_jenis_keuangan()->result_array()));
	}
	
	public function simpan_transaksi_keuangan(){

		$data['dariAplikasi'] = $this->input->post('dariAplikasi');
		$data['id_karyawan'] = $this->input->post('id_karyawan');
		$data['nama_akun'] = $this->input->post('nama_akun');
		$data['keterangan_transaksi'] = $this->input->post('keterangan_transaksi');
		$data['pemasukan_transaksi'] = $this->input->post('pemasukan_transaksi');
		$data['nama_keuangan'] = $this->input->post('nama_keuangan');
		$data['kode_nama_keuangan'] = $this->input->post('nama_keuangan');
		$data['total'] = $this->input->post('total');
		$data['fc_kdarea'] = $this->input->post('fc_kdarea');
		$data['fc_kddivisi'] = $this->input->post('fc_kddivisi');

		$this->M_transaksi->simpan_transaksi_keuangan($data);

		if($data['dariAplikasi']){
			$result['success'] = true;
			return die(json_encode($result));
		}else{
			redirect(base_url('Transaksi'));
		}

	}

	public function ajax_add_transaksi(){
		$data['id_karyawan'] = $this->input->post('fc_kdkaryawan');
		if($this->input->post('jenisTransaksiPemasukan')){
			$data['nama_akun'] = $this->input->post('jenisTransaksiPemasukan');
		}

		if($this->input->post('jenisTransaksiPengeluaran')){
			$data['nama_akun'] = $this->input->post('jenisTransaksiPengeluaran');
		}
		
		$data['keterangan_transaksi'] = $this->input->post('keterangan');
		$data['pemasukan_transaksi'] = $this->input->post('jenisTransaksi');
		$data['nama_keuangan'] = $this->input->post('jenisKeuangan');
		$data['kode_nama_keuangan'] = $this->input->post('jenisKeuangan');
		$data['total'] = $this->input->post('total');
		$data['fc_kdarea'] = $this->input->post('fc_kdarea');
		$data['fc_kddivisi'] = $this->input->post('fc_kddivisi');

		$this->M_transaksi->simpan_transaksi_keuangan($data);

		//if($data['dariAplikasi']){
		$result['success'] = true;
		return die(json_encode($result));
		
	}
	
	public function simpan_transaksi_keuangan_ubah($ok=null){

		$data['dariAplikasi'] = $this->input->post('dariAplikasi');
		$data['id_karyawan'] = $this->input->post('id_karyawan');
		$data['kode_transaksi_master'] = $this->input->post('kode_transaksi_master');
	//	$data['nama_akun'] = $this->input->post('id_nama_keuangan');
		$data['keterangan_transaksi'] = $this->input->post('keterangan_transaksi');
		/*$data['pemasukan_transaksi'] = $this->input->post('pemasukan_transaksi');*/
		//$data['nama_keuangan'] = $this->input->post('jenis_keuangan');
		
		$data['total'] = $this->input->post('total');
		$data['debit_transaksi_master'] = $this->input->post('debit_transaksi_master');

		$this->M_transaksi->simpan_transaksi_keuangan_ubah($data);
		
		if($data['dariAplikasi']){
			$result['success'] = true;
			return die(json_encode($result));
		}

		if(empty($ok)){
			redirect(base_url('Transaksi/laporan_transaksi'));
		}else{
			redirect(base_url('Transaksi'));
		}

		

		

	}
}