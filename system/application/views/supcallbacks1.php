
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

<style type="text/css">

	.ui-timepicker-div .ui-widget-header{ margin-bottom: 8px; }
	.ui-timepicker-div dl{ text-align: left; }
	.ui-timepicker-div dl dt{ height: 25px; }
	.ui-timepicker-div dl dd{ margin: -40px 0 10px 65px; }
	.ui-timepicker-div td { font-size: 80%; }
	
	/*.ui-jqgrid tr.jqgrow td {
		white-space: normal !important;
		height:auto;
		vertical-align:middle;
		padding-top:2px;
	}
	
	.EditTable {
		width: 95% !important;
	}
	
	.DataTD{
		float:left;
	}
	.CaptionTD{
		vertical-align: bottom !important;
		width: 50% !important;
	} */

	/* #pData, #nData{
		display:none !important;
	} */
	
	
	
	
	.ui-jqgrid tr.jqgrow td {
		vertical-align:middle;
		padding-top:2px;
	}
	
	.EditTable {
		width: 95% !important;
	}

	.CaptionTD{
		vertical-align: top !important;
		width: 185px !important;
	}


	
	#ViewTbl_list2 tr{
		border: 1px solid black !important;
	}

	.ui-jqdialog-content .form-view-data{
		white-space: normal !important;
	}
	
	.ui-button-text{
		color: yellow !important;
	}	
	
	.ui-jqgrid tr.jqgrow td{
		white-space: nowrap !important;
		height: 20px !important;
	}

    #scrollTable {
		height:250px;
		overflow-x:hidden;
		overflow-y:scroll;
    }	
	
