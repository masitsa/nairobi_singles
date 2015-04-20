<style type="text/css">
	div#accordionNo input[type="checkbox"] {
		display: none;
		margin: 4px 0 0 -20px;
	}
</style>
<!--left column-->
  
    <div class="col-lg-3 col-md-3 col-sm-12">
      <div class="panel-group" id="accordionNo">
        
       <!--Gender--> 
        <!--<div class="panel panel-default">
          <div class="panel-heading">
            <h4 class="panel-title"> 
            <a data-toggle="collapse"  href="#collapseCategory" class="collapseWill"> 
            <span class="pull-left"> <i class="fa fa-caret-right"></i></span> Looking for a 
            </a> 
            </h4>
          </div>
          
          <div id="collapseCategory" class="panel-collapse collapse in">
            <div class="panel-body">
              <ul class="nav nav-pills nav-stacked tree">
                <form action="<?php echo site_url().'browse/filter-gender';?>" method="POST">
                <?php
					if($genders_query->num_rows() > 0)
					{
						foreach($genders_query->result() as $res)
						{
							$gender_id = $res->gender_id;
							$gender_name = $res->gender_name;
							
							echo 
							'
								<div class="block-element">
									<label> <input type="checkbox" name="gender_id[]" value="'.$gender_id.'"  /> '.$gender_name.' </label>
								</div>
	
							';
						}
					}
				?>
                <button type="submit" class="btn btn-default">Filter gender</button>
              </form>
              </ul>
            </div>
          </div>
        </div>--> <!--/Gender menu end-->  
        
       <!--Age group--> 
        <div class="panel panel-default">
          <div class="panel-heading">
            <h4 class="panel-title"> 
            <a data-toggle="collapse"  href="#collapse-age" class="collapseWill"> 
            <span class="pull-left"> <i class="fa fa-caret-right"></i></span> Aged between
            </a> 
            </h4>
          </div>
          
          <div id="collapse-age" class="panel-collapse collapse in">
            <div class="panel-body">
              <ul class="nav nav-pills nav-stacked tree">
                <form action="<?php echo site_url().'browse/filter-age';?>" method="POST">
                <?php
					echo form_hidden('post_neighbourhoods', $post_neighbourhoods);
					echo form_hidden('post_genders', $post_genders);
					echo form_hidden('post_encounters', $post_encounters);
					
					if($age_groups_query->num_rows() > 0)
					{
						foreach($age_groups_query->result() as $res)
						{
							$age_group_id = $res->age_group_id;
							$age_group_name = $res->age_group_name;
										
							if(is_array($ages_array))
							{
								$total_ages = count($ages_array);
								$checked = '';
								
								for($r = 0; $r < $total_ages; $r++)
								{
									if($ages_array[$r] == $age_group_name)
									{
										$checked = 'checked = "checked"';
										break;
									}
								}
							
								echo 
								'
									<div class="block-element">
										<input type="checkbox" name="age_group_id[]" value="'.$age_group_name.'" id="age_group_id'.$age_group_id.'" '.$checked.'/>
										<label for="age_group_id'.$age_group_id.'"><span></span> '.$age_group_name.'</label>
									</div>
		
								';
							}
							
							else
							{
								echo 
								'
									<div class="block-element">
										<input type="checkbox" name="age_group_id[]" value="'.$age_group_name.'" id="age_group_id'.$age_group_id.'" />
										<label for="age_group_id'.$age_group_id.'"><span></span> '.$age_group_name.'</label>
									</div>
		
								';
							}
						}
					}
				?>
                <button type="submit" class="btn btn-default">Filter age</button>
              </form>
              </ul>
            </div>
          </div>
        </div> <!--/Age groupd menu end--> 
        
        
        
       <!--Age group--> 
        <div class="panel panel-default">
          <div class="panel-heading">
            <h4 class="panel-title"> 
            <a data-toggle="collapse"  href="#collapse-encounter" class="collapseWill"> 
            <span class="pull-left"> <i class="fa fa-caret-right"></i></span> Who wants a 
            </a> 
            </h4>
          </div>
          
          <div id="collapse-encounter" class="panel-collapse collapse in">
            <div class="panel-body">
              <ul class="nav nav-pills nav-stacked tree">
                <form action="<?php echo site_url().'browse/filter-encounter';?>" method="POST">
                <?php
					echo form_hidden('post_neighbourhoods', $post_neighbourhoods);
					echo form_hidden('post_genders', $post_genders);
					echo form_hidden('post_ages', $post_ages);
					if($encounters_query->num_rows() > 0)
					{
						foreach($encounters_query->result() as $res)
						{
							$encounter_id = $res->encounter_id;
							$encounter_name = $res->encounter_name;
							$web_name = $this->profile_model->create_web_name($encounter_name);
										
							if(is_array($encounters_array))
							{
								$total_encounters = count($encounters_array);
								$checked = '';
								
								for($r = 0; $r < $total_encounters; $r++)
								{
									if($encounters_array[$r] == $web_name)
									{
										$checked = 'checked = "checked"';
										break;
									}
								}
								
								echo 
								'
									<div class="block-element">
										<input type="checkbox" name="encounter_id[]" value="'.$web_name.'" id="encounter_id'.$encounter_id.'" '.$checked.'/>
										<label for="encounter_id'.$encounter_id.'"><span></span> '.$encounter_name.'</label>
									</div>
		
								';
							}
							
							else
							{
								echo 
								'
									<div class="block-element">
										<input type="checkbox" name="encounter_id[]" value="'.$web_name.'" id="encounter_id'.$encounter_id.'" />
										<label for="encounter_id'.$encounter_id.'"><span></span> '.$encounter_name.'</label>
									</div>
		
								';
							}
						}
					}
				?>
                <button type="submit" class="btn btn-default">Filter encounter</button>
              </form>
              </ul>
            </div>
          </div>
        </div> <!--/Who wants a menu end--> 
       <!--Neighourhood--> 
        <div class="panel panel-default" style="overflow:visible;">
          <div class="panel-heading">
            <h4 class="panel-title"> 
            <a data-toggle="collapse"  href="#collapse-neighbourhood" class="collapseWill"> 
            <span class="pull-left"> <i class="fa fa-caret-right"></i></span> Neighbourhoods 
            </a> 
            </h4>
          </div>
          
          <div id="collapse-neighbourhood" class="panel-collapse collapse in">
            <div class="panel-body">
              <ul class="nav nav-pills nav-stacked tree">
                <form action="<?php echo site_url().'browse/filter-neighbourhood';?>" method="POST">
                	<div class="row"><div class="col-md-12">
                <?php
					echo form_hidden('post_encounters', $post_encounters);
					echo form_hidden('post_genders', $post_genders);
					echo form_hidden('post_ages', $post_ages);

					//parents
					if($neighbourhoods_query['neighbourhood_parents']->num_rows() > 0)
					{
						$parents_array = array();
						$selected = '';
						$parents_array[''] = '--All neighbourhoods--';
						$js = 'id="filter_neighbourhood" class="form-control"';
						
						foreach($neighbourhoods_query['neighbourhood_parents']->result() as $res)
						{
							$neighbourhood_id = $res->neighbourhood_id;
							$neighbourhood_name = $res->neighbourhood_name;
							$web_name = $this->profile_model->create_web_name($neighbourhood_name);
							$parents_array[$web_name] = $neighbourhood_name;
						}
						
						//check for selected neighbourhood
						if(is_array($neighbourhoods_array))
						{
							$total_neighbourhoods = count($neighbourhoods_array);
							
							for($r = 0; $r < $total_neighbourhoods; $r++)
							{
								$selected = $neighbourhoods_array[$r];
							}
						}
						echo form_dropdown('neighbourhood_parent', $parents_array, $selected, $js);
					}
					
					/*if($neighbourhoods_query->num_rows() > 0)
					{
						foreach($neighbourhoods_query->result() as $res)
						{
							$neighbourhood_id = $res->neighbourhood_id;
							$neighbourhood_name = $res->neighbourhood_name;
							$web_name = $this->profile_model->create_web_name($neighbourhood_name);
										
							if(is_array($neighbourhoods_array))
							{
								$total_neighbourhoods = count($neighbourhoods_array);
								$checked = '';
								
								for($r = 0; $r < $total_neighbourhoods; $r++)
								{
									if($neighbourhoods_array[$r] == $web_name)
									{
										$checked = 'checked = "checked"';
										break;
									}
								}
								
								
								echo 
								'
									<div class="block-element">
										<input type="checkbox" name="neighbourhood_id[]" value="'.$web_name.'" id="neighbourhood_id'.$neighbourhood_id.'" '.$checked.'/>
										<label for="neighbourhood_id'.$neighbourhood_id.'"><span></span> '.$neighbourhood_name.'</label>
									</div>
		
								';
							}
							
							else
							{
								
								echo 
								'
									<div class="block-element">
										<input type="checkbox" name="neighbourhood_id[]" value="'.$web_name.'" id="neighbourhood_id'.$neighbourhood_id.'"/>
										<label for="neighbourhood_id'.$neighbourhood_id.'"><span></span> '.$neighbourhood_name.'</label>
									</div>
		
								';
							}
						}
					}*/
				?>
                </div>
                <div class="col-md-12"><div id="children_section"></div></div></div>
				</nav>
                <button type="submit" class="btn btn-default">Filter neighbourhood</button>
              </form>
              </ul>
            </div>
          </div>
        </div> <!--/Neighourhood menu end--> 
        
      </div>
    </div>