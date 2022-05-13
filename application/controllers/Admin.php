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
		$app_url  = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ? "https" : "http");
		$app_url .= "://" . $_SERVER['HTTP_HOST'];
		$data['SITE_URL']= $app_url;
		
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

	// Insert data user ke database tb_user
	public function addUser(){
		$data['title'] = "Audit 5R | Data User Page";
		$nama          = $this->input->post("nama");
		$username      = htmlspecialchars(trim($this->input->post("username")));
		$password      = htmlspecialchars(trim($this->input->post("password")));
		$level         = $this->input->post("level");
		$bagian        = $this->input->post("bagian");

		// cek apakah username suda dipakai apa belum
		$whereUser     = array('username' => $username);
		$isUsername    = $this->m_admin->getWhere('s_mst.tb_user', $whereUser)->num_rows(); 
		if ($isUsername > 0){
			$this->session->set_flashdata('warning', "Username $username sudah ada di sistem. Silakan pilih username lain!");
			echo "<script>location='".base_url()."admin/user';</script>";
			exit;
		}

		$data_user     = array(
			'nama'     => $nama,
			'username' => $username,
			'password' => md5($password),
			'level'    => $level,
			'kd_dept'  => $bagian,
		);

		// insert user ke tb_user
		$insertUser  = $this->m_admin->insertData('s_mst.tb_user', $data_user);
		if ($insertUser){
			$log_type = 'insert';
			$log_desc = 'Tambah Data User untuk bagian: '.$bagian. ', level: '.$level.', username: '.$username;
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
			$this->session->set_flashdata('success', 'Berhasil tambah data User');
			echo "<script>location='".base_url()."admin/user';</script>";
		} else{
			$this->session->set_flashdata('error', 'Gagal menambah data User. Ada kesalahan di sisi server. Silakan ulangi lagi!');
			echo "<script>location='".base_url()."admin/user';</script>";
			exit;
		}
	}

	// menampilkan halaman mapped user
	function auditor(){
		$data['title']   = "Audit 5R | Data Auditor Page";
		$level           = $this->session->userdata("level");
		$data['dept']    = $this->m_admin->get('s_mst.tb_dept')->result();
		$data['user']    = $this->m_admin->getUsers('s_mst.tb_user','s_mst.tb_dept')->result();
		$data['auditor'] = $this->m_admin->get('s_mst.tb_auditor')->result();
		$data['map_adt'] = $this->m_admin->getMapAuditors('s_mst.tb_map_auditor','s_mst.tb_auditor', 's_mst.tb_user')->result();
		$this->load->view('admin/v_data_auditor', $data);
	}

	// Insert data auditor ke database tb_auditor
	public function addAuditor(){
		$data['title'] = "Audit 5R | Data Auditor Page";
		$nama          = htmlspecialchars(trim(strtoupper($this->input->post("nama"))));
		$area          = $this->input->post("area");
		$level         = $this->input->post("level");

		// cek apakah nama auditor suda dipakai apa belum
		$whereAuditor  = array('nama_auditor' => $nama);
		$isAuditor     = $this->m_admin->getWhere('s_mst.tb_auditor', $whereAuditor)->num_rows(); 
		if ($isAuditor > 0){
			$this->session->set_flashdata('warning', 'Nama auditor sudah ada di sistem. Silakan pilih nama lain!');
			echo "<script>location='".base_url()."admin/auditor';</script>";
			exit;
		}

		$data_auditor  = array(
			'nama_auditor' => $nama,
			'area_auditor' => $area,
			'level_auditor'=> $level,
		);

		// insert auditor ke tb_auditor
		$insertAuditor  = $this->m_admin->insertData('s_mst.tb_auditor', $data_auditor);
		if ($insertAuditor){
			$log_type = 'insert';
			$log_desc = 'Tambah Data Auditor dengan nama: '.$nama. ', level: '.$level.', area: '.$area;
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
			$this->session->set_flashdata('success', "Auditor $nama, berhasil ditambahkan ke sistem.");
			echo "<script>location='".base_url()."admin/auditor';</script>";
		} else{
			$this->session->set_flashdata('error', 'Gagal tambah auditor. Ada kesalahan di sisi server. Silakan ulangi lagi!');
			echo "<script>location='".base_url()."admin/auditor';</script>";
			exit;
		}
	}

	// Insert data mamp auditor ke database tb_Map_auditor
	public function mapAuditor(){
		$data['title'] = "Audit 5R | Data Auditor Page";
		$auditor       = $this->input->post("auditor");
		$koordinator   = $this->input->post("koordinator");
		
		// cek apakah koor ada di tb_user
		$whereKoor     = array('id_user' => $koordinator);
		$getKoor       = $this->m_admin->getKoor('s_mst.tb_user', 's_mst.tb_dept', $whereKoor)->result();
		
		// cek apakah nama auditor sudah dimapping apa belum
		$whereMA       = array('id_auditor' => $auditor, 'id_koor' => $koordinator);
		$isMapAuditor  = $this->m_admin->getWhere('s_mst.tb_map_auditor', $whereMA)->num_rows(); 
		if ($isMapAuditor > 0){
			$this->session->set_flashdata('warning', 'Nama auditor sudah dimapping di sistem. Silakan pilih nama lain!');
			echo "<script>location='".base_url()."admin/auditor';</script>";
			exit;
		}

		$data_ma  = array(
			'id_auditor' => $auditor,
			'id_koor'    => $koordinator,
			'area_ma'    => $getKoor[0]->area_dept,
		);

		// insert auditor ke tb_auditor
		$insertMapAuditor  = $this->m_admin->insertData('s_mst.tb_map_auditor', $data_ma);
		if ($insertMapAuditor){
			$log_type = 'insert';
			$log_desc = 'Tambah Data Map Auditor dengan ID Auditor: '.$auditor. ', Koordinator: '.$koordinator;
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
			$this->session->set_flashdata('success', "ID Auditor: $auditor, berhasil dimapping ke sistem.");
			echo "<script>location='".base_url()."admin/auditor';</script>";
		} else{
			$this->session->set_flashdata('error', 'Gagal mapping auditor. Ada kesalahan di sisi server. Silakan ulangi lagi!');
			echo "<script>location='".base_url()."admin/auditor';</script>";
			exit;
		}
	}

	// FUNGSI UNTUK MENAMPILKAN HALAMAN JADWAL
	function jadwal(){
		$data['title']   = "Audit 5R | Data Jadwal Audit Page";
		$level           = $this->session->userdata("level");
		$data['dept']    = $this->m_admin->get('s_mst.tb_dept')->result();
		$data['section'] = $this->m_admin->get('s_mst.tb_section')->result();
		$data['jadwal']  = $this->m_admin->getJadwal('s_mst.tb_jadwal','s_mst.tb_user','s_mst.tb_dept')->result();
		$where           = array('level' => 'auditor');
		$data['user']    = $this->m_admin->getWhere('s_mst.tb_user', $where)->result();
		$this->load->view('admin/v_jadwal', $data);
	}

	// FUNGSI UNTUK MENGAMBIL DATA SECTION
	function getSect(){
		$area = $this->input->post('data');
		$where = array(
			'area_section' => $area
		);
 
		$data = $this->m_admin->getWhere('s_mst.tb_section', $where)->result();
		echo json_encode($data);
	}

	// FUNGSI UNTUK MENGAMBIL DATA DEPT
	function getDept(){
		$section = $this->input->post('data');
		$where = array(
			'section' => $section
		);
 
		$data = $this->m_admin->getWhere('s_mst.tb_dept', $where)->result();
		echo json_encode($data);
	}

	// SUBMIT DATA JADWAL AUDIT KE TB_JADWAL
	function addJadwal(){
		date_default_timezone_set("Asia/Jakarta");
		$data['title'] = "Audit 5R | Data Jadwal Audit Page";
		
		$dt            = date_create($this->input->post("date_time"));
		$auditee       = $this->input->post("auditee");
		$auditor       = $this->input->post("auditor[]");
		$periode       = date_format($dt,'Y-m');


		for ($i=0; $i < count($auditor) ; $i++) { 
			// cek apakah jadwal audit suda ada pada periode tersebut atau tidak
			$whereJA     = array(
				'auditee' => $auditee,
				'auditor' => $auditor[$i],
				'periode' => $periode,
			);
	
			$isJA[$i] = $this->m_admin->getWhere('s_mst.tb_jadwal', $whereJA)->num_rows(); 
			if ($isJA[$i] > 0){
				$this->session->set_flashdata('warning', "Jadwal auditor: $auditor[$i], pada auditee: $auditee, periode: $periode, sudah ada di jadwal. Silakan pilih jadwal/periode lain!");
				continue;
			}

			$kd_jadwal[$i] = "JA".date("YmdHi").$i;
	
			$data_jadwal[$i] = array(
				'kd_jadwal' => $kd_jadwal[$i],
				'tgl_waktu' => date_format($dt,'d-m-Y H:i'),
				'auditee'   => $auditee,
				'auditor'   => $auditor[$i],
				'realisasi' => false,
				'periode'   => $periode,
				'updated'   => date("Y-m-d H:i:s"),
			);
	
			// insert user ke tb_user
			$insertJadwal  = $this->m_admin->insertData('s_mst.tb_jadwal', $data_jadwal[$i]);

			$log_type = 'insert';
			$log_desc = "Tambah data jadwal auditor: $auditor[$i], pada auditee: $auditee, periode: $periode";
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
		}

		if ($insertJadwal){
			$this->session->set_flashdata('success', "Jadwal auditor berhasil ditambahkan");
			echo "<script>location='".base_url()."admin/jadwal';</script>";
		} else{
			$this->session->set_flashdata('error', 'Gagal menambah data jadwal. Ada kesalahan saat input di sistem!');
			echo "<script>location='".base_url()."admin/jadwal';</script>";
			exit;
		}
	}
	


	/**================================================================================================================
	 * FUNCTION UNTUK LAPORAN
	 * ================================================================================================================
	 */

	// Menmapilkan Data Laporan Ketidaksesuaian
	function lap(){
		$data['title'] = "Audit 5R | Lap Ketidaksesuaian Page";
		$data['dept']  = $this->m_admin->get('s_mst.tb_dept')->result();
        $this->load->view('admin/v_lap', $data);
	}

	// Fungsi untuk menampilkan Laporan Ketidaksesuaian
	function lk($id_dept){
		$app_url  = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ? "https" : "http");
		$app_url .= "://" . $_SERVER['HTTP_HOST'];
		$data['SITE_URL']= $app_url;

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
		$app_url  = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ? "https" : "http");
		$app_url .= "://" . $_SERVER['HTTP_HOST'];
		$data['SITE_URL']= $app_url;

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
			$log_desc = 'Ubah Data Rekomendasi Temuan Audit id: '.$id_audit;
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
			$this->session->set_flashdata('success', "Berhasil update rekomendasi untuk data audit id: $id_audit, pada auditee: $id_dep");
			echo "<script>location='".base_url()."admin/data_audit/$id_dep';</script>";
		} else{
			$this->session->set_flashdata('error', "Gagal update rekomendasi untuk data audit id: $id_audit, pada auditee: $id_dep");
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
		date_default_timezone_set("Asia/Jakarta");
		$periode    = $this->input->post('periode');
		$area       = $this->input->post('area');
		$where_area = array('kat_dept' => $area);
		$data_dept  = $this->m_admin->getWhere('s_mst.tb_dept', $where_area)->result();

		// cek apakag rangking pada periode tertentu sudah ada atau tidak
		$whereRanking = array('area_ranking' => $area, 'periode_ranking' => $periode);
		$isRanking    = $this->m_admin->getWhere('s_mst.tb_ranking', $whereRanking)->num_rows();
		if ($isRanking > 0) {
			$this->m_admin->delete('s_mst.tb_ranking', $whereRanking);
		}

		// Kosongkan (truncate) tabel ranking
		// $this->m_admin->truncateRanking('s_mst.tb_ranking');

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

			// cek updated temuan terakhir
			$whereDateClose[$i] = array(
				'kd_lok_audit'  => $area,
				'periode'       => $periode,
				'kd_dept_audit' => $row->id_dept,
			);

			// get jlh temuan open per auditee
			$data_sum_temuan[$i] = $this->m_admin->getSumTemAuditee($row->id_dept)->result();
			if ($data_sum_temuan[$i] == null) {
				$real_sum[$i] = 0;
			} else {
				$real_sum[$i] = $data_sum_temuan[$i][0]->sum;
			}


			$date_close[$i] = $this->m_admin->getDateClose('s_mst.tb_audit', $whereDateClose[$i])->result();
			$num_dl         = $this->m_admin->getDateClose('s_mst.tb_audit', $whereDateClose[$i])->num_rows();
			if ($num_dl == 0) {
				$updated_ranking[$i]  = '2000-01-01 01:01:01+07';
			} else {
				$updated_ranking[$i]  = $date_close[$i][0]->max;
			}

			$data_r1[$i]    = $r1AT[$i] + $r1BT[$i] + $r1CT[$i];
			$data_r2[$i]    = $r2AT[$i] + $r2BT[$i] + $r2CT[$i];
			$data_r3[$i]    = $r3AT[$i] + $r3BT[$i] + $r3CT[$i];
			$data_r4[$i]    = $r4AT[$i];
			$data_total[$i] = $data_r1[$i] + $data_r2[$i] + $data_r3[$i] +$data_r4[$i];
			$id_ranking[$i] = date('YmdHis').$i;
			$data_ranking[$i] = array(
				'id_ranking'      => $id_ranking[$i],
				'area_ranking'    => $area,
				'dept_ranking'    => $row->id_dept,
				'periode_ranking' => $periode,
				'total_ranking'   => $data_total[$i] - $real_sum[$i],
				'updated_ranking' => $updated_ranking[$i],
				'nama_dep'        => $row->bagian_dept,
			);
			$insert_ranking[$i] = $this->m_admin->insert('s_tmp.tb_ranking', $data_ranking[$i]);
			if ($insert_ranking[$i]){
				$log_type = 'insert';
				$log_desc = 'Generate Data Ranking Temuan Audit, Area: '.$area.', Bagian: '.$row->area_dept.', Periode: '.$periode;
				$ip       = $this->input->ip_address();
				$userLog  = $this->session->userdata("username");
				$data_log = array(
					'username'      => $userLog,
					'type_log'      => $log_type,
					'deskripsi_log' => $log_desc,
					'date'          => date("Y-m-d H:i:s"),
					'ip'            => $ip
				);
				$this->m_log->insertLog('s_log.tb_log', $data_log);
			} else{
				$this->session->set_flashdata('error', "Gagal generate data ranking. Ada kesalahan di sisi server. Error 500!");
				continue;
			}
			$i++;
		}

		// cek apakag rangking pada periode tertentu sudah ada atau tidak
		$whereRanking = array('area_ranking' => $area, 'periode_ranking' => $periode);
		$isRanking    = $this->m_admin->getWhere('s_tmp.tb_ranking', $whereRanking)->num_rows();
		if ($isRanking > 0) {
			// lakukan generate urutan ranking dan simpan ke tabel master
			$this->m_admin->generateRanking();
			$this->m_admin->truncateRanking('s_tmp.tb_ranking');

			$this->session->set_flashdata('success', "Berhasil generate data ranking");
			echo "<script>location='".base_url()."admin/ranking';</script>";
		} else {
			$this->session->set_flashdata('error', "Gagal generate data ranking. Ada kesalahan di sisi server. Error 500!");
			echo "<script>location='".base_url()."admin/ranking';</script>";
			exit;
		}
	}

	



	// Menampilkan Data Log
	public function log(){
		$data['title'] = "Data Log | Audit 5R";
		$data['log']   = $this->m_admin->getLog('s_log.tb_log')->result();
		$this->load->view('admin/v_log', $data);
	}

	public function coba(){
		
	}
}