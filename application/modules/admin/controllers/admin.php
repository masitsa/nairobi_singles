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
}
?>