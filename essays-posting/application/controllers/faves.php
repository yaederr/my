<?php
class Faves extends CI_Controller {
	public function all(){
		if($this->session->userdata("auth")){
			$this->load->model("fave");
			$current_user_faves = $this->fave->find_faves();
			$this->load->view("sendjson", array("json"=>$current_user_faves));
		}
		else{//users must login to use faves feature
			redirect("/");
		}
	}
	public function add(){
		$this-> load -> model("fave");
		$eid = $this -> input ->post("eid");
		echo $this-> fave ->model_add($eid);
	}
	public function is_fave(){//post sent here. tell if eid is on fave list
		$this-> load -> model("fave");
		echo $this -> fave -> model_is_fave( $this -> input -> post("eid") );
	}
	public function remove(){//do removal according to data received from post
		$this-> load -> model("fave");
		echo $this -> fave -> model_remove( $this -> input -> post("eid") );
	}
}