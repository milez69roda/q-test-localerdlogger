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
	
	.mytable1{
		font-size: 12px !important;
	}
	.mytable1 td{
		padding: 4px;		
	}
	
	.mytable2{
		border:1px solid #666666; 	
		color: black;
		
	}
	.mytable2 td{
		padding: 4px;
		border:1px solid #666666; 
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
	
	.error{
		
		color: red;
		
	}
	
	textarea.error{
		border: 1px block red !important;
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
				
				<table width="900" border="0" cellpadding="1" cellspacing="1" class="mytable1"><br />
					<tr>
						<td><label class="labeltitle">Issue ID</label></td>
						<td><strong><?php echo $mylog->center_acronym.$mylog->erd_id; ?></strong></td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>						
					<tr>
						<td><label class="labeltitle">Representative</label></td>
						<td><strong><?php echo $mylog->lname.', '.$mylog->fname; ?></strong></td>
						<td><label class="labeltitle">Center</label></td>
						<td><?php echo $mylog->center_desc; ?></td>
					</tr>						
					<tr>
						<td><label class="labeltitle">Status</label></td>
						<td><?php								
								echo $mylog->status_desc;
							?></td>
						<td><span class="labeltitle">Contact No.</span></td>
						<td><?php echo $mylog->phone_no; ?></td>
					</tr>
					<tr>
						<td><label class="labeltitle">Avaya</label></td>
						<td><?php echo $mylog->avaya; ?></td>
						<td><label class="labeltitle">MIN</label></td>
						<td><?php echo $mylog->minno; ?></td>
					</tr>                  
					<tr>
						<td width="137"><label class="labeltitle">Customer Name</label></td>
						<td width="246"><?php echo $mylog->cust_name; ?></td>
						<td><label class="labeltitle">IMEI</label></td>
						<td width="374"><?php echo $mylog->imei; ?></td>
					</tr>
					<tr>
						<td><label class="labeltitle">Email Address</label></td>
						<td><?php echo $mylog->emailaddress; ?></td>
						<td width="143"><label class="labeltitle">Interaction/Case No.</label></td>
						<td width="374"><?php echo $mylog->case_no; ?></td>
					</tr>
					<tr>
						<td valign="top" style="vertical-align:top !important"><label class="labeltitle">Channel</label></td>
						<td><?php										
								echo $mylog->source;
							?>                      </td>
						<td><label class="labeltitle">CallBack</label></td>
						<td width="374">			
							<?php 
								
								$var1 = strtotime($mylog->callback_date);
								if( $var1 != '' )
									echo date("F j, Y, g:i a", strtotime($mylog->callback_date)); 							
							?>						
						</td>
					</tr>
					<tr>
						<td valign="top" style="vertical-align:top !important"><label class="labeltitle">Brand</label></td>
						<td><?php							
								echo $mylog->organization;
							?>                      
						</td>
						<td><label class="labeltitle">Escalated To</label></td>
						<td width="374">
							<?php								
								echo $mylog->escalatedto;
							?>						
						</td>
					</tr>
								  
					<tr>
						<td><label class="labeltitle">Issue Type</label></td>
						<td><?php
								
								echo $mylog->erd_issue_desc;
								
							?>                      
						</td>
						<td valign="top" style="vertical-align:top !important">							
							<!--<label class="labeltitle">Referrence Issue ID</em></label>-->
							&nbsp;
						</td>
						<td valign="top" style="vertical-align:top !important">														
							<!--<?php echo $mylog->reference_id; ?>-->
							&nbsp;
						</td>
					</tr>

					<tr>
						<td><label class="labeltitle">Issue Description</label></td>
						<td><?php
								
								echo $mylog->erd_issuesub_desc;
								
							?>                      
						</td>
						<td valign="top" style="vertical-align:top !important">	
							<label class="labeltitle">	
							<?php 
								
								if( $mylog->status_id == 2 OR  $mylog->status_id == 7 ){
									echo 'Follow-up';
								}elseif( $mylog->status_id == 3 ){
									echo 'Courtesy Call';
								}else{
									
								}
							
							?>
							</label>
							&nbsp;
						</td>
						<td valign="top" style="vertical-align:top !important">		
							<?php 
								if( $mylog->status_id != 8 ){
									if( $mylog->callback_type == 1 ){
										echo 'Yes';
									}elseif( $mylog->callback_type == 2  ){
										echo 'Yes';
									}else{
										
									}
								}
							?>						
							&nbsp;
						</td>
					</tr>					
					
					<tr>
						<td valign="top" style="vertical-align:top !important"><label class="labeltitle">Date Opened</label></td>
						<td><?php echo date("F j, Y, g:i a", strtotime($mylog->date_opened)); ?></td>
						<td><label class="labeltitle">Date Closed</label></td>
						<td width="374"><?php 
								$var2 = strtotime($mylog->date_closed);
								if( $var2 != '' )
									echo date("F j, Y, g:i a", $var2); 
							
						?></td>
					</tr>	
					<tr>
						<td valign="top" style="vertical-align:top !important"><label class="labeltitle">Date Updated</label></td>
						<td> <?php echo date("F j, Y, g:i a", strtotime($mylog->date_updated)); ?></td>
						<td>&nbsp;</td>
						<td width="374">&nbsp;</td>
					</tr>					
					<tr>
					  <td valign="top" style="vertical-align:top !important"><label class="labeltitle">Agent Notes</label></td>
					  <td colspan="3"><?php echo $mylog->erd_note; ?>
						<div>
							<?php
								foreach( $notes as $mynote):
							?>	
							<div style="padding: 10px 2px 2px; color:red;"><?php echo $mynote->lname.', '.$mynote->fname.' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; '.date("F j, Y, g:i a", strtotime($mynote->note_created)); 	 ?></div>
							<div><?php echo $mynote->note_text; ?></div>
							<?php
								endforeach;
							?>
						</div>					  
					  </td>
				    </tr>
					
				</table>			
				
				<br />				
				<div>
					<table width="100%" border="1" cellpadding="0" cellspacing="0" class="mytable2">
						<tr>
							<td colspan="2">
								<h1>Comments</h1> 
							</td>
						</tr>
						<?php 

							foreach( $comments as $mycoment):
						
						?>
						<tr>
							<td width="150">
								<strong><?php echo $mycoment->fname.' '.$mycoment->lname ?><br/></strong>
								<em>(<?php echo $mycoment->name; ?>)</em>
							</td>
							<td>
								<em><?php echo date("F j, Y, g:i a", strtotime($mycoment->comment_date)); ?></em><br/>
								<?php echo $mycoment->comment_desc ?>
							</td>
						</tr>
						
						<?php 						
							endforeach;
						?>
					</table>
					
				</div>				
		</div>		
		
		<div style="font-size: 12px; padding-top: 10px; font-weight:bold">
			<?php
				//if( $mylog->user_id != $this->_userid  AND ($this->_roleid != 6) AND  ):
				if( ($this->_roleid != 6) AND ($this->_roleid != 2) ):
			?>		
			<a href="javascript:void(0)" id="postcommentabtn" >Post Comment</a> &nbsp; | &nbsp;
			<?php				
				endif;
				
				//if( ($mylog->user_id == $this->_userid)  AND ($mylog->status_id == 1  OR  $mylog->status_id == 2) ):
				//if( ($mylog->center_id == $this->_centerid)  AND ($mylog->status_id == 1  OR  $mylog->status_id == 2)  and ($this->_roleid != 6)):
				if( ($mylog->center_id == $this->_centerid)  AND ($mylog->status_id != 8 )  and ($this->_roleid != 6)):
			?>
				<a href="dashboard/updatelog/<?php echo $mylog->erd_id; ?>">Update</a> &nbsp; | &nbsp; 
			<?php
				endif;
				
				if(  ($mylog->status_id == 8 OR $mylog->status_id == 7) AND ($this->_roleid == 5 OR $this->_roleid == 1 OR $this->_roleid == 8 OR $this->_roleid == 4) ):				
			?>
				<a href="dashboard/updatelog/<?php echo $mylog->erd_id; ?>">Update</a> &nbsp; | &nbsp; 
			<?php
				endif;
				
				if( $this->_roleid == 1 AND ($mylog->status_id == 1  OR  $mylog->status_id == 2) ):
			?>
			<a href="javascript:void(0)" id="transferlogbtn">Re-Assign Issue</a> &nbsp; | &nbsp; 
			<?php
				endif;
				
				//if( ($mylog->center_id == $this->_centerid)  AND ($mylog->status_id == 1  OR  $mylog->status_id == 2) AND ($this->_roleid == 2)):
			?>
			<!--<a href="javascript:void(0)" id="addnotebtn">Add Note</a>  &nbsp; | &nbsp; -->
			<?php
				//endif;
			?>
			<a href="javascript: history.go(-1)">Back to List</a>
		</div>

		<div id="godownxs">
			<div style="padding-top:20px; display:none" id="postcommentdiv" class="actionlinks postcommentdiv">
				<div class="error" style="display:none"><span></span></div>			
				<h1 style="font-size: 12px !important; color: black"><strong>Post Comment:</strong></h1>
				<hr />
				
				<form name="newform1" id="newform1" action="dashboard/openlog/<?php echo $mylog->erd_id; ?>" method="POST">
					<input type="hidden" name="xdtoken" value="<?php echo  $mylog->erd_id; ?>" />
					<input type="hidden"  name="actType" id="actType" value="comment" />
					<textarea style="width:600px" name="comments" rows="5" class="required"></textarea> <br />
					<!--<input type="submit" name="submitbtncomment" id="submitbtncomment" value="Submit" class="small"  /> -->
					<input type="submit" class="small sbtn" name="submitbtncomment"  id="submitbtncomment" value="Submit" class="required"/>
				</form>
			</div>
			
			<div style="padding-top:20px; display:none" id="transferlogdiv" class="actionlinks transferlogdiv">
				<div class="error" style="display:none"><span></span></div>
				<div class="msgcontainer" style="display:none"></div>
				<h1 style="font-size: 12px !important; color: black"><strong>Re-Assign Issue:</strong></h1>
				<hr />
				
				<form name="newform2" id="newform2" action="dashboard/openlog/<?php echo $mylog->erd_id; ?>" method="POST">
					
					<input type="hidden"  name="efx_hlid" id="efx_hlid" value="<?php echo $mylog->erd_id; ?>" />
					<input type="hidden"  name="efx_huid" id="efx_huid" value="" />
					<!--<input type="hidden"  name="efx_hname" id="efx_hname" value="<?php echo $mylog->lname.', '.$mylog->fname; ?>" />-->
					<input type="hidden"  name="actType" id="actType" value="transfer" />
					Comments to <?php echo $mylog->lname.', '.$mylog->fname; ?>:<br />
					<textarea style="width:600px" name="comments2" rows="4" class="required"></textarea> <br />
					<br />		
					Re-assign To:<br />
					<input type="text" name="efx_toid" id="efx_toid" value="" class="required small" /><br />
					Comments:<br />
					<textarea style="width:600px" name="comments3" rows="4" class="required"></textarea>
					<br />
					<input type="submit" class="small sbtn" name="submitbtncomment"  id="submitbtncomment" value="Transfer"/>
				</form>
			</div>
			<div style="padding-top:20px; display:none" id="newnotediv" class="actionlinks newnotediv">
				<h1 style="font-size: 12px !important; color: black"><strong>Add Note:</strong></h1>
				<hr />
				<form name="newform3" id="newform3" action="dashboard/openlog/<?php echo $mylog->erd_id; ?>" method="POST">
					<input type="hidden" name="ntd_hid" id="ntd_hid" value="<?php echo  $mylog->erd_id; ?>" />
					<input type="hidden"  name="actType" id="actType" value="addnote" />
					<textarea style="width:600px" name="note" id="note" rows="5" class="required"></textarea> <br />
					<input type="submit" class="small sbtn" name="submitbtncomment3"  id="submitbtncomment3" value="Submit" class="required"/>
				</form>
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
		
		$("#postcommentabtn").click( function(){	
			
			//$("#postcommentdiv").toggle();						
			//$("#transferlogdiv").fadeOut(100);	
			
			$(".actionlinks").hide();
			$(".postcommentdiv").show();
			
			goToPage('godownxs');			
		});
		
		$("#transferlogbtn").click( function(){
			//$("#transferlogdiv").toggle();
			//$("#postcommentdiv").fadeOut(100);
			
			$(".actionlinks").hide();
			$(".transferlogdiv").show();
			
			goToPage('godownxs');	
		});
		
		$("#addnotebtn").click( function(){
			//$("#transferlogdiv").toggle();
			//$("#postcommentdiv").fadeOut(100);
			
			$(".actionlinks").hide();
			$(".newnotediv").show();
			
			goToPage('godownxs');	
		});
		
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
		
		
		
		$(".sbtn").button();	
		
		jQuery.validator.messages.required = "";
		
		$("#newform1").validate({
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
				var cfrm = confirm("Do you want to submit your comment?");
				if( cfrm ){									
					//document.newform1.submit();
					
					$.ajax({
						type: "POST",
						url: "dashboard/ajaxOpenAction/track=1",
						data: $("#newform1").serialize(),
						success: function( xhr, statusText ) {
							
							if ( $.isJson(xhr) ){
								
								var json = jQuery.parseJSON(xhr);
								alert(json.msg);	
								
								if( json.status ){
									window.location =  window.location.href;								
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
				/*textcallbackdate: {
					required:  "#needcallback:checked"

				},
				issueother:{
					required: function(){
						return ($("#cissue option:selected").attr('value') == "Other")?true:false;						
					}
				} ,
				txtnote: {
					maxlength: 255
				} */
			}
			
			
		});
		
		$("#newform2").validate({
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
				var cfrm = confirm("Do you want to tranfer the current issue?");
				if( cfrm ){			
				
					$.ajax({
						type: "POST",
						url: "dashboard/ajaxOpenAction/track=1",
						data: $("#newform2").serialize(),
						success: function( xhr, statusText ) {
							
							/* var res = jQuery.parseJSON(xhr);
							window.location = res.link;  */
							//alert(xhr);
							/* if( statusText == 'success'){
								alert('Got you!');
							} */
							
							if ( $.isJson(xhr) ){
								
								var json = jQuery.parseJSON(xhr);
								//alert(json.status)
								
								//alert(json.msg);	
								
								if( json.status ){
									window.location =  window.location.href;
									
								}else{
									
									$(".msgcontainer").fadeIn(3500,function(){
										$(".msgcontainer").html(json.msg);
									});	
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
			}


		});	
		
		$("#newform3").validate({
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
				var cfrm = confirm("Do you want to tranfer the current issue?");
				if( cfrm ){			
				
					$.ajax({
						type: "POST",
						url: "dashboard/ajaxOpenAction/track=1",
						data: $("#newform3").serialize(),
						success: function( xhr, statusText ) {

							
							if ( $.isJson(xhr) ){
								
								var json = jQuery.parseJSON(xhr);
								if( json.status ){
									window.location =  window.location.href;
									
								}else{
									
									$(".msgcontainer").fadeIn(3500,function(){
										$(".msgcontainer").html(json.msg);
									});	
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
			}

		});	
			
		
		jQuery.isJson = function(str) {
		 if (jQuery.trim(str) == '') return false;
		 str = str.replace(/\\./g, '@').replace(/"[^"\\\n\r]*"/g, '');
		 return (/^[,:{}\[\]0-9.\-+Eaeflnr-u \n\r\t]*$/).test(str);
		}
		
		
	});
	
	$( "#efx_toid" ).autocomplete({
		source: function( request, response ) {
			$.ajax({
				url: "dashboard/getUsers/track=1",
				dataType: "json",
				data: {
					style: "full",
					maxRows: 12,
					searchtxt: request.term
				},
				success: function( data ) {
					response( $.map( data, function( item ) {
						return {
							label: item.lname+', '+item.fname,
							dataid: item.uid,	
							value: item.lname+', '+item.fname
						}
					}));
				}
			});
		},
		minLength: 2,
		select: function( event, ui ) {
			
			$("#efx_huid").attr('value', ui.item.dataid);
			$("#efx_txtto").html(ui.item.label);
			//console.log( ui.item +' '+ui.item.label);				 
		},
		open: function() {
			$( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
		},
		close: function() {
			$( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
		}
	});	

	function goToPage(targetId){
		var target_offset = $('#'+targetId).offset();
		var target_top = target_offset.top;
		//$('html, body').animate({scrollTop:target_top}, 0);		
		//window.scrollTo(0, $(targetId).position().top);}
		$('html, body').scrollTop(target_top);	
		//$('#'+targetId).scroll();
	}
 
</script>