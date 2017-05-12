<div id="registration">
	<h2>Register</h2>
<?php
$this->load->library('form_validation');			
$this->load->helper('form'); 
if($this->session->userdata("issues")) echo $this->session->userdata("issues");
echo validation_errors();
echo form_open('',array("id"=>"registration_form"));
echo "<label>Email: ".form_input(array("id"=>"reg_form_email"))."</label>";
echo "<label>Name: ".form_input(array("id"=>"reg_form_name"))."</label>";
echo "<label>Password:".form_password(array("id"=>"reg_form_pw1"))."</label>";
echo "<label>Password confirm:".form_password(array("id"=>"reg_form_pw2"))."</label>";
echo form_submit("submit","Create Account");
echo form_close();
?>
	<button class="select_login" href="/users/login">I want to try logging in</button>
</div>