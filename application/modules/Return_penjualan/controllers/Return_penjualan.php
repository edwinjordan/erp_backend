<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Return_penjualan extends MY_Admin {

	public function __construct(){
        parent::__construct();
        $this->load->model('M_return_penjualan');
       // $this->load->library('session');
    }

    public function get_pembayaran_hutang_tampiloke3($id=null, $faktur=null){

       echo json_encode($this->M_return_penjualan->get_pembayaran_hutang_tampiloke3($id, $faktur)->result());
        // $this->M_return_penjualan->get_pembayaran_hutang_tampiloke3($id, $faktur)->result();
        // print_r($this->db->last_query());
      
    }

    public function ambilKeuangan(){
        return die(json_encode($this->M_return_penjualan->tampil_jenis_keuangan()->result_array()));
    }

    public function get_pembayaran_hutang_tampiloke2($id){
     
            $datakirim3 = $this->M_return_penjualan->get_nota_print_barang_penjualane3($id);
          //  print_r($this->db->last_query());
            foreach ($datakirim3 as $key => $value) {
                $l = $this->M_return_penjualan->get_nama_barang($value->fc_kdstock, $value->fn_idpenjualan)->result_array();
             //   print_r($this->db->last_query());
                foreach ($l as $k => $v) {
                    //if($value->kode_satuan == $v['kode_satuan'] && $value->harga_jual == $v['harga_jual']){
                        $value->barang[] = $v;
                        
                        $value->all_nama_barang = $value->fv_namastock;
                        foreach ($value->barang as $kk => $vv) {
                            $value->all_nama_barang .= " " . $vv['fn_qty'] . ",";
                        }
                   // }
                }
            }
            echo json_encode($datakirim3);
        
    }

    public function get_pembayaran_hutang_tampiloke33(){
        echo json_encode($this->M_return_penjualan->get_pembayaran_hutang_tampiloke33()->result());
        // $this->M_return_penjualan->get_pembayaran_hutang_tampiloke33()->result();
        // print_r($this->db->last_query());
    }

    public function simpan_return_penjualan(){
        $data['dariAplikasi'] = $this->input->post('dariAplikasi')? $this->input->post('dariAplikasi') : false;

        $data['fn_id'] = $this->input->post('id_detail_penjualane2');
        $data['fc_nofaktur'] = $this->input->post('fc_nofaktur');
        $data['fn_qty'] = $this->input->post('jumlah_barang');
        $data['kode_nama_keuangan'] = $this->input->post('kode_nama_keuangan');
        $data['fv_note'] = $this->input->post('keterangan_barang');
        $data['fc_kdcust'] = $this->input->post('fc_kdcust');
        //  $data['tunaikan'] = $this->input->post('tunaikan');
        $data['fc_kdstock'] = $this->input->post('fc_kdstock');
        $data['fd_tglinput'] = $this->input->post('date');
        $data['fc_kdkaryawan'] = $this->input->post('id_karyawanne');
        //$data['pilihan'] = $this->input->post('pilihan');
        $data['pengembalian'] = $this->input->post('pengembalian');
     

        $this->db->order_by('fc_noretur', 'DESC');
		$returnnya = $this->db->get('tm_returninv')->row();

		$tanggal = date('y');
		if(empty($returnnya->fc_noretur)){
			$data['no_faktur_return'] = 'RJ'.$tanggal.'-1';
			$datadetail['fc_noretur'] = 'RJ'.$tanggal.'-1';
		}else{
			$pecah = explode('-', $returnnya->fc_noretur);
			$pecahjadi = $pecah[1]+1;
			$data['no_faktur_return'] = 'RJ'.$tanggal.'-'.$pecahjadi;
			$datadetail['fc_noretur'] = 'RJ'.$tanggal.'-'.$pecahjadi;
        }
        
        $data['tgl_return'] = date('Y-m-d H:i:s');
		$data['keterangan_return'] = $data['fv_note'];
		$data['fc_kdkaryawan'] = $data['dariAplikasi']? $data['fc_kdkaryawan'] : ($data['dariAplikasi']? $data['fc_kdkaryawan'] : $this->session->userdata('fc_kdkaryawan'));


        $whereReturnExis = array();
        $whereReturnPenjualanExis = array();
        $whereReturnMaxExis = array();
        $whereStokGudang = array();

        $id_detail_penjualanne = $this->input->post('id_detail_penjualane');
        $input_detail_penjualan_det = $this->input->post('input_detail_penjualan_det');
        $fc_kdstock = $this->input->post('fc_kdstock');
        $fc_kdarea = $this->input->post('fc_kdarea');
        $fc_kddivisi = $this->input->post('fc_kddivisi');
        $qty_detail = $this->input->post('qty_detail');
        $qty_return = $this->input->post('qty_return');
        $input_max_return = $this->input->post('input_max_return');
        $fc_kdtipe = $this->input->post('fc_kdtipe');
        $fc_kdbrand = $this->input->post('fc_kdbrand');
        $fc_kdgroup = $this->input->post('fc_kdgroup');
        $fc_kdsatuan = $this->input->post('fc_kdsatuan');
        $harga_penjualan = $this->input->post('harga_penjualan');
        $qty_jml_return = $this->input->post('qty_jml_return');

        // $siyap_ok = $this->M_return_penjualan->get_penjualan($data['fc_nofaktur'])->row();
        // $hasil = $this->M_return_penjualan->get_detail_penjualan($id_detail_penjualanne)->row();
        
        $datane['fc_nofaktur'] = $data['fc_nofaktur'];
        $datane['fd_tglinput'] = date('Y-m-d H:i:s');
        $datane['fc_noretur'] = $data['no_faktur_return'];
        $datane['fc_sts'] = 'I';
        $datane['fv_note'] = $this->input->post('keterangan_barang');
        $datane['fc_kdcust'] = $data['fc_kdcust'];
        $datane['fm_total'] = $data['pengembalian'];
        // $datane['bayar_biaya_return'] = -($this->input->post('qty_detail')*$hasil->fm_price);
        $this->db->insert('tm_returninv', $datane);
        
        $lokasi = $this->M_return_penjualan->get_lokasi($fc_kdstock, $fc_kdarea, $fc_kddivisi)->result();

        foreach($lokasi as $l){
            $data_lokasi = array(
                'fn_qty'          => $l->fn_qty +  $data['fn_qty']
            );
          
            $this->M_return_penjualan->update_stok($data_lokasi,array('fn_detail_stok' => $l->fn_detail_stok));
        }

       // $datadetail['fc_noretur'] = $datadetail['no_faktur_return'];
       //$datadetail['no_faktur'] =  $data['no_faktur'];
        $datadetail['fc_kdstock'] = $fc_kdstock;
        $datadetail['fc_kdtipe'] = $fc_kdtipe;
        $datadetail['fc_kdbrand'] = $fc_kdbrand;
        $datadetail['fc_kdgroup'] = $fc_kdgroup;
        $datadetail['fc_kdsatuan'] = $fc_kdsatuan;
        $datadetail['fm_price'] = $harga_penjualan;
        $datadetail['fn_qtyretur'] = $qty_jml_return;
        $datadetail['fc_sts'] = 'I';
        $datadetail['fm_subtot'] = $harga_penjualan * $qty_jml_return;
        $datadetail['fc_kdarea'] = $fc_kdarea;
        $datadetail['fc_kddivisi'] = $fc_kddivisi;
        $datadetail['fv_ket'] = "Return Penjualan ".$data['fc_nofaktur'];
        $datadetail['fc_kdkaryawan'] = $data['fc_kdkaryawan'];
        $this->db->insert('td_returninv', $datadetail);

        $this->db->order_by('tgl_transaksi_master', 'DESC');
        $this->db->where('status_transaksi_master', '5');
        $siyap_bp = $this->db->get('transaksi_master')->row();

        $pakai_bp = '';
        $tanggal_bp = date('y');
        if(empty($siyap_bp->faktur_bp)){
            $pakai_bp = 'BRJ'.$tanggal_bp.'-1';
        }else{
            $pecah = explode('-', $siyap_bp->faktur_bp);
            $angka = $pecah[1]+1;
            $pakai_bp = 'BRJ'.$tanggal_bp.'-'.$angka;
        }

        $data_return_pakai_master_pembelian['tgl_transaksi_master'] = date('Y-m-d H:i:s');
        $data_return_pakai_master_pembelian['no_faktur'] = $data['no_faktur_return'];
        $data_return_pakai_master_pembelian['faktur_bp'] = $pakai_bp;
        $data_return_pakai_master_pembelian['status_transaksi_master'] = 5;
        $data_return_pakai_master_pembelian['kode_nama_keuangan'] =  $data['kode_nama_keuangan'];
        $data_return_pakai_master_pembelian['kode_pegawai'] = $data['kode_nama_keuangan']? $data['kode_nama_keuangan'] : ($data['dariAplikasi']? $data['fc_kdkaryawan'] : $this->session->userdata('fc_kdkaryawan'));
        $data_return_pakai_master_pembelian['kredit_transaksi_master'] = $datane['fm_total'];
        $this->db->insert('transaksi_master', $data_return_pakai_master_pembelian);
        
        // if($data['pilihan']=="saldo"){
        //     $this->db->where('kode_pelanggan',  $datane['id_pelanggan']);
        //     $hasil_pelanggan = $this->db->get('pelanggan')->row();
        //     $saldo_pelanggan = $hasil_pelanggan->saldo + $this->input->post('pengembalian');

        //     $data_saldo_pelanggan['saldo'] = $saldo_pelanggan;
        //     $this->db->where('kode_pelanggan',$datane['id_pelanggan']);
        //     $this->db->update('pelanggan', $data_saldo_pelanggan);
        // }

        $hasilnya2 = $this->M_return_penjualan->get_transaksi_keuangan($data['kode_nama_keuangan'])->result_array();
        $data_keuangan = array(
            'saldo_keuangan'   => $hasilnya2[0]['saldo_keuangan'] -  $this->input->post('pengembalian')
        );
           
        $this->M_return_penjualan->update_saldo_keuangan($data_keuangan,array('kode_nama_keuangan' => $data['kode_nama_keuangan']));
      
        if($data['dariAplikasi']){
            $result['success'] = true;
            die(json_encode($result));
        }else{
            redirect(base_url('Return_penjualan'));
        }
    }


}    