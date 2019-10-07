<?php
defined('BASEPATH') or exit('No direct script access allowed');

class SupplierController extends CI_Controller
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
		$data['title'] = 'Supplier';
		$data['bread'] = 'Supplier';
		$data['content'] = $this->load->view('admin/supplier/supplier', $data, TRUE);
		$this->load->view('admin/layouts/master', $data);
    }
    
    public function getSeletedSuppliers(){
        $getSupplier = $this->db->query("
                        SELECT
                         sp.supplier_id,
                         sp.phone,
                         sp.due_amount as previous_due,
                         sp.name,
                         CONCAT(sp.name,' - ', sp.supplier_code) as display_name
                        FROM tbl_suppliers as sp
                        WHERE sp.is_deleted = 0")->result();
        echo json_encode($getSupplier);
    }


}
