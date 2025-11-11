<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Billing extends MY_Admin {

	public function __construct()
    {
        parent::__construct();
        $this->load->model('M_billing');
    } 

    function ajax_get_list_billing(){
        $bindings = array();
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && empty($_POST))
        $request = json_decode(file_get_contents('php://input'), true);
        $data = $this->M_billing->get_datatables();
    	$output = array(
                        "draw" => isset ( $request['draw'] ) ?
                        intval( $request['draw'] ) :
                        0,
                        "recordsTotal" => $this->M_billing->count_all(),
                        "recordsFiltered" => $this->M_billing->count_filtered(),
                        "data" => $data,
				);
        echo json_encode($output);
    }

    public function ajax_get_data_bank(){
		$rs = $this->M_billing->getBank()->result_array();
        echo json_encode($rs);
	}

	public function ajax_get_kode_billing(){
        $data = $this->M_billing->where_max()->row();
        //print_r($this->db->last_query());
        $json['maxs'] = @$data->maxs;
        echo json_encode($json);
	}

	 public function ajax_get_by_id_bpb($id)
	{
		header("Access-Control-Allow-Origin: *");
		header("Access-Control-Allow-Headers: authorization, Content-Type");


		$blog = $this->M_billing->get_by_id2($id);

		$post = array(
			'fc_nobpb' => $blog->fc_nobpb,
            'fv_nama' => $blog->fv_nama,
            'tanggal' => $blog->tanggal,
            'fd_tglbpbp' => $blog->fd_tglbpbp,
            'fc_kdsupp' => $blog->fc_kdsupp,
            'fm_dpp' => $blog->fm_dpp
		);
		

		$this->output
			->set_status_header(200)
			->set_content_type('application/json')
			->set_output(json_encode($post)); 
		
    }

    public function simpanBilling(){
    	$data_billing = array(
            'fc_nopay'           => $this->input->post('fc_nopay'), 
            'fd_paydate'         => date('Y-m-d'),
            'fc_kdsupp'          => $this->input->post('fc_kdsupp'),
            'fc_userid'           => $this->input->post('fc_userid'), 
            'fc_status'        => '1',
            'fd_tglinput'             => date('Y-m-d H:i:s'), 
            'fc_nobpb'               => $this->input->post('fc_nobpb')
        );

        $id_billing = $this->M_billing->insert_billing($data_billing);

        $data_detail_billing = array(
            'fc_nopay'           => $this->input->post('fc_nopay'), 
            'fc_kdrek'          => $this->input->post('fc_kdrek'),
            'fd_bpbdate'           => $this->input->post('fd_tglbpbp'),
            'fm_totalinv'               => $this->input->post('fm_totalinv'),
            'fm_value'               => $this->input->post('fm_value'),
            'fm_sisa'               => $this->input->post('fm_totalinv') + $this->input->post('fm_value'),
            'fc_status'               => '1',
            'fc_userid'           => $this->input->post('fc_userid'),
        );

        $id_detail_billing = $this->M_billing->insert_detail_billing($data_detail_billing);

        $get_total_bpb = $this->M_billing->get_total_bpb($this->input->post('fc_nobpb'));

        $data2 = array(
            'fm_dpp'          => $get_total_bpb->fm_dpp +  $this->input->post('fm_value')
        );
  
        $this->M_billing->update_value(array('fc_nobpb' =>  $this->input->post('fc_nobpb')), $data2);

        $this->db->order_by('tgl_transaksi_master', 'DESC');
        $this->db->where('status_transaksi_master', '1');
        $siyap_bp = $this->db->get('transaksi_master')->row();

        $pakai_bp = '';
        $tanggal_bp = date('y');
        if(empty($siyap_bp->faktur_bp)){
            $pakai_bp = 'BJ'.$tanggal_bp.'-1';
        }else{
            $pecah = explode('-', $siyap_bp->faktur_bp);
            $angka = $pecah[1]+1;
            $pakai_bp = 'BJ'.$tanggal_bp.'-'.$angka;
        }

        if ($this->input->post('cara_bayar')=='C') { 

        	 	$data_return_pakai_master_pembelian['tgl_transaksi_master'] = date('Y-m-d H:i:s');
                $data_return_pakai_master_pembelian['no_faktur'] = $this->input->post('fc_nopay');
                $data_return_pakai_master_pembelian['faktur_bp'] = $pakai_bp;
                $data_return_pakai_master_pembelian['status_transaksi_master'] = 1;
                $data_return_pakai_master_pembelian['kode_nama_keuangan'] = $this->input->post('kode_nama_keuangan');
                $data_return_pakai_master_pembelian['kode_pegawai'] = $this->input->post('fc_userid');
                $data_return_pakai_master_pembelian['kredit_transaksi_master'] = $this->input->post('fm_value');
                $data_return_pakai_master_pembelian['keterangan_transaksi_master'] = 'pembayaran dengan cash';
                $this->db->insert('transaksi_master', $data_return_pakai_master_pembelian);

                $this->db->where('kode_nama_keuangan',$data_return_pakai_master_pembelian['kode_nama_keuangan']);
                $this->db->from('transaksi_nama_keuangan');
                            //teko kenen
                $hasilnya2=$this->db->get()->result_array();

                $saldo_uang = @$hasilnya2[0]['saldo_keuangan'] - @$data_return_pakai_master_pembelian['kredit_transaksi_master'];

                $data_saldo['saldo_keuangan'] = $saldo_uang;
                $this->db->where('kode_nama_keuangan',$data_return_pakai_master_pembelian['kode_nama_keuangan']);
                $this->db->update('transaksi_nama_keuangan', $data_saldo);
        }else if($this->input->post('metode_pembayaran')=='D'){
        		$data_return_pakai_master_pembelian['tgl_transaksi_master'] = date('Y-m-d H:i:s');
                $data_return_pakai_master_pembelian['no_faktur'] = $this->input->post('fc_nopay');
                $data_return_pakai_master_pembelian['faktur_bp'] = $pakai_bp;
                $data_return_pakai_master_pembelian['status_transaksi_master'] = 1;
                $data_return_pakai_master_pembelian['kode_nama_keuangan'] = $this->input->post('kode_nama_keuangan');
                $data_return_pakai_master_pembelian['kode_pegawai'] = $fc_kdkaryawan;
                $data_return_pakai_master_pembelian['kredit_transaksi_master'] = $this->input->post('fm_value');
                $data_return_pakai_master_pembelian['keterangan_transaksi_master'] = 'pembayaran dengan debit';
                $this->db->insert('transaksi_master', $data_return_pakai_master_pembelian);

                $this->db->where('kode_nama_keuangan',$data_return_pakai_master_pembelian['kode_nama_keuangan']);
                $this->db->from('transaksi_nama_keuangan');
                            //teko kenen
                $hasilnya2=$this->db->get()->result_array();

                $saldo_uang = $hasilnya2[0]['saldo_keuangan'] - $data_return_pakai_master_pembelian['kredit_transaksi_master'];

                $data_saldo['saldo_keuangan'] = $saldo_uang;
                $this->db->where('kode_nama_keuangan',$data_return_pakai_master_pembelian['kode_nama_keuangan']);
                $this->db->update('transaksi_nama_keuangan', $data_saldo);
        }

        $result['success'] = true;
        return die(json_encode($result));  
    }

}    