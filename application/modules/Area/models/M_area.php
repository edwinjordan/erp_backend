<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_area extends CI_Model {

	var $table = 'tm_area';
	var $column_order = array('fc_kdarea','fv_nmarea',null); //set column field database for datatable orderable
	var $column_search = array('fc_kdarea','fv_nmarea'); //set column field database for datatable searchable just title , author , category are searchable
    var $order = array('fc_kdarea' => 'asc'); // default order

    private function _get_datatables_query() {
		if ($_SERVER['REQUEST_METHOD'] == 'POST' && empty($_POST))
		$request = json_decode(file_get_contents('php://input'), true);
		
        $this->db->join('tm_wilayah','tm_area.fc_kdwilayah=tm_wilayah.fc_kdwilayah', 'left outer join');
		$this->db->from('tm_area');
		
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

    public function insertSales($DataSales)
	{
	  $this->db->insert('tm_area', $DataSales);
	  return $this->db->insert_id();
    }
    
    function insert($where){
		$this->db->insert('tm_area',$where);
		return $this->db->insert_id();
	}
    
    function get_data_wilayah(){
        $this->db->from('tm_wilayah');

		$query = $this->db->get();
		return $query->result_array();
    }

    function where_max(){
		return $this->db->query('SELECT fc_kdarea AS maxs FROM tm_area order by fc_kdarea desc limit 1 ');
    }
	
	public function updateArea($id, $blogData)
	{
		$this->db->where('fc_kdarea', $id);
		$this->db->update('tm_area', $blogData);
	}

	public function get_by_id2($id)
	{
	  $this->db->from('tm_area');
	  $this->db->where('fc_kdarea', $id);
	  $query = $this->db->get();
	  return $query->row();
	}

	public function deleteArea($id)
	{
		$this->db->where('fc_kdarea', $id);
		$this->db->delete('tm_area');
	}
    
}    