<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pinjam extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        // cek_login();

        $this->load->model('m_pinjam');
        $this->load->model('Mmain');
        $this->load->helper('url');
		
		
		if (!$this->session->userdata('email')){
		redirect('auth');
		
    }
	}

    public function index()
    {
        $data['title'] = 'Pinjam';
        /* $data['Pinjam'] = $this->m_pinjam->pinjam()->result(); */
		$render=$this->Mmain->qRead("pinjam");
		$data['Pinjam'] = $render->result();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('pinjam/pinjam', $data);
        $this->load->view('templates/footer');
    }
    public function tambah_pinjam()
    {
        $data['title'] = 'TambahPinjam';
       /*   $data['Pinjam'] = $this->m_pinjam->tambah_pinjam()->result();  */
		$render=$this->Mmain->qRead("pinjam");
		$data['Pinjam'] = $render->result();
		$data['barang'] = $this->m_pinjam->getBarang();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('pinjam/tambah_data', $data);
        $this->load->view('templates/footer');
    }
    public function proses_tambah()
    {
        if ($this->session->login['role'] == 'admin') {
            $this->session->set_flashdata('error', 'Tambah data hanya untuk admin!');
            redirect('dashboard');
        }

        $id = $this->Mmain->autoId("pinjam", "id_pinjam", "PJ", "PJ" . "001", "001");


        $data = [
            'id_pinjam' => $this->input->post('id_pinjam'),
            'nama_peminjam' => $this->input->post('nama_peminjam'),
            'nama_penerima' => $this->input->post('nama_penerima'),
            'nama_pemberi' => $this->input->post('nama_pemberi'),
            /* 'nama_barang' => $this->input->post('nama_barang'), */
            'tgl_pinjam' => $this->input->post('tgl_pinjam'),
            'jam_pinjam' => $this->input->post('jam_pinjam'),
            'keterangan' => $this->input->post('keterangan'),

        ];

        $nama_peminjam = $this->input->post('nama_peminjam');
        $nama_penerima = $this->input->post('nama_penerima');
        $nama_pemberi = $this->input->post('nama_pemberi');
        //$nama_barang = $this->input->post('nama_barang');
        $tgl_pinjam = $this->input->post('tgl_pinjam');
        $jam_pinjam = $this->input->post('jam_pinjam');
        $keterangan = $this->input->post('keterangan');

        // var_dump($nama_peminjam, $nama_penerima, $nama_pemberi,);
        // die;
		
		
        $this->Mmain->qIns("pinjam", array(

            $id,
            $nama_peminjam,
            $nama_penerima,
            $nama_pemberi,
            /* $nama_barang, */
            $tgl_pinjam,
            $jam_pinjam,
            $keterangan

        ));

        $this->session->set_flashdata('success', 'Data Barang <strong>Berhasil</strong> Ditambahkan!');
        redirect('Detail_pinjam/tambah_detail/'.$id.'');
    }
    public function edit_data($id)
    {
        $data['title'] = 'Pinjam';
        $data['Pinjam'] = $this->m_pinjam->edit_data($id);
		$data['barang'] = $this->m_pinjam->getBarang();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('pinjam/edit_data', $data);
        $this->load->view('templates/footer');
    }

    public function proses_ubah()
{
    if ($this->session->login['role'] == 'admin') {
        $this->session->set_flashdata('error', 'Ubah data hanya untuk admin!');
        redirect('dashboard');
    }

    $data = [
        'id_pinjam' => $this->input->post('id_pinjam'),
        'nama_peminjam' => $this->input->post('nama_peminjam'),
        'nama_penerima' => $this->input->post('nama_penerima'),
        'nama_pemberi' => $this->input->post('nama_pemberi'),
        /* 'nama_barang' => $this->input->post('nama_barang'), */
        'tgl_pinjam' => $this->input->post('tgl_pinjam'),
        'jam_pinjam' => $this->input->post('jam_pinjam'),
        'keterangan' => $this->input->post('keterangan'),
    ];

    // Load model
    $this->load->model('Mmain');

    // Menggunakan metode qUpdpart untuk mengubah data
    $this->Mmain->qUpdpart('pinjam', 'id_pinjam', $data['id_pinjam'], ['nama_peminjam', 'nama_penerima', 'nama_pemberi', 'tgl_pinjam', 'jam_pinjam', 'keterangan'], [$data['nama_peminjam'], $data['nama_penerima'], $data['nama_pemberi'], $data['tgl_pinjam'], $data['jam_pinjam'],  $data['keterangan']]);

    $this->session->set_flashdata('success', 'Data Barang <strong>Berhasil</strong> Diubah!');
    
    redirect('pinjam');
}

    public function hapus_data($id)
    {
		
        $result = $this->Mmain->qDel("detail_pinjam", "id_pinjam", $id);
        $result = $this->Mmain->qDel("pinjam", "id_pinjam", $id);
		

        if ($result) {
            $this->session->set_flashdata('success', 'Data Barang <strong>Berhasil</strong> Dihapus!');
            redirect('pinjam');
        } else {
            $this->session->set_flashdata('error', 'Data Barang <strong>Gagal</strong> Dihapus!');
            redirect('pinjam');
        }
    }
}

