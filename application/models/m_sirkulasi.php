<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
* 
*/
class M_sirkulasi extends CI_model
{
	//PENERBIT

	function get_penerbit()
	{
		$this->db->where('date_delete','0000-00-00 00:00:00');
		return $this->db->get('penerbit')->result_array();
	}

	//MAJALAH
	function get_majalah()
	{
		$this->db->where('date_delete','0000-00-00 00:00:00');
		$this->db->order_by('nama_majalah','ASC');
		return $this->db->get('majalah')->result_array();
	}

	function get_one_majalah($majalah_id)
	{
		$this->db->where('majalah_id',$majalah_id);
		return $this->db->get('majalah')->row_array();
	}

	//EDISI
	function get_edisi()
	{
		$this->db->select('edisi_id,main_article,kode_edisi,cover,edisi.harga,nama_majalah');
		$this->db->from('edisi');
		$this->db->join('majalah', 'edisi.majalah_id = majalah.majalah_id','LEFT');
		$this->db->where('edisi.date_delete','0000-00-00 00:00:00');
		return $this->db->get()->result_array();
	}

	function get_one_edisi($edisi_id)
	{
		$this->db->select('*');
		$this->db->from('edisi');
		$this->db->where('edisi.edisi_id',$edisi_id);
		return $this->db->get()->row_array();
	}

	function get_edisi_majalah($id)
	{
		$this->db->where('majalah_id',$id);
		$this->db->where('date_delete','0000-00-00 00:00:00');
		$this->db->order_by('edisi_id','DESC');
		return $this->db->get('edisi')->result_array();
	}

	function get_agent_cat()
	{
		$this->db->where('date_delete','0000-00-00');
		$this->db->order_by('nama_agent_cat','ASC');
		return $this->db->get('agent_category')->result_array();
	}

	//AGENT
	function get_agent()
	{
		$this->db->select('agent_id,nama_agent,kota,phone,contact,nama_agent_cat,discount,deposit');
		$this->db->from('agent');
		$this->db->join('agent_category', 'agent.agent_category = agent_category.agent_category_id','LEFT');
		$this->db->where('agent.date_delete','0000-00-00 00:00:00');
		$this->db->order_by('nama_agent','ASC');
		return $this->db->get()->result_array();
	}

	function get_one_agent($agent_id)
	{
		$this->db->where_in('agent_id',$agent_id);
		return $this->db->get('agent')->result_array();
	}

	function get_relasi($id)
	{
		$this->db->select('agent_magazine.majalah_id,nama_majalah');
		$this->db->from('agent_magazine');
		$this->db->join('majalah', 'agent_magazine.majalah_id = majalah.majalah_id','LEFT');
		$this->db->where('agent_id',$id);
		return $this->db->get()->result_array();
	}

	function get_relasi_majalah($majalah)
	{
		$this->db->where_not_in('majalah_id',$majalah);
		return $this->db->get('majalah')->result_array();
	}

	//RENCANA  DISTRIBUSI
	function cek_edisi($edisi)
	{
		$this->db->select('distribution_plan.*,retur_date');
		$this->db->from('distribution_plan');
		$this->db->join('edisi','distribution_plan.edisi_id = edisi.edisi_id','LEFT');
		$this->db->where('distribution_plan.date_delete','0000-00-00 00:00:00');
		$this->db->where('distribution_plan.edisi_id',$edisi);
		$this->db->limit(1);
		return $this->db->get()->row_array();
	}

	function simpan_rencana_distribusi($data)
	{
		$data['user_created'] = $this->session->userdata('id');
		$data['date_created'] = date("Y-m-d h:i:s");
		$this->db->insert('distribution_plan',$data);
	}

	function get_last_distribution_plan_id()
	{
		$this->db->order_by('distribution_plan_id','DESC');
		$this->db->limit(1);
		return $this->db->get('distribution_plan')->row_array();
	}

	function get_rencana_distribusi($majalah,$page)
	{
		$this->db->select('distribution_plan_id,print,edisi.kode_edisi,majalah.nama_majalah,date_publish,is_realisasi');
		$this->db->from('distribution_plan');
		$this->db->join('edisi', 'distribution_plan.edisi_id = edisi.edisi_id','LEFT');
		$this->db->join('majalah', 'edisi.majalah_id = majalah.majalah_id','LEFT');
		$this->db->where('distribution_plan.date_delete','0000-00-00 00:00:00');
		//$this->db->where('distribution_plan.is_realisasi','0');
		if ($majalah != 0) {
			$this->db->where('majalah.majalah_id',$majalah);
		}
		if ($page != 0 || $page != '') {
			$this->db->limit(10,$page);
		}
		$this->db->order_by('distribution_plan.distribution_plan_id', 'DESC');
		return $this->db->get();
	}

	function get_realisasi_distribusi($majalah,$page)
	{
		$this->db->select('distribution_plan_id,print,edisi.kode_edisi,majalah.nama_majalah,date_publish,is_realisasi');
		$this->db->from('distribution_plan');
		$this->db->join('edisi', 'distribution_plan.edisi_id = edisi.edisi_id','LEFT');
		$this->db->join('majalah', 'edisi.majalah_id = majalah.majalah_id','LEFT');
		if ($majalah != 0) {
			$this->db->where('majalah.majalah_id',$majalah);
		}
		if ($page != 0 || $page != '') {
			$this->db->limit(10,$page);
		}
		$this->db->where('distribution_plan.date_delete','0000-00-00 00:00:00');
		$this->db->where_in('distribution_plan.is_realisasi',array('1','2'));
		$this->db->order_by('distribution_plan.distribution_plan_id', 'DESC');
		return $this->db->get();
	}

	function get_one_rencana_distribusi($id)
	{
		$this->db->select('distribution_plan_id,print,edisi.kode_edisi,edisi.harga,majalah.nama_majalah,majalah.majalah_id,date_publish,print_number,is_realisasi,alamat,nama,phone,username,npwp,pkp');
		$this->db->from('distribution_plan');
		$this->db->join('edisi', 'distribution_plan.edisi_id = edisi.edisi_id','LEFT');
		$this->db->join('majalah', 'edisi.majalah_id = majalah.majalah_id','LEFT');
		$this->db->join('penerbit', 'majalah.penerbit_id = penerbit.penerbit_id','LEFT');
		$this->db->join('user', 'distribution_plan.user_realisasi = user.user_id','LEFT');
		$this->db->where('distribution_plan_id',$id);
		return $this->db->get()->row_array();
	}

	function get_one_rencana_distribusi_from_prev($prev_edition)
	{
		$this->db->select('distribution_plan.print');
		$this->db->from('edisi');
		$this->db->join('distribution_plan', 'edisi.edisi_id = distribution_plan.edisi_id', 'LEFT');
		$this->db->where('edisi.edisi_id',$prev_edition);
		$this->db->where('distribution_plan.date_delete','0000-00-00 00:00:00');
		return $this->db->get()->row_array();
	}

	function get_realisasi_distribusi_detail_from_prev($prev_edition)
	{
		$this->db->select('agent_id,quota,consigned,gratis,disc_total,disc_deposit,ekspedisi');
		$this->db->from('distribution_realization_detail');
		$this->db->join('distribution_plan', 'distribution_realization_detail.distribution_plan_id = distribution_plan.distribution_plan_id', 'LEFT');
		$this->db->where('distribution_plan.edisi_id',$prev_edition);
		$this->db->where('distribution_realization_detail.date_delete','0000-00-00 00:00:00');
		return $this->db->get()->result_array();
	}

	function get_rencana_distribusi_detail_from_prev($prev_edition)
	{
		$this->db->select('agent_id,quota,consigned,gratis,disc_deposit,disc_total');
		$this->db->from('distribution_plan_detail');
		$this->db->join('distribution_plan', 'distribution_plan_detail.distribution_plan_id = distribution_plan.distribution_plan_id', 'LEFT');
		$this->db->where('distribution_plan.edisi_id',$prev_edition);
		$this->db->where('distribution_plan_detail.date_delete','0000-00-00 00:00:00');
		$this->db->where('distribution_plan.date_delete','0000-00-00 00:00:00');
		return $this->db->get()->result_array();
	}

	function edit_rencana_distribusi($id)
	{
		$this->db->select('distribution_plan_id,print,edisi.kode_edisi,print,date_publish,print_number,is_realisasi,majalah.majalah_id');
		$this->db->from('distribution_plan');
		$this->db->join('edisi', 'distribution_plan.edisi_id = edisi.edisi_id','LEFT');
		$this->db->join('majalah', 'edisi.majalah_id = majalah.majalah_id','LEFT');
		$this->db->where('distribution_plan_id',$id);
		return $this->db->get()->row_array();
	}

