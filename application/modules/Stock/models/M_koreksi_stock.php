<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_koreksi_stock extends CI_Model {

	var $table = 'tm_koreksi_stok';
	var $column_order = array('a.fn_id','a.fc_notrans','a.fd_date','b.fv_nama','c.fv_nmarea','d.fv_nmdivisi',null); //set column field database for datatable orderable
	var $column_search = array('a.fn_id','a.fc_notrans','a.fd_date','b.fv_nama','c.fv_nmarea','d.fv_nmdivisi'); //set column field database for datatable searchable just title , author , category are searchable
    var $order = array('a.fn_id' => 'asc'); // default order

    private function _get_datatables_query() {
		if ($_SERVER['REQUEST_METHOD'] == 'POST' && empty($_POST))
		$request = json_decode(file_get_contents('php://input'), true);
		
        $this->db->select('a.fn_id, a.fc_notrans, a.fd_date, b.fv_nama, c.fv_nmarea, d.fv_nmdivisi, a.fc_kdarea, a.fc_kddivisi');
        $this->db->join('tm_karyawan b', 'a.fc_kdkaryawan=b.fc_kdkaryawan','left outer');
        $this->db->join('tm_area c','a.fc_kdarea=c.fc_kdarea','left outer');
        $this->db->join('tm_divisi d','a.fc_kddivisi=d.fc_kddivisi','left outer');
		$this->db->from('tm_koreksi_stok a');
		
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
	
}	