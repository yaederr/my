
<?php if(count($today)==0 and count($future)==0){ echo "<p>No tasks yet. Add one!</p>";} ?>
<?php if(count($today)>0){ ?>
<h2>Today's Tasks (<?php echo date("F j, Y"); ?>)</h2>
<table>
	<tr>
		<th>Task</th>
		<th>Time</th>
		<th>Status</th>
		<th>Action</th>
	</tr>
<?php for($i=0; $i<count($today); $i++){ ?>
	<tr>
		<td><?php echo $today[$i]["d"]; ?></td>
		<td><?php echo date("H:i:s", $today[$i]["time"]); ?></td>
		<td><?php echo $today[$i]["status"]; ?></td>
		<td><a href=<?php echo "\"/belt/delete/".$today[$i]["id"]."\""; ?>>Delete</a></td>
	</tr>
<?php } ?>
</table>
<?php } ?>
<?php if(count($future)>0){ ?>
<h2>Tasks for Later</h2>
<table>
	<tr>
		<th>Task</th>
		<th>Time</th>
		<th>Time</th>
		<th>Action</th>
	</tr>
	<?php for($i=0; $i<count($future); $i++){ ?>
	<tr>
		<td><?php echo $future[$i]["d"]; ?></td>
		<td><?php echo date("F j", $future[$i]["time"]); ?></td>
		<td><?php echo date("H:i:s", $future[$i]["time"]); ?></td>
		<td><a href=<?php echo "\"/belt/delete/".$future[$i]["id"]."\""; ?>>Delete</a></td>
	</tr>	
	<?php } ?>
</table>
<?php } ?>