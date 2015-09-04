<?php
/*
 * AUTHOR:  Travis Simmons
 * DESCRIPTION:  The default WebPage to set the initinal settings by extending the Webpage.class.php
 *
 */
require_once 'WebPage.class.php';

class DefaultWebPage extends WebPage
{
	/*
	 * VARIABLES
	 */
	//PRIVATE
	private $title = "FMA::Family Memories App";
	private $version = null;
	private $nav = array(
		'News' => array('onClick' => "window.location = '/news';", 'applyTabSpacing' => false, 'active' => true),
		'Pictures' => array('onClick' => "window.location = '/pictures';", 'applyTabSpacing' => false, 'active' => false),
		'Videos' => array('onClick' => "window.location = '/videos';", 'applyTabSpacing' => false, 'active' => false),
		'Admin' => array('onClick' => "window.location = '/admin';", 'applyTabSpacing' => false, 'active' => false)
	);
	private $subNav = null;
	private $activeNav = null;
	private	$topRightContent = null;
	private $topRightLinks = null;
	private $faviconPath = null;
	private $meta = "<meta http-equiv='X-UA-Compatible' content = 'IE=edge'/>
					 <meta content='text/html;charset=utf-8' http-equiv='Content-Type'>
					 <meta content='utf-8' http-equiv='encoding'>";
	private $applicationName = "FMA";

	//Constructor
	public function __construct()
	{
		parent::__construct($this->title, $this->version, $this->nav, $this->subNav, $this->activeNav, $this->topRightContent, $this->topRightLinks, $this->faviconPath, $this->meta, $this->applicationName);
	}
}
?>
