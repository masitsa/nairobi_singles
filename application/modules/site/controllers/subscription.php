<?php   if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once "./application/modules/site/controllers/account.php";

class Subscription extends account 
{
	function __construct()
	{
		parent:: __construct();
	}
	
	public function subscribe()
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
		
		$v_data['credit_types'] = $this->payments_model->get_credit_types();
		$v_data['credits'] = $this->payments_model->get_client_credits($this->client_id);
		$v_data['account_balance'] = $this->payments_model->get_account_balance($this->client_id);
		
		$v_data['iframe'] = '';
		
		//form validation rules
		$this->form_validation->set_rules('credit_type_credits', 'Credits', 'required|xss_clean');
		$this->form_validation->set_rules('credit_type_amount', 'Amount', 'required|xss_clean');
		$this->form_validation->set_rules('description', 'Description', 'required|xss_clean');
		
		//if form has been submitted
		if ($this->form_validation->run())
		{
			$iframe = $this->payments_model->make_pesapal_payment($this->client_id);
			$v_data['iframe'] = $iframe;
		}
		
		else
		{
			$validation_errors = validation_errors();
			
			if(!empty($validation_errors))
			{
				$this->session->set_userdata('error_message', validation_errors());
			}
		}
		
		$v_data['crumbs'] = $this->site_model->get_crumbs();
		
		$data['content'] = $this->load->view('subscription/subscription', $v_data, true);
		$data['title'] = $this->site_model->display_page_title();
		$this->load->view('templates/general_page', $data);
	}
    
	/*
	*
	*	Payment success Page
	*
	*/
	public function payment()
	{
		//mark booking as paid in the database
		$payment_data = $this->input->get();
		$transaction_tracking_id = $payment_data['pesapal_transaction_tracking_id'];
		$client_credit_id = $payment_data['pesapal_merchant_reference'];
		
		if($this->payments_model->activate_payment($transaction_tracking_id, $client_credit_id))
		{
			$this->session->set_userdata('success_message', 'Your payment has been received successfully');
		}
		
		else
		{
			$this->session->set_userdata('error_message', 'Unable to complete your payment. Please contact an administrator');
		}
		redirect('credits');
	}
}
?>