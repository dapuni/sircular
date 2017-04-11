<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Edisi extends CI_Controller {

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
		$this->load->library('pagination');
		$this->m_user->login_trigger();
		$this->m_user->access_module(11);
	}

	public function index($cari = null)
	{
		$cari = $this->input->get('cari');;

		//pagination
		$page = $this->input->get('page')?$this->input->get('page'):'0';
		$per_page = 10;
		$config['uri_segment'] = 3; 	
		$config['per_page'] = $per_page; 
		$config['num_links'] = 10.3;
		$config['query_string_segment'] = 'page';
		$config['page_query_string'] = true;
		$config['base_url'] = base_url().'/masterdata/edisi?cari='.$cari;
		$config['total_rows'] = $this->m_masterdata->cari_edisi($cari,0)->num_rows();

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

		$data['pagination'] = $this->pagination->create_links();
		$data['edisi'] = $this->m_masterdata->cari_edisi($cari,$page)->result_array();
		$data['cari'] = $cari;
		$data['url'] = 'masterdata/edisi';
		$data['majalah'] = $this->m_masterdata->get_majalah();
		$data['content'] = 'edisi/edisi';
		$this->load->view('template',$data);
	}

	public function tambah()
	{
		$data['accounting'] = $this->m_user->sessionAccess(1);
		$data['label'] = 'Tambah Edisi';
		$data['url'] = 'masterdata/edisi/simpan';
		$data['majalah'] = $this->m_masterdata->get_majalah();
		$data['content'] = 'edisi/tambah';
		$this->load->view('template',$data);
	}

	public function simpan()
	{
		$this->form_validation->set_rules('kode_edisi','Edition Code','required');
		$this->form_validation->set_rules('majalah_id','Majalah','required');
		$this->form_validation->set_rules('harga','Harga','required');
		$this->form_validation->set_rules('retur_date','Tanggal Retur','required');

		$data = $this->input->post();

		if ($this->form_validation->run() == TRUE) 
		{
			$this->m_masterdata->tambah_edisi($data);
			$this->session->set_flashdata('confirm', 'Data Sudah Di Simpan');
		} else{
			$this->session->set_flashdata('confirm',validation_errors());
		}
		redirect('masterdata/edisi');
	}
	
	public function edit($id)
	{
		$data['accounting'] = $this->m_user->sessionAccess(1);
		$data['label'] = 'Update Edisi';
		$data['url'] = 'masterdata/edisi/update/'.$id;
		$data['majalah'] = $this->m_masterdata->get_majalah();
		$data['edisi'] = $this->m_masterdata->edit_edisi($id);
		$data['content'] = 'edisi/tambah';
		$this->load->view('template',$data);
	}

	public function update($id)
	{
		$data = $this->input->post();
		$this->m_masterdata->update_edisi($id,$data);
		redirect('masterdata/edisi');
	} 

	public function cari()
	{
		$cari = $this->input->get('cari');
		$data['cari'] = $cari;
		$data['edisi'] = $this->m_masterdata->cari_edisi($cari);
		$data['url'] = 'masterdata/edisi/cari';
		$data['majalah'] = $this->m_masterdata->get_majalah();
		$data['content'] = 'edisi/edisi';
		$this->load->view('template',$data);
	}

	public function delete($id)
	{
		$this->session->set_flashdata('confirm', 'Data Sudah Di Hapus');
		$this->m_masterdata->hapus_edisi($id);
		redirect('masterdata/edisi');
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */