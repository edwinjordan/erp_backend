<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Stock extends MY_Admin {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_stock');
        $this->load->model('M_kartu_stock');
        $this->load->model('M_koreksi_stock');
        $this->load->model('M_transfer_stock');
    } 

    function ajax_get_list_stock(){
        $bindings = array();
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && empty($_POST))
        $request = json_decode(file_get_contents('php://input'), true);
        $data = $this->M_stock->get_datatables();
    	$output = array(
                        "draw" => isset ( $request['draw'] ) ?
                        intval( $request['draw'] ) :
                        0,
                        "recordsTotal" => $this->M_stock->count_all(),
                        "recordsFiltered" => $this->M_stock->count_filtered(),
                        "data" => $data,
				);
        echo json_encode($output);
    }
    
    function ajax_get_list_kartu_stock(){
        
        $bindings = array();
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && empty($_POST))
        $request = json_decode(file_get_contents('php://input'), true);
        $data = $this->M_kartu_stock->get_datatables();
    	$output = array(
                        "draw" => isset ( $request['draw'] ) ?
                        intval( $request['draw'] ) :
                        0,
                        "recordsTotal" => $this->M_kartu_stock->count_all(),
                        "recordsFiltered" => $this->M_kartu_stock->count_filtered(),
                        "data" => $data,
				);
        echo json_encode($output);
        
    }

    function ajax_get_list_koreksi_stock(){
        
        $bindings = array();
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && empty($_POST))
        $request = json_decode(file_get_contents('php://input'), true);
        $data = $this->M_koreksi_stock->get_datatables();
    	$output = array(
                        "draw" => isset ( $request['draw'] ) ?
                        intval( $request['draw'] ) :
                        0,
                        "recordsTotal" => $this->M_koreksi_stock->count_all(),
                        "recordsFiltered" => $this->M_koreksi_stock->count_filtered(),
                        "data" => $data,
				);
        echo json_encode($output);
        
    }

    function ajax_get_list_transfer_stock(){
        
        $bindings = array();
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && empty($_POST))
        $request = json_decode(file_get_contents('php://input'), true);
        $data = $this->M_transfer_stock->get_datatables();
      //  print_r($this->db->last_query());
    	$output = array(
                        "draw" => isset ( $request['draw'] ) ?
                        intval( $request['draw'] ) :
                        0,
                        "recordsTotal" => $this->M_transfer_stock->count_all(),
                        "recordsFiltered" => $this->M_transfer_stock->count_filtered(),
                        "data" => $data,
				);
        echo json_encode($output);
        
    }

    function ajax_get_data_barang(){
        $rs = $this->M_stock->getBarang()->result();
        echo json_encode($rs);
    }

    public function ajax_get_kode_transaksi(){
        $data = $this->M_stock->where_max()->row();
        //print_r($this->db->last_query());
        $json['maxs'] = @$data->maxs;
        echo json_encode($json);
	}

    public function ajax_get_kode_transfer(){
        $data = $this->M_stock->where_max_transfer()->row();
        //print_r($this->db->last_query());
        $json['maxs'] = @$data->maxs;
        echo json_encode($json);
	}

    public function simpanKoreksi(){

        $data_koreksi = array(
            'fc_notrans'           => $this->input->post('fc_notrans'), 
            'fd_date'              => date('Y-m-d'), 
            'fc_kdkaryawan'        => $this->input->post('fc_kdkaryawan'), //$this->input->post('tanggal_penjualan'), 
            'fc_sts'                => $this->input->post('fc_sts'), 
            'fc_kdarea'             => $this->input->post('fc_kdarea'), 
            'fc_kddivisi'               => $this->input->post('fc_kddivisi'), 
            'fc_periode'           => $this->input->post('fc_periode')
        );

        $id_koreksi = $this->M_stock->insert($data_koreksi);

        foreach ($this->input->post('fc_kdstock') as $key => $value){

            $data_detail_koreksi = array(
                'fc_notrans'    => $this->input->post('fc_notrans'),
                'fc_kdstock' =>  $_POST['fc_kdstock'][$key],     
                'fc_kdtipe'      => $_POST['fc_kdtipe'][$key], 
                'fc_kdbrand'     => $_POST['fc_kdbrand'][$key], 
                'fc_kdgroup'       => $_POST['fc_kdgroup'][$key], 
                'fc_kdsatuan'       => $_POST['fc_kdsatuan'][$key], 
                'fn_qty_sistem' => $_POST['fn_qty_sistem'][$key],
                'fn_qty_aktual' => $_POST['fn_qty_aktual'][$key], 
                'fn_qty_selisih' => $_POST['fn_qty_aktual'][$key] - $_POST['fn_qty_sistem'][$key], 
                'fv_ket'     => $_POST['fv_ket'][$key]
             );

             $id_penjualan_koreksi = $this->M_stock->insert_detail($data_detail_koreksi);
        } 

        $no_trans = $this->input->post('fc_notrans');
        $get_koreksi = $this->M_stock->get_koreksi_stock($no_trans);

        foreach ($get_koreksi as $value) {
            $divisi = $this->input->post('fc_kddivisi');
            $area = $this->input->post('fc_kdarea');
            $fc_kdstock = $value->fc_kdstock;
            $ket = 'Koreksi Stock'.$no_trans;
            $date = date('Y-m-d');
            $user = $this->input->post('fc_kdkaryawan');

            $fn_qty_awal= $value->fn_qty_sistem;
            $fn_qty_in = $value->fn_qty_aktual;
            $fn_qty_sisa = $value->fn_qty_aktual;

            $this->db->query("call kartu_approve_pembelian('".$area."','".$fc_kdstock."','".$date."','".$user."','".$fn_qty_awal."','".$fn_qty_in."','0','".$fn_qty_sisa."','".$ket."','".$divisi."')");

            $data = array(
                'fn_qty' => $value->fn_qty_aktual,
            );

            $this->M_stock->update_stock(array('fc_kdstock' =>  $fc_kdstock,'fc_kdarea' =>  $area,'fc_kddivisi' => $divisi), $data);
        }    

        $result['success'] = true;
        return die(json_encode($result));
    }

    public function ajax_get_by_id($id)
	{
		$koreksi = $this->M_stock->get_by_id2($id);

		$post = array(
			'fc_notrans' => $koreksi->fc_notrans,
			'tanggal' => $koreksi->tanggal,
            'fv_nama' => $koreksi->fv_nama,
            'fc_periode' => $koreksi->fc_periode,
		);
		

		$this->output
			->set_status_header(200)
			->set_content_type('application/json')
			->set_output(json_encode($post)); 
		
	}

    function ajax_get_data_detail_koreksi($id){
        $rs = $this->M_stock->getDataDetailKoreksi($id)->result();
        echo json_encode($rs);
    }

    function simpanTransfer(){
        $data_transfer = array(
            'fc_faktur_transfer'           => $this->input->post('fc_faktur_transfer'), 
            'fd_date'              => date('Y-m-d'), 
            'fc_kdkaryawan'        => $this->input->post('fc_kdkaryawan'),
            'fc_kdarea'             => $this->input->post('fc_kdarea'), 
            'fc_kddivisi'               => $this->input->post('fc_kddivisi'), 
            'fc_periode'           => $this->input->post('fc_periode')
        );

        $id_transfer = $this->M_stock->insert_transfer($data_transfer);

        foreach ($this->input->post('fc_kdstock') as $key => $value){

            $data_detail_transfer = array(
                'fc_faktur_transfer'    => $this->input->post('fc_faktur_transfer'),
                'fc_lokasi_area_permintaan' =>  $this->input->post('fc_kdarea'),     
                'fc_lokasi_divisi_permintaan'      => $this->input->post('fc_kddivisi'), 
                'fc_kdstock'     => $_POST['fc_kdstock'][$key], 
                'fc_kdtipe'      => $_POST['fc_kdtipe'][$key], 
                'fc_kdbrand'     => $_POST['fc_kdbrand'][$key], 
                'fc_kdgroup'       => $_POST['fc_kdgroup'][$key], 
                'fc_kdsatuan'       => $_POST['fc_kdsatuan'][$key], 
                'fc_lokasi_area_tujuan' => $_POST['fc_lokasi_area_tujuan'][$key],
                'fc_lokasi_divisi_tujuan' => $_POST['fc_lokasi_divisi_tujuan'][$key], 
                'fn_jumlah_tujuan' => $_POST['fn_jumlah_tujuan'][$key], 
                'fv_ket'     => $_POST['fv_ket'][$key]
            );

            $id_detail_transfer = $this->M_stock->insert_detail_transfer($data_detail_transfer);

            $this->db->where('fc_kdstock', $_POST['fc_kdstock'][$key]);
            $this->db->where('fc_kdarea', $this->input->post('fc_kdarea'));
            $this->db->where('fc_kddivisi',$this->input->post('fc_kddivisi'));
            $cek_stock_asal = $this->db->get('td_stock')->row();

            $this->db->where('fc_kdstock', $_POST['fc_kdstock'][$key]);
            $this->db->where('fc_kdarea', $_POST['fc_lokasi_area_tujuan'][$key]);
            $this->db->where('fc_kddivisi',$_POST['fc_lokasi_divisi_tujuan'][$key]);
            $cek_stock_tujuan = $this->db->get('td_stock')->row();

            $get_count_transfer = $this->M_stock->get_count_transfer($_POST['fc_kdstock'][$key], $_POST['fc_lokasi_area_tujuan'][$key], $_POST['fc_lokasi_divisi_tujuan'][$key]);

            if($get_count_transfer->jml_ada>0){
                $data_lokasi['fn_qty'] = @$cek_stock_tujuan->fn_qty+@$_POST['fn_jumlah_tujuan'][$key];

                $divisi = $this->input->post('fc_kddivisi');
                $area = $this->input->post('fc_kdarea');
                $fc_kdstock = $_POST['fc_kdstock'][$key];
                $ket = 'Transfer Stock'.$this->input->post('fc_faktur_transfer');
                $date = date('Y-m-d');
                $user = $this->input->post('fc_kdkaryawan');
    
                $fn_qty_awal= $cek_stock_tujuan->fn_qty;
                $fn_qty_in = $_POST['fn_jumlah_tujuan'][$key];
                $fn_qty_sisa = $data_lokasi['fn_qty'];

                $this->db->query("call kartu_approve_pembelian('".$area."','".$fc_kdstock."','".$date."','".$user."','".$fn_qty_awal."','".$fn_qty_in."','0','".$fn_qty_sisa."','".$ket."','".$divisi."')");
                
                $this->db->where('fc_kdstock', $_POST['fc_kdstock'][$key]);
				$this->db->where('fc_kdarea',$_POST['fc_lokasi_area_tujuan'][$key]);
                $this->db->where('fc_kddivisi',$_POST['fc_lokasi_divisi_tujuan'][$key]);
				$this->db->update('td_stock', $data_lokasi);

                $data_lokasie['fn_qty'] = $cek_stock_asal->fn_qty-$_POST['fn_jumlah_tujuan'][$key];
				
                $this->db->where('fc_kdstock', $_POST['fc_kdstock'][$key]);
				$this->db->where('fc_kdarea',$this->input->post('fc_kdarea'));
                $this->db->where('fc_kddivisi',$this->input->post('fc_kddivisi'));
				$this->db->update('td_stock', $data_lokasie);
            }else{
                $divisi = $this->input->post('fc_kddivisi');
                $area = $this->input->post('fc_kdarea');
                $fc_kdstock = $_POST['fc_kdstock'][$key];
                $ket = 'Transfer Stock'.$this->input->post('fc_faktur_transfer');
                $date = date('Y-m-d');
                $user = $this->input->post('fc_kdkaryawan');
    
                $fn_qty_awal= 0;
                $fn_qty_in = $_POST['fn_jumlah_tujuan'][$key];
                $fn_qty_sisa = $_POST['fn_jumlah_tujuan'][$key];
              //  $this->db->query("call kartu_stok_konversi('".$_POST['id_varian_harga2'][$key]."','".$_POST['id_lokasi2'][$key]."','".$_POST['id_barang2'][$key]."','".$cek_stock_tujuan->stok_gudang."','".$ket."','".$userid."','".$_POST['jumlah_tujuan'][$key]."','".$_POST['jumlah_tujuan'][$key]."')");
                $this->db->query("call kartu_approve_pembelian('".$area."','".$fc_kdstock."','".$date."','".$user."','".$fn_qty_awal."','".$fn_qty_in."','0','".$fn_qty_sisa."','".$ket."','".$divisi."')");
				$data_stok = array(
					'fc_kdstock' =>  $_POST['fc_kdstock'][$key],
					'fc_kdarea' =>  $_POST['fc_lokasi_area_tujuan'][$key],
					'fc_kddivisi' => $_POST['fc_lokasi_divisi_tujuan'][$key],
					'fn_qty' => @$_POST['fn_jumlah_tujuan'][$key]
				);
                $this->db->insert('td_stock', $data_stok);

                $data_lokasie['fn_qty'] = $cek_stock_asal->fn_qty-$_POST['fn_jumlah_tujuan'][$key];
				
                $this->db->where('fc_kdstock', $_POST['fc_kdstock'][$key]);
				$this->db->where('fc_kdarea',$this->input->post('fc_kdarea'));
                $this->db->where('fc_kddivisi',$this->input->post('fc_kddivisi'));
				$this->db->update('td_stock', $data_lokasie);
			}     
        }

        
        
        $result['success'] = true;
        return die(json_encode($result));
    }

    public function ajax_get_by_id_transfer($id)
	{
		$transfer = $this->M_stock->get_by_id_transfer($id);

		$post = array(
			'fc_faktur_transfer' => $transfer->fc_faktur_transfer,
			'tanggal' => $transfer->tanggal,
            'fv_nama' => $transfer->fv_nama,
            'fc_periode' => $transfer->fc_periode,
		);
		

		$this->output
			->set_status_header(200)
			->set_content_type('application/json')
			->set_output(json_encode($post)); 
		
	}

    function ajax_get_data_detail_transfer($id){
        $rs = $this->M_stock->getDataDetailTransfer($id)->result();
        echo json_encode($rs);
    }
	
}    
    