<?php

class Products_model extends CI_Model 
{	
	/*
	*	Retrieve all products
	*
	*/
	public function all_products()
	{
		$this->db->where('product_status = 1');
		$query = $this->db->get('product');
		
		return $query;
	}
	
	/*
	*	Retrieve all products
	*	@param string $table
	* 	@param string $where
	*
	*/
	public function get_all_products($table, $where, $per_page, $page, $limit = NULL, $order_by = 'created', $order_method = 'DESC')
	{
		$this->db->from($table);
		$this->db->select('product.sale_price, product.featured, product.product_id, product.product_name, product.product_buying_price, product.product_selling_price, product.product_status, product.product_description, product.product_code, product.product_balance, product.brand_id, product.category_id, product.created, product.created_by, product.last_modified, product.modified_by, product.product_thumb_name, product.product_image_name, category.category_name, brand.brand_name');
		$this->db->where($where);
		$this->db->order_by($order_by, $order_method);
		
		if(isset($limit))
		{
			$query = $this->db->get('', $limit);
		}
		
		else
		{
			$query = $this->db->get('', $per_page, $page);
		}
		
		return $query;
	}
	
	/*
	*	Add a new product
	*	@param string $image_name
	*
	*/
	public function add_product($image_name, $thumb_name)
	{
		$code = $this->create_product_code($this->input->post('category_id'));
		
		$data = array(
				'product_name'=>ucwords(strtolower($this->input->post('product_name'))),
				'featured'=>$this->input->post('featured'),
				'sale_price'=>$this->input->post('product_sale_price'),
				'product_buying_price'=>$this->input->post('product_buying_price'),
				'product_selling_price'=>$this->input->post('product_selling_price'),
				'product_status'=>$this->input->post('product_status'),
				'product_description'=>$this->input->post('product_description'),
				'product_code'=>$code,
				'product_balance'=>$this->input->post('product_balance'),
				'brand_id'=>$this->input->post('brand_id'),
				'category_id'=>$this->input->post('category_id'),
				'created'=>date('Y-m-d H:i:s'),
				'created_by'=>$this->session->userdata('user_id'),
				'modified_by'=>$this->session->userdata('user_id'),
				'product_thumb_name'=>$thumb_name,
				'product_image_name'=>$image_name
			);
			
		if($this->db->insert('product', $data))
		{
			return $this->db->insert_id();
		}
		else{
			return FALSE;
		}
	}
	
