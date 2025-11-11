<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_karyawan extends CI_Model {

	var $table = 'tm_karyawan';
	var $column_order = array('a.fc_kdkaryawan','a.fv_noktp','a.fv_nama','a.fv_alamat','a.fc_kota','a.fv_notelp','b.f_deptname','c.fv_nmarea','d.fv_nmdivisi',null); //set column field database for datatable orderable
	var $column_search = array('a.fc_kdkaryawan','a.fv_noktp','a.fv_nama','a.fv_alamat','a.fc_kota','a.fv_notelp','b.f_deptname','c.fv_nmarea','d.fv_nmdivisi'); //set column field database for datatable searchable just title , author , category are searchable
	var $order = array('a.fc_kdkaryawan' => 'asc'); // default order
	
    
    private function _get_datatables_query() {
		if ($_SERVER['REQUEST_METHOD'] == 'POST' && empty($_POST))
		$request = json_decode(file_get_contents('php://input'), true);
        
        $this->db->select('a.fc_kdkaryawan, a.fv_noktp, a.fv_nama, a.fv_alamat, a.fc_kota, a.fv_notelp,a.fc_sts, b.f_deptname, c.fv_nmarea, d.fv_nmdivisi');
        $this->db->join('t_departement b','a.f_deptid=b.f_deptid', 'left outer join');
        $this->db->join('tm_area c','a.fc_kdarea=c.fc_kdarea', 'left outer join');
        $this->db->join('tm_divisi d','a.fc_kddivisi=d.fc_kddivisi', 'left outer join');
		$this->db->from('tm_karyawan a');
		
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

    public function get_data_dept() {
       
		$this->db->from('t_departement');

		$query = $this->db->get();
		return $query->result_array();
    }

    public function get_data_divisi() {
       
		$this->db->from('tm_divisi');

		$query = $this->db->get();
		return $query->result_array();
    }
    
    public function get_data_area() {
       
		$this->db->from('tm_area');

		$query = $this->db->get();
		return $query->result_array();
    }
    
    function where_max(){
		return $this->db->query('SELECT fc_kdkaryawan AS maxs FROM tm_karyawan order by fc_kdkaryawan desc limit 1 ');
	}

	public function get_by_id2($id)
	{
	  $this->db->from('tm_karyawan');
	  $this->db->where('fc_kdkaryawan', $id);
	  $query = $this->db->get();
	  return $query->row();
	}

	public function get_by_id3($id){
	  $this->db->from('tm_karyawan');
	  $this->db->where('fc_kdkaryawan', $id);
	  $query = $this->db->get();
	  return $query->row();
	}

	public function updateKaryawan($id, $blogData)
	{
		$this->db->where('fc_kdkaryawan', $id);
		$this->db->update('tm_karyawan', $blogData);
	}

	public function deleteKaryawan($id)
	{
		$this->db->where('fc_kdkaryawan', $id);
		$this->db->delete('tm_karyawan');
	}

	public function updateLoginKaryawan($id, $blogData){
		$this->db->where('fc_kdkaryawan', $id);
		$this->db->update('tm_karyawan', $blogData);
	}
    
}   