<?php 
$database=array(
	"db_address"=>"localhost",
	"db_user"=>"root",
	"db_pw"=>"root",
	"db_schema"=>"crime"
); 
function delete_incident($incident_id){
	global $database;
	$con=mysqli_connect($database["db_address"], $database["db_user"], $database["db_pw"], $database["db_schema"]);
	mysqli_multi_query($con, "delete from sitings where sitings".'.'."incidents_id=".$incident_id."; delete from incidents where incidents".'.'."id=".$incident_id);
	mysqli_close($con);
}
function add_witness($email, $incidents_id){
	global $database;
	$con=mysqli_connect($database["db_address"], $database["db_user"], $database["db_pw"], $database["db_schema"]);
	mysqli_query($con,"insert into sitings(users_id, incidents_id, created_at, updated_at)
		VALUES ('".$email."',".$incidents_id.",".time().",".time().")");
		mysqli_close($con);
}
function get_witnesses($incident_id){
	global $database;
	$con=mysqli_connect($database["db_address"], $database["db_user"], $database["db_pw"], $database["db_schema"]);
	$witnesses=[];
	$result = mysqli_query($con, "select users".'.'."fname, users".'.'."lname from sitings left join users on sitings".'.'."users_id=users".'.'."email
		where sitings".'.'."incidents_id=".$incident_id);
	while($row=mysqli_fetch_array($result)){
		$witnesses[] = $row;
	}
	mysqli_close($con);
	return $witnesses;
}
function get_incident($id){
	global $database;
	$con=mysqli_connect($database["db_address"], $database["db_user"], $database["db_pw"], $database["db_schema"]);
	$result=mysqli_fetch_array(mysqli_query($con, "
		select * from incidents where incidents".'.'."id=".$id));    
	mysqli_close($con);
	return $result;
}
function get_incidents(){
	global $database;
	$con=mysqli_connect($database["db_address"], $database["db_user"], $database["db_pw"], $database["db_schema"]);
	$incidents=[];
	$result = mysqli_query($con, "
		select incidents".'.'."happened, incidents".'.'."id as 'iid', incidents".'.'."title, incidents".'.'."description, incidents".'.'."user_id, incidents".'.'."created_at, users".'.'."fname, users".'.'."lname, users".'.'."email 
		from incidents left join users on users".'.'."email=incidents".'.'."user_id order by incidents".'.'."updated_at desc");
	while(($row = mysqli_fetch_array($result))){
        $incidents[] = $row;
    }
	mysqli_close($con);
	return $incidents;
}
function add_incident($title, $description, $when, $email){
	global $database;
	$con=mysqli_connect($database["db_address"], $database["db_user"], $database["db_pw"], $database["db_schema"]);
		mysqli_query($con,"insert into incidents(title, description, user_id, happened, created_at, updated_at) VALUES ('".$title."','".$description."','".$email."',".$when.",".time().",".time().")");
		mysqli_query($con, "
			insert into sitings(users_id, incidents_id, created_at, updated_at)
			values ('".$_SESSION["logged_in"]."',".mysqli_insert_id($con).",".time().",".time().")");
		mysqli_close($con);
}
function print_greeting($is_member){
	if($is_member)
		echo "
			<div id=\"status\">
				<a href=\"index.php\"><img alt=\"logo\" src=\"logo.png\"><a>
				<p> Welcome, ".$_SESSION["logged_in"]."</p>
				<a href=\"process.php?logout=true\" id=\"logout\">Logout</a>
			</div>";
	else
		echo "
		<div id=\"status\">
			<a href=\"index.php\"><img alt=\"logo\" src=\"logo.png\"><a>
			<p> Login to see crime reports in your local dojo area!</p>
		</div>";	
}
function getPW($email){
	global $database;
	$con=mysqli_connect($database["db_address"], $database["db_user"], $database["db_pw"], $database["db_schema"]);
	$pw= mysqli_fetch_array(mysqli_query($con,"
			SELECT password FROM users
			WHERE email='".$email."'"))["password"];
	mysqli_close($con);
	return $pw;
}
function addDB($first_name, $last_name, $email, $pw){
	global $database;
	$con=mysqli_connect($database["db_address"], $database["db_user"], $database["db_pw"], $database["db_schema"]);
	//null getuser means the user is unique one. the opposite means its a dupe
	if(!is_null(get_user_id($email)))
		$_SESSION["dupe"]=true;
	else
		mysqli_query($con,"
				INSERT INTO users(fname, lname, email, password,created_at,updated_at)
				VALUES ('".$first_name."','".$last_name."','".$email."','".$pw."',".time().",".time().")");
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
function get_user_name($email){
	global $database;
	$con=mysqli_connect($database["db_address"], $database["db_user"], $database["db_pw"], $database["db_schema"]);
	$name=mysqli_fetch_array(mysqli_query($con,"
			SELECT * FROM users
			WHERE users.email='".$email."'"));
	mysqli_close($con);
	return substr($name["fname"], 0 , 1).".".$name["lname"];
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
?>