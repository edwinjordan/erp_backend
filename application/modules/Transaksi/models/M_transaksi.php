<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class M_transaksi extends CI_Model

{

	var $table  = 'transaksi_master';

	var $table1 = 'transaksi_akun';

    var $table2 = 'transaksi_nama_keuangan';

    //var $table = 't_bpbmst';
	var $column_order = array('a.fc_nobpb','a.fn_qtytot','a.fn_qtyretur','a.fd_tglbpbp','a.fm_total','b.fv_nama',null); //set column field database for datatable orderable
	var $column_search = array('a.fc_nobpb','a.fn_qtytot','a.fn_qtyretur','a.fd_tglbpbp','a.fm_total','b.fv_nama'); //set column field database for datatable searchable just title , author , category are searchable
    var $order = array('a.fc_nobpb' => 'asc'); // default order

    private function _get_datatables_query() {
		if ($_SERVER['REQUEST_METHOD'] == 'POST' && empty($_POST))
		$request = json_decode(file_get_contents('php://input'), true);
		
        $this->db->where('status_transaksi_master', '6');

		$this->db->or_where('status_transaksi_master', '7');

		$this->db->select('tgl_transaksi_master,
							status_transaksi_master,
						   nama_transaksi_akun,
						   nama_keuangan,
						   debit_transaksi_master,
						   kredit_transaksi_master,
						   keterangan_transaksi_master,
						   lampiran,
						   kode_transaksi_master,
						   no_faktur,
						   transaksi_master.kode_nama_keuangan,
						   DATE_FORMAT(tgl_transaksi_master, "%d-%m-%Y") as tanggal');

		$this->db->from($this->table);

		$this->db->join($this->table1, $this->table.'.no_faktur='.$this->table1.'.id_transaksi_akun','left outer');

		$this->db->join($this->table2, $this->table.'.kode_nama_keuangan='.$this->table2.'.kode_nama_keuangan','left outer');
		
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

    public function keuangan_transaksi_awal(){

		$this->db->where('status_transaksi_master', '6');

		$this->db->or_where('status_transaksi_master', '7');

		$this->db->select('tgl_transaksi_master,
							status_transaksi_master,
						   nama_transaksi_akun,
						   nama_keuangan,
						   debit_transaksi_master,
						   kredit_transaksi_master,
						   keterangan_transaksi_master,
						   lampiran,
						   kode_transaksi_master,
						   no_faktur,
						   transaksi_master.kode_nama_keuangan,
						   DATE_FORMAT(tgl_transaksi_master, "%d-%m-%Y") as tanggal,
						   fc_kdarea,
						   fc_kddivisi');

		$this->db->from($this->table);

		$this->db->join($this->table1, $this->table.'.no_faktur='.$this->table1.'.id_transaksi_akun','left outer');

		$this->db->join($this->table2, $this->table.'.kode_nama_keuangan='.$this->table2.'.kode_nama_keuangan','left outer');

		//$this->db->limit(10);

		$this->db->order_by('kode_transaksi_master', 'DESC');

		return $this->db->get();

	}
	
	public function jenis_tampil(){

		$this->db->where('kelompok_hitungan', '0');

		return $this->db->get($this->table1);

	}
	
	public function tampil_jenis_keuangan(){

		return $this->db->get($this->table2);

	}
	
	public function simpan_transaksi_keuangan_ubah($datainput){

		//$this->db->where('id_transaksi_akun', $datainput['nama_akun']);

		$ok = $this->db->get($this->table1)->row();

		$config['upload_path'] = realpath('./assets/images/');
		$config['allowed_types']        = 'gif|jpg|png';
		$config['max_size'] = '2000000000';
		
		$new_name = 'fotolampiran_'.time();
		$config['file_name'] = $new_name;
		$this->load->library('upload', $config);
		$this->upload->initialize($config);

		if(!$this->upload->do_upload('file-upload')){

			//$data['no_faktur'] = $datainput['nama_akun'];

			$data['keterangan_transaksi_master'] = $datainput['keterangan_transaksi'];

		//	$data['kode_nama_keuangan'] = $datainput['nama_keuangan'];
			if($datainput['debit_transaksi_master'] !=0){
				$data['debit_transaksi_master'] = $this->input->post('total');
			}else{
				$data['kredit_transaksi_master'] = $this->input->post('total');
			}

			//$data['kode_pegawai'] =  $datainput['dariAplikasi']? $datainput['id_karyawan'] : $this->session->userdata('id_karyawan');
		}else{
			$get_name = $this->upload->data();
			$nama_foto = $get_name['file_name'];
			$gambar1 = $nama_foto;

			//$data['no_faktur'] = $datainput['nama_akun'];

			$data['keterangan_transaksi_master'] = $datainput['keterangan_transaksi'];

			//$data['kode_nama_keuangan'] = $datainput['nama_keuangan'];
			if($datainput['debit_transaksi_master'] !=0){
				$data['debit_transaksi_master'] =$datainput['total'];
			}else{
				$data['kredit_transaksi_master'] = $datainput['total'];
			}

			//$data['kode_pegawai'] =  $datainput['dariAplikasi']? $datainput['id_karyawan'] : $this->session->userdata('id_karyawan');

			$data['lampiran'] =  $gambar1;
		}

		$this->db->where('kode_transaksi_master', $datainput['kode_transaksi_master']);

		$this->db->update($this->table, $data);

	}

	function getJenisTransaksi(){
    	return $this->db->get('transaksi_akun');
    }

    public function simpan_transaksi_keuangan($datainput){

		$this->db->where('id_transaksi_akun', $datainput['nama_akun']);

		$ok = $this->db->get($this->table1)->row();



		// if($ok->status_debit_kredit==2){

		// 	$data['debit_transaksi_master'] = $datainput['total'];

		// 	$data['kredit_transaksi_master'] = '0';

		// 	$data['status_transaksi_master'] = '6';

		// }else{

		// 	$data['debit_transaksi_master'] = '0';

		// 	$data['kredit_transaksi_master'] = $datainput['total'];

		// 	$data['status_transaksi_master'] = '7';

		// }

		$config['upload_path'] = realpath('./assets/images/');
		$config['allowed_types']        = 'gif|jpg|png';
		$config['max_size'] = '2000000000';
		// $config['max_width'] = '2024';
		// $config['max_height']= '1468';
		// $config['file_name'] = $nama_file;	
		
		$new_name = 'fotolampiran_'.time();
		$config['file_name'] = $new_name;
		$this->load->library('upload', $config);
		$this->upload->initialize($config);
		 
		if(!$this->upload->do_upload('file-upload')){
			if($datainput['pemasukan_transaksi']=="Pemasukan"){

				$data['debit_transaksi_master'] = $datainput['total'];
	
				$data['kredit_transaksi_master'] = '0';
	
				$data['status_transaksi_master'] = '6';

				$data['status_beban']	= 'N';
	
			}else{
	
				$data['debit_transaksi_master'] = '0';
	
				$data['kredit_transaksi_master'] = $datainput['total'];
	
				$data['status_transaksi_master'] = '7';

				$data['status_beban']	= 'Y';
	
			}
	
			$data['no_faktur'] = $datainput['nama_akun'];
	
			$data['tgl_transaksi_master'] = date('Y-m-d H:i:s');
	
			$data['keterangan_transaksi_master'] = $datainput['keterangan_transaksi'];
	
			$data['kode_nama_keuangan'] = $datainput['nama_keuangan'];
	
			$data['kode_pegawai'] =   $datainput['id_karyawan'];
			$data['fc_kdarea'] =   $datainput['fc_kdarea'];
			$data['fc_kddivisi'] =   $datainput['fc_kddivisi'];
		}else{
			//unlink('../assets/galeri/'.$this->input->post('terserah'));
			$get_name = $this->upload->data();
			$nama_foto = $get_name['file_name'];
			$gambar1 = $nama_foto;
		
			if($datainput['pemasukan_transaksi']=="pemasukan"){

				$data['debit_transaksi_master'] = $datainput['total'];

				$data['kredit_transaksi_master'] = '0';

				$data['status_transaksi_master'] = '6';

			}else{

				$data['debit_transaksi_master'] = '0';

				$data['kredit_transaksi_master'] = $datainput['total'];

				$data['status_transaksi_master'] = '7';

			}

			$data['no_faktur'] = $datainput['nama_akun'];

			$data['tgl_transaksi_master'] = date('Y-m-d H:i:s');

			$data['keterangan_transaksi_master'] = $datainput['keterangan_transaksi'];

			$data['kode_nama_keuangan'] = $datainput['nama_keuangan'];

			$data['kode_pegawai'] =  $datainput['id_karyawan'];
			$data['fc_kdarea'] =   $datainput['fc_kdarea'];
			$data['fc_kddivisi'] =   $datainput['fc_kddivisi'];

			$data['lampiran'] =  $gambar1;
		}	

		$this->db->insert($this->table, $data);
		//print_r($this->db->last_query());

		if($datainput['pemasukan_transaksi']=="Pemasukan"){
			$this->db->where('kode_nama_keuangan',$datainput['nama_keuangan']);
			$this->db->from('transaksi_nama_keuangan');
								//teko kenen
			$hasilnya2=$this->db->get()->result_array();

			$saldo_uang = $hasilnya2[0]['saldo_keuangan'] + $datainput['total'];

			$data_saldo['saldo_keuangan'] = $saldo_uang;
			$this->db->where('kode_nama_keuangan',$datainput['kode_nama_keuangan']);
			$this->db->update('transaksi_nama_keuangan', $data_saldo);
		}else{
			$this->db->where('kode_nama_keuangan',$datainput['nama_keuangan']);
			$this->db->from('transaksi_nama_keuangan');
								//teko kenen
			$hasilnya2=$this->db->get()->result_array();

			$saldo_uang = $hasilnya2[0]['saldo_keuangan'] - $datainput['total'];

			$data_saldo['saldo_keuangan'] = $saldo_uang;
			$this->db->where('kode_nama_keuangan',$datainput['kode_nama_keuangan']);
			$this->db->update('transaksi_nama_keuangan', $data_saldo);
		}	

	}
	
}    