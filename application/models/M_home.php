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

    // Fungsi untuk mengambil data auditor
    function getAuditor($table,$table2,$where) {
		$this->db->select('*');
		$this->db->from($table);
		$this->db->join($table2, $table.'.id_auditor='.$table2.'.id_auditor');
        $this->db->where($where);
		return $this->db->get();
	}

    // fungsi untuk jlh data temuan baru
    function getJlhTB($tahun){
        $sql ="select count(*) from s_mst.tb_audit where date_part('year', tgl_audit)='$tahun'";
        return $this->db->query($sql);
    }

    // fungsi untuk jlh data temuan open sebelumnya
    function getJlhOP($tahun){
        $sql ="select count(*) from s_mst.tb_audit where status='false' and date_part('year', tgl_audit)='$tahun'";
        return $this->db->query($sql);
    }
    
    // fungsi untuk jlh data temuan open sebelumnya
    function getJlhOS($periode,$tahun){
        $sql ="select count(*) from s_mst.tb_audit where status='false' and periode <> '$periode' and date_part('year', tgl_audit)='$tahun'";
        return $this->db->query($sql);
    }

    // fungsi untuk jlh data temuan belum tindak lanjut
    function getJlhBTL($tahun){
        $sql ="select count(*) from s_mst.tb_audit where status='false' and otorisasi='SUDAH' and gambar_sesudah = '0' and date_part('year', tgl_audit)='$tahun'";
        return $this->db->query($sql);
    }

    // fungsi untuk jlh data temuan sudah tindak lanjut
    function getJlhSTL($tahun){
        $sql ="select count(*) from s_mst.tb_audit where status='false' and otorisasi='SUDAH' and gambar_sesudah <> '0' and date_part('year', tgl_audit)='$tahun'";
        return $this->db->query($sql);
    }

    // fungsi untuk jlh data temuan sudah tindak lanjut per area
    function getJlhTSOT($tahun){
        $sql ="select count(*) from s_mst.tb_audit where otorisasi='SUDAH' and gambar_sesudah<>'0' and date_part('year', tgl_audit)='$tahun'";
        return $this->db->query($sql);
    }

    // fungsi untuk jlh data temuan per periode
    function getJlhTemuanPeriode($periode){
        $sql ="select count(*) from s_mst.tb_audit where periode='$periode'";
        return $this->db->query($sql);
    }



    // fungsi untuk jlh data temuan closed all
    function getJlhTemuanClosedAll(){
        $sql ="select count(*) from s_mst.tb_audit where status='true'";
        return $this->db->query($sql);
    }

    // fungsi untuk jlh data temuan open all
    function getJlhTemuanOpenAll(){
        $sql ="select count(*) from s_mst.tb_audit where status='false'";
        return $this->db->query($sql);
    }
	
	// fungsi untuk jlh data temuan open all
    function getTemuanClosedAll($tahun){
        $sql ="select count(*) from s_mst.tb_audit where status='true' and date_part('year', tgl_audit)='$tahun'";
        return $this->db->query($sql);
    }

    // fungsi untuk jlh data temuan Sudah Tindak Lanjut all
    function getJlhTemuanSTLAll(){
        $sql ="select count(*) from s_mst.tb_audit where otorisasi='SUDAH' and gambar_sesudah<>'0' and status='false'";
        return $this->db->query($sql);
    }
    
    // fungsi untuk jlh data temuan belum otorisasi all
    function getJlhTemuanBOTAll(){
        $sql ="select count(*) from s_mst.tb_audit where otorisasi='BELUM' and status='false'";
        return $this->db->query($sql);
    }
    
    // fungsi untuk jlh data temuan sudah otorisasi dan belum tindak lanjut all
    function getJlhTemuanSOTAll(){
        $sql ="select count(*) from s_mst.tb_audit where otorisasi='SUDAH' and gambar_sesudah='0' and status='false'";
        return $this->db->query($sql);
    }
    
    // fungsi untuk jlh data temuan all
    function getJlhTemuanAll(){
        $sql ="select count(*) from s_mst.tb_audit";
        return $this->db->query($sql);
    }

    // ambil data jumlah jadwal based realisasi 
    function getJadwalByRealisasi($area, $realisasi){
        $sql ="select count(*) from s_tmp.tb_jadwal where area='$area' and realisasi='$realisasi'";
        return $this->db->query($sql);
    }
	
	// ambil data jumlah temuan based area 
    function getJlhTemuanByArea($area,$tahun){
        $sql ="select count(jlh_tem_audit),area_dept from s_mst.tb_audit a left join
        s_mst.tb_dept b on a.kd_dept_audit=b.id_dept
        where kd_lok_audit='$area' and date_part('year', tgl_audit)='$tahun'
        group by area_dept order by area_dept asc";
        return $this->db->query($sql);
    }

	// ambil data PARETO
    function getDataPareto($tahun, $r){
        $sql ="select datas.* from(
            select rr.kd_5r_audit, rr.desk_aspek, rr.desk_pt, rr.area_dept, rr.total,
                rank() over (partition by desk_aspek order by total desc)
                from
                (select result_rank.* from
                    (select ranked.*,
                        rank() over (partition by desk_pt order by total desc)
                        from 
                            (select sum(a.jlh_tem_audit) as total, a.kd_5r_audit, c.desk_aspek, d.desk_pt, b.area_dept from s_mst.tb_audit a 
                            left join s_mst.tb_dept b on a.kd_dept_audit=b.id_dept
                            left join s_mst.tb_aspek c on a.kd_atem_audit=c.id_aspek
                            left join s_mst.tb_par_temuan d on a.kd_tem_audit=d.id_pt
                            where date_part('year', tgl_audit)='$tahun' and kd_5r_audit='$r'
                            group by (a.kd_5r_audit, c.desk_aspek, d.desk_pt, b.area_dept)
                            ) as ranked
                    ) result_rank
                where result_rank.rank <=1
                order by desk_aspek asc,  total desc, desk_pt asc) rr
            where rr.rank <= 3
            order by rank limit(9)) datas
        order by desk_aspek, rank";
        return $this->db->query($sql);
    }
}