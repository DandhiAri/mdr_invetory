<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Detail_request extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_detail_req');
		$this->load->model('m_detail_barang');
        $this->load->model('Mmain');
        $this->load->helper('url');
    $this->load->library('form_validation');
		if (!$this->session->userdata('email')){
		redirect('auth');
		
    }
	}
	
    public function index()
    {
        $data['title'] = 'Detail Request';
        $data['Detail_Request'] = $this->m_detail_req->tampil_datarequest()->result();
		//$data['Detail_Request'] = $this->Mmain->qRead('detail_request');
		//$render  = $this->Mmain->qRead("detail_request det 
        //INNER JOIN barang b ON det.id_barang = b.id_barang WHERE det.id_barang  = '$id' ",
        //"det.id_detail_barang, det.nama_barang_request, det.jumlah_request, det.keterangan, det.id_barang, det.serial_code, det.jumlah, det.tanggal_waktu, det.status");
        $this->load->view('templates/header', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('detail_request/detail_request', $data);
        $this->load->view('templates/footer');
    }
	
	public function init($id)
    {
        $data['title'] = 'Detail Request';
		$data['id'] = $id;
		/* $render  = $this->Mmain->qRead("detail_request det 
        INNER JOIN request r ON det.id_request = r.id_request WHERE det.id_request  = '$id' ",
        "det.id_detail_request, det.id_request, det.barang_request, det.jumlah_request, det.keterangan, det.id_barang, det.serial_code, det.lokasi, det.jumlah, det.tanggal_waktu, det.status");  */
		$render  = $this->Mmain->qRead("request r 
        INNER JOIN detail_request det ON det.id_request = r.id_request 
		LEFT JOIN detail_barang dbr ON dbr.id_detail_barang = det.id_detail_barang WHERE det.id_request  = '$id' ",
        "det.id_detail_request, det.id_request, det.keterangan, det.id_barang, det.serial_code, det.lokasi, det.jumlah, det.status, det.id_detail_barang, dbr.item_description"); 
		
        $data['Detail_Request'] = $render->result();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('detail_request/detail_request', $data);
        $this->load->view('templates/footer');
    }

    public function tambah($id)
    {
        $data['title'] = 'Detail Request';
		/* $render  = $this->Mmain->qRead("detail_request det 
        INNER JOIN barang b ON det.id_barang = b.id_barang WHERE det.id_barang",
        "det.id_detail_request, det.id_request, det.barang_request, det.jumlah_request, det.keterangan, det.id_barang, det.serial_code, det.lokasi, det.jumlah, det.tanggal_waktu, det.status"); */
		$render  = $this->Mmain->qRead("request r 
        INNER JOIN detail_request det ON det.id_request = r.id_request 
		LEFT JOIN detail_barang dbr ON dbr.id_detail_barang = det.id_detail_barang WHERE det.id_request  = '$id' ",
        "det.id_detail_request, det.id_request, det.keterangan, det.id_barang, det.serial_code, det.lokasi, det.jumlah, det.status, det.id_detail_barang, dbr.item_description");
        $data['Detail_Request'] = $render->result();
		$data['id'] = $id;
		//$data['Detail_Request'] = $this->m_detail_req->tampil_datarequest()->result();
		//$data['barang'] = $this->Mmain->qRead('barang'); 
		#$data['detail_barang'] = $this->m_detail_req->getseri();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('detail_request/adddetail', $data);
        $this->load->view('templates/footer');
    }

    public function proses_tambah()
    {
        if ($this->session->login['role'] == 'admin') {
            $this->session->set_flashdata('error', 'Tambah data hanya untuk admin!');
            redirect('dashboard');
        }
        $id = $this->Mmain->autoId("detail_request","id_detail_request","DRQ","DRQ"."001","001");

		$id_request = $this->input->post('id_request');
        //$barang_request = $this->input->post('barang_request');
		$id_detail_barang = $this->input->post('id_detail_barang');
        //$jumlah_request = $this->input->post('jumlah_request');
        $keterangan = $this->input->post('keterangan');
        $id_barang = $this->input->post('id_barang');
        $serial_code = $this->input->post('serial_code');
		$item_description 	= $this->input->post('item_description');
        $lokasi = $this->input->post('lokasi');
		$jumlah = $this->input->post('jumlah');
        //$tanggal_waktu = $this->input->post('tanggal_waktu');
        $status = $this->input->post('status');
        
		if ($status == 'Finished') {
		$renQty = $this->Mmain->qRead("detail_barang where serial_code = '".$serial_code."' ","qtty, id_detail_barang");
		
		 if ($renQty->num_rows() > 0) {
            foreach ($renQty->result() as $row) {
                $qty = $row->qtty;
                $idDetailBarang = $row->id_detail_barang;
            }
        }		
		
		$valStok = $qty - $jumlah;
		
		$this->Mmain->qUpdpart("detail_barang", "id_detail_barang", $idDetailBarang, Array("qtty"), Array($valStok) );
		}
		
		$detail_barang_data = $this->Mmain->qRead("detail_barang where serial_code = '$serial_code' ", "id_detail_barang");
		
		if ($detail_barang_data->num_rows()>0 ) {
        $idDetailBarang = $detail_barang_data->row()->id_detail_barang;
		
		$this->Mmain->qIns("detail_request", array(
            $id,
			$id_request,
            //$barang_request,
			$idDetailBarang, // ini value hasil dari qRead diatas.
            //$jumlah_request,
            $keterangan,
            $id_barang,
            $serial_code,
			$lokasi,
            $jumlah,
            //$tanggal_waktu,
            $status,

        ));
		}

        $this->session->set_flashdata('success', 'Data <strong>Berhasil</strong> Ditambahkan!');
        redirect("detail_request/init/".$id_request);

    }

    public function edit($id){
        $data['title'] = 'Detail Request';
        $data['Detail_Request'] = $this->m_detail_req->edit_request($id);
		$data['barang'] = $this->m_detail_barang->getBarang();
		$data['detail_barang'] = $this->m_detail_req->getseri();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('detail_request/editdetail',$data);
        $this->load->view('templates/footer');
		
		/* $isAll = $this->Mmain->qRead(
										"tb_accfrm AS a INNER JOIN tb_frm AS b ON a.code_frm = b.code_frm 
										WHERE a.id_acc ='".$this->session->userdata['accUser']."' AND b.id_frm='".$this->viewLink."'",
										"a.is_add as isadd,a.is_edt as isedt,a.is_del as isdel,a.is_spec1 as acc1,a.is_spec2 as acc2","")->row(); */
    }

   public function proses_ubah()
	{
		if ($this->session->login['role'] == 'admin') {
			$this->session->set_flashdata('error', 'Ubah data hanya untuk admin!');
			redirect('dashboard');
		}

		// Mendapatkan ID dari inputan POST
		$id = $this->input->post('id_detail_request');
		$serial_code = $this->input->post('serial_code');
		
		$detail_barang_data = $this->Mmain->qRead("detail_barang where serial_code = '$serial_code' ", "id_detail_barang");
		
		if ($detail_barang_data->num_rows() > 0) {
			//$id_request = $this->input->post('id_request');
			$idDetailBarang = $detail_barang_data->row()->id_detail_barang;
			//$jumlah_request = $this->input->post('jumlah_request');
			$keterangan = $this->input->post('keterangan');
			$id_barang = $this->input->post('id_barang');
			$serial_code = $this->input->post('serial_code');
			$lokasi = $this->input->post('lokasi');
			$jumlah = $this->input->post('jumlah');
			$status = $this->input->post('status');
		
		if ($status == 'Finished') {
		$renQty = $this->Mmain->qRead("detail_barang where serial_code = '".$serial_code."' ","qtty, id_detail_barang");
		
		 if ($renQty->num_rows() > 0) {
            foreach ($renQty->result() as $row) {
                $qty = $row->qtty;
                $idDetailBarang = $row->id_detail_barang;
            }
        }		
		
		$valStok = $qty - $jumlah;
		
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
			
			$valStok = $qty + $jumlah;
			
			$this->Mmain->qUpdpart("detail_barang", "id_detail_barang", $idDetailBarang, Array("qtty"), Array($valStok) );
			}  
		
		// Data untuk diubah
		$data = [
			//'id_detail_request' => $id,
			'id_request' => $this->input->post('id_request'),
			'id_detail_barang' => $idDetailBarang, 
			//'jumlah_request' => $this->input->post('jumlah_request'),
			'keterangan' => $this->input->post('keterangan'),
			'id_barang' => $this->input->post('id_barang'),
			'serial_code' => $this->input->post('serial_code'),
			'lokasi' => $this->input->post('lokasi'),
			'jumlah' => $this->input->post('jumlah'),
			'status' => $this->input->post('status'),
		];

		// Memuat database dan model
		$this->load->database();
		$this->load->model('Mmain');
		//echo $this->input->post('jumlah_request');
		// Menggunakan metode qUpdpart untuk mengubah data
			$tbColUpd = Array("id_detail_barang","keterangan","id_barang","serial_code","lokasi","jumlah","status");
			$tbColVal = Array($idDetailBarang,$keterangan,$id_barang,$serial_code,$lokasi,$jumlah,$status);
			$this->Mmain->qUpdpart("detail_request", 'id_detail_request', $id, $tbColUpd, $tbColVal); // Menambahkan argumen terakhir
		//echo $id;
		// Set flash data untuk notifikasi keberhasilan
		$this->session->set_flashdata('success', 'Data <strong>Berhasil</strong> Diubah!');

		// Redirect ke halaman detail_request
		redirect("detail_request/init/".$data['id_request']);
		} else {
			$this->session->set_flashdata('error', 'Serial code tidak ditemukan!');
			redirect("detail_request/init/".$data['id_request']);
		}
	}
	
	

    public function hapus_data($id,$idRequest)
       {
           //$result = $this->m_detail_req->hapus_request($id);
		   $result=$this->Mmain->qDel("Detail_request","id_detail_request",$id);
   
           if ($render) {
               $this->session->set_flashdata('success', 'Data <strong>Berhasil</strong> Dihapus!');
               redirect("detail_request/init/".$idRequest);
           } else {
               $this->session->set_flashdata('error', 'Data <strong>Gagal</strong> Dihapus!');
               redirect("detail_request/init/".$idRequest);
           }
       }
}