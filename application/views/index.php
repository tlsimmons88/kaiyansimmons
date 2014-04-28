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
	//$topRightContent .= "<a href='index.php/logout'> My Logout URL </a>";
	//$topRightContent .= "<a href='".$fb_data['logoutUrl']."'>Logout</a>";
	//$topRightContent .= $fb_data['logoutUrl'];
	$topRightContent .= "<a href='index.php/logout/index'> My Logout URL </a>";
}
else
{
	$topRightContent .= "Welcome";
	$topRightContent .= "<br>";
	//$topRightContent .= "<a href='".$fb_data['loginUrl']."' class='login'>Login</a>";
	//$topRightContent .= "<span onclick='init_login_dialog();' >My Login URL</span>";
	//$topRightContent .= "<span id='facebook_login_url'>".$fb_data['loginUrl']."</span>";
	//$topRightContent .= "<a href='index.php/login'> My Login URL </a>";
	$topRightContent .= "<a href='index.php/login/index'> My Login URL </a>";

}
$webpage->setHeaderRightContent($topRightContent);
$webpage->setHeaderRightLinks($topRightLink);
$webpage->start();
echo "News Test";
$webpage->load_dialog_divs();
$webpage->end();
?>
