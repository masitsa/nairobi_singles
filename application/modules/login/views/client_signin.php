    <!-- Home content -->
    <div class="home-content">
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
                    <?php
                    	$attributes = array(
										'class' => 'form-horizontal',
										'role' => 'form',
									);
						echo form_open($this->uri->uri_string(), $attributes);
					?>
                    	<div class="row">
                        	<div class="col-md-6 col-md-offset-3">
                            	<p class="center-align">Please sign in to be able to browse matches.</p>
                                
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
                                    	<button type="submit" class="btn btn-default join-button">Sign in</button>
                                        <div class="center-align">
                                            <p>Don't have an account?</p>
                                            <a href="<?php echo site_url();?>" class="cupid">Sign up</a>
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