<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Agent extends CI_Controller {

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
		$this->m_user->access_module(13);
		$this->m_user->login_trigger();
	}

	public function index($category_agent = null,$city = null)
	{	
		$category_agent = $this->input->get('category_agent');
		$city = $this->input->get('kota');

		//pagination
		$page = $this->input->get('page')?$this->input->get('page'):'0';
		$per_page = 10;
		$config['uri_segment'] = 3; 	
		$config['per_page'] = $per_page; 
		$config['num_links'] = 10.3;
		$config['query_string_segment'] = 'page';
		$config['page_query_string'] = true;
		$config['base_url'] = base_url().'/masterdata/agent?category_agent='.$category_agent.'&kota='.$city;
		$config['total_rows'] = $this->m_masterdata->find_agent($category_agent,$city,0)->num_rows();

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
		$category_agent = $this->input->get('category_agent');
		$city = $this->input->get('kota');
		$data['category'] = $category_agent;
		$data['city'] = $city;
		$data['category_agent'] = $this->m_masterdata->get_agent_cat();
		$data['kota'] = $this->m_masterdata->get_city();
		$data['agent'] = $this->m_masterdata->find_agent($category_agent,$city,$page)->result_array();
		$data['content'] = 'agent/agent';
		$this->load->view('template',$data);
	}

	public function tambah()
	{
		$data['accounting'] = $this->m_user->sessionAccess(1);;
		$data['kota'] =$this->m_masterdata->get_city();
		$data['url'] = 'masterdata/agent/simpan';
		$data['agent_cat'] = $this->m_masterdata->get_agent_cat();
		$data['content'] = 'agent/tambah';
		$this->load->view('template',$data);
	}

	public function simpan()
	{
		$this->form_validation->set_rules('nama_agent','Agent Name','required');
		$this->form_validation->set_rules('address','Alamat','required');

		$data = $this->input->post();
		if ($this->form_validation->run() == TRUE) 
		{
			$this->m_masterdata->tambah_agent($data);
			$this->session->set_flashdata('confirm', 'Data Sudah Di Simpan');
		} else{
			$this->session->set_flashdata('confirm',validation_errors());
		}
		
		redirect('masterdata/agent');
	}

	public function delete($id)
	{
		$this->session->set_flashdata('confirm','Data Sudah Dihapus');
		$this->m_masterdata->hapus_agent($id);
		redirect('masterdata/agent');
	}

	public function edit($id)
	{
		$data['accounting'] = $this->m_user->sessionAccess(1);;
		$data['kota'] =$this->m_masterdata->get_city();
		$data['url'] = 'masterdata/agent/update/'.$id;
		$data['agent_cat'] = $this->m_masterdata->get_agent_cat();
		$data['agent'] = $this->m_masterdata->edit_agent($id);
		$data['content'] = 'agent/tambah';
		$this->load->view('template',$data);
	}

	public function cari()
	{
		$category_agent = $this->input->get('category_agent');
		$city = $this->input->get('kota');
		$data['category'] = $category_agent;
		$data['city'] = $city;
		$data['category_agent'] = $this->m_masterdata->get_agent_cat();
		$data['kota'] = $this->m_masterdata->get_city();
		$data['agent'] = $this->m_masterdata->find_agent($category_agent,$city);
		$data['content'] = 'agent/agent';
		$this->load->view('template',$data);
	} 
	public function update($id)
	{
		$this->form_validation->set_rules('nama_agent','Agent Name','required');
		$this->form_validation->set_rules('address','Alamat','required');
		
		$data = $this->input->post();

		if ($this->form_validation->run() == TRUE) 
		{
			$this->m_masterdata->update_agent($id,$data);
			$this->session->set_flashdata('confirm','Data Sudah Diupdate');
		} else{
			$this->session->set_flashdata('confirm',validation_errors());
		}

		redirect('masterdata/agent');	
	}

	public function relation($id)
	{
		$data['accounting'] = $this->m_user->sessionAccess(1);;
		$data['id'] = $id;
		$data['agent'] = $this->m_masterdata->edit_agent($id);
		$data['data_majalah'] = $this->m_masterdata->get_agent_magazine_detail_by_agent($id);
		$data['majalah'] = $this->m_masterdata->get_majalah();
		$data['content'] = 'agent/relation';
		$this->load->view('template',$data);
	}

	public function simpan_relation($id)
	{
		$majalah = $this->input->post('majalah');
		$jatah = $this->input->post('jatah');
		$konsinyasi = $this->input->post('konsinyasi');
		$gratis = $this->input->post('gratis');
		$disc_total = $this->input->post('disc_total');
		$disc_simpan = $this->input->post('disc_simpan');

		for ($i=0; $i < count($jatah); $i++) 
		{ 
			if ($jatah[$i] OR $konsinyasi[$i] OR $gratis[$i]) 
			{
				//check data add or update
				$check = $this->m_masterdata->check_agent_magazine_detail($id,$majalah[$i]);
				$data = array('agent_id' => $id,
							  'majalah_id' => $majalah[$i],
							  'jatah' => $jatah[$i],
							  'konsinyasi' => $konsinyasi[$i],
							  'gratis' => $gratis[$i],
							  'disc_total' => $disc_total[$i],
							  'disc_deposit' => $disc_simpan[$i]);
				if ($check == 1) {
					$this->m_masterdata->update_agent_magazine_detail($id,$majalah[$i],$data);
				} else {
					$this->m_masterdata->simpan_agent_magazine_detail($data);
				}
			}
		}
		$this->session->set_flashdata('confirm', 'Data Sudah Di Simpan');
		redirect('masterdata/agent/relation/'.$id);	
	}

	public function clearstatus($agent_id,$majalah)
	{
		$check = $this->m_masterdata->check_agent_magazine_detail($agent_id,$majalah);
		echo $check;
		if ($this->session->userdata('group') >= 1) {
			if ($check == 1) {
				$this->m_masterdata->hapus_agent_magazine_detail($agent_id,$majalah);
				$this->session->set_flashdata('confirm', 'Data Sudah Di Hapus');
			} else {
				$this->session->set_flashdata('confirm', 'Data Gagal Di Hapus');
			}
		} else {
			$this->session->set_flashdata('confirm', 'You don\'t have access to this area. Please contact your Administrator.');
		}
		redirect('masterdata/agent/relation/'.$agent_id);	
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */