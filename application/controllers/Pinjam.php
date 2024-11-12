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
		$config['per_page'] = 10;
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
		$this->db->join('detail_pinjam', 'pinjam.id_pinjam = detail_pinjam.id_pinjam', 'left');

		if (!empty($key)) {
			$this->db->group_start();
			$this->db->like('detail_pinjam.serial_code', $data['keywordPin']);
			$this->db->or_like('detail_pinjam.id_detail_barang', $data['keywordPin']);
			$this->db->or_like('detail_pinjam.id_detail_pinjam', $data['keywordPin']);
            $this->db->or_like('pinjam.nama_peminjam', $data['keywordPin']);
            $this->db->or_like('pinjam.id_pinjam', $data['keywordPin']);
			$this->db->group_end();
		}
		
		$this->db->select('COUNT(DISTINCT pinjam.id_pinjam) as total');
		$query = $this->db->get();
		$config['total_rows'] = $query->row()->total;
		$data['page'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
		$this->pagination->initialize($config);

		$data['Pinjam'] = $this->Mmain->getData('pinjam',$data['keywordPin'], $config['per_page'], $data['page']);
		
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
			];

			$data['id_pinjam'] = $this->Mmain->autoId("pinjam", "id_pinjam", "PJ", "PJ" . "001", "001");
			$this->Mmain->qIns("pinjam", $data);

			$this->session->set_flashdata('success', 'Data Pinjam <strong>Berhasil</strong> Ditambahkan!');
			redirect('Detail_Pinjam/tambah_detail/'.$data['id_pinjam']);
        }
    }

	public function accept($id){
		$data['status'] = $data2['status'] = "Finished";
		$status_get = $this->db->query('SELECT id_barang,lokasi,qtty,status,id_detail_pinjam,id_detail_barang FROM detail_pinjam WHERE id_pinjam = "'.$id.'"')->result();
		foreach ($status_get as $sg){
			$query = $this->db->query("
				SELECT qtty, status 
				FROM detail_barang 
				WHERE id_detail_barang = '".$sg->id_detail_barang."'
			")->row();

			$satuanBarang = $this->db->query('SELECT id_satuan FROM barang WHERE id_barang ="'.$sg->id_barang.'"')->row()->id_satuan;
			if($satuanBarang === "16"){
				$data1["PIC"] = $this->db->query("SELECT nama_peminjam FROM pinjam WHERE id_pinjam ='".$id."'")->row()->nama;
				$data1["status"] = "In-Used";
				$data1["lokasi"] = $sg->lokasi;
				$data1["id_transaksi"] = $sg->id_detail_pinjam;
			}
			if ($query->qtty !== null && $query->qtty > 0 && $sg->status !== "Finished") {
				$data1["qtty"] = max($query->qtty - $sg->qtty, 0);
			}
			if(!empty($data1)){
				$this->Mmain->qUpdpart("detail_barang", "id_detail_barang", $sg->id_detail_barang, array_keys($data1), array_values($data1));
			}
			$data2['wkt_kembali'] = date('Y-m-d\TH:i');
			$data2['user_update'] = $this->user['name'];
			$this->Mmain->qUpdpart("detail_pinjam", 'id_detail_pinjam', $sg->id_detail_pinjam, array_keys($data2), array_values($data2));
		}

		if($status_get){
			$this->Mmain->qUpdpart("pinjam", 'id_pinjam', $id, array_keys($data), array_values($data));
			$this->session->set_flashdata('success', 'Status Pinjam Barang Diterima!');
		} else {
			$this->session->set_flashdata('failed', 'Status Pinjam Barang Gagal Diproses!');
		}

		redirect('pinjam/index/' . $this->get_page_for_id($id));

	}

	public function reject($id){
		$data['status'] = $data2['status'] = "Rejected";
		$status_get = $this->db->query('SELECT id_barang,lokasi,qtty,status,id_detail_pinjam,id_detail_barang FROM detail_pinjam WHERE id_pinjam = "'.$id.'"')->result();
		foreach ($status_get as $sg){
			$query = $this->db->query("
				SELECT qtty, status 
				FROM detail_barang 
				WHERE id_detail_barang = '".$sg->id_detail_barang."'
			")->row();

			$satuanBarang = $this->db->query('SELECT id_satuan FROM barang WHERE id_barang ="'.$sg->id_barang.'"')->row()->id_satuan;
			if($satuanBarang === "16"){
				$data1["status"] = "Stored";
				$data1["PIC"] = null;
				$data1["lokasi"] = "IT STOCKROOM";
				$data1["id_transaksi"] = "";
			}
			if($sg->status === "Finished"){
				$data1["qtty"] = max($query->qtty + $sg->qtty, 0);
			}
			if(!empty($data1)){
				$this->Mmain->qUpdpart("detail_barang", "id_detail_barang", $sg->id_detail_barang, array_keys($data1), array_values($data1));
			}
			$data2['wkt_kembali'] = null;
			$data2['user_update'] = $this->user['name'];
			$this->Mmain->qUpdpart("detail_pinjam", 'id_detail_pinjam', $sg->id_detail_pinjam, array_keys($data2), array_values($data2));
		}

		if($status_get){
			$this->Mmain->qUpdpart("pinjam", 'id_pinjam', $id, array_keys($data), array_values($data));
			$this->session->set_flashdata('success', 'Status Pinjam Barang Ditolak!');
		} else {
			$this->session->set_flashdata('failed', 'Status Pinjam Barang Gagal Diproses!');
		}
		redirect('pinjam/index/' . $this->get_page_for_id($id));
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
			];

			$this->Mmain->qUpdpart('pinjam', 'id_pinjam', $id , array_keys($data) , array_values($data));

			$this->session->set_flashdata('success', 'Data Pinjam <strong>Berhasil</strong> Diubah!');
			redirect('pinjam/index/' . $this->get_page_for_id($id));
        }
	}

    public function hapus_data($id)
    {
		$data = $this->db->query("SELECT * FROM detail_pinjam WHERE id_pinjam = '".$id."'")->result();
		foreach ($data as $dt){
			$query = $this->db->query("SELECT * FROM detail_barang WHERE id_detail_barang = '".$dt->id_detail_barang."'")->row();
			$barang = $this->db->query("SELECT * FROM barang WHERE id_barang = '".$query->id_barang."'")->row();
			if ($dt->status == "Finished") {
				if($barang->id_satuan === "16"){
					$data1["status"] = "Stored";
					$data1["PIC"] = null;
					$data1["lokasi"] = "IT STOCKROOM";
				}
				$data1["qtty"] = $query->qtty + $dt->qtty;
				$this->Mmain->qUpdpart("detail_barang", "id_detail_barang", $dt->id_detail_barang, array_keys($data1), array_values($data1));
			}
		}

		$this->Mmain->qDel("detail_pinjam", "id_pinjam", $id);
		$this->Mmain->qDel("pinjam", "id_pinjam", $id);

		if(!$result){
			$this->session->set_flashdata('success', 'Data Pinjam <strong>Berhasil</strong> Dihapus!');
		} else {
			$this->session->set_flashdata('failed', 'Data Pinjam <strong>Gagal</strong> Dihapus!');
		}
		redirect('pinjam/index/' . $this->get_page_for_id($id));
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

