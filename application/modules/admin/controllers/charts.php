<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once "./application/modules/admin/controllers/admin.php";

class Charts extends admin {
	
	var $days;

	function __construct()
	{
		parent::__construct();
		
		//$this->load->model('charts_model');
		//$this->load->model('dates_model');
		$this->load->model('reports_model');
		$this->load->model('clients_model');
		$this->days = 7;
	}
	
	function latest_patient_totals()
	{
		$period = $this->dates_model->last_seven_days();
		//var_dump($period);
		$patient_totals = '';
		$r = 0;
		$highest_bar = 0;
		
		foreach( $period as $day) 
		{
			$date = $day->format( 'Y-m-d');
			
			$total = $this->reports_model->get_queue_total($date);
			
			if($total > $highest_bar)
			{
				$highest_bar = $total;
			}
			
			if($r == 7)
			{
				$patient_totals .= $total;
			}
			
			else
			{
				$patient_totals .= $total.',';
			}
			
			$r++;
		}
		
		$result['highest_bar'] = $highest_bar;
		$result['bars'] = $patient_totals;
		
		echo json_encode($result);
	}
	
	function queue_total()
	{
		$highest_bar = 0;
		//nurse total
		$nurse_total = $this->reports_model->get_queue_total(NULL, 'nurse_visit = 0');
		$result['bars'] = $nurse_total;
		
		if($nurse_total > $highest_bar)
		{
			$highest_bar = $nurse_total;
		}
		
		//doctor total
		$doctor_total = $this->reports_model->get_queue_total(NULL, 'doc_visit = 0 AND nurse_visit = 1');
		$result['bars'] .= $doctor_total.',';
		
		if($doctor_total > $highest_bar)
		{
			$highest_bar = $doctor_total;
		}
		
		//dental total
		$dental_total = $this->reports_model->get_queue_total(NULL, 'dental_visit = 1');
		$result['bars'] .= $dental_total.',';
		
		if($dental_total > $highest_bar)
		{
			$highest_bar = $dental_total;
		}
		
		//lab total
		$lab_total = $this->reports_model->get_queue_total(NULL, 'doc_visit = 1 AND nurse_visit = 1 AND lab_visit = 0');
		$result['bars'] .= $lab_total.',';
		
		if($lab_total > $highest_bar)
		{
			$highest_bar = $lab_total;
		}
		
		//pharmacy total
		$pharmacy_total = $this->reports_model->get_queue_total(NULL, 'doc_visit = 1 AND nurse_visit = 1 AND pharmarcy = 6');
		$result['bars'] .= $pharmacy_total;
		
		if($pharmacy_total > $highest_bar)
		{
			$highest_bar = $pharmacy_total;
		}
		
		$result['highest_bar'] = $highest_bar;
		
		echo json_encode($result);
	}
	
	function payment_methods()
	{
		//get all payment methods
		$methods_result = $this->reports_model->get_all_payment_methods();
		
		$totals = '';
		$highest_bar = 0;
		$r = 0;
		
		if($methods_result->num_rows() > 0)
		{
			$result = $methods_result->result();
			
			foreach($result as $res)
			{
				$payment_method_id = $res->payment_method_id;
				
				//get method total
				$total = $this->reports_model->get_payment_method_total($payment_method_id);
				
				if($total > $highest_bar)
				{
					$highest_bar = $total;
				}
				
				if($r == $methods_result->num_rows())
				{
					$totals .= $total;
				}
				
				else
				{
					$totals .= $total.',';
				}
				$r++;
			}
		}
		
		$result['highest_bar'] = $highest_bar;
		$result['bars'] = $totals;
		
		echo json_encode($result);
	}
	
	function clients_totals($timestamp)
	{
		$date = gmdate("Y-m-d", ($timestamp/1000));
		
		//get all patient types
		$genders_result = $this->clients_model->get_all_genders();
		
		//initialize required variables
		$highest_bar = 0;
		
		if($genders_result->num_rows() > 0)
		{
			$result = $genders_result->result();
			
			foreach($result as $res)
			{				
				$gender_id = $res->gender_id;
				$gender_name = $res->gender_name;
				
				//get method total
				$total = $this->reports_model->get_clients_total($gender_id, $date);
				//mark the highest bar
				if($total > $highest_bar)
				{
					$highest_bar = $total;
				}
				
				//prep data for the particular visit type
				$result[strtolower($gender_name)] = $total;
			}
		}
		$result['highest_bar'] = $highest_bar;//var_dump($result['bars']);
		echo json_encode($result);
	}
	
	function credit_types_totals()
	{
		$this->load->model('credit_types_model');
		//get all patient types
		$parents = $this->credit_types_model->all_credit_types();
		
		//initialize required variables
		$totals = '';
		$names = '';
		$highest_bar = 0;
		$r = 1;
		
		if($parents->num_rows() > 0)
		{
			$result = $parents->result();
			
			foreach($result as $res)
			{
				$credit_type_id = $res->credit_type_id;
				$credit_type_name = $res->credit_type_name;
				
				//get service total
				$total = $this->reports_model->get_credit_types_total($credit_type_id);
				
				//mark the highest bar
				if($total > $highest_bar)
				{
					$highest_bar = $total;
				}
				
				if($r == $parents->num_rows())
				{
					$totals .= $total;
					$names .= $credit_type_name;
				}
				
				else
				{
					$totals .= $total.',';
					$names .= $credit_type_name.',';
				}
				$r++;
			}
		}
		
		$result['total_credit_types'] = $parents->num_rows();
		$result['names'] = $names;
		$result['bars'] = $totals;
		$result['highest_bar'] = $highest_bar;
		echo json_encode($result);
	}
	
	public function usage_total()
	{
		$total = $this->reports_model->get_usage_total();
		$result['usage_total'] = $total;
		
		echo json_encode($result);
	}
}