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
		$data['content'] = $this->load->view('admin/purchase/product_purchase', $data, TRUE);
		$this->load->view('admin/layouts/master', $data);
	}
	public function purchaseOrder()
	{
		$res = ['success' => false, 'message' => '', 'purchase_id' => ''];
		try{
			$data = json_decode($this->input->raw_input_stream);
			echo "<pre>";
			print_r($data);
			exit;
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
				'transport_cost' => $data->purchase->transport_amount,
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
				'purchase_rate' => $cart->purchase_rate,
				'sale_rate' => $cart->sale_rate,
				'purchase_date' => $data->purchase->purchase_date,
				'total' => $cart->purchase_rate * $cart->qty,
				'branch' => $this->branch,
				'added_by' => $this->user_id,
				'added_time' => date("Y-m-d h:i:s"),
			);
			$inventoryCheck = $this->db->where("product_id", $cart->product_id)->where("group_id",$cart->group_id)->where('branch',$this->branch)->get("tbl_current_inventory")->num_rows();
			if($inventoryCheck > 0){
				// update current inventory
				$update = $this->db->query("
						update tbl_current_inventory set
						purchase_quantity  = purchase_quantity + ?
						where product_id = ?
						and group_id = ?
						and branch = ? ",[$cart->qty, $cart->product_id,  $cart->group_id, $this->branch]);
			}else{
				$inventroyData = array(
					'product_id' => $cart->product_id,
					'barcode' => $cart->barcode,
					'group_id' => $cart->group_id,
					'purchase_quantity' => $cart->qty,
					'sale_rate' => $cart->sale_rate,
					'purchase_rate' => $cart->purchase_rate,
					'branch' => $this->branch
				);
				$this->db->insert("tbl_current_inventory",$inventroyData);
			}
			array_push($cartArray,$purchaseDetails);
			endforeach;
			$this->db->insert_batch("tbl_purchases_details",$cartArray);
			$res = ['success' => true, 'message' => 'Purchase Successfully', 'purchase_id' => $master_id];
		}catch(Exception $e){
			$res = ['success' => false, 'message' => $e->getMessage(),'purchase_id' => ''];
		}
		echo json_encode($res);
	}
	
	public function checkAlreadyExits(){
	 $data = json_decode($this->input->raw_input_stream);
	 $res = ['success' => false, 'sale_rate'=> '', 'purchase_rate' => ''];
	 $get = $this->db->query("select purchase_rate,sale_rate from tbl_current_inventory where branch = ? and product_id = ? and group_id = ?",[$this->branch,$data->product_id,$data->group_id]);
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
							s.supplier_code
							
						FROM tbl_purchase_master as pm
						LEFT JOIN tbl_suppliers as s on s.supplier_id = pm.supplier_id
						WHERE pm.is_deleted =0 AND pm.branch = ? 
						AND pm.purchase_date BETWEEN ? AND ?
						$end
						",[$this->branch, $data->start_date, $data->end_date])->result();
		echo json_encode($getData);
	
	}



}
