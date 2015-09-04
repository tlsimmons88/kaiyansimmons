<?php
$this->load->view('include/DefaultWebPage.class.php');
$webpage = new DefaultWebPage();
$webpage->setActiveNav("Admin");
$topRightContent = "";
$topRightLink = "";
$html = "";

if($fb_data['userProfile']['id'] > 0)
{
	$topRightContent .= "Welcome ".$fb_data['userProfile']['first_name'];
	$topRightContent .= "<br>";
	$topRightContent .= "<a href='logout/index'>Logout</a>";

	if($isAdmin == true)
	{
		$html .= "<div id='upload-wrapper'>
					<div align='center'>
						<h3>File Uploader</h3>
						<form action='' method='post' enctype='multipart/form-data' id='MyUploadForm'>
							<br>
							<div align='left'>Description
								<br>
								<textarea id='file_description' rows='4' cols='45' name='file_description' form='MyUploadForm'></textarea>
							</div>
							<br>
							<div align='left'>Date Taken
								<br>
								<input type='text' id='date_taken'/>
							</div>
							<div align='left'>Tags
								<br>
								<input type='text' id='tags'/>
							</div>
							<br>
							<div align='left'>File
								<br>
								<input name='file_name' id='file_name' type='file' />
								<input type='submit'  id='submit-btn' value='Upload'/>
								<img src='/images/ajax-loader.gif' id='loading-img' style='display:none;' alt='Please Wait'/>
							</div>
						</form><br>

						<div id='output'></div>
					</div>
				</div><br>";
	}
	else
	{
		$html .= "You are not allowed to view this content.";
	}
}
else
{
	$topRightContent .= "Welcome";
	$topRightContent .= "<br>";
	$topRightContent .= "<a href='".$fb_data['loginUrl']."'>Login</a>";
	$html .= "You must be logged in to view this page.";
}
$webpage->setHeaderRightContent($topRightContent);
$webpage->setHeaderRightLinks($topRightLink);
$webpage->start();
echo $html;
$webpage->end();
?>
