<?php
require_once "./application/libraries/OAuth.php";

class Payments_model extends CI_Model 
{	
	public function make_pesapal_payment($client_id)
	{
		//$api = 'http://demo.pesapal.com';
		$api = 'https://www.pesapal.com';
	
		$token = $params 	= NULL;
		$iframelink 		= $api.'/api/PostPesapalDirectOrderV4';
		
		//Kenyan keys
		$consumer_key 		= $this->config->item('consumer_key'); //fill key here
		$consumer_secret 	= $this->config->item('consumer_secret'); //fill secret here
		 
		$signature_method	= new OAuthSignatureMethod_HMAC_SHA1();
		$consumer 			= new OAuthConsumer($consumer_key, $consumer_secret);
		
		//payment data
		$amount = $this->input->post('credit_type_amount');
		
		//save client credit
		$data = array
		(
			'credit_type_id' => $this->input->post('credit_type_id'),
			'client_id' => $client_id,
			'purchase_amount' => $amount,
			'client_credit_amount' => $this->input->post('credit_type_credits'),
			'created' => date('Y-m-d H:i:s')
		);
		
		$this->db->insert('client_credit', $data);
		$client_credit_id = $this->db->insert_id();
		
		//$amount 		= str_replace(',','',$amount); // remove thousands seperator if included
		$amount 		= number_format($amount, 2); //format amount to 2 decimal places
		$desc 			= $this->input->post('description');
		$type 			= 'MERCHANT';	
		$first_name 	= '';
		$last_name 		= '';
		$email 			= $this->session->userdata('client_email');
		$phonenumber	= '';
		$currency 		= "KES";//$_POST['currency'];
		$reference 		= $client_credit_id;// $_POST['reference']; //unique transaction id, generated by merchant.
		$callback_url 	= site_url().'mobile/subscription/payment';//'http://localhost/pbf/demo/redirect.php'; //URL user to be redirected to after payment
		
		//Record order in your database.
		/*$database = new pesapalDatabase();
		$database->store($_POST);*/ 
			
		$post_xml	= "<?xml version=\"1.0\" encoding=\"utf-8\"?>
					   <PesapalDirectOrderInfo 
							xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\" 
							xmlns:xsd=\"http://www.w3.org/2001/XMLSchema\" 
							Currency=\"".$currency."\" 
							Amount=\"".$amount."\" 
							Description=\"".$desc."\" 
							Type=\"".$type."\" 
							Reference=\"".$reference."\" 
							FirstName=\"".$first_name."\" 
							LastName=\"".$last_name."\" 
							Email=\"".$email."\" 
							PhoneNumber=\"".$phonenumber."\" 
							xmlns=\"http://www.pesapal.com\" />";
		$post_xml = htmlentities($post_xml);
		
		//post transaction to pesapal
		$iframe_src = OAuthRequest::from_consumer_and_token($consumer, $token, "GET", $iframelink, $params);
		$iframe_src->set_parameter("oauth_callback", $callback_url);
		$iframe_src->set_parameter("pesapal_request_data", $post_xml);
		$iframe_src->sign_request($signature_method, $consumer, $token);
		return $iframe_src;
	}
	
	public function get_pesapal_payment($pesapalTrackingId, $pesapal_merchant_reference)
	{
		$statusrequestAPI 	= 'https://www.pesapal.com/api/querypaymentstatus';//'http://demo.pesapal.com/api/querypaymentstatus'
		$consumer_key 		= $this->config->item('consumer_key');
		$consumer_secret 	= $this->config->item('consumer_secret');
		
		// Parameters sent to you by PesaPal IPN
		$pesapalNotification	=	'CHANGE';
		
		if($pesapalNotification=="CHANGE" && $pesapalTrackingId!='')
		{
		   $token = $params = NULL;
		   $consumer = new OAuthConsumer($consumer_key, $consumer_secret);
		   $signature_method = new OAuthSignatureMethod_HMAC_SHA1();
		
		   //get transaction status
		   $request_status = OAuthRequest::from_consumer_and_token($consumer, $token, "GET", $statusrequestAPI, $params);
		   $request_status->set_parameter("pesapal_merchant_reference", $pesapal_merchant_reference);
		   $request_status->set_parameter("pesapal_transaction_tracking_id",$pesapalTrackingId);
		   $request_status->sign_request($signature_method, $consumer, $token);
		
		   $ch = curl_init();
		   curl_setopt($ch, CURLOPT_URL, $request_status);
		   curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		   curl_setopt($ch, CURLOPT_HEADER, 1);
		   curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		   if(defined('CURL_PROXY_REQUIRED')) if (CURL_PROXY_REQUIRED == 'True')
		   {
			  $proxy_tunnel_flag = (defined('CURL_PROXY_TUNNEL_FLAG') && strtoupper(CURL_PROXY_TUNNEL_FLAG) == 'FALSE') ? false : true;
			  curl_setopt ($ch, CURLOPT_HTTPPROXYTUNNEL, $proxy_tunnel_flag);
			  curl_setopt ($ch, CURLOPT_PROXYTYPE, CURLPROXY_HTTP);
			  curl_setopt ($ch, CURLOPT_PROXY, CURL_PROXY_SERVER_DETAILS);
		   }
		
		   $response = curl_exec($ch);
		
		   $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
		   $raw_header  = substr($response, 0, $header_size - 4);
		   $headerArray = explode("\r\n\r\n", $raw_header);
		   $header      = $headerArray[count($headerArray) - 1];
		
		   //transaction status
		   $elements = preg_split("/=/",substr($response, $header_size));
		   $status = $elements[1];
		
		   curl_close ($ch);
		   return $elements;
		   
		   //UPDATE YOUR DB TABLE WITH NEW STATUS FOR TRANSACTION WITH pesapal_transaction_tracking_id $pesapalTrackingId
		
		   /*if(DB_UPDATE_IS_SUCCESSFUL)
		   {
			  $resp="pesapal_notification_type=$pesapalNotification&pesapal_transaction_tracking_id=$pesapalTrackingId&pesapal_merchant_reference=$pesapal_merchant_reference";
			  ob_start();
			  echo $resp;
			  ob_flush();
			  exit;
		   }*/
		}
	}

	public function get_credit_types()
	{
		$this->db->where('credit_type_status', 1);
		$this->db->order_by('credit_type_amount', 'ASC');
		$query = $this->db->get('credit_type');
		
		return $query;
	}

	public function get_credit_type($credit_type_id)
	{
		$this->db->where('credit_type_id', $credit_type_id);
		$query = $this->db->get('credit_type');
		
		return $query;
	}
	
	public function get_client_credits($client_id)
	{
		$this->db->where(array('client_id'=>$client_id, 'client_credit_status > '=> 0));
		$this->db->order_by('created', 'DESC');
		$query = $this->db->get('client_credit');
		
		return $query;
	}
	
	public function get_client_bills($client_id)
	{
		$this->db->where('client_id', $client_id);
		$this->db->order_by('created', 'DESC');
		$query = $this->db->get('client_bill');
		
		return $query;
	}
	
	public function activate_payment($transaction_tracking_id, $client_credit_id)
	{
		$data['transaction_tracking_id'] = $transaction_tracking_id;
		$data['client_credit_status'] = 1;
		
		$this->db->where('client_credit_id', $client_credit_id);
		if($this->db->update('client_credit', $data))
		{
			return TRUE;
		}
		
		else
		{
			return FALSE;
		}
	}
	
	public function update_payment_response($transaction_tracking_id, $client_credit_id)
	{
		$data['transaction_tracking_id'] = $transaction_tracking_id;
		$data['client_credit_status'] = 2;
		
		$this->db->where('client_credit_id', $client_credit_id);
		if($this->db->update('client_credit', $data))
		{
			return TRUE;
		}
		
		else
		{
			return FALSE;
		}
	}
	
	public function calculate_credit_total($client_id)
	{
		//select the user by email from the database
		$this->db->select('SUM(client_credit.client_credit_amount) AS total_credit');
		$this->db->where('client_credit_status = 1 AND client_id = '.$client_id);
		$this->db->from('client_credit');
		$query = $this->db->get();
		
		$result = $query->row();
		
		return $result->total_credit;
	}
	
	public function calculate_bill_total($client_id)
	{
		//select the user by email from the database
		$this->db->select('SUM(client_bill.client_bill_amount) AS total_bill');
		$this->db->where('client_bill_status = 1 AND client_id = '.$client_id);
		$this->db->from('client_bill');
		$query = $this->db->get();
		
		$result = $query->row();
		
		return $result->total_bill;
	}
	
	public function get_account_balance($client_id)
	{
		$bill_total = $this->payments_model->calculate_bill_total($client_id);
		$credit_total = $this->payments_model->calculate_credit_total($client_id);
		
		return ($credit_total - $bill_total);
	}
	
	public function bill_client($client_id, $amount)
	{
		//save client credit
		$data = array
		(
			'client_id' => $client_id,
			'client_bill_amount' => $amount,
			'created' => date('Y-m-d H:i:s')
		);
		
		if($this->db->insert('client_bill', $data))
		{
			$client_bill_id = $this->db->insert_id();
			return TRUE;
		}
		
		else
		{
			return FALSE;
		}
	}
	
	public function first_hundred($client_id)
	{
		$this->db->from('client');
		$total_clients = $this->db->count_all_results();
		
		//grant 300 credits to first 100 users
		if($total_clients <= 100)
		{
			//save client credit
			$data = array
			(
				'client_id' => $client_id,
				'client_credit_status' => 1,
				'client_credit_amount' => 50,
				'created' => date('Y-m-d H:i:s')
			);
			
			$this->db->insert('client_credit', $data);
			$client_credit_id = $this->db->insert_id();
		}
		
		else
		{
			//save client credit
			$data = array
			(
				'client_id' => $client_id,
				'client_credit_status' => 1,
				'client_credit_amount' => 25,
				'created' => date('Y-m-d H:i:s')
			);
			
			$this->db->insert('client_credit', $data);
			$client_credit_id = $this->db->insert_id();
		}
		
		return TRUE;
	}
}
?>