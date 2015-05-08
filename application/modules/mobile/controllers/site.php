<?php   if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Site extends MX_Controller 
{
	var $profile_image_location;
	var $profile_image_path;
		
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
    
	/*
	*
	*	Terms Page
	*
	*/
	public function terms() 
	{
		$data['content'] = $this->load->view('terms', '', true);
		
		$data['title'] = $this->site_model->display_page_title();
		$this->load->view('templates/home_page', $data);
	}
    
	/*
	*
	*	Privacy Page
	*
	*/
	public function privacy() 
	{
		$data['content'] = $this->load->view('privacy', '', true);
		
		$data['title'] = $this->site_model->display_page_title();
		$this->load->view('templates/home_page', $data);
	}
	
	public function get_payments($pesapalTrackingId, $pesapal_merchant_reference)
	{
		$this->load->model('site/payments_model');
		$response = $this->payments_model->get_pesapal_payment($pesapalTrackingId, $pesapal_merchant_reference);
		
		var_dump($response);
	}
}
?>