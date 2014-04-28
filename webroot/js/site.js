please_wait = "Loading please wait...";

//Set this so the jQuery lib of CI doesn't butt heads with mine
jQuery.noConflict();

//Setup Login Dialog
/*function init_login_dialog()
{
	var url =  jQuery("#facebook_login_url").text();
	alert(url);
	jQuery("#facebook_login").dialog({
		autoOpen: false,
		dragable: true,
		closeOnEscape: true,
		modal: true,
		title: "Facebook Login",
		height: 200,
		width: 500
	});
	load_login_dialog(url);
}

//Load the content of the login dialog
function load_login_dialog(url)
{
	jQuery("#facebook_login").html('<object data="'+url+' target="top"/>');
	jQuery("#facebook_login").dialog("open");
}*/