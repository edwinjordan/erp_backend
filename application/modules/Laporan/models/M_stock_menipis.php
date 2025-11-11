<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class M_stock_menipis extends CI_Model
{

	var $column_order = array('a.fc_kdstock','a.fc_barcode','a.fv_namastock','a.fn_qtymin','b.fn_qty',null); //set column field database for datatable orderable
	var $column_search = array('a.fc_kdstock','a.fc_barcode','a.fv_namastock','a.fn_qtymin','b.fn_qty'); //set column field database for datatable searchable just title , author , category are searchable
    var $order = array('a.fc_kdstock' => 'asc'); // default order

    private function _get_datatables_query() {
		if ($_SERVER['REQUEST_METHOD'] == 'POST' && empty($_POST))
		$request = json_decode(file_get_contents('php://input'), true);
	

		$this->db->select('a.fc_kdstock, a.fc_barcode, a.fv_namastock, a.fn_qtymin, b.fn_qty, b.fc_kddivisi, b.fc_kdarea');

		$this->db->from('tm_stock a');

		$this->db->join('td_stock b', 'a.fc_kdstock=b.fc_kdstock','left outer');
		
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

}	