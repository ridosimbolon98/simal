<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_auditor extends CI_Model {
    public function __construct()
    {
        parent::__construct();
    }

    // Fungsi untuk mengambil data audit 
    function getAuditByAuditor($table,$table2,$table3,$table4,$where) {
		$this->db->select('*');
		$this->db->from($table);
		$this->db->join($table2, $table.'.kd_dept_audit='.$table2.'.id_dept');
		$this->db->join($table3, $table.'.kd_atem_audit='.$table3.'.id_aspek');
		$this->db->join($table4, $table.'.kd_tem_audit='.$table4.'.id_pt');
        $this->db->where($where);
		return $this->db->get();
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

    // Fungsi untuk mengambil data auditor
    function getAuditor($table,$table2,$where) {
		$this->db->select('*');
		$this->db->from($table);
		$this->db->join($table2, $table.'.id_auditor='.$table2.'.id_auditor');
        $this->db->where($where);
		return $this->db->get();
	}

    // Fungsi untuk mengambil data map auditor
    function getMapAuditors($table,$table2,$table3, $where) {
		$this->db->select('*');
		$this->db->from($table);
		$this->db->join($table2, $table.'.id_auditor='.$table2.'.id_auditor');
		$this->db->join($table3, $table.'.id_koor='.$table3.'.id_user');
        $this->db->where($where);
		return $this->db->get();
	}

    // Fungsi untuk mengambil data jadwal auditor
    function getJadwal($table,$table2,$table3, $where) {
		$this->db->select('*');
		$this->db->from($table);
		$this->db->join($table2, $table.'.auditor='.$table2.'.id_user');
		$this->db->join($table3, $table.'.auditee='.$table3.'.section');
        $this->db->where($where);
		return $this->db->get();
	}


}