<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Bpb extends MY_Admin {

	public function __construct()
    {
        parent::__construct();
        $this->load->model('M_bpb');
    }

    function ajax_get_list_po(){
        $bindings = array();
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && empty($_POST))
        $request = json_decode(file_get_contents('php://input'), true);
        $data = $this->M_bpb->get_datatables();
        $output = array(
                        "draw" => isset ( $request['draw'] ) ?
                        intval( $request['draw'] ) :
                        0,
                        "recordsTotal" => $this->M_bpb->count_all(),
                        "recordsFiltered" => $this->M_bpb->count_filtered(),
                        "data" => $data,
                );
        echo json_encode($output);
    }

    public function ajax_get_kode_bpb(){
        $data = $this->M_bpb->where_max()->row();
        //print_r($this->db->last_query());
        $json['maxs'] = @$data->maxs;
        echo json_encode($json);
	}

	 public function ajax_get_by_id_po($id)
	{
		header("Access-Control-Allow-Origin: *");
		header("Access-Control-Allow-Headers: authorization, Content-Type");


		$blog = $this->M_bpb->get_by_id2($id);

		$post = array(
			'fc_nopo' => $blog->fc_nopo,
            'fv_nama' => $blog->fv_nama,
            'tanggal' => $blog->tanggal,
            'fv_nama_supplier' => $blog->fv_nama_supplier,
            'fn_totqty' => $blog->fn_totqty,
            'fv_alamat' => $blog->fv_alamat,
            'fm_total' => $blog->fm_total,
		);
		

		$this->output
			->set_status_header(200)
			->set_content_type('application/json')
			->set_output(json_encode($post)); 
		
    }

    function ajax_get_data_barang_po($id){
        $rs = $this->M_bpb->getBarangPO($id)->result();
        echo json_encode($rs);
    }

    public function simpanBpb(){
        $data_bpb = array(
            'fc_nobpb'           => $this->input->post('fc_nobpb'), 
            'fc_nopo'         => $this->input->post('fc_nopo'),
            'fd_tglbpbp'         => date('Y-m-d'),
            'fd_tglinput'              => date('Y-m-d'), 
            'fc_kdsupp'        => $this->input->post('fc_kdsupp'),
            'fd_tglinput'             => $this->input->post('fc_kdarea'), 
            'fc_userinput'               => $this->input->post('fc_userinput'), 
            'fn_qtytot'           => $this->input->post('fn_qtytot'),
            'fn_qtyretur'           => $this->input->post('fn_qtyretur'),
            'fm_dpp'           => $this->input->post('fm_dpp'),
            'fm_retur'           => $this->input->post('fm_retur'),
            'fm_total'           => $this->input->post('fm_total'),
            'fc_kdarea'             => $this->input->post('fc_kdarea'), 
            'fc_kddivisi'               => $this->input->post('fc_kddivisi')
        );

        $id_bpb = $this->M_bpb->insert_bpb($data_bpb);

        foreach ($this->input->post('fc_kdstock') as $key => $value){

            $data_detail_po = array(
                'fc_nobpb'    => $this->input->post('fc_nobpb'),
                'fc_kdstock'     => $_POST['fc_kdstock'][$key], 
                'fc_kdtipe'      => $_POST['fc_kdtipe'][$key], 
                'fc_kdbrand'     => $_POST['fc_kdbrand'][$key], 
                'fc_kdgroup'       => $_POST['fc_kdgroup'][$key], 
                'fc_kdsatuan'       => $_POST['fc_kdsatuan'][$key], 
                'fn_qtypo'            => $_POST['fn_qtypo'][$key],
                'fn_qtyretur_det' => $_POST['fn_qtyretur_det'][$key], 
                'fn_qtyterima'     => $_POST['fn_qtyterima'][$key],
                'fm_harsat'             => $_POST['fm_harsat'][$key], 
                'fm_subtot'             => $_POST['fm_subtot'][$key], 
                'fc_kdarea'             => $this->input->post('fc_kdarea'), 
                'fc_kddivisi'               => $this->input->post('fc_kddivisi')
            );

            $id_detail_bpb = $this->M_bpb->insert_detail_bpb($data_detail_po);
        }  

        $data2 = array(
            'fc_sts'          => '2'
        );
  
        $this->M_bpb->update_sts(array('fc_nopo' =>  $this->input->post('fc_nopo')), $data2); 

        $listBpb = $this->M_bpb->getTablePembelian($this->input->post('fc_nobpb'))->result();

        foreach ($listBpb as $value) {
            $query3 = $this->M_bpb->stok_gudang($value->fc_kdstock, $value->fc_kdarea, $value->fc_kddivisi);
            $query2 = $this->M_bpb->detail_gedung($value->fc_kdstock, $value->fc_kdarea, $value->fc_kddivisi);

            if($query3->jml_ada>0){
                foreach ($query2 as $value2) {
                    $stok_gudang = $value2->fn_qty + $value->fn_qtyterima;

                    $divisi = $this->input->post('fc_kddivisi');
                    $area = $this->input->post('fc_kdarea');
                    $fc_kdstock = $value->fc_kdstock;
                    $ket = 'BPB Stock'.$this->input->post('fc_nobpb');
                    $date = date('Y-m-d');
                    $user = $this->input->post('fc_userinput');

                    $fn_qty_awal= $value2->fn_qty;
                    $fn_qty_in = $value->fn_qtyterima;
                    $fn_qty_sisa = $stok_gudang;

                    $this->db->query("call kartu_approve_pembelian('".$area."','".$fc_kdstock."','".$date."','".$user."','".$fn_qty_awal."','".$fn_qty_in."','0','".$fn_qty_sisa."','".$ket."','".$divisi."')");

                    $data_qty = array(
                        'fn_qty' => $stok_gudang
                    );

                    $update_qty = $this->M_bpb->update_table('td_stock',$data_qty, array('fc_kdstock' => $value->fc_kdstock , 'fc_kdarea' => $value->fc_kdarea, 'fc_kddivisi' => $value->fc_kddivisi));


                }    
            }else{
                $data = array(
                    'fc_kdstock' => $value->fc_kdstock,
                    'fc_kdarea'   =>  $value->fc_kdarea,
                    'fc_kddivisi'   => $value->fc_kddivisi,
                    'fn_qty'   => $value->fn_qtyterima
                );  
                                
                $insert_data = $this->M_bpb->insert_table('td_stock',$data);

                $divisi = $this->input->post('fc_kddivisi');
                $area = $this->input->post('fc_kdarea');
                $fc_kdstock = $value->fc_kdstock;
                $ket = 'BPB Stock'.$this->input->post('fc_nobpb');
                $date = date('Y-m-d');
                $user = $this->input->post('fc_userinput');

                $fn_qty_awal= 0;
                $fn_qty_in = $value->fn_qtyterima;
                $fn_qty_sisa = $value->fn_qtyterima;

                $this->db->query("call kartu_approve_pembelian('".$area."','".$fc_kdstock."','".$date."','".$user."','".$fn_qty_awal."','".$fn_qty_in."','0','".$fn_qty_sisa."','".$ket."','".$divisi."')");
            }    
        }    

        $result['success'] = true;
        return die(json_encode($result)); 
    }    

 }   