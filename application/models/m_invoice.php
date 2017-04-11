<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
* 
*/
class M_invoice extends CI_model
{
	function get_agent_cat()
	{
		$this->db->where('date_delete','0000-00-00');
		$this->db->order_by('nama_agent_cat','ASC');
		return $this->db->get('agent_category')->result_array();
	}

	function get_agent()
	{
		$this->db->select('agent_id,nama_agent,agent_category,kota,phone,contact,address,nama_agent_cat,discount,deposit,city.name');
		$this->db->from('agent');
		$this->db->join('agent_category', 'agent.agent_category = agent_category.agent_category_id','LEFT');
		$this->db->join('city', 'agent.kota = city.id','LEFT');
		$this->db->where('agent.date_delete','0000-00-00');
		$this->db->order_by('nama_agent','ASC');
		return $this->db->get()->result_array();
	}

	function get_one_agent($agent)
	{
		$this->db->where_in('agent_id',$agent);
		return $this->db->get('agent')->row_array();
	}

	function get_majalah()
	{
		$this->db->select('majalah.*,penerbit.nama,penerbit.npwp,penerbit.alamat,penerbit.phone');
		$this->db->from('majalah');
		$this->db->join('penerbit', 'majalah.penerbit_id = penerbit.penerbit_id','LEFT');
		$this->db->where('majalah.date_delete','0000-00-00');
		$this->db->order_by('majalah.nama_majalah','ASC');
		return $this->db->get()->result_array();
	}

	function get_one_majalah($majalah_id)
	{
		$this->db->where('majalah_id',$majalah_id);
		return $this->db->get('majalah')->row_array();
	}

	function get_list_do_jatah($majalah_id,$agent,$proccess_date)
	{
		$this->db->select('distribution_realization_detail.*,edisi.kode_edisi,edisi.harga,majalah.nama_majalah');
		$this->db->from('distribution_realization_detail');
		$this->db->join('distribution_plan','distribution_realization_detail.distribution_plan_id = distribution_plan.distribution_plan_id', 'LEFT');
		$this->db->join('edisi','distribution_plan.edisi_id = edisi.edisi_id', 'LEFT');
		$this->db->join('majalah','edisi.majalah_id = majalah.majalah_id', 'LEFT');
		$this->db->where('distribution_realization_detail.quota !=','0');
		$this->db->where('distribution_plan.date_delete','0000-00-00 00:00:00');
		$this->db->where('distribution_realization_detail.date_delete','0000-00-00 00:00:00');
		$this->db->where_in('distribution_realization_detail.invoice_jatah',array('0'));
		$this->db->where('distribution_plan.date_publish <=',$proccess_date.' 23:59:59');
		$this->db->where('distribution_plan.is_realisasi','2');
		$this->db->where('majalah.majalah_id',$majalah_id);
		$this->db->where_in('distribution_realization_detail.agent_id',$agent);
		return $this->db->get()->result_array();
	}

	function get_list_do_konsinyasi($majalah_id,$agent,$proccess_date)
	{
		$this->db->select('distribution_realization_detail.*,edisi.kode_edisi,edisi.harga,majalah.nama_majalah');
		$this->db->from('distribution_realization_detail');
		$this->db->join('distribution_plan','distribution_realization_detail.distribution_plan_id = distribution_plan.distribution_plan_id', 'LEFT');
		$this->db->join('edisi','distribution_plan.edisi_id = edisi.edisi_id', 'LEFT');
		$this->db->join('majalah','edisi.majalah_id = majalah.majalah_id', 'LEFT');
		$this->db->where('distribution_realization_detail.consigned !=','0');
		$this->db->where('distribution_realization_detail.date_delete','0000-00-00 00:00:00');
		$this->db->where('distribution_plan.date_delete','0000-00-00 00:00:00');
		$this->db->where_in('distribution_realization_detail.invoice_konsinyasi',array('0'));
		$this->db->where('distribution_plan.date_publish <=',$proccess_date.' 23:59:59');
		$this->db->where('distribution_plan.is_realisasi','2');
		$this->db->where('majalah.majalah_id',$majalah_id);
		$this->db->where_in('distribution_realization_detail.agent_id',$agent);
		return $this->db->get()->result_array();
	}

	function update_do($inv_do,$invoice)
	{
		$data['invoice_konsinyasi'] = $invoice;
		$this->db->where_in('distribution_realization_detail_id',$inv_do);
		$this->db->update('distribution_realization_detail',$data);
	}

	function update_do_jatah($inv_do,$invoice)
	{
		$data['invoice_jatah'] = $invoice;
		$this->db->where_in('distribution_realization_detail_id',$inv_do);
		$this->db->update('distribution_realization_detail',$data);
	}

	function sum_do($inv_do)
	{
		$this->db->select('quota,consigned,disc_total,harga');
		$this->db->from('distribution_realization_detail');
		$this->db->join('distribution_plan','distribution_realization_detail.distribution_plan_id = distribution_plan.distribution_plan_id', 'LEFT');
		$this->db->join('edisi','distribution_plan.edisi_id = edisi.edisi_id', 'LEFT');
		$this->db->where_in('distribution_realization_detail_id',$inv_do);
		return $this->db->get()->result_array();
	}

	function get_list_retur($majalah_id,$agent,$proccess_date)
	{
		$this->db->select('return_item.*,edisi.kode_edisi,edisi.harga,majalah.nama_majalah,distribution_realization_detail.disc_total');
		$this->db->from('return_item');
		$this->db->join('edisi','return_item.edisi_id = edisi.edisi_id', 'LEFT');
		$this->db->join('majalah','return_item.majalah_id = majalah.majalah_id', 'LEFT');
		$this->db->join('distribution_realization_detail','return_item.distribution_realization_id = distribution_realization_detail.distribution_realization_detail_id', 'LEFT');
		$this->db->where('return_item.date_delete','0000-00-00 00:00:00');
		$this->db->where('return_item.invoice','0');
		$this->db->where('return_item.return_date <=',$proccess_date.' 23:59:59');
		$this->db->where('return_item.majalah_id',$majalah_id);
		$this->db->where_in('return_item.agent_id',$agent);
		return $this->db->get()->result_array();
	}

	function update_retur($inv_retur,$invoice)
	{
		$data['invoice'] = $invoice;
		$this->db->where_in('return_item_id',$inv_retur);
		$this->db->update('return_item',$data);
	}

	function sum_retur($inv_retur)
	{
		$this->db->select('jumlah,disc_total,harga');
		$this->db->from('return_item');
		$this->db->join('distribution_realization_detail','return_item.distribution_realization_id = distribution_realization_detail.distribution_realization_detail_id', 'LEFT');
		$this->db->join('edisi','return_item.edisi_id = edisi.edisi_id', 'LEFT');
		$this->db->where_in('return_item_id',$inv_retur);
		return $this->db->get()->result_array();
	}

	function check_max_no_invoice($majalah_id)
	{
		$this->db->select_max('no_invoice');
		$this->db->from('invoice');
		$this->db->where('majalah_id',$majalah_id);
		return $this->db->get()->row_array();
	}

	function check_max_no_invoice_id($majalah_id,$no_invoice)
	{
		$this->db->select('*');
		$this->db->from('invoice');
		$this->db->where('majalah_id',$majalah_id);
		$this->db->where('no_invoice',$no_invoice);
		return $this->db->get()->row_array();
	}

	function simpan_invoice($invoice_data)
	{
		$this->db->insert('invoice',$invoice_data);
	}

	function simpan_invoice_detail($invoice_detail)
	{
		$this->db->insert('invoice_consign_detail',$invoice_detail);
	}
	function simpan_invoice_jatah_detail($invoice_detail)
	{
		$this->db->insert('invoice_jatah_detail',$invoice_detail);
	}

	function get_invoice_jatah($agent_category,$agent,$startdate,$enddate,$page)
	{
		$this->db->select('invoice.*,nama_majalah,nama_agent,npwp,total');
		$this->db->from('invoice');
		$this->db->join('majalah','invoice.majalah_id = majalah.majalah_id','LEFT');
		$this->db->join('invoice_jatah_detail','invoice.invoice_id = invoice_jatah_detail.invoice_id','LEFT');
		$this->db->join('agent','invoice.agent_id = agent.agent_id','LEFT');
		$this->db->join('agent_category','agent.agent_category = agent_category.agent_category_id','LEFT');

		if ($agent_category != 0) {
			$this->db->where('agent_category.agent_category_id',$agent_category);
		}
		if ($agent != 0) {
			$this->db->where('invoice.agent_id',$agent);
		}
		if ($startdate != '') {
			$this->db->where('invoice.proccess_date >=',$startdate.' 00:00:00');
		}
		if ($enddate != '') {
			$this->db->where('invoice.proccess_date <=',$enddate.' 23:59:59');
		}
		if ($page != 0 || $page != '') {
			$this->db->limit(10,$page);
		}
		$this->db->where('invoice.type_invoice',1);
		$this->db->where('invoice.date_delete','0000-00-00 00:00:00');
		$this->db->order_by('invoice_id','DESC');
		return $this->db->get();
	}

