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
		$this->load->model('m_sirkulasi');
		$this->load->model('m_masterdata');
		$this->load->model('m_user');
		$this->m_user->login_trigger();
		$this->m_user->access_module(2);
		$this->load->library('pagination');
	}

	public function index($majalah = null)
	{	
		$majalah = $this->input->get('majalah');
		//pagination
		$page = $this->input->get('page')?$this->input->get('page'):'0';
		$per_page = 10;
		$config['uri_segment'] = 3; 	
		$config['per_page'] = $per_page; 
		$config['num_links'] = 10.3;
		$config['query_string_segment'] = 'page';
		$config['page_query_string'] = true;
		$config['base_url'] = base_url().'/sirkulasi/rencana_distribusi?majalah='.$majalah;
		$config['total_rows'] = $this->m_sirkulasi->get_rencana_distribusi($majalah,0)->num_rows();

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
		$data['search'] = $this->input->get('majalah');
		$data['majalah'] =  $this->m_sirkulasi->get_majalah();
		$data['rencana'] = $this->m_sirkulasi->get_rencana_distribusi($majalah,$page)->result_array();
		$data['content'] = 'rencana_distribusi/distribusi';
		$this->load->view('template',$data);
	}

	public function tambah()
	{
		$data['majalah'] = $this->m_sirkulasi->get_majalah();
		$data['content'] = 'rencana_distribusi/tambah';
		$this->load->view('template',$data);
	}

	public function simpan()
	{
		$this->form_validation->set_rules('majalahy', 'majalah', 'required'); 
		$this->form_validation->set_rules('edisiy', 'Edisi', 'required');
		$this->form_validation->set_rules('plan_print', 'Plan print', 'required'); 
		$this->form_validation->set_rules('publish_date', 'Publish Date', 'required');

		$majalah = $this->input->post('majalahy');
		$edisi = $this->input->post('edisiy');
		$plan_print = $this->input->post('plan_print');
		$publish_date = $this->input->post('publish_date');
		
		//check edisi
		$checkedisi = $this->m_sirkulasi->cek_edisi($edisi);

		if ($checkedisi == null && $this->form_validation->run() != FALSE) 
		{
	
			$data = array('edisi_id' => $edisi,
					  'print' => $plan_print,
					  'date_publish' =>$publish_date );
			$this->m_sirkulasi->simpan_rencana_distribusi($data);
			$distribution_plan_id = $this->m_sirkulasi->get_last_distribution_plan_id();
			
			//save detail rencana distribusi from agent_magazine_ detail
			$data_for_rencana_id = $this->m_sirkulasi->get_agent_magazine_detail($majalah);
			foreach ($data_for_rencana_id as $data_for_rencana_id) 
			{
				$data = array('distribution_plan_id' => $distribution_plan_id['distribution_plan_id'],
							  'agent_id' => $data_for_rencana_id['agent_id'],
							  'quota' => $data_for_rencana_id['jatah'],
							  'consigned' => $data_for_rencana_id['konsinyasi'],
							  'gratis' => $data_for_rencana_id['gratis'],
							  'disc_total' => $data_for_rencana_id['disc_total'],
							  'disc_deposit' => $data_for_rencana_id['disc_deposit'] );

				//add to distribution plan detail
				$this->m_sirkulasi->tambah_agent_detail($data);
				
				//add to distribution plan realization
				//$this->m_sirkulasi->tambah_agent_realizaton_detail($data);
			}
			$this->session->set_flashdata('confirm','Data sudah Di Tambahkan');
			redirect('sirkulasi/rencana_distribusi');
		} else {
			$this->session->set_flashdata('confirm','Something Error. Silahkan dicek kembali');
			redirect('sirkulasi/rencana_distribusi/tambah');
		}
	}

	public function simpan_from_prev()
	{
		$this->form_validation->set_rules('prev_edition', 'Previous Edition', 'required'); 
		$this->form_validation->set_rules('majalahx', 'Majalah', 'required');
		$this->form_validation->set_rules('edisix', 'Edisi', 'required'); 
		$this->form_validation->set_rules('publish_date', 'Publish Date', 'required');

		$prev_edition = $this->input->post('prev_edition');
		$majalah = $this->input->post('majalahx');
		$edisi = $this->input->post('edisix');
		$publish_date = $this->input->post('publish_date');

		//check edisi and change format date
		$checkedisi = $this->m_sirkulasi->cek_edisi($edisi);
		$check_pev = $this->m_sirkulasi->cek_edisi($prev_edition);
		
		// if edisi empty and prev is not empty
		if (empty($checkedisi) && !empty($check_pev) && $this->form_validation->run() == TRUE) 
		{
			//create distribution_plan form prev_edition
			$distribution_plan_prev_edition = $this->m_sirkulasi->get_one_rencana_distribusi_from_prev($prev_edition);

			if (!empty($distribution_plan_prev_edition)) {
				//save distribution plan
				$data = array('edisi_id' => $edisi,
					  'print' => $distribution_plan_prev_edition['print'],
					  'date_publish' => $publish_date);
				$this->m_sirkulasi->simpan_rencana_distribusi($data);
				
				//get last data distribution plan
				$last_data = $this->m_sirkulasi->get_last_distribution_plan_id();
				
				//collect all data from distribution plan detail based on prev_edition
				$all_data_from_prev = $this->m_sirkulasi->get_rencana_distribusi_detail_from_prev($prev_edition);
				
				foreach ($all_data_from_prev as $all_data_from_prev) 
				{
					$data = array('distribution_plan_id' => $last_data['distribution_plan_id'],
						  'agent_id' => $all_data_from_prev['agent_id'],
						  'quota' => $all_data_from_prev['quota'],
						  'consigned' => $all_data_from_prev['consigned'],
						  'gratis' => $all_data_from_prev['gratis'],
						  'disc_total' => $all_data_from_prev['disc_total'],
						  'disc_deposit' => $all_data_from_prev['disc_deposit'] );
					$this->m_sirkulasi->tambah_agent_detail($data);
				}
			} else {
				$this->session->set_flashdata('confirm','Insert Previous Edition Error, Please Check Carefully');
				redirect('sirkulasi/rencana_distribusi/tambah');
			}
			$this->session->set_flashdata('confirm','Data sudah Di Tambahkan');
			redirect('sirkulasi/rencana_distribusi');
		} else {
			$this->session->set_flashdata('confirm','Insert Previous Edition Error, Please Check Carefully');
			redirect('sirkulasi/rencana_distribusi/tambah');
		}
		
	}

	public function edit($id)
	{
		$data['id'] = $id;
		$data['rencana'] =  $this->m_sirkulasi->edit_rencana_distribusi($id);
		$data['majalah'] = $this->m_sirkulasi->get_majalah();
		$data['content'] = 'rencana_distribusi/edit';
		$this->load->view('template',$data);
	}

	public function update($id)
	{
		$this->form_validation->set_rules('plan_print', 'Plan print', 'required'); 
		$this->form_validation->set_rules('publish_date', 'Publish Date', 'required');

		$plan_print = $this->input->post('plan_print');
		$publish_date = $this->input->post('publish_date');
		$print_number = $this->input->post('print_number');
		$rencana = $this->m_sirkulasi->edit_rencana_distribusi($id);

		$data = array('print' => $plan_print,
					  'date_publish' => $publish_date,
					  'print_number' => $print_number, );
		
		if ($rencana['is_realisasi'] == 2 || $this->form_validation->run() == FALSE ) 
		{
			$this->session->set_flashdata('confirm','Data Locked or Error While Updating data');
		} else{
			$this->session->set_flashdata('confirm','Data sudah Di Update');
			$this->m_sirkulasi->update_rencana_distribusi($id,$data);
		}
		redirect('sirkulasi/rencana_distribusi');
	}

	public function detail($id,$agent_category = null)
	{
		$agent_category = $this->input->get('agent_category');
		$detail = $this->m_sirkulasi->get_one_rencana_distribusi($id);
		$data['id'] = $id;
		$data['agent_category'] = $agent_category;
		$data['agent_cat'] = $this->m_sirkulasi->get_agent_cat();
		$data['agent'] = $this->m_sirkulasi->get_agent_detail($id,$agent_category);
		$data['detail'] = $detail;
		$data['content'] = 'rencana_distribusi/detail';
		$this->load->view('template',$data);
	}

	public function tambah_agent($id)
	{
		$detail = $this->m_sirkulasi->get_one_rencana_distribusi($id);

		if ($detail['is_realisasi'] == 1 || $detail['is_realisasi'] == 2 || $detail == null) 
		{
			$this->session->set_flashdata('confirm','Data Tidak bisa ditambahkan');
			redirect('sirkulasi/rencana_distribusi');
		} else {
			$data['url'] = 'sirkulasi/rencana_distribusi/simpan_agent';
			$data['id'] = $id;
			$data['agent'] = $this->m_sirkulasi->get_agent();
			$data['content'] = 'rencana_distribusi/tambah_agent';
			$this->load->view('template',$data);
		}
	}

	public function simpan_agent()
	{
		$id = $this->input->post('distribution_plan_id');
		$detail = $this->m_sirkulasi->get_one_rencana_distribusi($id);

		if ($detail['is_realisasi'] == 1 || $detail['is_realisasi'] == 2 || $detail == null) 
		{
			$this->session->set_flashdata('confirm','Data Tidak bisa ditambahkan');
			redirect('sirkulasi/rencana_distribusi');
		} else {
			$diskon =  $this->db->query("select discount,deposit from agent where agent_id =".$this->input->post('agent_id'))->row_array();
			$data = $this->input->post();
			$data['disc_total'] = $diskon['discount'];
			$data['disc_deposit'] = $diskon['deposit'];
			$this->session->set_flashdata('confirm','Data Sudah Disimpan');
			$this->m_sirkulasi->tambah_agent_detail($data);
			redirect('sirkulasi/rencana_distribusi/detail/'.$id);
		}
	}

	public function edit_agent($id,$detail_data)
	{
		$detail = $this->m_sirkulasi->get_one_rencana_distribusi($id);

		if ($detail['is_realisasi'] == 1 || $detail['is_realisasi'] == 2 || $detail == null) 
		{
			$this->session->set_flashdata('confirm','Data Tidak bisa ditambahkan / diedit');
			redirect('sirkulasi/rencana_distribusi/detail/'.$id);
		} else {
			$data['id'] = $id;
			$data['url'] = 'sirkulasi/rencana_distribusi/update_agent/'.$id.'/'.$detail_data;
			$data['agent'] = $this->m_sirkulasi->get_agent();
			$data['detail_agent'] = $this->m_sirkulasi->get_one_agent_detail($detail_data);
			$data['content'] = 'rencana_distribusi/tambah_agent';
			$this->load->view('template',$data);
		}
	}

	public function update_agent($id,$detail_data)
	{
		$detail = $this->m_sirkulasi->get_one_rencana_distribusi($id);

		if ($detail['is_realisasi'] == 1 || $detail['is_realisasi'] == 2 || $detail == null) 
		{
			$this->session->set_flashdata('confirm','Data Tidak bisa ditambahkan');
			redirect('sirkulasi/rencana_distribusi');
		} else {
			$data = $this->input->post();
			$this->m_sirkulasi->update_agent_detail($detail_data,$data);
			$this->session->set_flashdata('confirm','Data Sudah Diupdate');
			redirect('sirkulasi/rencana_distribusi/detail/'.$id);
		}
	}

	public function hapus_agent($id,$detail_agent)
	{
		$detail = $this->m_sirkulasi->get_one_rencana_distribusi($id);
		
		if ($detail['is_realisasi'] == 1 || $detail['is_realisasi'] == 2 || $detail == null) 
		{
			$this->session->set_flashdata('confirm','Data tidak ada / Sudah Direalisasikan');
			redirect('sirkulasi/rencana_distribusi/detail/'.$id);
		} else {
			$this->session->set_flashdata('confirm','Data Sudah Dihapus');
			$this->m_sirkulasi->hapus_agent($detail_agent);
			redirect('sirkulasi/rencana_distribusi/detail/'.$id);
		}
	}

	public function hapus_rencana($id)
	{
		$detail = $this->m_sirkulasi->get_one_rencana_distribusi($id);
		
		if ($detail['is_realisasi'] == 1 || $detail['is_realisasi'] == 2 || $detail == null) 
		{
			$this->session->set_flashdata('confirm','Data tidak ada / Sudah Direalisasikan');
			redirect('sirkulasi/rencana_distribusi');
		} else {
			$this->session->set_flashdata('confirm','Data di Hapus');
			$this->m_sirkulasi->hapus_rencana($id);
			redirect('sirkulasi/rencana_distribusi');
		}
	}

	public function edisi_majalah($id)
	{
		$data['select_majalah'] = $id;
		$data['edisi'] = $this->m_sirkulasi->get_edisi_majalah($id);
		$data['majalah'] = $this->m_sirkulasi->get_majalah();
		$data['prev_majalah'] = $this->m_sirkulasi->get_edisi_majalah($id);
		$data['content'] = 'rencana_distribusi/tambah';
		$this->load->view('template',$data);
	}

	public function realisasi($id)
	{
		//CHECK DATA AGAR TIDAK DAPAT DI REALISASIKAN DUA KALI
		$detail = $this->m_sirkulasi->get_one_rencana_distribusi($id);
		
		if ($detail['is_realisasi'] == 1 || $detail['is_realisasi'] == 2 || $detail == null) 
		{
			$this->session->set_flashdata('confirm','Data tidak ada / Sudah Direalisasikan');
			redirect('sirkulasi/rencana_distribusi/detail/'.$id);
		} else {
			$data_agent_for_realization = $this->m_sirkulasi->get_agent_detail($id,0);
			foreach ($data_agent_for_realization as $keydata) 
			{
				$datarealisasi = array('distribution_plan_id' => $keydata['distribution_plan_id'],
							  'ekspedisi' => '',
							  'agent_id' => $keydata['agent_id'],
							  'quota' => $keydata['quota'],
							  'consigned' => $keydata['consigned'],
							  'gratis' => $keydata['gratis'],
							  'disc_total' => $keydata['disc_total'],
							  'disc_deposit' => $keydata['disc_deposit'], );
				$this->m_sirkulasi->tambah_agent_realizaton_detail($datarealisasi);
			}
			$this->session->set_flashdata('confirm','Data Sudah Realisasikan');
			$this->m_sirkulasi->realisasi_distribusi($id);
			redirect('sirkulasi/rencana_distribusi/detail/'.$id);
		}
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */