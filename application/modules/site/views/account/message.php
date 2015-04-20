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
<input type="hidden" id="ajax_receiver" value="<?php echo $receiver_id;?>" />
<input type="hidden" id="prev_message_count" value="<?php echo $received_messages;?>" />
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"> &times; </button>
    <h3 class="modal-title-site text-center" > Message <?php echo $receiver_username;?></h3>
</div>

<div class="modal-body">
    
    <!-- Previous Messages -->
    <div id="modal_messages">
    	<?php echo $this->load->view('modal_messages');?>
    </div>
    
     <?php
	if($account_balance > 0)
	{
		
    	echo form_open('site/profile/message_profile/2', array('class' => 'send_message'));
		echo form_hidden('receiver_id', $receiver_id);
	?>
    <div class="form-group login-username">
        <div >
            <input type="text" name="client_message_details" id="instant_message" class="form-control input instant-message" placeholder="Enter message" required="required" />
            <?php echo $smiley_table; ?>
        </div>
    </div>
    
    <div >
        <div >
        	<input name="submit" class="btn  btn-block btn-lg btn-primary" value="Send message" type="submit">
							
            <div class="alert alert-warning" style="margin-top:10px;">
                <strong><i class="fa fa-lightbulb-o"></i> Safety tips</strong><br />
                <ol>
                    <li>1. Always meet in public places</li>
                    <li>2. Never sent money to someone you don't know</li>
                    <li>3. Be careful who share your personal contacts with</li>
                </ol>
            </div>
        </div>
    </div>
    <!--userForm--> 
	<?php echo form_close();
	}
	
	else
	{
		?>
		<a class="btn btn-block btn-lg btn-warning" href="<?php echo site_url().'credits';?>"><span><i class="fa fa-money"></i> Top up chatcredits</span> </a>
		<?php
	}
	
	?>
</div>
<div class="modal-footer">
    <!--<p class="text-center"> Not here before? <a data-toggle="modal"  data-dismiss="modal" href="#ModalSignup"> Sign Up. </a> <br>
    <a href="forgot-password.html" > Lost your password? </a> </p>-->
</div>
<script type="text/javascript">
	$(document).ready(function() {
		
		//keep div scrolled at the bottom
		var objDiv = document.getElementById("scrollable-messages");
		objDiv.scrollTop = objDiv.scrollHeight;

		//check if new messages have been sent
		var receiver_id = $('#ajax_receiver').val();
		
		(function worker() {
			var prev_message_count = parseInt($('#prev_message_count').val());//count the number of messages displayed
			
			$.ajax({
				url: '<?php echo site_url();?>site/profile/send_message/'+receiver_id+'/1', 
				cache:false,
				contentType: false,
				processData: false,
				dataType: 'json',
				success: function(data) 
				{
					var curr_message_count = parseInt(data.curr_message_count);//count the number of messages received
					
					//if there is a new message
					if(curr_message_count != prev_message_count)
					{
						$('#prev_message_count').val(curr_message_count);
						//display new message
						$("#modal_messages").html(data.messages);
						
						//play message tone
						var new_message = document.getElementById("new_message");
						if (new_message.paused !== true)
						{
							new_message.pause();
						}
						else
						{
							new_message.play();
						}
					}

				},
				complete: function() 
				{
					// Schedule the next request when the current one's complete
					setTimeout(worker, 2000);
				}
				});
			})();
	});
</script>
