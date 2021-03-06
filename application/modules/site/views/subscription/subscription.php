<div class="container main-container headerOffset"> 
  
    <div class="row">
  		<?php echo $this->load->view('products/left_navigation');?>
        
        <!--right column-->
        <div class="col-lg-9 col-md-9 col-sm-12">
        	
            <div class="w100 clearfix category-top">
            	<h2> Credits </h2>
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

            <div class="alert alert-info">
                <h2 class="center-align">Chatcredit</h2>
                
            	<p class="center-align">Your account balance is currently <?php echo $account_balance;?> chatcredits</p>
                
                <p>We charge our members for the services in order to keep advertisement away, maintain the site and so that only serious persons register.</p>
                
                <p>Chatcredit never expires. Pay as you go. A third party does the processing for the payment and it is no way linked to your profile. We will never know your phone number or credit card information. Every chat message is worth <?php echo $this->config->item('message_cost');?> chatcredits and liking, poking, kissing or hugging other users is <?php echo $this->config->item('like_cost');?> chatcredits per like, poke, kiss or hug.</p>
                
                <!--<p>
                    <ul>
                        <li>Buy 100 chatcredits (KES 50)</li>
                        <li>Buy 250 chatcredits (KES 100)</li>
                        <li>Buy 600 chatcredits (KES 500)</li>
                        <li>Buy 1500 chatcredits (KES 1000)</li>
                    </ul>
                </p>-->
            </div>
            <?php
            
            if(!empty($iframe))
            {
                ?>
                <iframe src="<?php echo $iframe;?>" width="100%" height="700px"  scrolling="no" frameBorder="0">
                    <p>Browser unable to load iFrame</p>
                </iframe>
                <?php
            }
            
            else
            {	
				?>
                <h3 class="center-align">Purchase</h3>
                <div class="row">
                <?php
				foreach($credit_types->result() as $credit_type_data)
				{
					$credit_type_id = $credit_type_data->credit_type_id;
					$credit_type_name = $credit_type_data->credit_type_name;
					$credit_type_amount = $credit_type_data->credit_type_amount;
					$credit_type_credits = $credit_type_data->credit_type_credits;
					$credit_type_description = 'Purchase to receive '.$credit_type_credits.' chatcredits';//$credit_type_data->credit_type_description;
					$web_name = str_replace(" ", "+", $credit_type_name);
					
					echo form_open($this->uri->uri_string(), array('class' => 'form-horizontal', 'role' => 'form'));
					echo form_hidden('type', 'MERCHANT');
					echo form_hidden('credit_type_id', $credit_type_id);
					echo form_hidden('credit_type_amount', $credit_type_amount);
					echo form_hidden('credit_type_credits', $credit_type_credits);
					echo form_hidden('description', $credit_type_description);
					
					?>
                    <div class="col-xs-12 col-sm-6 col-md-4">
                        <div class="thumbnail">
                            <img src="http://placehold.it/300x200&text=<?php echo $credit_type_name;?>" alt="<?php echo $web_name;?>">
                            <div class="caption">
                                <p><?php echo $credit_type_description;?></p>
                                <p class="center-align"><button type="submit" class="btn btn-primary">Subscribe</button></p>
                            </div>
                        </div>
                    </div>
                    <?php
					echo form_close();
				}
				?>
                </div>
                <?php
			}
                
        ?>
        
        <h3 class="center-align">Purchase history</h3>
        
        <div class="row">
        	<div class="col-md-12">
            	<?php
					if($credits->num_rows() > 0)
					{
						?>
                        <table class="table table-condensed table-striped table-hover">
                        	<tr>
                            	<th>#</th>
                            	<th>Created</th>
                            	<th>Credits</th>
                            	<th>Status</th>
                            	<th></th>
                            </tr>
                        <?php
						$total = 0;
						$count = 0;
						foreach($credits->result() as $cred)
						{
							$count++;
							$client_credit_amount = $cred->client_credit_amount;
							$client_credit_id = $cred->client_credit_id;
							$transaction_tracking_id = $cred->transaction_tracking_id;
							$client_credit_status = $cred->client_credit_status;
							$created = date('jS M Y H:i a',strtotime($cred->created));
							
							if($client_credit_status == 1)
							{
								$total += $client_credit_amount;
								$status = '<span class="label label-success">Active</span>';
								$button = '';
							}
							
							else
							{
								$status = '<span class="label label-danger">Pending</span>';
								$button = '<a href="'.site_url().'process-payment/'.$transaction_tracking_id.'/'.$client_credit_id.'" class="btn btn-danger btn-sm">Check payment</a>';
							}
							
							?>
                            <tr>
                            	<td><?php echo $count;?></td>
                            	<td><?php echo $created;?></td>
                            	<td><?php echo number_format($client_credit_amount, 0);?></td>
                            	<td><?php echo $status;?></td>
                            	<td><?php echo $button;?></td>
                            </tr>
                            <?php
						}
							
						?>
						<tr>
							<td colspan="3">Total</td>
							<td><?php echo number_format($total, 0);?></td>
						</tr>
                        </table>
						<?php
					}
					
					else
					{
						echo '<div class="alert alert-danger center-align">You have not purchased any credits yet</div>';
					}
				?>
            </div>
        </div>
        
        </div><!--/right column end-->
    </div><!-- /.row  --> 
</div>
<!-- /main container -->

<div class="gap"> </div>