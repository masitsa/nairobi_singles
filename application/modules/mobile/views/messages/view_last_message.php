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
			'<div class="message message-sent"><div class="message-text">'.$client_message_details.'</div><div class="messages-date">'.date('jS M Y',strtotime($created)).' <span>'.date('H:i a',strtotime($created)).'</span></div></div><div class="message message-sent message-pic"><div class="message-label">Delivered</div></div>';
		}
	}
}
?>