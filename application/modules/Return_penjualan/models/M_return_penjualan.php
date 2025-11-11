<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class M_return_penjualan extends CI_Model {

    function get_pembayaran_hutang_tampiloke3($no_faktur=null, $faktur=null){
        $this->db->join('t_customer','tm_invoice.fc_kdcust=t_customer.fc_kdcust','left outer');
        if($no_faktur!=""){
          $this->db->where('tm_invoice.fc_nofaktur',$no_faktur);
        }
        $this->db->where("STR_TO_DATE(fd_tglinput, '%Y-%m-%d') > NOW() - INTERVAL 30 DAY");
        return $this->db->get('tm_invoice');
    }
    
    public function tampil_jenis_keuangan(){
		  return $this->db->get('transaksi_nama_keuangan');
    }

    public function get_nota_print_barang_penjualane3($where){
      $this->db->select('a.fc_nofaktur');
      $this->db->select('a.fn_idpenjualan');
      $this->db->select('a.fc_kdstock');
      $this->db->select('a.fc_barcode');
      $this->db->select('a.fc_kdtipe');
      $this->db->select('a.fc_kdbrand');
      $this->db->select('a.fc_kdgroup');
      $this->db->select('a.fc_kdsatuan');
      $this->db->select('a.fn_id');
      $this->db->select('a.fm_price');
      $this->db->select('a.fn_qty');
      $this->db->select('a.fm_subtot');
      $this->db->select('a.fc_kdarea');
      $this->db->select('a.fc_kddivisi');
      $this->db->select('b.fv_namastock');
      $this->db->select('c.fv_nmtipe');
      $this->db->select('d.fv_nmbrand');
      $this->db->select('e.fv_nmgroup');
      $this->db->select('f.fv_satuan');
      $this->db->select('p.fc_kdcust');
      $this->db->select('p.fd_tglinput');
      $this->db->select('p.fc_kdkaryawan');

      $this->db->from('td_invoice a');
      $this->db->join('tm_invoice p','a.fc_nofaktur=p.fc_nofaktur','left outer');
      $this->db->join('tm_stock b','a.fc_kdstock=b.fc_kdstock','left outer');
      $this->db->join('tm_satuan f','a.fc_kdsatuan=f.fc_kdsatuan','left outer');
      $this->db->join('tm_brand d', 'a.fc_kdbrand = d.fc_kdbrand', 'left outer');
      $this->db->join('tm_group e','a.fc_kdgroup=e.fc_kdgroup and a.fc_kdbrand=e.fc_kdbrand', 'left outer');
      $this->db->join('tm_tipe c','a.fc_kdtipe=c.fc_kdtipe and a.fc_kdgroup=c.fc_kdgroup and a.fc_kdbrand=c.fc_kdbrand','left outer');

      $this->db->where('a.fn_idpenjualan',$where);
      //$this->db->group_by('fc_nofaktur');
      $query = $this->db->get();
      return $query->result();
    }  

    public function get_nama_barang($fc_kdstock,$fn_idpenjualan){
      $this->db->select('
        a.fn_id, 
        a.fc_kdstock, 
        a.fc_nofaktur, 
        a.fn_qty,
        a.fc_nofaktur, 
        a.fm_price,
        b.fm_hargajual');
      $this->db->where('a.fc_kdstock', $fc_kdstock);
      $this->db->where('a.fn_idpenjualan', $fn_idpenjualan);
      $this->db->join('tm_stock b','a.fc_kdstock=b.fc_kdstock','left outer');
      //$this->db->group_by('detail_penjualan.id_barang,detail_penjualan.harga_jual,varian_harga.kode_satuan');
      return $this->db->get('td_invoice a');
    }

    function get_pembayaran_hutang_tampiloke33(){
      $this->db->select('
        tm_invoice.fc_nofaktur,
        DATE_FORMAT(tm_invoice.fd_tglinput, "%d-%m-%Y") as tanggal, 
        t_customer.fv_nama, 
        t_customer.fc_kota,
        t_customer.fv_alamat,
        t_customer.fc_notelp,
        tm_invoice.fc_kdcust,
        tm_invoice.fc_kdkaryawan,
        tm_invoice.fn_idpenjualan,
        td_invoice.fc_kddivisi,
        td_invoice.fc_kdarea'
      );
      $this->db->join('t_customer',
        'tm_invoice.fc_kdcust = t_customer.fc_kdcust',
        'left outer');
      $this->db->join('td_invoice',
        'tm_invoice.fc_nofaktur = td_invoice.fc_nofaktur',
        'left outer');  
      // $this->db->like('penjualan.no_faktur',$no_faktur);
     // $this->db->where("STR_TO_DATE(fd_tglinput, '%Y-%m-%d') > NOW() - INTERVAL 30 DAY");
      $this->db->where('fm_selisih NOT LIKE ', '-%');
      $this->db->order_by('fd_tglinput','DESC');
      return $this->db->get('tm_invoice');
    }

    function get_penjualan($no_faktur){
      $this->db->where('fc_nofaktur', $no_faktur);
      return $this->db->get('tm_invoice');
    }

    function get_detail_penjualan($id){
      $this->db->where('fn_id', $id);
      return $this->db->get('td_invoice');
    }

    function get_lokasi($fc_kdstock, $fc_kdarea, $fc_kddivisi){
      $this->db->where('fc_kdstock', $fc_kdstock);
      $this->db->where('fc_kdarea', $fc_kdarea);
      $this->db->where('fc_kddivisi', $fc_kddivisi);
      return $this->db->get('td_stock');
    }

    function update_stok($where, $id){
      return $this->db->update('td_stock',$where,$id);
    }

    function get_transaksi_keuangan($kode_keuangan){
      $this->db->where('kode_nama_keuangan',$kode_keuangan);
      return $this->db->get('transaksi_nama_keuangan');
    }

    function update_saldo_keuangan($where, $id){
      return $this->db->update('transaksi_nama_keuangan',$where,$id);
    }

}    