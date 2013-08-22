
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


	.ui-jqgrid tr.jqgrow td {
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

	.ui-button-text {
		padding: 0.4em 0.2em !important; 
		line-height: 1 !important; 
	}	

</style>


<!--<script SRC="js/summary_scripts.js" type="text/javascript"></script>-->
    <!-- START CONTENT -->
<div id="content">
 

    <!-- START MAIN CONTEMT -->
    <div id="main_content">
        <!-- TAB HEADERS -->
        <div id="tabs">
          <ul>
			<?php
			$roles=$this->session->userdata('role_id');
			if($roles==1 or $roles==3 or $roles==4 or $roles==5){
			?>
            <li><a href="dashboard/accountlist/">Agent List</a></li>
            <li><a href="dashboard/createuser/">Create User</a></li>
			<?php
			}
			if($roles==1){
			?>
            <li><a href="dashboard/acceptaccount/">Accept Agent</a></li>
			<?
			}
			?>
            <li><a href="dashboard/myaccount/">My Account</a></li>
          </ul>
        <!-- END TAB HEADERS -->
		</div>
        <div class="spacer">&nbsp;</div>  
  
	</div><!-- END MAIN CONTENT -->

</div>
<!-- END CONTEMT -->

<script type="text/javascript">

	$(document).ready(function() {
	
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