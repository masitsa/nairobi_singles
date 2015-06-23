<?php
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
	
	if($total_messages > 0)
	{
		//last message
		$r = $total_messages - 1;
		
		$message_data = $messages[$r];
		$sender = $message_data->client_id;
		$receiver = $message_data->receiver_id;
		$created = $message_data->created;
		$client_message_details = $this->profile_model->convert_smileys($message_data->client_message_details, $smiley_location);
		
		//if I am the one receiving align left
		if($sender == $client_id)
		{
			echo 
			'
			<li class="row">
				<div class="col-xs-3">
					<img src="'.$client_thumb.'" class="img-responsive">
				</div>
				
				<div class="col-xs-9">
					<div class="bubble-left">
						<div>'.$client_message_details.'</div>
						
						<div class="message-date">'.date('jS M Y H:i a',strtotime($created)).'</div>
					</div>
				</div>
			</li>
			';
		}
	}
}
?>