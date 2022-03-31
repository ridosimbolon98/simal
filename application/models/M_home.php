<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_home extends CI_Model {
    public function __construct()
    {
        parent::__construct();
    }

    public function getFormSelect($table,$where){
        return $this->db->get_where($table,$where);
    }

	public function getTASelect($table,$table2,$where){
		$sql = "select * from $table join $table2
        on $table.bagian_auditor=$table2.id_dept and $table.area_auditor='$where'";
		return $this->db->query($sql);
	}

    // Fungsi untuk insert data ke database
    function insert($table,$data) {
		return $this->db->insert($table,$data);
	}

    // Fungsi untuk ambil data dari database
    function get($table){
        return $this->db->get($table);
    }

    // Fungsi untuk ambil data dari database
    function getWhere($table,$where){
        return $this->db->get_where($table,$where);
    }

    function updateData($table,$data,$where){
        $this->db->where($where);
		return $this->db->update($table,$data);
    }
}