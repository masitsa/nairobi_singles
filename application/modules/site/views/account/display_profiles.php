<div class="row  categoryProduct xsResponse clearfix">
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
      
      	<?php
        	if($profiles->num_rows() > 0)
			{
				$product = $profiles->result();
				
				foreach($product as $prods)
				{
					$client_username = $prods->client_username;
					$client_image = $prods->client_image;
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
					$image = $this->profile_model->image_display($profile_image_path, $profile_image_location, $client_image);
					$time_difference = $this->profile_model->check_online($client_id);
					
					//check if user is online
					if(!empty($time_difference) && ($time_difference <= 10))
					{
						$online = '<span class="badge online">Online</span>';
					}
					else
					{
						$online = '<span class="badge offline">Offline</span>';
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
								<a class="btn btn-default" href="'.site_url().'profile/unlike/'.$client_id.'"> 
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
								<a class="btn btn-primary" href="'.site_url().'profile/like/'.$client_id.'"> 
									<span class="add2cart"><i class="glyphicon glyphicon-heart"> </i> Like </span> 
								</a>
						';
					}
					
					if($account_balance > 0)
					{
						$actions = '
							<div class="hide-mobile">
								<span id="like_section'.$client_id.'">'.$like.'</span>
								<a class="btn btn-success message" client_id="'.$client_id.' "data-toggle="modal"  data-dismiss="modal" href="#send-message"> 
									<span class="add2cart"><i class="glyphicon glyphicon-envelope"> </i> Message </span> 
								</a>
							</div>
							
							<div class="show-mobile">
								<span id="like_section'.$client_id.'">'.$like2.'</span>
								<a class="btn btn-success" href="'.site_url().'messages/inbox/'.$web_name.'"> 
									<span class="add2cart"><i class="glyphicon glyphicon-envelope"> </i> Message </span> 
								</a>
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
					
					//number to display per line
					if(isset($like_section))
					{
						$number = '<div class="item col-sm-6 col-lg-3 col-md-3 col-xs-12">';
					}
					
					else
					{
						$number = '<div class="item col-sm-4 col-lg-4 col-md-4 col-xs-6">';
					}
					
					echo
						$number.'
						<div class="product">
							<div class="image"> 
								<a href="'.site_url().'browse/'.$web_name.'"><img src="'.$image.'" alt="img" class="img-responsive"></a>
								'.$online.'
							</div>
							
							<div class="description">
								<h4><a href="'.site_url().'browse/'.$web_name.'">'.$client_username.'</a></h4>
								'.$age.' year old '.$gender_name.' 
								<p>'.$mini_desc.'</p>
								<div style="margin-top: -20px; min-height: 100px;">
									<br/><strong>Seeking </strong>'.$client_looking_gender_name.' for '.$encounter_name.'
									<br/><strong>Location:</strong> '.$neighbourhood_name.'
								</div>
							</div>
							
							<div class="action-control">
								'.$actions.'
							</div>
						</div>
					</div><!--/.item-->
					';
				}
			}
			
			else
			{
				echo 'There are no profiles :-(';
			}
		?>
    </div> <!--/.categoryProduct || product content end-->
      
      <div class="w100 categoryFooter">
        <div class="pagination pull-left no-margin-top">
          <?php if(isset($links)){echo $links;}?>
        </div>
        <div class="pull-right pull-right col-sm-4 col-xs-12 no-padding text-right text-left-xs">
          <p>Showing <?php echo $first;?>–<?php echo $last;?> of <?php echo $total;?> results</p>
        </div>
      </div> <!--/.categoryFooter-->