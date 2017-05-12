<?php session_start(); require("dbconn.php");
?>
<html>
<head>
	<title>user registration</title>
	<link rel="stylesheet" type="text/css" href="crime.css">
</head>
<body>
	<div id="wrapper">
	<?php
	print_greeting(false);?>
		<div id="registration_form">
			<div id="form_issues">
	<?php
	if(isset($_SESSION["issues"])){
		if(count($_SESSION["issues"])>0){
			while($issue = array_shift($_SESSION["issues"])){
				echo $issue."<br>";
			}
		}
	}
	?>
		</div>
			 <form method="post" action="process.php">
			 	<input type="hidden" name="check_submit" value="registering"/>
			    <label>email: <input type="text" name="email" /></label>
			    <label>first name: <input type="text" name="first_name" /></label>
			    <label>last name: <input type="text" name="last_name" /></label>
			    <label>password: <input type="password" name="pw1" /></label>
			    <label>repeat password: <input type="password" name="pw2" /></label>
			    <input type="submit" class="submit_form" value="Create Your Account"/>
			</form>
			<div><a href="index.php">Or try logging in again</a></div>
		</div>
	</div>
</body>
</html>