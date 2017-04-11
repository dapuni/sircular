<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class retur_penjualan extends CI_Controller {

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
		$this->load->model('m_sirkulasi');
		$this->load->model('m_masterdata');
		$this->load->model('m_user');
		$this->m_user->login_trigger();
		$this->m_user->access_module(4);
		$this->load->library('pagination');
	}

	public function index($agent_cat = null,$agent = null,$majalah = null,$edisi = null)
	{	
		$agent_cat = $this->input->get('agent_cat');
		$agent = $this->input->get('agent');
		$majalah = $this->input->get('majalah');
		$edisi = $this->input->get('edisi');

		//pagination
		$page = $this->input->get('page')? $this->input->get('page'):'0';
		$per_page = 10;
		$config['uri_segment'] = 3; 	
		$config['per_page'] = $per_page; 
		$config['num_links'] = 10.3;
		$config['query_string_segment'] = 'page';
		$config['page_query_string'] = true;
		$config['base_url'] = base_url().'/sirkulasi/retur_penjualan?majalah='.$majalah.'&edisi='.$edisi;
		$config['total_rows'] = $this->m_sirkulasi->get_all_return($majalah,$edisi,0)->num_rows();

		//config for bootstrap pagination class integration
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['first_link'] = false;
        $config['last_link'] = false;
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['prev_link'] = '&laquo';
        $config['prev_tag_open'] = '<li class="prev">';
        $config['prev_tag_close'] = '</li>';
        $config['next_link'] = '&raquo';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a >';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';

		$this->pagination->initialize($config);

		$data['select_majalah'] = $majalah;
		$data['select_edisi'] = $edisi;
		$data['majalah'] =$this->m_masterdata->get_majalah();
		$data['edisi'] = $this->m_sirkulasi->get_edisi_majalah($majalah);
		$data['pagination'] = $this->pagination->create_links();
		$data['retur'] = $this->m_sirkulasi->get_all_return($majalah,$edisi,$page)->result_array();
		$data['content'] = 'retur_penjualan/retur';
		$this->load->view('template',$data);
	}

	public function tambah($majalah = null,$agent = null,$edisi = null,$return_date = null,$retur_no = null,$do = null,$keterangan = null)
	{
		$majalah = $this->input->get('majalah');
		$edisi = $this->input->get('edisi');
		$agent = $this->input->get('agent');
		$return_date = $this->input->get('return_date');
		$retur_no = $this->input->get('retur_no');
		$do = $this->input->get('do');
		$keterangan = $this->input->get('keterangan');
		$data['select_majalah'] = $majalah;
		$data['select_agent'] = $agent;
		$data['select_edisi'] = $edisi;
		$data['select_do'] = $do;
		$data['select_keterangan'] = $keterangan;
		$data['return_date'] = $return_date;
		$data['retur_no'] = $retur_no;
		$data['agent'] = $this->m_sirkulasi->get_agent();
		$data['majalah'] = $this->m_sirkulasi->get_majalah();
		$data['edisi'] = $this->m_sirkulasi->get_edisi_majalah($majalah);
		$data['do'] = $this->m_sirkulasi->get_do($agent,$edisi);
		$data['return'] = $this->m_sirkulasi->get_return($agent,$edisi);
		$data['jumlah'] = $this->m_sirkulasi->get_jumlah_do($do);
		$data['content'] = 'retur_penjualan/tambah';
		$this->load->view('template',$data);
	}

	public function simpan()
	{
		$this->form_validation->set_rules('return_no', 'Nomor Retur', 'required'); 
		$this->form_validation->set_rules('do', 'Nomor Do', 'required');
		$this->form_validation->set_rules('jumlah', 'Jumlah', 'required');
		$this->form_validation->set_rules('return_date', 'Retur Date', 'required');
				
		//get publish date
		$do = $this->m_sirkulasi->cek_edisi($this->input->post('edisi'));
		$startdate = strtotime($do['date_publish']);
		$enddate = strtotime($do['retur_date']);
		$now = strtotime("now");

		//change date format
		$return_date = $this->input->post('return_date');

		//get password to overrinde insert data
		$password = $this->input->post('password');
		//jika permintaan dari user untuk buka passwors 
		//$password = 'crabypatty';

		$data = array('no_return' => $this->input->post('return_no'),
						  'agent_id' => $this->input->post('agent'),
						  'return_date' => $return_date,
						  'majalah_id' => $this->input->post('majalah'),
						  'edisi_id' => $this->input->post('edisi'),
						  'distribution_realization_id' => $this->input->post('do'),
						  'jumlah' => $this->input->post('jumlah'),
						  'keterangan' => $this->input->post('keterangan') );
		
		//Cek jika tanggal retur melewati batas akhir retur 
		if (date('Ym',$enddate) >= date('Ym',$now) && date('Ym',$startdate) <= date('Ym',$now) || $password == 'crabypatty') {
			
			//cek tanggal retur satu priode bulan yang sama dengan sistem atau override melalui password 
			
			if (date('Ym',strtotime($return_date)) == date('Ym',$now) && date('Ymd',strtotime($return_date)) <= date('Ymd',$enddate) || $password == 'crabypatty') {
			
				//form validation
				if ($this->form_validation->run() == FALSE ) {
					$this->session->set_flashdata('confirm',validation_errors());
					redirect('sirkulasi/retur_penjualan/tambah');
				} else{
					$this->session->set_flashdata('confirm','Data sudah Di simpan');
					$this->m_sirkulasi->simpan_retur_majalah($data);
					redirect('sirkulasi/retur_penjualan/tambah?retur_no='.$this->input->post('return_no').'&return_date='.$this->input->post('return_date').'&agent='.$this->input->post('agent'));
				}
				
			} else {
				$this->session->set_flashdata('confirm','Data tidak bisa diinput! Melewati Periode waktu inputan');
				redirect('sirkulasi/retur_penjualan/tambah');
			}
		} else {
			$this->session->set_flashdata('confirm','Data tidak bisa diinput! Melewati batas waktu inputan');
			redirect('sirkulasi/retur_penjualan/tambah');
		}
	}

	public function detail($id,$majalah = null,$agent = null,$edisi = null,$retur_date = null,$retur_no = null,$do = null,$keterangan = null)
	{
		$majalah = $this->input->get('majalah');
		$edisi = $this->input->get('edisi');
		$agent = $this->input->get('agent');
		$return_date = $this->input->get('return_date');
		$retur_no = $this->input->get('retur_no');
		$do = $this->input->get('do');
		$keterangan = $this->input->get('keterangan');
		$data['id'] = $id;
		$data['select_majalah'] = $majalah;
		$data['select_agent'] = $agent;
		$data['select_edisi'] = $edisi;
		$data['select_do'] = $do;
		$data['select_keterangan'] = $keterangan;
		$data['return_date'] = $return_date;
		$data['retur_no'] = $retur_no;
		$data['agent'] = $this->m_masterdata->get_agent();
		$data['majalah'] = $this->m_sirkulasi->get_majalah();
		$data['edisi'] = $this->m_sirkulasi->get_edisi_majalah($majalah);
		$data['do'] = $this->m_sirkulasi->get_do($agent,$edisi);
		$data['return'] = $this->m_sirkulasi->get_one_return_item($id);
		$data['return_all'] = $this->m_sirkulasi->get_return($agent,$edisi);
		$data['jumlah'] = $this->m_sirkulasi->get_jumlah_do($do);
		$data['content'] = 'retur_penjualan/edit';
		$this->load->view('template',$data);
	}

	public function hapus($return_item_id)
	{
		$check = $this->m_sirkulasi->get_one_return_item($return_item_id);
		$startdate = strtotime($check['date_publish']);
		$return_date = strtotime($check['return_date']);
		$now = strtotime("now");
		
		//cek jika dalam satu periode dan belum ada invoice date('Ym',$return_date) <= date('Ym',$now) && 
		if ($check['invoice'] == 0 ) 
		{
			$this->session->set_flashdata('confirm','Data sudah Di Hapus');
			$this->m_sirkulasi->hapus_return_item($return_item_id);
			redirect('sirkulasi/retur_penjualan');
		} else {
			$this->session->set_flashdata('confirm','Data Gagal Di Hapus Atau Invoice Sudah ada');
			redirect('sirkulasi/retur_penjualan');
		}
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */