<?php session_start(); ?>
<html>
<head>
	<title>user registration</title>
	<style type="text/css">#form_issues{color:red;}</style>
</head>
<body>
	<div id="form_issues">
<?php
if($_SESSION["screen_name_issue"] 
	or $_SESSION["pw_issue"]
	or $_SESSION["pw_match_issue"]
	or $_SESSION['dupe']
	or $_SESSION["first_name_issue"]
	or $_SESSION["last_name_issue"]
	){
	echo "In order to continue, please correct these errors.<br>";
	if($_SESSION["screen_name_issue"])
		echo "We believe this is not a valid email address.<br>";
	if($_SESSION["first_name_issue"])
		echo "Please give us your first name<br>";
	if($_SESSION["last_name_issue"])
		echo "Please give us your last name<br>";
	if($_SESSION["pw_issue"])
		echo "We require passwords at least six characters long.<br>";
	if($_SESSION["pw_match_issue"])
		echo "The passwords you gave did not match.<br>";
	if($_SESSION['dupe']){
		echo "Please use different name. That one is taken.<br>";
		unset($_SESSION['dupe']);
	}
}
?>
	</div>
	 <form method="post" action="process.php">
	 	<input type="hidden" name="check_submit" value="registering"/>
	    email: <input type="text" name="screen_name" /><br />
	    first name: <input type="text" name="first_name" /><br />
	    last name: <input type="text" name="last_name" /><br />
	    password: <input type="password" name="pw1" /><br />
	    repeat password: <input type="password" name="pw2" /><br />
	    <input type="submit" value="Create Your Account"/>
	</form>
</body>
</html>