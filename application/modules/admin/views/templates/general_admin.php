<!DOCTYPE html>
<html lang="en">
    <?php echo modules::run('admin/control/admin_header'); ?>
<body>

    <?php echo modules::run('admin/control/top_navigation'); ?>

    <!-- Main content starts -->
    
    <div class="content">
    	<?php echo modules::run('admin/control/left_navigation'); ?>
        
        <!-- Main bar -->
        <div class="mainbar">
            <?php //echo modules::run('admin/control/crumbs'); ?>
            
            <!-- Matter -->
            
            <div class="matter">
                <div class="container">
                
                    <div class="row">
                    
                        <div class="col-md-12">
							<?php echo modules::run('admin/control/welcome'); ?>
                            
                                <div class="widget boxed">
                                
                                <div class="widget-head">
                                    <h4 class="pull-left"><i class="icon-reorder"></i><?php echo $title;?></h4>
                                    <div class="widget-icons pull-right">
                                        <a href="#" class="wminimize"><i class="icon-chevron-up"></i></a> 
                                        <a href="#" class="wclose"><i class="icon-remove"></i></a>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                                
                                <div class="widget-content">
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
                                	<?php echo $content;?>
                                </div>
                                
                                <div class="widget-foot">
                                
                                	<?php if(isset($links)){echo $links;}?>
                                
                                	<div class="clearfix"></div> 
                                
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
    
<?php //echo modules::run('admin/control/notifications'); ?>

<?php echo modules::run('admin/control/admin_footer'); ?>

</body>
</html>