	function update_rencana_distribusi($id,$data)
	{
		$data['user_update'] = $this->session->userdata('id');
		$data['date_update'] = date("Y-m-d h:i:s");
		$this->db->where('distribution_plan_id',$id);
		$this->db->update('distribution_plan',$data);
	}

	function update_realisasi_distribusi($id,$data)
	{
		$data['user_update'] = $this->session->userdata('id');
		$data['date_update'] = date("Y-m-d h:i:s");
		$this->db->where('distribution_realization_detail_id',$id);
		$this->db->update('distribution_realization_detail',$data);
	}

	function get_relasi_agent($data)
	{
		$this->db->where_not_in('agent_id',$data);
		return $this->db->get('agent')->result_array();
	}

	function get_agent_detail($id,$agent_category)
	{
		$this->db->select('distribution_plan_detail_id,distribution_plan_id,nama_agent,quota,consigned,gratis,disc_total,disc_deposit,distribution_plan_detail.agent_id');
		$this->db->from('distribution_plan_detail');
		$this->db->join('agent', 'distribution_plan_detail.agent_id = agent.agent_id','LEFT');
		$this->db->where('distribution_plan_id',$id);
		$this->db->where('distribution_plan_detail.date_delete','0000-00-00 00:00:00');
		if ($agent_category > 0) {
			$this->db->where('agent.agent_category',$agent_category);
		}
		$this->db->order_by('nama_agent','ASC');
		return $this->db->get()->result_array();
	}

	function get_realisasi_agent_detail($id,$agent_category)
	{
		$this->db->select('distribution_realization_detail_id,nama_agent,ekspedisi,quota,consigned,gratis,distribution_realization_detail.date_created,distribution_realization_detail.agent_id,disc_total,disc_deposit');
		$this->db->from('distribution_realization_detail');
		$this->db->join('agent', 'distribution_realization_detail.agent_id = agent.agent_id','LEFT');
		$this->db->where('distribution_plan_id',$id);
		if ($agent_category > 0) {
			$this->db->where('agent.agent_category',$agent_category);
		}
		$this->db->where('distribution_realization_detail.date_delete','0000-00-00 00:00:00');
		$this->db->order_by('nama_agent','ASC');
		return $this->db->get()->result_array();
	}

	function edit_realisasi_agent_detail($id)
	{
		$this->db->select('distribution_realization_detail_id,nama_agent,ekspedisi,quota,consigned,gratis,distribution_realization_detail.date_created,distribution_realization_detail.agent_id,disc_total,disc_deposit');
		$this->db->from('distribution_realization_detail');
		$this->db->join('agent', 'distribution_realization_detail.agent_id = agent.agent_id','LEFT');
		$this->db->where('distribution_realization_detail_id',$id);
		$this->db->where('distribution_realization_detail.date_delete','0000-00-00 00:00:00');
		$this->db->limit(1);
		return $this->db->get()->row_array();
	}

	function get_realisation_agent_detail($id)
	{
		return $this->db->query('SELECT DISTINCT nama_agent,agent.agent_id from distribution_plan_detail LEFT JOIN agent ON distribution_plan_detail.agent_id = agent.agent_id WHERE distribution_plan_id = '.$id)->result_array();
	}

	function tambah_agent_detail($data)
	{
		$data['user_created'] = $this->session->userdata('id');
		$this->db->insert('distribution_plan_detail',$data);
	}

	function tambah_agent_realizaton_detail($data)
	{
		$data['user_created'] = $this->session->userdata('id');
		$this->db->insert('distribution_realization_detail',$data);
	}

	function update_agent_detail($id,$data)
	{
		$data['user_update'] = $this->session->userdata('id');
		$data['date_update'] = date("Y-m-d h:i:s");
		$this->db->where('distribution_plan_detail_id',$id);
		$this->db->update('distribution_plan_detail',$data);
	}

	function get_some_agent_detail($detail)
	{
		$this->db->select('*');
		$this->db->from('distribution_plan_detail');
		$this->db->join('agent','distribution_plan_detail.agent_id = agent.agent_id','LEFT');
		$this->db->where_in('distribution_plan_detail_id',$detail);
		return $this->db->get()->result_array();
	}

