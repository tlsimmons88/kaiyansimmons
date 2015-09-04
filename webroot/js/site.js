please_wait = "Loading please wait...";

//Set this so the jQuery lib of CI doesn't butt heads with mine
jQuery.noConflict();

jQuery(document).ready(function(){
	//Init Facebook JS SDK
	window.fbAsyncInit = function(){
		FB.init({
			appId: '563563110405200',
			xfbml: true,
			version: 'v2.0'
		});
	};

	(function(d, s, id)
	{
		var js, fjs = d.getElementsByTagName(s)[0];
		if (d.getElementById(id)) {
			return;
		}
		js = d.createElement(s);
		js.id = id;
		js.src = "//connect.facebook.net/en_US/sdk.js";
		fjs.parentNode.insertBefore(js, fjs);
	}
	(document, 'script', 'facebook-jssdk'));

	jQuery(".fancybox").fancybox({
		width: 300, // so fancybox doesn't shrink way too much
		helpers: {
			title: {
				type: "inside"
			}
		},
		afterLoad: function() {
			this.title += ':  <a href="' + this.href + '"><button>DOWNLOAD</button></a> \n\
							  <br>\n\
							  <div class="fb-comments" data-href="' + this.href + '" data-num-posts="2" data-width="400"></div>';
		},
		beforeShow: function() {
			jQuery.fancybox.wrap.bind("contextmenu", function(e) {
				return false;
			});
		},
		afterShow: function() {
			FB.XFBML.parse();			//reparse the dom after getting data back from FB
			jQuery.fancybox.update();	// resize after show
		}
	});

	//Date picker for Pictures and Videos page
	jQuery("#date_taken_from").datepicker();
	jQuery("#date_taken_from").datepicker("setDate", "-1");

	jQuery("#date_taken_to").datepicker();
	jQuery("#date_taken_to").datepicker("setDate", new Date().toLocaleDateString("en-US"));

	//Date picker for Admin page
	jQuery("#date_taken").datepicker();
	jQuery("#date_taken").datepicker("setDate", new Date().toLocaleDateString("en-US"));

	jQuery('#MyUploadForm').submit(function(){
		//Grab data from upload form
		var formData = new FormData(jQuery('#MyUploadForm')[0]);
		var file_name = jQuery('#file_name').val() || '';
		var file_description = jQuery('#file_description').val() || '';
		var date_taken = jQuery('#date_taken').val() || new Date().toLocaleDateString("en-US");
		var tags = jQuery('#tags').val() || '';

		formData.append('file_name', file_name);
		formData.append('file_description', file_description);
		formData.append('date_taken', date_taken);
		formData.append('tags', tags);

		//Validation
		if(file_name === ""){
			jQuery("#output").html("Please select a file.").css('color', 'red');
			return false;
		}

		var file_type = jQuery('#file_name')[0].files[0].type;

		//allow only valid image file types
		switch(file_type){
			case 'image/png': case 'image/gif': case 'image/jpeg':
				formData.append('file_type', file_type);
				break;
			default:
				jQuery("#output").html("Unsupported file type.").css('color', 'red');
				return false;
		}

		jQuery('#submit-btn').hide();
		jQuery('#loading-img').show();
		jQuery("#output").html("");

		//AJAX
		jQuery.ajax({
			url: "api/rest/upload",
			type: "POST",
			data:  formData,
			cache: false,
			dataType: 'json',
			processData: false, // Don't process the files
			contentType: false, // Set content type to false as jQuery will tell the server its a query string request
			success:  function(response){
				if(response['status'] === "OK"){
					jQuery("#output").html(response['message']);
				}
				else{
					var jsonString = JSON.stringify(response);
					jQuery("#output").html(jsonString).css('color', 'red');;
				}
				jQuery('#submit-btn').show(); //hide submit button
				jQuery('#loading-img').hide(); //hide submit button
			},
			error:  function(response){
				if(response['status'] === "OK"){
					jQuery("#output").html(response['message']);
				}
				else{
					var jsonString = JSON.stringify(response);
					jQuery("#output").html(jsonString).css('color', 'red');;
				}
				jQuery('#submit-btn').show(); //hide submit button
				jQuery('#loading-img').hide(); //hide submit button
			}
		});

		// always return false to prevent standard browser submit and page navigation
		return false;
	});
});


