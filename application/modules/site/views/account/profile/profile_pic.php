        <!-- Jasny -->
        <link rel="stylesheet" href="<?php echo base_url();?>assets/themes/jasny/css/jasny-bootstrap.css">
        <script type="text/javascript" src="<?php echo base_url();?>assets/jasny/jasny-bootstrap.js"></script> 
<div class="row">
    <div class="col-sm-6">
        <div class="panel panel-default">
            <div class="panel-heading"><a href="#" class="pull-right">View all</a> <h4>Newest Items</h4></div>
            <div class="panel-body">
                <?php
					$attributes = array(
									'class' => 'form-horizontal',
									'role' => 'form',
								);
					echo form_open_multipart($this->uri->uri_string(), $attributes);
				?>
                <div class="fileinput fileinput-new" data-provides="fileinput">
                    <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="cursor:pointer;">
                        <img src="<?php echo $vendor_logo_location;?>" class="img-responsive">
                    </div>
                    <div>
                        <span class="btn btn-file btn-primary"><span class="fileinput-new">Click here to upload image</span><span class="fileinput-exists">Change</span><input type="file" name="vendor_logo"></span>
                        <a href="#" class="btn btn-success fileinput-exists" data-dismiss="fileinput">Remove</a>
                    </div>
                </div>
                <div class="row center-align">
                        <div class="col-sm-12">
                            <a href="<?php echo site_url().'vendor/sign-up/personal-details';?>">Back</a>
                            <button type="submit" class="btn btn-red">Continue</button>
                            <p>already have an account?</p>
                            <a href="<?php echo site_url().'sign-in';?>">Sign In</a>
                        </div>
                    </div>
                <?php echo form_close();?>
            </div><!--/panel-body-->
        </div><!--/panel-->
    </div><!--/col-->
</div><!--/row-->
                