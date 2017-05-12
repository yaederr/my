<?php 
$database=array(
	"db_address"=>"localhost",
	"db_user"=>"root",
	"db_pw"=>"root",
	"db_schema"=>"wall"
);


function print_greeting(){
	global $database;
	$con=mysqli_connect($database["db_address"], $database["db_user"], $database["db_pw"], $database["db_schema"]);
 	if (mysqli_connect_errno())
 		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	$id=mysqli_fetch_array(mysqli_query($con,"
			SELECT email FROM users
			WHERE email='".$_SESSION["logged_in"]."'"))['email'];
	echo "<p id=\"greeting\"> welcome, ".$id."</p>";
	mysqli_close($con);
}
function get_messages(){
	global $database;
	$con=mysqli_connect($database["db_address"], $database["db_user"], $database["db_pw"], $database["db_schema"]);
	$messages=[];
	$result=mysqli_query($con,"SELECT * FROM messages ORDER BY updated_at DESC");
	while($row = mysqli_fetch_array($result)){
        $messages[] = $row;
    }
	mysqli_close($con);
	return $messages;
}
function get_comments($post_id){
	global $database;
	$con=mysqli_connect($database["db_address"], $database["db_user"], $database["db_pw"], $database["db_schema"]);
	$comments=[];
	$result=mysqli_query($con,"
		SELECT * FROM comments
		WHERE comments.message_id = ".$post_id."
		");
	while($row = mysqli_fetch_array($result)){
        $comments[] = $row;
    }
	mysqli_close($con);
	return $comments;
}
function get_user_name($id){
	global $database;
	$con=mysqli_connect($database["db_address"], $database["db_user"], $database["db_pw"], $database["db_schema"]);
	$name=mysqli_fetch_array(mysqli_query($con,"
			SELECT users.email FROM users
			WHERE users.id=".$id."
		"));
	mysqli_close($con);
	return $name["email"];
}
function addDB($first_name, $last_name, $email, $pw){
	global $database;
	$con=mysqli_connect($database["db_address"], $database["db_user"], $database["db_pw"], $database["db_schema"]);
	if(!is_null(get_user_id($email,$database)))
		$_SESSION["dupe"]=true;

	else
		mysqli_query($con,"
				INSERT INTO users(fname, lname, email, pw,created_at,updated_at)
				VALUES ('".$first_name."','".$last_name."','".$email."','".$pw."',Now(),Now())");
	mysqli_close($con);
}
function add_message($user, $message){
	global $database;
	$con=mysqli_connect($database["db_address"], $database["db_user"], $database["db_pw"], $database["db_schema"]);
	mysqli_query($con,"
			INSERT INTO messages(user_id, message,created_at,updated_at)
			VALUES ('".$user."','".$message."',Now(),Now())");
	mysqli_close($con);
}
function add_comment($user, $regarding, $message){
	global $database;
	$con=mysqli_connect($database["db_address"], $database["db_user"], $database["db_pw"], $database["db_schema"]);
	mysqli_query($con,"
			INSERT INTO comments(user_id, message_id, comment,created_at,updated_at)
			VALUES ('".$user."','".$regarding."','".$message."',Now(),Now())");
	mysqli_close($con);
}
function get_user_id($email){
	global $database;
	$con=mysqli_connect($database["db_address"], $database["db_user"], $database["db_pw"], $database["db_schema"]);
	$id=mysqli_fetch_array(mysqli_query($con,"
				SELECT users.id FROM users
				WHERE users.email = '".$email."'"));
	mysqli_close($con);
	return $id["id"];
}
function clean_input($data) {
	global $database;
	$con=mysqli_connect($database["db_address"], $database["db_user"], $database["db_pw"], $database["db_schema"]);
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	$data = mysqli_real_escape_string($con, $data);
  return $data;
}
function getPW($user){
	global $database;
	$con=mysqli_connect($database["db_address"], $database["db_user"], $database["db_pw"], $database["db_schema"]);
	$pw= mysqli_fetch_array(mysqli_query($con,"
			SELECT pw FROM users
			WHERE email='".$user."'"))["pw"];
	mysqli_close($con);
	return $pw;
}				
?>