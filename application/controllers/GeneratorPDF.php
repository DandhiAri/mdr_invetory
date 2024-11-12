<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class GeneratorPDF extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('pdfgenerator');
    }

	public function test(){
		$data = array(
            'title' => 'Surat Jalan',
            'nomor_surat' => 'MDR-DN-038-SC-XI-24',
            'tanggal' => date('d F Y'),
            'tujuan' => 'Sample Tujuan',
            'items' => array(
                array(
                    'name' => 'Label PKK297',
                    'qty' => '1 set'
                )
            )
        );
		$this->load->view('layout/pdfLayout/suratJalan', $data);
	}
    public function index() {
        $data = array(
            'title' => 'Surat Jalan',
            'nomor_surat' => 'MDR-DN-038-SC-XI-24',
            'tanggal' => date('d F Y'),
            'tujuan' => 'Sample Tujuan',
            'items' => array(
                array(
                    'name' => 'Label PKK297',
                    'qty' => '1 set'
                )
            )
        );

        $html = $this->load->view('layout/pdfLayout/suratJalan', $data, true);
        $this->pdfgenerator->generate($html, $data['title']);
    }
	
}
