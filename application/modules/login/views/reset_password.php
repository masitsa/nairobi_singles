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
                	<h2>Forgot password</h2>
                </div>
            </div>
            
            <p class="center-align"> To reset your password, enter the email address you use to sign in to site. We will then send you a new password. </p>
			<?php
				$error = $this->session->userdata('error_message');
				
				if(!empty($error))
				{
					?>
                        <div class="alert alert-danger">
                            <p>
								<?php 
									echo $error;
									$this->session->unset_userdata('error_message');
                                ?>
                            </p>
                        </div>
					<?php
            	}
            ?>
            
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
                        	<div class="col-md-7 col-md-offset-1">
                                
                                <div class="form-group">
                                    <label for="client_email" class="col-md-5 col-sm-3 control-label">Email <span class="required">*</span></label>
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
                                    <div class="col-md-7 col-md-offset-5 col-sm-7 col-sm-offset-3">
                                    	<button type="submit" class="btn btn-default join-button2">Reset password</button>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-7 col-md-offset-5 col-sm-7 col-sm-offset-3">
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
<?php echo $this->load->view('site/home/security', '', TRUE);?>