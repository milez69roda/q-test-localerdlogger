<style type="text/css">
td{padding:3px}
form label{text-transform:capitalize}
label.error{margin-left:5px;color:#ff0000;font-weight:normal;}
</style>
<script type="text/javascript" src="js/jquery.validate.js"></script>
<form action="" id="frmcreate1" name="frmcreate1" method="post">
	<table cellspacing="5" cellpadding="5">
		<?php
		$uid="SELECT * FROM users WHERE id=".$this->session->userdata('user_id')." LIMIT 1;";
		$quer=$this->db->query($uid);
		$rows=$quer->row();
		?>
		<input type="hidden" name="userid" value="<?php echo $rows->id;?>" />
		<tr>
			<td>Username:</td>
			<td><input type="text" name="txtusername" readonly="true" value="<?php echo $rows->username?>" /></td>
		</tr>
		<tr>
			<td>Password:</td>
			<td><input type="text" name="txtpassword" value="<?php echo $rows->password?>" /></td>
		</tr>
		<tr id="avya_otp">
			<td>Avaya:</td>
			<td><input type="text" id="txtavaya" name="txtavaya" value="<?php echo $rows->avaya?>" /></td>
		</tr>
		<tr>
			<td>Firstname:</td>
			<td><input type="text" name="txtfname" value="<?php echo $rows->fname?>" /></td>
		</tr>
		<tr>
			<td>Lastname:</td>
			<td><input type="text" name="txtlname" value="<?php echo $rows->lname?>" /></td>
		</tr>
		<tr>
			<td colspan="2">&nbsp;</td>
		</tr>
		<tr>
			<td colspan="2">
				<input type="submit" name="btnsave" id="btnsave" value="Update" />
			</td>
		</tr>
	</table>
</form>
<script type="text/javascript">
	$().ready(function(){
		$.validator.addMethod("loginRegex", function(value, element) {
			return this.optional(element) || /^[a-z0-9\-]+$/i.test(value);
		}, "Must contain only letters, numbers, or dashes.");
		$("#frmcreate1").validate({
			rules: {
				txtfname: {
					loginRegex:true,
					required:true
				},
				txtlname: {
					loginRegex:true,
					required:true
				},
				txtavaya: {
					required: true,
					minlength: 4,
					maxlength: 6,
					number:true
				},
				txtpassword: {
					required: true,
					minlength: 5
				}
			},
			messages: {
				txtfname: {required:"Please enter your firstname"},
				txtlname: {required:"Please enter your lastname"},
				txtavaya: {
					required: "Please enter your avaya",
					minlength: "Your username must consist of at least 5 characters",
					number: "Please enter numeric only"
				},
				txtpassword: {
					required: "Please provide a password",
					minlength: "Your password must be at least 5 characters long"
				}
			},
			submitHandler: function() {
				$.ajax({
					type:'post',
					data:$('#frmcreate1').serialize(),
					url:"ajax_controller/updateUsers",
					dataType:"html",
					success:function(d){
						if(d=='success'){
							alert('Successfully Updated!');
							window.location='<?php echo base_url();?>auth/logout';
						}else{
							alert('Failed to save!');
						}
					},
					cache:false
				});
				return false;
			}
		});
	});
</script>