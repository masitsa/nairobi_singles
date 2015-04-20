<footer>
  <div class="footer">
    <div class="container">
      <div class="row">
        <div class="col-lg-4  col-md-4 col-sm-4 col-xs-6">
          <h3> Support </h3>
          <ul>
            <li class="supportLi">
              <p> Contact us at </p>
              <h4> <a class="inline" href="mailto:info@nairobisingles.com"> <i class="fa fa-envelope-o"> </i> info@nairobisingles.com </a> </h4>
            </li>
          </ul>
        </div>
        <div class="col-lg-4  col-md-4 col-sm-4 col-xs-6">
          <h3> Quick Links </h3>
          <ul>
            <li> <a href="<?php echo site_url().'browse';?>"> Browse </a> </li>
            <li> <a href="<?php echo site_url().'messages/inbox';?>"> Messages </a> </li>
          </ul>
        </div>
        <div class="col-lg-4  col-md-4 col-sm-4 col-xs-6">
          <h3> My account </h3>
          <ul>
            <li> <a href="<?php echo site_url().'credits';?>"> Credits </a> </li>
            <li> <a href="<?php echo site_url().'my-profile';?>"> My profile </a> </li>
            <li> <a href="<?php echo site_url().'sign-out';?>"> Sign out </a> </li>
          </ul>
        </div>
        <!--<div class="col-lg-2  col-md-2 col-sm-4 col-xs-6">
          <h3> My Account </h3>
          <ul>
            <li> <a href="#"> Account Login </a> </li>
            <li> <a href="#"> My Account </a> </li>
          </ul>
        </div>
        <div class="col-lg-3  col-md-3 col-sm-6 col-xs-12 ">
          <h3> Stay in touch </h3>
          <ul>
            <li>
              <div class="input-append newsLatterBox text-center">
                <input type="text" class="full text-center"  placeholder="Email ">
                <button class="btn  bg-gray" type="button"> Subscribe <i class="fa fa-long-arrow-right"> </i> </button>
              </div>
            </li>
          </ul>
          <ul class="social">
            <li> <a href="http://facebook.com" target="_blank"> <i class=" fa fa-facebook"> &nbsp; </i> </a> </li>
            <li> <a href="http://twitter.com" target="_blank"> <i class="fa fa-twitter"> &nbsp; </i> </a> </li>
            <li> <a href="https://plus.google.com" target="_blank"> <i class="fa fa-google-plus"> &nbsp; </i> </a> </li>
            <li> <a href="http://pinterest.com" target="_blank"> <i class="fa fa-pinterest"> &nbsp; </i> </a> </li>
            <li> <a href="http://youtube.com" target="_blank"> <i class="fa fa-youtube"> &nbsp; </i> </a> </li>
          </ul>
        </div>-->
      </div>
      <!--/.row--> 
    </div>
    <!--/.container--> 
  </div>
  <!--/.footer-->
  
  <div class="footer-bottom">
    <div class="container">
      <p class="pull-left"> &copy; Nairobi Singles <?php echo date('Y');?>. All right reserved. </p>
      <!--<div class="pull-right paymentMethodImg"> <img height="30" class="pull-right" src="<?php echo base_url()."assets/themes/tshop/";?>images/site/payment/master_card.png" alt="img" > <img height="30" class="pull-right" src="<?php echo base_url()."assets/themes/tshop/";?>images/site/payment/paypal.png" alt="img" > <img height="30" class="pull-right" src="<?php echo base_url()."assets/themes/tshop/";?>images/site/payment/american_express_card.png" alt="img" > <img  height="30" class="pull-right" src="<?php echo base_url()."assets/themes/tshop/";?>images/site/payment/discover_network_card.png" alt="img" > <img  height="30" class="pull-right" src="<?php echo base_url()."assets/themes/tshop/";?>images/site/payment/google_wallet.png" alt="img" > </div>-->
    </div>
  </div>
  <!--/.footer-bottom--> 
</footer>


<!-- Send message start -->
<div class="modal signUpContent fade" id="send-message" tabindex="-1" role="dialog" >
  <div class="modal-dialog ">
    <div class="modal-content" id="modal-message">
      
    </div>
    <!-- /.modal-content --> 
    
  </div>
  <!-- /.modal-dialog --> 
  
</div>
<!-- /.Send message end --> 
<audio id="new_message" src="<?php echo base_url();?>assets/audio/new_message.mp3"></audio>

<?php echo $this->load->view('site/home/security', '', TRUE);?>
<!-- Le javascript
================================================== --> 

<!-- Placed at the end of the document so the pages load faster --> 
<script src="<?php echo base_url()."assets/themes/tshop/";?>bootstrap/js/bootstrap.min.js"></script> 

<!-- include jqueryCycle plugin --> 
<script src="<?php echo base_url()."assets/themes/tshop/";?>js/jquery.cycle2.min.js"></script> 
<!-- include easing plugin --> 
<script src="<?php echo base_url()."assets/themes/tshop/";?>js/jquery.easing.1.3.js"></script> 

<!-- include  parallax plugin --> 
<script type="text/javascript"  src="<?php echo base_url()."assets/themes/tshop/";?>js/jquery.parallax-1.1.js"></script> 

<!-- optionally include helper plugins --> 
<script type="text/javascript"  src="<?php echo base_url()."assets/themes/tshop/";?>js/helper-plugins/jquery.mousewheel.min.js"></script> 

<!-- include mCustomScrollbar plugin //Custom Scrollbar  --> 

<script type="text/javascript" src="<?php echo base_url()."assets/themes/tshop/";?>js/jquery.mCustomScrollbar.js"></script> 

<!-- include checkRadio plugin //Custom check & Radio  --> 
<script type="text/javascript" src="<?php echo base_url()."assets/themes/tshop/";?>js/ion-checkRadio/ion.checkRadio.min.js"></script> 

<!-- include grid.js // for equal Div height  --> 
<script src="<?php echo base_url()."assets/themes/tshop/";?>js/grids.js"></script> 

<!-- include carousel slider plugin  --> 
<script src="<?php echo base_url()."assets/themes/tshop/";?>js/owl.carousel.min.js"></script> 

<!-- jQuery minimalect // custom select   --> 
<!-- <script src="<?php echo base_url()."assets/themes/tshop/";?>js/jquery.minimalect.min.js"></script> -->

<!-- include touchspin.js // touch friendly input spinner component   --> 
<script src="<?php echo base_url()."assets/themes/tshop/";?>js/bootstrap.touchspin.js"></script> 

<!-- include custom script for site  --> 
<script src="<?php echo base_url()."assets/themes/tshop/";?>js/script.js"></script>

<script type="text/javascript">
//Like
$(document).on("click","a.like",function()
{
	var client_id = $(this).attr('href');
	
	$.ajax({
		type:'POST',
		url: '<?php echo site_url();?>site/profile/like_profile/'+client_id,
		cache:false,
		contentType: false,
		processData: false,
		statusCode: {
			302: function() {
				window.location.href = '<?php echo site_url();?>error';
			}
		},
		success:function(data){
			
			if(data == "true")
			{
				$("#like_section"+client_id).html('<a class="btn btn-default unlike" href="'+client_id+'"><span class="add2cart"><i class="glyphicon glyphicon-heart"> </i> Unlike </span></a>');
			}
			else
			{
				console.log(data);
				window.location.href = '<?php echo site_url();?>error';
			}
		},
		error: function(xhr, status, error) {
			console.log("XMLHttpRequest=" + xhr.responseText + "\ntextStatus=" + status + "\nerrorThrown=" + error);
			window.location.href = '<?php echo site_url();?>error';
		}
	});
	
	return false;
});



//Unlike
$(document).on("click","a.unlike",function()
{
	var client_id = $(this).attr('href');
	
	$.ajax({
		type:'POST',
		url: '<?php echo site_url();?>site/profile/unlike_profile/'+client_id,
		cache:false,
		contentType: false,
		processData: false,
		statusCode: {
			302: function() {
				window.location.href = '<?php echo site_url();?>error';
			}
		},
		success:function(data){
			
			if(data == "true")
			{
				$("#like_section"+client_id).html('<a class="btn btn-primary like" href="'+client_id+'"><span class="add2cart"><i class="glyphicon glyphicon-heart"> </i> Like </span></a>');
			}
			else
			{
				console.log('Unable to unlike profile. '+data);
				window.location.href = '<?php echo site_url();?>error';
			}
		},
		error: function(xhr, status, error) {
			console.log("XMLHttpRequest=" + xhr.responseText + "\ntextStatus=" + status + "\nerrorThrown=" + error);
			window.location.href = '<?php echo site_url();?>error';
		}
	});
	
	return false;
});

//Message
$(document).on("click","a.message",function()
{
	var client_id = $(this).attr('client_id');
	
	$.ajax({
		type:'POST',
		url: '<?php echo site_url();?>site/profile/send_message/'+client_id,
		cache:false,
		contentType: false,
		processData: false,
		statusCode: {
			302: function() {
				window.location.href = '<?php echo site_url();?>error';
			}
		},
		success:function(data)
		{
			$("#modal-message").html(data);
		},
		error: function(xhr, status, error) {
			console.log("XMLHttpRequest=" + xhr.responseText + "\ntextStatus=" + status + "\nerrorThrown=" + error);
			window.location.href = '<?php echo site_url();?>error';
		}
	});
	
	return false;
});

