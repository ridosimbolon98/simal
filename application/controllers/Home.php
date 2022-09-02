<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @author Rido
 */

class Home extends CI_Controller {
	function __construct(){
		parent::__construct();

		if ($this->session->userdata('level') != "auditor") {
			echo "<script>alert('Anda dilarang akses halaman ini tanpa autentikasi');</script>";
			echo "<script>location='".base_url()."auth';</script>";
		} else {
			$this->load->helper('url');
			$this->load->model('m_auth');
			$this->load->model('m_home');
			$this->load->model('m_log');
		}		
	}

	function index(){
		// hapus session audit
		$this->session->unset_userdata('lokasi');
		$this->session->unset_userdata('tim_audit');
		$this->session->unset_userdata('area');
		$this->session->unset_userdata('audit');

		$data['title']   = "Audit 5R | Form Audit Page";
		$userid          = $this->session->userdata("user_id");
		$where           = array('id_koor' => $userid);
		$data['area']    = $this->m_home->get('s_mst.tb_dept')->result();
		$data['auditor'] = $this->m_home->getAuditor('s_mst.tb_map_auditor','s_mst.tb_auditor', $where)->result();
		$this->load->view('auditor/v_index', $data);
	}

	function form(){
		$isAudit = $this->session->has_userdata('audit');
		if ($isAudit) {
			$lokasi        = $this->session->userdata("lokasi");
			$data['title'] = "Audit 5R-$lokasi| Form Audit Page";
			$this->load->view('auditor/v_form', $data);
		} else {
			if (!empty($_POST['area'])) {
				$auditor    = $this->input->post('tim_audit[]');
				$lokasi     = $this->input->post('lokasi');
				$area       = $this->input->post('area');
				$koor_audit = strtoupper($this->session->userdata("username"));
				array_push($auditor, $koor_audit);
				
				$audit_session  = array(
					'lokasi'    => $lokasi,
					'tim_audit' => json_encode($auditor),
					'area'      => $area,
					'audit'     => true,
				);
		
				// Mencatat log audit
				$this->session->set_userdata($audit_session);
				$data['title'] = "Audit 5R-$lokasi| Form Audit Page";
				$this->load->view('auditor/v_form', $data);
			} else {
				echo "<script>alert('Silakan pilih Tim Audit dan Area terlebih dahulu!');</script>";
				echo "<script>location='".base_url()."home';</script>";
				exit;
			}
		}
	}

	// Fungsi untuk menyimpan data tidak ada audit
	function formno(){
		$auditor        = $this->input->post('tim_audit2[]');
		$lokasi         = $this->input->post('lokasi2');
		$area           = $this->input->post('area2');
		$periode        = date('Y-m');
		$koor_audit     = strtoupper($this->session->userdata("username"));
		array_push($auditor, $koor_audit);

		$whereArea   = array('id_dept' => $area);
		$bagian_dept = $this->m_home->getWhere('s_mst.tb_dept', $whereArea)->result();
		
		$data_audit = array(
			'kd_lok_audit'  => $lokasi,
			'tgl_audit'     => date("Y-m-d"),
			'ket_audit'     => "TIDAK ADA TEMUAN",
			'user_audit'    => $this->session->userdata("user_id"),
			'kd_dept_audit' => $area,
			'status'        => false,
			'tim_audit'     => json_encode($auditor),
			'gambar_sesudah'=> '0',
			'updated'       => date("Y-m-d"),
			'periode'       => $periode,
			'otorisasi'     => 'BELUM',
			'bagian_dept'   => $bagian_dept[0]->bagian_dept,
		);

		$insert = $this->m_home->insert('s_mst.tb_audit',$data_audit);
		if ($insert){
			$log_type = 'insert';
			$log_desc = 'Tambah Data Audit Area: '.$area.', Lokasi: '.$lokasi;
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
			$this->session->set_flashdata('success', "Berhasil submit data audit tidak ada temuan.");
			redirect(base_url('home/'));
		} else{
			$this->session->set_flashdata('error', "Gagal submit data audit.");
			echo "<script>location='".base_url()."home/';</script>";
			exit;
		}
	}

	public function getArea(){
		$k_lok = $this->input->post('data1');
		$where = array(
			'kat_dept' => $k_lok
		);
 
		$data = $this->m_home->getWhere('s_mst.tb_dept', $where)->result();
		echo json_encode($data);
	}
	
	public function get_at(){
		$k_5r  = $this->input->post('data1');
		$k_lok = $this->input->post('data2');
		$where = array(
			'kat_5r' => $k_5r,
			'kd_form' => $k_lok
		);
 
		$data = $this->m_home->getFormSelect('s_mst.tb_aspek', $where)->result();
		echo json_encode($data);
	}

