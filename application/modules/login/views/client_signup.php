<!-- Home content -->
<div class="inner-content">
    <!-- Container -->
    <div class="container">
    	
        <?php echo $this->load->view('site/includes/page_header');?>
        
    </div><!-- End Container -->
</div><!-- End Home content -->

<div class="home-sign-up">
    <div class="container">
    	<!-- Sign up -->
        	<div class="row">
            	<div class="col-md-12">
                	<h2>Create an account</h2>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-12">
                    <?php
                    	$attributes = array(
										'class' => 'form-horizontal',
										'role' => 'form',
									);
						echo form_open($this->uri->uri_string(), $attributes);
					?>
                    	<div class="row">
                        	<div class="col-md-6">
                                <div class="form-group">
                                    <label for="client_email" class="col-sm-5 control-label">Email <span class="required">*</span></label>
                                    <div class="col-sm-7">
                                    	<?php
											//case of an input error
                                        	if(!empty($client_email_error))
											{
												?>
                                                <input type="text" class="form-control alert-danger" name="client_email" placeholder="<?php echo $client_email_error;?>" onFocus="this.value = '<?php echo $client_email;?>';">
                                                <?php
											}
											
											else
											{
												?>
                                                <input type="text" class="form-control" name="client_email" placeholder="Email" value="<?php echo $client_email;?>">
                                                <?php
											}
										?>
                                    </div>
                                </div>
                                
                            	<div class="form-group">
                                    <label for="client_username" class="col-sm-5 control-label">Username <span class="required">*</span></label>
                                    <div class="col-sm-7">
                                    	<?php
											//case of an input error
                                        	if(!empty($client_username_error))
											{
												?>
                                                <input type="text" class="form-control alert-danger" name="client_username" placeholder="<?php echo $client_username_error;?>" onFocus="this.value = '<?php echo $client_username;?>';">
                                                <?php
											}
											
											else
											{
												?>
                                                <input type="text" class="form-control" name="client_username" placeholder="Username" value="<?php echo $client_username;?>">
                                                <?php
											}
										?>
                                    </div>
                                </div>
                            </div>
                            
                        	<div class="col-md-6">
                                 <div class="form-group">
                                    <label for="client_password" class="col-sm-5 control-label">Password <span class="required">*</span></label>
                                    <div class="col-sm-7">
                                        <?php
                                            //case of an input error
                                            if(!empty($client_password_error))
                                            {
                                                ?>
                                                <input type="password" class="form-control alert-danger" name="client_password" placeholder="<?php echo $client_password_error;?>" onFocus="this.value = '<?php echo $client_password;?>';">
                                                <?php
                                            }
                                            
                                            else
                                            {
                                                ?>
                                                <input type="password" class="form-control" name="client_password" placeholder="Password" value="<?php echo $client_password;?>">
                                                <?php
                                            }
                                        ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="confirm_password" class="col-sm-5 control-label">Confirm password <span class="required">*</span></label>
                                    <div class="col-sm-7">
                                    	<?php
											//case of an input error
                                        	if(!empty($confirm_password_error))
											{
												?>
                                                <input type="password" class="form-control alert-danger" name="confirm_password" placeholder="<?php echo $confirm_password_error;?>" onFocus="this.value = '<?php echo $confirm_password;?>';">
                                                <?php
											}
											
											else
											{
												?>
                                                <input type="password" class="form-control" name="confirm_password" placeholder="Confirm password" value="<?php echo $confirm_password;?>">
                                                <?php
											}
										?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                        	<div class="col-md-12">
                            	
                                <div class="center-align checkbox">
									<?php
                                        //case of an input error
                                        if(!empty($client_agree_error))
                                        {
                                            ?>
                                            <div class="required">You must agree to our terms of service</div>
                                            <?php
                                        }
                                        
                                        ?>
                                        <div class="checkbox">
                                            
                                            <label>
                                                <input type="checkbox" name="client_agree"> By clicking Join, you agree to our terms and conditions of service and you agree that you are at least 18 years or older  today.
                                            </label>
                                        </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-12">
                            	<div class="center-align">
                                    <button type="submit" class="btn btn-default join-button">Join</button>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row" style="margin-top:20px;">
                            <div class="col-md-12">
                            	<div class="center-align">
                                	<p>already have an account?</p>
                                    <a href="<?php echo site_url().'sign-in';?>" class="cupid">Sign in</a>
                                </div>
                            </div>
                        </div>
                    <?php echo form_close();?>
                </div><!-- End col-md-12 -->
            </div><!-- End row -->
    </div>
</div>
        