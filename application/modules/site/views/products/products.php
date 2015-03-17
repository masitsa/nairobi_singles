<div class="container main-container headerOffset"> 
  
  <?php echo $this->load->view('products/breadcrumbs');?>
  
  <div class="row">
  
  	<?php echo $this->load->view('products/left_navigation');?>
    
    <!--right column-->
    <div class="col-lg-9 col-md-9 col-sm-12">
    
      <div class="w100 clearfix category-top">
        <h2> PRODUCTS </h2>
      </div><!--/.category-top-->
      
      <?php
      if($product_sub_categories->num_rows() > 0)
	  {
		  ?>
          <div class="row subCategoryList clearfix">
		  <?php
		  $sub_categories = $product_sub_categories->result();
		  
		  foreach($sub_categories as $sub)
		  {
			  $category_image = $sub->category_image_name;
			  $category_id = $sub->category_id;
			  $category_name = $sub->category_name;
			  
			  if(!empty($category_image))
			  {
				  $image = base_url().'assets/images/categories/thumbnail_'.$category_image;
			  }
			  
			  else
			  {
				  $image = '';
			  }
			  
			  echo '
			  	<div class="col-lg-2 col-md-2 col-sm-3 col-xs-4  text-center ">
				  <div class="thumbnail equalheight"> <a class="subCategoryThumb" href="'.site_url().'products/category/'.$category_id.'"><img src="'.$image.'" class="img-rounded " alt="'.$category_name.'"> </a> <a  class="subCategoryTitle"><span> '.$category_name.' </span></a></div>
				</div>
			  ';
		  }
		  ?>
		  </div><!--/.subCategoryList-->
		  <?php
	  }
	  ?>
      
      <div class="w100 productFilter clearfix">
        <p class="pull-left"> Showing <strong><?php echo $last;?></strong> products </p>
        <div class="pull-right ">
          <div class="change-order pull-right">
            <select class="form-control" name="orderby" id="sort_products">
              <option selected="created" >Default Sorting (Newness)</option>
              <!-- <option value="popularity">Sort by popularity</option> 
              <option value="rating">Sort by average rating</option>
              <option value="product_date">Sort by newness</option> -->
              <option value="price">Sort by Price: low to high</option>
              <option value="price_desc">Sort by Price: high to low</option>
            </select>
          </div>
          <div class="change-view pull-right"> 
          <a href="#" title="Grid" class="grid-view"> <i class="fa fa-th-large"></i> </a> 
          <a href="#" title="List" class="list-view "><i class="fa fa-th-list"></i></a> </div>
        </div>
      </div> <!--/.productFilter-->
      <div class="row  categoryProduct xsResponse clearfix">
      
      	<?php
        	if($products->num_rows() > 0)
			{
				$product = $products->result();
				
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
					<div class="item col-sm-4 col-lg-4 col-md-4 col-xs-6">
						<div class="product">
							<div class="image"> <a href="'.site_url().'products/view-product/'.$product_id.'"><img src="'.base_url().'assets/images/products/images/'.$thumb.'" alt="img" class="img-responsive"></a>
								'.$sale.'
							</div>
							
							<div class="description">
								<h4><a href="'.site_url().'products/view-product/'.$product_id.'">'.$product_name.'</a></h4>
								<p>'.$mini_desc.'</p>
								<!-- <span class="size">XL / XXL / S </span> -->
							</div>
							<div class="price"> 
								<span>KES '.$price.'</span>
							</div>
							
							<div class="action-control">
								<a class="btn btn-primary add_to_cart" href="'.$product_id.'"> 
									<span class="add2cart"><i class="glyphicon glyphicon-shopping-cart"> </i> Add to cart </span> 
								</a>
							</div>
						</div>
					</div><!--/.item-->
					';
				}
			}
			
			else
			{
				echo 'There are no products :-(';
			}
		?>
    </div> <!--/.categoryProduct || product content end-->
      
      <div class="w100 categoryFooter">
        <div class="pagination pull-left no-margin-top">
          <?php if(isset($links)){echo $links;}?>
        </div>
        <div class="pull-right pull-right col-sm-4 col-xs-12 no-padding text-right text-left-xs">
          <p>Showing <?php echo $first;?>–<?php echo $last;?> of <?php echo $total;?> results</p>
        </div>
      </div> <!--/.categoryFooter-->
    </div><!--/right column end-->
  </div><!-- /.row  --> 
</div>
<!-- /main container -->

<div class="gap"> </div>

<script type="text/javascript">
//Sort Products
$(document).on("change","select#sort_products",function()
{
	var order_by = $('#sort_products :selected').val();
	
	window.location.href = '<?php echo site_url();?>products/sort-by/'+order_by;
});
</script>
