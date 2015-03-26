<?php

class Login_model extends CI_Model 
{
	/*
	*	Check if user has logged in
	*
	*/
	public function check_login()
	{
		if($this->session->userdata('login_status'))
		{
			return TRUE;
		}
		
		else
		{
			return FALSE;
		}
	}
	/*
	*	Check if client has logged in
	*
	*/
	public function check_client_login()
	{
		if($this->session->userdata('client_login_status'))
		{
			return TRUE;
		}
		
		else
		{
			return FALSE;
		}
	}
	
	/*
	*	Validate a user's login request
	*
	*/
	public function validate_user()
	{
		//select the user by email from the database
		$this->db->select('*');
		$this->db->where(array('email' => $this->input->post('email'), 'activated' => 1, 'password' => md5($this->input->post('password'))));
		$query = $this->db->get('users');
		
		//if users exists
		if ($query->num_rows() > 0)
		{
			$result = $query->result();
			//create user's login session
			$newdata = array(
                   'login_status'     => TRUE,
                   'first_name'     => $result[0]->first_name,
                   'email'     => $result[0]->email,
                   'user_id'  => $result[0]->user_id,
                   'user_level_id'  => $result[0]->user_level_id
               );

			$this->session->set_userdata($newdata);
			
			//update user's last login date time
			$this->update_user_login($result[0]->user_id);
			return TRUE;
		}
		
		//if user doesn't exist
		else
		{
			return FALSE;
		}
	}
	
	/*
	*	Update user's last login date
	*
	*/
	private function update_user_login($user_id)
	{
		$data['last_login'] = date('Y-m-d H:i:s');
		$this->db->where('user_id', $user_id);
		$this->db->update('users', $data); 
	}
	
	/*
	*	Reset a user's password
	*
	*/
	public function reset_password($user_id)
	{
		$new_password = substr(md5(date('Y-m-d H:i:s')), 0, 6);
		
		$data['password'] = md5($new_password);
		$this->db->where('user_id', $user_id);
		$this->db->update('users', $data); 
		
		return $new_password;
	}
	
	public function register_client_details()
	{
		$newdata = array(
			   'client_username'			=> $this->input->post('client_username'),
			   'client_email'				=> strtolower($this->input->post('client_email')),
			   'created'     				=> date('Y-m-d H:i:s'),
			   'client_password'			=> md5($this->input->post('client_password')),
			   'gender_id'					=> $this->input->post('gender_id'),
			   'client_looking_gender_id'	=> $this->input->post('client_looking_gender_id')
		   );

		if($this->db->insert('client', $newdata))
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
	
	/*
	*	Validate a client's login request
	*
	*/
	public function validate_client()
	{
		//select the user by email from the database
		$this->db->select('*');
		$this->db->where(array('client_email' => strtolower($this->input->post('client_email')), 'client_status' => 1, 'client_password' => md5($this->input->post('client_password'))));
		$query = $this->db->get('client');
		
		//if users exists
		if ($query->num_rows() > 0)
		{
			$result = $query->result();
			//create user's login session
			$newdata = array(
                   'client_login_status'    => TRUE,
                   'client_username'     	=> $result[0]->client_username,
                   'client_email'     		=> $result[0]->client_email,
                   'client_id'  			=> $result[0]->client_id,
                   'client_code'  			=> md5($result[0]->client_id)
               );

			$this->session->set_userdata($newdata);
			
			//update user's last login date time
			$this->update_client_login($result[0]->client_id);
			return TRUE;
		}
		
		//if user doesn't exist
		else
		{
			return FALSE;
		}
	}
	
	/*
	*	Update user's last login date
	*
	*/
	private function update_client_login($client_id)
	{
		$data['last_login'] = date('Y-m-d H:i:s');
		$this->db->where('client_id', $client_id);
		$this->db->update('client', $data); 
	}
	
	public function get_balance()
	{
		//select the user by email from the database
		$this->db->select('SUM(price*quantity) AS total_orders');
		$this->db->where('order_status = 2 AND orders.order_id = order_item.order_id');
		$this->db->from('orders, order_item');
		$query = $this->db->get();
		
		$result = $query->row();
		
		return $result->total_orders;
	}
	
	/*
	*	Retrieve a single user by their email
	*	@param int $email
	*
	*/
	public function get_user_by_email($email)
	{
		//retrieve all users
		$this->db->where('client_email', $email);
		$query = $this->db->get('client');
		
		return $query;
	}
	
	public function reset_client_password()
	{
		$email = $this->input->post('client_email');
		//reset password
		$result = md5(date("Y-m-d H:i:s"));
		$pwd2 = substr($result, 0, 6);
		$pwd = md5($pwd2);
		
		$data = array(
				'client_password' => $pwd
			);
		$this->db->where('client_email', $email);
		
		if($this->db->update('client', $data))
		{
			//email the password to the user
			$user_details = $this->get_user_by_email($email);
			
			$user = $user_details->row();
			$user_name = $user->client_username;
			
			$cc = NULL;
			$name = $user_name;
			
			$subject = 'You requested a password reset';
			$message = '<p>You have password has been successfully reset.</p><p>Next time you log in to Nairobisingles please use <strong>'.$pwd2.'</strong> as your password. You can change your password to something more memorable in your profile section once you log in.</p>';
			
			$button = '<p><a class="mcnButton " title="Sign in" href="'.site_url().'sign-in" target="_blank" style="font-weight: bold;letter-spacing: normal;line-height: 100%;text-align: center;text-decoration: none;color: #FFFFFF;">Sign in</a></p>';
			$shopping = '<p>If you have any queries or concerns do not hesitate to get in touch with us at <a href="mailto:info@nairobisingles.com">info@nairobisingles.com</a> </p>';
			$sender_email = 'info@nairobisingles.com';
			$from = 'Nairobisingles';
			
			$response = $this->email_model->send_mandrill_mail($email, $name, $subject, $message, $sender_email, $shopping, $from, $button, $cc);
			
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
}