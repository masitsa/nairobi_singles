<link href="<?php echo base_url();?>assets/jasny/jasny-bootstrap.css" rel="stylesheet">
<script src="<?php echo base_url();?>assets/jasny/jasny-bootstrap.js"></script>
<?php 
	if($all_features->num_rows() > 0){
		$feature = $all_features->result();
?>
		<div class="tabbable tabs-left">
			<ul class="nav nav-tabs">
<?php
			$count = 0;
			foreach($feature as $feat){
				
				$category_feature_id = $feat->feature_id;
				$category_feature_name = $feat->feature_name;
				$_SESSION['category_feature'][$count] = $category_feature_id;
				$count++;
				if($count == 1)
				{
					echo '<li class="active"><a href="#tab'.$count.'" data-toggle="tab">'.$category_feature_name.'</a></li>';
				}
				else
				{
					echo '<li><a href="#tab'.$count.'" data-toggle="tab">'.$category_feature_name.'</a></li>';
				}
			}
			$_SESSION['count'] = $count;
?>
            </ul>
            <div class="tab-content">
<?php
			for($r = 0; $r < $_SESSION['count']; $r++)
			{
				$category_feature_id = $_SESSION['category_feature'][$r];
				$ct = $r+1;
				
				$options = form_open_multipart("admin/products/add_new_feature/".$category_feature_id, array('id' => 'cat_feature'.$category_feature_id, 'name' => $category_feature_id)).'
					<div class="row">
						<div class="col-md-6">
							<div class="form-group"><input type="text" class="form-control feature_input" placeholder="Feature Name" id="sub_feature_name'.$category_feature_id.'" name="sub_feature_name'.$category_feature_id.'"/></div>
							<div class="form-group"><input type="number" class="form-control feature_input" placeholder="Quantity" id="sub_feature_qty'.$category_feature_id.'" name="sub_feature_qty'.$category_feature_id.'"/></div>
							<div class="form-group"><input type="number" class="form-control feature_input" placeholder="Additional Price" id="sub_feature_price'.$category_feature_id.'" name="sub_feature_price'.$category_feature_id.'"/></div>
						</div>
						<div class="col-md-6">
							<div class="fileinput fileinput-new" data-provides="fileinput">
								<div class="fileinput-preview thumbnail" data-trigger="fileinput" style="height:160px;">
									<img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&text=no+image" />
								</div>
								<div>
									<span class="btn btn-file btn_pink"><span class="fileinput-new">Select Image</span><span class="fileinput-exists">Change</span><input type="file" name="feature_image'.$category_feature_id.'"></span>
									<a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
								</div>
							</div>
							
						</div><div class="center-align"><button type="submit" class="btn add_feature">Add Feature</button></div>'.form_close().'
						</div>
						<div class="row">
						<div class="col-md-12">
							<h4>Added Features</h4>
							<div id="new_features'.$category_feature_id.'">
				';
				
				if($features->num_rows() > 0)
				{
					$feat = $features->result();
					$feature_values = '';
					
					foreach($feat as $f)
					{
						$feat_id = $f->feature_id;
						
						if($feat_id == $category_feature_id)
						{
							$name = $f->feature_value;
							$price = $f->price;
							$quantity = $f->quantity;
							$image = '<img src="'. base_url().'assets/images/features/'.$f->thumb.'" alt="'.$name.'"/>';
							
							$feature_values .=
							'
								<tr>
									<td><a href="'.$f->product_feature_id.'" class="delete_product_feature"  onclick="return confirm(\'Do you want to delete '.$name.'?\');"><i class="icon-trash butn butn-danger"></i></a></td>
									<td>'.$name.'</td>
									<td>'.$quantity.'</td>
									<td>'.$price.'</td>
									<td>'.$image.'</td>
								</tr>
							';
						}
					}
					
					$options .= '
						<table class="table table-condensed table-responsive table-hover table-striped">
							<tr>
								<th></th>
								<th>Sub Feature</th>
								<th>Quantity</th>
								<th>Additional Price</th>
								<th>Image</th>
							</tr>
					'.$feature_values.'</table>
					';
				}
				
				else
				{
					$options .= '<p>You have not added any features</p>';
				}
				
				$options .= '</div></div></div>';
				
				if($r == 0)
				{
					echo '
					<div class="tab-pane active" id="tab'.$ct.'">
						'.$options.'
					</div>';
				}
				
				else
				{
					echo '
					<div class="tab-pane" id="tab'.$ct.'">
						'.$options.'
					</div>';
				}
			}
			
?>
  </div>
</div>
<?php
	}
?>