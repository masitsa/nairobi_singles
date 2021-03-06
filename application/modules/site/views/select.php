
        <meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="<?php echo base_url();?>assets/themes/bootstrap/css/bootstrap.min.css">
<link href="<?php echo base_url()."assets/themes/cupid/";?>css/bootstrap-select.min.css" rel="stylesheet">
	<script type="text/javascript" src="<?php echo base_url();?>assets/themes/cupid/js/jquery-2.1.1.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/themes/bootstrap/js/bootstrap.min.js"></script>
    
</head>
<body>
	
<div class="container">
	<div class="row">
		<h2>Button Dropdown Select</h2><br>
<div class="bs-docs-example">
  <select class="selectpicker" data-style="btn-primary" style="display: none;">
      <option>Mustard</option>
      <option>Ketchup</option>
      <option>Relish</option>
  </select>
  <select class="selectpicker" data-style="btn-info" style="display: none;">
      <option>Mustard</option>
      <option>Ketchup</option>
      <option>Relish</option>
  </select>
  <select class="selectpicker" data-style="btn-success" style="display: none;">
      <option>Mustard</option>
      <option>Ketchup</option>
      <option>Relish</option>
  </select>
  <select class="selectpicker" data-style="btn-warning" style="display: none;">
      <option>Mustard</option>
      <option>Ketchup</option>
      <option>Relish</option>
  </select>
  <select class="selectpicker" data-style="btn-danger" style="display: none;">
      <option>Mustard</option>
      <option>Ketchup</option>
      <option>Relish</option>
  </select>
  <select class="selectpicker" data-style="btn-inverse" style="display: none;">
      <option>Mustard</option>
      <option>Ketchup</option>
      <option>Relish</option>
  </select>
      
  </div>
<div class="bs-docs-example">
  <select class="selectpicker" multiple="" style="display: none;">
    <option>Mustard</option>
    <option>Ketchup</option>
    <option>Relish</option>
  </select>
</div>
<select class="selectpicker" data-show-subtext="true" style="display: none;">
        <option data-subtext="French's">Mustard</option>
        <option data-subtext="Heinz">Ketchup</option>
        <option data-subtext="Sweet">Relish</option>
        <option data-subtext="Miracle Whip">Mayonnaise</option>
        <option data-divider="true"></option>
        <option data-subtext="Honey">Barbecue Sauce</option>
        <option data-subtext="Ranch">Salad Dressing</option>
        <option data-subtext="Sweet & Spicy">Tabasco</option>
        <option data-subtext="Chunky">Salsa</option>
    </select>
    <select class="selectpicker" data-header="Select a condiment" style="display: none;">
        <option data-subtext="French's">Mustard</option>
        <option data-subtext="Heinz">Ketchup</option>
        <option data-subtext="Sweet">Relish</option>
        <option data-subtext="Miracle Whip">Mayonnaise</option>
        <option data-divider="true"></option>
        <option data-subtext="Honey">Barbecue Sauce</option>
        <option data-subtext="Ranch">Salad Dressing</option>
        <option data-subtext="Sweet & Spicy">Tabasco</option>
        <option data-subtext="Chunky">Salsa</option>
    </select>
    <select class="selectpicker" data-size="5" style="display: none;">
      <option>Mustard</option>
      <option>Ketchup</option>
      <option>Relish</option>
      <option>Mayonnaise</option>
      <option>Barbecue Sauce</option>
      <option>Salad Dressing</option>
      <option>Tabasco</option>
      <option>Salsa</option>
  </select>
  <select class="selectpicker">
    <optgroup label="Picnic" disabled>
      <option>Mustard</option>
      <option>Ketchup</option>
      <option>Relish</option>
    </optgroup>
    <optgroup label="Camping">
      <option>Tent</option>
      <option>Flashlight</option>
      <option>Toilet Paper</option>
    </optgroup>
  </select>
  <select class="selectpicker">
    <option>Mustard</option>
    <option class="special">Ketchup</option>
    <option>Relish</option>
  </select>
    <select class="selectpicker" data-style="btn-primary" style="display: none;">
      <option data-icon="glyphicon glyphicon-music">Mustard</option>
      <option data-icon="glyphicon glyphicon-star">Ketchup</option>
      <option data-icon="glyphicon glyphicon-heart">Relish</option>
  </select>
      <select class="selectpicker" data-style="btn-primary" data-width="auto" style="display: none;">
      <option data-icon="glyphicon glyphicon-music">Mustard</option>
      <option data-icon="glyphicon glyphicon-star">Ketchup</option>
      <option data-icon="glyphicon glyphicon-heart">Relish</option>
  </select><br>
  <h4>Original by <a href="http://silviomoreto.github.io/bootstrap-select/">http://silviomoreto.github.io/bootstrap-select/</a><br>
      Tweaked by <a href="http://www.twitter.com/RodyMolenaar">@RodyMolenaar</a>
  </h4>
	</div>
</div>

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
    <script src="http://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.5.4/bootstrap-select.js" /></script>
</body>
</html>
