<!DOCTYPE html>
<html lang="en">
    <head>
        <?php echo $this->load->view('site/includes/header_homepage', '', TRUE); ?>
    </head>

	<body>
        <?php echo $content;?>
        <?php echo $this->load->view('site/includes/home_footer', '', TRUE); ?>
	</body>
</html>
