<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ColorController extends CI_Controller
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
		$data['title'] = 'color';
		$data['bread'] = 'color';
		$data['content'] = $this->load->view('admin/color/color', $data, TRUE);
		$this->load->view('admin/layouts/master', $data);
	}
	public function addColor()
	{
		$data = json_decode($this->input->raw_input_stream);
		$res = ['success' => false, 'message' => ''];
		$colorData = array(
			'color_name' => $data->color->color_name,
			'added_by' => $this->user_id,
			'added_time' => date("Y-m-d H:i:s")
		);
		$insert = $this->db->insert("tbl_colors", $colorData);
		if ($insert) :
			$res = ['success' => true, 'message' => 'Color Added SuccessFully'];
		else :
			$res = ['success' => false, 'message' => 'Color Added Faill'];
		endif;
		echo json_encode($res);
	}

	public function updateColor()
	{
		$data = json_decode($this->input->raw_input_stream);
		$res = ['success' => false, 'message' => ''];
		$colorData = array(
			'color_name' => $data->color->color_name,
			'update_by' => $this->user_id,
			'update_time' => date("Y-m-d H:i:s")
		);
		$update = $this->db->where('id', $data->color->id)->update("tbl_colors", $colorData);
		if ($update) :
			$res = ['success' => true, 'message' => 'Color Updated SuccessFully'];
		else :
			$res = ['success' => false, 'message' => 'Color Updated Field'];
		endif;
		echo json_encode($res);
	}
	public function deleteColor()
	{
		$data = json_decode($this->input->raw_input_stream);
		$res = ['success' => false, 'message' => ''];
		$delete = $this->db->where('id', $data->id)->update("tbl_colors", ['is_deleted' => 1]);
		if ($delete) :
			$res = ['success' => true, 'message' => 'color Deleted SuccessFully'];
		else :
			$res = ['success' => false, 'message' => 'color Deleted Field'];
		endif;
		echo json_encode($res);
	}

	public function getColors()
	{
		$getcolors = $this->db->where('is_deleted', 0)->order_by('id','desc')->get("tbl_colors")->result();
		echo json_encode($getcolors);
	}
}
