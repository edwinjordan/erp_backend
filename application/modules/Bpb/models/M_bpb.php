<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_bpb extends CI_Model {

	var $table = 'tm_po';
	var $column_order = array('a.fc_nopo','b.fv_nama','c.fv_nmarea','d.fv_nmdivisi','a.fn_totqty','a.fm_total',null); //set column field database for datatable orderable
	var $column_search = array('a.fc_nopo','b.fv_nama','c.fv_nmarea','d.fv_nmdivisi','a.fn_totqty','a.fm_total'); //set column field database for datatable searchable just title , author , category are searchable
    var $order = array('a.fc_nopo' => 'asc'); // default order

    private function _get_datatables_query() {
		if ($_SERVER['REQUEST_METHOD'] == 'POST' && empty($_POST))
		$request = json_decode(file_get_contents('php://input'), true);
		
        $this->db->select('a.fc_nopo, DATE_FORMAT(a.fd_tglinput, "%d-%m-%Y") as tanggal, c.fv_nmarea, d.fv_nmdivisi, a.fn_totqty, a.fm_total, e.fv_nama, a.fc_kdarea, a.fc_kddivisi
        ');
        $this->db->join('tm_supplier b','a.fc_kdsupp=b.fc_kdsupp', 'left outer');
        $this->db->join('tm_karyawan e','a.fc_userid=e.fc_kdkaryawan','left outer');
        $this->db->join('tm_area c','a.fc_kdarea=c.fc_kdarea', 'left outer');
        $this->db->join('tm_divisi d','a.fc_kddivisi=d.fc_kddivisi', 'left outer');
        $this->db->where('a.fc_sts', 1);
		$this->db->from('tm_po a');
		
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
		return $this->db->query('SELECT fc_nobpb AS maxs FROM t_bpbmst order by fc_nobpb desc limit 1 ');
    }

    public function get_by_id2($id)
	{
	  $this->db->select('a.fc_nopo, b.fv_nama, DATE_FORMAT(a.fd_tglinput, "%d-%m-%Y") as tanggal, c.fv_nama as fv_nama_supplier,a.fn_totqty, c.fv_alamat,a.fm_total');	
	  $this->db->from('tm_po a');
	  $this->db->join('tm_karyawan b','a.fc_userid=b.fc_kdkaryawan','left outer');
	  $this->db->join('tm_supplier c','a.fc_kdsupp=c.fc_kdsupp','left outer');
	  $this->db->where('a.fc_nopo', $id);
	  $query = $this->db->get();
	  return $query->row();
    }

    public function getBarangPO($id)
	{


		$this->db->select('	b.fc_kdstock,
												b.fc_barcode,
												b.fv_namastock,
												b.fm_hargabeli,
												a.fc_kdsatuan,
												a.fc_kdtipe,
												a.fc_kdbrand,
												a.fc_kdgroup,
												c.fv_nmtipe,
                                                d.fv_nmbrand,
                                                e.fv_nmgroup,
												f.fv_satuan,
												a.fn_qty,
												a.fm_price,
												a.fm_subtot_det,
												a.fc_kdarea,
												a.fc_kddivisi');
        $this->db->from('td_po as a');
        $this->db->join('tm_stock as b','a.fc_kdstock=b.fc_kdstock','left outer');
        $this->db->join('tm_satuan as f','a.fc_kdsatuan=f.fc_kdsatuan','left outer');
		$this->db->join('tm_brand as d', 'a.fc_kdbrand = d.fc_kdbrand', 'left outer');
        $this->db->join('tm_group as e','a.fc_kdgroup=e.fc_kdgroup and a.fc_kdbrand=e.fc_kdbrand', 'left outer');
        $this->db->join('tm_tipe as c','a.fc_kdtipe=c.fc_kdtipe and a.fc_kdgroup=c.fc_kdgroup and a.fc_kdbrand=c.fc_kdbrand','left outer');
        $this->db->where('a.fc_nopo', $id);
		return $this->db->get();
	}	

	function insert_bpb($where){
		$this->db->insert('t_bpbmst',$where);
		return $this->db->insert_id();
	}

	function insert_detail_bpb($where){
		$this->db->insert('t_bpbdtl',$where);
		return $this->db->insert_id();
	}

	public function update_sts($where, $data) {
		$this->db->update('tm_po', $data, $where);
		return $this->db->affected_rows();
	}

	public function getTablePembelian($fc_nobpb){
		$this->db->where('fc_nobpb', $fc_nobpb);
    	$query = $this->db->get('t_bpbdtl');
    	return $query;
	}

	public function stok_gudang($id, $fc_kdarea, $fc_kddivisi){
    	$this->db->select('count(*) as jml_ada');
    	$this->db->from('td_stock');
    	$this->db->where('fc_kdstock', $id);
    	$this->db->where('fc_kdarea',$fc_kdarea);
    	$this->db->where('fc_kddivisi',$fc_kddivisi);
    	$query = $this->db->get();
    	return $query->row();
    }

     public function detail_gedung($id, $fc_kdarea, $fc_kddivisi){

    	$this->db->where('fc_kdstock', $id);
    	$this->db->where('fc_kdarea',$fc_kdarea);
    	$this->db->where('fc_kddivisi',$fc_kddivisi);
    	$query = $this->db->get('td_stock');
    	return $query->result();

    }

    public function update_table($table, $data, $where) {
        $this->db->where($where);
        $query = $this->db->update($table, $data);
    }

    function insert_table($table, $data) {
        $query = $this->db->insert($table, $data);
        return $query;
    }
}	