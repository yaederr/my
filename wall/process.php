<?php session_start();
require "dbconn.php";
//this block adds comments sent from index.php
if($_POST['check_submit']=="reply" and isset($_SESSION["logged_in"])){
	add_comment(get_user_id($_SESSION["logged_in"]), $_POST["regarding"], clean_input($_POST["message"]));
		header('Location:index.php');
}
//this block adds messages sent from index.php
if($_POST['check_submit']=="add_message" and isset($_SESSION["logged_in"])){
	add_message(get_user_id($_SESSION["logged_in"]), clean_input($_POST["message"]));
		header('Location:index.php');
}
//this block logs people out when they send the get request
if(isset($_GET["logout"]))
	if($_GET['logout']=="true"){
		$_SESSION=[];
		header('Location:index.php');
}
//this block checks passwords and logs people in
if($_POST['check_submit']=="login"){
	$_SESSION["login_issue"]=false;
	if($_POST['pw1']==getPW($_POST['screen_name']) and $_POST["pw1"]!="")
		$_SESSION['logged_in']=$_POST['screen_name'];
	else{
		$_SESSION["login_issue"]=true;
	}
	header('Location:index.php');
}
//this block is responsible for creating new users
if($_POST['check_submit']=="registering"){
	//load up the variables with form data
	$screen_name = clean_input($_POST["screen_name"]);
	$first_name = clean_input($_POST["first_name"]);
	$last_name = clean_input($_POST["last_name"]);
	$pw1=$_POST["pw1"];
	$pw2=$_POST["pw2"];
	//check the data received through regex and other techniques
	$_SESSION["dupe"]=$_SESSION["first_name_issue"]=$_SESSION["last_name_issue"]=$_SESSION["screen_name_issue"]=$_SESSION["pw_issue"]=$_SESSION["pw_match_issue"]=false;
	if(!preg_match("/^[a-zA-Z]+/", $first_name))
		$_SESSION["first_name_issue"]=true;
	if(!preg_match("/^[a-zA-Z]+/", $last_name))
		$_SESSION["last_name_issue"]=true;
	if(!preg_match("/^[a-z0-9]{6,}/i", $pw1)) 
		$_SESSION["pw_issue"]=true;
	if(!preg_match("/^[a-z0-9]{6,}/i", $pw2))
		$_SESSION["pw_issue"]=true;
	if($pw1!=$pw2)
		$_SESSION["pw_match_issue"]=true;
	if(!filter_var($screen_name, FILTER_VALIDATE_EMAIL))
		$_SESSION["screen_name_issue"]=true;
	if(!$_SESSION["first_name_issue"] and
		!$_SESSION["screen_name_issue"] and
		!$_SESSION["pw_issue"] and
		!$_SESSION["pw_match_issue"] and
		!$_SESSION["last_name_issue"]){
		addDB($first_name, $last_name, $screen_name, $pw1);
		if(!$_SESSION['dupe']){
			$_SESSION['logged_in']=$screen_name;
			header('Location:index.php');				
		}
	}
	if(!$_SESSION["logged_in"])
		header('Location:register-nodb.php');
}

?>