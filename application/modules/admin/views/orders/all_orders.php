<?php
		$result = '<a href="'.site_url().'add-order" class="btn btn-success pull-right">Add order</a>';
		
		//if users exist display them
		if ($query->num_rows() > 0)
		{
			$count = $page;
			
			$result .= 
			'
				<table class="table table-hover table-bordered ">
				  <thead>
					<tr>
					  <th>Date Created</th>
					  <th>Order Number</th>
					  <th>Customer</th>
					  <th>Total Items</th>
					  <th>Order Total</th>
					  <th>Status</th>
					  <th colspan="3">Actions</th>
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
				$order_id = $row->order_id;
				$order_number = $row->order_number;
				$order_status = $row->order_status;
				$order_instructions = $row->order_instructions;
				$order_status_name = $row->order_status_name;
				$created_by = $row->created_by;
				$created = $row->created;
				$modified_by = $row->modified_by;
				$last_modified = $row->modified;
				$user = $row->first_name.' '.$row->other_names;
				
				$order_details = $this->orders_model->get_order_items($order_id);
				
				//creators & editors
				if($admins != NULL)
				{
					foreach($admins as $adm)
					{
						$user_id = $adm->user_id;
						
						if($user_id == $modified_by)
						{
							$modified_by = $adm->first_name;
						}
					}
				}
				
				else
				{
					$modified_by = '-- Not modified --';
				}
				
				if($order_details->num_rows() > 0)
				{
					$items = '
					<p><strong>Last Modified:</strong> '.date('jS M Y H:i a',strtotime($last_modified)).'<br/>
					<strong>Modified by:</strong> '.$modified_by.'</strong></br>
					<strong>Instructions:</strong> '.$order_instructions.'</strong></p>
					
					<table class="table table-striped table-condensed">
					<tr>
						<th>Item</th>
						<th>Quantity</th>
						<th>Price</th>
						<th>Total</th>
					</tr>';
					$order_items = $order_details->result();
					$total_price = 0;
					$total_items = 0;
					
					foreach($order_items as $ord)
					{
						$product = $ord->product_name;
						$quantity = $ord->quantity;
						$price = $ord->price;
						
						$total_price += ($quantity*$price);
						$total_items += $quantity;
						
						$items .= '
						<tr>
							<td>'.$product.'</td>
							<td>'.$quantity.'</td>
							<td>'.number_format($price, 0, '.', ',').'</td>
							<td>'.number_format(($quantity*$price), 0, '.', ',').'</td>
						</tr>
						';
					}
						
					$items .= '
					<tr>
						<td></td>
						<td></td>
						<td></td>
						<td>'.number_format($total_price, 0, '.', ',').'</td>
					</tr></table>
					';
				}
				
				else
				{
					$items = 'This order has no items';
				}
				
				//create deactivated status display
				if($order_status == 1)
				{
					$status = '<span class="label label-primary">'.$order_status_name.'</span>';
				}
				//create activated status display
				else if($order_status == 2)
				{
					$status = '<span class="label label-success">'.$order_status_name.'</span>';
				}
				//create activated status display
				else if($order_status == 3)
				{
					$status = '<span class="label label-danger">'.$order_status_name.'</span>';
				}
				
				$count++;
				$result .= 
				'
					<tr>
						<td>'.date('jS M Y H:i a',strtotime($created)).'</td>
						<td>'.$order_number.'</td>
						<td>'.$user.'</td>
						<td>'.$total_items.'</td>
						<td>'.number_format($total_price, 0, '.', ',').'</td>
						<td>'.$status.'</td>
						<td>
							<!-- Button to trigger modal -->
							<a href="#user'.$order_id.'" class="btn btn-primary" data-toggle="modal">View</a>
							
							<!-- Modal -->
							<div id="user'.$order_id.'" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
								<div class="modal-dialog">
									<div class="modal-content">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
											<h4 class="modal-title">'.$order_number.'</h4>
										</div>
										
										<div class="modal-body">
											'.$items.'
										</div>
										<div class="modal-footer">
											<button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
											<a href="'.site_url().'edit-order/'.$order_id.'" class="btn btn-sm btn-primary">Edit</a>
											<a href="'.site_url().'finish-order/'.$order_id.'" class="btn btn-sm btn-success" onclick="return confirm(\'Do you really want to complete this order '.$order_number.'?\');">Complete</a>
											<a href="'.site_url().'cancel-order/'.$order_id.'" class="btn btn-sm btn-danger" onclick="return confirm(\'Do you really want to cancel this order '.$order_number.'?\');">Cancel</a>
											<a href="'.site_url().'deactivate-order/'.$order_id.'" class="btn btn-sm btn-default" onclick="return confirm(\'Do you really want to deactivate this order '.$order_number.'?\');">Deactivate</a>
											<a href="'.site_url().'delete-order/'.$order_id.'" class="btn btn-sm btn-danger" onclick="return confirm(\'Do you really want to delete this order '.$order_number.'?\');">Delete</a>
										</div>
									</div>
								</div>
							</div>
						</td>
						<td><a href="'.site_url().'edit-order/'.$order_id.'" class="btn btn-sm btn-primary">Edit</a></td>
						<td><a href="'.site_url().'delete-order/'.$order_id.'" class="btn btn-sm btn-danger" onclick="return confirm(\'Do you really want to delete this order '.$order_number.'?\');">Delete</a></td>
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
			$result .= "There are no orders";
		}
		
		echo $result;
?>