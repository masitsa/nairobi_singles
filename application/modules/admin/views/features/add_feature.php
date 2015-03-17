
          <div class="padd">
            <!-- Adding Errors -->
            <?php
            if(isset($error)){
                echo '<div class="alert alert-danger"> Oh snap! Change a few things up and try submitting again. </div>';
            }
            
            $validation_errors = validation_errors();
            
            if(!empty($validation_errors))
            {
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
								
                                if($res->category_id == set_value('category_id'))
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
            <!-- Category Name -->
            <div class="form-group">
                <label class="col-lg-4 control-label">Feature Name</label>
                <div class="col-lg-4">
                	<input type="text" class="form-control" name="feature_name" placeholder="Feature Name" value="<?php echo set_value('feature_name');?>" required>
                </div>
            </div>
            <!-- Activate checkbox -->
            <div class="form-group">
                <label class="col-lg-4 control-label">Activate Feature?</label>
                <div class="col-lg-4">
                    <div class="radio">
                        <label>
                            <input id="optionsRadios1" type="radio" checked value="1" name="feature_status">
                            Yes
                        </label>
                    </div>
                    <div class="radio">
                        <label>
                            <input id="optionsRadios2" type="radio" value="0" name="feature_status">
                            No
                        </label>
                    </div>
                </div>
            </div>
            <div class="form-actions center-align">
                <button class="submit btn btn-primary" type="submit">
                    Add Feature
                </button>
            </div>
            <br />
            <?php echo form_close();?>
		</div>