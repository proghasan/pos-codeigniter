<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class CrudModel extends CI_Model {

    public function insertData($table,$data){
       $insert = $this->db->insert($table,$data);
       if($insert):
        return true;
       else:
        return false;
       endif;
    }
   

    
}