<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @author Rido
 */

class Admin extends CI_Controller {
	function __construct(){
		parent::__construct();

		if ($this->session->userdata('level') != "admin") {
			echo "<script>alert('Anda dilarang akses halaman ini tanpa autentikasi');</script>";
			echo "<script>location='".base_url()."auth';</script>";
		} else {
			$this->load->helper('url');
			$this->load->model('m_auth');
			$this->load->model('m_admin');
			$this->load->model('m_monitoring');
			$this->load->model('m_log');
		}		
	}

	
	function index(){
		$data['title'] = "Audit 5R | Data Audit Page";
		$this->load->view('admin/v_db1', $data);
	}

	// Menampilkan Data Audit Pabrik
	function pabrik(){
		$data['title'] = "Audit 5R | Data Audit bbarik";
		$data['ap']    = "active";
		$data['anp']   = "";
		$where_dept    = array('kat_dept' => "PABRIK");
        $data['dept']  = $this->m_admin->getWhere('s_mst.tb_dept',$where_dept)->result();
		$this->load->view('admin/v_home', $data);
	}

	// Menampilkan Data Audit Non Pabrik
	function non_pabrik(){
		$data['title'] = "Audit 5R | Data Audit Non Pabrik";
		$data['ap']    = "";
		$data['anp']   = "active";
        $where_dept    = array('kat_dept' => "NON-PABRIK");
        $data['dept']  = $this->m_admin->getWhere('s_mst.tb_dept',$where_dept)->result();
		$this->load->view('admin/v_home', $data);
	}

	// Menampilkan Data Audit Pabrik By Dept
	function data_audit($id_dept){
		$data['title'] = "Audit 5R | Data Audit Page";
        $data['id_dep']= $id_dept;
        $where         = array('kd_dept_audit' => $id_dept);
        $where2        = array('id_dept' => $id_dept);
        $data['dept']  = $this->m_admin->getWhere('s_mst.tb_dept', $where2)->result();
		$data['area']  = $data['dept'][0]->kat_dept;
		if ($data['area'] == 'PABRIK') {
			$data['ap']    = "active";
			$data['anp']   = "";
		} else {
			$data['ap']    = "";
			$data['anp']   = "active";
		}
		
        $data['audit'] = $this->m_admin->getAllAudit('s_mst.tb_audit', 's_mst.tb_dept', 's_mst.tb_aspek', 's_mst.tb_par_temuan', $where)->result();
		$this->load->view('admin/v_audit', $data);
	}

	// fungsi untuk menampilkan halaman user
	function user(){
		$data['title'] = "Audit 5R | Data User Page";
		$level         = $this->session->userdata("level");
		$data['area']  = $this->m_admin->get('s_mst.tb_dept')->result();
		$data['users'] = $this->m_admin->getUsers('s_mst.tb_user','s_mst.tb_dept')->result();
		$this->load->view('admin/v_user', $data);
	}

	
	// Menmapilkan Data Laporan Ketidaksesuaian
	function lap(){
		$data['title'] = "Audit 5R | Lap Ketidaksesuaian Page";
		$data['dept']  = $this->m_admin->get('s_mst.tb_dept')->result();
        $this->load->view('admin/v_lap', $data);
	}

	// Fungsi untuk menampilkan Laporan Ketidaksesuaian
	function lk($id_dept){
		$data['title'] = "Audit 5R | Lap Ketidaksesuaian Page";
		$data['id_dep']= $id_dept;
        $where         = array('kd_dept_audit' => $id_dept);
        $where2        = array('id_dept' => $id_dept);
        $data['dept']  = $this->m_admin->getWhere('s_mst.tb_dept', $where2)->result();
		$data['area']  = $data['dept'][0]->kat_dept;
        $data['audit'] = $this->m_admin->getAllAudit('s_mst.tb_audit', 's_mst.tb_dept', 's_mst.tb_aspek', 's_mst.tb_par_temuan', $where)->result();
		$this->load->view('admin/v_lk', $data);
	}

