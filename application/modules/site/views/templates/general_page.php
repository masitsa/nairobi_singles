<!DOCTYPE html>
<html lang="en">
    <head>
        <?php echo $this->load->view('site/includes/header', '', TRUE); ?>
    </head>

	<body>
    	<!-- Modal Login -->
        
    	<!-- Top Navigation -->
        <?php echo $this->load->view('includes/top_navigation', '', TRUE); ?>
        
        <?php echo $content;?>
        <?php echo $this->load->view('site/includes/footer', '', TRUE); ?>
	</body>
</html>
