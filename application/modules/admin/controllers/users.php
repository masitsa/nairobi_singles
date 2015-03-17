<?php   if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once "./application/modules/admin/controllers/admin.php";

class Users extends admin {
	
	function __construct()
	{
		parent:: __construct();
		$this->load->model('users_model');
	}
    
	/*
	*
	*	Default action is to show all the users
	*
	*/
	public function index() 
	{
		$where = 'users.user_level_id = user_level.u_level_id AND users.activated = user_status.user_status_id AND country.country_id = users.country_id';
		$table = 'users, user_level, user_status, country';
		//pagination
		$this->load->library('pagination');
		$config['base_url'] = base_url().'all-users';
		$config['total_rows'] = $this->users_model->count_items($table, $where);
		$config['uri_segment'] = 2;
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
		
		$config['cur_tag_open'] = '<li class="active">';
		$config['cur_tag_close'] = '</li>';
		
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$this->pagination->initialize($config);
		
		$page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
        $data["links"] = $this->pagination->create_links();
		$query = $this->users_model->get_all_users($table, $where, $config["per_page"], $page);
		
		if ($query->num_rows() > 0)
		{
			$v_data['users'] = $query;
			$v_data['page'] = $page;
			$data['content'] = $this->load->view('users/all_users', $v_data, true);
		}
		
		else
		{
			$data['content'] = 'user does not exist';
		}
		$data['title'] = 'All Users';
		
		$this->load->view('templates/general_admin', $data);
	}
    
	/*
	*
	*	Add a new user page
	*
	*/
	public function add_user() 
	{
		//form validation rules
		$this->form_validation->set_rules('email', 'Email', 'required|xss_clean|is_unique[users.email]');
		$this->form_validation->set_rules('password', 'Password', 'required|xss_clean');
		$this->form_validation->set_rules('other_names', 'Other Names', 'required|xss_clean');
		$this->form_validation->set_rules('first_name', 'First Name', 'required|xss_clean');
		$this->form_validation->set_rules('phone', 'Phone', 'required|xss_clean');
		$this->form_validation->set_rules('address', 'Address', 'required|xss_clean');
		$this->form_validation->set_rules('post_code', 'Post Code', 'required|xss_clean');
		$this->form_validation->set_rules('country_id', 'Country', 'required|xss_clean');
		$this->form_validation->set_rules('city', 'City', 'required|xss_clean');
		$this->form_validation->set_rules('user_level_id', 'User Level', 'required|xss_clean');
		$this->form_validation->set_rules('activated', 'Activate User', 'xss_clean');
		
		//if form has been submitted
		if ($this->form_validation->run())
		{
			//check if user has valid login credentials
			if($this->users_model->add_user())
			{
				redirect('all-users');
			}
			
			else
			{
				$data['error'] = 'Unable to add user. Please try again';
			}
		}
		
		//open the add new user page
		$data['title'] = 'Add New User';
		$data['content'] = modules::run('admin/users/load_add_page');
		$this->load->view('templates/general_admin', $data);
	}
	
	public function load_add_page()
	{
		$v_data['countries'] = $this->users_model->get_all_countries();
		$this->load->view('users/add_user', $v_data);
	}
    
	/*
	*
	*	Edit an existing user page
	*	@param int $user_id
	*
	*/
	public function edit_user($user_id) 
	{
		//form validation rules
		$this->form_validation->set_rules('email', 'Email', 'required|xss_clean');
		$this->form_validation->set_rules('other_names', 'Other Names', 'required|xss_clean');
		$this->form_validation->set_rules('first_name', 'First Name', 'required|xss_clean');
		$this->form_validation->set_rules('phone', 'Phone', 'required|xss_clean');
		$this->form_validation->set_rules('address', 'Address', 'required|xss_clean');
		$this->form_validation->set_rules('post_code', 'Post Code', 'required|xss_clean');
		$this->form_validation->set_rules('country_id', 'Country', 'required|xss_clean');
		$this->form_validation->set_rules('city', 'City', 'required|xss_clean');
		$this->form_validation->set_rules('user_level_id', 'User Level', 'required|xss_clean');
		$this->form_validation->set_rules('activated', 'Activate User', 'xss_clean');
		
		//if form has been submitted
		if ($this->form_validation->run())
		{
			//check if user has valid login credentials
			if($this->users_model->edit_user($user_id))
			{
				$pwd_update = $this->input->post('admin_user');
				if(!empty($pwd_update))
				{
					redirect('admin-profile/'.$user_id);
				}
				
				else
				{
					redirect('all-users');
				}
			}
			
			else
			{
				$data['error'] = 'Unable to add user. Please try again';
			}
		}
		
		//open the add new user page
		$data['title'] = 'Edit User';
		$v_data['countries'] = $this->users_model->get_all_countries();
		
		//select the user from the database
		$query = $this->users_model->get_user($user_id);
		if ($query->num_rows() > 0)
		{
			$v_data['users'] = $query->result();
			$data['content'] = $this->load->view('users/edit_user', $v_data, true);
		}
		
		else
		{
			$data['content'] = 'user does not exist';
		}
		
		$this->load->view('templates/general_admin', $data);
	}
    
	/*
	*
	*	Delete an existing user page
	*	@param int $user_id
	*
	*/
	public function delete_user($user_id) 
	{
		$this->users_model->delete_user($user_id);
		
		redirect('all-users');
	}
    
	/*
	*
	*	Activate an existing user page
	*	@param int $user_id
	*
	*/
	public function activate_user($user_id) 
	{
		$this->users_model->activate_user($user_id);
		
		redirect('all-users');
	}
    
	/*
	*
	*	Deactivate an existing user page
	*	@param int $user_id
	*
	*/
	public function deactivate_user($user_id) 
	{
		$this->users_model->deactivate_user($user_id);
		
		redirect('all-users');
	}
	
	/*
	*
	*	Reset a user's password
	*	@param int $user_id
	*
	*/
	public function reset_password($user_id)
	{
		$new_password = $this->login_model->reset_password($user_id);
		$this->session->set_userdata('success_message', 'New password is <br/><strong>'.$new_password.'</strong>');
		
		redirect('all-users');
	}
	
	/*
	*
	*	Show an administrator's profile
	*	@param int $user_id
	*
	*/
	public function admin_profile($user_id)
	{
		//open the add new user page
		$data['title'] = 'Edit User';
		$v_data['countries'] = $this->users_model->get_all_countries();
		
		//select the user from the database
		$query = $this->users_model->get_user($user_id);
		if ($query->num_rows() > 0)
		{
			$v_data['users'] = $query->result();
			$v_data['admin_user'] = 1;
			$tab_content[0] = $this->load->view('users/edit_user', $v_data, true);
		}
		
		else
		{
			$data['tab_content'][0] = 'user does not exist';
		}
		$tab_name[1] = 'Overview';
		$tab_name[0] = 'Edit Account';
		$tab_content[1] = 'Coming soon';//$this->load->view('account_overview', $v_data, true);
		$data['total_tabs'] = 2;
		$data['content'] = $tab_content;
		$data['tab_name'] = $tab_name;
		
		$this->load->view('templates/tabs', $data);
	}
}
?>