<?php
defined('BASEPATH') or exit('No direct script access allowed');

class BasicController extends CI_Controller
{
	public $branch;
	public $user_id;
	public function __construct()
	{
		parent::__construct();
		$this->branch = $this->session->userdata('branch');
        $this->user_id = $this->session->userdata('user_id');
        $this->load->model('CodeModel', 'codeRat');
		if ($this->session->userdata('status') == false) {
			redirect('/path', 'location');
		}
    }
    
    public function getBranchInfo()
    {
        $getInfo = $this->db->query("
                              select 
                                b.branch_name,
                                a.name

                              from tbl_admin as a
                              inner join tbl_branch as b on b.branch_id = a.branch
                              where b.branch_id = ? 
                              and b.is_active= ?",[$this->branch,1])->row();
        echo json_encode($getInfo);
    }

    public function getPurchaseInvoice()
    {
        $invoice = $this->codeRat->genInvoice("purchase_id","tbl_purchase_master");
        echo json_encode($invoice);
    }



}
