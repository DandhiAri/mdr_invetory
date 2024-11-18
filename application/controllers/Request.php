<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Request extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
		date_default_timezone_set('Asia/Jakarta');

        $this->load->model('m_data');
        $this->load->model('Mmain');
        $this->load->model('m_detail_req');
		$this->load->model('m_detail_barang');
        $this->user = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $this->load->helper('url');
		$this->load->library('form_validation');
		$this->load->library('pagination');
		$this->load->library('pdfgenerator');

		$this->itemPerPage = 10;

		if (!$this->session->userdata('email')){
			redirect('auth');
		}
		$this->form_validation->set_rules('nama', 'Nama PIC', 'required');
        $this->form_validation->set_rules('tgl_request', 'Tanggal Request', 'required');
	}


    public function index()
    {
        $data['title'] = 'Request';
        $data['user'] = $this->user;
		
		$config['base_url'] = base_url('request/index/');
		$config['per_page'] = 10;
		$data['per_page'] = $config['per_page'];
		$config['uri_segment'] = 3;
		
		if ($this->input->post('keywordReq')){
			$data['keywordReq'] = $this->input->post('keywordReq');
			$this->session->set_userdata('keywordReq',$data['keywordReq']);
		} elseif ($this->input->post('reset')){
			$data['keywordReq'] = null;
			$this->session->unset_userdata('keywordReq');
		} else {
			$data['keywordReq'] = $this->session->userdata('keywordReq');
		}
		$key = $data['keywordReq'];
		
		$this->db->from('request');
		$this->db->join('detail_request', 'request.id_request = detail_request.id_request', 'left');

		if (!empty($key)) {
			$this->db->group_start();
			$this->db->like('detail_request.serial_code', $data['keywordReq']);
			$this->db->or_like('detail_request.id_detail_barang', $data['keywordReq']);
			$this->db->or_like('detail_request.id_detail_request', $data['keywordReq']);
			$this->db->or_like('request.nama', $data['keywordReq']);
			$this->db->or_like('request.id_request',$data['keywordReq']);
			$this->db->group_end();
		}
		
		$this->db->select('COUNT(DISTINCT request.id_request) as total');
		$query = $this->db->get();
		$config['total_rows'] = $query->row()->total;
		$data['total_rows'] = $config['total_rows'];
		$data['page'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

		$data['Request'] = $this->Mmain->getData('request',$data['keywordReq'], $config['per_page'], $data['page']);
		$this->pagination->initialize($config);
		
		if (!empty($key)) {
			$res = $this->Mmain->qRead(
				"detail_request WHERE serial_code LIKE '%$key%'"
			)->result();
			if(!$res==null){
				$data['Detail_Request'] = $res;
			} else {
				$data['Detail_Request'] = $this->Mmain->qRead(
					"detail_request"
				)->result();
			}
		} else {
			$data['Detail_Request'] = $this->Mmain->qRead(
				"detail_request"
			)->result();
		}
		$data['pagination'] = $this->pagination->create_links();

        $data['content'] = $this->load->view('pages/request/request', $data, true);
		$this->load->view('layout/master_layout',$data);
    }

	private function idNomerSurat($tbl0, $pk0, $prefix, $suffix, $defno, $custno = null) {
		$month = date('n');
		$roman_month = ["I", "II", "III", "IV", "V", "VI", "VII", "VIII", "IX", "X", "XI", "XII"][$month - 1];
		$year = date('y');
		$base_id = "{$prefix}-{$suffix}-{$roman_month}-{$year}";
		$query = $this->db->query("SELECT $pk0 FROM $tbl0 WHERE $pk0 LIKE '{$prefix}-%-{$suffix}-{$roman_month}-{$year}' ORDER BY $pk0 DESC LIMIT 1");
		
		if ($query->num_rows() > 0 && $custno === null) {
			$last_id = $query->row()->$pk0;
			$last_number = (int) substr($last_id, strlen($prefix) + 1, strlen($last_id) - strlen($base_id) - 1);
			$next_number = $last_number + 1;
			$formatted_number = str_pad($next_number, 3, '0', STR_PAD_LEFT);
		} else if ($query->num_rows() > 0 && $custno !== null) {
			$formatted_number = str_pad($custno, 3, '0', STR_PAD_LEFT);
		} else {
			$formatted_number = str_pad($defno ?? '001', 3, '0', STR_PAD_LEFT);
		}
		
		return "{$prefix}-{$formatted_number}-{$suffix}-{$roman_month}-{$year}";
	}

	public function viewSuratJalan($no_surat) {
		$data['user'] = $this->user;
		$data['title'] = $no_surat;

		$data['request'] = $this->db->query('SELECT tgl_request,id_request,nama FROM request WHERE no_surat LIKE "'.$no_surat.'"')->row();
		$data['detail_request'] = $this->db->query('SELECT detail_request.*, barang.nama_barang FROM detail_request INNER JOIN barang ON barang.id_barang = detail_request.id_barang WHERE detail_request.id_request = "' . $data['request']->id_request . '"')->result();
		$data['barang'] = $this->db->query('SELECT * FROM barang')->result();

		$id = $data['request']->id_request;
		$data3['status'] = $data2['status'] = "Finished";
		$status_get = $this->db->query('SELECT id_barang,lokasi,qtty,status,id_detail_request,id_detail_barang FROM detail_request WHERE id_request = "'.$id.'"')->result();
		foreach ($status_get as $sg){
			$query = $this->db->query("
				SELECT qtty, status 
				FROM detail_barang 
				WHERE id_detail_barang = '".$sg->id_detail_barang."'
			")->row();
			$satuanBarang = $this->db->query('SELECT id_satuan FROM barang WHERE id_barang ="'.$sg->id_barang.'"')->row()->id_satuan;
			if($satuanBarang === "16"){
				$data1["PIC"] = $this->db->query("SELECT nama FROM request WHERE id_request ='".$id."'")->row()->nama;
				$data1["status"] = "In-Used";
				$data1["lokasi"] = $sg->lokasi;
				$data1["id_transaksi"] = $sg->id_detail_request;
			}
			if ($query->qtty !== null && $query->qtty > 0 && $sg->status !== "Finished") {
				$data1["qtty"] = max($query->qtty - $sg->qtty, 0);
			} 
			if(!empty($data1) ){
				$this->Mmain->qUpdpart("detail_barang", "id_detail_barang", $sg->id_detail_barang, array_keys($data1), array_values($data1));
			}
			$data2['tgl_request_update'] = date('Y-m-d\TH:i');
			$data2['user_update'] = $this->user['name'];
			$this->Mmain->qUpdpart("detail_request", 'id_detail_request', $sg->id_detail_request, array_keys($data2), array_values($data2));
			$this->Mmain->qUpdpart("request", 'id_request', $id, array_keys($data3), array_values($data3));
		}

        $html = $this->load->view('layout/pdfLayout/suratJalan', $data, true);
        $this->pdfgenerator->generate($html, $data['title']);
    }


    public function tambah()
    {
        $data['title'] = 'Request';
		$render = $this->Mmain->qRead("request");
		$data['Request'] = $render->result();
		$data['Barang'] = $this->m_detail_barang->getBarang();
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

		$data['content'] = $this->load->view('pages/request/addrequest', $data, true);
		$this->load->view('layout/master_layout',$data);
    }

    public function proses_tambah()
    {
        if ($this->session->login['role'] == 'admin') {
            $this->session->set_flashdata('failed', 'Tambah data hanya untuk admin!');
            redirect('dashboard');
        }

		if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('failed', validation_errors());
			redirect($_SERVER['HTTP_REFERER']);
        } else {
            $data = array(
                'nama' => $this->input->post('nama'),
                'tgl_request' => $this->input->post('tgl_request'),
            );
			$data['id_request'] = $id = $this->Mmain->autoId("request","id_request","RQ","RQ"."001","001");
			$data['no_surat'] = $this->idNomerSurat('request', 'no_surat', 'MDR-DN', 'SC', '001');
			
			$this->Mmain->qIns('request', $data);
            $this->session->set_flashdata('success', 'Data Request sudah ditambahkan');
			redirect('detail_request/tambah/'.$id);
        }
    }

	public function accept($id){
		$data['status'] = $data2['status'] = "Finished";
		$status_get = $this->db->query('SELECT id_barang,lokasi,qtty,status,id_detail_request,id_detail_barang FROM detail_request WHERE id_request = "'.$id.'"')->result();
		foreach ($status_get as $sg){
			$query = $this->db->query("
				SELECT qtty, status 
				FROM detail_barang 
				WHERE id_detail_barang = '".$sg->id_detail_barang."'
			")->row();
			$satuanBarang = $this->db->query('SELECT id_satuan FROM barang WHERE id_barang ="'.$sg->id_barang.'"')->row()->id_satuan;
			if($satuanBarang === "16"){
				$data1["PIC"] = $this->db->query("SELECT nama FROM request WHERE id_request ='".$id."'")->row()->nama;
				$data1["status"] = "In-Used";
				$data1["lokasi"] = $sg->lokasi;
				$data1["id_transaksi"] = $sg->id_detail_request;
			}
			if ($query->qtty !== null && $query->qtty > 0 && $sg->status !== "Finished") {
				$data1["qtty"] = max($query->qtty - $sg->qtty, 0);
			} 
			if(!empty($data1) ){
				$this->Mmain->qUpdpart("detail_barang", "id_detail_barang", $sg->id_detail_barang, array_keys($data1), array_values($data1));
			}
			$data2['tgl_request_update'] = date('Y-m-d\TH:i');
			$data2['user_update'] = $this->user['name'];
			$this->Mmain->qUpdpart("detail_request", 'id_detail_request', $sg->id_detail_request, array_keys($data2), array_values($data2));
		}

		if($status_get){
			$this->Mmain->qUpdpart("request", 'id_request', $id, array_keys($data), array_values($data));
			$this->session->set_flashdata('success', 'Request Barang Berhasil Diterima!');
		} else {
			$this->session->set_flashdata('failed', 'Request Barang Gagal Diterima!');
		}

		redirect('request/index/' . $this->get_page_for_id($id));
	}

	public function reject($id){
		$data['status'] = $data2['status'] = "Rejected";
		$status_get = $this->db->query('SELECT id_barang,lokasi,qtty,status,id_detail_request,id_detail_barang FROM detail_request WHERE id_request = "'.$id.'"')->result();
		
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
			if(!empty($data1) ){
				$this->Mmain->qUpdpart("detail_barang", "id_detail_barang", $sg->id_detail_barang, array_keys($data1), array_values($data1));
			}
			$data2['tgl_request_update'] = date('Y-m-d\TH:i');
			$data2['user_update'] = $this->user['name'];
			$this->Mmain->qUpdpart("detail_request", 'id_detail_request', $sg->id_detail_request, array_keys($data2), array_values($data2));
		}

		if($status_get){
			$this->Mmain->qUpdpart("request", 'id_request', $id, array_keys($data), array_values($data));
			$this->session->set_flashdata('success', 'Request Barang Berhasil Ditolak!');
		} else {
			$this->session->set_flashdata('failed', 'Request Barang Gagal Ditolak!');
		}
		redirect('request/index/' . $this->get_page_for_id($id));
	}

    public function edit($id){
        $data['title'] = 'Request';
        $data['Request'] = $this->m_data->edit_request($id);
		$data['barang'] = $this->m_detail_barang->getBarang();
        $data['user'] = $this->user;
		$data['id'] = $id;

		$data['content'] = $this->load->view('pages/request/edit_request', $data, true);
		$this->load->view('layout/master_layout',$data);
    }
	
	public function proses_ubah($id)
	{
		if ($this->session->login['role'] == 'admin') {
			$this->session->set_flashdata('failed', 'Ubah data hanya untuk admin!');
			redirect('dashboard');
		}
		if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('failed', validation_errors());
			redirect($_SERVER['HTTP_REFERER']);
        } else {
			$data = [
				'nama' => $this->input->post('nama'),
				'tgl_request' => $this->input->post('tgl_request'),
				'no_surat' => $this->input->post('no_surat'),
			];
			$last_nosurat = $this->db->query('SELECT no_surat FROM Request WHERE id_request LIKE "'.$id.'"')->row()->no_surat;
			if (!empty($data['no_surat'])){
				if ( empty($last_nosurat) || $last_nosurat !== $data['no_surat'] && !empty($data['no_surat'])){
					$data['no_surat'] = $this->idNomerSurat('request', 'no_surat', 'MDR-DN', 'SC', null, $data['no_surat']);
				}
			} else {
				$data['no_surat'] = null;
			}
			$dereq = $this->db->query("SELECT * FROM detail_request WHERE id_request = '".$id."'")->row();
			$query = $this->db->query("SELECT * FROM detail_barang WHERE id_detail_barang = '".$dereq->id_detail_barang."'")->row();
			
			if ($query) {
				if ($dereq->status == "Finished") {
					$data1["PIC"] = $data['nama'];
					$this->Mmain->qUpdpart("detail_barang", "id_detail_barang", $dereq->id_detail_barang, array_keys($data1), array_values($data1));
				}
				$this->Mmain->qUpdpart("request", 'id_request', $id, array_keys($data), array_values($data));
				$this->session->set_flashdata('success', 'Data Request <strong>Berhasil</strong> Diubah!');
			} else {
				$this->session->set_flashdata('failed', 'ID Detail Barang tidak ada!');
			}
			
			redirect('request/index/' . $this->get_page_for_id($id));
		}
	}

    public function hapus_data($id)
	{
		$data = $this->db->query("SELECT * FROM detail_request WHERE id_request = '".$id."'")->result();
		foreach ($data as $dt){
			$query = $this->db->query("SELECT * FROM detail_barang WHERE id_detail_barang = '".$dt->id_detail_barang."'")->row();
			$barang = $this->db->query("SELECT * FROM barang WHERE id_barang = '".$query->id_barang."'")->row();
			if ($dt->status == "Finished") {
				if($barang->id_satuan === "16"){
					$data1["status"] = "Stored";
					$data1["PIC"] = null;
					$data1["lokasi"] = "IT STOCKROOM";
					$data1['id_transaksi'] = "";
				}
				$data1["qtty"] = $query->qtty + $dt->qtty;
				$this->Mmain->qUpdpart("detail_barang", "id_detail_barang", $dt->id_detail_barang, array_keys($data1), array_values($data1));
			}
		}
		$this->Mmain->qDel("detail_request", "id_request", $id);
		$this->Mmain->qDel("request", "id_request", $id);

		if(!$result){
			$this->session->set_flashdata('success', 'Data Request <strong>Berhasil</strong> Dihapus!');
		} else {
			$this->session->set_flashdata('failed', 'Data Request <strong>Gagal</strong> Dihapus!');
		}
		redirect('request/index/' . $this->get_page_for_id($id));
	}

	public function suratJalan($id){
		$barang = $this->db->query("SELECT * FROM barang WHERE id_barang ='".$id."'")->result();
		$jumlahBarang = $this->db->query("SELECT * FROM detail_barang WHERE id_barang ='".$id."'")->result();
		
		$data['title'] = "Data Random";
		$file_pdf = $data['title'];
		$paper = 'A4';
		$orientation = "landscape";
		$html = $this->load->view('V_test_data', $data, true);
		$this->pdfgenerator->generate($html, $file_pdf, $paper, $orientation);
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
