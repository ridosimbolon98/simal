<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @author Rido
 */

class Admin extends CI_Controller {
	function __construct(){
		parent::__construct();

		if ($this->session->userdata('level') != "ADMIN") {
			echo "<script>alert('Anda dilarang akses halaman ini tanpa autentikasi');</script>";
			echo "<script>location='".base_url()."auth';</script>";
		} else {
			$this->load->helper('url');
			$this->load->model('m_auth');
			$this->load->model('m_admin');
		}		
	}

	
	function index(){
		date_default_timezone_set("Asia/Jakarta");
		$data['title'] = "SIMAL | Admin Page";
		$bulan = date('m');
		$tahun = date('Y');

		// ambil jumlah data untuk ditampilkan di dashboard
		$data['jlh_user'] = $this->m_admin->getAll('user')->num_rows();
		$data['jlh_cust'] = $this->m_admin->getAll('customer')->num_rows();
		$data['jlh_griya'] = $this->m_admin->getAll('griya')->num_rows();
		$data['jlh_sudah_cetak'] = $this->m_admin->getKartuSudahCetak('kartu_meter','customer',$bulan,$tahun)->num_rows();
		$data_kartu_all = $this->m_admin->getKartuTotal('kartu_meter','customer',$bulan,$tahun)->num_rows();
		$data['jlh_belum_cetak'] = ($data_kartu_all - $data['jlh_sudah_cetak']);

		$this->load->view('admin/v_index', $data);
	}


	// fungsi untuk menampilkan data user
	function user(){
		$data['title'] = "SIMAL | Data User";
    // data all user dari tabel user
		$data['users'] = $this->m_admin->getAll('user')->result();
		$this->load->view('admin/v_user', $data);
	}

	// fungsi untuk tambah data user ke database
	function add_user() {
		date_default_timezone_set("Asia/Jakarta");
		$nama          = htmlspecialchars(trim($this->input->post("nama")));
		$username      = htmlspecialchars(trim($this->input->post("username")));
		$password      = htmlspecialchars(trim($this->input->post("password")));
		$level         = $this->input->post("level");

		// cek apakah username suda dipakai apa belum
		$whereUser     = array('username' => $username);
		$isUsername    = $this->m_admin->getWhere('user', $whereUser)->num_rows(); 
		if ($isUsername > 0){
			$this->session->set_flashdata('warning', "Username $username sudah ada di sistem. Silakan pilih username lain!");
			redirect(base_url("admin/user"));
			exit;
		}

		$new_user     = array(
			'uid'      => time(),
			'nama'     => $nama,
			'username' => $username,
			'password' => md5($password),
			'level'    => $level,
			'created_at' => date('Y-m-d H:m:s'),
			'updated_at' => date('Y-m-d H:m:s')
		);

		// insert new user ke table user
		$insert_user  = $this->m_admin->insertData('user', $new_user);
		if ($insert_user) {
			$this->session->set_flashdata('success', 'Berhasil tambah user baru');
			redirect(base_url("admin/user"));
		} else {
			$this->session->set_flashdata('error', 'Gagal menambah user baru. Ada kesalahan di sisi server. Silakan ulangi lagi!');
			redirect(base_url("admin/user"));
		}
	}

	// fungsi untuk delete data user admin
	function delete_user($uid){
		date_default_timezone_set("Asia/Jakarta");
		$where = array('uid' => $uid);

		// deelte user by uid
		$delete = $this->m_admin->delete('user', $where);
		if ($delete) {
			$this->session->set_flashdata('success', "Berhasil hapus data user admin dengan UID: $uid");
			redirect(base_url("admin/user"));
		} else {
			$this->session->set_flashdata('error', "Gagal hapus user admin dengan UID: $uid");
			redirect(base_url("admin/user"));
		}
	}


