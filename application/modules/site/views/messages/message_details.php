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
	<div class="row">
    	<div class="col-md-12">
    		<div class="scrollable-messages" id="scrollable-messages2">
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
								<div class="row">
									<div class="col-md-2 col-sm-2 col-xs-2">
										<img src="'.$receiver_thumb.'" class="img-responsive profile-image">
									</div>
									
									<div class="col-md-8 col-md-offset-2 col-sm-8 col-sm-offset-2 col-xs-8 col-xs-offset-2 bubble-left">
										'.$client_message_details.'
										<div class="message-date pull-right">'.date('jS M Y H:i a',strtotime($created)).'</div>
									</div>
								</div>
							';
						}
						
						//align right
						else
						{
							echo 
							'
								<div class="row">
									<div class="col-md-8 col-md-offset-2 col-sm-8 col-sm-offset-2 col-xs-8 col-xs-offset-2 bubble">
										<div>'.$client_message_details.'</div>
										<div class="message-date pull-right">'.date('jS M Y H:i a',strtotime($created)).'</div>
									</div>
									<div class="col-md-2 col-sm-2 col-xs-2">
										<img src="'.$client_thumb.'" class="img-responsive profile-image">
									</div>
								</div>
							';
						}
					}
                }
                ?>
            </div>
    	</div>
    </div>
    <div class="center-align" id="send_error"></div>
    
	<script type="text/javascript">
	
//keep div scrolled at the bottom
var objDiv2 = document.getElementById("scrollable-messages2");
objDiv2.scrollTop = objDiv2.scrollHeight;
	</script>