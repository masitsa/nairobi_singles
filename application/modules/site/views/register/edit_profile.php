<link rel="stylesheet" href="<?php echo base_url();?>assets/themes/jasny/css/jasny-bootstrap.css">
<script type="text/javascript" src="<?php echo base_url();?>assets/jasny/jasny-bootstrap.js"></script> 
<div class="container main-container headerOffset"> 
  
    <div class="row">
  		<?php echo $this->load->view('products/left_navigation');?>
        
        <!--right column-->
        <div class="col-lg-9 col-md-9 col-sm-12">
        	
            <div class="w100 clearfix category-top">
            	<h2> Edit profile </h2>
            </div>
        
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
            <?php echo form_open_multipart($this->uri->uri_string(), array('role' => 'form', 'class' => 'form-horizontal'))?>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="vendor_logo" class="col-sm-3 control-label">Profile Image</label>
                            <div class="col-sm-9">
                                <div class="center-align">
                                    <?php
                                        
                                        if(!empty($profile_image_error))
                                        {
                                            echo '<div class="alert alert-danger">'.$profile_image_error.'</div>';
                                            $this->session->unset_userdata('profile_error_message');
                                        }
                                    ?>
                                </div>
                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                    <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="cursor:pointer; width:200px;">
                                        <img src="<?php echo $profile_image_location;?>" class="img-responsive">
                                    </div>
                                    <div>
                                        <span class="btn btn-file btn-primary"><span class="fileinput-new">Click here to upload image</span><span class="fileinput-exists">Change</span><input type="file" name="profile_image"></span>
                                        <a href="#" class="btn btn-success fileinput-exists" data-dismiss="fileinput">Remove</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- End photo -->
                    
                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="client_about" class="col-sm-3 control-label">Describe yourself
                                <span class="required">*</span></label>
                            <div class="col-sm-9">
                                <?php
                                    //case of an input error
                                    if(!empty($client_about_error))
                                    {
                                        ?>
                                        <textarea class="form-control alert-danger" name="client_about" onFocus="this.value = '<?php echo $client_about;?>';" placeholder="<?php echo $client_about_error;?>"></textarea>
                                        <?php
                                    }
                                    
                                    else
                                    {
                                        ?>
                                        <textarea class="form-control" name="client_about" placeholder="About you"><?php echo $client_about;?></textarea>
                                        <?php
                                    }
                                ?>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="client_dob" class="col-sm-3 control-label">Your age
                                <span class="required">*</span></label>
                            <div class="col-sm-3">
                                <?php
                                    //case of an input error
                                    if(!empty($client_dob1_error))
                                    {
                                        ?>
                                        <input type="text" class="form-control alert-danger" name="client_dob1" placeholder="<?php echo $client_dob1_error;?>" onFocus="this.value = '<?php echo $client_dob1;?>';" title="<?php echo $client_dob1_error;?>">
                                        <?php
                                    }
                                    
                                    else
                                    {
                                        ?>
                                        <input type="text" class="form-control" name="client_dob1" placeholder="dd" value="<?php echo $client_dob1;?>">
                                        <?php
                                    }
                                ?>
                            </div>
                            <div class="col-sm-3">
                                <?php
                                    //case of an input error
                                    if(!empty($client_dob2_error))
                                    {
                                        ?>
                                        <input type="text" class="form-control alert-danger" name="client_dob2" placeholder="<?php echo $client_dob2_error;?>" onFocus="this.value = '<?php echo $client_dob2;?>';" title="<?php echo $client_dob2_error;?>">
                                        <?php
                                    }
                                    
                                    else
                                    {
                                        ?>
                                        <input type="text" class="form-control" name="client_dob2" placeholder="mm" value="<?php echo $client_dob2;?>">
                                        <?php
                                    }
                                ?>
                            </div>
                            <div class="col-sm-3">
                                <?php
                                    //case of an input error
                                    if(!empty($client_dob3_error))
                                    {
                                        ?>
                                        <input type="text" class="form-control alert-danger" name="client_dob3" placeholder="<?php echo $client_dob3_error;?>" onFocus="this.value = '<?php echo $client_dob3;?>';" title="<?php echo $client_dob3_error;?>">
                                        <?php
                                    }
                                    
                                    else
                                    {
                                        ?>
                                        <input type="text" class="form-control" name="client_dob3" placeholder="yyyy" value="<?php echo $client_dob3;?>">
                                        <?php
                                    }
                                ?>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="neighbourhood_id" class="col-sm-3 control-label">You're from
                                <span class="required">*</span></label>
                            <div class="col-sm-9">
                                <?php
                                    //case of an input error
                                    if(!empty($neighbourhood_id_error))
                                    {
                                        ?>
                                        <select name="neighbourhood_id" class="form-control alert-danger">
                                            <option value="">---Select neighbourhood---</option>
                                        <?php
                                    }
                                    
                                    else
                                    {
                                        ?>
                                        <select name="neighbourhood_id" class="form-control">
                                            <option value="">---Select neighbourhood---</option>
                                        <?php
                                    }
                                    if($neighbourhoods_query->num_rows() > 0)
                                    {
                                        foreach($neighbourhoods_query->result() as $res)
                                        {
                                            $neighbourhood_id2 = $res->neighbourhood_id;
                                            $neighbourhood_name = $res->neighbourhood_name;
                                            
                                            if($neighbourhood_id2 == $neighbourhood_id)
                                            {
                                                echo '<option value="'.$neighbourhood_id2.'" selected="selected">'.$neighbourhood_name.'</option>';
                                            }
                                            
                                            else
                                            {
                                                echo '<option value="'.$neighbourhood_id2.'">'.$neighbourhood_name.'</option>';
                                            }
                                        }
                                    }
                                ?>
                                </select>
                            </div>
                        </div>
                        
                        <div class="row">
                        	<div class="col-md-4 col-md-offset-3">
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <?php
                                            //case of an input error
                                            if(!empty($gender_id_error))
                                            {
                                                ?>
                                                <select name="gender_id" class="form-control alert-danger">
                                                    <option value="">--I am a--</option>
                                                <?php
                                            }
                                            
                                            else
                                            {
                                                ?>
                                                <select name="gender_id" class="form-control">
                                                    <option value="">--I am a--</option>
                                                <?php
                                            }
                                            if($genders_query->num_rows() > 0)
                                            {
                                                foreach($genders_query->result() as $res)
                                                {
                                                    $gender_id2 = $res->gender_id;
                                                    $gender_name = $res->gender_name;
                                                    
                                                    if($gender_id2 == $gender_id)
                                                    {
                                                        echo '<option value="'.$gender_id2.'" selected="selected">'.$gender_name.'</option>';
                                                    }
                                                    
                                                    else
                                                    {
                                                        echo '<option value="'.$gender_id2.'">'.$gender_name.'</option>';
                                                    }
                                                }
                                            }
                                        ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-1">
                            	<div style="margin: 0 auto; text-align:center; line-height:2.5em;margin-left: -12px;">
                            		seeking
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                        
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <?php
                                            //case of an input error
                                            if(!empty($client_looking_gender_id_error))
                                            {
                                                ?>
                                                <select name="client_looking_gender_id" class="form-control alert-danger">
                                                    <option value="">--Looking for a--</option>
                                                <?php
                                            }
                                            
                                            else
                                            {
                                                ?>
                                                <select name="client_looking_gender_id" class="form-control">
                                                    <option value="">--Looking for a--</option>
                                                <?php
                                            }
                                            if($genders_query->num_rows() > 0)
                                            {
                                                foreach($genders_query->result() as $res)
                                                {
                                                    $gender_id2 = $res->gender_id;
                                                    $gender_name = $res->gender_name;
                                                    
                                                    if($gender_id2 == $client_looking_gender_id)
                                                    {
                                                        echo '<option value="'.$gender_id2.'" selected="selected">'.$gender_name.'</option>';
                                                    }
                                                    
                                                    else
                                                    {
                                                        echo '<option value="'.$gender_id2.'">'.$gender_name.'</option>';
                                                    }
                                                }
                                            }
                                        ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                        	<div class="col-md-4 col-md-offset-3">
                                <div class="form-group">
                                    <div class="col-sm-12">
                                <?php
                                    //case of an input error
                                    if(!empty($age_group_id_error))
                                    {
                                        ?>
                                        <select name="age_group_id" class="form-control alert-danger">
                                            <option value="">--Aged--</option>
                                        <?php
                                    }
                                    
                                    else
                                    {
                                        ?>
                                        <select name="age_group_id" class="form-control">
                                            <option value="">--Aged--</option>
                                        <?php
                                    }
                                    if($age_groups_query->num_rows() > 0)
                                    {
                                        foreach($age_groups_query->result() as $res)
                                        {
                                            $age_group_id2 = $res->age_group_id;
                                            $age_group_name = $res->age_group_name;
                                            
                                            if($age_group_id == $age_group_id2)
                                            {
                                                echo '<option value="'.$age_group_id2.'" selected="selected">'.$age_group_name.'</option>';
                                            }
                                            
                                            else
                                            {
                                                echo '<option value="'.$age_group_id2.'">'.$age_group_name.'</option>';
                                            }
                                        }
                                    }
                                ?>
                                </select>
                            </div>
                        </div>
                       </div>
                            
                            <div class="col-md-1">
                            	<div style="margin: 0 auto; text-align:center; line-height:2.5em;margin-left: -12px;">
                            		for a
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                        
                                <div class="form-group">
                                    <div class="col-sm-12">
                                <?php
                                    //case of an input error
                                    if(!empty($age_group_id_error))
                                    {
                                        ?>
                                        <select name="encounter_id" class="form-control alert-danger">
                                            <option value="">---Select encounter---</option>
                                        <?php
                                    }
                                    
                                    else
                                    {
                                        ?>
                                        <select name="encounter_id" class="form-control">
                                            <option value="">---Select encounter---</option>
                                        <?php
                                    }
                                    if($encounters_query->num_rows() > 0)
                                    {
                                        foreach($encounters_query->result() as $res)
                                        {
                                            $encounter_id2 = $res->encounter_id;
                                            $encounter_name = $res->encounter_name;
                                            
                                            if($encounter_id2 == $encounter_id)
                                            {
                                                echo '<option value="'.$encounter_id2.'" selected="selected">'.$encounter_name.'</option>';
                                            }
                                            
                                            else
                                            {
                                                echo '<option value="'.$encounter_id2.'">'.$encounter_name.'</option>';
                                            }
                                        }
                                    }
                                ?>
                                </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- End details -->
                    
                </div><!-- End row -->
                
                <div class="row">
                	<div class="col-md-12">
                        <div class="center-align">
                            <button type="submit" class="btn btn-primary">
                                Update profile
                            </button>
                        </div>
                    </div>
                </div>
			<?php echo form_close();?>
        
        </div><!--/right column end-->
    </div><!-- /.row  --> 
</div>
<!-- /main container -->

<div class="gap"> </div>