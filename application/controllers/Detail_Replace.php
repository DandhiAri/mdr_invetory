<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Detail_Replace extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
		date_default_timezone_set('Asia/Jakarta');

        $this->load->model('M_detail_replace');
		$this->load->model('m_detail_barang');
		$this->load->database();
        $this->load->model('Mmain');
        $this->load->helper('url');
		$this->user = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

		$this->load->library('form_validation');
		if (!$this->session->userdata('email')){
			redirect('auth');
   		}
	}
	
    public function index()
    {
        $data['title'] = 'Detail Replace';
        $data['Detail_Replace'] = $this->Mmain->qRead('detail_ganti');
		$data['user'] = $this->user;

		$data['content'] = $this->load->view('detail_replace', $data,true);
		$this->load->view('layout/master_layout', $data);
    }
	
	public function init($id)
 	{
        $data['title'] = 'Detail Replace';
		$data['id'] = $id;
		$data['user'] = $this->user;
		
		$render  = $this->Mmain->qRead("ganti r
        INNER JOIN detail_ganti det ON det.id_replace = r.id_replace 
		LEFT JOIN detail_barang db ON db.id_detail_barang = det.id_detail_barang WHERE det.id_replace  = '$id' ", 
		"det.id_detail_replace, det.tgl_replace, det.id_barang, det.qty_replace, det.serial_code, det.lokasi, det.status, det.keterangan, det.id_detail_barang, db.item_description, det.id_replace"); 
        $data['Detail_Replace'] = $render->result();

		$data['content'] = $this->load->view('pages/detail_replace/detail_replace', $data,true);
		$this->load->view('layout/master_layout', $data);
    }
    
	public function tambah_data_detail($id)
	{
        $data['title'] = 'Detail Replace';

		$data['id'] = $id;
		$data['Barang'] = $this->Mmain->qRead("barang")->result();
		$data['Detail_Replace'] = $this->Mmain->qRead("detail_barang")->result();
		$data['user'] = $this->user;

		$data['content'] = $this->load->view('pages/detail_replace/add_detail', $data,true);
		$this->load->view('layout/master_layout', $data);
    }
   
    public function proses_tambah_detail($id)
    {
        if ($this->session->login['role'] == 'admin') {
            $this->session->set_flashdata('error', 'Tambah data hanya untuk admin!');
            redirect('dashboard');
        }

		$this->form_validation->set_rules('id_replace', 'ID Replace', 'required');
		$this->form_validation->set_rules('tgl_replace_update', 'Waktu Update Replace', 'required');
		$this->form_validation->set_rules('id_barang', 'ID Barang', 'required');
		$this->form_validation->set_rules('qty_replace', 'Quantity Replace', 'required|integer');
		$this->form_validation->set_rules('lokasi', 'Lokasi', 'required');

		if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('failed', validation_errors());
			redirect($_SERVER['HTTP_REFERER']);
        } else {
            $data = array(
				"id_replace" => $this->input->post('id_replace'),
				"tgl_replace_update" => $this->input->post('tgl_replace_update'),
				"id_barang" => $this->input->post('id_barang'),
				"qty_replace" => $this->input->post('qty_replace'),
				"serial_code" => $this->input->post('serial_code'),
				"lokasi" => $this->input->post('lokasi'),
				"keterangan" => $this->input->post('keterangan'),
            );

			$data['id_detail_replace'] = $this->Mmain->autoId("detail_ganti","id_detail_replace","DRT","DRT"."001","001");
			
			$this->Mmain->qIns('detail_ganti', $data);
			$this->session->set_flashdata('success', 'Data Detail Replace <strong>Berhasil</strong> Ditambahkan!');
			redirect("replace");
        }
    }

    public function edit_detail($id)
    {
        $data['title'] = 'Detail Replace';
        $data['Detail_Replace'] = $this->M_detail_replace->edit_detail($id);
		$data['barang'] = $this->M_detail_replace->getBarang();
		$data['detail_barang'] = $this->M_detail_replace->getseri();
		$data['user'] = $this->user;

		$data['content'] = $this->load->view('pages/detail_replace/edit_detail', $data,true);
		$this->load->view('layout/master_layout', $data);
    }
 
    public function proses_edit_detail()
	{
    if ($this->session->login['role'] == 'admin') {
        $this->session->set_flashdata('error', 'Ubah data hanya untuk admin!');
        redirect('dashboard');
    }
	
	$id = $this->input->post('id_detail_replace');
		$serial_code = $this->input->post('serial_code');
		
		$detail_barang_data = $this->Mmain->qRead("detail_barang where serial_code = '$serial_code' ", "id_detail_barang");
		
		if ($detail_barang_data->num_rows() > 0) {
			$tgl_replace = $this->input->post('tgl_replace');
			$id_barang = $this->input->post('id_barang');
			$qty_replace = $this->input->post('qty_replace');
			$serial_code = $this->input->post('serial_code');
			$idDetailBarang = $detail_barang_data->row()->id_detail_barang;
			$lokasi = $this->input->post('lokasi');
			$status = $this->input->post('status');
			$keterangan = $this->input->post('keterangan');
			
			if ($status == 'Finished') {
		$renQty = $this->Mmain->qRead("detail_barang where serial_code = '".$serial_code."' ","qtty, id_detail_barang");
		
		 if ($renQty->num_rows() > 0) {
            foreach ($renQty->result() as $row) {
                $qty = $row->qtty;
                $idDetailBarang = $row->id_detail_barang;
            }
        }		
		
		$valStok = $qty - $qty_replace;
		
		$this->Mmain->qUpdpart("detail_barang", "id_detail_barang", $idDetailBarang, Array("qtty"), Array($valStok) );
		}
		
		if ($status == 'Rejected') {
			$renQty = $this->Mmain->qRead("detail_barang where serial_code = '".$serial_code."' ","qtty, id_detail_barang");
			
			 if ($renQty->num_rows() > 0) {
				foreach ($renQty->result() as $row) {
					$qty = $row->qtty;
					$idDetailBarang = $row->id_detail_barang;
				}
			}		
			
			$valStok = $qty + $qty_replace;
			
			$this->Mmain->qUpdpart("detail_barang", "id_detail_barang", $idDetailBarang, Array("qtty"), Array($valStok) );
			}
			
			
    $data = [
        //'id_detail_replace' => $id,
        'id_replace' => $this->input->post('id_replace'),
        'tgl_replace' => $this->input->post('tgl_replace'),
        'id_barang' => $this->input->post('id_barang'),
        'qty_replace' => $this->input->post('qty_replace'),
        'serial_code' => $this->input->post('serial_code'),
		'id_detail_barang' => $idDetailBarang, 
        'lokasi' => $this->input->post('lokasi'),
		'status' => $this->input->post('status'),
        'keterangan' => $this->input->post('keterangan'),
    ];

		$tbColUpd = Array("tgl_replace","id_barang","qty_replace","serial_code","id_detail_barang","lokasi","status","keterangan");
		$tbColVal = Array($tgl_replace,$id_barang,$qty_replace,$serial_code,$idDetailBarang,$lokasi,$status,$keterangan,);
		$this->Mmain->qUpdpart("detail_ganti", 'id_detail_replace', $id, $tbColUpd, $tbColVal); // Menambahkan argumen terakhir

    if ($this->db->affected_rows() > 0) {
        $this->session->set_flashdata('success', 'Jenis Barang <strong>Berhasil</strong> Diubah!');
        redirect("replace");
    } else {
        $this->session->set_flashdata('error', 'Jenis Barang <strong>Gagal</strong> Diubah!');
        redirect("replace");
    }
}
}

   public function del_replace($id,$idBarang)
{
    $result = $this->Mmain->qDel("detail_ganti", "id_detail_replace", $id);
    if ($result) {
        redirect("replace");
    } else {
        $this->session->set_flashdata('error', 'Jenis Barang <strong>Gagal</strong> Dihapus!');
        redirect("replace");
    }
}
}
