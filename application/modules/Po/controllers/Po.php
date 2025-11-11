<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Po extends MY_Admin {

	public function __construct()
    {
        parent::__construct();
        $this->load->model('M_po');
    } 

    function ajax_get_list_po(){
        $bindings = array();
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && empty($_POST))
        $request = json_decode(file_get_contents('php://input'), true);
        $data = $this->M_po->get_datatables();
    	$output = array(
                        "draw" => isset ( $request['draw'] ) ?
                        intval( $request['draw'] ) :
                        0,
                        "recordsTotal" => $this->M_po->count_all(),
                        "recordsFiltered" => $this->M_po->count_filtered(),
                        "data" => $data,
				);
        echo json_encode($output);
    }

    public function ajax_get_kode_po(){
        $data = $this->M_po->where_max()->row();
        //print_r($this->db->last_query());
        $json['maxs'] = @$data->maxs;
        echo json_encode($json);
	}

	public function ajax_get_data_supplier(){
		$rs = $this->M_po->getSupplier()->result();
        echo json_encode($rs);
	}

	public function simpanPo(){
		$data_po = array(
            'fc_nopo'           => $this->input->post('fc_nopo'), 
            'fc_kdsupp'         => $this->input->post('fc_kdsupp'),
            'fc_userid'         => $this->input->post('fc_userid'),
            'fd_tglinput'              => date('Y-m-d'), 
            'fd_tglpokirim'        => $this->input->post('fd_tglpokirim'),
            'fc_kdarea'             => $this->input->post('fc_kdarea'), 
            'fc_kddivisi'               => $this->input->post('fc_kddivisi'), 
            'fc_sts'           => $this->input->post('fc_sts'),
            'fn_totqty'           => $this->input->post('fn_totqty'),
            'fm_subtot'           => $this->input->post('fm_subtot'),
            'fm_total'           => $this->input->post('fm_total'),
            'fm_ppn'           => $this->input->post('fm_ppn'),
        );

        $id_po = $this->M_po->insert_po($data_po);

        foreach ($this->input->post('fc_kdstock') as $key => $value){

            $data_detail_po = array(
                'fc_nopo'    => $this->input->post('fc_nopo'),
                'fc_kdstock'     => $_POST['fc_kdstock'][$key], 
                'fc_kdtipe'      => $_POST['fc_kdtipe'][$key], 
                'fc_kdbrand'     => $_POST['fc_kdbrand'][$key], 
                'fc_kdgroup'       => $_POST['fc_kdgroup'][$key], 
                'fc_kdsatuan'       => $_POST['fc_kdsatuan'][$key], 
                'fn_qty' 			=> $_POST['qty'][$key],
                'fm_price' => $_POST['price'][$key], 
                'fm_subtot_det'     => $_POST['subtotal'][$key],
                'fc_kdarea'             => $this->input->post('fc_kdarea'), 
            	'fc_kddivisi'               => $this->input->post('fc_kddivisi')
            );

            $id_detail_po = $this->M_po->insert_detail_po($data_detail_po);
        }   

        $result['success'] = true;
        return die(json_encode($result)); 
	}

}	