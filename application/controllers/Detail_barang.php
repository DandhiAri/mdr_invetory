<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Detail_barang extends CI_Controller
{
//private $mainTable = 'detail_barang';

    public function __construct()
    {
        parent::__construct();
        // $this->load->library('Commonfunction','','fn');
        $this->load->model('m_detail_barang');
        $this->load->model('Mmain');
        $this->load->helper('url');
		$this->user = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
    	$this->load->library('form_validation');
		$this->load->library('pagination');
		if (!$this->session->userdata('email')){
			redirect('auth');
    	}
		$this->form_validation->set_rules('id_barang', 'ID Barang', 'required');
        $this->form_validation->set_rules('serial_code', 'Serial Code', 'required|is_unique[detail_barang.serial_code]', array( 'is_unique'=> 'This %s already exists.'));
        $this->form_validation->set_rules('lokasi', 'Lokasi', 'required');
        $this->form_validation->set_rules('qtty', 'Quantity', 'required|integer');
	}
	
	var $data="id_barang"; 
	
    public function index()
    {
        $data['title'] = 'Detail Barang';
		$data['product'] = $this->Mmain->qRead('detail_barang')->result();
        $data['user'] = $this->user;
        $data['content'] = $this->load->view('pages/detail_barang/index', $data, true);
        $this->load->view('layout/master_layout',$data);
    }
	
	public function init($id)
    {
        $data['title'] = 'Detail Barang';
        $data['user'] = $this->user;
		$data['id'] = $id;
		$config['base_url'] = base_url('controller/detail/'.$id);
		$config['total_rows'] = $this->db->where('id_barang', $id)->count_all_results('detail_barang');
		$config['per_page'] = 10; 
		$config['uri_segment'] = 4;
		
		$this->pagination->initialize($config);
	
		$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
		$data['detail_barang'] = $this->YourModel->tampil_datadetail($id, $config['per_page'], $page);
		$data['pagination'] = $this->pagination->create_links();

        $data['Detail_Barang'] = $this->m_detail_barang->tampil_datadetail($id,$config['per_page'],$config['uri_segment'])->result();
		$data['content'] = $this->load->view('pages/detail_barang/index', $data, true);
        $this->load->view('layout/master_layout',$data);
    }

    public function tambah($id)
    {
        $data['title'] = 'Detail Barang';
        $data['Detail_Barang'] = $this->m_detail_barang->tampil_datadetail()->result();
		$render  = $this->Mmain->qRead("detail_barang det 
        INNER JOIN barang b ON det.id_barang = b.id_barang WHERE det.id_barang ",
        "det.id_detail_barang, b.nama_barang, det.item_description, det.serial_code, det.lokasi, det.qtty, det.keterangan");

		$data['id'] = $id;
        $data['user'] = $this->user;
		$data['Detail_Barang'] = $render->result();
        $data['barang'] = $this->m_detail_barang->getBarang();
		$data['content'] = $this->load->view('pages/detail_barang/create', $data, true);
        $this->load->view('layout/master_layout',$data);
    }

	public function proses_tambah($id) {
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('failed', validation_errors());
			redirect($_SERVER['HTTP_REFERER']);
        } else {
            $data = array(
                'id_barang' => $this->input->post('id_barang'),
                'serial_code' => $this->input->post('serial_code'),
                'lokasi' => $this->input->post('lokasi'),
                'qtty' => $this->input->post('qtty'),
                'keterangan' => $this->input->post('keterangan')
            );
			$data['id_detail_barang'] = $this->Mmain->autoId("detail_barang", "id_detail_barang", "DBR", "DBR" . "001", "001");
			$this->Mmain->qIns('detail_barang', $data);

            $this->session->set_flashdata('success', 'Detail Barang sudah ditambahkan');
			redirect('detail_barang/init/'.$id);
        }
    }

    public function edit($id){
        $data['title'] = 'Detail Barang';
        $data['Detail_Barang'] = $this->m_detail_barang->edit_detail($id);
		$data['user'] = $this->user;
		$data['barang'] = $this->m_detail_barang->getBarang();
		$data['content'] = $this->load->view('pages/detail_barang/edit', $data, true);
        $this->load->view('layout/master_layout',$data);
    }
	
	public function proses_ubah($id)
	{
		$original_value = $this->db->query("SELECT serial_code FROM detail_barang WHERE id_detail_barang = ".$id)->row()->serial_code;
		if($this->input->post('serial_code') != $original_value) {
		   $is_unique =  '|is_unique[detail_barang.serial_code]';
		} else {
		   $is_unique =  '';
		}

		$this->form_validation->set_rules('serial_code', 'Serial Code', 'required'.$is_unique, array( 'is_unique'=> 'This %s already exists.'));
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('failed', validation_errors());
			redirect($_SERVER['HTTP_REFERER']);
		} else {
			$data = [
				'id_detail_barang' => $id,
				'id_barang' => $this->input->post('id_barang'),
				'item_description' => $this->input->post('item_description'),
				'serial_code' => $this->input->post('serial_code'),
				'lokasi' => $this->input->post('lokasi'),
				'qtty' => $this->input->post('qtty'),
				'keterangan' => $this->input->post('keterangan'),
			];
		}

		$this->Mmain->qUpdpart("detail_barang", 'id_detail_barang', $id, array_keys($data), array_values($data));

		$this->session->set_flashdata('success', 'Detail Barang berhasil diedit');
		redirect("detail_barang/init/".$data['id_barang']); 
	}

    public function hapus_data($id,$idBarang)
       {
		   
		   $result = $this->Mmain->qDel("detail_barang","id_detail_barang",$id);
   
           if (!$result) {
               $this->session->set_flashdata('success', 'Data <strong>Berhasil</strong> Dihapus!');
               redirect("detail_barang/init/".$idBarang);
           } else {
               $this->session->set_flashdata('failed', 'Data <strong>Gagal</strong> Dihapus!');
               redirect("detail_barang/init/".$idBarang);
           }
       }  
	   
	   
}
