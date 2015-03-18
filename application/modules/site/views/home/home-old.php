<!-- Home content -->
<div class="home-content">
	<!-- Container -->
    <div class="container">
    	<?php echo $this->load->view('site/includes/page_header');?>
    </div>
    <!-- End Container -->
</div>
<!-- End Home content -->

<div class="home-sign-up">
	<div class="container">
    	<!-- Sign in -->
        <div class="row">
            <div class="col-md-12">
            	<?php
					$attributes = array("class" => "form-inline center-align sign-up-form");
					echo form_open("sign-up", $attributes);
				?>
                    <div class="form-group">
                        <label for="exampleInputName2">I am a </label>
                        <select class="selectpicker" data-style="btn-primary" style="display: none;" name="gender_id">
                            <?php
                                if($gender_query->num_rows() > 0)
                                {
                                    foreach($gender_query->result() as $res)
                                    {
                                        echo '<option value="'.$res->gender_id.'">'.$res->gender_name.'</option>';
                                    }
                                }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        
                        <div class="bs-docs-example">
                        	<label for="exampleInputName2"> seeking a </label>
                            <select class="selectpicker" data-style="btn-primary" style="display: none;" name="client_looking_gender_id">
                            	<?php
                                	if($gender_query->num_rows() > 0)
									{
										foreach($gender_query->result() as $res)
										{
											if($res->gender_id == 2)
											{
												$selected = 'selected="selected"';
											}
											else
											{
												$selected = '';
											}
											echo '<option value="'.$res->gender_id.'" '.$selected.'>'.$res->gender_name.'</option>';
										}
									}
								?>
                            </select>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-default">Continue</button>
                </form>
            </div>
        </div>
        <!-- End Sign in -->
    </div>
</div>

<script src="<?php echo base_url();?>assets/themes/cupid/js/bootstrap-select.js" /></script>
<script type="text/javascript">
  window.onload=function(){
      $('.selectpicker').selectpicker();
      $('.rm-mustard').click(function() {
        $('.remove-example').find('[value=Mustard]').remove();
        $('.remove-example').selectpicker('refresh');
      });
      $('.rm-ketchup').click(function() {
        $('.remove-example').find('[value=Ketchup]').remove();
        $('.remove-example').selectpicker('refresh');
      });
      $('.rm-relish').click(function() {
        $('.remove-example').find('[value=Relish]').remove();
        $('.remove-example').selectpicker('refresh');
      });
      $('.ex-disable').click(function() {
          $('.disable-example').prop('disabled',true);
          $('.disable-example').selectpicker('refresh');
      });
      $('.ex-enable').click(function() {
          $('.disable-example').prop('disabled',false);
          $('.disable-example').selectpicker('refresh');
      });

      // scrollYou
      $('.scrollMe .dropdown-menu').scrollyou();

      prettyPrint();
      };
    </script>