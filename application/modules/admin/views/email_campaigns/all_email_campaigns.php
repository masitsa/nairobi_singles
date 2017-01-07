<?php
		
		$result = '<a href="'.site_url().'admin/email_campaigns/send_mail" class="btn btn-success pull-right">Add email campaign</a>';
		
		//if users exist display them
		if ($query->num_rows() > 0)
		{
			$count = $page;
			
			$result .= 
			'
				<table class="table table-hover table-bordered ">
				  <thead>
					<tr>
					  <th>#</th>
					  <th><a href="'.site_url().'admin/email_campaigns/index/subject/'.$order_method.'/'.$page.'">Subject</a></th>
					  <th><a href="'.site_url().'admin/email_campaigns/index/created/'.$order_method.'/'.$page.'">Created</a></th>
					  <th><a href="'.site_url().'admin/email_campaigns/index/last_sent'.$order_method.'/'.$page.'">Last sent</a></th>
					  <th><a href="#">Recepients</a></th>
					  <th colspan="1">Actions</th>
					</tr>
				  </thead>
				  <tbody>
			';
			
			foreach ($query->result() as $row)
			{
				$email_campaign_id = $row->email_campaign_id;
				$subject = $row->subject;
				$created = date('jS M Y H:i a',strtotime($row->created));
				$last_sent = date('jS M Y H:i a',strtotime($row->last_sent));
				$recepients = $this->email_campaigns_model->count_recepients($email_campaign_id);
				
				$count++;
				$result .= 
				'
					<tr>
						<td>'.$count.'</td>
						<td>'.$subject.'</td>
						<td>'.$created.'</td>
						<td>'.$last_sent.'</td>
						<td>'.$recepients.'</td>
						<!--<td><a href="'.site_url().'edit-email_campaign/'.$email_campaign_id.'" class="btn btn-sm btn-success">Edit</a></td>-->
						<td><a href="'.site_url().'admin/email_campaigns/continue_send/'.$email_campaign_id.'" class="btn btn-sm btn-danger" onclick="return confirm(\'Do you really want to continue sending '.$subject.'?\');">Continue sending</a></td>
					</tr> 
				';
			}
			
			$result .= 
			'
						  </tbody>
						</table>
			';
		}
		
		else
		{
			$result .= "There are no email_campaigns";
		}
		
		echo $result;
?>