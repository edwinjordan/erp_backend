<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Penjualan extends MY_Admin {

    public function __construct()
    {
        parent::__construct(); 
        $this->load->library('session');
        $this->load->model('M_penjualan');
    }

    public function getKaryawan()
    {
        $rs = $this->M_penjualan->getKaryawan_api()->result();
        echo json_encode($rs);
    }

    public function getPelanggan()
    {
        $rs = $this->M_penjualan->getPelanggan_api()->result();
        echo json_encode($rs);
    }

    public function getDataBarang(){
       $this->M_penjualan->ambilBarang();
    }

    public function getDiskone()
    {
        $rs = $this->M_penjualan->getDiskone()->result();
        echo json_encode($rs);
    }

    public function getDiskonPeriode(){
        $rs = $this->M_penjualan->getDiskonPeriode()->result();
        echo json_encode($rs);
    }

    public function max_umum(){
        $data = $this->M_penjualan->where_max_umum()->row();
        $json['maxs'] = @$data->maxs;
        echo json_encode($json);
    }

    public function max_pel($kode_pelanggan){
        $data = $this->M_penjualan->where_max_pel($kode_pelanggan)->row();
        $json['maxs'] = @$data->maxs;
        echo json_encode($json);
    }

    public function ambilKodePelanggan(){
       
        $kat = $this->M_penjualan->where_max_pelanggan()->row();
        $urut = $kat->maxs;
        $urut++;
        $kode = sprintf("%08s", $urut);
        // $data = $this->M_penjualan->where_max_pelanggan()->row();
        // $kode = @$data->maxs;
    
        $data['top'] = $this->M_penjualan->get_top();
        $data['profesi'] = $this->M_penjualan->get_profesi();
        $data['kode'] = $kode;
        return die(json_encode($data));
    }

    public function add_data_pelanggan(){
        $fc_kdcust = $this->input->post('fc_kdcust');
		$fv_nama = $this->input->post('fv_nama');
		$fv_alamat = $this->input->post('fv_alamat');		
		$fv_email = $this->input->post('fv_email');
		$fc_notelp = $this->input->post('fc_notelp');
        $fv_noktp = $this->input->post('fv_noktp');
        $fc_hold = $this->input->post('fc_hold');
        $fc_kota = $this->input->post('fc_kota');
        $fc_kdtop = $this->input->post('fc_kdtop');
        $fc_kdprofesi = $this->input->post('fc_kdprofesi');
        $fc_statusangsur = $this->input->post('fc_statusangsur');
        
        $DataCustomer = array(
                'fc_kdcust' => $fc_kdcust,
                'fv_nama' => $fv_nama,
                'fv_alamat' => $fv_alamat,
                'fv_email' => $fv_email,
                'fc_notelp' => $fc_notelp,
                'fv_noktp' => $fv_noktp,
                'fc_hold' => $fc_hold,
                'fc_kota' => $fc_kota,
                'fc_kdtop' => $fc_kdtop,
                'fc_kdprofesi' => $fc_kdprofesi,
                'fc_statusangsur' => $fc_statusangsur,
        );
        $id = $this->M_penjualan->insertCustomer($DataCustomer);
  
           
		$result['success'] = true;
		return die(json_encode($result));
    }

    public function keuangane(){
        echo json_encode($this->M_penjualan->keuangane()->result_array());
    }

    public function keuangane2(){
        echo json_encode($this->M_penjualan->keuangane2()->result_array());
    }  

    public function simpanTransaksi()
    {   
        $dariandroid = $this->input->post('dariAplikasi');

        $fc_kdkaryawan = $this->input->post('fc_kdkaryawan');
        $fc_kdcust = $this->input->post('fc_kdcust');

        $fd_tglinput =  $this->input->post('fd_tglinput');

        if($fc_kdcust == 0){
            $pelanggan = "UMUM";
        }else{
            $pelanggan = $fc_kdcust;
        }

        if($this->input->post('metode_pembayaran')=='cash'){
            $bayar = $this->input->post('cash');
            $selisih = $this->input->post('selisih_cash');
        }else if($this->input->post('metode_pembayaran')=='debit'){
            $bayar = $this->input->post('cash_debit');
            $selisih = $this->input->post('selisih_debit');
        }    

        if($fc_kdcust !="0"){
            $tgl_tempo = $this->M_penjualan->get_jatuh_tempo($fc_kdcust);  
            $date = date('Y-m-d');
            if($selisih <=0){
                $tempo = date('Y-m-d', strtotime('+'.@$tgl_tempo->fn_jumlah.' days', strtotime($date)));

            }else{
                $tempo = date('Y-m-d');
            }
        }else{
            $tempo = date('Y-m-d');
        }

        $data_penjualan = array(
            'fc_nofaktur'           => $this->input->post('fc_nofaktur'), 
            'fc_kdcust'             => $pelanggan, 
            'fd_tglinput'           => $fd_tglinput, //$this->input->post('tanggal_penjualan'), 
            'fc_kdkaryawan'         => $fc_kdkaryawan, 
            'fc_contacperson'       => $this->input->post('fc_contacperson'), 
            'fv_alamatkirim'               => $this->input->post('fv_alamatkirim'), 
            'fc_sts'           => 'I',   
            'fm_dpp'           => $bayar,   
            'fm_total'               => $this->input->post('fm_total'),
            'fm_selisih'       => $selisih, 
            'fv_memo'         => $this->input->post('catatan'),
            'fd_tgljatuh_tempo' => $tempo
        );

        $id_penjualan = $this->M_penjualan->insert($data_penjualan);

        foreach ($this->input->post('fc_kdstock') as $key => $value){
            //$check_harga_beli_tinggi = $this->M_penjualan->check_harga_beli_tinggi($telp_idne[$ii]);
           // $total = $_POST['jumlah_beli'][$key] * $_POST['harga_jual'][$key];
            $data_detail_penjualan = array(
                            'fc_nofaktur'    => $this->input->post('fc_nofaktur'),
                            'fn_idpenjualan' => $id_penjualan,  
                            'fc_kdstock'      => $_POST['fc_kdstock'][$key], 
                            'fc_barcode'             => $_POST['fc_barcode'][$key], 
                            'fc_kdtipe'       => $_POST['fc_kdtipe'][$key], 
                            'fc_kdbrand'       => $_POST['fc_kdbrand'][$key], 
                            'fc_kdgroup' => $_POST['fc_kdgroup'][$key],
                            'fc_kdsatuan' => $_POST['fc_kdsatuan'][$key], 
                            'fc_sts' => 'I', 
                            'fn_qty'     => $_POST['fn_qty'][$key], 
                            'fm_price'        => $_POST['fm_price'][$key],
                            'fm_disc'    => $_POST['ff_disc_rupiah'][$key],
                            'fm_subtot' => $_POST['fm_subtot'][$key],
                            'fc_kdarea' => $this->input->post('fc_kdarea'),
                            'fc_kddivisi' => $this->input->post('fc_kddivisi'),
                            'fv_ket'        => 'Penjualan '.$this->input->post('fc_nofaktur'),
                            'fc_kdkaryawan'        => $fc_kdkaryawan
             );

             $id_penjualan_detail = $this->M_penjualan->insert_detail($data_detail_penjualan);

            //  $this->db->query("call kartu_approve_pembelian('".$this->input->post('fc_kdarea')."','".$_POST['fc_kdstock'][$key]."','".$fd_tglinput."','".$fc_kdkaryawan."','".$value2->stok_gudang."','".$value->qty."','0','".$stok_gudang."','".$ket."')"); 
        } 

        $this->db->order_by('tgl_transaksi_master', 'DESC');
        $this->db->where('status_transaksi_master', '3');
        $this->db->or_where('status_transaksi_master', '8');
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

        if ($this->input->post('metode_pembayaran')=='cash') { 
            if($selisih>=0){
                $data_return_pakai_master_pembelian['tgl_transaksi_master'] = date('Y-m-d H:i:s');
                $data_return_pakai_master_pembelian['no_faktur'] = $this->input->post('fc_nofaktur');
                $data_return_pakai_master_pembelian['faktur_bp'] = $pakai_bp;
                $data_return_pakai_master_pembelian['status_transaksi_master'] = 3;
                $data_return_pakai_master_pembelian['kode_nama_keuangan'] = $this->input->post('nama_keuangan');
                $data_return_pakai_master_pembelian['kode_pegawai'] = $fc_kdkaryawan;
                $data_return_pakai_master_pembelian['debit_transaksi_master'] = $this->input->post('cash');
                $data_return_pakai_master_pembelian['keterangan_transaksi_master'] = 'pembayaran dengan cash';
                $this->db->insert('transaksi_master', $data_return_pakai_master_pembelian);

                $this->db->where('kode_nama_keuangan',$data_return_pakai_master_pembelian['kode_nama_keuangan']);
                $this->db->from('transaksi_nama_keuangan');
                            //teko kenen
                $hasilnya2=$this->db->get()->result_array();

                $saldo_uang = @$hasilnya2[0]['saldo_keuangan'] + @$data_return_pakai_master_pembelian['debit_transaksi_master'];

                $data_saldo['saldo_keuangan'] = $saldo_uang;
                $this->db->where('kode_nama_keuangan',$data_return_pakai_master_pembelian['kode_nama_keuangan']);
                $this->db->update('transaksi_nama_keuangan', $data_saldo);
            }    
        }else if($this->input->post('metode_pembayaran')=='debit'){
            if($selisih>=0){
                $data_return_pakai_master_pembelian['tgl_transaksi_master'] = date('Y-m-d H:i:s');
                $data_return_pakai_master_pembelian['no_faktur'] = $this->input->post('fc_nofaktur');
                $data_return_pakai_master_pembelian['faktur_bp'] = $pakai_bp;
                $data_return_pakai_master_pembelian['status_transaksi_master'] = 3;
                $data_return_pakai_master_pembelian['kode_nama_keuangan'] = $this->input->post('nama_keuangan2');
                $data_return_pakai_master_pembelian['kode_pegawai'] = $fc_kdkaryawan;
                $data_return_pakai_master_pembelian['debit_transaksi_master'] = $this->input->post('cash_debit');
                $data_return_pakai_master_pembelian['keterangan_transaksi_master'] = 'pembayaran dengan debit';
                $this->db->insert('transaksi_master', $data_return_pakai_master_pembelian);

                $this->db->where('kode_nama_keuangan',$data_return_pakai_master_pembelian['kode_nama_keuangan']);
                $this->db->from('transaksi_nama_keuangan');
                            //teko kenen
                $hasilnya2=$this->db->get()->result_array();

                $saldo_uang = $hasilnya2[0]['saldo_keuangan'] + $data_return_pakai_master_pembelian['debit_transaksi_master'];

                $data_saldo['saldo_keuangan'] = $saldo_uang;
                $this->db->where('kode_nama_keuangan',$data_return_pakai_master_pembelian['kode_nama_keuangan']);
                $this->db->update('transaksi_nama_keuangan', $data_saldo);
            }
        }    

        if($dariandroid){
            $hasil['success'] = 1;

            $data['master_penjualan']=$this->M_penjualan->get_nota_print(array('fc_nofaktur'=>$this->input->post('fc_nofaktur')));
            $data['count_barang'] = $this->M_penjualan->get_nota_count_barang_penjualan(array('td_invoice.fc_nofaktur'=>$this->input->post('fc_nofaktur')));
            $data['det_barang']=$this->M_penjualan->get_nota_print_barang_penjualan_kecil($this->input->post('fc_nofaktur'));

            $data['nama_toko'] = $this->M_penjualan->get_nama_toko()->row();
            $data['alamat_toko'] = $this->M_penjualan->get_alamat_toko()->row();
            $data['telp_toko'] = $this->M_penjualan->get_telp_toko()->row();                

            $this->db->where('fc_nofaktur', $this->input->post('fc_nofaktur'));
            $this->db->set('fn_print', 'fn_print+1', FALSE);
            $this->db->update('tm_invoice');

            $hasil['nota'] = $this->load->view('Penjualan/view_notakecil', $data, TRUE);

            die(json_encode($hasil));
        }       
    }   

    function nota_kecil($id){
        $data['master_penjualan']=$this->M_penjualan->get_nota_print(array('fc_nofaktur'=> $id));
        $data['count_barang'] = $this->M_penjualan->get_nota_count_barang_penjualan(array('td_invoice.fc_nofaktur'=> $id));
        $data['det_barang']=$this->M_penjualan->get_nota_print_barang_penjualan_kecil($id);

        $data['nama_toko'] = $this->M_penjualan->get_nama_toko()->row();
        $data['alamat_toko'] = $this->M_penjualan->get_alamat_toko()->row();
        $data['telp_toko'] = $this->M_penjualan->get_telp_toko()->row();                

        $this->db->where('fc_nofaktur', $id);
        $this->db->set('fn_print', 'fn_print+1', FALSE);
        $this->db->update('tm_invoice');
        $this->load->view('Penjualan/view_notakecil', $data);
    }

    function nota_kecil_new($id){
        $data['master_penjualan']=$this->M_penjualan->get_nota_print(array('fn_idpenjualan'=> $id));
        $data['count_barang'] = $this->M_penjualan->get_nota_count_barang_penjualan(array('td_invoice.fn_idpenjualan'=> $id));
        $data['det_barang']=$this->M_penjualan->get_nota_print_barang_penjualan_kecil_new($id);

        $data['nama_toko'] = $this->M_penjualan->get_nama_toko()->row();
        $data['alamat_toko'] = $this->M_penjualan->get_alamat_toko()->row();
        $data['telp_toko'] = $this->M_penjualan->get_telp_toko()->row();                

        $this->db->where('fn_idpenjualan', $id);
        $this->db->set('fn_print', 'fn_print+1', FALSE);
        $this->db->update('tm_invoice');
        $this->load->view('Penjualan/view_notakecil', $data);
    }

    public function Barcode($code)
    {
      $this->load->library('Zend');
      $this->zend->load('Zend/Barcode');
      Zend_Barcode::render('code128', 'image', array(
        'text'=>$code,
        'fontSize'=> 0,
        'barThickWidth' => 5,
        'barHeight' => 35,
        'drawText' => false
      ), array());
    }


}    