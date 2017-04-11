<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class penerbit extends CI_Controller {

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
		$data['majalah'] =$this->m_masterdata->get_majalah();
		$data['content'] = 'laporan/penerbit';
		$this->load->view('template',$data);
	}

	public function cetak()
	{
		$data['majalah'] =$this->m_masterdata->get_majalah();
		$this->load->view('laporan/print_penerbit',$data);
	}

	public function export()
	{
		$data['majalah'] = $this->m_masterdata->get_majalah();
		$data['excel'] = TRUE;
		$this->load->view('laporan/print_penerbit',$data);
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
 		$objPHPExcel->getActiveSheet()->setCellValue('A1','LAPORAN DATA PENERBIT');
 		$objPHPExcel->getActiveSheet()->setCellValue('A2','No');
 		$objPHPExcel->getActiveSheet()->setCellValue('B2','Penerbit');
 		$objPHPExcel->getActiveSheet()->setCellValue('C2','NPWP');
 		$objPHPExcel->getActiveSheet()->setCellValue('D2','Alamat');
 		$objPHPExcel->getActiveSheet()->setCellValue('E2','Telpon');
 		$objPHPExcel->getActiveSheet()->setCellValue('F2','Majalah');

 		//save from database
 		$data = $this->m_masterdata->get_majalah();
 		$nama = '';
 		$no = 1;
 		foreach ($data as $data) 
 		{
			$objPHPExcel->getActiveSheet()->setCellValue('A'.($no+2),$no);
			
			if ($nama != $data['nama']) {
				$objPHPExcel->getActiveSheet()->setCellValue('B'.($no+2),$data['nama']);
				$nama = $data['nama'];
			}
	 		
	 		$objPHPExcel->getActiveSheet()->setCellValue('C'.($no+2),$data['npwp']);
	 		$objPHPExcel->getActiveSheet()->setCellValue('D'.($no+2),$data['alamat']);
	 		$objPHPExcel->getActiveSheet()->setCellValue('E'.($no+2),$data['phone']);
	 		$objPHPExcel->getActiveSheet()->setCellValue('F'.($no+2),$data['nama_majalah']);
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
        header('Content-Disposition: attachment;filename="Laporan Penerbit.xls"');
        //unduh file
        $objWriter->save("php://output");
	}

	public function pdf()
	{
		
		$data['majalah'] =$this->m_masterdata->get_majalah();
		$this->load->view('laporan/print_penerbit',$data);
		
		// Get output html
		$html = $this->output->get_output();
		
		// Load library
		$this->load->library('dompdf_gen');
		
		// Convert to PDF
		$this->dompdf->load_html($html);
		$this->dompdf->render();
		$this->dompdf->stream("Penertbit.pdf",array('Attachment'=>0));
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */