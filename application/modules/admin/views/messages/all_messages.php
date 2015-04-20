<?php
		
		$result = '<a href="#" class="btn btn-success pull-right">Add chat</a>';
		
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
					  <th><a href="'.site_url().'all-messages/client_message.client_id/'.$order_method.'/'.$page.'">Sender</a></th>
					  <th><a href="'.site_url().'all-messages/client_message.receiver_id/'.$order_method.'/'.$page.'">Receiver</a></th>
					  <th><a href="'.site_url().'all-messages/client_message.created/'.$order_method.'/'.$page.'">Initated on</a></th>
					  <th colspan="5">Actions</th>
					</tr>
				  </thead>
				  <tbody>
			';
			
			foreach ($query->result() as $row)
			{
				$client_message_id = $row->client_message_id;
				$sender_id = $row->client_id;
				$receiver_id = $row->receiver_id;
				$created = $row->created;
				
				//sender
				$client = $this->clients_model->get_client($sender_id);
				if($client->num_rows() > 0)
				{
					$row = $client->row();
					$sender_username = $row->client_username;
					$sender_image = $row->client_image;
					$image_s = $this->profile_model->image_display($profile_image_path, $profile_image_location, $sender_image);
				}
				
				else
				{
					$sender_username = '';
					$image_s = '';
				}
				
				//receiver
				$client = $this->clients_model->get_client($receiver_id);
				if($client->num_rows() > 0)
				{
					$row = $client->row();
					$receiver_username = $row->client_username;
					$receiver_image = $row->client_image;
					$image_r = $this->profile_model->image_display($profile_image_path, $profile_image_location, $receiver_image);
				}
				
				else
				{
					$receiver_username = '';
					$image_r = '';
				}
				
				$count++;
				$result .= 
				'
					<tr>
						<td>'.$count.'</td>
						<td><img src="'.$image_s.'" width="100"> <br/> '.$sender_username.'</td>
						<td><img src="'.$image_r.'" width="100"> <br/> '.$receiver_username.'</td>
						<td>'.date('jS M Y H:i a',strtotime($created)).'</td>
						
						<td><a href="'.site_url().'view-chat/'.$client_message_id.'/'.$sender_id.'/'.$receiver_id.'" class="btn btn-sm btn-success">View chat</a></td>
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
			$result .= "There are no chats";
		}
		
		echo $result;
?>