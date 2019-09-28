<?php
defined('BASEPATH') or exit('No direct script access allowed');

class GroupController extends CI_Controller
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
		$data['title'] = 'Group';
		$data['bread'] = 'Group';
		$data['content'] = $this->load->view('admin/group/group', $data, TRUE);
		$this->load->view('admin/layouts/master', $data);
	}
	public function addGroup()
	{
		$data = json_decode($this->input->raw_input_stream);
		$res = ['success' => false, 'message' => ''];
		$groupData = array(
			'group_name' => $data->group->group_name,
			'added_by' => $this->user_id,
			'added_time' => date("Y-m-d H:i:s")
		);
		$insert = $this->db->insert("tbl_groups", $groupData);
		if ($insert) :
			$res = ['success' => true, 'message' => 'Group Added SuccessFully'];
		else :
			$res = ['success' => false, 'message' => 'Group Added Faill'];
		endif;
		echo json_encode($res);
	}

	public function updateGroup()
	{
		$data = json_decode($this->input->raw_input_stream);
		$res = ['success' => false, 'message' => ''];
		$groupData = array(
			'group_name' => $data->group->group_name,
			'update_by' => $this->user_id,
			'update_time' => date("Y-m-d H:i:s")
		);
		$update = $this->db->where('id', $data->group->id)->update("tbl_groups", $groupData);
		if ($update) :
			$res = ['success' => true, 'message' => 'Group Updated SuccessFully'];
		else :
			$res = ['success' => false, 'message' => 'Group Updated Field'];
		endif;
		echo json_encode($res);
	}
	public function deleteGroup()
	{
		$data = json_decode($this->input->raw_input_stream);
		$res = ['success' => false, 'message' => ''];
		$delete = $this->db->where('id', $data->id)->update("tbl_groups", ['is_deleted' => 1]);
		if ($delete) :
			$res = ['success' => true, 'message' => 'Group Deleted SuccessFully'];
		else :
			$res = ['success' => false, 'message' => 'Group Deleted Field'];
		endif;
		echo json_encode($res);
    }
    public function getGroups()
	{
		$getGroups = $this->db->where('is_deleted', 0)->order_by('id','desc')->get("tbl_groups")->result();
		echo json_encode($getGroups);
	}

}
