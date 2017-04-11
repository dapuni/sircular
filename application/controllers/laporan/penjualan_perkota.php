<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class penjualan_perkota extends CI_Controller {

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

	public function index($majalah = null,$edisi = null,$startdate = '',$enddate = '')
	{
		$majalah = $this->input->get('majalah');
		$edisi = $this->input->get('edisi');

		$data['majalah'] =$this->m_masterdata->get_majalah();
		$data['select_majalah'] = $majalah;
		$data['edisi'] = $this->m_sirkulasi->get_edisi_majalah($majalah);
		$data['select_edisi'] = $edisi;
		if ($majalah != '' && $edisi != '') {
			$datapenjualan = $this->m_sirkulasi->get_laporan_realisasi_distribusi($majalah,$edisi); 
			for ($i=0; $i < count($datapenjualan) ; $i++) { 
				$dataretur = $this->m_sirkulasi->jumlahretur($datapenjualan[$i]['agent_id'],$edisi);
				$datapenjualan[$i]['retur'] = $dataretur['retur'];
			}
			$data['laporan'] = $datapenjualan;

		}
		$data['content'] = 'laporan/penjualan_perkota';
		$this->load->view('template',$data);
	}

	public function cetak($startdate = '',$enddate = '')
	{
		$majalah = $this->input->get('majalah');
		$edisi = $this->input->get('edisi');

		$data['majalah'] = $this->m_sirkulasi->get_one_majalah($majalah);
		$data['edisi'] = $this->m_sirkulasi->get_one_edisi($edisi);
		if ($majalah != '' && $edisi != '') {
			$datapenjualan = $this->m_sirkulasi->get_laporan_realisasi_distribusi($majalah,$edisi); 
			for ($i=0; $i < count($datapenjualan) ; $i++) { 
				$dataretur = $this->m_sirkulasi->jumlahretur($datapenjualan[$i]['agent_id'],$edisi);
				$datapenjualan[$i]['retur'] = $dataretur['retur'];
			}
			$data['laporan'] = $datapenjualan;

		}
		$this->load->view('laporan/print_penjualan_perkota',$data);
	}

	public function pdf_retur($startdate = '',$enddate = '')
	{
		
		$majalah = $this->input->get('majalah');
		$edisi = $this->input->get('edisi');

		$data['majalah'] = $this->m_sirkulasi->get_one_majalah($majalah);
		$data['edisi'] = $this->m_sirkulasi->get_one_edisi($edisi);
		if ($majalah != '' && $edisi != '') {
			$datapenjualan = $this->m_sirkulasi->get_laporan_realisasi_distribusi($majalah,$edisi); 
			for ($i=0; $i < count($datapenjualan) ; $i++) { 
				$dataretur = $this->m_sirkulasi->jumlahretur($datapenjualan[$i]['agent_id'],$edisi);
				$datapenjualan[$i]['retur'] = $dataretur['retur'];
			}
			$data['laporan'] = $datapenjualan;

		}
		$this->load->view('laporan/print_penjualan_perkota',$data);
		
		// Get output html
		$html = $this->output->get_output();
		
		// Load library
		$this->load->library('dompdf_gen');
		
		// Convert to PDF
		$this->dompdf->load_html($html);
		$this->dompdf->render();
		$this->dompdf->stream("Penjualan Perkota.pdf",array('Attachment'=>0));
	}

	public function excel($startdate = '',$enddate = '')
	{
		$majalah = $this->input->get('majalah');
		$edisi = $this->input->get('edisi');

		$data['majalah'] = $this->m_sirkulasi->get_one_majalah($majalah);
		$data['edisi'] = $this->m_sirkulasi->get_one_edisi($edisi);
		$data['excel'] = TRUE;
		if ($majalah != '' && $edisi != '') {
			$datapenjualan = $this->m_sirkulasi->get_laporan_realisasi_distribusi($majalah,$edisi); 
			for ($i=0; $i < count($datapenjualan) ; $i++) { 
				$dataretur = $this->m_sirkulasi->jumlahretur($datapenjualan[$i]['agent_id'],$edisi);
				$datapenjualan[$i]['retur'] = $dataretur['retur'];
			}
			$data['laporan'] = $datapenjualan;

		}
		$this->load->view('laporan/print_penjualan_perkota',$data);
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */