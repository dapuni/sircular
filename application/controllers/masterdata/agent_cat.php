<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Agent_cat extends CI_Controller {

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
		$this->m_user->access_module(12);
	}

	public function index()
	{
		$data['agent_cat'] = $this->m_masterdata->get_agent_cat();
		$data['content'] = 'agent_cat/agent_cat';
		$this->load->view('template',$data);
	}

	public function tambah()
	{
		$data['url'] = 'masterdata/agent_cat/simpan';
		$data['content'] = 'agent_cat/tambah';
		$this->load->view('template',$data);
	}

	public function simpan()
	{
		$this->form_validation->set_rules('nama_agent_cat','Agent Category','required');

		$data = $this->input->post();

		if ($this->form_validation->run() == TRUE) 
		{
			$this->m_masterdata->tambah_agent_cat($data);
			$this->session->set_flashdata('confirm','Data sudah Di Simpan');
		} else{
			$this->session->set_flashdata('confirm',validation_errors());
		}
		redirect('masterdata/agent_cat');
	}

	public function edit($id)
	{
		$data['url'] = 'masterdata/agent_cat/update/'.$id;
		$data['agent_cat'] = $this->m_masterdata->edit_agent_cat($id);
		$data['content'] = 'agent_cat/tambah';
		$this->load->view('template',$data);
	}

	public function update($id)
	{
		$this->form_validation->set_rules('nama_agent_cat','Agent Category','required');
		
		$data = $this->input->post();

		if ($this->form_validation->run() == TRUE) 
		{
			$this->m_masterdata->update_agent_cat($id,$data);
			$this->session->set_flashdata('confirm','Data sudah Di Update');
		} else{
			$this->session->set_flashdata('confirm',validation_errors());
		}
		redirect('masterdata/agent_cat');
	}

	public function delete($id)
	{
		$this->m_masterdata->hapus_agent_cat($id,$data);
		$this->session->set_flashdata('confirm','Data sudah Di Hapus');
		redirect('masterdata/agent_cat');
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */