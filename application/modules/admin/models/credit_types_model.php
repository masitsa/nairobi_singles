<?php

class Credit_types_model extends CI_Model 
{	
	/*
	*	Retrieve all credit_types
	*
	*/
	public function all_credit_types()
	{
		$this->db->where('credit_type_status = 1');
		$query = $this->db->get('credit_type');
		
		return $query;
	}
	/*
	*	Retrieve all credit_types by category
	*	@param int $category_id
	*
	*/
	public function all_credit_types_by_category($category_id)
	{
		$this->db->where('credit_type_status = 1 AND (category_id = '.$category_id.' OR category_id = 0)');
		$query = $this->db->get('credit_type');
		
		return $query;
	}
	
	/*
	*	Retrieve all credit_types
	*	@param string $table
	* 	@param string $where
	*
	*/
	public function get_all_credit_types($table, $where, $per_page, $page)
	{
		//retrieve all users
		$this->db->from($table);
		$this->db->select('credit_type.*, category.category_name');
		$this->db->where($where);
		$this->db->order_by('category_name, credit_type_name');
		$query = $this->db->get('', $per_page, $page);
		
		return $query;
	}
	
	/*
	*	Add a new credit_type
	*
	*/
	public function add_credit_type()
	{
		$data = array(
				'credit_type_name'=>ucwords(strtolower($this->input->post('credit_type_name'))),
				'category_id'=>$this->input->post('category_id'),
				'credit_type_status'=>$this->input->post('credit_type_status'),
				'created'=>date('Y-m-d H:i:s'),
				'created_by'=>$this->session->userdata('user_id'),
				'modified_by'=>$this->session->userdata('user_id')
			);
			
		if($this->db->insert('credit_type', $data))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	/*
	*	Update an existing credit_type
	*	@param int $credit_type_id
	*
	*/
	public function update_credit_type($credit_type_id)
	{
		$data = array(
				'credit_type_name'=>ucwords(strtolower($this->input->post('credit_type_name'))),
				'category_id'=>$this->input->post('category_id'),
				'credit_type_status'=>$this->input->post('credit_type_status'),
				'modified_by'=>$this->session->userdata('user_id')
			);
			
		$this->db->where('credit_type_id', $credit_type_id);
		if($this->db->update('credit_type', $data))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	/*
	*	get a single credit_type's details
	*	@param int $credit_type_id
	*
	*/
	public function get_credit_type($credit_type_id)
	{
		$this->db->from('credit_type');
		$this->db->select('*');
		$this->db->where('credit_type_id = '.$credit_type_id);
		$query = $this->db->get();
		
		return $query;
	}
	
	/*
	*	Delete an existing credit_type
	*	@param int $credit_type_id
	*
	*/
	public function delete_credit_type($credit_type_id)
	{
		if($this->db->delete('credit_type', array('credit_type_id' => $credit_type_id)))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	/*
	*	Activate a deactivated credit_type
	*	@param int $credit_type_id
	*
	*/
	public function activate_credit_type($credit_type_id)
	{
		$data = array(
				'credit_type_status' => 1
			);
		$this->db->where('credit_type_id', $credit_type_id);
		
		if($this->db->update('credit_type', $data))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	/*
	*	Deactivate an activated credit_type
	*	@param int $credit_type_id
	*
	*/
	public function deactivate_credit_type($credit_type_id)
	{
		$data = array(
				'credit_type_status' => 0
			);
		$this->db->where('credit_type_id', $credit_type_id);
		
		if($this->db->update('credit_type', $data))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
}
?>