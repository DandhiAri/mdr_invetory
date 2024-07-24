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
        $data['Detail_Request'] = $this->Mmain->qRead("detail_request")->result();

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
    public function proses_tambah()
    {
        if ($this->session->login['role'] == 'admin') {
            $this->session->set_flashdata('error', 'Tambah data hanya untuk admin!');
            redirect('dashboard');
        }

		$this->form_validation->set_rules('id_request', 'ID Request', 'required');
		$this->form_validation->set_rules('id_barang', 'ID Barang', 'required');
		$this->form_validation->set_rules('serial_code', 'Serial Code', 'required');
		$this->form_validation->set_rules('lokasi', 'Lokasi', 'required');
		$this->form_validation->set_rules('jumlah', 'Jumlah', 'required|integer');

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
            );

			$id_request = $this->Mmain->autoId("detail_request","id_detail_request","DRQ","DRQ"."001","001");
			
			$data['id_detail_request'] = $id_request;

			$this->Mmain->qIns('detail_request', $data);
			$this->session->set_flashdata('success', 'Data <strong>Berhasil</strong> Ditambahkan!');
			redirect("detail_request/init/".$id_request);
        }
    }

    public function edit($id){
        $data['title'] = 'Detail Request';
		$data['user'] = $this->user;
        $data['Detail_Request'] = $this->m_detail_req->edit_request($id);
		$data['barang'] = $this->m_detail_barang->getBarang();
		$data['detail_barang'] = $this->m_detail_req->getseri();

		$data['content'] = $this->load->view('pages/detail_request/editdetail', $data, true);
		$this->load->view('layout/master_layout',$data);
    }

   public function proses_ubah()
	{
		if ($this->session->login['role'] == 'admin') {
			$this->session->set_flashdata('error', 'Ubah data hanya untuk admin!');
			redirect('dashboard');
		}

		// Mendapatkan ID dari inputan POST
		$id = $this->input->post('id_detail_request');
		$serial_code = $this->input->post('serial_code');
		
		$detail_barang_data = $this->Mmain->qRead("detail_barang where serial_code = '$serial_code' ", "id_detail_barang");
		
		if ($detail_barang_data->num_rows() > 0) {	
			$keterangan = $this->input->post('keterangan');
			$id_barang = $this->input->post('id_barang');
			$serial_code = $this->input->post('serial_code');
			$lokasi = $this->input->post('lokasi');
			$jumlah = $this->input->post('jumlah');
			$status = $this->input->post('status');
		
			if ($status == 'Finished') {
				$renQty = $this->Mmain->qRead("detail_barang where serial_code = '".$serial_code."' ","qtty, id_detail_barang");
			
				if ($renQty->num_rows() > 0) {
				foreach ($renQty->result() as $row) {
					$qty = $row->qtty;
					$idDetailBarang = $row->id_detail_barang;
				}
        	}		
		
			$valStok = $qty - $jumlah;
			
			$this->Mmain->qUpdpart("detail_barang", "id_detail_barang", $idDetailBarang, Array("qtty"), Array($valStok) );
		}
		
		if ($status == 'Rejected') {
			$renQty = $this->Mmain->qRead("detail_barang where serial_code = '".$serial_code."' ","qtty, id_detail_barang");
			
			 if ($renQty->num_rows() > 0) {
				foreach ($renQty->result() as $row) {
					$qty = $row->qtty;
					$idDetailBarang = $row->id_detail_barang;
				}
			}		
			
			$valStok = $qty + $jumlah;
			
			$this->Mmain->qUpdpart("detail_barang", "id_detail_barang", $idDetailBarang, Array("qtty"), Array($valStok) );
			}  
		
		// Data untuk diubah
		$data = [
			'id_request' => $this->input->post('id_request'),
			'id_detail_barang' => $idDetailBarang, 
			'keterangan' => $this->input->post('keterangan'),
			'id_barang' => $this->input->post('id_barang'),
			'serial_code' => $this->input->post('serial_code'),
			'lokasi' => $this->input->post('lokasi'),
			'jumlah' => $this->input->post('jumlah'),
			'status' => $this->input->post('status'),
		];

		// Memuat database dan model
		$this->load->database();
		$this->load->model('Mmain');
		//echo $this->input->post('jumlah_request');
		// Menggunakan metode qUpdpart untuk mengubah data
			$tbColUpd = Array("id_detail_barang","keterangan","id_barang","serial_code","lokasi","jumlah","status");
			$tbColVal = Array($idDetailBarang,$keterangan,$id_barang,$serial_code,$lokasi,$jumlah,$status);
			$this->Mmain->qUpdpart("detail_request", 'id_detail_request', $id, $tbColUpd, $tbColVal); // Menambahkan argumen terakhir
		//echo $id;
		// Set flash data untuk notifikasi keberhasilan
		$this->session->set_flashdata('success', 'Data <strong>Berhasil</strong> Diubah!');

		// Redirect ke halaman detail_request
		redirect("detail_request/init/".$data['id_request']);
		} else {
			$this->session->set_flashdata('error', 'Serial code tidak ditemukan!');
			redirect("detail_request/init/".$data['id_request']);
		}
	}
	
	

    public function hapus_data($id,$idRequest)
	{
		//$result = $this->m_detail_req->hapus_request($id);
		$result=$this->Mmain->qDel("Detail_request","id_detail_request",$id);

		if ($render) {
			$this->session->set_flashdata('success', 'Data <strong>Berhasil</strong> Dihapus!');
			redirect("detail_request/init/".$idRequest);
		} else {
			$this->session->set_flashdata('error', 'Data <strong>Gagal</strong> Dihapus!');
			redirect("detail_request/init/".$idRequest);
		}
	}
}
