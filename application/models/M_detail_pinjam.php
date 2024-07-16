<?php

class M_detail_pinjam extends CI_Model
{
	  public function getBarang()
    {
        $query = $this->db->query("SELECT * FROM detail_barang ORDER BY id_detail_barang ASC");

        if ($query->num_rows() == 0) {
            $query = [];
        } else {
            $query = $query->result_array();
        }

        return $query;
    }
	public function getSeri()
    {
        $query = $this->db->query("SELECT * FROM detail_barang ORDER BY serial_code ASC");

        if ($query->num_rows() == 0) {
            $query = [];
        } else {
            $query = $query->result_array();
        }

        return $query;
    }
	public function getItemDescription()
    {
        $query = $this->db->query("SELECT * FROM detail_barang ORDER BY id_detail_barang ASC");

        if ($query->num_rows() == 0) {
            $query = [];
        } else {
            $query = $query->result_array();
        }

        return $query;
    }

    function tampil_detail()
    {
        //return $this->db->get('detail_pinjam');
		$query = $this->db->query("SELECT * 
									FROM detail_pinjam dpm 
									INNER JOIN pinjam p ON dpm.id_pinjam = p.id_pinjam 
									INNER JOIN detail_barang b ON dpm.id_detail_barang=b.id_detail_barang " );
		if ($query->num_rows() == 0) {
            $query = [];
        } else {
            $query = $query->result_array();
        }

        return $query;
    }
    function tambah_detail($id)
    {
        return $this->db->get('detail_pinjam');
		$query = $this->db->query("SELECT dpm.id_detail_pinjam, dpm.id_pinjam, dpm.id_detail_barang, dpm.keterangan FROM detail_pinjam dpm INNER JOIN pinjam p ON dpm.id_pinjam = p.id_pinjam INNER JOIN detail_barang b ON dpm.id_detail_barang=b.id_detail_barang");
		if ($query->num_rows() == 0) {
            $query = [];
        } else {
            $query = $query->result_array();
        }

        return $query;
    }
    public function tambah_ubah($data)
    {
        return $this->db->insert($this->_table, $data);
    }
    public function edit_data($id)
    {
        $query = $this->db->query("SELECT * FROM detail_pinjam WHERE id_detail_pinjam = '".$id."' ");

        if ($query->num_rows() == 0) {
            $query = [];
			
        } else {
		
            $query = $query->row_array();
			
        }
		
		//echo $query->num_rows();

        return $query;
    }

public function ubah($data)
{
    $this->db->set('id_detail_barang', $data['id_detail_barang']);
    $this->db->set('keterangan', $data['keterangan']);

    $this->db->where('id_pinjam', $data['id_pinjam']);

    return $this->db->update('detail_pinjam');
}

    public function hapus($id)
    {
        $this->db->where('id_pinjam', $id);
        return $this->db->delete('detail_pinjam');
    }
}
