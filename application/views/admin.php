<?php
$this->load->view('include/DefaultWebPage.class.php');
$webpage = new DefaultWebPage();
$webpage->setActiveNav("Admin");
$webpage->start();
echo "Admin Test";
$webpage->end();
?>
