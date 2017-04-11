<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
* 
*/
class M_dashboard extends CI_model
{
	function get_rencana_distribusi() {
		$this->db->select('nama_majalah, sum(quota) + sum(consigned) + sum(gratis) as total');
		$this->db->from('distribution_plan');
		$this->db->join('edisi', 'distribution_plan.edisi_id = edisi.edisi_id','LEFT');
		$this->db->join('majalah', 'edisi.majalah_id = majalah.majalah_id','LEFT');
		$this->db->join('distribution_plan_detail', 'distribution_plan.distribution_plan_id = distribution_plan_detail.distribution_plan_id','LEFT');
		$this->db->where('distribution_plan.date_publish >=', ''.date('Y').'-00-00 00:00:00');
		$this->db->where('distribution_plan.date_publish <=', ''.date('Y').'-12-31 00:00:00');
		$this->db->where('distribution_plan.date_delete','0000-00-00 00:00:00');
		$this->db->where('distribution_plan_detail.date_delete','0000-00-00 00:00:00');
		$this->db->order_by('nama_majalah','ASC');
		$this->db->group_by('edisi.majalah_id');
		return $this->db->get()->result_array();
	}

	function get_realisasi_distribusi() {
		$this->db->select('majalah.majalah_id,nama_majalah, SUM(quota) + SUM(consigned) + sum(gratis) as total');
		$this->db->from('distribution_plan');
		$this->db->join('edisi', 'distribution_plan.edisi_id = edisi.edisi_id','LEFT');
		$this->db->join('majalah', 'edisi.majalah_id = majalah.majalah_id','LEFT');
		$this->db->join('distribution_realization_detail', 'distribution_plan.distribution_plan_id = distribution_realization_detail.distribution_plan_id','LEFT');
		$this->db->where('distribution_plan.date_delete','0000-00-00 00:00:00');
		$this->db->where('distribution_realization_detail.date_delete','0000-00-00 00:00:00');
		$this->db->where('distribution_plan.date_publish >=', ''.date('Y').'-00-00 00:00:00');
		$this->db->where('distribution_plan.date_publish <=', ''.date('Y').'-12-31 00:00:00');
		$this->db->order_by('nama_majalah','ASC');
		$this->db->group_by('edisi.majalah_id');
		return $this->db->get()->result_array();
	}

	function get_return($majalah_id) {
		$this->db->select('SUM(jumlah) as total_return');
		$this->db->from('return_item');
		$this->db->join('distribution_realization_detail', 'return_item.distribution_realization_id = distribution_realization_detail.distribution_realization_detail_id','LEFT');
		$this->db->join('distribution_plan', 'distribution_realization_detail.distribution_plan_id = distribution_plan.distribution_plan_id','LEFT');
		$this->db->where('return_item.date_delete','0000-00-00 00:00:00');
		$this->db->where('distribution_plan.date_publish >=', ''.date('Y').'-00-00 00:00:00');
		$this->db->where('distribution_plan.date_publish <=', ''.date('Y').'-12-31 00:00:00');
		$this->db->where('return_item.majalah_id',$majalah_id);
		return $this->db->get()->row_array();
	}
}