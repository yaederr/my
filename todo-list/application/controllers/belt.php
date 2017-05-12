<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Belt extends CI_Controller {
    public function index() {
        $this -> load -> model("appt");
        $this -> load -> model("user");
		if($this->session->userdata("auth")){//version of page for members
			$user = $this->session->userdata("auth");
			$this -> load -> view("headerview", ["data"=>$this->user->get_user_info($user)]);
			$todays_tasks = $this->appt->get_appts_for_today($user);//load todays appt
			$future_tasks = $this->appt->get_future_appts($user);//load future appt
			$this->load->view("taskview", ["today"=>$todays_tasks, "future"=>$future_tasks]);
			$this -> load -> view("addview"); //load form for adding appt
		}
		else{//version of page for those not logged in
			$this->load->view("headerview", ["data"=>array()]);
			$this->load->view("registrationview");//load register pane
			$this->load->view("loginview");//load login pane
		}
        $this -> load -> view("footerview");
    }
    public function delete($id){
    	$this->load->model("appt");
    	$this->appt->remove_appt($id);
    	redirect(base_url());
    }

    public function add() {
    	$okay = true;
        $this -> load -> model("appt");
        $this -> load -> library('form_validation');
        $this -> form_validation -> set_rules("date", "date", "required");
        $this -> form_validation -> set_rules("time", "time", "required");
        $this -> form_validation -> set_rules("description", "description", "required");
    	$time = strtotime($this->input->post("date")." ".$this->input->post("time"));

    	if($time<time()){
    		$okay = false;
    		$this->session->set_userdata("issues", "you need to add a future appointment");
    	}
        $this -> form_validation -> set_rules("status", "status", "required");
        if ($this -> form_validation -> run() == TRUE and $okay) {
        	//you need to convert date, time, desc into 
        	//desc, time, status
        	$status = $this->input->post("status");
        	$description = $this->input->post("description");
            $this -> appt -> make_appt(["time"=>$time, "status"=>$status, "description"=>$description]);
        }
        redirect(base_url());
    }
	public function logout(){
		$this->session->sess_destroy();
		redirect(base_url());
	}
	public function register(){
		$this->load->model("user");
		$issues = "";
		if($this->input->post("submitted")){
			$this->load->library('form_validation');			
			if($this->check_registration()){
				$email = $this->input->post("email");
				$first_name = $this->input->post("first_name");
				$last_name = $this->input->post("last_name");
				$pw = $this->input->post("pw1");
				if($this->input->post("dob")) $dob=$this->input->post("dob");
				else $dob="1/1/1111";
				if($pw != $this->input->post("pw2"))
					$issues = $issues."<p>The passwords must match.</p>";
				if($this->user->get_pw($email)) //this checks if email exists
					$issues = $issues."<p>Someone has already registered an account with this email address.</p>";
				if(strlen($issues)==0){
					$this->user->make_user(["first_name"=>$first_name, "last_name"=>$last_name, "email"=>$email, "pw"=>$pw, "dob"=>$dob]);
					$this->session->set_userdata("auth", $email);
					redirect(base_url());
				}
			}
		}
		$this->session->set_userdata("issues", $issues.validation_errors());
		//the last ditch measure is to send them back to the register page
		if(!$this->session->userdata("auth")) 
			redirect(base_url());
		}
	private function check_registration(){ //for checking reg form
		$this->load->library('form_validation');
		$this->form_validation->set_rules('email', 'email', 'required|valid_email');
		$this->form_validation->set_rules('pw1', 'password', 'required|min_length[8]');
		$this->form_validation->set_rules("first_name", "first name", "required");
		$this->form_validation->set_rules("last_name", "last name","required");
		return $this->form_validation->run();
	}
	public function login(){
		$this->load->model("user");
		$login_issues="";
		$this->load->library('form_validation');
		$this->form_validation->set_rules('email', 'email', 'required');
		$this->form_validation->set_rules('password', 'password', 'required');
		if (($this->form_validation->run())){
			$password = $this->user->get_pw($this->input->post("email"));
			if($password){ //a test to see if user exists
				if($password == $this->input->post("password"))//login success
					$this->session->set_userdata("auth",$this->input->post("email"));
				else $login_issues = $login_issues."<p>The user exists, but the password does not match our records.</p>";
 			}
			else $login_issues = $login_issues."<p>This user is not in our system.</p>";
		}
		//$this->load->view("homeview");
		$login_issues = $login_issues.validation_errors();
		$this->session->set_flashdata("login_issues", $login_issues);
		redirect(base_url());
	}

}