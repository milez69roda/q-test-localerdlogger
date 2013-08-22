
<style type="text/css">

	.welcome label{
		width: 80px;
		float:left;
		font-weight:bold;
		color:#333333;
	}

</style>

    <!-- START CONTENT -->
    <div id="content">
 

    <!-- START MAIN CONTEMT -->
    <div id="main_content">
		<h1 class="h1">Welcome</h1>
		<br />
		<div style="font-size: 15px" class="welcome">	
			<p><label>Center: </label><?php echo $centerinfo[0]->center_desc; ?></p>	
			<br />
			<p><label>Date/Time: </label><?php echo date('Y-m-d g:i a'); ?></p>			
			<p><label>Access: </label><?php echo $this->session->userdata('role_name'); ?></p>			
			<p><label>Name: </label><?php echo $this->session->userdata('firstname')." ".$this->session->userdata('lastname'); ?></p>			
		</div>
		
		<!--
		<?php
			if( $this->_roleid == 1 or $this->_roleid == 2 ):
		?>
		<br />
		<h1 class="h1">Re-Assigned Issues</h1>
		<div>
			<table width="579"  border="1" class="tablesorter">
				<head>
					<tr>
						<?php
							if( $this->_roleid == 2 ):
						?>
						<th  width="130">&nbsp;</th>
						<?php
							endif;
						?>
						<th>Issue ID</th>
						<th>Re-Assigned To</th>
						<th>New Issue ID</th>
						<th>Date</th>
					</tr>
				</head>
				<?php
				
				foreach( $reassignedRes as $row):
				
				?>
				<body>
					<tr id="htr_<?php echo $row->erd_id; ?>">
						<?php
							if( $this->_roleid == 2 ):
						?>						
						<td>&nbsp;<a href="javascript:void(0)" class="alink" data="<?php echo $row->erd_id; ?>">Mark as Read</a></td>
						<?php
							endif;
						?>						
						<td>&nbsp;<a href="dashboard/viewLog/<?php echo $row->erd_id; ?>" target="_blank"><?php echo $row->center_acronym.$row->erd_id; ?></a></td>
						<td>&nbsp;<?php echo $row->lname.', '.$row->fname; ?></td>
						<td>&nbsp;<a href="dashboard/viewLog/<?php echo $row->reassigned_erd_id; ?>" target="_blank"><?php echo $row->center_acronym.$row->reassigned_erd_id; ?></a></td>
						<td>&nbsp;<?php echo $row->reassigned_datetime;?></td>
						
					</tr>
				</tbody>
			  <?php
				endforeach;
			  ?>
			</table>
		</div>
		<?php
			endif;
		?> -->
		<br />
		<?php
			if( isset($centerSummary) ):
		?>
		<div>
			<h1 class="h1">Summary</h1>
			
			<table id="mytable" class="tablesorter" style="width: 300px !important">
				<tr>
					<td>Total Closed</td>
					<td><?php echo number_format($centerSummary->closed); ?></td>
				</tr>				
				<tr>
					<td>Total Active</td>
					<td><?php echo number_format($centerSummary->pending + $centerSummary->unable); ?></td>
				</tr>				
				<tr>
					<td>Total Pending</td>
					<td><?php echo number_format($centerSummary->pending); ?></td>
				</tr>				
				<tr>
					<td>Unable to Reach</td>
					<td><?php echo number_format($centerSummary->unable); ?></td>
				</tr>				
				<tr>
					<td>Callbacks</td>
					<td><?php echo number_format($centerSummary->callback); ?></td>
				</tr>				
				<tr>
					<td>Follow-up</td>
					<td><?php echo number_format($centerSummary->less); ?></td>
				</tr>				
				<tr>
					<td>Courtesy Call</td>
					<td><?php echo number_format($centerSummary->more); ?></td>
				</tr>		
				
			</table>
			
		</div>
		<?php
			endif;
		?>
	</div><!-- END MAIN CONTENT -->

</div>
<!-- END CONTEMT -->

<script type="text/javascript">

	$(function() {
				
		//$(".alink").button();	
		
		$(".alink").click( function(){
		
			if( confirm("Hide Issue?") ){
				var ttoken = $(this).attr('data');
				$.ajax({
					type: "POST",
					url: "dashboard/ajaxHomeAction/?track=1",
					data: "ttoken="+ttoken,
					success: function( xhr, statusText ) {
						
						if ( $.isJson(xhr) ){
							
							var json = jQuery.parseJSON(xhr);
							
							alert(json.msg);	
							
							if( json.status ){
								//window.location =  window.location.href;
								$("#"+json.token).fadeOut(1000);							
							}	
						
						}else{
							window.location = '<?php echo base_url(); ?>';
						}					
					}
				});
			}
		})
	});	
 
	jQuery.isJson = function(str) {
		if (jQuery.trim(str) == '') return false;
		str = str.replace(/\\./g, '@').replace(/"[^"\\\n\r]*"/g, '');
		return (/^[,:{}\[\]0-9.\-+Eaeflnr-u \n\r\t]*$/).test(str);
	}
</script>