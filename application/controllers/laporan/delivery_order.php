<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class delivery_order extends CI_Controller {

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

		$data['majalah'] =$this->m_masterdata->get_majalah();
		$data['select_majalah'] = $majalah;
		$data['edisi'] = $this->m_sirkulasi->get_edisi_majalah($majalah);
		$data['select_edisi'] = $edisi;
		$data['laporan'] = $this->m_sirkulasi->get_laporan_do($edisi); 
		$data['content'] = 'laporan/delivery_order';
		$this->load->view('template',$data);
	}

	public function cetak($majalah = null,$edisi = null)
	{
		$edisi = $this->input->get('edisi');
		$majalah = $this->input->get('majalah');

		$data['nama_majalah'] = $this->db->query('select nama_majalah from majalah where majalah_id ='.$majalah)->row_array();
		$data['kode_edisi'] = $this->db->query('select kode_edisi from edisi where edisi_id ='.$edisi)->row_array();
		$data['laporan'] = $this->m_sirkulasi->get_laporan_do($edisi); 
		$this->load->view('laporan/print_delivery_order',$data);
	}

	public function pdf()
	{
		
		$edisi = $this->input->get('edisi');
		$majalah = $this->input->get('majalah');

		$data['nama_majalah'] = $this->db->query('select nama_majalah from majalah where majalah_id ='.$majalah)->row_array();
		$data['kode_edisi'] = $this->db->query('select kode_edisi from edisi where edisi_id ='.$edisi)->row_array();
		$data['laporan'] = $this->m_sirkulasi->get_laporan_do($edisi); 
		$this->load->view('laporan/print_delivery_order',$data);
		
		// Get output html
		$html = $this->output->get_output();
		
		// Load library
		$this->load->library('dompdf_gen');
		
		// Convert to PDF
		$this->dompdf->load_html($html);
		$this->dompdf->render();
		$this->dompdf->stream("realisasi_distribusi.pdf",array('Attachment'=>0));
	}

	public function excel($majalah = null,$edisi = null)
	{
		$edisi = $this->input->get('edisi');
		$majalah = $this->input->get('majalah');

		$data['nama_majalah'] = $this->db->query('select nama_majalah from majalah where majalah_id ='.$majalah)->row_array();
		$data['kode_edisi'] = $this->db->query('select kode_edisi from edisi where edisi_id ='.$edisi)->row_array();
		$data['excel'] = TRUE;
		$data['laporan'] = $this->m_sirkulasi->get_laporan_do($edisi); 
		$this->load->view('laporan/print_delivery_order',$data);
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

 		//header tabel 
 		$objPHPExcel->getActiveSheet()->mergeCells('A1:C1');
 		$objPHPExcel->getActiveSheet()->setCellValue('A1','LAPORAN DATA DELIVERY ORDER');
 		$objPHPExcel->getActiveSheet()->setCellValue('A2','No');
 		$objPHPExcel->getActiveSheet()->setCellValue('B2','Tanggal DO');
 		$objPHPExcel->getActiveSheet()->setCellValue('C2','Nomor DO');
 		$objPHPExcel->getActiveSheet()->setCellValue('D2','Nama Agent');
 		$objPHPExcel->getActiveSheet()->setCellValue('E2','Jatah');
 		$objPHPExcel->getActiveSheet()->setCellValue('F2','Konsinyasi');
 		$objPHPExcel->getActiveSheet()->setCellValue('G2','Gratis');
 		$objPHPExcel->getActiveSheet()->setCellValue('H2','Total');

 		//save from database
 		$data = $this->m_sirkulasi->get_laporan_do($edisi);
 		$nama = '';
 		$no = 1;
 		foreach ($data as $data) 
 		{
			$objPHPExcel->getActiveSheet()->setCellValue('A'.($no+2),$no);
			$objPHPExcel->getActiveSheet()->setCellValue('B'.($no+2),date('d/m/Y',strtotime($data['date_created'])));
			$objPHPExcel->getActiveSheet()->setCellValue('C'.($no+2),date('y',strtotime($data['date_created']))."/0".$data['distribution_realization_detail_id']);
			
			if ($nama != $data['nama_agent']) {
				$objPHPExcel->getActiveSheet()->setCellValue('D'.($no+2),$data['nama_agent']);
				$nama = $data['nama_agent'];
			}
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
        header('Content-Disposition: attachment;filename="Laporan DO.xls"');
        //unduh file
        $objWriter->save("php://output");
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */