<?php 
 
class M_dashboard extends CI_Model{
    public function count($table)
    {
        return $this->db->count_all($table);
    }
    function pjm() 
    {
        $this->db->select('*');
        $this->db->form('pinjam');
        $this->db->where('id_pinjam');

        return $this->db->get()->num_rows();
    }

    function rqes($id) 
    {
        // $this->db->select('*');
        // $this->db->form('request');
        // $this->db->where('id_request');

        // return $this->db->get()->num_rows();
        $query = $this->db->query("SELECT * FROM request WHERE id_request = '$id'");

        if ($query->num_rows() == 0) {
            $query = [];
        } else {
            $query = $query->row_array();
        }

        return $query;
    }

    function rpc() 
    {
        $this->db->select('*');
        $this->db->form('replace');
        $this->db->where('id_replace');

        return $this->db->get()->num_rows();
    }

    function brg() 
    {
        $this->db->select('*');
        $this->db->form('barang');
        $this->db->where('id_barang');

        return $this->db->get()->num_rows();
    }
}