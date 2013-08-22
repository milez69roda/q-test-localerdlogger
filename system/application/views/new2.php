<script SRC="js/jquery-ui-timepicker-addon.js" type="text/javascript"></script>
<script SRC="js/jquery.validate.js" type="text/javascript"></script>
<style>
	/* .ui-widget-content{
		border: 1px solid #171717 !important;
	}	 */
	.lfleft{
			float:left; 
			width:155px;
	}
	
	.ui-timepicker-div .ui-widget-header{ margin-bottom: 8px; }
	.ui-timepicker-div dl{ text-align: left; }
	.ui-timepicker-div dl dt{ height: 25px; }
	.ui-timepicker-div dl dd{ margin: -40px 0 10px 65px; }
	.ui-timepicker-div td { font-size: 80%; }
	
	#mytable1{
		
	}
	#mytable1 td{
		padding: 4px;
	}
	
	.star{
		color:red;
		font-weight:bold;
	}
	
	.labeltitle{
		font-weight:bold !important;
		text-transform: none !important;
		color: #333333;
	}
	.ui-button .ui-button-text {
		line-height: 1.0 !important;
	}
	
	input.error, select.error{
		
		border: 1px solid red !important;
		
	}
	
	div.error{
		color: red;
	}
	
	label.error{
		color:red;
		text-transform: none !important;
	}
</style>

<!-- START CONTENT -->
<div id="content">

    <!-- START MAIN CONTEMT -->
    <div id="main_content">
		
         
		<!--<p>Here are some example form elements. You can add some custom classes like small, medium and last to adjust to your own needs.</p>-->
		
		
		
		<div>
			<h1 class="h1">New Call</h1>
			<form name="newform" id="newform" action="dashboard/newlog" method="POST">
				<?php 
					/* echo '2011-02-08 05:50 am <br/>';
					$tmp2 =  strtotime('2011-02-08 05:50 am');	
					echo $tmp2 .'<br/>';
					echo date('Y-m-d h:i:s', $tmp2); */
				?>
				<div class="error" style="display:none"><span></span></div>
				
				<table width="900" border="0" cellpadding="1" cellspacing="1" id="mytable1"><br />
				<tr>
					<td><label class="labeltitle">First Name</label></td>
					<td><input type="text" name="txtcustname1" id="txtcustname1" tabindex="1" class="required" value=""/></td>
					<td><span class="labeltitle">Contact No.</span></td>
					<td><input type="text" name="txtphoneno" id="txtphoneno" value="" tabindex="7" /></td>
				</tr>
				<tr>
					<td width="137"><label class="labeltitle">Last Name</label></td>
					<td width="246"><input type="text" name="txtcustname2" id="txtcustname2" value="" tabindex="2" class="required"/></td>
					<td><label class="labeltitle">MIN</label></td>
					<td><input type="text" name="txtmin" id="txtmin" value="" tabindex="8"/></td>
				</tr>                  
				<tr>
					<td><label class="labeltitle">Email Address</label></td>
					<td><input type="text" name="txtemailaddress" id="txtemailaddress" value="" tabindex="3" /></td>
					<td><label class="labeltitle">IMEI</label></td>
					<td width="374"><input type="text" name="txtimei" id="txtimei" value="" tabindex="9" class="required"/> <a href="javascript:void(0)" name="checkimeibtn" id="checkimeibtn">Check</a> </td>
				</tr>
				<tr>
					<td valign="top" style="vertical-align:top !important"><label class="labeltitle">Channel</label></td>
					<td><?php
							echo form_dropdown('dchannel', $source_options, '','id="dchannel" tabindex="4" class="required"');
						?>
					</td>
					<td width="143"><label class="labeltitle">Interaction/Case No.</label></td>
					<td width="374"><input type="text" name="txtcaseno" id="txtcaseno" value="" tabindex="10" class="required"/></td>
				</tr>
				<tr>
					<td valign="top" style="vertical-align:top !important"><label class="labeltitle">Brand</label></td>
					<td><?php
							echo form_dropdown('dorg', $org_options, '','id="dorg" tabindex="5" class="required"');
						?>
					</td>
					<td><label class="labeltitle">CallBack</label></td>
					<td width="374"><input type="checkbox" name="needcallback" id="needcallback" value="1" tabindex="11"/></td>
				</tr>
				<tr>
					<td><label class="labeltitle">Issue Description</label></td>
					<td>
						<?php
							echo form_dropdown('cissue', $issue_options, '','id="cissue" tabindex="6" class="required"');
						?>
						<input type="text" name="issueother" id="issueother" value="" class="large" style="display:none" tabindex="6"/>					
					</td>
					 <td><label class="labeltitle pcbdatetime" style="display:none">Callback Datetime</label></td>
					<td width="374"><span class="pcbdatetime" style="display:none"><input type="text" name="textcallbackdate" id="textcallbackdate" value="" tabindex="12"/></span></td>
				</tr>
							  
				<tr>
					<td valign="top" style="vertical-align:top !important"><label class="labeltitle">Notes</label></td>
					<td><textarea name="txtnote" cols="25" rows="5" id="txtnote" tabindex="15"></textarea></td>
					<td valign="top" style="vertical-align:top !important">
						<label class="labeltitle">Status</label><br/><br/>
						<label class="labeltitle">Referrence No. <em>(Issue ID)</em></label>
					 </td>
					<td valign="top" style="vertical-align:top !important">
						<?php
							echo form_dropdown('dstatus', $status_options, '','id="dstatus" tabindex="13" class="required"');
						?>
						<br /><br />
						<input type="text" name="textrefno" id="textrefno" value="" tabindex="14" />

					</td>
				</tr>
				</table>				
				<input type="submit" class="small" name="btnSubmit"  id="btnSubmit" value="Submit Log" tabindex="16"/>
			</form>

		</div>		
		
		<br />
		<div>
			<h1 class="h1">Related Issues</h1>
			
			<div id="rel_imei_display">
			
			</div>
			
		</div>
		<br style="clear:both"/>
	</div><!-- END MAIN CONTENT -->
 
