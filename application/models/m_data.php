<?php 
 
class M_data extends CI_Model{

    function tampil_data(){
        return $this->db->get('barang');
    }
	public function getJenis()
    {
        $query = $this->db->query("SELECT * FROM jenis ORDER BY nama_jenis ASC");

        if ($query->num_rows() == 0) {
            $query = [];
        } else {
            $query = $query->result_array();
        }


        return $query;
    }
	public function getSatuan()
    {
        $query = $this->db->query("SELECT * FROM satuan ORDER BY nama_satuan ASC");

        if ($query->num_rows() == 0) {
            $query = [];
        } else {
            $query = $query->result_array();
        }


        return $query;
    }

    function tampil_databarang(){
        return $this->db->get('barang');
    }

    public function tambah_ubah($data)
    {
        return $this->db->insert($this->_table, $data);
    }

    function edit_data($id)
    { 
        $query = $this->db->query("SELECT * FROM barang WHERE id_barang = '$id'");

        if ($query->num_rows() == 0) {
            $query = [];
        } else {
            $query = $query->row_array();
        }

        return $query;
    }

    public function ubah($data)
    {
        $this->db->set('nama_barang', $data['nama_barang']);
        $this->db->set('stok', $data['stok']);
        // $this->db->set('satuan_id', $data['satuan_id']);
        // $this->db->set('jenis_id', $data['jenis_id']);
        $this->db->where('id_barang', $data['id_barang']);

        return $this->db->update('barang');
    }

    function update_data($where,$data,$table){
        $this->db->where($where);
        $this->db->update($table,$data);
    } 
    
    public function hapus($id)
    {
        $this->db->where('id_barang', $id);
        return $this->db->delete('barang');
    }

// REQUEST
    function tampil_request()
    {
        return $this->db->get('request');
    }

    function tampil_datarequest(){
        return $this->db->get('request');
    }

    function edit_request($id)
    { 
        $query = $this->db->query("SELECT * FROM request WHERE id_request = '$id'");

        if ($query->num_rows() == 0) {
            $query = [];
        } else {
            $query = $query->row_array();
        }

        return $query;
    }

    public function ubah_request($data)
    {
        $this->db->set('nama', $data['nama']);
        $this->db->set('tgl_request', $data['tgl_request']);
        $this->db->set('id_barang', $data['id_barang']);
        $this->db->set('jumlah', $data['jumlah']);
        $this->db->set('keterangan', $data['keterangan']);
        $this->db->where('id_request', $data['id_request']);

        return $this->db->update('request');
    }

    function update_data_request($where,$data,$table){
        $this->db->where($where);
        $this->db->update($table,$data);
    } 

    public function hapus_request($id)
    {
        $this->db->where('id_request', $id);
        return $this->db->delete('request');
    }
    
    public function count($table)
    {
        return $this->db->count_all($table);
    }
}