<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class CodeModel extends CI_Model {
    public function genCode($code,$col,$table){
        $Id = $code.'00001';
        $lastCode = $this->db->query("select $col from $table order by $col desc limit 1");
        if($lastCode->num_rows() == 0){ return $Id;}

        $lastCode = $lastCode->row()->$col + 1;
        $zeros = array('0', '00', '000', '0000');
        $Id = "$code" . (strlen($lastCode) > count($zeros) ? $lastCode : $zeros[count($zeros) - strlen($lastCode)] . $lastCode);
        return $Id;
    }
    public function genInvoice($col,$table){
        $Id = date("Y").date("m").'0001';
        $lastCode = $this->db->query("select $col from $table order by $col desc limit 1");
        if($lastCode->num_rows() == 0){ return $Id;}

        $lastCode = $lastCode->row()->$col + 1;
        $zeros = array('0', '00', '000');
        $Id = date('Y').date('m') . (strlen($lastCode) > count($zeros) ? $lastCode : $zeros[count($zeros) - strlen($lastCode)] . $lastCode);
        return $Id;
    }

    
}