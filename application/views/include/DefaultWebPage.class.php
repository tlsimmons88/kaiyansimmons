<?php
/*
 * AUTHOR:  Travis Simmons
 * DESCRIPTION:  The default WebPage to set the initinal settings by extending the Webpage.class.php
 *
 */
require_once 'commonui/WebPage.class.php';

class DefaultWebPage extends WebPage
{
	/*
	 * VARIABLES
	 */
	//PRIVATE
	private $title = "FMA::Family Memories App";
	private $version = "1.0";
	private $nav = array(
		'News' => array('onClick' => "window.location = 'index.php/news';", 'applyTabSpacing' => false, 'active' => true),
		'Images' => array('onClick' => "window.location = 'index.php/images';", 'applyTabSpacing' => false, 'active' => false),
		'Videos' => array('onClick' => "window.location = 'index.php/videos';", 'applyTabSpacing' => false, 'active' => false),
		'Admin' => array('onClick' => "window.location = 'index.php/admin';", 'applyTabSpacing' => false, 'active' => false)
	);
	private $subNav = null;
	private $activeNav = null;
	private	$topRightContent = null;
	private $topRightLinks = null;
	private $faviconPath = null;
	private $meta = "<meta http-equiv='X-UA-Compatible' content = 'IE=edge'/>";
	private $applicationName = "FMA";

	//Constructor
	public function __construct()
	{
		parent::__construct($this->title, $this->version, $this->nav, $this->subNav, $this->activeNav, $this->topRightContent, $this->topRightLinks, $this->faviconPath, $this->meta, $this->applicationName);
	}

	public function load_dialog_divs()
	{
		//echo "<div id='facebook_login' title='Login' style='display: none;'>Test Dialog</div";
	}
}
?>
