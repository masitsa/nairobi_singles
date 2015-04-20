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
                        <div class="avatar">
                            <img src="'.$image.'" class="img-responsive">
                        </div>
                        <div class="details">
                         <div class="profile-name"><a href="'.site_url().'browse/'.$web_name.'">'.$client_username.'</a></div>
                            <div class="profile-details">'.$age.' year old. '.$gender_name.' . '.$neighbourhood_name.'</div>
                            
                            <a href="#" class="btn btn-lg btn-primary"><i class="glyphicon glyphicon-heart"></i></a>
                            <a href="#" class="btn btn-lg btn-success"><i class="glyphicon glyphicon-envelope"></i></a>
                        </div>
                    </li>
			';
		}
	}
	
	else
	{
		echo 'There are no profiles :-(';
	}
?>