<?php	
		$result = '<a href="'.site_url().'add-user" class="btn btn-success pull-right">Add User</a>';
		
		//if users exist display them
		if ($users->num_rows() > 0)
		{
			$count = $page;
			
			$result .= 
			'
				<table class="table table-hover table-bordered ">
				  <thead>
					<tr>
					  <th>#</th>
					  <th>Name</th>
					  <th>Type</th>
					  <th>Date Created</th>
					  <th>Last Login</th>
					  <th>Status</th>
					  <th colspan="5">Actions</th>
					</tr>
				  </thead>
				  <tbody>
			';
			foreach ($users->result() as $row)
			{
				$user_id = $row->user_id;
				$fname = $row->first_name;
				//create deactivated status display
				if($row->activated == 0)
				{
					$status = '<span class="label label-important">Deactivated</span>';
					$button = '<a class="btn btn-info" href="'.site_url().'activate-user/'.$user_id.'" onclick="return confirm(\'Do you want to activate '.$fname.'?\');">Activate</a>';
				}
				//create activated status display
				else if($row->activated == 1)
				{
					$status = '<span class="label label-success">Active</span>';
					$button = '<a class="btn btn-info" href="'.site_url().'deactivate-user/'.$user_id.'" onclick="return confirm(\'Do you want to deactivate '.$fname.'?\');">Deactivate</a>';
				}
				$count++;
				$result .= 
				'
					<tr>
						<td>'.$count.'</td>
						<td>'.$row->first_name.' '.$row->other_names.'</td>
						<td>'.$row->user_level.'</td>
						<td>'.date('jS M Y H:i a',strtotime($row->created)).'</td>
						<td>'.date('jS M Y H:i a',strtotime($row->last_login)).'</td>
						<td>'.$row->user_status_name.'</td>
						<td>
							
							<!-- Button to trigger modal -->
							<a href="#user'.$user_id.'" class="btn btn-primary" data-toggle="modal">View</a>
							
							<!-- Modal -->
							<div id="user'.$user_id.'" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
								<div class="modal-dialog">
									<div class="modal-content">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
											<h4 class="modal-title">'.$fname.' '.$row->other_names.'</h4>
										</div>
										
										<div class="modal-body">
											<table class="table table-stripped table-condensed table-hover">
												<tr>
													<th>First Name</th>
													<td>'.$row->first_name.'</td>
												</tr>
												<tr>
													<th>Other Names</th>
													<td>'.$row->other_names.'</td>
												</tr>
												<tr>
													<th>Email</th>
													<td>'.$row->email.'</td>
												</tr>
												<tr>
													<th>Phone</th>
													<td>'.$row->phone.'</td>
												</tr>
												<tr>
													<th>Address</th>
													<td>'.$row->address.'</td>
												</tr>
												<tr>
													<th>Postal Code</th>
													<td>'.$row->post_code.'</td>
												</tr>
												<tr>
													<th>Country</th>
													<td>'.$row->country_name.'</td>
												</tr>
												<tr>
													<th>City</th>
													<td>'.$row->city.'</td>
												</tr>
												<tr>
													<th>User Type</th>
													<td>'.$row->user_level.'</td>
												</tr>
												<tr>
													<th>User Status</th>
													<td>'.$row->user_status_name.'</td>
												</tr>
												<tr>
													<th>Date Created</th>
													<td>'.$row->created.'</td>
												</tr>
												<tr>
													<th>Last Modified</th>
													<td>'.$row->modified.'</td>
												</tr>
												<tr>
													<th>Last Login</th>
													<td>'.$row->last_login.'</td>
												</tr>
											</table>
										</div>
										<div class="modal-footer">
											<button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
											<a href="'.site_url().'edit-user/'.$user_id.'" class="btn btn-sm btn-success">Edit</a>
											'.$button.'
											<a href="'.site_url().'reset-user-password/'.$user_id.'" class="btn btn-sm btn-warning" onclick="return confirm(\'Do you want to reset '.$fname.'\'s password?\');">Reset Password</a>
											<a href="'.site_url().'delete-user/'.$user_id.'" class="btn btn-sm btn-danger" onclick="return confirm(\'Do you really want to delete '.$fname.'?\');">Delete</a>
										</div>
									</div>
								</div>
							</div>
						
						</td>
						<td><a href="'.site_url().'edit-user/'.$user_id.'" class="btn btn-sm btn-success">Edit</a></td>
						<td>'.$button.'</td>
						<td><a href="'.site_url().'reset-user-password/'.$user_id.'" class="btn btn-sm btn-warning" onclick="return confirm(\'Do you want to reset '.$fname.'\'s password?\');">Reset Password</a></td>
						<td><a href="'.site_url().'delete-user/'.$user_id.'" class="btn btn-sm btn-danger" onclick="return confirm(\'Do you really want to delete '.$fname.'?\');">Delete</a></td>
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
			$result .= "There are no users";
		}
		
		echo $result;
?>