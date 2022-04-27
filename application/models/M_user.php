<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_user extends CI_Model {
    public function __construct()
    {
        parent::__construct();
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
    function getDept($table){
        $sql = "SELECT bagian_dept FROM $table GROUP BY bagian_dept";
		return $this->db->query($sql);
    }

    // Ambil data user by ID
    function getUserById($table,$table2,$where){
        $this->db->select('*');
		$this->db->from($table);
		$this->db->join($table2, $table.'.kd_dept='.$table2.'.id_dept');
        $this->db->where($where);
		return $this->db->get();
    }

    // Fungsi untuk ambil data dari database
    function getWhere($table,$where){
        return $this->db->get_where($table,$where);
    }

    function updateData($table,$data,$where){
        $this->db->where($where);
		return $this->db->update($table,$data);
    }

    // Ambil data Audit
    function getAllAudit($table,$table2,$table3,$table4,$where) {
		$this->db->select('*');
		$this->db->from($table);
		$this->db->join($table2, $table.'.kd_dept_audit='.$table2.'.id_dept');
		$this->db->join($table3, $table.'.kd_atem_audit='.$table3.'.id_aspek');
		$this->db->join($table4, $table.'.kd_tem_audit='.$table4.'.id_pt');
        $this->db->where($where);
		return $this->db->get();
	}

    // Ambil data Audit temuan referensi per bagian
    // 's_mst.tb_referensi', 's_mst.tb_audit', 's_mst.tb_dept', 's_mst.tb_aspek', 's_mst.tb_par_temuan'
    function getRefAudit($table,$table2,$table3,$table4,$table5,$where) {
		$this->db->select('*');
		$this->db->from($table);
		$this->db->join($table2, $table.'.id_audit='.$table2.'.id_audit');
		$this->db->join($table3, $table2.'.kd_dept_audit='.$table3.'.id_dept');
		$this->db->join($table4, $table2.'.kd_atem_audit='.$table4.'.id_aspek');
		$this->db->join($table5, $table2.'.kd_tem_audit='.$table5.'.id_pt');
        $this->db->where($where);
		return $this->db->get();
	}

    function getAuditPerID($table,$table2,$table3,$table4,$table5,$where) {
		$this->db->select('*');
		$this->db->from($table);
		$this->db->join($table2, $table.'.kd_dept_audit='.$table2.'.id_dept');
		$this->db->join($table3, $table.'.kd_atem_audit='.$table3.'.id_aspek');
		$this->db->join($table4, $table.'.kd_tem_audit='.$table4.'.id_pt');
        $this->db->where($where);
		return $this->db->get();
	}

    // AMBIL DATA JADWAL BERDASARKAN BAGIAN TERTENTU
    function getJA($table,$table2,$table3,$where) {
		$this->db->select('*');
		$this->db->from($table);
		$this->db->join($table2, $table.'.auditor='.$table2.'.id_user');
		$this->db->join($table3, $table.'.auditee='.$table3.'.id_dept');
        $this->db->where($where);
		return $this->db->get();
	}
}