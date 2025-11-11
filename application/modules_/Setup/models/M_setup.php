<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_setup extends CI_Model {


	public function get_by_id() {
        $this->db->select('a.fc_isi as set_data_id,
                           b.fc_isi as set_data_id2,
                           c.fc_isi as set_data_id3,
                           d.fc_isi as set_data_id4,
                           e.fc_isi as set_data_id5,
                           f.fc_isi as set_data_id6
                           ');
		$this->db->from('t_setup a');
		$this->db->join('t_setup b ', 'b.fc_param="TELP"', 'left outer');
    $this->db->join('t_setup c ', 'c.fc_param="EMAIL"', 'left outer');
    $this->db->join('t_setup d ', 'd.fc_param="ALAMAT"', 'left outer');
    $this->db->join('t_setup e ', 'e.fc_param="TENTANG"', 'left outer');
    $this->db->join('t_setup f ', 'f.fc_param="KONTAK"', 'left outer');
		$this->db->where('a.fc_param','LOGO1');

		$query = $this->db->get();
		return $query->row();
    }

    public function get_by_en(){
      $this->db->select('
            a.fc_isi_en as set_data_id,
            b.fc_isi_en as set_data_id2,
            c.fc_isi_en as set_data_id3,
            d.fc_isi_en as set_data_id4
            ');
      $this->db->from('t_setup a');
      $this->db->join('t_setup b ', 'b.fc_param="Menu2"', 'left outer');
      $this->db->join('t_setup c ', 'c.fc_param="Menu3"', 'left outer');
      $this->db->join('t_setup d ', 'd.fc_param="Menu4"', 'left outer');
      $this->db->where('a.fc_param','Menu1');

      $query = $this->db->get();
      return $query->row();
    }

    public function get_by_jp(){
      $this->db->select('
            a.fc_isi_jp as set_data_id,
            b.fc_isi_jp as set_data_id2,
            c.fc_isi_jp as set_data_id3,
            d.fc_isi_jp as set_data_id4
            ');
      $this->db->from('t_setup a');
      $this->db->join('t_setup b ', 'b.fc_param="Menu2"', 'left outer');
      $this->db->join('t_setup c ', 'c.fc_param="Menu3"', 'left outer');
      $this->db->join('t_setup d ', 'd.fc_param="Menu4"', 'left outer');
      $this->db->where('a.fc_param','Menu1');

      $query = $this->db->get();
      return $query->result();
    }

    public function update_link($data1,$where) {
      $this->db->update('t_setup', $data1, $where);
      return $this->db->affected_rows();
    }

    public function updateSetup($id, $blogData)
    {
      $this->db->where('fc_param', $id);
      $this->db->update('t_setup', $blogData);
    }
}    