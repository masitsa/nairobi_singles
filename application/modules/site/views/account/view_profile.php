<?php
	$prods = $profile_query->row();
	$client_username = $prods->client_username;
	$client_image = $this->profile_image_location.$prods->client_image;
	$client_id = $prods->client_id;
	$client_dob = $prods->client_dob;
	$age = $this->profile_model->calculate_age($client_dob);
	$client_looking_gender_id = $prods->client_looking_gender_id;
	$client_looking_gender_name = $this->profile_model->get_gender_name($client_looking_gender_id);
	$age_group_id = $prods->age_group_id;
	$encounter_name = $prods->encounter_name;
	$neighbourhood_name = $prods->neighbourhood_name;
	$gender_name = $prods->gender_name;
	$client_about = $prods->client_about;
	$mini_desc = implode(' ', array_slice(explode(' ', $client_about), 0, 10));
	$web_name = $this->profile_model->create_web_name($client_username);

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

//check if profile is liked
if($this->profile_model->is_profile_liked($current_client_id, $client_id))
{
	$like = '
			<a class="btn btn-default unlike" href="'.$client_id.'"> 
				<span class="add2cart"><i class="glyphicon glyphicon-heart"> </i> Unlike </span> 
			</a>
	';
	$like2 = '
			<a class="btn btn-default" href="'.site_url().'profile/unlike/'.$client_id.'/'.$web_name.'"> 
				<span class="add2cart"><i class="glyphicon glyphicon-heart"> </i> Unlike </span> 
			</a>
	';
}
else
{
	$like = '
			<a class="btn btn-primary like" href="'.$client_id.'"> 
				<span class="add2cart"><i class="glyphicon glyphicon-heart"> </i> Like </span> 
			</a>
	';
	$like2 = '
			<a class="btn btn-primary" href="'.site_url().'profile/like/'.$client_id.'/'.$web_name.'"> 
				<span class="add2cart"><i class="glyphicon glyphicon-heart"> </i> Like </span> 
			</a>
	';
}
					
if($account_balance > 0)
{
	$actions = '
		<div class="hide-mobile">
			<span id="like_section'.$client_id.'">'.$like.'</span>
		</div>
		
		<div class="show-mobile">
			<span id="like_section'.$client_id.'">'.$like2.'</span>
		</div>
			';
}

else
{
	$actions = '
			<a class="btn btn-warning" href="'.site_url().'credits"> 
				<span><i class="fa fa-money"></i> Top up chatcredits </span> 
			</a>';
}
?>

<div class="container main-container headerOffset"> 

	<?php echo $this->load->view('products/breadcrumbs');?>
    
    <div class="row">
    
		<?php echo $this->load->view('products/left_navigation');?>
        
        <!--right column-->
        <div class="col-lg-9 col-md-9 col-sm-12">
        	<?php
				//error messages
				if($this->session->userdata('error_message'))
				{
					?>
					<div class="alert alert-danger">
					  <?php 
						echo $this->session->userdata('error_message');
						$this->session->unset_userdata('error_message');
					  ?>
					</div>
					<?php
				}
				
				//success messages
				if($this->session->userdata('success_message'))
				{
					?>
					<div class="alert alert-success">
					  <?php 
						echo $this->session->userdata('success_message');
						$this->session->unset_userdata('success_message');
					  ?>
					</div>
					<?php
				}
			?>
        
            <div class="w100 clearfix category-top">
            	<h2> View <?php echo $receiver_username;?> </h2>
            </div><!--/.category-top-->
            
            <div id="view_profile">
            	<div class="row profile_details">
                	<!-- profile image -->
                	<div class="col-md-6">
                    	<img src="<?php echo $client_image;?>" alt="<?php echo $receiver_username;?>" class="img-responsive">
                    </div>
                	<!-- end profile image -->
                    
                	<!-- profile image -->
                	<div class="col-md-6">
                    	<h4><?php echo $receiver_username;?></h4>
                    	<p><?php echo $age;?> . <?php echo $gender_name;?> . <?php echo $neighbourhood_name;?></p>
                    	<p>Seeking <?php echo $client_looking_gender_name;?> for <?php echo $encounter_name;?></p>
                        <h5>About me</h5>
                    	<p><?php echo $client_about;?></p>
                        <div class="center-align"><?php echo $actions;?></div>
                    </div>
                	<!-- end profile image -->
                </div>
                
            	<div class="row profile_message">
                	<h3 class="center-align">Chat with <?php echo $receiver_username;?></h3>
                	<!-- messages -->
                	<div class="col-md-12">
                        <div id="view_message">
                            <?php echo $this->load->view('messages/message_details');?>
                        </div>
                    
                        <input type="hidden" id="ajax_receiver" value="<?php echo $receiver_id;?>" />
                        <input type="hidden" id="prev_message_count" value="<?php echo $received_messages;?>" />
                        <?php
                            echo form_open('site/profile/message_profile/1', array('class' => 'send_message2'));
                            echo form_hidden('receiver_id', $receiver_id);
                        ?>
                        <div class="form-group login-username">
                            <div >
                                <input type="text" name="client_message_details" id="instant_message2" class="form-control input instant-message" placeholder="Enter message" required="required" />
                                <?php echo $smiley_table; ?>
                            </div>
                        </div>
                        
                        <div >
                            <div >
                                <input name="submit" class="btn  btn-block btn-lg btn-primary" value="Send message" type="submit">
                            </div>
							
                            <div class="alert alert-warning" style="margin-top:10px;">
                            	<strong><i class="fa fa-lightbulb-o"></i> Safety tips</strong><br />
                                <ol>
                                	<li>1. Always meet in public places</li>
                                    <li>2. Never sent money to someone you don't know</li>
                                    <li>3. Be careful who share your personal contacts with</li>
                                </ol>
                            </div>
                        </div>
                        <?php echo form_close();?>
                    </div>
                	<!-- end messages -->
                </div>
            </div>
        
        </div><!--/right column end-->
    </div><!-- /.row  --> 
</div>
<!-- /main container -->

<div class="gap"> </div>