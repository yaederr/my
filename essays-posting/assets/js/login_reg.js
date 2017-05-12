$(document).ready(function(){
	$(document).on("click", "#select_login", function(){//draw form for login
		$(".wedge").remove();
		now_playing=null;
		$.ajax({
			type: "POST",
			url: app_uri+"/users/login/",
			success: function(data){
				$("#essay").html(data);
				set_activated("select_login");
				set_margin_function_right_hand();//we must adjust margin again
			}
		});
	});
	$(document).on("click", "#select_logout", function(){//logout user
		$.ajax({
			type: "POST",
			url: app_uri+"users/logout",
			success: function(){
				logged_in = false;
				$("#select_logout").remove();
				$(".functions_greeting").remove();
				$("#right_hand").append("<button id=\"select_login\">Login</button>");
				set_margin_function_right_hand();//we must adjust margin again
			}
		});

	});
	$(document).on("click", "#select_registration", function(){//draw reg form
		$.ajax({
			type: "POST",
			url: app_uri+"users/register/",
			success: function(data){
				$("#essay").html(data);
				$("#select_dl").css("background-color", "white");
				$("#select_share").css("background-color", "white");
				$("#select_fave").css("background-color", "white");
			}
		});
	});
	$(document).on("submit", "#login_form", function(){//handle login submit
		$("#select_login").css("background-color", "white");
		var email = document.getElementById("login_form_email").value;
		var pw = document.getElementById("login_form_pw").value;
		$.ajax({
			type: "POST",
			url: app_uri+"users/post_login/",
			data:{email:email, pw:pw},
			success: function(login_success){
				$(".notice").remove();//remove previous signals
				if(login_success){//the login has been validated
					logged_in = true;
					//chg login to logout
					$("#select_login").remove();
					//only add the greeting after we hear from the server
					get_user_name(function(nom){
						$("#right_hand").append("<span class=\"functions_greeting\">Hi, "+nom+"</span><button id=\"select_logout\"> (Logout)</button>");
						set_margin_function_right_hand();
					});
					//switch back to essay view
					if(now_playing){
						$.ajax({
							type: "POST",
							data: {link:"./"+now_playing},
							url: "/essays/view/",
							success: function(data){
								$("#essay").html("<div>"+data+"</div>");
								$("#select_dl").css("background-color", "white");
								$("#select_share").css("background-color", "white");
								$("#select_fave").css("background-color", "white");
								add_wedge(now_playing);
							}
						});
					}
					else{
						$("#essay").html("<h1>Read essays. Pick from the left!</h1>");
					}
				}
				else{//inform user of the issue
					$("#login_form").append("<p class=\"notice\">We could not log you on with the information you provided.</p>")
				}
			}
		});
		return false;
	});
	$(document).on("submit", "#registration_form", function(){//do user reg
		var email = document.getElementById("reg_form_email").value;
		var name = document.getElementById("reg_form_name").value;
		var pw1 = document.getElementById("reg_form_pw1").value;
		var pw2 = document.getElementById("reg_form_pw2").value;
		$(".notice").remove();//get rid of old error messages
		$.ajax({
			type: "POST",
			url: app_uri+"users/post_register/",
			data:{email:email, name:name, pw1:pw1, pw2:pw2},
			success: function(data){
				if(data==1){//the registration has been validated
					//chg login to logout
					$(".select_login").remove();
					$("#right_hand").append("<div id=\"select_logout\">logout</div>")
					//switch back to essay view
					if(now_playing){
						$.ajax({
							type: "POST",
							data: {link:"./"+now_playing},
							url: "/essays/view/",
							success: function(data){
								$("#essay").html("<div>"+data+"</div>");
								$("#select_dl").css("background-color", "white");
								$("#select_share").css("background-color", "white");
								$("#select_fave").css("background-color", "white");
								add_wedge(now_playing);
							}
						});
					}
					else{
						$("#essay").html("<h1>Read essays. Pick from the left!</h1>");
					}
				}
				else{//write down the issues
					data = JSON.parse(data);
					if(data.email)
						$("#registration>#registration_form>label>#reg_form_email").closest("label").append("<span class=\"notice\">"+data.email+"</span>");
					if(data.name)
						$("#registration>#registration_form>label>#reg_form_name").closest("label").append("<span class=\"notice\">"+data.name+"</span>");
					if(data.pw1)
						$("#registration>#registration_form>label>#reg_form_pw1").closest("label").append("<span class=\"notice\">"+data.pw1+"</span>");
					if(data.pw2)
						$("#registration>#registration_form>label>#reg_form_pw2").closest("label").append("<span class=\"notice\">"+data.pw2+"</span>");
				}
			}
		});
		return false;
	});
});
function get_user_name(callback){
	$.ajax({
		type: "POST",
		url: "/users/name/",
		success: function(nom){
			callback(nom);
		}
	});
}