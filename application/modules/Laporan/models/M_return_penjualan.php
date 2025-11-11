<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class M_return_penjualan extends CI_Model
{

	var $column_order = array('a.fc_noretur','a.fc_nofaktur','a.fd_tglinput','b.fv_nama','b.fn_qty','b.fc_kota',null); //set column field database for datatable orderable
	var $column_search = array('a.fc_noretur','a.fc_nofaktur','a.fd_tglinput','b.fv_nama','b.fn_qty','b.fc_kota'); //set column field database for datatable searchable just title , author , category are searchable
    var $order = array('a.fc_noretur' => 'asc'); // default order

    private function _get_datatables_query() {
		if ($_SERVER['REQUEST_METHOD'] == 'POST' && empty($_POST))
		$request = json_decode(file_get_contents('php://input'), true);
	

		$this->db->select('a.fc_noretur, a.fc_nofaktur, a.fd_tglinput, DATE_FORMAT(a.fd_tglinput, "%d-%m-%Y") as tanggal, b.fv_nama, b.fc_kota, a.fm_total, c.fc_kddivisi, c.fc_kdarea');

		$this->db->from('tm_returninv a');

		$this->db->join('t_customer b', 'a.fc_kdcust=b.fc_kdcust','left outer');
		$this->db->join('td_returninv c', 'a.fc_noretur=c.fc_noretur','left outer');
		$this->db->group_by('c.fc_noretur');
		
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
		$this->db->from('tm_stock');
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

	public function get_rincian_retur($id){
		$this->db->where('fc_noretur', $id);

		$this->db->select('f.fc_kdstock,f.fv_namastock,b.fv_nmtipe,c.fv_nmbrand, d.fv_nmgroup, e.fv_satuan,a.fn_qtyretur,a.fm_subtot');
		$this->db->join('tm_tipe b','a.fc_kdtipe=b.fc_kdtipe', 'left outer');
        $this->db->join('tm_brand c','a.fc_kdbrand=c.fc_kdbrand', 'left outer');
        $this->db->join('tm_group d','a.fc_kdgroup=d.fc_kdgroup', 'left outer');
        $this->db->join('tm_satuan e','a.fc_kdsatuan=e.fc_kdsatuan', 'left outer');
        $this->db->join('tm_stock f','a.fc_kdstock=f.fc_kdstock','left outer');
		$this->db->from('td_returninv a');

		$query = $this->db->get();
		return $query->result_array();
	}

}	