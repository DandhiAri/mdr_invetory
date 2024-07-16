<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth_model extends CI_Model
{

    function tampil(){
        return $this->db->get('user');
    }

    function tampil_user(){
        return $this->db->get('user');
    }

    public function tambah_ubah($data)
    {
        return $this->db->insert($this->_table, $data);
    }
	
	public function get($id = null)
    {
        $this->db->from('user');
        if ($id != null) {
            $this->db->where('id', $id);
        }
        $query = $this->db->get();
        return $query;
    }
    
}