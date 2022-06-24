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

    // fungsi untuk hapus data 
    function delete($table,$where){
        $this->db->where($where);
        return $this->db->delete($table);
    }
    
    function updateData($table,$data,$where){
        $this->db->where($where);
		return $this->db->update($table,$data);
    }
    
    // Fungsi untuk ambil data dari database
    function getLog($table){
        $this->db->select('*');
		$this->db->from($table);
        $this->db->order_by($table.'.date', 'DESC');
        return $this->db->get();
    }

    // Fungsi untuk ambil data ranking dari database
    function getRanking($table){
        $this->db->select('*');
		$this->db->from($table);
        $this->db->order_by($table.'.periode_ranking', 'DESC');
        $this->db->order_by($table.'.row_number', 'ASC');
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
        $this->db->order_by($table.'.id_user', 'DESC');
		return $this->db->get();
	}

    // Fungsi untuk mengambil data users
    function getKoor($table,$table2,$where) {
		$this->db->select('*');
		$this->db->from($table);
		$this->db->join($table2, $table.'.kd_dept='.$table2.'.id_dept');
        $this->db->where($where);
		return $this->db->get();
	}

    // Fungsi untuk mengambil data map auditor
    function getMapAuditors($table,$table2,$table3) {
		$this->db->select('*');
		$this->db->from($table);
		$this->db->join($table2, $table.'.id_auditor='.$table2.'.id_auditor');
		$this->db->join($table3, $table.'.id_koor='.$table3.'.id_user');
		return $this->db->get();
	}

    // Fungsi untuk mengambil data jadwal auditor
    function getJadwal($table,$table2,$table3) {
		$this->db->select('*');
		$this->db->from($table);
		$this->db->join($table2, $table.'.auditor='.$table2.'.id_user');
		$this->db->join($table3, $table.'.auditee='.$table3.'.section');
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

    // insert data ke database
    function insertData($table, $data){
        return $this->db->insert($table,$data);
    }

    // fungsi untuk generate ranking dari tb tmp ke tbl mst
    function generateRanking(){
        $sql = "INSERT INTO s_mst.tb_ranking SELECT id_ranking, area_ranking, dept_ranking, periode_ranking, total_ranking, updated_ranking, nama_dep, 
        row_number() OVER (ORDER BY total_ranking DESC, updated_ranking ASC) FROM s_tmp.tb_ranking";
        return $this->db->query($sql);
    }

    // ambil data date close terlama
    function getDateClose($table,$where){
        $this->db->select('MAX(date_close)');
		$this->db->from($table);
        $this->db->where($where);
        $this->db->group_by('date_close');
        $this->db->limit('1');
		return $this->db->get();
    }

    // ambil data jumlah temuan yg open per auditee
    function getSumTemAuditee($auditee){
        $sql = "select sum(jlh_tem_audit) from s_mst.tb_audit where kd_dept_audit='$auditee' and status='false'";
        return $this->db->query($sql);
    }


    // ambil data jumlah temuan yg open per auditee
    function getPareto($table, $kd_temuan, $periode){
        $sql = "select sum(jlh_tem_audit) as total from $table a where a.kd_tem_audit='$kd_temuan' and a.periode='$periode' ";
        return $this->db->query($sql);
    }

    // fungsi untuk ambil data pareto
    function getDataPareto($table,$table2,$where){
        $this->db->select('*');
		$this->db->from($table);
		$this->db->join($table2, $table.'.aspek='.$table2.'.id_aspek');
        $this->db->where($where);
        $this->db->order_by($table.'.kat_5r', 'ASC');
        $this->db->order_by($table.'.jumlah', 'DESC');
		return $this->db->get();
    }

    // ambil data jumlah paretor terbaik
    function getJlhPareto($aspek,$kat5r,$periode){
        $sql = "select * from s_mst.tb_pareto a join s_mst.tb_aspek b on a.aspek=b.id_aspek where kode_aspek='$aspek' and a.kat_5r='$kat5r' and a.periode='$periode' order by jumlah desc limit(3)";
        return $this->db->query($sql);
    }
}
