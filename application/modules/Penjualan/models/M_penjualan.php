<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_penjualan extends CI_Model {

    public function getKaryawan_api(){
		return $this->db->get('tm_karyawan');
	}

	public function getPelanggan_api(){
		$this->db->join('tm_top','t_customer.fc_kdtop=tm_top.fc_kdtop','left outer');
		return $this->db->get('t_customer');
    }
    
    public function ambilBarang()
	{


		$this->db->select('	a.fc_kdstock,
												a.fc_barcode,
												a.fv_namastock,
												a.fm_hargajual,
												a.ff_disc_persen,
												a.ff_disc_rupiah,
												a.fm_ongkir,
												a.f_foto,
												a.fc_kdsatuan,
												a.fc_kdtipe,
												a.fc_kdbrand,
												a.fc_kdgroup,
												b.fv_nmtipe,
                                                c.fv_nmbrand,
                                                d.fv_nmgroup,
                                                e.fn_qty,
												f.fv_satuan,
												e.fc_kdarea,
												e.fc_kddivisi');
        $this->db->from('tm_stock as a');
        $this->db->join('td_stock as e','a.fc_kdstock=e.fc_kdstock','left outer');
        $this->db->join('tm_satuan as f','a.fc_kdsatuan=f.fc_kdsatuan','left outer');
		$this->db->join('tm_brand as c', 'a.fc_kdbrand = c.fc_kdbrand', 'left outer');
        $this->db->join('tm_group as d','a.fc_kdgroup=d.fc_kdgroup and a.fc_kdbrand=d.fc_kdbrand', 'left outer');
        $this->db->join('tm_tipe as b','a.fc_kdtipe=b.fc_kdtipe and a.fc_kdgroup=b.fc_kdgroup and a.fc_kdbrand=b.fc_kdbrand','left outer');
		$this->db->where('e.fn_qty > 0');
		// $this->db->or_like('nama_barang', $keyword);

		$barang = $this->db->get();
		
		if($barang->num_rows() > 0){
			$json['status'] 	= 1;
			foreach($barang->result_array() as $b)
			{
				$json['datanya'][] = $b;
			}
			$json['jumlah_barang'] = count($barang->result());
		}
		else
		{
			$json['status'] 	= 0;
		}

		echo json_encode($json);

    }
    
    public function getDiskone(){

		return $this->db->get('tm_stock');
    }
    
    public function getDiskonPeriode(){
        return $this->db->get('t_diskonperiode');
	}
	
	function where_max_umum(){
		return $this->db->query('SELECT fc_nofaktur AS maxs FROM tm_invoice where fc_kdcust="UMUM" order by fc_nofaktur desc limit 1 ');
	}

	function where_max_pel($kode_pelanggan){
		return $this->db->query('SELECT fc_nofaktur AS maxs FROM tm_invoice where fc_kdcust="'.$kode_pelanggan.'" order by fc_nofaktur desc limit 1 ');
	}

	function where_max_pelanggan(){
		return $this->db->query('SELECT fc_kdcust AS maxs FROM t_customer order by fc_kdcust desc limit 1 ');
	}

	function get_top(){
		return $this->db->get('tm_top')->result();
	}

	function get_profesi(){
		return $this->db->get('tm_profesi')->result();
	}

	public function insertCustomer($DataSales)
	{
	  $this->db->insert('t_customer', $DataSales);
	  return $this->db->insert_id();
	}

	public function keuangane(){
		$this->db->where('kode_nama_keuangan',7);
		return $this->db->get('transaksi_nama_keuangan');
	}

	public function keuangane2(){
		$this->db->where('kode_nama_keuangan !=',7);
		return $this->db->get('transaksi_nama_keuangan');
	}

	function insert($where){
		$this->db->insert('tm_invoice',$where);
		return $this->db->insert_id();
	}
	
	function insert_detail($where){
		$this->db->insert('td_invoice',$where);
		return $this->db->insert_id();
	}

	public function get_jatuh_tempo($id_pelanggan){
		$this->db->select('tm_top.fn_jumlah');
		$this->db->join('tm_top','t_customer.fc_kdtop=tm_top.fc_kdtop');
		$this->db->where('t_customer.fc_kdcust', $id_pelanggan);
		return $this->db->get('t_customer')->row();
	}

	function get_nota_print($where)
	{
		$this->db->where($where);
		return $this->db->get('tm_invoice')->row();
	}

	function get_nama_toko(){
		$this->db->where('fc_param','NAMATOKO');
		$this->db->where('fc_kode','1');
		return $this->db->get('t_setup');
	}

	function get_alamat_toko(){
		$this->db->where('fc_param','ALAMATTOKO');
		$this->db->where('fc_kode','1');
		return $this->db->get('t_setup');
	}

	function get_telp_toko(){
		$this->db->where('fc_param','TELPTOKO');
		$this->db->where('fc_kode','1');
		return $this->db->get('t_setup');
	}

	public function get_nota_count_barang_penjualan($where){
		$this->db->select('count(fc_kdstock) as jml_barang');
		$this->db->where($where);
		//$this->db->group_by('id_barang');
		return $this->db->get('td_invoice')->row();
	}

	function get_nota_print_barang_penjualan_kecil($where){
		$this->db->select('b.fc_kdstock');
		$this->db->select('b.fc_barcode');
		$this->db->select('b.fv_namastock');
		$this->db->select('a.fn_qty');
		$this->db->select('a.fm_price');
		$this->db->select('a.fm_subtot');
		$this->db->select('a.fc_nofaktur');
		$this->db->select('c.fv_satuan');

		$this->db->from('td_invoice a');
		$this->db->join('tm_stock b', 'a.fc_kdstock=b.fc_kdstock','left outer');
		$this->db->join('tm_satuan c','b.fc_kdsatuan=c.fc_kdsatuan','left outer');
		$this->db->where('a.fc_nofaktur',$where);
		$query = $this->db->get();
		return $query->result();
	}

	function get_nota_print_barang_penjualan_kecil_new($where){
		$this->db->select('b.fc_kdstock');
		$this->db->select('b.fc_barcode');
		$this->db->select('b.fv_namastock');
		$this->db->select('a.fn_qty');
		$this->db->select('a.fm_price');
		$this->db->select('a.fm_subtot');
		$this->db->select('a.fc_nofaktur');
		$this->db->select('c.fv_satuan');

		$this->db->from('td_invoice a');
		$this->db->join('tm_stock b', 'a.fc_kdstock=b.fc_kdstock','left outer');
		$this->db->join('tm_satuan c','b.fc_kdsatuan=c.fc_kdsatuan','left outer');
		$this->db->where('a.fn_idpenjualan',$where);
		$query = $this->db->get();
		return $query->result();
	}	

}