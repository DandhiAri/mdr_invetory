<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Detail_pinjam extends CI_Controller
{
	private $mainTable = 'detail_pinjam';
    /* private $mainPk = 'id_pinjam';  */
	
    public function __construct()
    {
        parent::__construct();
        // cek_login();

        $this->load->model('M_detail_pinjam');
		$this->load->model('m_pinjam');
        $this->load->model('Mmain');
        $this->load->helper('url');
		$this->user = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		
		if (!$this->session->userdata('email')){
			redirect('auth');
		}

		$this->form_validation->set_rules('id_barang', 'ID Barang', 'required');
		$this->form_validation->set_rules('serial_code', 'Serial Code', 'required');
		$this->form_validation->set_rules('qtty', 'Quantity', 'required|integer');
		$this->form_validation->set_rules('lokasi', 'Lokasi', 'required');
		$this->form_validation->set_rules('tgl_kembali', 'Tanggal Kembali', 'required');
		$this->form_validation->set_rules('jam_kembali', 'Jam Kembali', 'required');
    }
	

    public function index()
    {
        $data['title'] = 'Detail pinjam';
        $data['Detail_pinjam'] = $this->M_detail_pinjam->tampil_detail();
		/* echo json_encode($data['Detail_pinjam']); die; */
		$this->load->view('templates/header', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('detail_pinjam/detail_pinjam', $data);
        $this->load->view('templates/footer'); 
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
				"serial_code" => $this->input->post('serial_code'),
				"qtty" => $this->input->post('qtty'),
				"lokasi" => $this->input->post('lokasi'),
				"tgl_kembali" => $this->input->post('tgl_kembali'),
				"jam_kembali" => $this->input->post('jam_kembali'),
				"keterangan" => $this->input->post('keterangan'),
            );

			$id_pinjam = $data['id_pinjam'];
			$data['id_detail_pinjam'] = $this->Mmain->autoId("detail_pinjam", "id_detail_pinjam", "DP", "DP" . "001", "001");
			
			$this->Mmain->qIns('detail_pinjam', $data);
			$this->session->set_flashdata('success', 'Data Barang <strong>Berhasil</strong> Ditambahkan!');
			redirect("pinjam");
        }
    }

    public function edit_data($id)
    {
        $data['title'] = 'Detail Pinjam';
		$data['id'] = $id;
		// $data['Barang'] = $this->Mmain->qRead("barang")->result();
        $data['Detail_pinjam'] = $this->M_detail_pinjam->edit_data($id);
		$data['barang'] = $this->M_detail_pinjam->getBarang();
		$data['detail_barang'] = $this->M_detail_pinjam->getSeri();
		$data['user'] = $this->user;

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
				"id_pinjam" => $this->input->post('id_pinjam'),
				"serial_code" => $this->input->post('serial_code'),
				"qtty" => $this->input->post('qtty'),
				"lokasi" => $this->input->post('lokasi'),
				"tgl_kembali" => $this->input->post('tgl_kembali'),
				"jam_kembali" => $this->input->post('jam_kembali'),
				'status'=> $this->input->post('status'),
				"keterangan" => $this->input->post('keterangan'),
            );

			$id_pinjam = $data['id_pinjam'];
			$this->Mmain->qUpdpart("detail_pinjam", 'id_detail_pinjam', $id, array_keys($data), array_values($data)); // Menambahkan argumen terakhir

			$this->session->set_flashdata('success', 'Data Barang <strong>Berhasil</strong> Diubah!');
			redirect("pinjam");
        }
	}


    public function hapus($id,$idPinjam) 
	{
		$result = $this->Mmain->qDel("detail_pinjam", "id_detail_pinjam", $id);
		
		if ($result) {
			$this->session->set_flashdata('success', 'Data Barang <strong>Berhasil</strong> Dihapus!');
			redirect("pinjam");
		} else {
			$this->session->set_flashdata('error', 'Data Barang <strong>Gagal</strong> Dihapus!');
			redirect("pinjam");
		}
	}
}



