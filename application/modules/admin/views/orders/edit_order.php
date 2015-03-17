          <div class="padd">
            <!-- Adding Errors -->
            <?php
            if(isset($error)){
                echo '<div class="alert alert-danger"> Oh snap! Change a few things up and try submitting again. </div>';
            }
            
            $validation_errors = validation_errors();
            
            if(!empty($validation_errors))
            {
                echo '<div class="alert alert-danger"> Oh snap! '.$validation_errors.' </div>';
            }
            ?>
            
            <?php echo form_open($this->uri->uri_string(), array("class" => "form-horizontal", "role" => "form"));?>
            <!-- Customer -->
            <div class="form-group col-lg-4">
                <label class="col-lg-4 control-label">Customer</label>
                <div class="col-lg-7">
                    <select name="user_id" id="user_id" class="form-control" required>
                        <?php
                        if($all_users->num_rows() > 0)
                        {
                            $result = $all_users->result();
                            
                            foreach($result as $res)
                            {
                                if($res->user_id == $order->user_id)
                                {
                                    echo '<option value="'.$res->user_id.'" selected>'.$res->first_name.' '.$res->other_names.'</option>';
                                }
                                else
                                {
                                    echo '<option value="'.$res->user_id.'">'.$res->first_name.' '.$res->other_names.'</option>';
                                }
                            }
                        }
                        ?>
                    </select>
                </div>
            </div> 
            <div class="form-group col-lg-4">
                <label class="col-lg-4 control-label">Payment Method</label>
                <div class="col-lg-7">
                    <select name="payment_method" class="form-control" required>
                        <?php
                        if($payment_methods->num_rows() > 0)
                        {
                            $result = $payment_methods->result();
                            
                            foreach($result as $res)
                            {
                                if($res->payment_method_id == $order->payment_method)
                                {
                                    echo '<option value="'.$res->payment_method_id.'" selected>'.$res->payment_method_name.'</option>';
                                }
                                else
                                {
                                    echo '<option value="'.$res->payment_method_id.'">'.$res->payment_method_name.'</option>';
                                }
                            }
                        }
                        ?>
                    </select>
                </div>
            </div> 
            <!-- brand Name -->
            <div class="form-group col-lg-4">
                <label class="col-lg-4 control-label">Order Instructions</label>
                <div class="col-lg-8">
                	<textarea class="form-control" name="order_instructions"><?php echo $order->order_instructions;?></textarea>
                </div>
            </div>
            <div class="form-actions center-align">
                <button class="submit btn btn-primary" type="submit">
                    Update Order
                </button>
            </div>
            <br />
            <?php echo form_close();?>
            
            <div class="row">
            	<div class="col-md-12">
                	<div class="pull-right">
                    <a href="#order_products" class="btn btn-primary" data-toggle="modal">Add Products</a>
                    <?php $order_id = $order->order_id; $order_number = $order->order_number; echo '<a href="'.site_url().'finish-order/'.$order_id.'" class="btn btn-sm btn-success" onclick="return confirm(\'Do you really want to complete this order '.$order_number.'?\');">Complete</a>
                    <a href="'.site_url().'cancel-order/'.$order_id.'" class="btn btn-sm btn-danger" onclick="return confirm(\'Do you really want to cancel this order '.$order_number.'?\');">Cancel</a>
                    <a href="'.site_url().'deactivate-order/'.$order_id.'" class="btn btn-sm btn-default" onclick="return confirm(\'Do you really want to deactivate this order '.$order_number.'?\');">Deactivate</a>
                    <a href="'.site_url().'delete-order/'.$order_id.'" class="btn btn-sm btn-danger" onclick="return confirm(\'Do you really want to delete this order '.$order_number.'?\');">Delete</a>';?>
                    </div>
                    <p>Order Products</p>
                </div>
            </div>
            
            <div class="row">
            	<div class="col-md-12">
            		<table class="table table-condensed table-striped">
                    	<tr>
                        	<th>Image</th>
                        	<th>Product</th>
                        	<th>Quantity</th>
                        	<th>Price</th>
                        	<th>Total</th>
                        	<th></th>
                        </tr>
                        
                        <?php
                        	if($order_items->num_rows() > 0)
							{
								$items = $order_items->result();
								$total_price = 0;
								$total_items = 0;
								
								foreach($items as $ord)
								{
									$order_item_id = $ord->order_item_id;
									$product = $ord->product_name;
									$image = $ord->product_thumb_name;
									$quantity = $ord->quantity;
									$price = $ord->price;
									
									$total_price += ($quantity*$price);
									$total_items += $quantity;
									
									echo '
									<tr>
										<td><img src="'.base_url().'assets/images/products/images/'.$image.'" class="img-responsive"/></td>
										<td>'.$product.'</td>
										<td class="update_cart">
											<input type="number" value="'.$quantity.'" id="update_quantity'.$order_item_id.'" class="form-control" style="width:20%;"/>
											<a href="'.$order_item_id.'" class="btn btn-primary">Update</a>
										</td>
										<td>'.number_format($price, 0, '.', ',').'</td>
										<td>'.number_format(($quantity*$price), 0, '.', ',').'</td>
										<td><a href="'.site_url().'orders/delete-order-item/'.$order->order_id.'/'.$order_item_id.'" class="btn btn-danger" onclick="return confirm(\'Do you want to delete this item?\');">Delete</a></td>
									</tr>
									';
								}
									
								echo '
								<tr>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td>'.number_format(($total_price), 0, '.', ',').'</td>
								</tr>
								';
							}
						?>
                    </table>
                </div>
            </div>
		</div>
        
        <!-- Modal -->
        <div id="order_products" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title">Add Products</h4>
                    </div>
                    
                    <div class="modal-body add_product">
                        <table class="table table-striped table-condensed table-hover">
                            <tr>
                                <th>Image</th>
                                <th>Code</th>
                                <th>Product</th>
                                <th>Price</th>
                                <th>Balance</th>
                                <th>Quantity</th>
                            </tr>
                        	<?php
                            	foreach ($products as $row)
								{
									$sale_price = $row->sale_price;
									$featured = $row->featured;
									$product_id = $row->product_id;
									$product_name = $row->product_name;
									$product_selling_price = $row->product_selling_price;
									$product_code = $row->product_code;
									$product_balance = $row->product_balance;
									$thumb = $row->product_thumb_name;
									
									if($sale_price > 0)
									{
										$product_selling_price = $product_selling_price - ($product_selling_price*($sale_price/100));
									}
									
									echo '
									<tr>
										<td><img src="'.base_url().'assets/images/products/images/'.$thumb.'" class="img-responsive"/></td>
										<td>'.$product_code.'</td>
										<td>'.$product_name.'</td>
										<td>'.number_format($product_selling_price, 0, '.', ',').'</td>
										<td>'.$product_balance.'</td>
										<td>
											<input type="hidden" id="price'.$product_id.'" value="'.$product_selling_price.'" class="form-control" />
											<input type="number" id="quantity'.$product_id.'" value="1" class="form-control" />
											<a href="'.$product_id.'" class="btn btn-primary">Add Product</a>
										</td>
									</tr>
									';
								}
							?>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
                    </div>
                </div>
            </div>
        </div>

<script type="text/javascript">

$(document).on("click","div.add_product a",function(e)
{
	e.preventDefault();
	var product_id = $(this).attr('href');
	var quantity = $('#quantity'+product_id).val();
	var price = $('#price'+product_id).val();
	
	window.location.href = '<?php echo site_url();?>orders/add-product/<?php echo $order->order_id?>/'+product_id+'/'+quantity+'/'+price;
	
	return false;
});

$(document).on("click","td.update_cart a",function(e)
{
	e.preventDefault();
	var order_item_id = $(this).attr('href');
	var quantity = $('#update_quantity'+order_item_id).val();
	
	window.location.href = '<?php echo site_url();?>orders/update-cart/<?php echo $order->order_id?>/'+order_item_id+'/'+quantity;
	
	return false;
});
</script>