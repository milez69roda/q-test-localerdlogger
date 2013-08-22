<?php
require_once "Spreadsheet/Excel/Writer.php";

class Erd extends Model {
	
	var $from;
	var $to;
	var $centerid;
	
	function __construct(){
		parent::Model();	
		error_reporting(0);  
	}
	
	function getList( $where, $isAll, $offset ){
		
		if( $isAll ){
		
		 
		}
		
		$this->db->where($where);
		
		$this->db->select('	centers.center_desc, 
							drp_department.dept_desc,
							drp_status.status_desc,
							erdlogs.* ');
		
		$this->db->join('users.id = erdlogs.owner', 'left');
		$this->db->join('drp_department.dept_id = users.dept_id', 'left');
		$this->db->join('centers.center_id = users.center_id', 'left');
		$this->db->join('drp_status.status_id = erdlogs.status_id', 'left');
		
		$ret = $this->db->get('erdlogs');
		
		return $ret;
	}
	
	function getLogs_by_imei($data){
	
		//$this->db->where('imei',$imei);
		$this->db->where($data);
		
		$this->db->select('	COUNT(comments.comment_id) AS numofcom,
							centers.center_desc, centers.center_acronym,
							drp_department.dept_desc,
							drp_status.status_desc,
							erdlogs.*,
							users.*');
		
		$this->db->join('users', 'users.id = erdlogs.user_id', 'left outer');
		$this->db->join('drp_department', 'drp_department.dept_id = users.dept_id', 'left outer');
		$this->db->join('centers', 'centers.center_id = users.center_id', 'left outer');
		$this->db->join('drp_status', 'drp_status.status_id = erdlogs.status_id', 'left outer');
		$this->db->join('comments', 'comments.erd_id = erdlogs.erd_id', 'left outer');
		
		$this->db->order_by("date_updated", "desc");
		$this->db->group_by('erdlogs.erd_id');
		
		$ret = $this->db->get('erdlogs');
		
		return $ret;	
	}
	
	
	function getMyLogs( $params, $page = 'all', $where = array(), $strwhere = '' ){
		$strwhere_flag = true;
		if( !empty($params) ){
		
			$this->db->order_by( $params['sort_by'], $params ["sort_direction"] );

			if ($page != "all"){
			
				$this->db->limit ($params["num_rows"], $params["num_rows"] *  ($params["page"] - 1) );
			}
			
		
			if  ($params["search"] == 'true' ){
				
				$this->jqgrid_oper( $params["search_field"], $params["search_operator"], $params["search_str"] );
				
				if( is_object($params["filters"]) ){
					
					$filters = $params["filters"];
					
					foreach(  $filters as $key=>$values ){
						
						if( $key == 'rules'){

							foreach( $values as $data){
								
								if( $data->field == 'status_id' ){															
									$this->jqgrid_oper( 'erdlogs.status_id', $data->op, strtolower($data->data) );
									$strwhere_flag = false;
								}elseif( $data->field == 'user_id' ){	
									$this->jqgrid_oper( 'erdlogs.user_id', $data->op, strtolower($data->data) );
								}elseif( $data->field == 'center_id' ){	
									$this->jqgrid_oper( 'users.center_id', $data->op, strtolower($data->data) );
								}elseif( $data->field == 'erdlogs.erd_id' ){	
									//ECHO strlen(TRIM($data->data));
									
									$a1 = trim($data->data);
									
									if( strlen($a1) > 3 ){
										$temp1 = $a1;	
										$erd_id = preg_replace('[\D]', '', $temp1);
										$this->jqgrid_oper( 'erdlogs.erd_id', $data->op, strtolower($erd_id) );
									}else{
										$this->jqgrid_oper( 'erdlogs.erd_id', $data->op, 'invalid' );
									}
								}elseif( $data->field == 'lname' ){	
									//$this->jqgrid_oper( 'erd_id', $data->op, strtolower($erd_id) );
									
									$temp1 = explode(',',$data->data);
									
									$this->db->like('lower(fname)', strtolower($temp1[1]));
									$this->db->or_like('lower(lname)', strtolower($temp1[0]));
									
								}elseif( $data->field == 'erd_issue_desc' ){	
									if( $data->data == "allmiami" ){
										$this->db->like($data->field, 'Miami');
									}else if( $data->data == "allcarecenter"){
										$this->db->not_like($data->field, 'Miami');
									}else{
										$this->jqgrid_oper( $data->field, $data->op, strtolower($data->data) );
									}									
																	
								}else{
									$this->jqgrid_oper( $data->field, $data->op, strtolower($data->data) );
								}
							}							
						}
					}			
				}			
			}		
		}
		
		if( !empty($where) ){
		
			$this->db->where($where,false);
		
		}

		if( $strwhere != '' AND $strwhere_flag )	{
			$this->db->where($strwhere,null,false);
		}
		
		$this->db->where('erd_deleted', 0);
			if( $page != 'all' ){
				$this->db->select('	centers.center_desc, centers.center_acronym,
									drp_department.dept_desc,
									drp_status.status_desc,
									erdlogs.*,
									users.*');	
			}else{
				$this->db->select(' count(erd_id) as numrows ');
			}
			
			$this->db->join('users', 'users.id = erdlogs.user_id', 'left outer');
			$this->db->join('drp_department', 'drp_department.dept_id = users.dept_id', 'left outer');
			$this->db->join('centers', 'centers.center_id = users.center_id', 'left outer');
			$this->db->join('drp_status', 'drp_status.status_id = erdlogs.status_id', 'left outer');
			//$this->db->join('comments', 'comments.erd_id = erdlogs.erd_id', 'left outer');
			
			//$this->db->group_by('erdlogs.erd_id');
			
		/*}else{
			$this->db->select('	COUNT(comments.comment_id) AS numofcom, centers.center_desc, centers.center_acronym, 
								drp_department.dept_desc,
								drp_status.status_desc,
								erdlogs.*,
								users.*');		
			
			$this->db->join('users', 'users.id = erdlogs.user_id', 'left outer');
			$this->db->join('drp_department', 'drp_department.dept_id = users.dept_id', 'left outer');
			$this->db->join('centers', 'centers.center_id = users.center_id', 'left outer');
			$this->db->join('drp_status', 'drp_status.status_id = erdlogs.status_id', 'left outer');
			$this->db->join('comments', 'comments.erd_id = erdlogs.erd_id', 'left outer');
			
			$this->db->group_by('erdlogs.erd_id');	
	     } */	
		
		
		
		
		$query = $this->db->get('erdlogs');
	
		
		return $query;	
		
	}
		
	function getMyLogsExport( $params, $page = 'all', $where = array(), $strwhere = '' ){
		$strwhere_flag = true;
		if( !empty($params) ){
			
			if( $params ["sort_direction"] != '')
				$this->db->order_by( $params['sort_by'], $params ["sort_direction"] );

			if ($page != "all"){
			
				$this->db->limit ($params["num_rows"], $params["num_rows"] *  ($params["page"] - 1) );
			}
			
		
			if  ($params["search"] == 'true' ){
				
				$this->jqgrid_oper( $params["search_field"], $params["search_operator"], $params["search_str"] );
				
				if( is_object($params["filters"]) ){
					
					$filters = $params["filters"];
					
					foreach(  $filters as $key=>$values ){
						
						if( $key == 'rules'){

							foreach( $values as $data){
								
								if( $data->field == 'status_id' ){															
									$this->jqgrid_oper( 'erdlogs.status_id', $data->op, strtolower($data->data) );
									$strwhere_flag = false;
								}elseif( $data->field == 'user_id' ){	
									$this->jqgrid_oper( 'erdlogs.user_id', $data->op, strtolower($data->data) );
								}elseif( $data->field == 'center_id' ){	
									$this->jqgrid_oper( 'users.center_id', $data->op, strtolower($data->data) );
								}elseif( $data->field == 'erdlogs.erd_id' ){	
									
									if( strlen($data->data) > 3 ){
										$temp1 = trim($data->data);
										$erd_id =  substr($temp1, 3, strlen($temp1)); 								
										$this->jqgrid_oper( 'erdlogs.erd_id', $data->op, strtolower($erd_id) );
									}else{
										$this->jqgrid_oper( 'erdlogs.erd_id', $data->op, 'invalid' );
									}
								}elseif( $data->field == 'lname' ){	
									//$this->jqgrid_oper( 'erd_id', $data->op, strtolower($erd_id) );
									
									$temp1 = explode(',',$data->data);
									
									$this->db->like('lower(fname)', strtolower($temp1[1]));
									$this->db->like('lower(lname)', strtolower($temp1[0]));

								}elseif( $data->field == 'erd_issue_desc' ){	
									if( $data->data == "allmiami" ){
										$this->db->like($data->field, 'Miami');
									}else if( $data->data == "allcarecenter"){
										$this->db->not_like($data->field, 'Miami');
									}else{
										$this->jqgrid_oper( $data->field, $data->op, strtolower($data->data) );
									}									
																	
								}else{
									$this->jqgrid_oper( $data->field, $data->op, strtolower($data->data) );
								}
							}							
						}
					}			
				}			
			}		
		}
		
		if( !empty($where) ){
		
			$this->db->where($where,false);
		
		}

		if( $strwhere != '' AND $strwhere_flag )	{
			$this->db->where($strwhere,null,false);
		}
		
		$this->db->where('erd_deleted', 0);
		
		/* $this->db->select('	COUNT(comments.comment_id) AS numofcom, centers.center_desc, centers.center_acronym, 
							drp_department.dept_desc,
							drp_status.status_desc,
							erdlogs.*,
							users.*');	 */

		$this->db->select("CONCAT(centers.center_acronym,'',erdlogs.erd_id) AS 'Issue ID', 
							status_desc AS 'Status', 
							
							CONCAT(users.lname,', ',users.fname) AS 'Representative',
							users.avaya AS 'Avaya',
							imei AS 'IMEI',
							phone_no AS 'Contact No',
							cust_name AS 'Customer Name',
							case_no AS 'Interaction/Case No',
							erd_issue_desc AS 'Issue Type',
							erd_issuesub_desc AS 'Issue Description',
							minno AS 'MIN',
							source AS 'channel',
							organization AS 'Brand',
							emailaddress AS 'Email Address',
							date_opened AS 'Date Opened',
							date_updated AS 'Date Updated',
							date_closed AS 'Date Closed',
							callback_date AS 'Callback Date/Time',
							escalatedto AS 'Escalated',
							(SELECT GROUP_CONCAT(note_text, '\n###\n' )  FROM notes WHERE erd_id = erdlogs.erd_id)  AS 'Notes'",false);							
		//CONCAT(sup.lname,', ',sup.fname) AS 'Supervisor',
		$this->db->join('users', 'users.id = erdlogs.user_id', 'left outer');		
		$this->db->join('drp_department', 'drp_department.dept_id = users.dept_id', 'left outer');
		$this->db->join('centers', 'centers.center_id = users.center_id', 'left outer');
		$this->db->join('drp_status', 'drp_status.status_id = erdlogs.status_id', 'left outer');
		//$this->db->join('comments', 'comments.erd_id = erdlogs.erd_id', 'left outer');
		//$this->db->join('users sup', 'sup.id = users.supervisor_id', 'left outer');
		
		$this->db->group_by('erdlogs.erd_id');
		
		$query = $this->db->get('erdlogs');
		
		
		return $query;	
		
	}
		
	function getMyLogsExportEnterprise( $params, $page = 'all', $where = array(), $strwhere = '' ){
		$strwhere_flag = true;
		if( !empty($params) ){
		
			$this->db->order_by( $params['sort_by'], $params ["sort_direction"] );

			if ($page != "all"){
			
				$this->db->limit ($params["num_rows"], $params["num_rows"] *  ($params["page"] - 1) );
			}
			
		
			if  ($params["search"] == 'true' ){
				
				$this->jqgrid_oper( $params["search_field"], $params["search_operator"], $params["search_str"] );
				
				if( is_object($params["filters"]) ){
					
					$filters = $params["filters"];
					
					foreach(  $filters as $key=>$values ){
						
						if( $key == 'rules'){

							foreach( $values as $data){
								
								if( $data->field == 'status_id' ){															
									$this->jqgrid_oper( 'erdlogs.status_id', $data->op, strtolower($data->data) );
									$strwhere_flag = false;
								}elseif( $data->field == 'user_id' ){	
									$this->jqgrid_oper( 'erdlogs.user_id', $data->op, strtolower($data->data) );
								}elseif( $data->field == 'center_id' ){	
									$this->jqgrid_oper( 'users.center_id', $data->op, strtolower($data->data) );
								}elseif( $data->field == 'erd_id' ){	
									
									if( strlen($data->data) > 3 ){
										$temp1 = trim($data->data);
										$erd_id =  substr($temp1, 3, strlen($temp1)); 								
										$this->jqgrid_oper( 'erdlogs.erd_id', $data->op, strtolower($erd_id) );
									}else{
										$this->jqgrid_oper( 'erdlogs.erd_id', $data->op, 'invalid' );
									}
								}elseif( $data->field == 'lname' ){	
									//$this->jqgrid_oper( 'erd_id', $data->op, strtolower($erd_id) );
									
									$temp1 = explode(',',$data->data);
									
									$this->db->like('lower(fname)', strtolower($temp1[1]));
									$this->db->like('lower(lname)', strtolower($temp1[0]));
								}else{
									$this->jqgrid_oper( $data->field, $data->op, strtolower($data->data) );
								}
							}							
						}
					}			
				}			
			}		
		}
		
		if( !empty($where) ){
		
			$this->db->where($where,false);
		
		}

		if( $strwhere != '' AND $strwhere_flag )	{
			$this->db->where($strwhere,null,false);
		}
		
		$this->db->where('erd_deleted', 0);
		
		/* $this->db->select('	COUNT(comments.comment_id) AS numofcom, centers.center_desc, centers.center_acronym, 
							drp_department.dept_desc,
							drp_status.status_desc,
							erdlogs.*,
							users.*');	 */

		$this->db->select("CONCAT(centers.center_acronym, '', erdlogs.erd_id) AS 'Issue ID', 
							centers.center_desc AS 'Center',
							CONCAT(users.lname, ', ', users.fname) AS 'Representative',
							users.avaya AS 'Avaya',
							status_desc AS 'Status',
							imei AS 'IMEI',
							phone_no AS 'Contact No',
							cust_name AS 'Customer Name',
							case_no AS 'Interaction/Case No',
							erd_issue_desc AS 'Issue Type',
							erd_issuesub_desc AS 'Issue Description',
							minno AS 'MIN',
							source AS 'channel',
							organization AS 'Brand',
							emailaddress AS 'Email Address',
							date_opened AS 'Date Opened',
							date_updated AS 'Date Updated',
							date_closed AS 'Date Closed',
							callback_date AS 'Callback Date/Time',
							escalatedto AS 'Escalated',
							(SELECT GROUP_CONCAT(note_text, '\n###\n' )  FROM notes WHERE erd_id = erdlogs.erd_id)  AS 'Notes'",false);							
		
		$this->db->join('users', 'users.id = erdlogs.user_id', 'left outer');
		$this->db->join('drp_department', 'drp_department.dept_id = users.dept_id', 'left outer');
		$this->db->join('centers', 'centers.center_id = users.center_id', 'left outer');
		$this->db->join('drp_status', 'drp_status.status_id = erdlogs.status_id', 'left outer');
		//$this->db->join('comments', 'comments.erd_id = erdlogs.erd_id', 'left outer');
		
		$this->db->group_by('erdlogs.erd_id');
		
		$query = $this->db->get('erdlogs');
		
		
		return $query;	
		
	}
	/* 	
	SELECT centers.center_id, center_desc, SUM(IF(status_id =1,1,0)) AS 'new', SUM(IF(status_id = 2,1,0)) AS 'pending', SUM(IF(status_id = 3,1,0)) AS 'closed', SUM(IF(needcallback = 1,1,0)) AS 'callbacks'
	FROM erdlogs
	LEFT OUTER JOIN users ON users.id = erdlogs.user_id
	LEFT OUTER JOIN centers ON centers.center_id = users.center_id
	GROUP BY centers.center_id
	*/	
	
	function getCenterSummary_active(){

		$this->db->where(" needcallback = 0 AND DATE_FORMAT(date_updated, '%Y-%m-%d') BETWEEN '".$this->from."' AND '".$this->to."' ", NULL,FALSE);
		//$this->db->select("centers.center_id, SUM(IF(status_id =1,1,0)) AS 'new', SUM(IF(status_id = 2,1,0)) AS 'pending', SUM(IF(status_id = 3,1,0)) AS 'closed', SUM(IF(status_id = 7,1,0)) AS 'unable', SUM(IF(needcallback = 1,1,0)) AS 'callbacks'", FALSE);
		//$this->db->select("centers.center_id, SUM(IF(status_id = 2,1,0)) AS 'pending', SUM(IF(status_id = 3,1,0)) AS 'closed', SUM(IF(status_id = 7,1,0)) AS 'unable'", FALSE);
		$this->db->where("erd_deleted",0);
		/* $this->db->select("centers.center_id, 
							SUM(IF(status_id = 2,1,0)) AS 'pending', 
							SUM(IF(status_id = 3,1,0)) AS 'closed',
							SUM( IF( (EXTRACT( DAY_HOUR FROM TIMEDIFF(NOW(), date_updated) ) > 24) AND (status_id <> 3), 1, 0) ) AS 'more', 
							SUM( IF( (EXTRACT( DAY_HOUR FROM TIMEDIFF(NOW(), date_updated) ) <= 24) AND (status_id <> 3), 1, 0) ) AS 'less' 		
							", FALSE); */
							
		$this->db->select("centers.center_id, 
							SUM(IF(status_id = 2,1,0)) AS 'pending', 
							SUM(IF(status_id = 3,1,0)) AS 'closed',
							SUM( IF( (callback_type = 1) AND (status_id = 2 OR status_id = 2), 1, 0) ) AS 'less', 
							SUM( IF( (callback_type = 2) AND (status_id = 3), 1, 0) ) AS 'more' 		
							", FALSE);
		$this->db->join('users', 'users.id = erdlogs.user_id', 'left outer');
		$this->db->join('centers', 'centers.center_id = users.center_id', 'left outer');
		$this->db->group_by('centers.center_id');
		$query = $this->db->get("erdlogs");
		
		return $query;
	}	
	
	function getCenterSummary_activeCallback(){

		$this->db->where(" needcallback = 1 AND DATE_FORMAT(date_updated, '%Y-%m-%d') BETWEEN '".$this->from."' AND '".$this->to."' ", NULL,FALSE);
		//$this->db->select("centers.center_id, SUM(IF(status_id =1,1,0)) AS 'new', SUM(IF(status_id = 2,1,0)) AS 'pending', SUM(IF(status_id = 3,1,0)) AS 'closed', SUM(IF(status_id = 7,1,0)) AS 'unable', SUM(IF(needcallback = 1,1,0)) AS 'callbacks'", FALSE);
		$this->db->where("erd_deleted",0);
		/* $this->db->select("centers.center_id, 
							SUM(IF(status_id = 2,1,0)) AS 'pending', 
							SUM(IF(status_id = 3,1,0)) AS 'closed', 
							SUM(IF(status_id = 7,1,0)) AS 'unable',
							SUM( IF( (EXTRACT( DAY_HOUR FROM TIMEDIFF(NOW(), date_updated) ) > 24) AND (status_id <> 3), 1, 0) ) AS 'more', 
							SUM( IF( (EXTRACT( DAY_HOUR FROM TIMEDIFF(NOW(), date_updated) ) <= 24) AND (status_id <> 3), 1, 0) ) AS 'less' 						
							", FALSE); */
							
		$this->db->select("centers.center_id, 
							SUM(IF(status_id = 2,1,0)) AS 'pending', 
							SUM(IF(status_id = 3,1,0)) AS 'closed', 
							SUM(IF(status_id = 7,1,0)) AS 'unable',
							SUM( IF( (callback_type = 1) AND (status_id = 2 OR status_id = 2), 1, 0) ) AS 'less', 
							SUM( IF( (callback_type = 2) AND (status_id = 3), 1, 0) ) AS 'more' 
							", FALSE);
							
		$this->db->join('users', 'users.id = erdlogs.user_id', 'left outer');
		$this->db->join('centers', 'centers.center_id = users.center_id', 'left outer');
		$this->db->group_by('centers.center_id');
		$query = $this->db->get("erdlogs");
		
		return $query;
	}
	
	function getCenterSummary( $center ){
	
		//$this->db->where(" DATE_FORMAT(date_updated, '%Y-%m-%d') BETWEEN '".$this->from."' AND '".$this->to."' ", NULL,FALSE);
		
/* 		$this->db->select("centers.center_id,							
							SUM(IF(status_id = 2,1,0)) AS 'pending', 
							SUM(IF(status_id = 3,1,0)) AS 'closed',
							SUM(IF(status_id = 7,1,0)) AS 'unable',
							SUM( IF( (EXTRACT( DAY_HOUR FROM TIMEDIFF(NOW(), date_updated) ) > 24) AND (status_id <> 3), 1, 0) ) AS 'more', 
							SUM( IF( (EXTRACT( DAY_HOUR FROM TIMEDIFF(NOW(), date_updated) ) <= 24) AND (status_id <> 3), 1, 0) ) AS 'less', 
							SUM( IF( needcallback = 1 and (status_id <> 3), 1, 0) ) AS 'callback'		
							", FALSE); */		
		$this->db->select("centers.center_id,							
							SUM(IF(status_id = 2,1,0)) AS 'pending', 
							SUM(IF(status_id = 3,1,0)) AS 'closed',
							SUM(IF(status_id = 7,1,0)) AS 'unable',
							SUM( IF( (callback_type = 1) AND (status_id = 2 OR status_id = 2), 1, 0) ) AS 'less', 
							SUM( IF( (callback_type = 2) AND (status_id = 3), 1, 0) ) AS 'more',
							SUM( IF( needcallback = 1 and (status_id <> 3), 1, 0) ) AS 'callback'		
							", FALSE);
		$this->db->join('users', 'users.id = erdlogs.user_id', 'left outer');
		$this->db->join('centers', 'centers.center_id = users.center_id', 'left outer');
		$this->db->group_by('centers.center_id');
		
		$this->db->where("centers.center_id", $center);
		$this->db->where("erd_deleted",0);
		
		$query = $this->db->get("erdlogs");	
		
		return $query;
	}
	
	function getCenterSummary_age(){
	
		$this->db->select("centers.center_id, COUNT(*) AS 'num', EXTRACT( DAY_HOUR FROM TIMEDIFF(NOW(),MIN(date_updated))) AS age ");			
		$this->db->join('users', 'users.id = erdlogs.user_id', 'left outer');		
		$this->db->join('centers', 'centers.center_id = users.center_id', 'left outer');
		$this->db->where("DATE_FORMAT(date_updated, '%Y-%m-%d') BETWEEN '".$this->from."' AND '".$this->to."' ", NULL,FALSE);
		$this->db->where("centers.center_id <> '' ", null, false);
		$this->db->where("(erdlogs.status_id <> 3) ", null, false);
		$this->db->group_by("centers.center_id");
		
		$query = $this->db->get("erdlogs");	
		
		return $query;
	}
	
	function no_of_new(){
		
		$this->db->where(" center_id = ".$this->centerid." AND status_id = 1 AND DATE_FORMAT(date_updated, '%Y-%m-%d') BETWEEN '".$this->from."' AND '".$this->to."' ", NULL,FALSE);
		$this->db->select(" count(*) 'num' ");
		$this->db->join('users', 'users.id = erdlogs.user_id', 'left outer');		
		$query = $this->db->get("erdlogs")->row();
		
		return $query->num;
	}	
	
	function no_of_pending(){
		
		$this->db->where(" center_id = ".$this->centerid." AND status_id = 2 AND DATE_FORMAT(date_updated, '%Y-%m-%d') BETWEEN '".$this->from."' AND '".$this->to."' ", NULL,FALSE);
		$this->db->select(" count(*) 'num' ");
		$this->db->join('users', 'users.id = erdlogs.user_id', 'left outer');		
		$query = $this->db->get("erdlogs")->row();
		
		return $query->num;
	}
	
	function no_of_closed(){
		
		$this->db->where(" center_id = ".$this->centerid." AND status_id = 3 AND DATE_FORMAT(date_updated, '%Y-%m-%d') BETWEEN  '".$this->from."' AND '".$this->to."' ", NULL,FALSE);
		$this->db->select(" count(*) 'num' ");
		$this->db->join('users', 'users.id = erdlogs.user_id', 'left outer');		
		$query = $this->db->get("erdlogs")->row();
		
		return $query->num;
	}
	
	function no_of_unable(){
		
		$this->db->where(" center_id = ".$this->centerid." AND status_id = 7 AND DATE_FORMAT(date_updated, '%Y-%m-%d') BETWEEN '".$this->from."' AND '".$this->to."' ", NULL,FALSE);
		$this->db->select(" count(*) 'num' ");
		$this->db->join('users', 'users.id = erdlogs.user_id', 'left outer');		
		$query = $this->db->get("erdlogs")->row();
		
		return $query->num;
	}
	
	function no_of_callbacks(){
		
		$this->db->where(" needcallback = 1 AND center_id = ".$this->centerid." AND (status_id = 1 OR status_id = 2) AND DATE_FORMAT(date_updated, '%Y-%m-%d') BETWEEN '".$this->from."' AND '".$this->to."' ", NULL,FALSE);
		$this->db->select(" count(*) 'num' ");
		$this->db->join('users', 'users.id = erdlogs.user_id', 'left outer');		
		$query = $this->db->get("erdlogs")->row();
		
		return $query->num;
	}
	
	
	function isYourIssue( $issueid, $acType, $userid, $centerid ){
	
		$this->db->where('erd_id', $issueid);
		
		$this->db->where('erd_deleted', 0);
		
		$this->db->select('	centers.center_desc, centers.center_acronym, 
							drp_department.dept_desc,
							drp_status.status_desc,
							erdlogs.*,
							users.*');		
		
		$this->db->join('users', 'users.id = erdlogs.user_id', 'left outer');
		$this->db->join('drp_department', 'drp_department.dept_id = users.dept_id', 'left outer');
		$this->db->join('centers', 'centers.center_id = users.center_id', 'left outer');
		$this->db->join('drp_status', 'drp_status.status_id = erdlogs.status_id', 'left outer');
		
		$query = $this->db->get('erdlogs')->row();
		
		if( trim($issueid) != '' ){
			if( $acType == 2 ){			
				//return ( $query->user_id == $userid )?true:false;
				return ( $query->center_id == $centerid )?true:false;
			}elseif( $acType == 1 OR $acType == 5 ){
				return ( $query->center_id == $centerid )?true:false;
			}elseif( $acType == 6 ){
				return true;
			}elseif( $acType == 3 ){
				return true;
			}else{
				return ( $query->center_id == $centerid )?true:false;
			}	
		}else{
			return false;
		}
	}
	
	function getTransferredIssues($where){
		
		//$this->db->where("user_id", $user_id);
		if( !empty($where) ){
			$this->db->where($where, null, false);
		}
		/* $this->db->where("reassigned", 1);
		$this->db->where("reassigned_flag", 0); */
		
		$this->db->order_by('reassigned_datetime','desc');
		$this->db->select('	centers.center_desc, centers.center_acronym, 
							erdlogs.*,
							users.*');	
							
		$this->db->join('users', 'users.id = erdlogs.reassignedto', 'left outer');
		$this->db->join('centers', 'centers.center_id = users.center_id', 'left outer');
		$query = $this->db->get("erdlogs");
		
		return $query;
	}
	
	
	function jqgrid_oper( $fld, $foper, $fldata ){
	
		switch ($foper) {
			case "eq":
				/*if(is_numeric($fldata)) {
					$wh .= " = ".$fldata;
				} else {
					$wh .= " = '".$fldata."'";
				}*/
				$this->db->where($fld,$fldata);
				break;
			case "ne":
				/*if(is_numeric($fldata)) {
					$wh .= " <> ".$fldata;
				} else {
					$wh .= " <> '".$fldata."'";
				}*/				
				$this->db->where($fld.' <> ',$fldata);
				break;
			case "lt":
				/*if(is_numeric($fldata)) {
					$wh .= " < ".$fldata;
				} else {
					$wh .= " < '".$fldata."'";
				}*/				
				$this->db->where($fld.' < ',$fldata);
				break;
			case "le":
				/*if(is_numeric($fldata)) {
					$wh .= " <= ".$fldata;
				} else {
					$wh .= " <= '".$fldata."'";
				}*/
				$this->db->where($fld.' <= ',$fldata);
				break;
			case "gt":
				/*if(is_numeric($fldata)) {
					$wh .= " > ".$fldata;
				} else {
					$wh .= " > '".$fldata."'";
				}*/
				$this->db->where($fld.' > ',$fldata);
				break;
			case "ge":
				/*if(is_numeric($fldata)) {
					$wh .= " >= ".$fldata;
				} else {
					$wh .= " >= '".$fldata."'";
				}*/
				$this->db->where($fld.' >= ',$fldata);
				break;			
			case "bw":
				$this->db->like($fld, $fldata, 'after');
				break;				
			case "bn":
				//$wh .= " LIKE '%".$fldata."'";
				$this->db->no_like($fld, $fldata, 'after');
				break;			
			case "ew":
				//$wh .= " LIKE '%".$fldata."'";
				$this->db->like($fld, $fldata, 'before');
				break;			
			case "en":
				//$wh .= " LIKE '%".$fldata."'";
				$this->db->not_like($fld, $fldata, 'before');
				break;
			case "cn":
				//$wh .= " LIKE '%".$fldata."%'";
				$this->db->like($fld, $fldata);
				break;			
			case "nc":
				//$wh .= " LIKE '%".$fldata."%'";
				$this->db->not_like($fld, $fldata);
				break;
			default :
				$wh = "";
		}	
	
	}
	
	function excelwriter_factory1( $query ){
		//delete files
		ini_set('memory_limit', '-1');
		error_reporting(0);
		   
		list($usec, $sec) = explode(" ", microtime());
		$now = ((float)$usec + (float)$sec);		

		$current_dir = @opendir('filemanager/auto/');

		//echo $current_dir;
		while( $filename = @readdir($current_dir) ) {
			
			if ($filename != "." and $filename != ".." and $filename != "index.html") {
				$name = str_replace(".xls", "", $filename);
				
				if (($name + 3600) < $now) {
					@unlink('filemanager/auto/'.$filename);
				}
			}
		}

		@closedir($current_dir); 

			
		$ifields = 0;
		foreach ( $query->list_fields() as $field ){
			//if( $ifields > 0)
				$colNames[] =  $field;
			
			$ifields++;	
		}

		$filename = 'filemanager/auto/'.number_format($now, 0, '.', '').'.xls';

		$wxsheet = '1';		

		$xls =& new Spreadsheet_Excel_Writer( $filename );
		
		$sheet = 'sheet'.$wxsheet;
		$$sheet = &$xls->addWorksheet("Page ".$wxsheet);
		
		
		$colHeadingFormat = &$xls->addFormat();
		$colHeadingFormat->setBold();
		$colHeadingFormat->setFontFamily('Arial');
		$colHeadingFormat->setSize('10');
		$colHeadingFormat->setColor(1);
		$colHeadingFormat->setFgColor(12);
		$colHeadingFormat->setAlign('center');
		$colHeadingFormat->setTextWrap();
	
		$$sheet->writeRow(0,0,$colNames,$colHeadingFormat);
		$$sheet->setColumn(0,50,10);				
		
		
		$rowformat =& $xls->addFormat();
		//$rowformat->setTextWrap();
		
		$i = 1;					
		foreach( $query->result() as $row ){
			$j = 0;  

			if(  ($i%20001) == 0 && ($i != 1) ){
			
				$wxsheet++;				
				$i = 1;

				$sheet = 'sheet'.$wxsheet;
				$$sheet = &$xls->addWorksheet("Page ".$wxsheet);
				
				$$sheet->writeRow(0,0,$colNames,$colHeadingFormat);
				$$sheet->setColumn(0,50,10);	
								
			}	
			
			foreach( $row as $value ){
		
				$$sheet->writestring( $i, $j, " ".$value." ", $rowformat );
				$j++;
			}

			$i++;
		}

		$xls->close();

		return  $filename;
	} 	
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */