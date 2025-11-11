<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_customer extends CI_Model {

	var $table = 't_customer';
	var $column_order = array('a.fc_kdcust','a.fv_nama','a.fv_alamat','a.fv_email','a.fv_noktp','b.fv_nmtop','c.fv_nmprofesi',null); //set column field database for datatable orderable
	var $column_search = array('a.fc_kdcust','a.fv_nama','a.fv_alamat','a.fv_email','a.fv_noktp','b.fv_nmtop','c.fv_nmprofesi'); //set column field database for datatable searchable just title , author , category are searchable
	var $order = array('a.fc_kdcust' => 'asc'); // default order
	
    
    private function _get_datatables_query() {
		if ($_SERVER['REQUEST_METHOD'] == 'POST' && empty($_POST))
		$request = json_decode(file_get_contents('php://input'), true);
		
        $this->db->join('tm_top b','a.fc_kdtop=b.fc_kdtop', 'left outer');
        $this->db->join('tm_profesi c','a.fc_kdprofesi=c.fc_kdprofesi', 'left outer');
		$this->db->from('t_customer a');
		
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

	public function get_data_top() {
       
		$this->db->from('tm_top');

		$query = $this->db->get();
		return $query->result_array();
    }
    
    public function get_data_profesi() {
       
		$this->db->from('tm_profesi');

		$query = $this->db->get();
		return $query->result_array();
	}

	function where_max(){
		return $this->db->query('SELECT fc_kdcust AS maxs FROM t_customer order by fc_kdcust desc limit 1 ');
	}

	function limit ( $request, $columns )
	{
		$limit = '';

		if ( isset($request['start']) && $request['length'] != -1 ) {
			$limit = "LIMIT ".intval($request['start']).", ".intval($request['length']);
		}

		return $limit;
	}

	public function insertCustomer($DataSales)
	{
	  $this->db->insert('t_customer', $DataSales);
	  return $this->db->insert_id();
	}

	public function get_by_id2($id)
	{
	  $this->db->from('t_customer');
	  $this->db->where('fc_kdcust', $id);
	  $query = $this->db->get();
	  return $query->row();
	}

	public function updateCustomer($id, $blogData)
	{
		$this->db->where('fc_kdcust', $id);
		$this->db->update('t_customer', $blogData);
	}

	public function deleteCustomer($id)
	{
		$this->db->where('fc_kdcust', $id);
		$this->db->delete('t_customer');
	}
}    