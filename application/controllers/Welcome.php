<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @author Rido
 */

class Welcome extends CI_Controller {
	function __construct(){
		parent::__construct();
    $this->load->helper('url');
    $this->load->model('m_home');
	}

  function index(){
		$data['title']   = "Audit 5R | Home Audit Page";
		if(isset($_POST['periode'])){
			$periode         = $this->input->post("periode");
			$data['periode'] = $periode;
			$data['prd']     = $periode;
			$now = date('Y-m');
			$data['tahun'] = $periode;

			$data['jlh_tb'] = $this->m_home->getJlhTB($periode)->result(); //jlh all temuan
			$data['jlh_op'] = $this->m_home->getJlhOP($periode)->result(); //jlh temuan open all
			$data['jlh_os'] = $this->m_home->getJlhOS($now,$periode)->result(); //jlh temuan open sebelumnya
			$data['jlh_btl'] = $this->m_home->getJlhBTL($periode)->result(); //jlh temuan belum tindak lanjut all
			$data['jlh_stl'] = $this->m_home->getJlhSTL($periode)->result(); //jlh temuan sudah tindaklanjut all
			$data['jlh_sot'] = $this->m_home->getJlhTSOT($periode)->result(); //jlh temuan sudah otorisasi
			$data['jlh_tcall'] = $this->m_home->getTemuanClosedAll($periode)->result();

			// line chart data
			$data['jan'] = $this->m_home->getJlhTemuanPeriode($periode.'-'.'01')->result(); 
			$data['feb'] = $this->m_home->getJlhTemuanPeriode($periode.'-'.'02')->result(); 
			$data['mar'] = $this->m_home->getJlhTemuanPeriode($periode.'-'.'03')->result();
			$data['apr'] = $this->m_home->getJlhTemuanPeriode($periode.'-'.'04')->result(); 
			$data['mei'] = $this->m_home->getJlhTemuanPeriode($periode.'-'.'05')->result(); 
			$data['jun'] = $this->m_home->getJlhTemuanPeriode($periode.'-'.'06')->result(); 
			$data['jul'] = $this->m_home->getJlhTemuanPeriode($periode.'-'.'07')->result(); 
			$data['agu'] = $this->m_home->getJlhTemuanPeriode($periode.'-'.'08')->result(); 
			$data['sep'] = $this->m_home->getJlhTemuanPeriode($periode.'-'.'09')->result(); 
			$data['okt'] = $this->m_home->getJlhTemuanPeriode($periode.'-'.'10')->result();
			$data['nov'] = $this->m_home->getJlhTemuanPeriode($periode.'-'.'11')->result();
			$data['des'] = $this->m_home->getJlhTemuanPeriode($periode.'-'.'12')->result(); 

			// bar chart
			$data['jlh_tca'] = $this->m_home->getJlhTemuanClosedAll()->result(); 
			$data['jlh_toa'] = $this->m_home->getJlhTemuanOpenAll()->result(); 
			$data['jlh_stla'] = $this->m_home->getJlhTemuanSTLAll()->result(); 
			$data['jlh_btla'] = $this->m_home->getJlhTemuanBOTAll()->result(); 
			$data['jlh_sota'] = $this->m_home->getJlhTemuanSOTAll()->result(); 
			$data['jlh_tall'] = $this->m_home->getJlhTemuanAll()->result(); 
			
			// jadwal
			$data['jpt'] = $this->m_home->getJadwalByRealisasi('PABRIK', 'true')->result();
			$data['jpf'] = $this->m_home->getJadwalByRealisasi('PABRIK', 'false')->result();
			$data['jnpt'] = $this->m_home->getJadwalByRealisasi('NON-PABRIK', 'true')->result();
			$data['jnpf'] = $this->m_home->getJadwalByRealisasi('NON-PABRIK', 'false')->result();
			
			// pareto
			$data['pareto_ringkas'] = $this->m_home->getDataPareto($periode, 'RINGKAS')->result();
			$data['pareto_rapi'] = $this->m_home->getDataPareto($periode, 'RAPI')->result();
			$data['pareto_resik'] = $this->m_home->getDataPareto($periode, 'RESIK')->result();
			$data['pareto_rawat'] = $this->m_home->getDataPareto($periode, 'RAWAT')->result();

		} else {
			$now = date('Y-m');
			$periode = date('Y');
			$data['periode'] = $now;
			$data['prd']     = $periode;
			$data['tahun']   = $periode;

			$data['jlh_tb'] = $this->m_home->getJlhTB($periode)->result(); //jlh all temuan
			$data['jlh_op'] = $this->m_home->getJlhOP($periode)->result(); //jlh temuan open all
			$data['jlh_os'] = $this->m_home->getJlhOS($now,$periode)->result(); //jlh temuan open sebelumnya
			$data['jlh_btl'] = $this->m_home->getJlhBTL($periode)->result(); //jlh temuan belum tindak lanjut all
			$data['jlh_stl'] = $this->m_home->getJlhSTL($periode)->result(); //jlh temuan sudah tindaklanjut all
			$data['jlh_sot'] = $this->m_home->getJlhTSOT($periode)->result(); 
			$data['jlh_tcall'] = $this->m_home->getTemuanClosedAll($periode)->result();

			// line chart data
			$data['jan'] = $this->m_home->getJlhTemuanPeriode($periode.'-'.'01')->result(); 
			$data['feb'] = $this->m_home->getJlhTemuanPeriode($periode.'-'.'02')->result(); 
			$data['mar'] = $this->m_home->getJlhTemuanPeriode($periode.'-'.'03')->result(); 
			$data['apr'] = $this->m_home->getJlhTemuanPeriode($periode.'-'.'04')->result(); 
			$data['mei'] = $this->m_home->getJlhTemuanPeriode($periode.'-'.'05')->result(); 
			$data['jun'] = $this->m_home->getJlhTemuanPeriode($periode.'-'.'06')->result(); 
			$data['jul'] = $this->m_home->getJlhTemuanPeriode($periode.'-'.'07')->result(); 
			$data['agu'] = $this->m_home->getJlhTemuanPeriode($periode.'-'.'08')->result(); 
			$data['sep'] = $this->m_home->getJlhTemuanPeriode($periode.'-'.'09')->result(); 
			$data['okt'] = $this->m_home->getJlhTemuanPeriode($periode.'-'.'10')->result(); 
			$data['nov'] = $this->m_home->getJlhTemuanPeriode($periode.'-'.'11')->result(); 
			$data['des'] = $this->m_home->getJlhTemuanPeriode($periode.'-'.'12')->result(); 

			// bar chart
			$data['jlh_tca'] = $this->m_home->getJlhTemuanClosedAll()->result(); 
			$data['jlh_toa'] = $this->m_home->getJlhTemuanOpenAll()->result(); 
			$data['jlh_stla'] = $this->m_home->getJlhTemuanSTLAll()->result(); 
			$data['jlh_btla'] = $this->m_home->getJlhTemuanBOTAll()->result(); 
			$data['jlh_sota'] = $this->m_home->getJlhTemuanSOTAll()->result(); 
			$data['jlh_tall'] = $this->m_home->getJlhTemuanAll()->result(); 

			// jadwal
			$data['jpt'] = $this->m_home->getJadwalByRealisasi('PABRIK', 'true')->result();
			$data['jpf'] = $this->m_home->getJadwalByRealisasi('PABRIK', 'false')->result();
			$data['jnpt'] = $this->m_home->getJadwalByRealisasi('NON-PABRIK', 'true')->result();
			$data['jnpf'] = $this->m_home->getJadwalByRealisasi('NON-PABRIK', 'false')->result();
			
			// pareto
			$data['pareto_ringkas'] = $this->m_home->getDataPareto($periode, 'RINGKAS')->result();
			$data['pareto_rapi'] = $this->m_home->getDataPareto($periode, 'RAPI')->result();
			$data['pareto_resik'] = $this->m_home->getDataPareto($periode, 'RESIK')->result();
			$data['pareto_rawat'] = $this->m_home->getDataPareto($periode, 'RAWAT')->result();
		}
		$this->load->view('home', $data);
	}
  
	function getDataPBR(){
		$tahun = $this->input->post('tahun');
		$bar_pbr = $this->m_home->getJlhTemuanByArea('PABRIK',$tahun)->result();
		echo json_encode($bar_pbr);
	}
	function getDataNPBR(){
		$tahun = $this->input->post('tahun');
		$bar_npbr = $this->m_home->getJlhTemuanByArea('NON-PABRIK',$tahun)->result();
		echo json_encode($bar_npbr);
	}
}