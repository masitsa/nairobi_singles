<?php
	//get receiver details
	if($receiver->num_rows() > 0)
	{
		$row = $receiver->row();
		$receiver_username = $row->client_username;
		$receiver_thumb = $profile_image_location.$row->client_thumb;
		$receiver_id = $row->client_id;
	}
	
	//get client details
	if($sender->num_rows() > 0)
	{
		$row = $sender->row();
		$client_username = $row->client_username;
		$client_thumb = $profile_image_location.$row->client_thumb;
		$client_id = $row->client_id;
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
			<li>
            	<img src="'.$receiver_thumb.'" class="img-responsive pull-left">
                
                <div class="bubble-left">
                	'.$client_message_details.'
                    <div class="message-date pull-right">'.date('jS M Y H:i a',strtotime($created)).'</div>
                </div>
            </li>
			';
		}
		
		//align right
		else
		{
			echo 
			'
				<li>
                    <div class="bubble">
                    	'.$client_message_details.'
                        <div class="message-date pull-left">'.date('jS M Y H:i a',strtotime($created)).'</div>
                    </div>
                    
                	<img src="'.$client_thumb.'" class="img-responsive pull-right">
                </li>
			';
		}
	}
}
?>
