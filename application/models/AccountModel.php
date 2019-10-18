<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class AccountModel extends CI_Model {
  
    // supplier current due
    public function supplierCurrentDue($id){
        $branch = $this->session->userdata('branch');
        $currentDue = $this->db->query("
                                SELECT
                                 s.supplier_id,
                                 s.supplier_code,
                                 ifnull((SELECT SUM(pr.cash_back_amount) FROM tbl_purchase_return as pr WHERE pr.supplier_id = '$id' AND pr.is_deleted =0 AND pr.branch= '$branch'),0) as total_cash_back_amount,
                                 ifnull((SELECT SUM(pm.due) FROM tbl_purchase_master as pm WHERE pm.is_deleted = 0 AND pm.branch = '$branch' AND pm.supplier_id='$id'),0) as total_purchase_due,
                                 ifnull((SELECT SUM(sp.amount) FROM tbl_supplier_payment as sp WHERE sp.is_deleted =0 AND sp.branch='$branch' AND sp.supplier_id ='$id'),0) as total_payment,        
                                 (SELECT total_purchase_due - (total_payment+total_cash_back_amount)) as current_due

                                FROM tbl_suppliers as s
                                WHERE s.supplier_id = '$id'
                                AND s.branch = '$branch'")->row();
        return $currentDue->current_due;
    }

    
}