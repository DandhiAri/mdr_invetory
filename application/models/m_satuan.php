<?php

class M_satuan extends CI_Model
{
	public function getSatuan($keyword=null, $limit, $start) {
		$this->db->select('satuan.*');
		$this->db->from('satuan');
		if ($keyword) {
			$this->db->or_like('satuan.nama_satuan', $keyword);
		}
		$this->db->group_by('satuan.id_satuan');
		$this->db->limit($limit, $start); 
		$query = $this->db->get();
		return $query->result();
	}
    function tampil_satuan()
    {
        return $this->db->get('satuan');
    }

    function tampil_datasatuan()
    {
        return $this->db->get('satuan');
    }
    public function tambah_ubah($data)
    {
        return $this->db->insert($this->_table, $data);
    }

    function edit_data($id)
    {
        $query = $this->db->query("SELECT * FROM satuan WHERE id_satuan = '$id'");

        if ($query->num_rows() == 0) {
            $query = [];
        } else {
            $query = $query->row_array();
        }

        return $query;
    }

    public function ubah($data)
    {
        $this->db->set('nama_satuan', $data['nama_satuan']);
        $this->db->where('id_satuan', $data['id_satuan']);

        return $this->db->update('satuan');
    }

    public function hapus($id)
    {
        $this->db->where('id_satuan', $id);
        return $this->db->delete('satuan');
    }
}
