<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Replace extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_replace');
		$this->load->model('m_detail_barang');
        $this->load->model('Mmain');
        $this->load->helper('url');
		$this->load->library('form_validation');
		$this->load->library('pagination');

		$this->user = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		if (!$this->session->userdata('email')){
			redirect('auth');
    	}
	}

    public function index()
    {
        $data['title'] = 'Replace';
        $data['user'] = $this->user;

		$config['base_url'] = base_url('replace/index/'); 
		$config['per_page'] = 6;
		$config['uri_segment'] = 3;
		
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
		$data['page'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
		$this->pagination->initialize($config);

		$data['Replace'] = $this->Mmain->getReplace($data['keywordRep'], $config['per_page'], $data['page']);
		
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

		$data = array(
			"nama" => $this->input->post('nama'),
			"tgl_replace" => $this->input->post('tgl_replace'),
			"keterangan" => $this->input->post('keterangan'),
		);
        
		$id = $this->Mmain->autoId("ganti","id_replace","R","R"."001","001");

		$data['id_replace'] = $id;

        $this->Mmain->qIns("ganti", $data);
        $this->session->set_flashdata('success', 'Data Replace <strong>Berhasil</strong> Ditambahkan!');
        redirect('Detail_Replace/tambah_data_detail/'.$id.'');
    }
    

    public function edit_replace($id)
    {
        $data['title'] = 'Replace';
        $data['Replace'] = $this->m_replace->edit_replace($id);
		$data['barang'] = $this->m_replace->getid();
		$data['detail_barang'] = $this->m_replace->getseri();
		$data['user'] = $this->user;

		$data['content'] = $this->load->view('pages/replace/edit_replace', $data,true);
		$this->load->view('layout/master_layout', $data);
    }

	public function proses_edit_replace()
	{
		if ($this->session->login['role'] == 'admin') {
			$this->session->set_flashdata('error', 'Ubah data hanya untuk admin!');
			redirect('dashboard');
		}

		// Mendapatkan ID dari inputan POST
		$id = $this->input->post('id_replace');

		// Data untuk diubah
		$data = [
            'id_replace' => $this->input->post('id_replace'),
            'nama' => $this->input->post('nama'),
            'tgl_replace' => $this->input->post('tgl_replace'),
/*          'id_barang' => $this->input->post('id_barang'),
			'serial_code' => $this->input->post('serial_code'),
            'jumlah' => $this->input->post('jumlah'),
            'qty' => $this->input->post('qty'), */
			'status' => $this->input->post('status'),
            'keterangan' => $this->input->post('keterangan'),

        ];

		// Memuat database dan model
		$this->load->database();
		$this->load->model('Mmain');

		// Menggunakan metode qUpdpart untuk mengubah data
		$this->Mmain->qUpdpart("ganti", 'id_replace', $id, array_keys($data), array_values($data));

		// Set flash data untuk notifikasi keberhasilan
		$this->session->set_flashdata('success', 'Data <strong>Berhasil</strong> Diubah!');

		// Redirect ke halaman detail_request
		redirect('replace');
	}
    

    public function hapus_replace($id)
    {
		$result = $this->Mmain->qDel("detail_ganti", "id_replace", $id);
        $result = $this->Mmain->qDel("ganti", "id_replace", $id);
        

        if ($result) {
            $this->session->set_flashdata('success', 'Jenis Barang <strong>Berhasil</strong> Dihapus!');
            redirect('replace');
        } else {
            $this->session->set_flashdata('error', 'Jenis Barang <strong>Gagal</strong> Dihapus!');
            redirect('replace');
        }
    }
}
