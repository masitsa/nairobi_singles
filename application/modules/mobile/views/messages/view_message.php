<?php
	//get receiver details
	if($receiver->num_rows() > 0)
	{
		$row = $receiver->row();
		$receiver_username = $row->client_username;
		$receiver_thumb = $row->client_thumb;
		$receiver_thumb = $this->profile_model->image_display($profile_image_path, $profile_image_location, $receiver_thumb);
		$receiver_id = $row->client_id;
	}
	
	//get client details
	if($sender->num_rows() > 0)
	{
		$row = $sender->row();
		$client_username = $row->client_username;
		$client_thumb = $row->client_thumb;
		$client_id = $row->client_id;
		$client_thumb = $this->profile_model->image_display($profile_image_path, $profile_image_location, $client_thumb);
	}
?>

<?php
//var_dump($messages);

if(is_array($messages))
{
	$total_messages = count($messages);
	
	for($r = 0; $r < $total_messages; $r++)
	{
		$message_data = $messages[$r];
		$sender = $message_data->client_id;
		$receiver = $message_data->receiver_id;
		$created = $message_data->created;
		$client_message_details = $this->profile_model->convert_smileys($message_data->client_message_details, $smiley_location);
		
		//if I am the one receiving align left
		if($receiver == $client_id)
		{
			echo 
			'
			<div class="messages-date">'.date('jS M Y',strtotime($created)).' <span>'.date('H:i a',strtotime($created)).'</span></div>
			<div class="message message-with-avatar message-last message-received">
				<div class="message-name">'.$receiver_username.'</div>
				<div class="message-text">'.$client_message_details.'</div>
				<div style="background-image:url('.$receiver_thumb.')" class="message-avatar"></div>
			</div>
			
			<!--<li class="row">
				<div class="col-xs-3">
					<img src="'.$receiver_thumb.'" class="img-responsive">
				</div>
				
				<div class="col-xs-9">
					<div class="bubble-left">
						<div>'.$client_message_details.'</div>
						
						<div class="message-date">'.date('jS M Y H:i a',strtotime($created)).'</div>
					</div>
				</div>
			</li>-->
			';
		}
		
		//align right
		else
		{
			echo 
			'
				<div class="messages-date">'.date('jS M Y',strtotime($created)).' <span>'.date('H:i a',strtotime($created)).'</span></div>
				<div class="message message-sent">
					<div class="message-text">'.$client_message_details.'</div>
				</div>
				
				<div class="message message-sent message-pic">
					<div class="message-text"><img src="http://lorempixel.com/300/300/"></div>
					<div class="message-label">Delivered</div>
				</div>
				
				<!--<li class="row">
					<div class="col-xs-9">
						<div class="bubble">
							<div>'.$client_message_details.'</div>
							<div class="message-date">'.date('jS M Y H:i a',strtotime($created)).'</div>
						</div>
					</div>
					
					<div class="col-xs-3">
						<img src="'.$client_thumb.'" class="img-responsive">
					</div>
				</li>-->
			';
		}
	}
}
?>
