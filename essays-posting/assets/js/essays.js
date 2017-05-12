var app_uri = "http://localhost:8888/";
var now_playing = null;
var logged_in = null;
$.ajax({//send xhr to discover whether anyone is logged in
	type: "POST",
	url: "/users/logstat/",
	success: function(login_status){logged_in = login_status;} 
});
$(function() {$( "#tree" ).accordion(); });
$(document).ready(function(){
	$("#select_upload").click(function(){
		$.ajax({
			url: app_uri+"/essays/upload",
			success: function(data){
				$("#essay").html(data);
				set_activated("select_upload");
				$(".wedge").remove();
			}
		});
	});
	$("#select_latest").click(function(){
		$.ajax({url: app_uri+"/essays/all",
		success: function(data){
			$("#tree").empty();
			for(var cat in data){
				if(data.hasOwnProperty(cat)){
					$("#tree").append("<h3>"+cat+"</h3>");//write cat name
					var string = "<div>";
					for(var i=0; i<data[cat].t.length; i++){//write essay names
						string = string.concat("<a class=\"read\" id=\""+data[cat].eid[i]+"\">"+data[cat].t[i]+"</a>")
					}
					string = string.concat("</div>");
					$("#tree").append(string);
				}
			}
			$('#tree').accordion("refresh");
			set_activated("select_latest");
			if(now_playing){//sometimes there is nothing on the essay view pane
				add_wedge(now_playing);//draw wedge to show what user is viewin
			}
		}})
	})
	$("#select_faves").click(function(){
		set_activated("select_faves");
		if(logged_in){
			$.ajax({url: app_uri+"faves/all",
			success: function(data){
				$("#tree").empty();
				for(var cat in data){
					if(data.hasOwnProperty(cat)){
						$("#tree").append("<h3>"+cat+"</h3>");//write cat name
						var string = "<div>";
						if(data[cat].t){
							for(var i=0; i<data[cat].t.length; i++){//write essay names
								string = string.concat("<a class=\"read\" id=\""+data[cat].eid[i]+"\">"+data[cat].t[i]+"</a>")
							}
							string = string.concat("</div>");
							$("#tree").append(string);
						}
						else{
							$("#tree").html("You not have any faves");
						}
					}
				}
				$('#tree').accordion("refresh");
				if(now_playing){//sometimes there is no essay being viewed
					add_wedge(now_playing);//mark the essay the user is viewing
				}
			}});
		}
		else{
			$("#tree").html("Please login in order to use this feature.");
		}
	})
	$("#select_share").click(function(){
		if(now_playing){//only allow sharing if something is being viewed
			$(".wedge").remove();
			$("#essay").html("<div>Share this with someone:<input id=\"send_email_to\" type=\"text\"><button class=\"share_button\">share</button><button class=\"return_to_essay\">back</button></div><div>Permanent Link<input class=\"uri_display\" value=\""+app_uri+now_playing+"\"/></div>");
			set_activated("select_share");
			$(".share_button").click(function(){//send email
				alert("somehow i will send an email to "+$("#send_email_to").val());
			});
			$(".return_to_essay").click(function(){//load essay view
				$.ajax({
					type: "POST",
					data: {link:"./"+now_playing},
					url: "/essays/view/",
					success: function(data){
						$("#essay").html("<div>"+data+"</div>");
						add_wedge(now_playing);
						set_reading_lights();
					}
				});
			})
			$(".uri_display").click(function(){//if user clicks box, select uri
				$(this).select();
			});
		}
	})
	$(document).on("click", ".read", function(){//user wants to view an essay
		$("#essay").empty();//clear essay pane because we want to show another
		$.ajax({
			type: "POST",
			data: {eid:this.id},
			url: app_uri+"/essays/view/",
			success: function(data){
				$("#essay").html("<div>"+data+"</div>");
				set_reading_lights();
			}
		});
		$(".wedge").remove();
		add_wedge(this.id);
	});

});
function add_wedge(id){//mark the list indicating the essay currently shown
	now_playing = id;//this line is the only place where now_playing is changed
	var elem = document.getElementById(id);
	$(elem).prepend("<span class=\"wedge\">></span>");
	adjust_fave_button();
}
function set_activated(elem){//turn on indicator. snuff the others on that side
	var bank_left = document.getElementById("left_hand");
	var bank_right = document.getElementById("right_hand");
	// console.log(bank_left);

	if(bank_left.children.namedItem(elem)){//we are dealing with the left side
		for(var i=0; i<bank_left.children.length; i++){
			$("#"+bank_left.children[i].id).css("background-color", "white");
		}
	}
	else{//we are on the right side
		for(var i=0; i<bank_right.children.length; i++){
			$("#"+bank_right.children[i].id).css("background-color", "white");
		}
	}
	$("#"+elem).css("background-color", "limegreen");
}
// function set_activated(elem){//turn on indicator. snuff the others on that side
// 	var bank_left = ["select_latest", "select_faves"];
// 	var bank_right = ["select_login", "select_fave", "select_upload", "select_login"];
// 	if(bank_left.indexOf(elem)>=0){//deal with activating a light on left
// 		for(var i=0; i<bank_left.length; i++){//snuff indicators on this side
// 			$("#"+bank_left[i]).css("background-color", "white");
// 		}
// 		$("#"+elem).css("background-color", "limegreen");
// 	}
// 	if(bank_right.indexOf(elem)>=0){//deal with activating a light on right
// 		for(var i=0; i<bank_right.length; i++){//snuff indicators on this side
// 			$("#"+bank_right[i]).css("background-color", "white");
// 		}
// 		$("#"+elem).css("background-color", "limegreen");
// 	}
// }
//turn off all indicators on RHS. use when someone clicks an essay
function set_reading_lights(){
	var elements = $("#right_hand").children();
	for(var i=0; i<elements.length; i++){
		elements.css("background-color", "white");
	}
}