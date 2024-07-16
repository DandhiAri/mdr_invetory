<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Request extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_data');
        $this->load->model('Mmain');
		$this->load->model('m_detail_barang');
        $this->load->helper('url');
    $this->load->library('form_validation');
		if (!$this->session->userdata('email')){
		redirect('auth');
		
    }
	}

    public function index()
    {
        $data['title'] = 'Request';
        //$data['Request'] = $this->m_data->tampil_request()->result();
		//$data['Request'] = $this->Mmain->getid();
		$render=$this->Mmain->qRead("request");
		$data['Request'] = $render->result();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('request', $data);
        $this->load->view('templates/footer');
    }

    public function tambah()
    {
        $data['title'] = 'Request';
        //$data['Request'] = $this->m_data->tampil_datarequest()->result();
		$render=$this->Mmain->qRead("request");
		$data['Request'] = $render->result();
		$data['barang'] = $this->m_detail_barang->getBarang();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('addrequest', $data);
        $this->load->view('templates/footer');
    }

    public function proses_tambah()
    {
        if ($this->session->login['role'] == 'admin') {
            $this->session->set_flashdata('error', 'Tambah data hanya untuk admin!');
            redirect('dashboard');
        }
        $id = $this->Mmain->autoId("request","id_request","RQ","RQ"."001","001");

        $nama = $this->input->post('nama');
        $tgl_request = $this->input->post('tgl_request');
        //$barang_request = $this->input->post('barang_request');
        //$jumlah = $this->input->post('jumlah');
        $keterangan = $this->input->post('keterangan');
		$status = $this->input->post('status');
        
        $this->Mmain->qIns("request", array(
            $id,
            $nama,
            $tgl_request,
            //$barang_request,
            //$jumlah,
            $keterangan,
			$status

        ));

        $this->session->set_flashdata('success', 'Data <strong>Berhasil</strong> Ditambahkan!');
        redirect('detail_request/tambah/'.$id.'');

    }

    public function edit($id){
        $data['title'] = 'Request';
        $data['Request'] = $this->m_data->edit_request($id);
		$data['barang'] = $this->m_detail_barang->getBarang();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('edit_request',$data);
        $this->load->view('templates/footer');
    }
	
	public function proses_ubah()
	{
		if ($this->session->login['role'] == 'admin') {
			$this->session->set_flashdata('error', 'Ubah data hanya untuk admin!');
			redirect('dashboard');
		}

		// Mendapatkan ID dari inputan POST
		$id = $this->input->post('id_request');

		// Data untuk diubah
		$data = [
			'id_request' => $this->input->post('id_request'),
            'nama' => $this->input->post('nama'),
            'tgl_request' => $this->input->post('tgl_request'),
            //'barang_request' => $this->input->post('barang_request'),
            //'jumlah' => $this->input->post('jumlah'),
            'keterangan' => $this->input->post('keterangan'),
			'status' => $this->input->post('status'),
		];

		// Memuat database dan model
		$this->load->database();
		$this->load->model('Mmain');

		// Menggunakan metode qUpdpart untuk mengubah data
		$this->Mmain->qUpdpart("request", 'id_request', $id, array_keys($data), array_values($data));

		// Set flash data untuk notifikasi keberhasilan
		$this->session->set_flashdata('success', 'Data <strong>Berhasil</strong> Diubah!');

		// Redirect ke halaman detail_request
		redirect('request');
	}

    public function hapus_data($id)
       {
           //$result = $this->m_data->hapus_request($id);
		   $result = $this->Mmain->qDel("detail_request","id_request",$id);
		   $result = $this->Mmain->qDel("request","id_request",$id);
   
           if ($result) {
               $this->session->set_flashdata('success', 'Data <strong>Berhasil</strong> Dihapus!');
               redirect('request');
           } else {
               $this->session->set_flashdata('error', 'Data <strong>Gagal</strong> Dihapus!');
               redirect('request');
           }
       }
}