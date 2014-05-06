<?
class WebPage
{
	private $doctype = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">';
	private $css = array('/css/jquery-ui-1.10.4.custom.css','/css/commonUIStyle.css');
	private $js = array('/js/jquery-1.10.2.js','/js/jquery-ui-1.10.4.custom.js', '/js/site.js');
	private $meta = "";
	private $onload = "";
	private $title = "";
	private $baseAddress = "/";
	private $version = '1';
	private $activeNav = "";
	private $navBar = array();
	private $subNavBar = array();
	private $headerRightContent = "";
	private $headerRightLinks = "";
	private $faviconPath = "";
	private $applicationName = "";

	public function __construct($title = null, $version = null, $nav = null, $subNav = null, $activeNav = null, $topRightContent=null, $topRightLinks = null, $faviconPath = null, $meta = null, $applicationName = null)
	{
		if($title) $this->title = $title;
		if($version) $this->version = $version;
		if($nav) $this->navBar = $nav;
		if($subNav) $this->subNavBar = $subNav;
		if($activeNav) $this->setActiveNav($activeNav);
		if($topRightContent) $this->headerRightContent = $topRightContent;
		if($topRightLinks) $this->headerRightLinks = $topRightLinks;
		if($faviconPath) $this->faviconPath = $faviconPath;
		if($meta) $this->meta = $meta;
		if($applicationName) $this->applicationName = $applicationName;
	}

	public function addCss($css)
	{
		if($css)
		{
			if(is_array($css))
			{
				foreach($css as $str)
				{
					$this->css[] = $str;
				}
			}
			else
			{
				$this->css[] = $css;
			}
		}
	}

	public function addJs($js)
	{
		if($js)
		{
			if(is_array($js))
			{
				foreach($js as $str)
				{
					$this->js[] = $str;
				}
			}
			else
			{
				$this->js[] = $js;
			}
		}
	}

	public function addOnload($str)
	{
		$this->onload .= $str;
	}

	public function setTitle($str)
	{
		$this->title = $str;
	}

	public function setBaseAddress($str)
	{
		$this->baseAddress = $str;
	}

	public function setFaviconPath($str)
	{
		$this->faviconPath = $str;
	}

	public function setVersion($str)
	{
		$this->version = $str;
	}

	public function setNavBar($arr)
	{
		$this->navBar = $arr;
	}

	public function setSubNavBar($arr)
	{
		if($arr && is_array($arr))
		{
			$this->subNavBar = $arr;
		}
	}

	public function setActiveNav($str)
	{
		if($this->navBar[$str])
		{
			foreach($this->navBar as $title => $n)
			{
				if($this->navBar[$title]['active'] == true)
				{
					$this->navBar[$title]['active'] = false;
				}
			}
			$this->activeNav = $str;
			$this->navBar[$str]['active'] = true;
		}
	}

	public function setHeaderRightContent($str)
	{
		$this->headerRightContent = $str;
	}

	public function setHeaderRightLinks($str)
	{
		$this->headerRightLinks = $str;
	}

	public function setApplicationName($str)
	{
		$this->applicationName = $str;
	}

	public function start()
	{
		$str = "";
		$str .= $this->doctype . "\n";
		$str .= "<html>\n";
		$str .= "<head>\n";
		if($this->baseAddress)
		{
			$str .= "<base href=\"" . $this->baseAddress . "\" />\n";
		}
		$str .= "<title>" . $this->title . "</title>\n";
		if($this->meta)
		{
			$str .= $this->meta . "\n";
		}
		$str .= $this->getCss();
		if($this->faviconPath)
		{
			$str .= "<link rel=\"shortcut icon\" href=\"".$this->faviconPath."\" type=\"image/x-icon\" />\n";
			$str .= "<link rel=\"icon\" href=\"".$this->faviconPath."\" type=\"image/x-icon\" />\n";
		}
		$str .= $this->getJs();
		$str .= "</head>\n";
		$str .= "<body onload=\"" . $this->onload . "\">\n";
		echo $str;

		$this->getHeader();
		echo "<div id='content'>\n";
	}

