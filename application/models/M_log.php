<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_log extends CI_Model {
    public function __construct()
    {
        parent::__construct();
    }

    // Fungsi untuk insert data log
    function insertLog($table,$data){
        return $this->db->insert($table,$data);
    }
}