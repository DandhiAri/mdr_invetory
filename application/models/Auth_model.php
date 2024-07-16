<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth_model extends CI_Model
{

    public function cek_username($name)
    {
        $query = $this->db->get_where('user', ['name' => $name]);
        return $query->num_rows();
    }

    public function get_password($name)
    {
        $data = $this->db->get_where('user', ['name' => $name])->row_array();
        return $data['password'];
    }

    public function userdata($name)
    {
        return $this->db->get_where('user', ['name' => $name])->row_array();
    }
	
	function tampil_data(){
        return $this->db->get('user');
    }
	
	public function get()
    {
        $this->db->from('user');
        if ($user['role_id'] == 1) {
            $this->db->where('role_id', $user);
        }
        $query = $this->db->get();
        return $query;
    }
	
	function edit_data($id)
    { 
        $query = $this->db->query("SELECT * FROM user WHERE id = '$id'");

        if ($query->num_rows() == 0) {
            $query = [];
        } else {
            $query = $query->row_array();
        }

        return $query;
    }

    public function ubah($data)
    {
        $this->db->set('name', $data['name']);
        $this->db->set('email', $data['email']);
        // $this->db->set('satuan_id', $data['satuan_id']);
        // $this->db->set('jenis_id', $data['jenis_id']);
        $this->db->where('id', $data['id']);

        return $this->db->update('user');
    }

    function update_data($where,$data,$table){
        $this->db->where($where);
        $this->db->update($table,$data);
    } 
}
