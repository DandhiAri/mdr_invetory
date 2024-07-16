<?php 
 
class M_replace extends CI_Model{

//replace//
function tampil_replace(){
    return $this->db->get('ganti');
 }
 function tampil_datareplace(){
   return $this->db->get('ganti');
}
public function getid()
{
    $query = $this->db->query("SELECT * FROM barang ORDER BY nama_barang ASC");

        if ($query->num_rows() == 0) {
            $query = [];
        } else {
            $query = $query->result_array();
        }

        return $query;
}
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

function tambah_data_replace($data){
    return $this->db->insert($this->_table->$data);
    }
    function edit_replace($id)
    {
        $query = $this->db->query("SELECT * FROM ganti WHERE id_replace = '$id'");
    
        if ($query->num_rows() == 0) {
            $query = [];
        } else {
            $query = $query->row_array();
        }
    
        return $query;
    }
    
    public function edit($data)
    {
        $this->db->set('nama', $data['nama']);
        $this->db->set('tgl_replace', $data['tgl_replace']);
        $this->db->set('jumlah', $data['jumlah']);
		$this->db->set('id_barang', $data['id_barang']);
		$this->db->set('serial_code', $data['serial_code']);
		$this->db->set('qty', $data['qty']);
		$this->db->set('status', $data['status']);
        $this->db->set('keterangan', $data['keterangan']);
        $this->db->where('id_replace', $data['id_replace']);
    
        return $this->db->update('ganti');
    }
    
    public function hapus_replace($id)
    {
        $this->db->where('id_replace', $id);
        return $this->db->delete('ganti');
    }
}

