<?php
	$account_balance = $this->payments_model->get_account_balance($this->session->userdata('client_id'));
?>
<!-- Fixed navbar start -->
<div class="navbar navbar-tshop navbar-fixed-top megamenu" role="navigation">
  <!--<div class="navbar-top">
    <div class="container">
      <div class="row">
        <div class="col-lg-6 col-sm-6 col-xs-6 col-md-6">
        
        <div class="pull-left ">
            <ul class="userMenu ">
              <li> <a href="#"> <span class="hidden-xs">HELP</span><i class="glyphicon glyphicon-info-sign hide visible-xs "></i> </a> </li>
              <li class="phone-number"> 
              <a  href="callto:+254713249320"> 
              <span> <i class="glyphicon glyphicon-phone-alt "></i></span> 
              <span class="hidden-xs" style="margin-left:5px"> +254 713 249 320 </span> </a> </li>
            </ul>
          </div>
        </div>
        <div class="col-lg-6 col-sm-6 col-xs-6 col-md-6 no-margin no-padding">
          <div class="pull-right">
            <ul class="userMenu">
            	<?php
				//user has logged in
				
					echo '<li> <a href="#"  data-toggle="modal" data-target="#ModalLogin"> <span class="hidden-xs">Sign In</span> <i class="glyphicon glyphicon-log-in hide visible-xs "></i> </a> </li>
					<li class="hidden-xs"> <a href="#"  data-toggle="modal" data-target="#ModalSignup"> Create Account </a> </li>';
				
				?>
             
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div> -->
  <!--/.navbar-top-->
  
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse"> <span class="sr-only"> Toggle navigation </span> <span class="icon-bar"> </span> <span class="icon-bar"> </span> <span class="icon-bar"> </span> </button>
      <!--<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-cart"> <i class="fa fa-shopping-cart colorWhite"> </i> <span class="cartRespons colorWhite" id="menu_cart_total"> Cart (KES ) </span> </button>-->
      <a class="navbar-brand " href="<?php echo site_url()."browse";?>"> Nairobisingles </a> 
      
      <!-- this part for mobile -->
      <div class="search-box pull-right hidden-lg hidden-md hidden-sm">
        <div class="input-group">
          <button class="btn btn-nobg" type="button"> <i class="fa fa-search"> </i> </button>
        </div>
        <!-- /input-group --> 
        
      </div>
    </div>
    
    <?php //echo $this->load->view('cart/menu_cart', '', TRUE);?>
    
    <div class="navbar-collapse collapse">
      <ul class="nav navbar-nav">
        <li > <a href="<?php echo site_url()."browse";?>"> Browse </a> </li>
        
        <li > <a href="<?php echo site_url()."messages/inbox";?>"> Messages </a> </li>
        
        <!-- change width of megamenu = use class > megamenu-fullwidth, megamenu-60width, megamenu-40width -->
        <li class="dropdown megamenu-80width "> <a data-toggle="dropdown" class="dropdown-toggle" href="<?php echo site_url()."";?>"> <?php echo $this->session->userdata('client_username');?> <b class="caret"> </b> </a>
          <ul class="dropdown-menu">
            <li class="megamenu-content"> 
                <ul class="col-md-12">
                    <li class="col-md-4"> <a href="<?php echo site_url()."sign-out";?>"> <i class="glyphicon glyphicon-log-out"> </i> Sign out </a> </li>
                    <li class="col-md-4"> <a href="<?php echo site_url()."credits";?>"> <i class="fa fa-money"></i>
 </i> Credits </a> </li>
                    <li class="col-md-4"> <a href="<?php echo site_url()."my-profile";?>"> <i class="glyphicon glyphicon-user"> </i> My profile </a> </li>
                </ul>
            </li>
          </ul>
        </li>
        
        <!-- change width of megamenu = use class > megamenu-fullwidth, megamenu-60width, megamenu-40width -->
        
       
      </ul>
      
        
        <div class="credit-box">
          <div class="input-group">
          	<a href="<?php echo site_url().'credits';?>" class="credits-available"><span id="available_credit"><?php echo $account_balance?></span> credits available</a>
            <a href="<?php echo site_url()."sign-out";?>" style="color:white; margin-left:1em;"> <i class="glyphicon glyphicon-log-out"> </i> Sign out </a>
            <!-- <button class="btn btn-nobg" type="button"> <i class="fa fa-search"> </i> </button> -->
          </div>
          <!-- /input-group --> 
          
        </div>
        <!--/.search-box --> 
      </div>
      <!--/.navbar-nav hidden-xs--> 
    </div>
    <!--/.nav-collapse --> 
    
  </div>
  <!--/.container -->
  
  <div class="search-full text-right"> <a class="pull-right search-close"> <i class=" fa fa-times-circle"> </i> </a>
    <div class="searchInputBox pull-right">
    <?php echo form_open('products/search');?>
      <input type="search"  data-searchurl="search?=" name="search_item" placeholder="start typing and hit enter to search" class="search-input">
      <button class="btn-nobg search-btn" type="submit"> <i class="fa fa-search"> </i> </button>
      <?php echo form_close();?>
    </div>
  </div>
  <!--/.search-full--> 
  
</div>
<!-- /.Fixed navbar  -->