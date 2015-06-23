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
		$account_balance = $this->payments_model->get_account_balance($this->client_id);
		$return = '<div class="alert alert-info"><p class="center-align">Your account balance is currently '.$account_balance.'chatcredits</p>';
		
		echo json_encode($return);
	}
	
	public function purchase_credit()
	{
		$v_data['iframe'] = '';
		
		//form validation rules
		$this->form_validation->set_rules('credit_type_id', 'Credit type', 'required|xss_clean');
		$this->form_validation->set_rules('credit_type_credits', 'Credits', 'required|xss_clean');
		$this->form_validation->set_rules('credit_type_amount', 'Amount', 'required|xss_clean');
		$this->form_validation->set_rules('description', 'Description', 'required|xss_clean');
		
		//if form has been submitted
		if ($this->form_validation->run())
		{
			$iframe = $this->payments_model->make_pesapal_payment($this->client_id);
			$v_data['iframe'] = $iframe;
		}
		
		$data['content'] = $this->load->view('subscription/subscription', $v_data, true);
		
		echo json_encode($data);
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
		
		//check to see if the payment was successfully made
		$response = $this->payments_model->get_pesapal_payment($transaction_tracking_id, $client_credit_id);
		
		if($response[1] == 'COMPLETED')
		{
			if($this->payments_model->activate_payment($transaction_tracking_id, $client_credit_id))
			{
				$this->session->set_userdata('success_message', 'Your payment has been received successfully');
			}
			
			else
			{
				$this->session->set_userdata('error_message', 'Unable to complete your payment. Please contact an administrator');
			}
			$this->subscribe();
		}
		
		else
		{
			$this->payments_model->update_payment_response($transaction_tracking_id, $client_credit_id);
			
			$this->process_payment($transaction_tracking_id, $client_credit_id);
		}
	}
	
	public function process_payment($transaction_tracking_id, $client_credit_id)
	{
		$v_data['transaction_tracking_id'] = $transaction_tracking_id;
		$v_data['client_credit_id'] = $client_credit_id;
		
		$data['content'] = $this->load->view('subscription/processing', $v_data, true);
		
		echo json_encode($data);
	}
	
	public function check_payment($count, $transaction_tracking_id, $client_credit_id)
	{	
		$count++;
		
		$response = $this->payments_model->get_pesapal_payment($transaction_tracking_id, $client_credit_id);
		$status = $response[1];
		
		if($response[1] == 'COMPLETED')
		{
			if($this->payments_model->activate_payment($transaction_tracking_id, $client_credit_id))
			{
				$this->session->set_userdata('success_message', 'Your payment has been received successfully');
			}
			
			else
			{
				$this->session->set_userdata('error_message', 'Unable to complete your payment. Please contact an administrator');
			}
			echo 'true';
			
			//$this->session->unset_userdata('transaction_tracking_id', $transaction_tracking_id);
			//$this->session->unset_userdata('client_credit_id', $client_credit_id);
		}
		
		else if($count == 20)
		{
			$this->session->set_userdata('error_message', 'Unable to complete your payment. Kindly ensure that you followed the steps provided in Pesapal and entered the correct transaction number');
			echo 'true';
		}
		
		else
		{
			echo $count;
		}
	}
	
	public function check_payment2()
	{
		/*$this->session->set_userdata('transaction_tracking_id', '2e39abc3-267c-4f21-84a6-e6d3f0c778c');
		$this->session->set_userdata('client_credit_id', '23');*/
		$status = '';
		$count = 0;
		$transaction_tracking_id = $this->session->userdata('pesapal_transaction_tracking_id');
		$client_credit_id = $this->session->userdata('client_credit_id');
		
		while($status != 'COMPLETED')
		{
			$count++;
			//echo $count.'<br/>';
			$response = $this->payments_model->get_pesapal_payment($transaction_tracking_id, $client_credit_id);
			$status = $response[1];
			
			if($response[1] == 'COMPLETED')
			{
				if($this->payments_model->activate_payment($transaction_tracking_id, $client_credit_id))
				{
					$this->session->set_userdata('success_message', 'Your payment has been received successfully');
				}
				
				else
				{
					$this->session->set_userdata('error_message', 'Unable to complete your payment. Please contact an administrator');
				}
				echo 'true';
			}
			
			if($count == 1000000)
			{
				$this->session->set_userdata('error_message', 'Unable to complete your payment. Kindly ensure that you followed the steps provided in Pesapal and entered the correct transaction number');
				echo 'false';
				break;
			}
		}
			
		$this->session->unset_userdata('transaction_tracking_id', $transaction_tracking_id);
		$this->session->unset_userdata('client_credit_id', $client_credit_id);
	}
}
?>