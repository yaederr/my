<?php 
session_start();
require("dbconn.php");
if(isset($_GET["logout"])){
	session_destroy();
	session_start();
	header("Location:index.php");
	die();
}
if(isset($_GET["saw"])){
	add_witness($_SESSION["logged_in"], $_GET["saw"]);
	header("Location:index.php");
	die();
}
if(isset($_GET["kill"])){
	delete_incident($_GET["kill"]);
	header("Location:index.php");
	die();
}
if(isset($_POST["check_submit"])){
	switch($_POST["check_submit"]){
		case "add_incident":
			$_SESSION["issues"]=[];
			$title = clean_input($_POST["title"]);
			$description = clean_input($_POST["description"]);
			if(!preg_match("/^.+/", $title))
				array_push($_SESSION["issues"], "<p class=\"issue_text\">You forgot to provide a title</p>");
			if(!preg_match("/^.+/", $description))
				array_push($_SESSION["issues"], "<p class=\"issue_text\">You forgot to provide a description</p>");
			if(count($_SESSION["issues"])<1){
				add_incident($title, $description, strtotime($_POST["date"]), $_SESSION["logged_in"]);
				$_SESSION["thanks_submit"]=1;
			}
			header("Location:index.php");
			die();
			break;
		case "registering":
			//load up the variables with form data
			$first_name = clean_input($_POST["first_name"]);
			$last_name = clean_input($_POST["last_name"]);
			$email = clean_input($_POST["email"]);
			$pw1=$_POST["pw1"];
			$pw2=$_POST["pw2"];
			//check the data received through regex and other techniques
			$_SESSION["issues"]=[];
			if(!preg_match("/^[a-zA-Z]+/", $first_name))
				array_push($_SESSION["issues"], "Please give a first name");
			if(!preg_match("/^[a-zA-Z]+/", $last_name))
				array_push($_SESSION["issues"], "Please give a last name");
			if(!preg_match("/^[a-z0-9]{6,}/i", $pw1)) 
				array_push($_SESSION["issues"], "Please make your password at least six characters.");
			if($pw1!=$pw2)
				array_push($_SESSION["issues"], "It seems your passwords did not match.");
			if(!filter_var($email, FILTER_VALIDATE_EMAIL))
				array_push($_SESSION["issues"], "Please ensure this is your email address.");
			//if there is exactly zero issues, log the user in. 
			if(count($_SESSION["issues"])<1){
				addDB($first_name, $last_name, $email, $pw1);
				if(!isset($_SESSION['dupe'])){
					$_SESSION['logged_in']=$email;
					header('Location:index.php');
					die();
					break;
				}
			}
			//else send usr back to registration page
			else{
				header('Location:registration.php');
				die();
				break;
			}
		case "login":
			unset($_SESSION["login_issue"]);
			if($_POST['pw1']==getPW($_POST['email']) and $_POST["pw1"]!="")
				$_SESSION['logged_in']=$_POST['email'];
			else
				$_SESSION["login_issue"]=1;
			header('Location:index.php');
			die();
			break;
	}
}
?>