	/*
	*	Update an existing product
	*	@param string $image_name
	*	@param int $product_id
	*
	*/
	public function update_product($file_name, $thumb_name, $product_id)
	{
		$data = array(
				'product_name'=>ucwords(strtolower($this->input->post('product_name'))),
				'featured'=>$this->input->post('featured'),
				'sale_price'=>$this->input->post('product_sale_price'),
				'product_buying_price'=>$this->input->post('product_buying_price'),
				'product_selling_price'=>$this->input->post('product_selling_price'),
				'product_status'=>$this->input->post('product_status'),
				'product_description'=>$this->input->post('product_description'),
				'product_balance'=>$this->input->post('product_balance'),
				'brand_id'=>$this->input->post('brand_id'),
				'category_id'=>$this->input->post('category_id'),
				'modified_by'=>$this->session->userdata('user_id'),
				'product_image_name'=>$file_name,
				'product_thumb_name'=>$thumb_name
			);
			
		$this->db->where('product_id', $product_id);
		if($this->db->update('product', $data))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	/*
	*	get a single product's details
	*	@param int $product_id
	*
	*/
	public function get_product($product_id)
	{
		//retrieve all users
		$this->db->from('product, category, brand');
		$this->db->select('product.sale_price, product.featured, product.product_thumb_name, product.product_id, product.product_name, product.product_buying_price, product.product_selling_price, product.product_status, product.product_description, product.product_code, product.product_balance, product.brand_id, product.category_id, product.created, product.created_by, product.last_modified, product.modified_by, product.product_image_name, category.category_name, brand.brand_name');
		$this->db->where('product.category_id = category.category_id AND product.brand_id = brand.brand_id AND product_id = '.$product_id);
		$query = $this->db->get();
		
		return $query;
	}
	
	/*
	*	Delete an existing product
	*	@param int $product_id
	*
	*/
	public function delete_product($product_id)
	{
		if($this->db->delete('product', array('product_id' => $product_id)))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	/*
	*	Activate a deactivated product
	*	@param int $product_id
	*
	*/
	public function activate_product($product_id)
	{
		$data = array(
				'product_status' => 1
			);
		$this->db->where('product_id', $product_id);
		
		if($this->db->update('product', $data))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	/*
	*	Deactivate an activated product
	*	@param int $product_id
	*
	*/
	public function deactivate_product($product_id)
	{
		$data = array(
				'product_status' => 0
			);
		$this->db->where('product_id', $product_id);
		
		if($this->db->update('product', $data))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	public function create_product_code($category_id)
	{
		//get category_details
		$query = $this->categories_model->get_category($category_id);
		
		if($query->num_rows() > 0)
		{
			$result = $query->result();
			$category_preffix =  $result[0]->category_preffix;
			
			//select product code
			$this->db->from('product');
			$this->db->select('MAX(product_code) AS number');
			$this->db->where("product_code LIKE '".$category_preffix."%'");
			$query = $this->db->get();
			
			if($query->num_rows() > 0)
			{
				$result = $query->result();
				$number =  $result[0]->number;
				$number++;//go to the next number
				
				if($number == 1){
					$number = $category_preffix."001";
				}
			}
			else{//start generating receipt numbers
				$number = $category_preffix."001";
			}
		}
		
		else
		{
			$number = '001';
		}
		
		return $number;
	}
	
	/*
	*	Save a product's gallery image
	*	@param int $product_id
	*	@param char $image
	*	@param char $thumb
	*
	*/
	public function save_gallery_file($product_id, $image, $thumb)
	{
		//save the image data to the database
		$data = array(
			'product_id' => $product_id,
			'product_image_name' => $image,
			'product_image_thumb' => $thumb
		);
		
		if($this->db->insert('product_image', $data))
		{
			return $this->db->insert_id();
		}
		else
		{
			return FALSE;
		}
	}
	
	/*
	*	get a single product's gallery images
	*	@param int $product_id
	*
	*/
	public function get_gallery_images($product_id)
	{
		//retrieve all users
		$this->db->from('product_image');
		$this->db->select('*');
		$this->db->where('product_id = '.$product_id);
		$query = $this->db->get();
		
		return $query;
	}
	
	/*
	*	delete a product's gallery images
	*	@param int $product_id
	*
	*/
	public function delete_gallery_images($product_id)
	{
		if($this->db->delete('product_image', array('product_id' => $product_id)))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	public function delete_gallery_image($product_image_id)
	{
		if($this->db->delete('product_image', array('product_image_id' => $product_image_id)))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	/**
	 * Get all the feature valuess of a feature
	 * Called when adding a new product
	 *
	 * @param int category_feature_id
	 *
	 * @return object
	 *
	 */
	function fetch_new_category_features($category_feature_id)
	{
		if(isset($_SESSION['name'.$category_feature_id]))
		{
			$total_features = count($_SESSION['name'.$category_feature_id]);
			
			if($total_features > 0)
			{
				$features = '';
				//var_dump($_SESSION['name'.$category_feature_id]);
				for($r = 0; $r < $total_features; $r++)
				{
					if(isset($_SESSION['name'.$category_feature_id][$r]))
					{
						$name = mysql_real_escape_string($_SESSION['name'.$category_feature_id][$r]);
						$quantity = $_SESSION['quantity'.$category_feature_id][$r];
						$price = $_SESSION['price'.$category_feature_id][$r];
						$image = '<img src="'. base_url().'assets/images/features/'.$_SESSION['thumb'.$category_feature_id][$r].'" alt="'.$name.'"/>';
						
						$features .= '
							<tr>
								<td>
									<a href="'.$r.'" class="delete_feature" id="'.$category_feature_id.'" onclick="return confirm(\'Do you want to delete '.$name.'?\');"><i class="icon-trash butn butn-danger"></i></a>
								</td>
								<td>'.$name.'</td>
								<td>'.$quantity.'</td>
								<td>'.$price.'</td>
								<td>'.$image.'</td>
							</tr>
						';
					}
				}
				
				return $features;
			}
		
			else{
				return NULL;
			}
		}
		
		else{
			return NULL;
		}
	}
	
	function add_new_features($category_feature_id, $feature_name, $feature_quantity, $feature_price, $image_name = 'None', $thumb_name = 'None')
	{
		if(isset($_SESSION['name'.$category_feature_id]))
		{
			$total_features = count($_SESSION['name'.$category_feature_id]);
			
			if($total_features > 0)
			{
				$r = $total_features;
			}
			
			else
			{
				$r = 0;
			}
				
		}
		
		else{
			$r = 0;
		}
		
		$_SESSION['name'.$category_feature_id][$r] = $feature_name;
		$_SESSION['quantity'.$category_feature_id][$r] = $feature_quantity;
		$_SESSION['price'.$category_feature_id][$r] = $feature_price;
		$_SESSION['image'.$category_feature_id][$r] = $image_name;
		$_SESSION['thumb'.$category_feature_id][$r] = $thumb_name;
		
		$feature_values = $this->fetch_new_category_features($category_feature_id);
		$options = '';
		
		if(isset($feature_values))
		{
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
		
		return $options;
	}
	
	/**
	 * Get all the feature valuess of a feature
	 * Called when adding a new product
	 *
	 * @param int category_feature_id
	 *
	 * @return object
	 *
	 */
	function save_features($product_id)
	{
		$features = $this->features_model->all_features();
		
		if($features->num_rows() > 0)
		{
			$feature = $features->result();
			
			foreach($feature as $feat)
			{
				$feature_id = $feat->feature_id;
				
				if(isset($_SESSION['name'.$feature_id]))
				{
					$total_features = count($_SESSION['name'.$feature_id]);
					
					if($total_features > 0)
					{	
						for($r = 0; $r < $total_features; $r++)
						{
							if(isset($_SESSION['name'.$feature_id][$r]))
							{
								$name = $_SESSION['name'.$feature_id][$r];
								$quantity = $_SESSION['quantity'.$feature_id][$r];
								$price = $_SESSION['price'.$feature_id][$r];
								$image = $_SESSION['image'.$feature_id][$r];
								$thumb = $_SESSION['thumb'.$feature_id][$r];
								
								$data = array(
										'feature_id'=>$feature_id,
										'product_id'=>$product_id,
										'feature_value'=>$name,
										'quantity'=>$quantity,
										'price'=>$price,
										'image'=>$image,
										'thumb'=>$thumb
									);
									
								$this->db->insert('product_feature', $data);
							}
						}
					}
				}
			}
		}
		session_unset();
		return TRUE;
	}
	
	/*
	*	get a single product's features
	*	@param int $product_id
	*
	*/
	public function get_features($product_id)
	{
		//retrieve all users
		$this->db->from('product_feature');
		$this->db->select('*');
		$this->db->where('product_id = '.$product_id);
		$query = $this->db->get();
		
		return $query;
	}
	
	/*
	*	delete a product's features
	*	@param int $product_id
	*
	*/
	public function delete_features($product_id)
	{
		
		if($this->db->delete('product_feature', array('product_id' => $product_id)))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	/*
	*	get a single product's features
	*	@param int $feature_id
	*
	*/
	public function get_product_feature($product_feature_id)
	{
		//retrieve all users
		$this->db->from('product_feature');
		$this->db->select('*');
		$this->db->where('product_feature_id = '.$product_feature_id);
		$query = $this->db->get();
		
		return $query;
	}
	
	/*
	*	delete a product feature
	*	@param int $product_feature_id
	*
	*/
	public function delete_product_feature($product_feature_id)
	{
		
		if($this->db->delete('product_feature', array('product_feature_id' => $product_feature_id)))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	/*
	*	Retrieve latest products
	*
	*/
	public function get_latest_products()
	{
		$this->db->select('*')->from('product')->where("product_status = 1")->order_by("created", 'DESC');
		$query = $this->db->get('',12);
		
		return $query;
	}
	
	/*
	*	Retrieve featured products
	*
	*/
	public function get_featured_products()
	{
		$this->db->select('*')->from('product')->where("product_status = 1 AND featured = 1")->order_by("created", 'DESC');
		$query = $this->db->get();
		
		return $query;
	}
	
	/*
	*	Retrieve max product price
	*
	*/
	public function get_max_product_price()
	{
		$this->db->select('MAX(product_selling_price) AS price')->from('product')->where("product_status = 1");
		$query = $this->db->get();
		$result = $query->row();
		
		return $result->price;
	}
	
	/*
	*	Retrieve min product price
	*
	*/
	public function get_min_product_price()
	{
		$this->db->select('MIN(product_selling_price) AS price')->from('product')->where("product_status = 1");
		$query = $this->db->get();
		$result = $query->row();
		
		return $result->price;
	}
	
	/*
	*	get a similar products
	*	@param int $product_id
	*
	*/
	public function get_similar_products($product_id)
	{
		//retrieve all users
		$this->db->from('product');
		$this->db->select('*');
		$this->db->where('(category_id = (SELECT category_id FROM product WHERE product_id = '.$product_id.')) AND (product_id <> '.$product_id.')');
		$query = $this->db->get('', 10);
		
		return $query;
	}
	
	public function update_clicks($product_id)
	{
		//get clicks);
		$this->db->select('clicks');
		$this->db->where('product_id', $product_id);
		$query = $this->db->get('product');
		
		$row = $query->row();
		$clicks = $row->clicks;
		
		//increment clicks
		$clicks++;
		
		//save clicks
		$data = array(
				'clicks'=>$clicks
			);
			
		$this->db->where('product_id', $product_id);
		if($this->db->update('product', $data))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
}
?>