<?php

class M_profile extends CI_Model
{
    public function profile()
    {
        return $this->db->get('user');
    }
}
