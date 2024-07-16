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
    	$this->load->library('form_validation');
		if (!$this->session->userdata('email')){
			redirect('auth');
    	}
	}
	
	var $data="id_barang"; 
	
    public function index()
    {
        $data['title'] = 'Detail Barang';
		$data['product'] = $this->Mmain->qRead('detail_barang')->result();
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['content'] = $this->load->view('detail_barang/detail_barang', $data, true);
        $this->load->view('layout/master_layout',$data);
    }
	
	public function init($id)
    {
        $data['title'] = 'Detail Barang';
        //$data['Detail_Barang'] = $this->m_detail_barang->tampil_detail()->result();
		$render  = $this->Mmain->qRead("detail_barang det 
        INNER JOIN barang b ON det.id_barang = b.id_barang WHERE det.id_barang  = '$id' ",
        "det.id_detail_barang, b.nama_barang, det.id_barang, det.item_description, det.serial_code, det.lokasi, det.qtty, det.keterangan");

        // $a=$this->Mmain->qRead("detail_barang db right OUTER JOIN barang b ON b.id_barang = b.id_barang = b.id_barang","db.id_barang, db.serial_code, db.lokasi, db.qtty");
        $data['id'] = $id;
        $data['Detail_Barang'] = $render->result();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('detail_barang/detail_barang', $data);
        $this->load->view('templates/footer');
    }

    public function tambah($id)
    {
        $data['title'] = 'Detail Barang';
        $data['Detail_Barang'] = $this->m_detail_barang->tampil_datadetail()->result();
		$render  = $this->Mmain->qRead("detail_barang det 
        INNER JOIN barang b ON det.id_barang = b.id_barang WHERE det.id_barang ",
        "det.id_detail_barang, b.nama_barang, det.item_description, det.serial_code, det.lokasi, det.qtty, det.keterangan");
		$data['id'] = $id;
		$data['Detail_Barang'] = $render->result();
        $data['barang'] = $this->m_detail_barang->getBarang();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('detail_barang/add', $data);
        $this->load->view('templates/footer');
    }

    public function proses_tambah()
    {
        // $this->_validasi();
        if ($this->session->login['role'] == 'admin') {
            $this->session->set_flashdata('error', 'Tambah data hanya untuk admin!');
            redirect('dashboard');
        }
        //$id = $this->Mmain->autoId("detail_barang","id_detail_barang","DB","DB"."001","001");

        $id_barang = $this->input->post('id_barang');
		$item_description = $this->input->post('item_description');
        $serial_code = $this->input->post('serial_code');
        $lokasi = $this->input->post('lokasi');
        $qtty = $this->input->post('qtty');
		$keterangan = $this->input->post('keterangan');
	
		// Check for duplicate serial code
		$existing = $this->Mmain->qRead("detail_barang where serial_code = '".$serial_code."' ", "serial_code");
		//dd($existing);
		if ($existing->num_rows() > 0) {
			// If a duplicate serial code is found
			$this->session->set_flashdata('error', 'Serial code already exists!');
			redirect('detail_barang/tambah/' . $id_barang);
		} else {
        // If no duplicate serial code is found, proceed with the insertion
        $id = $this->Mmain->autoId("detail_barang", "id_detail_barang", "DB", "DB001", "001");
		
        $this->Mmain->qIns("detail_barang", array(
            $id,
            $id_barang,
			$item_description,
            $serial_code,
            $lokasi,
            $qtty,
			$keterangan,
        ));

        $this->session->set_flashdata('success', 'Data <strong>Berhasil</strong> Ditambahkan!');
        redirect("detail_barang/init/".$id_barang);
		}
    }


    public function edit($id){
        $data['title'] = 'Detail Barang';
        $data['Detail_Barang'] = $this->m_detail_barang->edit_detail($id);
		//$render = $this->Mmain->qRead("detail_barang WHERE id_detail_barang='".$id."'","id_detail_barang","")->row()->id_detail_barang;
		/* $render = $this->Mmain->qRead("detail_barang WHERE id_detail_barang = '$id'");
		$data['Detail_Barang'] = $render->result(); */
		$data['barang'] = $this->m_detail_barang->getBarang();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('detail_barang/editdetail',$data);
        $this->load->view('templates/footer');
    }
	
	public function proses_ubah($id)
	{
		if ($this->session->login['role'] == 'admin') {
			$this->session->set_flashdata('error', 'Ubah data hanya untuk admin!');
			redirect('dashboard');
		}
		
		// Mengambil nilai-nilai yang dikirimkan melalui form
		$data = [
			'id_detail_barang' => $id,
			'id_barang' => $this->input->post('id_barang'),
			'item_description' => $this->input->post('item_description'),
			'serial_code' => $this->input->post('serial_code'),
			'lokasi' => $this->input->post('lokasi'),
			'qtty' => $this->input->post('qtty'),
			'keterangan' => $this->input->post('keterangan'),
		];

		// Load database and model
		$this->load->database();
		$this->load->model('Mmain');

		// Menggunakan metode qUpdpart untuk mengubah data
		//$this->Mmain->qUpdpart($this->mainTable, 'id_detail_barang', $data['id_detail_barang'], ['id_barang', 'serial_code', 'lokasi', 'qtty'], [$data['id_barang'], $data['serial_code'], $data['lokasi'], $data['qtty']]);
		$this->Mmain->qUpdpart("detail_barang", 'id_detail_barang', $id, array_keys($data), array_values($data));

		// Set flash data for success notification
		$this->session->set_flashdata('success', 'Data Barang <strong>Berhasil</strong> Diubah!');
		
		// Redirect to the appropriate page
		redirect("detail_barang/init/".$data['id_barang']); 
	}

    public function hapus_data($id,$idBarang)
       {
		   
		   $result = $this->Mmain->qDel("detail_barang","id_detail_barang",$id);
   
           if ($result) {
               $this->session->set_flashdata('success', 'Data <strong>Berhasil</strong> Dihapus!');
               redirect("detail_barang/init/".$idBarang);
           } else {
               $this->session->set_flashdata('error', 'Data <strong>Gagal</strong> Dihapus!');
               redirect("detail_barang/init/".$idBarang);
           }
       }  
	   
	   
}
