<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class AccountModel extends CI_Model {
    public $branch;

    function __construct(){
      parent::__construct();
      // $this->load->database();
      $this->branch = $this->session->userdata('branch');
    }
    // supplier current due
    public function supplierCurrentDue($id){
        $currentDue = $this->db->query("
                                SELECT
                                 s.supplier_id,
                                 s.supplier_code,
                                 ifnull((SELECT SUM(pr.cash_back_amount) FROM tbl_purchase_return as pr WHERE pr.supplier_id = '$id' AND pr.is_deleted =0 AND pr.branch= '$this->branch'),0) as total_cash_back_amount,
                                 ifnull((SELECT SUM(pm.due) FROM tbl_purchase_master as pm WHERE pm.is_deleted = 0 AND pm.branch = '$this->branch' AND pm.supplier_id='$id'),0) as total_purchase_due,
                                 ifnull((SELECT SUM(sp.amount) FROM tbl_supplier_payment as sp WHERE sp.is_deleted =0 AND sp.branch='$this->branch' AND sp.supplier_id ='$id'),0) as total_payment,        
                                 (SELECT total_purchase_due - (total_payment+total_cash_back_amount)) as current_due

                                FROM tbl_suppliers as s
                                WHERE s.supplier_id = '$id'
                                AND s.branch = '$this->branch'")->row();
        return $currentDue->current_due;
    }

    public function getCustomerInfo($id){
        $currentDue = $this->db->query("
                    SELECT
                        c.customer_id,
                        c.customer_code,
                        c.customer_name,
                        IFNULL((SELECT SUM(sm.total) from tbl_sale_master as sm WHERE sm.customer_id = c.customer_id AND sm.is_deleted = 0 AND sm.branch = c.branch),0) as total_bill_amount,
                        IFNULL((SELECT SUM(cp.amount) FROM tbl_customer_payment as cp WHERE cp.is_received = 0  AND cp.customer_id = c.customer_id AND cp.is_deleted =0 AND cp.branch =c.branch),0) as total_cash_payment,
                        IFNULL((SELECT SUM(cp.amount) FROM tbl_customer_payment as cp WHERE cp.is_received = 1 AND cp.is_deleted =0 AND cp.branch =c.branch),0) as total_cash_receive,
                        IFNULL((SELECT SUM(sr.total) FROM tbl_sale_return as sr WHERE sr.customer_id = c.customer_id AND sr.is_deleted = 0 AND sr.branch = c.branch),0) as total_return_amount,

                        (SELECT (total_bill_amount + total_cash_payment) - (total_cash_receive+total_return_amount)) as current_due

                    FROM tbl_customers as c
                    WHERE c.customer_id = '$id'
                    AND c.branch = '$this->branch'")->row();
        return $currentDue->current_due;
    }

    public function getAllCustomers(){
        $customers = $this->db->query("
                               SELECT
                                c.customer_id,
                                c.customer_code,
                                c.customer_name,
                                c.customer_phone,
                                CONCAT(c.customer_name,'-',c.customer_code) as display_name,
                                IFNULL((SELECT SUM(sm.total) from tbl_sale_master as sm WHERE sm.customer_id = c.customer_id AND sm.is_deleted = 0 AND sm.branch = c.branch),0) as total_bill_amount,
                                IFNULL((SELECT SUM(cp.amount) FROM tbl_customer_payment as cp WHERE cp.is_received = 0  AND cp.customer_id = c.customer_id AND cp.is_deleted =0 AND cp.branch =c.branch),0) as total_cash_payment,
                                IFNULL((SELECT SUM(cp.amount) FROM tbl_customer_payment as cp WHERE cp.is_received = 1 AND cp.is_deleted =0 AND cp.branch =c.branch),0) as total_cash_receive,
                                IFNULL((SELECT SUM(sr.total) FROM tbl_sale_return as sr WHERE sr.customer_id = c.customer_id AND sr.is_deleted = 0 AND sr.branch = c.branch),0) as total_return_amount,

                                (SELECT (total_bill_amount + total_cash_payment) - (total_cash_receive+total_return_amount)) as current_due

                               FROM tbl_customers as c
                               WHERE c.is_deleted = 0
                               AND (c.branch =0 or c.branch = '$this->branch')");
        return $customers->result();
    }

    
}