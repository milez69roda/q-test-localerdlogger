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
							<?php echo $mylog->callback_date; ?>						
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
						<td><label class="labeltitle">Issue Description</label></td>
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
						<td valign="top" style="vertical-align:top !important"><label class="labeltitle">Date Opened</label></td>
						<td><?php echo $mylog->date_opened; ?></td>
						<td><label class="labeltitle">Date Closed</label></td>
						<td width="374"><?php echo $mylog->date_closed; ?></td>
					</tr>	
					<tr>
						<td valign="top" style="vertical-align:top !important"><label class="labeltitle">Date Updated</label></td>
						<td> <?php echo $mylog->date_updated; ?></td>
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
		
		<br style="clear:both"/>
	</div><!-- END MAIN CONTENT -->
 
</div>
<!-- END CONTEMT -->

<script type="text/javascript">

	$(function() {
				
		$(".sbtn").button();	
		
		$("#currentlogininfo, #navigation").css('display','none');
		
	});	
 
</script>