<?php

class Centers extends Model {

	
	function __construct(){
		parent::Model();	
	}
	
	function _get_center_by( $id ){
		
		$this->db->where('center_id', $id);
		
		$ret = $this->db->get('centers');		
		
		return $ret->row();			
	}	
	
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */