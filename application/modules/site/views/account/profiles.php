<div class="container main-container headerOffset"> 
  
  <?php //echo $this->load->view('products/breadcrumbs');?>
  
  <div class="row">
  
  	<?php echo $this->load->view('products/left_navigation');?>
    
    <!--right column-->
    <div class="col-lg-9 col-md-9 col-sm-12">
      
      <div class="w100 productFilter clearfix">
        <div class="pull-right ">
          <div class="change-order pull-right">
            <select class="form-control" name="orderby" id="sort_profiles">
              <option selected="created" >Default Sorting (Joined)</option>
              <!-- <option value="popularity">Sort by popularity: highest to lowest</option> -->
              <option value="client_dob">Age</option>
            </select>
          </div>
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

<script type="text/javascript">
//Sort Products
$(document).on("change","select#sort_profiles",function()
{
	var order_by = $('#sort_profiles :selected').val();alert('<?php echo site_url();?>browse/sort-by/'+order_by+'/<?php echo $post_neighbourhoods;?>/<?php echo $post_ages;?>/<?php echo $post_encounters;?>/ajax');
            
	$.ajax({
		type:'POST',
		url: '<?php echo site_url();?>browse/sort-by/'+order_by+'/<?php echo $post_neighbourhoods;?>/<?php echo $post_ages;?>/<?php echo $post_encounters;?>/ajax',
		cache:false,
		contentType: false,
		processData: false,
		dataType: 'json',
		success:function(data)
		{
			/*$("#showing").html(data.showing);*/
			$("#profiles").html(data.profiles);
		},
		error: function(xhr, status, error) {
			alert("XMLHttpRequest=" + xhr.responseText + "\ntextStatus=" + status + "\nerrorThrown=" + error);
		}
	});
	
	return false;
});
</script>
