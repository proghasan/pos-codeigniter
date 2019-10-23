<?php
defined('BASEPATH') or exit('No direct script access allowed');

class SalesController extends CI_Controller
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
	public function index()
	{
		$data['title'] = 'Product Sales';
		$data['bread'] = 'Product Sales';
		$data['edit_id'] = 0;
		$data['content'] = $this->load->view('admin/sale/sale', $data, TRUE);
		$this->load->view('admin/layouts/master', $data);
	}
	public function purchaseOrder()
	{
		$res = ['success' => false, 'message' => '', 'purchase_id' => ''];
		try{
			$data = json_decode($this->input->raw_input_stream);
			$invoice = $this->codeRat->genInvoice("purchase_id","tbl_purchase_master");
			$previous_due = $this->ac->supplierCurrentDue($data->purchase->supplier_id);
			$purchaseMater = array( 
				'supplier_id' => $data->purchase->supplier_id,
				'invoice' => $invoice,
				'sub_total' => $data->purchase->sub_total,
				// 'discount_percent' => 0,
				'discount_amount' => $data->purchase->discount_amount,
				'vat_percent' => $data->purchase->vat_percent,
				'vat_amount' => $data->purchase->vat_amount,
				'transport_cost' => $data->purchase->transport_cost,
				'other_cost' => 0,
				'total' => $data->purchase->total,
				'paid' => $data->purchase->paid,
				'due' => $data->purchase->due,
				'previous_due' => $previous_due,
				'branch' => $this->branch,
				'purchase_date' => $data->purchase->purchase_date,
				'added_by' => $this->user_id,
				'added_time' => date("Y-m-d h:i:s"),
			);
			// insert master
			$this->db->insert("tbl_purchase_master",$purchaseMater);
			$master_id  = $this->db->insert_id();

			// details
			$cartArray = [];
			foreach($data->cart as $cart):
			$purchaseDetails = array(
				'purchase_id' => $master_id,
				'product_id' => $cart->product_id,
				'group_id' => $cart->group_id,
				'qty' => $cart->qty,
				'barcode' => $cart->barcode,
				'purchase_rate' => $cart->purchase_rate,
				'sale_rate' => $cart->sale_rate,
				'purchase_date' => $data->purchase->purchase_date,
				'total' => $cart->purchase_rate * $cart->qty,
				'branch' => $this->branch,
				'added_by' => $this->user_id,
				'added_time' => date("Y-m-d h:i:s"),
			);
			array_push($cartArray,$purchaseDetails);
			endforeach;
			$this->db->insert_batch("tbl_purchases_details",$cartArray);
			$res = ['success' => true, 'message' => 'Purchase Successfully', 'purchase_id' => $master_id];
		}catch(Exception $e){
			$res = ['success' => false, 'message' => $e->getMessage(),'purchase_id' => ''];
		}
		echo json_encode($res);
	}
}
