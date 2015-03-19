<?php   if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends MX_Controller {
	
	function __construct()
	{
		parent:: __construct();
		$this->load->model('login_model');
		$this->load->model('site/email_model');
		$this->load->library('Mandrill', $this->config->item('mandrill_key'));
	}
    
	/*
	*
	*	Login a user
	*
	*/
	public function login_admin() 
	{
		//form validation rules
		$this->form_validation->set_rules('email', 'Email', 'required|xss_clean|exists[users.email]');
		$this->form_validation->set_rules('password', 'Password', 'required|xss_clean');
		
		//if form has been submitted
		if ($this->form_validation->run())
		{
			//check if user has valid login credentials
			if($this->login_model->validate_user())
			{
				redirect('dashboard');
			}
			
			else
			{
				$data['error'] = 'The email or password provided is incorrect. Please try again';
				$this->load->view('admin_login', $data);
			}
		}
		
		else
		{
			$this->load->view('admin_login');
		}
	}
	
	public function logout_admin()
	{
		$this->session->sess_destroy();
		redirect('login-admin');
	}
	
	public function logout_user()
	{
		$this->session->sess_destroy();
		$this->session->set_userdata('success_message', 'Your have been signed out of your account');
		redirect('home');
	}
	
	public function register_user()
	{
		$v_data['client_username_error'] = '';
		$v_data['client_password_error'] = '';
		$v_data['confirm_password_error'] = '';
		$v_data['client_email_error'] = '';
		$v_data['client_agree'] = '';
		
		$this->form_validation->set_error_delimiters('', '');
		$this->form_validation->set_rules('client_username', 'Username', 'trim|required|is_unique[client.client_username]|xss_clean');
		$this->form_validation->set_rules('client_password', 'Password', 'trim|required|matches[confirm_password]|xss_clean');
		$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required|xss_clean');
		$this->form_validation->set_rules('client_email', 'Email', 'trim|valid_email|is_unique[client.client_email]|required|xss_clean');
		$this->form_validation->set_rules('client_agree', 'Agree', 'trim|required|xss_clean');
		
		//if form conatins invalid data
		if ($this->form_validation->run())
		{
			if($this->login_model->register_client_details())
			{
				if($this->login_model->validate_client())
				{
					$this->session->set_userdata('success_message', 'You have successfully created your account. We need some info from you so that we can link you with people looking for you.');
					redirect('register/about-you');
				}
				else
				{
					$this->session->set_userdata('error_message', 'Please sign in to access your account');
					redirect('sign-in');
				}
			}
			
			else
			{
				$this->session->set_userdata('error_message', 'Unable to create account. Please try again');
			}
		}
		else
		{
			$validation_errors = validation_errors();
			
			//repopulate form data if validation errors are present
			if(!empty($validation_errors))
			{
				//create errors
				$v_data['client_username_error'] = form_error('client_username');
				$v_data['client_password_error'] = form_error('client_password');
				$v_data['confirm_password_error'] = form_error('confirm_password');
				$v_data['client_email_error'] = form_error('client_email');
				$v_data['client_agree_error'] = form_error('client_agree');
				
				//repopulate fields
				$v_data['client_username'] = set_value('client_username');
				$v_data['client_password'] = set_value('client_password');
				$v_data['confirm_password'] = set_value('confirm_password');
				$v_data['client_email'] = set_value('client_email');
				$v_data['client_agree'] = set_value('client_agree');
			}
			
			//populate form data on initial load of page
			else
			{
				$v_data['client_username'] = "";
				$v_data['client_password'] = "";
				$v_data['confirm_password'] = "";
				$v_data['client_email'] = "";
				$v_data['client_agree'] = "";
			}
		}
		$data['content'] = $this->load->view('client_signup', $v_data, true);
		
		$data['title'] = 'Sign up';
		$this->load->view('site/templates/home_page', $data);
	}
    
	/*
	*
	*	Login a client
	*
	*/
	public function login_client() 
	{
		$v_data['client_password_error'] = '';
		$v_data['client_email_error'] = '';
		
		//form validation rules
		$this->form_validation->set_error_delimiters('', '');
		$this->form_validation->set_rules('client_email', 'Email', 'required|xss_clean|exists[client.client_email]');
		$this->form_validation->set_rules('client_password', 'Password', 'required|xss_clean');
		$this->form_validation->set_message('exists', 'That email does not exist. Are you trying to sign up?');
		
		//if form has been submitted
		if($this->form_validation->run())
		{
			//check if user has valid login credentials
			if($this->login_model->validate_client())
			{
				$this->session->set_userdata('success_message', 'Welcome back.');
				redirect('browse');
			}
			
			else
			{
				$this->session->set_userdata('error_message', 'The email or password provided is incorrect. Please try again');
				
				//repopulate fields
				$v_data['client_password'] = set_value('client_password');
				$v_data['client_email'] = set_value('client_email');
			}
		}
		else
		{
			$validation_errors = validation_errors();
			
			//repopulate form data if validation errors are present
			if(!empty($validation_errors))
			{
				//create errors
				$v_data['client_password_error'] = form_error('client_password');
				$v_data['client_email_error'] = form_error('client_email');
				
				//repopulate fields
				$v_data['client_password'] = set_value('client_password');
				$v_data['client_email'] = set_value('client_email');
			}
			
			//populate form data on initial load of page
			else
			{
				$v_data['client_password'] = "";
				$v_data['client_email'] = "";
			}
		}
		
		$data['content'] = $this->load->view('client_signin', $v_data, true);
		
		$data['title'] = 'Sign in';
		$this->load->view('site/templates/home_page', $data);
	}
    
	/*
	*
	*	Action of a forgotten password
	*
	*/
	public function forgot_password()
	{
		$v_data['client_email_error'] = '';
		
		//form validation rules
		$this->form_validation->set_error_delimiters('', '');
		$this->form_validation->set_rules('client_email', 'Email', 'required|xss_clean|valid_email|exists[client.client_email]');
		$this->form_validation->set_message('exists', 'That email does not exist. Are you trying to sign up?');
		
		//if form has been submitted
		if ($this->form_validation->run())
		{
			$this->load->model('email_model');
			
			//reset password
			if($this->login_model->reset_client_password())
			{
				$this->session->set_userdata('success_message', 'Your password has been reset and mailed to '.$this->input->post('client_email').'. Please use that password to sign in here');
				
				redirect('sign-in');
			}
			
			else
			{
				$this->session->set_userdata('error_message', 'Could not add a new user. Please try again.');
			}
		}
		
		else
		{
			$validation_errors = validation_errors();
			
			//repopulate form data if validation errors are present
			if(!empty($validation_errors))
			{
				//create errors
				$v_data['client_email_error'] = form_error('client_email');
				
				//repopulate fields
				$v_data['client_email'] = set_value('client_email');
			}
			
			//populate form data on initial load of page
			else
			{
				$v_data['client_email'] = "";
			}
		}
		
		//page datea
		$data['content'] = $this->load->view('reset_password', $v_data, true);
		
		$data['title'] = 'Forgot password';
		$this->load->view('site/templates/home_page', $data);
	}
}
?>