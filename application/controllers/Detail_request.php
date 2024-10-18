<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Detail_request extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
		date_default_timezone_set('Asia/Jakarta');
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
		$this->form_validation->set_rules('qtty', 'Quantity', 'required');
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
				"qtty" => $this->input->post('qtty'),
            );
			if ($data['serial_code'] === "-"){
				$data['serial_code'] = "";
			}
			$id_detail_request = $this->Mmain->autoId("detail_request","id_detail_request","DRQ","DRQ"."001","001");
			$data['id_detail_request'] = $id_detail_request;
			$data['tgl_request_update'] = date('Y-m-d\TH:i');
			$data['user_create'] = $this->user['name'];

			$this->Mmain->qIns('detail_request', $data);
			$this->m_detail_req->changeStatusRequest($data['id_request']);

			$this->session->set_flashdata('success', 'Data Detail Request <strong>Berhasil</strong> Ditambahkan!');
			redirect('request/index/' . $this->get_page_for_id($data['id_request']));
			// redirect("request");

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
				"id_detail_barang" => $this->input->post('id_detail_barang'),
				"serial_code" => $this->input->post('serial_code'),
				"lokasi" => $this->input->post('lokasi'),
				"qtty" => $this->input->post('qtty'),
				"status" => $this->input->post('status'),
            );
			if ($data['serial_code'] === "-"){
				$data['serial_code'] = "";
			}
			$query = $this->db->query("
				SELECT qtty, status 
				FROM detail_barang 
				WHERE id_detail_barang = '".$data['id_detail_barang']."'
			")->row();
			$query1 = $this->db->query("
				SELECT qtty,status 
				FROM detail_request 
				WHERE id_detail_request = '".$id."'
			")->row();
			$satuanBarang = $this->db->query('SELECT id_satuan FROM barang WHERE id_barang ="'.$data['id_barang'].'"')->row()->id_satuan;

			if (($query1->status == 'Requested' || $query1->status == 'Rejected') && $data['status'] == 'Finished') {
				if($satuanBarang === "16"){
					$data1["PIC"] = $this->db->query("SELECT nama FROM request WHERE id_request ='".$data['id_request']."'")->row()->nama;
					$data1["status"] = "In-Used";
					$data1["lokasi"] = $data['lokasi'];
					$data1['id_transaksi'] = $id;
				}
				if ($query->qtty !== null && $query->qtty > 0) {
					$data1["qtty"] = max($query->qtty - $data['qtty'], 0);
				}

				$this->Mmain->qUpdpart("detail_barang", "id_detail_barang", $data['id_detail_barang'], array_keys($data1), array_values($data1));
			
			} elseif ($query1->status == 'Finished' && ($data['status'] == 'Rejected' || $data['status'] == 'Requested')) {
				if($satuanBarang === "16"){
					$data1["status"] = "Stored";
					$data1["PIC"] = "";
					$data1["lokasi"] = "IT-STOCKROOM";
					$data1['id_transaksi'] = "";
				}
				if ($query1->status == "Finished"){
					$data1["qtty"] = max($query->qtty + $data['qtty'], 0);
				}

				$this->Mmain->qUpdpart("detail_barang", "id_detail_barang", $data['id_detail_barang'], array_keys($data1), array_values($data1));
			} elseif ($data['status'] == 'Finished' && $query1->status == 'Finished' ){
				if($satuanBarang === "16"){
					$data1["lokasi"] = $data['lokasi'];
				}
				if ($query->qtty !== null && $query->qtty > 0 && $query->qtty !== $data['qtty']) {
					$awalNilai = max($query->qtty + $query1->qtty, 0);
					$data1["qtty"] = max($awalNilai - $data['qtty'], 0);
				}
				$this->Mmain->qUpdpart("detail_barang", "id_detail_barang", $data['id_detail_barang'], array_keys($data1), array_values($data1));
			}

			$data['tgl_request_update'] = date('Y-m-d\TH:i');
			$data['user_update'] = $this->user['name'];
			$this->Mmain->qUpdpart("detail_request", 'id_detail_request', $id, array_keys($data), array_values($data)); 

			$this->m_detail_req->changeStatusRequest($data['id_request']); 

			$this->session->set_flashdata('success', 'Data Detail Request <strong>Berhasil</strong> Diubah!');
			redirect('request/index/' . $this->get_page_for_id($data['id_request']));
			// redirect("request");

        }
	}

    public function hapus_data($id,$idRequest)
	{
		$data = $this->db->query("SELECT * FROM detail_request WHERE id_detail_request = '".$id."'")->row();
		$query = $this->db->query("SELECT * FROM detail_barang WHERE id_detail_barang = '".$data->id_detail_barang."'")->row();
		$barang = $this->db->query("SELECT * FROM barang WHERE id_barang = '".$query->id_barang."'")->row();
		
		if ($data->status == "Finished") {
			if ($barang->id_satuan === "16"){
				$data1["status"] = "Stored";
				$data1["PIC"] = "";
				$data1["lokasi"] ="IT-STOCKROOM";
				$data1['id_transaksi'] = "";
			}
			$data1["qtty"] = $query->qtty + $data->qtty;
			$this->Mmain->qUpdpart("detail_barang", "id_detail_barang", $data->id_detail_barang, array_keys($data1), array_values($data1));
		}

		$result=$this->Mmain->qDel("Detail_request","id_detail_request",$id);

		$this->m_detail_req->changeStatusRequest($data->id_request);

		if(!$result){
			$this->session->set_flashdata('success', 'Data Detail Request <strong>Berhasil</strong> Dihapus!');
		} else {
			$this->session->set_flashdata('error', 'Data Detail Request <strong>Gagal</strong> Dihapus!');
		}
		
		redirect('request/index/' . $this->get_page_for_id($data->id_request));
	}

	private function get_page_for_id($id) {
		if (!empty($this->session->userdata('keywordReq'))){
			$keyword = $this->session->userdata('keywordReq');
		}
		$position = $this->Mmain->getData('request', $keyword, null, null, $id, true);
		if ($position === 0) {
			return false;
		}
		$per_page = 10;
		return floor(($position - 1) / $per_page) * $per_page;
	}
}
