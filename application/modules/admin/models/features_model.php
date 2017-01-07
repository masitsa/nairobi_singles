<?php

class features_model extends CI_Model 
{	
	/*
	*	Retrieve all features
	*
	*/
	public function all_features()
	{
		$this->db->where('feature_status = 1');
		$query = $this->db->get('feature');
		
		return $query;
	}
	/*
	*	Retrieve all features by category
	*	@param int $category_id
	*
	*/
	public function all_features_by_category($category_id)
	{
		$this->db->where('feature_status = 1 AND (category_id = '.$category_id.' OR category_id = 0)');
		$query = $this->db->get('feature');
		
		return $query;
	}
	
	/*
	*	Retrieve all features
	*	@param string $table
	* 	@param string $where
	*
	*/
	public function get_all_features($table, $where, $per_page, $page)
	{
		//retrieve all users
		$this->db->from($table);
		$this->db->select('feature.*, category.category_name');
		$this->db->where($where);
		$this->db->order_by('category_name, feature_name');
		$query = $this->db->get('', $per_page, $page);
		
		return $query;
	}
	
	/*
	*	Add a new feature
	*
	*/
	public function add_feature()
	{
		$data = array(
				'feature_name'=>ucwords(strtolower($this->input->post('feature_name'))),
				'category_id'=>$this->input->post('category_id'),
				'feature_status'=>$this->input->post('feature_status'),
				'created'=>date('Y-m-d H:i:s'),
				'created_by'=>$this->session->userdata('user_id'),
				'modified_by'=>$this->session->userdata('user_id')
			);
			
		if($this->db->insert('feature', $data))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	/*
	*	Update an existing feature
	*	@param int $feature_id
	*
	*/
	public function update_feature($feature_id)
	{
		$data = array(
				'feature_name'=>ucwords(strtolower($this->input->post('feature_name'))),
				'category_id'=>$this->input->post('category_id'),
				'feature_status'=>$this->input->post('feature_status'),
				'modified_by'=>$this->session->userdata('user_id')
			);
			
		$this->db->where('feature_id', $feature_id);
		if($this->db->update('feature', $data))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	/*
	*	get a single feature's details
	*	@param int $feature_id
	*
	*/
	public function get_feature($feature_id)
	{
		$this->db->from('feature');
		$this->db->select('*');
		$this->db->where('feature_id = '.$feature_id);
		$query = $this->db->get();
		
		return $query;
	}
	
	/*
	*	Delete an existing feature
	*	@param int $feature_id
	*
	*/
	public function delete_feature($feature_id)
	{
		if($this->db->delete('feature', array('feature_id' => $feature_id)))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	/*
	*	Activate a deactivated feature
	*	@param int $feature_id
	*
	*/
	public function activate_feature($feature_id)
	{
		$data = array(
				'feature_status' => 1
			);
		$this->db->where('feature_id', $feature_id);
		
		if($this->db->update('feature', $data))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	/*
	*	Deactivate an activated feature
	*	@param int $feature_id
	*
	*/
	public function deactivate_feature($feature_id)
	{
		$data = array(
				'feature_status' => 0
			);
		$this->db->where('feature_id', $feature_id);
		
		if($this->db->update('feature', $data))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
}
?>