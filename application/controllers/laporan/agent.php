<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class agent extends CI_Controller {

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
		$this->load->model('m_user');
		$this->m_user->login_trigger();
	}

	public function index()
	{
		$data['agent'] =$this->m_masterdata->get_agent();
		$data['content'] = 'laporan/agent';
		$this->load->view('template',$data);
	}

	public function cetak()
	{
		$data['agent'] =$this->m_masterdata->get_agent();
		$this->load->view('laporan/print_agent',$data);
	}

	public function export()
	{
		$data['agent'] =$this->m_masterdata->get_agent();
		$data['excel'] = TRUE;
		$this->load->view('laporan/print_agent',$data);
	}

	public function export5()
	{
		$this->load->library("PHPExcel/PHPExcel");

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
 		$objPHPExcel->getActiveSheet()->setCellValue('A1','LAPORAN DATA AGENT');
 		$objPHPExcel->getActiveSheet()->setCellValue('A2','No');
 		$objPHPExcel->getActiveSheet()->setCellValue('B2','Agen Category');
 		$objPHPExcel->getActiveSheet()->setCellValue('C2','Agent');
 		$objPHPExcel->getActiveSheet()->setCellValue('D2','Alamat');
 		$objPHPExcel->getActiveSheet()->setCellValue('E2','Kontak');
 		$objPHPExcel->getActiveSheet()->setCellValue('F2','Telepon');

 		//save from database
 		$data = $this->m_masterdata->get_agent();
 		$agent_cat = '';
 		$no = 1;
 		foreach ($data as $data) 
 		{
			$objPHPExcel->getActiveSheet()->setCellValue('A'.($no+2),$no);
			
			if ($agent_cat != $data['nama_agent_cat']) {
				$objPHPExcel->getActiveSheet()->setCellValue('B'.($no+2),$data['nama_agent_cat']);
				$agent_cat = $data['nama_agent_cat'];
			}
	 		
	 		$objPHPExcel->getActiveSheet()->setCellValue('C'.($no+2),$data['nama_agent']);
	 		$objPHPExcel->getActiveSheet()->setCellValue('D'.($no+2),$data['address']);
	 		$objPHPExcel->getActiveSheet()->setCellValue('E'.($no+2),$data['contact']);
	 		$objPHPExcel->getActiveSheet()->setCellValue('F'.($no+2),$data['phone']);
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
        header('Content-Disposition: attachment;filename="Laporan Agent.xls"');
        //unduh file
        $objWriter->save("php://output");
	}

	public function pdf_agent()
	{
		
		$data['agent'] =$this->m_masterdata->get_agent();
		$this->load->view('laporan/print_agent',$data);
		
		// Get output html
		$html = $this->output->get_output();
		
		// Load library
		$this->load->library('dompdf_gen');
		
		// Convert to PDF
		$this->dompdf->load_html($html);
		$this->dompdf->render();
		$this->dompdf->stream("Penerbit.pdf",array('Attachment'=>0));
	}

	public function ketentuan()
	{
		$data['agent'] =$this->m_masterdata->all_agent_magazine_detail();
		$data['content'] = 'laporan/ketentuan_agent';
		$this->load->view('template',$data);
	}

	public function cetak_ketentuan()
	{
		$data['agent'] =$this->m_masterdata->all_agent_magazine_detail();
		$this->load->view('laporan/print_ketentuan_agent',$data);
	}

	public function export_ketentuan()
	{
		$data['agent'] =$this->m_masterdata->all_agent_magazine_detail();
		$data['excel'] = TRUE;
		$this->load->view('laporan/print_ketentuan_agent',$data);
	}

	public function export5_ketentuan()
	{
		$this->load->library("PHPExcel/PHPExcel");

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
 		$objPHPExcel->getActiveSheet()->setCellValue('A1','LAPORAN KETENTUAN AGENT');
 		$objPHPExcel->getActiveSheet()->setCellValue('A2','No');
 		$objPHPExcel->getActiveSheet()->setCellValue('B2','Agen Category');
 		$objPHPExcel->getActiveSheet()->setCellValue('C2','Agent');
 		$objPHPExcel->getActiveSheet()->setCellValue('D2','Majalah');
 		$objPHPExcel->getActiveSheet()->setCellValue('E2','Jatah');
 		$objPHPExcel->getActiveSheet()->setCellValue('F2','Konsinyasi');
 		$objPHPExcel->getActiveSheet()->setCellValue('G2','Gratis');
 		$objPHPExcel->getActiveSheet()->setCellValue('H2','Total');

 		$objPHPExcel->getActiveSheet()->setCellValue('I2','Disc Total');
 		$objPHPExcel->getActiveSheet()->setCellValue('J2','Disc Deposit');

 		//save from database
 		$data = $this->m_masterdata->all_agent_magazine_detail();
 		$no = 1;
 		foreach ($data as $data) 
 		{
			$objPHPExcel->getActiveSheet()->setCellValue('A'.($no+2),$no);
			$objPHPExcel->getActiveSheet()->setCellValue('B'.($no+2),$data['nama_agent_cat']);
	 		$objPHPExcel->getActiveSheet()->setCellValue('C'.($no+2),$data['nama_agent']);
	 		$objPHPExcel->getActiveSheet()->setCellValue('D'.($no+2),$data['nama_majalah']);
	 		$objPHPExcel->getActiveSheet()->setCellValue('E'.($no+2),$data['jatah']);
	 		$objPHPExcel->getActiveSheet()->setCellValue('F'.($no+2),$data['konsinyasi']);
	 		$objPHPExcel->getActiveSheet()->setCellValue('G'.($no+2),$data['gratis']);
	 		$objPHPExcel->getActiveSheet()->setCellValue('H'.($no+2),$data['jatah'] + $data['konsinyasi'] + $data['gratis']);
	 		$objPHPExcel->getActiveSheet()->setCellValue('I'.($no+2),$data['disc_total']);
	 		$objPHPExcel->getActiveSheet()->setCellValue('J'.($no+2),$data['disc_deposit']);
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
        header('Content-Disposition: attachment;filename="Laporan Agent.xls"');
        //unduh file
        $objWriter->save("php://output");
	}

	public function pdf_ketentuan()
	{
		
		$data['agent'] =$this->m_masterdata->all_agent_magazine_detail();
		$this->load->view('laporan/print_ketentuan_agent',$data);
		
		// Get output html
		$html = $this->output->get_output();
		
		// Load library
		$this->load->library('dompdf_gen');
		
		// Convert to PDF
		$this->dompdf->load_html($html);
		$this->dompdf->render();
		$this->dompdf->stream("Ketentuan.pdf",array('Attachment'=>0));
	}

	public function discount()
	{
		$data['agent'] =$this->m_masterdata->all_agent_magazine_detail();
		$data['content'] = 'laporan/discount';
		$this->load->view('template',$data);
	}

	public function cetak_discount()
	{
		$data['agent'] =$this->m_masterdata->all_agent_magazine_detail();
		$this->load->view('laporan/print_discount',$data);
	}

	public function export_discount()
	{
		$this->load->library("PHPExcel/PHPExcel");

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
 		$objPHPExcel->getActiveSheet()->setCellValue('A1','LAPORAN KETENTUAN AGENT');
 		$objPHPExcel->getActiveSheet()->setCellValue('A2','No');
 		$objPHPExcel->getActiveSheet()->setCellValue('B2','Agen Category');
 		$objPHPExcel->getActiveSheet()->setCellValue('C2','Agent');
 		$objPHPExcel->getActiveSheet()->setCellValue('D2','Majalah');
 		$objPHPExcel->getActiveSheet()->setCellValue('E2','Disc Total');
 		$objPHPExcel->getActiveSheet()->setCellValue('F2','Disc Deposit');

 		//save from database
 		$data = $this->m_masterdata->all_agent_magazine_detail();
 		$no = 1;
 		foreach ($data as $data) 
 		{
			$objPHPExcel->getActiveSheet()->setCellValue('A'.($no+2),$no);
			$objPHPExcel->getActiveSheet()->setCellValue('B'.($no+2),$data['nama_agent_cat']);
	 		$objPHPExcel->getActiveSheet()->setCellValue('C'.($no+2),$data['nama_agent']);
	 		$objPHPExcel->getActiveSheet()->setCellValue('D'.($no+2),$data['nama_majalah']);
	 		$objPHPExcel->getActiveSheet()->setCellValue('E'.($no+2),$data['disc_total']);
	 		$objPHPExcel->getActiveSheet()->setCellValue('F'.($no+2),$data['disc_deposit']);
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
        header('Content-Disposition: attachment;filename="Laporan Discount Agent.xls"');
        //unduh file
        $objWriter->save("php://output");
	}

	public function pdf_discount()
	{
		
		$data['agent'] =$this->m_masterdata->all_agent_magazine_detail();
		$this->load->view('laporan/print_discount',$data);
		
		// Get output html
		$html = $this->output->get_output();
		
		// Load library
		$this->load->library('dompdf_gen');
		
		// Convert to PDF
		$this->dompdf->load_html($html);
		$this->dompdf->render();
		$this->dompdf->stream("Ketentuan.pdf",array('Attachment'=>0));
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */