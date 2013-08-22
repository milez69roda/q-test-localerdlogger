
<!--<script SRC="js/summary_scripts.js" type="text/javascript"></script>-->
    <!-- START CONTENT -->
<div id="content">
 

    <!-- START MAIN CONTEMT -->
    <div id="main_content">
        <!-- TAB HEADERS -->
        <div id="tabs">
          <ul>
            <li><a href="dashboard/centersummary/?tk=1&st=0&from=<?php echo date('Y-m-d'); ?>&to=<?php echo date('Y-m-d'); ?>">Center</a></li>
            <!--<li><a href="dashboard/statussummary/?tk=1&st=0&from=<?php echo date('Y-m-d'); ?>&to=<?php echo date('Y-m-d'); ?>">Status</a></li>
            <li><a href="dashboard/getLogAge">Age</a></li>-->
            <!--<li><a href="dashboard/statussummary/">Status</a></li>-->
            
          </ul>
        <!-- END TAB HEADERS -->
		</div>
        <div class="spacer">&nbsp;</div>  
  
	</div><!-- END MAIN CONTENT -->

</div>
<!-- END CONTEMT -->

<script type="text/javascript">

	$(document).ready(function() {
	
		/* $("#fromdate").datepicker({dateFormat:'yy-mm-dd'});
		$("#todate").datepicker({dateFormat:'yy-mm-dd'});		
		 */
		$('#tabs').tabs({
			load: function(event, ui) {
				$('a', ui.panel).click(function() {
					 $(ui.content).load(this.href);
					return false;
				});
			}
		});	
	

	});	
	



</script>