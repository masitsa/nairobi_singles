<div class="container main-container headerOffset"> 
  
  <?php //echo $this->load->view('products/breadcrumbs');?>
  
  <div class="row">
    <!--right column-->
    <div class="col-lg-12 col-md-12 col-sm-12">
      
      <div class="w100 productFilter clearfix">
        <div class="pull-right ">
          
          <div class="change-view pull-right"> 
          <a href="#" title="Grid" class="grid-view"> <i class="fa fa-th-large"></i> </a> 
          <a href="#" title="List" class="list-view "><i class="fa fa-th-list"></i></a> </div>
        </div>
        
        <div id="showing">
        	<?php //echo $this->load->view('account/showing');?>
        </div>
        
      </div> <!--/.productFilter-->
      
      <div id="profiles">
      	<?php echo $this->load->view('account/display_profiles');?>
      </div>
      
    </div><!--/right column end-->
  </div><!-- /.row  --> 
</div>
<!-- /main container -->

<div class="gap"> </div>
