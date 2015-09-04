<?php
$this->load->view('include/DefaultWebPage.class.php');
$webpage = new DefaultWebPage();
$webpage->setActiveNav("Videos");
$topRightContent = "";
$topRightLink = "";
$html = "";

if($fb_data['userProfile']['id'] > 0)
{
	$topRightContent .= "Welcome ".$fb_data['userProfile']['first_name'];
	$topRightContent .= "<br>";
	$topRightContent .= "<a href='logout/index'>Logout</a>";
}
else
{
	$topRightContent .= "Welcome";
	$topRightContent .= "<br>";
	$topRightContent .= "<a href='".$fb_data['loginUrl']."'>Login</a>";
}
$html .= "<div>
	           <label for='date_taken_from'>From</label>
			   <input type='text' id='date_taken_from' name='date_taken_from'>
			   <label for='date_taken_to'>To</label>
			   <input type='text' id='date_taken_to' name='date_taken_to'>
			   <label for='tags'>Album</label>
			   <input type='text' id='tags' name='tags'>
			   <button type='button' onclick='getMedia(2)'>Find Videos</button>
	      </div><br>";

$webpage->setHeaderRightContent($topRightContent);
$webpage->setHeaderRightLinks($topRightLink);
$webpage->start();
echo $html;
$webpage->end();
?>