</style>

    <!-- START CONTENT -->
    <div id="content">
 
		<!-- START MAIN CONTEMT -->
		<div id="main_content">
			
			<div id="grid_container">
				<h1 class="h1">All My Logs <span style="padding-left:130px; color:red">NOTE: After 3rd unable to reach, change status of call log to closed.</span></h1>
				<div style="padding: 3px 0;">
					<strong>Filter Date</strong> From: <input type="text" name="xdatefrom" id="xdatefrom" value="<?php echo date("Y-m-d"); ?>" />
					To: <input type="text" name="xdateto" id="xdateto" value="<?php echo date("Y-m-d"); ?>" />
					<input type="button" id="searchrange" value="Search" />
				</div>	  				
				<div id="list2_container">	
					<table id="list2"></table> 
					<div id="pager2"></div> 			
				</div>
			</div>
			<div id="edit_container" style="display:none">
			
				<h1 class="h1">Transfer Log</h1>
				<form id="transferform" name="transferform" method="post">
					
					<input type="hidden"  name="efx_huid" id="efx_huid" value="" />
					<input type="hidden"  name="efx_hlog" id="efx_hlog" value="" />
					
					<div id="log_info_container">
						
						<table width="900" border="1" cellpadding="0" cellspacing="0" class="tablesorter">
						
						  <tr>
							<td><strong>Issue ID</strong></td>
							<td>&nbsp;<span id="efx_dissueid"></span></td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
						  </tr>
						  <tr>
							<td width="110"><strong>Representative</strong></td>
							<td width="166">&nbsp;<span id="efx_direpsname"></span></td>
							<td width="144"><strong>Center</strong></td>
							<td width="110">&nbsp;<span id="efx_dcenter"></span></td>
							<td width="111"><strong>Department</strong></td>
							<td width="144">&nbsp;<span id="efx_didepartment"></span></td>
						  </tr>
						  <tr>
							<td><strong>Customer Name</strong></td>
							<td>&nbsp;<span id="efx_dcust"></span></td>
							<td><strong>Email Address</strong></td>
							<td>&nbsp;<span id="efx_demail"></span></td>
							<td><strong>Contact No</strong></td>
							<td>&nbsp;<span id="efx_dcontact"></span></td>
						  </tr>
						  <tr>
							<td><strong>MIN</strong></td>
							<td>&nbsp;<span id="efx_dmin"></span></td>
							<td><strong>IMEI</strong></td>
							<td>&nbsp;<span id="efx_dimei"></span></td>
							<td><strong>Channel</strong></td>
							<td>&nbsp;<span id="efx_dchannel"></span></td>
						  </tr>
						  <tr>
							<td><strong>Brand</strong></td>
							<td>&nbsp;<span id="efx_dbrand"></span></td>
							<td><strong>Interaction/Case No</strong></td>
							<td>&nbsp;<span id="efx_dcaseno"></span></td>
							<td><strong>Callback</strong></td>
							<td>&nbsp;<span id="efx_dcallback"></span></td>
						  </tr>
						  <tr>
							<td><strong>Issue Description</strong></td>
							<td>&nbsp;<span id="efx_dissuedesc"></span></td>
							<td><strong>Escalated</strong></td>
							<td>&nbsp;<span id="efx_descated"></span></td>
							<td><strong>Status</strong></td>
							<td>&nbsp;<span id="efx_dstatus"></span></td>
						  </tr>
						  <tr>
							<td><strong>Notes</strong></td>
							<td>&nbsp;<span id="efx_dnotes"></span></td>
							<td><strong>Comments</strong></td>
							<td>&nbsp;<span id="efx_dcomments"></span></td>
							<td><strong>Referrence No.</strong></td>
							<td>&nbsp;<span id="efx_drefno"></span></td>
						  </tr>
						</table>
						
					</div>
					<div id="errorDivnote" style="color:red; display:none">
					
					</div>
					<div>
						<table width="743" border="0" cellpadding="0" cellspacing="0">
							<tr>
							  <td style="vertical-align:top"><strong>Message to</strong> <br/><span id="efx_txtfrom" style="font-weight:bold; color:#0033FF">&nbsp;</span> <span style="color:red">*</span></td>
							  <td><textarea name="efx_tocomments1" cols="60" rows="3" id="efx_tocomments1"></textarea></td>
							</tr>
							<tr>
								<td width="130"><strong>Transfer To:<span style="color:red">*</span></strong></td>
								<td width="613"><input type="text" name="efx_toid" id="efx_toid" value="" /></td>
							</tr>
							<tr>
								<td style="vertical-align:top"><strong>Comments To:</strong>
								<br/><span id="efx_txtto" style="font-weight:bold; color:#0033FF">&nbsp;</span>
								<span style="color:red">*</span></td>
								<td><textarea name="efx_tocomments2" cols="60" rows="3" id="efx_tocomments2"></textarea> </td>
							</tr>
							<tr>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
							</tr>							
						</table>
						
					</div>
					
					<div>
						<input type="button" name="efx_savebtn" id="efx_savebtn" value="Transfer Log" />
						<input type="button" id="backtogridbtn" value="Back to Grid" />
					</div>
					
				</form>
	
			</div>
		</div><!-- END MAIN CONTENT -->

	</div>
<!-- END CONTEMT -->

