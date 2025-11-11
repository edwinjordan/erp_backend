<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class M_piutang_penjualan extends CI_Model {

	public function get_penjualan_crud(){
		// $this->db->where('selisih LIKE', '%-%');
		// $this->db->order_by('id_penjualan','desc');
		// return $this->db->get('penjualan');

		$this->db->select('a.*, b.fv_nama, b.fv_alamat, b.fc_notelp, DATE_FORMAT(a.fd_tglinput, "%d-%m-%Y") as tanggal');
		$this->db->from('tm_invoice a');
		$this->db->join('t_customer b', 'a.fc_kdcust = b.fc_kdcust', 'left outer');
		$this->db->where('fm_selisih LIKE', '%-%');
		//$this->db->where('a.status',1);
		$this->db->order_by('fn_idpenjualan','desc');
		return $this->db->get();
	}

	public function get_siyap_bp(){
        $this->db->order_by('tgl_transaksi_master', 'DESC');
		$this->db->where('status_transaksi_master', '3');
        $this->db->or_where('status_transaksi_master', '8');
        return $this->db->get('transaksi_master')->row();
    }

    public function get_cek_pembelianok($no_nota){
        $this->db->where('fc_nofaktur', $no_nota);
        return $this->db->get('tm_invoice')->row();
    }

    public function get_hasilnya($no_nota){
		$this->db->where('tm_invoice.fc_nofaktur',$no_nota);
		$this->db->from('tm_invoice');
		return $this->db->get()->row_array();
	}

	function max($no_nota, $kode_pelanggan){
		return $this->db->query('SELECT max(fn_angsuran_hitungan) AS maxs FROM t_angsuran WHERE fc_kdcust="'.$kode_pelanggan.'" AND fc_nofaktur="'.$no_nota.'"');
	}
}	