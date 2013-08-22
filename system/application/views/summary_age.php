<h1 class="h1">Summary By Age</h1>
<div id="actions">

</div>
<div class="spacer">&nbsp;</div>  
<div id="tableLoader" style="display:none; color:orange">Fetching Record....</div>
<div id="sumbycenter_display">
	<?php echo $table; ?>
</div>
<div>
	Legend: <br>
	Active = New, Pending and Callbacks(both new and pending)
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
			$("#sumbycenter_display").html("Fetching Record...");
			
/* 			var df = $("#fromdate").attr("value");
			dfsplit = df.split('-');			
			var nf = new Date();
			nf.setFullYear(dfsplit[0], dfsplit[1]-1, dfsplit[2]);
			
			var dt = $("#todate").attr("value");
			dtsplit = dt.split('-');	
			var nt = new Date();
			nt.setFullYear(dtsplit[0], dtsplit[1]-1, dtsplit[2]); */
			
			if( nt >= nf){
				//var dpopup = $("<div>Retrieving Information...<div>").dialog();
				$.get("dashboard/getLogAge/", function(data, status){				
							
					
					
					if( status == "success"){
						$("#sumbycenter_display").html(stripslashes(data));
						
						//$("#tableLoader").fadeOut(500);	
						
					}else{	
						//$("#tableLoader").fadeOut(500);	
						$("#sumbycenter_display").html("ERROR ON FETCHING RECORD!!!");
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
	
	function stripslashes( str ) {
		return (str+'').replace('/\0/g', '0').replace('/\(.)/g', '$1');
	}	
</script>