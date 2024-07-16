<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Satuan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        // cek_login();

        $this->load->model('m_satuan');
        $this->load->model('Mmain');
        $this->load->helper('url');
    	$this->load->library('form_validation');
		if (!$this->session->userdata('email')){
		redirect('auth');
		
    }
	}

    public function index()
    {
        // $data['title'] = 'Satuan';
        //$data['Satuan'] = $this->m_satuan->tampil_satuan()->result();
		$data['Satuan']=$this->Mmain->qRead("satuan")->result();
		// $data['Satuan'] = $render->result();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('satuan/satuan', $data);
        $this->load->view('templates/footer');
    }
    public function tambah()
    {
        $data['title'] = 'Satuan';
        //$data['Satuan'] = $this->m_satuan->tampil_datasatuan()->result();
		$render=$this->Mmain->qRead("satuan");
		$data['Satuan'] = $render->result();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('satuan/tambah_data', $data);
        $this->load->view('templates/footer');
    }
    public function proses_tambah()
    {
        if ($this->session->login['role'] == 'admin') {
            $this->session->set_flashdata('error', 'Tambah data hanya untuk admin!');
            redirect('dashboard');
        }

        /* $data = [
            'id_satuan' => $this->input->post('id_satuan'),
            'nama_satuan' => $this->input->post('nama_satuan'),
            'nomer_seri' => $this->input->post('nomer_seri'),

        ]; */

        $nama = $this->input->post('nama');
        $nomer = $this->input->post('nomer');

        $this->Mmain->qIns("satuan", array(
            0,
            $nama,
            '',''

        ));

        $this->session->set_flashdata('success', 'Data Barang <strong>Berhasil</strong> Ditambahkan!');
        redirect('satuan');
    }

    public function edit_data($id)
    {
        $data['title'] = 'Satuan';
        $data['Satuan'] = $this->m_satuan->edit_data($id);

        $this->load->view('templates/header', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('satuan/edit_data', $data);
        $this->load->view('templates/footer');
    }

    public function proses_ubah()
    {
        if ($this->session->login['role'] == 'admin') {
            $this->session->set_flashdata('error', 'Ubah data hanya untuk admin!');
            redirect('dashboard');
        }

        $data = [
            'id_satuan' => $this->input->post('id_satuan'),
            'nama_satuan' => $this->input->post('nama_satuan'),
            //'nomer_seri' => $this->input->post('nomer_seri'),

        ];

        if ($this->m_satuan->ubah($data)) {
            $this->session->set_flashdata('success', 'Data Barang <strong>Berhasil</strong> Diubah!');
            redirect('satuan');
        } else {
            $this->session->set_flashdata('error', 'Data Barang <strong>Gagal</strong> Diubah!');
            redirect('satuan');
        }
    }

    public function hapus_data($id)
    {
        $result = $this->m_satuan->hapus($id);

        if ($result) {
            $this->session->set_flashdata('success', 'Data Barang <strong>Berhasil</strong> Dihapus!');
            redirect('satuan');
        } else {
            $this->session->set_flashdata('error', 'Data Barang <strong>Gagal</strong> Dihapus!');
            redirect('satuan');
        }
    }
}
