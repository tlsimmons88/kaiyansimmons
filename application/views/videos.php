<?php
$this->load->view('include/DefaultWebPage.class.php');
$webpage = new DefaultWebPage();
$webpage->setActiveNav("Videos");
$webpage->start();
echo "Videos Test";
$webpage->end();
?>
