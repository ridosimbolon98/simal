<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_monitoring extends CI_Model {
    public function __construct()
    {
        parent::__construct();
    }


    /* Fungsi untuk mengambil data jumlah temuan audit 
    ========================================================*/
    function getJlhTemuan1A($table,$table2,$table3,$table4,$kd_lok_audit,$kd_dept_audit,$tgl_audit) {
        $where = array(
            'kd_lok_audit'  => $kd_lok_audit,
            'kd_dept_audit' => $kd_dept_audit,
            'periode'       => $tgl_audit,
            'kd_5r_audit'   => 'RINGKAS',
            'kode_aspek'    => 'A'
        );

		$this->db->select_sum('jlh_tem_audit');
		$this->db->from($table);
		$this->db->join($table2, $table.'.kd_dept_audit='.$table2.'.id_dept');
		$this->db->join($table3, $table.'.kd_atem_audit='.$table3.'.id_aspek');
		$this->db->join($table4, $table.'.kd_tem_audit='.$table4.'.id_pt');
        $this->db->where($where);
		return $this->db->get();
	}

    function getJlhTemuan1B($table,$table2,$table3,$table4,$kd_lok_audit,$kd_dept_audit,$tgl_audit) {
        $where = array(
            'kd_lok_audit'  => $kd_lok_audit,
            'kd_dept_audit' => $kd_dept_audit,
            'periode'       => $tgl_audit,
            'kd_5r_audit'   => 'RINGKAS',
            'kode_aspek'    => 'B'
        );

		$this->db->select_sum('jlh_tem_audit');
		$this->db->from($table);
		$this->db->join($table2, $table.'.kd_dept_audit='.$table2.'.id_dept');
		$this->db->join($table3, $table.'.kd_atem_audit='.$table3.'.id_aspek');
		$this->db->join($table4, $table.'.kd_tem_audit='.$table4.'.id_pt');
        $this->db->where($where);
		return $this->db->get();
	}

    function getJlhTemuan1C($table,$table2,$table3,$table4,$kd_lok_audit,$kd_dept_audit,$tgl_audit) {
        $where = array(
            'kd_lok_audit'  => $kd_lok_audit,
            'kd_dept_audit' => $kd_dept_audit,
            'periode'       => $tgl_audit,
            'kd_5r_audit'   => 'RINGKAS',
            'kode_aspek'    => 'C'
        );

		$this->db->select_sum('jlh_tem_audit');
		$this->db->from($table);
		$this->db->join($table2, $table.'.kd_dept_audit='.$table2.'.id_dept');
		$this->db->join($table3, $table.'.kd_atem_audit='.$table3.'.id_aspek');
		$this->db->join($table4, $table.'.kd_tem_audit='.$table4.'.id_pt');
        $this->db->where($where);
		return $this->db->get();
	}

    function getJlhTemuan2A($table,$table2,$table3,$table4,$kd_lok_audit,$kd_dept_audit,$tgl_audit) {
        $where = array(
            'kd_lok_audit'  => $kd_lok_audit,
            'kd_dept_audit' => $kd_dept_audit,
            'periode'       => $tgl_audit,
            'kd_5r_audit'   => 'RAPI',
            'kode_aspek'    => 'A'
        );

		$this->db->select_sum('jlh_tem_audit');
		$this->db->from($table);
		$this->db->join($table2, $table.'.kd_dept_audit='.$table2.'.id_dept');
		$this->db->join($table3, $table.'.kd_atem_audit='.$table3.'.id_aspek');
		$this->db->join($table4, $table.'.kd_tem_audit='.$table4.'.id_pt');
        $this->db->where($where);
		return $this->db->get();
	}
    function getJlhTemuan2B($table,$table2,$table3,$table4,$kd_lok_audit,$kd_dept_audit,$tgl_audit) {
        $where = array(
            'kd_lok_audit'  => $kd_lok_audit,
            'kd_dept_audit' => $kd_dept_audit,
            'periode'       => $tgl_audit,
            'kd_5r_audit'   => 'RAPI',
            'kode_aspek'    => 'B'
        );

		$this->db->select_sum('jlh_tem_audit');
		$this->db->from($table);
		$this->db->join($table2, $table.'.kd_dept_audit='.$table2.'.id_dept');
		$this->db->join($table3, $table.'.kd_atem_audit='.$table3.'.id_aspek');
		$this->db->join($table4, $table.'.kd_tem_audit='.$table4.'.id_pt');
        $this->db->where($where);
		return $this->db->get();
	}
    function getJlhTemuan2C($table,$table2,$table3,$table4,$kd_lok_audit,$kd_dept_audit,$tgl_audit) {
        $where = array(
            'kd_lok_audit'  => $kd_lok_audit,
            'kd_dept_audit' => $kd_dept_audit,
            'periode'       => $tgl_audit,
            'kd_5r_audit'   => 'RAPI',
            'kode_aspek'    => 'C'
        );

		$this->db->select_sum('jlh_tem_audit');
		$this->db->from($table);
		$this->db->join($table2, $table.'.kd_dept_audit='.$table2.'.id_dept');
		$this->db->join($table3, $table.'.kd_atem_audit='.$table3.'.id_aspek');
		$this->db->join($table4, $table.'.kd_tem_audit='.$table4.'.id_pt');
        $this->db->where($where);
		return $this->db->get();
	}

    function getJlhTemuan3A($table,$table2,$table3,$table4,$kd_lok_audit,$kd_dept_audit,$tgl_audit) {
        $where = array(
            'kd_lok_audit'  => $kd_lok_audit,
            'kd_dept_audit' => $kd_dept_audit,
            'periode'       => $tgl_audit,
            'kd_5r_audit'   => 'RESIK',
            'kode_aspek'    => 'A'
        );

		$this->db->select_sum('jlh_tem_audit');
		$this->db->from($table);
		$this->db->join($table2, $table.'.kd_dept_audit='.$table2.'.id_dept');
		$this->db->join($table3, $table.'.kd_atem_audit='.$table3.'.id_aspek');
		$this->db->join($table4, $table.'.kd_tem_audit='.$table4.'.id_pt');
        $this->db->where($where);
		return $this->db->get();
	}
    function getJlhTemuan3B($table,$table2,$table3,$table4,$kd_lok_audit,$kd_dept_audit,$tgl_audit) {
        $where = array(
            'kd_lok_audit'  => $kd_lok_audit,
            'kd_dept_audit' => $kd_dept_audit,
            'periode'       => $tgl_audit,
            'kd_5r_audit'   => 'RESIK',
            'kode_aspek'    => 'B'
        );

		$this->db->select_sum('jlh_tem_audit');
		$this->db->from($table);
		$this->db->join($table2, $table.'.kd_dept_audit='.$table2.'.id_dept');
		$this->db->join($table3, $table.'.kd_atem_audit='.$table3.'.id_aspek');
		$this->db->join($table4, $table.'.kd_tem_audit='.$table4.'.id_pt');
        $this->db->where($where);
		return $this->db->get();
	}
    function getJlhTemuan3C($table,$table2,$table3,$table4,$kd_lok_audit,$kd_dept_audit,$tgl_audit) {
        $where = array(
            'kd_lok_audit'  => $kd_lok_audit,
            'kd_dept_audit' => $kd_dept_audit,
            'periode'       => $tgl_audit,
            'kd_5r_audit'   => 'RESIK',
            'kode_aspek'    => 'C'
        );

		$this->db->select_sum('jlh_tem_audit');
		$this->db->from($table);
		$this->db->join($table2, $table.'.kd_dept_audit='.$table2.'.id_dept');
		$this->db->join($table3, $table.'.kd_atem_audit='.$table3.'.id_aspek');
		$this->db->join($table4, $table.'.kd_tem_audit='.$table4.'.id_pt');
        $this->db->where($where);
		return $this->db->get();
	}

    function getJlhTemuan4A($table,$table2,$table3,$table4,$kd_lok_audit,$kd_dept_audit,$tgl_audit) {
        $where = array(
            'kd_lok_audit'  => $kd_lok_audit,
            'kd_dept_audit' => $kd_dept_audit,
            'periode'       => $tgl_audit,
            'kd_5r_audit'   => 'RAWAT',
            'kode_aspek'    => 'A'
        );

		$this->db->select_sum('jlh_tem_audit');
		$this->db->from($table);
		$this->db->join($table2, $table.'.kd_dept_audit='.$table2.'.id_dept');
		$this->db->join($table3, $table.'.kd_atem_audit='.$table3.'.id_aspek');
		$this->db->join($table4, $table.'.kd_tem_audit='.$table4.'.id_pt');
        $this->db->where($where);
		return $this->db->get();
	}
    /* End Fungsi untuk mengambil data jumlah temuan audit 
    ========================================================*/
}