    <!-- Home content -->
	<div class="inner-content">
        <!-- Container -->
        <div class="container">
            <?php echo $this->load->view('site/includes/page_header');?>
        </div><!-- End Container -->
	</div><!-- End Home content -->
    
    <div class="home-sign-up">
    	<div class="container">
    		<!-- Sign in -->
        	<div class="row">
            	<div class="col-md-12">
                	<h2>Sign in</h2>
                </div>
            </div>
            
            <div class="center-align">
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
            </div>
        	<!-- Sign in -->
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
                        	<div class="col-md-6 col-md-offset-3">
                                
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
                                    <div class="col-sm-7 col-md-offset-5">
                                    	<button type="submit" class="btn btn-default join-button2">Sign in</button>
                                        <p class="center-align">
                                        <a href="<?php echo site_url().'forgot-password';?>" class="cupid">Forgot password</a>
                                        </p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-7 col-md-offset-5">
                                    	<div class="center-align">
                                            <p>Don't have an account?</p>
                                            <a href="<?php echo site_url();?>join" class="cupid">Join</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php echo form_close();?>
                </div><!-- End col-md-12 -->
            </div><!-- End row -->
        </div>
    </div>