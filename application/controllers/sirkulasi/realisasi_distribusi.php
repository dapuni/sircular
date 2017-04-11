<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class realisasi_distribusi extends CI_Controller {

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
		$this->load->model('m_user');
		$this->m_user->login_trigger();
		$this->m_user->access_module(3);
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
		$config['base_url'] = base_url().'/sirkulasi/realisasi_distribusi?majalah='.$majalah;
		$config['total_rows'] = $this->m_sirkulasi->get_realisasi_distribusi($majalah,0)->num_rows();

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
		$data['majalah'] =  $this->m_sirkulasi->get_majalah();
		$data['search'] = $this->input->get('majalah');
		$data['rencana'] = $this->m_sirkulasi->get_realisasi_distribusi($majalah,$page)->result_array();
		$data['content'] = 'realisasi_distribusi/distribusi';
		$this->load->view('template',$data);
	}

	public function detail($id,$agent_category = null)
	{
		$agent_category = $this->input->get('agent_category');
		$data['accounting'] = $this->m_user->sessionAccess(1);;
		$data['id'] = $id;
		$data['total_rencana'] = $this->db->query("SELECT (SUM(quota) + SUM(consigned) + SUM(gratis)) as 'total' FROM distribution_plan_detail WHERE distribution_plan_id =".$id." AND date_delete = '000-00-00'")->row_array();
		$data['total_realisasi'] = $this->db->query("SELECT (SUM(quota) + SUM(consigned) + SUM(gratis)) as 'total' FROM distribution_realization_detail WHERE distribution_plan_id =".$id." AND date_delete = '000-00-00'")->row_array();
		$data['agent_category'] = $agent_category;
		$data['agent_cat'] = $this->m_sirkulasi->get_agent_cat();
		$data['agent'] = $this->m_sirkulasi->get_realisasi_agent_detail($id,$agent_category);
		$data['detail'] = $this->m_sirkulasi->get_one_rencana_distribusi($id);
		$data['content'] = 'realisasi_distribusi/detail';
		$this->load->view('template',$data);
	}

	public function cetak_do()
	{
		$id = $this->input->post('id');
		$dist_realization_detail_id = $this->input->post('dist_realization_detail_id');
		$agent_id = $this->input->post('agent_id');
		$data['majalah'] = $this->m_sirkulasi->get_some_agent_realization_detail($dist_realization_detail_id);
		$data['detail'] = $this->m_sirkulasi->get_one_rencana_distribusi($id);
		$this->load->view('realisasi_distribusi/doHTMLform',$data);
	}

	public function cetak_do_pdf()
	{
		$id = $this->input->post('id');
		$dist_realization_detail_id = $this->input->post('dist_realization_detail_id');
		$agent_id = $this->input->post('agent_id');
		$data['majalah'] = $this->m_sirkulasi->get_some_agent_realization_detail($dist_realization_detail_id);
		$data['detail'] = $this->m_sirkulasi->get_one_rencana_distribusi($id);
		$this->load->view('realisasi_distribusi/doHTMLform',$data);
		// Get output html
		$html = $this->output->get_output();
		
		// Load library
		$this->load->library('dompdf_gen');
		
		// Convert to PDF
		$this->dompdf->load_html($html);
		$customPaper = array(0,0,600,500);
		$this->dompdf->set_paper($customPaper);
		$this->dompdf->render();

		$this->dompdf->stream("DO.pdf",array('Attachment'=>0));
	}

	public function tambah($id)
	{
		$detail = $this->m_sirkulasi->get_one_rencana_distribusi($id);
		if ($detail['is_realisasi'] == 2 || $detail == null) 
		{
			$this->session->set_flashdata('confirm','Data Tidak bisa ditambahkan');
			redirect('sirkulasi/realisasi_distribusi/detail/'.$id);
		} else {
			$data['id'] = $id;
			$data['agent'] = $this->m_sirkulasi->get_agent();
			$data['content'] = 'realisasi_distribusi/tambah';
			$this->load->view('template',$data);
		}
	}

	public function simpan($id)
	{
		$detail = $this->m_sirkulasi->get_one_rencana_distribusi($id);
		if ($detail['is_realisasi'] == 2 || $detail == null) 
		{
			$this->session->set_flashdata('confirm','Data Tidak bisa ditambahkan');
			redirect('sirkulasi/realisasi_distribusi/tambah/'.$id);
		} else {
			$adddisc = $this->m_sirkulasi->get_one_agent($this->input->post('agent_id'));
			$data = $this->input->post();
			$data['distribution_plan_id'] = $id;
			$data['disc_total'] = $adddisc[0]['discount'];
			$data['disc_deposit'] = $adddisc[0]['deposit'];
			$this->session->set_flashdata('confirm','Data Sudah Disimpan');
			$this->m_sirkulasi->tambah_agent_realizaton_detail($data);
			redirect('sirkulasi/realisasi_distribusi/detail/'.$id);
		}
	}

	public function edit($distribution_plan_id,$id)
	{
		$detail = $this->m_sirkulasi->get_one_rencana_distribusi($distribution_plan_id);
		if ($detail['is_realisasi'] == 2 || $detail == null) 
		{
			$this->session->set_flashdata('confirm','Data Tidak bisa Edit');
			redirect('sirkulasi/realisasi_distribusi/detail/'.$distribution_plan_id);
		} else {
			$data['accounting'] = $this->m_user->sessionAccess(1);;
			$data['distribution_plan_id'] = $distribution_plan_id;
			$data['id'] = $id;
			$data['realisasi'] =  $this->m_sirkulasi->edit_realisasi_agent_detail($id);
			$data['content'] = 'realisasi_distribusi/edit';
			$this->load->view('template',$data);
		}		
	}

	public function update($distribution_plan_id,$id)
	{
		$this->form_validation->set_rules('quota', 'Quota', 'required'); 
		$this->form_validation->set_rules('consigned', 'Consigned', 'required');
		$this->form_validation->set_rules('gratis', 'Gratis', 'required');
	
		$data = $this->input->post();
		$detail = $this->m_sirkulasi->get_one_rencana_distribusi($distribution_plan_id);
		if ($detail['is_realisasi'] == 2 || $detail == null) 
		{
			$this->session->set_flashdata('confirm','Data dikunci, Tidak bisa Diupdate');
			redirect('sirkulasi/realisasi_distribusi/edit/'.$distribution_plan_id.'/'.$id);
		} else {
			if ($this->form_validation->run() == FALSE ) 
			{
				$this->session->set_flashdata('confirm','Data Locked or Error While Updating data');
			} else{
				$this->session->set_flashdata('confirm','Data sudah Di Update');
				$this->m_sirkulasi->update_realisasi_distribusi($id,$data);
			}
			redirect('sirkulasi/realisasi_distribusi/detail/'.$distribution_plan_id);
		}
	}

	public function hapus($distribution_plan_id,$id)
	{
		$detail = $this->m_sirkulasi->get_one_rencana_distribusi($distribution_plan_id);
		if ($detail['is_realisasi'] == 2 || $detail == null) 
		{
			$this->session->set_flashdata('confirm','Data dikunci, Tidak bisa Dihapus');
			redirect('sirkulasi/realisasi_distribusi/detail/'.$distribution_plan_id);
		} else {
			$this->session->set_flashdata('confirm','Data sudah Di Hapus');
			$this->m_sirkulasi->hapus_realisasi_agent($id);
			redirect('sirkulasi/realisasi_distribusi/detail/'.$distribution_plan_id);
		}
	}

	public function lock($id)
	{
		$accounting = $this->m_user->sessionAccess(1);
		if ($accounting == TRUE) {
			$this->session->set_flashdata('confirm','Data Sudah Dikunci');
			$this->m_sirkulasi->lock_distribusi($id);
			redirect('sirkulasi/realisasi_distribusi/detail/'.$id);
		} else {
			$this->session->set_flashdata('confirm','Data Gagal Dikunci');
			redirect('sirkulasi/realisasi_distribusi/detail/'.$id);
		}
	}

	public function hapusRealisasi($distribution_plan_id)
	{
		$detail = $this->m_sirkulasi->get_one_rencana_distribusi($distribution_plan_id);
		if ($detail['is_realisasi'] == 2 || $detail == null) 
		{
			$this->session->set_flashdata('confirm','Data dikunci, Tidak bisa Dihapus');
			redirect('sirkulasi/realisasi_distribusi');
		} else {
			$this->m_sirkulasi->hapus_realisasi($distribution_plan_id);
			$this->m_sirkulasi->rollback_realisasi_distribusi($distribution_plan_id);
			$this->session->set_flashdata('confirm','Data sudah Di Hapus');
			redirect('sirkulasi/realisasi_distribusi');
		}
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */