<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
* 
*/
class M_user extends CI_model
{
	function get_user($username,$password)
	{
		$this->db->where('username',$username);
		$this->db->where('password',$password);
		$this->db->where('is_del','0');
		$this->db->limit(1);
		return $this->db->get('user')->row_array();
	}

	function get_user_detail($id)
	{
		$this->db->where('user_id',$id);
		$this->db->where('is_del','0');
		$this->db->limit(1);
		return $this->db->get('user')->row_array();
	}

	function login_trigger()
	{
		if ($this->session->userdata('username') == null ) 
		{
			redirect('login');
		}
	}

	function access_module($module)
	{
		$access = isset($this->session->userdata['module']) ? explode(',', $this->session->userdata['module']) : $this->login_trigger();
		if ($this->session->userdata['group'] == 2) {
			$keyaccess = TRUE;
		} else {
			$keyaccess = FALSE;
			if (!empty($access)) {
				foreach ($access as $access) {
					if ($access == $module ) 
					{
						$keyaccess = TRUE;
					}
				}
			}
		}
		
		if ($keyaccess == FALSE) {
			redirect('dashboard/forbidden');
		}
	}

	function get_list_user()
	{
		return $this->db->get('user')->result_array();
	}

	function simpan($data)
	{
		$this->db->insert('user',$data);
	}

	function update($id,$data)
	{
		$this->db->where('user_id',$id);
		$this->db->update('user',$data);
	}

	function change($id,$data)
	{
		$this->db->where('user_id',$id);
		$this->db->update('user',$data);
	}

	function get_module()
	{
		return $this->db->get('module')->result_array();
	}

	function get_user_module($module)
	{
		$this->db->where_in('module_id',$module);
		return $this->db->get('module')->result_array();
	}

	function deactive($id)
	{
		$data['is_del'] = 1;
		$this->db->where('user_id',$id);
		$this->db->update('user',$data);
	}

	function active($id)
	{
		$data['is_del'] = 0;
		$this->db->where('user_id',$id);
		$this->db->update('user',$data);
	}

	function sessionAccess($value) {
		if ($this->session->userdata('group') >= $value) {
			return TRUE;
		} else{
			return FALSE;
		}
	}
}