<?php   if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends MX_Controller 
{
	function __construct()
	{
		parent:: __construct();
		$this->load->model('login_model');
		
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
			//create user's login session
			$newdata = array(
                   'client_login_status'    => TRUE,
                   'client_username'     	=> $result[0]->client_username,
                   'client_email'     		=> $result[0]->client_email,
                   'client_id'  			=> $result[0]->client_id,
                   'client_code'  			=> md5($result[0]->client_id)
               );
			
			$response['message'] = 'success';
			$response['result'] = $newdata;
		}
		
		else
		{
			$response['message'] = 'fail';
			$response['result'] = 'You have entered incorrect details. Please try again '.$client_email.$client_password;
		}
		
		echo $_GET['callback'].'(' . json_encode($response) . ')';
	}
}
?>