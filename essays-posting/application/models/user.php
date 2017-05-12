<?php
class User extends CI_Model {
	public function model_logout(){
		$this->session->sess_destroy();
	}
	public function model_add($data){
		$this->session->set_userdata("auth", $uid);
	}
	public function model_login($email, $pw){
		if($email and $pw){
			$query = "select * from users where email = '".$email."'";
			foreach ($this->db->query($query)->result() as $row) {
				if($row->pw == $pw){
					$this->session->set_userdata("auth", $row -> uid);
					return true;
				}
			}
		}
		return false;
	}
	public function model_register($email, $name, $pw1, $pw2){
		$issues = array();
		if($email){
			if(!preg_match('/@/', $email)){
				$issues["email"] = "Please check to see if this is a valid email address.";
			}
		}
		else{
			$issues["email"]= "Please provide an email address.";
		}
		if(!$name){
			$issues["name"] = "What shall we call you?";
		}
		if(!$pw1){
			$issues["pw1"] = "Please provide a password.";
		}
		if(!$pw2){
			$issues["pw2"] = "Please confirm the password.";
		}
		if(count($issues) < 1){
			$query = "insert into users(name, email, pw, ca, ua) values('".$name."','".$email."','".$pw1."',".time().",".time().")";
			$this->db->query($query);
			return 1;
		}
		else{
			return json_encode($issues, true);
		}

	}
	public function get_name(){
		if($this->session->userdata("auth")){
			$query = $this->db->query("select users.name from users where users.uid = ".$this->session->userdata("auth"));
			return $query->first_row()->name;
		}
		else{
			return "no one is logged in right now";
		}
	}
}
?>