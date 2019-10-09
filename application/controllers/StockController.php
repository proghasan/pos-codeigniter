<?php
defined('BASEPATH') or exit('No direct script access allowed');

class StockController extends CI_Controller
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
		$data['title'] = 'Product Stock';
		$data['bread'] = 'Product Stock';
		$data['content'] = $this->load->view('admin/stock/stock', $data, TRUE);
		$this->load->view('admin/layouts/master', $data);
    }
    public function getCurrentStock()
    {
        $data = json_decode($this->input->raw_input_stream);
        $end = "";
        if(!empty($data->product_id)){
            $end .= " and i.product_id = '$data->product_id'";
        }
        if(!empty($data->group_id)){
            $end .= " and i.group_id = '$data->group_id'";
        }
        if(!empty($data->stock_status) && $data->stock_status != "All" && $data->stock_status == "current_stock"){
            $end .= " HAVING current_stock > 0";
        }
        if(!empty($data->stock_status) && $data->stock_status != "All" && $data->stock_status == 'stock_out'){
            $end .= " HAVING current_stock = 0";
        }
        $stock = $this->db->query("
                        select 
                         p.product_name,
                         p.product_code,
                         i.sale_rate,
                         i.purchase_rate,
                         i.sale_quantity,
                         i.sale_return_quantity,
                         g.group_name,
                         ((i.purchase_quantity+i.transfer_to_quantity) - (i.sale_quantity+i.sale_return_quantity+i.transfer_from_quantity+i.purchase_return_quantity)) as current_stock

                        from tbl_current_inventory as i 
                        left join tbl_products as p on p.product_id = i.product_id
                        left join tbl_groups as g on g.id = i.group_id 
                        where i.branch = '$this->branch' $end")->result();
                        // echo  $this->db->last_query();exit;
        echo json_encode($stock);
    }

}
