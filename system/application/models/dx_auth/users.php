<?php

class Users extends Model 
{
	function Users()
	{
		parent::Model();

		// Other stuff
		$this->_prefix = $this->config->item('DX_table_prefix');
		$this->_table = $this->_prefix.$this->config->item('DX_users_table');	
		$this->_roles_table = $this->_prefix.$this->config->item('DX_roles_table');
	}
	
	// General function
	
	function get_all($offset = 0, $row_count = 0)
	{
		$users_table = $this->_table;
		$roles_table = $this->_roles_table;
		
		if ($offset >= 0 AND $row_count > 0)
		{
			$this->db->select("$users_table.*", FALSE);
			$this->db->select("$roles_table.name AS role_name", FALSE);
			$this->db->join($roles_table, "$roles_table.id = $users_table.role_id");
			$this->db->order_by("$users_table.id", "ASC");
			
			$query = $this->db->get($this->_table, $row_count, $offset); 
		}
		else
		{
			$query = $this->db->get($this->_table);
		}
		
		return $query;
	}

	function get_user_by_id($user_id)
	{
		$this->db->where('id', $user_id);
		return $this->db->get($this->_table);
	}

	function get_user_by_username($username)
	{
		$this->db->where('username', $username);
		return $this->db->get($this->_table);
	}
	
	function get_user_by_email($email)
	{
		$this->db->where('email', $email);
		return $this->db->get($this->_table);
	}	
	
	function get_user_by_center_all_supervisor($center_id)
	{
		$this->db->where('role_id', 1);
		$this->db->where('banned', 0);
		
		if( $center_id != 'all' )
			$this->db->where('center_id', $center_id);
		
		return $this->db->get($this->_table);
	}
	function get_user_by_all_supervisor($center_id)
	{
		$this->db->where('role_id', 1);
		$this->db->where('banned', 0);
		$this->db->where('center_id', $center_id);
		return $this->db->get($this->_table);
	}
	
	function get_login($login)
	{
		$this->db->where('username', $login);
		//$this->db->or_where('email', $login);
		return $this->db->get($this->_table);
	}
	
	function check_ban($user_id)
	{
		$this->db->select('1', FALSE);
		$this->db->where('id', $user_id);
		$this->db->where('banned', '1');
		return $this->db->get($this->_table);
	}
	
	function check_username($username)
	{
		$this->db->select('1', FALSE);
		$this->db->where('LOWER(username)=', strtolower($username));
		return $this->db->get($this->_table);
	}

	function check_email($email)
	{
		$this->db->select('1', FALSE);
		$this->db->where('LOWER(email)=', strtolower($email));
		return $this->db->get($this->_table);
	}
		
	function ban_user($user_id, $reason = NULL)
	{
		$data = array(
			'banned' 			=> 1,
			'ban_reason' 	=> $reason
		);
		return $this->set_user($user_id, $data);
	}
	
	function unban_user($user_id)
	{
		$data = array(
			'banned' 			=> 0,
			'ban_reason' 	=> NULL
		);
		return $this->set_user($user_id, $data);
	}
		
	function set_role($user_id, $role_id)
	{
		$data = array(
			'role_id' => $role_id
		);
		return $this->set_user($user_id, $data);
	}

	// User table function

	function create_user($data)
	{
		$data['created'] = date('Y-m-d H:i:s', time());
		return $this->db->insert($this->_table, $data);
	}

	function get_user_field($user_id, $fields)
	{
		$this->db->select($fields);
		$this->db->where('id', $user_id);
		return $this->db->get($this->_table);
	}

	function set_user($user_id, $data)
	{
		$this->db->where('id', $user_id);
		return $this->db->update($this->_table, $data);
	}
	
	function delete_user($user_id)
	{
		$this->db->where('id', $user_id);
		$this->db->delete($this->_table);
		return $this->db->affected_rows() > 0;
	}
	
	// Forgot password function

	function newpass($user_id, $pass, $key)
	{
		$data = array(
			'newpass' 			=> $pass,
			'newpass_key' 	=> $key,
			'newpass_time' 	=> date('Y-m-d h:i:s', time() + $this->config->item('DX_forgot_password_expire'))
		);
		return $this->set_user($user_id, $data);
	}

	function activate_newpass($user_id, $key)
	{
		$this->db->set('password', 'newpass', FALSE);
		$this->db->set('newpass', NULL);
		$this->db->set('newpass_key', NULL);
		$this->db->set('newpass_time', NULL);
		$this->db->where('id', $user_id);
		$this->db->where('newpass_key', $key);
		
		return $this->db->update($this->_table);
	}

	function clear_newpass($user_id)
	{
		$data = array(
			'newpass' 			=> NULL,
			'newpass_key' 	=> NULL,
			'newpass_time' 	=> NULL
		);
		return $this->set_user($user_id, $data);
	}
	
