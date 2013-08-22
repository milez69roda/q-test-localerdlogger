
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
	
	/* .ui-jqgrid tr.jqgrow td {
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
	}
 */
 
 
 	
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
 
	/* #pData, #nData{
		display:none !important;
	} */
	


</style>

    <!-- START CONTENT -->
    <div id="content">
 
		<!-- START MAIN CONTEMT -->
		<div id="main_content">
			<h1 class="h1">My Callbacks  <span style="padding-left:130px; color:red">NOTE: After 3rd unable to reach, change status of call log to closed.</span></h1>
	  
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
		//alert(setwidth);
		var mygrid = jQuery("#list2").jqGrid({ 
			url:'dashboard/ajaxcallbacks/?track=1', 
			datatype: "json", 
			height: '100%',
			width: setwidth-5, 
			mtype: 'GET',
			colNames:['','No. of Comments','ID','Status','IMEI', 'Contact No', 'Customer Name', 'Interaction / Case No', 'Issue Description',  'Callback', 'Callback Date/Time', 'MIN', 'Channel','Organization','Email Address', 'Escalated'], 
			colModel:[ {name:'options',index:'options', width:50, search:false, viewable:false},
					   {name:'numofcom',index:'numofcom', width:75, search:false, align:'center', sortable:false},
					   {name:'erd_id',index:'erd_id', width:60, search:true, searchoptions:{sopt:['eq']}}, 						   					   					  
					   {name:'status_id',index:'status_id', width:80, search:true, stype:'select', searchoptions:{sopt:['eq'], dataUrl:"dashboard/getstatusdropdown/"}}, 
					   {name:'imei',index:'imei', width:90, search:true}, 	
					   {name:'phone_no',index:'phone_no', width:90, search:true}, 	
					   {name:'cust_name',index:'cust_name', width:120, search:true}, 
					   {name:'case_no',index:'case_no', width:90, search:true}, 
					   {name:'erd_issue_desc',index:'erd_issue_desc', width:150, search:true, stype:'select', searchoptions:{sopt:['eq'], dataUrl:"dashboard/getissuedropdown/"}, sortable:false}, 					   					  
					   {name:'needcallback',index:'needcallback', width:80, hidden:true, align:'left', search:true, stype:'select', searchoptions:{sopt:['eq'], value:":-select-;1:Yes;0:No"},viewable:false}, 						   
					   {name:'callback_date',index:'callback_date', width:100, 
							searchoptions:{
											dataInit:function(el){
												$(el).datepicker({dateFormat:'yy-mm-dd'});
											}}
					   },
					   {name:'minno',index:'minno', width:100, search:true},
					   {name:'source',index:'source', width:100, search:true, stype:'select', searchoptions:{sopt:['eq'], dataUrl:"dashboard/getSourceDropdown/"}},
					   {name:'organization',index:'organization', width:100, search:true, stype:'select', searchoptions:{sopt:['eq'], dataUrl:"dashboard/getOrgDropdown/"}},
					   {name:'emailaddress',index:'emailaddress', width:100, search:true},			   
					   {name:'escalatedto',index:'escalatedto', width:150, search:true, stype:'select', searchoptions:{sopt:['eq'], dataUrl:"dashboard/getEscalatedDropdown/"}, sortable:false} 		   
					   
			], 
			gridComplete: function(){ 
				var ids = jQuery("#list2").jqGrid('getDataIDs'); 				
								
				for(var i=0;i < ids.length;i++){ 
				
					var cl = ids[i]; 
					
					/* ae = '<a href="javascript:void(0)" onclick="updatelog('+cl+');" class="alink"> U </a>';									
					be = '<a href="javascript:void(0)" onclick="deletelog('+cl+');" class="alink"> D </a><br/>';	 */	
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
			rowNum:10, 
			rowList:[10,20,30],
			rownumbers: true,
			shrinkToFit: false,
			sortname: "callback_date", 
			viewrecords: true, 
			sortorder: "asc",
			pager: '#pager2', 		
			gridview: true, 
			editurl: 'dashboard/ajaxmysqlogsaction',			
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

		
		$(".ui-jqgrid-sortable").css('white-space', 'normal');
		$(".ui-jqgrid-sortable").css('height', 'auto');		

	
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
										width:600,
										saveData: "Data has been changed! Save changes?",
										bYes : "Yes",
										bNo : "No",
										closeAfterEdit: true,
										checkOnSubmit: true,
										onInitializeForm: function(){},										
										beforeShowForm: function(formid){},
										onClose: function(){}
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


	
</script>