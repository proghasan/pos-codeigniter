<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class HomeController extends CI_Controller {

	public function index()
	{
		$this->load->view('admin/home');
		$this->load->view('admin/layouts/master')
	}
}
