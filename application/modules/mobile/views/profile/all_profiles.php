<?php
	if($profiles->num_rows() > 0)
	{
		$product = $profiles->result();
		
		foreach($product as $prods)
		{
			$client_username = $prods->client_username;
			$client_image = $prods->client_thumb;
			$client_id = $prods->client_id;
			$client_dob = $prods->client_dob;
			$age = $this->profile_model->calculate_age($client_dob);
			$client_looking_gender_id = $prods->client_looking_gender_id;
			$client_looking_gender_name = $this->profile_model->get_gender_name($client_looking_gender_id);
			$age_group_id = $prods->age_group_id;
			$encounter_name = $prods->encounter_name;
			//$neighbourhood_name = $prods->neighbourhood_name;
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
							<i class="fa fa-heart-o"></i> 
						</a>
				';
			}
			
			if($account_balance > 0)
			{
				$actions = '<a class="btn btn-primary" href="#" onclick="like_profile(\''.$web_name.'\')"><i class="fa fa-heart-o"></i></a>';
			}
			
			else
			{
				$actions = '<a class="btn btn-warning" href="'.site_url().'credits"><span><i class="fa fa-money"></i> Top up chatcredits </span></a>';
			}
			$number = '';
			//number to display per line
			// if(isset($like_section))
			// {
			// 	$number = '<div class="item col-sm-6 col-lg-3 col-md-3 col-xs-12">';
			// }
			
			// else
			// {
			// 	$number = '<div class="item col-sm-4 col-lg-4 col-md-4 col-xs-6">';
			// }
			
			echo
				$number.'
					<li>
						<div class="row">
							<div class="col-25" style="max-height:80px; max-width:80px; overflow:hidden;">
								<a class="item-link item-content" href="pages/chat.html?web_name='.$web_name.'">
									<img src="'.$image.'">
								</a>
							</div>
							
							<div class="col-75">
								<div class="item-inner blog-list">
									<div class="row" style="width:100%;">
										<div class="col-60">
											<a class="item-link item-content" href="pages/chat.html?web_name='.$web_name.'">
												<div class="text">
													<h4 class="title mt-5 mb-0">'.$client_username.'</h4>
													<p>'.$age.' year old. '.$gender_name.' . Looking for '.$encounter_name.'</p>
												</div>
											</a>
										</div>
									
										<div class="col-40">
											<a class="button button-secondary" href="#" onclick="like_profile(\''.$web_name.'\')"><i class="fa fa-heart-o"></i> Like</a>
										</div>
									</div>
								</div>
							</div>
						</div>
						
					</li>
			';
		}
	}
	
	else
	{
		if(!isset($like_section))
		{
			echo ' We are unable to find any profiles that match your preferences. Please update them';
		}
		
		else if($like_section == 1)
		{
			echo 'You have no profile likes yet. Try liking a few profiles first by clicking the like button <br>
			<a href="#" class="btn btn-lg btn-primary center-align" style="width:50%;"><i class="glyphicon glyphicon-heart"></i></a>';
		}
		
		else
		{
			echo 'You have not liked any profiles yet. Take the first step. Like a profile by clicking the like button <br>
			<a href="#" class="btn btn-lg btn-primary center-align" style="width:50%;"><i class="glyphicon glyphicon-heart"></i></a>';
		}
	}
?>