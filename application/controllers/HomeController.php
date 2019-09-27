<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class HomeController extends CI_Controller {

	public function index()
	{
		$data['title'] = 'Home page';
		//$data['bread'] = 'Home';
		$data['content'] = $this->load->view('admin/home',$data, TRUE);
		$this->load->view('admin/layouts/master',$data);
	}
}
