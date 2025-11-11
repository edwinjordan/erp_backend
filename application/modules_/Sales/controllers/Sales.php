<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Sales extends MY_Admin {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_sales');
    } 

    function ajax_get_list_sales(){
        $bindings = array();
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && empty($_POST))
        $request = json_decode(file_get_contents('php://input'), true);
        $data = $this->M_sales->get_datatables();
    	$output = array(
                        "draw" => isset ( $request['draw'] ) ?
                        intval( $request['draw'] ) :
                        0,
                        "recordsTotal" => $this->M_sales->count_all(),
                        "recordsFiltered" => $this->M_sales->count_filtered(),
                        "data" => $data,
				);
        echo json_encode($output);
    }

    function limit ( $request, $columns )
	{
		$limit = '';

		if ( isset($request['start']) && $request['length'] != -1 ) {
			$limit = "LIMIT ".intval($request['start']).", ".intval($request['length']);
		}

		return $limit;
    }
    
    function order ( $request, $columns )
	{
		$order = '';

		if ( isset($request['order']) && count($request['order']) ) {
			$orderBy = array();
			$dtColumns = $this->pluck( $columns, 'dt' );

			for ( $i=0, $ien=count($request['order']) ; $i<$ien ; $i++ ) {
				// Convert the column index into the column data property
				$columnIdx = intval($request['order'][$i]['column']);
				$requestColumn = $request['columns'][$columnIdx];

				$columnIdx = array_search( $requestColumn['data'], $dtColumns );
				$column = $columns[ $columnIdx ];

				if ( $requestColumn['orderable'] == 'true' ) {
					$dir = $request['order'][$i]['dir'] === 'asc' ?
						'ASC' :
						'DESC';

					$orderBy[] = '`'.$column['db'].'` '.$dir;
				}
			}

			$order = 'ORDER BY '.implode(', ', $orderBy);
		}

		return $order;
    }
    
    function filter ( $request, $columns, &$bindings )
	{
		$globalSearch = array();
		$columnSearch = array();
		$dtColumns = $this->pluck( $columns, 'dt' );

		if ( isset($request['search']) && $request['search']['value'] != '' ) {
			$str = $request['search']['value'];

			for ( $i=0, $ien=count($request['columns']) ; $i<$ien ; $i++ ) {
				$requestColumn = $request['columns'][$i];
				$columnIdx = array_search( $requestColumn['data'], $dtColumns );
				$column = $columns[ $columnIdx ];

				if ( $requestColumn['searchable'] == 'true' ) {
					$binding = $this->bind( $bindings, '%'.$str.'%', PDO::PARAM_STR );
					$globalSearch[] = "`".$column['db']."` LIKE ".$binding;
				}
			}
		}

		// Individual column filtering
		if ( isset( $request['columns'] ) ) {
			for ( $i=0, $ien=count($request['columns']) ; $i<$ien ; $i++ ) {
				$requestColumn = $request['columns'][$i];
				$columnIdx = array_search( $requestColumn['data'], $dtColumns );
				$column = $columns[ $columnIdx ];

				$str = $requestColumn['search']['value'];

				if ( $requestColumn['searchable'] == 'true' &&
				 $str != '' ) {
					$binding = $this->bind( $bindings, '%'.$str.'%', PDO::PARAM_STR );
					$columnSearch[] = "`".$column['db']."` LIKE ".$binding;
				}
			}
		}

		// Combine the filters into a single string
		$where = '';

		if ( count( $globalSearch ) ) {
			$where = '('.implode(' OR ', $globalSearch).')';
		}

		if ( count( $columnSearch ) ) {
			$where = $where === '' ?
				implode(' AND ', $columnSearch) :
				$where .' AND '. implode(' AND ', $columnSearch);
		}

		if ( $where !== '' ) {
			$where = 'WHERE '.$where;
		}

		return $where;
    }
    
    static function bind ( &$a, $val, $type )
	{
		$key = ':binding_'.count( $a );

		$a[] = array(
			'key' => $key,
			'val' => $val,
			'type' => $type
		);

		return $key;
    }
    
    static function pluck ( $a, $prop )
	{
		$out = array();

		for ( $i=0, $len=count($a) ; $i<$len ; $i++ ) {
			$out[] = $a[$i][$prop];
		}

		return $out;
	}


    function api(){
         $data = $this->M_sales->get_data_sales();
		
        echo json_encode($data);
    }

    function get_data_departement(){
        $data = $this->M_sales->get_data_departement();
		
        echo json_encode($data);
    }

    public function ajax_get_kode_sales(){
        $data = $this->M_sales->where_max()->row();
        //print_r($this->db->last_query());
        $json['maxs'] = @$data->maxs;
        echo json_encode($json);
    }

    public function ajax_add_sales(){
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Request-Headers: GET,POST,OPTIONS,DELETE,PUT");
        header("Access-Control-Allow-Headers: authorization, Content-Type");
		
    
		$fc_salesid = $this->input->post('fc_salesid');
		$fv_nama = $this->input->post('fv_nama');
		$fc_email = $this->input->post('fc_email');		
		$fc_hp = $this->input->post('fc_hp');
		
        $fc_aktif = $this->input->post('fc_aktif');
        $fd_tglaktif = date('Y-m-d');
        $fd_tgllahir = $this->input->post('fd_tgllahir');
		$f_deptid = $this->input->post('f_deptid');
		$date_time_Obj = date_create($fd_tgllahir);
		//formatting the date/time object
		$format = date_format($date_time_Obj, "Y-m-d");
		//print('aaa'.$f_deptid);
        $DataSales = array(
                'fc_salesid' => $fc_salesid,
                'fv_nama' => $fv_nama,
                'fc_email' => $fc_email,
                'fc_hp' => $fc_hp,
                'fc_aktif' => $fc_aktif,
                'fd_tglaktif' => $fd_tglaktif,
                'fd_tgllahir' => $format,
                'f_deptid' => $f_deptid
        );
		//print_r('aaa'.$DataSales);
             $id = $this->M_sales->insertSales($DataSales);
            //print_r($this->db->last_query());  
  
           
			$result['success'] = true;
			return die(json_encode($result));
        
	}
	
	public function ajax_get_by_id($id)
	{
		header("Access-Control-Allow-Origin: *");
		header("Access-Control-Allow-Headers: authorization, Content-Type");


		$blog = $this->M_sales->get_by_id2($id);

		$post = array(
			'fc_salesid' => $blog->fc_salesid,
			'fv_nama' => $blog->fv_nama,
			'fc_email' => $blog->fc_email,
			'fc_hp' => $blog->fc_hp,
			'fc_aktif' => $blog->fc_aktif,
			'fd_tglaktif' => $blog->fd_tglaktif,
			'fd_tgllahir' => $blog->fd_tgllahir,
			'f_deptid' => $blog->f_deptid
		);
		

		$this->output
			->set_status_header(200)
			->set_content_type('application/json')
			->set_output(json_encode($post)); 
		
	}

	public function ajax_edit_post($id){
		header("Access-Control-Allow-Origin: *");
		header("Access-Control-Allow-Headers: authorization, Content-Type");
		header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");

		$fc_salesid = $this->input->post('fc_salesid');
		$fv_nama = $this->input->post('fv_nama');
		$fc_email = $this->input->post('fc_email');		
		$fc_hp = $this->input->post('fc_hp');
		
        $fc_aktif = $this->input->post('fc_aktif');
        $fd_tglaktif = date('Y-m-d');
        $fd_tgllahir = $this->input->post('fd_tgllahir');
		$f_deptid = $this->input->post('f_deptid');
		
		$date_time_Obj = date_create($fd_tgllahir);
		//formatting the date/time object
		$format = date_format($date_time_Obj, "Y-m-d");
		//print('aaa'.$f_deptid);
        $DataSales = array(
                'fc_salesid' => $fc_salesid,
                'fv_nama' => $fv_nama,
                'fc_email' => $fc_email,
                'fc_hp' => $fc_hp,
                'fc_aktif' => $fc_aktif,
                'fd_tglaktif' => $fd_tglaktif,
                'fd_tgllahir' => $format,
                'f_deptid' => $f_deptid
		);
		
		$this->M_sales->updateSales($fc_salesid, $DataSales);

		$result['success'] = true;
		return die(json_encode($result));
	}

	public function ajax_delete($id)
	{
	  header('Access-Control-Allow-Origin: *');
	  header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
	  header("Access-Control-Allow-Headers: authorization, Content-Type");
  
	 
	  //if($id){
	  $this->M_sales->deleteSales(@$id);
  
	  $response = array(
			'status' => 'success'
	  );
	
	  $this->output
			->set_status_header(200)
			->set_content_type('application/json')
			->set_output(json_encode($response)); 
	   // }
  
	   
	}

}   