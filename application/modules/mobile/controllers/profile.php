<?php   if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once "./application/modules/mobile/controllers/account.php";

class Profile extends account 
{
	function __construct()
	{
		parent:: __construct();
	}
	
	public function update_profile_image()
	{
		$images_query = $this->profile_model->get_profile_image($this->client_id);
		$v_data['profile_images'] = $this->profile_model->display_profile_image($images_query, $this->profile_image_path, $this->profile_image_location, $this->image_size, $this->thumb_size);
		$images_row = $images_query->row();
		
		$this->session->unset_userdata('profile_error_message');
		
		//upload image if it has been selected
		$response = $this->profile_model->upload_profile_image($this->profile_image_path, $edit_image = $images_row->client_image, $edit_thumb = $images_row->client_thumb);
		if($response)
		{
			$this->session->set_userdata('profile_image_success_message', 'Your profile image has been successfully updated');
			$this->update_profile_image();
		}
		
		$data['content'] = $this->load->view("account/profile/profile_pic", $v_data, TRUE);
		$data['title'] = 'Update profile';
		
		$this->load->view('site/templates/account', $data);
	}
	
	public function about_you()
	{	
		//initialize required variables
		$v_data['profile_image_location'] = 'http://placehold.it/300x200&text=Upload+image';
		$v_data['parent_error'] = '';
		$v_data['child_error'] = '';
		$v_data['client_about_error'] = '';
		$v_data['client_dob1_error'] = '';
		$v_data['client_dob2_error'] = '';
		$v_data['client_dob3_error'] = '';
		$v_data['gender_id_error'] = '';
		$v_data['client_looking_gender_id_error'] = '';
		$v_data['age_group_id_error'] = '';
		$v_data['encounter_id_error'] = '';
		
		//upload image if it has been selected
		$response = $this->profile_model->upload_profile_image($this->profile_image_path);
		if($response)
		{
			$v_data['profile_image_location'] = $this->profile_image_location.$this->session->userdata('profile_file_name');
		}
		
		//case of upload error
		else
		{
			$v_data['profile_image_error'] = $this->session->userdata('profile_error_message');
		}
		
		$youngest_year = date('Y')-17;
		
		$this->form_validation->set_error_delimiters('', '');
		$this->form_validation->set_rules('parent', 'Neighbourhood', 'trim|required|xss_clean');
		$this->form_validation->set_rules('child', 'Location', 'trim|xss_clean');
		$this->form_validation->set_rules('client_about', 'About you', 'trim|required|min_length[20]|xss_clean');
		$this->form_validation->set_rules('client_dob1', 'Day of birth', 'trim|required|greater_than[0]|less_than[32]|xss_clean');
		$this->form_validation->set_rules('client_dob2', 'Month of birth', 'trim|required|greater_than[0]|less_than[13]|xss_clean');
		$this->form_validation->set_rules('client_dob3', 'Year of birth', 'trim|required|greater_than[1900]|less_than['.$youngest_year.']|xss_clean');
		$this->form_validation->set_rules('client_looking_gender_id', 'Looking for', 'trim|required|xss_clean');
		$this->form_validation->set_rules('age_group_id', 'Aged', 'trim|required|xss_clean');
		$this->form_validation->set_rules('encounter_id', 'Encounter type', 'trim|required|xss_clean');
		$this->form_validation->set_rules('gender_id', 'Gender', 'trim|required|xss_clean');
		
		//if form conatins invalid data
		if ($this->form_validation->run())
		{
			if($this->profile_model->register_profile_details($this->client_id, $this->session->userdata('profile_file_name'), $this->session->userdata('profile_thumb_name')))
			{
				//redirect only if logo error isnt present
				if(empty($v_data['profile_image_error']))
				{
					redirect('browse');
				}
			}
			
			else
			{
				$this->session->set_userdata('vendor_signup2_error_message', 'Unable to add user details. Please try again');
			}
		}
		$validation_errors = validation_errors();
		
		//repopulate form data if validation errors are present
		if(!empty($validation_errors))
		{
			//create errors
			$v_data['parent_error'] = form_error('parent');
			$v_data['child_error'] = form_error('child');
			$v_data['client_about_error'] = form_error('client_about');
			$v_data['client_dob1_error'] = form_error('client_dob1');
			$v_data['client_dob2_error'] = form_error('client_dob2');
			$v_data['client_dob3_error'] = form_error('client_dob3');
			$v_data['gender_id_error'] = form_error('gender_id');
			$v_data['client_looking_gender_id_error'] = form_error('client_looking_gender_id');
			$v_data['age_group_id_error'] = form_error('age_group_id');
			$v_data['encounter_id_error'] = form_error('encounter_id');
			
			//repopulate fields
			$v_data['parent'] = set_value('parent');
			$v_data['child'] = set_value('child');
			$v_data['client_about'] = set_value('client_about');
			$v_data['client_looking_gender_id'] = set_value('client_looking_gender_id');
			$v_data['age_group_id'] = set_value('age_group_id');
			$v_data['encounter_id'] = set_value('encounter_id');
			$v_data['client_dob1'] = set_value('client_dob1');
			$v_data['client_dob2'] = set_value('client_dob2');
			$v_data['client_dob3'] = set_value('client_dob3');
			$v_data['gender_id'] = set_value('gender_id');
			$v_data['client_looking_gender_id'] = set_value('client_looking_gender_id');
		}
		
		//populate form data on initial load of page
		else
		{
			if(!empty($v_data['profile_image_error']))
			{
				$v_data['parent'] = set_value('parent');
				$v_data['child'] = set_value('child');
				$v_data['client_about'] = set_value('client_about');
				$v_data['client_looking_gender_id'] = set_value('client_looking_gender_id');
				$v_data['age_group_id'] = set_value('age_group_id');
				$v_data['encounter_id'] = set_value('encounter_id');
				$v_data['client_dob1'] = set_value('client_dob1');
				$v_data['client_dob2'] = set_value('client_dob2');
				$v_data['client_dob3'] = set_value('client_dob3');
			}
			
			else
			{
				$v_data['parent'] = '';
				$v_data['child'] = '';
				$v_data['client_about'] = '';
				$v_data['gender_id'] = "";
				$v_data['client_looking_gender_id'] = "";
				$v_data['age_group_id'] = '';
				$v_data['encounter_id'] = '';
				$v_data['client_dob1'] = '';
				$v_data['client_dob2'] = '';
				$v_data['client_dob3'] = '';
			}
		}
		$v_data['neighbourhoods_query'] = $this->profile_model->get_neighbourhoods();
		$v_data['genders_query'] = $this->profile_model->get_gender();
		$v_data['age_groups_query'] = $this->profile_model->get_age_group();
		$v_data['encounters_query'] = $this->profile_model->get_encounter();
		
		$data['content'] = $this->load->view('register/about_you', $v_data, true);
		
		$data['title'] = $this->site_model->display_page_title();
		$this->load->view('site/templates/home_page', $data);
	}
	
	public function like_profile($web_name)
	{
		$like_id = $this->messages_model->get_receiver_id($web_name);
		$client_username = str_replace("-", " ", $web_name);
		
		if($this->profile_model->like_profile($this->client_id, $like_id))
		{
			if($this->payments_model->bill_client($this->client_id, $this->like_amount))
			{
				$data['response'] = 'success';
				$data['message'] = 'You have liked '.$client_username;
				$data['account_balance'] = $this->payments_model->get_account_balance($this->client_id);
			}
			
			else
			{
				$data['response'] = 'success';
				$data['message'] = 'You have liked '.$client_username;
				$data['account_balance'] = $this->account_balance;
			}
		}
		
		else
		{
			$data['response'] = 'fail';
			$data['message'] = 'Unable to like '.$client_username;
		}
		
		echo json_encode($data);
	}
	
	public function unlike_profile($like_id, $ajax = NULL, $page = NULL)
	{
		if($this->profile_model->unlike_profile($this->client_id, $like_id))
		{
			if($ajax == 'true')
			{
				$this->session->set_userdata('success_message', 'You have un liked a profile');
				
				if($page == NULL)
				{
					redirect('browse');
				}
				else
				{
					redirect('browse/'.$page);
				}
			}
			
			else
			{
				echo 'true';
			}
		}
		
		else
		{
			if($ajax == 'true')
			{
				$this->session->set_userdata('error_message', 'Unable to un liked profile');
				
				if($page == NULL)
				{
					redirect('browse');
				}
				else
				{
					redirect('browse/'.$page);
				}
			}
			
			else
			{
				echo 'true';
			}
		}
	}
	
