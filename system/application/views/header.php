<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>ERD Logger</title>
<base href="<?php echo base_url()?>" />

<!-- The recommended practice is to load jQuery from Google's CDN service.  --> 
<script SRC="js/jquery-1.4.2.min.js" type="text/javascript"></script>
<!--<script SRC="js/jquery-1.4.4.min.js" type="text/javascript"></script>-->


<!-- Import jQuery UI Javascript & Customer Scripts file  --> 
<script SRC="js/jquery-ui-1.8.9.custom.min.js" type="text/javascript"></script>
<!--<script SRC="js/ui_scripts.js" type="text/javascript"></script>-->


<!-- LOAD WYSIWYG EDITOR -->
<!--<script type="text/javascript" SRC="js/jquery.wysiwyg.js"></script>-->

<!-- LOAD TABLESORTER -->
<!--<script type="text/javascript" SRC="js/jquery.tablesorter.min.js"></script>-->

<!-- LOAD CUFON FOR FONT REPLACEMENT -->
<script SRC="js/cufon/cufon-yui.js" type="text/javascript"></script>
<script SRC="js/cufon/Qlassik_Font.js" type="text/javascript"></script>

<script type="text/javascript">
	Cufon.replace('H1');
</script>


<!-- Import Master CSS File  --> 
<link href="css/styles.css" rel="stylesheet" type="text/css" />

    <!--[if lte IE 6]>
			<script type="text/javascript" src="js/ddpng.js"></script>
			<script type="text/javascript">
				DD_belatedPNG.fix('#header');
				DD_belatedPNG.fix('#navigation img');
                DD_belatedPNG.fix('#logo img');
				DD_belatedPNG.fix('.tabNavigation');
				DD_belatedPNG.fix('.png_bg');
				DD_belatedPNG.fix('.tabNavigation LI A');
			</script>
		<![endif]-->
</head>

<body>

<script type="text/javascript">
	 $(function() {
	$("#sortable").sortable();
	$("#sortable").disableSelection();
	});
</script>

<div id="contatiner">
<div id="fix_sub_container">	
    <!-- START HEADER -->
    <div id="header">
    
        <!-- START LOGO -->
        <!--<div id="logo">
			<img SRC="images/logo.png" alt="Your Logo" width="450" height="75" />
        </div>-->
        <!-- END LOGO -->
        
        <!-- START PANEL -->
        <div id="panel">
			<h1 style="font-size:20px"><a href="">Local ERD Logger</a></h1>
        </div>
        <div style="color:#0099cc;" id="currentlogininfo">
			<b style="font-size:13px;"><?php echo "(".$this->session->userdata('role_name').") ".$this->session->userdata('firstname')." ".$this->session->userdata('lastname');?></b>&nbsp;&nbsp;&nbsp;<a style="color:#666;" href="auth/logout/">Logout</a>
        </div>		
        <!-- END PANEL -->
    
    </div>
    <!-- END HEADER -->
    
    <!-- START NAVIGATION -->
    <div id="navigation">
		<?php 
			$hroleid 		= $this->session->userdata('role_id' ); 
			$labellog 		= 'Issues';
			$labelcallback 	= 'Callbacks';
			$labelclosed 	= 'Completed';

			/* if( $hroleid == 1 )	{
				$labellog 		= 'All Issues';
				$labelcallback 	= 'All Callbacks';			
				$labelclosed 	= 'All Closed Issues';			
			} */
		?>	
		<ul class="tabNavigation">		
			<li><a HREF="dashboard/" title="My Logs" <?php echo ($menu == 'dashboard')?'class="active"':'' ?> ><img SRC="images/icons/home1_32.png" alt="Home" width="32" height="32" /><span class="tabNavigation_navitem">Home</span></a></li>
			<?php if( $hroleid == 4 OR $hroleid == 2 ): ?>
			<li><a HREF="dashboard/newlog/" title="New Log" <?php echo ($menu == 'new')?'class="active"':'' ?>><img SRC="images/icons/newlog1_32.png" alt="Home" width="32" height="32" /><span class="tabNavigation_navitem">New Call</span></a></li>			
			<?php
				endif;	
				if( $hroleid == 6 OR $hroleid == 5 OR $hroleid == 4 OR $hroleid == 2 OR $hroleid == 1): 
			?>
			<li><a HREF="dashboard/mylog" title="All Logs " <?php echo ($menu == 'mylog')?'class="active"':'' ?> ><img SRC="images/icons/logs_32.png" alt="Home" width="32" height="32" /><span class="tabNavigation_navitem"><?php echo $labellog; ?></span></a></li>
			<li><a href="dashboard/callback" title="Callback Logs" <?php echo ($menu == 'callback')?'class="active"':'' ?> ><img SRC="images/icons/schedule_32.png" alt="Home" width="32" height="32" /><?php echo $labelcallback; ?></a></li>		
			<li><a href="dashboard/closed" title="Closed Logs" <?php echo ($menu == 'closed')?'class="active"':'' ?> ><img SRC="images/icons/schedule_32.png" alt="Home" width="32" height="32" /><?php echo $labelclosed; ?></a></li>		
			<?php 
				endif; 
				if( $hroleid == 4 OR $hroleid == 3):
			?>
			<li><a href="dashboard/enterprise" title="Enterprise View" <?php echo ($menu == 'enterpriseviewlog')?'class="active"':'' ?> ><img SRC="images/icons/enterprise.png" alt="Home" width="32" height="32" />Enterprise View</a></li>		
			<li><a href="dashboard/callback" title="Callback View" <?php echo ($menu == 'callback')?'class="active"':'' ?> ><img SRC="images/icons/enterprise.png" alt="Home" width="32" height="32" />Callback</a></li>		
			<li><a href="dashboard/summary" title="Summary View" <?php echo ($menu == 'summary')?'class="active"':'' ?> ><img SRC="images/icons/summary.png" alt="Home" width="32" height="32" />Summary</a></li>		
			<?php endif; ?>
			
			<?php if( $hroleid == 1 ): ?>
			
			<li><a href="dashboard/ilogs" title="Manage Account" <?php echo ($menu == 'ilogs')?'class="active"':'' ?>><img SRC="images/icons/myacct.png" alt="Home" width="32" height="32" />My Issues</a></li>
			<li><a href="dashboard/icallback" title="Manage Account" <?php echo ($menu == 'icallback')?'class="active"':'' ?> ><img SRC="images/icons/myacct.png" alt="Home" width="32" height="32" />My Callbacks</a></li>
			
			<?php endif; ?>
			
			<?php if( $hroleid == 2 ): ?>
			<li><a href="dashboard/ilogs" title="Manage Account" <?php echo ($menu == 'ilogs')?'class="active"':'' ?>><img SRC="images/icons/myacct.png" alt="Home" width="32" height="32" />My Issues</a></li>
			<li><a href="dashboard/icallback" title="Manage Account" <?php echo ($menu == 'icallback')?'class="active"':'' ?> ><img SRC="images/icons/myacct.png" alt="Home" width="32" height="32" />My Callbacks</a></li>					
			<?php endif; ?>
			
			<?php 
				if( $hroleid <> 6 AND $this->_userid <> 2669):
			?>

			<li><a href="dashboard/manageaccount" title="Manage Account" <?php echo ($menu == 'manageaccount')?'class="active"':'' ?> ><img SRC="images/icons/myacct.png" alt="Home" width="32" height="32" />Manage Account</a></li>		
			<?php
				endif;
			?>
			
			<!--<li><a HREF="typography.html" title="Users"><img SRC="images/icons/comment_32.png" alt="Home" width="32" height="32" border="0" /><span class="tabNavigation_navitem">Comments</span></a></li>-->
			
			<!--<li><a HREF="demo.html" title="Logout"><img SRC="images/icons/user_32.png" alt="Manage Content" width="32" height="32" /><span class="tabNavigation_navitem">Logout</span></a></li>-->
			<!--<li><a href="#" title="Users"><img SRC="images/icons/tools_32.png" alt="Home" width="32" height="32" /><span class="tabNavigation_navitem">Settings</span></a></li> --> 
				
		</ul>
    
    </div>
    <!-- END NAVIGATION -->