<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @author Rido
 */

class Auditor extends CI_Controller {
	function __construct(){
		parent::__construct();

		if ($this->session->userdata('level') != "auditor") {
			echo "<script>alert('Anda dilarang akses halaman ini tanpa autentikasi');</script>";
			echo "<script>location='".base_url()."auth';</script>";
		} else {
			$this->load->helper('url');
			$this->load->model('m_auth');
			$this->load->model('m_auditor');
			$this->load->model('m_log');
		}		
	}

	function index(){
		$app_url  = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ? "https" : "http");
		$app_url .= "://" . $_SERVER['HTTP_HOST'];
		$data['SITE_URL']= $app_url;
		
		$data['title']   = "Audit 5R | Dashboard Auditor Page";
		$userid          = $this->session->userdata("user_id");

		// cek apakah ada inputan periode
		$periode         = $this->input->post('periode');
		if (isset($periode)) {
			$data['periode'] = $periode;
			$where           = array (
				'user_audit' => $userid,
				'periode'    => $periode,
			);

			// ambil data audit yg diaudit oleh auditor di session ini pd periode tertentu
			$data['audit'] = $this->m_auditor->getAuditByAuditor('s_mst.tb_audit', 's_mst.tb_dept', 's_mst.tb_aspek', 's_mst.tb_par_temuan', $where)->result();
			$this->load->view('auditor/v_audit', $data);
		} else {
			$data['periode'] = "----/--";
			$data['audit']   = null;
			$this->session->set_flashdata('warning', "Silakan filter periode audit terlebih dahulu!");
			$this->load->view('auditor/v_audit', $data);
		}
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

		$update_rekom  = $this->m_auditor->updateData('s_mst.tb_audit', $data_ur,$where);
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
			echo "<script>location='".base_url()."auditor';</script>";
		} else{
			$this->session->set_flashdata('error', "Gagal update rekomendasi untuk data audit id: $id_audit, pada auditee: $id_dep");
			echo "<script>location='".base_url()."auditor';</script>";
			exit;
		}	
	}

	// Fungsi untuk close data audit
	function close_audit($id_audit){
		$app_url  = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ? "https" : "http");
		$app_url .= "://" . $_SERVER['HTTP_HOST'];
		$data['SITE_URL']= $app_url;

		$data['title'] = "Audit 5R | Auditor Page";
		$where         = array('id_audit' => $id_audit);
		$data_status   = array('status' => true);

		$data_audit    = $this->m_auditor->getWhere('s_mst.tb_audit', $where)->result();
		// cek apakah gambar sesudah sudah diupload oleh auditte
		if ($data_audit[0]->gambar_sesudah == 0) {
			$this->session->set_flashdata('error', "Gagal close untuk data audit id: $id_audit. User auditee terkait belum upload gambar sesudah audit. Silakan di follow up ke user terkait!");
			echo "<script>location='".base_url()."auditor';</script>";
			exit;
		}

		$update_audit  = $this->m_auditor->updateData('s_mst.tb_audit', $data_status, $where);
		if ($update_audit){
			$log_type = 'update';
			$log_desc = 'Ubah Data Status Temuan Audit id: '.$id_audit.', jadi TRUE';
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
			$this->session->set_flashdata('success', "Berhasil update status untuk data audit id: $id_audit");
			echo "<script>location='".base_url()."auditor';</script>";
		} else{
			$this->session->set_flashdata('error', "Gagal update rekomendasi untuk data audit id: $id_audit");
			echo "<script>location='".base_url()."auditor';</script>";
			exit;
		}
	}


	// menampilkan halaman anggota auditor
	function anggota(){
		$data['title']   = "Audit 5R | Data Auditor Page";
		$level           = $this->session->userdata("level");
		$userid          = $this->session->userdata("user_id");
		$where           = array ('id_koor' => $userid);

		$data['dept']    = $this->m_auditor->get('s_mst.tb_dept')->result();
		$data['auditor'] = $this->m_auditor->get('s_mst.tb_auditor')->result();
		$data['map_adt'] = $this->m_auditor->getMapAuditors('s_mst.tb_map_auditor','s_mst.tb_auditor', 's_mst.tb_user', $where)->result();
		$this->load->view('auditor/v_auditor', $data);
	}

	// FUNGSI UNTUK MENAMPILKAN HALAMAN JADWAL
	function jadwal(){
		$data['title']   = "Audit 5R | Data Jadwal Audit Page";
		$level           = $this->session->userdata("level");
		$userid          = $this->session->userdata("user_id");
		$where           = array ('auditor' => $userid);
		
		$data['jadwal']  = $this->m_auditor->getJadwal('s_mst.tb_jadwal','s_mst.tb_user','s_mst.tb_dept',$where)->result();
		$this->load->view('auditor/v_jadwal', $data);
	}


	function md5(){
		$this->load->view('auditor/md5');
	}


}