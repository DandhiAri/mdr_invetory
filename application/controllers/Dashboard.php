<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
    function __construct(){
    parent::__construct();
    }

    public function index() 
    {
        $data['title'] = "Dashboard";
        $data['pinjam'] = $this->m_dashboard->pjm();
        $data['request'] = $this->m_dashboard->rqes();
        $data['replace'] = $this->m_dashboard->rpc();
        $data['barang'] = $this->m_dashboard->brg();
        $this->load->view('user/index',$data);
		$this->load->view('dashboard',$data);

    }
}