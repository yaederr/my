<!DOCTYPE html>
<html>
	<head>
		<script src="/assets/js/jquery.js"></script>
		<script src="/assets/js/jqueryui.js"></script>
		<script src="/assets/js/bootstrap.js"></script>
		<link rel="stylesheet" type="text/css" href="/assets/css/courses.css">
		<link rel="stylesheet" href="/assets/css/jqueryui.css">
		<link rel="stylesheet" type="text/css" href="/assets/css/bootstrap.css">
		<title>Posts</title>
		<script type="text/javascript">
			$(document).ready(function() {
				$(document).on("click", "button.edit_button", function() {
					$current_description = $("#" + this.id.substr(4) + ">.description").html();//i use substr to extract id
					$(".change_post_form>textarea").val($current_description);
					$(".modal").on("shown.bs.modal", function(e) {
						$(".change_post_form>textarea").select();
					});
				});
				//after post changed, the spec says we need to add it dynamically not fetching from the database
				$(document).on("submit", "form.change_post_form", function() {
					$.post($(this).attr('action'), $(this).serialize(), function(output) {
						//update view to remove deleted post
						output = eval('(' + output + ')');
						$("#" + output.id + ">p").html(output.d);
						$("#button" + output.id).modal('hide');
					});
					return false;
				});
				//after something is deleted, the spec says we need to remove it dynamically with javascript without fetching from the database
				$(document).on("click", "button.delete_button", function() {
					//this.id returns delete109 where 109 is an id. to extract id: call substring with index 6. button has six letters
					var remove = this.id.substr(6);
					//from callback data, figure out which one was removed and erase from screen
					$.get("/posts/delete_post/" + remove, function(output) {
						output = eval('(' + output + ')');
						$("#" + output.killed).remove(); 
					});
				});
				$('#add_post_form').submit(function() {
					$.post($(this).attr('action'), $(this).serialize(),
					function(output) {                     //this callback adds success or fail alert
						$(".alert").remove();
						if (output == "") {
							msg = "Error: please provide a description.";
						}
						else {
							//after we add a post, the spec says we need to add it dynamically not fetching from the database
							$(".blocks").append(output);
							msg = "Thanks for posting!";
							$("textarea").val("");
						}
						$("#add_post_pane").append("<p class=\"alert\">"+msg+"</p>");
					});
					return false;
				});
			});
		</script>
	</head>
	<body>
		<div id="wrapper">