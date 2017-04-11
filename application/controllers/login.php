<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class login extends CI_Controller {

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
	}

	public function index()
	{
		if (!$this->session->userdata('username')) {
			$this->load->view('login');
		} else {
			redirect('dashboard');
		}
	}

	public function do_login()
	{
		$username = $this->input->post('username');
		$password = md5($this->input->post('password'));
		$login = $this->m_user->get_user($username,$password);
		if ($login != null ) 
		{
			$this->session->set_userdata('username',$login['username']);
			$this->session->set_userdata('id',$login['user_id']);
			$this->session->set_userdata('module',$login['module']);
			$this->session->set_userdata('group',$login['is_group']);
			redirect('dashboard');
		} else {
			$this->session->set_flashdata('login',1);
			redirect('login');
		}
	}

	public function change()
	{
		$username = $this->session->userdata('username');
		$id = $this->session->userdata('id');
		$oldpass =  md5($this->input->post('oldpass'));
		$data['username'] = $this->input->post('username');
		$data['password'] = md5($this->input->post('newpass'));
		$login = $this->m_user->get_user($username,$oldpass);

		if ($login != null ) 
		{
			$this->m_user->change($id,$data);
			$this->session->set_flashdata('confirm','berhasil Update');
			$login = $this->m_user->get_user($data['username'],$data['password']);

			if ($login != null) {
				$this->session->set_userdata('username',$login['username']);
				$this->session->set_userdata('id',$login['user_id']);
				$this->session->set_userdata('module',$login['module']);
				redirect('login/password');
			} else {
				echo "Failed!!!";
			}
		} else {
			$this->session->set_flashdata('confirm','Gagal Update ');
			redirect('login/password');
		}
	}

	public function user()
	{
		$this->m_user->sessionAccess(2);
		$user = $this->m_user->get_list_user();
		foreach ($user as $keyuser) 
		{
			$list = explode(',', $keyuser['module']);
			$userlist[$keyuser['username']] = $this->m_user->get_user_module($list);
		}
		$data['user'] = $user;
		$data['content'] = 'user';
		$this->load->view('template',$data);
	}

	public function user_detail($id)
	{
		$this->m_user->sessionAccess(2);
		$data['user'] = $this->m_user->get_user_detail($id);
		$data['module'] = $this->m_user->get_module();
		$data['button'] = 'login/update/'.$id;
		$data['content'] = 'add_user';
		$this->load->view('template',$data);
	}

	public function update($id)
	{
		$this->m_user->sessionAccess(2);
		$module = implode(',', $this->input->post('module'));
		$data = array('username' => $this->input->post('username'),
					  'password' => md5($this->input->post('password')),
					  'module' => $module,
					  'is_group' => $this->input->post('group'));
		$this->m_user->update($id,$data);
		$this->session->set_flashdata('confirm','berhasil Update');
		redirect('login/user_detail/'.$id);
	}

	public function add()
	{
		$this->m_user->sessionAccess(2);
		$data['module'] = $this->m_user->get_module();
		$data['content'] = 'add_user';
		$data['button'] = 'login/simpan';
		$this->load->view('template',$data);
	}

	public function simpan()
	{
		$this->m_user->sessionAccess(2);
		$module = implode(',', $this->input->post('module'));
		$data = array('username' => $this->input->post('username'),
					  'password' =>  md5($this->input->post('password')),
					  'module' => $module,
					  'is_group' => $this->input->post('group'));
		$this->m_user->simpan($data);
		$this->session->set_flashdata('confirm','berhasil Tambah');
		redirect('login/add');
	}


	public function password()
	{
		$data['content'] = 'change_password';
		$this->load->view('template',$data);
	}

	public function deactive($id)
	{
		$this->m_user->sessionAccess(2);
		if ($this->session->userdata('group') == 2) {
			$this->m_user->deactive($id);
			$this->session->set_flashdata('confirm','User Deactive');
			redirect('login/user');
		} else {
			$this->session->set_flashdata('confirm','You dont have Permission to Change User');
			redirect('login/user');
		}
	}

	public function active($id)
	{
		$this->m_user->sessionAccess(2);
		if ($this->session->userdata('group') == 2) {
			$this->m_user->active($id);
			$this->session->set_flashdata('confirm','User Active');
			redirect('login/user');
		} else {
			$this->session->set_flashdata('confirm','You dont have Permission to Change User');
			redirect('login/user');
		}
	}

	public function logout()
	{
		$this->session->sess_destroy();
		redirect('login');
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */