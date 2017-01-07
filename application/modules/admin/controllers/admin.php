<?php   if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends MX_Controller 
{
	var $profile_image_path;
	var $profile_image_location;
	var $smiley_location;
	var $messages_path;
		
	function __construct()
	{
		parent:: __construct();
		$this->load->model('login/login_model');
		
		//user has logged in
		if($this->login_model->check_login())
		{
			$this->load->model('file_model');
			$this->load->model('site/profile_model');
			$this->profile_image_path = realpath(APPPATH . '../assets/images/profile');
			$this->profile_image_location = base_url().'assets/images/profile/';
			$this->smiley_location = base_url().'assets/images/smileys/';
			$this->messages_path = realpath(APPPATH . '../assets/messages');
		}
		
		//user has not logged in
		else
		{
			redirect('login-admin');
		}
	}
    
	/*
	*
	*	Default action is to show the dashboard
	*
	*/
	public function index() 
	{
		$data['title'] = 'Dashboard';
		
		$this->load->view('dashboard', $data);
	}
    
	/*
	*
	*	Login an administrator
	*
	*/
	public function admin_login() 
	{
		redirect('login/login_admin');
	}
    
	/*
	*
	*	Send bulk mail campaigns
	*
	*/
	public function send_mail() 
	{
		$this->load->model('site/email_model');
		///form validation rules
		$this->form_validation->set_rules('emails', 'Email', 'xss_clean');
		$this->form_validation->set_rules('subject', 'Message', 'required|xss_clean');
		$this->form_validation->set_rules('message', 'Message', 'required|xss_clean');
		
		$data2['success2'] = '';
		//if form has been submitted
		if ($this->form_validation->run())
		{
			$this->load->library('Mandrill', $this->config->item('mandrill_key'));
			$this->load->model('site/email_model');
			
			$check = $_POST['emails'];
			
			if(!empty($check))
			{
				$emails = explode(",",$_POST['emails']);
				$total = count($emails);
				
				for($r = 0; $r < $total; $r++)
				{
					$address = $emails[$r];
					$client_email = $address;
					$client_username = '';
					$subject = $this->input->post('subject');
					$message = $this->input->post('message');
					$sender_email = 'info@nairobisingles.com';
					$shopping = "";
					$from = 'Nairobisingles';
					
					$button = '<a class="mcnButton " title="Install Nairobisingles now" href="https://play.google.com/store/apps/details?id=com.nairobisingles" target="_blank" style="font-weight: bold;letter-spacing: normal;line-height: 100%;text-align: center;text-decoration: none;color: #FFFFFF;">Install Nairobisingles now</a>';
					$response = $this->email_model->send_mandrill_mail($client_email, "Hi ".$client_username, $subject, $message, $sender_email, $shopping, $from, $button, $cc = NULL);
					
					if($response)
					{
						$data2['success'] = $response;
					}
					
					else
					{
						$data2['error'] = $response;
					}
				}
			}
			
			else
			{
				//get all users
				$where = 'client.client_id > 20';
				$table = 'client';
				$this->db->where($where);
				$query = $this->db->get($table);
				
				if($query->num_rows() > 0)
				{
					foreach($query->result() as $res)
					{
						$client_email = $res->client_email;
						$client_username = $res->client_username;
						$subject = $this->input->post('subject');
						$message = $this->input->post('message');
						$sender_email = 'info@nairobisingles.com';
						$shopping = "";
						$from = 'Nairobisingles';
						
						//var_dump($client_email);die();
						
						$button = '<a class="mcnButton " title="Install Nairobisingles now" href="https://play.google.com/store/apps/details?id=com.nairobisingles" target="_blank" style="font-weight: bold;letter-spacing: normal;line-height: 100%;text-align: center;text-decoration: none;color: #FFFFFF;">Install Nairobisingles now</a>';
						$response = $this->email_model->send_mandrill_mail($client_email, "Hi ".$client_username, $subject, $message, $sender_email, $shopping, $from, $button, $cc = NULL);
						
						if($response)
						{
							$data2['success'] = $response;
						}
						
						else
						{
							$data2['error'] = $response;
						}
					}
				}
			}
		}
		
		else
		{
			$data['error'] = validation_errors();
		}
		
		//open the add new grade
		$data['title'] = 'Send Email';
		$data['content'] = $this->load->view('send_mail', $data2, true);
		$this->load->view('templates/general_admin', $data);
	}
}
?>