<?php session_start();
require "dbconn.php";

echo "
<html>
<head>
	<title>MyWall</title>
	<link rel=\"stylesheet\" type=\"text/css\" href=\"wall.css\">
	<link rel=\"stylesheet\" type=\"text/css\" href=\"jqueryui.css\">
	<script type=\"text/javascript\" src=\"jquery.js\"></script>
	<script type=\"text/javascript\" src=\"jqueryui.js\"></script>
	<script type=\"text/javascript\">
		$(document).ready(function(){
			$(\".reply\").hide();
			$(\".start_reply\").click(function(){
				$(this).next().toggle();
				if($(this).html()==\"Reply to this message\")
					$(this).html(\"Stop Replying\");
				else
					if($(this).html()==\"Stop Replying\")
						$(this).html(\"Reply to this message\");
			});
		});
	</script>
</head>
<body>
	<div id=\"wrapper\">
";
//if the user is logged in, show the messages
//$_SESSION['logged_in'] shall hold the id of the logged in user
if(isset($_SESSION['logged_in'])){
	echo "
		<div id=\"controls\">
		<a href=\"index.php\" id=\"logo\">My Wall</a>
	";
	print_greeting();
	echo "
			<a href=\"process.php?logout=true\" id=\"logout\">Logout</a>
		</div>
	
		<div id=\"message_adding\">
			<form method=\"post\" action=\"process.php\">
				<input type=\"hidden\" name=\"check_submit\" value=\"add_message\" />
 				<textarea rows=\"4\" cols=\"81\" name=\"message\"></textarea>
 				<input type=\"submit\" value=\"post\"/>
			</form>
		</div>
		<div id=\"messages\">";
		//here we must print out all messages
		foreach(get_messages() as $msg){
			echo "
			<div class=\"message\">
				<p>".get_user_name($msg["user_id"])." said ".$msg["message"]."</p>";
			//write all comments that target this message
			foreach(get_comments($msg["id"]) as $comment){
				echo "<p class=\"comment\">".get_user_name($comment["user_id"])." comments ".$comment["comment"]."</p>";
			}
			echo "
				<button class=\"start_reply\">Reply to this message</button>
					<form method=\"post\" action=\"process.php\" class=\"reply\">
						<input type=\"hidden\" name=\"check_submit\" value=\"reply\" />
						<input type=\"hidden\" name=\"regarding\" value=\"".$msg["id"]."\" />
			 			<textarea rows=\"4\" cols=\"81\" name=\"message\"></textarea>
			 			<input type=\"submit\" value=\"send reply\"/>
					</form>
				</div>
			";
		}
		echo "
		</div>
	";
}
//this means the user is not logged in. we show a generic page.
else{
	if($_SESSION["login_issue"]){
		echo "That user and password combination does not match our records. Please try again.";
		unset($_SESSION["login_issue"]);
	}
	echo "
		<form method=\"post\" action=\"process.php\">
			<input type=\"hidden\" name=\"check_submit\" value=\"login\" />
			email: <input type=\"text\" name=\"screen_name\" /><br>
			password: <input type=\"password\" name=\"pw1\" /><br>
			<input type=\"submit\" value=\"login\"/>
		</form>
		<div>
			<a href=\"register-nodb.php\">Or create account</a>
		</div>";
}
echo "
	</div>
</body>
</html>
";

?>