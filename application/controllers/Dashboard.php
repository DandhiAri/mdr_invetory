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
		$data['det_barang'] = $this->db->count_all("detail_barang");
        $data['pengajuan'] = $this->m_dashboard->count('pengajuan');
		$data['type'] = ['request', 'replace', 'pinjam'];

		$st = ['Requested','Rejected','Finished'];
		foreach($st as $status){
			$data['statusRequest'.$status] = $this->db->where('status',$status)->from('request')->count_all_results();
			$data['statusReplace'.$status] = $this->db->where('status',$status)->from('ganti')->count_all_results();
			$data['statusPinjam'.$status] = $this->db->where('status',$status)->from('detail_pinjam')->count_all_results();
		}
		$data['stB'] = ['In-Used','Stored'];
		$data['statusBarangInused'] = $this->db->where('status',"In-Used")->from('detail_barang')->count_all_results();
		$data['statusBarangStored'] = $this->db->where('status',"Stored")->from('detail_barang')->count_all_results();

		$data['tinta'] = $this->db->query('SELECT nama_barang, SUM(detail_barang.qtty) AS detail_count FROM barang LEFT JOIN detail_barang ON barang.id_barang = detail_barang.id_barang WHERE id_jenis = 87 GROUP BY nama_barang')->result();
		
		$data['content'] = $this->load->view('dashboard', $data, true);
		$this->load->view('layout/master_layout',$data);
    }
}
