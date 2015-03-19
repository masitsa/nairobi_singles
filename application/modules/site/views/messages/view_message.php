<?php
	//get receiver details
	if($receiver->num_rows() > 0)
	{
		$row = $receiver->row();
		$receiver_username = $row->client_username;
		$receiver_id = $row->client_id;
	}
?>
<div class="container main-container headerOffset"> 
  
    <div class="row">
    	
  		<?php echo $this->load->view('products/left_navigation');?>
        
        <!--right column-->
        <div class="col-lg-9 col-md-9 col-sm-12">
        	<div class="row  categoryProduct xsResponse clearfix">
        
              <div class="col-md-6">
                    <h2>Chat history with <?php echo $receiver_username;?></h2>
              </div>
        
              <div class="col-md-6">
                    <button type="button" class="btn btn-default pull-right" data-toggle="tooltip" title="Refresh">
                           <span class="glyphicon glyphicon-refresh"></span>   
                    </button>
               </div>
            </div>
            <hr />
            <div class="row">
                <div class="col-md-12">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#home" data-toggle="tab"><span class="glyphicon glyphicon-inbox">
                        </span>Messages</a></li>
                        <!--<li><a href="#profile" data-toggle="tab"><span class="glyphicon glyphicon-user"></span>
                            Social</a></li>
                        <li><a href="#messages" data-toggle="tab"><span class="glyphicon glyphicon-tags"></span>
                            Promotions</a></li>
                        <li><a href="#settings" data-toggle="tab"><span class="glyphicon glyphicon-plus no-margin">
                        </span></a></li>-->
                    </ul>
                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div class="tab-pane fade in active" id="home">
                            <!-- Previous Messages -->
    						<div id="view_message">
                            	<?php echo $this->load->view('messages/message_details');?>
                            </div>
                            <input type="hidden" id="ajax_receiver" value="<?php echo $receiver_id;?>" />
                            <input type="hidden" id="prev_message_count" value="<?php echo $received_messages;?>" />
                            <?php
								echo form_open('site/profile/message_profile/1', array('class' => 'send_message2', 'id' => 'compose_message'));
								echo form_hidden('receiver_id', $receiver_id);
							?>
							<div class="form-group login-username">
								<div >
									<textarea name="client_message_details" id="instant_message2" class="form-control input"  size="20" placeholder="Enter message" required="required"></textarea>
                                    <?php echo $smiley_table; ?>
								</div>
							</div>
							
							<div >
								<div >
									<input name="submit" class="btn  btn-block btn-lg btn-primary" value="Send message" type="submit">
								</div>
							</div>
							<?php echo form_close();?>
                        </div>
                        <!--<div class="tab-pane fade in" id="profile">
                            <div class="list-group">
                                <div class="list-group-item">
                                    <span class="text-center">This tab is empty.</span>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade in" id="messages">
                            ...</div>
                        <div class="tab-pane fade in" id="settings">
                            This tab is empty.</div> -->
                    </div>
                    
                </div>
            </div>
            </div> <!--/.categoryProduct || product content end-->
        
        </div><!--/right column end-->
    </div><!-- /.row  --> 
</div>
<!-- /main container -->

<div class="gap"> </div>
<script type="text/javascript">

	$(document).ready(function() {
		
		//keep div scrolled at the bottom
		var objDiv = document.getElementById("scrollable-messages2");
		objDiv.scrollTop = objDiv.scrollHeight;

		//check if new messages have been sent
		var receiver_id = $('#ajax_receiver').val();
		
		(function worker() {
			var prev_message_count = parseInt($('#prev_message_count').val());//count the number of messages displayed
			
			$.ajax({
				url: '<?php echo site_url();?>site/profile/send_message/'+receiver_id+'/NULL /1', 
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
					setTimeout(worker, 5000);
				}
				});
			})();
	});
</script>