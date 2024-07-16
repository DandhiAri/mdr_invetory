<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Detail_Replace extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_detail_replace');
		$this->load->model('m_detail_barang');
		$this->load->database();
        $this->load->model('Mmain');
        $this->load->helper('url');
    $this->load->library('form_validation');
		if (!$this->session->userdata('email')){
		redirect('auth');
		
    }
	}
	
    public function index()
    {
        $data['title'] = 'Detail Replace';
        $data['Detail_Replace'] = $this->Mmain->qRead('detail_ganti');
        $this->load->view('templates/header', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('detail_replace', $data);
        $this->load->view('templates/footer');
    }
	
public function init($id="")
 {
        $data['title'] = 'Detail Replace';
		$data['id'] = $id;
		
        //$data['Detail_Barang'] = $this->m_detail_barang->tampil_detail()->result();
		/* $render  = $this->Mmain->qRead("detail_ganti det
        INNER JOIN barang b ON det.id_barang = b.id_barang WHERE det.id_barang  = '$id' ",
        "det.id_detail_replace, det.nama_replace, det.tgl_replace, det.id_barang, det.jml_replace, det.qty_replace, det.serial_code, det.lokasi, det.status, det.keterangan"); */
		/* $render  = $this->Mmain->qRead("barang b
        INNER JOIN detail_ganti det ON det.id_barang = b.id_barang 
		LEFT JOIN detail_barang db ON db.id_detail_barang = det.id_detail_barang WHERE det.id_barang  = '$id' ", 
		"det.id_detail_replace, det.tgl_replace, det.id_barang, det.jml_replace, det.qty_replace, det.serial_code, det.lokasi, det.status, det.keterangan, det.id_detail_barang, db.item_description, det.id_replace");  */
		
		$render  = $this->Mmain->qRead("ganti r
        INNER JOIN detail_ganti det ON det.id_replace = r.id_replace 
		LEFT JOIN detail_barang db ON db.id_detail_barang = det.id_detail_barang WHERE det.id_replace  = '$id' ", 
		"det.id_detail_replace, det.tgl_replace, det.id_barang, det.qty_replace, det.serial_code, det.lokasi, det.status, det.keterangan, det.id_detail_barang, db.item_description, det.id_replace"); 
        $data['Detail_Replace'] = $render->result();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('detail_replace', $data);
        $this->load->view('templates/footer');
    }
    
	public function tambah_data_detail($id)
	 {
        $data['title'] = 'Detail Replace';
		
        //$data['Detail_Replace'] = $this->M_detail_replace->tampil_data_detail()->result();
		/* $render  = $this->Mmain->qRead("detail_ganti det
        INNER JOIN barang b ON det.id_barang = b.id_barang WHERE det.id_barang",
        "det.id_detail_replace, det.nama_replace, det.tgl_replace, det.id_barang, det.jml_replace, det.qty_replace, det.serial_code, det.lokasi, det.status, det.keterangan"); */
		/* $render  = $this->Mmain->qRead("barang b
        INNER JOIN detail_ganti det ON det.id_barang = b.id_barang 
		LEFT JOIN detail_barang db ON db.id_detail_barang = det.id_detail_barang WHERE det.id_barang", 
		"det.id_detail_replace, det.tgl_replace, det.id_barang, det.jml_replace, det.qty_replace, det.serial_code, det.lokasi, det.status, det.keterangan, det.id_detail_barang, db.item_description, det.id_replace"); */
		$render  = $this->Mmain->qRead("ganti r
        INNER JOIN detail_ganti det ON det.id_replace = r.id_replace 
		LEFT JOIN detail_barang db ON db.id_detail_barang = det.id_detail_barang WHERE det.id_replace  = '$id' ", 
		"det.id_detail_replace, det.tgl_replace, det.id_barang, det.qty_replace, det.serial_code, det.lokasi, det.status, det.keterangan, det.id_detail_barang, db.item_description, det.id_replace"); 
        $data['Detail_Replace'] = $render->result();
		$data['id'] = $id;
		$data['barang'] = $this->M_detail_replace->getBarang();
		#$data['detail_barang'] = $this->m_detail_req->getseri();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('tambah_data_detail', $data);
        $this->load->view('templates/footer');
    }
   
    public function proses_tambah_detail()
    {
        if ($this->session->login['role'] == 'admin') {
            $this->session->set_flashdata('error', 'Tambah data hanya untuk admin!');
            // $id = $this->Mmain->autoId("detail_replace","id_detail_replace","DRT","DRT"."001","001");
            redirect('dashboard');
        }
        $id = $this->Mmain->autoId("detail_ganti","id_detail_replace","DRT","DRT"."001","001");
		
        $id_replace = $this->input->post('id_replace');
		//$nama_replace = $this->input->post('nama_replace');
        $tgl_replace = $this->input->post('tgl_replace');
        $id_barang = $this->input->post('id_barang');
        $qty_replace = $this->input->post('qty_replace');
        $serial_code = $this->input->post('serial_code');
		$item_description 	= $this->input->post('item_description');
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

		$detail_barang_data = $this->Mmain->qRead("detail_barang where serial_code = '$serial_code' ", "id_detail_barang");
		
		if ($detail_barang_data->num_rows()>0 ) {
        $idDetailBarang = $detail_barang_data->row()->id_detail_barang;
		
        $this->Mmain->qIns("detail_ganti", array(
            $id,
            $id_replace,
            $tgl_replace,
            $id_barang,
            $qty_replace,
            $serial_code,
			$idDetailBarang, // ini value hasil dari qRead diatas.
			$lokasi,
            $status,
            $keterangan,
        ));
		}
		
        $this->session->set_flashdata('success', 'Data Detail Replace <strong>Berhasil</strong> Ditambahkan!');
        redirect("detail_replace/init/".$id_replace);
    }

    public function edit_detail($id)
    {
        $data['title'] = 'Detail Replace';
        $data['Detail_Replace'] = $this->M_detail_replace->edit_detail($id);
		$data['barang'] = $this->M_detail_replace->getBarang();
		$data['detail_barang'] = $this->M_detail_replace->getseri();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('edit_detail', $data);
        $this->load->view('templates/footer');
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

    // Menggunakan metode qUpdpart untuk mengubah data
   /*  $this->Mmain->qUpdpart('detail_ganti', 'id_detail_replace', $data['id_detail_replace'], 
        ['id_replace','tgl_replace', 'id_barang', 'jml_replace', 'qty_replace', 'serial_code', 'lokasi','status', 'keterangan'], 
        [$data['tgl_replace'], $data['id_barang'], $data['jml_replace'], 
        $data['qty_replace'], $data['serial_code'],$data['lokasi'], $data['status'], $data['keterangan']]); */
		
	// Menggunakan metode qUpdpart untuk mengubah data
			$tbColUpd = Array("tgl_replace","id_barang","qty_replace","serial_code","id_detail_barang","lokasi","status","keterangan");
			$tbColVal = Array($tgl_replace,$id_barang,$qty_replace,$serial_code,$idDetailBarang,$lokasi,$status,$keterangan,);
			$this->Mmain->qUpdpart("detail_ganti", 'id_detail_replace', $id, $tbColUpd, $tbColVal); // Menambahkan argumen terakhir

    if ($this->db->affected_rows() > 0) {
        $this->session->set_flashdata('success', 'Jenis Barang <strong>Berhasil</strong> Diubah!');
        redirect("detail_replace/init/".$data['id_replace']);
    } else {
        $this->session->set_flashdata('error', 'Jenis Barang <strong>Gagal</strong> Diubah!');
        redirect("detail_replace/init/".$data['id_replace']);
    }
}
}

   public function del_replace($id,$idBarang)
{
    $result = $this->Mmain->qDel("detail_ganti", "id_detail_replace", $id);
    if ($result) {
        redirect("detail_replace/init/".$idBarang);
    } else {
        $this->session->set_flashdata('error', 'Jenis Barang <strong>Gagal</strong> Dihapus!');
        redirect("detail_replace/init/".$idBarang);
    }
}
}