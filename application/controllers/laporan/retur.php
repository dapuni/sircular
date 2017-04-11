<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class retur extends CI_Controller {

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
		$this->load->model('m_masterdata');
		$this->load->model('m_sirkulasi');
		$this->load->model('m_user');
		$this->m_user->login_trigger();
	}

	public function index($majalah = null,$edisi = null)
	{
		$majalah = $this->input->get('majalah');
		$edisi = $this->input->get('edisi');
		$agent = '';

		if ($this->input->get('startdate') > $this->input->get('enddate')) 
		{
			$startdate = $this->input->get('enddate');
			$enddate = $this->input->get('startdate');
		} else {
			$startdate = $this->input->get('startdate');
			$enddate = $this->input->get('enddate');
		}
		
		$data['agent'] = $this->m_sirkulasi->get_laporan_agent();
		$data['majalah'] =$this->m_masterdata->get_majalah();
		$data['select_majalah'] = $majalah;
		$data['edisi'] = $this->m_sirkulasi->get_edisi_majalah($majalah);
		$data['select_edisi'] = $edisi;
		$data['select_startdate'] = $startdate;
		$data['select_enddate'] = $enddate;


		if ($majalah != '' && $edisi != '') {
			$dataretur = $this->m_sirkulasi->find_return($majalah,$edisi,$startdate,$enddate,$agent);
			for ($i=0; $i < count($dataretur); $i++) { 
				$quota = $this->m_sirkulasi->quotaretur($dataretur[$i]['distribution_plan_id'],$dataretur[$i]['agent_id']);
				$dataretur[$i]['quota'] = $quota['quota'];
				$dataretur[$i]['consigned'] = $quota['consigned'];
			}
			
			$data['laporan'] = $dataretur;
		}
		$data['content'] = 'laporan/retur';
		$this->load->view('template',$data);
		
	}

	public function cetak()
	{
		$majalah = $this->input->get('majalah');
		$edisi = $this->input->get('edisi');
		$agent = '';

		if ($this->input->get('startdate') > $this->input->get('enddate')) 
		{
			$startdate = $this->input->get('enddate');
			$enddate = $this->input->get('startdate');
		} else {
			$startdate = $this->input->get('startdate');
			$enddate = $this->input->get('enddate');
		}

		$data['select_startdate'] = $startdate;
		$data['select_enddate'] = $enddate;
		$data['agent'] = $this->m_sirkulasi->get_laporan_agent();
		$data['majalah'] = $this->m_sirkulasi->get_one_majalah($majalah);
		$data['edisi'] = $this->m_sirkulasi->get_one_edisi($edisi);
		if ($majalah != '' && $edisi != '') {
			$dataretur = $this->m_sirkulasi->find_return($majalah,$edisi,$startdate,$enddate,$agent);
			for ($i=0; $i < count($dataretur); $i++) { 
				$quota = $this->m_sirkulasi->quotaretur($dataretur[$i]['distribution_plan_id'],$dataretur[$i]['agent_id']);
				$dataretur[$i]['quota'] = $quota['quota'];
				$dataretur[$i]['consigned'] = $quota['consigned'];
			}
			
			$data['laporan'] = $dataretur;
		}
		$this->load->view('laporan/print_retur',$data);
	}

	public function pdf_retur()
	{
		
		$majalah = $this->input->get('majalah');
		$edisi = $this->input->get('edisi');
		$agent = '';

		if ($this->input->get('startdate') > $this->input->get('enddate')) 
		{
			$startdate = $this->input->get('enddate');
			$enddate = $this->input->get('startdate');
		} else {
			$startdate = $this->input->get('startdate');
			$enddate = $this->input->get('enddate');
		}

		$data['select_startdate'] = $startdate;
		$data['select_enddate'] = $enddate;
		$data['agent'] = $this->m_sirkulasi->get_laporan_agent();
		$data['majalah'] = $this->m_sirkulasi->get_one_majalah($majalah);
		$data['edisi'] = $this->m_sirkulasi->get_one_edisi($edisi);
		if ($majalah != '' && $edisi != '') {
			$dataretur = $this->m_sirkulasi->find_return($majalah,$edisi,$startdate,$enddate,$agent);
			for ($i=0; $i < count($dataretur); $i++) { 
				$quota = $this->m_sirkulasi->quotaretur($dataretur[$i]['distribution_plan_id'],$dataretur[$i]['agent_id']);
				$dataretur[$i]['quota'] = $quota['quota'];
				$dataretur[$i]['consigned'] = $quota['consigned'];
			}
			
			$data['laporan'] = $dataretur;
		}
		$this->load->view('laporan/print_retur',$data);
		
		// Get output html
		$html = $this->output->get_output();
		
		// Load library
		$this->load->library('dompdf_gen');
		
		// Convert to PDF
		$this->dompdf->load_html($html);
		$this->dompdf->render();
		$this->dompdf->stream("Retur.pdf",array('Attachment'=>0));
	}

	public function excel()
	{
		$majalah = $this->input->get('majalah');
		$edisi = $this->input->get('edisi');
		$agent = '';
		
		if ($this->input->get('startdate') > $this->input->get('enddate')) 
		{
			$startdate = $this->input->get('enddate');
			$enddate = $this->input->get('startdate');
		} else {
			$startdate = $this->input->get('startdate');
			$enddate = $this->input->get('enddate');
		}

		$data['select_startdate'] = $startdate;
		$data['select_enddate'] = $enddate;
		$data['agent'] = $this->m_sirkulasi->get_laporan_agent();
		$data['majalah'] = $this->m_sirkulasi->get_one_majalah($majalah);
		$data['edisi'] = $this->m_sirkulasi->get_one_edisi($edisi);
		$data['excel'] = TRUE;
		if ($majalah != '' && $edisi != '') {
			$dataretur =  $this->m_sirkulasi->find_return($majalah,$edisi,$startdate,$enddate,$agent);
			for ($i=0; $i < count($dataretur); $i++) { 
				$quota = $this->m_sirkulasi->quotaretur($dataretur[$i]['distribution_plan_id'],$dataretur[$i]['agent_id']);
				$dataretur[$i]['quota'] = $quota['quota'];
				$dataretur[$i]['consigned'] = $quota['consigned'];
			}
			
			$data['laporan'] = $dataretur;
		}
		$this->load->view('laporan/print_retur',$data);
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */