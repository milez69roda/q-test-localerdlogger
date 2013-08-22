<?php

class Dashboard extends Controller {

	var $_userid = '';
	var $_roleid = '';
	var $_centerid = '';
	var $_center_syn = '';
	
	function __construct(){
	
		parent::Controller();	
		$this->ci =& get_instance();
		$this->load->library('DX_Auth');
		
		$this->_userid = $this->session->userdata('user_id' );
		$this->_roleid = $this->session->userdata('role_id' );
		$this->_centerid = $this->session->userdata('center_id' );
		$this->_center_syn =  $this->session->userdata('center_acronym' );
		
		$this->dx_auth->check_uri_permissions();
		parse_str( $_SERVER['REQUEST_URI'], $_GET );
		
		ini_set('memory_limit', -1);
		
	}
	
	function index(){
	
		$hdata["menu"] = 'dashboard';
		$data[] = '';
		
		//echo phpinfo();		
		
		$centerRes = $this->db->query("SELECT * FROM centers WHERE center_id = ".$this->_centerid)->result();		
		$data["centerinfo"] = $centerRes;
		
		$this->load->model("Erd","erd");	
		
		$data["reassignedRes"] = '';
		$where = array();
		
		if( $this->_roleid == 2 ){
			$where['user_id'] = $this->_userid;
			$where['centers.center_id'] = $this->_centerid;
			$where['reassigned'] = 1;
			$where['reassigned_flag'] = 0;			
		}
		
		if( $this->_roleid == 1){
			$where['supervisor_id'] = $this->_userid;
			$where['centers.center_id'] = $this->_centerid;
			$where['reassigned'] = 1;
			$where['reassigned_flag'] = 0;		
		}
		
		/* if( $this->_roleid == 5 or $this->_roleid == 6){
			$where['centers.center_id'] = $this->_centerid;		
			$where[' WEEK(date_updated) = '] = (int)date('W', strtotime(date('Y-m-d')));	
			$where['reassigned'] = 1;			
		} */
		
		/* if( $this->_roleid == 3 ){
		} */
		
		if( $this->_roleid == 2 or $this->_roleid == 1){
		
			$data["reassignedRes"] = $this->erd->getTransferredIssues($where)->result();
		
		}
		//echo $this->db->last_query();
		
		if( $this->_roleid != 4 and $this->_roleid != 3){
			$data["centerSummary"] = $this->erd->getCenterSummary($this->_centerid)->row();
			
		}
		
		$this->load->view('header', $hdata);
		$this->load->view('dashboard', $data);
		$this->load->view('footer');
	}
	
	function ilogs(){
		
		$hdata["menu"] = 'ilogs';
		$data[] = '';
		
		$this->load->view('header', $hdata);
		
		if( $this->_roleid == 2)
			$this->load->view('mylog', $data);
		elseif( $this->_roleid == 1 )
			$this->load->view('suplog', $data);
		else
			redirect(base_url().'dashboard/mylog'); 	
		
		
		$this->load->view('footer');		
	}
	
	
	function mylog(){
	
		$hdata["menu"] = 'mylog';
		
		$data[] = '';
		
		$this->load->view('header', $hdata);
	
	
		/* if( $this->_roleid == 2)
			$this->load->view('mylog', $data);
		elseif( $this->_roleid == 1 or $this->_roleid == 5 or $this->_roleid == 6)
			$this->load->view('suplog', $data);
		else
			$this->load->view('mylog', $data); */
		
		if( $this->_roleid == 3){
			redirect(base_url().'dashboard/enterprise'); 
		}else{
			$this->load->view('suplog', $data);
		}
		
		$this->load->view('footer');
	}
	
	function closed(){
	
		$hdata["menu"] = 'closed';
		
		$data[] = '';
		
		$this->load->view('header', $hdata);
		
		/* if( $this->_roleid == 2)
			$this->load->view('myClosedlog', $data);
		elseif( $this->_roleid == 1 or $this->_roleid == 5 or $this->_roleid == 6)
			$this->load->view('supClosedlog', $data);
		else
			$this->load->view('myClosedlog', $data); */
		
		$this->load->view('supClosedlog', $data);		
		
		$this->load->view('footer');	
	
	}
	
	
	function openlog(){
		ob_start();
		$hdata["menu"] = '';
		$data[] = '';		
		$id = $this->uri->segment(3);		
		
		$this->load->model("Erd","erd");
		
		$where['erdlogs.erd_id'] = $id;		
		$data['mylog'] = $this->erd->getMyLogs( '', '', $where, '')->row();
		
		if( $this->erd->isYourIssue( $id, $this->_roleid, $this->_userid, $data['mylog']->center_id ) ){
		
			//load models
			$this->load->model("Comments","comments");
			$this->load->model("Notes","notes");
			$this->load->model("Dropdown","dropdown");
			
			//set the status dropdown
			$rStatus = $this->dropdown->status_all('0')->result();
			$dStatus = array(''=>'---Select Status---');
			
			foreach( $rStatus as $row ){
				$dStatus[$row->status_id] = $row->status_desc;
			}
			$data['status_options'] = $dStatus;			
			
			//set the issue dropdown
			$rIssue = $this->dropdown->issue_all('0')->result();
			$dIssue = array(''=>'---Select Issue---');		
			foreach( $rIssue as $row ){
				$dIssue[$row->issue_desc] = $row->issue_desc;
			}		
			$dIssue['Other'] = "Other";		
			$data['issue_options'] = $dIssue;
			//$data['roleid'] = $this->_roleid;
			
			//set the channel/source dropdown
			$rSource = $this->dropdown->source_all('0')->result();
			$dSource = array(''=>'---Select Channel---');		
			foreach( $rSource as $row ){
				$dSource[$row->src_name] = $row->src_name;
			}				
			$data['source_options'] = $dSource;	
			
			//set the organization dropdown
			$rOrg = $this->dropdown->org_all('0')->result();
			$dOrg = array(''=>'---Select Organization---');		
			foreach( $rOrg as $row ){
				$dOrg[$row->org_name] = $row->org_name;
			}				
			$data['org_options'] = $dOrg;		
			
			//set the organization dropdown
			$rEsc = $this->dropdown->escalate_all('0')->result();
			$dEsc = array(''=>'---Select Department---');		
			foreach( $rEsc as $row ){
				$dEsc[$row->esc_name] = $row->esc_name;
			}				
			$data['esc_options'] = $dEsc;			
			
			
			$data['comments'] =  $this->comments->get_comments_by_erd_id($id)->result();
			$data['notes'] =  $this->notes->get_notes_by_erd_id($id)->result();
			
			
			$this->load->view('header', $hdata);
			$this->load->view('viewlog', $data);
			$this->load->view('footer');
			
		}else{
			redirect(base_url().'dashboard/mylog');
		}
		
	}
	
	function ajaxOpenAction(){
		$this->load->model("Erd","erd");
		$type = $this->input->post("actType");
		
		if( $type == "comment" ){		
		
			$result['status'] = false;			
			$result['msg'] = "Failed to transfer the issue, Please logout and login again";
			
			$up['comment_desc'] = $this->input->post('comments');
			$up['user_id']	 	= $this->_userid;	
			$up['erd_id'] 		= $this->input->post('xdtoken');	

			if( $this->db->insert('comments',$up) ){
			
				$result['status'] = true;
				$result['msg'] = "Comment Successfully Submitted";
				
				$eset['date_updated'] = date('Y-m-d H:i:s');	
				
				$this->db->where('erd_id', $this->input->post('xdtoken') );
				$this->db->update('erdlogs', $eset);
				
			}else{
				$result['status'] = false;
				$result['msg'] = "Failed to transfer the issue, Please logout and login again";
			}			
			echo json_encode($result);
		}
		
		
		if( $type == "transfer" ){
			
			$curUser = $this->session->userdata('lastname').', '.$this->session->userdata('firstname');
			
			$reassignedto 		= $this->input->post("efx_huid");
			$original_erd_id 	= $this->input->post("efx_hlid");			
			
			$query1 = "SELECT erdlogs.*, centers.center_acronym FROM erdlogs 
						LEFT OUTER JOIN users ON users.id = erdlogs.user_id
						LEFT OUTER JOIN centers ON centers.center_id = users.center_id
						WHERE erd_id=".$original_erd_id;
			
			$prevres = $this->db->query($query1)->row();
			
			//print_r($prevres);
			
			
			$new = array();
			$new['date_opened'] 	= $prevres->date_opened;
			$new['date_updated'] 	= date('Y-m-d H:i:s');
			$new['date_date_closed']= date('Y-m-d H:i:s');
			$new['cust_name'] 		= $prevres->cust_name;
			$new['user_id'] 		= $reassignedto;
			$new['erd_issue_desc'] 	= $prevres->erd_issue_desc;
			$new['status_id'] 		= 2;
			$new['imei'] 			= $prevres->imei;
			$new['erd_ipaddress'] 	= $_SERVER['REMOTE_ADDR'];
			$new['needcallback'] 	= $prevres->needcallback;
			$new['callback_date'] 	= $prevres->callback_date;
			$new['erd_note'] 		= $prevres->erd_note;
			$new['case_no'] 		= $prevres->case_no;
			$new['phone_no'] 		= $prevres->phone_no;
			$new['source'] 			= $prevres->source;
			$new['emailaddress'] 	= $prevres->emailaddress;
			$new['organization'] 	= $prevres->organization;
			$new['minno'] 			= $prevres->minno;		
			//$new['reference_id'] 	= $prevres->center_acronym.$original_erd_id;
								
			$new['escalatedto'] 	= $prevres->escalatedto;
			
			$new['callback_type'] 	= $prevres->callback_type;		
			

			
			$result['status'] = false;
			$result['link'] = base_url().'dashboard/openlog/'.$original_erd_id;
			$result['msg'] = "Failed to transfer the issue, Please logout and login again";
		
			if( $this->db->insert('erdlogs',$new) ){
				$reassigned_erd_id = $this->db->insert_id();
				
				//add comment to the new added and reassigned issue
				$com1["comment_desc"] 	= $this->input->post("comments3");
				$com1["user_id"]  		= $this->_userid;
				$com1["erd_id"]	  		= $reassigned_erd_id;	
				$this->db->insert('comments', $com1);
				
				//add comment to the original owner of the issue
				$transtxt = '<p style="color:red;"><strong><em>Issue was Reassigned to '.$this->input->post("efx_toid").' with the new Issue ID ('.$this->_center_syn.$reassigned_erd_id.')</em></strong></p>';
				$com2["comment_desc"] 	= $transtxt.$this->input->post("comments2");
				$com2["user_id"]  		= $this->_userid;
				$com2["erd_id"]	  		= $original_erd_id;				
				$this->db->insert('comments', $com2);
				
				//update the original issuestatus and some other fields.
				$upOrig["status_id"] 			=  3;
				$upOrig["reassigned"] 			=  1;
				$upOrig["reassignedto"] 		=  $reassignedto;
				$upOrig["reassigned_erd_id"] 	=  $reassigned_erd_id;
				$upOrig["reassigned_by"] 		=  $this->_userid;
				$upOrig["reassigned_datetime"] 	= date('Y-m-d H:i:s');
				$upOrig["date_updated"] 		= date('Y-m-d H:i:s');
				
				$this->db->where('erd_id', $original_erd_id);
				$this->db->update('erdlogs',$upOrig);
				
				$result['status'] = true;
				$result['msg'] = "Issue Re-assigned Successfully ";
			}else{
				$result['status'] = false;
				$result['msg'] = "Failed to transfer the issue, Please logout and login again";
			}
			
			echo json_encode($result);			
			
		}
		
		if( $type == "updatelog" ){
		
			//echo $this->_userid.' '.$this->input->post('huid');
			
			$result['status'] 	= false;
			$result['redirect'] = 'mylog';
			$result['msg'] 		= "Failed on Updating the issue, Please logout and login again";
			
			$userid 	= $this->input->post('huid');
			$acType 	= $this->_roleid;
			$id 		= $this->input->post('herd_id');	
			$centerid 	= $this->_centerid;
			$status_id = $this->input->post('dstatus'); 
			
			if( $this->erd->isYourIssue( $id, $acType, $userid, $centerid )  ){
			
				
				$needcallback = @$this->input->post('needcallback');
				
				if( $needcallback == 1 ){
					$post['needcallback'] 	= 1;				
					$tmp_date =  strtotime( $this->input->post('textcallbackdate') );	
					$post['callback_date'] 	= date('Y-m-d h:i:s', $tmp_date);
				}
				
				if( $this->input->post('cissue') == 'Other' ){
					$post['erd_issue_desc'] = $this->input->post('issueother');	
					$post['isother'] 		= 1;
				}else{
					$post['erd_issue_desc'] = $this->input->post('cissue');						
				}
				
				$curdate = 	date('Y-m-d H:i:s');	
				
				
				$post['status_id'] = $status_id;
				
				if( $status_id == 3 OR $status_id == 7 ){
					$post['date_closed'] 	= $curdate;	
					$result['redirect'] = 'closed';
				}
				
				$post['imei'] 			= $this->input->post('txtimei');					
				$post['cust_name']	 	= $this->input->post('txtcustname2');		
				//$post['erd_note'] 		= $this->input->post('txtnote');		
				//$post['date_opened'] 	= $curdate;
				$post['date_updated'] 	= $curdate;
				$post['erd_ipaddress'] 	= $_SERVER['REMOTE_ADDR'];
				
				$post['case_no'] 		= $this->input->post('txtcaseno');		
				$post['phone_no'] 		= $this->input->post('txtphoneno');		
				$post['source'] 		= $this->input->post('dchannel');		
				$post['emailaddress'] 	= $this->input->post('txtemailaddress');		
				$post['organization'] 	= $this->input->post('dorg');		
				$post['minno'] 			= $this->input->post('txtmin');		
				//$post['reference_id'] 	= $this->input->post('textrefno');					
				$post['escalatedto'] 	= $this->input->post('descalated');		
				
				$post['erd_issuesub_desc'] 	= $this->input->post('cissue_sub');		
				
				if( isset($_POST["callback_type"]) ){
					$post['callback_type'] 	= $this->input->post('callback_type');		
				}				
				
				$this->db->where('erd_id', $id);
				
				if( $this->db->update('erdlogs', $post) ){
					$result['status'] 	= true;
					$result['msg'] 		= "Update Successfully!";

					//if( $acType == 1 OR $acType == 5 OR $acType == 3 ){
						
						//$setcom['comment_desc'] = '<p style="color:red;"><strong>Updated by: '.$this->session->userdata('lastname' ).', '.$this->session->userdata('firstname' ).'</strong></p>';
						$setcom['comment_desc'] = '<p style="color:red;"><strong>UPDATED</strong></p>';
						$setcom['user_id'] = $this->_userid;
						$setcom['erd_id'] = $id;
						
						$this->db->insert('comments', $setcom);
						
					//}
					
					if( trim($this->input->post("txtnote")) != '' ){
						$note['erd_id'] 	= $id;
						$note['note_text'] 	= $this->input->post("txtnote");
						$note['user_id'] 	= $this->_userid;
						
						$this->db->insert('notes',$note);
					}
				}			
			
			}
			echo json_encode($result);
		}	
		
		if( $type == "addnote" ){
			
			$result['status'] 	= false;
			$result['redirect'] = 'mylog';
			
			$note['erd_id'] 	= $this->input->post("ntd_hid");
			$note['note_text'] 	= $this->input->post("note");
			$note['user_id'] 	= $this->_userid;
			
			if( $this->db->insert('notes', $note) ){
				$result['status'] = true;
			}
			
			echo json_encode($result);
			
		}
		
	}
	
	function ajaxHomeAction(){
		
		$this->load->model("Erd","erd");
			
		$userid 	= $this->_userid;
		$acType 	= $this->_roleid;
		$id 		= $this->input->post('ttoken');	
		$centerid 	= $this->_centerid;
			
		$result['status'] 	= false;
		$result['msg'] 		= "Failed";
		$result['token'] 	= "";
		
		if( $this->erd->isYourIssue( $id, $acType, $userid, $centerid )  ){
		
			$ups['reassigned_flag'] = 1;			
			$this->db->where("erd_id", $id);			
			if( $this->db->update("erdlogs", $ups) ){
				$result['status'] 	= true;
				$result['msg'] 		= "Success";
				$result['token'] 	= "htr_".$id;				
			}
		}		
		echo json_encode($result);
	}
	
	function updatelog(){
		
		ob_start();
		
		$hdata["menu"] = 'mylog';
		$data[] = '';		
		$id = $this->uri->segment(3);
		
		if( $id == '' ){
			redirect(base_url().'dashboard/mylog');
		}
		
		if( $this->_roleid == 6 ){		
			redirect(base_url().'dashboard/openlog/'.$id);
		}
	
		$this->load->model("Erd","erd");
		
		$where['erdlogs.erd_id'] = $id;		
		$data['mylog'] = $this->erd->getMyLogs( '', '', $where, '')->row();	
		
		//echo $this->_userid.'-'.$data['mylog']->user_id;

		
		//load models
		$this->load->model("Dropdown","dropdown");
		$this->load->model("Notes","notes");
		
		//set the status dropdown
		$rStatus = $this->dropdown->status_all('0')->result();
		$dStatus = array(''=>'---Select Status---');
		
		foreach( $rStatus as $row ){
			$dStatus[$row->status_id] = $row->status_desc;
		}
		$data['status_options'] = $dStatus;			
		
		//set the issue dropdown
		$rIssue = $this->dropdown->issue_all('0')->result();
		$dIssue = array(''=>'---Select Issue---');		
		foreach( $rIssue as $row ){
			$dIssue[$row->issue_id] = $row->issue_desc;
		}		
		$dIssue['Other'] = "Other";		
		$data['issue_options'] = $dIssue;
		
		
		$data['issuesub_option']  = $this->dropdown->issuesub_by_desc($data['mylog']->erd_issuesub_desc);
		
		//set the channel/source dropdown
		$rSource = $this->dropdown->source_all('0')->result();
		$dSource = array(''=>'---Select Channel---');		
		foreach( $rSource as $row ){
			$dSource[$row->src_name] = $row->src_name;
		}				
		$data['source_options'] = $dSource;	
		
		//set the organization dropdown
		$rOrg = $this->dropdown->org_all('0')->result();
		$dOrg = array(''=>'---Select Organization---');		
		foreach( $rOrg as $row ){
			$dOrg[$row->org_name] = $row->org_name;
		}				
		$data['org_options'] = $dOrg;		
		
		//set the organization dropdown
		$rEsc = $this->dropdown->escalate_all('0')->result();
		$dEsc = array(''=>'---Select Department---');		
		foreach( $rEsc as $row ){
			$dEsc[$row->esc_name] = $row->esc_name;
		}				
		$data['esc_options'] = $dEsc;			
		
		$data['notes'] =  $this->notes->get_notes_by_erd_id($id)->result();
		
		
		
		$this->load->view('header', $hdata);
		$this->load->view('updatelog', $data);
		$this->load->view('footer');
		
	}
	
	function viewLog(){
	
		ob_start();
		$hdata["menu"] = '';
		$data[] = '';		
		$id = $this->uri->segment(3);		
		
		if( trim($id) == '' ){
			redirect(base_url().'dashboard/mylog');
		}
		
		$this->load->model("Erd","erd");
		$this->load->model("Comments","comments");

		
		$where['erdlogs.erd_id'] = $id;		
		$data['mylog'] = $this->erd->getMyLogs( '', '', $where, '')->row();

		
		//$data['comments'] =  $this->comments->get_comments_by_id($id)->result();
		$data['comments'] =  $this->comments->get_comments_by_erd_id($id)->result();
		$data['notes'] =  $this->notes->get_notes_by_erd_id($id)->result();		
		
		$this->load->view('header', $hdata);
		$this->load->view('viewLog_view_by_all', $data);
		$this->load->view('footer');
		
	}
	
	
	function ajaxmylogs(){
		
		$this->load->model("Erd","erd");
		$this->load->model("Comments","comments");
		
		$filters = json_decode( stripslashes(@$_GET["filters"]) );
		
		$req_param = array (
			"sort_by" => $_GET["sidx"],
			"sort_direction" => $_GET["sord"],
			"page" => $_GET["page"],
			"num_rows" => $_GET["rows"],
			"search" => $_GET["_search"],
			"search_field" => @$_GET["searchField"],
			"search_operator" => @$_GET["searchOper"],
			"search_str" => @$_GET["searchString"],					
			"filters" => $filters					
		);	
		
		//if( $this->_roleid ) 
		$where['erdlogs.user_id'] = $this->_userid;
		$where['needcallback'] = false;
		//$where["( erdlogs.status_id OR "] = 2;
		//$where["erdlogs.status_id"] = '3 )';
		
		//$strwhere = ' (erdlogs.status_id = 1 OR  erdlogs.status_id = 2 ) ';
		$strwhere = ' erdlogs.status_id <> 3 ';
		
		//$where['needcallback'] = 0;
		
		$response->page 	= $_GET["page"];
		//$response->records 	= $this->erd->getMyLogs($req_param,"all", $where, $strwhere)->num_rows();
		$response->records 	= $this->erd->getMyLogs($req_param,"all", $where, $strwhere)->row()->numrows;
		$response->total 	= ceil($response->records/$_GET["rows"] );
		$records 			= $this->erd->getMyLogs($req_param, "", $where, $strwhere)->result_array();
		//echo $this->db->last_query();
		
		$i=0;
		foreach($records as $row) { 

			$noofcomments = $this->comments->get_num_comments_by_id($row['erd_id'])->num_rows();
			
			$response->rows[$i]['id']=$row['erd_id']; 
			$response->rows[$i]['cell']=array(  '',
												$noofcomments,
												$row['center_acronym'].$row['erd_id'],												
												$row['status_desc'],
												$row['imei'],
												$row['phone_no'],
												$row['cust_name'],
												$row['case_no'],
												$row['erd_issue_desc'],	
												$row['minno'],									
												$row['source'],									
												$row['organization'],									
												$row['emailaddress'],													
												$row['date_opened'],
												$row['date_updated'],
												$row['date_closed'],												
												($row['needcallback'] == 1)?'Yes':'No',
												$row['callback_date'],
												$row['escalatedto']/* ,
												$row['erd_note'],
												$row['comments'] */												
												); 
			$i++;
		} 
		echo json_encode($response);		
	}	
	
	function ajaxsupmylogs(){
		
		$this->load->model("Erd","erd");
		$this->load->model("dx_auth/Users","users");
		$this->load->model("Comments","comments");
		
		$filters = json_decode( stripslashes(@$_GET["filters"]) );
		
		$req_param = array (
				"sort_by" => $_GET["sidx"],
				"sort_direction" => $_GET["sord"],
				"page" => $_GET["page"],
				"num_rows" => $_GET["rows"],
				"search" => $_GET["_search"],
				"search_field" => @$_GET["searchField"],
				"search_operator" => @$_GET["searchOper"],
				"search_str" => @$_GET["searchString"],					
				"filters" => $filters					
		);	
		
		$strwhere = '';
		$where = array();
		//if( $this->_roleid ) 
		//$where['supervisor_id'] = $this->_userid;
		
		//if( !isset($_GET["issummary"]) ){
		
			if( $this->_roleid ==  1){
				
				if( $_GET['own'] == 0 ){
					$where["supervisor_id"] = $this->_userid;
				}
				$where["centers.center_id"] = $this->_centerid;
				$where['needcallback'] = false;	
			}	
			
			if( $this->_roleid ==  2){
				//$where["supervisor_id"] = $this->_userid;
				$where["centers.center_id"] = $this->_centerid;
				$where['needcallback'] = false;	
			}			
			
			
			if( $this->_roleid ==  5){
				$where["centers.center_id"] = $this->_centerid;
				$where['needcallback'] = false;	
			}
			
			if( $this->_roleid ==  6){
				$where["centers.center_id"] = $this->_centerid;
				$where['needcallback'] = false;	
			}
		/* }else{
			
			print_r($_GET);
			
			$strwhere = " DATE_FORMAT(date_updated, '%Y-%m-%d') BETWEEN '".$_GET["from"]."' AND '".$_GET["to"]."' AND ";
			$where['needcallback'] = $_GET["center"];
		} */
			
		//$where['needcallback'] = 0;
		
		//$strwhere = ' (erdlogs.status_id = 1 OR  erdlogs.status_id = 2 ) ';
		
		
		$xdfrom = ( $_GET["xdfrom"] != '' )?$_GET["xdfrom"]:date("Y-m-d");
		$xdto = ( $_GET["xdto"] != '' )?$_GET["xdto"]:date("Y-m-d");
		$strwhere .= " DATE_FORMAT(date_updated,'%Y-%m-%d' ) BETWEEN '$xdfrom' AND '$xdto' ";
		
		$strwhere .= ' AND erdlogs.status_id <> 8 ';
		
		$response->page 	= $_GET["page"];
		//$response->records 	= $this->erd->getMyLogs($req_param,"all", $where, $strwhere)->num_rows();
		$response->records 	= $this->erd->getMyLogs($req_param,"all", $where, $strwhere)->row()->numrows;
		//echo $this->db->last_query();
		
		$response->total 	= ceil($response->records/$_GET["rows"] );
		$records 			= $this->erd->getMyLogs($req_param, "", $where, $strwhere)->result_array();
		
		
		$i=0;
		foreach($records as $row) { 
			
			$supname = $this->users->get_user_by_id($row['supervisor_id'])->row();
			$noofcomments = $this->comments->get_num_comments_by_id($row['erd_id'])->num_rows();
			
			$response->rows[$i]['id']=$row['erd_id']; 
			$response->rows[$i]['cell']=array(  '',
												$noofcomments,
												$row['center_acronym'].$row['erd_id'],
												$row['status_desc'],	
												@$supname->lname.', '.@$supname->fname,
												$row["lname"].", ".$row["fname"],
												$row['avaya'],												
												$row['imei'],												
												$row['phone_no'],
												$row['cust_name'],
												$row['case_no'],
												$row['erd_issue_desc'],	
												$row['erd_issuesub_desc'],	
												$row['minno'],									
												$row['source'],									
												$row['organization'],									
												$row['emailaddress'],													
												$row['date_opened'],
												$row['date_updated'],
												$row['date_closed'],												
												($row['needcallback'] == 1)?'Yes':'No',
												$row['callback_date'],
												$row['escalatedto']/* ,
												$row['erd_note'],
												$row['comments'] */
												); 
			$i++;
		} 
		echo json_encode($response);		
	}
	
	
	function ajaxsupSummaryDetails(){
		
		$this->load->model("Erd","erd");
		$this->load->model("dx_auth/Users","users");
		$this->load->model("Comments","comments");
		
		$filters = json_decode( stripslashes(@$_GET["filters"]) );
		
		$req_param = array (
				"sort_by" => $_GET["sidx"],
				"sort_direction" => $_GET["sord"],
				"page" => $_GET["page"],
				"num_rows" => $_GET["rows"],
				"search" => $_GET["_search"],
				"search_field" => @$_GET["searchField"],
				"search_operator" => @$_GET["searchOper"],
				"search_str" => @$_GET["searchString"],					
				"filters" => $filters					
		);	
		
		$strwhere = '';
		$where = array();
	
		/* closed
		active
		pending
		unable
		callbacks		
		lessthan
		morethan */
		
		$sum_var = $_GET["sumvar"];
		$center_id = $_GET["center"];
		$from = $_GET["from"];
		$to = $_GET["to"];
		
		switch( $sum_var ){
		
			case 'closed':
				$where['erdlogs.status_id'] = 3;	
				$where['centers.center_id'] = $center_id;
				$where["DATE_FORMAT(date_updated, '%Y-%m-%d') BETWEEN '{$from}' AND"] = "$to";
				break;
			case 'active':
				$where['centers.center_id'] = $center_id;
				$where["DATE_FORMAT(date_updated, '%Y-%m-%d') BETWEEN '{$from}' AND"] = "$to";
				$strwhere .= ' erdlogs.status_id <> 3 ';				
				break;			
			case 'pending':
				$where['centers.center_id'] = $center_id;
				$where["DATE_FORMAT(date_updated, '%Y-%m-%d') BETWEEN '{$from}' AND"] = "$to";
				$strwhere .= ' erdlogs.status_id = 2';				
				break;			
			case 'unable':
				$where['erdlogs.status_id'] = 7;	
				$where["DATE_FORMAT(date_updated, '%Y-%m-%d') BETWEEN '{$from}' AND"] = "$to";
				$where['centers.center_id'] = $center_id;
				break;			
			case 'callbacks':
				$where['needcallback'] = 1;	
				$strwhere .= ' erdlogs.status_id = 2 AND  erdlogs.status_id = 7  ';
				$where["DATE_FORMAT(date_updated, '%Y-%m-%d') BETWEEN '{$from}' AND"] = "$to";
				$where['centers.center_id'] = $center_id;
				break;			
			case 'lessthan':
				$where['centers.center_id'] = $center_id;
				$where["DATE_FORMAT(date_updated, '%Y-%m-%d') BETWEEN '{$from}' AND"] = "$to";
				$strwhere .= ' erdlogs.status_id <> 3 ';
				$strwhere .= ' AND (EXTRACT( DAY_HOUR FROM TIMEDIFF(NOW(), date_updated) ) <= 24) ';				
				break;			
			case 'morethan':
				$where['centers.center_id'] = $center_id;
				$where["DATE_FORMAT(date_updated, '%Y-%m-%d') BETWEEN '{$from}' AND"] = "$to";
				$strwhere .= ' erdlogs.status_id <> 3 ';
				$strwhere .= ' AND (EXTRACT( DAY_HOUR FROM TIMEDIFF(NOW(), date_updated) ) > 24) ';				
				break;
			
		}
		
		
			
		//$where['needcallback'] = 0;
		
		//$strwhere = ' (erdlogs.status_id = 1 OR  erdlogs.status_id = 2 ) ';
		//$strwhere .= ' erdlogs.status_id <> 3 ';
		
		$response->page 	= $_GET["page"];
		//$response->records 	= $this->erd->getMyLogs($req_param,"all", $where, $strwhere)->num_rows();
		$response->records 	= $this->erd->getMyLogs($req_param,"all", $where, $strwhere)->row()->numrows;
		//echo $this->db->last_query();
		
		$response->total 	= ceil($response->records/$_GET["rows"] );
		$records 			= $this->erd->getMyLogs($req_param, "", $where, $strwhere)->result_array();
		
		
		$i=0;
		foreach($records as $row) { 
			
			$supname = $this->users->get_user_by_id($row['supervisor_id'])->row();
			$noofcomments = $this->comments->get_num_comments_by_id($row['erd_id'])->num_rows();
			
			$response->rows[$i]['id']=$row['erd_id']; 
			$response->rows[$i]['cell']=array(  '',
												$noofcomments,
												$row['center_acronym'].$row['erd_id'],
												$row['status_desc'],	
												@$supname->lname.', '.@$supname->fname,
												$row["lname"].", ".$row["fname"],
												$row['avaya'],												
												$row['imei'],												
												$row['phone_no'],
												$row['cust_name'],
												$row['case_no'],
												$row['erd_issue_desc'],	
												$row['erd_issuesub_desc'],	
												$row['minno'],									
												$row['source'],									
												$row['organization'],									
												$row['emailaddress'],													
												$row['date_opened'],
												$row['date_updated'],
												$row['date_closed'],												
												($row['needcallback'] == 1)?'Yes':'No',
												$row['callback_date'],
												$row['escalatedto']/* ,
												$row['erd_note'],
												$row['comments'] */
												); 
			$i++;
		} 
		echo json_encode($response);		
	}	
	
	
	function ajaxclosedlogs(){
		
		$this->load->model("Erd","erd");
		$this->load->model("Comments","comments");
		
		$filters = json_decode( stripslashes(@$_GET["filters"]) );
		
		$req_param = array (
				"sort_by" => $_GET["sidx"],
				"sort_direction" => $_GET["sord"],
				"page" => $_GET["page"],
				"num_rows" => $_GET["rows"],
				"search" => $_GET["_search"],
				"search_field" => @$_GET["searchField"],
				"search_operator" => @$_GET["searchOper"],
				"search_str" => @$_GET["searchString"],					
				"filters" => $filters					
		);	
		
		//if( $this->_roleid ) 
		$where['erdlogs.user_id'] = $this->_userid;
		//$where["( erdlogs.status_id OR "] = 2;
		//$where["erdlogs.status_id"] = '3 )';
		
		//$strwhere = ' ( erdlogs.status_id = 3 OR  erdlogs.status_id = 7 ) ';
		$strwhere = ' erdlogs.status_id = 3 ';
		
		//$where['needcallback'] = 0;
		
		$response->page 	= $_GET["page"];
		//$response->records 	= $this->erd->getMyLogs($req_param,"all", $where, $strwhere)->num_rows();
		$response->records 	= $this->erd->getMyLogs($req_param,"all", $where, $strwhere)->row()->numrows;
		$response->total 	= ceil($response->records/$_GET["rows"] );
		$records 			= $this->erd->getMyLogs($req_param, "", $where, $strwhere)->result_array();
		//echo $this->db->last_query();
		
		$i=0;
		foreach($records as $row) { 
			
			$noofcomments = $this->comments->get_num_comments_by_id($row['erd_id'])->num_rows();
			
			$response->rows[$i]['id']=$row['erd_id']; 
			$response->rows[$i]['cell']=array(  '',
												$noofcomments,
												$row['center_acronym'].$row['erd_id'],
												$row['status_desc'],
												$row['imei'],
												$row['phone_no'],
												$row['cust_name'],
												$row['case_no'],
												$row['erd_issue_desc'],	
												$row['minno'],									
												$row['source'],									
												$row['organization'],									
												$row['emailaddress'],													
												$row['date_opened'],
												$row['date_updated'],
												$row['date_closed'],												
												($row['needcallback'] == 1)?'Yes':'No',
												$row['callback_date'],
												$row['escalatedto'],
												$row['reassigned']
												/* ,
												$row['erd_note'],
												$row['comments'] */												
												); 
			$i++;
		} 
		echo json_encode($response);		
	}	

	function ajaxsupclosedlogs(){
		
		$this->load->model("Erd","erd");
		$this->load->model("dx_auth/Users","users");
		$this->load->model("Comments","comments");
		
		$filters = json_decode( stripslashes(@$_GET["filters"]) );
		
		$req_param = array (
				"sort_by" => $_GET["sidx"],
				"sort_direction" => $_GET["sord"],
				"page" => $_GET["page"],
				"num_rows" => $_GET["rows"],
				"search" => $_GET["_search"],
				"search_field" => @$_GET["searchField"],
				"search_operator" => @$_GET["searchOper"],
				"search_str" => @$_GET["searchString"],					
				"filters" => $filters					
		);	
		
		//if( $this->_roleid ) 
		//$where['supervisor_id'] = $this->_userid;
		
		if( $this->_roleid ==  1){
			//$where["supervisor_id"] = $this->_userid;
			$where["centers.center_id"] = $this->_centerid;			
		}
		
		if( $this->_roleid ==  2){
			$where["centers.center_id"] = $this->_centerid;
		}		
		
		if( $this->_roleid ==  5){
			$where["centers.center_id"] = $this->_centerid;
		}	

		if( $this->_roleid ==  6){
			$where["centers.center_id"] = $this->_centerid;
		}	
		
		//$where['needcallback'] = 0;
		
		//$strwhere = ' (erdlogs.status_id = 3 OR  erdlogs.status_id = 7 ) ';
		$strwhere = ' erdlogs.status_id = 8 ';
		
		$response->page 	= $_GET["page"];
		$response->records 	= $this->erd->getMyLogs($req_param,"all", $where, $strwhere)->row()->numrows;
		//echo $this->db->last_query();
		
		$response->total 	= ceil($response->records/$_GET["rows"] );
		$records 			= $this->erd->getMyLogs($req_param, "", $where, $strwhere)->result_array();
		
		
		$i=0;
		foreach($records as $row) { 
					
			$supname = $this->users->get_user_by_id($row['supervisor_id'])->row();
			$noofcomments = $this->comments->get_num_comments_by_id($row['erd_id'])->num_rows();
			
			$response->rows[$i]['id']=$row['erd_id']; 
			$response->rows[$i]['cell']=array(  '',	
												$noofcomments,
												$row['center_acronym'].$row['erd_id'],
												$row['status_desc'],												
												$supname->lname.', '.$supname->fname,												
												$row["lname"].", ".$row["fname"],
												$row['avaya'],												
												$row['imei'],												
												$row['phone_no'],
												$row['cust_name'],
												$row['case_no'],
												$row['erd_issue_desc'],	
												$row['erd_issuesub_desc'],	
												$row['minno'],									
												$row['source'],									
												$row['organization'],									
												$row['emailaddress'],													
												$row['date_opened'],
												$row['date_updated'],
												$row['date_closed'],												
												($row['needcallback'] == 1)?'Yes':'No',
												$row['callback_date'],
												$row['escalatedto'],
												$row['reassigned']
												/* ,
												$row['erd_note'],
												$row['comments'] */
												); 
			$i++;
		} 
		echo json_encode($response);		
	}	
	
	function ajaxExportAction(){
	
		
		
		$this->load->model("Erd","erd");
		$this->load->model("dx_auth/Users","users");
		
		$filters = json_decode( stripslashes(@$_GET["filters"]) );
		
		$req_param = array (
				"sort_by" => $_GET["sidx"],
				"sort_direction" => $_GET["sord"],
				//"page" => $_GET["page"],
				"num_rows" => $_GET["rows"],
				"search" => $_GET["_search"],
				"search_field" => @$_GET["searchField"],
				"search_operator" => @$_GET["searchOper"],
				"search_str" => @$_GET["searchString"],					
				"filters" => $filters					
		);	
		
		$tabType = $_GET['tablType'];
		
		$where = '';
		
		$xdfrom = ( $_GET["xdfrom"] != '' )?$_GET["xdfrom"]:date("Y-m-d");
		$xdto = ( $_GET["xdto"] != '' )?$_GET["xdto"]:date("Y-m-d");
		$strwhere .= " DATE_FORMAT(date_updated,'%Y-%m-%d' ) BETWEEN '$xdfrom' AND '$xdto' AND ";		
		
		if( $this->_roleid ==  1){
			$where["centers.center_id"] = $this->_centerid;			
		}
		
		if( $this->_roleid ==  5){
			$where["centers.center_id"] = $this->_centerid;
		}	

		if( $this->_roleid ==  6){
			$where["centers.center_id"] = $this->_centerid;
		}	
		
		if( $tabType == 'callback' ){
			$where['needcallback'] = true;
			//$strwhere = ' (erdlogs.status_id = 1 OR  erdlogs.status_id = 2 ) ';
			//$strwhere = ' erdlogs.status_id <> 3';
			$strwhere .= ' erdlogs.status_id <> 8';
		}
		
		if( $tabType == 'myissue' ){
			$where['needcallback'] = false;
			//$strwhere = ' (erdlogs.status_id = 1 OR  erdlogs.status_id = 2 ) ';
			//$strwhere = ' erdlogs.status_id <> 3';
			$strwhere .= ' erdlogs.status_id <> 8';
			
		}
		
		if( $tabType == 'closed'  ){
			$strwhere .= ' erdlogs.status_id = 3 ';
		}
		
		
		$records 	= $this->erd->getMyLogsExport($req_param,"all", $where, $strwhere)->result();	
		//echo $this->db->last_query();
		/* $filename 	= $this->erd->excelwriter_factory1($records); 
		
		
		//echo $filename;		
		$return['filepath'] = $filename;
		
		$xp 	 = explode("/",$filename);
		$return['filename'] = $xp[2];
		
		echo json_encode($return);		 */
		
		
		$this->load->library('ExportDataExcel'); 
		
					 
		$excel = new ExportDataExcel('browser');
		$excel->filename = strtotime('now').".xls";

		$header = array('Issue ID', 'Status', 'Representative', 'Avaya', 'IMEI', 'Contact No', 'Customer Name', 'Interaction/Case No', 'Issue Type', 'Issue Description', 'MIN','channel','Brand','Email Address','Date Opened','Date Updated','Date Closed','Callback Date/Time','Escalated', 'Notes' ); 
		$excel->initialize();
		$excel->addRow($header);
		foreach($records as $row) {
			$excel->addRow($row);
		}
		$excel->finalize();	
	
	}
	
	function ajaxExportActionEnterprise(){
	
		$this->load->model("Erd","erd");
		
		$filters = json_decode( stripslashes(@$_GET["filters"]) );
		
		$req_param = array (
				"sort_by" => $_GET["sidx"],
				"sort_direction" => $_GET["sord"],
				//"page" => $_GET["page"],
				"num_rows" => $_GET["rows"],
				"search" => $_GET["_search"],
				"search_field" => @$_GET["searchField"],
				"search_operator" => @$_GET["searchOper"],
				"search_str" => @$_GET["searchString"],					
				"filters" => $filters					
		);	
		
		//$where['user_id'] = $this->_userid;
		//$where['needcallback'] = 0;
		$where = array();
		$strwhere = "";
		
		$xdfrom = date("Y-m-d") ;
		$xdto = date("Y-m-d") ;
		
		
		if( isset($_GET["xdfrom"]) && $_GET["xdfrom"] != '' ){
			$xdfrom = $_GET["xdfrom"];
		}
		if( isset($_GET["xdto"]) && $_GET["xdto"] != '' ){
			$xdto = $_GET["xdto"];
		}
		
		$strwhere = " DATE_FORMAT(date_updated,'%Y-%m-%d' ) BETWEEN '$xdfrom' AND '$xdto' ";
		
		$records 	= $this->erd->getMyLogsExportEnterprise($req_param,"all", $where, $strwhere);			
		//$records 	= $this->erd->getMyLogsExportEnterprise($req_param,"all", $where, '');	
		//echo $this->db->last_query();
		$filename 	= $this->erd->excelwriter_factory1($records); 
		
		
		//echo $filename;		
		$return['filepath'] = $filename;
		
		$xp 	 = explode("/",$filename);
		$return['filename'] = $xp[2];
		
		echo json_encode($return);	
	}
	
/* 	function ajaxtransfersave(){
		
		$curUser = $this->session->userdata('lastname').', '.$this->session->userdata('firstname');
		
		$query1 = "SELECT erdlogs.*, centers.center_acronym FROM erdlogs 
					LEFT OUTER JOIN users ON users.id = erdlogs.user_id
					LEFT OUTER JOIN centers ON centers.center_id = users.center_id
					WHERE erd_id=".$this->input->post('efx_huid');
		
		$prevres = $this->db->query($query1)->row();
		
		//print_r($prevres);
		
		$new = array();
		$new['date_opened'] 	= $prevres->date_opened;
		$new['date_updated'] 	= date('Y-m-d H:i:s');
		$new['cust_name'] 		= $prevres->cust_name;
		$new['user_id'] 		= $this->input->post('efx_huid');
		$new['erd_issue_desc'] 	= $prevres->erd_issue_desc;
		$new['status_id'] 		= $prevres->status_id;
		$new['imei'] 			= $prevres->imei;
		$new['erd_ipaddress'] 	= $_SERVER['REMOTE_ADDR'];
		$new['needcallback'] 	= $prevres->needcallback;
		$new['callback_date'] 	= $prevres->callback_date;
		$new['erd_note'] 		= $prevres->erd_note;
		$new['case_no'] 		= $prevres->case_no;
		$new['phone_no'] 		= $prevres->phone_no;
		$new['source'] 			= $prevres->source;
		$new['emailaddress'] 	= $prevres->emailaddress;
		$new['organization'] 	= $prevres->organization;
		$new['minno'] 			= $prevres->minno;		
		$new['reference_id'] 	= $prevres->center_acronym.$this->input->post('efx_huid');
				
		//$new['comments'] 		= '<span><p><strong>'.$curUser.':</strong></p><p>'.$_POST['efx_tocomments2'].'</p></span>';
		
		$new['escalatedto'] 	= $prevres->escalatedto;
		
		$result['status'] = true;
		$result['link'] = base_url().'dashboard/openlog/'.$this->input->post("efx_huid");
		$result['msg'] = "Failed to transfer the issue, Please logout and login back";
	
		if( $this->db->insert('erdlogs',$new) ){
		
			$com1["comment_desc"] 	= $this->input->post("comments2");
			$com1["user_id"]  		= $this->_userid;
			$com1["erd_id"]	  		= $this->db->insert_id;	
			$this->db->insert('comments', $com1);
			
			$com2["comment_desc"] 	= $this->input->post("comments3");
			$com2["user_id"]  		= $this->_userid;
			$com2["erd_id"]	  		= $this->input->post("efx_huid");				
			$this->db->insert('comments', $com2);
			
			$result['status'] = true;
			$result['msg'] = "Issue successfully transfered";
		}else{
			$result['status'] = false;
			$result['msg'] = "Failed to transfer the issue, Please logout and login back";
		}
		
		echo json_encode($result);
	} */
	
	function ajaxmysqlogsaction(){
	
		$oper = $this->input->post("oper");
		$id = $this->input->post("id");
		if( $oper == 'edit' ){
			
			$status_id = $this->input->post("status_id");
			
			$post['status_id'] 	= $status_id;
			$post['imei']		= $this->input->post("imei");;
			$post['cust_name'] 	= $this->input->post("cust_name");;
			$post['erd_note'] 	= $this->input->post("erd_note");
			
			
			//if the status is closed
			if($status_id == 3){
				$post['date_closed'] = date('Y-m-d H:i:s');
			}
			
			//if it needs a callback
			if( $this->input->post("needcallback") == "Yes"){
				$post['needcallback'] = 1;
				$post['callback_date'] = $this->input->post("callback_date");
			}
			
			if( $this->input->post("needcallback") == "No"){
				$post['needcallback'] = 0;
				$post['callback_date'] = "0000-00-00 00:00:00";
			}
			
			$post['date_updated'] = date('Y-m-d H:i:s');
			
			$this->db->where("erd_id", $id);
			$this->db->update("erdlogs",$post);			
		}
		
		if( $oper == 'del'){
		
			$post['erd_deleted'] = 1;
			$post['erd_del_date'] = date('Y-m-d H:i:s');
			
			$this->db->where("erd_id", $id);
			$this->db->update("erdlogs",$post);
		}
		
	
	}
	

	function ajaxSuplogsaction(){
	
		$oper = $this->input->post("oper");
		$id = $this->input->post("id");
		if( $oper == 'edit' ){
			$curUser = $this->session->userdata('lastname').', '.$this->session->userdata('firstname');
			
			$prvQuery = $this->db->query("select * from erdlogs where erd_id=".$id)->row();
			
			$update['comments'] 	= $prvQuery->comments.'</br><span><p><strong>'.$curUser.':</strong></p><p>'.$this->input->post('comments').'</p></span>';
			$update['comment_by'] 	= $this->_userid;
			$update['comment_date'] = date("Y-m-d H:i:s");
			
			$this->db->where("erd_id", $id);
			$this->db->update('erdlogs',$update);
			
		}
	}		
	
	function getstatusdropdown(){
		
		$this->load->model("Dropdown", 'dropdown');
		
		$res = $this->dropdown->status_all('0')->result();
		
		$options = '<option value=""> --- select --- </option>';
		/* foreach( $res as $row){
			$options .= '<option value="'.$row->status_id.'">'.$row->status_desc.'</option>';			
		} */
		
		//$options .= '<option value="1">New</option>';	
		$options .= '<option value="2">Pending</option>';	
		$options .= '<option value="7">Unable to reach</option>';	
		$options .= '<option value="3">Closed</option>';	
		
		echo '<select>'.$options.'</select>';
	}	
	
	function getstatusdropdown1(){
		
		$this->load->model("Dropdown", 'dropdown');
		
		$res = $this->dropdown->status_all('0')->result();
		
		$options = '<option value=""> --- select --- </option>';
		foreach( $res as $row){
			$options .= '<option value="'.$row->status_id.'">'.$row->status_desc.'</option>';			
		}
		
		
		echo '<select>'.$options.'</select>';
	}	
	
	function getstatusdropdown2(){
		
		$this->load->model("Dropdown", 'dropdown');
		
		$res = $this->dropdown->status_all('0')->result();
		
		$options = '<option value=""> --- select --- </option>';
		/* foreach( $res as $row){
			$options .= '<option value="'.$row->status_id.'">'.$row->status_desc.'</option>';			
		} */
		
		$options .= '<option value="8">Completed</option>';	
		//$options .= '<option value="7">Unable to Reach</option>';	
		
		echo '<select>'.$options.'</select>';
	}	
	
	function getissuedropdown(){
		
		$this->load->model("Dropdown", 'dropdown');
		
		$res = $this->dropdown->issue_all('0')->result();
		
		$options = '<option value=""> --- select --- </option>';
		foreach( $res as $row){
			$options .= '<option value="'.$row->issue_desc.'">'.$row->issue_desc.'</option>';			
		}
		
		$options .= '<option value="allmiami"> All miami issues</option>';			
		$options .= '<option value="allcarecenter"> All care center issues</option>';	
		
		echo '<select>'.$options.'</select>';
	}
	
	function getissuesubdropdown(){
		
		$this->load->model("Dropdown", 'dropdown');
		
		$res = $this->dropdown->issuesub_all('0')->result();
		
		$options = '<option value=""> --- select --- </option>';
		foreach( $res as $row){
			$options .= '<option value="'.$row->issuesub_desc.'">'.$row->issuesub_desc.'</option>';			
		}
		echo '<select>'.$options.'</select>';
	}
	

	
	
	function getcenterdropdown(){
		
		$this->load->model("Dropdown", 'dropdown');
		
		$res = $this->dropdown->center_all('0')->result();
		
		$options = '<option value=""> --- select --- </option>';
		foreach( $res as $row){
			$options .= '<option value="'.$row->center_id.'">'.$row->center_desc.'</option>';			
		}
		echo '<select>'.$options.'</select>';
	}	
	
	function getDeptdropdown(){
		
		$this->load->model("Dropdown", 'dropdown');
		
		$res = $this->dropdown->department_all('0')->result();
		
		$options = '<option value=""> --- select --- </option>';
		foreach( $res as $row){
			$options .= '<option value="'.$row->dept_id.'">'.$row->dept_desc.'</option>';			
		}
		echo '<select>'.$options.'</select>';
	}
	
	function getSourceDropdown(){
		
		$this->load->model("Dropdown", 'dropdown');
		
		$res = $this->dropdown->source_all('0')->result();
		
		$options = '<option value=""> --- select --- </option>';
		foreach( $res as $row){
			$options .= '<option value="'.$row->src_name.'">'.$row->src_name.'</option>';			
		}
		echo '<select>'.$options.'</select>';
	}	
	
	function getOrgDropdown(){
		
		$this->load->model("Dropdown", 'dropdown');
		
		$res = $this->dropdown->org_all('0')->result();
		
		$options = '<option value=""> --- select --- </option>';
		foreach( $res as $row){
			$options .= '<option value="'.$row->org_name.'">'.$row->org_name.'</option>';			
		}
		echo '<select>'.$options.'</select>';
	}	
	
	function getEscalatedDropdown(){
		
		$this->load->model("Dropdown", 'dropdown');
		
		$res = $this->dropdown->escalate_all('0')->result();
		
		$options = '<option value=""> --- select --- </option>';
		foreach( $res as $row){
			$options .= '<option value="'.$row->esc_name.'">'.$row->esc_name.'</option>';			
		}
		echo '<select>'.$options.'</select>';
	}	
	
	function getAccessDropdown1(){
		
		$this->load->model("Dropdown", 'dropdown');
		
		$res = $this->dropdown->access_all1('0')->result();
		
		$options = '<option value=""> --- select --- </option>';
		foreach( $res as $row){
			$options .= '<option value="'.$row->id.'">'.$row->name.'</option>';			
		}
		echo '<select>'.$options.'</select>';
	
	}
	
	function getSupervisorDropdown(){
	
		$this->load->model("dx_auth/Users", 'users');
		
		if( $this->_roleid == 3 ){
		
			$sel = $this->uri->segment(3);
			
			if( $sel != '' ){
				$res = $this->users->get_user_by_center_all_supervisor($sel)->result();
			}else{
				//$res = $this->users->get_user_by_center_all_supervisor('all')->result();
				$res = array();
			}
			
		}else{
			$res = $this->users->get_user_by_center_all_supervisor($this->_centerid)->result();
		}
		
		
		$options = '<option value=""> --- select --- </option>';
		foreach( $res as $row){
			$options .= '<option value="'.$row->id.'">'.$row->lname.', '.$row->fname.'</option>';			
		}
		echo '<select>'.$options.'</select>';	
	
	}
	
	function getSupervisorDropdown1(){
	
		$this->load->model("dx_auth/Users", 'users');
		
		$sel = $this->input->post('center');
		
		if( $sel != '' ){
			$res = $this->users->get_user_by_center_all_supervisor($sel)->result();
		}else{
			$res = $this->users->get_user_by_center_all_supervisor('all')->result();
		}	
		
		$options = '<option value=""> --- select --- </option>';
		foreach( $res as $row){
			$options .= '<option value="'.$row->id.'">'.$row->lname.', '.$row->fname.'</option>';			
		}
		echo $options;	
		
	}
	
	function getUsers(){
		
		
		$searchtxt = strtolower($_GET["searchtxt"]);
		
		$this->db->select("id as 'uid', fname, lname");
		$this->db->where('center_id', $this->_centerid);
		$this->db->where('banned', 0);		
		$this->db->where('role_id <> ', 4, false);		
		$this->db->where('role_id <> ', 3, false);		
		$this->db->where("(lower(fname) LIKE '%$searchtxt%' OR lower(lname) LIKE '%$searchtxt%')", null, false);	
		
		/*$this->db->like('lower(fname)', "$searchtxt", false);
		$this->db->or_like('lower(lname)', "$searchtxt", false); */
		$res = $this->db->get('users');
		
		$users = $res->result_array();
		
		//echo $this->db->last_query();
		
		echo json_encode($users);
		
	}
	
	
	function newlog(){
		
		if( $this->input->post('btnSubmit') == "Submit Log" ){
		
			$post['user_id'] 		= $this->_userid;	
			
			
			$needcallback = @$this->input->post('needcallback');
			
			if( $needcallback == 1 ){
				$post['needcallback'] 	= 1;				
				$tmp_date =  strtotime( $this->input->post('textcallbackdate') );	
				$post['callback_date'] 	= date('Y-m-d h:i:s', $tmp_date);
			}
			
			if( $this->input->post('cissue') == 'Other' ){
				$post['erd_issue_desc'] = $this->input->post('issueother');	
				$post['isother'] 		= 1;
			}else{
				$post['erd_issue_desc'] = $this->input->post('cissue');						
			}
			
			$post['erd_issue_desc'] = $this->input->post('cissue');		
			$post['erd_issuesub_desc'] = $this->input->post('cissue_sub');		
			$curdate = 	date('Y-m-d H:i:s');	
			
			$post['status_id'] 		= $this->input->post('dstatus');	
			$post['imei'] 			= $this->input->post('txtimei');
				
			$post['cust_name']	 	= $this->input->post('txtcustname1').' '.$this->input->post('txtcustname2');		
			$post['erd_note'] 		= $this->input->post('txtnote');		
			$post['date_opened'] 	= $curdate;
			$post['date_updated'] 	= $curdate;
			$post['erd_ipaddress'] 	= $_SERVER['REMOTE_ADDR'];
			
			$post['case_no'] 		= $this->input->post('txtcaseno');		
			$post['phone_no'] 		= $this->input->post('txtphoneno');		
			$post['source'] 		= $this->input->post('dchannel');		
			$post['emailaddress'] 	= $this->input->post('txtemailaddress');		
			$post['organization'] 	= $this->input->post('dorg');		
			$post['minno'] 			= $this->input->post('txtmin');		
			$post['reference_id'] 	= $this->input->post('textrefno');	
			
			$post['escalatedto'] 	= $this->input->post('descalated');		
			
			if( isset($_POST["callback_type"]) ){
				$post['callback_type'] 	= $this->input->post('callback_type');		
			}
			
			//print_r($post);
			if( $this->db->insert('erdlogs', $post) ){
				redirect(base_url().'dashboard/mylog');
			}
			

		}
		//load models
		$this->load->model("Dropdown","dropdown");
		
		//set the status dropdown
		$rStatus = $this->dropdown->status_all('0')->result();
		$dStatus = array(''=>'---Select Status---');
		
		foreach( $rStatus as $row ){
			$dStatus[$row->status_id] = $row->status_desc;
		}
		$data['status_options'] = $dStatus;			
		
		//set the issue dropdown
		$rIssue = $this->dropdown->issue_all('0')->result();
		//$dIssue = array(''=>'---Select Issue---');		
		/* $dIssue = "";		
		foreach( $rIssue as $row ){
			$dIssue[$row->issue_id] = $row->issue_desc;
		}	 */	
		//$dIssue['Other'] = "Other";		
		$data['issue_options'] = $rIssue;
		//$data['issuesub_options'] = "";
		//$data['roleid'] = $this->_roleid;
		
		//set the channel/source dropdown
		$rSource = $this->dropdown->source_all('0')->result();
		$dSource = array(''=>'---Select Channel---');		
		foreach( $rSource as $row ){
			$dSource[$row->src_name] = $row->src_name;
		}				
		$data['source_options'] = $dSource;	
		
		//set the organization dropdown
		$rOrg = $this->dropdown->org_all('0')->result();
		$dOrg = array(''=>'---Select Organization---');		
		foreach( $rOrg as $row ){
			$dOrg[$row->org_name] = $row->org_name;
		}				
		$data['org_options'] = $dOrg;		
		
		//set the organization dropdown
		$rEsc = $this->dropdown->escalate_all('0')->result();
		$dEsc = array(''=>'---Select Department---');		
		foreach( $rEsc as $row ){
			$dEsc[$row->esc_name] = $row->esc_name;
		}				
		$data['esc_options'] = $dEsc;		
		
		
		$hdata["menu"] = 'new';
		
		$this->load->view('header', $hdata);
		$this->load->view('new',$data);
		$this->load->view('footer');	
	}
	
	function ajaxcheckemei(){
	
		//load models
		$this->load->model("Erd", 'erd');
		
		$uri = '';
		foreach($_GET as $k=>$v){
			//echo $k.'='.$v.'<br>';
			
			if( $k != '/localerdlogger/dashboard/ajaxcheckemei/tr' ){
				$uri[$k]= $v;
			}
		}
		$uri['centers.center_id'] = $this->_centerid;
		
		//if( count($_GET) > 1 ){
		
			//$data['imei_title'] = $imei; 
			$data["relResults"] = $this->erd->getLogs_by_imei($uri)->result();
			
			$this->load->view('imei_related_issues',$data);
		//}
			
	}
	
	function callback(){
		$hdata["menu"] = 'callback';
		$data = '';
		
		$this->load->view('header', $hdata);
		
		//$this->load->view('callbacks1');
		
		/* if( $this->_roleid == 2)
			$this->load->view('callbacks1', $data);
		elseif( $this->_roleid == 1 or $this->_roleid == 5 or $this->_roleid == 6)
			$this->load->view('supcallbacks1', $data);
		else		
			$this->load->view('callbacks1', $data); */
			
		
		if( $this->_roleid == 3)
			$this->load->view('enterprise_callbacks1', $data);
		else		
			$this->load->view('supcallbacks1', $data);
			
		
		
		$this->load->view('footer');	
	}
	
	function icallback(){
		$hdata["menu"] = 'icallback';
		$data = '';
		
		$this->load->view('header', $hdata);
	
	
		if( $this->_roleid == 2)
			$this->load->view('callbacks1', $data);
		elseif( $this->_roleid == 1 )
			$this->load->view('supcallbacks1', $data);
		else
			redirect(base_url().'dashboard/mylog'); 	
		
		
		$this->load->view('footer');	
	}
	
	function ajaxcallbacks(){
		
		$this->load->model("Erd","erd");
		$this->load->model("Comments","comments");
		
		$filters = json_decode( stripslashes(@$_GET["filters"]) );
		
		$req_param = array (
				"sort_by" => $_GET["sidx"],
				"sort_direction" => $_GET["sord"],
				"page" => $_GET["page"],
				"num_rows" => $_GET["rows"],
				"search" => $_GET["_search"],
				"search_field" => @$_GET["searchField"],
				"search_operator" => @$_GET["searchOper"],
				"search_str" => @$_GET["searchString"],					
				"filters" => $filters					
		);	
		
		$where['erdlogs.user_id'] = $this->_userid;
		$where['needcallback'] = 1;		
		//$strwhere = ' (erdlogs.status_id = 1 OR  erdlogs.status_id = 2 ) ';
		$strwhere = ' erdlogs.status_id <> 3';
		
		$response->page 	= $_GET["page"];
		//$response->records 	= $this->erd->getMyLogs($req_param,"all", $where, $strwhere)->num_rows();
		$response->records 	= $this->erd->getMyLogs($req_param,"all", $where, $strwhere)->row()->numrows;
		$response->total 	= ceil($response->records/$_GET["rows"] );
		$records 			= $this->erd->getMyLogs($req_param, "", $where, $strwhere)->result_array();
		
		
		$i=0;
		foreach($records as $row) { 
			
			$noofcomments = $this->comments->get_num_comments_by_id($row['erd_id'])->num_rows();			
						
			$response->rows[$i]['id']=$row['erd_id']; 
			$response->rows[$i]['cell']=array(  '',
												$noofcomments,
												$row['center_acronym'].$row['erd_id'],
												$row['status_desc'],
												$row['imei'],
												$row['phone_no'],
												$row['cust_name'],
												$row['case_no'],
												$row['erd_issue_desc'],	
												($row['needcallback'] == 1)?'Yes':'No',
												$row['callback_date'],
												$row['minno'],									
												$row['source'],									
												$row['organization'],									
												$row['emailaddress'],													
												$row['erd_note']
												); 
			$i++;
		} 
		echo json_encode($response);		
	}

	function ajaxsupcallbacks(){
		
		$this->load->model("Erd","erd");
		$this->load->model("dx_auth/Users","users");
		$this->load->model("Comments","comments");
		
		$filters = json_decode( stripslashes(@$_GET["filters"]) );
		
		$req_param = array (
				"sort_by" => $_GET["sidx"],
				"sort_direction" => $_GET["sord"],
				"page" => $_GET["page"],
				"num_rows" => $_GET["rows"],
				"search" => $_GET["_search"],
				"search_field" => @$_GET["searchField"],
				"search_operator" => @$_GET["searchOper"],
				"search_str" => @$_GET["searchString"],					
				"filters" => $filters					
		);	
		
		//$where['user_id'] = $this->_userid;
		
		if( $this->_roleid ==  1){
			
			if( $_GET['own'] == 0 ){
				$where["supervisor_id"] = $this->_userid;
			}
			
		}
		
		$where["centers.center_id"] = $this->_centerid;		
		$where['needcallback'] = 1;		
		
		//$strwhere = ' (erdlogs.status_id = 1 OR  erdlogs.status_id = 2 ) ';
		$xdfrom = ( $_GET["xdfrom"] != '' )?$_GET["xdfrom"]:date("Y-m-d");
		$xdto = ( $_GET["xdto"] != '' )?$_GET["xdto"]:date("Y-m-d");
		$strwhere = " DATE_FORMAT(date_updated,'%Y-%m-%d' ) BETWEEN '$xdfrom' AND '$xdto' ";
		
		$strwhere .= ' AND erdlogs.status_id <> 8 ';
		
		$response->page 	= $_GET["page"];
		//$response->records 	= $this->erd->getMyLogs($req_param,"all", $where, $strwhere)->num_rows();
		$response->records 	= $this->erd->getMyLogs($req_param,"all", $where, $strwhere)->row()->numrows;
		//echo $this->db->last_query();
		$response->total 	= ceil($response->records/$_GET["rows"] );
		$records 			= $this->erd->getMyLogs($req_param, "", $where, $strwhere)->result_array();
		
		
		$i=0;
		foreach($records as $row) { 
			
			$supname = $this->users->get_user_by_id($row['supervisor_id'])->row();
			$noofcomments = $this->comments->get_num_comments_by_id($row['erd_id'])->num_rows();	
			
			$response->rows[$i]['id']=$row['erd_id']; 
			$response->rows[$i]['cell']=array(  '',
												$noofcomments,
												$row['center_acronym'].$row['erd_id'],
												$row['status_desc'],
												@$supname->lname.', '.@$supname->fname,
												$row["lname"].", ".$row["fname"],
												$row['avaya'],
												$row['imei'],
												$row['phone_no'],
												$row['cust_name'],
												$row['case_no'],
												$row['erd_issue_desc'],	
												$row['erd_issuesub_desc'],	
												($row['needcallback'] == 1)?'Yes':'No',
												$row['callback_date'],
												$row['minno'],									
												$row['source'],									
												$row['organization'],									
												$row['emailaddress'],													
												$row['escalatedto'],													
												$row['erd_note'],
												$row['comments']
												); 
			$i++;
		} 
		echo json_encode($response);		
	}
	
	function ajaxenterprisecallbacks(){
		
		$this->load->model("Erd","erd");
		$this->load->model("dx_auth/Users","users");
		$this->load->model("Comments","comments");
		
		$filters = json_decode( stripslashes(@$_GET["filters"]) );
		
		$req_param = array (
				"sort_by" => $_GET["sidx"],
				"sort_direction" => $_GET["sord"],
				"page" => $_GET["page"],
				"num_rows" => $_GET["rows"],
				"search" => $_GET["_search"],
				"search_field" => @$_GET["searchField"],
				"search_operator" => @$_GET["searchOper"],
				"search_str" => @$_GET["searchString"],					
				"filters" => $filters					
		);	
		
		//$where['user_id'] = $this->_userid;
		
		 
		//$where["centers.center_id"] = $this->_centerid;		
		$where['needcallback'] = 1;		
		
		//$strwhere = ' (erdlogs.status_id = 1 OR  erdlogs.status_id = 2 ) ';
		$strwhere = ' erdlogs.status_id <> 3 ';
		
		$response->page 	= $_GET["page"];
		//$response->records 	= $this->erd->getMyLogs($req_param,"all", $where, $strwhere)->num_rows();
		$response->records 	= $this->erd->getMyLogs($req_param,"all", $where, $strwhere)->row()->numrows;
		//echo $this->db->last_query();
		$response->total 	= ceil($response->records/$_GET["rows"] );
		$records 			= $this->erd->getMyLogs($req_param, "", $where, $strwhere)->result_array();
		
		
		$i=0;
		foreach($records as $row) { 
			
			$supname = $this->users->get_user_by_id($row['supervisor_id'])->row();
			$noofcomments = $this->comments->get_num_comments_by_id($row['erd_id'])->num_rows();
			
			$response->rows[$i]['id']=$row['erd_id']; 
			$response->rows[$i]['cell']=array(  '',
												$noofcomments,
												$row['center_acronym'].$row['erd_id'],
												$row['status_desc'],
												$row['callback_date'],
												$row['center_desc'],
												@$supname->lname.', '.@$supname->fname,
												$row["lname"].", ".$row["fname"],
												$row['avaya'],
												$row['imei'],
												$row['phone_no'],
												$row['cust_name'],
												$row['case_no'],
												$row['erd_issue_desc'],	
												$row['erd_issuesub_desc'],	
												($row['needcallback'] == 1)?'Yes':'No',												
												$row['minno'],									
												$row['source'],									
												$row['organization'],									
												$row['emailaddress'],													
												$row['escalatedto'],													
												$row['erd_note'],
												$row['comments']
												); 
			$i++;
		} 
		echo json_encode($response);		
	}

	
	function ajaxgetLogInfo(){
		
		//$data = '';
		//$this->load->view('transfer_form', $data);
		
		$issueid = $this->input->post('token');
		
		$this->db->select(' erdlogs.*, drp_status.status_desc, users.*, centers.center_desc, ,centers.center_acronym, drp_department.dept_desc', false);
		$this->db->join('drp_status', 'drp_status.status_id = erdlogs.status_id', 'left outer');
		$this->db->join('users', 'users.id = erdlogs.user_id', 'left outer');
		$this->db->join('centers', 'centers.center_id = users.center_id', 'left outer');
		$this->db->join('drp_department', 'drp_department.dept_id = users.dept_id', 'left outer');		
		$this->db->where('erd_deleted', 0);
		$this->db->where('erd_id', $issueid);
		
		$logs = $this->db->get('erdlogs')->result_array();
		
		//$result['record'] = $logs[0];
		
		echo json_encode($logs[0]);
	}
	
	
	function enterprise(){
		$hdata["menu"] = 'enterpriseviewlog';
		
		$data[] = '';
		
		$this->load->view('header', $hdata);
		$this->load->view('enterpriseLogview', $data);
		$this->load->view('footer');
	}
	
	function ajaxenterpriseviewlog(){
		
		$this->load->model("Erd","erd");
		$this->load->model("dx_auth/Users","users");
		$this->load->model("Comments","comments");
		
		$filters = json_decode( stripslashes(@$_GET["filters"]) );
		
		$req_param = array (
				"sort_by" => $_GET["sidx"],
				"sort_direction" => $_GET["sord"],
				"page" => $_GET["page"],
				"num_rows" => $_GET["rows"],
				"search" => $_GET["_search"],
				"search_field" => @$_GET["searchField"],
				"search_operator" => @$_GET["searchOper"],
				"search_str" => @$_GET["searchString"],					
				"filters" => $filters					
		);	
		
		//$where['user_id'] = $this->_userid;
		//$where['needcallback'] = 0;
		
		$where = array();

		$xdfrom = ( $_GET["xdfrom"] != '' )?$_GET["xdfrom"]:date("Y-m-d");
		$xdto = ( $_GET["xdto"] != '' )?$_GET["xdto"]:date("Y-m-d");
		$strwhere = " DATE_FORMAT(date_updated,'%Y-%m-%d' ) BETWEEN '$xdfrom' AND '$xdto' ";

		
		$response->page 	= $_GET["page"];
		//$response->records 	= $this->erd->getMyLogs($req_param,"all", $where, '')->num_rows();
		$response->records 	= $this->erd->getMyLogs($req_param,"all", $where, $strwhere)->row()->numrows;
		
		//echo $this->db->last_query();
		$response->total 	= ceil($response->records/$_GET["rows"] );
		$records 			= $this->erd->getMyLogs($req_param, "", $where, $strwhere)->result_array();
		
		
		$i=0;
		foreach($records as $row) { 
			
			$supname = $this->users->get_user_by_id($row['supervisor_id'])->row();
			$noofcomments = $this->comments->get_num_comments_by_id($row['erd_id'])->num_rows();
			
			$response->rows[$i]['id']=$row['erd_id']; 
			$response->rows[$i]['cell']=array( '',
												'<a href="javascript:popCom('.$row['erd_id'].')" >'.$noofcomments.'</a>',
												$row['center_acronym'].$row['erd_id'],
												$row['center_desc'],
												@$supname->lname.', '.@$supname->fname,
												$row["lname"].", ".$row["fname"],
												$row['avaya'],
												$row['status_desc'],
												$row['imei'],
												$row['phone_no'],
												$row['cust_name'],
												$row['case_no'],
												$row['erd_issue_desc'],	
												$row['erd_issuesub_desc'],	
												$row['minno'],									
												$row['source'],									
												$row['organization'],									
												$row['emailaddress'],													
												$row['date_opened'],
												$row['date_updated'],
												$row['date_closed'],												
												($row['needcallback'] == 1)?'Yes':'No',
												$row['callback_date']/* 
												$row['erd_note'],
												$row['comments'] */
												); 
			$i++;
		} 
		
		
		
		
		echo json_encode($response);		
	}
	
	function ajaxgetReps(){
		
		$name = $_GET['term'];
		//$fname = $_GET['name1'];
		
		if( $this->_roleid == 1){
			$this->db->where('center_id', $this->_centerid);
			$this->db->where('supervisor_id', $this->_userid);			
		}
		
		$this->db->like('lower(fname)', strtolower($name));
		$this->db->or_like('lower(lname)', strtolower($name));
		$result = $this->db->get('users')->result();
		
		//echo $this->db->last_query();
		
		$return = array();
		
		foreach( $result as $row ){
			$return[]  = $row->lname.','.$row->fname;
		}
		echo json_encode($return);
	}
	
	function summary(){
		
		$hdata["menu"] = 'summary';
		
		$data[] = '';
		
		$this->load->view('header', $hdata);
		$this->load->view('summary', $data);
		$this->load->view('footer');		
		
	}
	
	function centersummary(){
		$this->load->model("Erd","erd");
		$data= "";
		$table = "";
		$from = trim($_GET["from"]);
		//$from = '2011-01-21';
		$to   = trim($_GET["to"]);
		//$to   = '2011-01-21';
		
		//if( strtotime($from);
		
		if( ($from != '') OR ( $to != '') ){
		
		
			$this->erd->from = $from;
			$this->erd->to = $to;
			
				
			$summaryActive = array();
			$summaryCallback = array();
			$summaryAge= array();
			
			$resActive = $this->erd->getCenterSummary_active()->result();	
			
			//echo $this->db->last_query();
				
			$resCallback = $this->erd->getCenterSummary_activeCallback()->result();					
			//$resAge = $this->erd->getCenterSummary_age()->result();	
			
			foreach( $resActive as $row){
				//$summary[$row->center_id] = array("new"=>$row->new,"pending"=>$row->pending,"closed"=>$row->closed,"unable"=>$row->unable);
				$summaryActive[$row->center_id] = array("pending"=>$row->pending,"closed"=>$row->closed,"more"=>$row->more,"less"=>$row->less);
			}			
			
			foreach( $resCallback  as $row){				
				$summaryCallback[$row->center_id] = array("pending"=>$row->pending,"closed"=>$row->closed,"unable"=>$row->unable,"more"=>$row->more,"less"=>$row->less);
			}
			
			/* foreach( $resAge  as $row){				
				$summaryAge[$row->center_id] = array("num"=>$row->num,"age"=>$row->age);
			} */
			
			$centers = $this->db->query("SELECT * FROM centers WHERE center_disabled = 0")->result();
			
			$tr = "";
			//$total = array('GrandTotalClosedCalls'=>0,'apending'=>0,'aunable'=>0,'totalCenterActive'=>0,'acpending'=>0,'acunable'=>0,'totalCenterActiveCallback'=>0,'totalActive'=>0);
			$total = array('GrandTotalClosedCalls'=>0,
							'GrandtotalActive'=>0,
							'GrandTotalPending'=>0,
							'GrandTotalUnableToReach'=>0,
							'GrandTotalCallbackCalls'=>0,
							//'GrandTotalCallbacksUnableToReach'=>0,
							'GrandTotalNoCallsLessThanHours'=>0,
							'GrandTotalNoCallsMoreThanHours'=>0);				
			//$totalCenterActive = 0;
			//$totalCenterActiveCallback = 0;
			
			foreach( $centers as $row){
			
				$this->erd->centerid = $row->center_id;
				
				//$totalCenterActive = 0;

				$apending 	= @(($summaryActive[$row->center_id]['pending'] == 0)?'0':$summaryActive[$row->center_id]['pending']);				
				$aclosed 	= @(($summaryActive[$row->center_id]['closed'] == 0)?'0':$summaryActive[$row->center_id]['closed']);
				
				$amore 		= @(($summaryActive[$row->center_id]['more'] == 0)?'0':$summaryActive[$row->center_id]['more']);
				$aless 		= @(($summaryActive[$row->center_id]['less'] == 0)?'0':$summaryActive[$row->center_id]['less']);
				
				
				$acpending 	= @(($summaryCallback[$row->center_id]['pending'] == 0)?'0':$summaryCallback[$row->center_id]['pending']);
				$acunable 	= @(($summaryCallback[$row->center_id]['unable'] == 0)?'0':$summaryCallback[$row->center_id]['unable']);
				$acclosed 	= @(($summaryCallback[$row->center_id]['closed'] == 0)?'0':$summaryCallback[$row->center_id]['closed']);				
				
				$acmore 	= @(($summaryCallback[$row->center_id]['more'] == 0)?'0':$summaryCallback[$row->center_id]['more']);				
				$acless 	= @(($summaryCallback[$row->center_id]['less'] == 0)?'0':$summaryCallback[$row->center_id]['less']);				
								
				//$num 		= @(($summaryAge[$row->center_id]['num'] == 0)?'0':$summaryAge[$row->center_id]['num']);
				//$age 		= @(($summaryAge[$row->center_id]['age'] == 0)?'0':$summaryAge[$row->center_id]['age']);				
			
				
				$totalClosedCalls = ($aclosed+$acclosed);
				$total['GrandTotalClosedCalls'] += $totalClosedCalls;
				
				$totalActive	= ($apending + $acpending + $acunable);
				$total['GrandtotalActive'] += $totalActive;
				
				$totalPending = $apending + $acpending;				
				$total['GrandTotalPending'] += $totalPending;				
				
				$totalUnableToReach 	= $acunable;
				$total['GrandTotalUnableToReach'] 	+= $totalUnableToReach;
				
				$totalCallbackCalls 	= ($acpending+$acunable);
				$total['GrandTotalCallbackCalls'] 	+= $totalCallbackCalls;
				
				//$callsWaitingCallbacks = $acpending;				
				//$total['GrandTotalCallsWaitingCallbacks'] += $callsWaitingCallbacks;

				$noCallsMoreThanHours = ($amore + $acmore);
				$total["GrandTotalNoCallsLessThanHours"] += $noCallsMoreThanHours;
				
				$noCallsLessThanHours = ($aless + $acless);
				$total["GrandTotalNoCallsMoreThanHours"] += $noCallsLessThanHours;
				
						
				/* closed
				active
				pending
				unable
				callbacks		
				lessthan
				morethan */				
							
				//window.open("Sample.htm",null,"height=200,width=400,status=yes,toolbar=no,menubar=no,location=no");
			/* 
				$tr .= '<tr>
					<td>'.$row->center_desc.'</td>				
					<td class="td-right"><a href="'.base_url().'dashboard/oldlogdetails/?trck=1&from='.$from.'&to='.$to.'&center='.$row->center_id.'&sumvar=closed">'.number_format($totalClosedCalls).'</a></td>
					<td class="td-right"><a href="'.base_url().'dashboard/oldlogdetails/?trck=1&from='.$from.'&to='.$to.'&center='.$row->center_id.'&sumvar=active" target="_blank">'.number_format($totalActive).'</a></td>
					<td class="td-right"><a href="'.base_url().'dashboard/oldlogdetails/?trck=1&from='.$from.'&to='.$to.'&center='.$row->center_id.'&sumvar=pending" target="_blank">'.number_format($totalPending).'</a></td>
					<td class="td-right"><a href="'.base_url().'dashboard/oldlogdetails/?trck=1&from='.$from.'&to='.$to.'&center='.$row->center_id.'&sumvar=unable" target="_blank">'.number_format($totalUnableToReach).'</a></td>					
					<td class="td-right"><a href="'.base_url().'dashboard/oldlogdetails/?trck=1&from='.$from.'&to='.$to.'&center='.$row->center_id.'&sumvar=callbacks" target="_blank">'.number_format($totalCallbackCalls).'</td>
					<td class="td-right"><a href="'.base_url().'dashboard/oldlogdetails/?trck=1&from='.$from.'&to='.$to.'&center='.$row->center_id.'&sumvar=morethan" target="_blank">'.number_format($noCallsLessThanHours).'</td>
					<td class="td-right"><a href="'.base_url().'dashboard/oldlogdetails/?trck=1&from='.$from.'&to='.$to.'&center='.$row->center_id.'&sumvar=lessthan" target="_blank">'.number_format($noCallsMoreThanHours).'</td>					
				</tr>';	 */
				 //\''.base_url().'dashboard/oldlogdetails/?trck=1&from='.$from.'&to='.$to.'&center='.$row->center_id.'&sumvar=closed\')
				//$mlink = base_url().'dashboard/oldlogdetails/?trck=1&from='.$from.'&to='.$to.'&center='.$row->center_id;
				//<td class="td-right"><span onclick="openit(\''.$mlink.'&sumvar=closed\')">'.number_format($totalClosedCalls).'</span></td>		
				$tr .= '<tr>
					<td>'.$row->center_desc.'</td>				
					<td class="td-right"><a href="'.base_url().'dashboard/oldlogdetails/?trck=1&from='.$from.'&to='.$to.'&center='.$row->center_id.'&sumvar=closed" target="_blank">'.number_format($totalClosedCalls).'</a></td>
					<td class="td-right"><a href="'.base_url().'dashboard/oldlogdetails/?trck=1&from='.$from.'&to='.$to.'&center='.$row->center_id.'&sumvar=active" target="_blank">'.number_format($totalActive).'</a></td>
					<td class="td-right"><a href="'.base_url().'dashboard/oldlogdetails/?trck=1&from='.$from.'&to='.$to.'&center='.$row->center_id.'&sumvar=pending" target="_blank">'.number_format($totalPending).'</a></td>
					<td class="td-right"><a href="'.base_url().'dashboard/oldlogdetails/?trck=1&from='.$from.'&to='.$to.'&center='.$row->center_id.'&sumvar=unable" target="_blank">'.number_format($totalUnableToReach).'</a></td>					
					<td class="td-right"><a href="'.base_url().'dashboard/oldlogdetails/?trck=1&from='.$from.'&to='.$to.'&center='.$row->center_id.'&sumvar=callbacks" target="_blank">'.number_format($totalCallbackCalls).'</td>
					<td class="td-right"><a href="'.base_url().'dashboard/oldlogdetails/?trck=1&from='.$from.'&to='.$to.'&center='.$row->center_id.'&sumvar=morethan" target="_blank">'.number_format($noCallsLessThanHours).'</td>
					<td class="td-right"><a href="'.base_url().'dashboard/oldlogdetails/?trck=1&from='.$from.'&to='.$to.'&center='.$row->center_id.'&sumvar=lessthan" target="_blank">'.number_format($noCallsMoreThanHours).'</td>					
				</tr>';			
			} 
			
			//dashboard/oldlogdetails/?trck=1&from=2011-03-01&to=2011-07-11&center=4&sumvar=pending
			$trTotal = "<tr style=\"text-align:right\">
					<td>&nbsp;</td>
					<td class=\"td-red-bold\">".number_format($total["GrandTotalClosedCalls"])."</td>
					<td class=\"td-red-bold\">".number_format($total["GrandtotalActive"])."</td>
					<td class=\"td-red-bold\">".number_format($total["GrandTotalPending"])."</td>
					<td class=\"td-red-bold\">".number_format($total["GrandTotalUnableToReach"])."</td>
					<td class=\"td-red-bold\">".number_format($total["GrandTotalCallbackCalls"])."</td>					
					<td class=\"td-red-bold\">".number_format($total["GrandTotalNoCallsLessThanHours"])."</td>
					<td class=\"td-red-bold\">".number_format($total["GrandTotalNoCallsMoreThanHours"])."</td>					
				</tr>";
			
					
			//$table = '<table cellpadding="0" cellspacing="0" class="tablesorter" id="myTable"><thead><tr><th width="154">Center</th><th width="55">New</th><th width="56">Pending</th><th width="69">Closed</th><th width="69">Unable to Reach</th><th width="67">Callback</th></tr></thead>'."<tbody>".$tr.$trTotal."</tbody>".'</table>';
			$table = '<table cellpadding="0" cellspacing="0" class="tablesorter" id="myTable" name="myTable">
					 <thead>
						<tr>
							<th>Centers</th>
							<th>Total Closed</th>
							<th>Total Active</th>
							<th>Pending</th>
							<th>Unable To Reach</th>
							<th>Callbacks</th>							
							<th>Follow-Up</th>
							<th>Courtesy Call</th>
						</tr>
					</thead>'.
					"<tbody>".$tr.$trTotal."</tbody>".
					'<tr style="text-align:left">
					  <td colspan="9">
						
					  </td>
					</tr>'.
					'</table>';
			
			$data["table"] = trim($table);
		} 
		
		$return = array();
		
		if( $_GET['st'] == 0 ){
					
			//echo $this->load->view('summary_center', $data, false);
			/* 
			$return['html'] = $this->load->view('summary_center', $data, false);
			$return['status'] = true; */
			
			echo $this->load->view('summary_center', $data, true);			
		}
		
		if( $_GET['st'] == 1 ){
			//echo $table	;
			$return['html'] = $table;
			$return['status'] = true;
			
			//echo json_encode($return);
			echo $table;
		}
		
		
	}
	function statussummary(){
		$data= "";
		$table = "";
		$from = date('Y-m-d',strtotime($_GET["from"]));
		//$from = '2011-01-01';
		//$to   = trim($_GET["to"]);
		$to   = date('Y-m-d',strtotime($_GET["to"]));
		
		//echo $from.' '.$to;
		
		$summary = array();
		
		//get centers
		$this->db->where("center_disabled", 0);
		$centerRes = $this->db->get("centers")->result();
		//echo $this->db->last_query();
		$selectParse1 = '';	
		$centerColID = array();	
		$centerColDesc = array();	
		
		foreach( $centerRes as $rows){
			
			$temp2 = strtolower(str_replace(' ', '_', $rows->center_desc ));
			
			$selectParse1 .= " SUM( IF(users.center_id = ".$rows->center_id.",1,0) ) AS '".$temp2."', ";
			$centerColID[$rows->center_id] 	= $rows->center_id;
			$centerColDesc[$rows->center_id]= $temp2;
			
		}
		
		//query erdlogs custom
		$this->db->select(" drp_status.status_id as 'sid', drp_status.status_desc as 'sdesc', ".$selectParse1,FALSE);
		$this->db->where(" DATE_FORMAT(date_opened, '%Y-%m-%d') BETWEEN '$from' AND '$to' ", NULL,FALSE);
		$this->db->join('drp_status', 'drp_status.status_id = erdlogs.status_id', 'left outer');
		$this->db->join('users', 'users.id = erdlogs.user_id', 'left outer');
		$this->db->join('centers', 'centers.center_id = users.center_id', 'left outer');
		$this->db->group_by('erdlogs.status_id');
		$erdlogsRes = $this->db->get('erdlogs');	
		
		
		//$i = 1;
		
		$fields = $erdlogsRes->list_fields();
		
		$thead = '<tr>';
		$tr = '';
		
		$totals = array();
		foreach( $fields as $hfield){
			
			$totals[$hfield] = 0;
			
			$thFiled = str_replace('_', ' ', $hfield);
			
			if( trim($thFiled) == 'sid' ) $thFiled = '&nbsp;';
			elseif( trim($thFiled) == 'sdesc' ) $thead .= '<th scope="col">Status</th>';
			else $thead .= '<th scope="col">'.ucwords($thFiled).'</th>';
			
			
		}
		$thead .= '</tr>';
		
		
		foreach( $erdlogsRes->result() as $row ){			
			//$tr .= '<tr>';
			foreach( $fields as $field ){
			
				$summary[$row->sid][$field] = $row->$field;	
				//$totals[$field] += $row->$field;
				//$tr .= '<td>&nbsp;'.$row->$field.'</td>';
			}
			//$tr .= '</tr>';
			//$i++;
		}

		
		$statusRes = $this->db->query("SELECT * FROM drp_status WHERE status_active = 0")->result();	
		
		foreach( $statusRes as $row ){
			
			$sum = @$summary[$row->status_id];
			$tr .= '<tr>';
			$tr .= '<td>&nbsp;'.$row->status_desc.'</td>';
			
			if( count($sum) > 0 ){
				foreach( $sum as $key=>$value ){
					
					if( $key == 'sid'){
					
					}elseif(  $key == 'sdesc'  ){
						
						$totals[$key] += $value;
					}else{
						
						$tr .= '<td>&nbsp;'.$value.'</td>';
						$totals[$key] += $value;
					}
					
				}	
			}else{
				foreach( $fields as $hfield){
					
					if( $hfield == 'sid'){
					
					}elseif( $hfield == 'sdesc'){
					
					}else{
						$tr .= '<td>&nbsp;0</td>';
					}
				}
			}			
			$tr .= '</tr>';	
		}
		
	 	$tTr = '<tr class="odd">';
		
		foreach( $totals as $key=>$total) {
			
			if( trim($key) == 'sid' ){
				
			}elseif( trim($key) == 'sdesc' ){
				$tTr .= '<td>&nbsp;<b>Total</b></td>';
			}else{
				$tTr .= '<td>&nbsp;<b>'.$total.'</b></td>';
			}
			
		}
		$tTr .= '</tr>';		
		
		$table = '<table cellpadding="0" cellspacing="0" class="tablesorter" id="myTable"><thead>'.$thead.'</thead><tbody>'.$tr.$tTr.'</tbody></table>'; 
		
		$data["table"] = $table;
		
		
		$return = array();
		
		if( $_GET['st'] == 0 ){
					

			echo $this->load->view('summary_status', $data);
		}
		
		if( $_GET['st'] == 1 ){

			$return['html'] = $table;
			$return['status'] = true;
						
			echo $table;
		}		
		
	}
	
	function getLogAge(){
	
		
		/* SELECT centers.center_desc AS 'center', COUNT(*) AS 'num', EXTRACT( DAY_HOUR FROM TIMEDIFF(NOW(),MIN(date_updated))) AS age
		FROM erdlogs
		LEFT OUTER JOIN users ON users.id = erdlogs.user_id
		LEFT OUTER JOIN centers ON centers.center_id = users.center_id
		WHERE erdlogs.status_id = 1 OR erdlogs.status_id = 2
		GROUP BY users.center_id */

		$this->db->select("centers.center_desc AS 'center', COUNT(*) AS 'num', EXTRACT( DAY_HOUR FROM TIMEDIFF(NOW(),MIN(date_updated))) AS age ");			
		$this->db->join('users', 'users.id = erdlogs.user_id', 'left outer');		
		$this->db->join('centers', 'centers.center_id = users.center_id', 'left outer');
		$this->db->where(" centers.center_id <> '' ", null, false);
		$this->db->where("(erdlogs.status_id <> 3) ", null, false);
		$this->db->group_by("centers.center_id");
		$this->db->order_by("centers.center_desc", "asc");
		
		$results = $this->db->get("erdlogs")->result();
		
		//echo $this->db->last_query();
		$thead = '<tr>
					<th scope="col">CENTERS</th>
					<th scope="col">ACTIVE</th>
					<th scope="col"># of Hrs Old</th>
				</tr>';
		$tr = '';		
		$totalactive = 0; //total of active
		foreach($results as $row){
			$tr .= '<tr>
						<td>'.$row->center.'</td>
						<td>'.$row->num.'</td>
						<td><a href="#" >'.(($row->age > 0)?$row->age.' hrs':$row->age).'</a></td>
					</tr>';
			$totalactive += $row->num;
		}
		
		$tTr = '<tr>
			<td><strong>Total</strong></td>
			<td><strong>'.$totalactive.'</strong></td>
			<td>&nbsp;</td>
		</tr>';
		
		$table = '<table cellpadding="0" cellspacing="0" class="tablesorter" id="myTable" style="width: 50% !important"><thead>'.$thead.'</thead><tbody>'.$tr.$tTr.'</tbody></table>'; 
		
		echo $table;
		
	}
	
	function oldlogdetails(){
		
		
		$hdata["menu"] = 'summary';
		$data[] = '';
		
		$data["from"] = $_GET["from"];
		$data["to"] = $_GET["to"];
		$data["center"] = $_GET["center"];
		$data["sumvar"] = $_GET["sumvar"];
		
		//print_r($_GET);
		
		$this->load->view('header', $hdata);
		$this->load->view('age_details', $data);
		$this->load->view('footer');		
	}

	
	function manageaccount(){
		
		if( $this->_userid == 2669){
			redirect(base_url()."dashboard/");
		}
	
		$hdata["menu"] = 'manageaccount';
		
		$data[] = '';
		
		$this->load->view('header', $hdata);
		$this->load->view('manageaccount.php',$data);
		$this->load->view('footer');	
	}
	
	function accountlist(){
		
		
		if( $this->_roleid == 1) {		
			$this->load->view('ajax/account_list_sup');
		}elseif( $this->_roleid == 3 or $this->_roleid == 4 ){
			$this->load->view('ajax/account_list_enter');
		}elseif( $this->_roleid == 5){
			$this->load->view('ajax/account_list_manager');
		}
		
	}
	
	function ajaxgetaccountlist(){
	
		$this->load->model("dx_auth/users","users");
		
		$where = array();
		$filters = json_decode( stripslashes(@$_GET["filters"]) );
		
		$req_param = array (
				"sort_by" => $_GET["sidx"],
				"sort_direction" => $_GET["sord"],
				"page" => $_GET["page"],
				"num_rows" => $_GET["rows"],
				"search" => $_GET["_search"],
				"search_field" => @$_GET["searchField"],
				"search_operator" => @$_GET["searchOper"],
				"search_str" => @$_GET["searchString"],					
				"filters" => $filters					
		);	
		
		//if( $this->_roleid ) 
		//$where['supervisor_id'] = $this->_userid;
		
		//if( $this->_roleid ==  1){
		//$where["supervisor_id"] = $this->_userid;
		//$where["centers.center_id"] = $this->_centerid;
			
		//}		
		//$where['needcallback'] = 0;
		
		if( $this->_roleid == 3) {			
			$where["roles.id <> "] = 4;
		}		
		
		if( $this->_roleid == 5) {			
			//$where["roles.id <> 3 AND roles.id <> 5"] = 4;
			$where["roles.id <> "] = 4;			
			$where["centers.center_id"] = $this->_centerid;
		}
		
		if( $this->_roleid == 1) {		
			$where["users.supervisor_id"] = $this->_userid;	
			$where["roles.id <> "] = 4;
			$where["centers.center_id"] = $this->_centerid;
		}
		
		$where["users.username <> "]  = "belron";
		
		$response->page 	= $_GET["page"];
		$response->records 	= $this->users->getUsersQuery( $req_param, "all", $where )->num_rows();		

		$response->total 	= ceil( $response->records/$_GET["rows"] );
		$records 			= $this->users->getUsersQuery( $req_param, "", $where )->result_array();
		//echo $this->db->last_query();

		
		$i=0;
		foreach($records as $row) { 
								
			$response->rows[$i]['id']=$row['user_id']; 
			$response->rows[$i]['cell']=array(  '',
												$row['lname'].', '.$row['fname'],
												$row['fname'],
												$row['lname'],
												$row['username'],												
												$row['password'],
												$row['role_name'],															
												$row['center_desc'],	
												$row['dept_desc'],
												$row['suplname'].', '.$row['supfname'],																								
												$row['last_login']
										); 
			$i++;
			
		} 
		echo json_encode($response);				
	}
	
	function ajaxUsersAction(){
		
		$oper = $this->input->post("oper");
		$id = $this->input->post("id");
		if( $oper == 'edit' ){

			$set['fname'] 		= $this->input->post('fname');	
			$set['lname'] 		= $this->input->post('lname1');	
			$set['password'] 	= $this->input->post('password');	
			$set['dept_id'] 	= $this->input->post('dept_id');
			
			if( $this->_roleid == 5){
				$set['supervisor_id'] 	= $this->input->post('supervisor_id');
			}
			
			$this->db->where('id', $id);	
			$this->db->update('users',$set);
				
		}		
		
	}
	
	function ajaxgetUsers(){
		$name = $_GET['term'];
		//$fname = $_GET['name1'];
		
		if( $this->_roleid == 1){
			$this->db->where('center_id', $this->_centerid);
			$this->db->where('supervisor_id', $this->_userid);			
		}
		
		if( $this->_roleid == 5){
			$this->db->where('center_id', $this->_centerid);
			//$this->db->where('supervisor_id', $this->_userid);			
		}		
		
		
		
		$this->db->where('role_id != ', 4);
		$this->db->where('banned', 0);
		
		$this->db->like('lower(fname)', strtolower($name));
		$this->db->or_like('lower(lname)', strtolower($name));
		$result = $this->db->get('users')->result();
		
		//echo $this->db->last_query();
		
		$return = array();
		
		foreach( $result as $row ){
			$return[]  = $row->lname.','.$row->fname;
		}
		echo json_encode($return);			
	}
	
	function createuser(){
		$this->load->view('ajax/createuser');
	}
	
	function myaccount(){
		$this->load->view('ajax/myaccount');
	}
	
	function acceptaccount(){
		$this->load->view('ajax/acceptaccount');
	}
	
	function ajax_acceptaccount_action(){		
		
		$id = $this->input->post('sid');
		
		$supid = $this->_userid;
		
		$result['status'] = false;
		$result['msg'] = '';
		$result['trid'] = "traccept_".$id;
		
		$query = $this->db->query("INSERT INTO users( role_id, username, PASSWORD, email, created, dept_id, center_id, fname, lname, supervisor_id, avaya, createdby )
									SELECT 2, username, PASSWORD, email, created, dept_id, center_id, fname, lname, supervisor_id, avaya, $supid FROM  user_temp WHERE id = $id");
		
		if( $query ){
			$this->db->where('id', $id);
			
			if( $this->db->delete('user_temp') ){
				$result['status'] = true;
			}
			
		}
		echo json_encode($result);
	}
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */