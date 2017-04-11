<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class dashboard extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	function __construct()
	{
		parent::__construct();
		$this->load->model('m_user');
		$this->load->model('m_dashboard');
		$this->m_user->login_trigger();
	}
	
	public function index()
	{
		$rencanamajalah = array();
		$rencanatotal = array();
		$realisasimajalah = array();
		$realisasitotal = array();
		$realisasiretur = array();
		$realisasiid = array();

		//Rencana Distribusi
		foreach ($this->m_dashboard->get_rencana_distribusi() as $keyrencana) {
			$rencanamajalah[] = $keyrencana['nama_majalah'];
			$rencanatotal[] = $keyrencana['total'];
		}

		//Rencana Distribusi
		foreach ($this->m_dashboard->get_realisasi_distribusi() as $keyrealiasi) {
			$realisasiid[] = $keyrealiasi['majalah_id'];
			$realisasimajalah[] = $keyrealiasi['nama_majalah'];
			$realisasitotal[] = $keyrealiasi['total'];

			//Retur
			$realisasiretur[] = $this->m_dashboard->get_return($keyrealiasi['majalah_id'])['total_return'];
		}


		$data['rencana_majalah'] = json_encode($rencanamajalah);
		$data['rencana_total'] = json_encode($rencanatotal);
		$data['realisasi_majalah_id'] = $realisasiid;
		$data['realisasi_majalah'] = $realisasimajalah;
		$data['realisasi_total'] = $realisasitotal;
		$data['realisasi_return'] = $realisasiretur;
		$data['content'] = 'dashboard';
		$this->load->view('template',$data);
	}

	public function forbidden() {
		$this->load->view('404');
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */