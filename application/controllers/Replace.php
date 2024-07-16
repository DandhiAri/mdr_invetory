<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Replace extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_replace');
		$this->load->model('m_detail_barang');
        $this->load->model('Mmain');
        $this->load->helper('url');
		$this->load->library('form_validation');
		if (!$this->session->userdata('email')){
		redirect('auth');
		
    }
	}

    public function index()
    {
        $data['title'] = 'Replace';
        $render=$this->Mmain->qRead("ganti");
		$data['Replace'] = $render->result();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('replace', $data);
        $this->load->view('templates/footer');
    }

    public function tambah_data_replace()
    {
        $data['title'] = 'Replace';
        $render=$this->Mmain->qRead("ganti");
		$data['Replace'] = $render->result();
        $data['barang'] = $this->m_replace->getid();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('tambah_data_replace', $data);
        $this->load->view('templates/footer');
    }
    public function proses_tambah_replace()
    {
        if ($this->session->login['role'] == 'admin') {
            $this->session->set_flashdata('error', 'Tambah data hanya untuk admin!');
            redirect('dashboard');
        }
        $id = $this->Mmain->autoId("ganti","id_replace","R","R"."001","001");
        $nama = $this->input->post('nama');
        $date = $this->input->post('tgl_replace');
        /* $id_barang = $this->input->post('id_barang');
		$serial_code = $this->input->post('serial_code');
        $jumlah = $this->input->post('jumlah');
        $qty = $this->input->post('qty'); */
		$status = $this->input->post('status');
        $keterangan = $this->input->post('keterangan');


        $this->Mmain->qIns("ganti", array(
            $id,
            $nama,
            $date,
           /*  $id_barang,
			$serial_code,
            $jumlah,
            $qty, */
			$status,
            $keterangan

        ));
        $this->session->set_flashdata('success', 'Data Replace <strong>Berhasil</strong> Ditambahkan!');
        redirect('Detail_Replace/tambah_data_detail/'.$id.'');
    }
    

    public function edit_replace($id)
    {
        $data['title'] = 'Replace';
        $data['Replace'] = $this->m_replace->edit_replace($id);
		$data['barang'] = $this->m_replace->getid();
		$data['detail_barang'] = $this->m_replace->getseri();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('edit_replace', $data);
        $this->load->view('templates/footer');
    }

	public function proses_edit_replace()
	{
		if ($this->session->login['role'] == 'admin') {
			$this->session->set_flashdata('error', 'Ubah data hanya untuk admin!');
			redirect('dashboard');
		}

		// Mendapatkan ID dari inputan POST
		$id = $this->input->post('id_replace');

		// Data untuk diubah
		$data = [
            'id_replace' => $this->input->post('id_replace'),
            'nama' => $this->input->post('nama'),
            'tgl_replace' => $this->input->post('tgl_replace'),
/*          'id_barang' => $this->input->post('id_barang'),
			'serial_code' => $this->input->post('serial_code'),
            'jumlah' => $this->input->post('jumlah'),
            'qty' => $this->input->post('qty'), */
			'status' => $this->input->post('status'),
            'keterangan' => $this->input->post('keterangan'),

        ];

		// Memuat database dan model
		$this->load->database();
		$this->load->model('Mmain');

		// Menggunakan metode qUpdpart untuk mengubah data
		$this->Mmain->qUpdpart("ganti", 'id_replace', $id, array_keys($data), array_values($data));

		// Set flash data untuk notifikasi keberhasilan
		$this->session->set_flashdata('success', 'Data <strong>Berhasil</strong> Diubah!');

		// Redirect ke halaman detail_request
		redirect('replace');
	}
    

    public function hapus_replace($id)
    {
		$result = $this->Mmain->qDel("detail_ganti", "id_replace", $id);
        $result = $this->Mmain->qDel("ganti", "id_replace", $id);
        

        if ($result) {
            $this->session->set_flashdata('success', 'Jenis Barang <strong>Berhasil</strong> Dihapus!');
            redirect('replace');
        } else {
            $this->session->set_flashdata('error', 'Jenis Barang <strong>Gagal</strong> Dihapus!');
            redirect('replace');
        }
    }
}
