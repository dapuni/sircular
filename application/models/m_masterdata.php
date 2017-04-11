<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
* 
*/
class M_masterdata extends CI_model
{
	//PENERBIT
	function tambah_penerbit($data)
	{
		$data['user_created'] = $this->session->userdata('id');
		$this->db->insert('penerbit',$data);
	}

	function hapus_penerbit($id)
	{
		$data['user_delete'] = $this->session->userdata('id');
		$data['date_delete'] = date("Y-m-d h:i:s");
		$this->db->where('penerbit_id',$id);
		$this->db->update('penerbit',$data);
	}

	function get_penerbit()
	{
		$this->db->select('penerbit.*,provinces.name as nama_provinsi, city.name as nama_kota');
		$this->db->from('penerbit');
		$this->db->join('provinces', 'penerbit.provinsi = provinces.id','LEFT');
		$this->db->join('city', 'penerbit.kota = city.id','LEFT');
		$this->db->where('date_delete','0000-00-00 00:00:00');
		return $this->db->get()->result_array();
	}

	function find_penerbit($find,$page)
	{
		$this->db->select('penerbit.*,provinces.name as nama_provinsi, city.name as nama_kota');
		$this->db->from('penerbit');
		$this->db->join('provinces', 'penerbit.provinsi = provinces.id','LEFT');
		$this->db->join('city', 'penerbit.kota = city.id','LEFT');
		$this->db->where('date_delete','0000-00-00 00:00:00');
		if ($find != '') 
		{
			$this->db->where('kota',$find);
		}
		if ($page != 0 || $page != '') 
		{
			$this->db->limit(10,$page);
		}
		$this->db->order_by('penerbit.nama','ASC');
		return $this->db->get();
	}

	function edit_penerbit($id)
	{
		$this->db->where('penerbit_id',$id);
		return $this->db->get('penerbit')->row_array();
	}

	function update_penerbit($id,$data)
	{
		$data['user_update'] = $this->session->userdata('id');
		$data['date_update'] = date("Y-m-d h:i:s");
		$this->db->where('penerbit_id',$id);
		$this->db->update('penerbit',$data);
	}

	//MAJALAH
	function get_majalah()
	{
		$this->db->select('majalah.*,penerbit.nama,penerbit.npwp,penerbit.alamat,penerbit.phone');
		$this->db->from('majalah');
		$this->db->join('penerbit', 'majalah.penerbit_id = penerbit.penerbit_id','LEFT');
		$this->db->where('majalah.date_delete','0000-00-00 00:00:00');
		$this->db->order_by('majalah.nama_majalah','ASC');
		return $this->db->get()->result_array();
	}

	function find_majalah($find,$page)
	{
		$this->db->select('majalah.*,penerbit.nama,penerbit.npwp,penerbit.alamat,penerbit.phone');
		$this->db->from('majalah');
		$this->db->join('penerbit', 'majalah.penerbit_id = penerbit.penerbit_id','LEFT');
		$this->db->where('majalah.date_delete','0000-00-00 00:00:00');
		if ($find != '') 
		{
			$this->db->where('majalah.penerbit_id',$find);
		}
		if ($page != 0 || $page != '') 
		{
			$this->db->limit(10,$page);
		}
		$this->db->order_by('majalah.nama_majalah','ASC');
		return $this->db->get();
	}

	function tambah_majalah($data)
	{
		$data['user_created'] = $this->session->userdata('id');
		$this->db->insert('majalah',$data);
	}

	function edit_majalah($id)
	{
		$this->db->where('majalah_id',$id);
		return $this->db->get('majalah')->row_array();
	}

	function update_majalah($id,$data)
	{
		$data['user_update'] = $this->session->userdata('id');
		$data['date_update'] = date("Y-m-d h:i:s");
		$this->db->where('majalah_id',$id);
		$this->db->update('majalah',$data);
	}

	function hapus_majalah($id)
	{
		$data['user_delete'] = $this->session->userdata('id');
		$data['date_delete'] = date("Y-m-d h:i:s");
		$this->db->where('majalah_id',$id);
		$this->db->update('majalah',$data);
	}

	//EDISI
	function get_edisi()
	{
		$this->db->select('edisi_id,kode_edisi,edisi.harga,nama_majalah');
		$this->db->from('edisi');
		$this->db->join('majalah', 'edisi.majalah_id = majalah.majalah_id','LEFT');
		$this->db->where('edisi.date_delete','0000-00-00 00:00:00');
		return $this->db->get()->result_array();
	}

	function cari_edisi($cari,$page)
	{
		$this->db->select('edisi_id,kode_edisi,edisi.harga,retur_date,nama_majalah');
		$this->db->from('edisi');
		$this->db->join('majalah', 'edisi.majalah_id = majalah.majalah_id','LEFT');
		$this->db->where('edisi.date_delete','0000-00-00 00:00:00');
		if ($cari != 0) {
			$this->db->where('majalah.majalah_id',$cari);
		}
		if ($page != 0 || $page != '') {
			$this->db->limit(10,$page);
		}
		$this->db->order_by('edisi_id','DESC');
		return $this->db->get();
	}

	function tambah_edisi($data)
	{
		$data['user_created'] = $this->session->userdata('id');
		$this->db->insert('edisi',$data);
	}

	function edit_edisi($id)
	{
		$this->db->select('edisi_id,edisi.majalah_id,kode_edisi,retur_date,edisi.harga,nama_majalah');
		$this->db->from('edisi');
		$this->db->join('majalah', 'edisi.majalah_id = majalah.majalah_id','LEFT');
		$this->db->where('edisi_id',$id);
		return $this->db->get()->row_array();
	}

	function update_edisi($id,$data)
	{
		$data['user_update'] = $this->session->userdata('id');
		$data['date_update'] = date("Y-m-d h:i:s");
		$this->db->where('edisi_id',$id);
		$this->db->update('edisi',$data);
	}

	function hapus_edisi($id)
	{
		$data['user_delete'] = $this->session->userdata('id');
		$data['date_delete'] = date("Y-m-d h:i:s");
		$this->db->where('edisi_id',$id);
		$this->db->update('edisi',$data);
	}

	//AGENT CAT
	function tambah_agent_cat($data)
	{
		$data['user_created'] = $this->session->userdata('id');
		$this->db->insert('agent_category',$data);
	}

	function get_agent_cat()
	{
		$this->db->where('date_delete','0000-00-00 00:00:00');
		$this->db->order_by('nama_agent_cat','ASC');
		return $this->db->get('agent_category')->result_array();
	}

	function edit_agent_cat($id)
	{
		$this->db->where('agent_category_id',$id);
		return $this->db->get('agent_category')->row_array();
	}

	function update_agent_cat($id,$data)
	{
		$data['user_update'] = $this->session->userdata('id');
		$data['date_update'] = date("Y-m-d h:i:s");
		$this->db->where('agent_category_id',$id);
		$this->db->update('agent_category',$data);
	}

	function hapus_agent_cat($id)
	{
		$data['user_delete'] = $this->session->userdata('id');
		$data['date_delete'] = date("Y-m-d h:i:s");
		$this->db->where('agent_category_id',$id);
		$this->db->update('agent_category',$data);
	}

	//AGENT
	function get_agent()
	{
		$this->db->select('agent_id,nama_agent,agent_category,kota,phone,contact,address,nama_agent_cat,discount,deposit,city.name');
		$this->db->from('agent');
		$this->db->join('agent_category', 'agent.agent_category = agent_category.agent_category_id','LEFT');
		$this->db->join('city', 'agent.kota = city.id','LEFT');
		$this->db->where('agent.date_delete','0000-00-00 00:00:00');
		$this->db->order_by('nama_agent_cat','ASC');
		$this->db->order_by('nama_agent','ASC');
		return $this->db->get()->result_array();
	}

	function tambah_agent($data)
	{
		$data['user_created'] = $this->session->userdata('id');
		$data['date_created'] = date("Y-m-d h:i:s");
		$this->db->insert('agent',$data);
	}

	function hapus_agent($id)
	{
		$data['user_delete'] = $this->session->userdata('id');
		$data['date_delete'] = date("Y-m-d h:i:s");
		$this->db->where('agent_id',$id);
		$this->db->update('agent',$data);
	}

	function edit_agent($id)
	{
		$this->db->select('agent_id,nama_agent,kota,phone,contact,nama_agent_cat,address,discount,deposit,agent_category,city.name');
		$this->db->from('agent');
		$this->db->join('agent_category', 'agent.agent_category = agent_category.agent_category_id','LEFT');
		$this->db->join('city', 'agent.kota = city.id','LEFT');
		$this->db->where('agent_id',$id);
		return $this->db->get()->row_array();
	}

	function update_agent($id,$data)
	{
		$data['user_update'] = $this->session->userdata('id');
		$data['date_update'] = date("Y-m-d h:i:s");
		$this->db->where('agent_id',$id);
		$this->db->update('agent',$data);
	}

