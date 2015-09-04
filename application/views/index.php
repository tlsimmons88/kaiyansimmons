<?php
$this->load->view('include/DefaultWebPage.class.php');
$webpage = new DefaultWebPage();
$webpage->setActiveNav("News");
$topRightContent = "";
$topRightLink = "";
$html = "";

if($fb_data['userProfile']['id'] > 0)
{
	$topRightContent .= "Welcome ".$fb_data['userProfile']['first_name'];
	$topRightContent .= "<br>";
	$topRightContent .= "<a href='logout/index'>Logout</a>";
	if($fb_data['isFriend'])
	{
		$html .= "News Test";
	}
	else
	{
		//$html .= "You are not allowed to view this content.";
	}

}
else
{
	$topRightContent .= "Welcome";
	$topRightContent .= "<br>";
	$topRightContent .= "<a href='".$fb_data['loginUrl']."'>Login</a>";
	//$html .= "You must be logged in to view this page."; 
}
$webpage->setHeaderRightContent($topRightContent);
$webpage->setHeaderRightLinks($topRightLink);
$webpage->start();
echo $html;
$webpage->end();
?>