	function get_some_agent_realization_detail($detail)
	{
		$this->db->select('distribution_realization_detail.*,agent.nama_agent,agent.address,agent.npwp');
		$this->db->from('distribution_realization_detail');
		$this->db->join('agent','distribution_realization_detail.agent_id = agent.agent_id','LEFT');
		$this->db->where_in('distribution_realization_detail_id',$detail);
		return $this->db->get()->result_array();
	}

	function get_one_agent_detail($detail)
	{
		$this->db->select('*');
		$this->db->from('distribution_plan_detail');
		$this->db->join('agent','distribution_plan_detail.agent_id = agent.agent_id','LEFT');
		$this->db->where('distribution_plan_detail_id',$detail);
		return $this->db->get()->row_array();
	}

	function hapus_agent($detail)
	{
		$data['user_delete'] = $this->session->userdata('id');
		$data['date_delete'] = date("Y-m-d h:i:s");
		$this->db->where('distribution_plan_detail.distribution_plan_detail_id',$detail);
		$this->db->update('distribution_plan_detail',$data);
	}

	function hapus_realisasi_agent($detail)
	{
		$data['user_delete'] = $this->session->userdata('id');
		$data['date_delete'] = date("Y-m-d h:i:s");
		$this->db->where('distribution_realization_detail_id',$detail);
		$this->db->update('distribution_realization_detail',$data);
	}

	function hapus_realisasi($detail)
	{
		$data['user_delete'] = $this->session->userdata('id');
		$data['date_delete'] = date("Y-m-d h:i:s");
		$this->db->where('distribution_plan_id',$detail);
		$this->db->update('distribution_realization_detail',$data);
	}

	function hapus_rencana($id)
	{
		$data['user_delete'] = $this->session->userdata('id');
		$data['date_delete'] = date("Y-m-d h:i:s");
		$this->db->where('distribution_plan_id',$id);
		$this->db->update('distribution_plan',$data);
	}

	function rollback_realisasi_distribusi($id)
	{
		$data['user_realisasi'] = $this->session->userdata('id');
		$data['is_realisasi'] = 0;
		$this->db->where('distribution_plan_id',$id);
		$this->db->update('distribution_plan',$data);	
	}

	function realisasi_distribusi($id)
	{
		$data['user_realisasi'] = $this->session->userdata('id');
		$data['is_realisasi'] = 1;
		$this->db->where('distribution_plan_id',$id);
		$this->db->update('distribution_plan',$data);	
	}

	function lock_distribusi($id)
	{
		$data['user_realisasi'] = $this->session->userdata('id');
		$data['is_realisasi'] = 2;
		$this->db->where('distribution_plan_id',$id);
		$this->db->update('distribution_plan',$data);	
	}

	//AGENT MAGAZINE DETAIL
	function get_agent_magazine_detail($majalah)
	{
		$this->db->where('majalah_id',$majalah);
		$this->db->where('date_delete','0000-00-00 00:00:00');
		return $this->db->get('agent_magazine_detail')->result_array();
	}

	//RETUR MAJALAH
	function get_do($agent_id,$edisi)
	{
		$this->db->select('distribution_realization_detail.*,distribution_plan.date_publish,edisi.retur_date,nama_majalah');
		$this->db->from('distribution_realization_detail');
		$this->db->join('distribution_plan','distribution_realization_detail.distribution_plan_id = distribution_plan.distribution_plan_id','LEFT');
		$this->db->join('edisi','distribution_plan.edisi_id = edisi.edisi_id','LEFT');
		$this->db->join('majalah','edisi.majalah_id = majalah.majalah_id','LEFT');
		$this->db->where('distribution_realization_detail.agent_id',$agent_id);
		$this->db->where_in('distribution_plan.is_realisasi',array('2'));
		$this->db->where('distribution_plan.edisi_id',$edisi);
		$this->db->where('distribution_realization_detail.date_delete','0000-00-00 00:00:00');
		return $this->db->get()->result_array();
	}

	function get_jumlah_do($do)
	{
		$this->db->select('distribution_realization_detail.*');
		$this->db->from('distribution_realization_detail');
		$this->db->join('distribution_plan','distribution_realization_detail.distribution_plan_id = distribution_plan.distribution_plan_id','LEFT');
		$this->db->where('distribution_realization_detail.distribution_realization_detail_id',$do);
		$this->db->where_in('distribution_plan.is_realisasi',array('1','2'));
		return $this->db->get()->row_array();
	}

