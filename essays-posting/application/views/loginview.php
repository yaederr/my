<div id="login_area">
	<h2>Login</h2><p>Try email=user and password=pw</p>
<?php
$this->load->helper('form');
$login_atts = array('class' => 'email', 'id' => 'login_form');
echo form_open('#',$login_atts);
echo "<label>Email: ".form_input(array("id"=>"login_form_email"))."</label>";
echo "<label>Password:".form_password(array("id"=>"login_form_pw"))."</label>";
echo form_submit("submit","login");
echo form_close();
?>
	<button id="select_registration" href="/users/register">I need an account</button>
</div>