<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

	/**
	 * @author Rido
	 */

	function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->model('m_auth');
		$this->load->model('m_log');	
	}

	public function index()
	{
		$data['title'] = "Audit 5R | Login Page";
		$this->load->view('auth/v_index', $data);
	}

	function login(){
        $this->load->database();

		$username = htmlspecialchars(trim($this->input->post('username')));
		$password = htmlspecialchars(trim($this->input->post('password')));
		$where    = array(
			'username' => $username,
			'password' => md5($password)
			);
		$data     = $this->m_auth->autentikasi('s_mst.tb_user',$where)->result();
		$cek      = $this->m_auth->autentikasi('s_mst.tb_user',$where)->num_rows();
		
		if($cek > 0){
			$level    = $data[0]->level;
			$userId   = $data[0]->id_user;
			$bagian   = $data[0]->kd_dept;
			// menyimpan data session
			$data_session  = array(
				'username' => $username,
				'level'    => $level,
				'user_id'  => $userId,
				'status'   => "logged",
				'bagian'   => $bagian
			);

			// Mencatat log login
 			$this->session->set_userdata($data_session);
			$log_type = 'login';
			$log_desc = 'Login User';
			$ip       = $this->input->ip_address();
			$userLog  = $username;
			date_default_timezone_set("Asia/Jakarta");
			$data_log = array(
				'username'      => $userLog,
				'type_log'      => $log_type,
				'deskripsi_log' => $log_desc,
				'date'          => date("Y-m-d H:i:s"),
				'ip'            => $ip
			);
			$this->m_log->insertLog('s_log.tb_log', $data_log);

			switch ($level) {
				case 'admin':
					redirect(base_url("admin/pabrik"));
					break;
		
				case 'auditor':
					redirect(base_url("home"));
					break;

				case 'user':
					redirect(base_url("user"));
					break;
				
				default:
					// user
					break;
			} 
		} else {
			echo "<script>alert('Gagal Login!. Pastikan username dan password benar.');</script>";
			echo "<script>location='".base_url()."';</script>";
		}
	}

	// Fungsi untuk logout
	function logout() {

		// Mencatat log logout
		$log_type = 'logout';
		$log_desc = 'Logout User';
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

		// hapus session dan redirect ke halaman login
		$this->session->sess_destroy();
		redirect(base_url('auth'));
	}
}
