<?php   if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends MX_Controller {
	
	function __construct()
	{
		parent:: __construct();
		$this->load->model('login/login_model');
		
		//user has logged in
		if($this->login_model->check_login())
		{
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