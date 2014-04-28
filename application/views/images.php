<?php
$this->load->view('include/DefaultWebPage.class.php');
$webpage = new DefaultWebPage();
$webpage->setActiveNav("Images");
$webpage->start();
echo "Images Test";
$webpage->end();
?>
