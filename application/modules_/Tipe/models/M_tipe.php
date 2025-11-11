<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_tipe extends CI_Model {

	var $table = 'tm_tipe';
	var $column_order = array('a.fc_kdtipe','b.fv_nmgroup','c.fv_nmbrand','a.fv_nmtipe',null); //set column field database for datatable orderable
	var $column_search = array('a.fc_kdtipe','b.fv_nmgroup','c.fv_nmbrand','a.fv_nmtipe'); //set column field database for datatable searchable just title , author , category are searchable
    var $order = array('a.fc_kdtipe' => 'asc'); // default order

    private function _get_datatables_query() {
		if ($_SERVER['REQUEST_METHOD'] == 'POST' && empty($_POST))
		$request = json_decode(file_get_contents('php://input'), true);
        
        $this->db->join('tm_group b','a.fc_kdgroup=b.fc_kdgroup','left outer');
        $this->db->join('tm_brand c','a.fc_kdbrand=c.fc_kdbrand','left outer');
		$this->db->from('tm_tipe a');
		
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

	function where_max(){
		return $this->db->query('SELECT fc_kdtipe AS maxs FROM tm_tipe order by fc_kdtipe desc limit 1 ');
	}
	
	public function get_by_id2($id)
	{
	  $this->db->from('tm_tipe');
	  $this->db->where('fc_kdtipe', $id);
	  $query = $this->db->get();
	  return $query->row();
	}

	public function updateTipe($id, $blogData)
	{
		$this->db->where('fc_kdtipe', $id);
		$this->db->update('tm_tipe', $blogData);
	}

	public function deleteTipe($id)
	{
		$this->db->where('fc_kdtipe', $id);
		$this->db->delete('tm_tipe');
	}

}    