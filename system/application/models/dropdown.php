<?php

class Dropdown extends Model {

	
	function __construct(){
		parent::Model();	
	}
	//status
	function status_all( $active = '' ){
		
		if( $active != '')
			$this->db->where('status_active', $active);	
			
		$ret = $this->db->get('drp_status');		
		return $ret;
	}
	
	function status_by_id( $id ){
		
		$this->db->where('status_id', $id);
		$ret = $this->db->get('drp_status');		
		return $ret;	
		
	}
	
	//department
	function department_all( $active = '' ){
	
		if( $active != '')
			$this->db->where('dept_active', 0);	
			
		$ret = $this->db->get('drp_department');		
		return $ret;		
	}
	
	function department_by_id( $id ){
		
		$this->db->where('dept_id', $id);
		$ret = $this->db->get('drp_department');		
		return $ret;	
		
	}
	
	//issues
	function issue_all( $active = '' )	{
	
		if( $active != '')
			$this->db->where('issue_active', $active);	
		
		$this->db->order_by('miamionly', 'asc');		
		$this->db->order_by('issue_desc', 'asc');	
		
		$ret = $this->db->get('drp_issue');		
		return $ret;	
		
	}
	
	function issue_by_id( $id ){
		
		$this->db->where('issue_id', $id);
		$ret = $this->db->get('drp_issue');		
		return $ret;	
		
	}	
	
	function issuesub_all( $active = '' ){
		
		if( $active != '')
			$this->db->where('issuesub_active', $active);	
		
		$this->db->order_by('issuesub_desc', 'asc');		
		$ret = $this->db->get('drp_issuesub');		
		return $ret;	
		
	}	
	
	function issuesub_by_issueid( $id ){
		
		$this->db->where('issue_id', $id);
		$ret = $this->db->get('drp_issuesub');		
		return $ret;	
		
	}	
	
	function issuesub_by_desc( $desc = ''){
		
		$descQuery = $this->db->query("SELECT * FROM drp_issuesub WHERE issuesub_desc = '$desc'");
		$descNum = $descQuery->num_rows();
		$issueQuery = '';
		$option = '';
		if( $descNum == 1 ){		
			$issueid = $descQuery->row();
			$issueQuery = $this->db->query("SELECT * FROM drp_issuesub WHERE issue_id = ".$issueid->issue_id)->result();	
			
			
			foreach( $issueQuery as $row ){
				$selected = "";
				if(  $row->issuesub_desc == $desc)
					$selected = 'selected="selected"';
				$option .= '<option value="'.$row->issuesub_desc.'" '.$selected.' data="'.$row->issuesub_id.'">'.$row->issuesub_desc.'</option>';
			}
		}
		
		return $option;
	}
	
	//source
	function source_all( $active = '' )	{
	
		if( $active != '')
			$this->db->where('src_active', $active);	
		
		$this->db->order_by('src_name', 'asc');
		$ret = $this->db->get('drp_source');		
		return $ret;	
		
	}
	
	function source_by_id( $id ){
		
		$this->db->where('src_id', $id);
		$ret = $this->db->get('drp_source');		
		return $ret;	
		
	}
	
	//organization
	function org_all( $active = '' )	{
	
		if( $active != '')
			$this->db->where('org_active', $active);	
		
		$this->db->order_by('org_name', 'asc');
		$ret = $this->db->get('drp_organization');		
		return $ret;	
		
	}
	
	function org_by_id( $id ){
		
		$this->db->where('org_id', $id);
		$ret = $this->db->get('drp_organization');		
		return $ret;	
		
	}	
	
	//escalated department
	function escalate_all( $active = '' )	{
	
		if( $active != '')
			$this->db->where('esc_active', $active);	
		
		$this->db->order_by('esc_name', 'asc');
		$ret = $this->db->get('drp_escalated');		
		return $ret;	
		
	}
	
	function escalate_by_id( $id ){
		
		$this->db->where('esc_id', $id);
		$ret = $this->db->get('drp_escalated');		
		return $ret;	
		
	}
	
	//centers
	function center_all( $active = '' )	{
	
		if( $active != '')
			$this->db->where('center_disabled', $active);	
			
		$ret = $this->db->get('centers');		
		return $ret;	
		
	}
	
	function center_by_id( $id ){
		
		$this->db->where('center_id', $id);
		$ret = $this->db->get('centers');		
		return $ret;	
		
	}	
	
	//access
	function access_all1( $active = '' ){
	
		//if( $active != '')
			//$this->db->where('center_disabled', $active);	
			
		$this->db->where('id <> 3 and id <> 4', null, false);	
		$ret = $this->db->get('roles');		
		return $ret;		
	}
	
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */