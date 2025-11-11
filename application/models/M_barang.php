<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class M_barang extends CI_Model{

	public $tables = 'barang';	
	public $tables2 = 'varian_harga';
	// kolom datatable
    var $select_column = 
    array(
    	"a.id_barang",
    	"a.kode_barang",
    	"a.kode_barcode",
    	"a.nama_barang",
    	"sum(b.stok_jual) as stok_jual",
    	"a.date_input",
    	"a.date_edit",
    	"max(b.harga) as harga_barang"
    );  
    var $order_column =  array(
    	null,
    	"a.kode_barang",
    	"a.kode_barcode",
    	"a.nama_barang",
    	null,
    	null,
    	null,
    	null
    );  
      function make_query()  
      {  
           $this->db->select($this->select_column);
			$this->db->from('barang as a');  
			$this->db->join('varian_harga as b', 'b.id_barang = a.id_barang','left');
		$this->db->group_by('a.id_barang');
			
           if(isset($_POST["search"]["value"]))  
           {  
                $this->db->like("a.kode_barang", $_POST["search"]["value"]);  
                $this->db->or_like("a.nama_barang", $_POST["search"]["value"]);  
                $this->db->or_like("a.kode_barcode", $_POST["search"]["value"]);  
           }  
           if(isset($_POST["order"]))  
           {  
                $this->db->order_by($this->order_column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);  
           }  
           else  
           {  
                $this->db->order_by('id_barang', 'DESC');  
           }  
      }  
      function make_datatables(){  
           $this->make_query();  
           if($_POST["length"] != -1)  
           {  
                $this->db->limit($_POST['length'], $_POST['start']);  
           }  
           $query = $this->db->get();  
           return $query->result();  
      }  
      function get_filtered_data(){  
           $this->make_query();  
           $query = $this->db->get();  
           return $query->num_rows();  
      }       
      function get_all_data()  
      {  
      	$this->db->select('
      		a.id_barang,a.kode_barang,a.kode_barcode,a.nama_barang,sum(b.stok_jual) as stok_jual,a.date_input,a.date_edit,
      		max(b.harga) as harga_barang');
      	$this->db->from('barang as a');
      	$this->db->join('varian_harga as b', 'b.id_barang = a.id_barang','left');
      	$this->db->group_by('a.id_barang');
      	return $this->db->count_all_results();  
      }

      // end datatables.
	function jumlah_row()
	{
		$this->db->select('max(id_barang) as max');
		return $this->db->get($this->tables)->row();
	}
	
	function where($where){		
		return $this->db->get_where($this->tables,$where);
	}
	
	function where_harga($where){		
		return $this->db->get_where($this->tables2,$where);
	}	

	function list_barang(){
		// return $this->db->query('
		// 	SELECT 
		// 	c.id_barang, kode_barang, kode_barcode, nama_barang, c.diskon_rupiah, c.diskon_persen, c.image, c.ket,
		// 	d.nama as nama_supplier, stok_gudang, stok_dijual, max(harga) as harga_dijual, 
		// 	c.date_input as input, c.date_edit as edit
		// 	FROM gudang AS a
		// 	INNER JOIN detail_gudang 	AS b ON a.id_gudang = b.id_gudang
		// 	INNER JOIN barang 			AS c ON b.id_barang = c.id_barang
		// 	INNER JOIN supplier 		AS d ON a.id_supplier = d.id_supplier
		// 	INNER JOIN varian_harga 	AS e ON c.id_barang = e.id_barang GROUP BY id_barang');

		$this->db->select('
			a.id_barang,a.kode_barang,a.kode_barcode,a.nama_barang,sum(b.stok_jual) as stok_jual,a.date_input,a.date_edit,
			max(b.harga) as harga_barang');
		$this->db->from('barang as a');
		$this->db->join('varian_harga as b', 'b.id_barang = a.id_barang','left');
		$this->db->group_by('a.id_barang');
		return $this->db->get();
		
	}


	function search_barang($cari){
		// return $this->db->query('SELECT 
		// c.id_barang, kode_barang, kode_barcode, nama_barang, c.diskon_rupiah, c.diskon_persen, c.image, c.ket,
		// d.nama as nama_supplier, stok_gudang, stok_dijual, max(harga) as harga_dijual, 
		// c.date_input as input, c.date_edit as edit
		// FROM gudang AS a
		// INNER JOIN detail_gudang 	AS b ON a.id_gudang = b.id_gudang
		// INNER JOIN barang 			AS c ON b.id_barang = c.id_barang
		// INNER JOIN supplier 		AS d ON a.id_supplier = d.id_supplier
		// INNER JOIN varian_harga 	AS e ON c.id_barang = e.id_barang WHERE nama_barang LIKE "%'.$cari.'%" GROUP BY id_barang');

		
		$this->db->select('
			a.id_barang,a.kode_barang,a.kode_barcode,a.nama_barang,a.date_input,a.date_edit,
			max(b.harga) as harga_barang');
		$this->db->from('barang as a');
		$this->db->join('varian_harga as b', 'b.id_barang = a.id_barang','left');
		$this->db->group_by('a.id_barang');	
		$this->db->like('a.nama_barang',$cari);
		return $this->db->get();
		
	}

	function list_varian(){
		return $this->db->query('SELECT
			barang.id_barang,
			barang.nama_barang,
			varian_harga.id_varian_harga,
			varian_harga.id_barang,
			varian_harga.ukuran,
			varian_harga.warna,
			varian_harga.harga,
			varian_harga.date_input as input,
			varian_harga.date_edit as edit
			FROM
			barang ,
			varian_harga
			GROUP BY
			varian_harga.id_varian_harga');
	}
	 function import($table,$data)
	 {
	 	 $query = $this->db->insert_batch($table, $data);
    	return $this->db->insert_id();
	 }
	 
	function insert($where){
		$this->db->insert($this->tables,$where);
		return $this->db->insert_id();
	}

	function update($where, $data){
		$this->db->where($where);
		$this->db->update($this->tables,$data);
	}
	
	function delete($table,$id){
		return $this->db->delete($table,$id);
	}

	

}
