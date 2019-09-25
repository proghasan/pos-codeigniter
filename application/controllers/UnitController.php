<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UnitController extends CI_Controller {

	public function index()
	{
		$this->load->view('admin/home');
	}
}
