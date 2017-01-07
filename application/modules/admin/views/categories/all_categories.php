<?php
		
		$result = '<a href="'.site_url().'add-category" class="btn btn-success pull-right">Add Category</a>';
		
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
					  <th>Image</th>
					  <th>Category Name</th>
					  <th>Category Parent</th>
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
				$category_id = $row->category_id;
				$category_name = $row->category_name;
				$parent = $row->category_parent;
				$category_status = $row->category_status;
				$image = $row->category_image_name;
				$created_by = $row->created_by;
				$modified_by = $row->modified_by;
				$category_image_name = $row->category_image_name;
				
				//status
				if($category_status == 1)
				{
					$status = 'Active';
				}
				else
				{
					$status = 'Disabled';
				}
				$category_parent = '-';
				
				//category parent
				foreach($query->result() as $row2)
				{
					$category_id2 = $row2->category_id;
					if($parent == $category_id2)
					{
						$category_parent = $row2->category_name;
						break;
					}
				}
				
				//create deactivated status display
				if($category_status == 0)
				{
					$status = '<span class="label label-important">Deactivated</span>';
					$button = '<a class="btn btn-info" href="'.site_url().'activate-category/'.$category_id.'" onclick="return confirm(\'Do you want to activate '.$category_name.'?\');">Activate</a>';
				}
				//create activated status display
				else if($category_status == 1)
				{
					$status = '<span class="label label-success">Active</span>';
					$button = '<a class="btn btn-info" href="'.site_url().'deactivate-category/'.$category_id.'" onclick="return confirm(\'Do you want to deactivate '.$category_name.'?\');">Deactivate</a>';
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
						<td><img src="'.base_url()."assets/images/categories/thumbnail_".$image.'"></td>
						<td>'.$category_name.'</td>
						<td>'.$category_parent.'</td>
						<td>'.date('jS M Y H:i a',strtotime($row->created)).'</td>
						<td>'.date('jS M Y H:i a',strtotime($row->last_modified)).'</td>
						<td>'.$status.'</td>
						<td>
							
							<!-- Button to trigger modal -->
							<a href="#user'.$category_id.'" class="btn btn-primary" data-toggle="modal">View</a>
							
							<!-- Modal -->
							<div id="user'.$category_id.'" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
								<div class="modal-dialog">
									<div class="modal-content">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
											<h4 class="modal-title">'.$category_name.'</h4>
										</div>
										
										<div class="modal-body">
											<table class="table table-stripped table-condensed table-hover">
												<tr>
													<th>Category Name</th>
													<td>'.$category_name.'</td>
												</tr>
												<tr>
													<th>Category Parent</th>
													<td>'.$category_parent.'</td>
												</tr>
												<tr>
													<th>Status</th>
													<td>'.$status.'</td>
												</tr>
												<tr>
													<th>Category Preffix</th>
													<td>'.$row->category_preffix.'</td>
												</tr>
												<tr>
													<th>Date Created</th>
													<td>'.date('jS M Y H:i a',strtotime($row->created)).'</td>
												</tr>
												<tr>
													<th>Created By</th>
													<td>'.$created_by.'</td>
												</tr>
												<tr>
													<th>Date Modified</th>
													<td>'.date('jS M Y H:i a',strtotime($row->last_modified)).'</td>
												</tr>
												<tr>
													<th>Modified By</th>
													<td>'.$modified_by.'</td>
												</tr>
												<tr>
													<th>Category Image</th>
													<td><img src="'.base_url()."assets/images/categories/".$image.'"></td>
												</tr>
											</table>
										</div>
										<div class="modal-footer">
											<button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
											<a href="'.site_url().'edit-category/'.$category_id.'" class="btn btn-sm btn-success">Edit</a>
											'.$button.'
											<a href="'.site_url().'delete-category/'.$category_id.'" class="btn btn-sm btn-danger" onclick="return confirm(\'Do you really want to delete '.$category_name.'?\');">Delete</a>
										</div>
									</div>
								</div>
							</div>
						
						</td>
						<td><a href="'.site_url().'edit-category/'.$category_id.'" class="btn btn-sm btn-success">Edit</a></td>
						<td>'.$button.'</td>
						<td><a href="'.site_url().'delete-category/'.$category_id.'" class="btn btn-sm btn-danger" onclick="return confirm(\'Do you really want to delete '.$category_name.'?\');">Delete</a></td>
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
			$result .= "There are no categories";
		}
		
		echo $result;
?>