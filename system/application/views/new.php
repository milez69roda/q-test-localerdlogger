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
	
	.reqFiled{
		color:red;
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
				
				<input type="hidden"  name="issue_id1" id="issue_id1" value="" />
				<input type="hidden"  name="issuesub_id1" id="issuesub_id1" value="" />
				<?php 
					/* echo '2011-02-08 05:50 am <br/>';
					$tmp2 =  strtotime('2011-02-08 05:50 am');	
					echo $tmp2 .'<br/>';
					echo date('Y-m-d h:i:s', $tmp2); */
				?>
				<p style="color:red; padding-left: 430px;">Note: <b>Contact No.</b>, <b>MIN</b>, <b>IMEI</b>, and <b>Interaction/Case No.</b>  are searchable using the Search button</p>
				<div class="error" style="display:none"><span></span></div>
				
			<table width="900" border="0" cellpadding="1" cellspacing="1" id="mytable1"><br />
				<tr>
					<td><label class="labeltitle">First Name</label> <span class="reqFiled">*</span></td>
					<td><input type="text" name="txtcustname1" id="txtcustname1" tabindex="1" class="required" value=""/></td>
					<td><span class="labeltitle">Alternate Contact No.</span><span class="reqFiled">*</span></td>
					<td><input type="text" name="txtphoneno" id="txtphoneno" class="searchable required" value="" tabindex="7" /> <span style="color:red"> Type 'NONE' if not available</span></td>
				</tr>
				<tr>
					<td width="137"><label class="labeltitle">Last Name</label> <span class="reqFiled">*</span></td>
					<td width="246"><input type="text" name="txtcustname2" id="txtcustname2" value="" tabindex="2" class="required"/></td>
					<td><label class="labeltitle">MIN</label></td>
					<td><input type="text" name="txtmin" id="txtmin" class="searchable" value="" tabindex="8"/></td>
				</tr>                  
				<tr>
					<td><label class="labeltitle">Email Address</label><span class="reqFiled">*</span> </td>
					<td><input type="text" name="txtemailaddress" id="txtemailaddress" value="" class="required" tabindex="3" /><span style="color:red"> Type 'NONE' if no email</span></td>
					<td><label class="labeltitle">IMEI</label> <span class="reqFiled">*</span></td>
					<td width="374"><input type="text" name="txtimei" id="txtimei" value="" tabindex="9" class="required searchable"/> <a href="javascript:void(0)" name="checkimeibtn" id="checkimeibtn">Search</a> </td>
				</tr>
				<tr>
					<td valign="top" style="vertical-align:top !important"><label class="labeltitle">Channel</label> <span class="reqFiled">*</span></td>
					<td><?php
							echo form_dropdown('dchannel', $source_options, '','id="dchannel" tabindex="4" class="required"');
						?>
					</td>
					<td width="143"><label class="labeltitle">Interaction/Case No.</label><span class="reqFiled">*</span></td>
					<td width="374"><input type="text" name="txtcaseno" id="txtcaseno" value="" tabindex="10" class="required searchable"/></td>
				</tr>
				<tr>
					<td valign="top" style="vertical-align:top !important"><label class="labeltitle">Brand</label> <span class="reqFiled">*</span></td>
					<td><?php
							echo form_dropdown('dorg', $org_options, '','id="dorg" tabindex="5" class="required"');
						?>
					</td>
					<td><label class="labeltitle">CallBack</label></td>
					<td width="374">
                    	<input type="checkbox" name="needcallback" id="needcallback" value="1" tabindex="11"/>
                    	<span class="pcbdatetime" style="display:none"><input type="text" name="textcallbackdate" id="textcallbackdate" value="" tabindex="12"/></span>	
                    </td>
				</tr>
				<tr>
					<td><label class="labeltitle">Issue Type</label><span class="reqFiled">*</span></td>
					<td>
					
						<select class="required" tabindex="6" id="cissue" name="cissue">
						<?php
							//echo form_dropdown('cissue', $issue_options, '','id="cissue" tabindex="6" class="required"');	
							$option1 = "";
							$option2 = "";
							
							foreach( $issue_options as $row ):
								
								if( $row->miamionly == 1 ){
									$option1 .= '<option value="'.$row->issue_desc.'" data="'.$row->issue_id.'" >'.$row->issue_desc.'</option>';
								}else{
									$option2 .= '<option value="'.$row->issue_desc.'" data="'.$row->issue_id.'" >'.$row->issue_desc.'</option>';
								}								
							endforeach;
							echo '<option value="">--- Select Issues ---</option>';
							echo '<optgroup label="Care Center Issues">'.$option2.'</optgroup>';
							//echo '<optgroup label="Miami Issues">'.$option1.'</optgroup>';
							
							//<option value="<?php echo $val; ?>" data="<?php echo $key; ?>" ><?php echo $val; ?></option>
						?>
						</select>
						
						<input type="text" name="issueother" id="issueother" value="" class="large" style="display:none" tabindex="6"/>	
						
					</td>
					 <td><label class="labeltitle">Escalated To</label></td>
					<td width="374">
                    	<?php
							echo form_dropdown('descalated', $esc_options, '','id="descalated" tabindex="11" ');
						?>
                    </td>
				</tr>
							  
				<tr>
					<td valign="top" style="vertical-align:top !important"><label class="labeltitle">Issue Description</label></td>
					<td>
						<div id="cissue_sub_div">
							<select class="" tabindex="6" id="cissue_sub" name="cissue_sub"> </select>
						</div>
					</td>
					<td valign="top" style="vertical-align:top !important">
						<label class="labeltitle">Status</label><span class="reqFiled">*</span><br/><br/>
						<!--<label class="labeltitle">Referrence No. <em>(Issue ID)</em></label>-->
					 </td>
					<td valign="top" style="vertical-align:top !important">
						<?php
							echo form_dropdown('dstatus', $status_options, '','id="dstatus" tabindex="13" class="required"');
						?>
						<br /><br />
						<!--<input type="text" name="textrefno" id="textrefno" value="" tabindex="14" />-->

					</td>
				</tr>
							  
				<tr>
					<td valign="top" style="vertical-align:top !important"><label class="labeltitle">Agent Notes</label></td>
					<td><textarea name="txtnote" cols="38" rows="5" id="txtnote" tabindex="6"></textarea></td>
					<td style="vertical-align:top !important" class="callback_type_label">
						 
					 </td>
					<td style="vertical-align:top !important" class="callback_type">
						 			
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
		
		$("#dstatus option[value=7]").attr("disabled", true); //disable the unable to reach status on loading the page
				
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
			
		})
		
		$('#textcallbackdate').datetimepicker({
					dateFormat: 'yy-mm-dd',
					ampm: true,
					stepMinute: 10
		});
		
		$("#checkimeibtn").button();		
		$("#checkimeibtn").click(function(){
		
			var uri = '';
			count = 0;
			$(".searchable").each( function(index){
				
				//uri += $(this).attr("id")+' ';
				
				switch( $(this).attr("id") ){
					case 'txtphoneno':
						if( jQuery.trim($(this).attr("value")) != ''){
							uri += '&phone_no='+$(this).attr("value");
							count++;
						}
						break;
					case 'txtmin':					
						if( jQuery.trim($(this).attr("value")) != ''){
							uri += '&minno='+$(this).attr("value");
							count++;
						}
						break;
					case 'txtimei':
						if( jQuery.trim($(this).attr("value")) != ''){
							uri += '&imei='+$(this).attr("value");
							count++;
						}
						break;
					case 'txtcaseno':
						if( jQuery.trim($(this).attr("value")) != ''){
							uri += '&case_no='+$(this).attr("value");
							count++;
						}
						break;
				}
				
				
				
			});
			
			if( count > 0) {
				getRelatedIssues(uri);
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
			
		    /* if( $("#cissue option:selected").attr('value') == 'Other' ){
				$("#issueother").fadeIn();
			}else{
				$("#issueother").fadeOut();
			} */			
			
			if( $("#cissue option:selected").attr('value') == 'Report New Issue (Miami)' ){
			
				$("#cissue_sub_div").html('<input type="text" id="cissue_sub" name="cissue_sub" value="" />');
			
			}else{			
				$("#cissue_sub_div").html('<select class="" tabindex="6" id="cissue_sub" name="cissue_sub"> </select>');
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
			}
			
		});
		
		$("#cissue_sub").change(function(){
		
			var subid = $("#cissue_sub option:selected").attr('data');
			$("#issuesub_id1").attr("value", subid); //set the of hidden issue id field
			
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
				}/* ,
				txtnote: {
					maxlength: 255
				} */
			}


		});
		
		$("#needcallback").click( function(){
			
			if( $(this).is(":checked")){

				$("#dstatus option:first").attr("selected","selected");
				$("#dstatus option[value=7]").removeAttr("disabled");				
			}else{
				$("#dstatus option:first").attr("selected","selected");
				$("#dstatus option[value=7]").attr("disabled", true);				
			}
			
		})
		
	});
	
	function getRelatedIssues(uri){
		
		
		
		/* $("#rel_imei_display").html('searching record...');
		$("#rel_imei_display").load("dashboard/ajaxcheckemei/"+imei, function(response, status, xhr) {
			

			if (status == "error") {
				var msg = "Sorry but there was an error: ";
				$("#rel_imei_display").html(msg + xhr.status + " " + xhr.statusText);
			}

		}); */
		

		//txtphoneno txtmin txtimei txtcaseno
		
		$("#rel_imei_display").html('searching record...');
		$("#rel_imei_display").load("dashboard/ajaxcheckemei/tr=1",uri,function(response, status, xhr) {
			
			if (status == "error") {
				var msg = "Sorry but there was an error: ";
				$("#rel_imei_display").html(msg + xhr.status + " " + xhr.statusText);
			}

		}) 
	}
	
	

</script>