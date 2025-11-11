<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class M_laporan_transaksi extends CI_Model

{

	var $table  = 'transaksi_master';

    //var $table = 't_bpbmst';
	var $column_order = array('kode_transaksi_master','no_faktur','tgl_transaksi_master','debit_transaksi_master','kredit_transaksi_master','kode_nama_keuangan',null); //set column field database for datatable orderable
	var $column_search = array('kode_transaksi_master','no_faktur','tgl_transaksi_master','debit_transaksi_master','kredit_transaksi_master','kode_nama_keuangan'); //set column field database for datatable searchable just title , author , category are searchable
    var $order = array('kode_transaksi_master' => 'asc'); // default order

    private function _get_datatables_query() {
		if ($_SERVER['REQUEST_METHOD'] == 'POST' && empty($_POST))
		$request = json_decode(file_get_contents('php://input'), true);
		
        $this->db->where('status_transaksi_master', '6');

		$this->db->or_where('status_transaksi_master', '7');

		$this->db->select('tgl_transaksi_master,
						   debit_transaksi_master,
						   kredit_transaksi_master,
						   fc_kdarea,
						   fc_kddivisi,
						   DATE_FORMAT(tgl_transaksi_master, "%d-%m-%Y") as tanggal');

		$this->db->from($this->table);

		
		
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
}	