<?php   if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once "./application/modules/admin/controllers/admin.php";

class Orders extends admin {
	
	function __construct()
	{
		parent:: __construct();
		$this->load->model('users_model');
		$this->load->model('orders_model');
		$this->load->model('products_model');
	}
    
	/*
	*
	*	Default action is to show all the orders
	*
	*/
	public function index() 
	{
		$where = 'orders.order_status = order_status.order_status_id AND users.user_id = orders.user_id';
		$table = 'orders, order_status, users';
		//pagination
		$this->load->library('pagination');
		$config['base_url'] = base_url().'all-orders';
		$config['total_rows'] = $this->users_model->count_items($table, $where);
		$config['uri_segment'] = 2;
		$config['per_page'] = 20;
		$config['num_links'] = 5;
		
		
		$config['full_tag_open'] = '<ul class="pagination pull-right">';
		$config['full_tag_close'] = '</ul>';
		
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		
		$config['next_tag_open'] = '<li>';
		$config['next_link'] = 'Next';
		$config['next_tag_close'] = '</span>';
		
		$config['prev_tag_open'] = '<li>';
		$config['prev_link'] = 'Prev';
		$config['prev_tag_close'] = '</li>';
		
		$config['cur_tag_open'] = '<li class="active">';
		$config['cur_tag_close'] = '</li>';
		
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$this->pagination->initialize($config);
		
		$page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
        $data["links"] = $this->pagination->create_links();
		$query = $this->orders_model->get_all_orders($table, $where, $config["per_page"], $page);
		
		if ($query->num_rows() > 0)
		{
			$v_data['query'] = $query;
			$v_data['page'] = $page;
			$data['content'] = $this->load->view('orders/all_orders', $v_data, true);
		}
		
		else
		{
			$data['content'] = '<a href="'.site_url().'add-order" class="btn btn-success pull-right">Add order</a>There are no orders';
		}
		$data['title'] = 'All orders';
		
		$this->load->view('templates/general_admin', $data);
	}
    
	/*
	*
	*	Add a new order
	*
	*/
	public function add_order() 
	{
		//form validation rules
		$this->form_validation->set_rules('order_instructions', 'Order Instructions', 'required|xss_clean');
		$this->form_validation->set_rules('user_id', 'Customer', 'required|xss_clean');
		$this->form_validation->set_rules('payment_method', 'Payment Method', 'required|xss_clean');
		
		//if form has been submitted
		if ($this->form_validation->run())
		{
			$order_id = $this->orders_model->add_order();
			//update order
			if($order_id > 0)
			{
				redirect('edit-order/'.$order_id);
			}
			
			else
			{
				$this->session->set_userdata('error_message', 'Could not update order. Please try again');
			}
		}
		
		//open the add new order
		$data['title'] = 'Add Order';
		
		$v_data['all_users'] = $this->users_model->get_all_front_end_users();
		$v_data['payment_methods'] = $this->orders_model->get_payment_methods();
		
		$data['content'] = $this->load->view('orders/add_order', $v_data, true);
		
		$this->load->view('templates/general_admin', $data);
	}
    
	/*
	*
	*	Edit an existing order
	*	@param int $order_id
	*
	*/
	public function edit_order($order_id) 
	{
		//form validation rules
		$this->form_validation->set_rules('order_instructions', 'Order Instructions', 'required|xss_clean');
		$this->form_validation->set_rules('user_id', 'Customer', 'required|xss_clean');
		$this->form_validation->set_rules('payment_method', 'Payment Method', 'required|xss_clean');
		
		//if form has been submitted
		if ($this->form_validation->run())
		{
			//update order
			if($this->orders_model->update_order($order_id))
			{
				$this->session->set_userdata('success_message', 'Order updated successfully');
			}
			
			else
			{
				$this->session->set_userdata('error_message', 'Could not update order. Please try again');
			}
		}
		
		//open the add new order
		$data['title'] = 'Edit Order';
		
		//select the order from the database
		$query = $this->orders_model->get_order($order_id);
		
		if ($query->num_rows() > 0)
		{
			$v_data['order'] = $query->row();
			$query = $this->products_model->all_products();
			$v_data['products'] = $query->result();
			$v_data['order_items'] = $this->orders_model->get_order_items($order_id);
			$v_data['all_users'] = $this->users_model->get_all_front_end_users();
			$v_data['payment_methods'] = $this->orders_model->get_payment_methods();
			
			$data['content'] = $this->load->view('orders/edit_order', $v_data, true);
		}
		
		else
		{
			$data['content'] = 'Order does not exist';
		}
		
		$this->load->view('templates/general_admin', $data);
	}
    
	/*
	*
	*	Add products to an order
	*	@param int $order_id
	*	@param int $product_id
	*	@param int $quantity
	*
	*/
	public function add_product($order_id, $product_id, $quantity, $price)
	{
		if($this->orders_model->add_product($order_id, $product_id, $quantity, $price))
		{
			redirect('edit-order/'.$order_id);
		}
	}
    
	/*
	*
	*	Add products to an order
	*	@param int $order_id
	*	@param int $order_item_id
	*	@param int $quantity
	*
	*/
	public function update_cart($order_id, $order_item_id, $quantity)
	{
		if($this->orders_model->update_cart($order_item_id, $quantity))
		{
			redirect('edit-order/'.$order_id);
		}
	}
    
	/*
	*
	*	Delete an existing order
	*	@param int $order_id
	*
	*/
	public function delete_order($order_id)
	{
		//delete order
		$this->db->delete('orders', array('order_id' => $order_id));
		$this->db->delete('order_item', array('order_item_id' => $order_id));
		redirect('all-orders');
	}
    
	/*
	*
	*	Add products to an order
	*	@param int $order_item_id
	*
	*/
	public function delete_order_item($order_id, $order_item_id)
	{
		if($this->orders_model->delete_order_item($order_item_id))
		{
			redirect('edit-order/'.$order_id);
		}
	}
    
	/*
	*
	*	Complete an order
	*	@param int $order_id
	*
	*/
	public function finish_order($order_id)
	{
		$data = array(
					'order_status'=>2
				);
				
		$this->db->where('order_id = '.$order_id);
		$this->db->update('orders', $data);
		
		redirect('all-orders');
	}
    
	/*
	*
	*	Cancel an order
	*	@param int $order_id
	*
	*/
	public function cancel_order($order_id)
	{
		$data = array(
					'order_status'=>3
				);
				
		$this->db->where('order_id = '.$order_id);
		$this->db->update('orders', $data);
		
		redirect('all-orders');
	}
    
	/*
	*
	*	Deactivate an order
	*	@param int $order_id
	*
	*/
	public function deactivate_order($order_id)
	{
		$data = array(
					'order_status'=>1
				);
				
		$this->db->where('order_id = '.$order_id);
		$this->db->update('orders', $data);
		
		redirect('all-orders');
	}
}
?>