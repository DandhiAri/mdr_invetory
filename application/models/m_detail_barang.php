<?php 
 
class M_detail_barang extends CI_Model{

	function tampil_datadetail($id, $limit=null, $start=null){
		$this->db->select('detail_barang.*, barang.nama_barang');
		$this->db->from('detail_barang');
		$this->db->join('barang', 'detail_barang.id_barang = barang.id_barang');
		$this->db->where('detail_barang.id_barang', $id);
		$this->db->limit($limit, $start);
		$query = $this->db->get();
		return $query;
    }

	public function count_all_detail_barang($id_barang) {
        $this->db->where('id_barang', $id_barang);
        return $this->db->count_all_results('detail_barang');
    }

    public function get_detail_barang_paginated($id_barang, $page, $limit) {
        $this->db->where('id_barang', $id_barang);
        $this->db->limit($limit, $page);
        $query = $this->db->get('detail_barang');
        return $query->result();
    }
	
    public function getBarang()
    {
        $query = $this->db->query("SELECT * FROM barang ORDER BY nama_barang ASC");

        if ($query->num_rows() == 0) {
            $query = [];
        } else {
            $query = $query->result_array();
        }

        return $query;
    }

    function edit_detail($id)
    { 
		
        $query = $this->db->query("SELECT * FROM detail_barang WHERE id_detail_barang = '$id'");
        if ($query->num_rows() == 0) {
            $query = [];
			
        } else {
            $query = $query->row_array();
        }

        return $query;
    }

    public function ubah_detail($data)
    {
        $this->db->set('id_barang', $data['id_barang']);
        $this->db->set('serial_code', $data['serial_code']);
        $this->db->set('lokasi', $data['lokasi']);
        $this->db->set('qtty', $data['qtty']);
        $this->db->where('id_detail_barang', $data['id_detail_barang']);

        return $this->db->update('detail_barang');
    }

    function update_data_detail($where,$data,$table){
        $this->db->where($where);
        $this->db->update($table,$data);
    } 

   public function hapus_detail($id)
    {
        $this->db->where('id_detail_barang', $id);
        return $this->db->delete('detail');
    } 

    public function is_serial_code_unique($serial_code) {
        $query = $this->db->get_where('detail_barang', array('serial_code' => $serial_code));
		return $query->num_rows() == 0;
    }
}