	// Change password function

	function change_password($user_id, $new_pass)
	{
		$this->db->set('password', $new_pass);
		$this->db->where('id', $user_id);
		return $this->db->update($this->_table);
	}
	

	
	function getUsersQuery( $params, $page = "all", $where = array() ){
	
		$this->db->order_by( $params['sort_by'], $params["sort_direction"] );

		if ( $page != "all" ){
			//echo 'tnot all';
			$this->db->limit( $params["num_rows"], $params["num_rows"] *  ($params["page"] - 1) );
		}
		
		if( !empty($where) ){
		
			$this->db->where($where);
		
		}
		
		
		$this->db->where('users.banned', 0);
		
		
		if  ($params["search"] == 'true' ){
			
			$this->jqgrid_oper( $params["search_field"], $params["search_operator"], $params["search_str"] );
			
			if( is_object($params["filters"]) ){
				
				$filters = $params["filters"];
				
				foreach(  $filters as $key=>$values ){
					
					if( $key == 'rules'){

						foreach( $values as $data){
							
							/* if( $data->field == 'status_id' ){															
								$this->jqgrid_oper( 'erdlogs.status_id', $data->op, strtolower($data->data) );
							}elseif( $data->field == 'center_id' ){	
								$this->jqgrid_oper( 'users.center_id', $data->op, strtolower($data->data) );
							}elseif( $data->field == 'erd_id' ){	
								
								if( strlen($data->data) > 3 ){
									$erd_id =  substr($data->data, 3, strlen($data->data)); 								
									$this->jqgrid_oper( 'erd_id', $data->op, strtolower($erd_id) );
								}else{
									$this->jqgrid_oper( 'erd_id', $data->op, 'invalid' );
								}
							}elseif( $data->field == 'lname' ){	
								//$this->jqgrid_oper( 'erd_id', $data->op, strtolower($erd_id) );
								
								$temp1 = explode(',',$data->data);
								
								$this->db->like('lower(fname)', strtolower($temp1[1]));
								$this->db->like('lower(lname)', strtolower($temp1[0]));
							}else{
								$this->jqgrid_oper( $data->field, $data->op, strtolower($data->data) );
							} */
							
							if( $data->field == 'users.lname' ){		
								$temp1 = explode(',',$data->data);
								
								//print_r($temp1);
								
								$this->db->like('lower(users.fname) ', strtolower($temp1[1]), 'both', false);
								$this->db->like('lower(users.lname) ', strtolower($temp1[0]), 'both', false);		
								
							}elseif( $data->field == 'supervisor' ){		
								$temp1 = explode(',',$data->data);
								
								$this->db->like('lower(sup.fname)', strtolower($temp1[1]), 'both', false);
								$this->db->like('lower(sup.lname)', strtolower($temp1[0]), 'both', false);		
								
							}elseif( $data->field == 'center_id' ){	
								$this->jqgrid_oper( 'centers.center_id', $data->op, strtolower($data->data) );							
							}/* elseif( $data->field == 'roles_text' ){	
								//$this->jqgrid_oper( 'drp_department.dept_id', $data->op, strtolower($data->data) );
								
								$vdata = strtolower($data->data);
								
								if( $vdata == "agent" ){
									$this->jqgrid_oper( 'role_id', $data->op, 2 );
								}
								if( $vdata == "supervisor" ){
									$this->jqgrid_oper( 'role_id', $data->op, 1 );
								}
								if( $vdata == "manager" ){
									$this->jqgrid_oper( 'role_id', $data->op, 5 );
								}
								
							 }*/
							elseif( $data->field == 'dept_id' ){	
								$this->jqgrid_oper( 'drp_department.dept_id', $data->op, strtolower($data->data) );
							}/* elseif( $data->field == 'role_id' ){	
								$this->jqgrid_oper( 'users.role_id', $data->op, strtolower($data->data) );
							} */
							else{
								$this->jqgrid_oper( $data->field, $data->op, strtolower($data->data) );
							}
							
							
						}
						
					}
				}			
			
			}			

		}		
		
		$this->db->select("	users.id as 'user_id', users.username, users.password, users.fname, users.lname, users.last_login,
							centers.center_id, center_desc, 
							drp_department.dept_id, dept_desc,
							roles.id as 'roles_id', roles.name as 'role_name',
							sup.id AS 'supid', sup.fname AS 'supfname', sup.lname AS 'suplname'");		
		
		$this->db->join('centers', 'centers.center_id = users.center_id', 'left outer');
		$this->db->join('drp_department', 'drp_department.dept_id = users.dept_id', 'left outer');
		$this->db->join('roles', 'roles.id = users.role_id', 'left outer');
		$this->db->join('users sup', 'sup.id = users.supervisor_id', 'left outer');
		
		$query = $this->db->get('users');
		
		
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
}

?>