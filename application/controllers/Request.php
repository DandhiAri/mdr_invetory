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
		$this->load->model('m_detail_barang');
        $this->user = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $this->load->helper('url');
		$this->load->library('form_validation');
		$this->load->library('pagination');

		if (!$this->session->userdata('email')){
			redirect('auth');
		}
	}

    public function index()
    {
        $data['title'] = 'Request';
        $data['user'] = $this->user;
		
		$config['base_url'] = base_url('request/index/'); 
		$config['per_page'] = 5;
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

		if (!empty($data['keywordReq'])) {
            $this->db->like('request.nama', $data['keywordReq']);
			$serial = $this->db->or_like('detail_request.serial_code', $data['keywordReq']);
        }
		
		$this->db->from('request');
		$config['total_rows'] = $this->db->count_all_results();

		$data['page'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
		$this->pagination->initialize($config);
		$limit = $config['per_page'];
		$start = $data['page'];

		$data['Request'] = $this->Mmain->getRequest($data['keywordReq'], $config['per_page'], $data['page']);
		
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

    public function tambah()
    {
        $data['title'] = 'Request';
        //$data['Request'] = $this->m_data->tampil_datarequest()->result();
		$render=$this->Mmain->qRead("request");
		$data['Request'] = $render->result();
		$data['Barang'] = $this->m_detail_barang->getBarang();
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

		$data['content'] = $this->load->view('pages/request/addrequest', $data, true);
		$this->load->view('layout/master_layout',$data);
    }

    public function proses_tambah()
    {
        if ($this->session->login['role'] == 'admin') {
            $this->session->set_flashdata('error', 'Tambah data hanya untuk admin!');
            redirect('dashboard');
        }
		
		$this->form_validation->set_rules('nama', 'Nama PIC', 'required');
        $this->form_validation->set_rules('tgl_request', 'Tanggal Request', 'required');

		if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('failed', validation_errors());
			redirect($_SERVER['HTTP_REFERER']);
        } else {
            $data = array(
                'nama' => $this->input->post('nama'),
                'tgl_request' => $this->input->post('tgl_request'),
                'keterangan' => $this->input->post('keterangan'),
            );
			$id = $this->Mmain->autoId("request","id_request","RQ","RQ"."001","001");
			$data['id_request'] = $id;
			$this->Mmain->qIns('request', $data);

            $this->session->set_flashdata('success', 'Data Request sudah ditambahkan');
			redirect('detail_request/tambah/'.$id);
        }
    }

    public function edit($id){
        $data['title'] = 'Request';
        $data['Request'] = $this->m_data->edit_request($id);
		$data['barang'] = $this->m_detail_barang->getBarang();
        $data['user'] = $this->user;

		$data['content'] = $this->load->view('pages/request/edit_request', $data, true);
		$this->load->view('layout/master_layout',$data);
    }
	
	public function proses_ubah()
	{
		if ($this->session->login['role'] == 'admin') {
			$this->session->set_flashdata('error', 'Ubah data hanya untuk admin!');
			redirect('dashboard');
		}
		$id = $this->input->post('id_request');
		$data = [
			'id_request' => $id,
            'nama' => $this->input->post('nama'),
            'tgl_request' => $this->input->post('tgl_request'),
            'keterangan' => $this->input->post('keterangan'),
			'status' => $this->input->post('status'),
		];
		$this->Mmain->qUpdpart("request", 'id_request', $id, array_keys($data), array_values($data));
		$this->session->set_flashdata('success', 'Data Request <strong>Berhasil</strong> Diubah!');
		redirect('request');
	}

    public function hapus_data($id)
	{
		$data = $this->db->query("SELECT * FROM detail_request WHERE id_request = '".$id."'")->row();
		$query = $this->db->query("SELECT * FROM detail_barang WHERE id_detail_barang = '".$data->id_detail_barang."'")->row();
		if ($query) {
			if ($data->status == "Finished") {
				$data1 = [];
				$data1["status"] = "Stored";
				$data1["PIC"] = "";
				$data1["qtty"] = $query->qtty + $data->qtty;
				$this->Mmain->qUpdpart("detail_barang", "id_detail_barang", $data->id_detail_barang, array_keys($data1), array_values($data1));
			}

			$this->Mmain->qDel("detail_request", "id_request", $id);
			$this->Mmain->qDel("request", "id_request", $id);

			if(!$result){
				$this->session->set_flashdata('success', 'Data Request <strong>Berhasil</strong> Dihapus!');
			} else {
				$this->session->set_flashdata('error', 'Data Request <strong>Gagal</strong> Dihapus!');
			}
		}
		redirect("request");
	}
}
