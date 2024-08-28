<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Jenis extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_jenis');
        $this->load->model('Mmain');
        $this->load->helper('url');
    	$this->load->library('form_validation');
    	$this->load->library('pagination');
		$this->user = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		if (!$this->session->userdata('email')){
			redirect('auth');
    	}
	}

    public function index()
    {
        $data['title'] = 'Jenis';
        $data['user'] = $this->user;

		$config['base_url'] = base_url('jenis/index/');
		$config['per_page'] = 10;
		$config['uri_segment'] = 3;

		if ($this->input->post('keywordJEN')){
			$data['keywordJEN'] = $this->input->post('keywordJEN');
			$this->session->set_userdata('keywordJEN',$data['keywordJEN']);
		} elseif ($this->input->post('reset')){
			$data['keywordJEN'] = null;
			$this->session->unset_userdata('keywordJEN');
		} else {
			$data['keywordJEN'] = $this->session->userdata('keywordJEN');
		}

		$key = $data['keywordJEN'];

		$this->db->from('jenis');

		if(!empty($key)){
			$this->db->like('jenis.nama_jenis', $key);
		}

		$config['total_rows'] = $this->db->count_all_results();
		$data['page'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
		$this->pagination->initialize($config);

		$data['jenis'] = $this->m_jenis->getJenis($data['keywordJEN'], $config['per_page'], $data['page']);

		$data['pagination'] = $this->pagination->create_links();
        $data['content'] = $this->load->view('pages/jenis_barang/jenis', $data, true);
		$this->load->view('layout/master_layout', $data);

    }

    public function tambah_jenis()
    {
        $data['title'] = 'Jenis';
        //$data['Jenis'] = $this->m_jenis->tampil_datajenis()->result();
		$render=$this->Mmain->qRead("jenis");
		$data['Jenis'] = $render->result();
        $data['user'] = $this->user;
		$data['content'] = $this->load->view('pages/jenis_barang/tambah_jenis', $data, true);
		$this->load->view('layout/master_layout', $data);
    }

    public function proses_tambah_jenis()
    {
		$this->form_validation->set_rules('nama_jenis', 'Nama Jenis', 'required');

		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('failed', validation_errors());
			redirect($_SERVER['HTTP_REFERER']);
		}else{
			$data = array(
				'nama_jenis' => $this->input->post('nama_jenis')
			);

			$this->Mmain->qIns('jenis', $data);
			$this->session->set_flashdata('success', 'Jenis Barang <strong>Berhasil</strong> Ditambahkan!');
			redirect('jenis');
		}
    }
    

    public function edit_data($id)
    {
		
        $data['title'] = 'Jenis';
        $data['Jenis'] = $this->m_jenis->edit_data($id);
        $data['user'] = $this->user;

		$data['content'] = $this->load->view('pages/jenis_barang/edit_data', $data, true);
		$this->load->view('layout/master_layout', $data);
    }
 
    public function proses_ubah()
    {
        if ($this->session->login['role'] == 'admin') {
            $this->session->set_flashdata('error', 'Ubah data hanya untuk admin!');
            redirect('dashboard');
        }
		
		$this->form_validation->set_rules('nama_jenis', 'Nama Jenis', 'required');

		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('failed', validation_errors());
			redirect($_SERVER['HTTP_REFERER']);
		}else{
			$data = array(
				'id_jenis' => $this->input->post('id_jenis'),
				'nama_jenis' => $this->input->post('nama_jenis')
			);

			$this->m_jenis->ubah($data);
			$this->session->set_flashdata('success', 'Jenis Barang <strong>Berhasil</strong> Ditambahkan!');
			redirect('jenis');
		}
    }

    public function hapus_data($id)
    {
        $result = $this->m_jenis->hapus($id);

        if ($result) {
            $this->session->set_flashdata('success', 'Jenis Barang <strong>Berhasil</strong> Dihapus!');
            redirect('jenis');
        } else {
            $this->session->set_flashdata('error', 'Jenis Barang <strong>Gagal</strong> Dihapus!');
            redirect('jenis');
        }
    }
}
