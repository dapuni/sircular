<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class invoice_konsinyasi extends CI_Controller {

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
		$this->load->model('m_user');
		$this->load->model('m_invoice');
		$this->m_user->login_trigger();
		$this->m_user->access_module(7);
		$this->load->library('pagination');
	}

	public function index($agent_category = null, $agent = null, $startdate = null, $endddate = null)
	{	
		$agent_category = $this->input->get('agent_category');
		$agent = $this->input->get('agent');
		$startdate = $this->input->get('startdate');
		$endddate = $this->input->get('enddate');

		//pagination
		$page = $this->input->get('page')?$this->input->get('page'):'0';
		$per_page = 10;
		$config['uri_segment'] = 3; 	
		$config['per_page'] = $per_page; 
		$config['num_links'] = 10.3;
		$config['query_string_segment'] = 'page';
		$config['page_query_string'] = true;
		$config['base_url'] = base_url().'/tagihan/invoice_konsinyasi?agent_category='.$agent_category.'&agent='.$agent.'&startdate='.$startdate.'&endddate='.$endddate;
		$config['total_rows'] = $this->m_invoice->get_invoice_consign($agent_category,$agent,$startdate,$endddate,0)->num_rows();

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
		$data['select_agent_category'] = $agent_category;
		$data['select_agent'] = $agent;
		$data['select_startdate'] = $startdate;
		$data['select_enddate'] = $endddate;
		$data['agent_category'] = $this->m_invoice->get_agent_cat();
		$data['agent'] = $this->m_invoice->get_agent();
		$data['invoice'] = $this->m_invoice->get_invoice_consign($agent_category,$agent,$startdate,$endddate,$page)->result_array();
		$data['content'] = 'invoice_konsinyasi/invoice_konsinyasi';
		$this->load->view('template',$data);
	}

	public function add()
	{
		$data['majalah'] = $this->m_invoice->get_majalah();
		$data['agent'] = $this->m_invoice->get_agent();
		$data['content'] = 'invoice_konsinyasi/add_invoice_konsinyasi';
		$this->load->view('template',$data);
	}

	public function list_data()
	{
		$agent = $this->input->post('agent');
		$proccess_date = $this->input->post('proccess_date');
		$majalah_id = $this->input->post('majalah_id');
		$data['href'] = base_url().'tagihan/invoice_konsinyasi/confirm_konsinyasi';
		$data['button'] = 'Konfirmasi Data';
		$data['checked'] = FALSE;
		$data['agent'] = $this->m_invoice->get_one_agent($agent);
		$data['majalah'] = $this->m_invoice->get_one_majalah($majalah_id);
		$data['date'] = $proccess_date;
		$data['list_do'] = $this->m_invoice->get_list_do_konsinyasi($majalah_id,$agent,$proccess_date);
		$data['list_retur'] = $this->m_invoice->get_list_retur($majalah_id,$agent,$proccess_date);
		$data['content'] = 'invoice_konsinyasi/list_invoice_konsinyasi';
		$this->load->view('template',$data);
	}

	public function confirm_konsinyasi()
	{
		$agent_id = $this->input->post('agent_id');
		$majalah_id = $this->input->post('majalah_id');
		$proccess_date = $this->input->post('proccess_date');
		$inv_do = $this->input->post('inv_do');
		$inv_retur = $this->input->post('inv_retur');
		$data['button'] = 'Buat Konsinyasi';
		$data['href'] = base_url().'tagihan/invoice_konsinyasi/buat_konsinyasi';
		$data['checked'] = TRUE;
		$data['agent'] = $this->m_invoice->get_one_agent($agent_id);
		$data['majalah'] = $this->m_invoice->get_one_majalah($majalah_id);
		$data['date'] = $proccess_date;
		$data['list_do'] = $this->m_invoice->get_list_detail_do($inv_do);
		$data['list_retur'] = $this->m_invoice->get_list_detail_retur($inv_retur);
		$data['content'] = 'invoice_konsinyasi/list_invoice_konsinyasi';
		$this->load->view('template',$data);
	}

	public function buat_konsinyasi()
	{
		$total_do = 0;
		$total_retur = 0;
		$total = 0;
		$agent_id = $this->input->post('agent_id');
		$majalah_id = $this->input->post('majalah_id');
		$proccess_date = $this->input->post('proccess_date');
		$inv_do = $this->input->post('inv_do');
		$inv_retur = $this->input->post('inv_retur');
		$user_created = $this->session->userdata('id');
		
		if ($inv_do == '' && $inv_retur == '') 
		{
			$this->session->set_flashdata('confirm','Data Gagal Disimpan');
			redirect('tagihan/invoice_konsinyasi');
		} else {
			//check nomor invoice berdasarkan majalah
			$check_invoice = $this->m_invoice->check_max_no_invoice($majalah_id);
			if (empty($check_invoice)) {
				$no_invoice = 1;
			} else {
				$no_invoice = $check_invoice['no_invoice'] + 1;
			}
			
			//save invoice
			$invoice_data = array('proccess_date' => $proccess_date,
								  'agent_id' => $agent_id,
								  'majalah_id' => $majalah_id,
								  'no_invoice' => $no_invoice,
								  'type_invoice' => 0,
								  'user_created' => $user_created );
			$this->m_invoice->simpan_invoice($invoice_data);

			//update realiasi
			if (!empty($inv_do)) {
				$quantity = 0;
				$gross = 0;
				$total_gross = 0;
				$rebate = 0;
				$total_rebate = 0;
				$this->m_invoice->update_do($inv_do,1);
				//sum invoice do
				$sum_do = $this->m_invoice->sum_do($inv_do);
				foreach ($sum_do as $keysum_do) 
				{
					$quantity = $keysum_do['consigned'];
					$gross = ($quantity *  $keysum_do['harga']);
					$total_gross = $total_gross + $gross;
					$rebate = $gross * ($keysum_do['disc_total'] / 100);
					$total_rebate = $total_rebate + $rebate;
				}
				$total_do = $total_gross - $total_rebate;
				$inv_do = implode(',', $inv_do);
			}
			//update retur
			if (!empty($inv_retur)) {
				$quantity = 0;
				$gross = 0;
				$total_gross = 0;
				$rebate = 0;
				$total_rebate = 0;
				$this->m_invoice->update_retur($inv_retur,1);
				//sum invoice retur
				$sum_retur = $this->m_invoice->sum_retur($inv_retur);
				foreach ($sum_retur as $keysum_retur) 
				{
					$quantity = $keysum_retur['jumlah'];
					$gross = ($quantity * $keysum_retur['harga']);
					$total_gross = $total_gross + $gross;
					$rebate = ($gross * ($keysum_retur['disc_total'] / 100));
					$total_rebate = $total_rebate + $rebate;
				}
				
				$total_retur = $total_gross - $total_rebate;
				$inv_retur = implode(',', $inv_retur);
			}

			$total = $total_do - $total_retur;
			//save invoice detail
			$check_invoice_id = $this->m_invoice->check_max_no_invoice_id($majalah_id,$no_invoice);
			$invoice_detail = array('invoice_id' => $check_invoice_id['invoice_id'],
									'distribution_realization_detail_id' => $inv_do,
									'return_item_id' => $inv_retur,
									'total' => $total);
			$this->m_invoice->simpan_invoice_detail($invoice_detail);
			$this->session->set_flashdata('confirm','Data Sudah Disimpan');
			redirect('tagihan/invoice_konsinyasi');
		}
	}

	public function detail($id)
	{
		$invoice = $this->m_invoice->get_one_invoice_consign($id);
		$list_detail_do = explode(',', $invoice['distribution_realization_detail_id']);
		$list_detail_retur = explode(',', $invoice['return_item_id']);
		$data['id'] = $id;
		$data['list_do'] = $this->m_invoice->get_list_detail_do($list_detail_do);
		$data['list_retur'] = $this->m_invoice->get_list_detail_retur($list_detail_retur);
		$data['invoice'] = $invoice;
		$data['content'] = 'invoice_konsinyasi/detail_invoice_konsinyasi';
		$this->load->view('template',$data);
	}

	public function hapus($id)
	{
		$password = $this->input->post('password');
		
		//cek password 
		if ($password == 'spongebob') {
			$invoice = $this->m_invoice->get_one_invoice_consign($id);
			$list_detail_do = explode(',', $invoice['distribution_realization_detail_id']);
			$list_detail_retur = explode(',', $invoice['return_item_id']);
			$this->m_invoice->update_do($list_detail_do,0);
			$this->m_invoice->update_retur($list_detail_retur,0);
			$this->m_invoice->update_invoice($id);
			$this->session->set_flashdata('confirm','Data Sudah Dihapus');
		} else {
			$this->session->set_flashdata('confirm','Password Salah');
		}

		redirect('tagihan/invoice_konsinyasi');
	}

	public function cetak()
	{
		$id = $this->input->get('id');
		$invoice_consign_detail = $this->m_invoice->get_one_invoice_consign($id);
		$list_detail_do = explode(',', $invoice_consign_detail['distribution_realization_detail_id']);
		$list_detail_retur = explode(',', $invoice_consign_detail['return_item_id']);
		
		$list_do = $this->m_invoice->get_list_detail_do($list_detail_do);
		$list_retur = $this->m_invoice->get_list_detail_retur($list_detail_retur);
		
		//INVOICE UNTUK DO
		$total_quantity = 0;
		$total_gross = 0;
		$total_rebate = 0;
		$quantity = 0;
		$gross = 0;
		$rebate = 0;
		$nett = 0;
		foreach ($list_do as $keylist_do) 
		{ 
			$quantity = $keylist_do['consigned'];
			$gross = $keylist_do['harga'] * $quantity;
			$rebate = ($keylist_do['disc_total'] / 100) * $gross;
			$nett = $gross - $rebate;
			$total_quantity = $total_quantity + $quantity;
			$total_gross = $total_gross + $gross;
			$total_rebate = $total_rebate + $rebate;
		}

		//INVOICE UNTUK RETUR
		$quantity = 0;
		foreach ($list_retur as $keylist_retur) 
		{ 
			$quantity = -$keylist_retur['jumlah'];
			$gross = $keylist_retur['harga'] * $quantity;
			$rebate = ($keylist_retur['disc_total'] / 100) * $gross;
			$nett = $gross - $rebate;
			$total_quantity = $total_quantity + $quantity;
			$total_gross = $total_gross + $gross;
			$total_rebate = $total_rebate + $rebate;
		}

		//DUE DATE
		$duedate = strtotime($invoice_consign_detail['proccess_date']);
		$duedate = strtotime("+ 1 month",$duedate);
		$data['pajak'] = $this->input->get('pajak');
		$data['terbilang'] = $this->terbilang($invoice_consign_detail['total']);
		$data['duedate'] = $duedate;
		$data['total_quantity'] = $total_quantity;
		$data['gross'] = $total_gross;
		$data['rebate'] = $total_rebate;
		$data['cetak_invoice'] = $invoice_consign_detail; 
		$this->load->view('invoice_konsinyasi/doHTMLform',$data);
	}

	public function terbilang($x) 
	{
	    $x = abs($x);
	    $angka = array("", "Satu", "Dua", "Tiga", "Empat", "Lima","Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas");
	    $temp = "";
	    if ($x <12) {
	        $temp = "". $angka[$x];
	    } else if ($x <20) {
	        $temp = $this->terbilang($x - 10). " Belas ";
	    } else if ($x <100) {
	        $temp = $this->terbilang($x/10)." Puluh ". $this->terbilang($x % 10);
	    } else if ($x <200) {
	        $temp = " seratus " . $this->terbilang($x - 100);
	    } else if ($x <1000) {
	        $temp = $this->terbilang($x/100) . " Ratus " . $this->terbilang($x % 100);
	    } else if ($x <2000) {
	        $temp = " seribu " . $this->terbilang($x - 1000);
	    } else if ($x <1000000) {
	        $temp = $this->terbilang($x/1000) . " Ribu " . $this->terbilang($x % 1000);
	    } else if ($x <1000000000) {
	        $temp = $this->terbilang($x/1000000) . " Juta " . $this->terbilang($x % 1000000);
	    } else if ($x <1000000000000) {
	        $temp = $this->terbilang($x/1000000000) . " Milyar " . $this->terbilang(fmod($x,1000000000));
	    } else if ($x <1000000000000000) {
	        $temp = $this->terbilang($x/1000000000000) . " Trilyun " . $this->terbilang(fmod($x,1000000000000));
	    }
	    return strtolower($temp);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */