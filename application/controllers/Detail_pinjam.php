<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Detail_Pinjam extends CI_Controller
{
	private $mainTable = 'detail_pinjam';
    /* private $mainPk = 'id_pinjam';  */
	
    public function __construct()
    {
        parent::__construct();
		date_default_timezone_set('Asia/Jakarta');

        $this->load->model('M_detail_pinjam');
		$this->load->model('m_pinjam');
        $this->load->model('Mmain');
        $this->load->helper('url');
		$this->user = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		
		if (!$this->session->userdata('email')){
			redirect('auth');
		}

		$this->form_validation->set_rules('id_barang', 'Nama Barang', 'required');
		$this->form_validation->set_rules('id_detail_barang', 'ID Detail Barang','required');
		$this->form_validation->set_rules('qtty', 'Quantity', 'required|integer');
		$this->form_validation->set_rules('lokasi', 'Lokasi', 'required');
    }
	
	public function init($id)
    {
        $data['title'] = 'Detail pinjam';
		$data['id'] = $id;
		$data['Detail_pinjam'] = $this->M_detail_pinjam->tampil_detail($id)->result();
		$data['user'] = $this->user;

		$data['content'] = $this->load->view('pages/detail_pinjam/detail_pinjam', $data,true);
		$this->load->view('layout/master_layout', $data);
    }
	
    public function tambah_detail($id)
    {
		
        $data['title'] = 'Detail Pinjam';
		$data['id'] = $id;

		$data['Barang'] = $this->Mmain->qRead("barang")->result();
		$data['Detail_Replace'] = $this->Mmain->qRead("detail_barang")->result();
		$data['user'] = $this->user;

		$data['content'] = $this->load->view('pages/detail_pinjam/tambah_data', $data,true);
		$this->load->view('layout/master_layout', $data);
    }
	
    public function proses_tambah()
    {
        if ($this->session->login['role'] == 'admin') {
            $this->session->set_flashdata('error', 'Tambah data hanya untuk admin!');
            redirect('dashboard');
        }
		
		$this->form_validation->set_rules('id_pinjam', 'ID Pinjam', 'required');
		
		if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('failed', validation_errors());
			redirect($_SERVER['HTTP_REFERER']);
        } else {
            $data = array(
				"id_pinjam" => $this->input->post('id_pinjam'),
				"id_barang" => $this->input->post('id_barang'),
				"id_detail_barang" => $this->input->post('id_detail_barang'),
				"serial_code" => $this->input->post('serial_code'),
				"qtty" => $this->input->post('qtty'),
				"lokasi" => $this->input->post('lokasi'),
				"keterangan" => $this->input->post('keterangan'),
            );
			if ($data['serial_code'] === "-"){
				$data['serial_code'] = "";
			}
			$id_pinjam = $data['id_pinjam'];
			$data['id_detail_pinjam'] = $this->Mmain->autoId("detail_pinjam", "id_detail_pinjam", "DPJ", "DPJ" . "001", "001");
			$data['user_create'] = $this->user['name'];
			$this->Mmain->qIns('detail_pinjam', $data);

			$this->M_detail_pinjam->changeStatusPinjam($data['id_pinjam']);

			$this->session->set_flashdata('success', 'Data Detail Pinjam <strong>Berhasil</strong> Ditambahkan!');
			redirect('pinjam/index/' . $this->get_page_for_id($data["id_pinjam"]));
        }
    }

    public function edit_data($id)
    {
        $data['title'] = 'Detail Pinjam';
		$data['user'] = $this->user;
		$data['id'] = $id;
        $data['Detail_pinjam'] = $this->M_detail_pinjam->edit_data($id);
		$data['barang'] = $this->Mmain->qRead('barang')->result();

		$data['content'] = $this->load->view('pages/detail_pinjam/edit', $data,true);
		$this->load->view('layout/master_layout', $data);
    }

	public function proses_ubah($id)
	{
		if ($this->session->login['role'] == 'admin') {
			$this->session->set_flashdata('error', 'Ubah data hanya untuk admin!');
			redirect('dashboard');
		}
		
		if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('failed', validation_errors());
			redirect($_SERVER['HTTP_REFERER']);
        } else {
            $data = array(
				"id_barang" => $this->input->post('id_barang'),
				"id_detail_barang" => $this->input->post('id_detail_barang'),
				"id_pinjam" => $this->input->post('id_pinjam'),
				"serial_code" => $this->input->post('serial_code'),
				"wkt_kembali" => $this->input->post('wkt_kembali'),
				"qtty" => $this->input->post('qtty'),
				"lokasi" => $this->input->post('lokasi'),
				'status'=> $this->input->post('status'),
				"keterangan" => $this->input->post('keterangan'),
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
				SELECT status 
				FROM detail_pinjam
				WHERE id_detail_pinjam = '".$id."'
			")->row();
			$satuanBarang = $this->db->query('SELECT id_satuan FROM barang WHERE id_barang ="'.$data['id_barang'].'"')->row()->id_satuan;
			
			if (($query1->status == 'Requested' || $query1->status == 'Rejected') && $data['status'] == 'Finished') {
				if($satuanBarang === "16"){
					$data1["PIC"] = $this->db->query("SELECT nama_peminjam FROM pinjam WHERE id_pinjam ='".$data['id_pinjam']."'")->row()->nama_peminjam;
					$data1["status"] = "In-Used";
					$data1["lokasi"] = $data['lokasi'];
					$data1["id_transaksi"] = $id;
				}
				if ($query->qtty !== null && $query->qtty > 0) {
					$data1["qtty"] = max($query->qtty - $data['qtty'], 0);
				}
				if(empty($data['wkt_kembali'])){
					$data['wkt_kembali'] = date('Y-m-d\TH:i');
				}
			} elseif ($query1->status == 'Finished' && ($data['status'] == 'Rejected' || $data['status'] == 'Requested')) {
				if($satuanBarang === "16"){
					$data1["status"] = "Stored";
					$data1["PIC"] = "";
					$data1["lokasi"] = "IT-STOCKROOM";
					$data1["id_transaksi"] = "";
				}
				if ($query1->status == "Finished"){
					$data1["qtty"] = max($query->qtty + $data['qtty'], 0);
				}
				$data['wkt_kembali'] = null;
				
			} elseif ($data['status'] == 'Finished' && $query1->status == 'Finished' ){
				if($satuanBarang === "16"){
					$data1["lokasi"] = $data['lokasi'];
				}
			} 

			if(!empty($data1)){
				$this->Mmain->qUpdpart("detail_barang", "id_detail_barang", $data['id_detail_barang'], array_keys($data1), array_values($data1));
			}
			$data['user_update'] = $this->user['name'];
			$this->Mmain->qUpdpart("detail_pinjam", 'id_detail_pinjam', $id, array_keys($data), array_values($data)); 

			$this->M_detail_pinjam->changeStatusPinjam($data['id_pinjam']);

			$this->session->set_flashdata('success', 'Data Detail Pinjam <strong>Berhasil</strong> Diubah!');
			
			redirect('pinjam/index/' . $this->get_page_for_id($data["id_pinjam"]));
        }
	}

    public function hapus($id) 
	{
		$data = $this->db->query("SELECT * FROM detail_pinjam WHERE id_detail_pinjam = '".$id."'")->row();
		$query = $this->db->query("SELECT * FROM detail_barang WHERE id_detail_barang = '".$data->id_detail_barang."'")->row();
		$barang = $this->db->query("SELECT * FROM barang WHERE id_barang = '".$query->id_barang."'")->row();
		if ($data->status == "Finished") {
			if ($barang->id_satuan === "16"){
				$data1["status"] = "Stored";
				$data1["PIC"] = "";
				$data1["lokasi"] = "IT-STOCKROOM";
			}
			$data1["qtty"] = $query->qtty + $data->qtty;
			$this->Mmain->qUpdpart("detail_barang", "id_detail_barang", $data->id_detail_barang, array_keys($data1), array_values($data1));
		}

		$result = $this->Mmain->qDel("detail_pinjam", "id_detail_pinjam", $id);
		
		$this->M_detail_pinjam->changeStatusPinjam($data->id_pinjam);

		if (!$result) {
			$this->session->set_flashdata('success', 'Data Detail Pinjam <strong>Berhasil</strong> Dihapus!');
		} else {
			$this->session->set_flashdata('failed', 'Data Detail Pinjam <strong>Gagal</strong> Dihapus!');
		}
		redirect('pinjam/index/' . $this->get_page_for_id($data->id_pinjam));
	}

	private function get_page_for_id($id) {
		if (!empty($this->session->userdata('keywordPin'))){
			$keyword = $this->session->userdata('keywordPin');
		}
		$position = $this->Mmain->getData('pinjam', $keyword, null, null, $id, true);
		if ($position === 0) {
			return false;
		}
		$per_page = 10;
		return floor(($position - 1) / $per_page) * $per_page;
	}
}