<script type="text/javascript">
	/*
		css/themes/black-tie/jquery-ui-1.8.9.custom.css
		
		LINE 77 CHANGE background: #111111 url(images/ui-bg_glass_40_111111_1x400.png) 50% 50% repeat-x TO background: #111111 url(images/ui-bg_glass_40_111111_1x400.png) 50% 55% repeat-x 
		LINE 79 CHANGE background: #1c1c1c url(images/ui-bg_glass_55_1c1c1c_1x400.png) 50% 50% repeat-x; TO background: #1c1c1c url(images/ui-bg_glass_55_1c1c1c_1x400.png) 50% 55% repeat-x;
	*/

	$(document).ready(function() {
		
		$("#xdatefrom").datepicker({dateFormat:'yy-mm-dd'});
		$("#xdateto").datepicker({dateFormat:'yy-mm-dd'});
		
		var setwidth = $('#list2_container').width();

		var mygrid = jQuery("#list2").jqGrid({ 
			url:'dashboard/ajaxsupcallbacks/?track=1&own=<?php echo ($this->uri->segment(2) == 'icallback')?'0':'1'; ?>', 
			datatype: "json", 
			height: '100%',
			/*height: '100%',*/
			width: setwidth-5, 
			mtype: 'GET',
			colNames:['','No. of Comments','ID','Status', 'Supervisor','Representative', 'Avaya', 'IMEI', 'Contact No', 'Customer Name', 'Case No', 'Issue Type', 'Issue Description',  'Callback', 'Callback Date/Time', 'MIN', 'Channel','Organization','Email Address', 'Escalated'], 
			colModel:[ {name:'options',index:'options', width:50, editable:false, search:false, viewable:false}, 	
					   {name:'numofcom',index:'numofcom', width:75, align:'center', search:false},
					   {name:'erd_id',index:'erd_id', width:60, search:true, searchoptions:{sopt:['eq']}}, 						   					   					  
					   {name:'status_id',index:'status_id', width:80,  search:true, stype:'select', searchoptions:{sopt:['eq'], dataUrl:"dashboard/getstatusdropdown/"}}, 
					   {name:'supervisor_id',index:'supervisor_id', <?php echo ($this->uri->segment(2) == 'icallback')?'hidden:true,':''; ?> width:150, search:true, stype:'select', searchoptions:{sopt:['eq'], dataUrl:"dashboard/getSupervisorDropdown/"}}, 
					   {name:'lname',index:'lname', width:90, search:true, 
							searchoptions:{
								dataInit:function(el){																									
									$(el).autocomplete({source:"dashboard/ajaxgetReps/?track=1"});																																																									
								}
							}
					   }, 	
					   {name:'avaya',index:'avaya', width:60, search:true},
					   {name:'imei',index:'imei', width:150, search:true}, 	
					   {name:'phone_no',index:'phone_no', width:90, editable:false, search:true}, 	
					   {name:'cust_name',index:'cust_name', width:120, search:true, searchoptions:{sopt:['cn']}}, 
					   {name:'case_no',index:'case_no', width:90, search:true}, 
					   {name:'erd_issue_desc',index:'erd_issue_desc', width:150,  search:true, stype:'select', searchoptions:{sopt:['eq'], dataUrl:"dashboard/getissuedropdown/"}, sortable:false}, 					   					  
					   {name:'erd_issuesub_desc',index:'erd_issuesub_desc', width:150,  search:true, stype:'select', searchoptions:{sopt:['eq'], dataUrl:"dashboard/getissuesubdropdown/"}, sortable:false}, 					   					  
					   {name:'needcallback',index:'needcallback', width:80, hidden:true, align:'left', search:true, stype:'select', searchoptions:{sopt:['eq'], value:":-select-;1:Yes;0:No"},viewable:false}, 						   
					   {name:'callback_date',index:'callback_date', width:100, 
							searchoptions:{
								dataInit:function(el){
									$(el).datepicker({dateFormat:'yy-mm-dd'});
								}
							}
					   },
					   {name:'minno',index:'minno', width:100, search:true},
					   {name:'source',index:'source', width:100, search:true, stype:'select', searchoptions:{sopt:['eq'], dataUrl:"dashboard/getSourceDropdown/"}},
					   {name:'organization',index:'organization', width:100, search:true, stype:'select', searchoptions:{sopt:['eq'], dataUrl:"dashboard/getOrgDropdown/"}},
					   {name:'emailaddress',index:'emailaddress', width:100, search:true},					   
					   {name:'escalatedto',index:'escalatedto', width:150, search:true, stype:'select', searchoptions:{sopt:['eq'], dataUrl:"dashboard/getEscalatedDropdown/"}, sortable:true} 
					   	
			], 
			gridComplete: function(){ 
				var ids = jQuery("#list2").jqGrid('getDataIDs'); 				
								
				for(var i=0;i < ids.length;i++){ 
				
					var cl = ids[i]; 
					
					/* ae = '<a href="javascript:void(0)" onclick="updatelog('+cl+');" class="alink">C</a>';									
					ab = '<a href="javascript:void(0)" onclick="transferLog('+cl+');" class="alink">T</a>';									
					jQuery("#list2").jqGrid('setRowData',ids[i],{options:ae+ab});  */
					
					oe = '<a href="dashboard/openlog/'+cl+'" class="alink" title="Open Log"> Open </a><br/>';
					jQuery("#list2").jqGrid('setRowData',ids[i],{options:oe}); 					
				}
				
				jQuery(".alink").button();	
			},	
			/* ondblClickRow: function(id){
				
				jQuery("#list2").jqGrid('viewGridRow', id,
						{
							width:800
						}
				);
			}, */	
			postData: {
				xdfrom: function(){ return jQuery("#xdatefrom").attr("value"); },
				xdto: function(){ return jQuery("#xdateto").attr("value"); }
			},				
			rowNum:10, 
			rowList:[10,20,30],
			rownumbers: true,
			shrinkToFit: false,
			sortname: "callback_date", 
			viewrecords: true, 
			sortorder: "asc",
			pager: '#pager2', 		
			gridview: true, 
			editurl: 'dashboard/ajaxSuplogsaction',			
			caption:""
		});
			
		jQuery("#list2").jqGrid('navGrid','#pager2',{edit:false,add:false,del:false,search:false, view:false},{},{},{} ); 

		//resizing grid
		jQuery("#list2").jqGrid('gridResize',{minWidth:900,maxWidth:1024,minHeight:300, maxHeight:700});
		
		//add toggle search button	
		jQuery("#list2").jqGrid('navButtonAdd',"#pager2",{caption:"Toggle Search",title:"Toggle Search Toolbar", buttonicon :'ui-icon-pin-s', 
														onClickButton:function(){ mygrid[0].toggleToolbar() } 
													}); 	
		jQuery("#list2").jqGrid('navButtonAdd',"#pager2",{caption:"Clear Search",title:"Clear Search",buttonicon :'ui-icon-refresh', 
														onClickButton:function(){ mygrid[0].clearToolbar() } 
													}); 
		
		jQuery("#list2").jqGrid('filterToolbar',{stringResult: true,searchOnEnter : true}); 

		jQuery("#list2").jqGrid('navButtonAdd',"#pager2",{caption:"Export to Excel",title:"Export to Excel",buttonicon :'ui-icon-save', 
														onClickButton:function(){ 
														
															var postData = $("#list2").jqGrid('getGridParam','postData');
															var str = '';
															for(i in postData){
																
																if( i == 'xdfrom' || i == 'xdto' ){
																}else{	
																	str+=i+"="+postData[i]+"&";
																	//console.log(i+"="+postData[i]);	
																}
															}	
															str += str+"&xdfrom="+jQuery("#xdatefrom").attr("value")+"&xdto="+jQuery("#xdateto").attr("value");
															 
															window.location = "<?php echo base_url();?>dashboard/ajaxExportAction/?track=1&tablType=callback&"+str;	
															
															/* var postData = $("#list2").jqGrid('getGridParam','postData');
															var str = '';
															for(i in postData){
																str+=i+"="+postData[i]+"&";
															}	
															
															str = str+"&xdfrom="+jQuery("#xdatefrom").attr("value")+"&xdto="+jQuery("#xdateto").attr("value");
															
															$.ajax({
																type: "GET",
																url: 'dashboard/ajaxExportAction/?track=1&tablType=callback&'+str,
																success: function(response){
																
																	var result = jQuery.parseJSON(response);
	
																	window.location = "<?php echo base_url();?>"+result.filepath;
																}
															}); */
									
														} 
													}); 		
		
		
		$(".ui-jqgrid-sortable").css('white-space', 'normal');
		$(".ui-jqgrid-sortable").css('height', 'auto');		


		//freez header
		 var maxWidth = $('#Header1').width();    // Get max row Width
		 $('#Header2 th').each(function(i) {     // Set col headers widths to to match col widths 
			  var width = $(this).width();
			  $('#Header1 th').eq(i).width(width);
		 });

		 var blankSpace = maxWidth - $('#Header1').width();               // Calculate extra space
		 $('#Header1 th:last').width( $('#Header1 th:last').width() + blankSpace );  // Stretch last header column to fill remaining space


		 
		$("#backtogridbtn").click(function(){
		
			/* $("#edit_container").slideToggle('normal', function(){
				$("#grid_container").css('display','block');
			}); */
			
			backtogridfunc();
			
		});
		
		
		//autocomplete users

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

		$("#efx_savebtn").click( function(){
			
			var msg = '';
			var flag = true;
			
			var comm1 = jQuery.trim($("#efx_tocomments1").val());
			var comm2 = jQuery.trim($("#efx_tocomments2").val());
			var uid = $("#efx_huid").val();
			
			
			if( uid == '' ){
				flag = false;
				msg += 'Transter To Field must be a valid user<br/>';
			}
			
			if( comm1 == ''){
				flag = false;
				msg += 'Message To Field is required<br/>';			
			}
			if( comm2 == ''){
				flag = false;
				msg += 'Comments Field is required<br/>';			
			}
			

			if( flag ){
				
				var items = $("#transferform").serialize();
				
				$.ajax({
					type:'POST',
					url:'dashboard/ajaxtransfersave/?track=1',
					data:items,
					success: function( response ){
						$("#grid").trigger("reloadGrid"); 
						backtogridfunc();
					}
				})
			
			}else{
				$("#errorDivnote").html(msg);
				$("#errorDivnote").fadeIn(500);
			}
		});
		
		//search button
		$("#searchrange").click( function(){
			jQuery("#list2").trigger("reloadGrid", [{current:true}]);
		
		});		
		
	});
	
	//make the callback date field required if the callback check box is checked.
	function checkCallbackdate(val){
		
		if( jQuery("#needcallback").is(':checked') ){		
			var vcbdate = jQuery("#callback_date").attr("value");
			if( jQuery.trim(vcbdate) != '' ){
				return [true,"",""];
			}else{
				return [false,"Callback Date: Field is required!",""]; 
			}		
		}else{
			return [true,"",""];
		}
	}
	function clearCallbackDate(){
		jQuery("#callback_date").attr("value", '');
	}
	
	
	
	function updatelog(gr){
		jQuery("#list2").jqGrid('editGridRow',gr,{
										width:300,
										saveData: "Data has been changed! Save changes?",
										bYes : "Yes",
										bNo : "No",
										closeAfterEdit: true,
										checkOnSubmit: true,
										onInitializeForm: function(){},										
										beforeShowForm: function(formid){
											$("#comments").attr('value',' ');
										},
										onClose: function(){}
									}
								);	
	}
	
