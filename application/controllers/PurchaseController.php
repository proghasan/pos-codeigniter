<?php
defined('BASEPATH') or exit('No direct script access allowed');

class PurchaseController extends CI_Controller
{
	public $branch;
	public $user_id;
	public function __construct()
	{
		parent::__construct();
		$this->branch = $this->session->userdata('branch');
		$this->user_id = $this->session->userdata('user_id');
		if ($this->session->userdata('status') == false) {
			redirect('/path', 'location');
		}
	}
	public function index()
	{
		$data['title'] = 'Product Purchase';
		$data['bread'] = 'Product Purchase';
		$data['content'] = $this->load->view('admin/purchase/Product_purchase', $data, TRUE);
		$this->load->view('admin/layouts/master', $data);
    }


}
