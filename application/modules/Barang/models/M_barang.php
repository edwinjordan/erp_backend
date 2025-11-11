<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_barang extends CI_Model {

	var $table = 'tm_stock';
	var $column_order = array('a.fn_id','a.fc_kdstock','a.fc_barcode','a.fv_namastock','b.fv_nmtipe','c.fv_nmbrand','d.fv_nmgroup','a.fm_hargajual','a.fm_hargabeli','e.fv_satuan',null); //set column field database for datatable orderable
	var $column_search = array('a.fn_id','a.fc_kdstock','a.fc_barcode','a.fv_namastock','b.fv_nmtipe','c.fv_nmbrand','d.fv_nmgroup','a.fm_hargajual','a.fm_hargabeli','e.fv_satuan'); //set column field database for datatable searchable just title , author , category are searchable
    var $order = array('a.fn_id' => 'asc'); // default order

    private function _get_datatables_query() {
		if ($_SERVER['REQUEST_METHOD'] == 'POST' && empty($_POST))
		$request = json_decode(file_get_contents('php://input'), true);
		
        $this->db->select('a.fn_id, a.fc_kdstock, a.fc_barcode, a.fv_namastock, b.fv_nmtipe, c.fv_nmbrand, d.fv_nmgroup, a.fm_hargajual, a.fm_hargabeli, a.fn_qtymin, a.fn_qtymax,
                           a.fn_qtyPOmax, a.fn_qtyPOmin, a.fc_status, a.fd_update, a.fd_tglinput, a.fc_userinput, a.fv_ket, a.ff_disc_persen, a.ff_disc_rupiah, a.fm_ongkir, a.f_foto,
                           e.fv_satuan 
        ');
        $this->db->join('tm_tipe b','a.fc_kdtipe=b.fc_kdtipe', 'left outer');
        $this->db->join('tm_brand c','a.fc_kdbrand=c.fc_kdbrand', 'left outer');
        $this->db->join('tm_group d','a.fc_kdgroup=d.fc_kdgroup', 'left outer');
        $this->db->join('tm_satuan e','a.fc_kdsatuan=e.fc_kdsatuan', 'left outer');
		$this->db->from('tm_stock a');
		
		$i = 0;
		foreach ($this->column_search as $item) {
			if (@$request['search']["value"]) {
				if ($i===0) {
					$this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
					$this->db->like($item, $request['search']["value"]);
				} else {
					$this->db->or_like($item, $request['search']["value"]);
			}
			
			if (count($this->column_search) - 1 == $i)
				$this->db->group_end();
			}

			$i++;
		}

		if (isset($request['order'])) {
			$this->db->order_by($this->column_order[$request['order']['0']['column']], $request['order']['0']['dir']);
		} else if (isset($this->order)) {
			$order = $this->order;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}

	function count_filtered() {
		$this->_get_datatables_query();
		$query = $this->db->get();
		return $query->num_rows();
	}

	function count_all() {
		$this->db->from($this->table);
		return $this->db->count_all_results();
	}

	public function get_datatables() {
		$this->_get_datatables_query();
		if ($_SERVER['REQUEST_METHOD'] == 'POST' && empty($_POST))
        $request = json_decode(file_get_contents('php://input'), true);
		if (@$request['length'] != -1) {
			$this->db->limit(@$request['length'], @$request['start']);
		}

		$query = $this->db->get();
		return $query->result();
	}
	
	public function get_data_tipe() {
       
		$this->db->from('tm_tipe');

		$query = $this->db->get();
		return $query->result_array();
	}

	public function get_data_group() {
       
		$this->db->from('tm_group');

		$query = $this->db->get();
		return $query->result_array();
	}

	public function get_data_brand() {
       
		$this->db->from('tm_brand');

		$query = $this->db->get();
		return $query->result_array();
	}

	public function get_data_satuan() {
       
		$this->db->from('tm_satuan');

		$query = $this->db->get();
		return $query->result_array();
	}

	public function insertBarang($blogData)
	{
	  $this->db->insert('tm_stock', $blogData);
	  return $this->db->insert_id();
	}

	public function get_by_id2($id)
  {
    $this->db->from('tm_stock');
    $this->db->where('fn_id', $id);
    $query = $this->db->get();
    return $query->row();
  }

  public function get_by_idne($id)
  {
    $this->db->from('tm_stock');
    $this->db->where('fn_id', $id);
    $query = $this->db->get();
    return $query->row();
  }

  public function updateBarang($id, $blogData)
  {
    $this->db->where('fn_id', $id);
    $this->db->update('tm_stock', $blogData);
  }

  public function deleteBarang($id)
  {
    $this->db->where('fn_id', $id);
    $this->db->delete('tm_stock');
  }

  public function get_barang(){
  	$this->db->select('a.fn_id, a.fc_kdstock, a.fc_barcode, a.fv_namastock, b.fv_nmtipe, c.fv_nmbrand, d.fv_nmgroup, a.fm_hargajual, a.fm_hargabeli, a.fn_qtymin, a.fn_qtymax,
                           a.fn_qtyPOmax, a.fn_qtyPOmin, a.fc_status, a.fd_update, a.fd_tglinput, a.fc_userinput, a.fv_ket, a.ff_disc_persen, a.ff_disc_rupiah, a.fm_ongkir, a.f_foto,
                           e.fv_satuan , f.fn_qty
        ');
    $this->db->join('tm_tipe b','a.fc_kdtipe=b.fc_kdtipe', 'left outer');
    $this->db->join('tm_brand c','a.fc_kdbrand=c.fc_kdbrand', 'left outer');
    $this->db->join('tm_group d','a.fc_kdgroup=d.fc_kdgroup', 'left outer');
    $this->db->join('tm_satuan e','a.fc_kdsatuan=e.fc_kdsatuan', 'left outer');
	$this->db->join('td_stock f', 'a.fc_kdstock=f.fc_kdstock','left outer');
	return $this->db->get('tm_stock a')->result();
  }

  function where($where){		
		$this->db->join('tm_tipe b','a.fc_kdtipe=b.fc_kdtipe', 'left outer');
	    $this->db->join('tm_brand c','a.fc_kdbrand=c.fc_kdbrand', 'left outer');
	    $this->db->join('tm_group d','a.fc_kdgroup=d.fc_kdgroup', 'left outer');
	    $this->db->join('tm_satuan e','a.fc_kdsatuan=e.fc_kdsatuan', 'left outer');
		return $this->db->get_where('tm_stock a',$where);
  }
}   