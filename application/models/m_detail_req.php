<?php 
 
class M_detail_req extends CI_Model{

    /* function tampil_request()
    {
        return $this->db->get('detail_request');
    } */

	function tampil_request()
    {
       //return $this->db->get('detail_barang');
        $query = $this->db->query("SELECT det.id_detail_request, det.nama_barang_request, det.jumlah_request, det.keterangan, det.id_barang, det.serial_code, det.jumlah, det.tanggal_waktu, det.status 
        FROM detail_request det INNER JOIN barang b ON det.id_barang = b.id_barang"); //WHERE det.id_barang = '$id'
        
        if ($query->num_rows() == 0) {
            $query = [];
        } else {
            $query = $query->result_array();
        }

        return $query;
    }
	
	function tampil_datarequest(){
       return $this->db->get('detail_request');
       $query = $this->db->query("SELECT det.id_detail_request, det.nama_barang_request, det.jumlah_request, det.keterangan, det.id_barang, det.serial_code, det.jumlah, det.tanggal_waktu, det.status 
        FROM detail_request det INNER JOIN barang b ON det.id_barang = b.id_barang");
        
        if ($query->num_rows() == 0) {
            $query = [];
        } else {
            $query = $query->result_array();
        }

        return $query;
    }
	
    /* function tampil_datarequest(){
        return $this->db->get('detail_request');
    } */

	public function getseri()
	{
    $query = $this->db->query("SELECT * FROM detail_barang ORDER BY serial_code ASC");
	//$query = $this->db->query("SELECT id_barang, nama_barang, COALESCE(stok, 0) AS stok FROM barang WHERE stok <> 0");

    if ($query->num_rows() == 0) {
        $query = [];
    } else {
        $query = $query->result_array();
    }

    return $query;
	}

    function edit_request($id)
    { 
        $query = $this->db->query("SELECT * FROM detail_request WHERE id_detail_request = '$id'");

        if ($query->num_rows() == 0) {
            $query = [];
        } else {
            $query = $query->row_array();
        }

        return $query;
    }

    public function ubah_request($data)
    {
        //$this->db->set('nama_barang_request', $data['nama_barang_request']);
        $this->db->set('jumlah_request', $data['jumlah_request']);
        $this->db->set('keterangan', $data['keterangan']);
        $this->db->set('id_barang', $data['id_barang']);
        $this->db->set('serial_code', $data['serial_code']);
        $this->db->set('jumlah', $data['jumlah']);
        //$this->db->set('tanggal_waktu', $data['tanggal_waktu']);
        $this->db->set('status', $data['status']);
        $this->db->where('id_detail_request', $data['id_detail_request']);

        return $this->db->update('detail_request');
    }

    function update_data_detail($where,$data,$table){
        $this->db->where($where);
        $this->db->update($table,$data);
    } 

    public function hapus_request($id)
    {
        $this->db->where('id_detail_request', $id);
        return $this->db->delete('detail_request');
    }
}