<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

	function __construct(){
        parent::__construct();
        $this->load->model('GeneralModel');
        if (empty($this->session->userdata('login'))) {
        	redirect('/login');
        }
    }
	public function index(){
		$data_to_show = array(
			'list' => $this->GeneralModel->getItem('*', 'info_jurusan'),
		);
		$this->load->view('pages/header');
		$this->load->view('dashboard/dashboard', $data_to_show);
		$this->load->view('pages/footer');
	}
	public function add(){
		$data_to_show = array(
			'jenis_kampus' => $this->GeneralModel->getItem('*', 'kampus_tipe'),
			'nama_kampus' => $this->GeneralModel->getItem('*', 'kampus_nama'),
			'regional' => $this->GeneralModel->getItem('*', 'regional'),
			'akreditasi' => $this->GeneralModel->getItem('*', 'akreditasi')
		);
		$this->load->view('pages/header');
		$this->load->view('dashboard/tambah_tab', $data_to_show);
		$this->load->view('pages/footer');
	}
	public function data(){
		$data_to_show = array(
			'jenis_kampus' => $this->GeneralModel->getItem('*', 'kampus_tipe'),
			'nama_kampus' => $this->GeneralModel->getItem('*', 'kampus_nama'),
			'regional' => $this->GeneralModel->getItem('*', 'regional'),
			'akreditasi' => $this->GeneralModel->getItem('*', 'akreditasi')
			);
		$this->load->view('pages/header');
		$this->load->view('dashboard/data_tab', $data_to_show);
		$this->load->view('pages/footer');
	}
	public function edit($id){
		$where = array('id'=>$id);
		$data_to_show = array(
			'jenis_kampus' => $this->GeneralModel->getItem('*', 'kampus_tipe'),
			'nama_kampus' => $this->GeneralModel->getItem('*', 'kampus_nama'),
			'regional' => $this->GeneralModel->getItem('*', 'regional'),
			'akreditasi' => $this->GeneralModel->getItem('*', 'akreditasi'),
			'item'=> $this->GeneralModel->getByParam('info_jurusan', $where),
			);
		$this->load->view('pages/header');
		$this->load->view('dashboard/edit_item_tab', $data_to_show);
		$this->load->view('pages/footer');
	}

	// logical

	public function tambah_data($param){
		$this->input->post('input');
		switch ($param) {
			case 'jenis_kampus':
				$this->form_validation->set_rules('input', 'Inputan', 'required|is_unique[kampus_tipe.tipe]');
				if ($this->form_validation->run()) {
					$data['tipe'] = $this->input->post('input');
					$this->GeneralModel->create('kampus_tipe', $data);
				}else{
					$this->session->set_flashdata('error_jenis_kampus', validation_errors());
				}
				break;

			case 'nama_kampus':
				$this->form_validation->set_rules('input', 'Inputan', 'required|is_unique[kampus_nama.nama]');
				if ($this->form_validation->run()) {
					$data['nama'] = $this->input->post('input');
					$this->GeneralModel->create('kampus_nama', $data);
				}else{
					$this->session->set_flashdata('error_nama_kampus', validation_errors());
				}
				break;

			case 'regional':
				$this->form_validation->set_rules('input', 'Inputan', 'required|is_unique[regional.regional]');
				if ($this->form_validation->run()) {
					$data['regional'] = $this->input->post('input');
					$this->GeneralModel->create('regional', $data);
				}else{
					$this->session->set_flashdata('error_regional', validation_errors());
				}
				break;

			case 'akreditasi':
				$this->form_validation->set_rules('input', 'Inputan', 'required|is_unique[akreditasi.akreditasi]');
				if ($this->form_validation->run()) {
					$data['akreditasi'] = $this->input->post('input');
					$this->GeneralModel->create('akreditasi', $data);
				}else{
					$this->session->set_flashdata('error_akreditasi', validation_errors());
				}
				break;

		}
		redirect(base_url().'dashboard/admin/data');
	}

	public function hapus_data($param, $id){
		
		switch ($param) {
			case 'jenis_kampus':
					$data['id'] = $id;
					$this->GeneralModel->destroy('kampus_tipe', $data);
				break;

			case 'nama_kampus':
				$data['id'] = $id;
				$this->GeneralModel->destroy('kampus_nama', $data);
				break;

			case 'regional':
				$data['id'] = $id;
				$this->GeneralModel->destroy('regional', $data);
				break;

			case 'akreditasi':
				$data['id'] = $id;
				$this->GeneralModel->destroy('akreditasi', $data);
				break;

		}
		redirect(base_url().'dashboard/admin/data');
	}

	public function tambah_info(){
		$this->form_validation->set_rules('nama_jurusan', 'Nama Jurusan', 'required');
		$this->form_validation->set_rules('jenis_kampus', 'Jenis Kampus', 'required');
		$this->form_validation->set_rules('nama_kampus', 'Nama Kampus', 'required');
		$this->form_validation->set_rules('regional', 'Regional', 'required');
		$this->form_validation->set_rules('akreditasi', 'Akreditasi', 'required');
		$this->form_validation->set_rules('peminat', 'Jumlah Peminat', 'required|numeric');
		$this->form_validation->set_rules('kuota', 'Data Tampung', 'required|numeric');
		$this->form_validation->set_rules('penerimaan', 'Jalur penerimaan', 'required');
		$this->form_validation->set_rules('ulasan', 'Ulasan', '');
		$this->form_validation->set_rules('portofolio', 'Portofolio', 'required');

		if ($this->form_validation->run()) {
			$data = array(
				'nama_jurusan'=> $this->input->post('nama_jurusan'), 
				'jenis_kampus'=> $this->input->post('jenis_kampus'), 
				'nama_kampus'=> $this->input->post('nama_kampus'), 
				'regional'=> $this->input->post('regional'), 
				'akreditasi'=> $this->input->post('akreditasi'), 
				'peminat'=> $this->input->post('peminat'), 
				'dayatampung'=> $this->input->post('kuota'), 
				'jalur_penerimaan'=> $this->input->post('penerimaan'), 
				'ulasan'=> $this->input->post('ulasan'), 
				'portofolio'=> $this->input->post('portofolio'), 
				'jurusan_sma' => $this->input->post('jurusanSMA'),
				);
			if (!empty($_FILES['image']['tmp_name'])) {
				$data['gambar'] = $this->uploadImage();
			}else{
				$data['gambar'] = base_url().'uploads/noimg.png';
			}
			
			if ($this->GeneralModel->create('info_jurusan', $data)) {
				redirect(base_url().'dashboard/admin');
			}else{
				// $this->session->set_flashdata('error','Oopss, telah terjadi error, coba sekali lagi!');
				// redirect(base_url().'dashboard/admin/add');
				// echo 'gagagaga';
			}
		}else{
			$this->add();
			// echo validation_errors();
			// redirect(base_url().'dashboard/admin/add');
		}

	}

	public function uploadImage(){
		$config = array(
				'upload_path'=> './uploads/',
				'allowed_types'=>'gif|jpg|png|jpeg',
				'max_size'=>20048,
				'overwrite'=>false,
				'file_name'=>'JURUSAN_'.$this->randString(9));
			$this->upload->initialize($config);
			$do = $this->upload->do_upload('image');
			if ($do) {
				return base_url().'uploads/'.$this->upload->data('file_name');
			}else{
				// $this->session->set_flashdata('error','Oopss, telah terjadi ketika mengupload gambar');
				// redirect(base_url().'dashboard/admin/add');
				echo "galgal";
			}
	}

	function randString($panjang){

		 $characters = '1234567890QWERTYUIOPLKJHGFDSAZXCVBNM';
		 $string = '';
		 $max = strlen($characters) - 1;
		 for ($i = 0; $i < $panjang; $i++) {
		      $string .= $characters[mt_rand(0, $max)];
		 }
		 return $string;
	}

	public function hapus_jurusan($id){
		$data['id'] = $id;
		$this->GeneralModel->destroy('info_jurusan', $data);
		redirect(base_url().'dashboard/admin');
	}

}
