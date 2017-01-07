<?php   if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once "./application/modules/admin/controllers/admin.php";

class Email_campaigns extends admin 
{	
	function __construct()
	{
		parent:: __construct();
		$this->load->model('users_model');
		$this->load->model('email_campaigns_model');
		
		$this->load->library('image_lib');
	}
    
	/*
	*
	*	Default action is to show all the email_campaigns
	*
	*/
	public function index($order = 'created', $order_method = 'DESC') 
	{
		$where = 'email_campaign.email_campaign_id > 0';
		$table = 'email_campaign';
		//pagination
		$segment = 6;
		$this->load->library('pagination');
		$config['base_url'] = base_url().'admin/email_campaigns/index/'.$order.'/'.$order_method;
		$config['total_rows'] = $this->users_model->count_items($table, $where);
		$config['uri_segment'] = $segment;
		$config['per_page'] = 20;
		$config['num_links'] = 5;
		
		$config['full_tag_open'] = '<ul class="pagination pull-right">';
		$config['full_tag_close'] = '</ul>';
		
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		
		$config['next_tag_open'] = '<li>';
		$config['next_link'] = 'Next';
		$config['next_tag_close'] = '</span>';
		
		$config['prev_tag_open'] = '<li>';
		$config['prev_link'] = 'Prev';
		$config['prev_tag_close'] = '</li>';
		
		$config['cur_tag_open'] = '<li class="active"><a href="#">';
		$config['cur_tag_close'] = '</a></li>';
		
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$this->pagination->initialize($config);
		
		$page = ($this->uri->segment($segment)) ? $this->uri->segment($segment) : 0;
        $data["links"] = $this->pagination->create_links();
		$query = $this->email_campaigns_model->get_all_email_campaigns($table, $where, $config["per_page"], $page, $order, $order_method);
		
		//change of order method 
		if($order_method == 'DESC')
		{
			$order_method = 'ASC';
		}
		
		else
		{
			$order_method = 'DESC';
		}
		
		if ($query->num_rows() > 0)
		{
			$v_data['order'] = $order;
			$v_data['order_method'] = $order_method;
			$v_data['query'] = $query;
			$v_data['page'] = $page;
			$data['content'] = $this->load->view('email_campaigns/all_email_campaigns', $v_data, true);
		}
		
		else
		{
			$data['content'] = '<a href="'.site_url().'admin/email_campaigns/send_mail" class="btn btn-success pull-right">Add email campaign</a>There are no email campaigns';
		}
		$data['title'] = 'All email campaigns';
		
		$this->load->view('templates/general_admin', $data);
	}
    
	/*
	*
	*	Send bulk mail email_campaigns
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
			//save email_campaign
			$save_data = array(
				'subject' => $this->input->post('subject'),
				'message' => $this->input->post('message'),
				'created' => date('Y-m-d H:i:s'),
				'last_sent' => date('Y-m-d H:i:s')
			);
			$this->db->insert('email_campaign', $save_data);
			
			$email_campaign_id = $this->db->insert_id();
			
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
				$where = "client.client_id > 20 AND client.client_email != ''";
				$table = 'client';
				$this->db->where($where);
				$query = $this->db->get($table);
				
				$this->db->select('*');
				$this->db->from('blogs');
				$this->db->join('comments', 'comments.id = blogs.id');
				
				$query = $this->db->get();
				
				if($query->num_rows() > 0)
				{
					foreach($query->result() as $res)
					{
						$client_id = $res->client_id;
						$client_email = $res->client_email;
						$client_username = $res->client_username;
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
							
							//save email_campaign recepient
							$save_data_recepient = array(
								'client_id' => $client_id,
								'email_campaign_id' => $email_campaign_id,
								'date_sent' => date('Y-m-d H:i:s')
							);
							$this->db->insert('email_recepient', $save_data_recepient);
						}
						
						else
						{
							$data2['error'] = $response;
						}
					}
					redirect('email-campaign');
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
    
	/*
	*
	*	Send bulk mail email_campaigns
	*
	*/
	public function continue_send($email_campaign_id) 
	{
		$this->load->model('site/email_model');
		
		$data2['success2'] = '';
		
		$this->load->library('Mandrill', $this->config->item('mandrill_key'));
		$this->load->model('site/email_model');
		
		//get campaign
		$this->db->where('email_campaign_id', $email_campaign_id);
		$query_campaign = $this->db->get('email_campaign');
		$row = $query_campaign->row();
		$subject = $row->subject;
		$message = $row->message;
			
		//get all users
		$where = "client.client_id > 20 AND client.client_email != '' AND client.client_id NOT IN (SELECT client_id FROM email_recepient WHERE email_campaign_id = ".$email_campaign_id.")";
		$this->db->from('client');
		$this->db->where($where);
		
		$query = $this->db->get();
		
		if($query->num_rows() > 0)
		{
			foreach($query->result() as $res)
			{
				$client_id = $res->client_id;
				$client_email = $res->client_email;
				$client_username = $res->client_username;
				$sender_email = 'info@nairobisingles.com';
				$shopping = "";
				$from = 'Nairobisingles';
				
				$button = '<a class="mcnButton " title="Install Nairobisingles now" href="https://play.google.com/store/apps/details?id=com.nairobisingles" target="_blank" style="font-weight: bold;letter-spacing: normal;line-height: 100%;text-align: center;text-decoration: none;color: #FFFFFF;">Install Nairobisingles now</a>';
				
				$response = $this->email_model->send_mandrill_mail($client_email, "Hi ".$client_username, $subject, $message, $sender_email, $shopping, $from, $button, $cc = NULL);
				
				if($response)
				{
					$data2['success'] = $response;
					
					//save email_campaign recepient
					$save_data_recepient = array(
						'client_id' => $client_id,
						'email_campaign_id' => $email_campaign_id,
						'date_sent' => date('Y-m-d H:i:s')
					);
					$this->db->insert('email_recepient', $save_data_recepient);
				}
				
				else
				{
					$data2['error'] = $response;
				}
			}
		}
		
		redirect('email-campaign');
	}
	
	public function sort_sent()
	{
		$query = $this->db->get('emails');
		
		foreach($query->result() as $res)
		{
			$email = $res->email;
			
			$this->db->where('client_email', $email);
			$query2 = $this->db->get('client');
			
			if($query2->num_rows() > 0)
			{
				$row = $query2->row();
				
				$client_id = $row->client_id;
				
				$save_array = array
				(
					'client_id' => $client_id,
					'email_campaign_id' => 1,
					'date_sent' => date('Y-m-d H:i:s')
				);
				
				$this->db->insert('email_recepient', $save_array);
			}
		}
	}
}
?>