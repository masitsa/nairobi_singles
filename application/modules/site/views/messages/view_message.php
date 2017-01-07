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
                    <a href="<?php echo site_url().$this->uri->uri_string();?>" class="btn btn-default pull-right" data-toggle="tooltip" title="Refresh">
                           <span class="glyphicon glyphicon-refresh"></span>   
                    </a>
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
							//if($account_balance > 0)
							if(1 > 0)
							{
								
								echo form_open('site/profile/message_profile/1', array('class' => 'send_message2', 'id' => 'compose_message'));
								echo form_hidden('receiver_id', $receiver_id);
								echo form_hidden('web_name', $web_name);
							?>
							<div class="form-group login-username">
								<div >
                                	<input type="text" name="client_message_details" id="instant_message2" class="form-control input instant-message" placeholder="Enter message" required="required" />
                                    <?php echo $smiley_table; ?>
								</div>
							</div>
							
                            <input name="submit" class="btn btn-block btn-lg btn-primary" value="Send message" type="submit">
							
                            <div class="alert alert-warning" style="margin-top:10px;">
                            	<strong><i class="fa fa-lightbulb-o"></i> Safety tips</strong><br />
                                <ol>
                                	<li>1. Always meet in public places</li>
                                    <li>2. Never sent money to someone you don't know</li>
                                    <li>3. Be careful who share your personal contacts with</li>
                                </ol>
                            </div>
							<?php 
							echo form_close();
							}
							
							else
							{
								?>
                                <a class="btn btn-block btn-lg btn-warning" href="<?php echo site_url().'credits';?>"><span><i class="fa fa-money"></i> Top up chatcredits</span> </a>
                                <?php
							}
							
							?>
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
		
		(function message_cheker() {
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