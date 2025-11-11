<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Piutang_penjualan extends MY_Admin {

	public function __construct(){
        parent::__construct();
        $this->load->model('M_piutang_penjualan');
       // $this->load->library('session');
    }

    public function get_penjualan_crud(){
        $data = $this->M_piutang_penjualan->get_penjualan_crud()->result();
        echo json_encode($data);
    }

    public function bayar_piutang_penjualan(){
    	$bayar_a = 0;
		$bayar_b = 0;
		$identik_a = 0;
        $identik_b = 0;
        $dariandroid = $this->input->post('dariAplikasi');
		if(empty($this->input->post('cash'))){
			$bayar_a = 0;
			$identik_a = 0;
		}else{
			$bayar_a = $this->input->post('cash');
			$identik_a = $this->input->post('cash');
        }

        $pembayaran = $bayar_a;
		//echo "aaa".$pembayaran;
		$nomer_pakai =1;
		$pindahan = 1;
		$pakai_pindahan = 0;


        $siyap_bp = $this->M_piutang_penjualan->get_siyap_bp();
        $no_nota = $this->input->post('no_nota');

        $pakai_bp = '';
		$tanggal_bp = date('y');
		if(empty($siyap_bp->faktur_bp)){
			$pakai_bp = 'BUJ'.$tanggal_bp.'-1';
		}else{
			$pecah = explode('-', $siyap_bp->faktur_bp);
			$angka = $pecah[1]+1;
			$pakai_bp = 'BUJ'.$tanggal_bp.'-'.$angka;
        }

        // $cek_pembelianok = $this->M_piutang_penjualan->get_cek_pembelianok($no_nota);

        // $antem = $cek_pembelianok->fm_selisih;

        $this->db->where('fc_nofaktur', $this->input->post('no_nota'));
        $cek_faktur = $this->db->get('tm_invoice')->row();

        $data_bayar = $cek_faktur->fm_selisih + $pembayaran;

        $hasilnya=$this->M_piutang_penjualan->get_hasilnya($this->input->post('no_nota'));

        $data['no_faktur'] = $hasilnya['fc_nofaktur'];
		$data['tgl_transaksi_master'] = date('Y-m-d H:i:s');
		$data['kredit_transaksi_master'] = '0';
		$data['status_transaksi_master'] = '3';
		$data['keterangan_transaksi_master'] = $this->input->post('keterangan_tagihan');
		$data['kode_nama_keuangan'] = $this->input->post('nama_keuangan');
        $data['kode_pegawai'] = $this->input->post('operator');
        $data['fc_kdarea'] = $this->input->post('area');
        $data['fc_kddivisi'] = $this->input->post('divisi');
                
        
        $data['kebijakan_transaksi_master'] = '0';

        $pembayaran = $hasilnya['fm_selisih']+$pembayaran;

        $pem = -($hasilnya['fm_selisih']);
		$bayar_a = $bayar_a - $pem;

		$pakai = 0;
		if($bayar_a>=0){
			$pakai = $pem;
			if($bayar_a==0){
				$nomer_pakai = 2;
			}
		}else{
			$pakai = $pem + $bayar_a;
			$pakai_pindahan = -($bayar_a);
			$nomer_pakai = 2;
		}
		$data['debit_transaksi_master'] = $pakai;
		$data['faktur_bp'] = $pakai_bp;
		
        $this->db->insert('transaksi_master', $data);

        $data_pembelian['fm_selisih'] = $hasilnya['fm_selisih']+$this->input->post('cash');
		$data_pembelian['fm_dpp'] = $hasilnya['fm_dpp']+$this->input->post('cash');
		//$data_pembelian['tgl_pembayaran'] = date('Y-m-d');
		$this->db->where('fc_nofaktur', $hasilnya['fc_nofaktur']);
        $this->db->update('tm_invoice', $data_pembelian);

        $this->db->where('kode_nama_keuangan',$this->input->post('nama_keuangan'));
		$this->db->from('transaksi_nama_keuangan');
								//teko kenen
		$hasilnya2=$this->db->get()->result_array();

		$saldo_uang = $hasilnya2[0]['saldo_keuangan'] + $data_pembelian['fm_selisih'];

		$data_saldo['saldo_keuangan'] = $saldo_uang;
		$this->db->where('kode_nama_keuangan',$this->input->post('nama_keuangan'));
        $this->db->update('transaksi_nama_keuangan', $data_saldo);

        $urutan = $this->M_piutang_penjualan->max($this->input->post('no_nota'), $this->input->post('kode_pelanggan'))->row();

        $kode = $urutan->maxs;
            //tampil data
        $urut = (int) substr($kode, 1);

        $urut++;

        $kode = sprintf("%01s", $urut);

        $data_angsur['fc_kdcust'] = $this->input->post('kode_pelanggan');
        $data_angsur['fd_date'] = date('Y-m-d');
        $data_angsur['fm_angsuran'] = $this->input->post('cash');
        $data_angsur['fn_angsuran_hitungan'] = $kode;
        $data_angsur['fc_nofaktur'] = $this->input->post('no_nota');

        $this->db->insert('t_angsuran', $data_angsur);
        
        $result['success'] = true;
		return die(json_encode($result));
    }	

}    