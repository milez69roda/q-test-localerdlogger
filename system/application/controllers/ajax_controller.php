<?php

class Ajax_controller extends Controller {

	function __construct(){
	
		parent::Controller();	
		$this->load->library('DX_Auth');
		$this->ci =& get_instance();
		parse_str( $_SERVER["REQUEST_URI"] ,$_GET);//converts query string into global GET array variable
		
	}

	function getUsers(){
		$username=strtolower($_GET['txtusername']);
		$query=$this->db->query("SELECT * FROM users WHERE lower(username) like '".urlencode($username)."'");
		$dumal="true";
		if($query->num_rows() > 0)
			$dumal = "false";
		else
			$dumal = "true";
		
		if($dumal!="false"){
			$query2=$this->db->query("SELECT * FROM user_temp WHERE username like '".urlencode($username)."'");
			if($query2->num_rows() > 0)
				$dumal = "false";
			else
				$dumal = "true";
		}
		echo $dumal;
	}
	
	function saveUsers(){
		$createdby = $this->session->userdata('user_id');
		$role_id=2;
		if(isset($_POST['optagnt']))
			$role_id=$_POST['optagnt'][0];
		$sups=0;
		if(isset($_POST['supervisorid']))
			$sups=$_POST['supervisorid'];
			
		if( $_POST['optagnt'] == 5 OR $_POST['optagnt'] == 6  )	{
			$sups='(NULL)';
		}
		
		$arrUser=array(
			'role_id'=>$role_id,
			'username'=>$_POST['txtusername'],
			'password'=>$_POST['txtpassword'],
			'fname'=>$_POST['txtfname'],
			'lname'=>$_POST['txtlname'],
			'avaya'=>$_POST['txtavaya'],
			'center_id'=>$_POST['dpcenter'],
			'supervisor_id'=>$sups,
			'dept_id'=>$_POST['dpdept'],
			'createdby'=>$createdby
		);
		if($this->db->insert('users', $arrUser))
			echo "success";
		else
			echo "failed";
		
	}
	
	function updateUsers(){
		$data = array(
			'password' => $_POST['txtpassword'],
			'fname' => $_POST['txtfname'],
			'lname' => $_POST['txtlname'],
			'avaya' => $_POST['txtavaya'],
			'updatedby' => $this->session->userdata('user_id')
		);
		$this->db->where('id', $_POST['userid']);
		if($this->db->update('users', $data))
			echo 'success';
		else
			echo 'fail';

	}
	
	function saveTotemp(){
		$isSup=$_POST['trigs'];
		$sups=0;
		if(isset($_POST['supervisorid']))
			$sups=$_POST['supervisorid'];
		$arrUser=array(
			'username'=>$_POST['txtusername'],
			'password'=>$_POST['password'],
			'fname'=>$_POST['firstname'],
			'lname'=>$_POST['lastname'],
			'avaya'=>$_POST['avaya'],
			'center_id'=>$_POST['dpcenter'],
			'supervisor_id'=>$sups,
			'dept_id'=>$_POST['dpdept']
		);
		
		if($isSup=='sup'){
			if($this->db->insert('users', $arrUser))
				echo "success";
			else
				echo "failed";
		}else{
			if($this->db->insert('user_temp', $arrUser))
				echo "success";
			else
				echo "failed";
		}
	}
	
	function getSubs(){
	
		$roles=$this->session->userdata('role_id');
		
		if( $roles == 5){
			$cntr_id = $this->session->userdata('center_id');
		}else{
			$cntr_id = $_POST['center'];
		}
		
		$dpt_id = $_POST['department'];
		$query=$this->db->query("SELECT * FROM users WHERE banned = 0 and role_id=1 AND center_id=".$cntr_id." AND dept_id=".$dpt_id." ORDER BY fname ASC");
		
		$pmar=array();
		$ctr1=1;
		$psmSel=0;
		
		foreach($query->result() as $row){
			
			$pmar[$row->id]=$row->fname." ".$row->lname;
			
		}
		
		// if($_POST['cbosel']=='dpdept')
			// $psmSel=$_POST['dumpsm'];
			
		// $query2=$this->db->query("SELECT * FROM drp_department ORDER BY dept_desc ASC");
		// $pcar2=array();
		// $ctr2=1;
		// $pcSel=0;
		// while($row2=mysql_fetch_array($sql2)){
			// if($ctr2==1)
				// $pcSel=$row2['m_subcatid'];
			// $pcar2[$row2['p_catid']]=$row2['p_catname'];
			// $ctr2++;
		// }
		$jason=array("cntr"=>$pmar);
		echo json_encode($jason);
	}
	
	function getissuesubdropdown(){
		
		$this->load->model("Dropdown", 'dropdown');
		
		$id = $this->uri->segment(3);
		
		$res = $this->dropdown->issuesub_by_issueid($id)->result();
		$options  = "";
		foreach( $res as $row){
			$options .= '<option value="'.$row->issuesub_desc.'">'.$row->issuesub_desc.'</option>';			
		}
		echo $options;
	}
	
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */