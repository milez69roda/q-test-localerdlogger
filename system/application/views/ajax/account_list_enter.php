
<div>
	<!--<h1 class="h1">Account List</h1>-->

	<div id="list2_container">	
		<table id="list2"></table> 
		<div id="pager2"></div> 			
	</div>	
	
</div>

<script type="text/javascript">

	$(document).ready(function() {
		var setwidth = $('#list2_container').width();

		var mygrid = jQuery("#list2").jqGrid({ 
			url:'dashboard/ajaxgetaccountlist/?track=1', 
			datatype: "json", 
			height: '100%', 
			width: setwidth, 
			mtype: 'GET',
			colNames:['','Name','First Name','Last Name','Username', 'Password', 'Access Type', 'Center', 'Department', 'Supervisor', 'Last Login'], 
			colModel:[ {name:'options',index:'options', width:55, search:false, viewable:false},
					   {name:'lname',index:'users.lname', width:130, editable:false, search:true, searchoptions:{
																dataInit:function(el){																									
																	$(el).autocomplete({source:"dashboard/ajaxgetUsers/?track=1"});																																																									
																}}
					    }, 						   					   					  
					   {name:'fname',index:'users.fname', width:80, hidden:true, editable:true, editrules:{edithidden:true, required:true}, viewable:false}, 
					   {name:'lname1',index:'lname1', width:80, hidden:true, editable:true, editrules:{edithidden:true}, viewable:false}, 
					   {name:'username',index:'users.username', width:80, editable:false}, 
					   {name:'password',index:'users.password', width:90, editable:true, search:true}, 						  
					   {name:'role_id',index:'users.role_id', width:90, editable:false, search:true, stype:'select', searchoptions:{sopt:['eq'], dataUrl:"dashboard/getAccessDropdown1/"}}, 						  
					   					  
					   {name:'center_id',index:'center_id', width:120, search:true, stype:'select', searchoptions:{sopt:['eq'], dataUrl:"dashboard/getcenterdropdown/"}},
					   {name:'dept_id',index:'dept_id', width:120, editable:true, edittype:'select', editoptions:{dataUrl:'dashboard/getDeptdropdown/'}, search:true, stype:'select', searchoptions:{sopt:['eq'], dataUrl:"dashboard/getDeptdropdown/"}}, 		
					   /*{name:'suplname',index:'suplname', width:90, editable:false, search:false}, 	*/
					   {name:'supervisor_id',index:'users.supervisor_id', editable:true, edittype:'select', editoptions:{dataUrl:'dashboard/getSupervisorDropdown/'},width:150, search:true, stype:'select', searchoptions:{sopt:['eq'], dataUrl:"dashboard/getSupervisorDropdown/"}}, 
					   {name:'last_login',index:'last_login', width:200, editable:false, search:false}, 	
			], 
			gridComplete: function(){ 
				 var ids = jQuery("#list2").jqGrid('getDataIDs'); 				
								
				for(var i=0;i < ids.length;i++){ 				
					var cl = ids[i]; 					
					ae = '<a href="javascript:void(0)" onclick="updatelog('+cl+');" class="alink"> Update </a>';																				
					jQuery("#list2").jqGrid('setRowData',ids[i],{options:ae}); 
				}	
				jQuery(".alink").button();	
			},					
			rowNum:10, 
			rowList:[10,20,30],
			rownumbers: true,
			shrinkToFit: false,
			sortname: "lname", 
			viewrecords: true, 
			sortorder: "desc",
			pager: '#pager2', 		
			gridview: true, 
			editurl: 'dashboard/ajaxUsersAction/',			
			caption:""
		});		
	});
	
	jQuery("#list2").jqGrid('navGrid','#pager2',{edit:false,add:false,del:false,search:false, view:true},{},{},{} ); 

	//resizing grid
	jQuery("#list2").jqGrid('gridResize',{minWidth:350,maxWidth:1024,minHeight:300, maxHeight:700});
	
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

	function updatelog(gr){
		jQuery("#list2").jqGrid('editGridRow',gr,{
										width:300,
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

											/* if( $("#needcallback").attr("value") == '0' ){
												$("#tr_callback_date").css('display','none');
											} */
											//alert(response.needcallback);
											//alert(formid);
										},
										onClose: function() {
										}
									}
								);	
	}	


</script>