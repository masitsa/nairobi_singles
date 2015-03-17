<!DOCTYPE html>
<html lang="en">
	<head>
		<?php echo $this->load->view('site/includes/account/header', '', TRUE);?>
	</head>
	<body>
        <div class="page-container">
          
            <?php echo $this->load->view('site/includes/account/top_nav', '', TRUE);?>
              
            <div class="container-fluid">
                <div class="row row-offcanvas row-offcanvas-left">
                
					<?php echo $this->load->view('site/includes/account/left_nav', '', TRUE);?>
                    
                    <!--/main-->
                    <div class="col-xs-12 col-sm-9" data-spy="scroll" data-target="#sidebar-nav">
                    	<?php echo $content;?>
                    </div><!--/.main-->
                </div><!--/.row-->
			</div><!--/.container-->
        </div><!--/.page-container-->
          
        <?php echo $this->load->view('site/includes/account/footer', '', TRUE);?>
	</body>
</html>