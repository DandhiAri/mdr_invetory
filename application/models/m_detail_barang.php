<?php 
 
class M_detail_barang extends CI_Model{

    function tampil_detail()
    {
       //return $this->db->get('detail_barang');
        $query = $this->db->query("SELECT det.id_detail_barang, b.nama_barang, det.serial_code, det.lokasi, det.qtty 
        FROM detail_barang det 
        INNER JOIN barang b ON det.id_barang = b.id_barang 
         "); //WHERE det.id_barang = '$id'
        
        if ($query->num_rows() == 0) {
            $query = [];
        } else {
            $query = $query->result_array();
        }

        return $query;
    }

    function tampil_datadetail(){
       return $this->db->get('detail_barang');
       $query = $this->db->query("SELECT det.id_detail_barang, b.nama_barang, det.serial_code, det.lokasi, det.qtty FROM detail_barang det INNER JOIN barang b ON det.id_barang = b.id_barang");
        
        if ($query->num_rows() == 0) {
            $query = [];
        } else {
            $query = $query->result_array();
        }

        return $query;
    } 

    public function getBarang()
    {
        $query = $this->db->query("SELECT * FROM barang ORDER BY nama_barang ASC");
        // $query = $this->db->query("SELECT id_barang, nama_barang, COALESCE(stok, 0) AS stok FROM barang WHERE stok <> 0");

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
		//$query = $this->db->query("SELECT det.id_detail_barang, b.nama_barang, det.serial_code, det.lokasi, det.qtty FROM detail_barang det INNER JOIN barang b ON det.id_barang = b.id_barang");
		//$query = $this->db->qRead("SELECT detail_barang a INNER JOIN barang b on a.id_barang = b.id_barang  where a.id_detail_barang = '".$id."'", "a.id_detail_barang, a.id_barang, b.nama_barang, a.serial_code, a.lokasi,a.qtty");
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
    
}