<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Replace extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
		date_default_timezone_set('Asia/Jakarta');

        $this->load->model('m_replace');
        $this->load->model('M_detail_replace');
		$this->load->model('m_detail_barang');
        $this->load->model('Mmain');
        $this->load->helper('url');
		$this->load->library('form_validation');
		$this->load->library('pagination');

		$this->user = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		if (!$this->session->userdata('email')){
			redirect('auth');
    	}
		$this->form_validation->set_rules('nama', 'Nama PIC', 'required');
        $this->form_validation->set_rules('tgl_replace', 'Tanggal Replace', 'required');
	}

    public function index()
    {
        $data['title'] = 'Replace';
        $data['user'] = $this->user;

		$config['base_url'] = base_url('replace/index/'); 
		$config['per_page'] = 10;
		$config['uri_segment'] = 3;

		$sort_by = $this->input->get('sort_by') ? $this->input->get('sort_by') : 'id_replace';
        $sort_order = $this->input->get('sort_order') ? $this->input->get('sort_order') : 'asc';

		$data['sort_by'] = $sort_by;
        $data['sort_order'] = $sort_order;

		if ($this->input->post('keywordRep')){
			$data['keywordRep'] = $this->input->post('keywordRep');
			$this->session->set_userdata('keywordRep',$data['keywordRep']);
		} elseif ($this->input->post('reset')){
			$data['keywordRep'] = null;
			$this->session->unset_userdata('keywordRep');
		} else {
			$data['keywordRep'] = $this->session->userdata('keywordRep');
		}

		$key = $data['keywordRep'];

		$this->db->from('ganti');
		$config['total_rows'] = $this->db->count_all_results();

		$this->session->set_userdata("total_rows",$config['total_rows']);
		$data['page'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
		$this->pagination->initialize($config);

		$data['Replace'] = $this->Mmain->getData('replace', $data['keywordRep'], $config['per_page'], $data['page']);

		if (!empty($key)) {
			$res = $this->Mmain->qRead(
				"detail_ganti WHERE serial_code LIKE '%$key%'"
			)->result();
			if(!$res==null){
				$data['Detail_Replace'] = $res;
			} else{
				$data['Detail_Replace'] = $this->Mmain->qRead(
					"detail_ganti"
				)->result();
			}
		} else {
			$data['Detail_Replace'] = $this->Mmain->qRead(
				"detail_ganti"
			)->result();
		}

		$data['pagination'] = $this->pagination->create_links();
        $data['content'] = $this->load->view('pages/replace/replace', $data,true);
		$this->load->view('layout/master_layout', $data);
    }

    public function tambah_data_replace()
    {
        $data['title'] = 'Replace';
        $render = $this->Mmain->qRead("ganti");
		$data['Replace'] = $render->result();
        $data['barang'] = $this->m_replace->getid();
        $data['user'] = $this->user;

        $data['content'] = $this->load->view('pages/replace/add_replace', $data,true);
		$this->load->view('layout/master_layout', $data);
    }
    public function proses_tambah_replace()
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
				"nama" => $this->input->post('nama'),
				"tgl_replace" => $this->input->post('tgl_replace'),
				"keterangan" => $this->input->post('keterangan'),
			);
			
			$id = $this->Mmain->autoId("ganti","id_replace","R","R"."001","001");

			$data['id_replace'] = $id;

			$this->Mmain->qIns("ganti", $data);
			$this->session->set_flashdata('success', 'Data Replace <strong>Berhasil</strong> Ditambahkan!');
       		redirect('Detail_Replace/tambah_data_detail/'.$id);
		}
    }
    

    public function edit_replace($id)
    {
        $data['title'] = 'Replace';
        $data['Replace'] = $this->m_replace->edit_replace($id);
		$data['barang'] = $this->m_replace->getid();
		$data['detail_barang'] = $this->m_replace->getseri();
		$data['user'] = $this->user;
		$data['id'] = $id;

		$data['content'] = $this->load->view('pages/replace/edit_replace', $data,true);
		$this->load->view('layout/master_layout', $data);
    }

	public function proses_edit_replace($id)
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
				'nama' => $this->input->post('nama'),
				'tgl_replace' => $this->input->post('tgl_replace'),
				'keterangan' => $this->input->post('keterangan'),
			];

			$this->Mmain->qUpdpart("ganti", 'id_replace', $id, array_keys($data), array_values($data));

			$this->session->set_flashdata('success', 'Data <strong>Berhasil</strong> Diubah!');
			redirect('replace/index/' . $this->get_page_for_id($id));
		}
	}
    
	public function accept($id){
		$data['status'] = $data2['status'] = "Finished";
		$status_get = $this->db->query('SELECT id_barang,lokasi,qtty,status,id_detail_replace,id_detail_barang FROM detail_ganti WHERE id_replace = "'.$id.'"')->result();
		foreach ($status_get as $sg){
			$query = $this->db->query("
				SELECT qtty, status 
				FROM detail_barang 
				WHERE id_detail_barang = '".$sg->id_detail_barang."'
			")->row();

			$satuanBarang = $this->db->query('SELECT id_satuan FROM barang WHERE id_barang ="'.$sg->id_barang.'"')->row()->id_satuan;
			if($satuanBarang === "16"){
				$data1["PIC"] = $this->db->query("SELECT nama FROM ganti WHERE id_replace ='".$id."'")->row()->nama;
				$data1["status"] = "In-Used";
				$data1["lokasi"] = $sg->lokasi;
				$data1["id_transaksi"] = $sg->id_detail_replace;
			}
			if ($query->qtty !== null && $query->qtty > 0 && $sg->status !== "Finished") {
				$data1["qtty"] = max($query->qtty - $sg->qtty, 0);
			}
			if(!empty($data1)){
				$this->Mmain->qUpdpart("detail_barang", "id_detail_barang", $sg->id_detail_barang, array_keys($data1), array_values($data1));
			}
			$data2['tgl_replace_update'] = date('Y-m-d\TH:i');
			$data2['user_update'] = $this->user['name'];
			$this->Mmain->qUpdpart("detail_ganti", 'id_detail_replace', $sg->id_detail_replace, array_keys($data2), array_values($data2));
		}

		if($status_get){
			$this->Mmain->qUpdpart("ganti", 'id_replace', $id, array_keys($data), array_values($data));
			$this->session->set_flashdata('success', 'Status Replace Barang Diterima!');
		} else {
			$this->session->set_flashdata('failed', 'Status Replace Barang Gagal Diproses!');
		}

		redirect('replace/index/' . $this->get_page_for_id($id));

	}

	public function reject($id){
		$data['status'] = $data2['status'] = "Rejected";
		$status_get = $this->db->query('SELECT id_barang,lokasi,qtty,status,id_detail_replace,id_detail_barang FROM detail_ganti WHERE id_replace = "'.$id.'"')->result();
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
			$data2['tgl_replace_update'] = date('Y-m-d\TH:i');
			$data2['user_update'] = $this->user['name'];
			$this->Mmain->qUpdpart("detail_ganti", 'id_detail_replace', $sg->id_detail_replace, array_keys($data2), array_values($data2));
		}

		if($status_get){
			$this->Mmain->qUpdpart("ganti", 'id_replace', $id, array_keys($data), array_values($data));
			$this->session->set_flashdata('success', 'Status Replace Barang Ditolak!');
		} else {
			$this->session->set_flashdata('failed', 'Status Replace Barang Gagal Diproses!');
		}
		redirect('replace/index/' . $this->get_page_for_id($id));
	}

    public function hapus_replace($id)
    {
		$data = $this->db->query("SELECT * FROM detail_ganti WHERE id_replace = '".$id."'")->result();
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
		$this->Mmain->qDel("detail_ganti", "id_replace", $id);
		$this->Mmain->qDel("ganti", "id_replace", $id);

		if(!$result){
			$this->session->set_flashdata('success', 'Data Replace <strong>Berhasil</strong> Dihapus!');
		} else {
			$this->session->set_flashdata('failed', 'Data Replace <strong>Gagal</strong> Dihapus!');
		}
		redirect('replace/index/' . $this->get_page_for_id($id));
    }
	
	private function get_page_for_id($id) {
		if (!empty($this->session->userdata('keywordRep'))){
			$keyword = $this->session->userdata('keywordRep');
		}
		$position = $this->Mmain->getData('replace', $keyword, null, null, $id, true);
		if ($position === 0) {
			return false;
		}
		$per_page = 10;
		return floor(($position - 1) / $per_page) * $per_page;
		
	}
}
