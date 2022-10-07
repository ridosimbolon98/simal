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
    function getRanking($table,$table2){
        $this->db->select('area_ranking, periode_ranking, total_ranking, area_dept, row_number');
		$this->db->from($table);
        $this->db->join($table2, $table.'.dept_ranking='.$table2.'.id_dept');
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
        $this->db->order_by($table.'.nama', 'ASC');
		return $this->db->get();
	}

    // Fungsi untuk mengambil data users koordinator
    function getUserKoorAud($table,$table2,$where) {
		$this->db->select('*');
		$this->db->from($table);
		$this->db->join($table2, $table.'.username='.$table2.'.nama_auditor');
		$this->db->where($where);
        $this->db->order_by($table.'.nama', 'ASC');
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
		$this->db->join($table3, $table.'.auditee='.$table3.'.area_dept');
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
        $sql = "select sum(jlh_tem_audit) from s_mst.tb_audit where kd_dept_audit = ? and status = ? ";
        return $this->db->query($sql, array($auditee, 'false'));
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

    // ambil data auditie by section
    function getDataAuditie($table,$section){
        $sql ="select area_dept from $table where section='$section'";
        return $this->db->query($sql);
    }

    // ambil data auditie by section
    function getDataAuditorByKoor($table, $table2, $id_koor){
        $sql ="select * from $table a left join $table2 b on a.id_auditor=b.id_auditor where id_koor=$id_koor";
        return $this->db->query($sql);
    }

    // ambil data jumlah jadwal based realisasi dan periode
    function getJadwalByRealisasi($area, $realisasi, $periode){
        $sql ="select count(distinct(id_dept)) as total from s_tmp.tb_jadwal where area='$area' and realisasi='$realisasi' and periode='$periode'";
        return $this->db->query($sql);
    }

    // insert dan update jadwal audit ke tmp
    function replikasiDataJadwalBaru($kd_jadwal){
        $sql ="insert into s_tmp.tb_jadwal (select id_dept,kat_dept as area,area_dept,section,kd_jadwal,auditor,anggota_auditor,realisasi,periode,
        tgl_waktu as tgl_audit from s_mst.tb_dept a join s_mst.tb_jadwal b
         on b.auditee=a.section  where b.kd_jadwal='$kd_jadwal' order by a.section);";
        return $this->db->query($sql);
    }

    // fungsi untuk ambil data jadwal auditor
    function getJadwalAuditor($table,$table2,$where){
        $this->db->select('*');
		$this->db->from($table);
		$this->db->join($table2, $table.'.koor='.$table2.'.id_user');
        $this->db->where($where);
		return $this->db->get();
    }

    // fungsi untuk jlh data temuan baru
    function getJlhTB($periode){
        $sql ="select count(*) from s_mst.tb_audit where status='false' and periode = '$periode'";
        return $this->db->query($sql);
    }

    // fungsi untuk jlh data temuan open sebelumnya
    function getJlhOS($periode){
        $sql ="select count(*) from s_mst.tb_audit where status='false' and periode <> '$periode'";
        return $this->db->query($sql);
    }

    // fungsi untuk jlh data temuan belum tindak lanjut
    function getJlhBTL($periode){
        $sql ="select count(*) from s_mst.tb_audit where status='false' and otorisasi='SUDAH' and periode = '$periode' and gambar_sesudah = '0'";
        return $this->db->query($sql);
    }

    // fungsi untuk jlh data temuan sudah tindak lanjut
    function getJlhSTL($periode){
        $sql ="select count(*) from s_mst.tb_audit where status='false' and otorisasi='SUDAH' and periode = '$periode' and gambar_sesudah <> '0'";
        return $this->db->query($sql);
    }

    // fungsi untuk jlh data temuan sudah tindak lanjut per area
    function getJlhTSTL($area,$periode){
        $sql ="select count(*) from s_mst.tb_audit where kd_lok_audit='$area' and otorisasi='SUDAH' and gambar_sesudah<>'0' and periode='$periode'";
        return $this->db->query($sql);
    }

    // fungsi untuk jlh data temuan belum tindak lanjut per area
    function getJlhTBTL($area,$periode){
        $sql ="select count(*) from s_mst.tb_audit where kd_lok_audit='$area' and otorisasi='SUDAH' and gambar_sesudah='0' and periode='$periode'";
        return $this->db->query($sql);
    }

    // fungsi untuk data temuan  tindak lanjut per area
    function getDataTL($area,$periode){
        $sql ="select id_audit,kd_lok_audit,b.area_dept,gambar_sesudah as tl,status from s_mst.tb_audit a left join s_mst.tb_dept b on a.kd_dept_audit=b.id_dept where kd_lok_audit='$area' and periode='$periode'";
        return $this->db->query($sql);
    }

    // fungsi untuk reschedule jadwal audit
    function rescheduleJadwalAudit($kode_jadwal, $tgl_audit){
        $sql ="UPDATE s_mst.tb_jadwal SET tgl_waktu='$tgl_audit' WHERE kd_jadwal='$kode_jadwal';
        UPDATE s_tmp.tb_jadwal SET tgl_audit='$tgl_audit' WHERE kd_jadwal='$kode_jadwal';";
        return $this->db->query($sql);
    }
    
    // fungsi untuk reschedule jadwal audit
    function getJadwalBelumAudit($periode){
        $sql ="select a.area_dept, a.koor, b.nama, a.auditor, b.no_wa, a.periode, a.tgl_audit from s_tmp.tb_jadwal a left outer join s_mst.tb_wa b on a.koor=b.id_auditor where realisasi='false' and a.periode='$periode' order by a.tgl_audit asc";
        return $this->db->query($sql);
    }

    // fungsi untuk ambild ata wa audit
    function getDataWa(){
        $sql ="select distinct(nama) as nama, no_wa, tipe from s_mst.tb_wa order by nama asc";
        return $this->db->query($sql);
    }
}
