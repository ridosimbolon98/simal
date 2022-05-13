<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @author Rido
 */

class User extends CI_Controller {
	function __construct(){
		parent::__construct();

		if ($this->session->userdata('level') != "user") {
			echo "<script>alert('Anda dilarang akses halaman ini tanpa autentikasi');</script>";
			echo "<script>location='".base_url()."auth';</script>";
		} else {
			$this->load->helper('url');
			$this->load->model('m_auth');
			$this->load->model('m_home');
			$this->load->model('m_user');
			$this->load->model('m_log');
		}		
	}

	function index(){
		$app_url  = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ? "https" : "http");
		$app_url .= "://" . $_SERVER['HTTP_HOST'];
		$data['SITE_URL']= $app_url;

		$data['title'] = "Audit 5R | User Page";
        $data['id_user'] = $this->session->userdata('user_id');
        $whereUserId   = array('id_user' => $data['id_user']);
        $data['user']  = $this->m_user->getUserById('s_mst.tb_user', 's_mst.tb_dept',$whereUserId)->result();
		$data['area']  = $data['user'][0]->kat_dept;
		$bagian        = $this->session->userdata('bagian');
		$dept          = $this->session->userdata('dept');
		$where         = array(
			's_mst.tb_audit.bagian_dept' => $dept,
			'otorisasi'   => 'SUDAH',
		);

		$whereAud           = array('bagian_dept' => $dept, 'status' => false, 'otorisasi' => 'BELUM');

		$data['jlh_otor'] = $this->m_user->getWhere('s_mst.tb_audit', $whereAud)->num_rows();
        $data['jlh_refa'] = $this->m_user->getRefOtherNum($dept)->num_rows();

