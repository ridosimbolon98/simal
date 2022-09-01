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

	// ambil data area berdasarkan temuan per auditor
	function index() {
		$data['title']   = "Audit 5R | Dashboard Auditor Page";
		$userid          = $this->session->userdata("user_id");

		// ambil data area
		$data['area'] = $this->m_auditor->getAreaByAuditor('s_mst.tb_audit', 's_mst.tb_dept', $userid)->result();

		$this->load->view('auditor/v_home', $data);
	}

	function data($id_dept){
		$app_url  = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ? "https" : "http");
		$app_url .= "://" . $_SERVER['HTTP_HOST'];
		$data['SITE_URL']= $app_url;
		
		$data['title']   = "Audit 5R | Dashboard Auditor Page";
		$data['id_dept'] = $id_dept;
		$userid          = $this->session->userdata("user_id");

		// cek apakah ada inputan periode
		$periode         = $this->input->post('periode');
		if (isset($periode)) {
			$data['periode'] = $periode;
			$where           = array (
				'user_audit' => $userid,
				'periode'    => $periode,
				'kd_dept_audit' => $id_dept
			);

			// ambil data audit yg diaudit oleh auditor di session ini pd periode tertentu
			$data['audit'] = $this->m_auditor->getAuditByAuditor('s_mst.tb_audit', 's_mst.tb_dept', 's_mst.tb_aspek', 's_mst.tb_par_temuan', $where)->result();
			$this->load->view('auditor/v_audit', $data);
		} else {
			$data['periode'] = date('Y-m');
			$where           = array (
				'user_audit' => $userid,
				'periode'    => $data['periode'],
				'kd_dept_audit' => $id_dept
			);

			// ambil data audit yg diaudit oleh auditor di session ini pd periode tertentu
			$data['audit'] = $this->m_auditor->getAuditByAuditor('s_mst.tb_audit', 's_mst.tb_dept', 's_mst.tb_aspek', 's_mst.tb_par_temuan', $where)->result();

			$this->session->set_flashdata('warning', "Silakan filter periode audit terlebih dahulu!");
			$this->load->view('auditor/v_audit', $data);
		}
	}

	function otorisasi(){
		$app_url  = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ? "https" : "http");
		$app_url .= "://" . $_SERVER['HTTP_HOST'];
		$data['SITE_URL']= $app_url;
		
		$data['title']   = "Audit 5R | Dashboard Auditor Page";
		$userid          = $this->session->userdata("user_id");

		$data['periode'] = date('Y-m');
		$where           = array (
			'user_audit' => $userid,
			'periode'    => $data['periode'],
			'otorisasi'  => 'BELUM',
		);

		// ambil data audit yg diaudit oleh auditor di session ini pd periode tertentu
		$data['audit'] = $this->m_auditor->getAuditByAuditor('s_mst.tb_audit', 's_mst.tb_dept', 's_mst.tb_aspek', 's_mst.tb_par_temuan', $where)->result();
		$this->load->view('auditor/v_today_audit', $data);
	}

	// delete data audit
	function del_audit($id_audit){
		$this->load->helper('file');
		$app_url  = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ? "https" : "http");
		$app_url .= "://" . $_SERVER['HTTP_HOST'];
		$data['SITE_URL']= $app_url;

		$where      = array('id_audit' => $id_audit);
		$data_audit = $this->m_auditor->get('s_mst.tb_audit', $where)->result();
		$gbr_awal   = $data_audit[0]->gambar;
		$gbr_ssdh   = $data_audit[0]->gambar_sesudah;

		// transfer to history audit
		$transfer = $this->m_auditor->insertLogAudit('s_log.tb_audit', 's_mst.tb_audit', $id_audit);
		if(!$transfer){
			$this->session->set_flashdata('error', "Gagal replikasi data audit ID: $id_audit. Silakan ulangi lagi");
			redirect(base_url('auditor/otorisasi'));
		}

		// delete data audit dari database
		$delete = $this->m_auditor->delete('s_mst.tb_audit', $where);
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
			redirect(base_url('auditor/otorisasi'));
		} else{
			$this->session->set_flashdata('error', "Gagal hapus data audit ID: $id_audit. Ada kesalahan di server!");
			echo "<script>location='".base_url()."auditor/otorisasi';</script>";
			exit;
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
			echo "<script>location='".base_url()."auditor/data/".$id_dep."';</script>";
		} else{
			$this->session->set_flashdata('error', "Gagal update rekomendasi untuk data audit id: $id_audit, pada auditee: $id_dep");
			echo "<script>location='".base_url()."auditor/data/".$id_dep."';</script>";
			exit;
		}	
	}

	// Fungsi untuk close data audit
	function close_audit(){
		$id_dept = $this->uri->segment(3);
		$id_audit = $this->uri->segment(4);

		date_default_timezone_set("Asia/Jakarta");
		$app_url  = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ? "https" : "http");
		$app_url .= "://" . $_SERVER['HTTP_HOST'];
		$data['SITE_URL']= $app_url;

		$data['title'] = "Audit 5R | Auditor Page";
		$date_close    = date("Y-m-d H:i:s");
		$where         = array('id_audit' => $id_audit);
		$data_status   = array('status' => true, 'date_close' => $date_close);

		$data_audit    = $this->m_auditor->getWhere('s_mst.tb_audit', $where)->result();
		// cek apakah gambar sesudah sudah diupload oleh auditte
		if ($data_audit[0]->gambar_sesudah == '0') {
			$this->session->set_flashdata('error', "Gagal close untuk data audit id: $id_audit. User auditee terkait belum upload gambar sesudah audit. Silakan di follow up ke user terkait!");
			echo "<script>location='".base_url()."auditor/data/".$id_dept."';</script>";
			exit;
		} else if ($data_audit[0]->otorisasi == 'BELUM') {
			// cek apakah data audit sudah diotorisasi
			$this->session->set_flashdata('error', "Gagal close untuk data audit id: $id_audit. User auditee terkait belum otorisasi data audit. Silakan di follow up ke user terkait!");
			echo "<script>location='".base_url()."auditor/data/".$id_dept."';</script>";
			exit;
		} else if ($data_audit[0]->status == 't') {
			// cek apakah temuan sudah close atau tidak
			$this->session->set_flashdata('error', "Gagal close untuk data audit id: $id_audit. Temuan audit sudah berstatus CLOSED!");
			echo "<script>location='".base_url()."auditor/data/".$id_dept."';</script>";
			exit;
		}
		

		$update_audit  = $this->m_auditor->updateData('s_mst.tb_audit', $data_status, $where);
		if ($update_audit){
			$log_type = 'update';
			$log_desc = 'Ubah Data Status Temuan Audit id: '.$id_audit.', jadi TRUE';
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
			$this->session->set_flashdata('success', "Berhasil update status untuk data audit id: $id_audit");
			echo "<script>location='".base_url()."auditor/data/".$id_dept."';</script>";
		} else{
			$this->session->set_flashdata('error', "Gagal update rekomendasi untuk data audit id: $id_audit");
			echo "<script>location='".base_url()."auditor/data/".$id_dept."';</script>";
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
		$where           = array ('koor' => $userid);
		
		$data['jadwal']  = $this->m_auditor->getWhere('s_tmp.tb_jadwal',$where)->result();
		$this->load->view('auditor/v_jadwal', $data);
	}

	// ambil data gambar
	public function getImg(){
		$id = $this->input->post('data');
		$where = array(
			'id_audit' => $id
		);
 
		$data = $this->m_auditor->getWhere('s_mst.tb_audit', $where)->result();
		echo json_encode($data[0]->gambar);
	}

	// ambil data gambar
	public function getImgSesudah(){
		$id = $this->input->post('data');
		$where = array(
			'id_audit' => $id
		);
 
		$data = $this->m_auditor->getWhere('s_mst.tb_audit', $where)->result();
		echo json_encode($data[0]->gambar_sesudah);
	}


	function md5(){
		$this->load->view('auditor/md5');
	}

	// sementara
	// Fungsi untuk update gambar sesudah
	function update_gbr(){
		$this->load->library('compress');
		
		$app_url  = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ? "https" : "http");
		$app_url .= "://" . $_SERVER['HTTP_HOST'];
		$data['SITE_URL']= $app_url;
		$username  = $this->session->userdata("username");

		date_default_timezone_set("Asia/Jakarta");
    $id_audit = $this->input->post('idaudit');
    $id_dept  = $this->input->post('iddept');
		$jumlah   = count($_FILES['files']['name']);
		
		$whereAud = array('id_audit' => $id_audit);

		// cek apakah data audit sudah close
		$isClosed   = array('id_audit' => $id_audit, 'status' => 't');
		$dataAudit  = $this->m_auditor->getWhere('s_mst.tb_audit', $isClosed)->num_rows();
		if ($dataAudit > 0) {
			$this->session->set_flashdata('error', "Gagal update gambar sesudah audit ID: $id_audit. Temuan audit sudah di closed!");
			echo "<script>location='".base_url()."auditor/data/".$id_dept."';</script>";
			exit;
		}
		
		for ($i=0; $i < $jumlah; $i++) {
			// config upload
			$root_folder             = $_SERVER['DOCUMENT_ROOT'].'/temuan_audit/';
			$imname[$i]              = $_FILES['files']['tmp_name'][$i];
			$source_photo[$i]        = $imname[$i];
			$namecreate[$i]          = "AUDIT5R_".$i."_".$id_audit."_".time();
			$namecreatenumber[$i]    = rand(1000 , 10000);
			$picname[$i]             = $namecreate[$i].$namecreatenumber[$i];
			$finalname[$i]           = $picname[$i].".jpeg";
			$dest_photo[$i]          = $root_folder.$finalname[$i];
			$compressimage[$i]       = $this->compress->compress_image($source_photo[$i], $dest_photo[$i], 60);

			if($compressimage[$i]){
				$data_gbr[$i]['file_name'] = $finalname[$i];
			} else {
				echo "<pre>";
				print_r('error upload gambar audit');
				echo "</pre>";
			}
			$data_gbr[$i] = $data_gbr[$i]['file_name'];
		}

		$data_update = array(
			'gambar' => json_encode($data_gbr),
		);
		$whereUpd = array('id_audit' => $id_audit);
		$update = $this->m_auditor->updateData('s_mst.tb_audit', $data_update, $whereUpd);

		if ($update){
			$log_type = 'insert';
			$log_desc = "Insert Gambar Temuan Audit ID: $id_audit, By User: $username";
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
			$this->session->set_flashdata('success', "Berhasil submit gambar temuan audit ID: $id_audit.");
			redirect(base_url('auditor/data/'.$id_dept));
		} else {
			$this->session->set_flashdata('error', "Gagal submit gambar sesudah audit ID: $id_audit.");
			echo "<script>location='".base_url()."auditor/data/".$id_dept."';</script>";
			exit;
		}
  }


	/**
	 * 
	 * ==============================================================================
	 * Fungsi untuk upload data file
	 */
	function cb() {
		$data['title'] = "Upload Multiple File";
		$this->load->view('auditor/upload', $data);
	}

	function upload(){
		$this->load->library('compress');
		if(isset($_FILES['file']))
		{
			for ($i=0; $i < count($_FILES['file']['name']); $i++) {
				// config upload
				$root_folder             = $_SERVER['DOCUMENT_ROOT'].'/temuan_audit/';
				$imname[$i]              = $_FILES['file']['tmp_name'][$i];
				$source_photo[$i]        = $imname[$i];
				$namecreate[$i]          = "AUDIT5R_".time();
				$namecreatenumber[$i]    = rand(1000 , 10000);
				$picname[$i]             = $namecreate[$i].$namecreatenumber[$i];
				$finalname[$i]           = $picname[$i].".jpeg";
				$dest_photo[$i]          = $root_folder.$finalname[$i];
				$compressimage[$i]       = $this->compress->compress_image($source_photo[$i], $dest_photo[$i], 60);
	
				if($compressimage[$i]){
					$data_gbr[$i]['file_name'] = $finalname[$i];
				} else {
					echo "<pre>";
					print_r('error upload gambar audit');
					echo "</pre>";
				}
				$data_gbr[$i] = $data_gbr[$i]['file_name'];
			}
			$this->session->set_flashdata('success', "Berhasil submit gambar temuan audit");
			$res = array('success'  => 'Multiple Image File Has Been uploaded Successfully');
			return json_encode($res);
		}
	}

}