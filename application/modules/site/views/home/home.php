<!-- Home content -->
<div class="home-content">
	<!-- Container -->
    <div class="container">
    	
        <?php echo $this->load->view('site/includes/page_header');?>
    	
        <div class="row">
        	<div class="col-md-12">
            	<div class="center-align home-links">
            	<a href="<?php echo site_url().'join'?>"><button class="btn btn-join">Join</button>
            	<a href="<?php echo site_url().'sign-in'?>"><button class="btn btn-sign-in">Sign in</button>
                </div>
            </div>
        </div>
        
    </div>
    <!-- End Container -->
</div>
<!-- End Home content -->

<div class="center-align">
	<a class="links" href="<?php echo site_url().'terms';?>" target="_blank">Terms & conditions</a>
    <a class="links" href="<?php echo site_url().'privacy';?>" target="_blank">Privacy policy</a>
</div>
<?php echo $this->load->view('site/home/security', '', TRUE);?>