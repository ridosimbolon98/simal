<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_admin extends CI_Model {
    public function __construct()
    {
        parent::__construct();
    }

    public function getFormSelect($table,$where){
        return $this->db->get_where($table,$where);
    }

    // Fungsi untuk insert data ke database
    function insert($table,$data) {
		return $this->db->insert($table,$data);
	}

    // Fungsi untuk ambil data dari database
    function get($table){
        return $this->db->get($table);
    }

    // Fungsi untuk ambil data ranking dari database
    function getRanking($table){
        $this->db->select('*');
		$this->db->from($table);
        $this->db->order_by($table.'.total_ranking', 'DESC');
        return $this->db->get();
    }

    // Fungsi untuk ambil data berdasarkan ketentuan tertentu dari database
    function getWhere($table,$where){
        return $this->db->get_where($table, $where);
    }

    // Fungsi untuk mengambil data users
    function getUsers($table,$table2) {
		$this->db->select('*');
		$this->db->from($table);
		$this->db->join($table2, $table.'.kd_dept='.$table2.'.id_dept');
		return $this->db->get();
	}
    
    // Fungsi untuk mengambil data audit
    function getAllAudit($table,$table2,$table3,$table4,$where) {
		$this->db->select('*');
		$this->db->from($table);
		$this->db->join($table2, $table.'.kd_dept_audit='.$table2.'.id_dept');
		$this->db->join($table3, $table.'.kd_atem_audit='.$table3.'.id_aspek');
		$this->db->join($table4, $table.'.kd_tem_audit='.$table4.'.id_pt');
        $this->db->where($where);
		return $this->db->get();
	}

    // Fungsi untuk mengambil data jumlah temuan audit
    function getJlhTemuan($table,$table2,$table3,$table4,$where) {
		$this->db->select_sum('jlh_tem_audit');
		$this->db->from($table);
		$this->db->join($table2, $table.'.kd_dept_audit='.$table2.'.id_dept');
		$this->db->join($table3, $table.'.kd_atem_audit='.$table3.'.id_aspek');
		$this->db->join($table4, $table.'.kd_tem_audit='.$table4.'.id_pt');
        $this->db->where($where);
		return $this->db->get();
	}

    // Update Rekomendasi
    function updateRekomendasi($table,$data,$where){
        $this->db->where($where);
        return $this->db->update($table,$data);
    }
    
    // Fungsi untuk hapus seluruh data di tabel ranking
    function truncateRanking($table){
        return $this->db->truncate($table);
    }
}
