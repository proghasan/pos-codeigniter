<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class FuckController extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('AccessModel','dataRet');
	}

	public function index(){
		if($this->session->userdata('status')==true){	
			redirect('/home', 'location');
		}
		$data['title'] = 'Login';
		$data['content'] = $this->load->view('login', $data);
	}
	// login process

	public function loginProcess(){
		$this->load->library('form_validation');
		$this->form_validation->set_rules('user_name','username','required');
		$this->form_validation->set_rules('password','password','required');

		if($this->form_validation->run() == false){
		  redirect('/path','location');
		}else{
			$username = $this->input->post('user_name');
			$password  = $this->input->post('password');
			$gurd = $this->dataRet->can_login($username,$password);
			if($gurd){
				$session_data = array(
					'name' => $gurd->name,
					'user_name' => $gurd->user_name,
					'access' => $gurd->access,
					'branch' => $gurd->branch,
					'user_id' => $gurd->user_id,
					'status' => true
				);
				$this->session->set_userdata($session_data);
				redirect('/home','location');	
			}else{
				$this->session->set_flashdata('error','Invalid username and password');	
				redirect('/path','location');
			}
		}

	}

	public function logout(){
		$this->session->sess_destroy();
		redirect('/path','location');
	}
}
