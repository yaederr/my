$(document).ready(function(){
	update_gold_display();update_combat_log();
	activity = [
		"hunt", //activity[0]
		"farm", //activity[1]
		"mine", //activity[2]
		"gamble"//activity[3]
	]
	$("#"+activity[0]).click(function(){
		$.ajax({url: window.location+"/hunt",
			success: function(){
				update_gold_display();update_combat_log();
		}})
	})
	$("#"+activity[1]).click(function(){
		$.ajax({url: window.location+"/farm",
			success: function(){
				update_gold_display();update_combat_log();
		}})
	})
	$("#"+activity[2]).click(function(){
		$.ajax({url: window.location+"/mine",
			success: function(){
				update_gold_display();update_combat_log();

		}})
	})
	$("#"+activity[3]).click(function(){
		$.ajax({url: window.location+"/gamble",
			success: function(){
				update_gold_display();update_combat_log();

		}})
	})
})
function update_gold_display(){
	$.ajax({
		type: "POST",
		url: window.location,
		success: function(res){$("#count").text(res.gold+" gold");},//update gold displ
	});
}
function update_combat_log(){
	$.ajax({
		type: "POST",
		url: window.location+"/log",
		success: function(res){
			var history = "";
			for(var i=0; i<res.length; i++){
				history= history.concat("<span class=\"log\">"+res[i].event+"</span>")
			}
			$("#log").html(history);// set the log text
			//ensure the log box is scrolled to the bottom
			$("#log").scrollTop($('#log').prop('scrollHeight'));
		},
	});
}