	public function get_kt(){
		$a_tem = $this->input->post('a_tem');
		$k_5r  = $this->input->post('k_5r');
		$k_lok = $this->input->post('k_lok');
		$where = array(
			'kd_aspek' => $a_tem,
			'kd_5r' => $k_5r,
			'kd_form' => $k_lok
		);
 
		$data = $this->m_home->getFormSelect('s_mst.tb_par_temuan', $where)->result();
		echo json_encode($data);
	}

	public function get_ta(){
		$k_lok = $this->input->post('data1');
		$where = array(
			'area_auditor' => $k_lok
		);
 
		$data = $this->m_home->getTASelect('s_mst.tb_auditor', 's_mst.tb_dept', $k_lok)->result();
		echo json_encode($data);
	}

	

	function send(){
		date_default_timezone_set("Asia/Jakarta");
		$this->load->library('compress');

		$lokasi        = $this->session->userdata("lokasi");
		$data['title'] = "Audit 5R-$lokasi| Form Audit Page";
		$data_gbr      = array();

		$k_lok   = $this->input->post('k_lok');
		$auditor = $this->session->userdata("tim_audit");
		$area    = $this->session->userdata("area");
		$periode = date('Y-m');
		$k_5r    = $this->input->post('k_5r');
		$a_tem   = $this->input->post('a_tem');
		$k_tem   = $this->input->post('k_tem');
		$ket     = $this->input->post('keterangan');
		$jlh_tem = $this->input->post('jlh_temuan');
		$jumlah  = count($_FILES['files']['name']);

		// ambil data id_audit terakhir
		$whCounter  = array('id' => 1);
		$id_current = $this->m_home->get('s_mst.tb_counter')->result();
		$id_aud     = $id_current[0]->counter + 1;

		for ($i=0; $i < $jumlah; $i++) {
			
			// config upload
			$root_folder             = $_SERVER['DOCUMENT_ROOT'].'/temuan_audit/';
			$imname[$i]              = $_FILES['files']['tmp_name'][$i];
			$source_photo[$i]        = $imname[$i];
			$namecreate[$i]          = "AUDIT5R_".$i."_".time();
			$namecreatenumber[$i]    = rand(1000 , 10000);
			$picname[$i]             = $namecreate[$i].$namecreatenumber[$i];
			$finalname[$i]           = $picname[$i].".jpeg";
			$dest_photo[$i]          = $root_folder.$finalname[$i];
			$compressimage[$i]       = $this->compress->compress_image($source_photo[$i], $dest_photo[$i], 60);

			if($compressimage[$i]){
				$data_gbr[$i]['file_name'] = $finalname[$i];
			} else {
				$error = array('error' => $this->upload->display_errors());
				echo "<pre>";
				print_r($error);
				echo "</pre>";
			}
			$data_gbr[$i] = $data_gbr[$i]['file_name'];
		}

		$whereArea   = array('id_dept' => $area);
		$bagian_dept = $this->m_home->getWhere('s_mst.tb_dept', $whereArea)->result();

		$data_audit = array(
			'id_audit'      => $id_aud,
			'kd_lok_audit'  => $k_lok,
			'tgl_audit'     => date("Y-m-d"),
			'kd_5r_audit'   => $k_5r,
			'kd_atem_audit' => $a_tem,
			'kd_tem_audit'  => $k_tem,
			'ket_audit'     => $ket,
			'jlh_tem_audit' => $jlh_tem,
			'gambar'        => json_encode($data_gbr),
			'user_audit'    => $this->session->userdata("user_id"),
			'kd_dept_audit' => $area,
			'status'        => false,
			'tim_audit'     => $auditor,
			'gambar_sesudah'=> '0',
			'updated'       => date("Y-m-d"),
			'periode'       => $periode,
			'otorisasi'     => 'BELUM',
			'bagian_dept'   => $bagian_dept[0]->bagian_dept,
		);

		$insert = $this->m_home->insert('s_mst.tb_audit',$data_audit);
		if ($insert){
			// update counter
			$data_id = array('counter' => $id_aud);
			$this->m_home->updateData('s_mst.tb_counter', $data_id, $whCounter);

			$log_type = 'insert';
			$log_desc = 'Tambah Data Audit Area: '.$area.', Lokasi: '.$k_lok;
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
			$this->session->set_flashdata('success', "Berhasil submit data audit.");
			redirect(base_url('home/form'));
		} else{
			$this->session->set_flashdata('error', "Gagal submit data audit.");
			echo "<script>location='".base_url()."home/form';</script>";
			exit;
		}
	}

	function md5(){
		$this->load->view('auditor/md5');
	}


	function coba($date){
		date_default_timezone_set("Asia/Jakarta");
		echo date("Y-m-d H:i:s", $date/10000);
	}
	


}