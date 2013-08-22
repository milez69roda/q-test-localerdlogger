<style type="text/css">
th{padding:5px;border:1px solid #000;}
td{padding:0px 2px;}
form label{text-transform:capitalize}
label.error{margin-left:5px;color:#ff0000;font-weight:normal;}
</style>
<script type="text/javascript" src="js/jquery.validate.js"></script>
<form action="" id="frmcreate1" name="frmcreate1" method="post">
	<table border="1" style="border-collapse:collapse;border:1px solid #000;" cellspacing="5" cellpadding="5">
		<?php
		
		$uid="SELECT * FROM user_temp WHERE supervisor_id=".$this->session->userdata('user_id')." ORDER BY fname ASC;";
		$quer=$this->db->query($uid);
		
		?>
		<tr >
			<th>Username</th>
			<th>First Name</th>
			<th>Last Name</th>
			<th>Options</th>
		</tr>
		<?php
		foreach($quer->result() as $row){
		?>
		<tr id="traccept_<?php echo $row->id;?>">
			<td><?php echo $row->username?></td>
			<td><?php echo $row->fname?></td>
			<td><?php echo $row->lname?></td>
			<td><a href="javascript:void(0)" data="<?php echo $row->id;?>" class="acceptbtn">Accept</a></td>
		</tr>
		<?php
		}
		?>
	</table>
</form>
<script type="text/javascript">
	$(document).ready(function(){
			
		$(".acceptbtn").click(function(){
			
			if( confirm("Does this representative belongs to you?") ){
				
				var sid = $(this).attr("data");
				
				$.ajax({
					type: "POST",
					url:"dashboard/ajax_acceptaccount_action/?trck=1",
					data: "sid="+sid,
					cache: false,
					success: function(results){
						var res = jQuery.parseJSON(results);
						
						if( res.status){
							$("#"+res.trid).fadeOut(1000,function(){
								//$("#"+res.trid)	
							})
						}
					}
				});
				
			}
			
		})
		
	});
</script>