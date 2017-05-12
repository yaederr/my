<!DOCTYPE html>
<html>
	<head>
		<script src="/assets/js/jquery.js"></script>
		<script src="/assets/js/jqueryui.js"></script>
		<script src="/assets/js/bootstrap.js"></script>
		<link rel="stylesheet" type="text/css" href="/assets/css/courses.css">
		<link rel="stylesheet" href="/assets/css/jqueryui.css">
		<link rel="stylesheet" type="text/css" href="/assets/css/bootstrap.css">
		<title>Appointments</title>
		<script type="text/javascript">
            $(document).ready(function() {
                $(function() {
                    $("#date").datepicker();
                 });
            });
		</script>
	</head>
	<body>
		<div id="wrapper">
            <?php if($this->session->userdata("auth")){ ?>
            <div id="header">
                <p>Hi, <?php echo $data["fname"]; ?></p>
                <a href="/belt/logout">Logout</a>
            </div>
            <?php } ?>