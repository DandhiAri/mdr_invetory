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
        $this->user = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$this->load->library('pagination');
		$this->load->library('form_validation');
		if (!$this->session->userdata('email')){
			redirect('auth');
    	}
		
        $this->form_validation->set_rules('id_jenis', 'Jenis Barang', 'required');
        $this->form_validation->set_rules('id_satuan', 'Satuan Barang', 'required');
    }

	public function get_serial_codes() {
        $id_barang = $this->input->post('id_barang');
        $this->load->model('Mmain');
        $serial_codes = $this->Mmain->get_serial_codes($id_barang);
        echo json_encode($serial_codes);
    }
	
    public function index()
    {
        $data['title'] = 'Barang';
		$data['user'] = $this->user;

		$config['base_url'] = base_url('barang/index/'); 
		$config['per_page'] = 6;
		$config['uri_segment'] = 3;

		if ($this->input->post('keyword')){
			$data['keyword'] = $this->input->post('keyword');
			$this->session->set_userdata('keyword',$data['keyword']);
		} elseif ($this->input->post('reset')){
			$data['keyword'] = null;	
			$this->session->unset_userdata('keyword');
		} else {
			$data['keyword'] = $this->session->userdata('keyword');
		}

		$key = $data['keyword'];

		$this->db->from('barang');
		if(!empty($key)){
			$this->db->join('detail_barang', 'barang.id_barang = detail_barang.id_barang', 'left');
			$this->db->like('detail_barang.serial_code', $key);
			$this->db->or_like('detail_barang.id_barang', $key);
			$this->db->or_like('detail_barang.id_detail_barang', $key);
			$this->db->or_like('barang.nama_barang', $key);
		}
		
		$config['total_rows'] = $this->db->count_all_results();
		

		$data['page'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

		$data['Barang'] = $this->Mmain->getBarang($key, $config['per_page'], $data['page']);
		$this->pagination->initialize($config);
		$data['pagination'] = $this->pagination->create_links();
		
		if (!empty($key)) {
			$res = $this->Mmain->qRead(
				"detail_barang WHERE serial_code LIKE '%$key%'"
			)->result();
			if(!$res==null){
				$data['DetailBarang'] = $res;
			} else{
				$data['DetailBarang'] = $this->Mmain->qRead(
					"detail_barang"
				)->result();
			}
		} else {
			$data['DetailBarang'] = $this->Mmain->qRead(
				"detail_barang"
			)->result();
		}

		$data['content'] = $this->load->view('pages/barang/barang', $data, true);
		$this->load->view('layout/master_layout', $data);
    }

    public function tambah()
    {
        $data['title'] = 'Barang';
		$data['user'] = $this->user;
		$data['Barang'] = $this->Mmain->qRead("barang")->result();
		$data['jenis'] = $this->m_data->getJenis();
		$data['satuan'] = $this->m_data->getSatuan();
        $data['content'] = $this->load->view('pages/barang/addbarang', $data,true);
		$this->load->view('layout/master_layout', $data);
    }

    public function proses_tambah()
    {
        if ($this->session->login['role'] == 'admin') {
            $this->session->set_flashdata('error', 'Tambah data hanya untuk admin!');
            redirect('dashboard');
        }
		$this->form_validation->set_rules('nama_barang', 'Nama barang', 'required|is_unique[barang.nama_barang]', array('is_unique' => 'This %s already taken.'));

		if ($this->form_validation->run() == FALSE) {
			$nama_barang = $this->input->post('nama_barang');
			$existing_barang = $this->db->get_where('barang', ['nama_barang' => $nama_barang])->row();
	
			if ($existing_barang) {
				$link = base_url('detail_barang/tambah/' . $existing_barang->id_barang);
				$message = 'Nama barang sudah digunakan. <a href="' . $link . '">Lihat detail barang</a>';
				$this->session->set_flashdata('failed', $message);
			} else {
				$this->session->set_flashdata('failed', validation_errors());
			}
			redirect($_SERVER['HTTP_REFERER']);
        } else {
            $data = array(
                'nama_barang' => $this->input->post('nama_barang'),
                'id_jenis' => $this->input->post('id_jenis'),
                'id_satuan' => $this->input->post('id_satuan'),
            );

			$id = $this->Mmain->autoId("barang","id_barang","BR","BR"."001","001");
			$data['id_barang'] = $id;
			$this->Mmain->qIns('barang', $data);

            $this->session->set_flashdata('success', 'Data Barang sudah ditambahkan');
			redirect('detail_barang/tambah/'.$id);
        }
    }
    
    public function edit($id){
        $data['title'] = 'Barang';
		$data['user'] = $this->user;
        $data['Barang'] = $this->m_data->edit_data($id);
		$data['jenis'] = $this->m_data->getJenis();
		$data['satuan'] = $this->m_data->getSatuan();
		$data['id'] = $id;
		$data['content'] = $this->load->view('pages/barang/edit_barang', $data,true);
		$this->load->view('layout/master_layout', $data);
    }
	
	public function proses_ubah($id)
	{
		if ($this->session->login['role'] == 'admin') {
			$this->session->set_flashdata('error', 'Ubah data hanya untuk admin!');
			redirect('dashboard');
		}
		
		$original_value = $this->db->query("SELECT nama_barang FROM barang WHERE id_barang ='$id'")->row()->nama_barang;
		if($this->input->post('nama_barang') != $original_value) {
			$is_unique =  'is_unique[barang.nama_barang]';
		} else {
			$is_unique =  '';
		}

		$this->form_validation->set_rules('nama_barang', 'Nama barang', "required".$is_unqiue, array( 'is_unique'=> 'This %s already taken.'));

		if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('failed', validation_errors());
			redirect($_SERVER['HTTP_REFERER']);
        } else {
            $data = array(
				'nama_barang' => $this->input->post('nama_barang'),
				'id_satuan' => $this->input->post('id_satuan'),
				'id_jenis' => $this->input->post('id_jenis')
            );
			$this->Mmain->qUpdpart("barang", 'id_barang', $id, array_keys($data), array_values($data));
			$this->session->set_flashdata('success', 'Data <strong>Berhasil</strong> Diubah!');
			redirect('barang');
		}
	}

	public function hapus_data($id)
	{
		$result1 = $this->Mmain->qDel("detail_barang","id_barang",$id);
		$result2 = $this->Mmain->qDel("barang","id_barang",$id);

		if (!$result1 && !$result2) {
			$this->session->set_flashdata('success', 'Data Barang <strong>Berhasil</strong> Dihapus!');
			redirect('barang');
		} else {
			$this->session->set_flashdata('failed', 'Data Barang <strong>Gagal</strong> Dihapus!');
			redirect('barang');
		}
	}
	
	public function getdetailbarang(){
		$id_barang = $this->input->post('id_barang');
		$render = $this->Mmain->qRead("detail_barang where id_barang = '".$id_barang."'","");
		$data = null;
		if($render->num_rows() > 0){			   
			for($i=0; $i<$render->num_rows(); $i++){
				$data .= "<option value=".$render->row($i)->serial_code."> ".$render->row($i)->serial_code."</option>";
			}
			$retval = $data;
		}else{
			$retval = '<option selected>- Item Detail Tidak Ditemukan, Pilih Yang Lain - </option>';
		}
		
		echo $retval;
	}
}
