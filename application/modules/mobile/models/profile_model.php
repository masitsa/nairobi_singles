<?php
class Profile_model extends CI_Model 
{
	public function upload_profile_image($profile_image_path, $client_image = NULL, $client_thumb = NULL)
	{
		//upload product's gallery images
		$resize['width'] = 500;
		$resize['height'] = 500;
		
		if(!empty($_FILES['profile_image']['tmp_name']))
		{
			$image = $this->session->userdata('profile_file_name');
			
			if((!empty($image)) || ($client_image != NULL))
			{
				if($client_image != NULL)
				{
					$image = $client_image;
				}
				
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
			$response = $this->file_model->upload_banner($profile_image_path, 'profile_image', $resize);
			if($response['check'])
			{
				$file_name = $response['file_name'];
				$thumb_name = $response['thumb_name'];
				
				//Set sessions for the image details
				$this->session->set_userdata('profile_file_name', $file_name);
				$this->session->set_userdata('profile_thumb_name', $thumb_name);
			
				return TRUE;
			}
		
			else
			{
				$this->session->set_userdata('profile_error_message', $response['error']);
				
				return FALSE;
			}
		}
		
		else
		{
			if($client_image != NULL)
			{
				$this->session->set_userdata('profile_file_name', $client_image);
				$this->session->set_userdata('profile_thumb_name', $client_thumb);
			}
			
			$profile_file_name = $this->session->userdata('profile_file_name');
			
			if(empty($profile_file_name))
			{
				$this->session->set_userdata('profile_error_message', 'Profiles with images are more likely to get matches. Please upload an image');
			}
			
			else
			{
				$this->session->set_userdata('profile_error_message', '');
			}
			return FALSE;
		}
	}
	
	public function get_profile_image($client_id)
	{
		//get profile data
		$table = "client";
		$where = "client_id = ".$client_id;
		
		$this->db->select('client_image, client_thumb');
		$this->db->where($where);
		$image_query = $this->db->get($table);
		
		return $image_query;
	}
	
	public function display_profile_image($image_query, $image_path, $image_location, $image_size, $thumb_size)
	{
		if($image_query->num_rows() > 0)
		{
			$row = $image_query->row();
			
			$image = $row->client_image;
			$thumb = $row->client_thumb;
			
			$return['image'] = $this->file_model->image_display($image_path, $image_location, $image, $image_size);
			$return['thumb'] = $this->file_model->image_display($image_path, $image_location, $thumb, $thumb_size);
		}
		
		else
		{
			$return['image'] = $this->file_model->image_display($image_path, $image_location, NULL, $image_size);
			$return['thumb'] = $this->file_model->image_display($image_path, $image_location, NULL, $thumb_size);
		}
		
		return $return;
	}
	
	public function get_neighbourhoods()
	{
		$this->db->where('neighbourhood_parent', NULL);
		$this->db->order_by('neighbourhood_name');
		$query = $this->db->get('neighbourhood');
		
		$this->db->where('neighbourhood_parent > 0');
		$this->db->order_by('neighbourhood_name');
		$query2 = $this->db->get('neighbourhood');
		
		$data['neighbourhood_parents'] = $query;
		$data['neighbourhood_children'] = $query2;
		
		return $data;
	}
	
	public function is_parent($neighbourhood_id)
	{
		$this->db->where('neighbourhood_id', $neighbourhood_id);
		$query = $this->db->get('neighbourhood');
		
		if($query->num_rows() > 0)
		{
			$row = $query->row();
			$parent = $row->neighbourhood_parent;
			
			return $parent;
		}
		
		else
		{
			return 0;
		}
	}
	
	public function get_gender()
	{
		$this->db->where('gender_status', 1);
		$query = $this->db->get('gender');
		
		return $query;
	}
	
	public function get_gender_name($gender_id)
	{
		$this->db->where('gender_id', $gender_id);
		$query = $this->db->get('gender');
		
		$row = $query->row();
		
		return $row->gender_name;
	}
	
	public function get_age_group()
	{
		$this->db->where('age_group_status', 1);
		$query = $this->db->get('age_group');
		
		return $query;
	}
	
	public function get_encounter()
	{
		$this->db->where('encounter_status', 1);
		$query = $this->db->get('encounter');
		
		return $query;
	}
	
	public function register_profile_details($client_id, $client_image, $client_thumb)
	{
		$parent_neighbourhood = $this->input->post('parent');
		$child_neighbourhood = $this->input->post('child');
		
		if(empty($child_neighbourhood))
		{
			$neighbourhood_id = $parent_neighbourhood;
		}
		else
		{
			$neighbourhood_id = $child_neighbourhood;
		}
		
		$newdata = array(
			   'client_about'			=> $this->input->post('client_about'),
			   'client_dob'				=> $this->input->post('client_dob3').'-'.$this->input->post('client_dob2').'-'.$this->input->post('client_dob1'),
			   'neighbourhood_id'		=> $neighbourhood_id,
			   'client_looking_gender_id'	=> $this->input->post('client_looking_gender_id'),
			   'gender_id'				=> $this->input->post('gender_id'),
			   'age_group_id'			=> $this->input->post('age_group_id'),
			   'encounter_id'			=> $this->input->post('encounter_id'),
			   'client_image'			=> $client_image,
			   'client_thumb'			=> $client_thumb
		   );
		
		$this->db->where('client_id', $client_id);
		if($this->db->update('client', $newdata))
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
	
	public function get_client($client_id)
	{
		//get profile data
		$table = "client";
		$where = "client_id = ".$client_id;
		
		$this->db->where($where);
		$query = $this->db->get($table);
		
		return $query;
	}
	
	public function get_client_username($client_username)
	{
		//get profile data
		$where = "client.neighbourhood_id = neighbourhood.neighbourhood_id AND client.gender_id = gender.gender_id AND client.encounter_id = encounter.encounter_id AND client.client_status = 1 AND client.client_username = '".$client_username."'";
		$table = 'client, gender, encounter, neighbourhood';
		$this->db->select('client.*, gender.gender_name, encounter.encounter_name, neighbourhood.neighbourhood_name');
		$this->db->where($where);
		$query = $this->db->get($table);
		
		return $query;
	}
	
	/*
	*	Retrieve all products
	*	@param string $table
	* 	@param string $where
	*
	*/
	public function get_all_clients($table, $where, $per_page, $page, $limit = NULL, $order_by = 'created', $order_method = 'DESC')
	{
		$this->db->from($table);
		$this->db->select('client.*, gender.gender_name, encounter.encounter_name, neighbourhood.neighbourhood_name');
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
	
	public function is_profile_liked($client_id, $like_id)
	{
		$where = array(
			'client_id' => $client_id,
			'like_id' => $like_id
		);
		$this->db->where($where);
		$query = $this->db->get('client_like');
		
		if($query->num_rows() > 0)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
	
	public function liked_profiles($client_id)
	{
		$where = array(
			'like_id' => $client_id
		);
		$this->db->where($where);
		$likes = $this->db->count_all_results('client_like');
		
		return $likes;
	}
	
	public function profile_likes($client_id)
	{
		$where = array(
			'client_id' => $client_id
		);
		$this->db->where($where);
		$likes = $this->db->count_all_results('client_like');
		
		return $likes;
	}
	
	public function like_profile($client_id, $like_id)
	{
		$data = array(
			'client_id' => $client_id,
			'like_id' => $like_id
		);
		
		if($this->db->insert('client_like', $data))
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
	
	public function unlike_profile($client_id, $like_id)
	{
		$where = array(
			'client_id' => $client_id,
			'like_id' => $like_id
		);
		
		$this->db->where($where);
		if($this->db->delete('client_like'))
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}

	public function calculate_age($date_of_birth)
	{
		$value = $this->dateDiff(date('y-m-d  h:i'), $date_of_birth." 00:00", 'year');
		
		return $value;
	}

	public function dateDiff($time1, $time2, $interval) 
	{
	    // If not numeric then convert texts to unix timestamps
	    if (!is_int($time1)) {
	      $time1 = strtotime($time1);
	    }
	    if (!is_int($time2)) {
	      $time2 = strtotime($time2);
	    }
	 
	    // If time1 is bigger than time2
	    // Then swap time1 and time2
	    if ($time1 > $time2) {
	      $ttime = $time1;
	      $time1 = $time2;
	      $time2 = $ttime;
	    }
	 
	    // Set up intervals and diffs arrays
	    $intervals = array('year','month','day','hour','minute','second');
	    if (!in_array($interval, $intervals)) {
	      return false;
	    }
	 
	    $diff = 0;
	    // Create temp time from time1 and interval
	    $ttime = strtotime("+1 " . $interval, $time1);
	    // Loop until temp time is smaller than time2
	    while ($time2 >= $ttime) {
	      $time1 = $ttime;
	      $diff++;
	      // Create new temp time from time1 and interval
	      $ttime = strtotime("+1 " . $interval, $time1);
	    }
	 
	    return $diff;
  	}
	
	/*public function create_query_filter($parameter_array, $table_field)
	{
		$parameters = explode("-", $parameter_array);
		$total = count($parameters);
		$where = ' AND (';
		
		for($r = 0; $r < $total; $r++)
		{
			if($r == 0)
			{
				$where .= $table_field.' = '.$parameters[$r];
			}
			
			else
			{
				$where .= ' OR '.$table_field.' = '.$parameters[$r];
			}
		}
		
		$where .= ')';
		
		return $where;
	}*/
	
	public function create_query_filter($parameter_array, $table_field)
	{
		$parameters = explode("&", $parameter_array);
		$total = count($parameters);
		$where = ' AND (';
		
		for($r = 0; $r < $total; $r++)
		{
			$parameter_name = str_replace("-", " ", $parameters[$r]);
			
			if($r == 0)
			{
				$where .= $table_field.' = \''.$parameter_name.'\'';
			}
			
			else
			{
				$where .= ' OR '.$table_field.' = \''.$parameter_name.'\'';
			}
		}
		
		$where .= ')';
		
		$return['where'] = $where;
		$return['parameters'] = $parameters;
		
		return $return;
	}
	
	public function create_neighbourhood_filter($parameter_array, $table_field)
	{
		$parameters = explode("&", $parameter_array);
		$total = count($parameters);
		$where = ' AND (';
		
		for($r = 0; $r < $total; $r++)
		{
			$parameter_name = str_replace("-", " ", $parameters[$r]);
			
			if($r == 0)
			{
				$where .= $table_field.' = \''.$parameter_name.'\' OR neighbourhood_parent = (SELECT neighbourhood_id FROM neighbourhood WHERE neighbourhood_name = \''.$parameter_name.'\')';
			}
			
			else
			{
				$where .= ' OR '.$table_field.' = \''.$parameter_name.'\' OR neighbourhood_parent = (SELECT neighbourhood_id FROM neighbourhood WHERE neighbourhood_name = \''.$parameter_name.'\')';
			}
		}
		
		$where .= ')';
		
		$return['where'] = $where;
		$return['parameters'] = $parameters;
		
		return $return;
	}
	
	public function create_age_filter($parameter_array, $table_field)
	{
		$parameters = explode("&", $parameter_array);
		$total = count($parameters);
		$where = ' AND (';
		
		for($r = 0; $r < $total; $r++)
		{
			$age_group_name = $parameters[$r];
			
			//remove any + signs from string
			$age_group_name = rtrim($age_group_name, "+");
			
			$ages = explode("-", $age_group_name);
			
			if(isset($ages[1]))
			{
				$max_year = (date('Y') - $ages[0]).date('-m-d')+1;
				$min_year = (date('Y') - $ages[1]).date('-m-d')-1;
				
				if($r == 0)
				{
					$where .= " EXTRACT(YEAR FROM ".$table_field.") BETWEEN '".$min_year."' AND '".$max_year."'";
				}
				
				else
				{
					$where .= " OR  EXTRACT(YEAR FROM ".$table_field.") BETWEEN '".$min_year."' AND '".$max_year."'";
				}
			}
			
			else
			{
				$max_year = (date('Y') - $ages[0]).date('-m-d');
				
				if($r == 0)
				{
					$where .= " EXTRACT(YEAR FROM ".$table_field.") > '".$max_year."'";
				}
				
				else
				{
					$where .= " OR EXTRACT(YEAR FROM ".$table_field.") > '".$max_year."'";
				}
			}
		}
		
		$where .= ')';
		
		$return['where'] = $where;
		$return['parameters'] = $parameters;
		
		return $return;
	}
	
	public function create_web_name($field_name)
	{
		$web_name = str_replace(" ", "-", $field_name);
		
		return $web_name;
	}
	
	public function chat_exists($client_id, $receiver_id)
	{
		$where = '(client_id = '.$client_id.' AND receiver_id = '.$receiver_id.') OR (client_id = '.$receiver_id.' AND receiver_id = '.$client_id.')';
		$this->db->where($where);
		$query = $this->db->get('client_message');
		
		return $query;
	}
	
	public function create_file_name($client_id, $receiver_id)
	{
		//check if file name session exists
		$file_name = $this->session->userdata('message_file_name_'.$receiver_id);
		
		if(empty($file_name))
		{
			//check if file exists in the db
			$query = $this->chat_exists($client_id, $receiver_id);
			
			if($query->num_rows() > 0)
			{
				$row = $query->row();
				$file_name = $row->message_file_name;
				$client_message_id = $row->client_message_id;
				$update_data['last_chatted'] = date('Y-m-d H:i:s');
				
				//update last date chatted
				$this->db->where('client_message_id', $client_message_id);
				$this->db->update('client_message', $update_data);
			}
			
			else
			{
				//create file name
				$file_name = md5('message-'.$client_id.'-'.$receiver_id.'-'.date('Y-m-d')).'.json';
				
				//save file name to db
				$data['message_file_name'] = $file_name;
				$data['client_id'] = $client_id;
				$data['receiver_id'] = $receiver_id;
				$data['created'] = date('Y-m-d H:i:s');
				$data['last_chatted'] = date('Y-m-d H:i:s');
				$this->db->insert('client_message', $data);
			}
			$this->session->set_userdata('message_file_name_'.$receiver_id, $file_name);
		}
		
		return $file_name;
	}
	
	public function get_messages($client_id, $receiver_id, $messages_path)
	{
		//check if message session exists
		$file_name = $this->session->userdata('message_file_name_'.$receiver_id);
		//var_dump($file_name);die();
		if(empty($file_name))
		{
			//check if file exists in the db
			$query = $this->chat_exists($client_id, $receiver_id);
			//echo $query->num_rows(); die();
			if($query->num_rows() > 0)
			{
				$row = $query->row();
				$file_name = $row->message_file_name;
				$this->session->set_userdata('message_file_name_'.$receiver_id, $file_name);
			}
		}
		
		if(!empty($file_name))
		{
			$file_path = $messages_path.'/'.$file_name;
			$content = $this->file_model->get_file_contents($file_path, $messages_path);
			$message_array = json_decode('['.$content.']');
			//var_dump($message_array);die();
		}
		
		else
		{
			$message_array = NULL;
		}
		return $message_array;
	}
	
	public function count_received_messages($message_array)
	{
		if(is_array($message_array))
		{
			$count = count($message_array);
		}
		
		else
		{
			$count = 0;
		}
		
		return $count;
	}
	
	public function generate_emoticons($col_array)
	{
		//get total rows
		$total_rows = count($col_array);
		$grid = '<div class="row">';
		
		//create grid
		for($r = 0; $r < $total_rows; $r++)
		{
			for($s = 0; $s < $total_rows; $s++)
			{
				$grid .= '<div class="col-md-1 col-sm-1 col-xs-1">'.$col_array[$r][$s].'</div>';
			}
		}
		
		$grid .= '</div>';
		
		return $grid;
	}
	
	public function convert_smileys($str, $smiley_location)
	{
		$str = parse_smileys($str, $smiley_location);
		return $str;
	}
	
	/*
	*	Edit an existing user's password
	*	@param int $user_id
	*
	*/
	public function edit_password($user_id)
	{
		if($this->input->post('slug') == md5($this->input->post('current_password')))
		{
			if($this->input->post('new_password') == $this->input->post('confirm_password'))
			{
				$data['client_password'] = md5($this->input->post('new_password'));
		
				$this->db->where('client_id', $user_id);
				
				if($this->db->update('client', $data))
				{
					$return['result'] = TRUE;
				}
				else{
					$return['result'] = FALSE;
					$return['message'] = 'Oops something went wrong and your password could not be updated. Please try again';
				}
			}
			else{
					$return['result'] = FALSE;
					$return['message'] = 'New Password and Confirm Password don\'t match';
			}
		}
		
		else
		{
			$return['result'] = FALSE;
			$return['message'] = 'You current password is not correct. Please try again';
		}
		
		return $return;
	}
	
	public function image_display($base_path, $location, $image_name = NULL)
	{
		$default_image = 'http://placehold.it/300x300&text=NS';
		$file_path = $base_path.'/'.$image_name;
		//echo $file_path.'<br/>';
		
		//Check if image was passed
		if($image_name != NULL)
		{
			if(!empty($image_name))
			{
				if((file_exists($file_path)) && ($file_path != $base_path.'\\'))
				{
					return $location.$image_name;
				}
				
				else
				{
					return $default_image;
				}
			}
			
			else
			{
				return $default_image;
			}
		}
		
		else
		{
			return $default_image;
		}
	}
	
	public function check_online($client_id)
	{
		$this->db->where("`user_data` LIKE '%\"client_code\";s:32:\"".md5($client_id)."\"%'");
		$query = $this->db->get('ci_sessions');
		
		if($query->num_rows() > 0)
		{
			$row = $query->row();
			
			$current_time = strtotime(date('Y-m-d H:i:s'));
			$last_activity = $row->last_activity;
			
			$activity_difference = $current_time - $last_activity;
			$time_difference = date('i', $activity_difference);
			
			return $time_difference;
		}
		
		else
		{
			return FALSE;
		}
	}
}