	// fungsi untuk menampilkan data master griya
	function griya(){
		$data['title'] = "SIMAL | Data Griya";
    	// data all user dari tabel user
		$data['griya'] = $this->m_admin->getAll('griya')->result();
		$this->load->view('admin/v_griya', $data);
	}

	// fungsi untuk tambah data griya
	function add_griya(){
		date_default_timezone_set("Asia/Jakarta");
		// ambil data dari form input post
		$nama_griya = strtoupper(strip_tags(trim($this->input->post("nama"))));
		$alamat_griya = strip_tags(trim($this->input->post("alamat")));

		$data_griya = array(
			'id' => time(),
			'nama' => $nama_griya,
			'alamat' => $alamat_griya
		);

		// insert ke table griya
		$insert = $this->m_admin->insertData('griya', $data_griya);
		if ($insert) {
			$this->session->set_flashdata('success', "Berhasil tambah data Griya baru.");
			redirect(base_url('admin/griya'));
		} else {
			$this->session->set_flashdata('error', "Gagal tambah data griya.");
			redirect(base_url('admin/griya'));
		}
	}

	// fungsi untuk update data griya by id
	function update_griya(){
		date_default_timezone_set("Asia/Jakarta");
		// ambil data dari form input post
		$id_griya = trim($this->input->post("id_griya"));
		$nama_griya = strtoupper(strip_tags(trim($this->input->post("nama"))));
		$alamat_griya = strip_tags(trim($this->input->post("alamat")));

		$where_id = array('id' => $id_griya);
		$data_griya = array(
			'nama' => strtoupper($nama_griya),
			'alamat' => $alamat_griya
		);

		// insert ke table griya
		$update = $this->m_admin->updateData('griya', $data_griya, $where_id);
		if ($update) {
			$this->session->set_flashdata('success', "Berhasil update data Griya dengan ID: $id_griya.");
			redirect(base_url('admin/griya'));
		} else {
			$this->session->set_flashdata('error', "Gagal update data griya.");
			redirect(base_url('admin/griya'));
		}
	}

	// fungsi untuk hapus data griya
	function delete_griya($id_griya) {
		date_default_timezone_set("Asia/Jakarta");

		$where_id = array('id' => $id_griya);
		// delete griya by id
		$delete = $this->m_admin->delete('griya', $where_id);
		if ($delete) {
			$this->session->set_flashdata('success', "Berhasil hapus data Griya dengan ID: $id_griya. Setelah dihapus, maka customer yang termapping dengan Griya ini tidak akan tampil di kartu meter. Silakan update griya cusomer yang termapping dengan griya ini.");
			redirect(base_url('admin/griya'));
		} else {
			$this->session->set_flashdata('error', "Gagal hapus data griya.");
			redirect(base_url('admin/griya'));
		}
	}

	// fungsi untuk menampilkan kartu pelanggan
	function kartu() {
		date_default_timezone_set("Asia/Jakarta");
		$data['title'] = "SIMAL | Kartu Pelanggan";
		// ambil data dari post
		$tahun    = $this->input->post('tahun');
		$griya_id = $this->input->post('griya');
		$cust_id  = $this->input->post('customer');

		if(isset($tahun) && isset($griya_id) && isset($cust_id)){
			$data['is_filter'] = true;
			$time=strtotime($tahun);
			$year=date("Y",$time);

			$where_griya = array('id' => $griya_id);
			// ambil data griya by id dari table griya
			$griya_byid = $this->m_admin->getWhere('griya', $where_griya)->result();
			$data['filter_griya'] = $griya_byid[0]->nama;
			$data['tahun'] = $year;

			$where_setup = array(
				'trx' => 'BIAYA',
				'tipe' => 'M3'
			);
			$where_kartu = array(
				'kartu_meter.cid' => $cust_id,
				'periode' => $year
			);
			$where_cust = array('cid' => $cust_id);
						
			// ambil data kartu meter pelanggan per periode by customer id, data customer by cid dan setup biaya
			$data['setup'] = $this->m_admin->getWhere('setup', $where_setup)->result();
			$data['customer'] = $this->m_admin->getWhere('customer', $where_cust)->result();
			$data['kartu'] = $this->m_admin->getKartuMeterPelanggan('kartu_meter', 'customer', 'griya', $where_kartu)->result();
		} else {
			$data['is_filter'] = false;
			// ambil data bulan dan tahun sekarang (waktu server)
			$periode = date("Y");
			$bulan = date("m");

			$where_periode =  array('bulan' => $bulan, 'periode' => $periode);
			$where_setup = array(
				'trx' => 'BIAYA',
				'tipe' => 'M3'
			);
			$where_kartu = array(
				'bulan' => $bulan,
				'periode' => $periode
			);
			
			$data['filter_griya'] = '--';
			$data['tahun'] = $periode;
			$data['setup'] = $this->m_admin->getWhere('setup', $where_setup)->result();
			$data['kartu'] = $this->m_admin->getKartuMeterPelanggan('kartu_meter', 'customer', 'griya', $where_kartu)->result();
		}

		// data all user dari tabel user
		$data['griya'] = $this->m_admin->getAll('griya')->result();
		$this->load->view('admin/v_kartu', $data);
	}

