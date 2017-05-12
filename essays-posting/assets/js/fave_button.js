//put +fave button if the currently viewed essay is not a fave, otherwise -fave
function adjust_fave_button(){
	$.ajax({
		type: "POST",
		url: "/faves/is_fave/",
		data: {eid:now_playing},
		success: function(fave_status){
			$("#fave_buttons").html("");
			if(fave_status){
				$("#fave_buttons").append("<button id=\"select_rm_fave\">Stop Keeping This As A Fave</button>");
			}
			else{
				$("#fave_buttons").append("<button id=\"select_add_fave\">+Fave</button>");
			}
			set_margin_function_right_hand();
		}
	});
}
$(document).on("click", "#select_add_fave", function(){
	if(now_playing){
		$.ajax({
			type: "POST",
			data: {eid:now_playing},
			url: app_uri+"faves/add",
			success: function(data){
				alert("this is now on your faves list");
			}
		});
	}
});
$(document).on("click", "#select_rm_fave", function(){
	if(now_playing){
		$.ajax({
			type: "POST",
			data: {eid:now_playing},
			url: app_uri+"faves/remove",
			success: function(data){
				if(data){
					alert("teleport successful");
				}
				else{
					alert("theyve broken through");
				}
			}
		});
	}
});