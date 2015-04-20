<?php   if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mobile extends MX_Controller 
{
	function __construct()
	{
		parent:: __construct();
		$this->load->model('login_model');
		
		$this->load->library('encrypt');
	}
}
?>