	// fungsi untuk ambil data customer by ajax
	function get_cust() {
		$gid  = $this->input->post('gryid');
		$where = array('griya_id' => $gid);
		$data  = $this->m_admin->getWhere('customer', $where)->result();
		echo json_encode($data);
	}
	
	// fungsi untuk ambil data griya by ajax
	function get_griya() {
		$data  = $this->m_admin->getAll('griya')->result();
		echo json_encode($data);
	}
	
	// fungsi untuk ambil data aka per periode dan customer by ajax
	function last_cust_aka() {
		$cid    = $this->input->post('cid');
		$tahun  = $this->input->post('tahun');
		$where  = array('cid' => $cid, 'tahun' => $tahun);
		$data   = $this->m_admin->getBulanKMP('kartu_meter', $where)->result();
		echo json_encode($data);
	}

	// fungsi untuk ambil data kartu per periode filter id by ajax
	function get_kartu_byid() {
		$id   = $this->input->post('kid');
		$where = array('kartu_meter.id' => $id);
		$data  = $this->m_admin->getTagihanPeriodeById('kartu_meter','customer','griya', $where)->result();
		echo json_encode($data);
	}

	// fungsi untuk menampilkan data customer
	function customer(){
		$data['title'] = "SIMAL | Customer Page";

		// ambil data customer, griya
		$data['griya'] = $this->m_admin->getAll('griya')->result();
		$data['customer'] = $this->m_admin->getAllCustomer('customer', 'griya')->result();
		$this->load->view('admin/v_customer', $data);
	}

	// fungsi untuk tambah new customer
	function add_customer() {
		date_default_timezone_set("Asia/Jakarta");

		// ambil data dari input post 
		$nama = strip_tags(trim($this->input->post('nama')));
		$alamat = strip_tags(trim($this->input->post('alamat')));
		$griya_id = trim($this->input->post('griya'));
		$stand_meter = strip_tags(trim($this->input->post('stand_meter')));
		$golongan = strip_tags(trim($this->input->post('golongan')));
		$input_by = $this->session->userdata('uid');

		$data_cust = array(
			'cid' => time(),
			'nama' => strtoupper($nama),
			'alamat' => $alamat,
			'griya_id' => $griya_id,
			'golongan' => $golongan,
			'stand_meter' => $stand_meter,
			'input_by' => $input_by,
			'inserted_at' => date('Y-m-d H:m:s'),
		);

		// insert ke database table kartu_meter
		$insert_customer = $this->m_admin->insertData('customer', $data_cust);
		if ($insert_customer) {
			$this->session->set_flashdata('success', "Berhasil input customer baru.");
			redirect(base_url('admin/customer'));
		} else {
			$this->session->set_flashdata('error', "Gagal input customer baru.");
			redirect(base_url('admin/customer'));
		}
	}
	
