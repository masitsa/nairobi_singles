<!DOCTYPE html>
<html lang="en">
    <?php echo modules::run('admin/control/admin_header'); ?>
<body>

    <?php echo modules::run('admin/control/top_navigation'); ?>

    <!-- Main content starts -->
    
    <div class="content">
    	<input type="hidden" id="config_url" value="<?php echo site_url();?>"/>
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
                            
                            <!-- Today status. jQuery Sparkline plugin used. -->
							<?php //echo $this->load->view('administration/summary');?>
                            <!-- Today status ends -->
                            
                            <div class="row">
                                <div class="col-md-12">
                                <?php echo $this->load->view('administration/line_graph');?>
                                </div>
                            </div>  
                            
                            <!-- Dashboard Graph starts -->
                            <?php echo $this->load->view('administration/bar_graph');?>
                            <!-- Dashboard graph ends --> 
                            
                            <!-- Dashboard Realtime chart starts -->
                            <?php //echo $this->load->view('administration/real_time');?>
                            <!-- Dashboard Realtime chart ends -->
                        
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
<script type="text/javascript" src="<?php echo base_url().'assets/themes/bluish/js/reports.js';?>"></script>

</body>
</html>