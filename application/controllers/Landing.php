<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Landing extends CI_Controller {

	function __construct(){
        parent::__construct();
        $this->load->model('GeneralModel');
    }

    public function index(){
    	$data = array(
    		'highlight' => $this->GeneralModel->getByLimit('info_jurusan'),
    		'title' => 'SiapKuliah | Home'
    		);
    	$this->load->view('front/header', $data);
    	$this->load->view('front/landing');
    	$this->load->view('front/footer');
    }

    public function lists(){
    	$data = array(
    		'title' => 'Kumpulan Info Jurusan',
    		'list' => $this->GeneralModel->getItem('*', 'info_jurusan')
    		);
    	$this->load->view('front/header', $data);
    	$this->load->view('front/list_page');
    	$this->load->view('front/footer');
    }
    public function item($id){
    	$where = array(
    		'id' => $id
    		);
    	$title = $this->GeneralModel->getByParam('info_jurusan',$where);
    	$data = array(
    		'title' => $title[0]['nama_jurusan'].' | Info Jurusan',
    		'item' => $this->GeneralModel->getByParam('info_jurusan',$where),
    		);
    	$this->load->view('front/header', $data);
    	$this->load->view('front/item_page');
    	$this->load->view('front/footer');
    }
    public function search(){
    	$input = $this->input->post('pencarian');
    	$hasil = array(
    		'title' => 'Pencarian | Info Jurusan',
    		'list' => $this->GeneralModel->data_on_search($input),
    		);
    	$this->load->view('front/header', $hasil);
    	$this->load->view('front/list_page');
    	$this->load->view('front/footer');
    }
}