function getMedia(type_id){
	var date_taken_from = jQuery("#date_taken_from").val();
	var date_taken_to = jQuery("#date_taken_to").val();
	var data = {
		'date_taken_from':  date_taken_from,
		'date_taken_to':  date_taken_to,
		'type_id':  type_id
	}

	//AJAX
		jQuery.ajax({
			url: "api/rest/media_by_date?from=2015-01-03&to=2015-01-03",
			type: "GET",
			data:  data,
			cache: false,
			dataType: 'json',
			processData: false, // Don't process the files
			contentType: false, // Set content type to false as jQuery will tell the server its a query string request
			success:  function(response)
			{
				if(response['status'] === "OK")
				{
					var string = "";
					var media = JSON.parse(response['data']);

					for (var key in media) {
						if (media.hasOwnProperty(key)) {
						   var obj = media[key];
						   for (var prop in obj) {
							  if (obj.hasOwnProperty(prop)) {
								 alert(prop + " = " + obj[prop]);
							  }
						   }
						}
					 }

					//obj = JSON.parse(json);
					for (var i = 0; i <= media.length; i++) {
						alert(i);
						/*if(media[i].type_id === "1"){
							string += "<a class='fancybox' rel='group' href='" + location.orign + "/" + media[i].file_location + "' title='" + media[i].file_description + "'><img src='" + location.orign + "/" + media[i].thumb_location + "'</a>";
						}*/
					}
					alert(media[0].type_id);
					alert(string);
					location.origin = location.protocol + "//" + location.host;
					//alert(location.origin);
					//var string = "<a class='fancybox' rel='group' href='" + location.orign + "/" + $picture['file_location'] + "' title='" + media[i].file_description + "'><img src='" + location.orign + "/" + media[i]['thumb_location'] + "'</a>";
					//alert(string);
					//jQuery("#pictures_gallery").html("<a class='fancybox' rel='group' href='" + location.orign+"/" + $picture['file_location'] + "' title='" + $picture['file_description'] + "'><img src='" + location.orign+"/" + $picture['thumb_location'] + "'</a>");
					jQuery("#output").html(response['message'] + "<br>" + response['details']);
				}
				else
				{
					var jsonString = JSON.stringify(response);
					jQuery("#output").html(jsonString).css('color', 'red');;
				}
				jQuery('#submit-btn').show(); //hide submit button
				jQuery('#loading-img').hide(); //hide submit button
			},
			error:  function(response)
			{
				if(response['status'] === "OK")
				{
					jQuery("#output").html(response['message']);
				}
				else
				{
					var jsonString = JSON.stringify(response);
					jQuery("#output").html(jsonString).css('color', 'red');;
				}
				jQuery('#submit-btn').show(); //hide submit button
				jQuery('#loading-img').hide(); //hide submit button
			}
		});
}

/*
 * Methods for File Uplaod
 */
/*function afterSuccess()
{
	jQuery('#submit-btn').show(); //hide submit button
	jQuery('#loading-img').hide(); //hide submit button

}

//function to check file size before uploading.
function beforeSubmit()
{
	//check whether browser fully supports all File API
	if (window.File && window.FileReader && window.FileList && window.Blob)
	{
		if( !jQuery('#file_input').val()) //check empty input filed
		{
			jQuery("#output").html("Please select a file first.");
			return false
		}

		var fsize = $('#file_input')[0].files[0].size; //get file size
		var ftype = $('#file_input')[0].files[0].type; // get file type


		//allow only valid image file types
		switch(ftype)
		{
			case 'image/png': case 'image/gif': case 'image/jpeg': case 'image/pjpeg':
				break;
			default:
				jQuery("#output").html("<b>"+ftype+"</b> Unsupported file type!");
				return false
		}

		//Allowed file size is less than 10 MB (10000000)
		if(fsize>10000000)
		{
			$("#output").html("<b>"+bytesToSize(fsize) +"</b> The file is too big.  Please ensure it is under 10 MB");
			return false
		}

		jQuery('#submit-btn').hide(); //hide submit button
		jQuery('#loading-img').show(); //hide submit button
		jQuery("#output").html("");
	}
	else
	{
		//Output error to older browsers that do not support HTML5 File API
		$("#output").html("Please upgrade your browser, because your current browser lacks some new features we need!");
		return false;
	}
}

//function to format bites bit.ly/19yoIPO
function bytesToSize(bytes)
{
	var sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
	if (bytes == 0) return '0 Bytes';
	var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
	return Math.round(bytes / Math.pow(1024, i), 2) + ' ' + sizes[i];
}*/