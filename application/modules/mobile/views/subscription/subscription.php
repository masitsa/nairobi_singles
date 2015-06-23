
    	<div class="row">
        
        <!--right column-->
        <div class="col-xs-12">

            <?php
            
            if(!empty($iframe))
            {
                ?>
                <iframe src="<?php echo $iframe;?>" width="100%" height="700px"  scrolling="no" frameBorder="0">
                    <p>Unable to load payment</p>
                </iframe>
                <?php
            }
				?>
            </div>
        </div>