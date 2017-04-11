<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author dr.emi
 * @copyright 2010
 */

function getModuleLink() {
	$ci = & get_instance();
	$usermodule = $ci->session->userdata('module');
	$module = $ci->db->query("SELECT * FROM module WHERE module_id IN  (".$usermodule.")");
	
	if ($module->num_rows() > 0) {
		foreach ($module->result_array() as $keymodule) {
			//Sirkulasi
			if ($keymodule['parent'] == 0) {
				$module_list = $keymodule['module_id'];
				echo '<li class="dropdown">';
			        echo '<a  class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">'.$keymodule['module_name'].'<span class="caret"></span></a>';
			        foreach ($module->result_array() as $keylistmodule) {
			        	//list module
			        	echo '<ul class="dropdown-menu">';
			        		if ($keylistmodule['parent'] == $module_list) {
			        			echo '<li><a href="'.$keylistmodule['module_link'].'">'.$keylistmodule['module_name'].'</a></li>';
			        		}
			        	echo '</ul>';
			        }
		        echo '</li>';
			}
		}
	}
}

?>
