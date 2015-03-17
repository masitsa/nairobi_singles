<?php
	$product = $product_details->result();
	//the product details
	$sale_price = $product[0]->sale_price;
	$featured = $product[0]->featured;
	$category_id = $product[0]->category_id;
	$brand_id = $product[0]->brand_id;
	$product_id = $product[0]->product_id;
	$product_name = $product[0]->product_name;
	$product_code = $product[0]->product_code;
	$product_buying_price = $product[0]->product_buying_price;
	$product_status = $product[0]->product_status;
	$product_selling_price = $product[0]->product_selling_price;
	$image = $product[0]->product_image_name;
	$thumb = $product[0]->product_thumb_name;
	$product_description = $product[0]->product_description;
	$product_balance = $product[0]->product_balance;
	$brand_name = $product[0]->brand_name;
	$category_name = $product[0]->category_name;
	$mini_desc = implode(' ', array_slice(explode(' ', $product_description), 0, 10));
	
	if($sale_price > 0)
	{
		$selling_price = $product_selling_price - ($product_selling_price * ($sale_price/100));
		$price = '<span class="price-sales">KES '. number_format($selling_price, 0, '.', ',').'</span> <span class="price-standard">KES '. number_format($product_selling_price, 0, '.', ',').'</span> ';
	}
	
	else
	{
		$price = '<span class="price-sales">KES '. number_format($product_selling_price, 0, '.', ',').'</span>';
	}
?>
<!-- styles needed by smoothproducts.js for product zoom  -->
<link rel="stylesheet" href="<?php echo base_url()."assets/themes/tshop/";?>css/smoothproducts.css">


