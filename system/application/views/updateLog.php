<link rel="stylesheet" type="text/css" media="screen" href="css/ui.jqgrid.css" />
<link rel="stylesheet" type="text/css" media="screen" href="css/ui.multiselect.css" />
<link rel="stylesheet" type="text/css" media="screen" href="css/jquery.searchFilter.css" />

<script src="js/jquery.jqGrid/js/jquery.layout.js" type="text/javascript"></script>
<script src="js/jquery.jqGrid/js/i18n/grid.locale-en.js" type="text/javascript"></script>
<script type="text/javascript">
	$.jgrid.no_legacy_api = true;
	$.jgrid.useJSON = true;
</script>
<script src="js/jquery.jqGrid/js/ui.multiselect.js" type="text/javascript"></script>
<script src="js/jquery.jqGrid/js/jquery.jqGrid.js" type="text/javascript"></script>

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
			<h1 class="h1">Log Preview</h1>
			<form name="newform" id="newform" action="dashboard/updatelog/" method="POST">
			
				<input type="hidden" id="herd_id" name="herd_id" value="<?php echo $mylog->erd_id; ?>" />
				<input type="hidden" id="huid" name="huid" value="<?php echo $mylog->user_id; ?>" />
				<input type="hidden"  name="actType" id="actType" value="updatelog" />
				<input type="hidden"  name="issue_id1" id="issue_id1" value="updatelog" />
				
			
				<div class="error" style="display:none"><span></span></div>
				
				<table width="900" border="0" cellpadding="1" cellspacing="1" id="mytable1"><br />
					<tr>
						<td><label class="labeltitle">Issue ID</label></td>
						<td><strong><?php echo $mylog->center_acronym.$mylog->erd_id; ?></strong></td>
						<td><span class="labeltitle">Contact No.</span></td>
						<td><input type="text" name="txtphoneno" id="txtphoneno" tabindex="7" value="<?php echo $mylog->phone_no; ?>" /></td>
					</tr>
					<tr>
						<td width="137"><label class="labeltitle">Customer Name</label></td>
						<td width="246"><input type="text" name="txtcustname2" id="txtcustname2" tabindex="2" class="required" value="<?php echo $mylog->cust_name; ?>" /></td>
						<td><label class="labeltitle">MIN</label></td>
						<td><input type="text" name="txtmin" id="txtmin" tabindex="8" value="<?php echo $mylog->minno; ?>"/></td>
					</tr>                  
					<tr>
						<td><label class="labeltitle">Email Address</label></td>
						<td><input type="text" name="txtemailaddress" id="txtemailaddress" tabindex="3" value="<?php echo $mylog->emailaddress; ?>"/></td>
						<td><label class="labeltitle">IMEI</label></td>
						<td width="374"><input type="text" name="txtimei" id="txtimei" tabindex="9" class="required" value="<?php echo $mylog->imei; ?>"/></td>
					</tr>
					<tr>
						<td valign="top" style="vertical-align:top !important"><label class="labeltitle">Channel</label></td>
						<td><?php
								//echo $mylog->source;
								echo form_dropdown('dchannel', $source_options, $mylog->source,'id="dchannel" tabindex="4" class="required"');
							?>
						</td>
						<td width="143"><label class="labeltitle">Interaction/Case No.</label></td>
						<td width="374"><input type="text" name="txtcaseno" id="txtcaseno" tabindex="10" class="required" value="<?php echo $mylog->case_no; ?>"/></td>
					</tr>
					<tr>
						<td valign="top" style="vertical-align:top !important"><label class="labeltitle">Brand</label></td>
						<td><?php
								echo form_dropdown('dorg', $org_options,  $mylog->organization,'id="dorg" tabindex="5" class="required"');
							?>
						</td>
						<td><label class="labeltitle">CallBack</label></td>
						<td width="374">
						<?php
							$callbackcheck = '';
							
							if( $mylog->needcallback == 1 ){
								$callbackcheck = 'checked="yes"';
							}
						?>
							<input type="checkbox" name="needcallback" id="needcallback" value="1" tabindex="11" <?php echo $callbackcheck; ?> />
							<span class="pcbdatetime" style="<?php echo ($mylog->needcallback == 1 )?'display:block':'display:none'; ?>"><input type="text" name="textcallbackdate" id="textcallbackdate" value="<?php echo $mylog->callback_date; ?>" tabindex="12"/></span>	
						</td>
					</tr>
					<tr>
						<td><label class="labeltitle">Issue Type</label></td>
						<td>
							<?php
								
								/* $vissue = trim($mylog->erd_issue_desc);
								$votherissuevalue = '';
								if( $mylog->isother == 1 ){
									$vissue = "Other";
									$votherissuevalue = $mylog->erd_issue_desc;
								}
							
								echo form_dropdown('cissue', $issue_options, $vissue,'id="cissue" tabindex="6" class="required"');
								 */
								$votherissuevalue = '';
								if( $mylog->isother == 1 ){
									
									$votherissuevalue = $mylog->erd_issue_desc;
								}								 
							?>
							
							<select class="required" tabindex="6" id="cissue" name="cissue">
							<?php
								//echo form_dropdown('cissue', $issue_options, '','id="cissue" tabindex="6" class="required"');							
								foreach( $issue_options as $key=>$val ):
									$issueSelected = "";
									if( $val == $mylog->erd_issue_desc )
										$issueSelected = 'selected="selected"';
							?>
								<option value="<?php echo $val; ?>" data="<?php echo $key; ?>" <?php echo $issueSelected;?> ><?php echo $val; ?></option>
							<?php endforeach ?>
							</select>							
							
							<input type="text" name="issueother" id="issueother" class="large" style="<?php echo ($mylog->isother == 1 )?'display:block':'display:none'; ?>" tabindex="6" value="<?php echo $votherissuevalue; ?>" />	
										
						</td>
						 <td><label class="labeltitle">Escalated To</label></td>
						<td width="374">
							<?php
								echo form_dropdown('descalated', $esc_options, $mylog->escalatedto,'id="descalated" tabindex="11" ');
							?>
						</td>
					</tr>
					<tr>
						<td><label class="labeltitle">Issue Description</label></td>
						<td>
							<select class="" tabindex="6" id="cissue_sub" name="cissue_sub">
								<?php echo $issuesub_option; ?>
							</select>						
						</td>
						<td><label class="labeltitle">Status</label><br/><br/></td>
						<td width="374">
							<?php
								echo form_dropdown('dstatus', $status_options, $mylog->status_id,'id="dstatus" tabindex="13" class="required"');
							?>	
							<br /><br />
							<!--<input type="text" name="textrefno" id="textrefno" value="<?php echo $mylog->reference_id ?>" tabindex="14" />-->

						</td>
					</tr>								  
					<tr>
						<td valign="top" style="vertical-align:top !important"><label class="labeltitle">Notes</label></td>
						<td>
							<textarea name="txtnote" cols="25" rows="5" id="txtnote" tabindex="15"></textarea>
							<div>
								
								<div style="padding: 10px 2px 2px; color:red;"><?php echo $mylog->lname.', '.$mylog->fname; ?></div>
								<div><?php echo $mylog->erd_note; ?><br/>
								</div>
								<?php
									foreach( $notes as $mynote):
								?>	
								<div style="padding: 10px 2px 2px; color:red;"><?php echo $mynote->lname.', '.$mynote->fname.' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; '.$mynote->note_created; 	 ?></div>
								<div><?php echo $mynote->note_text; ?></div>
								<?php
									endforeach;
								?>
							</div>	
						</td>
						<td valign="top" style="vertical-align:top !important" class="callback_type_label">
							<?php 
								
								if( $mylog->status_id == 2 OR  $mylog->status_id == 7 ){
									echo '<label class="labeltitle" id="callback_type_label">Follow-up</label>';
								}elseif( $mylog->status_id == 3 ){
									echo '<label class="labeltitle" id="callback_type_label">Courtesy Call</label>';
								}else{
									
								}
							
							?>
						 </td>
						<td valign="top" style="vertical-align:top !important" class="callback_type">
							<?php 
								$checked = "";
								if( $mylog->status_id == 2 OR  $mylog->status_id == 7 ){
									if( $mylog->callback_type == 1) $checked = 'checked="checked"';
									echo '<input type="checkbox" name="callback_type" id="callback_type" value="1" tabindex="11" '.$checked.'/>';
								}elseif( $mylog->status_id == 3 ){
									if( $mylog->callback_type == 2) $checked = 'checked="checked"';
									echo '<input type="checkbox" name="callback_type" id="callback_type" value="2" tabindex="11" '.$checked.'/>';
								}else{
									
								}
							
							?>

						</td>
					</tr>
				</table>	
				<br />	
				<input type="submit" class="small buttonDez" name="btnSubmit"  id="btnSubmit" value="Update Log" tabindex="16"/>
				<a class="buttonDez" href="dashboard/mylog/"> Back to Listing </a>
			</form>

		</div>		
		<!--
		<br />
		<div>
			<h1 class="h1">Related Issues</h1>
			
			<div id="rel_imei_display">
			
			</div>
			
		</div>
		<br style="clear:both"/>
		-->
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
		
		$("#dstatus").change( function(){
			
			var sel = $("#dstatus option:selected").val();
			
			if( sel == 2 || sel == 7 ){
				$(".callback_type_label").html('<label class="labeltitle" id="callback_type_label">Follow-up</label>');
				$(".callback_type").html('<input type="checkbox" name="callback_type" id="callback_type" value="1" tabindex="11"/>');				
			}else if( sel == 3 ){
				$(".callback_type_label").html('<label class="labeltitle" id="callback_type_label">Courtesy Call</label>');	
				$(".callback_type").html('<input type="checkbox" name="callback_type" id="callback_type" value="2" tabindex="11"/>');	
			}else{
				$(".callback_type").html("");
				$(".callback_type_label").html("");
			}
			
		});
		
		//$('#textcallbackdate').datepicker({ dateFormat: 'yy-mm-dd' });
		
		$('#textcallbackdate').datetimepicker({
					dateFormat: 'yy-mm-dd',
					ampm: true,
					stepMinute: 10
		});
		
		/* $("#checkimeibtn").button();		
		$("#checkimeibtn").click(function(){
			var	imei = jQuery.trim($("#txtimei").attr('value'));
			
			if( imei != ''){
				getRelatedIssues(imei);
			}
		}); */
		
		
		$("#needcallback").click(function(){
			
			 if( $("#needcallback").is(':checked')){
				$(".pcbdatetime").fadeIn();
			}else{
				$(".pcbdatetime").fadeOut();
			} 			
		});
		
		//$("#cissue option:first").attr('selected',"selected");
		/* $("#cissue").change(function(){
		    if( $("#cissue option:selected").attr('value') == 'Other' ){
				$("#issueother").fadeIn();
			}else{
				$("#issueother").fadeOut();
			}
			//alert( $("#cissue option:selected").val());
		}); */
		
		$("#cissue").change(function(){
			
		    /* if( $("#cissue option:selected").attr('value') == 'Other' ){
				$("#issueother").fadeIn();
			}else{
				$("#issueother").fadeOut();
			} */			
			
			var aid = $("#cissue option:selected").attr('data');
			
			$("#issue_id1").attr("value", aid); //set the of hidden issue id field
			
			$.ajax({
				type: "GET",
				url: "<?php echo base_url(); ?>/ajax_controller/getissuesubdropdown/"+aid,			
				success: function( xhr ){
					
					$("#cissue_sub").html(xhr);					
					var subid = $("#cissue_sub option:selected").attr('data');
					$("#issuesub_id1").attr("value", subid); //set the of hidden issue sub id field
					
				}
			});
			
		});
		
		$("#cissue_sub").change(function(){
		
			var subid = $("#cissue_sub option:selected").attr('data');
			$("#issuesub_id1").attr("value", subid); //set the of hidden issue id field
			
		});

		
		
		$(".buttonDez").button();	
		
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
				var cfrm = confirm("Do you want to update the log?");
				if( cfrm ){									
					//document.newform.submit();
					//alert($("#newform").serialize());
					$.ajax({
						type: "POST",
						url: "dashboard/ajaxOpenAction/track=1",
						data: $("#newform").serialize(),
						success: function( xhr, statusText ) {
							
							if ( $.isJson(xhr) ){
								
								var json = jQuery.parseJSON(xhr);
								alert(json.msg);	
								
								if( json.status ){
									//window.location =  history.back(); 								
									setTimeout(function() {
										history.go(-2);
									}, 300);
									
								}
							
							}else{
								window.location = '<?php echo base_url(); ?>';
							}
							
						},
						error: function(request,error) {
							alert(error);
							
						}
					});						
					
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
				}/* ,
				txtnote: {
					maxlength: 255
				} */
			}


		});
		
		jQuery.isJson = function(str) {
		 if (jQuery.trim(str) == '') return false;
		 str = str.replace(/\\./g, '@').replace(/"[^"\\\n\r]*"/g, '');
		 return (/^[,:{}\[\]0-9.\-+Eaeflnr-u \n\r\t]*$/).test(str);
		}		
		
	});
	

</script>