</div>
<!-- END CONTEMT -->

<div style="display:none">
	<div id="confirm-submit" title="Confirmation Dialog">
		
		Do you want to continue submitting the log?
	</div>
</div>

<script type="text/javascript">

	$(function() {
		
		//$('#textcallbackdate').datepicker({ dateFormat: 'yy-mm-dd' });
		
		$('#textcallbackdate').datetimepicker({
					dateFormat: 'yy-mm-dd',
					ampm: true,
					stepMinute: 10
		});
		
		$("#checkimeibtn").button();		
		$("#checkimeibtn").click(function(){
			var	imei = jQuery.trim($("#txtimei").attr('value'));
			
			if( imei != ''){
				getRelatedIssues(imei);
			}
		});
		
		
		$("#needcallback").click(function(){
			
			 if( $("#needcallback").is(':checked')){
				$(".pcbdatetime").fadeIn();
			}else{
				$(".pcbdatetime").fadeOut();
			} 			
		});
		
		$("#cissue option:first").attr('selected',"selected");
		$("#cissue").change(function(){
		    if( $("#cissue option:selected").attr('value') == 'Other' ){
				$("#issueother").fadeIn();
			}else{
				$("#issueother").fadeOut();
			}
			//alert( $("#cissue option:selected").val());
		});
		
		
		
		$("#btnSubmit").button();	
		
		jQuery.validator.messages.required = "";
		
		$("#newform").validate({
			invalidHandler: function(e, validator) {
				var errors = validator.numberOfInvalids();
				if (errors) {
					var message = errors == 1
						? 'You missed 1 field. It has been highlighted below'
						: 'You missed ' + errors + ' fields.  They have been highlighted below';
					$("div.error span").html(message);
					$("div.error").show();
				} else {
					$("div.error").hide();
				}
			},
			onkeyup: false,
			submitHandler: function() {
				$("div.error").hide();
				var cfrm = confirm("Do you want to continue submitting the log?");
				if( cfrm ){									
					document.newform.submit();
					//alert($("#newform").serialize());
				}
				
			},
			rules: {
				textcallbackdate: {
					required:  "#needcallback:checked"

				},
				issueother:{
					required: function(){
						return ($("#cissue option:selected").attr('value') == "Other")?true:false;						
					}
				},
				txtnote: {
					maxlength: 255
				}
			}


		})
		
	});
	
	function getRelatedIssues(imei){
		
		$("#rel_imei_display").html('fetching record...');
		$("#rel_imei_display").load("dashboard/ajaxcheckemei/"+imei, function(response, status, xhr) {
			

			if (status == "error") {
				var msg = "Sorry but there was an error: ";
				$("#rel_imei_display").html(msg + xhr.status + " " + xhr.statusText);
			}

		});

	}
	
	

</script>