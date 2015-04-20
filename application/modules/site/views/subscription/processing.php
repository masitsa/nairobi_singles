<div class="container main-container headerOffset"> 
  
    <div class="row">
        <!--right column-->
        <div class="col-lg-12 col-md-12 col-sm-12">
        	
            <div class="w100 clearfix category-top">
            	<h2> Processing payment </h2>
            </div>

            <div class="alert alert-info">
            	<p class="center-align">Please wait while we process your payment</p>
            </div>
            
            <div class="center-align" id="processing_payment">
            	<img src="<?php echo base_url();?>assets/images/332.GIF">
                <input type="hidden" id="check_count" value="0" />
            </div>
        
        </div><!--/right column end-->
    </div><!-- /.row  --> 
</div>
<!-- /main container -->

<div class="gap"> </div>

<script type="text/javascript">
	$( document ).ready(function() 
	{
		(function worker() {
			
			var check_count = parseInt($('#check_count').val());
			$.ajax({
				type:'POST',
				url: '<?php echo site_url();?>site/subscription/check_payment/'+check_count+'/<?php echo $transaction_tracking_id;?>/<?php echo $client_credit_id;?>',
				cache:false,
				contentType: false,
				processData: false,
				success:function(data)
				{
					if(data == 'true')
					{
						window.location.href = '<?php echo site_url();?>credits';
						
					}
					
					else
					{
						$('#check_count').val(data);
					}
				},
				error: function(xhr, status, error) 
				{
					console.log("XMLHttpRequest=" + xhr.responseText + "\ntextStatus=" + status + "\nerrorThrown=" + error);
				},
				complete: function() 
				{
					// Schedule the next request when the current one's complete
					setTimeout(worker, 3000);
				}
			});
				
			})();
	});
</script>