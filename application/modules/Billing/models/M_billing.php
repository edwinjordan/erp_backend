<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_billing extends CI_Model {

	var $table = 't_bpbmst';
	var $column_order = array('a.fc_nobpb','a.fn_qtytot','a.fn_qtyretur','a.fd_tglbpbp','a.fm_total','b.fv_nama',null); //set column field database for datatable orderable
	var $column_search = array('a.fc_nobpb','a.fn_qtytot','a.fn_qtyretur','a.fd_tglbpbp','a.fm_total','b.fv_nama'); //set column field database for datatable searchable just title , author , category are searchable
    var $order = array('a.fc_nobpb' => 'asc'); // default order

    private function _get_datatables_query() {
		if ($_SERVER['REQUEST_METHOD'] == 'POST' && empty($_POST))
		$request = json_decode(file_get_contents('php://input'), true);
		
        $this->db->select('a.fc_nobpb, DATE_FORMAT(a.fd_tglbpbp, "%d-%m-%Y") as tanggal, a.fn_qtytot, a.fn_qtyretur, a.fm_total, b.fv_nama, a.fc_kddivisi, a.fc_kdarea
        ');
        $this->db->join('tm_supplier b','a.fc_kdsupp=b.fc_kdsupp', 'left outer');
		$this->db->from('t_bpbmst a');
		$this->db->where('a.fc_status', '1');
		$this->db->where('a.fm_dpp LIKE', '%-%');
		
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

	function getBank(){
    	return $this->db->get('transaksi_nama_keuangan');
    }

    function where_max(){
		return $this->db->query('SELECT fc_nopay AS maxs FROM t_apmst order by fc_nopay desc limit 1 ');
    }

    public function get_by_id2($id)
	{
	  $this->db->select('a.fc_nobpb, c.fv_nama, DATE_FORMAT(a.fd_tglbpbp, "%d-%m-%Y") as tanggal, a.fc_kdsupp, a.fm_dpp, a.fd_tglbpbp');	
	  $this->db->from('t_bpbmst a');
	  $this->db->join('tm_supplier c','a.fc_kdsupp=c.fc_kdsupp','left outer');
	  $this->db->where('a.fc_nobpb', $id);
	  $query = $this->db->get();
	  return $query->row();
    }

    function insert_billing($where){
		$this->db->insert('t_apmst',$where);
		return $this->db->insert_id();
	}

	function insert_detail_billing($where){
		$this->db->insert('t_apdtl',$where);
		return $this->db->insert_id();
	}

	function get_total_bpb($id){
		$this->db->where('fc_nobpb', $id);
		return $this->db->get('t_bpbmst')->row();
	}

	public function update_value($where, $data) {
		$this->db->update('t_bpbmst', $data, $where);
		return $this->db->affected_rows();
	}
}	