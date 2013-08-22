
<style>
	.ui-jqgrid tr.jqgrow td {
		white-space: normal !important;
		height:auto;
		vertical-align:middle;
		padding-top:2px;		
	}
/* .ui-jqgrid tr.jqgrow td {
	font-weight: normal; 
	overflow: hidden; 
	white-space: normal !important; 
	height:22px; 
	padding: 0 2px 0 2px;
	border-bottom-width: 1px; 
	border-bottom-color: inherit;
	border-bottom-style: solid;
} */	
</style>

<script type="text/javascript">

	$(function () {
	
		var setwidth = $('#innerdiv2').width();
		
		tableToGrid("#myTable2", {	
				width: setwidth-17, 
				height: '100%',
				rownumbers: true,
				shrinkToFit: false,
				gridComplete: function(){
					jQuery(".alink").button();	
				}
			}
		);
	});

</script>

<?php if( count($relResults) > 0): ?>
<div id="innerdiv2">

	<table id="myTable2">
		
		<thead>
			<tr>
			  <th width="50" align="center" valign="middle">Action</th>
			  <th width="70" align="center" valign="middle">Issue ID</th>
			  <th width="50" align="center" valign="middle">No. of Comments</th>
			  <th width="80" align="center" valign="middle">Status</th>
			  <th width="120" align="center" valign="middle">Customer Name</th>
			  <th width="80" align="center" valign="middle">Date Opened</th>
			  <th width="80" align="center" valign="middle">Date Updated</th>
			  <th width="80" align="center" valign="middle">Date Closed</th>
			  <th width="80" align="center" valign="middle">Callback Date/Time</th>
			  <th width="120" align="center" valign="middle">Representative</th>
			  <th width="80" align="center" valign="middle">Center</th>
			  <th width="80" align="center" valign="middle">Department</th>
			  <th width="120" align="center" valign="middle">Issue Description</th>
			  <!--<th width="50" align="center" valign="middle">Ref. No.</th>-->
			</tr>
		</thead>	
		<tbody>
			<?php 
				
				$i = 0;
				foreach( $relResults as $row ): 
					//$class = (($i%2) ==0)?'':'class="odd"';
					//target="_blank"
			
			?>
			<tr <?php //echo $class ?> >
				<td >
				<?php
					if( $row->status_id != 3 ):
				?>
					<a href="dashboard/openlog/<?php echo $row->erd_id; ?>"  class="alink">Open</a>
				<?php
					endif;
				?>
				</td>
				<td ><?php echo $row->center_acronym.''.$row->erd_id; ?></td>
				<td ><?php echo $row->numofcom; ?></td>
				<td ><?php echo $row->status_desc; ?></td>
				<td ><?php echo $row->cust_name; ?></td>
				<td ><?php echo $row->date_opened; ?></td>
				<td ><?php echo $row->date_updated; ?></td>
				<td ><?php echo $row->date_closed; ?></td>
				<td ><?php echo $row->callback_date; ?></td>
				<td ><?php echo $row->fname.' '.$row->lname; ?></td>
				<td ><?php echo $row->center_desc; ?></td>
				<td ><?php echo $row->dept_desc; ?></td>
				<td ><?php echo $row->erd_issue_desc; ?></td>			
				<!--<td ><?php echo $row->reference_id; ?></td>	-->		
			</tr>
			<?php 
				$i++;
				endforeach; 
			?>
		</tbody>			
	</table>
</div>
<?php 
	
	else:
?>
<div class="information canhide  png_bg" style="position: relative;">No Related Issues</div>
<?php endif; ?>