	function find_agent($category_agent,$kota,$page)
	{
		$this->db->select('agent_id,nama_agent,agent_category,kota,phone,contact,nama_agent_cat,discount,city.name');
		$this->db->from('agent');
		$this->db->join('agent_category', 'agent.agent_category = agent_category.agent_category_id','LEFT');
		$this->db->join('city', 'agent.kota = city.id','LEFT');
		if ($category_agent != 0) {
			$this->db->where('agent.agent_category',$category_agent);
		}
		if ($kota != 0) {
			$this->db->where('agent.kota',$kota);
		}
		if ($page != 0 || $page != '') {
			$this->db->limit(10,$page);
		}
		$this->db->where('agent.date_delete','0000-00-00 00:00:00');
		$this->db->order_by('agent_category_id','ASC');
		return $this->db->get();
	}

	function simpan_agent_magazine_detail($data)
	{
		$data['user_created'] = $this->session->userdata('id');
		$data['date_created'] = date("Y-m-d h:i:s");
		$this->db->insert('agent_magazine_detail',$data);
	}

	function get_agent_magazine_detail($id)
	{
		$this->db->select('agent_magazine_detail.*,majalah.nama_majalah');
		$this->db->from('agent_magazine_detail');
		$this->db->join('majalah', 'agent_magazine_detail.majalah_id = majalah.majalah_id', 'LEFT');
		$this->db->where('agent_magazine_detail.majalah_id',$id);
		$this->db->where('agent_magazine_detail.date_delete','0000-00-00 00:00:00');
		return $this->db->get()->result_array();
	}

	function get_agent_magazine_detail_by_agent($id)
	{
		$this->db->select('agent_magazine_detail.*,majalah.nama_majalah');
		$this->db->from('agent_magazine_detail');
		$this->db->join('majalah', 'agent_magazine_detail.majalah_id = majalah.majalah_id', 'LEFT');
		$this->db->where('agent_magazine_detail.agent_id',$id);
		$this->db->where('agent_magazine_detail.date_delete','0000-00-00 00:00:00');
		return $this->db->get()->result_array();
	}

	function all_agent_magazine_detail()
	{
		$this->db->select('agent_magazine_detail.*,majalah.nama_majalah,agent.nama_agent,name,agent_category.nama_agent_cat');
		$this->db->from('agent_magazine_detail');
		$this->db->join('majalah', 'agent_magazine_detail.majalah_id = majalah.majalah_id', 'LEFT');
		$this->db->join('agent', 'agent_magazine_detail.agent_id = agent.agent_id', 'LEFT');
		$this->db->join('city', 'agent.kota = city.id', 'LEFT');
		$this->db->join('agent_category', 'agent.agent_category = agent_category.agent_category_id', 'LEFT');
		$this->db->order_by('agent_category_id','ASC');
		$this->db->order_by('agent.kota','ASC');
		$this->db->order_by('agent.nama_agent','ASC');
		$this->db->where('agent_magazine_detail.date_delete','0000-00-00 00:00:00');
		return $this->db->get()->result_array();
	}

	function check_agent_magazine_detail($agent_id,$majalah)
	{
		$this->db->where('agent_id',$agent_id);
		$this->db->where('majalah_id',$majalah);
		$this->db->where('agent_magazine_detail.date_delete','0000-00-00 00:00:00');
		$this->db->limit(1);
		return $this->db->get('agent_magazine_detail')->num_rows();
	}

	function update_agent_magazine_detail($agent_id,$majalah,$data)
	{
		$data['user_update'] = $this->session->userdata('id');
		$data['date_update'] = date("Y-m-d h:i:s");
		$this->db->where('agent_id',$agent_id);
		$this->db->where('majalah_id',$majalah);
		$this->db->update('agent_magazine_detail',$data);
	}

	function hapus_agent_magazine_detail($agent_id,$majalah)
	{
		$data['user_delete'] = $this->session->userdata('id');
		$data['date_delete'] = date("Y-m-d h:i:s");
		$this->db->where('agent_id',$agent_id);
		$this->db->where('majalah_id',$majalah);
		$this->db->update('agent_magazine_detail',$data);
	}

	//PROVINSI
	function get_provinsi()
	{
		return $this->db->get('provinces')->result_array();
	}

	//CITY
	function get_city()
	{
		$this->db->order_by('name','ASC');
		return $this->db->get('city')->result_array();
	}
}