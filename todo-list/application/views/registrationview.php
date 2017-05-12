<div id="registration">
	<h2>Register</h2>
<?php
$this->load->library('form_validation');			
$this->load->helper('form'); 
if($this->session->userdata("issues")) echo $this->session->userdata("issues");
echo validation_errors();
echo form_open('/belt/register');
echo form_hidden("submitted", "true");
echo "<label>Email: ".form_input("email")."</label>";
echo "<label>First Name: ".form_input("first_name")."</label>";
echo "<label>Last Name: ".form_input("last_name")."</label>";
echo "<label>Password:".form_password("pw1")."</label>";
echo "<label>Repeat Password:".form_password("pw2")."</label>";
echo form_submit("submit","Create Account");
echo form_close();
?>
</div>