//Send message
$(document).on("submit","form.send_message",function(e)
{
	e.preventDefault();
	
	var formData = new FormData(this);

	$.ajax({
		type:'POST',
		url: $(this).attr('action'),
		data:formData,
		cache:false,
		contentType: false,
		processData: false,
		dataType: 'json',
		statusCode: {
			302: function() {
				window.location.href = '<?php echo site_url();?>error';
			}
		},
		success:function(data)
		{	
			if(data == "false")
			{
				$("#send_error").html('<div class="alert alert-danger">Unable to send message. Please try again</div>');
			}
			else
			{//alert(data.messages);
				var prev_message_count = parseInt($('#prev_message_count').val());//count the number of messages displayed
				prev_message_count = prev_message_count + 1;
				$('#prev_message_count').val(prev_message_count);
				$('#instant_message').val('');
				$("#modal_messages").html(data.messages);
				$("#available_credit").html(data.account_balance);
			}
		},
		error: function(xhr, status, error) {
			console.log("XMLHttpRequest=" + xhr.responseText + "\ntextStatus=" + status + "\nerrorThrown=" + error);
			window.location.href = '<?php echo site_url();?>error';
		}
	});
	return false;
});

//Send message
$(document).on("submit","form.send_message2",function(e)
{
	e.preventDefault();
	
	var formData = new FormData(this);

	$.ajax({
		type:'POST',
		url: $(this).attr('action'),
		data:formData,
		cache:false,
		contentType: false,
		processData: false,
		dataType: 'json',
		statusCode: {
			302: function() {
				window.location.href = '<?php echo site_url();?>error';
			}
		},
		success:function(data){
			
			if(data == "false")
			{
				$("#send_error").html('<div class="alert alert-danger">Unable to send message. Please try again</div>');
			}
			else
			{
				var prev_message_count = parseInt($('#prev_message_count').val());//count the number of messages displayed
				prev_message_count = prev_message_count + 1;
				$('#prev_message_count').val(prev_message_count);
				$('#instant_message2').val('');
				$("#view_message").html(data.messages);
				$("#available_credit").html(data.account_balance);
			}
		},
		error: function(xhr, status, error) {
			console.log("XMLHttpRequest=" + xhr.responseText + "\ntextStatus=" + status + "\nerrorThrown=" + error);
			window.location.href = '<?php echo site_url();?>error';
		}
	});
	return false;
});

//Like
$(document).on("change","select#filter_neighbourhood",function()
{
	var category_parent = $(this).val();
	
	$.ajax({
		type:'POST',
		url: '<?php echo site_url();?>site/account/get_neighbourhood_children/'+category_parent,
		cache:false,
		contentType: false,
		processData: false,
		dataType: 'json',
		statusCode: {
			302: function() {
				window.location.href = '<?php echo site_url();?>error';
			}
		},
		success:function(data)
		{	
			$("#children_section").html(data);
		},
		error: function(xhr, status, error) 
		{
			console.log("XMLHttpRequest=" + xhr.responseText + "\ntextStatus=" + status + "\nerrorThrown=" + error);
			window.location.href = '<?php echo site_url();?>error';
		}
	});
	
	return false;
	
});
$(document).on("change","select#filter_neighbourhood2",function()
{
	var category_parent = $(this).val();
	
	$.ajax({
		type:'POST',
		url: '<?php echo site_url();?>site/account/get_neighbourhood_children2/'+category_parent,
		cache:false,
		contentType: false,
		processData: false,
		dataType: 'json',
		statusCode: {
			302: function() {
				window.location.href = '<?php echo site_url();?>error';
			}
		},
		success:function(data)
		{	
			$("#children_section2").html(data);
		},
		error: function(xhr, status, error) 
		{
			console.log("XMLHttpRequest=" + xhr.responseText + "\ntextStatus=" + status + "\nerrorThrown=" + error);
			window.location.href = '<?php echo site_url();?>error';
		}
	});
	
	return false;
});

$(document).ready(function() {
	
	(function check_new_messages() {
		
		$.ajax({
			url: '<?php echo site_url();?>site/messages/count_unread_messages',
			cache:false,
			contentType: false,
			processData: false,
			dataType: 'json',
			statusCode: {
				302: function() {
					window.location.href = '<?php echo site_url();?>error';
				}
			},
			success: function(data) 
			{
				$("#message_badge").html(data.unread_messages);

			},
			complete: function() 
			{
				// Schedule the next request when the current one's complete
				setTimeout(check_new_messages, 3000);
			}
			});
		})();
});
</script>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-61276708-2', 'auto');
  ga('send', 'pageview');

</script>