<style type="text/css">
td{padding:3px}
form label{text-transform:capitalize}
label.error{margin-left:5px;color:#ff0000;font-weight:normal;}
</style>
<script type="text/javascript" src="js/jquery.validate.js"></script>
<form action="" id="frmcreate" name="frmcreate" method="post">
	<table cellspacing="5" cellpadding="5">
		<?php
		$roles=$this->session->userdata('role_id');
		if($roles!=2 && $roles!=1){
		?>
		<tr>
			<td colspan="2">
				<label><input class="optagnts" type="radio" name="optagnt[]" value="2" checked="checked" />&nbsp;Agent</label>
				<label><input class="optagnts" type="radio" name="optagnt[]" value="1" />&nbsp;Supervisor</label>
				<label><input class="optagnts" type="radio" name="optagnt[]" value="5" />&nbsp;Manager</label>
				<label><input class="optagnts" type="radio" name="optagnt[]" value="6" />&nbsp;QA</label>
			</td>
		</tr>
		<?php
		}
		?>
		<tr>
			<td>Username:</td>
			<td><input type="text" name="txtusername" value="" /></td>
		</tr>
		<tr>
			<td>Password:</td>
			<td><input type="text" name="txtpassword" value="" /></td>
		</tr>
		<tr id="avya_otp">
			<td>Avaya:</td>
			<td><input type="text" id="txtavaya" name="txtavaya" value="" /></td>
		</tr>
		<tr>
			<td>Firstname:</td>
			<td><input type="text" name="txtfname" value="" /></td>
		</tr>
		<tr>
			<td>Lastname:</td>
			<td><input type="text" name="txtlname" value="" /></td>
		</tr>
		<?php
		
		if($roles==1  or $roles==5){
			echo "<input type='hidden' name='dpcenter' value='".$this->session->userdata('center_id')."' />";
		}else{
		?>
		<tr>
			<td>Center:</td>
			<td>
				<select class="drp_opts" name="dpcenter" id="dpcenter">
					<?php
						$query = $this->db->query("SELECT * FROM centers WHERE center_disabled=0 ORDER BY center_desc ASC");
						foreach($query->result() as $row){
							echo "<option value='".$row->center_id."'>".$row->center_desc."</option>";
						}
					?>
				</select>
			</td>
		</tr>
		<?php
		}
		if($roles==1){
			echo "<input type='hidden' name='dpdept' value='".$this->session->userdata('dept_id')."' />";
		}else{
		?>
		<tr>
			<td>Department:</td>
			<td>
				<select class="drp_opts" name="dpdept" id="dpdept">
					<?php
						$query1 = $this->db->query("SELECT * FROM drp_department WHERE dept_active=0 ORDER BY dept_desc ASC");
						foreach($query1->result() as $row1){
							echo "<option value='".$row1->dept_id."'>".$row1->dept_desc."</option>";
						}
					?>
				</select>
			</td>
		</tr>
		<?php
		}
		
		if($roles==1){
			echo "<input type='hidden' name='supervisorid' value='".$this->session->userdata('user_id')."' />";
		}else{
		?>
		<tr id="supts">
			<td>Supervisor:</td>
			<td>
				<select name="supervisorid" id="supervisorid">
					<option>---</option>
				</select>
				<!--<input type="text" name="supervisorid" value="" />-->
			</td>
		</tr>
		<?php
		}	
		?>
		<tr>
			<td colspan="2">&nbsp;</td>
		</tr>
		<tr>
			<td colspan="2">
				<input type="submit" name="btnsave" id="btnsave" value="Save" />
			</td>
		</tr>
	</table>
</form>
<script type="text/javascript">
	$().ready(function(){
		<?php
			if($roles!=2 && $roles!=1){
		?>
		getSups($('#dpcenter'));
		<?php 
			}
		?>
		$('.drp_opts').change(function(){
			getSups(this);
		});
		$('.optagnts').click(function(){
			if($(this).val()==2){
				getSups($('#dpcenter'));
				$('#supts').show();
				$('#txtavaya').val('');
				$('#avya_otp').show();
			}else{
				$('#supts').hide();
				$('#avya_otp').hide();
				$('#txtavaya').val('00000');
				var selopt= $('#supervisorid');
				$('option',selopt).remove();
				$(selopt).append('<option val="0"></option>');
			}
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
				txtfname: {
					loginRegex:true,
					required:true
				},
				txtlname: {
					loginRegex:true,
					required:true
				},
				txtusername: {
					required: true,
					minlength: 3,
					loginRegex:true,
					remote: "ajax_controller/getUsers/?flag=0"
				},
				txtavaya: {
					required: true,
					minlength: 4,
					maxlength:6,
					number:true
				},
				txtpassword: {
					required: true,
					minlength: 5
				},
				txtsupervisor: {
					required: true
				}
			},
			messages: {
				txtfname: {required:"Please enter your firstname"},
				txtlname: {required:"Please enter your lastname"},
				txtusername: {
					required: "Please enter a username",
					minlength: jQuery.format("Enter at least {0} characters"),
					remote: jQuery.format("username is already in use")
				},
				txtavaya: {
					required: "Please enter your avaya",
					minlength: "Your avaya must consist of at least 4 characters",
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
					data:$('#frmcreate').serialize(),
					url:"ajax_controller/saveUsers",
					dataType:"html",
					success:function(d){
						if(d=='success'){
							alert('Successfully Save!');
							window.location='dashboard/manageaccount';
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