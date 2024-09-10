<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Detail_Replace extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
		date_default_timezone_set('Asia/Jakarta');

        $this->load->model('M_detail_replace');
		$this->load->model('m_detail_barang');
		$this->load->database();
        $this->load->model('Mmain');
        $this->load->helper('url');
		$this->user = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

		$this->load->library('form_validation');
		if (!$this->session->userdata('email')){
			redirect('auth');
   		}
		
		$this->form_validation->set_rules('id_replace', 'ID Replace', 'required');
		$this->form_validation->set_rules('tgl_replace_update', 'Waktu Update Replace', 'required');
		$this->form_validation->set_rules('id_barang', 'ID Barang', 'required');
		$this->form_validation->set_rules('id_detail_barang', 'ID Detail Barang', 'required');
		$this->form_validation->set_rules('qtty', 'Quantity Replace', 'required|integer');
		$this->form_validation->set_rules('lokasi', 'Lokasi', 'required');
	}
	
    public function index()
    {
        $data['title'] = 'Detail Replace';
        $data['Detail_Replace'] = $this->Mmain->qRead('detail_ganti');
		$data['user'] = $this->user;

		$data['content'] = $this->load->view('detail_replace', $data,true);
		$this->load->view('layout/master_layout', $data);
    }
	
	public function init($id)
 	{
        $data['title'] = 'Detail Replace';
		$data['id'] = $id;
		$data['user'] = $this->user;
		
		$render  = $this->Mmain->qRead("ganti r
        INNER JOIN detail_ganti det ON det.id_replace = r.id_replace 
		LEFT JOIN detail_barang db ON db.id_detail_barang = det.id_detail_barang WHERE det.id_replace  = '$id' ", 
		"det.id_detail_replace, det.tgl_replace, det.id_barang, det.qty_replace, det.serial_code, det.lokasi, det.status, det.keterangan, det.id_detail_barang, db.item_description, det.id_replace"); 
        $data['Detail_Replace'] = $render->result();

		$data['content'] = $this->load->view('pages/detail_replace/detail_replace', $data,true);
		$this->load->view('layout/master_layout', $data);
    }
    
	public function tambah_data_detail($id)
	{
        $data['title'] = 'Detail Replace';

		$data['id'] = $id;
		$data['Barang'] = $this->Mmain->qRead("barang")->result();
		$data['detail_barang'] = $this->Mmain->qRead("detail_barang")->result();
		$data['user'] = $this->user;

		$data['content'] = $this->load->view('pages/detail_replace/add_detail', $data,true);
		$this->load->view('layout/master_layout', $data);
    }
   
    public function proses_tambah_detail($id)
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
				"id_replace" => $this->input->post('id_replace'),
				"tgl_replace_update" => $this->input->post('tgl_replace_update'),
				"id_barang" => $this->input->post('id_barang'),
				"id_detail_barang" => $this->input->post('id_detail_barang'),
				"qtty" => $this->input->post('qtty'),
				"serial_code" => $this->input->post('serial_code'),
				"lokasi" => $this->input->post('lokasi'),
				"keterangan" => $this->input->post('keterangan'),
            );
			if ($data['serial_code'] === "-"){
				$data['serial_code'] = "";
			}
			$data['id_detail_replace'] = $this->Mmain->autoId("detail_ganti","id_detail_replace","DRT","DRT"."001","001");
			
			$this->Mmain->qIns('detail_ganti', $data);
			$this->session->set_flashdata('success', 'Data Detail Replace <strong>Berhasil</strong> Ditambahkan!');
			redirect("replace");
        }
    }

    public function edit_detail($id)
    {
        $data['title'] = 'Detail Replace';
        $data['Detail_Replace'] = $this->M_detail_replace->edit_detail($id);
		$data['Barang'] = $this->Mmain->qRead("barang")->result();
		$data['detail_barang'] = $this->Mmain->qRead("detail_barang")->result();
		$data['user'] = $this->user;
		$data['id'] = $id;

		$data['content'] = $this->load->view('pages/detail_replace/edit_detail', $data,true);
		$this->load->view('layout/master_layout', $data);
    }
	
	public function proses_edit_detail($id){
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
                'id_replace' => $this->input->post('id_replace'),
				'tgl_replace_update' => $this->input->post('tgl_replace_update'),
				'id_barang' => $this->input->post('id_barang'),
				'qtty' => $this->input->post('qtty'),
				'serial_code' => $this->input->post('serial_code'),
				'id_detail_barang' => $this->input->post('id_detail_barang'), 
				'lokasi' => $this->input->post('lokasi'),
				'status' => $this->input->post('status'),
				'keterangan' => $this->input->post('keterangan'),
            );
			if ($data['serial_code'] === "-"){
				$data['serial_code'] = "";
			}
			$query = $this->db->query("
				SELECT *
				FROM detail_barang 
				WHERE id_detail_barang = '".$data['id_detail_barang']."'
			")->row();
			$query1 = $this->db->query("
				SELECT * 
				FROM detail_ganti 
				WHERE id_detail_replace = '".$id."'
			")->row();
			$satuanBarang = $this->db->query('SELECT id_satuan FROM barang WHERE id_barang ="'.$query->id_barang.'"')->row();

			if (($query1->status == 'Requested' || $query1->status == 'Rejected') && $data['status'] == 'Finished') {
				if($satuanBarang === "16"){
					$data1["PIC"] = $this->db->query("SELECT nama FROM ganti WHERE id_replace ='".$data['id_replace']."'")->row()->nama;
					$data1["status"] = "In-Used";
					$data1["lokasi"] = $data['lokasi'];
				}
				if ($query->qtty !== null && $query->qtty > 0) {
					$data1["qtty"] = max($query->qtty - $data['qtty'], 0);
				}

				$this->Mmain->qUpdpart("detail_barang", "id_detail_barang", $data['id_detail_barang'], array_keys($data1), array_values($data1));
			
			} elseif ($query1->status == 'Finished' && ($data['status'] == 'Rejected' || $data['status'] == 'Requested')) {
				if($satuanBarang === "16"){
					$data1["status"] = "Stored";
					$data1["PIC"] = null;
					$data1["lokasi"] = "IT STOCKROOM";
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

			$data['tgl_replace_update'] = date('Y-m-d\TH:i');
			$this->Mmain->qUpdpart("detail_ganti", 'id_detail_replace', $id, array_keys($data), array_values($data)); 

			$this->M_detail_replace->changeStatusReplace($data['id_replace']);

			$this->session->set_flashdata('success', 'Data Detail Replace <strong>Berhasil</strong> Diubah!');
			redirect("replace");
        }
	}
   public function del_replace($id)
	{
		$data = $this->db->query("SELECT * FROM detail_ganti WHERE id_detail_replace = '".$id."'")->row();
		$query = $this->db->query("SELECT * FROM detail_barang WHERE id_detail_barang = '".$data->id_detail_barang."'")->row();
		$barang = $this->db->query("SELECT * FROM barang WHERE id_barang = '".$query->id_barang."'")->row();
		
		if ($data->status == "Finished") {
			if ($barang->id_satuan === "16"){
				$data1["status"] = "Stored";
				$data1["PIC"] = "";
				$data1["lokasi"] ="IT-STOCKROOM";
			}
			$data1["qtty"] = $query->qtty + $data->qtty;
			$this->Mmain->qUpdpart("detail_barang", "id_detail_barang", $data->id_detail_barang, array_keys($data1), array_values($data1));
		}

		$result = $this->Mmain->qDel("detail_ganti", "id_detail_replace", $id);

		$this->M_detail_replace->changeStatusReplace($data->id_replace);

		if(!$result){
			$this->session->set_flashdata('success', 'Data Detail Replace <strong>Berhasil</strong> Dihapus!');
		} else {
			$this->session->set_flashdata('error', 'Data Detail Replace <strong>Gagal</strong> Dihapus!');
		}
		
		redirect("replace");
	}
}
