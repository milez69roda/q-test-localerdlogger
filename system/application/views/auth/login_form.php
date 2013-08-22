<?php
$username = array(
	'name'	=> 'username',
	'id'	=> 'username',
	'class' => 'input large',
	'size'	=> 30,
	'value' => set_value('username')
);

$password = array(
	'name'	=> 'password',
	'id'	=> 'password',
	'class' => 'input large',
	'size'	=> 30
);

$remember = array(
	'name'	=> 'remember',
	'id'	=> 'remember',
	'value'	=> 1,
	'checked'	=> set_value('remember'),
	'style' => 'margin:0;padding:0'
);

$confirmation_code = array(
	'name'	=> 'captcha',
	'id'	=> 'captcha',
	'maxlength'	=> 8
);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<base href="<?php echo base_url()?>"/>
<link href="css/admin.css" rel="stylesheet" type="text/css" />
<link href="css/themes/blue.css" rel="stylesheet" type="text/css" />
<title>Local ERD Logger</title>

<!--[if IE 6]>
<script src="js/pngfix.js"></script>
<script>
    DD_belatedPNG.fix('.png_bg');
</script>        
<![endif]-->
<style type="text/css">
.error{color:#ff0000;font-size:13px;}
</style>
</head>
<body>

<div id="admin_wrapper">
	<h1>Local ERD Logger</h1>
	<?php echo form_open($this->uri->uri_string())?>
	<!--<form action="dashboard.html" method="get">-->
		<p><label>Username</label>
			<?php echo form_input($username)?>
			<?php echo form_error($username['name']); ?>
	      <!--<input name="username" type="text" class="input large" value="" />-->
	  </p>
		
	  <p><label>Password</label>
		<!--<input name="password" type="password" class="input large" value="" />-->
		<?php echo form_password($password)?>
		<?php echo form_error($password['name']); ?>
	  </p>
	  
	  <p>
		<input type="submit" name="Submit" id="button" value="Login"  class="button"/>
		<br />
		<a href="auth/register/" style="font-size:12px;font-weight:bold;">Register</a>
	  </p>
	  <?php
	  if($this->dx_auth->get_auth_error()!=""){
	  ?>
	  <div class="fail large png_bg"><?php echo $this->dx_auth->get_auth_error(); ?></div>
	  <?php
	  }
	  ?>
	   <!--<div class="success large png_bg">This is a success message.</div>
	   <div class="attention large png_bg">This is an attention message.</div>-->
	</form>
</div>
</body>
</html>