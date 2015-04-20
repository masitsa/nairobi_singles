<div class="row">
	<div class="col-md-12">
    	<a href="<?php echo site_url().'all-messages';?>" class="btn btn-primary pull-right">Back to messages</a>
    </div>
</div>
<div id="view_message">
	<?php echo $this->load->view('site/messages/message_details');?>
</div>
<input type="hidden" id="ajax_receiver" value="<?php echo $receiver_id;?>" />
<input type="hidden" id="prev_message_count" value="<?php echo $received_messages;?>" />

<script type="text/javascript">

	$(document).ready(function() {
		
		//keep div scrolled at the bottom
		var objDiv = document.getElementById("scrollable-messages2");
		objDiv.scrollTop = objDiv.scrollHeight;

		//check if new messages have been sent
		var receiver_id = $('#ajax_receiver').val();
		
		(function message_cheker() {
			var prev_message_count = parseInt($('#prev_message_count').val());//count the number of messages displayed
			
			$.ajax({
				url: '<?php echo site_url();?>admin/messages/send_message/'+receiver_id+'/1', 
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
						$("#view_message").html(data.messages);
						
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
					setTimeout(message_cheker, 2000);
				}
				});
			})();
	});
</script>