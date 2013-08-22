<?php

class Comments extends Model {

	
	function __construct(){
		parent::Model();	
	}
	
	function get_comments_by_erd_id( $id ){
		
		$this->db->where('erd_id', $id);
		
		$this->db->join('users', 'users.id = comments.user_id', 'left outer');
		$this->db->join('roles', 'roles.id = users.role_id', 'left outer');
		$ret = $this->db->get('comments');		
		
		return $ret;	
		
	}

	function get_num_comments_by_id($id){
	
		$this->db->where('erd_id', $id);
		$ret = $this->db->get('comments');
		return $ret;
	}
	
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */