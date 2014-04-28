<?php
$this->load->view('include/DefaultWebPage.class.php');
$webpage = new DefaultWebPage();
$webpage->setActiveNav("News");
$topRightContent = "";
$topRightLink = "";

$webpage->setHeaderRightContent($topRightContent);
$webpage->setHeaderRightLinks($topRightLink);
$webpage->start();
echo "You have been logged out.";
$webpage->load_dialog_divs();
$webpage->end();
?>