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
		if (!$this->session->userdata('email')){
		redirect('auth');
		
    }
	}

    public function index()
    {
        $data['title'] = 'Jenis';
        $data['jenis'] = $this->m_jenis->tampil_jenis()->result();
		//$render=$this->Mmain->qRead("jenis");
		//$data['Jenis'] = $render->result();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('jenis', $data);
        $this->load->view('templates/footer');
    }

    public function tambah_jenis()
    {
        $data['title'] = 'Jenis';
        //$data['Jenis'] = $this->m_jenis->tampil_datajenis()->result();
		$render=$this->Mmain->qRead("jenis");
		$data['Jenis'] = $render->result();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('tambah_jenis', $data);
        $this->load->view('templates/footer');
    }
    public function proses_tambah_jenis()
    {
        if ($this->session->login['role'] == 'admin') {
            $this->session->set_flashdata('error', 'Tambah data hanya untuk admin!');
            redirect('dashboard');
        }
        $id = $this->Mmain->autoId("jenis","id_jenis","JS","JS"."001","001");

        /* $data = [
            'id_jenis' => $this->input->post('id_jenis'),
            'nama_jenis' => $this->input->post('nama_jenis'),
            'nomor_seri' => $this->input->post('nomor_seri'),

        ]; */
        $nama = $this->input->post('nama');
        $nomor = $this->input->post('nomor');

        $this->Mmain->qIns("jenis", array(
            $id,
            $nama,
            '',''
        ));
        $this->session->set_flashdata('success', 'Jenis Barang <strong>Berhasil</strong> Ditambahkan!');
        redirect('jenis');
    }
    

    public function edit_data($id)
    {
        $data['title'] = 'Jenis';
        $data['Jenis'] = $this->m_jenis->edit_data($id);

        $this->load->view('templates/header', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('edit_data', $data);
        $this->load->view('templates/footer');
    }
 
    public function proses_ubah()
    {
        if ($this->session->login['role'] == 'admin') {
            $this->session->set_flashdata('error', 'Ubah data hanya untuk admin!');
            redirect('dashboard');
        }

        $data = [
            'id_jenis' => $this->input->post('id_jenis'),
            'nama_jenis' => $this->input->post('nama_jenis'),
            //'nomor_seri' => $this->input->post('nomor_seri'),

        ];

        if ($this->m_jenis->ubah($data)) {
            $this->session->set_flashdata('success', 'Jenis Barang <strong>Berhasil</strong> Diubah!');
            redirect('jenis');
        } else {
            $this->session->set_flashdata('error', 'Jenis Barang <strong>Gagal</strong> Diubah!');
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
