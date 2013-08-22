<style>
	.td-red-bold{
		color:red !important;
		font-weight:bold;
	}
	
	.td-right{
		text-align:right;
	}

	#myTable th {
		text-transform: none;
	}
	
</style>
<h1 class="h1">Summary By Center</h1>
<div id="actions">
	<label>From: </label> <input type="text" name="fromdate" id="fromdate" value="<?php echo date('Y-m-d'); ?>" />
	<label>To: </label> <input type="text" name="todate" id="todate" value="<?php echo date('Y-m-d'); ?>" />
	<input type="button" name="btnview"  id="btnview" value="view" />
</div>
<div class="spacer">&nbsp;</div>  
<div id="tableLoader" style="display:none; color:orange">Searching Record....</div>
<div id="sumbycenter_display">
	<?php echo $table; ?>
</div>

<div id="pdisplay">

</div>
<div>
	<input type="button" name="test2" onclick="CreateExcelSheet()" value="export" />
</div>
<!-- END CONTEMT -->


<div style="display:none">
	<div id="dialog-message" title="Error Message">
		<p>
			<span class="ui-icon ui-icon-notice" style="float:left; margin:0 7px 50px 0;"></span>
			Date Error
		</p>

	</div>
</div>

<script type="text/javascript">
	
	$(document).ready(function() {

		$("#fromdate").datepicker({dateFormat:'yy-mm-dd'});
		$("#todate").datepicker({dateFormat:'yy-mm-dd'});		
	
		$("#btnview").button();
		
			
		$("#btnview").click( function(){
			
			//mark loading
			//$("#sumbycenter_display").fadeIn(500);
			$("#sumbycenter_display").html("Searching Record...");
			
			var df = $("#fromdate").attr("value");
			dfsplit = df.split('-');			
			var nf = new Date();
			nf.setFullYear(dfsplit[0], dfsplit[1]-1, dfsplit[2]);
			
			var dt = $("#todate").attr("value");
			dtsplit = dt.split('-');	
			var nt = new Date();
			nt.setFullYear(dtsplit[0], dtsplit[1]-1, dtsplit[2]);
			
			if( nt >= nf){
				//var dpopup = $("<div>Retrieving Information...<div>").dialog();
				$.get("dashboard/centersummary/",{tk:1,st:1,from:df,to:dt}, function(data, status){				
							
					
					
					if( status == "success"){
						$("#sumbycenter_display").html(stripslashes(data));
						
						//$("#tableLoader").fadeOut(500);	
						
					}else{	
						//$("#tableLoader").fadeOut(500);	
						$("#sumbycenter_display").html("ERROR ON SEARCHING RECORD!!!");
					}		
					/* var json = jQuery.parseJSON(data);					
					if( json.status == true){
						$("#sumbycenter_display").html(stripslashes(json.html));
						dpopup.dialog("close");
					}elseif( json.status == false){
						$("#sumbycenter_display").html('');
						dpopup.dialog("close");
						$('<div id="dialog-message" title="Error Message"><p>Faild to retrieve the Information<br/>Please Contact you Administrator<p></div>').dialog();
					}else{
						
					}*/
					
				});
					
			}else{
				$( "#dialog-message" ).dialog({
					modal: true,
					buttons: {
						Ok: function() {
							//$("#fromdate").attr("value",'');
							//$("#todate").attr("value",'');
							$( this ).dialog( "close" );
						}
					}
				});
			}
			
		});
	
	});
	
	function openit(a){
	
		window.open(a, '_blank', 'status=yes,resizable=yes');
		//alert(a);
		//return false;
	}


	function CreateExcelSheet(){

		var strCopy = document.getElementById("myTable").innerHTML;
		window.clipboardData.setData("Text", strCopy);
		var objExcel = new ActiveXObject ("Excel.Application");
		objExcel.visible = true;

		var objWorkbook = objExcel.Workbooks.Add;
		var objWorksheet = objWorkbook.Worksheets(1);
		objWorksheet.Paste;

	}	
		
	function stripslashes( str ) {
		return (str+'').replace('/\0/g', '0').replace('/\(.)/g', '$1');
	}	
</script>