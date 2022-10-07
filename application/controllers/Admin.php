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
		$data['title'] = "Audit 5R | Data Audit pabrik";
		$data['ap']    = "active";
		$data['anp']   = "";
		$data['area']  = "PABRIK";
		$where_dept    = array('kat_dept' => "PABRIK");
        $data['dept']  = $this->m_admin->getWhere('s_mst.tb_dept',$where_dept)->result();
		$this->load->view('admin/v_home', $data);
	}

	// Fungsi untuk menampilkan data temuan dengan status open
	function stpb($status){
		$app_url  = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ? "https" : "http");
		$app_url .= "://" . $_SERVER['HTTP_HOST'];
		$data['SITE_URL']= $app_url;

		$data['status'] = $status;
		$data['title']  = "Audit 5R | Data Audit Status";
	
		$data['area'] = "PABRIK";
		$data['ap']   = "active";
		$data['anp']  = "";
		$where          = array('s_mst.tb_audit.kd_lok_audit' => $data['area'], 's_mst.tb_audit.status' => "$status");
		$data['temuan'] = $this->m_admin->getAllAudit('s_mst.tb_audit', 's_mst.tb_dept', 's_mst.tb_aspek', 's_mst.tb_par_temuan', $where)->result();
		$this->load->view('admin/v_stp', $data);	
	}

	// Fungsi untuk menampilkan data temuan dengan status open
	function stnp($status){
		$app_url  = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ? "https" : "http");
		$app_url .= "://" . $_SERVER['HTTP_HOST'];
		$data['SITE_URL']= $app_url;

		$data['status'] = $status;
		$data['title']  = "Audit 5R | Data Audit Status";
	
		$data['area'] = "NON-PABRIK";
		$data['ap']   = "";
		$data['anp']  = "active";
		$where          = array('s_mst.tb_audit.kd_lok_audit' => $data['area'], 's_mst.tb_audit.status' => "$status");
		$data['temuan'] = $this->m_admin->getAllAudit('s_mst.tb_audit', 's_mst.tb_dept', 's_mst.tb_aspek', 's_mst.tb_par_temuan', $where)->result();
		$this->load->view('admin/v_stp', $data);		
	}

	// Menampilkan Data Audit Non Pabrik
	function non_pabrik(){
		$data['title'] = "Audit 5R | Data Audit Non Pabrik";
		$data['ap']    = "";
		$data['anp']   = "active";
		$data['area']  = "NON-PABRIK";
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


	// ambil data gambar
	public function getImg(){
		$id = $this->input->post('data');
		$where = array(
			'id_audit' => $id
		);
 
		$data = $this->m_admin->getWhere('s_mst.tb_audit', $where)->result();
		echo json_encode($data[0]->gambar);
	}

	// ambil data gambar
	public function getImgSesudah(){
		$id = $this->input->post('data');
		$where = array(
			'id_audit' => $id
		);
 
		$data = $this->m_admin->getWhere('s_mst.tb_audit', $where)->result();
		echo json_encode($data[0]->gambar_sesudah);
	}

	// fungsi untuk menampilkan halaman user
	function user(){
		$data['title'] = "Audit 5R | Data User Page";
		$level         = $this->session->userdata("level");
		$data['area']  = $this->m_admin->get('s_mst.tb_dept')->result();
		$data['users'] = $this->m_admin->getUsers('s_mst.tb_user','s_mst.tb_dept')->result();
		$this->load->view('admin/v_user', $data);
	}

	function get_dept(){
		$area  = $this->input->post('data');
		$where = array('kat_dept' => $area);
		$data  = $this->m_admin->getWhere('s_mst.tb_dept', $where)->result();
		echo json_encode($data);
	}


	// Insert data user ke database tb_user
	public function addUser(){
		$data['title'] = "Audit 5R | Data User Page";
		$nama          = $this->input->post("nama");
		$username      = htmlspecialchars(trim($this->input->post("username")));
		$password      = htmlspecialchars(trim($this->input->post("password")));
		$level         = $this->input->post("level");
		$area          = $this->input->post("area_usr");
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

	// update data user ke database tb_user
	public function editUser(){
		$data['title'] = "Audit 5R | Data User Page";
		$id_user       = $this->input->post("id_user");
		$nama          = htmlspecialchars(trim($this->input->post("nama")));
		$username      = htmlspecialchars(trim($this->input->post("username")));
		$level         = $this->input->post("level");
		$bagian        = $this->input->post("bagian");

		// cek apakah username suda dipakai apa belum
		$whereUser     = array('username' => $username);
		$whereId       = array('id_user' => $id_user);
		$isUsername    = $this->m_admin->getWhere('s_mst.tb_user', $whereUser)->num_rows(); 
		if ($isUsername > 0){
			$this->session->set_flashdata('warning', "Username $username sudah ada di sistem. Silakan pilih username lain!");
			echo "<script>location='".base_url()."admin/user';</script>";
			exit;
		}

		$data_user     = array(
			'nama'     => $nama,
			'username' => $username,
			'level'    => $level,
			'kd_dept'  => $bagian,
		);

		// insert user ke tb_user
		$updateUser  = $this->m_admin->updateData('s_mst.tb_user', $data_user, $whereId);
		if ($updateUser){
			$log_type = 'update';
			$log_desc = "Update Data User untuk ID: $id_user, Bagian: $bagian, Level: $level, Username: $username";
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
			$this->session->set_flashdata('success', 'Berhasil update data User');
			echo "<script>location='".base_url()."admin/user';</script>";
		} else{
			$this->session->set_flashdata('error', 'Gagal update data User. Ada kesalahan di sisi server. Silakan ulangi lagi!');
			echo "<script>location='".base_url()."admin/user';</script>";
			exit;
		}
	}

	// menampilkan halaman mapped user
	function auditor(){
		$data['title']   = "Audit 5R | Data Auditor Page";
		$level           = $this->session->userdata("level");
		$whereAngg       = array('level_auditor' => 'ANGGOTA');
		$whereKoor       = array('level_auditor' => 'KOORDINATOR');
		$data['dept']    = $this->m_admin->get('s_mst.tb_dept')->result();
		$data['user']    = $this->m_admin->getUsers('s_mst.tb_user','s_mst.tb_dept')->result();
		$data['koor_aud']= $this->m_admin->getUserKoorAud('s_mst.tb_user','s_mst.tb_auditor', $whereKoor)->result();
		$data['auditor'] = $this->m_admin->getWhere('s_mst.tb_auditor', $whereAngg)->result();
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

	// Edit data auditor ke database tb_auditor
	public function editAuditor(){
		$data['title'] = "Audit 5R | Data Auditor Page";
		$id_auditor    = $this->input->post("id_auditor");
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
		$whereID = array('id_auditor' => $id_auditor);
		$data_auditor  = array(
			'nama_auditor' => $nama,
			'area_auditor' => $area,
			'level_auditor'=> $level,
		);

		// update auditor ke tb_auditor
		$updateAuditor  = $this->m_admin->updateData('s_mst.tb_auditor', $data_auditor, $whereID);
		if ($updateAuditor){
			$log_type = 'update';
			$log_desc = 'Update Data Auditor dengan nama: '.$nama. ', level: '.$level.', area: '.$area;
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
			$this->session->set_flashdata('success', "Data auditor $nama, berhasil diperbaharui ke sistem.");
			echo "<script>location='".base_url()."admin/auditor';</script>";
		} else{
			$this->session->set_flashdata('error', 'Gagal update data auditor. Ada kesalahan di sisi server. Silakan ulangi lagi!');
			echo "<script>location='".base_url()."admin/auditor';</script>";
			exit;
		}
	}

	// delete auditor
	function deleteAuditor($id_auditor){
		$whereID = array('id_auditor' => $id_auditor);

		// delete map auditor dari tb_auditor
		$deleteAuditor  = $this->m_admin->delete('s_mst.tb_auditor', $whereID);
		if ($deleteAuditor){
			$log_type = 'delete';
			$log_desc = 'Delete Data Auditor dengan ID: '.$id_auditor;
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
			$this->session->set_flashdata('success', "Data auditor dengan ID: $id_auditor, berhasil dihapus.");
			echo "<script>location='".base_url()."admin/auditor';</script>";
		} else{
			$this->session->set_flashdata('error', 'Gagal hapus data auditor. Ada kesalahan di sisi server. Silakan ulangi lagi!');
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

	// Update data mamp auditor ke database tb_Map_auditor
	public function updateMapAuditor(){
		$data['title'] = "Audit 5R | Data Auditor Page";
		$id_map        = $this->input->post("id_map");
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

		$whereIdMap     = array('id_ma' => $id_map);
		$data_ma  = array(
			'id_auditor' => $auditor,
			'id_koor'    => $koordinator,
			'area_ma'    => $getKoor[0]->area_dept,
		);

		// insert auditor ke tb_auditor
		$updateMapAuditor  = $this->m_admin->updateData('s_mst.tb_map_auditor', $data_ma, $whereIdMap);
		if ($updateMapAuditor){
			$log_type = 'update';
			$log_desc = 'Update Data Map Auditor dengan ID Auditor: '.$auditor. ', Koordinator: '.$koordinator;
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
			$this->session->set_flashdata('success', "ID Auditor: $auditor, berhasil dimapping ke sistem dengan data baru.");
			echo "<script>location='".base_url()."admin/auditor';</script>";
		} else{
			$this->session->set_flashdata('error', 'Gagal update mapping auditor. Ada kesalahan di sisi server. Silakan ulangi lagi!');
			echo "<script>location='".base_url()."admin/auditor';</script>";
			exit;
		}
	}

	// delete map auditor
	function deleteMapAuditor($id_map){
		$whereID = array('id_ma' => $id_map);

		// delete map auditor dari tb_auditor
		$deleteMapAuditor  = $this->m_admin->delete('s_mst.tb_map_auditor', $whereID);
		if ($deleteMapAuditor){
			$log_type = 'delete';
			$log_desc = 'Delete Data Map Auditor dengan ID: '.$id_map;
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
			$this->session->set_flashdata('success', "Data map auditor dengan ID: $id_map, berhasil dihapus.");
			// echo "<script>location='".base_url()."admin/auditor';</script>";
		} else{
			$this->session->set_flashdata('error', 'Gagal hapus data map auditor. Ada kesalahan di sisi server. Silakan ulangi lagi!');
			echo "<script>location='".base_url()."admin/auditor';</script>";
			exit;
		}
	}

	// FUNGSI UNTUK MENAMPILKAN HALAMAN JADWAL
	function jadwal(){
		$data['title']   = "Audit 5R | Data Jadwal Audit";
		$periode         = $this->input->post('periode');
		if (isset($periode)) {
			$wh_periode      = array('periode' => $periode);
			$wh_jap          = array('area' => 'PABRIK' ,'periode' => $periode);
			$wh_janp         = array('area' => 'NON-PABRIK' ,'periode' => $periode);


			$level           = $this->session->userdata("level");
			$data['dept']    = $this->m_admin->get('s_mst.tb_dept')->result();
			$data['section'] = $this->m_admin->get('s_mst.tb_section')->result();
			$data['all_jadwal'] = $this->m_admin->getJadwal('s_mst.tb_jadwal','s_mst.tb_user','s_mst.tb_dept')->result();
			$data['jadwal']  = $this->m_admin->getJadwalAuditor('s_tmp.tb_jadwal', 's_mst.tb_user', $wh_periode)->result();
			$data['jap']     = $this->m_admin->getWhere('s_tmp.tb_jadwal', $wh_jap)->result();
			$data['janp']    = $this->m_admin->getWhere('s_tmp.tb_jadwal', $wh_janp)->result();
			$where           = array('level' => 'auditor');
			$data['user']    = $this->m_admin->getWhere('s_mst.tb_user', $where)->result();

			// ambil data realisasi jadwal audit
			$jpt = $this->m_admin->getJadwalByRealisasi('PABRIK', 'true', $periode)->result();
			$jpf = $this->m_admin->getJadwalByRealisasi('PABRIK', 'false', $periode)->result();
			$jnpt = $this->m_admin->getJadwalByRealisasi('NON-PABRIK', 'true', $periode)->result();
			$jnpf = $this->m_admin->getJadwalByRealisasi('NON-PABRIK', 'false', $periode)->result();
			$data['jp_true']   = $jpt[0]->total;
			$data['jp_false']  = $jpf[0]->total;
			$data['jnp_true']  = $jnpt[0]->total;
			$data['jnp_false'] = $jnpf[0]->total;
			$data['periode'] = $periode;

			$this->load->view('admin/v_jadwal', $data);
		} else {
			$periode         = date('Y-m');
			$wh_periode      = array('periode' => $periode);
			$wh_jap          = array('area' => 'PABRIK' ,'periode' => $periode);
			$wh_janp         = array('area' => 'NON-PABRIK' ,'periode' => $periode);


			$level           = $this->session->userdata("level");
			$data['dept']    = $this->m_admin->get('s_mst.tb_dept')->result();
			$data['section'] = $this->m_admin->get('s_mst.tb_section')->result();
			$data['all_jadwal'] = $this->m_admin->getJadwal('s_mst.tb_jadwal','s_mst.tb_user','s_mst.tb_dept')->result();
			$data['jadwal']  = $this->m_admin->getJadwalAuditor('s_tmp.tb_jadwal', 's_mst.tb_user', $wh_periode)->result();
			$data['jap']     = $this->m_admin->getWhere('s_tmp.tb_jadwal', $wh_jap)->result();
			$data['janp']    = $this->m_admin->getWhere('s_tmp.tb_jadwal', $wh_janp)->result();
			$where           = array('level' => 'auditor');
			$data['user']    = $this->m_admin->getWhere('s_mst.tb_user', $where)->result();

			// ambil data realisasi jadwal audit
			$jpt = $this->m_admin->getJadwalByRealisasi('PABRIK', 'true', $periode)->result();
			$jpf = $this->m_admin->getJadwalByRealisasi('PABRIK', 'false', $periode)->result();
			$jnpt = $this->m_admin->getJadwalByRealisasi('NON-PABRIK', 'true', $periode)->result();
			$jnpf = $this->m_admin->getJadwalByRealisasi('NON-PABRIK', 'false', $periode)->result();
			$data['jp_true']   = $jpt[0]->total;
			$data['jp_false']  = $jpf[0]->total;
			$data['jnp_true']  = $jnpt[0]->total;
			$data['jnp_false'] = $jnpf[0]->total;
			$data['periode'] = $periode;

			$this->load->view('admin/v_jadwal', $data);
		}
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

	// FUNGSI UNTUK MENGAMBIL DATA AUditor
	function getAuditor(){
		$id_koor   = $this->input->post('data');
		$data = $this->m_admin->getDataAuditorByKoor('s_mst.tb_map_auditor', 's_mst.tb_auditor', $id_koor)->result();
		echo json_encode($data);
	}

	// SUBMIT DATA JADWAL AUDIT KE TB_JADWAL
	function addJadwal(){
		date_default_timezone_set("Asia/Jakarta");
		$data['title'] = "Audit 5R | Data Jadwal Audit Page";
		
		$dt            = date_create($this->input->post("date_time"));
		$auditee       = $this->input->post("auditee");
		$koordinator   = $this->input->post("koordinator");
		$auditor       = $this->input->post("auditor[]");
		$periode       = date_format($dt,'Y-m');

		$aud = array();
		for ($i=0; $i < count($auditor) ; $i++) { 
			array_push($aud, $auditor[$i]);
		}

		// cek apakah jadwal audit suda ada pada periode tersebut atau tidak
		$whereJA     = array(
			'auditee' => $auditee,
			'auditor' => $koordinator,
			'anggota_auditor' => json_encode($aud),
			'periode' => $periode,
		);

		$isJA = $this->m_admin->getWhere('s_mst.tb_jadwal', $whereJA)->num_rows(); 
		if ($isJA > 0){
			$this->session->set_flashdata('warning', "Jadwal auditor: $koordinator, pada auditee: $auditee, periode: $periode, sudah ada di jadwal. Silakan pilih jadwal/periode lain!");
			echo "<script>location='".base_url()."admin/jadwal';</script>";
			exit;
		}

		$kd_jadwal = "JA".date("YmdHi");

		$data_jadwal = array(
			'kd_jadwal' => $kd_jadwal,
			'tgl_waktu' => date_format($dt,'d-m-Y H:i'),
			'auditee'   => $auditee,
			'auditor'   => $koordinator,
			'realisasi' => false,
			'periode'   => $periode,
			'updated'   => date("Y-m-d H:i:s"),
			'wa_status' => false,
			'anggota_auditor' => json_encode($aud),
		);

		// insert user ke tb_user
		$insertJadwal  = $this->m_admin->insertData('s_mst.tb_jadwal', $data_jadwal);

		$log_type = 'insert';
		$log_desc = "Tambah data jadwal auditor: $koordinator, pada auditee: $auditee, periode: $periode";
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

		if ($insertJadwal){
			// replikasi ke tmp.tb_jadwal
			$duplikat_tmp = $this->m_admin->replikasiDataJadwalBaru($kd_jadwal);
			if (!$duplikat_tmp) {
				$this->session->set_flashdata('warning', "Jadwal auditor berhasil ditambahkan namun gagal di repplikasi!");
				echo "<script>location='".base_url()."admin/jadwal';</script>";
			}
			$this->session->set_flashdata('success', "Jadwal auditor berhasil ditambahkan");
			echo "<script>location='".base_url()."admin/jadwal';</script>";
		} else{
			$this->session->set_flashdata('error', 'Gagal menambah data jadwal. Ada kesalahan saat input di sistem!');
			echo "<script>location='".base_url()."admin/jadwal';</script>";
			exit;
		}
	}
	
	// fungsi untuk reschedule jadwal audit
	function editJadwal(){
		date_default_timezone_set("Asia/Jakarta");
		$data['title'] = "Audit 5R | Edit Jadwal Audit Page";
		
		$kode_jadwal = $this->input->post("kode");
		$tgl_audit   = $this->input->post("tgl_audit");

		$update = $this->db->query('SELECT s_mst.updatejadwal(kodejadwal=>`'.$kode_jadwal.'`, tglaudit=>`'.$tgl_audit.'`)')->result();
		// $update = $this->m_admin->rescheduleJadwalAudit($kode_jadwal, $tgl_audit);

		if ($update[0]->updatejadwal) {
			$log_type = 'update';
			$log_desc = "Rechedule data jadwal kode: $kode_jadwal, jadi tgl: $tgl_audit";
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

			$this->session->set_flashdata('success', "Jadwal auditor berhasil diperbaharui");
			echo "<script>location='".base_url()."admin/jadwal';</script>";
		} else {
			$this->session->set_flashdata('error', "Jadwal auditor gagal diperbaharui");
			echo "<script>location='".base_url()."admin/jadwal';</script>";
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
		$r4A        = $this->m_monitoring->getJlhTemuan4A($kd_lok_audit, $kd_dept_audit, $tgl_audit)->result();
		
		
		// RINGKAS
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

		// RAPI
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

		// RESIK
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

		// RAWAT
		if (count($r4A) == 0) {
			$r4AT = 0;
		} else {	
			if($r4A[0]->kode_pt == 1) {
				$r4AT = 0;
			} else if($r4A[0]->kode_pt == 2) {
				$r4AT = 1;
			} else if($r4A[0]->kode_pt == 3) {
				$r4AT = 2;
			} else if($r4A[0]->kode_pt == 4) {
				$r4AT = 3;
			} else {
				$r4AT = 4;
			}
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
		$data['ranking'] = $this->m_admin->getRanking('s_mst.tb_ranking', 's_mst.tb_dept')->result();
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
			$r4A[$i] = $this->m_monitoring->getJlhTemuan4A($area, $row->id_dept, $periode)->result();

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

			if (count($r4A[$i]) == 0) {
				$r4AT[$i] = 0;
			}
			
			if($r4A[$i][0]->kode_pt == 1) {
				$r4AT[$i] = 0;
			} else if($r4A[$i][0]->kode_pt == 2) {
				$r4AT[$i] = 1;
			} else if($r4A[$i][0]->kode_pt == 3) {
				$r4AT[$i] = 2;
			} else if($r4A[$i][0]->kode_pt == 4) {
				$r4AT[$i] = 3;
			} else {
				$r4AT[$i] = 4;
			}
			

			// cek updated temuan terakhir
			$whereDateClose[$i] = array(
				'kd_lok_audit'  => $area,
				'periode'       => $periode,
				'kd_dept_audit' => $row->id_dept,
			);

			// get jlh temuan open per auditie
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


	// fungsi untuk generate data pareto temuan
	public function pareto(){
		date_default_timezone_set("Asia/Jakarta");
		$app_url  = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ? "https" : "http");
		$app_url .= "://" . $_SERVER['HTTP_HOST'];
		$data['SITE_URL']= $app_url;

		$data['title'] = "Audit 5R | Pareto Temuan Page";
		$par_temuan    = $this->m_admin->get('s_mst.tb_par_temuan')->result();

		if(isset($_POST['periode'])){
			$periode       = $this->input->post("periode");
			$wherePeriode  = array('periode' => $periode);
			$cekPareto     = $this->m_admin->getWhere('s_mst.tb_pareto',$wherePeriode)->result();
			if (count($cekPareto) > 0) {
				// loop untuk set jumlah temuan tiap kode temuan

				$i = 0;
				foreach ($par_temuan as $pt){
					$wherePer[$i]  = array(
						'kd_partem'   => $pt->id_pt,
						'periode'     => $periode,
					);

					$jlh_tem[$i] = $this->m_admin->getPareto('s_mst.tb_audit', $pt->id_pt, $periode)->result();
					$par[$i]     = $jlh_tem[$i][0]->total;
					if ($par[$i] === null) {
						$par[$i] = 0;
					}
		
					$data_pareto[$i] = array(
						'kat_form'    => $pt->kd_form,
						'kat_5r'      => $pt->kd_5r,
						'aspek'       => $pt->kd_aspek,
						'desk_partem' => $pt->desk_pt,
						'jumlah'      => $par[$i],
						'periode'     => $periode,
						'kd_partem'   => $pt->id_pt,
					);
					$this->m_admin->updateData('s_mst.tb_pareto', $data_pareto[$i], $wherePer[$i]);			
				}
			} else {
				// loop untuk set jumlah temuan tiap kode temuan
				$i = 0;
				foreach ($par_temuan as $pt){
					$jlh_tem[$i] = $this->m_admin->getPareto('s_mst.tb_audit', $pt->id_pt, $periode)->result();
					$par[$i]     = $jlh_tem[$i][0]->total;
					if ($par[$i] === null) {
						$par[$i] = 0;
					}
		
					$data_pareto[$i] = array(
						'kat_form'    => $pt->kd_form,
						'kat_5r'      => $pt->kd_5r,
						'aspek'       => $pt->kd_aspek,
						'desk_partem' => $pt->desk_pt,
						'jumlah'      => $par[$i],
						'periode'     => $periode,
						'kd_partem'   => $pt->id_pt,
					);
		
					$this->m_admin->insertData('s_mst.tb_pareto', $data_pareto[$i]);			
				}
			}
		} else {
			$periode       = date('Y-m');
			$wherePeriode  = array('periode' => $periode);
			$cekPareto     = $this->m_admin->getWhere('s_mst.tb_pareto',$wherePeriode)->result();

			if (count($cekPareto) > 0) {
				// loop untuk set jumlah temuan tiap kode temuan

				$i = 0;
				foreach ($par_temuan as $pt){
					$wherePer[$i]  = array(
						'kd_partem'   => $pt->id_pt,
						'periode'     => $periode,
					);

					$jlh_tem[$i] = $this->m_admin->getPareto('s_mst.tb_audit', $pt->id_pt, $periode)->result();
					$par[$i]     = $jlh_tem[$i][0]->total;
					if ($par[$i] === null) {
						$par[$i] = 0;
					}
		
					$data_pareto[$i] = array(
						'kat_form'    => $pt->kd_form,
						'kat_5r'      => $pt->kd_5r,
						'aspek'       => $pt->kd_aspek,
						'desk_partem' => $pt->desk_pt,
						'jumlah'      => $par[$i],
						'periode'     => $periode,
						'kd_partem'   => $pt->id_pt,
					);
					$this->m_admin->updateData('s_mst.tb_pareto', $data_pareto[$i], $wherePer[$i]);			
				}
			} else {
				// loop untuk set jumlah temuan tiap kode temuan
				$i = 0;
				foreach ($par_temuan as $pt){
					$jlh_tem[$i] = $this->m_admin->getPareto('s_mst.tb_audit', $pt->id_pt, $periode)->result();
					$par[$i]     = $jlh_tem[$i][0]->total;
					if ($par[$i] === null) {
						$par[$i] = 0;
					}
		
					$data_pareto[$i] = array(
						'kat_form'    => $pt->kd_form,
						'kat_5r'      => $pt->kd_5r,
						'aspek'       => $pt->kd_aspek,
						'desk_partem' => $pt->desk_pt,
						'jumlah'      => $par[$i],
						'periode'     => $periode,
						'kd_partem'   => $pt->id_pt,
					);
		
					$this->m_admin->insertData('s_mst.tb_pareto', $data_pareto[$i]);
				}
			}
		}
		
		$aspek = ['A','B','C','A','B','C','A','B','C','A'];
		$kat5r = ['RINGKAS','RINGKAS','RINGKAS','RAPI','RAPI','RAPI','RESIK','RESIK','RESIK','RAWAT'];
		$data['periode'] = $periode;

		for ($i=0; $i < 10; $i++) { 
			$data['jlh_pareto'][$i] = $this->m_admin->getJlhPareto($aspek[$i],$kat5r[$i],$periode)->result();
		}

		$this->load->view('admin/v_pareto', $data);
	}

	// menampilkan halaman laporan tindak lanjut
	function tl() {
		$data['title'] = "Halaman Laporan Tindak Lanjut | Admin Audit";
		
		if(isset($_POST['periode'])){
			$periode       = $this->input->post("periode");
			$data['periode'] = $periode;

			$data['jlh_tb'] = $this->m_admin->getJlhTB($periode)->result(); //jlh temuan baru
			$data['jlh_os'] = $this->m_admin->getJlhOS($periode)->result(); //jlh temuan open sebelumnya
			$data['jlh_btl'] = $this->m_admin->getJlhBTL($periode)->result(); //jlh temuan belum tindak lanjut all
			$data['jlh_stl'] = $this->m_admin->getJlhSTL($periode)->result(); //jlh temuan sudah tindaklanjut all

			$data['jlh_stl_p'] = $this->m_admin->getJlhTSTL('PABRIK',$periode)->result(); //jlh temuan sudah tindak lanjut pabrik
			$data['jlh_stl_np'] = $this->m_admin->getJlhTSTL('NON-PABRIK',$periode)->result(); //jlh temuan sudah tindak lanjut non-pabrik
			$data['jlh_btl_p'] = $this->m_admin->getJlhTBTL('PABRIK',$periode)->result(); //jlh temuan sudah tindak lanjut pabrik
			$data['jlh_btl_np'] = $this->m_admin->getJlhTBTL('NON-PABRIK',$periode)->result(); //jlh temuan sudah tindak lanjut non-pabrik

			// data temuan yg pabrik dan non-pabrik yg belum ditindaklanjut
			$data['data_btl_p'] = $this->m_admin->getDataTBTL('PABRIK',$periode)->result();
			$data['data_btl_np'] = $this->m_admin->getDataTBTL('NON-PABRIK',$periode)->result();
			$data['data_stl_p'] = $this->m_admin->getDataTSTL('PABRIK',$periode)->result();
			$data['data_stl_np'] = $this->m_admin->getDataTSTL('NON-PABRIK',$periode)->result();
		} else {
			$periode = date('Y-m');
			$data['periode'] = $periode;

			$data['jlh_tb'] = $this->m_admin->getJlhTB($periode)->result(); //jlh temuan baru
			$data['jlh_os'] = $this->m_admin->getJlhOS($periode)->result(); //jlh temuan open sebelumnya
			$data['jlh_btl'] = $this->m_admin->getJlhBTL($periode)->result(); //jlh temuan open sebelumnya
			$data['jlh_stl'] = $this->m_admin->getJlhSTL($periode)->result(); //jlh temuan open sebelumnya

			$data['jlh_stl_p'] = $this->m_admin->getJlhTSTL('PABRIK',$periode)->result(); //jlh temuan sudah tindak lanjut pabrik
			$data['jlh_stl_np'] = $this->m_admin->getJlhTSTL('NON-PABRIK',$periode)->result(); //jlh temuan sudah tindak lanjut non-pabrik
			$data['jlh_btl_p'] = $this->m_admin->getJlhTBTL('PABRIK',$periode)->result(); //jlh temuan sudah tindak lanjut pabrik
			$data['jlh_btl_np'] = $this->m_admin->getJlhTBTL('NON-PABRIK',$periode)->result(); //jlh temuan sudah tindak lanjut non-pabrik

			// data temuan yg pabrik dan non-pabrik yg belum ditindaklanjut
			$data['data_tl_p'] = $this->m_admin->getDataTL('PABRIK',$periode)->result();
			$data['data_tl_np'] = $this->m_admin->getDataTL('NON-PABRIK',$periode)->result();
		}

		$this->load->view('admin/v_tl', $data);
	}

	// fungsi untuk mengirim jadwal audit yg belum dilakukan
	function sendJadwalBelum(){
		date_default_timezone_set("Asia/Jakarta");
		$periode = date('Y-m');
		$jadwal_belum = $this->m_admin->getJadwalBelumAudit($periode)->result();

		$id       = time();
		$iter = 1;
		$trx_type = "REMINDER JADWAL AUDIT 5R";
		foreach ($jadwal_belum as $row) {
			$data_notif[$iter] = array(
				'id'        => $id + $iter,
				'user'      => $row->nama,
				'no_wa'     => $row->no_wa,
				'tipe_trx'  => $trx_type,
				'deskripsi' => "Halo, $row->nama. Ucok informasikan saat ini anda belum melakukan Audit 5R periode: *$row->periode*, pada auditie: *$row->area_dept*, dengan anggota: *".str_replace(array('"','[',']'), '', $row->auditor)."*, tanggal: *$row->tgl_audit*. \nMohon agar segera melakukan audit sebelum periode *$periode* berakhir.\n\nTerima kasih.",
				'date'      => date("Y-m-d H:i:s"),
				'status'    => false
			);

			$insert = $this->m_admin->insert('s_wa.tb_notif',$data_notif[$iter]);
			if (!$insert) {
				$this->session->set_flashdata('error', "Gagal kirim notif. Ada kesalahan di sisi server. Error 500!");
				echo "<script>location='".base_url()."admin/jadwal';</script>";
				exit;
			}
			$iter++;
		}

		$this->session->set_flashdata('success', "Berhasil kirim notif Wa jadwal audit");
		echo "<script>location='".base_url()."admin/jadwal';</script>";
		exit;
	}


	// FUNGSI UNTUK EOP Temuan
	function eop(){
		date_default_timezone_set("Asia/Jakarta");
		$periode = new DateTime(date('Y-m'));
		$periode->modify('-1 month');
		$cutoff  = $periode->format('Y-m');

		$where_eop = array('periode' => $cutoff);

		// cek apakah bulan ini sudah dilakukan EOP atau tidak
		$eop_bln = $this->m_admin->getWhere('s_tmp.tb_audit', $where_eop)->num_rows();
		if ($eop_bln > 0) {
			$msg = (object) [
				'status' => 400,
				'message' => 'EOP telah dilakukan. Silakan melakukan EOP di bulan berikutnya.',
			];
			echo json_encode($msg);
			exit;
		}

		// insert data cutoff ke tabel log dan tmp
		$insert_tmp = $this->m_admin->insertTmpTemuanCutOff('s_mst.tb_audit', $cutoff);
		$insert_log = $this->m_admin->insertLogTemuanCutOff('s_log.tb_audit', 's_mst.tb_audit', $cutoff);

		if ($insert_log && $insert_tmp) {
			$audit_temp = $this->m_admin->get('s_tmp.tb_audit')->result();
			$at_jlm = $this->m_admin->get('s_tmp.tb_audit')->num_rows();
			if ($at_jlm < 1) {
				$msg = (object) [
					'status' => 400,
					'message' => 'Data Kosong.',
				];
				echo json_encode($msg);
				exit;
			}

			$whCounter  = array('id' => 1);
			foreach ($audit_temp as $key) {
				// ambil data id_audit terakhir
				$id_current = $this->m_admin->get('s_mst.tb_counter')->result();
				$id_aud     = $id_current[0]->counter + 1;
				$data_audit = array(
					'id_audit'      => $id_aud,
					'kd_lok_audit'  => $key->kd_lok_audit,
					'tgl_audit'     => date('Y-m').'-10',
					'kd_5r_audit'   => $key->kd_5r_audit,
					'kd_atem_audit' => $key->kd_atem_audit,
					'kd_tem_audit'  => $key->kd_tem_audit,
					'ket_audit'     => $key->ket_audit,
					'jlh_tem_audit' => $key->jlh_tem_audit,
					'gambar'        => $key->gambar,
					'user_audit'    => $key->user_audit,
					'kd_dept_audit' => $key->kd_dept_audit,
					'status'        => $key->status,
					'tim_audit'     => $key->tim_audit,
					'gambar_sesudah'=> $key->gambar_sesudah,
					'updated'       => date("Y-m-d"),
					'periode'       => date("Y-m"),
					'otorisasi'     => $key->otorisasi,
					'bagian_dept'   => $key->bagian_dept,
				);
		
				$response = $this->m_admin->insert('s_mst.tb_audit',$data_audit);
				// close temuan
				$status = array('status' => 'true');
				$whAudit = array('id_audit' => $key->id_audit);
				$this->m_admin->updateData('s_mst.tb_audit', $status, $whAudit);
				
				// update counter
				$data_id = array('counter' => $id_aud);
				$this->m_admin->updateData('s_mst.tb_counter', $data_id, $whCounter);
			}

			if ($response) {
				$msg = (object) [
					'status' => 200,
					'message' => 'Berhasil End Of Periode.',
				];
				echo json_encode($msg);
			} else {
				$msg = (object)[
					'status' => 500,
					'message' => 'Gagal End Of Periode.!'.$response
				];
				echo json_encode($msg);
			}
			
		} else {
			// kirim notif bahwa gagal duplikasi cutoff
			$msg = (object)[
				'status' => 400,
				'message' => 'Gagal Duplikasi Temuan End Of Periode.!'.$insert_log
			];
			echo json_encode($msg);
		}
 
	}

















/**===================================================================================================================================================
 * ===================================================================================================================================================
 */
	// fungsi untuk mengirim jadwal audit yg belum dilakukan
	function SendNotifWA(){
		date_default_timezone_set("Asia/Jakarta");
		$data_wa = $this->m_admin->getDataWa()->result();

		$id       = time();
		$iter = 1;
		$trx_type = "PERUBAHAN ALAMAT WEB AUDIT 5R";
		foreach ($data_wa as $row) {
			$data_notif[$iter] = array(
				'id'        => $id + $iter,
				'user'      => $row->nama,
				'no_wa'     => $row->no_wa,
				'tipe_trx'  => $trx_type,
				'deskripsi' => "Ucok informasikan saat ini ada perubahan alamat web audit 5R menjadi:\nhttp://103.247.123.64:8346/audit/\n\natau melalui jaringan lokal:\nhttp://192.168.10.13:8346/audit\n\nTerima kasih.",
				'date'      => date("Y-m-d H:i:s"),
				'status'    => false
			);

			$insert = $this->m_admin->insert('s_wa.tb_notif',$data_notif[$iter]);
			if (!$insert) {
				$this->session->set_flashdata('error', "Gagal kirim notif. Ada kesalahan di sisi server. Error 500!");
				echo "<script>location='".base_url()."admin/jadwal';</script>";
				exit;
			}
			$iter++;
		}

		echo "berhasil";
	}



	// Menampilkan Data Log
	public function log(){
		$data['title'] = "Data Log | Audit 5R";
		$data['log']   = $this->m_admin->getLog('s_log.tb_log')->result();
		$this->load->view('admin/v_log', $data);
	}


}