<div class="container main-container headerOffset">
  
  <?php echo $this->load->view('products/breadcrumbs');?>
  
  <div class="row transitionfx">
  
   <!-- left column -->
    <div class="col-lg-6 col-md-6 col-sm-6">
    	<!-- product Image and Zoom -->

    <div class="main-image sp-wrap col-lg-12 no-padding style2"> 
    	<a href="<?php echo base_url()."assets/images/products/images/".$image;?>"><img src="<?php echo base_url()."assets/images/products/images/".$image;?>" class="img-responsive" alt="img"></a> 
    <?php
		if($product_images->num_rows() > 0)
		{
			$galleries = $product_images->result();
			
			foreach($galleries as $gal)
			{
				$thumb = $gal->product_image_thumb;
				$image = $gal->product_image_name;
				?>
                <a href="<?php echo base_url()."assets/images/products/gallery/".$image;?>"><img src="<?php echo base_url()."assets/images/products/gallery/".$image;?>" class="img-responsive" alt="img"></a> 
				<?php
			}
		}
	?>
      </div>
    </div><!--/ left column end -->
    
    
    <!-- right column -->
    <div class="col-lg-6 col-md-6 col-sm-5">
    
      <h1 class="product-title"> <?php echo $product_name;?></h1>
      <h3 class="product-code">Product Code : <?php echo $product_code;?></h3>
      <div class="product-price"> 
          <?php echo $price;?>
      </div>
      
      <div class="details-description">
        <p><?php echo $mini_desc;?></p>
      </div>
      
      <?php
      	//product features
		if(($all_features->num_rows() > 0) && ($product_features->num_rows() > 0))
		{
			$feature = $all_features->result();
			$product_feature = $product_features->result();
		
			$count = 0;
			foreach($feature as $feat)
			{	
				//feature details
				$feature_id = $feat->feature_id;
				$feature_name = $feat->feature_name;
				$count = 0;
				
				//product feature details
				$feature_values = '';
				
				foreach($product_feature as $f)
				{
					$feat_id = $f->feature_id;
					
					if($feat_id == $feature_id)
					{
						$product_feature_id = $f->product_feature_id;
						$name = $f->feature_value;
						$price = $f->price;
						$quantity = $f->quantity;
						$image = $f->thumb;
						//$image = '<img src="'. base_url().'assets/images/features/'.$f->thumb.'" alt="'.$name.'"/>';
						
						if(!empty($image))
						{
							//open section
							if($count == 0)
							{
								$feature_values .= '
								<div class="color-details"> 
									<span class="selected-color"><strong>'.$feature_name.'</strong></span>
									<ul class="swatches Color">';
							}
							//add values
							$feature_values .= '<li> <a ><img src="'. base_url().'assets/images/features/'.$image.'" alt="'.$name.'"/></a> </li>';
							//close section
							if($count == (count($product_feature) - 1))
							{
								$feature_values .= '
									</ul>
      							</div>';
							}
						}
						
						else
						{
							//open section
							if($count == 0)
							{
								$feature_values .= '
								<div class="productFilter">
									<div class="filterBox">
										<select>';
							}
							//add values
							$feature_values .= '<option value="'.$product_feature_id.'">'.$name.'"</option>';
							//close section
							if($count == (count($product_feature) - 1))
							{
								$feature_values .= '
									</select>
        						</div>';
							}
							
						}
						
						$count++;
					}
				}
			}
		}
	  ?>
      
      <div class="cart-actions">
        <div class="addto">
        	<a href="<?php echo $product_id;?>" class="add_to_cart"><button class="button btn-cart cart first" title="Add to Cart" type="button">Add to Cart</button></a>
          <!--<a class="link-wishlist wishlist add_to_wishlist" href="<?php echo $product_id;?>">Add to Wishlist</a> </div> -->
          
        <div style="clear:both"></div>
        
        <?php
        	if($product_balance > 0)
			{
				echo '<h3 class="incaps"><i class="fa fa fa-check-circle-o color-in"></i> In stock</h3>';
			}
			
			else
			{
				echo '<h3 style="display:none" class="incaps"><i class="fa fa-minus-circle color-out"></i> Out of stock</h3>';
			}
		?>
        <h3 class="incaps"> <i class="glyphicon glyphicon-lock"></i> Secure online ordering</h3>
      </div>
      <!--/.cart-actions-->
      
      <div class="clear"></div>
      
      <div class="product-tab w100 clearfix">
      
        <ul class="nav nav-tabs">
          <li class="active"><a href="#details" data-toggle="tab">Details</a></li>
          <li><a href="#shipping" data-toggle="tab">How to Order</a></li>
        </ul>
        
        <!-- Tab panes -->
        <div class="tab-content">
          <div class="tab-pane active" id="details">
          	<?php echo $product_description;?>
          </div>
          
          <div class="tab-pane" id="shipping">
            <table >
              <colgroup>
              <col style="width:33%">
              <col style="width:33%">
              <col style="width:33%">
              </colgroup>
              <tbody>
                <tr>
                  <td>Browse for the items that you would liketo purchase</td>
                </tr>
                <tr>
                  <td>Add the items to your cart</td>
                </tr>
                <tr>
                  <td>If you would like to buy the items later add them to your wish list</td>
                </tr>
                <tr>
                  <td>Proceed to checkout to confirm your order</td>
                </tr>
                <tr>
                  <td>We will get back to you as soon as we receive your order</td>
                </tr>
              </tbody>
              <tfoot>
                <tr>
                  <td colspan="3">* We offer free delivery for your order</td>
                </tr>
              </tfoot>
            </table>
          </div>
          
        </div> <!-- /.tab content -->
        
      </div><!--/.product-tab-->
      
      <div style="clear:both"></div>
      
      <div class="product-share clearfix">
        <p> SHARE </p>
        <div class="socialIcon"> 
        	<a href="#"> <i  class="fa fa-facebook"></i></a> 
            <a href="#"> <i  class="fa fa-twitter"></i></a> 
            <a href="#"> <i  class="fa fa-google-plus"></i></a> 
            <a href="#"> <i  class="fa fa-pinterest"></i></a> </div>
      </div>
      <!--/.product-share--> 
      
    </div><!--/ right column end -->
    
  </div>
  <!--/.row-->
  
  <div class="row recommended">
  
    <h1> YOU MAY ALSO LIKE </h1>
    
    <div id="SimilarProductSlider">
    	<?php
        	if($similar_products->num_rows() > 0)
			{
				$product = $similar_products->result();
				
				foreach($product as $prods)
				{
					$sale_price = $prods->sale_price;
					$thumb = $prods->product_image_name;
					$product_id = $prods->product_id;
					$product_name = $prods->product_name;
					$product_price = $prods->product_selling_price;
					$description = $prods->product_description;
					$mini_desc = implode(' ', array_slice(explode(' ', $description), 0, 10));
					$price = number_format($product_price, 2, '.', ',');
					$sale = '';
					
					if($sale_price > 0)
					{
						$sale = '<div class="promotion"> <span class="discount">'.$sale_price.'% OFF</span> </div>';
					}
					
					echo
					'
					<div class="item">
						<div class="product"> <a class="product-image" href="'.site_url().'products/view-product/'.$product_id.'"> <img src="'.base_url().'assets/images/products/images/'.$thumb.'"  alt="img"> </a>
						'.$sale.'
						  <div class="description">
							<h4><a href="san-remo-spaghetti">'.$product_name.'</a></h4>
							<div class="price"> <span>KES '.$price.'</span> </div>
						  </div>
						</div>
					  </div>
					';
				}
			}
		?>
    </div><!--/.SimilarProductSlider-->
  </div>  <!--/.recommended--> 
  
  
  <div style="clear:both"></div>
  
  
</div> <!-- /main-container -->


<div class="gap"></div>
</div>

<!-- include smoothproducts // product zoom plugin  --> 
<script type="text/javascript" src="<?php echo base_url()."assets/themes/tshop/";?>js/smoothproducts.min.js"></script> 