	// Update data rekomendasi
	function update_rekom(){
		$data['title'] = "Audit 5R | Lap Ketidaksesuaian Page";
		$id_audit      = $this->input->post("id_audit");
		$id_dep        = $this->input->post("id_dep");
		$rekomendasi   = htmlspecialchars(trim($this->input->post("rekomendasi")));
		$due_date      = $this->input->post("due_date");
		$data_ur       = array('rekomendasi' => $rekomendasi, 'due_date' => $due_date);
		$where         = array('id_audit' => $id_audit);

		$update_rekom  = $this->m_admin->updateRekomendasi('s_mst.tb_audit', $data_ur,$where);
		if ($update_rekom){
			$log_type = 'update';
			$log_desc = 'Ubah Data Rekomendasi Temuan Audit';
			$ip       = $this->input->ip_address();
			$userLog  = $this->session->userdata("username");
			date_default_timezone_set("Asia/Jakarta");
			$data_log = array(
				'username'      => $userLog,
				'type_log'      => $log_type,
				'deskripsi_log' => $log_desc,
				'date'          => date("Y-m-d H:i:s"),
				'ip'            => $ip
			);
			$this->m_log->insertLog('s_log.tb_log', $data_log);
			echo "<script>location='".base_url()."admin/data_audit/$id_dep';</script>";
		} else{
			echo "<script>alert('Gagal update data rekomendasi audit');</script>";
			echo "<script>location='".base_url()."admin/data_audit/$id_dep';</script>";
			exit;
		}
		
	}

	// Fungsi untuk menampilkan halaman monitoring audit pabrik
	function mt_pabrik(){
		$data['title'] = "Audit 5R | Monitoring Audit Pabrik Page";
		$data['area']  = "PABRIK";
		if ($data['area'] == 'PABRIK') {
			$data['ap']    = "active";
			$data['anp']   = "";
		} else {
			$data['ap']    = "";
			$data['anp']   = "active";
		}
		$where_dept    = array('kat_dept' => $data['area']);
        $data['dept']  = $this->m_admin->getWhere('s_mst.tb_dept',$where_dept)->result();

		$this->load->view('admin/v_dept_mtpab', $data);
	}

	// Fungsi untuk menampilkan halaman monitoring audit non pabrik
	function mt_nonpabrik(){
		$data['title'] = "Audit 5R | Monitoring Audit Non-Pabrik Page";
		$data['area']  = "NON-PABRIK";
		if ($data['area'] == 'PABRIK') {
			$data['ap']    = "active";
			$data['anp']   = "";
		} else {
			$data['ap']    = "";
			$data['anp']   = "active";
		}
		$where_dept    = array('kat_dept' => $data['area']);
        $data['dept']  = $this->m_admin->getWhere('s_mst.tb_dept',$where_dept)->result();

		$this->load->view('admin/v_dept_mtpab', $data);
	}

