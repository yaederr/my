<?php
class Essays extends CI_Controller {
	function index() {
		$this -> load -> model("essay");
		$this -> load -> model("user");
		$this -> load -> view("headerview");
		if($this -> session -> userdata("auth")){
			$this -> load->view("functions", array("name"=>$this->user->get_name($this->session->userdata("auth"))));
		}
		else{
			$this -> load->view("functions");
		}
		$this -> load -> view("tree");
		$this -> load -> view("essay");
		$this -> load -> view("footerview");
	}
	function all(){// handle ajax requests to see article list
		$this -> load -> model("essay");
		$this -> load -> view("sendjson",array("json"=>$this-> essay ->get_essay_list()));
	}
	function view(){ //post ajax requests here. i return essay contents
		$this -> load -> model("essay");
		$val = $this -> essay -> send_essay($this -> input -> post("eid"));
		$this -> load -> view("sendjson", array("json"=>$val));
	}
	function upload(){//show the upload page when someone gets this route
		$this -> load -> model("essay");
		$this -> load -> helper("form");
		$this -> load -> view("upload_view");
	}
	function do_upload()//this is just a bunch of things we do when we upload
	{
		$config['upload_path'] = './application/texts';
		$config['allowed_types'] = 'txt'; //we only allow upload of txt
		$fn = preg_replace("/\W/", "-", strtolower($this->input->post("fn")));
		$config['file_name'] = $fn.time();
		$config['max_size']	= '100';
		$this -> load -> library('upload', $config);
		$this -> upload -> do_upload();
		$cid = $this -> input -> post("cat");
		//tell the database about this entry
		$this-> db -> query("insert into essays (cid,title, ca, ua) values(".$cid.", '".$this->input->post("fn")."',".time().",".time().")");
		$final_file_name = "./application/texts/".$fn.time();
		rename($final_file_name.".txt", $final_file_name);//rmv file extension
		redirect("/");
	}
}
?>