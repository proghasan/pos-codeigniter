<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ProductController extends CI_Controller
{
    public $branch;
    public $user_id;
    public function __construct()
    {
        parent::__construct();
        $this->branch = $this->session->userdata('branch');
        $this->user_id = $this->session->userdata('user_id');
        $this->load->model('CodeModel', 'codeRat');
        $this->load->model('CrudModel', 'crudRat');
        if ($this->session->userdata('status') == false) {
            redirect('/path', 'location');
        }
    }
    public function index()
    {
        $data['title'] = 'Product';
        $data['bread'] = 'Product';
        $data['content'] = $this->load->view('admin/product/product', $data, TRUE);
        $this->load->view('admin/layouts/master', $data);
    }
    public function productCode()
    {
        $getCode = $this->codeRat->genCode('P', 'product_id', 'tbl_products');
        echo json_encode($getCode);
    }

    public function addProduct()
    {
        $data = json_decode($this->input->raw_input_stream);
        $getCode = $this->codeRat->genCode('P', 'product_id', 'tbl_products');
        $res = ['success' => false, 'message' => ''];
        $productData = array(
            'product_code' => $getCode,
            'product_name' => $data->product->product_name,
            'unit_id' => $data->product->unit,
            'color_id' => $data->product->color,
            'branch' => $this->branch,
            'added_by' => $this->user_id,
            'added_time' => date("Y-m-d H:i:s")
        );
        $insert = $this->db->insert('tbl_products',$productData);
        // echo $this->db->last_query();exit;
        if($insert):
            $res = ['success' => true, 'message' => 'Product Added Successfully'];
        else:
            $res = ['success' => false, 'message' => 'Product Added Faield'];
        endif;
        echo json_encode($res);
    }

    public function getProducts(){
        $products = $this->db->query("
                                SELECT
                                 p.product_id,
                                 p.color_id as color,
                                 p.unit_id as unit,
                                 p.product_code as code,
                                 p.product_name,
                                 c.color_name,
                                 u.unit_name,
                                 CONCAT(product_name,'-', product_code) as display_name

                                FROM tbl_products as p
                                LEFT JOIN tbl_units as u on u.id = p.unit_id
                                LEFT JOIN tbl_colors as c on c.id = p.color_id
                                WHERE p.is_deleted = 0 
                                AND p.branch = ? ",$this->branch)->result();
        echo json_encode($products);
    }
    public function updateProduct()
    {
        $data = json_decode($this->input->raw_input_stream);
        $getCode = $this->codeRat->genCode('P', 'product_id', 'tbl_products');
        $res = ['success' => false, 'message' => ''];
        $productData = array(
            'product_name' => $data->product->product_name,
            'unit_id' => $data->product->unit,
            'color_id' => $data->product->color,
            'update_by' => $this->user_id,
            'update_time' => date("Y-m-d H:i:s")
        );
        $update = $this->db->where('product_id', $data->product->product_id)->update('tbl_products',$productData);
        // echo $this->db->last_query();exit;
        if($update):
            $res = ['success' => true, 'message' => 'Product Updated Successfully'];
        else:
            $res = ['success' => false, 'message' => 'Product Updated Faield'];
        endif;
        echo json_encode($res);
    }

    public function getSelectedProducts(){
        $selectProduct = $this->db->query("
                                SELECT
                                  p.product_id,
                                  p.product_name,
                                  p.product_code,
                                  CONCAT(p.product_name,'-',p.product_code) as display_name

                                FROM tbl_products as p
                                LEFT JOIN tbl_units as u on u.id = p.unit_id
                                LEFT JOIN tbl_colors as c on c.id = p.color_id
                                WHERE p.is_deleted = 0 
                                AND p.branch = ? ",$this->branch)->result();
        echo json_encode($selectProduct);
    }

    public function getSaleProducts(){
        $selectProduct = $this->db->query("
                                SELECT
                                 p.product_id,
                                 p.product_name,
                                 p.product_code,
                                 CONCAT(p.product_name,'-',p.product_code) as display_name

                                FROM tbl_products as p
                                LEFT JOIN tbl_units as u on u.id = p.unit_id
                                LEFT JOIN tbl_colors as c on c.id = p.color_id
                                WHERE p.is_deleted = 0 
                                AND p.branch = ? ",$this->branch)->result();
        echo json_encode($selectProduct);  
    }
}
