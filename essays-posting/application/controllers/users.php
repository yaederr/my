<?php
class Users extends CI_Controller {
	public function view(){ //post ajax requests here. i return essay contents

	}
	public function add($data){//register a user
		$this -> load -> model("user");
		$result = $this -> user -> model_add($data);
		// $this->load->view("sendjson", array("json"=>$result));
		redirect("/");
	}
	public function login(){
		$this -> load -> view("loginview");
	}
	public function post_login(){
		$this -> load -> model("user");
		$email= $this->input->post("email");
		$pw= $this->input->post("pw");
		echo $this -> user -> model_login($email, $pw);//respond with results
	}
	public function register(){
		$this -> load -> view("registrationview");
	}
	public function post_register(){
		$this -> load -> model("user");
		$email= $this->input->post("email");
		$name= $this->input->post("name");
		$pw1= $this->input->post("pw1");
		$pw2= $this->input->post("pw2");
		echo $this -> user -> model_register($email, $name, $pw1, $pw2);
	}
	public function name(){
		$this -> load -> model("user");
		echo $this->user->get_name();
	}
	public function logout(){
		$this -> load -> model("user");
		$this -> user -> model_logout();
	}
	//this route is used by the frontend to check if the user is logged in
	public function logstat(){
		if($this->session->userdata("auth"))
			echo true;
		else
			echo false;
	}
}
?>