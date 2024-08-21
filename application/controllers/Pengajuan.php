<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pengajuan extends CI_Controller
{
	public function __construct()
    {
        parent::__construct();
        // cek_login();

        $this->load->model('m_pengajuan');
        $this->load->model('Mmain');
        $this->load->helper('url');
		
		$this->load->library('pagination');
		if (!$this->session->userdata('email')){
			redirect('auth');
    	}
	}

	public function index()
    {
        $data['title'] = 'Pinjam';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		
		$config['base_url'] = base_url('pinjam/index/'); 
		$config['per_page'] = 5;
		$config['uri_segment'] = 3;
		
		if ($this->input->post('keywordPin')){
			$data['keywordPin'] = $this->input->post('keywordPin');
			$this->session->set_userdata('keywordPin',$data['keywordPin']);
		} elseif ($this->input->post('reset')){
			$data['keywordPin'] = null;
			$this->session->unset_userdata('keywordPin');
		} else {
			$data['keywordPin'] = $this->session->userdata('keywordPin');
		}

		$key = $data['keywordPin'];

		$this->db->from('pengajuan');
		$config['total_rows'] = $this->db->count_all_results();
		$data['page'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
		$this->pagination->initialize($config);

		$data['Pengajuan'] = $this->m_pengajuan->getPengajuan($data['keywordPin'], $config['per_page'], $data['page']);

		$data['pagination'] = $this->pagination->create_links();

        $data['content'] = $this->load->view('pages/pengajuan/index', $data,true);
		$this->load->view('layout/master_layout', $data);
    }
	public function tambah(){
		$data['content'] = $this->load->view('pages/pengajuan/tambah_data', $data,true);
		$this->load->view('layout/master_layout', $data);
	}
	public function proses_tambah()
    {
		if ($this->session->login['role'] == 'admin') {
            $this->session->set_flashdata('error', 'Tambah data hanya untuk admin!');
            redirect('dashboard');
        }

		$this->form_validation->set_rules('nama_satuan', 'Nama satuan', 'required');

		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('failed', validation_errors());
			redirect($_SERVER['HTTP_REFERER']);
		}else{
			$data = array(
				'nama_satuan' => $this->input->post('nama_satuan')
			);

			$this->Mmain->qIns('satuan', $data);
			$this->session->set_flashdata('success', 'Satuan <strong>Berhasil</strong> Ditambahkan!');
			redirect('satuan');
		}
    }
	public function edit_data(){
		$data['content'] = $this->load->view('pages/pengajuan/edit_data', $data,true);
		$this->load->view('layout/master_layout', $data);
	}
	public function proses_ubah()
    {
        if ($this->session->login['role'] == 'admin') {
            $this->session->set_flashdata('error', 'Ubah data hanya untuk admin!');
            redirect('dashboard');
        }

		$this->form_validation->set_rules('nama_satuan', 'Nama satuan', 'required');

		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('failed', validation_errors());
			redirect($_SERVER['HTTP_REFERER']);
		}else{
			$data = array(
				'id_satuan' => $this->input->post('id_satuan'),
				'nama_satuan' => $this->input->post('nama_satuan')
			);

			$this->m_satuan->ubah($data);
			$this->session->set_flashdata('success', 'Satuan <strong>Berhasil</strong> Diubah!');
			redirect('satuan');
		}
    }
	public function hapus_data($id)
    {
        $result = $this->m_satuan->hapus($id);

        if ($result) {
            $this->session->set_flashdata('success', 'Satuan <strong>Berhasil</strong> Dihapus!');
            redirect('satuan');
        } else {
            $this->session->set_flashdata('failed', 'Satuan <strong>Gagal</strong> Dihapus!');
            redirect('satuan');
        }
    }
}
