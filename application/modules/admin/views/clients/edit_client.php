          <link href="<?php echo base_url()."assets/themes/jasny/css/jasny-bootstrap.css"?>" rel="stylesheet"/>
          <div class="padd">
            <!-- Adding Errors -->
            <?php
            if(isset($error)){
                echo '<div class="alert alert-danger"> Oh snap! Change a few things up and try submitting again. </div>';
            }
			
			//the brand details
			$brand_id = $brand[0]->brand_id;
			$brand_name = $brand[0]->brand_name;
			$brand_status = $brand[0]->brand_status;
			$image = $brand[0]->brand_image_name;
            
            $validation_errors = validation_errors();
            
            if(!empty($validation_errors))
            {
				$brand_name = set_value('brand_name');
				$brand_status = set_value('brand_status');
				
                echo '<div class="alert alert-danger"> Oh snap! '.$validation_errors.' </div>';
            }
			
            ?>
            
            <?php echo form_open_multipart($this->uri->uri_string(), array("class" => "form-horizontal", "role" => "form"));?>
            <!-- brand Name -->
            <div class="form-group">
                <label class="col-lg-4 control-label">Brand Name</label>
                <div class="col-lg-4">
                	<input type="text" class="form-control" name="brand_name" placeholder="brand Name" value="<?php echo $brand_name;?>" required>
                </div>
            </div>
            <!-- Image -->
            <div class="form-group">
                <label class="col-lg-4 control-label">Brand Image</label>
                <input type="hidden" value="<?php echo $image;?>" name="current_image"/>
                <div class="col-lg-4">
                    
                    <div class="row">
                    
                    	<div class="col-md-4 col-sm-4 col-xs-4">
                        	<div class="fileinput fileinput-new" data-provides="fileinput">
                                <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width:200px; height:200px;">
                                    <img src="<?php echo base_url()."assets/images/brands/".$image;?>">
                                </div>
                                <div>
                                    <span class="btn btn-file btn_pink"><span class="fileinput-new">Select Image</span><span class="fileinput-exists">Change</span><input type="file" name="brand_image"></span>
                                    <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
            <!-- Activate checkbox -->
            <div class="form-group">
                <label class="col-lg-4 control-label">Activate brand?</label>
                <div class="col-lg-4">
                    <div class="radio">
                        <label>
                        	<?php
                            if($brand_status == 1){echo '<input id="optionsRadios1" type="radio" checked value="1" name="brand_status">';}
							else{echo '<input id="optionsRadios1" type="radio" value="1" name="brand_status">';}
							?>
                            Yes
                        </label>
                    </div>
                    <div class="radio">
                        <label>
                        	<?php
                            if($brand_status == 0){echo '<input id="optionsRadios1" type="radio" checked value="0" name="brand_status">';}
							else{echo '<input id="optionsRadios1" type="radio" value="0" name="brand_status">';}
							?>
                            No
                        </label>
                    </div>
                </div>
            </div>
            <div class="form-actions center-align">
                <button class="submit btn btn-primary" type="submit">
                    Edit brand
                </button>
            </div>
            <br />
            <?php echo form_close();?>
		</div>