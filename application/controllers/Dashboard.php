<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
	public function __construct()
    {
        parent::__construct();
        $this->load->model('m_dashboard');
        $this->load->helper('url');
		
        $this->load->library('form_validation');
		if (!$this->session->userdata('email')){
			redirect('auth');
    	}
    }

    public function index() 
    {
        $data['title'] = 'Dashboard';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['pinjam'] = $this->m_dashboard->count('pinjam');
        $data['request'] = $this->m_dashboard->count('request');
        $data['replace'] = $this->m_dashboard->count('ganti');
        $data['barang'] = $this->m_dashboard->count('barang');
        $data['pengajuan'] = $this->m_dashboard->count('pengajuan');

		$data['content'] = $this->load->view('dashboard', $data, true);
		$this->load->view('layout/master_layout',$data);
    }
}
