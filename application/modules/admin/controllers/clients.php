<?php   if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once "./application/modules/admin/controllers/admin.php";

class Clients extends admin 
{	
	function __construct()
	{
		parent:: __construct();
		$this->load->model('users_model');
		$this->load->model('clients_model');
		$this->load->model('file_model');
		$this->load->model('site/payments_model');
		
		$this->load->library('image_lib');
	}
    
	/*
	*
	*	Default action is to show all the clients
	*
	*/
	public function index($order = 'created', $order_method = 'DESC') 
	{
		$where = 'client.gender_id = gender.gender_id';
		$table = 'client, gender';
		//pagination
		$segment = 4;
		$this->load->library('pagination');
		$config['base_url'] = base_url().'all-clients/'.$order.'/'.$order_method;
		$config['total_rows'] = $this->users_model->count_items($table, $where);
		$config['uri_segment'] = $segment;
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
		
		$config['cur_tag_open'] = '<li class="active"><a href="#">';
		$config['cur_tag_close'] = '</a></li>';
		
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$this->pagination->initialize($config);
		
		$page = ($this->uri->segment($segment)) ? $this->uri->segment($segment) : 0;
        $data["links"] = $this->pagination->create_links();
		$query = $this->clients_model->get_all_clients($table, $where, $config["per_page"], $page, $order, $order_method);
		
		$v_data['profile_image_path'] = $this->profile_image_path;
		$v_data['profile_image_location'] = $this->profile_image_location;
		
		//change of order method 
		if($order_method == 'DESC')
		{
			$order_method = 'ASC';
		}
		
		else
		{
			$order_method = 'DESC';
		}
		
		if ($query->num_rows() > 0)
		{
			$v_data['order'] = $order;
			$v_data['order_method'] = $order_method;
			$v_data['query'] = $query;
			$v_data['page'] = $page;
			$data['content'] = $this->load->view('clients/all_clients', $v_data, true);
		}
		
		else
		{
			$data['content'] = '<a href="#" class="btn btn-success pull-right">Add client</a>There are no clients';
		}
		$data['title'] = 'All clients';
		
		$this->load->view('templates/general_admin', $data);
	}
    
	/*
	*
	*	Add a new client
	*
	*/
	public function add_client() 
	{
		//form validation rules
		$this->form_validation->set_rules('client_name', 'client Name', 'required|xss_clean');
		$this->form_validation->set_rules('client_status', 'client Status', 'required|xss_clean');
		
		//if form has been submitted
		if ($this->form_validation->run())
		{
			//upload product's gallery images
			$resize['width'] = 600;
			$resize['height'] = 800;
			
			if(is_uploaded_file($_FILES['client_image']['tmp_name']))
			{
				$clients_path = $this->clients_path;
				/*
					-----------------------------------------------------------------------------------------
					Upload image
					-----------------------------------------------------------------------------------------
				*/
				$response = $this->file_model->upload_file($clients_path, 'client_image', $resize);
				if($response['check'])
				{
					$file_name = $response['file_name'];
					$thumb_name = $response['thumb_name'];
				}
			
				else
				{
					$this->session->set_userdata('error_message', $response['error']);
					
					$data['title'] = 'Add New Client';
					$v_data['all_clients'] = $this->clients_model->all_clients();
					$data['content'] = $this->load->view('clients/add_client', $v_data, true);
					$this->load->view('templates/general_admin', $data);
					break;
				}
			}
			
			else{
				$file_name = '';
			}
			
			if($this->clients_model->add_client($file_name))
			{
				$this->session->set_userdata('success_message', 'client added successfully');
				redirect('all-clients');
			}
			
			else
			{
				$this->session->set_userdata('error_message', 'Could not add client. Please try again');
			}
		}
		
		//open the add new client
		$data['title'] = 'Add New client';
		$data['content'] = $this->load->view('clients/add_client', '', true);
		$this->load->view('templates/general_admin', $data);
	}
    
	/*
	*
	*	Edit an existing client
	*	@param int $client_id
	*
	*/
	public function edit_client($client_id) 
	{
		//form validation rules
		$this->form_validation->set_rules('client_name', 'client Name', 'required|xss_clean');
		$this->form_validation->set_rules('client_status', 'client Status', 'required|xss_clean');
		
		//if form has been submitted
		if ($this->form_validation->run())
		{
			//upload product's gallery images
			$resize['width'] = 600;
			$resize['height'] = 800;
			
			if(is_uploaded_file($_FILES['client_image']['tmp_name']))
			{
				$clients_path = $this->clients_path;
				
				//delete original image
				$this->file_model->delete_file($clients_path."\\".$this->input->post('current_image'));
				
				//delete original thumbnail
				$this->file_model->delete_file($clients_path."\\thumbnail_".$this->input->post('current_image'));
				/*
				/*
					-----------------------------------------------------------------------------------------
					Upload image
					-----------------------------------------------------------------------------------------
				*/
				$response = $this->file_model->upload_file($clients_path, 'client_image', $resize);
				if($response['check'])
				{
					$file_name = $response['file_name'];
					$thumb_name = $response['thumb_name'];
				}
			
				else
				{
					$this->session->set_userdata('error_message', $response['error']);
					
					$data['title'] = 'Edit client';
					$query = $this->clients_model->get_client($client_id);
					if ($query->num_rows() > 0)
					{
						$v_data['client'] = $query->result();
						$v_data['all_clients'] = $this->clients_model->all_clients();
						$data['content'] = $this->load->view('clients/edit_client', $v_data, true);
					}
					
					else
					{
						$data['content'] = 'client does not exist';
					}
					
					$this->load->view('templates/general_admin', $data);
					break;
				}
			}
			
			else{
				$file_name = $this->input->post('current_image');
			}
			//update client
			if($this->clients_model->update_client($file_name, $client_id))
			{
				$this->session->set_userdata('success_message', 'client updated successfully');
				redirect('all-clients');
			}
			
			else
			{
				$this->session->set_userdata('error_message', 'Could not update client. Please try again');
			}
		}
		
		//open the add new client
		$data['title'] = 'Edit client';
		
		//select the client from the database
		$query = $this->clients_model->get_client($client_id);
		
		if ($query->num_rows() > 0)
		{
			$v_data['client'] = $query->result();
			$v_data['all_clients'] = $this->clients_model->all_active_clients();
			
			$data['content'] = $this->load->view('clients/edit_client', $v_data, true);
		}
		
		else
		{
			$data['content'] = 'client does not exist';
		}
		
		$this->load->view('templates/general_admin', $data);
	}
    
	/*
	*
	*	Delete an existing client
	*	@param int $client_id
	*
	*/
	public function delete_client($client_id)
	{
		//delete client image
		$query = $this->clients_model->get_client($client_id);
		
		if ($query->num_rows() > 0)
		{
			$result = $query->result();
			$image = $result[0]->client_image_name;
			
			$this->load->model('file_model');
			//delete image
			$this->file_model->delete_file($this->clients_path."/images/".$image);
			//delete thumbnail
			$this->file_model->delete_file($this->clients_path."/thumbs/".$image);
		}
		$this->clients_model->delete_client($client_id);
		$this->session->set_userdata('success_message', 'client has been deleted');
		redirect('all-clients');
	}
    
	/*
	*
	*	Activate an existing client
	*	@param int $client_id
	*
	*/
	public function activate_client($client_id)
	{
		$this->clients_model->activate_client($client_id);
		$this->session->set_userdata('success_message', 'client activated successfully');
		redirect('all-clients');
	}
    
	/*
	*
	*	Deactivate an existing client
	*	@param int $client_id
	*
	*/
	public function deactivate_client($client_id)
	{
		$this->clients_model->deactivate_client($client_id);
		$this->session->set_userdata('success_message', 'client disabled successfully');
		redirect('all-clients');
	}
}
?>