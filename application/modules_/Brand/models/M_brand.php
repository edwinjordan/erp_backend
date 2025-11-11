<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_brand extends CI_Model {

	var $table = 'tm_brand';
	var $column_order = array('fc_kdbrand','fv_nmbrand','fc_hold',null); //set column field database for datatable orderable
	var $column_search = array('fc_kdbrand','fv_nmbrand','fc_hold'); //set column field database for datatable searchable just title , author , category are searchable
    var $order = array('fc_kdbrand' => 'asc'); // default order

    private function _get_datatables_query() {
		if ($_SERVER['REQUEST_METHOD'] == 'POST' && empty($_POST))
		$request = json_decode(file_get_contents('php://input'), true);
		
		$this->db->from('tm_brand');
		
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
    
    public function get_by_id2($id)
	{
	  $this->db->from('tm_brand');
	  $this->db->where('fc_kdbrand', $id);
	  $query = $this->db->get();
	  return $query->row();
    }

    public function updateBrand($id, $blogData)
	{
		$this->db->where('fc_kdbrand', $id);
		$this->db->update('tm_brand', $blogData);
    }

    public function deleteBrand($id)
	{
		$this->db->where('fc_kdbrand', $id);
		$this->db->delete('tm_brand');
	}

}    