	// Fungsi untuk menampilkan data monitoring per bagian dan area tertentu
	function monitoring(){
		$id_dept       = $this->input->post('id_dept');
		$data['title'] = "Audit 5R | Monitoring Audit Page";
		$data['id_dep']= $this->input->post('id_dept');
        $where2        = array('id_dept' => $id_dept);
        $data['dept']  = $this->m_admin->getWhere('s_mst.tb_dept', $where2)->result();
		$data['area']  = $data['dept'][0]->kat_dept;
		
		$kd_lok_audit  = $this->input->post('kd_lok_audit');
		$kd_dept_audit = $id_dept;
		$tgl_audit     = $this->input->post('tgl_audit');

		$periode       = date('Y-m', strtotime($tgl_audit));
		
        $where         = array('kd_dept_audit' => $id_dept, 'periode' => $periode, 'kd_lok_audit' => $kd_lok_audit);

		if ($data['area'] == 'PABRIK') {
			$data['ap']    = "active";
			$data['anp']   = "";
		} else {
			$data['ap']    = "";
			$data['anp']   = "active";
		}

		// =IF(SUM(N18:N29)=0;"4";

		$r1A        = $this->m_monitoring->getJlhTemuan1A('s_mst.tb_audit', 's_mst.tb_dept', 's_mst.tb_aspek', 's_mst.tb_par_temuan', $kd_lok_audit, $kd_dept_audit, $tgl_audit)->result();
		$r1B        = $this->m_monitoring->getJlhTemuan1B('s_mst.tb_audit', 's_mst.tb_dept', 's_mst.tb_aspek', 's_mst.tb_par_temuan', $kd_lok_audit, $kd_dept_audit, $tgl_audit)->result();
		$r1C        = $this->m_monitoring->getJlhTemuan1C('s_mst.tb_audit', 's_mst.tb_dept', 's_mst.tb_aspek', 's_mst.tb_par_temuan', $kd_lok_audit, $kd_dept_audit, $tgl_audit)->result();
		$r2A        = $this->m_monitoring->getJlhTemuan2A('s_mst.tb_audit', 's_mst.tb_dept', 's_mst.tb_aspek', 's_mst.tb_par_temuan', $kd_lok_audit, $kd_dept_audit, $tgl_audit)->result();
		$r2B        = $this->m_monitoring->getJlhTemuan2B('s_mst.tb_audit', 's_mst.tb_dept', 's_mst.tb_aspek', 's_mst.tb_par_temuan', $kd_lok_audit, $kd_dept_audit, $tgl_audit)->result();
		$r2C        = $this->m_monitoring->getJlhTemuan2C('s_mst.tb_audit', 's_mst.tb_dept', 's_mst.tb_aspek', 's_mst.tb_par_temuan', $kd_lok_audit, $kd_dept_audit, $tgl_audit)->result();
		$r3A        = $this->m_monitoring->getJlhTemuan3A('s_mst.tb_audit', 's_mst.tb_dept', 's_mst.tb_aspek', 's_mst.tb_par_temuan', $kd_lok_audit, $kd_dept_audit, $tgl_audit)->result();
		$r3B        = $this->m_monitoring->getJlhTemuan3B('s_mst.tb_audit', 's_mst.tb_dept', 's_mst.tb_aspek', 's_mst.tb_par_temuan', $kd_lok_audit, $kd_dept_audit, $tgl_audit)->result();
		$r3C        = $this->m_monitoring->getJlhTemuan3C('s_mst.tb_audit', 's_mst.tb_dept', 's_mst.tb_aspek', 's_mst.tb_par_temuan', $kd_lok_audit, $kd_dept_audit, $tgl_audit)->result();
		$r4A        = $this->m_monitoring->getJlhTemuan4A('s_mst.tb_audit', 's_mst.tb_dept', 's_mst.tb_aspek', 's_mst.tb_par_temuan', $kd_lok_audit, $kd_dept_audit, $tgl_audit)->result();

		if($r1A[0]->jlh_tem_audit == 0) {
			$r1AT = 4;
		} else if($r1A[0]->jlh_tem_audit > 0 && $r1A[0]->jlh_tem_audit < 4) {
			$r1AT = 3;
		} else if($r1A[0]->jlh_tem_audit > 3 && $r1A[0]->jlh_tem_audit < 8) {
			$r1AT = 2;
		} else if($r1A[0]->jlh_tem_audit > 7 && $r1A[0]->jlh_tem_audit <= 10) {
			$r1AT = 1;
		} else {
			$r1AT = 0;
		}

		if($r1B[0]->jlh_tem_audit == 0) {
			$r1BT = 4;
		} else if($r1B[0]->jlh_tem_audit > 0 && $r1B[0]->jlh_tem_audit < 4) {
			$r1BT = 3;
		} else if($r1B[0]->jlh_tem_audit > 3 && $r1B[0]->jlh_tem_audit < 8) {
			$r1BT = 2;
		} else if($r1B[0]->jlh_tem_audit > 7 && $r1B[0]->jlh_tem_audit <= 10) {
			$r1BT = 1;
		} else {
			$r1BT = 0;
		}
		
		if($r1C[0]->jlh_tem_audit == 0) {
			$r1CT = 4;
		} else if($r1C[0]->jlh_tem_audit > 0 && $r1C[0]->jlh_tem_audit < 4) {
			$r1CT = 3;
		} else if($r1C[0]->jlh_tem_audit > 3 && $r1C[0]->jlh_tem_audit < 8) {
			$r1CT = 2;
		} else if($r1C[0]->jlh_tem_audit > 7 && $r1C[0]->jlh_tem_audit <= 10) {
			$r1CT = 1;
		} else {
			$r1CT = 0;
		}

		if($r2A[0]->jlh_tem_audit == 0) {
			$r2AT = 4;
		} else if($r2A[0]->jlh_tem_audit > 0 && $r2A[0]->jlh_tem_audit < 4) {
			$r2AT = 3;
		} else if($r2A[0]->jlh_tem_audit > 3 && $r2A[0]->jlh_tem_audit < 8) {
			$r2AT = 2;
		} else if($r2A[0]->jlh_tem_audit > 7 && $r2A[0]->jlh_tem_audit <= 10) {
			$r2AT = 1;
		} else {
			$r2AT = 0;
		}

		if($r2B[0]->jlh_tem_audit == 0) {
			$r2BT = 4;
		} else if($r2B[0]->jlh_tem_audit > 0 && $r2B[0]->jlh_tem_audit < 4) {
			$r2BT = 3;
		} else if($r2B[0]->jlh_tem_audit > 3 && $r2B[0]->jlh_tem_audit < 8) {
			$r2BT = 2;
		} else if($r2B[0]->jlh_tem_audit > 7 && $r2B[0]->jlh_tem_audit <= 10) {
			$r2BT = 1;
		} else {
			$r2BT = 0;
		}

		if($r2C[0]->jlh_tem_audit == 0) {
			$r2CT = 4;
		} else if($r2C[0]->jlh_tem_audit > 0 && $r2C[0]->jlh_tem_audit < 4) {
			$r2CT = 3;
		} else if($r2C[0]->jlh_tem_audit > 3 && $r2C[0]->jlh_tem_audit < 8) {
			$r2CT = 2;
		} else if($r2C[0]->jlh_tem_audit > 7 && $r2C[0]->jlh_tem_audit <= 10) {
			$r2CT = 1;
		} else {
			$r2CT = 0;
		}

		if($r3A[0]->jlh_tem_audit == 0) {
			$r3AT = 4;
		} else if($r3A[0]->jlh_tem_audit > 0 && $r3A[0]->jlh_tem_audit < 4) {
			$r3AT = 3;
		} else if($r3A[0]->jlh_tem_audit > 3 && $r3A[0]->jlh_tem_audit < 8) {
			$r3AT = 2;
		} else if($r3A[0]->jlh_tem_audit > 7 && $r3A[0]->jlh_tem_audit <= 10) {
			$r3AT = 1;
		} else {
			$r3AT = 0;
		}

		if($r3B[0]->jlh_tem_audit == 0) {
			$r3BT = 4;
		} else if($r3B[0]->jlh_tem_audit > 0 && $r3B[0]->jlh_tem_audit < 4) {
			$r3BT = 3;
		} else if($r3B[0]->jlh_tem_audit > 3 && $r3B[0]->jlh_tem_audit < 8) {
			$r3BT = 2;
		} else if($r3B[0]->jlh_tem_audit > 7 && $r3B[0]->jlh_tem_audit <= 10) {
			$r3BT = 1;
		} else {
			$r3BT = 0;
		}

		if($r3C[0]->jlh_tem_audit == 0) {
			$r3CT = 4;
		} else if($r3C[0]->jlh_tem_audit > 0 && $r3C[0]->jlh_tem_audit < 4) {
			$r3CT = 3;
		} else if($r3C[0]->jlh_tem_audit > 3 && $r3C[0]->jlh_tem_audit < 8) {
			$r3CT = 2;
		} else if($r3C[0]->jlh_tem_audit > 7 && $r3C[0]->jlh_tem_audit <= 10) {
			$r3CT = 1;
		} else {
			$r3CT = 0;
		}

		if($r4A[0]->jlh_tem_audit == 0) {
			$r4AT = 4;
		} else if($r4A[0]->jlh_tem_audit > 0 && $r4A[0]->jlh_tem_audit < 4) {
			$r4AT = 3;
		} else if($r4A[0]->jlh_tem_audit > 3 && $r4A[0]->jlh_tem_audit < 8) {
			$r4AT = 2;
		} else if($r4A[0]->jlh_tem_audit > 7 && $r4A[0]->jlh_tem_audit <= 10) {
			$r4AT = 1;
		} else {
			$r4AT = 0;
		}

		$data['r1'] = $r1AT + $r1BT + $r1CT;
		$data['r2'] = $r2AT + $r2BT + $r2CT;
		$data['r3'] = $r3AT + $r3BT + $r3CT;
		$data['r4'] = $r4AT;
		$data['total'] = $data['r1'] + $data['r2'] + $data['r3'] + $data['r4'];
		$data['periode'] = $tgl_audit;
		
        $data['audit'] = $this->m_admin->getAllAudit('s_mst.tb_audit', 's_mst.tb_dept', 's_mst.tb_aspek', 's_mst.tb_par_temuan', $where)->result();

		$this->load->view('admin/v_monitoring', $data);
	}

