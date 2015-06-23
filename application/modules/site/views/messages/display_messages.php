
	<div class="row  categoryProduct xsResponse clearfix">
        

      <div class="col-md-12">
            
            <button type="button" class="btn btn-default" data-toggle="tooltip" title="Refresh">
                   <span class="glyphicon glyphicon-refresh"></span>   </button>
            
            <div class="pull-right">
                <span class="text-muted"><b><?php echo $first;?></b>–<b><?php echo $last;?></b> of <b><?php echo $total;?></b></span>
                <div class="btn-group btn-group-sm">
                    <button type="button" class="btn btn-default">
                        <span class="glyphicon glyphicon-chevron-left"></span>
                    </button>
                    <button type="button" class="btn btn-default">
                        <span class="glyphicon glyphicon-chevron-right"></span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <hr />
    
    <div class="row">
        
        <div class="col-md-12">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs">
                <li class="active"><a href="#home" data-toggle="tab"><span class="glyphicon glyphicon-inbox">
                </span>Primary</a></li>
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
                	<div class="list-group">
                    	<?php
							$last_chatted = '';
                            if($messages->num_rows() > 0)
                            {
                                $message = $messages->result();
                                
                                foreach($message as $mes)
                                {
									$unread = 0;
                                    $client_id = $mes->client_id;
                                    $receiver_id = $mes->receiver_id;
                                    $created = $mes->created;
                                    //$last_chatted = $mes->last_chatted;
                                    $message_file_name = $mes->message_file_name;
									
                                    if($client_id == $current_client_id)
                                    {
                                        $receiver_query = $this->profile_model->get_client($receiver_id);
										$sent_messages = $this->profile_model->get_messages($current_client_id, $receiver_id, $this->messages_path);
                                    }
                                    else
                                    {
                                        $receiver_query = $this->profile_model->get_client($client_id);
										$sent_messages = $this->profile_model->get_messages($current_client_id, $client_id, $messages_path);
                                    }
									
									//message details
									$mini_msg = '';
									if(is_array($sent_messages))
									{
										$total_messages = count($sent_messages);
										$last_message = $total_messages - 1;
										
										if($total_messages > 0)
										{
											$message_data = $sent_messages[$last_message];
											$client_message_details = $message_data->client_message_details;
											$check_receiver_id = $message_data->receiver_id;
											$last_chatted = $message_data->created;
											$mini_msg = implode(' ', array_slice(explode(' ', $client_message_details), 0, 10));
										
											//bold unread messages
											if($check_receiver_id == $current_client_id)
											{
												$unread = 1;
											}
										}
									}
                                    $today_check = date('jS M Y',strtotime($last_chatted));
                                    $today = date('jS M Y',strtotime(date('Y-m-d')));
                                    
                                    //if today display time
                                    if($today_check == $today)
                                    {
                                        $date_display = date('H:i a',strtotime($last_chatted));
                                    }
                                    else
                                    {
                                        $date_display = date('jS M Y',strtotime($last_chatted));
                                    }
                                    
                                    //get receiver details
                                    $prods = $receiver_query->row();
                                    $client_image = $this->profile_image_location.$prods->client_thumb;
                                    $client_dob = $prods->client_dob;
                                    $client_username = $prods->client_username;
                                    $age = $this->profile_model->calculate_age($client_dob);
									$web_name = $this->profile_model->create_web_name($client_username);
									
									if($unread == 1)
									{
										$client_username = '<strong>'.$client_username.'</strong>';
										$mini_msg = '<strong>'.$mini_msg.'</strong>';
									}
                                    
                                    echo
                                    '
                                    
                                    <a href="'.site_url().'messages/inbox/'.$web_name.'" class="list-group-item">
                                        <div class="checkbox" style="float:left;">
                                            <label>
                                                <input type="checkbox">
                                            </label>
                                        </div>
                                        <!--<span class="glyphicon glyphicon-star-empty"></span>-->
                                        <span class="message-image">
											<img src="'.$client_image.'" alt="img" class="img-responsive">
										</span> 
                                        <span class="name" style="min-width: 120px; display: inline-block;">
											'.$client_username.'						
										</span> 
                                        <span class="">'.$mini_msg.'</span>
                                        <!--<span class="text-muted" style="font-size: 11px;">- Hi hello how r u ?</span> -->
                                        <span class="badge">'.$date_display.'</span> 
                                        <!--<span class="pull-right"><span class="glyphicon glyphicon-paperclip"></span></span>-->
                                    </a>
                                    ';
                                }
                            }
                            
                            else
                            {
                                echo 'There are no messages :-(';
                            }
                        ?>
                    </div>
                </div>
                <div class="tab-pane fade in" id="profile">
                    <div class="list-group">
                        <div class="list-group-item">
                            <span class="text-center">This tab is empty.</span>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade in" id="messages">
                    ...</div>
                <div class="tab-pane fade in" id="settings">
                    This tab is empty.</div>
            </div>
            
        </div>
    </div>
    </div> <!--/.categoryProduct || product content end-->
      
      <div class="w100 categoryFooter">
        <div class="pagination pull-left no-margin-top">
          <?php if(isset($links)){echo $links;}?>
        </div>
        <div class="pull-right pull-right col-sm-4 col-xs-12 no-padding text-right text-left-xs">
          <p>Showing <?php echo $first;?>–<?php echo $last;?> of <?php echo $total;?> results</p>
        </div>
      </div> <!--/.categoryFooter-->