		$data['dept']      = $this->m_user->getDept('s_mst.tb_dept')->result();
		$data['audit']     = $this->m_user->getAllAudit('s_mst.tb_audit', 's_mst.tb_dept', 's_mst.tb_aspek', 's_mst.tb_par_temuan', $where)->result();
		$this->load->view('user/v_index', $data);
	}

	// ambil data gambar
	public function getImg(){
		$id = $this->input->post('data');
		$where = array(
			'id_audit' => $id
		);
 
		$data = $this->m_user->getWhere('s_mst.tb_audit', $where)->result();
		echo json_encode($data[0]->gambar);
	}

	// ambil data gambar
	public function getImgSesudah(){
		$id = $this->input->post('data');
		$where = array(
			'id_audit' => $id
		);
 
		$data = $this->m_user->getWhere('s_mst.tb_audit', $where)->result();
		echo json_encode($data[0]->gambar_sesudah);
	}

	// menampilkan halaman data temuan referensi
	function ref_audit(){
		$app_url           = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ? "https" : "http");
		$app_url          .= "://" . $_SERVER['HTTP_HOST'];
		$data['SITE_URL']  = $app_url;
		
		$data['title']     = "Audit 5R | Temuan Referensi Page";
        $kd_dept           = $this->session->userdata('bagian');
        $whereDept         = array('id_dept' => $kd_dept);
		$dept_user         = $this->m_user->getWhere('s_mst.tb_dept', $whereDept)->result();
		$where             = array('dept_ref' => $dept_user[0]->bagian_dept);
        $data['ref_audit'] = $this->m_user->getRefAudit('s_mst.tb_referensi', 's_mst.tb_audit', 's_mst.tb_dept', 's_mst.tb_aspek', 's_mst.tb_par_temuan', $where)->result();
		$this->load->view('user/v_ref_audit', $data);
	}

	// menampilkan halaman data temuan referensi
	function ref_temuan(){
		$app_url           = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ? "https" : "http");
		$app_url          .= "://" . $_SERVER['HTTP_HOST'];
		$data['SITE_URL']  = $app_url;
		
		$data['title']     = "Audit 5R | Temuan Referensi Page";
        $kd_dept           = $this->session->userdata('bagian');
        $dept              = $this->session->userdata('dept');
		$where             = array('s_mst.tb_audit.bagian_dept' => $dept, 'status_ref' => false);
        $data['ref_audit'] = $this->m_user->getRefAudit('s_mst.tb_referensi', 's_mst.tb_audit', 's_mst.tb_dept', 's_mst.tb_aspek', 's_mst.tb_par_temuan', $where)->result();
		$this->load->view('user/v_ref_temuan', $data);
	}

	// Tambah data referensi temuan
	function add_ref(){
		$this->load->helper('string');
		date_default_timezone_set("Asia/Jakarta");
		$app_url           = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ? "https" : "http");
		$app_url          .= "://" . $_SERVER['HTTP_HOST'];
		$data['SITE_URL']  = $app_url;

		$id_audit   = $this->input->post('id_audit');
		$bagian_ref = $this->input->post('referensi');
		$alasan     = $this->input->post('alasan');
		$token      = strtoupper(random_string('alnum', 3));
		$kd_ref     = 'RF'.date('Ymdhi').$token;

		// cek apakah sudah ada temuan ref dibagian dgn id audit terssebut
		$whereRef   = array (
			'id_audit' => $id_audit,
			'dept_ref' => $bagian_ref,
		);
		$isRef      = $this->m_user->getWhere('s_mst.tb_referensi', $whereRef)->result();
		if (count($isRef) > 0) {
			$this->session->set_flashdata('warning', "Gagal tambah referensi audit. ID Audit: $id_audit dan Referensi Bagian: $bagian_ref, sudah ada di sistem.");
			echo "<script>location='".base_url()."user';</script>";
			exit;
		}

		$data_ref   = array(
			'kd_ref'     => $kd_ref,
			'id_audit'   => $id_audit,
			'dept_ref'   => $bagian_ref,
			'deskripsi'  => '',
			'status_ref' => false,
			'updated'    => date("Y-m-d H:i:s"),
			'alasan_ref' => $alasan,
		);

		$insert_ref = $this->m_user->insert('s_mst.tb_referensi', $data_ref);
		if ($insert_ref){
			$log_type = 'insert';
			$log_desc = "Tambah data referensi temuan audit id: ".$id_audit.", referensi: ".$bagian_ref;
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
			$this->session->set_flashdata('success', "Berhasil tambah referensi audit.");
			redirect(base_url('user'));
		} else{
			$this->session->set_flashdata('error', "Gagal tambah referensi audit. Ada kesalahan di server!");
			echo "<script>location='".base_url()."user';</script>";
			exit;
		}
	}

	// Fungsi untuk update progress temuan referensi
	function update_ref(){
		$kd_ref    = $this->input->post('kd_ref');
		$deskripsi = $this->input->post('deskripsi');

		$whereRef  = array('kd_ref' => $kd_ref); 

		$data_ref  = array(
			'deskripsi'  => $deskripsi,
			'updated'    => date("Y-m-d H:i:s"),
		);

		$update_ref = $this->m_user->updateData('s_mst.tb_referensi', $data_ref, $whereRef);
		if ($update_ref){
			$log_type = 'update';
			$log_desc = "Update data progress perbaikan referensi temuan audit KD: ".$kd_ref;
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
			$this->session->set_flashdata('success', "Berhasil update progress referensi audit.");
			redirect(base_url('user'));
		} else{
			$this->session->set_flashdata('error', "Gagal update progress referensi audit. Ada kesalahan di server!");
			echo "<script>location='".base_url()."user';</script>";
			exit;
		}
	}

	// fungsi untuk close referensi temuan
	function close_ref($kd_ref){
		date_default_timezone_set("Asia/Jakarta");
		$data_ref = array(
			'status_ref' => true,
			'updated'    => date("Y-m-d H:i:s"),
		);
		$where    = array('kd_ref' => $kd_ref);
		$update_ref = $this->m_user->updateData('s_mst.tb_referensi', $data_ref, $where);
		if ($update_ref){
			$log_type = 'update';
			$log_desc = "Close Temuan Referensi Audit KD: $kd_ref";
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
			$this->session->set_flashdata('success', "Berhasil close temuan referensi audit kode: $kd_ref.");
			redirect(base_url('user'));
		} else{
			$this->session->set_flashdata('error', "Gagal close temuan referensi audit kode: $kd_ref. Ada kesalahan di server!");
			echo "<script>location='".base_url()."user';</script>";
			exit;
		}
	}

	// menampilkan data jadwal audit bagian
	function jadwal(){
		$data['title'] = "Audit 5R | Jadwal Audit Page";
        $bagian        = $this->session->userdata('bagian');
        $whereDept     = array('id_dept' => $bagian);
        $data['dept']  = $this->m_user->getWhere('s_mst.tb_dept', $whereDept)->result();
		$auditee       = $data['dept'][0]->section;
        $data['jadwal']= $this->m_user->getJA($auditee)->result();
		
		$this->load->view('user/v_jadwal', $data);
	}

	// Fungsi untuk menampilkan Laporan Ketidaksesuaian Bagian
	function lk(){
		$app_url  = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ? "https" : "http");
		$app_url .= "://" . $_SERVER['HTTP_HOST'];
		$data['SITE_URL']= $app_url;

		$data['title'] = "Audit 5R | Lap Ketidaksesuaian Page";
		$id_dept       = $this->session->userdata('bagian');
		$dept          = $this->session->userdata('dept');
        $where         = array('s_mst.tb_audit.bagian_dept' => $dept, 'otorisasi' => 'SUDAH');
        $where2        = array('id_dept' => $id_dept);
        $data['dept']  = $this->m_user->getWhere('s_mst.tb_dept', $where2)->result();
		$data['area']  = $data['dept'][0]->kat_dept;
        $data['audit'] = $this->m_user->getAllAudit('s_mst.tb_audit', 's_mst.tb_dept', 's_mst.tb_aspek', 's_mst.tb_par_temuan', $where)->result();
		$this->load->view('user/v_lk', $data);
	}

	// Menampilkan data audit yg belum diotorisasi
	function otorisasi(){
		$app_url  = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ? "https" : "http");
		$app_url .= "://" . $_SERVER['HTTP_HOST'];
		$data['SITE_URL']= $app_url;

		date_default_timezone_set("Asia/Jakarta");
		$data['title'] = "Audit 5R | Otorisasi Audit Page";

        $userid        = $this->session->userdata('user_id');
        $bagian        = $this->session->userdata('bagian');
        $dept          = $this->session->userdata('dept');
		$whereAudit    = array(
			'tgl_audit'     => date('Y-m-d'),
			's_mst.tb_audit.bagian_dept' => $dept,
			'status'        => false,
			'otorisasi'     => 'BELUM',
		);

		$whereRef           = array('s_mst.tb_audit.bagian_dept' => $dept, 'status_ref' => false);
		$whereAud           = array('bagian_dept' => $dept, 'status' => false, 'otorisasi' => 'BELUM');

		$data['jlh_otor'] = $this->m_user->getWhere('s_mst.tb_audit', $whereAud)->num_rows();
        $data['jlh_refa'] = $this->m_user->getRefAudit('s_mst.tb_referensi', 's_mst.tb_audit', 's_mst.tb_dept', 's_mst.tb_aspek', 's_mst.tb_par_temuan', $whereRef)->num_rows();

		$data['audit']    = $this->m_user->getAllAudit('s_mst.tb_audit', 's_mst.tb_dept', 's_mst.tb_aspek', 's_mst.tb_par_temuan', $whereAudit)->result();
		$this->load->view('user/v_otorisasi', $data);
	}

	// untuk otorisasi data audit per bagian per hari itu
	function otorAudit(){
		$app_url  = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ? "https" : "http");
		$app_url .= "://" . $_SERVER['HTTP_HOST'];
		$data['SITE_URL']= $app_url;

		date_default_timezone_set("Asia/Jakarta");
		$data['title'] = "Audit 5R | Otorisasi Audit Page";
        $userid        = $this->session->userdata('user_id');
        $bagian        = $this->session->userdata('bagian');
        $dept          = $this->session->userdata('dept');
		$whereAudit    = array(
			'tgl_audit'     => date('Y-m-d'),
			's_mst.tb_audit.bagian_dept' => $dept,
			'status'        => false,
			'otorisasi'     => 'BELUM',
		);

		$whereJA = array(
			'auditee' => $bagian,
			'periode' => date('Y-m'),
		);

		$data_otor = array('otorisasi' => 'SUDAH');
		$data_ja   = array('realisasi' => true);

		$dataOtor = $this->m_user->getAllAudit('s_mst.tb_audit', 's_mst.tb_dept', 's_mst.tb_aspek', 's_mst.tb_par_temuan', $whereAudit)->result();

		// lakukan otorisasi
		foreach ($dataOtor as $row) {
			$where[$row->id_audit] = array('id_audit' => $row->id_audit);
			$update = $this->m_user->updateData('s_mst.tb_audit', $data_otor,  $where[$row->id_audit]);

			if ($update) {
				$this->session->set_flashdata('success', "Berhasil otorisasi data audit.");
			} else {
				$this->session->set_flashdata('error', "Gagal otorisasi data audit. Ada kesalahan di server!");
			}
		}

		if ($update){
			// LAKUKAN REALISASI JADWAL AUDIT
			$isRealisasi = $this->m_user->updateData('s_mst.tb_jadwal', $data_ja, $whereJA);
			if (!$isRealisasi) {
				$this->session->set_flashdata('isrealisasi', "Gagal update realisasi jadwal.");
			}

			$log_type = 'update';
			$log_desc = "Otorisasi Audit Periode:".date("Y-m-d")."By User";
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
			$this->session->set_flashdata('success', "Berhasil otorisasi data audit.");
			redirect(base_url('user'));
		} else{
			$this->session->set_flashdata('error', "Gagal otorisasi data audit. Ada kesalahan di server!");
			echo "<script>location='".base_url()."user';</script>";
			exit;
		}
	}

	// Fungsi untuk hapus data audit yang tidak sesudai oleh user
	function del_audit($id_audit){
		$this->load->helper('file');
		$app_url  = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ? "https" : "http");
		$app_url .= "://" . $_SERVER['HTTP_HOST'];
		$data['SITE_URL']= $app_url;

		$where      = array('id_audit' => $id_audit);
		$data_audit = $this->m_user->get('s_mst.tb_audit', $where)->result();
		$gbr_awal   = $data_audit[0]->gambar;
		$gbr_ssdh   = $data_audit[0]->gambar_sesudah;

		// delete gambar awal dari server
		for ($i=0; $i < count(json_decode($gbr_awal, true)) ; $i++) { 
			unlink($_SERVER['DOCUMENT_ROOT'].'/temuan_audit/'.json_decode($gbr_awal, true)[$i]);
		}

		// delete gambar sesudah dari server
		for ($i=0; $i < count(json_decode($gbr_ssdh, true)) ; $i++) { 
			unlink($_SERVER['DOCUMENT_ROOT'].'/temuan_audit/'.json_decode($gbr_ssdh, true)[$i]);
		}

		// delete data audit dari database
		$delete = $this->m_user->delete('s_mst.tb_audit', $where);
		if ($delete){
			$log_type = 'delete';
			$log_desc = "Hapus Data Audit ID: $id_audit";
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
			$this->session->set_flashdata('success', "Berhasil hapus data audit ID: $id_audit.");
			redirect(base_url('user/otorisasi'));
		} else{
			$this->session->set_flashdata('error', "Gagal hapus data audit ID: $id_audit. Ada kesalahan di server!");
			echo "<script>location='".base_url()."user/otorisasi';</script>";
			exit;
		}
	}

    // Fungsi untuk update gambar sesudah
    function update_gbr(){
		$app_url  = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ? "https" : "http");
		$app_url .= "://" . $_SERVER['HTTP_HOST'];
		$data['SITE_URL']= $app_url;

		date_default_timezone_set("Asia/Jakarta");
        $id_audit = $this->input->post('id_audit');
		$jumlah   = count($_FILES['files']['name']);

		// cek apakah data audit sudah close
		$isClosed  = array('id_audit' => $id_audit, 'status' => 't');
		$dataAudit = $this->m_user->getWhere('s_mst.tb_audit', $isClosed)->num_rows();
		if ($dataAudit > 0) {
			$this->session->set_flashdata('error', "Gagal update gambar sesudah audit ID: $id_audit. Temuan audit sudah di closed!");
			echo "<script>location='".base_url()."user/lk';</script>";
			exit;
		}

		for ($i=0; $i < $jumlah; $i++) {
			$_FILES['file']['name']     = $_FILES['files']['name'][$i];
			$_FILES['file']['type']     = $_FILES['files']['type'][$i];
			$_FILES['file']['tmp_name'] = $_FILES['files']['tmp_name'][$i];
			$_FILES['file']['error']    = $_FILES['files']['error'][$i];
			$_FILES['file']['size']     = $_FILES['files']['size'][$i];

			$config['upload_path']   = $_SERVER['DOCUMENT_ROOT'].'/temuan_audit';
			$config['allowed_types'] = 'jpg|png|jpeg';
			$config['remove_space']  = TRUE;
			$config['file_name']     = $_FILES['files']['name'][$i];
			$this->load->library('upload',$config);
	
			if($this->upload->do_upload('file')){
				$fileUpload   = $this->upload->data();
				$data_gbr[$i]['file_name'] = $fileUpload['file_name'];
			} else {
				$error = array('error' => $this->upload->display_errors());
				echo "<pre>";
				print_r($error);
				echo "</pre>";
			}
			$data_gbr[$i] = $data_gbr[$i]['file_name'];
		}

		$data_update = array(
			'gambar_sesudah' => json_encode($data_gbr),
		);
		$whereUpd = array('id_audit' => $id_audit);
		$update = $this->m_user->updateData('s_mst.tb_audit', $data_update, $whereUpd);

		if ($update){
			$log_type = 'update';
			$log_desc = "Update Gambar Sesudah Data Audit ID: $id_audit, By User";
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
			$this->session->set_flashdata('success', "Berhasil submit gambar sesudah audit ID: $id_audit.");
			redirect(base_url('user/lk'));
		} else {
			$this->session->set_flashdata('error', "Gagal submit gambar sesudah audit ID: $id_audit.");
			echo "<script>location='".base_url()."user/lk';</script>";
			exit;
		}
    }

	// menampilkan halaman detail temuan per id
	function detail_temuan($id_audit){
		$app_url  = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ? "https" : "http");
		$app_url .= "://" . $_SERVER['HTTP_HOST'];
		$data['SITE_URL']= $app_url;

		$data['title']  = "User Audit | Detail Temuan Audit 5R";
		$data['id_user']= $this->session->userdata('user_id');
        $whereUserId    = array('id_user' => $data['id_user']);
		$data['user']   = $this->m_user->getUserById('s_mst.tb_user', 's_mst.tb_dept',$whereUserId)->result();
		$data['area']   = $data['user'][0]->kat_dept;
		$where          = array('id_audit' => $id_audit);

		$data['temuan'] = $this->m_user->getAuditPerID('s_mst.tb_audit', 's_mst.tb_dept', 's_mst.tb_aspek', 's_mst.tb_par_temuan', $where)->result();
		$this->load->view('user/v_detail_temuan', $data);
	}

	// menampilkan halaman detail temuan per id
	function detail_tref($kd_ref){
		$app_url  = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ? "https" : "http");
		$app_url .= "://" . $_SERVER['HTTP_HOST'];
		$data['SITE_URL']= $app_url;

		$data['title']  = "User Audit | Detail Temuan Referensi Audit 5R";
		$data['id_user']= $this->session->userdata('user_id');
        $whereUserId    = array('id_user' => $data['id_user']);
		$data['user']   = $this->m_user->getUserById('s_mst.tb_user', 's_mst.tb_dept',$whereUserId)->result();
		$data['area']   = $data['user'][0]->kat_dept;

		$where          = array('kd_ref' => $kd_ref);
		$data['temuan'] = $this->m_user->getRefAudit('s_mst.tb_referensi', 's_mst.tb_audit', 's_mst.tb_dept', 's_mst.tb_aspek', 's_mst.tb_par_temuan', $where)->result();
		$this->load->view('user/v_detail_ref', $data);
	}

	// fungsi untuk menampilkan data ranking user
	function ranking(){
		$app_url  = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ? "https" : "http");
		$app_url .= "://" . $_SERVER['HTTP_HOST'];
		$data['SITE_URL']= $app_url;

		$data['title']   = "User Audit | Data Ranking Audit 5R";
		$data['dept']    = $this->session->userdata('dept');
		$data['id_user'] = $this->session->userdata('user_id');
		$whereUserId     = array('id_user' => $data['id_user']);
		$data['user']    = $this->m_user->getUserById('s_mst.tb_user', 's_mst.tb_dept',$whereUserId)->result();
		$data['area']    = $data['user'][0]->kat_dept;
		$where           = array(
			'nama_dep'   => $data['dept'],
		);
		$data['ranking'] = $this->m_user->getWhere('s_mst.tb_ranking', $where)->result();
		$this->load->view('user/v_ranking', $data);
	}

}