	// Fungsi untuk menampilkan ranking auditee
	function ranking(){
		$data['title']   = "Audit 5R | Ranking Audit Page";
		$data['ranking'] = $this->m_admin->getRanking('s_mst.tb_ranking')->result();
		$this->load->view('admin/v_ranking', $data);
	}

	// Fungsi untuk generate ranking
	function generate_ranking(){
		$periode    = $this->input->post('periode');
		$area       = $this->input->post('area');
		$where_area = array('kat_dept' => $area);
		$data_dept  = $this->m_admin->getWhere('s_mst.tb_dept', $where_area)->result();

		// Kosongkan (truncate) tabel ranking
		$this->m_admin->truncateRanking('s_mst.tb_ranking');

		// Generate ranking dan insert ke table tb_ranking
		$i = 0;
		foreach($data_dept as $row){
			$r1A[$i] = $this->m_monitoring->getJlhTemuan1A('s_mst.tb_audit', 's_mst.tb_dept', 's_mst.tb_aspek', 's_mst.tb_par_temuan', $area, $row->id_dept, $periode)->result();
			$r1B[$i] = $this->m_monitoring->getJlhTemuan1B('s_mst.tb_audit', 's_mst.tb_dept', 's_mst.tb_aspek', 's_mst.tb_par_temuan', $area, $row->id_dept, $periode)->result();
			$r1C[$i] = $this->m_monitoring->getJlhTemuan1C('s_mst.tb_audit', 's_mst.tb_dept', 's_mst.tb_aspek', 's_mst.tb_par_temuan', $area, $row->id_dept, $periode)->result();
			$r2A[$i] = $this->m_monitoring->getJlhTemuan2A('s_mst.tb_audit', 's_mst.tb_dept', 's_mst.tb_aspek', 's_mst.tb_par_temuan', $area, $row->id_dept, $periode)->result();
			$r2B[$i] = $this->m_monitoring->getJlhTemuan2B('s_mst.tb_audit', 's_mst.tb_dept', 's_mst.tb_aspek', 's_mst.tb_par_temuan', $area, $row->id_dept, $periode)->result();
			$r2C[$i] = $this->m_monitoring->getJlhTemuan2C('s_mst.tb_audit', 's_mst.tb_dept', 's_mst.tb_aspek', 's_mst.tb_par_temuan', $area, $row->id_dept, $periode)->result();
			$r3A[$i] = $this->m_monitoring->getJlhTemuan3A('s_mst.tb_audit', 's_mst.tb_dept', 's_mst.tb_aspek', 's_mst.tb_par_temuan', $area, $row->id_dept, $periode)->result();
			$r3B[$i] = $this->m_monitoring->getJlhTemuan3B('s_mst.tb_audit', 's_mst.tb_dept', 's_mst.tb_aspek', 's_mst.tb_par_temuan', $area, $row->id_dept, $periode)->result();
			$r3C[$i] = $this->m_monitoring->getJlhTemuan3C('s_mst.tb_audit', 's_mst.tb_dept', 's_mst.tb_aspek', 's_mst.tb_par_temuan', $area, $row->id_dept, $periode)->result();
			$r4A[$i] = $this->m_monitoring->getJlhTemuan4A('s_mst.tb_audit', 's_mst.tb_dept', 's_mst.tb_aspek', 's_mst.tb_par_temuan', $area, $row->id_dept, $periode)->result();

			if($r1A[$i][0]->jlh_tem_audit == 0) {
				$r1AT[$i] = 4;
			} else if($r1A[$i][0]->jlh_tem_audit > 0 && $r1A[$i][0]->jlh_tem_audit < 4) {
				$r1AT[$i] = 3;
			} else if($r1A[$i][0]->jlh_tem_audit > 3 && $r1A[$i][0]->jlh_tem_audit < 8) {
				$r1AT[$i] = 2;
			} else if($r1A[$i][0]->jlh_tem_audit > 7 && $r1A[$i][0]->jlh_tem_audit <= 10) {
				$r1AT[$i] = 1;
			} else {
				$r1AT[$i] = 0;
			}

			if($r1B[$i][0]->jlh_tem_audit == 0) {
				$r1BT[$i] = 4;
			} else if($r1B[$i][0]->jlh_tem_audit > 0 && $r1B[$i][0]->jlh_tem_audit < 4) {
				$r1BT[$i] = 3;
			} else if($r1B[$i][0]->jlh_tem_audit > 3 && $r1B[$i][0]->jlh_tem_audit < 8) {
				$r1BT[$i] = 2;
			} else if($r1B[$i][0]->jlh_tem_audit > 7 && $r1B[$i][0]->jlh_tem_audit <= 10) {
				$r1BT[$i] = 1;
			} else {
				$r1BT[$i] = 0;
			}
			
			if($r1C[$i][0]->jlh_tem_audit == 0) {
				$r1CT[$i] = 4;
			} else if($r1C[$i][0]->jlh_tem_audit > 0 && $r1C[$i][0]->jlh_tem_audit < 4) {
				$r1CT[$i] = 3;
			} else if($r1C[$i][0]->jlh_tem_audit > 3 && $r1C[$i][0]->jlh_tem_audit < 8) {
				$r1CT[$i] = 2;
			} else if($r1C[$i][0]->jlh_tem_audit > 7 && $r1C[$i][0]->jlh_tem_audit <= 10) {
				$r1CT[$i] = 1;
			} else {
				$r1CT[$i] = 0;
			}

			if($r2A[$i][0]->jlh_tem_audit == 0) {
				$r2AT[$i] = 4;
			} else if($r2A[$i][0]->jlh_tem_audit > 0 && $r2A[$i][0]->jlh_tem_audit < 4) {
				$r2AT[$i] = 3;
			} else if($r2A[$i][0]->jlh_tem_audit > 3 && $r2A[$i][0]->jlh_tem_audit < 8) {
				$r2AT[$i] = 2;
			} else if($r2A[$i][0]->jlh_tem_audit > 7 && $r2A[$i][0]->jlh_tem_audit <= 10) {
				$r2AT[$i] = 1;
			} else {
				$r2AT[$i] = 0;
			}

			if($r2B[$i][0]->jlh_tem_audit == 0) {
				$r2BT[$i] = 4;
			} else if($r2B[$i][0]->jlh_tem_audit > 0 && $r2B[$i][0]->jlh_tem_audit < 4) {
				$r2BT[$i] = 3;
			} else if($r2B[$i][0]->jlh_tem_audit > 3 && $r2B[$i][0]->jlh_tem_audit < 8) {
				$r2BT[$i] = 2;
			} else if($r2B[$i][0]->jlh_tem_audit > 7 && $r2B[$i][0]->jlh_tem_audit <= 10) {
				$r2BT[$i] = 1;
			} else {
				$r2BT[$i] = 0;
			}

			if($r2C[$i][0]->jlh_tem_audit == 0) {
				$r2CT[$i] = 4;
			} else if($r2C[$i][0]->jlh_tem_audit > 0 && $r2C[$i][0]->jlh_tem_audit < 4) {
				$r2CT[$i] = 3;
			} else if($r2C[$i][0]->jlh_tem_audit > 3 && $r2C[$i][0]->jlh_tem_audit < 8) {
				$r2CT[$i] = 2;
			} else if($r2C[$i][0]->jlh_tem_audit > 7 && $r2C[$i][0]->jlh_tem_audit <= 10) {
				$r2CT[$i] = 1;
			} else {
				$r2CT[$i] = 0;
			}

			if($r3A[$i][0]->jlh_tem_audit == 0) {
				$r3AT[$i] = 4;
			} else if($r3A[$i][0]->jlh_tem_audit > 0 && $r3A[$i][0]->jlh_tem_audit < 4) {
				$r3AT[$i] = 3;
			} else if($r3A[$i][0]->jlh_tem_audit > 3 && $r3A[$i][0]->jlh_tem_audit < 8) {
				$r3AT[$i] = 2;
			} else if($r3A[$i][0]->jlh_tem_audit > 7 && $r3A[$i][0]->jlh_tem_audit <= 10) {
				$r3AT[$i] = 1;
			} else {
				$r3AT[$i] = 0;
			}

			if($r3B[$i][0]->jlh_tem_audit == 0) {
				$r3BT[$i] = 4;
			} else if($r3B[$i][0]->jlh_tem_audit > 0 && $r3B[$i][0]->jlh_tem_audit < 4) {
				$r3BT[$i] = 3;
			} else if($r3B[$i][0]->jlh_tem_audit > 3 && $r3B[$i][0]->jlh_tem_audit < 8) {
				$r3BT[$i] = 2;
			} else if($r3B[$i][0]->jlh_tem_audit > 7 && $r3B[$i][0]->jlh_tem_audit <= 10) {
				$r3BT[$i] = 1;
			} else {
				$r3BT[$i] = 0;
			}

			if($r3C[$i][0]->jlh_tem_audit == 0) {
				$r3CT[$i] = 4;
			} else if($r3C[$i][0]->jlh_tem_audit > 0 && $r3C[$i][0]->jlh_tem_audit < 4) {
				$r3CT[$i] = 3;
			} else if($r3C[$i][0]->jlh_tem_audit > 3 && $r3C[$i][0]->jlh_tem_audit < 8) {
				$r3CT[$i] = 2;
			} else if($r3C[$i][0]->jlh_tem_audit > 7 && $r3C[$i][0]->jlh_tem_audit <= 10) {
				$r3CT[$i] = 1;
			} else {
				$r3CT[$i] = 0;
			}

			if($r4A[$i][0]->jlh_tem_audit == 0) {
				$r4AT[$i] = 4;
			} else if($r4A[$i][0]->jlh_tem_audit > 0 && $r4A[$i][0]->jlh_tem_audit < 4) {
				$r4AT[$i] = 3;
			} else if($r4A[$i][0]->jlh_tem_audit > 3 && $r4A[$i][0]->jlh_tem_audit < 8) {
				$r4AT[$i] = 2;
			} else if($r4A[$i][0]->jlh_tem_audit > 7 && $r4A[$i][0]->jlh_tem_audit <= 10) {
				$r4AT[$i] = 1;
			} else {
				$r4AT[$i] = 0;
			}

			$data_r1[$i] = $r1AT[$i] + $r1BT[$i] + $r1CT[$i];
			$data_r2[$i] = $r2AT[$i] + $r2BT[$i] + $r2CT[$i];
			$data_r3[$i] = $r3AT[$i] + $r3BT[$i] + $r3CT[$i];
			$data_r4[$i] = $r4AT[$i];
			$data_total[$i] = $data_r1[$i] + $data_r2[$i] + $data_r3[$i] +$data_r4[$i];

			$data_ranking[$i] = array(
				'area_ranking'    => $area,
				'dept_ranking'    => $row->id_dept,
				'periode_ranking' => $periode,
				'total_ranking'   => $data_total[$i],
				'updated_ranking' => date('Y-m-d'),
				'nama_dep'       => $row->area_dept
			);
			$insert_ranking = $this->m_admin->insert('s_mst.tb_ranking', $data_ranking[$i]);
			if ($insert_ranking){
				$log_type = 'insert';
				$log_desc = 'Generate Data Ranking Temuan Audit';
				$ip       = $this->input->ip_address();
				$userLog  = $this->session->userdata("username");
				date_default_timezone_set("Asia/Jakarta");
				$data_log = array(
					'username'      => $userLog,
					'type_log'      => $log_type,
					'deskripsi_log' => $log_desc,
					'date'          => date("Y-m-d H:i:s"),
					'ip'            => $ip
				);
				$this->m_log->insertLog('s_log.tb_log', $data_log);
				echo "<script>location='".base_url()."admin/ranking';</script>";
			} else{
				echo "<script>alert('Gagal generate data ranking audit');</script>";
				echo "<script>location='".base_url()."admin/ranking';</script>";
				exit;
			}


			$i++;
		}

	}





	public function coba(){
		$this->load->view('admin/v_coba');
	}
}