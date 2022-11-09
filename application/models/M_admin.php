<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_admin extends CI_Model {
    public function __construct()
    {
        parent::__construct();
    }


    // Fungsi untuk insert data ke database
    function insertData($table,$data) {
		return $this->db->insert($table,$data);
	}

    // Fungsi untuk ambil data dari database
    function getAll($table){
        return $this->db->get($table);
    }

    // fungsi untuk hapus data 
    function delete($table,$where){
        $this->db->where($where);
        return $this->db->delete($table);
    }
    
    // fungsi untuk update data ke tabel
    function updateData($table,$data,$where){
        $this->db->where($where);
		return $this->db->update($table,$data);
    }

    // Fungsi untuk ambil data berdasarkan ketentuan tertentu dari database
    function getWhere($table,$where){
        return $this->db->get_where($table, $where);
    }

    // fungsi untuk ambil data kartu meter pelanggan per cust_id dan tahun
    function getKartuMeterPelanggan($table,$table2,$table3,$where) {
        $this->db->select("
            $table.bulan,
            $table.periode,
            $table.aka_lalu,
            $table.aka_akhir,
            $table.jlh_pakai,
            $table.jlh_biaya,
            $table.id,
            $table2.nama as nama_cust,
            $table3.nama as nama_griya
        ");
		$this->db->from($table);
		$this->db->join($table2, $table.'.cid='.$table2.'.cid');
		$this->db->join($table3, $table2.'.griya_id='.$table3.'.id');
        $this->db->where($where);
		$this->db->order_by("$table.bulan", 'ASC');
        return $this->db->get();
    }

    // fungsi untuk ambil data kartu meter pelanggan per periode by id
    function getTagihanPeriodeById($table,$table2,$table3,$where) {
        $this->db->select("
            $table2.nama as nama_cust,
            $table3.biaya_mtc,
            $table2.alamat as alamat_cust,
            $table3.alamat as alamat_griya,
            $table.bulan,
            $table.periode,
            $table2.stand_meter,
            $table.jlh_pakai,
            $table.jlh_biaya
        ");
		$this->db->from($table);
		$this->db->join($table2, $table.'.cid='.$table2.'.cid');
		$this->db->join($table3, $table2.'.griya_id='.$table3.'.id');
        $this->db->where($where);
        return $this->db->get();
    }
    
    // fungsi untuk ambil data customer join griya
    function getAllCustomer($table,$table2) {
        $this->db->select("
            $table.cid,
            $table.nama,
            $table.alamat,
            $table.golongan,
            $table.stand_meter,
            $table.inserted_at,
            $table2.id,
            $table2.nama as nama_griya
        ");
		$this->db->from($table);
		$this->db->join($table2, $table.'.griya_id='.$table2.'.id');
		$this->db->order_by("$table.nama", 'ASC');
        return $this->db->get();
    }

    // ambil data customer by id join griya
    function getGriyaByCID($table,$table2,$where_cid){
        $this->db->select("
            $table.cid,
            $table.nama,
            $table.alamat,
            $table.golongan,
            $table.stand_meter,
            $table.inserted_at,
            $table2.id,
            $table2.nama as nama_griya,
            $table2.biaya_mtc
        ");
		$this->db->from($table);
		$this->db->join($table2, $table.'.griya_id='.$table2.'.id');
		$this->db->order_by("$table.nama", 'ASC');
        $this->db->where($where_cid);
        return $this->db->get();
    }

    // fungsi untuk ambil data kartu meter pelanggan by periode
    function getBulanKMP($table,$where) {
        $this->db->select("bulan");
		$this->db->from($table);
		$this->db->order_by("$table.bulan", 'ASC');
        return $this->db->get();
    }
    
    // fungsi untuk ambil data bulan terakhir kartu meter pelanggan by periode dan customer
    function getLastMonthAKA($table,$where) {
        $this->db->select("*");
		$this->db->from($table);
		$this->db->order_by("$table.bulan", 'DESC');
        return $this->db->get();
    }

    // fungsi untuk mengambil jumlah kartu yg belum di cetak
    function getKartuTotal($table,$table2,$bulan,$tahun) {
        $sql = "SELECT DISTINCT($table.cid) FROM $table RIGHT JOIN $table2 ON $table.cid=$table2.cid";
        return $this->db->query($sql);
    }
    
    // fungsi untuk mengambil jumlah kartu yg belum di cetak
    function getKartuSudahCetak($table,$table2,$bulan,$tahun) {
        $sql = "SELECT DISTINCT($table.cid) FROM $table RIGHT JOIN $table2 ON $table.cid=$table2.cid WHERE $table.bulan='$bulan' AND $table.periode='$tahun'";
        return $this->db->query($sql);
    }

}
