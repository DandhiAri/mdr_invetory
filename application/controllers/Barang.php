<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Barang extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_data');
        $this->load->model('Mmain');
        $this->load->helper('url');
		
		$this->load->library('form_validation');
		if (!$this->session->userdata('email')){
		redirect('auth');
		
    }
    }

    public function index()
    {
        $data['title'] = 'Barang';
        //$data['Barang'] = $this->m_data->tampil_data('barang')->result();
		/* $render=$this->Mmain->qRead("barang a left outer join detail_barang b on a.id_barang = b.id_barang group by a.id_barang "
		,"a.id_barang, a.nama_barang, a.id_jenis, a.id_satuan, 
		case when sum(b.qtty) is not null 
		then sum(b.qtty) else 0 end as qtty  "); */
		$render=$this->Mmain->qRead("barang b LEFT OUTER JOIN detail_barang d ON d.id_barang =b.id_barang GROUP BY b.id_barang",
									"b.id_barang, b.nama_barang, SUM(d.qtty) as stok, b.id_jenis, b.id_satuan ");
		$data['Barang'] = $render->result();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('barang', $data);
        $this->load->view('templates/footer');
    }

    public function tambah()
    {
        $data['title'] = 'Barang';
        //$data['Barang'] = $this->m_data->tampil_databarang()->result();
		$render=$this->Mmain->qRead("barang","");
		$data['Barang'] = $render->result();
		$data['jenis'] = $this->m_data->getJenis();
		$data['satuan'] = $this->m_data->getSatuan();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('addbarang', $data);
        $this->load->view('templates/footer');
    }

    public function proses_tambah()
    {
        $this->load->model('Mmain');
        if ($this->session->login['role'] == 'admin') {
            $this->session->set_flashdata('error', 'Tambah data hanya untuk admin!');
            redirect('dashboard');
        }
        $id = $this->Mmain->autoId("barang","id_barang","BR","BR"."001","001");
        
        // $data = [
        //     'id_barang' => $id,
        //     'nama_barang' => $this->input->post('nama_barang'),
        //     'stok' => $this->input->post('stok'),
        //     'satuan_id' => $this->input->post('satuan_id'),
        //     'jenis_id' => $this->input->post('jenis_id'),

        // ];

        $nama = $this->input->post('nama');
        $stok = $this->input->post('stok');
		$jenis = $this->input->post('id_jenis');
        $satuan = $this->input->post('id_satuan');
        
        $this->Mmain->qIns("barang", array(
            $id,
            $nama,
            $stok,
            $jenis,
			$satuan

        ));

        $this->session->set_flashdata('success', 'Data Barang <strong>Berhasil</strong> Ditambahkan!');
        redirect('detail_barang/tambah/'.$id.'');

    }
    
    public function edit($id){
        $data['title'] = 'Barang';
		/* $render=$this->Mmain->qRead("barang","");
		$data['Barang'] = $render->result(); */
        $data['Barang'] = $this->m_data->edit_data($id);
		$data['jenis'] = $this->m_data->getJenis();
		$data['satuan'] = $this->m_data->getSatuan();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('edit_barang',$data);
        $this->load->view('templates/footer');
    }
	
	public function proses_ubah()
	{
		if ($this->session->login['role'] == 'admin') {
			$this->session->set_flashdata('error', 'Ubah data hanya untuk admin!');
			redirect('dashboard');
		}

		// Mendapatkan ID dari inputan POST
		$id = $this->input->post('id_barang');

		// Data untuk diubah
		$data = [
			'id_barang' => $this->input->post('id_barang'),
            'nama_barang' => $this->input->post('nama_barang'),
            'stok' => $this->input->post('stok'),
            'id_satuan' => $this->input->post('id_satuan'),
            'id_jenis' => $this->input->post('id_jenis')
		];

		// Memuat database dan model
		$this->load->database();
		$this->load->model('Mmain');

		// Menggunakan metode qUpdpart untuk mengubah data
		$this->Mmain->qUpdpart("barang", 'id_barang', $id, array_keys($data), array_values($data));

		// Set flash data untuk notifikasi keberhasilan
		$this->session->set_flashdata('success', 'Data <strong>Berhasil</strong> Diubah!');

		// Redirect ke halaman Barang
		redirect('barang');
	}


       public function hapus_data($id)
       {
           //$result = $this->m_data->hapus($id);
		   $result = $this->Mmain->qDel("detail_barang","id_barang",$id);
		   $result = $this->Mmain->qDel("barang","id_barang",$id);
   
           if ($result) {
               $this->session->set_flashdata('success', 'Data Barang <strong>Berhasil</strong> Dihapus!');
               redirect('barang');
           } else {
               $this->session->set_flashdata('error', 'Data Barang <strong>Gagal</strong> Dihapus!');
               redirect('barang');
           }
       }
	   
	   public function getdetailbarang(){
		   $id_barang = $this->input->post('id_barang');
		   $render = $this->Mmain->qRead("detail_barang where id_barang = '".$id_barang."'","");
		   $data = null;
		   if($render->num_rows() > 0){			   
			   for($i=0; $i<$render->num_rows(); $i++){
				  //$data .= "<option value=".$render->row()->serial_code."> ".$render->row()->serial_code."" ;
				  $data .= "<option value=".$render->row($i)->serial_code."> ".$render->row($i)->serial_code."</option>";
			   }
			   $retval = $data;
		   }else{
			   $retval = '<option selected>- Item Detail Tidak Ditemukan, Pilih Yang Lain - </option>';
		   }
		  
		   echo $retval;
	   }
	   

}