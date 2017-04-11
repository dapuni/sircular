<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class rencana_distribusi extends CI_Controller {

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
		$prev_edisi = $this->input->get('prev_edisi');

		$data['majalah'] =$this->m_masterdata->get_majalah();
		$data['select_majalah'] = $majalah;
		$data['edisi'] = $this->m_sirkulasi->get_edisi_majalah($majalah);
		$data['select_edisi'] = $edisi;
		$data['select_prev_edisi'] = $prev_edisi;
		$data['agent'] = $this->m_sirkulasi->get_laporan_agent();
		$data['laporan'] = $this->m_sirkulasi->get_laporan_rencana_distribusi($majalah,$edisi); 
		$data['prev_laporan'] = $this->m_sirkulasi->get_laporan_rencana_distribusi($majalah,$prev_edisi); 
		$data['content'] = 'laporan/rencana_distribusi';
		$this->load->view('template',$data);
	}

	public function cetak($majalah = null,$edisi = null)
	{
		$majalah = $this->input->get('majalah');
		$edisi = $this->input->get('edisi');
		$prev_edisi = $this->input->get('prev_edisi');

		$data['agent'] = $this->m_sirkulasi->get_laporan_agent();
		$data['majalah'] = $this->m_sirkulasi->get_one_majalah($majalah);
		$data['edisi'] = $this->m_sirkulasi->get_one_edisi($edisi);
		$data['laporan'] = $this->m_sirkulasi->get_laporan_rencana_distribusi($majalah,$edisi);
		$data['prev_laporan'] = $this->m_sirkulasi->get_laporan_rencana_distribusi($majalah,$prev_edisi); 
		$this->load->view('laporan/print_rencana_distribusi',$data);
	}

	public function pdf()
	{
		
		$majalah = $this->input->get('majalah');
		$edisi = $this->input->get('edisi');
		$prev_edisi = $this->input->get('prev_edisi');

		$data['agent'] = $this->m_sirkulasi->get_laporan_agent();
		$data['majalah'] = $this->m_sirkulasi->get_one_majalah($majalah);
		$data['edisi'] = $this->m_sirkulasi->get_one_edisi($edisi);
		$data['laporan'] = $this->m_sirkulasi->get_laporan_rencana_distribusi($majalah,$edisi); 
		$data['prev_laporan'] = $this->m_sirkulasi->get_laporan_rencana_distribusi($majalah,$prev_edisi); 
		$this->load->view('laporan/print_rencana_distribusi',$data);
		
		// Get output html
		$html = $this->output->get_output();
		
		// Load library
		$this->load->library('dompdf_gen');
		
		// Convert to PDF
		$this->dompdf->load_html($html);
		$this->dompdf->render();
		$this->dompdf->stream("Rencana Distribusi.pdf",array('Attachment'=>0));
	}

	public function edisi_majalah($id)
	{
		$data['select_majalah'] = $id;
		$data['edisi'] = $this->m_sirkulasi->get_edisi_majalah($id);
		$data['majalah'] =$this->m_masterdata->get_majalah();
		$data['content'] = 'laporan/rencana_distribusi';
		$this->load->view('template',$data);
	}

	public function excel($majalah = null,$edisi = null)
	{
		$majalah = $this->input->get('majalah');
		$edisi = $this->input->get('edisi');
		$prev_edisi = $this->input->get('prev_edisi');
		
		$data['agent'] = $this->m_sirkulasi->get_laporan_agent();
		$data['majalah'] = $this->m_sirkulasi->get_one_majalah($majalah);
		$data['edisi'] = $this->m_sirkulasi->get_one_edisi($edisi);
		$data['excel'] = TRUE;
		$data['laporan'] = $this->m_sirkulasi->get_laporan_rencana_distribusi($majalah,$edisi);
		$data['prev_laporan'] = $this->m_sirkulasi->get_laporan_rencana_distribusi($majalah,$prev_edisi); 
		$this->load->view('laporan/print_rencana_distribusi',$data);
	}


	public function excel5()
	{
		$this->load->library("PHPExcel/PHPExcel");
		$majalah = $this->input->get('majalah');
		$edisi = $this->input->get('edisi');

		//membuat objek PHPExcel
        $objPHPExcel = new PHPExcel();

        //set Sheet yang akan diolah 
        $objPHPExcel->setActiveSheetIndex(0);

        // auto width size kolom
		$objPHPExcel->getSheet(0)->getColumnDimension('A')->setAutoSize(true);
		$objPHPExcel->getSheet(0)->getColumnDimension('B')->setAutoSize(true);
		$objPHPExcel->getSheet(0)->getColumnDimension('C')->setAutoSize(true);
		$objPHPExcel->getSheet(0)->getColumnDimension('D')->setAutoSize(true);
		$objPHPExcel->getSheet(0)->getColumnDimension('E')->setAutoSize(true);
		$objPHPExcel->getSheet(0)->getColumnDimension('F')->setAutoSize(true);
		$objPHPExcel->getSheet(0)->getColumnDimension('G')->setAutoSize(true);
		$objPHPExcel->getSheet(0)->getColumnDimension('H')->setAutoSize(true);
		$objPHPExcel->getSheet(0)->getColumnDimension('I')->setAutoSize(true);
		$objPHPExcel->getSheet(0)->getColumnDimension('J')->setAutoSize(true);
		$objPHPExcel->getSheet(0)->getColumnDimension('K')->setAutoSize(true);
		$objPHPExcel->getSheet(0)->getColumnDimension('L')->setAutoSize(true);
		$objPHPExcel->getSheet(0)->getColumnDimension('M')->setAutoSize(true);

 		//header tabel 
 		$objPHPExcel->getActiveSheet()->mergeCells('A1:C1');
 		$objPHPExcel->getActiveSheet()->setCellValue('A1','LAPORAN DATA RENCANA DISTRIBUSI');
 		$objPHPExcel->getActiveSheet()->setCellValue('A2','No');
 		$objPHPExcel->getActiveSheet()->setCellValue('B2','Agent Category');
 		$objPHPExcel->getActiveSheet()->setCellValue('C2','Kota');
 		$objPHPExcel->getActiveSheet()->setCellValue('D2','Agent');
 		$objPHPExcel->getActiveSheet()->setCellValue('E2','Jatah');
 		$objPHPExcel->getActiveSheet()->setCellValue('F2','Konsinyasi');
 		$objPHPExcel->getActiveSheet()->setCellValue('G2','Gratis');

 		//save from database
 		$data = $this->m_sirkulasi->get_laporan_rencana_distribusi($majalah,$edisi);;
 		$nama = '';
 		$no = 1;
 		foreach ($data as $data) 
 		{
			$objPHPExcel->getActiveSheet()->setCellValue('A'.($no+2),$no);
			
			if ($nama != $data['nama_agent_cat']) {
				$objPHPExcel->getActiveSheet()->setCellValue('B'.($no+2),$data['nama_agent_cat']);
				$nama = $data['nama_agent_cat'];
			}
	 		
	 		$objPHPExcel->getActiveSheet()->setCellValue('C'.($no+2),$data['name']);
	 		$objPHPExcel->getActiveSheet()->setCellValue('D'.($no+2),$data['nama_agent']);
	 		$objPHPExcel->getActiveSheet()->setCellValue('E'.($no+2),$data['quota']);
	 		$objPHPExcel->getActiveSheet()->setCellValue('F'.($no+2),$data['consigned']);
	 		$objPHPExcel->getActiveSheet()->setCellValue('G'.($no+2),$data['gratis']);
	 		$no++; 			
 		}
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
 
        //sesuaikan headernya 
        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        header("Cache-Control: no-store, no-cache, must-revalidate");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        //ubah nama file saat diunduh
        header('Content-Disposition: attachment;filename="Laporan Rencana Distribusi.xls"');
        //unduh file
        $objWriter->save("php://output");
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */