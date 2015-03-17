          <link href="<?php echo base_url()."assets/themes/jasny/css/jasny-bootstrap.css"?>" rel="stylesheet"/>
          <div class="padd">
            <!-- Adding Errors -->
            <?php
            if(isset($error)){
                echo '<div class="alert alert-danger"> Oh snap! Change a few things up and try submitting again. </div>';
            }
			
			//the feature details
			$feature_id = $feature[0]->feature_id;
			$category_id = $feature[0]->category_id;
			$feature_name = $feature[0]->feature_name;
			$feature_status = $feature[0]->feature_status;
            
            $validation_errors = validation_errors();
            
            if(!empty($validation_errors))
            {
				$feature_id = set_value('feature_id');
				$category_id = set_value('category_id');
				$feature_name = set_value('feature_name');
				$feature_status = set_value('feature_status');
				
                echo '<div class="alert alert-danger"> Oh snap! '.$validation_errors.' </div>';
            }
			
            ?>
            
            <?php echo form_open($this->uri->uri_string(), array("class" => "form-horizontal", "role" => "form"));?>
            <!-- Product Category -->
            <div class="form-group">
                <label class="col-lg-4 control-label">Feature Category</label>
                <div class="col-lg-4">
                	<select name="category_id" class="form-control" required>
                    	<?php
						echo '<option value="0">All Categories</option>';
						if($all_categories->num_rows() > 0)
						{
							$result = $all_categories->result();
							
							foreach($result as $res)
							{
								$category = $res->category_name;
								if($category == 'No Category'){$category = 'All Categories';}
								
								if($res->category_id == $category_id)
								{
									echo '<option value="'.$res->category_id.'" selected>'.$category.'</option>';
								}
								else
								{
									echo '<option value="'.$res->category_id.'">'.$category.'</option>';
								}
							}
						}
						?>
                    </select>
                </div>
            </div> 
            <!-- feature Name -->
            <div class="form-group">
                <label class="col-lg-4 control-label">feature Name</label>
                <div class="col-lg-4">
                	<input type="text" class="form-control" name="feature_name" placeholder="feature Name" value="<?php echo $feature_name;?>" required>
                </div>
            </div>
            <!-- Activate checkbox -->
            <div class="form-group">
                <label class="col-lg-4 control-label">Activate feature?</label>
                <div class="col-lg-4">
                    <div class="radio">
                        <label>
                        	<?php
                            if($feature_status == 1){echo '<input id="optionsRadios1" type="radio" checked value="1" name="feature_status">';}
							else{echo '<input id="optionsRadios1" type="radio" value="1" name="feature_status">';}
							?>
                            Yes
                        </label>
                    </div>
                    <div class="radio">
                        <label>
                        	<?php
                            if($feature_status == 0){echo '<input id="optionsRadios1" type="radio" checked value="0" name="feature_status">';}
							else{echo '<input id="optionsRadios1" type="radio" value="0" name="feature_status">';}
							?>
                            No
                        </label>
                    </div>
                </div>
            </div>
            <div class="form-actions center-align">
                <button class="submit btn btn-primary" type="submit">
                    Edit feature
                </button>
            </div>
            <br />
            <?php echo form_close();?>
		</div>