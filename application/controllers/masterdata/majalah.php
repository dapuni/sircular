<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class majalah extends CI_Controller {

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
		$this->m_user->access_module(10);
	}

	public function index($find = null)
	{
		$find = $this->input->get('cari');
		//pagination
		$page = $this->input->get('page')?$this->input->get('page'):'0';
		$per_page = 10;
		$config['uri_segment'] = 3; 	
		$config['per_page'] = $per_page; 
		$config['num_links'] = 10.3;
		$config['query_string_segment'] = 'page';
		$config['page_query_string'] = true;
		$config['base_url'] = base_url().'/masterdata/majalah?cari='.$find;
		$config['total_rows'] = $this->m_masterdata->find_majalah($find,0)->num_rows();

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
		$data['penerbit'] = $this->m_masterdata->get_penerbit();
		$data['data'] = $this->m_masterdata->find_majalah($find,$page)->result_array();
		$data['find'] = $find;
		$data['content'] = 'majalah/majalah';
		$this->load->view('template',$data);
	}

	public function tambah()
	{
		$data['legend'] = 'Tambah Majalah';
		$data['url'] = 'masterdata/majalah/save';
		$data['penerbit'] = $this->m_masterdata->get_penerbit();
		$data['content'] = 'majalah/tambah';
		$this->load->view('template',$data);
	}

	public function save()
	{
		$this->form_validation->set_rules('nama_majalah','Nama Majalah','required');
		$this->form_validation->set_rules('penerbit_id','Publisher','required');

		$data = $this->input->post();

		if ($this->form_validation->run() == TRUE) 
		{
			$this->m_masterdata->tambah_majalah($data);
			$this->session->set_flashdata('confirm', 'Data Sudah Disimpan');
		} else{
			$this->session->set_flashdata('confirm',validation_errors());
		}
		redirect('masterdata/majalah');
	}

	public function edit($id)
	{
		$data['url'] = 'masterdata/majalah/update/'.$id;
		$data['penerbit'] = $this->m_masterdata->get_penerbit();
		$data['legend'] = 'Update Majalah';
		$data['data'] = $this->m_masterdata->edit_majalah($id);
		$data['content'] = 'majalah/tambah';
		$this->load->view('template',$data);
	}

	public function update($id)
	{
		$this->form_validation->set_rules('nama_majalah','Nama Majalah','required');
		$this->form_validation->set_rules('penerbit_id','Publisher','required');

		$data = $this->input->post();

		if ($this->form_validation->run() == TRUE) 
		{
			$this->m_masterdata->update_majalah($id,$data);
			$this->session->set_flashdata('confirm', 'Data Sudah Di Update');
		} else{
			$this->session->set_flashdata('confirm',validation_errors());
		}
		redirect('masterdata/majalah');
	}

	public function delete($id)
	{
		$this->m_masterdata->hapus_majalah($id);
		$this->session->set_flashdata('confirm', 'Data Sudah Di Hapus');
		redirect('masterdata/majalah');	
	}

	public function agent($id)
	{
		$data['accounting'] = $this->m_user->sessionAccess(1);
		$data['agent_cat'] = $this->m_masterdata->get_agent_cat();
		$data['agent'] =$this->m_masterdata->get_agent();
		$data['agent_magazine_detail'] =$this->m_masterdata->get_agent_magazine_detail($id);
		$data['id'] = $id;
		$data['majalah'] = $this->m_masterdata->edit_majalah($id);
		$data['content'] = 'majalah/agent';
		$this->load->view('template',$data);
	}

	public function relasi_agent($id)
	{
		$agent = $this->input->post('agent'); 
		$majalah = $this->input->post('majalah'); 
		$jatah = $this->input->post('jatah');
		$konsinyasi = $this->input->post('konsinyasi');
		$gratis = $this->input->post('gratis');
		$disc_total = $this->input->post('disc_total');
		$disc_simpan = $this->input->post('disc_simpan');

		for ($i=0; $i < count($jatah); $i++) 
		{ 
			//check if all have a data
			if ($jatah[$i] OR $konsinyasi[$i] OR $gratis[$i]) 
			{
				$data = array('agent_id' => $agent[$i],
							  'majalah_id' => $majalah,
							  'jatah' => $jatah[$i],
							  'konsinyasi' => $konsinyasi[$i],
							  'gratis' => $gratis[$i],
							  'disc_total' => $disc_total[$i],
							  'disc_deposit' => $disc_simpan[$i]);
				//check if newdata or update
				$check = $this->m_masterdata->check_agent_magazine_detail($agent[$i],$majalah);
				//echo $check;
				if ($check == 1) {
					$this->m_masterdata->update_agent_magazine_detail($agent[$i],$majalah,$data);
				} else {
					$this->m_masterdata->simpan_agent_magazine_detail($data);
				}
				$this->session->set_flashdata('confirm', 'Data Sudah Di Simpan');
			}
		}
		redirect('masterdata/majalah/agent/'.$id);	
	}

	public function cari()
	{
		$find = $this->input->get('cari');
		$data['find'] = $find;
		$data['penerbit'] = $this->m_masterdata->get_penerbit();
		$data['data'] = $this->m_masterdata->find_majalah($find);
		$data['content'] = 'majalah/majalah';
		$this->load->view('template',$data);
	}

	public function clearstatus($majalah,$agent_id)
	{
		$check = $this->m_masterdata->check_agent_magazine_detail($agent_id,$majalah);
		if ($this->session->userdata('group') >= 1 ) {
			if ($check == 1) {
				$this->m_masterdata->hapus_agent_magazine_detail($agent_id,$majalah);
				$this->session->set_flashdata('confirm', 'Data Sudah Di Hapus');
			} else {
				$this->session->set_flashdata('confirm', 'Data Gagal Di Hapus');
			}
		} else {
			$this->session->set_flashdata('confirm', 'You don\'t have access to this area. Please contact your Administrator.');
		}
		redirect('masterdata/majalah/agent/'.$majalah);	
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */