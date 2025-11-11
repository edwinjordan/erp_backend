<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_sales extends CI_Model {

	var $table = 't_sales';
	var $column_order = array('fc_salesid','fv_nama',null); //set column field database for datatable orderable
	var $column_search = array('fc_salesid','fv_nama'); //set column field database for datatable searchable just title , author , category are searchable
	var $order = array('fc_salesid' => 'asc'); // default order
	
    
    private function _get_datatables_query() {
		if ($_SERVER['REQUEST_METHOD'] == 'POST' && empty($_POST))
		$request = json_decode(file_get_contents('php://input'), true);
		
		$this->db->where('fc_aktif','Y');
        $this->db->join('t_departement','t_sales.f_deptid=t_departement.f_deptid', 'left outer join');
		$this->db->from('t_sales');
		
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

    public function get_data_sales() {
		$this->db->where('fc_aktif','Y');
        $this->db->join('t_departement','t_sales.f_deptid=t_departement.f_deptid', 'left outer join');
		$this->db->from('t_sales');

		$query = $this->db->get();
		return $query->result_array();
	}

	public function get_data_departement() {
       
		$this->db->from('t_departement');

		$query = $this->db->get();
		return $query->result_array();
	}

	function where_max(){
		return $this->db->query('SELECT fc_salesid AS maxs FROM t_sales order by fc_salesid desc limit 1 ');
	}

	function limit ( $request, $columns )
	{
		$limit = '';

		if ( isset($request['start']) && $request['length'] != -1 ) {
			$limit = "LIMIT ".intval($request['start']).", ".intval($request['length']);
		}

		return $limit;
	}

	public function insertSales($DataSales)
	{
	  $this->db->insert('t_sales', $DataSales);
	  return $this->db->insert_id();
	}

	public function get_by_id2($id)
	{
	  $this->db->from('t_sales');
	  $this->db->where('fc_salesid', $id);
	  $query = $this->db->get();
	  return $query->row();
	}

	public function updateSales($id, $blogData)
	{
		$this->db->where('fc_salesid', $id);
		$this->db->update('t_sales', $blogData);
	}

	public function deleteSales($id)
	{
		$this->db->where('fc_salesid', $id);
		$this->db->delete('t_sales');
	}
}    