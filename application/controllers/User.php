<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_dashboard');
        $this->load->model('Mmain');
        $this->load->helper('url');
		
        $this->load->library('form_validation');
		if (!$this->session->userdata('email')){
		redirect('auth');
		
    }
    }

    public function index()
    {
        $data['tittle'] = 'login';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        // $this->load->view('user/index');
        $data['pinjam'] = $this->m_dashboard->count('pinjam');
        $data['request'] = $this->m_dashboard->count('request');
        $data['replace'] = $this->m_dashboard->count('ganti');
        $data['barang'] = $this->m_dashboard->count('barang');
        
		$this->load->view('user/index',$data);
		
    }
	public function tampil()
	{
		$this->load->view('templates/sidebar',$data);
	}

    // public function dashboard() 
    // {
    //     $data['title'] = "Dashboard";
    //     $data['pinjam'] = $this->m_dashboard->pjm();
    //     $data['request'] = $this->m_dashboard->rqes();
    //     $data['replace'] = $this->m_dashboard->rpc();
    //     $data['barang'] = $this->m_dashboard->brg();
    //     $this->load->view('user/index',$data);

    // }

    
}
