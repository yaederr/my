<div id="add_appt_pane">
	<h2>Add Appointment</h2>
<?php
$this->load->library('form_validation');			
$this->load->helper('form');
echo validation_errors();
if($this->session->userdata("issues")){
	echo $this->session->userdata("issues");
	$this->session->unset_userdata("issues");
}
$attributes = array('id' => 'add_appt_form');
echo form_open('/belt/add');
echo form_hidden("submitted", "true");
$attributes = array('id' => 'date', "name"=>"date");

echo "<label>Date: ".form_input($attributes)."</label>";
echo "<label>Time: ".form_input("time")."</label>";
echo "<label>Description".form_input("description")."</label>";
echo "<label>status".form_input("status")."</label>";
echo form_submit("submit","add");
echo form_close();
?>
</div>