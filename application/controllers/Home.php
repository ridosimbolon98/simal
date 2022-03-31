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
		$data['title'] = "Audit 5R-Pabrik | Form Audit Page";
		$where         = array('area_auditor' => 'PABRIK');
		$data['area']  = $this->m_home->get('s_mst.tb_dept')->result();
		$data['audit'] = $this->m_home->getWhere('s_mst.tb_auditor', $where)->result();
		$this->load->view('auditor/v_index', $data);
	}

	function pabrik(){
		$data['title'] = "Audit 5R-Pabrik | Form Audit Page";
		$userid        = $this->session->userdata("user_id");
		$where         = array('area_auditor' => 'PABRIK', 'parent_koor' => $userid);
		$data['area']  = $this->m_home->get('s_mst.tb_dept')->result();
		$data['audit'] = $this->m_home->getWhere('s_mst.tb_auditor', $where)->result();
		$this->load->view('auditor/v_pabrik', $data);
	}

	function np(){
		$data['title'] = "Audit 5R-Non Pabrik | Form Audit Page";
		$where         = array('area_auditor' => 'NON-PABRIK');
		$data['area']  = $this->m_home->get('s_mst.tb_dept')->result();
		$data['audit'] = $this->m_home->getWhere('s_mst.tb_auditor', $where)->result();
		$this->load->view('auditor/v_non_pabrik', $data);
	}

	public function get_at(){
		$k_5r = $this->input->post('data1');
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
		$k_lok   = $this->input->post('k_lok');
		$auditor = $this->input->post('tim_audit[]');
		$area    = $this->input->post('area');
		$tanggal = $this->input->post('tanggal');
		$periode = date('Y-m', strtotime($tanggal));
		$k_5r    = $this->input->post('k_5r');
		$a_tem   = $this->input->post('a_tem');
		$k_tem   = $this->input->post('k_tem');
		$ket     = $this->input->post('keterangan');
		$jlh_tem = $this->input->post('jlh_temuan');
		$gambar  = $this->input->post('gambar');

		$config['upload_path']   = './public/audit';
		$config['allowed_types'] = 'jpg|png|jpeg';
		$config['remove_space']  = TRUE;
		$this->load->library('upload',$config);

		if($this->upload->do_upload('gambar')){
			$file  = $this->upload->data();
			$name  = $file['file_name'];
			date_default_timezone_set("Asia/Jakarta");

			$data_audit = array(
				'kd_lok_audit'  => $k_lok,
				'tgl_audit'     => $tanggal,
				'kd_5r_audit'   => $k_5r,
				'kd_atem_audit' => $a_tem,
				'kd_tem_audit'  => $k_tem,
				'ket_audit'     => $ket,
				'jlh_tem_audit' => $jlh_tem,
				'gambar'        => $name,
				'user_audit'    => $this->session->userdata("user_id"),
				'kd_dept_audit' => $area,
				'status'        => false,
				'tim_audit'     => json_encode($auditor),
				'gambar_sesudah'=> '0',
				'updated'       => date("Y-m-d"),
				'periode'       => $periode
			);

			$insert = $this->m_home->insert('s_mst.tb_audit',$data_audit);
			if ($insert){
				$log_type = 'insert';
				$log_desc = 'Tambah Data Audit';
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
				redirect(base_url('home'));
			} else{
				echo "<script>alert('Gagal send data audit');</script>";
				echo "<script>location='".base_url()."home';</script>";
				exit;
			}
		} else {
			$error = array('error' => $this->upload->display_errors());
			echo "<pre>";
			print_r($error);
			echo "</pre>";
		}

	}


}