	public function send_message($receiver_id, $page = NULL)
	{
		$v_data['smiley_location'] = $this->smiley_location;
		$v_data['receiver'] = $this->profile_model->get_client($receiver_id);
		$v_data['sender'] = $this->profile_model->get_client($this->client_id);
		$v_data['messages'] = $this->profile_model->get_messages($this->client_id, $receiver_id, $this->messages_path);
		$v_data['received_messages'] = $this->profile_model->count_received_messages($v_data['messages']);
		$v_data['profile_image_location'] = $this->profile_image_location;
		
		//make payment if message was sent
		if($page > 0)
		{
		}
		
		if($page == 1)
		{
			$data['messages'] = $this->load->view('messages/message_details', $v_data, true);
			$data['curr_message_count'] = $v_data['received_messages'];
			$data['account_balance'] = $this->payments_model->get_account_balance($this->session->userdata('client_id'));
			
			echo json_encode($data);
		}
		
		else if($page == 2)
		{
			$data['messages'] = $this->load->view('account/modal_messages', $v_data, true);
			$data['curr_message_count'] = $v_data['received_messages'];
			$data['account_balance'] = $this->payments_model->get_account_balance($this->session->userdata('client_id'));
			
			echo json_encode($data);
		}
		
		else
		{
			//for smileys
			$image_array = get_clickable_smileys($this->smiley_location, 'instant_message');
			$col_array = $this->table->make_columns($image_array, 12);
			
			$v_data['smiley_table'] = $this->profile_model->generate_emoticons($col_array);
			$v_data['account_balance'] = $this->account_balance;
			
			echo $this->load->view('account/message', $v_data, true);
		}
	}
	
	public function message_profile($page = NULL)
	{
		$this->form_validation->set_error_delimiters('', '');
		$this->form_validation->set_rules('client_message_details', 'Message', 'required|xss_clean');
		
		if($this->form_validation->run())
		{
			$data['client_message_details'] = $this->input->post('client_message_details');
			$data['client_id'] = $this->client_id;
			$data['receiver_id'] = $this->input->post('receiver_id');
			$data['created'] = date('Y-m-d H:i:s');
			$content = json_encode($data);
			
			//create file name
			$file_name = $this->profile_model->create_file_name($this->client_id, $this->input->post('receiver_id'));
			$file_path = $this->messages_path.'//'.$file_name;
			$base_path = $this->messages_path;
			
			//check if file exists
			if(!$this->file_model->check_if_file_exists($file_path, $base_path))
			{
				//create file if not exists
				if($this->file_model->create_file($file_path, $base_path))
				{
					$this->file_model->write_to_file($file_path, $content);
					
					//bill client
					if($this->payments_model->bill_client($this->client_id, $this->message_amount))
					{
					}
					
					else
					{
					}
					$this->send_message($data['receiver_id'], $page);
				}
				
				else
				{
					echo 'false';
				}
			}
			
			else
			{
				$this->file_model->write_to_file($file_path, $content);
					
				//bill client
				if($this->payments_model->bill_client($this->client_id, $this->message_amount))
				{
				}
				
				else
				{
				}
				$this->send_message($data['receiver_id'], $page);
			}
			
			//$this->db->insert('client_message', $data);
		}
		
		else
		{
			echo 'false';
		}
	}
	public function get_client_details()
	{
		$client_query = $this->profile_model->get_client($this->client_id);
		$row = $client_query->row();
		$v_data['profile_image_location'] = $this->profile_image_location.$row->client_image;
		$neighbourhood_id = $row->neighbourhood_id;
		$v_data['gender_id'] = $row->gender_id;
		$v_data['client_about'] = $row->client_about;
		$v_data['client_looking_gender_id'] = $row->client_looking_gender_id;
		$v_data['age_group_id'] = $row->age_group_id;
		$v_data['encounter_id'] = $row->encounter_id;
		$v_data['current_password'] = $row->client_password;
		$client_dob = $row->client_dob;
		$v_data['client_dob1'] = date('d',strtotime($client_dob));
		$v_data['client_dob2'] = date('m',strtotime($client_dob));
		$v_data['client_dob3'] = date('Y',strtotime($client_dob));
		
		echo json_encode($v_data);
	}
	
	public function edit_profile_image()
	{
		$client_query = $this->profile_model->get_client($this->client_id);
		$row = $client_query->row();
		
		/*$v_data['file'] = $_FILES["file"]["type"];
		
		//upload image if it has been selected
		$response = $this->profile_model->upload_profile_image($this->profile_image_path, $row->client_image, $row->client_thumb);
		if($response)
		{
			$profile_image_location = $this->profile_image_location.$this->session->userdata('profile_file_name');
		}
		
		//case of upload error
		else
		{
			$profile_image_error = $this->session->userdata('profile_error_message');
		}
		
		if(!empty($profile_image_error))
		{
			$v_data['response'] = 'failure';
			$v_data['message'] = $profile_image_error;
		}
		
		else
		{
			$v_data['response'] = 'success';
			$v_data['message'] = $profile_image_location;
		}*/
		if(!empty($_FILES['file']['tmp_name']))
		{
			$profile_image_path = $this->profile_image_path;
			$client_image = $row->client_image;
			$client_thumb = $row->client_thumb;
			
			//delete previous images
			if(!empty($client_image))
			{
				$image = $client_image;
				
				//delete any other uploaded image
				if($this->file_model->delete_file($profile_image_path."\\".$image, $profile_image_path))
				{
					//delete any other uploaded thumbnail
					$this->file_model->delete_file($profile_image_path."\\thumbnail_".$image, $profile_image_path);
				}
				
				else
				{
					$this->file_model->delete_file($profile_image_path."/".$image, $profile_image_path);
					$this->file_model->delete_file($profile_image_path."/thumbnail_".$image, $profile_image_path);
				}
			}
			
			//Upload image
			$new_image_name = md5(date('Y-m-d H:i:s')).".jpg";
			if(move_uploaded_file($_FILES["file"]["tmp_name"], $this->profile_image_path."/".$new_image_name))
			{
				//resize the image
				$resize['width'] = 500;
				$resize['height'] = 500;
				$master_dim = 'width';
				
				$resize_conf = array(
						'source_image'  => $this->profile_image_path."/".$new_image_name, 
						'width' => $resize['width'],
						'height' => $resize['height'],
						'master_dim' => $master_dim,
						'maintain_ratio' => TRUE
					);
	
				// initializing
				$this->image_lib->initialize($resize_conf);
				// do it!
				if ( ! $this->image_lib->resize())
				{
					$v_data['response'] = 'failure';
					$v_data['message'] =  $this->image_lib->display_errors();
				}
				else
				{
					$width = $height = 150;
					$resize_conf2 = array(
						'source_image'  => $this->profile_image_path."/".$new_image_name,
						'new_image'     => $this->profile_image_path."/thumbnail_".$new_image_name,
						'create_thumb'  => FALSE,
						'width' => $width,
						'height' => $height,
						'maintain_ratio' => true,
					);
					
					$this->image_lib->initialize($resize_conf2);
					 
					 if ( ! $this->image_lib->resize())
					{
						$v_data['response'] = 'failure';
						$v_data['message'] =  $this->image_lib->display_errors();
					}
					
					else
					{
						//update db
						$update_data['client_image'] = $new_image_name;
						$update_data['client_thumb'] = "thumbnail_".$new_image_name;
						
						$this->db->where('client_id', $this->client_id);
						
						if($this->db->update('client', $update_data))
						{
							$v_data['response'] = 'success';
							$v_data['message'] =  $this->profile_image_location.'/'.$new_image_name;
						}
						
						else
						{
							$v_data['response'] = 'fail';
							$v_data['message'] =  'Unable to set your profile image. Please try again';
						}
					}
				}
			}
		}
		
		//unable to upload image
		else
		{
			$v_data['response'] = 'failure';
			$v_data['message'] = 'Unable to upload image. Please try again';
		}
		
		echo json_encode($v_data);
	}
	