	public function end()
	{
		?>
		     </div>
						</td>
						<td background="/images/portlet_body_right.jpg"></td>
					</tr>
					<tr >
						<td width="15" height="15"><img src="/images/portlet_bottom_left.jpg" ></td>
						<td align="center" background="/images/portlet_bottom_bg.jpg"  height="15">&nbsp;</td>
						<td width="15" height="15"><img src="/images/portlet_bottom_right.jpg"></td>
					</tr>
			</table>
			</div>
			<!--<div class="menu-gradient"></div>-->
			<div class="footer">Copyright &copy; kaiyansimmons.com - All rights reserved</div>
			</body>
		</html>
		<?
	}

	private function getCss()
	{
		$str = "";

		foreach( $this->css as $val )
			$str .= "<link rel='stylesheet' type='text/css' href='" . $val . (strpos($val, 'http') === false ? '?ver=' . $this->version : '') . "' />\n";

		return $str;
	}

	private function getJs()
	{
		$str = "";

		foreach( $this->js as $val )
			$str .= "<script type='text/javascript' src='" . $val . (strpos($val, 'http') === false ? '?ver=' . $this->version : '') . "' ></script>\n";

		return $str;
	}

	public function getHeader()
	{
  ?>
		<div class="app-container" id="app-container">
		<div class="header-container">
			<div class="logo-header-container">
			<div class="gd-logo"></div>
			<div class="app-name"><a href="<?= $this->baseAddress ?>"><?= $this->applicationName ?></a></div></a>
			<div class="version">v <?= $this->version ?></div>
			<div class="top-bar">
				<p>
					<?= $this->headerRightLinks ?>
				</p>
			</div>
			</div>
			<div class="menu-header clear-fix">
				<div class="right-content">
					<p><?= $this->headerRightContent ?></p>
				</div>
			</div>
			<?= $this->getNavBar() ?>
			<div class="menu-area clear-fix">
				<div class="integrated-menu clear-fix" id="integrated_sub_menu">
					<?= $this->getSubNavBar() ?>
				</div>
			</div>
		</div>
		<!--<div class="menu-gradient"></div>-->
		<div class="main_content_container">
		<table width="100%" cellpadding="0" cellspacing="0" border="0">
			<tr >
				<td width="15" height="15"><img src="/images/portlet_top_left.jpg"></td>
				<td background="/images/portlet_top_bg.jpg" height="15"></td>
				<td  width="15" height="15"><img src="/images/portlet_top_right.jpg"></td>
			</tr>
			<tr >
				<td background="/images/portlet_body_left.jpg"> </td>
				<td background="/images/portlet_body_bg.jpg" valign="top">
					<div id="main_content">
<?
	}

	public function getNavBar()
	{
		$str = "
			<div class='tabs clear-fix'>
				<ul id='tabNavigation' class='clear-fix'>
				";
			if($this->navBar && is_array($this->navBar))
			{
				$tabSpacer = "spacer";
				foreach($this->navBar as $title => $nav)
				{
					$activelink = $nav['active']==true ? "activelink " : "";
					$tabspacer = $nav['applyTabSpacing']==true ? "tabspacer" : "";

					if($activelink) $this->activeNav = $title;
					$str .= "<li class='". $activelink . " " . $tabspacer ."' id='".str_replace(" ","",$title)."Tab' onClick=\"". $nav['onClick'] ."\"><span>".$title."</span></li>\n";
					unset($spacer);
				}
			}
			$str .= "
				</ul>
   </div>";
		return $str;
	}

	public function getSubNavBar()
	{
		$str = "
				<ul id='subnav' class='nav'>
		";
		if($this->subNavBar && is_array($this->subNavBar))
		{
			foreach($this->subNavBar[$this->activeNav] as $title => $subNav)
			{
				$dropDownImg = $subNav['dropDownList'] && is_array($subNav['dropDownList']) ? " <img src='commonui/images/drop-down-arrow.gif'>" : "";
				$str .= "<li><span onclick=\"". $subNav['onClick'] ."\">".$title.$dropDownImg."</span>";
				if($dropDownImg)
				{
					$str .="<ul>";
					foreach($subNav['dropDownList'] as $ddTitle => $ddOnClick)
					{
						$str .= "<li onClick=\"".$ddOnClick."\"><span>".$ddTitle."</span></li>";
					}
					$str .="</ul>";
				}
				$str .="</li>";
			}
		}
		$str .= "
			</ul>
		";
		return $str;
	}
}
?>
