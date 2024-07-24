<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pinjam extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        // cek_login();

        $this->load->model('m_pinjam');
        $this->load->model('Mmain');
        $this->load->helper('url');
		
		if (!$this->session->userdata('email')){
			redirect('auth');
    	}
	}

    public function index()
    {
        $data['title'] = 'Pinjam';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$render = $this->Mmain->qRead("pinjam");
		$data['Pinjam'] = $render->result();

        $data['content'] = $this->load->view('pages/pinjam/pinjam', $data,true);
		$this->load->view('layout/master_layout', $data);
    }
    public function tambah_pinjam()
    {
        $data['title'] = 'TambahPinjam';
		$render=$this->Mmain->qRead("pinjam");
		$data['Pinjam'] = $render->result();
		$data['barang'] = $this->m_pinjam->getBarang();
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

		$data['content'] = $this->load->view('pages/pinjam/tambah_data', $data,true);
		$this->load->view('layout/master_layout', $data);
    }
    public function proses_tambah()
    {
        if ($this->session->login['role'] == 'admin') {
            $this->session->set_flashdata('error', 'Tambah data hanya untuk admin!');
            redirect('dashboard');
        }

		$this->form_validation->set_rules('nama_peminjam', 'Nama Peminjam', 'required');
		$this->form_validation->set_rules('nama_penerima', 'Nama Penerima', 'required');
		$this->form_validation->set_rules('nama_pemberi', 'Nama Pemberi', 'required');
		$this->form_validation->set_rules('tgl_pinjam', 'Tanggal Pinjam', 'required');
		$this->form_validation->set_rules('jam_pinjam', 'Jam Pinjam', 'required');
		$this->form_validation->set_rules('keterangan', 'Keterangan', 'required');

		if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('failed', validation_errors());
			redirect($_SERVER['HTTP_REFERER']);
        } else {
            $data = [
				'nama_peminjam' => $this->input->post('nama_peminjam'),
				'nama_penerima' => $this->input->post('nama_penerima'),
				'nama_pemberi' => $this->input->post('nama_pemberi'),
				'tgl_pinjam' => $this->input->post('tgl_pinjam'),
				'jam_pinjam' => $this->input->post('jam_pinjam'),
				'keterangan' => $this->input->post('keterangan'),
			];

			$data['id_pinjam'] = $this->Mmain->autoId("pinjam", "id_pinjam", "PJ", "PJ" . "001", "001");
			$this->Mmain->qIns("pinjam", $data);

			$this->session->set_flashdata('success', 'Data Barang <strong>Berhasil</strong> Ditambahkan!');
			redirect('Pinjam/tambah_pinjam');
        }
    }
    public function edit_data($id)
    {
        $data['title'] = 'Pinjam';
        $data['Pinjam'] = $this->m_pinjam->edit_data($id);
		$data['barang'] = $this->m_pinjam->getBarang();
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

		
		$data['content'] = $this->load->view('pages/pinjam/edit_data', $data,true);
		$this->load->view('layout/master_layout', $data);
    }

    public function proses_ubah()
{
    if ($this->session->login['role'] == 'admin') {
        $this->session->set_flashdata('error', 'Ubah data hanya untuk admin!');
        redirect('dashboard');
    }

    $data = [
        'id_pinjam' => $this->input->post('id_pinjam'),
        'nama_peminjam' => $this->input->post('nama_peminjam'),
        'nama_penerima' => $this->input->post('nama_penerima'),
        'nama_pemberi' => $this->input->post('nama_pemberi'),
        /* 'nama_barang' => $this->input->post('nama_barang'), */
        'tgl_pinjam' => $this->input->post('tgl_pinjam'),
        'jam_pinjam' => $this->input->post('jam_pinjam'),
        'keterangan' => $this->input->post('keterangan'),
    ];

    // Load model
    $this->load->model('Mmain');

    // Menggunakan metode qUpdpart untuk mengubah data
    $this->Mmain->qUpdpart('pinjam', 'id_pinjam', $data['id_pinjam'], ['nama_peminjam', 'nama_penerima', 'nama_pemberi', 'tgl_pinjam', 'jam_pinjam', 'keterangan'], [$data['nama_peminjam'], $data['nama_penerima'], $data['nama_pemberi'], $data['tgl_pinjam'], $data['jam_pinjam'],  $data['keterangan']]);

    $this->session->set_flashdata('success', 'Data Barang <strong>Berhasil</strong> Diubah!');
    
    redirect('pinjam');
}

    public function hapus_data($id)
    {
		
        $result = $this->Mmain->qDel("detail_pinjam", "id_pinjam", $id);
        $result = $this->Mmain->qDel("pinjam", "id_pinjam", $id);
		

        if ($result) {
            $this->session->set_flashdata('success', 'Data Barang <strong>Berhasil</strong> Dihapus!');
            redirect('pinjam');
        } else {
            $this->session->set_flashdata('error', 'Data Barang <strong>Gagal</strong> Dihapus!');
            redirect('pinjam');
        }
    }
}

