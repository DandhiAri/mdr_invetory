<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pengajuan extends CI_Controller
{
	public function __construct()
    {
        parent::__construct();
        $this->load->model('m_pengajuan');
        $this->load->model('Mmain');
        $this->load->model('m_data');
        $this->load->helper(array('form','url'));
		$this->user = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$this->load->library('pagination');
		if (!$this->session->userdata('email')){
			redirect('auth');
    	}
		$this->form_validation->set_rules('tgl_pengajuan', 'Tanggal Pengajuan', 'required');
		$this->form_validation->set_rules('no_surat', 'Nomer Surat', 'required');
	}

	public function index()
    {
        $data['title'] = 'Pengajuan';
        $data['user'] = $this->user;
		
		$config['base_url'] = base_url('pengajuan/index/');
		$config['per_page'] = 6;
		$config['uri_segment'] = 3;
		
		if ($this->input->post('keywordPNJ')){
			$data['keywordPNJ'] = $this->input->post('keywordPNJ');
			$this->session->set_userdata('keywordPNJ',$data['keywordPNJ']);
		} elseif ($this->input->post('reset')){
			$data['keywordPNJ'] = null;
			$this->session->unset_userdata('keywordPNJ');
		} else {
			$data['keywordPNJ'] = $this->session->userdata('keywordPNJ');
		}

		$key = $data['keywordPNJ'];

		$this->db->from('pengajuan');

		if(!empty($key)){
			$this->db->like('pengajuan.tgl_pengajuan', $key);
			$this->db->or_like('pengajuan.id_pengajuan', $key);
		}

		$config['total_rows'] = $this->db->count_all_results();
		$data['page'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
		$this->pagination->initialize($config);

		$data['Pengajuan'] = $this->m_pengajuan->getPengajuan($data['keywordPNJ'], $config['per_page'], $data['page']);

		$data['pagination'] = $this->pagination->create_links();

        $data['content'] = $this->load->view('pages/pengajuan/index', $data,true);
		$this->load->view('layout/master_layout', $data);
    }

	public function tambah(){
		$data['title'] = 'Pengajuan';
        $data['user'] = $this->user;
		
		$data['content'] = $this->load->view('pages/pengajuan/tambah_data', $data,true);
		$this->load->view('layout/master_layout', $data);
	}
	public function proses_tambah()
    {
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('failed', validation_errors());
			redirect($_SERVER['HTTP_REFERER']);
		} else {
			$config['upload_path'] = './assets/img/bukti/invoice/';
			$config['allowed_types'] = 'jpeg||jpg|png|pdf';
			$config['max_size'] = 10000;

			if (!is_dir($config['upload_path'])) {
				mkdir($config['upload_path'], 0755, true);
			}
			$this->load->library('upload', $config);

			if (!$this->upload->do_upload('invoice')) {
				$error = $this->upload->display_errors();
				$this->session->set_flashdata('failed', $error);
				redirect($_SERVER['HTTP_REFERER']);
			} else {
				$file_data = $this->upload->data();
				$invoice_file = $file_data['file_name'];
	
				$data = array(
					'tgl_pengajuan' => $this->input->post('tgl_pengajuan'),
					'no_surat' => $this->input->post('no_surat'),
					'invoice' => $invoice_file,
				);
	
				$id = $this->Mmain->autoId("pengajuan", "id_pengajuan", "PNJ", "PNJ" . "001", "001");
				$data['id_pengajuan'] = $id;
	
				$this->Mmain->qIns('pengajuan', $data);
	
				$this->session->set_flashdata('success', 'Data Pengajuan sudah ditambahkan');
				redirect('pengajuan');
			}
		}
    }
	public function edit_data($id){
		$data['title'] = 'Pengajuan';
        $data['user'] = $this->user;
        $data['Pengajuan'] = $this->m_data->edit_pengajuan($id);

		$data['content'] = $this->load->view('pages/pengajuan/edit_data', $data,true);
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
                'tgl_pengajuan' => $this->input->post('tgl_pengajuan'),
				'no_surat' => $this->input->post('no_surat'),
                'invoice' => $this->input->post('id_jenis'),
            );
			
			$this->Mmain->qUpdpart("pengajuan", 'id_pengajuan', $id, array_keys($data), array_values($data));
			$this->Mmain->qIns('pengajuan', $data);

            $this->session->set_flashdata('success', 'Data Pengajuan sudah ditambahkan');
			redirect('pengajuan');
        }
    }
	public function hapus_data($id)
    {
        $result = $this->m_pengajuan->hapus($id);

        if ($result) {
            $this->session->set_flashdata('success', 'Pengajuan <strong>Berhasil</strong> Dihapus!');
            redirect('Pengajuan');
        } else {
            $this->session->set_flashdata('failed', 'Pengajuan <strong>Gagal</strong> Dihapus!');
            redirect('Pengajuan');
        }
    }
}
