<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_profesi extends CI_Model {

	var $table = 'tm_profesi';
	var $column_order = array('fc_kdprofesi','fv_nmprofesi',null); //set column field database for datatable orderable
	var $column_search = array('fc_kdprofesi','fv_nmprofesi'); //set column field database for datatable searchable just title , author , category are searchable
    var $order = array('fc_kdprofesi' => 'asc'); // default order

    private function _get_datatables_query() {
		if ($_SERVER['REQUEST_METHOD'] == 'POST' && empty($_POST))
		$request = json_decode(file_get_contents('php://input'), true);
		
		$this->db->from('tm_profesi');
		
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
		return $this->db->query('SELECT fc_kdprofesi AS maxs FROM tm_profesi order by fc_kdprofesi desc limit 1 ');
    }

    public function get_by_id2($id)
	{
	  $this->db->from('tm_profesi');
	  $this->db->where('fc_kdprofesi', $id);
	  $query = $this->db->get();
	  return $query->row();
    }

    public function updateProfesi($id, $blogData)
	{
		$this->db->where('fc_kdprofesi', $id);
		$this->db->update('tm_profesi', $blogData);
    }
    
    public function deleteProfesi($id)
	{
		$this->db->where('fc_kdprofesi', $id);
		$this->db->delete('tm_profesi');
	}
}   