	function get_return($agent,$edisi)
	{
		$this->db->where('agent_id',$agent);
		$this->db->where('edisi_id',$edisi);
		$this->db->where('return_item.date_delete','0000-00-00 00:00:00');
		return $this->db->get('return_item')->result_array();
	}

	function get_all_return($majalah,$edisi,$page)
	{
		$this->db->select('agent.nama_agent,return_item.*,majalah.nama_majalah,edisi.kode_edisi');
		$this->db->from('return_item');
		$this->db->join('agent','return_item.agent_id = agent.agent_id','LEFT');
		$this->db->join('majalah','return_item.majalah_id = majalah.majalah_id','LEFT');
		$this->db->join('edisi','return_item.edisi_id = edisi.edisi_id','LEFT');

		if ($majalah != 0 || $majalah = '') {
			$this->db->where('return_item.majalah_id',$majalah);
		}
		if ($edisi != 0 || $edisi != '') {
			$this->db->where('return_item.edisi_id',$edisi);
		}
		if ($page != 0 || $page != '') {
			$this->db->limit(10,$page);
		}

		$this->db->where('return_item.date_delete','0000-00-00 00:00:00');
		$this->db->order_by('agent.nama_agent', 'ASC');
		$this->db->order_by('return_item_id', 'DESC');
		return $this->db->get();
	}

	function get_one_return_item($id)
	{
		$this->db->select('return_item.*,nama_majalah,kode_edisi,distribution_realization_detail_id,distribution_realization_detail.date_created,distribution_plan.date_publish,edisi.retur_date');
		$this->db->from('return_item');
		$this->db->join('majalah','return_item.majalah_id = majalah.majalah_id','LEFT');
		$this->db->join('edisi','return_item.edisi_id = edisi.edisi_id','LEFT');
		$this->db->join('distribution_plan','return_item.edisi_id = distribution_plan.edisi_id','LEFT');
		$this->db->join('distribution_realization_detail','return_item.distribution_realization_id = distribution_realization_detail.distribution_realization_detail_id','LEFT');
		$this->db->where('return_item_id',$id);
		$this->db->where('return_item.date_delete','0000-00-00 00:00:00');
		$this->db->where('distribution_plan.date_delete','0000-00-00 00:00:00');
		$this->db->limit(1);
		return $this->db->get()->row_array();		
	}

	function simpan_retur_majalah($data)
	{
		$data['user_created'] = $this->session->userdata('id');
		$data['date_created'] = date("Y-m-d h:i:s");
		$this->db->insert('return_item',$data);
	}

	function update_retur_majalah($id,$data)
	{
		$data['user_update'] = $this->session->userdata('id');
		$data['date_update'] = date("Y-m-d h:i:s");
		$this->db->where('return_item_id',$id);
		$this->db->update('return_item',$data);
	}

	function hapus_return_item($return_item_id)
	{
		$data['user_delete'] = $this->session->userdata('id');
		$data['date_delete'] = date("Y-m-d h:i:s");
		$this->db->where('return_item_id',$return_item_id);
		$this->db->update('return_item',$data);
	}

	//LAPORAN
	function get_laporan_do($edisi)
	{
		$this->db->select('distribution_realization_detail_id,nama_agent,distribution_realization_detail.agent_id,distribution_plan.print,quota,consigned,gratis,distribution_realization_detail.agent_id,nama_agent_cat,agent_category_id,city.name,distribution_realization_detail.date_created,nama_majalah');
		$this->db->from('distribution_realization_detail');
		$this->db->join('distribution_plan', 'distribution_realization_detail.distribution_plan_id = distribution_plan.distribution_plan_id','LEFT');
		$this->db->join('edisi', 'distribution_plan.edisi_id = edisi.edisi_id','LEFT');
		$this->db->join('majalah', 'edisi.majalah_id = majalah.majalah_id','LEFT');
		$this->db->join('agent', 'distribution_realization_detail.agent_id = agent.agent_id','LEFT');
		$this->db->join('agent_category', 'agent.agent_category = agent_category.agent_category_id','LEFT');
		$this->db->join('city', 'agent.kota = city.id','LEFT');
		$this->db->where('distribution_plan.edisi_id',$edisi);
		$this->db->where('distribution_realization_detail.date_delete','0000-00-00 00:00:00');
		$this->db->where('distribution_plan.date_delete','0000-00-00 00:00:00');
		$this->db->where('distribution_plan.is_realisasi !=','0');
		$this->db->order_by('nama_agent_cat','ASC');
		$this->db->order_by('city.name','ASC');
		$this->db->order_by('nama_agent','ASC');
		return $this->db->get()->result_array();
	}

