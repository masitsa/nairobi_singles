          <div class="padd">
            <!-- Adding Errors -->
            <?php
            if(isset($error)){
                echo '<div class="alert alert-danger"> Oh snap! Change a few things up and try submitting again. </div>';
            }
			$first_name = $users[0]->first_name;
			$other_names = $users[0]->other_names;
			$email = $users[0]->email;
			$password = $users[0]->password;
			$phone = $users[0]->phone;
			$address = $users[0]->address;
			$post_code = $users[0]->post_code;
			$city = $users[0]->city;
			$user_level_id = $users[0]->user_level_id;
			$activated = $users[0]->activated;
			$country_id = $users[0]->country_id;
			$user_id = $users[0]->user_id;
            
            $validation_errors = validation_errors();
            
            if(!empty($validation_errors))
            {
                echo '<div class="alert alert-danger"> Oh snap! '.$validation_errors.' </div>';
				$first_name = set_value('first_name');
				$other_names = set_value('other_names');
				$email = set_value('email');
				$password = set_value('password');
				$phone = set_value('phone');
				$address = set_value('address');
				$post_code = set_value('post_code');
				$city = set_value('city');
				$user_level_id = set_value('user_level_id');
				$activated = set_value('activated');
				$country_id = set_value('country_id');
            }
            ?>
            
            <?php echo form_open('edit-user/'.$user_id, array("class" => "form-horizontal", "role" => "form"));?>
            <!-- First Name -->
            <div class="form-group">
                <label class="col-lg-4 control-label">First Name</label>
                <div class="col-lg-4">
                	<input type="text" class="form-control" name="first_name" placeholder="First Name" value="<?php echo $first_name;?>">
                </div>
            </div>
            <!-- Other Names -->
            <div class="form-group">
                <label class="col-lg-4 control-label">Other Names</label>
                <div class="col-lg-4">
                	<input type="text" class="form-control" name="other_names" placeholder="Other Names" value="<?php echo $other_names;?>">
                </div>
            </div>
            <!-- Email -->
            <div class="form-group">
                <label class="col-lg-4 control-label">Email</label>
                <div class="col-lg-4">
                	<input type="email" class="form-control" name="email" placeholder="Email" value="<?php echo $email;?>">
                </div>
            </div>
            <?php if(isset($admin_user)){ ?>
            <!-- Password -->
            <div class="form-group">
                <label class="col-lg-4 control-label">Current Password</label>
                <div class="col-lg-4">
                	<input type="hidden" class="form-control" name="admin_user" value="<?php echo $admin_user;?>">
                	<input type="hidden" class="form-control" name="old_password" value="<?php echo $password;?>">
                	<input type="password" class="form-control" name="current_password" placeholder="Password">
                </div>                
            </div>
            <div class="form-group">
                <label class="col-lg-4 control-label">New Password</label>
                <div class="col-lg-4">
                	<input type="password" class="form-control" name="new_password" placeholder="Password">
                </div>                
            </div>
            <?php } ?>
            <!-- Phone -->
            <div class="form-group">
                <label class="col-lg-4 control-label">Phone</label>
                <div class="col-lg-4">
                	<input type="text" class="form-control" name="phone" placeholder="Phone" value="<?php echo $phone;?>">
                </div>
            </div>
            <!-- Address -->
            <div class="form-group">
                <label class="col-lg-4 control-label">Address</label>
                <div class="col-lg-4">
                	<input type="text" class="form-control" name="address" placeholder="Address" value="<?php echo $address;?>">
                </div>
            </div>
            <!-- Postal Code -->
            <div class="form-group">
                <label class="col-lg-4 control-label">Postal Code</label>
                <div class="col-lg-4">
                	<input type="text" class="form-control" name="post_code" placeholder="Postal Code" value="<?php echo $post_code;?>">
                </div>
            </div>
            <!-- Country -->
            <div class="form-group">
                <label class="col-lg-4 control-label">Country</label>
                <div class="col-lg-4">
                	<?php 
		
					$return = '<select name="country_id" class="form-control">';
					
					//if users exist display them
					if ($countries->num_rows() > 0)
					{
						$result = $countries->result();
						
						foreach($result as $res)
						{
							if($country_id == $res->country_id)
							{
								$return .= '<option value="'.$res->country_id.'" selected>'.$res->country_name.'</option>';
							}
							
							else
							{
								$return .= '<option value="'.$res->country_id.'">'.$res->country_name.'</option>';
							}
						}
					}
					
					else
					{
						$return .= "<option>There are no countries</option>";
					}
					
					$return .= '</select>';
					
					echo $return;
					?>
                </div>
            </div>
            <!-- City -->
            <div class="form-group">
                <label class="col-lg-4 control-label">City</label>
                <div class="col-lg-4">
                	<input type="text" class="form-control" name="city" placeholder="City" value="<?php echo $city;?>">
                </div>
            </div>
            <!-- User Level -->
            <div class="form-group">
                <label class="col-lg-4 control-label">User Level</label>
                <div class="col-lg-4">
                    <select name="user_level_id" class="form-control">
                    	<?php
						if($user_level_id == 1){echo '<option value="1" selected>Admin</option><option value="2">Front End User</option>';}
						else{echo '<option value="1>Admin</option><option value="2" selected>Front End User</option>';}
						?>
                    </select>
                </div>
            </div>
            <!-- Activate checkbox -->
            <div class="form-group">
                <label class="col-lg-4 control-label">Activate User?</label>
                <div class="col-lg-4">
                    <div class="radio">
                        <label>
                        	<?php
                            if($activated == 1){echo '<input id="optionsRadios1" type="radio" checked value="1" name="activated">';}
							else{echo '<input id="optionsRadios1" type="radio" value="1" name="activated">';}
							?>
                            Yes
                        </label>
                    </div>
                    <div class="radio">
                        <label>
                        	<?php
                            if($activated == 0){echo '<input id="optionsRadios1" type="radio" checked value="0" name="activated">';}
							else{echo '<input id="optionsRadios1" type="radio" value="0" name="activated">';}
							?>
                            No
                        </label>
                    </div>
                </div>
            </div>
            <div class="form-actions center-align">
                <button class="submit btn btn-primary" type="submit">
                    Edit User
                </button>
            </div>
            <br />
            <?php echo form_close();?>
		</div>