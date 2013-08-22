<h1 class="h1">Summary By Status</h1>
<div id="actions">
	<label>From: </label> <input type="text" name="fromdate2" id="fromdate2" value="<?php echo date('Y-m-d'); ?>" />
	<label>To: </label> <input type="text" name="todate2" id="todate2" value="<?php echo date('Y-m-d'); ?>" />
	<input type="button" name="btnview2"  id="btnview2" value="view" />
</div>
<div class="spacer">&nbsp;</div>  

<div id="sumbycenter_display2">
	<?php echo $table; ?>
</div>
<!-- END CONTEMT -->


<div style="display:none">
	<div id="dialog-message2" title="Error Message">
		<p>
			<span class="ui-icon ui-icon-notice" style="float:left; margin:0 7px 50px 0;"></span>
			Date Error
		</p>

	</div>
</div>

<script type="text/javascript">
	
	$(document).ready(function() {

		$("#fromdate2").datepicker({dateFormat:'yy-mm-dd'});
		$("#todate2").datepicker({dateFormat:'yy-mm-dd'});		
	
		$("#btnview2").button();
		
			
		$("#btnview2").click( function(){
					
		/* 	var df = $("#fromdate2").val();
			var dt = $("#todate2").val(); */
			
			$("#sumbycenter_display2").html("Fetching Record...");
			
			var df = $("#fromdate2").attr("value");
			dfsplit = df.split('-');			
			var nf = new Date();
			nf.setFullYear(dfsplit[0], dfsplit[1]-1, dfsplit[2]);
			
			var dt = $("#todate2").attr("value");
			dtsplit = dt.split('-');	
			var nt = new Date();
			nt.setFullYear(dtsplit[0], dtsplit[1]-1, dtsplit[2]);
			
			//alert(df+' '+nt); 
 			if( nt >= nf){

				$.get("dashboard/statussummary/",{tk:1,st:1,from:df,to:dt}, function(data, status){				
					
					if( status == 'success')	
						$("#sumbycenter_display2").html(stripslashes(data));	
					else
						$("#sumbycenter_display2").html("ERROR ON FETCHING RECORD!!!");

				});
					
			}else{
				$( "#dialog-message" ).dialog({
					modal: true,
					buttons: {
						Ok: function() {
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