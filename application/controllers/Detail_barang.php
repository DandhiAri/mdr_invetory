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
		$config['per_page'] = 6; 
		$config['uri_segment'] = 3;
		
		$this->pagination->initialize($config);
	
		$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
		$data['detail_barang'] = $this->m_detail_barang->tampil_datadetail($id, $config['per_page'], $page);
		$data['pagination'] = $this->pagination->create_links();
		
		$render  = $this->Mmain->qRead("ganti r
        INNER JOIN detail_ganti det ON det.id_replace = r.id_replace 
		LEFT JOIN detail_barang db ON db.id_detail_barang = det.id_detail_barang WHERE det.id_replace  = '$id' ", 
		"det.id_detail_replace, det.tgl_replace, det.id_barang, det.qty_replace, det.serial_code, det.lokasi, det.status, det.keterangan, det.id_detail_barang, db.item_description, det.id_replace"); 
        $data['Detail_Replace'] = $render->result();

        $data['Detail_Barang'] = $this->m_detail_barang->tampil_datadetail($id,$config['per_page'],$config['uri_segment'])->result();
		$data['content'] = $this->load->view('pages/detail_barang/index', $data, true);
        $this->load->view('layout/master_layout',$data);
    }

    public function tambah($id)
    {
        $data['title'] = 'Detail Barang';
		$render  = $this->Mmain->qRead("detail_barang det 
        INNER JOIN barang b ON det.id_barang = b.id_barang WHERE det.id_barang ",
        "det.id_detail_barang, b.nama_barang, det.serial_code, det.lokasi, det.qtty, det.keterangan");

		$data['id'] = $id;
        $data['user'] = $this->user;
		$data['Detail_Barang'] = $render->result();
		$data['pengajuan'] = $this->Mmain->qRead("pengajuan")->result();
        // $data['barang'] = $this->m_detail_barang->getBarang();
		$data['content'] = $this->load->view('pages/detail_barang/create', $data, true);
        $this->load->view('layout/master_layout',$data);
    }

	public function proses_tambah($id) {
		if(empty($this->input->post('serialEmpty'))) {
			$is_unique =  'required|is_unique[detail_barang.serial_code]';
		} else {
			$is_unique =  '';
		}
		$this->form_validation->set_rules('serial_code', 'Serial Code', $is_unique, array( 'is_unique'=> 'This %s already exists.'));

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('failed', validation_errors());
			redirect($_SERVER['HTTP_REFERER']);
        } else {
            $data = array(
                'id_barang' => $this->input->post('id_barang'),
                'id_pengajuan' => $this->input->post('id_pengajuan'),
                'serial_code' => $this->input->post('serial_code'),
                'lokasi' => $this->input->post('lokasi'),
				'qtty' => $this->input->post('qtty'),
                'keterangan' => $this->input->post('keterangan'),
				'PIC' => $this->input->post('PIC'),
            );
			$data['id_detail_barang'] = $this->Mmain->autoId("detail_barang", "id_detail_barang", "DBR", "DBR" . "001", "001");
			$this->Mmain->qIns('detail_barang', $data);

            $this->session->set_flashdata('success', 'Detail Barang sudah ditambahkan');
			$total_items = $this->db->count_all('barang');

			redirect('barang/index/' . $this->get_page_for_id($data["id_barang"]));
        }
    }

    public function edit($id){
        $data['title'] = 'Detail Barang';
        $data['Detail_Barang'] = $this->m_detail_barang->edit_detail($id);

		$data['user'] = $this->user;
		$data['barang'] = $this->m_detail_barang->getBarang();
		$data['pengajuan'] = $this->Mmain->qRead("pengajuan")->result();

		$data['content'] = $this->load->view('pages/detail_barang/edit', $data, true);
        $this->load->view('layout/master_layout',$data);
    }
	
	public function proses_ubah($id)
	{
		$original_value = $this->db->query("SELECT serial_code FROM detail_barang WHERE id_detail_barang ='$id'")->row()->serial_code;
		if(empty($this->input->post('serialEmpty'))) {
			if($this->input->post('serial_code') != $original_value) {
				$is_unique =  'required|is_unique[detail_barang.serial_code]';
			} else {
				$is_unique =  '';
			}
		} else{
			$is_unique =  '';
		}
		$this->form_validation->set_rules('serial_code', 'Serial Code', $is_unique, array( 'is_unique'=> 'This %s already exists.'));
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('failed', validation_errors());
			redirect($_SERVER['HTTP_REFERER']);
		} else {
			$data = [
				'id_detail_barang' => $id,
                'id_pengajuan' => $this->input->post('id_pengajuan'),
				'id_barang' => $this->input->post('id_barang'),
				'serial_code' => $this->input->post('serial_code'),
				'qtty' => $this->input->post('qtty'),
				'lokasi' => $this->input->post('lokasi'),
				'keterangan' => $this->input->post('keterangan'),
				'PIC' => $this->input->post('PIC'),
				'status' => $this->input->post('status'),
			];
		}

		$this->Mmain->qUpdpart("detail_barang", 'id_detail_barang', $id, array_keys($data), array_values($data));

		$this->session->set_flashdata('success', 'Detail Barang berhasil diedit');
		redirect('barang/index/' . $this->get_page_for_id($data["id_barang"]));
	}

    public function hapus_data($id,$idBarang)
	{
		$this->Mmain->qDel("detail_request","id_detail_barang",$id);
		$this->Mmain->qDel("detail_ganti","id_detail_barang",$id);
		$this->Mmain->qDel("detail_pinjam","id_detail_barang",$id);
		$result = $this->Mmain->qDel("detail_barang","id_detail_barang",$id);

		if (!$result) {
			$this->session->set_flashdata('success', 'Data <strong>Berhasil</strong> Dihapus!');
			redirect('barang/index/' . $this->get_page_for_id($idBarang));
		} else {
			$this->session->set_flashdata('failed', 'Data <strong>Gagal</strong> Dihapus!');
			redirect('barang/index/' . $this->get_page_for_id($idBarang));
		}
	}  
	private function get_page_for_id($id) {
		if (!empty($this->session->userdata('keyword'))){
			$keyword = $this->session->userdata('keyword');
		}
        $position = $this->Mmain->getBarang($keyword, null, null, $id, true);
		if ($position === 0) {
			return false;
		}
        $per_page = 10;
        return floor(($position - 1) / $per_page) * $per_page;
    }
}
