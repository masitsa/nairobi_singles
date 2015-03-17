<?php

class Orders_model extends CI_Model 
{
	/*
	*	Retrieve all orders
	*	@param string $table
	* 	@param string $where
	*
	*/
	public function get_all_orders($table, $where, $per_page, $page)
	{
		//retrieve all orders
		$this->db->from($table);
		$this->db->select('orders.*, users.first_name, users.other_names, order_status.order_status_name');
		$this->db->where($where);
		$this->db->order_by('created, order_number');
		$query = $this->db->get('', $per_page, $page);
		
		return $query;
	}
	
	/*
	*	Retrieve all orders of a user
	*
	*/
	public function get_user_orders($user_id)
	{
		$this->db->where('user_id = '.$user_id);
		$this->db->order_by('created', 'DESC');
		$query = $this->db->get('orders');
		
		return $query;
	}
	
	/*
	*	Retrieve an order
	*
	*/
	public function get_order($order_id)
	{
		$this->db->select('*');
		$this->db->where('orders.order_status = order_status.order_status_id AND users.user_id = orders.user_id AND orders.order_id = '.$order_id);
		$query = $this->db->get('orders, order_status, users');
		
		return $query;
	}
	
	/*
	*	Retrieve all order items of an order
	*
	*/
	public function get_order_items($order_id)
	{
		$this->db->select('product.product_name, product.product_thumb_name, order_item.*');
		$this->db->where('product.product_id = order_item.product_id AND order_item.order_id = '.$order_id);
		$query = $this->db->get('order_item, product');
		
		return $query;
	}
	
	/*
	*	Create order number
	*
	*/
	public function create_order_number()
	{
		//select product code
		$this->db->from('orders');
		$this->db->where("order_number LIKE 'ORD".date('y')."/%'");
		$this->db->select('MAX(order_number) AS number');
		$query = $this->db->get();
		
		if($query->num_rows() > 0)
		{
			$result = $query->result();
			$number =  $result[0]->number;
			$number++;//go to the next number
			
			if($number == 1){
				$number = "ORD".date('y')."/001";
			}
		}
		else{//start generating receipt numbers
			$number = "ORD".date('y')."/001";
		}
		
		return $number;
	}
	
	/*
	*	Create the total cost of an order
	*	@param int order_id
	*
	*/
	public function calculate_order_cost($order_id)
	{
		//select product code
		$this->db->from('order_item');
		$this->db->where('order_id = '.$order_id);
		$this->db->select('SUM(price * quantity) AS total_cost');
		$query = $this->db->get();
		
		if($query->num_rows() > 0)
		{
			$result = $query->result();
			$total_cost =  $result[0]->total_cost;
		}
		
		else
		{
			$total_cost = 0;
		}
		
		return $total_cost;
	}
	
	/*
	*	Add a new order
	*
	*/
	public function add_order()
	{
		$order_number = $this->create_order_number();
		
		$data = array(
				'order_number'=>$order_number,
				'user_id'=>$this->input->post('user_id'),
				'payment_method'=>$this->input->post('payment_method'),
				'order_status'=>1,
				'order_instructions'=>$this->input->post('order_instructions'),
				'created'=>date('Y-m-d H:i:s'),
				'created_by'=>$this->session->userdata('user_id'),
				'modified_by'=>$this->session->userdata('user_id')
			);
			
		if($this->db->insert('orders', $data))
		{
			return $this->db->insert_id();
		}
		else{
			return FALSE;
		}
	}
	
	/*
	*	Update an order
	*	@param int $order_id
	*
	*/
	public function _update_order($order_id)
	{
		$order_number = $this->create_order_number();
		
		$data = array(
				'user_id'=>$this->input->post('user_id'),
				'payment_method'=>$this->input->post('payment_method'),
				'order_status'=>1,
				'order_instructions'=>$this->input->post('order_instructions'),
				'modified_by'=>$this->session->userdata('user_id')
			);
		
		$this->db->where('order_id', $order_id);
		if($this->db->update('orders', $data))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	/*
	*	Retrieve all orders
	*	@param string $table
	* 	@param string $where
	*
	*/
	public function get_payment_methods()
	{
		//retrieve all orders
		$this->db->from('payment_method');
		$this->db->select('*');
		$this->db->order_by('payment_method_name');
		$query = $this->db->get();
		
		return $query;
	}
	
	/*
	*	Add a order product
	*
	*/
	public function add_product($order_id, $product_id, $quantity, $price)
	{
		//Check if item exists
		$this->db->select('*');
		$this->db->where('product_id = '.$product_id.' AND order_id = '.$order_id);
		$query = $this->db->get('order_item');
		
		if($query->num_rows() > 0)
		{
			$result = $query->row();
			$qty = $result->quantity;
			
			$quantity += $qty;
			
			$data = array(
					'quantity'=>$quantity
				);
				
			$this->db->where('product_id = '.$product_id.' AND order_id = '.$order_id);
			if($this->db->update('order_item', $data))
			{
				return TRUE;
			}
			else{
				return FALSE;
			}
		}
		
		else
		{
			$data = array(
					'order_id'=>$order_id,
					'product_id'=>$product_id,
					'quantity'=>$quantity,
					'price'=>$price
				);
				
			if($this->db->insert('order_item', $data))
			{
				return TRUE;
			}
			else{
				return FALSE;
			}
		}
	}
	
	/*
	*	Update an order item
	*
	*/
	public function update_cart($order_item_id, $quantity)
	{
		$data = array(
					'quantity'=>$quantity
				);
				
		$this->db->where('order_item_id = '.$order_item_id);
		if($this->db->update('order_item', $data))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	/*
	*	Delete an existing order item
	*	@param int $product_id
	*
	*/
	public function delete_order_item($order_item_id)
	{
		if($this->db->delete('order_item', array('order_item_id' => $order_item_id)))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
}