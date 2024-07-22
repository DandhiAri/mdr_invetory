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
        $this->user = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $this->load->helper('url');
		$this->load->library('form_validation');
		if (!$this->session->userdata('email')){
			redirect('auth');
		}
	}

    public function index()
    {
        $data['title'] = 'Request';
        $data['user'] = $this->user;
		$render = $this->Mmain->qRead("request");
		$data['Request'] = $render->result();
        $data['content'] = $this->load->view('pages/request/request', $data, true);
		$this->load->view('layout/master_layout',$data);

    }

    public function tambah()
    {
        $data['title'] = 'Request';
        //$data['Request'] = $this->m_data->tampil_datarequest()->result();
		$render=$this->Mmain->qRead("request");
		$data['Request'] = $render->result();
		$data['barang'] = $this->m_detail_barang->getBarang();
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

		$data['content'] = $this->load->view('pages/request/addrequest', $data, true);
		$this->load->view('layout/master_layout',$data);
    }

    public function proses_tambah()
    {
        if ($this->session->login['role'] == 'admin') {
            $this->session->set_flashdata('error', 'Tambah data hanya untuk admin!');
            redirect('dashboard');
        }
		
		$this->form_validation->set_rules('nama', 'Nama PIC', 'required');
        $this->form_validation->set_rules('tgl_request', 'Tanggal Request', 'required');
        $this->form_validation->set_rules('keterangan', 'Keterangan', 'required');
        $this->form_validation->set_rules('status', 'Status', 'required');

		if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('failed', validation_errors());
			redirect($_SERVER['HTTP_REFERER']);
        } else {
            $data = array(
                'nama' => $this->input->post('nama'),
                'tgl_request' => $this->input->post('tgl_request'),
                'keterangan' => $this->input->post('keterangan'),
                'status' => $this->input->post('status'),
            );
			$id = $this->Mmain->autoId("request","id_request","RQ","RQ"."001","001");
			$data['id_request'] = $id;
			$this->Mmain->qIns('request', $data);

            $this->session->set_flashdata('success', 'Data Barang sudah ditambahkan');
			redirect('detail_request/tambah/'.$id);
        }
    }

    public function edit($id){
        $data['title'] = 'Request';
        $data['Request'] = $this->m_data->edit_request($id);
		$data['barang'] = $this->m_detail_barang->getBarang();
        $data['user'] = $this->user;

		$data['content'] = $this->load->view('pages/request/edit_request', $data, true);
		$this->load->view('layout/master_layout',$data);
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
			'id_request' => $id,
            'nama' => $this->input->post('nama'),
            'tgl_request' => $this->input->post('tgl_request'),
            'keterangan' => $this->input->post('keterangan'),
			'status' => $this->input->post('status'),
		];

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
