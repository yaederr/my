<div id="login_area">
	<h2>Login</h2>
<?php
$this->load->helper('form');
if($this->session->flashdata("login_issues")){
	echo $this->session->flashdata("login_issues");
}
$login_atts = array('class' => 'email', 'id' => 'myform');
echo form_open('/belt/login');
echo form_hidden("submit_form","login");
echo "<label>Email: ".form_input("email")."</label>";
echo "<label>Password:".form_password("password")."</label>";
echo form_submit("submit","login");
echo form_close();
?>		
</div>