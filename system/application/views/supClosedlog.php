
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
	
	.ui-jqgrid tr.jqgrow td {
		/*white-space: normal !important;*/
		height:auto;
		vertical-align:middle;
		padding-top:2px;
	}
	
	.EditTable {
		width: 95% !important;
	}
	

	/* .DataTD{
		float:left;
		width: 600px !important;
	} */
	.CaptionTD{
		vertical-align: top !important;
		width: 185px !important;
	}

/* 	#ViewTbl_list2{
		width: 795px !important;
		cellpadding: 0;
		
	} */
	
	#ViewTbl_list2 tr{
		border: 1px solid black !important;
	}
	
	
/* 	#viewmodlist2{
		
		width: 800px !important;		
	} */
	
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
		
	/* #pData, #nData{
		display:none !important;
	} */

    #scrollTable {
		height:250px;
		overflow-x:hidden;
		overflow-y:scroll;
    }	
	
	.markReassigned{
		color: red !important;
		font-weight: bold !important;
	}	

</style>

    <!-- START CONTENT -->
    <div id="content">
 
		<!-- START MAIN CONTEMT -->
		<div id="main_content">
			<h1 class="h1">All My Logs</h1>
	  
			<div id="list2_container">	
				<table id="list2"></table> 
				<div id="pager2"></div> 			
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
		
		var setwidth = $('#list2_container').width();

		var mygrid = jQuery("#list2").jqGrid({ 
			url:'dashboard/ajaxsupclosedlogs/?track=1', 
			datatype: "json", 
			height: '100%',
			/*height: '100%',*/
			width: setwidth-5, 
			mtype: 'GET',
			colNames:['','No. of Comments','Issue ID','Status','Supervisor','Representative', 'Avaya', 'IMEI', 'Contact No', 'Customer Name', 'Interaction / Case No', 'Issue Type', 'Issue Description',  'MIN', 'Channel','Organization','Email Address', 'Date Opened','Date Updated','Date Closed', 'Callback', 'Callback Date/Time', 'Escalated', 'reassigned'], 
			colModel:[ {name:'options',index:'options', width:50, editable:false, search:false, viewable:false}, 	
					   {name:'numofcom',index:'numofcom', width:75, align:'center', search:false},
					   {name:'erd_id',index:'erd_id', width:80, search:true, searchoptions:{sopt:['eq']}}, 						   					   					  
					   {name:'status_id',index:'status_id',  width:100, search:false, stype:'select', searchoptions:{sopt:['eq'], dataUrl:"dashboard/getstatusdropdown2/"}}, 
					   {name:'supervisor_id',index:'users.supervisor_id', width:150, search:true, stype:'select', searchoptions:{sopt:['eq'], dataUrl:"dashboard/getSupervisorDropdown/"}}, 
					   {name:'lname',index:'lname', width:120,   search:true, 
							searchoptions:{
								dataInit:function(el){																									
									$(el).autocomplete({source:"dashboard/ajaxgetReps/?track=1"});																																																									
								}
							},
							editable:true, editoptions:{readonly:true}
					   }, 	
					   {name:'avaya',index:'avaya', width:60, search:true},
					   {name:'imei',index:'imei', width:150,   search:true}, 	
					   {name:'phone_no',index:'phone_no', width:120,   search:true},
					   {name:'cust_name',index:'cust_name', width:120,   search:true, searchoptions:{sopt:['cn']}}, 	
					   {name:'case_no',index:'case_no', width:100,   search:true},
					   {name:'erd_issue_desc',index:'erd_issue_desc', width:220,   edittype:"textarea", editoptions:{readonly:true,rows:"4",cols:"30"}, search:true, stype:'select', searchoptions:{sopt:['eq'], dataUrl:"dashboard/getissuedropdown/"}, sortable:false}, 					   					   
					   {name:'erd_issuesub_desc',index:'erd_issuesub_desc', width:220,   edittype:"textarea", editoptions:{readonly:true,rows:"4",cols:"30"}, search:true, stype:'select', searchoptions:{sopt:['eq'], dataUrl:"dashboard/getissuesubdropdown/"}, sortable:false}, 					   					   
					   {name:'minno',index:'minno', width:100, search:true},
					   {name:'source',index:'source', width:100, search:true, stype:'select', searchoptions:{sopt:['eq'], dataUrl:"dashboard/getSourceDropdown/"}},
					   {name:'organization',index:'organization', width:100, search:true, stype:'select', searchoptions:{sopt:['eq'], dataUrl:"dashboard/getOrgDropdown/"}},
					   {name:'emailaddress',index:'emailaddress', width:200, search:true},					   
					   {name:'date_opened',index:'date_opened', width:130, editable:false, search:true, searchoptions:{
																																dataInit:function(el){
																																	$(el).datepicker({dateFormat:'yy-mm-dd'});
																																}}
					   }, 
					   {name:'date_updated',index:'date_updated', width:130, editable:false, search:true, searchoptions:{
																																dataInit:function(el){
																																	$(el).datepicker({dateFormat:'yy-mm-dd'});
																																}}
					   },
					   {name:'date_closed',index:'date_closed', width:130, editable:false, search:true, searchoptions:{
																																dataInit:function(el){
																																	$(el).datepicker({dateFormat:'yy-mm-dd'});
																																}}
					   }, 					   
					   {name:'needcallback',index:'needcallback', width:80, hidden:true,align:'left',  edittype:"checkbox",editoptions:{value:"Yes:No"}, editrules:{edithidden:true}, search:true, stype:'select', searchoptions:{sopt:['eq'], value:":-select-;1:Yes;0:No"},viewable:false}, 						   
					   {name:'callback_date',index:'callback_date', width:130,   editoptions:{
							dataInit:function(el){$(el).datetimepicker({dateFormat: 'yy-mm-dd'});}							
							}, formoptions:{elmsuffix:'<span style="float:left"><a href="javascript:void(0)" onclick="clearCallbackDate()">clear</a></span>', colpos:1},
							editrules:{custom:true, custom_func:checkCallbackdate},
							searchoptions:{
											dataInit:function(el){
												$(el).datepicker({dateFormat:'yy-mm-dd'});
											}}
					   },
					   {name:'escalatedto',index:'escalatedto', width:150, editable:false, search:true, stype:'select', searchoptions:{sopt:['eq'], dataUrl:"dashboard/getEscalatedDropdown/"}, sortable:true},
					    {name:'reassigned',index:'reassigned', width:100, search:false,viewable:false, editable:false, hidden:true}
					   /*{name:'erd_note',index:'erd_note', width:200}, 
					   {name:'comments',index:'comments', width:200,  editable:true, edittype:"textarea", editoptions:{rows:"6",cols:"150"}, search:false}*/	
			], 
			gridComplete: function(){ 
				var ids = jQuery("#list2").jqGrid('getDataIDs'); 				
								
				for(var i=0;i < ids.length;i++){ 
				
					var cl = ids[i]; 
					
					data = $('#list2').jqGrid('getCell',cl,'reassigned');

					if( data == 1 ){
						//$("#"+cl,this).addClass('markReassigned');
						//jQuery("#list2").jqGrid('setCell',cl,'','',{color:'red'}); 
						//jQuery("#list2").jqGrid('setRowData',ids[i],{color:'red'}); 
						$("#list2").jqGrid('setRowData', ids[i], false, {color:'red'});

					} 
					
					//ae = '<a href="javascript:void(0)" onclick="updatelog('+cl+');" class="alink">Comment</a>';									
					ae= '<a href="dashboard/openlog/'+cl+'" class="alink" title="Open Log"> Open </a><br/>';		
					jQuery("#list2").jqGrid('setRowData',ids[i],{options:ae}); 
				}
				
				jQuery(".alink").button();	
			},	
			/* ondblClickRow: function(id){
				
				//alert(1);
				jQuery("#list2").jqGrid('viewGridRow', id,
						{
							width:800
						}
				);
			},	 */		
			rowNum:10, 
			rowList:[10,20,30],
			rownumbers: true,
			shrinkToFit: false,
			sortname: "date_updated", 
			viewrecords: true, 
			sortorder: "desc",
			pager: '#pager2', 		
			gridview: true, 
			editurl: 'dashboard/ajaxSuplogsaction',			
			caption:""
		});
			
		jQuery("#list2").jqGrid('navGrid','#pager2',{edit:false,add:false,del:false,search:false, view:false},{},{},{}); 

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
																str+=i+"="+postData[i]+"&";
															}	
															
															
															var ldui = $('<div>Please Wait...</div>').dialog('open');
															
															
															$.ajax({
																type: "GET",
																url: 'dashboard/ajaxExportAction/?track=1&tablType=closed&'+str,
																success: function(response){
																	
																	
																	var result = jQuery.parseJSON(response);
	
																	window.location = "<?php echo base_url();?>"+result.filepath;
																	ldui.dialog('destroy');
																}
															});
									
														} 
													}); 		
		
		$(".ui-jqgrid-sortable").css('white-space', 'normal');
		$(".ui-jqgrid-sortable").css('height', 'auto');		


		//freeze header
		 var maxWidth = $('#Header1').width();    // Get max row Width
		 $('#Header2 th').each(function(i) {     // Set col headers widths to to match col widths 
			var width = $(this).width();
			$('#Header1 th').eq(i).width(width);
		 });

		 var blankSpace = maxWidth - $('#Header1').width();               // Calculate extra space
		 $('#Header1 th:last').width( $('#Header1 th:last').width() + blankSpace );  // Stretch last header column to fill remaining space

	});
	
	//make the callback date field required if the callback check box is checked.
	function checkCallbackdate(val){
		var vcbdate = jQuery("#callback_date").attr("value");
		if( jQuery.trim(vcbdate) != '' ){
			return [true,"",""];
		}else{
			return [false,"Callback Date: Field is required!",""]; 
		}
		
	}

	
	function updatelog(gr){
		jQuery("#list2").jqGrid('editGridRow',gr,{
										width:800,
										saveData: "Data has been changed! Save changes?",
										bYes : "Yes",
										bNo : "No",
										closeAfterEdit: true,
										checkOnSubmit: true,
										onInitializeForm: function() {
											
											/* jQuery("#needcallback").click(function(){
												
												if( $("#needcallback").is(':checked')){
													//$("#callback_date").attr("value");
												}else{
													$("#tr_callback_date").fadeOut();
												} 			 
											});	 */	
									
										},										
										beforeShowForm: function(formid){
											$("#comments").attr('value',' ');
										},
										onClose: function() {
										}
									}
								);	
	}
	
	function deletelog(gr){
		jQuery("#list2").jqGrid('delGridRow', gr, {caption: "Delete",
													msg: "Delete selected log?",
													bSubmit: "Delete",
													bCancel: "Cancel"
													} );
	}

	function clearCallbackDate(){
		jQuery("#callback_date").attr("value", '');
	}
	
	
</script>