<?php

class Brands_model extends CI_Model 
{	
	/*
	*	Retrieve all active brands
	*
	*/
	public function all_active_brands()
	{
		$this->db->where('brand_status = 1');
		$query = $this->db->get('brand');
		
		return $query;
	}
	
	/*
	*	Retrieve latest brand
	*
	*/
	public function latest_brand()
	{
		$this->db->limit(1);
		$this->db->order_by('created', 'DESC');
		$query = $this->db->get('brand');
		
		return $query;
	}
	
	/*
	*	Retrieve all brands
	*	@param string $table
	* 	@param string $where
	*
	*/
	public function get_all_brands($table, $where, $per_page, $page)
	{
		//retrieve all users
		$this->db->from($table);
		$this->db->select('*');
		$this->db->where($where);
		$this->db->order_by('brand_name');
		$query = $this->db->get('', $per_page, $page);
		
		return $query;
	}
	
	/*
	*	Add a new brand
	*	@param string $image_name
	*
	*/
	public function add_brand($image_name)
	{
		$data = array(
				'brand_name'=>ucwords(strtolower($this->input->post('brand_name'))),
				'brand_status'=>$this->input->post('brand_status'),
				'created'=>date('Y-m-d H:i:s'),
				'created_by'=>$this->session->userdata('user_id'),
				'modified_by'=>$this->session->userdata('user_id'),
				'brand_image_name'=>$image_name
			);
			
		if($this->db->insert('brand', $data))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	/*
	*	Update an existing brand
	*	@param string $image_name
	*	@param int $brand_id
	*
	*/
	public function update_brand($image_name, $brand_id)
	{
		$data = array(
				'brand_name'=>ucwords(strtolower($this->input->post('brand_name'))),
				'brand_status'=>$this->input->post('brand_status'),
				'modified_by'=>$this->session->userdata('user_id'),
				'brand_image_name'=>$image_name
			);
			
		$this->db->where('brand_id', $brand_id);
		if($this->db->update('brand', $data))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	/*
	*	get a single brand's details
	*	@param int $brand_id
	*
	*/
	public function get_brand($brand_id)
	{
		//retrieve all users
		$this->db->from('brand');
		$this->db->select('*');
		$this->db->where('brand_id = '.$brand_id);
		$query = $this->db->get();
		
		return $query;
	}
	
	/*
	*	Delete an existing brand
	*	@param int $brand_id
	*
	*/
	public function delete_brand($brand_id)
	{
		if($this->db->delete('brand', array('brand_id' => $brand_id)))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	/*
	*	Activate a deactivated brand
	*	@param int $brand_id
	*
	*/
	public function activate_brand($brand_id)
	{
		$data = array(
				'brand_status' => 1
			);
		$this->db->where('brand_id', $brand_id);
		
		if($this->db->update('brand', $data))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	/*
	*	Deactivate an activated brand
	*	@param int $brand_id
	*
	*/
	public function deactivate_brand($brand_id)
	{
		$data = array(
				'brand_status' => 0
			);
		$this->db->where('brand_id', $brand_id);
		
		if($this->db->update('brand', $data))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
}
?>