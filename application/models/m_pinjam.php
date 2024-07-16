<?php

class m_pinjam extends CI_Model
{
    function pinjam()
    {
        return $this->db->get('pinjam');
    }

    public function getBarang()
    {
        $query = $this->db->query("SELECT id_barang, nama_barang, COALESCE(stok, 0) AS stok FROM barang WHERE stok <> 0");

        if ($query->num_rows() == 0) {
            $query = [];
        } else {
            $query = $query->result_array();
        }


        return $query;
    }

    function tambah_pinjam()
    {
        return $this->db->get('pinjam');
    }

    public function proses_tambah($data)
    {
        return $this->db->insert($this->_table, $data);
    }

    function edit_data($id)
    {
        $query = $this->db->query("SELECT * FROM pinjam WHERE id_pinjam = '$id'");

        if ($query->num_rows() == 0) {
            $query = [];
        } else {
            $query = $query->row_array();
        }

        return $query;
    }

    public function ubah($data)
    {
        $this->db->set('nama_peminjam', $data['nama_peminjam']);
        $this->db->set('nama_penerima', $data['nama_penerima']);
        $this->db->set('nama_pemberi', $data['nama_pemberi']);
        $this->db->set('tgl_pinjam', $data['tgl_pinjam']);
        $this->db->set('tgl_kembali', $data['tgl_kembali']);
        $this->db->set('jam_pinjam', $data['jam_pinjam']);
        $this->db->set('jam_kembali', $data['jam_kembali']);
        $this->db->set('keterangan', $data['keterangan']);
        $this->db->where('id_pinjam', $data['id_pinjam']);

        return $this->db->update('pinjam');
    }

    public function hapus($id)
    {
        $this->db->where('id_pinjam', $id);
        return $this->db->delete('pinjam');
    }
}
