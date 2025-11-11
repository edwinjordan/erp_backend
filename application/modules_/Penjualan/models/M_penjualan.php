<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_penjualan extends CI_Model {

    public function ambilBarang()
    {


            $this->db->select('	a.fc_kdstock,
                                a.fc_barcode,
                                a.fv_namastock,
                                a.fc_kdtipe,
                                a.fc_kdbrand,
                                a.fc_kdgroup,
                                a.fm_hargajual,
                                a.fc_kdsatuan,
                                b.fv_nmbrand,
                                c.fv_nmgroup,
                                d.fv_nmtipe,
                                e.fv_satuan,
                                f.fn_qty');
            $this->db->from('tm_stock as a');
            $this->db->join('tm_brand as b', 'a.fc_kdbrand = b.fc_kdbrand', 'left outer');
            $this->db->join('tm_group as c', 'a.fc_kdgroup = c.fc_kdgroup and a.fc_kdbrand=c.fc_kdbrand', 'left outer');
            $this->db->join('tm_tipe as d','a.fc_kdtipe=d.fc_kdtipe and a.fc_kdgroup=d.fc_kdgroup and a.fc_kdbrand=d.fc_kdbrand', 'left outer');
            $this->db->join('tm_satuan as e','a.fc_kdsatuan=e.fc_kdsatuan','left outer');
            $this->db->join('td_stock f','a.fc_kdstock=f.fc_kdstock','left outer');
            $this->db->where('f.fn_qty > 0');

            $barang = $this->db->get();
            
            if($barang->num_rows() > 0){
                $json['status'] 	= 1;
                foreach($barang->result() as $b)
                {
                    $json['datanya'][] = $b;
                }
                $json['jumlah_barang'] = count($barang->result());
            }
            else
            {
                $json['status'] 	= 0;
            }

            echo json_encode($json);

    }

}