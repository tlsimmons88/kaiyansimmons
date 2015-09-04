<?php
$this->load->view('include/DefaultWebPage.class.php');
$webpage = new DefaultWebPage();
$webpage->setActiveNav("News");
$topRightContent = "";
$topRightLink = "";

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
$webpage->setHeaderRightContent($topRightContent);
$webpage->setHeaderRightLinks($topRightLink);
$webpage->start();
echo "<h1>404 - Page Not found</h1>";
echo "This is not the page you are looking for...";
$webpage->end();
?>