	// fungsi untuk update data customer
	function update_customer() {
		date_default_timezone_set("Asia/Jakarta");

		// ambil data dari input post 
		$cid = trim($this->input->post('cid'));
		$nama = strip_tags(trim($this->input->post('nama')));
		$alamat = strip_tags(trim($this->input->post('alamat')));
		$griya_id = trim($this->input->post('griya'));
		$stand_meter = strip_tags(trim($this->input->post('stand_meter')));
		$golongan = strip_tags(trim($this->input->post('golongan')));
		$input_by = $this->session->userdata('uid');

		$where_cid = array('cid' => $cid);
		$data_cust = array(
			'nama' => strtoupper($nama),
			'alamat' => $alamat,
			'griya_id' => $griya_id,
			'golongan' => $golongan,
			'stand_meter' => $stand_meter,
			'input_by' => $input_by,
			'inserted_at' => date('Y-m-d H:m:s'),
		);

		// insert ke database table kartu_meter
		$update_customer = $this->m_admin->updateData('customer', $data_cust, $where_cid);
		if ($update_customer) {
			$this->session->set_flashdata('success', "Berhasil input customer baru.");
			redirect(base_url('admin/customer'));
		} else {
			$this->session->set_flashdata('error', "Gagal input customer baru.");
			redirect(base_url('admin/customer'));
		}
	}

	// fungsi untuk menampilkan AKA Customer bulan berjalan
	function aka(){
		date_default_timezone_set("Asia/Jakarta"); 
		$data['title'] = "SIMAL | AKA Pelanggan";
		$bulan         = date('m'); 
		$tahun         = date('Y'); 

		$where_periode = array(
			'periode' => $tahun
		);

		$data['tahun'] = $tahun;
		// ambil data AKA customer per periode tertentu
		$data['aka_cust'] = $this->m_admin->getAKACustToday('kartu_meter', 'customer', 'griya', $where_periode)->result();
		$this->load->view('admin/v_aka_cust', $data);
	}

	// fungsi untuk insert AKA pelanggan baru
	function input_new_aka() {
		date_default_timezone_set("Asia/Jakarta"); 

		// input data post
		$cid       = $this->input->post('cust_id');
		$tahun     = $this->input->post('tahun');
		$new_bln   = $this->input->post('bulan');
		$aka_akhir = $this->input->post('aka_akhir');

		$where_cid = array('cid' => $cid);
		$where_stp_m3 = array('trx' => 'BIAYA', 'tipe' => 'M3');
		$where_stp_adm = array('trx' => 'BIAYA', 'tipe' => 'ADMIN');

		// ambil data kartu meter pelanggan per periode by customer id, data customer by cid dan setup biaya
		$setup = $this->m_admin->getWhere('setup', $where_stp_m3)->result();
		$setup_adm = $this->m_admin->getWhere('setup', $where_stp_adm)->result();
		$data_griya = $this->m_admin->getGriyaByCID('customer', 'griya', $where_cid)->result();
		
		$biaya_m3  = (int)$setup[0]->nilai; //biaya per meter kubik
		$biaya_adm  = (int)$setup_adm[0]->nilai; //biaya administrasi
		$biaya_mtc = (int)$data_griya[0]->biaya_mtc; //biaya maintenance berdasarkan griya

		// cek aka_lalu by cust_id dan periode
		$where_custid = array(
			'cid' => $cid,
			'periode' => $tahun,
		);
		$data_aka_last = $this->m_admin->getLastMonthAKA('kartu_meter',$where_custid)->result();

		$aka_lalu = $data_aka_last[0]->aka_akhir;
		$jlh_pakai = ($aka_akhir - $aka_lalu);
		$biaya = (($biaya_m3 * $jlh_pakai) + $biaya_mtc);

		// cek jika aka new > aka_lalu
		if($aka_akhir <= $aka_lalu){
			$this->session->set_flashdata('warning', "gagal input AKA Baru. Nilai AKA baru tidak boleh lebih kecil dari nilai AKA Akhir!");
			redirect(base_url('admin/kartu'));
		}

		$data_aka_new = array(
			'id' => time(), 
			'cid' => $cid, 
			'bulan' => date('m', strtotime($new_bln)), 
			'periode' => $tahun, 
			'aka_lalu' => $aka_lalu,
			'aka_akhir' => $aka_akhir, 
			'jlh_pakai' => $jlh_pakai, 
			'jlh_biaya' => ($biaya + $biaya_adm), 
			'biaya_per_meter' => $biaya_m3, 
			'inserted_at' => date("Y-m-d H:i:s")
		);

		// insert ke database table kartu_meter
		$insert_aka_new = $this->m_admin->insertData('kartu_meter', $data_aka_new);
		if ($insert_aka_new) {
			$this->session->set_flashdata('success', "Berhasil input AKA Baru.");
			redirect(base_url('admin/aka'));
		} else {
			$this->session->set_flashdata('error', "Gagal input AKA Baru.");
			redirect(base_url('admin/aka'));
		}
		
	}

