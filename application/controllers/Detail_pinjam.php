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
		$this->form_validation->set_rules('wkt_kembali', 'Waktu Kembali', 'required');
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
				"wkt_kembali" => $this->input->post('wkt_kembali'),
				"keterangan" => $this->input->post('keterangan'),
            );

			$id_pinjam = $data['id_pinjam'];
			$data['id_detail_pinjam'] = $this->Mmain->autoId("detail_pinjam", "id_detail_pinjam", "DP", "DP" . "001", "001");
			
			$this->Mmain->qIns('detail_pinjam', $data);
			$this->session->set_flashdata('success', 'Data Detail Pinjam <strong>Berhasil</strong> Ditambahkan!');
			redirect("pinjam");
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
				"qtty" => $this->input->post('qtty'),
				"lokasi" => $this->input->post('lokasi'),
				"wkt_kembali" => $this->input->post('wkt_kembali'),
				'status'=> $this->input->post('status'),
				"keterangan" => $this->input->post('keterangan'),
            );

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
			$satuanBarang = $this->db->query('SELECT id_satuan FROM barang WHERE id_barang ="'.$query->id_barang.'"')->row();

			if (($query1->status == 'Requested' || $query1->status == 'Rejected') && $data['status'] == 'Finished') {
				if($satuanBarang === "16"){
					$data1["PIC"] = $this->db->query("SELECT nama_peminjam FROM pinjam WHERE id_pinjam ='".$data['id_pinjam']."'")->row()->nama_peminjam;
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
					$data1["PIC"] = "";
					$data1["lokasi"] = "IT-STOCKROOM";
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
			$this->Mmain->qUpdpart("detail_pinjam", 'id_detail_pinjam', $id, array_keys($data), array_values($data)); 

			$this->session->set_flashdata('success', 'Data Detail Pinjam <strong>Berhasil</strong> Diubah!');
			redirect("pinjam");
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

		if (!$result) {
			$this->session->set_flashdata('success', 'Data Detail Pinjam <strong>Berhasil</strong> Dihapus!');
		} else {
			$this->session->set_flashdata('failed', 'Data Detail Pinjam <strong>Gagal</strong> Dihapus!');
		}
		redirect("pinjam");
	}
}



