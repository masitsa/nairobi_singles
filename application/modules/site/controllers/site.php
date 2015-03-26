<?php   if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Site extends MX_Controller 
{
	var $profile_image_location;
	var $profile_image_path;
		
	function __construct()
	{
		parent:: __construct();
		$this->load->model('admin/users_model');
		$this->load->model('site_model');
		$this->load->model('login/login_model');
		
		$this->load->library('image_lib');
		$this->load->library('encrypt');
		
		//path to image directory
		$this->profile_image_path = realpath(APPPATH . '../assets/images/profile');
		$this->profile_image_location = base_url().'assets/images/profile/';
	}
    
	/*
	*
	*	Default action is to go to the home page
	*
	*/
	public function index() 
	{
		redirect('home');
	}
    
	/*
	*
	*	Home Page
	*
	*/
	public function home_page() 
	{
		$v_data['gender_query'] = $this->site_model->get_gender();
		$data['content'] = $this->load->view('home/home', $v_data, true);
		
		$data['title'] = $this->site_model->display_page_title();
		$this->load->view('templates/home_page', $data);
	}
	
	public function __get_payments()
	{
		$this->load->model('site/payments_model');
		$response = $this->payments_model->get_pesapal_payment();
		
		var_dump($response);
	}
}
?>