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
		$this->load->library('pagination');
		$this->m_user->login_trigger();
		$this->m_user->access_module(9);
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
		$config['base_url'] = base_url().'/masterdata/penerbit?cari='.$find;
		$config['total_rows'] = $this->m_masterdata->find_penerbit($find,0)->num_rows();

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
		$data['city'] = $this->m_masterdata->get_city();
		$data['data'] = $this->m_masterdata->find_penerbit($find,$page)->result_array();
		$data['content'] = 'penerbit/penerbit';
		$this->load->view('template',$data);
	}

	public function tambah()
	{
		$data['city'] = $this->m_masterdata->get_city();
		$data['provinsi'] = $this->m_masterdata->get_provinsi();
		$data['url'] = 'masterdata/penerbit/save';
		$data['label'] = 'Tambah Penerbit';
		$data['content'] = 'penerbit/tambah';
		$this->load->view('template',$data);
	}

	public function save()
	{
		$this->form_validation->set_rules('nama','Nama','required');
		$this->form_validation->set_rules('alamat','alamat','required');
		$this->form_validation->set_rules('phone_1','phone 1','required');

		$phone = $this->input->post('phone_1').','.$this->input->post('phone_2');
		$contact = $this->input->post('contact_1').','.$this->input->post('contact_2');
		$jabatan = $this->input->post('jabatan_1').','.$this->input->post('jabatan_2');
		$bank = $this->input->post('bank_1').','.$this->input->post('bank_2');
		$rekening = $this->input->post('rek_1').','.$this->input->post('rek_2');
		$data = array('nama' => $this->input->post('nama'),
					  'npwp' => $this->input->post('npwp'),
					  'pkp' => $this->input->post('pkp'),
					  'authorized_signature' => $this->input->post('authorized_signature'),
					  'alamat' => $this->input->post('alamat'),
					  'kota' => $this->input->post('kota'),
					  'provinsi' => $this->input->post('provinsi'),
					  'kode_pos' => $this->input->post('kode_pos'),
					  'phone' => $phone,
					  'fax' => $this->input->post('fax'),
					  'email' => $this->input->post('email'),
					  'contact' => $contact,
					  'jabatan' => $jabatan,
					  'bank' => $bank,
					  'rekening' => $rekening, );
		if ($this->form_validation->run() == TRUE) 
		{
			$this->m_masterdata->tambah_penerbit($data);
			$this->session->set_flashdata('confirm','Data Sudah Disimpan');
		} else{
			$this->session->set_flashdata('confirm',validation_errors());
		}
		redirect('masterdata/penerbit');
	}

	public function delete($id)
	{
		$this->m_masterdata->hapus_penerbit($id);
		$this->session->set_flashdata('confirm','Data Sudah Dihapus');
		redirect('masterdata/penerbit');
	}

	public function edit($id)
	{
		$data['city'] = $this->m_masterdata->get_city();
		$data['label'] = 'Update Penerbit';
		$data['provinsi'] = $this->m_masterdata->get_provinsi();
		$data['url'] = 'masterdata/penerbit/update/'.$id;
		$data['data'] = $this->m_masterdata->edit_penerbit($id);
		$data['content'] = 'penerbit/tambah';
		$this->load->view('template',$data);
	}

	public function update($id)
	{
		$this->form_validation->set_rules('nama','Nama','required');
		$this->form_validation->set_rules('alamat','alamat','required');
		$this->form_validation->set_rules('phone_1','phone 1','required');

		$phone = $this->input->post('phone_1').','.$this->input->post('phone_2');
		$contact = $this->input->post('contact_1').','.$this->input->post('contact_2');
		$jabatan = $this->input->post('jabatan_1').','.$this->input->post('jabatan_2');
		$bank = $this->input->post('bank_1').','.$this->input->post('bank_2');
		$rekening = $this->input->post('rek_1').','.$this->input->post('rek_2');
		$data = array('nama' => $this->input->post('nama'),
					  'npwp' => $this->input->post('npwp'),
					  'pkp' => $this->input->post('pkp'),
					  'authorized_signature' => $this->input->post('authorized_signature'),
					  'alamat' => $this->input->post('alamat'),
					  'kota' => $this->input->post('kota'),
					  'provinsi' => $this->input->post('provinsi'),
					  'kode_pos' => $this->input->post('kode_pos'),
					  'phone' => $phone,
					  'fax' => $this->input->post('fax'),
					  'email' => $this->input->post('email'),
					  'contact' => $contact,
					  'jabatan' => $jabatan,
					  'bank' => $bank,
					  'rekening' => $rekening, );
		if ($this->form_validation->run() == TRUE) 
		{
			$this->m_masterdata->update_penerbit($id,$data);
			$this->session->set_flashdata('confirm','Data Sudah Diupdate');
		} else{
			$this->session->set_flashdata('confirm',validation_errors());
		}
		redirect('masterdata/penerbit');
	}

	public function cari()
	{
		$find = $this->input->get('cari');
		$data['find']= $find;
		$data['city'] = $this->m_masterdata->get_city();
		$data['data'] = $this->m_masterdata->find_penerbit($find);
		$data['content'] = 'penerbit/penerbit';
		$this->load->view('template',$data);
	}
}
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */