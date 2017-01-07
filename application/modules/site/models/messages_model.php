<?php
class Messages_model extends CI_Model 
{
	public function get_all_messages($table, $where, $per_page, $page, $limit = NULL, $order_by = 'last_chatted', $order_method = 'DESC')
	{
		$this->db->from($table);
		$this->db->select('*');
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
	
	public function get_receiver_id($receiver_web_name)
	{
		$client_username = str_replace("-", " ", $receiver_web_name);
		
		$this->db->where('client_username', $client_username);
		$query = $this->db->get('client');
		
		if($query->num_rows() > 0)
		{
			$row = $query->row();
			$client_id = $row->client_id;
		}
		
		else
		{
			$client_id = NULL;
		}
		
		return $client_id;
	}
	
	public function count_unread_messages($client_id, $messages_path)
	{
		//get message partners
		$this->db->where('client_id = '.$client_id.' OR receiver_id = '.$client_id);
		$query = $this->db->get('client_message');
		$total_received = 0;
		
		if($query->num_rows() > 0)
		{
			$results = $query->result();
			
			foreach($results as $res)
			{
				$file_name = $res->message_file_name;
				
				$file_path = $messages_path.'/'.$file_name;
				$content = $this->file_model->get_file_contents($file_path, $messages_path);
				
				$message_array = json_decode('['.$content.']');
				
				if(is_array($message_array))
				{
					$total_messages = count($message_array);
					
					if($total_messages > 0)
					{
						$last_message = $total_messages - 1;
						
						$message_data = $message_array[$last_message];
						$receiver_id = $message_data->receiver_id;
						
						if($receiver_id == $client_id)
						{
							$total_received++;
						}
					}
				}
			}
		}
		
		if($total_received > 0)
		{
			$total_received = '<span class="badge red-badge">'.$total_received.'</span>';
		}
		
		else
		{
			$total_received = '';
		}
		
		return $total_received;
	}
}