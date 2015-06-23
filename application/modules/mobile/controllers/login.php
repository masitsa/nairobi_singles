<?php   if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends MX_Controller 
{
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
    
		$this->load->model('login_model');
		$this->load->library('Mandrill', $this->config->item('mandrill_key'));
		
		$this->load->library('encrypt');
	}
    
	/*
	*
	*	Default action is to go to the home page
	*
	*/
	public function login_client($client_email = '', $client_password = '') 
	{
		$result = $this->login_model->validate_client($client_email, $client_password);
		
		if($result != FALSE)
		{
			$this->load->model('payments_model');
			//create user's login session
			$newdata = array(
                   'client_login_status'    => TRUE,
                   'client_username'     	=> $result[0]->client_username,
                   'client_email'     		=> $result[0]->client_email,
                   'client_id'  			=> $result[0]->client_id,
                   'account_balance'  		=> $this->payments_model->get_account_balance( $result[0]->client_id),
                   'client_code'  			=> md5($result[0]->client_id)
               );
			$this->session->set_userdata($newdata);
			
			$response['message'] = 'success';
			$response['result'] = $newdata;
		}
		
		else
		{
			$response['message'] = 'fail';
			$response['result'] = 'You have entered incorrect details. Please try again';
		}
		
		//echo $_GET['callback'].'(' . json_encode($response) . ')';
		echo json_encode($response);
	}
	
	public function dummy()
	{
		$return[0]['firstName'] = 'James';
		$return[0]['lastName'] = 'King';
		$return[1]['firstName'] = 'Eugene';
		$return[1]['lastName'] = 'Lee';
		$return[2]['firstName'] = 'Julie';
		$return[2]['lastName'] = 'Taylor';
		
		echo json_encode($return);
	}
	
	public function register_user()
	{
		$this->form_validation->set_rules('email', 'Email', 'trim|valid_email|is_unique[client.client_email]|required|xss_clean');
		$this->form_validation->set_rules('username', 'Username', 'trim|required|is_unique[client.client_username]|xss_clean');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');
		$this->form_validation->set_rules('client_agree', 'Agree', 'trim|required|xss_clean');
		
		//if form conatins invalid data
		if ($this->form_validation->run())
		{
			$client_id = $this->login_model->register_client_details();
			
			if($client_id > 0)
			{
				$this->load->model('site/payments_model');
				//grant 100 chat credits for the first 100 users
				if($this->payments_model->first_hundred($client_id))
				{
				}
				
				else
				{
				}
				$response['account_balance'] = $this->payments_model->get_account_balance($client_id);
				$response['message'] = 'success';
				$response['result'] = 'You have successfully created your account. We need some info from you so that we can link you with people looking for you';
			}
			
			else
			{
				$response['message'] = 'fail';
				$response['result'] = 'Unable to create your account. Plese try again';
			}
		}
		else
		{
			$validation_errors = validation_errors();
			
			//repopulate form data if validation errors are present
			if(empty($validation_errors))
			{
				$response['message'] = 'fail';
				$response['result'] = 'Ensure that you have entered all the values in the form provided';
			}
			
			//populate form data on initial load of page
			else
			{
				$response['message'] = 'fail';
			 	$response['result'] = $validation_errors;
			}
		}
		echo json_encode($response);
	}
    
	/*
	*
	*	Action of a forgotten password
	*
	*/
	public function forgot_password($email)
	{
		$this->load->model('email_model');
		
		//reset password
		$data = array();
		$data = $this->login_model->reset_client_password($email);
		
		echo json_encode($data);
	}
}
?>