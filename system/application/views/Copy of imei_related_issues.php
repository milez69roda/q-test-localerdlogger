
<script type="text/javascript">
	$(function() {
		
		$("#accordion").accordion({ header: "h3" });
	
	});
</script>

<style>
	
	.labelTitle label{
		font-weight:bold;
		width: 100px;
		
		
	}
	.labelTitle p{
		margin:0;
		padding:2px;		
	}
	
</style>

<div id="accordion">
	 <h1>IMEI: <?php echo $imei_title; ?></h1>
	<?php foreach( $relResults as $row ): ?>
	<h3><a href="#"><?php echo $row->erd_issue_desc; ?></a></h3>
		<div class="labelTitle">			
			<p><label>Status: </label> <?php echo $row->status_desc; ?></p>
			<p><label>Center: </label> <?php echo $row->center_desc; ?></p>
			<p><label>Department: </label> <?php echo $row->dept_desc; ?></p>
			<p><label>Representative:</label> <?php echo $row->fname.' '.$row->lname; ?></p>					
			<p><label>Date Opened:</label> <?php echo $row->date_opened; ?></p>
			<p><label>Date Updated:</label> <?php echo $row->date_updated;?></p>
			<p><label>Date Closed:</label> <?php echo $row->date_closed;?></p>
						
			<p><label>Need Call Back:</label> <?php echo $row->needcallback;?></p>
			<p><label>Call Back Date:</label> <?php echo $row->callback_date;?></p>					
			
		</div>
	<?php endforeach; ?>
</div>