	function get_laporan_realisasi_distribusi($majalah,$edisi)
	{
		$this->db->select('distribution_realization_detail_id,nama_agent,distribution_realization_detail.agent_id,print,sum(quota) as quota,sum(consigned) as consigned,sum(gratis) as gratis,disc_total,distribution_realization_detail.agent_id,nama_agent_cat,agent_category_id,city.name,harga');
		$this->db->from('distribution_realization_detail');
		$this->db->join('distribution_plan', 'distribution_realization_detail.distribution_plan_id = distribution_plan.distribution_plan_id','LEFT');
		$this->db->join('agent', 'distribution_realization_detail.agent_id = agent.agent_id','LEFT');
		$this->db->join('agent_category', 'agent.agent_category = agent_category.agent_category_id','LEFT');
		$this->db->join('city', 'agent.kota = city.id','LEFT');
		$this->db->join('edisi', 'distribution_plan.edisi_id = edisi.edisi_id','LEFT');
		$this->db->where('distribution_plan.edisi_id',$edisi);
		$this->db->where('distribution_realization_detail.date_delete','0000-00-00 00:00:00');
		$this->db->where('distribution_plan.date_delete','0000-00-00 00:00:00');
		$this->db->where('distribution_plan.is_realisasi !=','0');
		$this->db->order_by('nama_agent_cat','ASC');
		$this->db->order_by('city.name','ASC');
		$this->db->order_by('nama_agent','ASC');
		$this->db->group_by('agent_id');
		return $this->db->get()->result_array();
	}

	function get_laporan_rencana_distribusi($majalah,$edisi)
	{
		$this->db->select('distribution_plan_detail_id,nama_agent,distribution_plan_detail.agent_id,print,quota,consigned,gratis,distribution_plan_detail.agent_id,nama_agent_cat,agent_category_id,city.name');
		$this->db->from('distribution_plan_detail');
		$this->db->join('distribution_plan', 'distribution_plan_detail.distribution_plan_id = distribution_plan.distribution_plan_id','LEFT');
		$this->db->join('agent', 'distribution_plan_detail.agent_id = agent.agent_id','LEFT');
		$this->db->join('agent_category', 'agent.agent_category = agent_category.agent_category_id','LEFT');
		$this->db->join('city', 'agent.kota = city.id','LEFT');
		$this->db->where('distribution_plan.edisi_id',$edisi);
		$this->db->where('distribution_plan_detail.date_delete','0000-00-00 00:00:00');
		$this->db->where('distribution_plan.date_delete','0000-00-00 00:00:00');
		$this->db->order_by('nama_agent_cat','ASC');
		$this->db->order_by('city.name','ASC');
		$this->db->order_by('nama_agent','ASC');
		return $this->db->get()->result_array();
	}

	function get_laporan_agent()
	{
		$this->db->select('agent_id,nama_agent,kota,phone,contact,nama_agent_cat,agent_category_id,discount,deposit');
		$this->db->from('agent');
		$this->db->join('agent_category', 'agent.agent_category = agent_category.agent_category_id','LEFT');
		$this->db->where('agent.date_delete','0000-00-00 00:00:00');
		$this->db->order_by('agent_category.agent_category_id','ASC');
		$this->db->order_by('kota','ASC');
		$this->db->order_by('nama_agent','ASC');
		return $this->db->get()->result_array();
	}

