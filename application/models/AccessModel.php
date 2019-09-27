<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class AccessModel extends CI_Model {
	//========= Login check  start ====================//
    public function can_login($username, $password){
       return $this->db->select("*")
                       ->where('user_name',$username)
                       ->where('password',$password)
                       ->where('is_active',1)
                       ->where('is_deleted',0)
                       ->get("tbl_admin")->row();
    }
    
}