<style>

	

</style>

<div>
	
	<h1 class="h1">Transfer Log</h1>
	<form id="transferform" name="transferform" method="post">
	
		<table width="900" border="1" cellpadding="0" cellspacing="0" class="tablesorter">
		
		  <tr>
			<td>Issue ID</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		  </tr>
		  <tr>
			<td width="110">Representative</td>
			<td width="166">&nbsp;</td>
			<td width="144">Center</td>
			<td width="110">&nbsp;</td>
			<td width="111">Department</td>
			<td width="144">&nbsp;</td>
		  </tr>
		  <tr>
			<td>Customer Name</td>
			<td>&nbsp;</td>
			<td>Email Address</td>
			<td>&nbsp;</td>
			<td>Contact No</td>
			<td>&nbsp;</td>
		  </tr>
		  <tr>
			<td>MIN</td>
			<td>&nbsp;</td>
			<td>IMEI</td>
			<td>&nbsp;</td>
			<td>Channel</td>
			<td>&nbsp;</td>
		  </tr>
		  <tr>
			<td>Brand</td>
			<td>&nbsp;</td>
			<td>Interaction/Case No</td>
			<td>&nbsp;</td>
			<td>Callback</td>
			<td>&nbsp;</td>
		  </tr>
		  <tr>
			<td>Issue Description</td>
			<td>&nbsp;</td>
			<td>Escalated</td>
			<td>&nbsp;</td>
			<td>Status</td>
			<td>&nbsp;</td>
		  </tr>
		  <tr>
			<td>Notes</td>
			<td>&nbsp;</td>
			<td>Comments</td>
			<td>&nbsp;</td>
			<td>Referrence No.</td>
			<td>&nbsp;</td>
		  </tr>
		</table>
	
	</form>
	<div>
		<input type="button" id="backtogridbtn" value="Back to Grid" />
	</div>		
</div>

<script type="text/javascript">
	$(document).ready(function() {
	
		$("#backtogridbtn").click(function(){
			$("#grid_container").fadeIn(50);
			$("#edit_container").fadeOut(50, function(){
				$(this).html('');
			});
			
				
		})
	
	});
		
</script>