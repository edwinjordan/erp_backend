<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class Laporan extends MY_Admin {



	public function __construct(){

		parent::__construct();

		$this->load->model('M_stock_menipis');

        $this->load->model('M_return_penjualan');

        $this->load->model('M_hutang_pembelian');

        $this->load->model('M_piutang_penjualan');

		$this->load->library('session');

    }

    function ajax_get_stock_menipis(){
        $bindings = array();
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && empty($_POST))
        $request = json_decode(file_get_contents('php://input'), true);
        $data = $this->M_stock_menipis->get_datatables();
    	$output = array(
                        "draw" => isset ( $request['draw'] ) ?
                        intval( $request['draw'] ) :
                        0,
                        "recordsTotal" => $this->M_stock_menipis->count_all(),
                        "recordsFiltered" => $this->M_stock_menipis->count_filtered(),
                        "data" => $data,
				);
        echo json_encode($output);
    }

    function ajax_get_return_penjualan(){
        $bindings = array();
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && empty($_POST))
        $request = json_decode(file_get_contents('php://input'), true);
        $data = $this->M_return_penjualan->get_datatables();
        $output = array(
                        "draw" => isset ( $request['draw'] ) ?
                        intval( $request['draw'] ) :
                        0,
                        "recordsTotal" => $this->M_return_penjualan->count_all(),
                        "recordsFiltered" => $this->M_return_penjualan->count_filtered(),
                        "data" => $data,
                );
        echo json_encode($output);
    }

    function ajax_get_rincian_retur($id){
        $data = $this->M_return_penjualan->get_rincian_retur($id);
        
        echo json_encode($data);
    }

    function ajax_get_hutang_pembelian(){
        $bindings = array();
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && empty($_POST))
        $request = json_decode(file_get_contents('php://input'), true);
        $data = $this->M_hutang_pembelian->get_datatables();
        $output = array(
                        "draw" => isset ( $request['draw'] ) ?
                        intval( $request['draw'] ) :
                        0,
                        "recordsTotal" => $this->M_hutang_pembelian->count_all(),
                        "recordsFiltered" => $this->M_hutang_pembelian->count_filtered(),
                        "data" => $data,
                );
        echo json_encode($output);
    }

    function ajax_get_piutang_penjualan(){
        $bindings = array();
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && empty($_POST))
        $request = json_decode(file_get_contents('php://input'), true);
        $data = $this->M_piutang_penjualan->get_datatables();
        $output = array(
                        "draw" => isset ( $request['draw'] ) ?
                        intval( $request['draw'] ) :
                        0,
                        "recordsTotal" => $this->M_piutang_penjualan->count_all(),
                        "recordsFiltered" => $this->M_piutang_penjualan->count_filtered(),
                        "data" => $data,
                );
        echo json_encode($output);
    }

}   