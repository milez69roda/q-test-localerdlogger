<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<base href="<?php echo base_url()?>"/>
<link href="css/admin.css" rel="stylesheet" type="text/css" />
<link href="css/themes/blue.css" rel="stylesheet" type="text/css" />
<title>Register - Local ERD Logger</title>
<script type="text/javascript" src="js/jquery-1.4.4.min.js"></script>
<script type="text/javascript" src="js/jquery.validate.js"></script>
<!--[if IE 6]>
<script src="js/pngfix.js"></script>
<script>
    DD_belatedPNG.fix('.png_bg');
</script>        
<![endif]-->
<style type="text/css">
.error{color:#ff0000;font-weight:normal;margin:0;font-size:13px;float:left;clear:both;}
table{font-family:Tahoma,Verdana}
</style>
<script type="text/javascript">
	$().ready(function(){
		getSups($('#dpcenter'));
		$('.drp_opts').change(function(){
			getSups(this);
		});
		function getSups(Obj){
			var centerid=$("#dpcenter option:selected").val();
			var deptid=$("#dpdept option:selected").val();
			//var dumpc=$("#selmprom2 option:selected").val();
			var cbosel=$(Obj).attr('name');
			$.ajax({
				type:'post',
				data:'&flag=0&center='+centerid+'&department='+deptid+'&cbosel='+cbosel,
				url:"ajax_controller/getSubs",
				dataType:"json",
				success:function(d){
					var newOptions = d.cntr;
					var selectedOption = '';
					var select = $('#supervisorid');
					var options = select.attr('options');
					$('option', select).remove();
					$.each(newOptions, function(val, text){
						options[options.length] = new Option(text, val);
					});
					select.val(selectedOption); 
				},
				cache:false
			});
		}
		$.validator.addMethod("loginRegex", function(value, element) {
			return this.optional(element) || /^[a-z0-9\-]+$/i.test(value);
		}, "Must contain only letters, numbers, or dashes.");

		$("#frmcreate").validate({
			rules: {
				firstname: {
					loginRegex:true,
					required:true
				},
				lastname: {
					loginRegex:true,
					required:true
				},
				txtusername: {
					required: true,
					minlength: 3,
					loginRegex:true,
					remote: "ajax_controller/getUsers/?flag=0"
				},
				avaya: {
					required: true,
					minlength: 4,
					maxlength: 6,
					number:true
				},
				password: {
					required: true,
					minlength: 5
				},
				password2: {
					required: true,
					minlength: 5,
					equalTo: "#password"
				},
				txtsupervisor: {
					required: true
				}
			},
			messages: {
				firstname: {required:"Please enter your firstname"},
				lastname: {required:"Please enter your lastname"},
				txtusername: {
					required: "Please enter a username",
					minlength: jQuery.format("Enter at least {0} characters"),
					remote: jQuery.format("username is already in use")
				},
				avaya: {
					required: "Please enter your avaya",
					minlength: "Your username must consist of at least 5 characters",
					number: "Please enter numeric only"
				},
				password: {
					required: "Please provide a password",
					minlength: "Your password must be at least 5 characters long"
				},
				password2: {
					required: "Repeat your password",
					minlength: jQuery.format("Enter at least {0} characters")
				}
			},
			submitHandler: function() {
				$.ajax({
					type:'post',
					data:$('#frmcreate').serialize()+'&trigs=<?php echo $trigs==true?'sup':'agent' ?>',
					url:"ajax_controller/saveTotemp",
					dataType:"html",
					success:function(d){
						if(d=='success'){
							alert('Successfully Saved! \nTell your supervisor you have registered in the ERD Tool and once they approve you can log in');
							//Tell your supervisor you have registered in the ERD Tool and once they approve you can log in.
							window.location='auth/login/';
						}else{
							alert('Failed to save!');
						}
					},
					cache:false
				});
				return false;
			}
		});
		$('#btncancel').click(function(){
			window.location='auth/login';
		});
	});
</script>
</head>
<body>

<div id="admin_wrapper">
	<h1><?php echo $trigs==true?'Supervisor Registration Form':'Agent Registration Form' ?></h1>
	<form name="frmcreate" id="frmcreate" method="post" action="#">
		<table style="width:380px;">
			<tr>
				<td valign="top" width="38%">Username</td>
				<td valign="top" width="100%"><input style="float:left;" type="text" name="txtusername" value="" /></td>
			</tr>
			<tr>
				<td valign="top">Password</td>
				<td valign="top"><input style="float:left;" type="password" id="password" name="password" value="" /></td>
			</tr>
			<tr>
				<td valign="top">Confirm Password</td>
				<td valign="top"><input style="float:left;" type="password" name="password2" value="" /></td>
			</tr>
			<tr style="display:<?php echo ($trigs!=true?'':'none')?>">
				<td valign="top">Avaya</td>
				<td valign="top"><input style="float:left;" type="text" name="avaya" value="<?php echo ($trigs==true?'00000':'')?>" /></td>
			</tr>
			<tr>
				<td valign="top">First Name</td>
				<td valign="top"><input style="float:left;" type="text" name="firstname" value="" /></td>
			</tr>
			<tr>
				<td valign="top">Last Name</td>
				<td valign="top"><input style="float:left;" type="text" name="lastname" value="" /></td>
			</tr>
			<tr>
				<td valign="top">Center</td>
				<td valign="top">
					<select style="float:left;" class="drp_opts" name="dpcenter" id="dpcenter">
						<?php
							$query = $this->db->query("SELECT * FROM centers WHERE center_disabled=0 ORDER BY center_desc ASC");
							foreach($query->result() as $row){
								echo "<option value='".$row->center_id."'>".$row->center_desc."</option>";
							}
						?>
					</select>
				</td>
			</tr>
			<tr>
				<td valign="top">Department</td>
				<td valign="top">
					<select style="float:left;" class="drp_opts" name="dpdept" id="dpdept">
						<?php
							$query1 = $this->db->query("SELECT * FROM drp_department WHERE dept_active=0 ORDER BY dept_desc ASC");
							foreach($query1->result() as $row1){
								echo "<option value='".$row1->dept_id."'>".$row1->dept_desc."</option>";
							}
						?>
					</select>
				</td>
			</tr>
			<tr style="display:<?php echo ($trigs!=true?'':'none')?>">
				<td valign="top">Supervisor</td>
				<td valign="top">
					<select style="float:left;" name="supervisorid" id="supervisorid">
						<option>---</option>
					</select>
				</td>
			</tr>
			<tr>
				<td colspan="2">&nbsp;</td>
			</tr>
			<tr>
				<td colspan="2">
					<input type="submit" value="Submit" name="btnsubmit" />
					<input type="button" value="Cancel" id="btncancel" name="btncancel" />
				</td>
			</tr>
		</table>
		<br />
		<a href="<?php echo base_url();?>">Back to Login Page </a>
	</form>
</div>
</body>
</html>