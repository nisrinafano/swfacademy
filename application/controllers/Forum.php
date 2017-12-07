<?php
class Forum extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model('Forum_model', 'forum');
	}

	public function index(){
		$this->load->view('forum/header');
		$this->load->view('forum/list_forum');
		$this->load->view('forum/footer');
	}
	public function ask(){
		$this->load->view('forum/header');
		$this->load->view('forum/asking_new');
		$this->load->view('forum/footer');	
	}
	public function item(){
		$this->load->view('forum/header');
		$this->load->view('forum/forum_item');
		$this->load->view('forum/footer');		
	}
	public function view_forum(){
		$getter = $this->forum->getAllData('nama tabel'); //return array object
		$this->load->view('view', $getter);
	}

	public function show($forum_id){
		$where['kolom'] = $forum_id;
		$getter = $this->forum->getById($where, 'nama tabel');
		$this->load->view('view', $getter);	
	}

	public function new_forum(){
		$this->form_validation->set_rules('name', 'showed name', 'required'); //validasi form

		$user_id = $this->session->userdata('sess name')['id'];
		$inserted_data = array(
			'' => $user_id,
			'' => 'whatever'
			);
		$query_action = $this->forum->insert($inserted_data, 'tabel name');
		if ($this->form_validation->run()) {
			if ($query_action) {
				echo true;
			}else{
				echo false;
			}
		}else{
			echo validation_errors();
		}
	}

	public function new_answer($forum_id){
		$this->form_validation->set_rules('name', 'showed name', 'required'); //validasi form

		$user_id = $this->session->userdata('sess name')['id'];
		$inserted_data = array(
			'' => $user_id,
			'' => $forum_id
			);
		$query_action = $this->forum->insert($inserted_data, 'tabel name');
		if ($this->form_validation->run()) {
			if ($query_action) {
				echo true;
			}else{
				echo false;
			}
		}else{
			echo validation_errors();
		}
	}

	public function new_like($answer_id){
		$user_id = $this->session->userdata('sess name')['id'];
		$where = array(
			'' => $answer_id, 
			'' => $user_id
			);
		$cekLike_status = $this->forum->matchId($where, 'tabel');

		if ($cekLike_status) {
			$this->forum->insert($where, 'tabel');
		}else{
			$this->forum->destroy($where, 'tabel');
		}
	}
}