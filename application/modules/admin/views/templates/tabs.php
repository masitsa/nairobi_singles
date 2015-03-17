<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html">
    <?php echo modules::run('admin/control/admin_header'); ?>
<body>

	<?php echo modules::run('admin/control/top_navigation'); ?>
    
    <!-- Main content starts -->
    
    <div class="content">
    	<?php echo modules::run('admin/control/left_navigation'); ?>
        
        <!-- Main bar -->
        <div class="mainbar">
            <?php echo modules::run('admin/control/crumbs'); ?>

	    <!-- Matter -->

	    <div class="matter">
            <div class="container">
    
              <div class="row">
    
                <div class="col-md-12">
                    <?php echo modules::run('admin/control/welcome'); ?>
    
                <div class="tabbable">
                    <ul id="myTab" class="nav nav-tabs">
                    <?php 
                    $count = 0;
                    while($total_tabs > $count){
                        
                        //display the active tab
                        if($count == 0){
                            echo 
                            '
                            <li class="active">
                                <a data-toggle="tab" href="#tab'.$count.'">'.$tab_name[$count].'</a>
                            </li>
                            ';
                        }
                        else{
                            echo 
                            '
                            <li class="">
                                <a data-toggle="tab" href="#tab'.$count.'">'.$tab_name[$count].'</a>
                            </li>
                            ';
                        }
                        $count++;
                    }
                    
                    ?>
                    </ul>
                    <div id="myTabContent" class="tab-content">
                        <?php 
                        $count = 0;
                        while($total_tabs > $count){
                            
                            //display the active tab
                            if($count == 0){
                                echo 
                                '
                                <div class="tab-pane fade in active" id="tab'.$count.'">
                                    '.$content[$count].'
                                </div>
                                ';
                            }
                            else{
                                echo 
                                '
                                <div class="tab-pane fade" id="tab'.$count.'">
                                    '.$content[$count].'
                                </div>
                                ';
                            }
                            $count++;
                        }
                        ?>
                    </div>
                </div>
                </div>
    
              </div>
    
            </div>
		</div>

		<!-- Matter ends -->

    </div>

   <!-- Mainbar ends -->	    	
   <div class="clearfix"></div>

    </div>
    <!-- Content ends -->
    
<?php echo modules::run('admin/control/notifications'); ?>

<?php echo modules::run('admin/control/admin_footer'); ?>

</body>
</html>