<?php

class Email_campaigns_model extends CI_Model 
{	
	/*
	*	Retrieve all active email_campaigns
	*
	*/
	public function count_recepients($email_campaign_id)
	{
		$this->db->where('email_campaign_id', $email_campaign_id);
		$this->db->from('email_recepient');
		
		return $this->db->count_all_results();
	}
	
	/*
	*	Retrieve all email_campaigns
	*	@param string $table
	* 	@param string $where
	*
	*/
	public function get_all_email_campaigns($table, $where, $per_page, $page, $order, $order_method)
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
	*	Add a new email_campaign
	*	@param string $image_name
	*
	*/
	public function add_email_campaign($image_name)
	{
		$data = array(
				'email_campaign_name'=>ucwords(strtolower($this->input->post('email_campaign_name'))),
				'email_campaign_status'=>$this->input->post('email_campaign_status'),
				'created'=>date('Y-m-d H:i:s'),
				'created_by'=>$this->session->userdata('user_id'),
				'modified_by'=>$this->session->userdata('user_id'),
				'email_campaign_image_name'=>$image_name
			);
			
		if($this->db->insert('email_campaign', $data))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	/*
	*	Update an existing email_campaign
	*	@param string $image_name
	*	@param int $email_campaign_id
	*
	*/
	public function update_email_campaign($image_name, $email_campaign_id)
	{
		$data = array(
				'email_campaign_name'=>ucwords(strtolower($this->input->post('email_campaign_name'))),
				'email_campaign_status'=>$this->input->post('email_campaign_status'),
				'modified_by'=>$this->session->userdata('user_id'),
				'email_campaign_image_name'=>$image_name
			);
			
		$this->db->where('email_campaign_id', $email_campaign_id);
		if($this->db->update('email_campaign', $data))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	/*
	*	get a single email_campaign's details
	*	@param int $email_campaign_id
	*
	*/
	public function get_email_campaign($email_campaign_id)
	{
		//retrieve all users
		$this->db->from('email_campaign');
		$this->db->select('*');
		$this->db->where('email_campaign_id = '.$email_campaign_id);
		$query = $this->db->get();
		
		return $query;
	}
	
	/*
	*	Delete an existing email_campaign
	*	@param int $email_campaign_id
	*
	*/
	public function delete_email_campaign($email_campaign_id)
	{
		if($this->db->delete('email_campaign', array('email_campaign_id' => $email_campaign_id)))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	/*
	*	Activate a deactivated email_campaign
	*	@param int $email_campaign_id
	*
	*/
	public function activate_email_campaign($email_campaign_id)
	{
		$data = array(
				'email_campaign_status' => 1
			);
		$this->db->where('email_campaign_id', $email_campaign_id);
		
		if($this->db->update('email_campaign', $data))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	/*
	*	Deactivate an activated email_campaign
	*	@param int $email_campaign_id
	*
	*/
	public function deactivate_email_campaign($email_campaign_id)
	{
		$data = array(
				'email_campaign_status' => 0
			);
		$this->db->where('email_campaign_id', $email_campaign_id);
		
		if($this->db->update('email_campaign', $data))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
}
?>