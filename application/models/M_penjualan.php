<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_penjualan extends CI_Model {

	public $tables = 'penjualan';
  public $tables2 = 'detail_penjualan';
    
  public function pencarianKode($keyword)
	{
		$this->db->select('
			a.id_barang,a.kode_barang,a.nama_barang,a.diskon_persen,a.diskon_rupiah,
			b.id_varian_harga,b.id_barang,b.ukuran,b.meter,b.warna,b.stok_jual,b.harga');
		$this->db->from('barang as a');
		$this->db->join('varian_harga as b', 'b.id_barang = a.id_barang', 'left');
		$this->db->like('kode_barang', $keyword);
		$this->db->or_like('nama_barang', $keyword);
		$barang = $this->db->get();
		
		if($barang->num_rows() > 0)
			{
				$json['status'] 	= 1;
				$json['datanya'] 	= "<ul id='daftar-autocomplete'>";
				foreach($barang->result() as $b)
				{
					$json['datanya'] .= "
						<li>
							<b>Kode</b> : 
							<span id='kodenya'>".$b->kode_barang."</span> <br />
							<span id='barangnya'>".$b->nama_barang."</span> <br />
							<span id='variannya'>".$b->ukuran." (".$b->meter." Pcs)"."</span>
							<span id='harganya' style='display:none;'>".$b->harga."</span>
							<span id='warnanya' style='display:none;'>".$b->warna."</span>
							<span id='id_varian' style='display:none;'>".$b->id_varian_harga."</span>
							<span id='id_barang' style='display:none;'>".$b->id_barang."</span>
						</li>
					";
				}
				$json['datanya'] .= "</ul>";
			}
			else
			{
				$json['status'] 	= 0;
			}

			echo json_encode($json);

	}
	function list_penjualan(){
		$this->db->select('*, karyawan.nama as nama_karyawan');
		$this->db->from('penjualan as b');
		$this->db->join('karyawan', 'karyawan.id_karyawan = b.id_karyawan');
		$this->db->join('pelanggan', 'pelanggan.id_pelanggan = b.id_pelanggan');
		return $this->db->get()->result();
	}

	function list_penjualanAndroid(){
		$this->db->select('*, karyawan.nama as nama_karyawan');
		$this->db->from('penjualan as b');
		$this->db->join('karyawan', 'karyawan.id_karyawan = b.id_karyawan');
		$this->db->join('pelanggan', 'pelanggan.id_pelanggan = b.id_pelanggan');
		$this->db->where('b.status !=', 2);
		return $this->db->get()->result();
	}

	function list_konfirmasiBayar(){
		$this->db->select('*, karyawan.nama as nama_karyawan');
		$this->db->from('penjualan as b');
		$this->db->join('karyawan', 'karyawan.id_karyawan = b.id_karyawan');
		$this->db->join('pelanggan', 'pelanggan.id_pelanggan = b.id_pelanggan');
		$this->db->where('b.status', 2);
		return $this->db->get()->result();
	}

	function where($where){		
		return $this->db->get_where($this->tables,$where);
	}
	function where_detail($where){
		$this->db->select('*');
		$this->db->from('detail_penjualan as b');
		$this->db->join('barang', 'barang.id_barang = b.id_barang');
		$this->db->join('varian_harga', 'varian_harga.id_varian_harga = b.id_varian_harga');
		$this->db->where($where);
		return $this->db->get();
	}
	function max(){
		return $this->db->query('SELECT max(no_faktur) AS maxs FROM '.$this->tables);
	}	

	function insert($where){
		$this->db->insert($this->tables,$where);
		return $this->db->insert_id();
    }
    
	function insert_detail($where){
		$this->db->insert($this->tables2,$where);
		return $this->db->insert_id();
	}

	function update($where, $id){
		return $this->db->update($this->tables,$where,$id);
	}

	function delete($id){
        return $this->db->delete($this->tables,$id);
	}

	public function ambilBarang()
	{
		$this->db->select('
			a.id_barang,
			a.kode_barang,
			a.nama_barang,
			a.diskon_persen,
			a.diskon_rupiah,
			b.id_varian_harga,
			b.id_barang,
			b.meter,
			b.warna,
			b.stok_jual,
			b.harga,
			c.satuan');
		$this->db->from('barang as a');
		$this->db->join('varian_harga as b', 'b.id_barang = a.id_barang', 'left');
		$this->db->join('tm_satuan c','b.kode_satuan=c.kode_satuan','left');
		// $this->db->like('kode_barang', $keyword);
		// $this->db->or_like('nama_barang', $keyword);
		$barang = $this->db->get();
		
		if($barang->num_rows() > 0){
			$json['status'] 	= 1;
			foreach($barang->result() as $b)
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
}