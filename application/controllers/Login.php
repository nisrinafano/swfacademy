<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	function __construct(){
        parent::__construct();
        $this->load->model('GeneralModel');
    }

    public function index(){
    	$this->load->view('pages/login');
    }

    public function doLogin(){
    	$where = array(
    		'username' => $this->input->post('username'),
    		'password' => $this->input->post('password'),
    		);
    	$do = $this->GeneralModel->getByParam('user', $where);
    	if ($do) {
    		$data['username'] = $this->input->post('username');
    		$this->session->set_userdata('login', $data);
    		redirect(base_url().'dashboard/admin');
    	}else{
    		$this->session->set_flashdata('gagal', 'username atau password salah');
    		redirect(base_url().'login');
    	}
    }

    public function logout(){
		$this->session->unset_userdata('login');
	    $this->session->sess_destroy();
	    redirect('login');
	}
}