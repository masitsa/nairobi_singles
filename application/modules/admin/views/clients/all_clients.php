<?php
		
		$result = '<a href="#" class="btn btn-success pull-right">Add client</a>';
		
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
					  <th>Image</th>
					  <th><a href="'.site_url().'all-clients/client.client_username/'.$order_method.'/'.$page.'">Username</a></th>
					  <th><a href="'.site_url().'all-clients/gender.gender_name/'.$order_method.'/'.$page.'">Gender</a></th>
					  <th><a href="'.site_url().'all-clients/client.client_email/'.$order_method.'/'.$page.'">Email</a></th>
					  <th><a href="'.site_url().'all-clients/client.created/'.$order_method.'/'.$page.'">Date registered</a></th>
					  <th><a href="'.site_url().'all-clients/client.last_login/'.$order_method.'/'.$page.'">Last login</a></th>
					  <th><a href="'.site_url().'all-clients/client.client_status/'.$order_method.'/'.$page.'">Status</a></th>
					  <th>Balance</th>
					  <th colspan="5">Actions</th>
					</tr>
				  </thead>
				  <tbody>
			';
			
			foreach ($query->result() as $row)
			{
				$client_id = $row->client_id;
				$client_username = $row->client_username;
				$client_status = $row->client_status;
				$client_thumb = $row->client_thumb;
				$gender_name = $row->gender_name;
				$client_email = $row->client_email;
				$image = $this->profile_model->image_display($profile_image_path, $profile_image_location, $client_thumb);
				$account_balance = $this->payments_model->get_account_balance($client_id);
				
				//create deactivated status display
				if($client_status == 0)
				{
					$status = '<span class="label label-important">Deactivated</span>';
					$button = '<a class="btn btn-info" href="'.site_url().'activate-client/'.$client_id.'" onclick="return confirm(\'Do you want to activate '.$client_username.'?\');">Activate</a>';
				}
				//create activated status display
				else if($client_status == 1)
				{
					$status = '<span class="label label-success">Active</span>';
					$button = '<a class="btn btn-default" href="'.site_url().'deactivate-client/'.$client_id.'" onclick="return confirm(\'Do you want to deactivate '.$client_username.'?\');">Deactivate</a>';
				}
				
				$count++;
				$result .= 
				'
					<tr>
						<td>'.$count.'</td>
						<td><img src="'.$image.'" class="img-responsive" width="100"></td>
						<td>'.$client_username.'</td>
						<td>'.$gender_name.'</td>
						<td>'.$client_email.'</td>
						<td>'.date('jS M Y H:i a',strtotime($row->created)).'</td>
						<td>'.date('jS M Y H:i a',strtotime($row->last_login)).'</td>
						<td>'.$status.'</td>
						<td>'.$account_balance.'</td>
						<td>'.$button.'</td>
						<!--<td><a href="'.site_url().'edit-client/'.$client_id.'" class="btn btn-sm btn-success">Edit</a></td>
						<td><a href="'.site_url().'delete-client/'.$client_id.'" class="btn btn-sm btn-danger" onclick="return confirm(\'Do you really want to delete '.$client_username.'?\');">Delete</a></td>-->
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
			$result .= "There are no clients";
		}
		
		echo $result;
?>