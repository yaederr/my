<?php session_start();
require("dbconn.php");
if(!isset($_GET["incident"])){
	header("Location: index.php");
	die();
}
$incident = get_incident($_GET["incident"]);
 ?>
<html>
<head>
	<title>Record Details of <?php echo $incident["id"]; ?></title>
	<link rel="stylesheet" type="text/css" href="display.css">
</head>
<body>
	<div id="wrapper">
		<div id="specs">
			<p>Title: <?php echo $incident["title"]; ?></p>
			<p>Date: <?php echo gmdate("m-d-Y", $incident["happened"]); ?></p>
			<p>Description: <?php echo $incident["description"]; ?></p>
		</div>
		<div id="witnesses"><p>
			<?php $witnesses = get_witnesses($incident["id"]);
			if(count($witnesses)==1){
				echo "This incident was seen by one person.";
			}
			else{
				echo "This incident was seen by ".count($witnesses)." people";
			}?></p>
			<p>Seen by </p>
			<?php 
			foreach($witnesses as $witness){
				echo "<p class=\"witness\">".$witness["fname"]." ".$witness["lname"]."</p>";
			}
			 ?>
			<div id="links">
				<a href="index.php" id="leftarrow">Back to Home</a>
				<?php echo "<a id=\"rightarrow\" href=\"process.php?kill=".$_GET["incident"]."\" id=\"kill\">Delete this Incident</a>"; ?>
			</div>
	</div>
</body>
</html>