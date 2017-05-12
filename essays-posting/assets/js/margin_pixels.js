//there are several events that can screw up the way the function bar renders
//set the css properly using this function
function set_margin_function_right_hand(){
	$("#right_hand").css("margin-left",get_left_margin()+"px");
}
//the left margin on the right hand menu depends on
//	the presence of the fave button
//	the length of the user name
function get_left_margin(){
	var wrapper=lhs=fave_buttons=upload=log=greet=0;
	//get the width of all elements on the right side and remove the px suffix
	wrapper = $("#wrapper").css("width").replace(/[^0-9]/g, '');
	upload = $("#select_upload").css("width").replace(/[^0-9]/g, '');
	fave_buttons = $("#fave_buttons").css("width").replace(/[^0-9]/g, '');
	if(document.getElementById("select_logout"))
		log = $("#select_logout").css("width").replace(/[^0-9]/g, '');
	else
		log = $("#select_login").css("width").replace(/[^0-9]/g, '');
	if(document.getElementById("functions_greeting"))
		greet =$(".functions_greeting").css("width").replace(/[^0-9]/g,'');
	lhs = $("#left_hand").css("width").replace(/[^0-9]/g, '');
	return wrapper - lhs - fave_buttons - upload - log - greet-30;
}