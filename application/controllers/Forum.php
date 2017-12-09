<?php
class Forum extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model('Forum_model', 'forum');
	}

	public function index(){
		$list_forum = $this->forum->getAllData_sort_desc('forum_topic');
		if(empty($list_forum)){echo '';}else{
			foreach ($list_forum as $l) {
				$num[] = $this->forum->count_row(array('id_forum'=>$l['forum_id']),'forum_answer');
				$vote[] = $this->forum->count_row(array('id_forum'=>$l['forum_id'], 'like_type'=>'0'),'forum_like');
				for ($i=0; $i < count($num); $i++) { 
							$list_forum[$i]['num'] = $num[$i];
						}
				for ($i=0; $i < count($vote); $i++) { 
							$list_forum[$i]['vote'] = $vote[$i];
						}		
			}
		}
		$data = array(
			'forum'=> $list_forum,
			'title'=> 'SWF Forum',
			// 'num_ans' => $num
			);
		// var_dump($data);
		$this->load->view('forum/header', $data);
		$this->load->view('forum/list_forum');
		$this->load->view('forum/footer');
	}

	public function tags($term){
		$where = array('tags'=>$term);
		$list_forum = $this->forum->searchById_many_desc($where, 'forum_topic','timestamp');
		if(empty($list_forum)){echo '';}else{
			foreach ($list_forum as $l) {
				$num[] = $this->forum->count_row(array('id_forum'=>$l['forum_id']),'forum_answer');
				$vote[] = $this->forum->count_row(array('id_forum'=>$l['forum_id'], 'like_type'=>'0'),'forum_like');
				for ($i=0; $i < count($num); $i++) { 
							$list_forum[$i]['num'] = $num[$i];
						}
				for ($i=0; $i < count($vote); $i++) { 
							$list_forum[$i]['vote'] = $vote[$i];
						}		
			}
		}
		$data = array(
			'forum'=> $list_forum,
			'title'=> $term.' | SWF Forum',
			// 'num_ans' => $num
			);
		// var_dump($data);
		$this->load->view('forum/header', $data);
		$this->load->view('forum/list_forum');
		$this->load->view('forum/footer');
	}

	public function search($param=''){
		if (!$param) {
			if (empty($this->input->post('search-term'))) {
				redirect(base_url().'forum');
			}else{
			$term = url_title($this->input->post('search-term'), 'dash', TRUE);
			redirect(base_url().'forum/search/'.$term);
			}
		}else{
			$search_term = str_replace('-', ' ', $param);
		}
		$where = array('title'=>$search_term,'tags'=>$search_term);
		$list_forum = $this->forum->multiSearchById_many_desc($where, 'forum_topic','timestamp');
		if(empty($list_forum)){echo '';}else{
			foreach ($list_forum as $l) {
				$num[] = $this->forum->count_row(array('id_forum'=>$l['forum_id']),'forum_answer');
				$vote[] = $this->forum->count_row(array('id_forum'=>$l['forum_id'], 'like_type'=>'0'),'forum_like');
				for ($i=0; $i < count($num); $i++) { 
							$list_forum[$i]['num'] = $num[$i];
						}
				for ($i=0; $i < count($vote); $i++) { 
							$list_forum[$i]['vote'] = $vote[$i];
						}		
			}
		}
		$data = array(
			'forum'=> $list_forum,
			'title'=> $search_term.' | SWF Forum',
			// 'num_ans' => $num
			);
		// var_dump($data);
		$this->load->view('forum/header', $data);
		$this->load->view('forum/list_forum');
		$this->load->view('forum/footer');
	}

	public function ask(){
		$data = array(
			'title'=> 'Ask something here'
			);
		$this->load->view('forum/header', $data);
		$this->load->view('forum/asking_new');
		$this->load->view('forum/footer');	
	}

	public function show($forum_id='', $slug=''){
		$where = array(
			'forum_id'=>$forum_id,
			);
		$where2 = array(
			'id_forum'=>$forum_id,
			);
		$getter = $this->forum->getById($where, 'forum_topic')[0];
		if (!$slug && !$forum_id) {
			redirect(base_url().'forum');
		}
		if (!$slug) {
			redirect(base_url().'forum/show/'.$forum_id.'/'.$getter['title_slug']);
		}
			// var_dump($getter['title_slug']);
		$getter_answer = $this->forum->getById_many_asc($where2, 'forum_answer', 'timestamp');

		if(empty($getter_answer)){echo '';}else{
			foreach ($getter_answer as $g) {
				$upvote[] = $this->forum->count_row(array('id_answer'=>$g['ans_id'], 'like_type'=>'0'),'forum_answer_like');
				$downvote[] = $this->forum->count_row(array('id_answer'=>$g['ans_id'], 'like_type'=>'1'),'forum_answer_like');
				for ($i=0; $i < count($upvote); $i++) { 
							$getter_answer[$i]['upvote'] = $upvote[$i];
						}
				for ($i=0; $i < count($downvote); $i++) { 
							$getter_answer[$i]['downvote'] = $downvote[$i];
						}
			}
		}

		$data = array(
			'title'=> $getter['title'],
			'forum'=> $getter,
			'answer' => $getter_answer,
			'num_ans' => $this->forum->count_row(array('id_forum'=>$forum_id),'forum_answer'),
			'upvote' => $this->forum->count_row(array('id_forum'=>$forum_id, 'like_type'=>'0'),'forum_like'),
			'downvote' => $this->forum->count_row(array('id_forum'=>$forum_id, 'like_type'=>'1'),'forum_like'),
			);
		$this->load->view('forum/header', $data);
		$this->load->view('forum/forum_item');
		$this->load->view('forum/footer');	
	}

	public function new_forum(){
		$this->form_validation->set_rules('forum-title', 'Topic Title', 'required|max_length[200]'); //validasi form

		$generate_slug = url_title($this->input->post('forum-title'), 'dash', TRUE);
		// $user_id = $this->session->userdata('sess name')['id'];
		$user_id = '12345';
		$inserted_data = array(
			'id_user' => $user_id,
			'title' => ucfirst($this->input->post('forum-title')),
			'content' => ucfirst($this->input->post('forum-content')),
			'tags' => $this->input->post('forum-tags'),
			'title_slug' => $generate_slug
			);
		if ($this->form_validation->run()) {
			$query_action = $this->forum->insert($inserted_data, 'forum_topic');
			if ($query_action) {
				// echo true;
				redirect(base_url()."forum");
			}else{
				// echo false;
				redirect(base_url()."forum/ask");
			}
		}else{
			echo validation_errors();
		}
	}

	public function new_answer($forum_id){
		$this->form_validation->set_rules('ans-content', 'Answer', 'required|max_length[450]'); //validasi form

		// $user_id = $this->session->userdata('sess name')['id'];
		$user_id = '1234';
		$inserted_data = array(
			'id_user' => $user_id,
			'id_forum' => $forum_id,
			'content' => $this->input->post('ans-content'),
			);
		
		if ($this->form_validation->run()) {
			$query_action = $this->forum->insert($inserted_data, 'forum_answer');
			if ($query_action) {
				// echo true;
				redirect(base_url().'forum/show/'.$forum_id);
			}else{
				// echo false;
				redirect(base_url().'forum/show/'.$forum_id);
			}
		}else{
			echo validation_errors();
		}
	}

	public function new_upvote_forum($forum_id){
		// $user_id = $this->session->userdata('sess name')['id'];
		$user_id = '1234';
		$where = array(
			'id_forum' => $forum_id, 
			'id_user' => $user_id,
			'like_type' => '0' //upvote
			);
		$where2 = array(
			'id_forum' => $forum_id, 
			'id_user' => $user_id,
			'like_type' => '1' //downvote
			);
		$where3 = array(
			'id_forum' => $forum_id, 
			'id_user' => $user_id,
			);
		$upvote_status = $this->forum->matchId($where, 'forum_like');
		$downvote_status = $this->forum->matchId($where2, 'forum_like');

		if ($upvote_status) { //true = sudah vote
			$this->forum->destroy($where3, 'forum_like');
		}elseif ($downvote_status) {
			$this->forum->update($where3, array('like_type'=>'0'), 'forum_like');
		}else{
			$this->forum->insert($where, 'forum_like');
		}
		if ($this->uri->segment(2)==false) {
			redirect(base_url().'forum');
		}else{
			redirect(base_url().'forum/show/'.$forum_id);
		}
	}

	public function new_downvote_forum($forum_id){
		// $user_id = $this->session->userdata('sess name')['id'];
		$user_id = '1234';
		$where = array(
			'id_forum' => $forum_id, 
			'id_user' => $user_id,
			'like_type' => '0' //upvote
			);
		$where2 = array(
			'id_forum' => $forum_id, 
			'id_user' => $user_id,
			'like_type' => '1' //downvote
			);
		$where3 = array(
			'id_forum' => $forum_id, 
			'id_user' => $user_id,
			);
		$upvote_status = $this->forum->matchId($where, 'forum_like');
		$downvote_status = $this->forum->matchId($where2, 'forum_like');

		if ($downvote_status) { //true = sudah downvote
			$this->forum->destroy($where3, 'forum_like');
		}elseif ($upvote_status) {
			$this->forum->update($where3, array('like_type'=>'1'), 'forum_like');
		}else{
			$this->forum->insert($where2, 'forum_like');
		}
		if ($this->uri->segment(2)==false) {
			redirect(base_url().'forum');
		}else{
			redirect(base_url().'forum/show/'.$forum_id);
		}
	}

	public function new_upvote_answer($forum_id, $answer_id){
		// $user_id = $this->session->userdata('sess name')['id'];
		$user_id = '1234';
		$where = array(
			'id_answer' => $answer_id, 
			'id_user' => $user_id,
			'like_type' => '0' //upvote
			);
		$where2 = array(
			'id_answer' => $answer_id, 
			'id_user' => $user_id,
			'like_type' => '1' //downvote
			);
		$where3 = array(
			'id_answer' => $answer_id, 
			'id_user' => $user_id,
			);
		$upvote_status = $this->forum->matchId($where, 'forum_answer_like');
		$downvote_status = $this->forum->matchId($where2, 'forum_answer_like');

		if ($upvote_status) { //true = sudah vote
			$this->forum->destroy($where3, 'forum_answer_like');
		}elseif ($downvote_status) {
			$this->forum->update($where3, array('like_type'=>'0'), 'forum_answer_like');
		}else{
			$this->forum->insert($where, 'forum_answer_like');
		}

		redirect(base_url().'forum/show/'.$forum_id);
		
	}

	public function new_downvote_answer($forum_id, $answer_id){
		// $user_id = $this->session->userdata('sess name')['id'];
		$user_id = '1234';
		$where = array(
			'id_answer' => $answer_id, 
			'id_user' => $user_id,
			'like_type' => '0' //upvote
			);
		$where2 = array(
			'id_answer' => $answer_id, 
			'id_user' => $user_id,
			'like_type' => '1' //downvote
			);
		$where3 = array(
			'id_answer' => $answer_id, 
			'id_user' => $user_id,
			);
		$upvote_status = $this->forum->matchId($where, 'forum_answer_like');
		$downvote_status = $this->forum->matchId($where2, 'forum_answer_like');

		if ($downvote_status) { //true = sudah downvote
			$this->forum->destroy($where3, 'forum_answer_like');
		}elseif ($upvote_status) {
			$this->forum->update($where3, array('like_type'=>'1'), 'forum_answer_like');
		}else{
			$this->forum->insert($where2, 'forum_answer_like');
		}

		redirect(base_url().'forum/show/'.$forum_id);

	}
}