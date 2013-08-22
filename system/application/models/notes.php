<?php

class Notes extends Model {

	
	function __construct(){
		parent::Model();	
	}
	
	function get_notes_by_erd_id( $id ){
		
		$this->db->where('erd_id', $id);
		
		$this->db->join('users', 'users.id = notes.user_id', 'left outer');
		
		$ret = $this->db->get('notes');		
		
		return $ret;	
		
	}	
	
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */