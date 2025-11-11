<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_top extends CI_Model {

	var $table = 'tm_top';
	var $column_order = array('fn_top','fc_kdtop','fv_nmtop','fn_jumlah',null); //set column field database for datatable orderable
	var $column_search = array('fn_top','fc_kdtop','fv_nmtop','fn_jumlah'); //set column field database for datatable searchable just title , author , category are searchable
    var $order = array('fn_top' => 'asc'); // default order

    private function _get_datatables_query() {
		if ($_SERVER['REQUEST_METHOD'] == 'POST' && empty($_POST))
		$request = json_decode(file_get_contents('php://input'), true);
		
		$this->db->from('tm_top');
		
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
    function where_max(){
		return $this->db->query('SELECT fc_kdtop AS maxs FROM tm_top order by fc_kdtop desc limit 1 ');
    }
    
    public function insertTop($DataSales)
	{
	  $this->db->insert('tm_top', $DataSales);
	  return $this->db->insert_id();
    }
    
    public function get_by_id2($id)
	{
	  $this->db->from('tm_top');
	  $this->db->where('fc_kdtop', $id);
	  $query = $this->db->get();
	  return $query->row();
	}

	public function updateTop($id, $blogData)
	{
		$this->db->where('fc_kdtop', $id);
		$this->db->update('tm_top', $blogData);
	}

	public function deleteTop($id)
	{
		$this->db->where('fc_kdtop', $id);
		$this->db->delete('tm_top');
	}

}    