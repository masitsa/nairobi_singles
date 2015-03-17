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
            <!-- Customer -->
            <div class="form-group col-lg-4">
                <label class="col-lg-4 control-label">Customer</label>
                <div class="col-lg-7">
                    <select name="user_id" id="user_id" class="form-control" required>
                        <?php
                        if($all_users->num_rows() > 0)
                        {
                            $result = $all_users->result();
                            
                            foreach($result as $res)
                            {
                                if($res->user_id == set_value('user_id'))
                                {
                                    echo '<option value="'.$res->user_id.'" selected>'.$res->first_name.' '.$res->other_names.'</option>';
                                }
                                else
                                {
                                    echo '<option value="'.$res->user_id.'">'.$res->first_name.' '.$res->other_names.'</option>';
                                }
                            }
                        }
                        ?>
                    </select>
                </div>
            </div> 
            <div class="form-group col-lg-4">
                <label class="col-lg-4 control-label">Payment Method</label>
                <div class="col-lg-7">
                    <select name="payment_method" class="form-control" required>
                        <?php
                        if($payment_methods->num_rows() > 0)
                        {
                            $result = $payment_methods->result();
                            
                            foreach($result as $res)
                            {
                                if($res->payment_method_id == set_value('payment_method'))
                                {
                                    echo '<option value="'.$res->payment_method_id.'" selected>'.$res->payment_method_name.'</option>';
                                }
                                else
                                {
                                    echo '<option value="'.$res->payment_method_id.'">'.$res->payment_method_name.'</option>';
                                }
                            }
                        }
                        ?>
                    </select>
                </div>
            </div> 
            <!-- brand Name -->
            <div class="form-group col-lg-4">
                <label class="col-lg-4 control-label">Order Instructions</label>
                <div class="col-lg-8">
                	<textarea class="form-control" name="order_instructions"><?php echo set_value('order_instructions');?></textarea>
                </div>
            </div>
            <div class="form-actions center-align">
                <button class="submit btn btn-primary" type="submit">
                    Create New Order
                </button>
            </div>
            <br />
            <?php echo form_close();?>
		</div>