	// fungsi untuk menampilkan data setup
	function setup() {
		date_default_timezone_set("Asia/Jakarta");
		$data['title'] = "SIMAL | Setup Page";

		// ambil data setup dari table setup
		$data['setup'] = $this->m_admin->getAll('setup')->result();

		$this->load->view('admin/v_setup', $data);
	}

	// update data setup by sid
	function update_setup(){
		date_default_timezone_set("Asia/Jakarta");
		$sid = $this->input->post('sid');
		$trx = strip_tags(trim($this->input->post('trx')));
		$tipe = strip_tags(trim($this->input->post('tipe')));
		$nilai = strip_tags(trim($this->input->post('nilai')));
		$updated_by = $this->session->userdata("uid");

		$where_sid = array('sid' => $sid);
		$data_setup = array(
			'trx' => $trx,
			'tipe' => $tipe,
			'nilai' => $nilai,
			'updated_by' => $updated_by,
			'updated_at' => date("Y-m-d H:i:s")
		);
		$update = $this->m_admin->updateData('setup', $data_setup, $where_sid);
		if ($update) {
			$this->session->set_flashdata('success', "Berhasil update data setup.");
			redirect(base_url('admin/setup'));
		} else {
			$this->session->set_flashdata('error', "Gagal update data setup.");
			redirect(base_url('admin/setup'));
		}
	}


	// test print
	function print($id){
		$this->load->library('Escpos');
					
		// ambil data kartu meter pelanggan per periode by customer id, data customer by cid dan setup biaya
		$where = array('kartu_meter.id' => $id);
		$where_setup = array('trx' => 'NAMA', 'tipe' => 'USAHA');
		$tagihan  = $this->m_admin->getTagihanPeriodeById('kartu_meter','customer','griya', $where)->result();
		$shop = $this->m_admin->getWhere('setup', $where_setup)->result();
		$nama_shop = $shop[0]->nilai; 

		$items = [];
		foreach ($tagihan as $row) {
			$items = [
				["item"=> "Nama","value"=> $row->nama_cust],
				["item"=> "B. Perawatan","value"=> number_format((int)$row->biaya_mtc,0,",",".")],
				["item"=> "Alamat","value"=> $row->alamat_cust],
				["item"=> "Periode","value"=> $row->bulan . '/' . $row->periode],
				["item"=> "Standmeter","value"=> $row->stand_meter],
				["item"=> "Pemakaian (M3)","value"=> $row->jlh_pakai],
				["item"=> "Total Bayar (Rp)","value"=> number_format((int)$row->jlh_biaya,0,",",".")]
			];
		}

		$this->escpos->print($items,$nama_shop);
		exit;
	}

	
}