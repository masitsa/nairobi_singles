<?php   if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Account extends MX_Controller 
{
	var $profile_image_path;
	var $profile_image_location;
	var $client_id;
	var $image_size;
	var $thumb_size;
	var $messages_path;
	
	function __construct()
	{
		parent:: __construct();
		
		$this->load->model('login/login_model');
		
		//user has logged in
		if($this->login_model->check_client_login())
		{
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
			$this->client_id = $this->session->userdata('client_id');
			$this->image_size = 600;
			$this->thumb_size = 80;
		}
		
		//user has not logged in
		else
		{
			$this->session->set_userdata('error_message', 'Please sign up/in to continue');
				
			redirect('sign-in');
		}
	}
    
	/*
	*
	*	Open the account page
	*
	*/
	public function my_account()
	{
		//Required general page data
		$v_data['all_children'] = $this->categories_model->all_child_categories();
		$v_data['parent_categories'] = $this->categories_model->all_parent_categories();
		$v_data['crumbs'] = $this->site_model->get_crumbs();
		
		//page data
		$v_data['user_details'] = $this->users_model->get_user($this->session->userdata('user_id'));
		$data['content'] = $this->load->view('user/my_account', $v_data, true);
		
		$data['title'] = $this->site_model->display_page_title();
		$this->load->view('templates/general_page', $data);
	}
    
	/*
	*
	*	Open the orders list
	*
	*/
	public function orders_list()
	{
		//Required general page data
		$v_data['all_children'] = $this->categories_model->all_child_categories();
		$v_data['parent_categories'] = $this->categories_model->all_parent_categories();
		$v_data['crumbs'] = $this->site_model->get_crumbs();
		
		//page data
		$v_data['all_orders'] = $this->orders_model->get_user_orders($this->session->userdata('user_id'));
		$data['content'] = $this->load->view('user/orders_list', $v_data, true);
		
		$data['title'] = $this->site_model->display_page_title();
		$this->load->view('templates/general_page', $data);
	}
    
	/*
	*
	*	Open the user's details page
	*
	*/
	public function my_details()
	{
		//Required general page data
		$v_data['all_children'] = $this->categories_model->all_child_categories();
		$v_data['parent_categories'] = $this->categories_model->all_parent_categories();
		$v_data['crumbs'] = $this->site_model->get_crumbs();
		
		//page data
		$v_data['user_details'] = $this->users_model->get_user($this->session->userdata('user_id'));
		$data['content'] = $this->load->view('user/my_details', $v_data, true);
		
		$data['title'] = $this->site_model->display_page_title();
		$this->load->view('templates/general_page', $data);
	}
    
	/*
	*
	*	Open the user's wishlist
	*
	*/
	public function wishlist()
	{
		//Required general page data
		$v_data['all_children'] = $this->categories_model->all_child_categories();
		$v_data['parent_categories'] = $this->categories_model->all_parent_categories();
		$v_data['crumbs'] = $this->site_model->get_crumbs();
		
		//page data
		$v_data['all_orders'] = $this->orders_model->get_users_wishlist($this->session->userdata('user_id'));
		$data['content'] = $this->load->view('user/wishlist', $v_data, true);
		
		$data['title'] = $this->site_model->display_page_title();
		$this->load->view('templates/general_page', $data);
	}
    
	/*
	*
	*	Update a user's account
	*
	*/
	public function update_account()
	{
		//form validation rules
		$this->form_validation->set_rules('last_name', 'Last Names', 'required|xss_clean');
		$this->form_validation->set_rules('first_name', 'First Name', 'required|xss_clean');
		$this->form_validation->set_rules('phone', 'Phone', 'required|xss_clean');
		
		//if form has been submitted
		if ($this->form_validation->run() == FALSE)
		{
			$this->session->set_userdata('front_error_message', validation_errors());
		}
		
		else
		{
			//check if user has valid login credentials
			if($this->users_model->edit_frontend_user($this->session->userdata('user_id')))
			{
				$this->session->set_userdata('front_success_message', 'Your details have been successfully updated');
			}
			
			else
			{
				$this->session->set_userdata('front_error_message', 'Oops something went wrong and we were unable to update your details. Please try again');
			}
		}
		
		$this->my_details();
	}
    
	/*
	*
	*	Update a user's password
	*
	*/
	public function update_password()
	{
		//form validation rules
		$this->form_validation->set_rules('current_password', 'Current Password', 'required|xss_clean');
		$this->form_validation->set_rules('new_password', 'New Password', 'required|xss_clean');
		$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|xss_clean');
		
		//if form has been submitted
		if ($this->form_validation->run() == FALSE)
		{
			$this->session->set_userdata('front_error_message', validation_errors());
		}
		
		else
		{
			//update password
			$update = $this->users_model->edit_password($this->session->userdata('user_id'));
			if($update['result'])
			{
				$this->session->set_userdata('front_success_message', 'Your password has been successfully updated');
			}
			
			else
			{
				$this->session->set_userdata('front_error_message', $update['message']);
			}
		}
		
		$this->my_details();
	}
    
	/*
	*
	*	Filter profiles by age
	*
	*/
	public function filter_age()
	{//var_dump($_POST['age_group_id']);die();
		if(isset($_POST['age_group_id']))
		{
			$total_ages = sizeof($_POST['age_group_id']);
			$neighbourhoods = $this->input->post('post_neighbourhoods');
			$genders = $this->input->post('post_genders');
			$encounters = $this->input->post('post_encounters');
			
			//check if any checkboxes have been ticked
			if($total_ages > 0)
			{
				$ages = '';
				$age = $_POST['age_group_id'];
				
				for($r = 0; $r < $total_ages; $r++)
				{
					$age_id = $age[$r]; 
					
					if($r == 0)
					{
						$ages .= $age_id;
					}
					
					else
					{
						$ages .= '&'.$age_id;
					}
				}
				$this->profiles('__', $neighbourhoods, $genders, $ages, $encounters);
			}
			
			else
			{
				redirect('browse');
			}
		}
		
		else
		{
			redirect('browse');
		}
	}
    
	/*
	*
	*	Filter profiles by age
	*
	*/
	public function filter_gender()
	{
		if(isset($_POST['gender_id']))
		{
			$total_genders = sizeof($_POST['gender_id']);
			$neighbourhoods = $this->input->post('post_neighbourhoods');
			$ages = $this->input->post('post_ages');
			$encounters = $this->input->post('post_encounters');
			
			//check if any checkboxes have been ticked
			if($total_genders > 0)
			{
				$genders = '';
				$gender = $_POST['gender_id'];
				
				for($r = 0; $r < $total_genders; $r++)
				{
					$gender_id = $gender[$r]; 
					
					if($r == 0)
					{
						$genders .= $gender_id;
					}
					
					else
					{
						$genders .= '&'.$gender_id;
					}
				}
				$this->profiles('__', $neighbourhoods, $genders, $ages, $encounters);
			}
			
			else
			{
				redirect('browse');
			}
		}
		
		else
		{
			redirect('browse');
		}
	}
    
	/*
	*
	*	Filter profiles by neighbourhood
	*
	*/
	public function filter_neighbourhood()
	{
		if(isset($_POST['neighbourhood_id']))
		{
			$total_neighbourhoods = sizeof($_POST['neighbourhood_id']);
			$genders = $this->input->post('post_genders');
			$ages = $this->input->post('post_ages');
			$encounters = $this->input->post('post_encounters');
			
			//check if any checkboxes have been ticked
			if($total_neighbourhoods > 0)
			{
				$neighbourhoods = '';
				$neighbourhood = $_POST['neighbourhood_id'];
				
				for($r = 0; $r < $total_neighbourhoods; $r++)
				{
					$neighbourhood_id = $neighbourhood[$r]; 
					
					if($r == 0)
					{
						$neighbourhoods .= $neighbourhood_id;
					}
					
					else
					{
						$neighbourhoods .= '&'.$neighbourhood_id;
					}
				}
				$this->profiles('__', $neighbourhoods, $genders, $ages, $encounters);
			}
			
			else
			{
				redirect('browse');
			}
		}
		
		else
		{
			redirect('browse');
		}
	}
    
	/*
	*
	*	Filter profiles by encounter
	*
	*/
	public function filter_encounter()
	{
		if(isset($_POST['encounter_id']))
		{
			$total_encounters = sizeof($_POST['encounter_id']);
			$genders = $this->input->post('post_genders');
			$ages = $this->input->post('post_ages');
			$neighbourhoods = $this->input->post('post_neighbourhoods');
			
			//check if any checkboxes have been ticked
			if($total_encounters > 0)
			{
				$encounters = '';
				$encounter = $_POST['encounter_id'];
				
				for($r = 0; $r < $total_encounters; $r++)
				{
					$encounter_id = $encounter[$r]; 
					
					if($r == 0)
					{
						$encounters .= $encounter_id;
					}
					
					else
					{
						$encounters .= '&'.$encounter_id;
					}
				}
				$this->profiles('__', $neighbourhoods, $genders, $ages, $encounters);
			}
			
			else
			{
				redirect('browse');
			}
		}
		
		else
		{
			redirect('browse');
		}
	}
    
	/*
	*
	*	profiles Page
	*
	*/
	public function profiles($search = '__', $neighbourhood_id = '__', $gender_id = '__', $age_group_id = '__', $encounter_id = '__', $order_by = 'created', $ajax = NULL) 
	{
		$v_data['neighbourhoods_query'] = $this->profile_model->get_neighbourhoods();
		$v_data['genders_query'] = $this->profile_model->get_gender();
		$v_data['age_groups_query'] = $this->profile_model->get_age_group();
		$v_data['encounters_query'] = $this->profile_model->get_encounter();
		
		$v_data['post_neighbourhoods'] = $neighbourhood_id;
		$v_data['post_genders'] = $gender_id;
		$v_data['post_ages'] = $age_group_id;
		$v_data['post_encounters'] = $encounter_id;
		
		$v_data['ages_array'] = '';
		$v_data['encounters_array'] = '';
		$v_data['neighbourhoods_array'] = '';
		
		//get user's prefered matches
		$client_query = $this->profile_model->get_client($this->client_id);
		$row = $client_query->row();
		$client_looking_gender_id = $row->client_looking_gender_id;
		$client_age_group_id = $row->age_group_id;
		$client_encounter_id = $row->encounter_id;
		$client_neighbourhood_id = $row->neighbourhood_id;
		
		//case of matches
		//$where = 'client.gender_id = '.$client_looking_gender_id.' AND client.encounter_id = '.$client_encounter_id.' AND client.neighbourhood_id = '.$client_neighbourhood_id.' AND client.client_status = 1 AND client.client_id != '.$this->client_id;
		
		//browse all profiles
		$where = 'client.neighbourhood_id = neighbourhood.neighbourhood_id AND client.gender_id = gender.gender_id AND client.encounter_id = encounter.encounter_id AND client.gender_id = '.$client_looking_gender_id.' AND client.client_status = 1 AND client.client_id != '.$this->client_id;
		$table = 'client, gender, encounter, neighbourhood';
		$limit = NULL;
		
		//ordering products
		switch ($order_by)
		{
			case 'created':
				$order_method = 'DESC';
			break;
			
			case 'client_username':
				$order_method = 'ASC';
			break;
			
			default:
				$order_method = 'DESC';
			break;
		}
		
		//case of filter_age_groups
		if($age_group_id != '__')
		{
			$return = $this->profile_model->create_age_filter($age_group_id, 'client.client_dob');
			$where .= $return['where'];
			$v_data['ages_array'] = $return['parameters'];
		}
		
		//case of filter_encounters
		if($encounter_id != '__')
		{
			$return = $this->profile_model->create_query_filter($encounter_id, 'client.encounter_id');
			$where .= $return['where'];
			$v_data['encounters_array'] = $return['parameters'];
		}
		
		//case of filter_gender
		if($gender_id != '__')
		{
			//$where .= $this->profile_model->create_query_filter($gender_id, 'client.gender_id');
		}
		
		//case of filter_neighbourhood
		if($neighbourhood_id != '__')
		{
			$return = $this->profile_model->create_query_filter($neighbourhood_id, 'client.neighbourhood_id');
			$where .= $return['where'];
			$v_data['neighbourhoods_array'] = $return['parameters'];
		}
		
		//case of search
		if($search != '__')
		{
			$where .= " client.encounter_id = encounter.encounter_id AND (client.client_username LIKE '%".$search."%' OR encounter.encounter_name LIKE '%".$search."%')";
			$table .= ', encounter';
		}
		
		//case of category
		if($encounter_id > 0)
		{
			$where .= ' AND client.encounter_id = encounter.encounter_id = '.$encounter_id.' ';
		}
		
		//case of brand
		if($neighbourhood_id > 0)
		{
			$where .= ' AND client.neighbourhood_id = '.$neighbourhood_id;
		}
		
		//case of brand
		if($gender_id > 0)
		{
			$where .= ' AND client.gender_id = '.$gender_id;
		}
		
		//pagination
		$segment = 5;
		$this->load->library('pagination');
		$config['base_url'] = $this->uri->uri_string();
		$config['total_rows'] = $this->users_model->count_items($table, $where, $limit);
		$config['uri_segment'] = $segment;
		$config['per_page'] = 21;
		$config['num_links'] = 5;
		
		$config['full_tag_open'] = '<ul class="pagination no-margin-top">';
		$config['full_tag_close'] = '</ul>';
		
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		
		$config['next_tag_open'] = '<li>';
		$config['next_link'] = '»';
		$config['next_tag_close'] = '</span>';
		
		$config['prev_tag_open'] = '<li>';
		$config['prev_link'] = '«';
		$config['prev_tag_close'] = '</li>';
		
		$config['cur_tag_open'] = '<li class="active"><a href="#">';
		$config['cur_tag_close'] = '</a></li>';
		
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$this->pagination->initialize($config);
		
		$page = ($this->uri->segment($segment)) ? $this->uri->segment($segment) : 0;
		
		if($limit == NULL)
		{
        	$v_data["links"] = $this->pagination->create_links();
			$v_data["first"] = $page + 1;
			$v_data["total"] = $config['total_rows'];
			
			if($v_data["total"] < $config["per_page"])
			{
				$v_data["last"] = $page + $v_data["total"];
			}
			
			else
			{
				$v_data["last"] = $page + $config["per_page"];
			}
		}
		
		else
		{
			$v_data["first"] = $page + 1;
			$v_data["total"] = $config['total_rows'];
			$v_data["last"] = $config['total_rows'];
		}
		$v_data['profiles'] = $this->profile_model->get_all_clients($table, $where, $config["per_page"], $page, $limit, $order_by, $order_method);
		$v_data['profile_image_location'] = $this->profile_image_location;
		$v_data['current_client_id'] = $this->client_id;
		$v_data['neighbourhoods_query'] = $this->profile_model->get_neighbourhoods();
		$v_data['genders_query'] = $this->profile_model->get_gender();
		$v_data['age_groups_query'] = $this->profile_model->get_age_group();
		$v_data['encounters_query'] = $this->profile_model->get_encounter();
		$v_data['crumbs'] = $this->site_model->get_crumbs();
		
		if($ajax == NULL)
		{
			$data['content'] = $this->load->view('account/profiles', $v_data, true);
			$data['title'] = $this->site_model->display_page_title();
			$this->load->view('templates/general_page', $data);
		}
		
		else
		{
			$data['content'] = $this->load->view('account/display_profiles', $v_data, true);
			$data['showing'] = $this->load->view('account/showing', $v_data, true);
			
			echo json_encode($data);
		}
	}
    
	/*
	*
	*	Search for a product
	*
	*/
	public function search()
	{
		$search = $this->input->post('search_item');
		
		if(!empty($search))
		{
			redirect('products/search/'.$search);
		}
		
		else
		{
			redirect('products/all-products');
		}
	}
    
	/*
	*
	*	Single profile page
	*
	*/
	public function view_profile($web_name)
	{
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
		$v_data['profile_page'] = 1;
		$v_data['current_client_id'] = $this->client_id;
		
		$client_username = str_replace("-", " ", $web_name);
		
		//Required general page data
		$v_data['profile_query'] = $this->profile_model->get_client_username($client_username);
		$v_data['profile_image_location'] = $this->profile_image_location;
		
		//message history details
		$receiver_id = $this->messages_model->get_receiver_id($web_name);
		$v_data['receiver'] = $this->profile_model->get_client($receiver_id);
		$v_data['sender'] = $this->profile_model->get_client($this->client_id);
		$v_data['messages'] = $this->profile_model->get_messages($this->client_id, $receiver_id, $this->messages_path);
		$v_data['received_messages'] = $this->profile_model->count_received_messages($v_data['messages']);
		$v_data['crumbs'] = $this->site_model->get_crumbs();
		
		$data['content'] = $this->load->view('account/view_profile', $v_data, true);
		$data['title'] = $this->site_model->display_page_title();
		$this->load->view('templates/general_page', $data);
	}
}