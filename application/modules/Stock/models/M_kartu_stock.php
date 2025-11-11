<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_kartu_stock extends CI_Model {

	var $table = 'tm_stock';
	var $column_order = array('a.fn_id','a.fc_kdstock','a.fc_barcode','a.fv_namastock','b.fv_nmtipe','c.fv_nmbrand','d.fv_nmgroup','a.fm_hargajual','a.fm_hargabeli','e.fv_satuan',null); //set column field database for datatable orderable
	var $column_search = array('a.fn_id','a.fc_kdstock','a.fc_barcode','a.fv_namastock','b.fv_nmtipe','c.fv_nmbrand','d.fv_nmgroup','a.fm_hargajual','a.fm_hargabeli','e.fv_satuan'); //set column field database for datatable searchable just title , author , category are searchable
    var $order = array('a.fn_id' => 'asc'); // default order

    private function _get_datatables_query() {
		if ($_SERVER['REQUEST_METHOD'] == 'POST' && empty($_POST))
		$request = json_decode(file_get_contents('php://input'), true);
		
        $this->db->select('a.fn_id, a.fc_kdstock, a.fc_barcode, a.fv_namastock, b.fv_nmtipe, c.fv_nmbrand, d.fv_nmgroup, a.fm_hargajual, a.fm_hargabeli, a.fn_qtymin, a.fn_qtymax,
                           a.fn_qtyPOmax, a.fn_qtyPOmin, a.fc_status, a.fd_update, a.fd_tglinput, a.fc_userinput, a.fv_ket, a.ff_disc_persen, a.ff_disc_rupiah, a.fm_ongkir, a.f_foto,
                           e.fv_satuan, g.fv_nmarea, h.fv_nmdivisi, f.fc_kdarea, f.fc_kddivisi, f.fn_qty_awal,f.fn_qty_in, f.fn_qty_out, f.fn_qty_sisa, f.fv_ket, i.fv_nama, f.fd_tgl
        ');
        $this->db->join('td_kartu_stok f','a.fc_kdstock=f.fc_kdstock', 'left outer');
        $this->db->join('tm_karyawan i', 'f.fc_userinput=i.fc_kdkaryawan','left outer');
        $this->db->join('tm_satuan e','a.fc_kdsatuan=e.fc_kdsatuan', 'left outer');
        $this->db->join('tm_brand c','a.fc_kdbrand=c.fc_kdbrand', 'left outer');
        $this->db->join('tm_group d','a.fc_kdgroup=d.fc_kdgroup and a.fc_kdbrand=d.fc_kdbrand', 'left outer');
        $this->db->join('tm_tipe b','a.fc_kdtipe=b.fc_kdtipe and a.fc_kdgroup=b.fc_kdgroup and a.fc_kdbrand=b.fc_kdbrand', 'left outer');
        $this->db->join('tm_area g','f.fc_kdarea=g.fc_kdarea','left outer');
        $this->db->join('tm_divisi h','f.fc_kddivisi=h.fc_kddivisi','left outer');
		$this->db->from('tm_stock a');
		
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