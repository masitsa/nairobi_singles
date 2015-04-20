<?php   if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once "./application/modules/admin/controllers/admin.php";

class Messages extends admin {
	
	function __construct()
	{
		parent:: __construct();
		$this->load->model('users_model');
		$this->load->model('client_messages_model');
		$this->load->model('clients_model');
	}
    
	/*
	*
	*	Default action is to show all the client_messages
	*
	*/
	public function index($order = 'created', $order_method = 'DESC') 
	{
		$where = 'client_message_id > 0';
		$table = 'client_message';
		//pagination
		$segment = 4;
		$this->load->library('pagination');
		$config['base_url'] = base_url().'all-messages/'.$order.'/'.$order_method;
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
		$query = $this->client_messages_model->get_all_client_messages($table, $where, $config["per_page"], $page, $order, $order_method);
		
		$v_data['profile_image_path'] = $this->profile_image_path;
		$v_data['profile_image_location'] = $this->profile_image_location;
		
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
			$data['content'] = $this->load->view('messages/all_messages', $v_data, true);
		}
		
		else
		{
			$data['content'] = '<a href="#" class="btn btn-success pull-right">Add client_message</a>There are no messages';
		}
		$data['title'] = 'All messages';
		
		$this->load->view('templates/general_admin', $data);
	}
    
	/*
	*
	*	Add a new client_message
	*
	*/
	public function add_client_message() 
	{
		//form validation rules
		$this->form_validation->set_rules('client_id', 'Category Name', 'required|is_natural|xss_clean');
		$this->form_validation->set_rules('client_message_name', 'Message Name', 'required|xss_clean');
		$this->form_validation->set_rules('client_message_status', 'Message Status', 'required|xss_clean');
		
		//if form has been submitted
		if ($this->form_validation->run())
		{	
			if($this->client_messages_model->add_client_message())
			{
				$this->session->set_userdata('success_client_message', 'client_message added successfully');
				redirect('all-client_messages');
			}
			
			else
			{
				$this->session->set_userdata('error_client_message', 'Could not add client_message. Please try again');
			}
		}
		
		//open the add new client_message
		$data['title'] = 'Add New client_message';
		$v_data['all_clients'] = $this->clients_model->all_clients();
		$v_data['all_client_messages'] = $this->client_messages_model->all_client_messages();
		$data['content'] = $this->load->view('client_messages/add_client_message', $v_data, true);
		$this->load->view('templates/general_admin', $data);
	}
    
	/*
	*
	*	Edit an existing client_message
	*	@param int $client_message_id
	*
	*/
	public function edit_client_message($client_message_id) 
	{
		//form validation rules
		$this->form_validation->set_rules('client_id', 'Category Name', 'required|is_natural|xss_clean');
		$this->form_validation->set_rules('client_message_name', 'client_message Name', 'required|xss_clean');
		$this->form_validation->set_rules('client_message_status', 'client_message Status', 'required|xss_clean');
		
		//if form has been submitted
		if ($this->form_validation->run())
		{
			//update client_message
			if($this->client_messages_model->update_client_message($client_message_id))
			{
				$this->session->set_userdata('success_client_message', 'client_message updated successfully');
				redirect('all-client_messages');
			}
			
			else
			{
				$this->session->set_userdata('error_client_message', 'Could not update client_message. Please try again');
			}
		}
		
		//open the add new client_message
		$data['title'] = 'Edit message';
		
		//select the client_message from the database
		$query = $this->client_messages_model->get_client_message($client_message_id);
		
		if ($query->num_rows() > 0)
		{
			$v_data['client_message'] = $query->result();
			$v_data['all_client_messages'] = $this->client_messages_model->all_client_messages();
			$v_data['all_clients'] = $this->clients_model->all_clients();
			
			$data['content'] = $this->load->view('client_messages/edit_client_message', $v_data, true);
		}
		
		else
		{
			$data['content'] = 'client_message does not exist';
		}
		
		$this->load->view('templates/general_admin', $data);
	}
    
	/*
	*
	*	Delete an existing client_message
	*	@param int $client_message_id
	*
	*/
	public function delete_client_message($client_message_id)
	{
		$this->client_messages_model->delete_client_message($client_message_id);
		$this->session->set_userdata('success_client_message', 'client_message has been deleted');
		redirect('all-client_messages');
	}
    
	/*
	*
	*	Activate an existing client_message
	*	@param int $client_message_id
	*
	*/
	public function activate_client_message($client_message_id)
	{
		$this->client_messages_model->activate_client_message($client_message_id);
		$this->session->set_userdata('success_client_message', 'client_message activated successfully');
		redirect('all-client_messages');
	}
    
	/*
	*
	*	Deactivate an existing client_message
	*	@param int $client_message_id
	*
	*/
	public function deactivate_client_message($client_message_id)
	{
		$this->client_messages_model->deactivate_client_message($client_message_id);
		$this->session->set_userdata('success_client_message', 'client_message disabled successfully');
		redirect('all-client_messages');
	}
	
	public function view_chat($client_message_id, $receiver_id, $sender_id)
	{
		//for smileys
		$image_array = get_clickable_smileys($this->smiley_location, 'instant_message2');
		$col_array = $this->table->make_columns($image_array, 12);
		
		$v_data['smiley_table'] = $this->profile_model->generate_emoticons($col_array);
		$v_data['smiley_location'] = $this->smiley_location;
		
		$v_data['neighbourhoods_query'] = $this->profile_model->get_neighbourhoods();
		$v_data['genders_query'] = $this->profile_model->get_gender();
		$v_data['age_groups_query'] = $this->profile_model->get_age_group();
		$v_data['encounters_query'] = $this->profile_model->get_encounter();
		
		$v_data['post_neighbourhoods'] = '';
		$v_data['post_genders'] = '';
		$v_data['post_ages'] = '';
		$v_data['post_encounters'] = '';
		
		$v_data['ages_array'] = '';
		$v_data['encounters_array'] = '';
		$v_data['neighbourhoods_array'] = '';
		
		$v_data['receiver'] = $this->profile_model->get_client($receiver_id);
		$v_data['sender'] = $this->profile_model->get_client($sender_id);
		$v_data['messages'] = $this->profile_model->get_messages($sender_id, $receiver_id, $this->messages_path);
		$v_data['received_messages'] = $this->profile_model->count_received_messages($v_data['messages']);
		$v_data['profile_image_location'] = $this->profile_image_location;
		$v_data['receiver_id'] = $receiver_id;
		
		//create title
		//get receiver details
		$receiver = $v_data['receiver'];
		if($receiver->num_rows() > 0)
		{
			$row = $receiver->row();
			$receiver_username = $row->client_username;
		}
		//get sender details
		$sender = $v_data['sender'];
		if($sender->num_rows() > 0)
		{
			$row = $sender->row();
			$sender_username = $row->client_username;
		}
		$data['title'] = 'View chat between '.$sender_username.' and '.$receiver_username;
		
		$data['content'] = $this->load->view('messages/view_message', $v_data, true);
		
		$this->load->view('templates/general_admin', $data);
	}
	
	public function send_message($receiver_id, $page = NULL)
	{
		$v_data['smiley_location'] = $this->smiley_location;
		$v_data['receiver'] = $this->profile_model->get_client($receiver_id);
		$v_data['sender'] = $this->profile_model->get_client($this->client_id);
		$v_data['messages'] = $this->profile_model->get_messages($this->client_id, $receiver_id, $this->messages_path);
		$v_data['received_messages'] = $this->profile_model->count_received_messages($v_data['messages']);
		$v_data['profile_image_location'] = $this->profile_image_location;
		
		//make payment if message was sent
		if($page > 0)
		{
		}
		
		if($page == 1)
		{
			$data['messages'] = $this->load->view('messages/message_details', $v_data, true);
			$data['curr_message_count'] = $v_data['received_messages'];
			$data['account_balance'] = $this->payments_model->get_account_balance($this->session->userdata('client_id'));
			
			echo json_encode($data);
		}
		
		else if($page == 2)
		{
			$data['messages'] = $this->load->view('account/modal_messages', $v_data, true);
			$data['curr_message_count'] = $v_data['received_messages'];
			$data['account_balance'] = $this->payments_model->get_account_balance($this->session->userdata('client_id'));
			
			echo json_encode($data);
		}
		
		else
		{
			//for smileys
			$image_array = get_clickable_smileys($this->smiley_location, 'instant_message');
			$col_array = $this->table->make_columns($image_array, 12);
			
			$v_data['smiley_table'] = $this->profile_model->generate_emoticons($col_array);
			$v_data['account_balance'] = $this->account_balance;
			
			echo $this->load->view('account/message', $v_data, true);
		}
	}
}
?>