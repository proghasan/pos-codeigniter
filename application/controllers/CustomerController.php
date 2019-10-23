<?php
defined('BASEPATH') or exit('No direct script access allowed');

class CustomerController extends CI_Controller
{
	public $branch;
	public $user_id;
	public function __construct()
	{
		parent::__construct();
		$this->branch = $this->session->userdata('branch');
        $this->user_id = $this->session->userdata('user_id');
        $this->load->model('CodeModel', 'codeRat');
        $this->load->model('AccountModel', 'ac');
        
		if ($this->session->userdata('status') == false) {
			redirect('/path', 'location');
		}
    }

    public function getCustomers(){
		$customers = $this->ac->getAllCustomers();
		echo json_encode($customers);
    }
    
}