/* 	function deletelog(gr){
		jQuery("#list2").jqGrid('delGridRow', gr, {caption: "Delete",
													msg: "Delete selected log?",
													bSubmit: "Delete",
													bCancel: "Cancel"
													} );
	} */
	
	function backtogridfunc(){
			$("#edit_container").slideToggle('normal', function(){
				$("#grid_container").css('display','block');
			});	
	}
	
	function transferLog( gr ){

		//$("#edit_container").load('dashboard/ajaxtrasform',{token:gr});
		
		$("#efx_hlog").attr('value', '');	
		$("#efx_huid").attr('value', '');	
		$("#efx_tocomments1").attr('value', '');
		$("#efx_tocomments2").attr('value', '');
		$("#efx_toid").attr('value', '');
		
		$("#efx_txtfrom").attr('value', '');
		$("#efx_txtto").html('');
		
		$("#grid_container").slideToggle('normal', function(){
		
			$.ajax({
				type:'POST',
				url:'dashboard/ajaxgetLogInfo',
				data:{token:gr},
				DataType:'jsonp',
				success: function(data){
				
					record = jQuery.parseJSON(data);
					
					$("#efx_hlog").attr('value', record.erd_id);	
					
					$("#efx_dissueid").html(record.center_acronym+''+record.erd_id);
					$("#efx_direpsname").html(record.lname+', '+record.fname);
					$("#efx_dcenter").html(record.center_desc);
					$("#efx_didepartment").html(record.dept_desc);
					$("#efx_dcust").html(record.cust_name);
					$("#efx_demail").html(record.efx_demail);
					$("#efx_dcontact").html(record.phone_no);
					$("#efx_dmin").html(record.minno);
					$("#efx_dimei").html(record.imei);
					$("#efx_dchannel").html(record.source);
					$("#efx_dbrand").html(record.organization);
					$("#efx_dcaseno").html(record.case_no);
					
					$("#efx_dcallback").html(record.callback_date);
						
					$("#efx_dissuedesc").html(record.erd_issue_desc);
					$("#efx_descated").html(record.escalatedto);
					$("#efx_dstatus").html(record.status_desc);
					$("#efx_dnotes").html(record.erd_note);
					$("#efx_dcomments").html(record.comments);
					$("#efx_drefno").html(record.reference_id);
					
																	
					$("#efx_txtfrom").html(record.lname+', '+record.fname);
					
				}
			})
		
			$("#edit_container").css('display','block');
		});
	

		
	}
	

</script>