	public function edit_profile()
	{
		$youngest_year = date('Y')-17;
		
		//$this->form_validation->set_error_delimiters('', '');
		/*$this->form_validation->set_rules('parent', 'Neighbourhood', 'trim|required|xss_clean');
		$this->form_validation->set_rules('child', 'Location', 'trim|xss_clean');*/
		$this->form_validation->set_rules('client_about', 'About you', 'trim|required|xss_clean');
		$this->form_validation->set_rules('client_dob', 'Date of birth', 'trim|required|xss_clean');
		/*$this->form_validation->set_rules('client_dob1', 'Day of birth', 'trim|required|greater_than[0]|less_than[32]|xss_clean');
		$this->form_validation->set_rules('client_dob2', 'Month of birth', 'trim|required|greater_than[0]|less_than[13]|xss_clean');
		$this->form_validation->set_rules('client_dob3', 'Year of birth', 'trim|required|greater_than[1900]|less_than['.$youngest_year.']|xss_clean');*/
		$this->form_validation->set_rules('gender_id', 'I am a', 'trim|required|xss_clean');
		$this->form_validation->set_rules('client_looking_gender_id', 'I want a', 'trim|required|xss_clean');
		$this->form_validation->set_rules('age_group_id', 'Aged', 'trim|required|xss_clean');
		$this->form_validation->set_rules('encounter_id', 'For a', 'trim|required|xss_clean');
		
		//if form conatins invalid data
		if ($this->form_validation->run())
		{
			if($this->profile_model->register_profile_details($this->client_id))
			{
				//redirect only if logo error isnt present
				$v_data['response'] = 'success';
				$v_data['message'] = 'Your profile has been updated successfully';
				
				$client_query = $this->profile_model->get_client($this->client_id);
				$row = $client_query->row();
				
				$v_data['gender_id'] = $row->gender_id;
				$v_data['client_about'] = $row->client_about;
				$v_data['client_looking_gender_id'] = $row->client_looking_gender_id;
				$v_data['age_group_id'] = $row->age_group_id;
				$v_data['encounter_id'] = $row->encounter_id;
				$v_data['current_password'] = $row->client_password;
				$client_dob = $row->client_dob;
				$v_data['client_dob'] = date('d M, Y',strtotime($client_dob));
			}
			
			else
			{
				$v_data['response'] = 'failure';
				$v_data['message'] = 'Unable to update your profile';
			}
		}
		
		else
		{
			$v_data['response'] = 'failure';
			$v_data['message'] = validation_errors();
		}
		
		if(!empty($profile_image_error))
		{
			$v_data['response'] = 'failure';
			$v_data['message'] = $profile_image_error;
		}
		echo json_encode($v_data);
	}
    
	/*
	*
	*	Update a user's password
	*
	*/
	public function update_password()
	{
		//form validation rules
		$this->form_validation->set_rules('current_password', 'Current Password', 'required|xss_clean');
		$this->form_validation->set_rules('new_password', 'New Password', 'required|xss_clean');
		$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|xss_clean');
		
		//if form has been submitted
		if ($this->form_validation->run() == FALSE)
		{
			$this->session->set_userdata('error_message', validation_errors());
		}
		
		else
		{
			//update password
			$update = $this->profile_model->edit_password($this->client_id);
			if($update['result'])
			{
				$this->session->set_userdata('success_message', 'Your password has been successfully updated');
			}
			
			else
			{
				$this->session->set_userdata('error_message', $update['message']);
			}
		}
		
		redirect('my-profile');
	}
}