<?php
		
		$result = '<a href="'.site_url().'add-feature" class="btn btn-success pull-right">Add feature</a>';
		
		//if users exist display them
		if ($query->num_rows() > 0)
		{
			$count = $page;
			
			$result .= 
			'
				<table class="table table-hover table-bordered ">
				  <thead>
					<tr>
					  <th>#</th>
					  <th>Category</th>
					  <th>Feature Name</th>
					  <th>Date Created</th>
					  <th>Last Modified</th>
					  <th>Status</th>
					  <th colspan="5">Actions</th>
					</tr>
				  </thead>
				  <tbody>
			';
			
			//get all administrators
			$administrators = $this->users_model->get_all_administrators();
			if ($administrators->num_rows() > 0)
			{
				$admins = $administrators->result();
			}
			
			else
			{
				$admins = NULL;
			}
			
			foreach ($query->result() as $row)
			{
				$feature_id = $row->feature_id;
				$category_name = $row->category_name;
				$feature_name = $row->feature_name;
				$feature_status = $row->feature_status;
				$created_by = $row->created_by;
				$modified_by = $row->modified_by;
				
				if($category_name == 'No Category'){$category_name = 'All Categories';}
				
				//status
				if($feature_status == 1)
				{
					$status = 'Active';
				}
				else
				{
					$status = 'Disabled';
				}
				
				//create deactivated status display
				if($feature_status == 0)
				{
					$status = '<span class="label label-important">Deactivated</span>';
					$button = '<a class="btn btn-info" href="'.site_url().'activate-feature/'.$feature_id.'" onclick="return confirm(\'Do you want to activate '.$feature_name.'?\');">Activate</a>';
				}
				//create activated status display
				else if($feature_status == 1)
				{
					$status = '<span class="label label-success">Active</span>';
					$button = '<a class="btn btn-info" href="'.site_url().'deactivate-feature/'.$feature_id.'" onclick="return confirm(\'Do you want to deactivate '.$feature_name.'?\');">Deactivate</a>';
				}
				
				//creators & editors
				if($admins != NULL)
				{
					foreach($admins as $adm)
					{
						$user_id = $adm->user_id;
						
						if($user_id == $created_by)
						{
							$created_by = $adm->first_name;
						}
						
						if($user_id == $modified_by)
						{
							$modified_by = $adm->first_name;
						}
					}
				}
				
				else
				{
				}
				$count++;
				$result .= 
				'
					<tr>
						<td>'.$count.'</td>
						<td>'.$category_name.'</td>
						<td>'.$feature_name.'</td>
						<td>'.date('jS M Y H:i a',strtotime($row->created)).'</td>
						<td>'.date('jS M Y H:i a',strtotime($row->last_modified)).'</td>
						<td>'.$status.'</td>
						<td><a href="'.site_url().'edit-feature/'.$feature_id.'" class="btn btn-sm btn-success">Edit</a></td>
						<td>'.$button.'</td>
						<td><a href="'.site_url().'delete-feature/'.$feature_id.'" class="btn btn-sm btn-danger" onclick="return confirm(\'Do you really want to delete '.$feature_name.'?\');">Delete</a></td>
					</tr> 
				';
			}
			
			$result .= 
			'
						  </tbody>
						</table>
			';
		}
		
		else
		{
			$result .= "There are no features";
		}
		
		echo $result;
?>