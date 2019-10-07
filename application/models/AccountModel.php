<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class AccountModel extends CI_Model {
  
    // supplier current due
    public function supplierCurrentDue($id){
       return $this->db->select("due_amount")->where("supplier_id",$id)->get("tbl_suppliers")->row()->due_amount;
    }

    
}