<div class="row  categoryProduct xsResponse clearfix">
      
      	<?php
        	if($profiles->num_rows() > 0)
			{
				$product = $profiles->result();
				
				foreach($product as $prods)
				{
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
					
					//check if profile is liked
					if($this->profile_model->is_profile_liked($current_client_id, $client_id))
					{
						$like = '
								<a class="btn btn-default unlike" href="'.$client_id.'"> 
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
					}
					
					echo
					'
					<div class="item col-sm-4 col-lg-4 col-md-4 col-xs-6">
						<div class="product">
							<div class="image"> 
								<a href="'.site_url().'browse/'.$web_name.'"><img src="'.$client_image.'" alt="img" class="img-responsive"></a>
							</div>
							
							<div class="description">
								<h4><a href="'.site_url().'browse/'.$web_name.'">'.$client_username.'</a></h4>
								'.$age.' year old '.$gender_name.' 
								<p>'.$mini_desc.'</p>
								<div style="margin-top: -20px;">
									<br/><strong>Seeking </strong>'.$client_looking_gender_name.' for '.$encounter_name.'
									<br/><strong>Location:</strong> '.$neighbourhood_name.'
								</div>
							</div>
							
							<div class="action-control">
								<span id="like_section">'.$like.'</span>
								<a class="btn btn-primary message" client_id="'.$client_id.' "data-toggle="modal"  data-dismiss="modal" href="#send-message"> 
									<span class="add2cart"><i class="glyphicon glyphicon-envelope"> </i> Message </span> 
								</a>
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