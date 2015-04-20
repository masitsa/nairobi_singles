<?php
	$new_orders = number_format($this->login_model->get_new_orders(), 0, '.', ',');
	$balance = number_format($this->login_model->get_balance(), 0, '.', ',');
?>
            <!-- Page header start -->
            <div class="page-header">
                <div class="page-title">
                    <h3>Tables</h3>
                    <span>
					<?php 
					//salutation
					if(date('a') == 'am')
					{
						echo 'Good morning, ';
					}
					
					else if((date('H') >= 12) && (date('H') < 17))
					{
						echo 'Good afternoon, ';
					}
					
					else
					{
						echo 'Good evening, ';
					}
					echo $this->session->userdata('first_name');
					?>
                    </span>
                </div>
                <ul class="page-stats">
                    <li>
                        <div class="summary">
                            <span>Active clients</span>
                            <h3><?php echo $new_orders;?></h3>
                        </div>
                        <span id="sparklines1"></span>
                    </li>
                    <li>
                        <div class="summary">
                            <span>My balance</span>
                            <h3>Ksh <?php echo $balance;?></h3>
                        </div>
                        <span id="sparklines2"></span>
                    </li>
                </ul>
            </div>
            <!-- Page header ends -->