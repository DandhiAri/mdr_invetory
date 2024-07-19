<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Satuan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
		
        $this->load->model('m_satuan');
        $this->load->model('Mmain');
        $this->load->helper('url');
    	$this->load->library('form_validation');
		$this->user = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		if (!$this->session->userdata('email')){
			redirect('auth');
    	}
	}

    public function index()
    {
		$data['Satuan'] = $this->Mmain->qRead("satuan")->result();
        $data['user'] = $this->user;

        $data['content'] = $this->load->view('pages/satuan/satuan', $data, true);
		$this->load->view('layout/master_layout', $data);
    }

    public function tambah()
    {
        $data['title'] = 'Satuan';
        $data['user'] = $this->user;
		$render=$this->Mmain->qRead("satuan");
		$data['Satuan'] = $render->result();
		$data['content'] = $this->load->view('pages/satuan/tambah_data', $data, true);
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

    public function edit_data($id)
    {
        $data['title'] = 'Satuan';
        $data['Satuan'] = $this->m_satuan->edit_data($id);
        $data['user'] = $this->user;

		$data['content'] = $this->load->view('pages/satuan/edit_data', $data, true);
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
