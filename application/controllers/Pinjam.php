<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pinjam extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
		date_default_timezone_set('Asia/Jakarta');

        $this->load->model('m_pinjam');
        $this->load->model('Mmain');
        $this->load->helper('url');
		$this->user = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$this->load->library('pagination');
		if (!$this->session->userdata('email')){
			redirect('auth');
    	}
		$this->form_validation->set_rules('nama_peminjam', 'Nama Peminjam', 'required');
		$this->form_validation->set_rules('nama_penerima', 'Nama Penerima', 'required');
		$this->form_validation->set_rules('nama_pemberi', 'Nama Pemberi', 'required');
		$this->form_validation->set_rules('wkt_pinjam', 'Waktu Pinjam', 'required');
	}

    public function index()
    {
        $data['title'] = 'Pinjam';
        $data['user'] = $this->user;
		
		$config['base_url'] = base_url('pinjam/index/'); 
		$config['per_page'] = 5;
		$config['uri_segment'] = 3;
		
		if ($this->input->post('keywordPin')){
			$data['keywordPin'] = $this->input->post('keywordPin');
			$this->session->set_userdata('keywordPin',$data['keywordPin']);
		} elseif ($this->input->post('reset')){
			$data['keywordPin'] = null;
			$this->session->unset_userdata('keywordPin');
		} else {
			$data['keywordPin'] = $this->session->userdata('keywordPin');
		}

		$key = $data['keywordPin'];

		$this->db->from('pinjam');
		$config['total_rows'] = $this->db->count_all("pinjam");
		$data['page'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
		$this->pagination->initialize($config);

		$data['Pinjam'] = $this->Mmain->getPinjam($data['keywordPin'], $config['per_page'], $data['page']);
		
		if (!empty($key)) {
			$res = $this->Mmain->qRead(
				"detail_pinjam WHERE serial_code LIKE '%$key%'"
			)->result();
			if(!$res==null){
				$data['Detail_pinjam'] = $res;
			} else {
				$data['Detail_pinjam'] = $this->Mmain->qRead(
					"detail_pinjam"
				)->result();
			}
		} else {
			$data['Detail_pinjam'] = $this->Mmain->qRead(
				"detail_pinjam"
			)->result();
		}

		$data['pagination'] = $this->pagination->create_links();

        $data['content'] = $this->load->view('pages/pinjam/pinjam', $data,true);
		$this->load->view('layout/master_layout', $data);
    }
	
    public function tambah_pinjam()
    {
        $data['title'] = 'Pinjam';
        $data['user'] = $this->user;

		$data['barang'] = $this->Mmain->qRead("barang")->result();

		$data['content'] = $this->load->view('pages/pinjam/tambah_data', $data,true);
		$this->load->view('layout/master_layout', $data);
    }
    public function proses_tambah()
    {
        if ($this->session->login['role'] == 'admin') {
            $this->session->set_flashdata('error', 'Tambah data hanya untuk admin!');
            redirect('dashboard');
        }

		if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('failed', validation_errors());
			redirect($_SERVER['HTTP_REFERER']);
        } else {
            $data = [
				'nama_peminjam' => $this->input->post('nama_peminjam'),
				'nama_penerima' => $this->input->post('nama_penerima'),
				'nama_pemberi' => $this->input->post('nama_pemberi'),
				'wkt_pinjam' => $this->input->post('wkt_pinjam'),
				'keterangan' => $this->input->post('keterangan'),
			];

			$data['id_pinjam'] = $this->Mmain->autoId("pinjam", "id_pinjam", "PJ", "PJ" . "001", "001");
			$this->Mmain->qIns("pinjam", $data);

			$this->session->set_flashdata('success', 'Data Pinjam <strong>Berhasil</strong> Ditambahkan!');
			redirect('pinjam');
        }
    }
    public function edit_data($id)
    {
        $data['title'] = 'Pinjam';
        $data['Pinjam'] = $this->m_pinjam->edit_data($id);
        $data['user'] = $this->user;
		$data['id'] = $id;
		$data['content'] = $this->load->view('pages/pinjam/edit_data', $data,true);
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
            $data = [
				'nama_peminjam' => $this->input->post('nama_peminjam'),
				'nama_penerima' => $this->input->post('nama_penerima'),
				'nama_pemberi' => $this->input->post('nama_pemberi'),
				'wkt_pinjam' => $this->input->post('wkt_pinjam'),
				'keterangan' => $this->input->post('keterangan'),
			];

			$this->Mmain->qUpdpart('pinjam', 'id_pinjam', $id , array_keys($data) , array_values($data));

			$this->session->set_flashdata('success', 'Data Pinjam <strong>Berhasil</strong> Diubah!');
			redirect('pinjam');
        }
	}

    public function hapus_data($id)
    {
		$data = $this->db->query("SELECT * FROM detail_pinjam WHERE id_pinjam = '".$id."'")->row();
		$query = $this->db->query("SELECT * FROM detail_barang WHERE id_detail_barang = '".$data->id_detail_barang."'")->row();
		$barang = $this->db->query("SELECT * FROM barang WHERE id_barang = '".$query->id_barang."'")->row();
		
		if ($data->status == "Finished") {
			if($barang->id_satuan === "16"){
				$data1["status"] = "Stored";
				$data1["PIC"] = null;
				$data1["lokasi"] = "IT STOCKROOM";
			}
			$data1["qtty"] = $query->qtty + $data->qtty;
			$this->Mmain->qUpdpart("detail_barang", "id_detail_barang", $data->id_detail_barang, array_keys($data1), array_values($data1));
		}

		$this->Mmain->qDel("detail_pinjam", "id_pinjam", $id);
		$this->Mmain->qDel("pinjam", "id_pinjam", $id);

		if(!$result){
			$this->session->set_flashdata('success', 'Data Pinjam <strong>Berhasil</strong> Dihapus!');
		} else {
			$this->session->set_flashdata('failed', 'Data Pinjam <strong>Gagal</strong> Dihapus!');
		}
		redirect("pinjam");
    }
}

