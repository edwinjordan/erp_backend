<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_stock extends CI_Model {

	var $table = 'tm_stock';
	var $column_order = array('a.fn_id','a.fc_kdstock','a.fc_barcode','a.fv_namastock','b.fv_nmtipe','c.fv_nmbrand','d.fv_nmgroup','a.fm_hargajual','a.fm_hargabeli','e.fv_satuan','f.fn_qty',null); //set column field database for datatable orderable
	var $column_search = array('a.fn_id','a.fc_kdstock','a.fc_barcode','a.fv_namastock','b.fv_nmtipe','c.fv_nmbrand','d.fv_nmgroup','a.fm_hargajual','a.fm_hargabeli','e.fv_satuan','f.fn_qty'); //set column field database for datatable searchable just title , author , category are searchable
    var $order = array('a.fn_id' => 'asc'); // default order

    private function _get_datatables_query() {
		if ($_SERVER['REQUEST_METHOD'] == 'POST' && empty($_POST))
		$request = json_decode(file_get_contents('php://input'), true);
		
        $this->db->select('a.fn_id, a.fc_kdstock, a.fc_barcode, a.fv_namastock, b.fv_nmtipe, c.fv_nmbrand, d.fv_nmgroup, a.fm_hargajual, a.fm_hargabeli, a.fn_qtymin, a.fn_qtymax,
                           a.fn_qtyPOmax, a.fn_qtyPOmin, a.fc_status, a.fd_update, a.fd_tglinput, a.fc_userinput, a.fv_ket, a.ff_disc_persen, a.ff_disc_rupiah, a.fm_ongkir, a.f_foto,
                           e.fv_satuan, f.fn_qty , g.fv_nmarea, h.fv_nmdivisi, f.fc_kdarea, f.fc_kddivisi
        ');
        $this->db->join('td_stock f','a.fc_kdstock=f.fc_kdstock', 'left outer');
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

	public function getBarang()
	{


		$this->db->select('	a.fc_kdstock,
												a.fc_barcode,
												a.fv_namastock,
												a.fm_hargajual,
												a.ff_disc_persen,
												a.ff_disc_rupiah,
												a.fm_ongkir,
												a.f_foto,
												a.fc_kdsatuan,
												a.fc_kdtipe,
												a.fc_kdbrand,
												a.fc_kdgroup,
												b.fv_nmtipe,
                                                c.fv_nmbrand,
                                                d.fv_nmgroup,
                                                e.fn_qty,
												f.fv_satuan,
												e.fc_kdarea,
												e.fc_kddivisi');
        $this->db->from('tm_stock as a');
        $this->db->join('td_stock as e','a.fc_kdstock=e.fc_kdstock','left outer');
        $this->db->join('tm_satuan as f','a.fc_kdsatuan=f.fc_kdsatuan','left outer');
		$this->db->join('tm_brand as c', 'a.fc_kdbrand = c.fc_kdbrand', 'left outer');
        $this->db->join('tm_group as d','a.fc_kdgroup=d.fc_kdgroup and a.fc_kdbrand=d.fc_kdbrand', 'left outer');
        $this->db->join('tm_tipe as b','a.fc_kdtipe=b.fc_kdtipe and a.fc_kdgroup=b.fc_kdgroup and a.fc_kdbrand=b.fc_kdbrand','left outer');
		return $this->db->get();
	}	

	function where_max(){
		return $this->db->query('SELECT fc_notrans AS maxs FROM tm_koreksi_stok order by fc_notrans desc limit 1 ');
    }

	function where_max_transfer(){
		return $this->db->query('SELECT fc_faktur_transfer AS maxs FROM tm_transfer_stock order by fc_faktur_transfer desc limit 1 ');
    }

	function insert($where){
		$this->db->insert('tm_koreksi_stok',$where);
		return $this->db->insert_id();
    }

	function insert_transfer($where){
		$this->db->insert('tm_transfer_stock',$where);
		return $this->db->insert_id();
	}

	function insert_detail($where){
		$this->db->insert('td_koreksi_stok',$where);
		return $this->db->insert_id();
	}

	function insert_detail_transfer($where){
		$this->db->insert('td_transfer_stock',$where);
		return $this->db->insert_id();
	}

	public function get_by_id2($id)
	{
	  $this->db->select('a.fc_notrans, DATE_FORMAT(a.fd_date, "%d-%m-%Y") as tanggal, b.fv_nama, a.fc_periode');	
	  $this->db->from('tm_koreksi_stok a');
	  $this->db->join('tm_karyawan b','a.fc_kdkaryawan=b.fc_kdkaryawan','left outer');
	  $this->db->where('a.fc_notrans', $id);
	  $query = $this->db->get();
	  return $query->row();
	}

	public function get_by_id_transfer($id)
	{
	  $this->db->select('a.fc_faktur_transfer, DATE_FORMAT(a.fd_date, "%d-%m-%Y") as tanggal, b.fv_nama, a.fc_periode');	
	  $this->db->from('tm_transfer_stock a');
	  $this->db->join('tm_karyawan b','a.fc_kdkaryawan=b.fc_kdkaryawan','left outer');
	  $this->db->where('a.fc_faktur_transfer', $id);
	  $query = $this->db->get();
	  return $query->row();
	}

	public function getDataDetailKoreksi($id){
		$this->db->select('	a.fc_kdstock,
							a.fn_qty_sistem,
							a.fn_qty_aktual,
							a.fn_qty_selisih,
							a.fv_ket,
							g.fv_namastock,
							b.fv_nmtipe,
                            c.fv_nmbrand,
                            d.fv_nmgroup,
							f.fv_satuan');
        $this->db->from('td_koreksi_stok as a');
        $this->db->join('tm_stock as g','a.fc_kdstock=g.fc_kdstock','left outer');
        $this->db->join('tm_satuan as f','a.fc_kdsatuan=f.fc_kdsatuan','left outer');
		$this->db->join('tm_brand as c', 'a.fc_kdbrand = c.fc_kdbrand', 'left outer');
        $this->db->join('tm_group as d','a.fc_kdgroup=d.fc_kdgroup and a.fc_kdbrand=d.fc_kdbrand', 'left outer');
        $this->db->join('tm_tipe as b','a.fc_kdtipe=b.fc_kdtipe and a.fc_kdgroup=b.fc_kdgroup and a.fc_kdbrand=b.fc_kdbrand','left outer');
		$this->db->where('a.fc_notrans', $id);
		return $this->db->get();
	}

	public function getDataDetailTransfer($id){
		$this->db->select('	a.fc_kdstock,
							a.fn_jumlah_tujuan,
							h.fv_nmarea,
							i.fv_nmdivisi,
							a.fv_ket,
							g.fv_namastock,
							b.fv_nmtipe,
                            c.fv_nmbrand,
                            d.fv_nmgroup,
							f.fv_satuan');
        $this->db->from('td_transfer_stock as a');
        $this->db->join('tm_stock as g','a.fc_kdstock=g.fc_kdstock','left outer');
        $this->db->join('tm_satuan as f','a.fc_kdsatuan=f.fc_kdsatuan','left outer');
		$this->db->join('tm_brand as c', 'a.fc_kdbrand = c.fc_kdbrand', 'left outer');
        $this->db->join('tm_group as d','a.fc_kdgroup=d.fc_kdgroup and a.fc_kdbrand=d.fc_kdbrand', 'left outer');
        $this->db->join('tm_tipe as b','a.fc_kdtipe=b.fc_kdtipe and a.fc_kdgroup=b.fc_kdgroup and a.fc_kdbrand=b.fc_kdbrand','left outer');
        $this->db->join('tm_area h','a.fc_lokasi_area_tujuan=h.fc_kdarea','left outer');
        $this->db->join('tm_divisi i','a.fc_lokasi_divisi_tujuan=i.fc_kddivisi','left outer');
		$this->db->where('a.fc_faktur_transfer', $id);
		return $this->db->get();
	}

	public function get_koreksi_stock($id){
		$this->db->where('fc_notrans', $id);
		return $this->db->get('td_koreksi_stok')->result();
	}

	public function update_stock($where, $data) {
		$this->db->update('td_stock', $data, $where);
		return $this->db->affected_rows();
	}

	function get_count_transfer($fc_kdstock, $fc_kdarea, $fc_kddivisi){
		$this->db->select('count(*) as jml_ada');
		$this->db->from('td_stock');
		$this->db->where('fc_kdstock', $fc_kdstock);
		$this->db->where('fc_kdarea', $fc_kdarea);
		$this->db->where('fc_kddivisi', $fc_kddivisi);

		return $this->db->get()->row();
	}
	
}	