<?php

class Clients_model extends CI_Model 
{	
	/*
	*	Retrieve all active clients
	*
	*/
	public function all_active_clients()
	{
		$this->db->where('client_status = 1');
		$query = $this->db->get('client');
		
		return $query;
	}
	
	/*
	*	Retrieve all genders
	*
	*/
	public function get_all_genders()
	{
		$this->db->where('gender_status = 1');
		$query = $this->db->get('gender');
		
		return $query;
	}
	
	/*
	*	Retrieve latest client
	*
	*/
	public function latest_client()
	{
		$this->db->limit(1);
		$this->db->order_by('created', 'DESC');
		$query = $this->db->get('client');
		
		return $query;
	}
	
	/*
	*	Retrieve all clients
	*	@param string $table
	* 	@param string $where
	*
	*/
	public function get_all_clients($table, $where, $per_page, $page, $order, $order_method)
	{
		//retrieve all users
		$this->db->from($table);
		$this->db->select('*');
		$this->db->where($where);
		$this->db->order_by($order, $order_method);
		$query = $this->db->get('', $per_page, $page);
		
		return $query;
	}
	
	/*
	*	Add a new client
	*	@param string $image_name
	*
	*/
	public function add_client($image_name)
	{
		$data = array(
				'client_name'=>ucwords(strtolower($this->input->post('client_name'))),
				'client_status'=>$this->input->post('client_status'),
				'created'=>date('Y-m-d H:i:s'),
				'created_by'=>$this->session->userdata('user_id'),
				'modified_by'=>$this->session->userdata('user_id'),
				'client_image_name'=>$image_name
			);
			
		if($this->db->insert('client', $data))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	/*
	*	Update an existing client
	*	@param string $image_name
	*	@param int $client_id
	*
	*/
	public function update_client($image_name, $client_id)
	{
		$data = array(
				'client_name'=>ucwords(strtolower($this->input->post('client_name'))),
				'client_status'=>$this->input->post('client_status'),
				'modified_by'=>$this->session->userdata('user_id'),
				'client_image_name'=>$image_name
			);
			
		$this->db->where('client_id', $client_id);
		if($this->db->update('client', $data))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	/*
	*	get a single client's details
	*	@param int $client_id
	*
	*/
	public function get_client($client_id)
	{
		//retrieve all users
		$this->db->from('client');
		$this->db->select('*');
		$this->db->where('client_id = '.$client_id);
		$query = $this->db->get();
		
		return $query;
	}
	
	/*
	*	Delete an existing client
	*	@param int $client_id
	*
	*/
	public function delete_client($client_id)
	{
		if($this->db->delete('client', array('client_id' => $client_id)))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	/*
	*	Activate a deactivated client
	*	@param int $client_id
	*
	*/
	public function activate_client($client_id)
	{
		$data = array(
				'client_status' => 1
			);
		$this->db->where('client_id', $client_id);
		
		if($this->db->update('client', $data))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	/*
	*	Deactivate an activated client
	*	@param int $client_id
	*
	*/
	public function deactivate_client($client_id)
	{
		$data = array(
				'client_status' => 0
			);
		$this->db->where('client_id', $client_id);
		
		if($this->db->update('client', $data))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
}
?>