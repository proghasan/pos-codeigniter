<?php
defined('BASEPATH') or exit('No direct script access allowed');

class UnitController extends CI_Controller
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
		$data['title'] = 'Unit';
		$data['bread'] = 'Unit';
		$data['content'] = $this->load->view('admin/unit/unit', $data, TRUE);
		$this->load->view('admin/layouts/master', $data);
	}
	public function addUnit()
	{
		$data = json_decode($this->input->raw_input_stream);
		$res = ['success' => false, 'message' => ''];
		$unitData = array(
			'unit_name' => $data->unit->unit_name,
			'added_by' => $this->user_id,
			'added_time' => date("Y-m-d H:i:s")
		);
		$insert = $this->db->insert("tbl_units", $unitData);
		// echo $this->db->last_query();exit;
		if ($insert) :
			$res = ['success' => true, 'message' => 'Unit Added SuccessFully'];
		else :
			$res = ['success' => false, 'message' => 'Unit Added Faill'];
		endif;
		echo json_encode($res);
	}

	public function updateUnit()
	{
		$data = json_decode($this->input->raw_input_stream);
		$res = ['success' => false, 'message' => ''];
		$unitData = array(
			'unit_name' => $data->unit->unit_name,
			'update_by' => $this->user_id,
			'update_time' => date("Y-m-d H:i:s")
		);
		$update = $this->db->where('id', $data->unit->id)->update("tbl_units", $unitData);
		if ($update) :
			$res = ['success' => true, 'message' => 'Unit Updated SuccessFully'];
		else :
			$res = ['success' => false, 'message' => 'Unit Updated Field'];
		endif;
		echo json_encode($res);
	}
	public function deleteUnit()
	{
		$data = json_decode($this->input->raw_input_stream);
		$res = ['success' => false, 'message' => ''];
		$delete = $this->db->where('id', $data->id)->update("tbl_units", ['is_deleted' => 1]);
		if ($delete) :
			$res = ['success' => true, 'message' => 'Unit Deleted SuccessFully'];
		else :
			$res = ['success' => false, 'message' => 'Unit Deleted Field'];
		endif;
		echo json_encode($res);
	}

	public function getUnits()
	{
		$getUnits = $this->db->where('is_deleted', 0)->order_by('id','desc')->get("tbl_units")->result();
		echo json_encode($getUnits);
	}
}
