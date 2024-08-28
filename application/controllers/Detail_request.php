<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Detail_request extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_detail_req');
		$this->load->model('m_detail_barang');
        $this->load->model('Mmain');
        $this->load->helper('url');
        $this->user = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
    	$this->load->library('form_validation');
		if (!$this->session->userdata('email')){
			redirect('auth');
    	}
		$this->form_validation->set_rules('id_request', 'ID Request', 'required');
		$this->form_validation->set_rules('id_barang', 'ID Barang', 'required');
		$this->form_validation->set_rules('lokasi', 'Lokasi', 'required');
	}
	
    public function index()
    {
        $data['title'] = 'Detail Request';
        $data['Detail_Request'] = $this->m_detail_req->tampil_datarequest()->result();

		$data['content'] = $this->load->view('pages/detail_request/detail_request', $data, true);
		$this->load->view('layout/master_layout',$data);
    }
	
	public function init($id)
    {
        $data['title'] = 'Detail Request';
		$data['id'] = $id;
		$data['user'] = $this->user;
        $data['Detail_Request'] = $this->m_detail_req->tampil_datarequest($id)->result();

		$data['content'] = $this->load->view('pages/detail_request/detail_request', $data, true);
		$this->load->view('layout/master_layout',$data);
    }

	public function get_serial_codes() {
        $id_barang = $this->input->post('id_barang');
        $this->load->model('Mmain');
        $serial_codes = $this->Mmain->get_serial_codes($id_barang);
        echo json_encode($serial_codes);
    }

    public function tambah($id)
    {
        $data['title'] = 'Detail Request';
		$data['id'] = $id;
		$data['user'] = $this->user;
		$data['Barang'] = $this->Mmain->qRead("barang")->result();
		$data['detail_barang'] = $this->Mmain->qRead("detail_barang")->result();

		$data['content'] = $this->load->view('pages/detail_request/adddetail', $data, true);
		$this->load->view('layout/master_layout',$data);
    }
    public function proses_tambah($id)
    {
        if ($this->session->login['role'] == 'admin') {
            $this->session->set_flashdata('error', 'Tambah data hanya untuk admin!');
            redirect('dashboard');
		}

		if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('failed', validation_errors());
			redirect($_SERVER['HTTP_REFERER']);
        } else {
            $data = array(
                "id_request" => $this->input->post('id_request'),
				"keterangan" => $this->input->post('keterangan'),
				"id_barang" => $this->input->post('id_barang'),
				"id_detail_barang" => $this->input->post('id_detail_barang'),
				"serial_code" => $this->input->post('serial_code'),
				"lokasi" => $this->input->post('lokasi'),
				"jumlah" => $this->input->post('jumlah'),
            );
			$id_detail_request = $this->Mmain->autoId("detail_request","id_detail_request","DRQ","DRQ"."001","001");
			$serial = $data['serial_code'];
			$data['id_detail_request'] = $id_detail_request;
			$this->Mmain->qIns('detail_request', $data);
			
			$this->session->set_flashdata('success', 'Data <strong>Berhasil</strong> Ditambahkan!');
			redirect("request");
        }
    }

    public function edit($id){
        $data['title'] = 'Detail Request';
		$data['user'] = $this->user;
        $data['Detail_Request'] = $this->m_detail_req->edit_request($id);
		$data['barang'] = $this->Mmain->qRead('barang')->result();
		$data['detail_barang'] = $this->Mmain->qRead("detail_barang")->result();
		$data['id'] = $id;

		$data['content'] = $this->load->view('pages/detail_request/editdetail', $data, true);
		$this->load->view('layout/master_layout',$data);
    }

   public function proses_ubah($id)
	{
		if ($this->session->login['role'] == 'admin') {
			$this->session->set_flashdata('error', 'Ubah data hanya untuk admin!');
			redirect('dashboard');
		}

		$this->form_validation->set_rules('status', 'status', 'required');

		if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('failed', validation_errors());
			redirect($_SERVER['HTTP_REFERER']);
        } else {
            $data = array(
                "id_request" => $this->input->post('id_request'),
				"keterangan" => $this->input->post('keterangan'),
				"id_barang" => $this->input->post('id_barang'),
				"serial_code" => $this->input->post('serial_code'),
				"lokasi" => $this->input->post('lokasi'),
				"jumlah" => $this->input->post('jumlah'),
				"status" => $this->input->post('status'),
            );
			
			if ($data['status'] == 'Finished') {
				$id_detail_barang = $this->db->query("SELECT id_detail_barang FROM detail_barang WHERE serial_code ='".$data['serial_code']."'")->row()->id_detail_barang;
				$data1["PIC"] = $this->db->query("SELECT nama FROM request WHERE id_request ='".$data['id_request']."'")->row()->nama;
				$data1["status"] = "In-Used";
				$this->Mmain->qUpdpart("detail_barang", "id_detail_barang", $id_detail_barang, array_keys($data1), array_values($data1) );
			}
		
			if ($data['status'] == 'Rejected') {
				$data1["status"] = "Stored";

				$this->Mmain->qUpdpart("detail_barang", "id_detail_barang", $idDetailBarang, array_keys($data1), array_values($data1) );
			}  

			$this->Mmain->qUpdpart("detail_request", 'id_detail_request', $id, array_keys($data), array_values($data)); 

			$this->session->set_flashdata('success', 'Data <strong>Berhasil</strong> Diubah!');
			redirect("request");
        }
	}
	
	

    public function hapus_data($id,$idRequest)
	{
		//$result = $this->m_detail_req->hapus_request($id);
		$result=$this->Mmain->qDel("Detail_request","id_detail_request",$id);

		if (!$render) {
			$this->session->set_flashdata('success', 'Data <strong>Berhasil</strong> Dihapus!');
			redirect("request");
		} else {
			$this->session->set_flashdata('failed', 'Data <strong>Gagal</strong> Dihapus!');
			redirect("request");
		}
	}
}
