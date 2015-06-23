<?php   if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Test extends MX_Controller 
{
	var $profile_image_path;
	var $profile_image_location;
	var $client_id;
	var $image_size;
	var $thumb_size;
	var $messages_path;
	var $smiley_location;
	var $account_balance;
	var $message_amount;
	var $like_amount;
	
	function __construct()
	{
		parent:: __construct();
		// Allow from any origin
		if (isset($_SERVER['HTTP_ORIGIN'])) {
			header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
			header('Access-Control-Allow-Credentials: true');
			header('Access-Control-Max-Age: 86400');    // cache for 1 day
		}
	
		// Access-Control headers are received during OPTIONS requests
		if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
	
			if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
				header("Access-Control-Allow-Methods: GET, POST, OPTIONS");         
	
			if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
				header("Access-Control-Allow-Headers:        {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
	
			exit(0);
		}
    	
		$this->load->model('login/login_model');
		
		$this->load->model('admin/file_model');
		$this->load->model('admin/users_model');
		$this->load->model('profile_model');
		$this->load->model('site_model');
		$this->load->model('payments_model');
		$this->load->model('messages_model');
		
		$this->load->library('image_lib');
		
		//path to image directory
		$this->messages_path = realpath(APPPATH . '../assets/messages');
		$this->profile_image_path = realpath(APPPATH . '../assets/images/profile');
		$this->profile_image_location = base_url().'assets/images/profile/';
		$this->smiley_location = base_url().'assets/images/smileys/';
		$this->client_id = 1;
		$this->image_size = 600;
		$this->thumb_size = 80;
		$this->message_amount = $this->config->item('message_cost');
		$this->like_amount = $this->config->item('like_cost');
	}
	
	public function count_unread_messages2()
	{
		$data['total_received'] = $this->messages_model->count_unread_messages($this->client_id, $this->messages_path);
		$data['messages'] = $this->view_last_messages();
		
		echo json_encode($data);
	}
	
	public function view_last_messages()
	{
		//get all unread messages from the db
		$unread_query = $this->messages_model->get_unread_messages($this->client_id);
		$return = array();
		
		//get all unread messages data
		if($unread_query->num_rows() > 0)
		{
			foreach($unread_query->result() as $res)
			{
				$last_receiver_web_name = $res->last_receiver_web_name;
				//for smileys
				$image_array = get_clickable_smileys($this->smiley_location, 'instant_message2');
				$col_array = $this->table->make_columns($image_array, 12);
				
				$v_data['smiley_table'] = $this->profile_model->generate_emoticons($col_array);
				$v_data['smiley_location'] = $this->smiley_location;
				
				$v_data['sender'] = $this->profile_model->get_client($this->client_id);
				$v_data['messages'] = $this->profile_model->get_messages($this->client_id, $receiver_id, $this->messages_path);
				//$v_data['received_messages'] = $this->profile_model->count_received_messages($v_data['messages']);
				$v_data['profile_image_location'] = $this->profile_image_location;
				$v_data['profile_image_path'] = $this->profile_image_path;
				$v_data['account_balance'] = $this->account_balance;
		
				$data['result']= $this->load->view('messages/view_last_message', $v_data, true);
				$data['web_name']= $last_receiver_web_name;
				$return = array_push($data);
			}
		}
		return $return;
	}
}