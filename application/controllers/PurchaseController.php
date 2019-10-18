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
		$this->load->model('CodeModel', 'codeRat');
		$this->load->model('AccountModel', 'ac');
		if ($this->session->userdata('status') == false) {
			redirect('/path', 'location');
		}
	}
	public function index()
	{
		$data['title'] = 'Product Purchase';
		$data['bread'] = 'Product Purchase';
		$data['edit_id'] = 0;
		$data['content'] = $this->load->view('admin/purchase/product_purchase', $data, TRUE);
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
	public function purchaseUpdateProcess()
	{
		$res = ['success' => false, 'message' => '', 'purchase_id' => ''];
		try{
			$data = json_decode($this->input->raw_input_stream);
			// first delete purchase details
			$deletePurchaseeDetails = $this->db->where("purchase_id", $data->purchase->purchase_id)->update("tbl_purchases_details",['is_deleted' => 1]);
			$purchaseMater = array( 
				'supplier_id' => $data->purchase->supplier_id,
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
				'branch' => $this->branch,
				'purchase_date' => $data->purchase->purchase_date,
				'updated_by' => $this->user_id,
				'updated_time' => date("Y-m-d h:i:s"),
			);
			// update master
			$this->db->where('purchase_id', $data->purchase->purchase_id)->update("tbl_purchase_master",$purchaseMater);
			$previous_due = $this->ac->supplierCurrentDue($data->purchase->supplier_id);
			// previous due update 
			$this->db->where("purchase_id", $data->purchase->purchase_id)->update("tbl_purchase_master",['previous_due' => $previous_due]);
			
			// details
			$cartArray = [];
			foreach($data->cart as $cart):
			$purchaseDetails = array(
				'purchase_id' => $data->purchase->purchase_id,
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
			$res = ['success' => true, 'message' => 'Purchase Update Successfully', 'purchase_id' => $data->purchase->purchase_id];
		}catch(Exception $e){
			$res = ['success' => false, 'message' => $e->getMessage(),'purchase_id' => ''];
		}
		echo json_encode($res);
	}
	
	public function checkAlreadyExits(){
	 $data = json_decode($this->input->raw_input_stream);
	 $res = ['success' => false, 'sale_rate'=> '', 'purchase_rate' => ''];
	 $get = $this->db->query("
							select 
							 purchase_rate,
							 sale_rate 
							from tbl_purchases_details 
							where is_deleted = 0 
							and branch = ? 
							and product_id = ? 
							and group_id = ?",[$this->branch,$data->product_id,$data->group_id]);
	 if($get->num_rows() > 0){
		$rate = $get->row();
		$res = ['success' => true, 'sale_rate'=> $rate->sale_rate, 'purchase_rate' => $rate->purchase_rate];
	 }
	 echo json_encode($res);
	}

	public function purchaseInvoice($id){
		echo $id;
	}
	public function purchaseReport(){
		$data['title'] = 'Purchase Report';
		$data['bread'] = 'Purchase Report';
		$data['content'] = $this->load->view('admin/purchase/purchase_report', $data, TRUE);
		$this->load->view('admin/layouts/master', $data);
	}
	public function getPurchaseReports(){
		$data = json_decode($this->input->raw_input_stream);
		$end = "";
		if($data->supplier_id !=""){
			$end .=" and pm.supplier_id = '$data->supplier_id'";
		}
		$getData = $this->db->query("
						SELECT
							pm.invoice,
							pm.sub_total,
							pm.discount_amount,
							pm.previous_due,
							pm.total,
							pm.supplier_id,
							pm.paid,
							pm.purchase_date,
							s.name,
							s.supplier_code,
							pm.purchase_id
							
						FROM tbl_purchase_master as pm
						LEFT JOIN tbl_suppliers as s on s.supplier_id = pm.supplier_id
						WHERE pm.is_deleted =0 AND pm.branch = ? 
						AND pm.purchase_date BETWEEN ? AND ?
						$end
						",[$this->branch, $data->start_date, $data->end_date])->result();
		echo json_encode($getData);
	
	}

	public function productPurchaseEdit($id)
	{
		$data['title'] = 'Product Purchase';
		$data['bread'] = 'Product Purchase';
		$data['edit_id'] = $id;
		$data['content'] = $this->load->view('admin/purchase/product_purchase', $data, TRUE);
		$this->load->view('admin/layouts/master', $data);
	}
	public function getSinglePurchase(){
		$data = json_decode($this->input->raw_input_stream);
		$dataObj = (object)[];
		$dataObj->masterData = $this->db->query("
										SELECT
										 * 
										FROM tbl_purchase_master
										WHERE purchase_id=?", $data->id)->row();
										
		$dataObj->purchase_detail = $this->db->query("
										select 
										 * 
										from  tbl_purchases_details as d
										left join tbl_products as p on p.product_id = d.product_id 
										left join tbl_groups as g on g.id = d.group_id
										where d.is_deleted = 0 
										and purchase_id = ? ",$data->id)->result();

		$dataObj->supplier = $this->db->query("
									SELECT
										sp.supplier_id,
										sp.phone,
										sp.name,
										CONCAT(sp.name,' - ', sp.supplier_code) as display_name
									FROM tbl_purchase_master as m
									LEFT JOIN tbl_suppliers as sp on sp.supplier_id = m.supplier_id
									WHERE m.purchase_id = ? ", $data->id)->row();
		echo json_encode($dataObj);
	}



}
