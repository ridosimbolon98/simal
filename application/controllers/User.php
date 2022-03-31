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
		$data['title'] = "Audit 5R | User Page";
        $data['id_user'] = $this->session->userdata('user_id');
        $whereUserId   = array('id_user' => $data['id_user']);
        $data['user']  = $this->m_user->getUserById('s_mst.tb_user', 's_mst.tb_dept',$whereUserId)->result();
		$data['area']  = $data['user'][0]->kat_dept;
		$where         = array('kd_lok_audit' => $data['area'], 'kd_dept_audit' => $data['user'][0]->kd_dept);
		$data['audit'] = $this->m_user->getAllAudit('s_mst.tb_audit', 's_mst.tb_dept', 's_mst.tb_aspek', 's_mst.tb_par_temuan', $where)->result();
		$this->load->view('user/v_index', $data);
	}

    // Fungsi untuk update gambar sesudah
    function update_gbr(){
        $id_audit    = $this->input->post('id_audit');

        $config['upload_path']   = './public/audit';
		$config['allowed_types'] = 'jpg|png|jpeg';
		$config['remove_space']  = TRUE;
		$this->load->library('upload',$config);

        if($this->upload->do_upload('gambar')){
			$file  = $this->upload->data();
			$name  = $file['file_name'];
			date_default_timezone_set("Asia/Jakarta");

            $data_update = array(
                'gambar_sesudah' => $name
            );

            $whereUpd = array('id_audit' => $id_audit);

            $update = $this->m_user->updateData('s_mst.tb_audit', $data_update, $whereUpd);
			if ($update){
				$log_type = 'update';
				$log_desc = 'Update Gambar Sesudah Data Audit By User';
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
				redirect(base_url('user'));
			} else{
				echo "<script>alert('Gagal update gambar sesudah data audit');</script>";
				echo "<script>location='".base_url()."user';</script>";
				exit;
			}
        } else {
            $error = array('error' => $this->upload->display_errors());
			echo "<pre>";
			print_r($error);
			echo "</pre>";
        }
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


	// menampilkan halaman detail temuan per id
	function detail_temuan($id_audit){
		$data['title']  = "User Audit : Audit 5R";
		$data['id_user']= $this->session->userdata('user_id');
        $whereUserId    = array('id_user' => $data['id_user']);
		$data['user']   = $this->m_user->getUserById('s_mst.tb_user', 's_mst.tb_dept',$whereUserId)->result();
		$data['area']   = $data['user'][0]->kat_dept;
		$where          = array('id_audit' => $id_audit,'kd_lok_audit' => $data['area'], 'kd_dept_audit' => $data['user'][0]->kd_dept);
		$data['temuan'] = $this->m_user->getAuditPerID('s_mst.tb_audit', 's_mst.tb_dept', 's_mst.tb_aspek', 's_mst.tb_par_temuan', $where)->result();
		$this->load->view('user/v_detail_temuan', $data);
	}

}