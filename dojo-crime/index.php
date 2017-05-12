<?php session_start(); require("dbconn.php");?>
<!doctype html>
<html>
<head>
	<title>CDIN</title>
	<script src="jquery.js"></script>
	<link rel="stylesheet" type="text/css" href="crime.css">
	<link rel="stylesheet" href="jqueryui.css">
	<script src="jqueryui.js"></script>
	<script type="text/javascript">
		$(function() {
			$("#dateselect").datepicker();
		});
	</script>
</head>
<body>
	<div id="wrapper">
		<div id="notifications">
			<?php
			if(isset($_SESSION["thanks_submit"])){
				echo "<p>Thanks for submitting an incident report!</p>";
				unset($_SESSION["thanks_submit"]);
			}
			if(isset($_SESSION["issues"])){
				if(count($_SESSION["issues"])>0){
					while($issue = array_shift($_SESSION["issues"])){
						echo $issue."<br>";
					}
				}
			}?>
		</div>
			<?php
			print_greeting(isset($_SESSION["logged_in"]));
			if(isset($_SESSION["logged_in"])){
				$incidents = get_incidents();
				if(count($incidents)>0){
					echo "<div id=\"incident_table\">
					<h2>Incidents</h2>
					<table>
						<tr>
							<th>Incident</th>
							<th>Date</th>
							<th>Reported By</th>
							<th>I Saw</th>
							<th>Link</th>
						</tr>";
				
					foreach($incidents as $incident){
						echo "
							<tr>
								<td>".$incident["title"]."</td>
								<td>".gmdate("m-d-Y", $incident["happened"])."</td>
								<td>".$incident["fname"]."</td>
								<td><a href=\"process.php?saw=".$incident["iid"]."\"><button class=\"witness_button\">I saw this incident!</button></a></td>
								<td><a href=\"display.php?incident=".$incident["iid"]."\"><button class=\"link_button\">Go</button></a></td>
							</tr>
						";
					}
					echo"
					</table></div>";
				}
				echo "	
				<div id=\"add_incident_area\">
					<h2> Add an Incident </h2>
					<form method=\"post\" action=\"process.php\" id=\"login_form\">
						<input type=\"hidden\" name=\"check_submit\" value=\"add_incident\" />
						<label>name: <input type=\"text\" name=\"title\" /></label>
						<label>description: <input type=\"text\" name=\"description\" size=\"44\"/></label>
						<label>when did this happen? <input type=\"text\" name=\"date\" id=\"dateselect\"/></label>

						<input type=\"submit\" class=\"submit_form\" value=\"report this incident\"/>
					</form>
				</div>";
			}
			else{
					echo "
					<div id=\"login_area\">";
				if(isset($_SESSION["login_issue"])){
					echo "<p class=\"issue\">That username and password combination did not work.</p><br>";
					unset($_SESSION["login_issue"]);
				}
				echo "
						<form method=\"post\" action=\"process.php\" id=\"login_form\">
							<input type=\"hidden\" name=\"check_submit\" value=\"login\" />
							<label>email: <input type=\"text\" name=\"email\" /></label>
							<label>password: <input type=\"password\" name=\"pw1\" /></label>
							<input type=\"submit\" class=\"submit_form\" value=\"login\"/>
						</form>
						<a href=\"registration.php\">Or create account</a>
					</div>
					";
			}
			?>
	</div>
</body>
</html>