	function get_invoice_consign($agent_category,$agent,$startdate,$enddate,$page)
	{
		$this->db->select('invoice.*,nama_majalah,nama_agent,npwp,total');
		$this->db->from('invoice');
		$this->db->join('majalah','invoice.majalah_id = majalah.majalah_id','LEFT');
		$this->db->join('invoice_consign_detail','invoice.invoice_id = invoice_consign_detail.invoice_id','LEFT');
		$this->db->join('agent','invoice.agent_id = agent.agent_id','LEFT');
		$this->db->join('agent_category','agent.agent_category = agent_category.agent_category_id','LEFT');

		if ($agent_category != 0) {
			$this->db->where('agent_category.agent_category_id',$agent_category);
		}
		if ($agent != 0) {
			$this->db->where('invoice.agent_id',$agent);
		}
		if ($startdate != '') {
			$this->db->where('invoice.proccess_date >=',$startdate.' 00:00:00');
		}
		if ($enddate != '') {
			$this->db->where('invoice.proccess_date <=',$enddate.' 23:59:59');
		}
		if ($page != 0 || $page != '') {
			$this->db->limit(10,$page);
		}
		$this->db->where('invoice.type_invoice',0);
		$this->db->where('invoice.date_delete','0000-00-00 00:00:00');
		$this->db->order_by('invoice_id','DESC');
		return $this->db->get();
	}

	function get_one_invoice_consign($id)
	{
		$this->db->select('invoice.*,nama,alamat,penerbit.phone as phone_penerbit,penerbit.npwp as npwp_penerbit,pkp,authorized_signature,nama_majalah,nama_agent,address,agent.npwp,distribution_realization_detail_id,return_item_id,total');
		$this->db->from('invoice');
		$this->db->join('majalah','invoice.majalah_id = majalah.majalah_id','LEFT');
		$this->db->join('penerbit','majalah.penerbit_id = penerbit.penerbit_id','LEFT');
		$this->db->join('invoice_consign_detail','invoice.invoice_id = invoice_consign_detail.invoice_id','LEFT');
		$this->db->join('agent','invoice.agent_id = agent.agent_id','LEFT');
		$this->db->join('agent_category','agent.agent_category = agent_category.agent_category_id','LEFT');
		$this->db->where('invoice.date_delete','0000-00-00 00:00:00');
		$this->db->where('invoice.invoice_id',$id);
		return $this->db->get()->row_array();
	}

	function get_one_invoice_jatah($id)
	{
		$this->db->select('invoice.*,nama,alamat,penerbit.phone as phone_penerbit,penerbit.npwp as npwp_penerbit,pkp,authorized_signature,nama_majalah,nama_agent,address,agent.npwp,distribution_realization_detail_id,return_item_id,total');
		$this->db->from('invoice');
		$this->db->join('majalah','invoice.majalah_id = majalah.majalah_id','LEFT');
		$this->db->join('penerbit','majalah.penerbit_id = penerbit.penerbit_id','LEFT');
		$this->db->join('invoice_jatah_detail','invoice.invoice_id = invoice_jatah_detail.invoice_id','LEFT');
		$this->db->join('agent','invoice.agent_id = agent.agent_id','LEFT');
		$this->db->join('agent_category','agent.agent_category = agent_category.agent_category_id','LEFT');
		$this->db->where('invoice.date_delete','0000-00-00 00:00:00');
		$this->db->where('invoice.invoice_id',$id);
		return $this->db->get()->row_array();
	}

	function get_list_detail_do($list_detail_do)
	{
		$this->db->select('distribution_realization_detail.*,edisi.kode_edisi,edisi.harga,majalah.nama_majalah');
		$this->db->from('distribution_realization_detail');
		$this->db->join('distribution_plan','distribution_realization_detail.distribution_plan_id = distribution_plan.distribution_plan_id', 'LEFT');
		$this->db->join('edisi','distribution_plan.edisi_id = edisi.edisi_id', 'LEFT');
		$this->db->join('majalah','edisi.majalah_id = majalah.majalah_id', 'LEFT');
		$this->db->where_in('distribution_realization_detail.distribution_realization_detail_id',$list_detail_do);
		return $this->db->get()->result_array();
	}

	function get_list_detail_retur($list_detail_retur)
	{
		$this->db->select('return_item.*,edisi.kode_edisi,edisi.harga,majalah.nama_majalah,distribution_realization_detail.disc_total');
		$this->db->from('return_item');
		$this->db->join('edisi','return_item.edisi_id = edisi.edisi_id', 'LEFT');
		$this->db->join('majalah','return_item.majalah_id = majalah.majalah_id', 'LEFT');
		$this->db->join('distribution_realization_detail','return_item.distribution_realization_id = distribution_realization_detail.distribution_realization_detail_id', 'LEFT');
		$this->db->where_in('return_item.return_item_id',$list_detail_retur);
		return $this->db->get()->result_array();
	}

	function update_invoice($id)
	{
		$data['user_delete'] = $this->session->userdata('id');
		$data['date_delete'] = date("Y-m-d h:i:s");
		$this->db->where('invoice_id',$id);
		$this->db->update('invoice',$data);
	}
}