	//laporan retur
	function find_return($majalah_id,$edisi_id,$startdate,$enddate,$agent)
	{
		
		$this->db->select('return_item.agent_id,agent_category_id,distribution_realization_detail.distribution_plan_id,return_item.edisi_id,nama_agent_cat,name as kota,nama_agent,sum(return_item.jumlah ) as jumlah, count(return_item_id) as xretur');
		$this->db->from('return_item');
		$this->db->join('distribution_realization_detail','return_item.distribution_realization_id = distribution_realization_detail.distribution_realization_detail_id','left');
		$this->db->join('distribution_plan','distribution_realization_detail.distribution_plan_id = distribution_plan.distribution_plan_id','left');
		$this->db->join('agent','distribution_realization_detail.agent_id = agent.agent_id','left');
		$this->db->join('agent_category','agent.agent_category = agent_category.agent_category_id','left');
		$this->db->join('city','agent.kota = city.id','left');

		if ($edisi_id != '') {
			$this->db->where('distribution_plan.edisi_id ',$edisi_id);
		}
		if ($startdate != '') {
			$this->db->where('return_item.return_date >=',$startdate.' 00:00:00');
		}
		if ($enddate != '') {
			$this->db->where('return_item.return_date <=',$enddate.' 23:59:59');
		}

		if ($agent != '') {
			$this->db->where('return_item.agent_id ',$agent);
		}
		
		$this->db->where('return_item.return_date <=',$enddate.' 23:59:59');
		$this->db->where('distribution_plan.date_delete','0000-00-00 00:00:00');
		$this->db->where('return_item.date_delete','0000-00-00 00:00:00');
		$this->db->order_by('nama_agent_cat', 'ASC');
		$this->db->order_by('name', 'ASC');
		$this->db->order_by('nama_agent', 'ASC');
		$this->db->group_by('agent_id');
		return $this->db->get()->result_array();
	}

	function find_return_by_agent($majalah_id,$edisi_id,$startdate,$enddate,$agent)
	{
		
		$this->db->select('return_item.agent_id,return_item.no_return,return_item.return_date,agent_category_id,distribution_realization_detail.distribution_plan_id,return_item.edisi_id,nama_agent_cat,nama_agent,name as kota,nama_agent,jumlah,majalah.nama_majalah,edisi.kode_edisi');
		$this->db->from('return_item');
		$this->db->join('distribution_realization_detail','return_item.distribution_realization_id = distribution_realization_detail.distribution_realization_detail_id','left');
		$this->db->join('distribution_plan','distribution_realization_detail.distribution_plan_id = distribution_plan.distribution_plan_id','left');
		$this->db->join('agent','distribution_realization_detail.agent_id = agent.agent_id','left');
		$this->db->join('agent_category','agent.agent_category = agent_category.agent_category_id','left');
		$this->db->join('majalah','return_item.majalah_id = majalah.majalah_id','left');
		$this->db->join('edisi','return_item.edisi_id = edisi.edisi_id','left');
		$this->db->join('city','agent.kota = city.id','left');

		if ($edisi_id != '') {
			$this->db->where('distribution_plan.edisi_id ',$edisi_id);
		}
		if ($startdate != '') {
			$this->db->where('return_item.return_date >=',$startdate.' 00:00:00');
		}
		if ($enddate != '') {
			$this->db->where('return_item.return_date <=',$enddate.' 23:59:59');
		}

		if ($agent != '') {
			$this->db->where('return_item.agent_id ',$agent);
		}
		
		$this->db->where('return_item.return_date <=',$enddate.' 23:59:59');
		$this->db->where('distribution_plan.date_delete','0000-00-00 00:00:00');
		$this->db->where('return_item.date_delete','0000-00-00 00:00:00');
		$this->db->order_by('nama_agent_cat', 'ASC');
		$this->db->order_by('name', 'ASC');
		$this->db->order_by('nama_agent', 'ASC');
		return $this->db->get()->result_array();
	}

	function quotaretur($distribution_plan_id,$agent_id)
	{
		$this->db->select('sum(quota) as quota, sum(consigned) as consigned');
		$this->db->from('distribution_realization_detail');
		$this->db->where('distribution_realization_detail.distribution_plan_id ',$distribution_plan_id);
		$this->db->where('distribution_realization_detail.agent_id ',$agent_id);
		$this->db->where('distribution_realization_detail.date_delete','0000-00-00 00:00:00');
		$this->db->group_by('agent_id');
		return $this->db->get()->row_array();
	}

	//laporan penjualan majalah
	function jumlahretur($agent_id,$edisi_id)
	{
		$this->db->select('sum(jumlah) as retur');
		$this->db->from('return_item');
		$this->db->where('agent_id',$agent_id);
		$this->db->where('edisi_id',$edisi_id);
		$this->db->where('return_item.date_delete','0000-00-00 00:00:00');
		return $this->db->get()->row_array();
	}

}